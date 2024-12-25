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
	echo "Board <i>$BOARD</i> doesn't exist.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Check wether the user has access to this board (viewpermission)
$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
if ($LOGIN_STATUS["Login"] === 0) {
	echo "You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>";
	exit();
}
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '{$LOGIN_STATUS['Username']}'");
if (empty($DB)) {
	echo "You don't have the permissions to view this board. <a href = 'Forum.php'>Go back.</a>";
	exit();
}

// At this point, the user has full clearance to view this board
?>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

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
$NEW_TIMEZONE = \Internals\Accounts\GetLoginStatus()["Timezone"];

$DB = \Internals\MySQL\Read("SELECT `Username`,`Comment`,`Date` FROM `forum_comments` WHERE `Board` = '$BOARD'");
for ($i = 0; $i < count($DB); $i++) {
	$ADJUSTED_DATETIME = \Internals\Time\UTCOffsetFromWebserver($DB[$i]["Date"], $NEW_TIMEZONE);
	$DB[$i]["Date"] = $ADJUSTED_DATETIME . ", $NEW_TIMEZONE";
}
$COMMENTS = json_encode($DB);

$USERS = [];
foreach ($DB as $C) {
	$USERNAME = $C["Username"];
	if(in_array($USERNAME, array_keys($USERS))) { continue; }
	
	$DB = \Internals\MySQL\Read("SELECT `Rank` FROM `accounts` WHERE `Username` = '$USERNAME'");
	$USERS[$USERNAME] = $DB[0]["Rank"];
}
$USERS = json_encode($USERS);

echo "<script>let COMMENTS = $COMMENTS; let USERS = $USERS;</script>";
?>

<block><flex_rows ID = "COMMENT_BLOCK"></flex_rows></block>

<script>
let BLOCK = document.getElementById("COMMENT_BLOCK");

for (let i = 0; i < COMMENTS.length; i++) {
	const USERNAME = COMMENTS[i]["Username"];
	let RANK = USERS[USERNAME];
	switch (RANK) {
		case "Superorchestrator":
			RANK = "class = 'superorchestrator'>Superorchestrator";
			break;
		case "Orchestrator":
			RANK = "class = 'orchestrator'>Orchestrator";
			break;
		case "Author":
			RANK = "class = 'author'>Author";
			break;
		case "Reader":
			RANK = "class = 'reader'>Reader";
			break;
	}
	const DATE = COMMENTS[i]["Date"];
	const COMMENT = COMMENTS[i]["Comment"];

	let COMMENT_TEMPLATE = `<block2><flex_rows>
		<flex_columns class = 'center_v'>
			<text_s ${RANK}</text_s>
			<space></space>
			<text> ${USERNAME}</text>
			<space></space>
			<text_s>${DATE}</text_s>
		</flex_columns>
		<space></space>
		<block3 class = 'comment'><text>${COMMENT}</text></block3>
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
	<flex_rows>
		<block2>
			<form method = "POST" action = "Post.php" style = "margin-bottom: 0px;">
				<flex_columns class = "center_v">
					<textarea rows = 4 cols = 64 name = "Comment" placeholder = "Something!" maxlength = 500 required></textarea>
					<input type = "text" name = "Board" value = "<?php echo $BOARD; ?>" hidden required>
					<space_l></space_l>
					<input type = "submit" style = "height: fit-content;" value = "Post!">
				</flex_columns>
			</form>
		</block2>
		<space_l></space_l>
		<block2>
			<flex_rows>
				<text>Stylizations are done using raw HTML:</text>
				<space></space>
				<flex_columns class = "center_v">
					<text>&lt;b&gt;<b>Bold</b>&lt;/b&gt;</text>
					<space></space>
					<text>&lt;i&gt;<i>Italic</i>&lt;/i&gt;</text>
					<space></space>
					<text>&lt;text_l&gt;<text_l>Larger</text_l>&lt;/text_l&gt;</text>
					<space></space>
					<text>&lt;text_s&gt;<text_s>Smaller</text_s>&lt;/text_s&gt;</text>
				</flex_columns>
			</flex_rows>
		</block2>
	</flex_rows>
</block>