<!DOCTYPE html>
<html>

<?php
// Board URL parameter specifies the board to view
if (!isset($_GET["Board"])) {
	echo "Board parameter is missing. <a href = 'Forum.php'>Go back.</a>";
	exit();
}
$BOARD = $_GET["Board"];

// Find out if the board actually exists to prevent PHP shitting itself later down the line
$FOUND_BOARD = false;
$BOARDS = \Internals\MySQL\Read("SELECT * FROM `forum_boards`");
foreach ($BOARDS as $V) {
	if ($V["Board"] === $BOARD) {
		$FOUND_BOARD = true;
		break;
	}
}
if (!$FOUND_BOARD) {
	echo "Board <i>$BOARD</i> doesn't exist. <a href = 'Forum.php'>Go back.</a>";
	exit();
}

// Check wether the user has access to this board (viewpermission)
$USERNAME = \Internals\Stc\Accounts\GetAccountInfo()["Username"];
if ($USERNAME === "None") { echo "Your session key has expired. <a href = 'https://sasakowski/Stc/Login/Login.php'>Login.</a>"; }
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '$USERNAME'");
$CAN_VIEW = !empty($DB);
if (!$CAN_VIEW) {
	echo "You don't have permissions to view this board. <a href = 'Forum.php'>Go back.</a>";
	exit();
}

// At this point, the user has full permissions to view this board

?>

<style>
input { font-size: var(--text); }
</style>

<?php \Internals\Stc\HTMLElements\NoScript();  \Internals\Stc\HTMLElements\Head(); \Internals\Stc\HTMLElements\Top(); ?>

<block>
	<block2>
		<flex_columns class = "center_v" style = "justify-content: space-evenly;">
			<text_l>Forum board: <i><?php echo $BOARD; ?></i></text_l>
			<text><a href = "Forum.php">Go back.</a></text>
		</flex_columns>
	</block2>
</block>

<space_xl></space_xl>

<?php
// Load the comments and associated metadata
$DB = \Internals\MySQL\Read("SELECT `Username`,`Comment`,`Date` FROM `forum_comments` WHERE `Board` = '$BOARD'");
$COMMENTS = json_encode($DB);
echo "<script>let COMMENTS = $COMMENTS</script>";
?>

<block><flex_rows ID = "COMMENT_BLOCK"></flex_rows></block>

<script>
let BLOCK = document.getElementById("COMMENT_BLOCK");

for (let i = 0; i < COMMENTS.length; i++) {
	const USERNAME = COMMENTS[i]["Username"];
	const DATE = COMMENTS[i]["Date"];
	const COMMENT = COMMENTS[i]["Comment"];

	let COMMENT_TEMPLATE = `<block2><flex_rows>
		<flex_columns>
			<text>${USERNAME}</text>
			<space></space>
			<text>${DATE} UTC+3</text>
		</flex_columns>
		<space></space>
		<text style = 'margin-left: var(--space_l);'>${COMMENT}</text>
	</flex_rows></block2>`;

	BLOCK.innerHTML += COMMENT_TEMPLATE;

	if (i < COMMENTS.length - 1) {
		BLOCK.innerHTML += "<space_l></space_l>";
	}
}

if (COMMENTS.length === 0) {
	BLOCK.innerHTML = "<text>This board is empty, yet...</text>";
	BLOCK.classList.add("center_h");
}
</script>

<space_xl></space_xl>

<block>
	<form method = "POST" action = "Post.php">
		<textarea rows = 4 cols = 64 name = "Comment" placeholder = "Comment something!" required></textarea>
		<input type = "text" name = "Board" value = "<?php echo $BOARD; ?>" hidden required>
		<input type = "submit">
	</form>
</block>