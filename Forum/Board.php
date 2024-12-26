<!DOCTYPE html>
<html>

<?php
// Load the board
$BOARD = isset($_GET["Board"]) ? $_GET["Board"] : null;
if ($BOARD === null) {
	echo "No board given.<br><br>
	<a href = 'Forum.php'>Go back.</a>";
	exit();
}
// Check wether this board actually exists
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_boards` WHERE `Board` = '$BOARD'");
if (empty($DB)) {
	echo "Board <i>$BOARD</i> doesn't exist.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
// Check wether the user has the clearance to view this board
$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
if ($LOGIN_STATUS["Login"] === 0) {
	echo "You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>";
	exit();
}
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '{$LOGIN_STATUS['Username']}'");
if (empty($DB)) {
	echo "You don't have the clearance to view this board.<br><br>
	<a href = 'Forum.php'>Go back.</a>";
	exit();
}

// At this point, the user has full clearance to view this board
// $BOARD -> The name of the board
// $LOGIN_STATUS -> User info
?>



<!-- HEADER -->

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<block>
	<block2>
		<flex_columns class = "center_v">
			<text_l>Forum board: <i><?php echo $BOARD; ?></i></text_l>
			<space_l></space_l>
			<text><a href = "Forum.php">Go back.</a></text>
		</flex_columns>
	</block2>
</block>

<space_xl></space_xl>



<!-- BODY -->

<style>
.edit { text-decoration: none; }
</style>

<?php
// Load the comments and adjust the timezones while at it
$TIMEZONE_OF_USER = $LOGIN_STATUS["Timezone"];
$DB = \Internals\MySQL\Read("SELECT `ID`,`Username`,`Comment`,`Date` FROM `forum_comments` WHERE `Board` = '$BOARD'");
for ($i = 0; $i < count($DB); $i++) {
	$ADJUSTED_TIMEZONE = \Internals\Time\UTCOffsetFromWebserver($DB[$i]["Date"], $TIMEZONE_OF_USER);
	$DB[$i]["Date"] = "$ADJUSTED_TIMEZONE, $TIMEZONE_OF_USER";
}
$COMMENTS = json_encode($DB);

// Load the ranks of all involved users
$USERS = [];
foreach ($DB as $COMMENT) {
	$USERNAME = $COMMENT["Username"];
	if(in_array($USERNAME, array_keys($USERS))) { continue; }
	
	$_DB = \Internals\MySQL\Read("SELECT `Rank` FROM `accounts` WHERE `Username` = '$USERNAME'");
	$USERS[$USERNAME] = $_DB[0]["Rank"];
}
$USERS = json_encode($USERS);

// Submit the data to the frontend (display is done by JS)
echo "<script>let COMMENTS = $COMMENTS; COMMENTS.reverse(); let USERS = $USERS; let THIS_USER = '{$LOGIN_STATUS["Username"]}';</script>";
?>

<block><flex_rows ID = "COMMENT_BLOCK"></flex_rows></block>

<script>
let BLOCK = document.getElementById("COMMENT_BLOCK");

for (let i = 0; i < COMMENTS.length; i++) {
	const USERNAME = COMMENTS[i]["Username"];
	const DATE = COMMENTS[i]["Date"];
	const COMMENT = COMMENTS[i]["Comment"];
	const ID = COMMENTS[i]["ID"];
	const RANK = USERS[USERNAME];
	const RANK_CLASS = RANK.toLowerCase();

	const EDIT = USERNAME == THIS_USER ? `<space></space><text title = 'Edit this comment.'><a href = 'Edit.php?ID=${ID}' class = 'edit'>✏️</a></text>` : "";

	const COMMENT_TEMPLATE = `<block2><flex_rows>
		<flex_columns class = 'center_v'>
			<text_s class = '${RANK_CLASS}'> ${RANK}</text_s>
			<space></space>
			<text>${USERNAME}</text>
			<space></space>
			<text_s>${DATE}</text_s>
			${EDIT}
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



<!-- FOOTER -->

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