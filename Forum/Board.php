<!DOCTYPE html>
<html>

<?php
// Load the board
$BOARD = isset($_GET["Board"]) ? $_GET["Board"] : null;
if ($BOARD === null) {
	echo "No board given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
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
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// At this point, the user has full clearance to view this board
// $BOARD -> The name of the board
// $LOGIN_STATUS -> User info
?>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<style>
.edit { text-decoration: none; font-style: normal; }
</style>

<?php
// Comments are divided into blocks of 16
$BLOCK = isset($_GET["Block"]) ? $_GET["Block"] : 1;
if (!is_numeric($BLOCK) or $BLOCK <= 0) { $BLOCK = 1; }
$BLOCK = ($BLOCK - 1) * 16;

// Load the comments and adjust the timezones while at it
$TIMEZONE_OF_USER = $LOGIN_STATUS["Timezone"];
$DB = \Internals\MySQL\Read("SELECT `ID`,`Username`,`Comment`,`Date` FROM `forum_comments` WHERE `Board` = '$BOARD' ORDER BY `Date` DESC LIMIT 16 OFFSET $BLOCK");
for ($i = 0; $i < count($DB); $i++) {
	$ADJUSTED_TIMEZONE = \Internals\Time\UTCOffsetFromWebserver($DB[$i]["Date"], $TIMEZONE_OF_USER);
	$DB[$i]["Date"] = "$ADJUSTED_TIMEZONE, $TIMEZONE_OF_USER";
}

// Split the mass of comments into blocks of 16, so that the available pages can be correctly displayed
$DB_COUNT = \Internals\MySQL\Read("SELECT `ID` FROM `forum_comments` WHERE `Board` = '$BOARD'");
$BLOCKCOUNT = ceil(count($DB_COUNT) / 16) + 1;

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
echo "<script>let COMMENTS = $COMMENTS; let USERS = $USERS; let THIS_USER = '{$LOGIN_STATUS["Username"]}';</script>";
?>

<block><flex_rows>

	<block2>
		<flex_columns class = "center_h center_v">
			<text_l>Forum board: <i><?php echo $BOARD; ?></i></text_l>
			<space_l></space_l>
			<text><a href = "Forum.php">Go back</a></text>
		</flex_columns>
	</block2>
		
	<space_l></space_l>

	<block2>
		<form method = "POST" action = "Post.php">
			<flex_columns>
				
				<textarea rows = 4 cols = 64 name = "Comment" placeholder = "Something!" maxlength = 500 required></textarea>
				<input type = "text" name = "Board" value = "<?php echo $BOARD; ?>" hidden required>
				
				<space_l></space_l>
				
				<flex_rows class = "noflex" style = "min-width: fit-content; justify-content: center;">
					<input type = "submit" value = "Post!">
					<space_l></space_l>
					<a href = "https://sasakowski.space/Static/StylizationGuide.php" target = "_blank">Stylization Guide</a>
				</flex_rows>

				<space_l></space_l>

				<flex_columns style = "gap: var(--space);">
					<?php
					for ($i = 1; $i < $BLOCKCOUNT; $i += 1) {
						echo "<a href = '?Board=$BOARD&Block=$i'>$i</a>";
					}
					?>
				</flex_columns>

			</flex_columns>
		</form>
	</block2>
</flex_rows></block>

<space_l></space_l>

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

	const EDIT_COMMENT = USERNAME == THIS_USER ? `<space></space><text title = 'Edit this comment.'><a href = 'Edit.php?ID=${ID}' class = 'edit'>✏️</a></text>` : "";
	const DELETE_COMMENT = USERNAME == THIS_USER ? `<space></space><text title = 'Delete this comment.'><a href = 'Delete.php?ID=${ID}' class = 'edit'>🗑️</a></text>` : "";

	const COMMENT_TEMPLATE = `<block2><flex_rows>
		<flex_columns class = 'center_v'>
			<text_s class = '${RANK_CLASS}'> ${RANK}</text_s>
			<space></space>
			<text>${USERNAME}</text>
			<space></space>
			<text_s>${DATE}</text_s>
			${EDIT_COMMENT}
			${DELETE_COMMENT}
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