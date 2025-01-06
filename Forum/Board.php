<?php
// Get the board name.

$BOARD = isset($_GET["Board"]) ? $_GET["Board"] : null;
if ($BOARD === null) {
	echo "<!DOCTYPE html><html>
	No board given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
\Internals\XSS\DisallowMarkup($BOARD);

// Check wether it actually exists.
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_boards` WHERE `Board` = '$BOARD'");
if (empty($DB)) {
	echo "<!DOCTYPE html><html>
	Board doesn't exist.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
// Check wether the user can actually view it.
if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE html><html>
	You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>";
	exit();
}
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '{$__GLOBAL__LOGIN["Username"]}'");
if (empty($DB)) {
	echo "<!DOCTYPE html><html>
	You don't have the permission to view this board.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Also get the block (this is relevant later).
// A board contains comments, which are divided into blocks of 16.
$BLOCK = isset($_GET["Block"]) ? $_GET["Block"] : 1;
\Internals\XSS\DisallowMarkup($BLOCK);
if (!is_numeric($BLOCK) or $BLOCK <= 0) {
	echo "<!DOCTYPE html><html>
	Block parameter is malformed.<br><br>
	<a href = '?Board=$BOARD'>Try again with no block parameter</a>&emsp;<a href = 'Forum.php'>Forum</a>
	";
	exit();
}
$BLOCK = ($BLOCK - 1) * 16; // Block is actually the OFFSET for the SQL query

?>

<!DOCTYPE html>
<html>

<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<style>
.edit { text-decoration: none; font-style: normal; }
</style>

<?php

// Load the comments.
$DB = \Internals\MySQL\Read("SELECT `ID`,`Username`,`Comment`,`Date` FROM `forum_comments` WHERE `Board` = '$BOARD' ORDER BY `Date` DESC LIMIT 16 OFFSET $BLOCK");

// XSS comment check.
for ($i = 0; $i < count($DB); $i += 1) {
	\Internals\XSS\FilterTags($DB[$i]["Comment"], [], ["b", "i", "text_l", "text_s"], false);
}

// Adjust for the user's timezone. The webserver's timezone is UTC+3.
for ($i = 0; $i < count($DB); $i += 1) {
	if ($__GLOBAL__LOGIN["Timezone"] !== "UTC+3") {
		$DB[$i]["Date"] = \Internals\Time\SetTimezoneOffset($DB[$i]["Date"], "UTC+3", $__GLOBAL__LOGIN["Timezone"]);
	}
	$DB[$i]["Date"] .= ", " . $__GLOBAL__LOGIN["Timezone"];
}

// Get the ranks of all users present in this block. Also determine wether this comment can be edited.
$USERS_DONE = [];
for ($i = 0; $i < count($DB); $i += 1) {
	
	$USER = \Internals\Accounts\GetInfo($DB[$i]["Username"]);
	$DB[$i]["Rank"] = $USER["Rank"];
	
	if ($DB[$i]["Username"] === $__GLOBAL__LOGIN["Username"]) {
		$DB[$i]["Edit"] = true;
	} else {
		$DB[$i]["Edit"] = false;
	}
}

// Calculate how many blocks there are within this board.
$_DB = \Internals\MySQL\Read("SELECT `ID` FROM `forum_comments` WHERE `Board` = '$BOARD'");
$BLOCKS = ceil(count($_DB) / 16);

if ($BLOCK > ($BLOCKS * 16) - 1) {
	echo "<block><flex_rows class = 'center_h'>
		<text_l>Block parameter is outside the available range.</text_l>
		<space></space>
		<a href = '?Board=$BOARD'>Try again with no block parameter</a>
	</flex_rows>
	";
	
	exit();
}

$COMMENTS = json_encode($DB);
echo "<script>let COMMENTS = $COMMENTS;</script>";

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
					for ($i = 0; $i < $BLOCKS; $i += 1) {
						$x = $i + 1;
						echo "<a href = '?Board=$BOARD&Block=$x'>$x</a>";
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
let DOM = document.getElementById("COMMENT_BLOCK");

for (let i = 0; i < COMMENTS.length; i++) {
	let USERNAME = COMMENTS[i]["Username"];
	let DATE = COMMENTS[i]["Date"];
	let COMMENT = COMMENTS[i]["Comment"];
	let ID = COMMENTS[i]["ID"];
	let RANK = COMMENTS[i]["Rank"];
	let EDIT = COMMENTS[i]["Edit"];

	let _RANK;
	switch (RANK) {

		case "Superorchestrator":
			_RANK = "rank_so";
			break;
		
		case "Superorchestrator":
			_RANK = "rank_o";
			break;

		case "Superorchestrator":
			_RANK = "rank_a";
			break;

		case "Superorchestrator":
			_RANK = "rank_r";
			break;
	}

	if (EDIT) {
		EDIT = `<space></space>
		<text_s><a class = 'edit' href = 'Edit.php?ID=${ID}'>✏️</a></text_s>
		<space></space>
		<text_s><a class = 'edit' href = 'Delete.php?ID=${ID}'>🗑️</a></text_s>
		`;
	} else {
		EDIT = "";
	}

	DOM.innerHTML += `<block2><flex_rows>
		<flex_columns class = 'center_v'>
			<text_s class = '${_RANK}'>${RANK}</text_s>
			<space></space>
			<img src = 'https://sasakowski.space/Accounts/Contents/${USERNAME}/PFP.png' style = 'height: var(--text); border-radius: 33%;'>
			<space></space>
			<text>${USERNAME}</text>
			<space></space>
			<text_s>${DATE}</text_s>
			${EDIT}
		</flex_columns>

		<space></space>

		<block3 class = 'comment'>
			<text>${COMMENT}</text>
		</block3>
	`;

	if (i < COMMENTS.length - 1) {
		DOM.innerHTML += "<space_l></space_l>";
	}
}

if (COMMENTS.length === 0) {
	DOM.innerHTML = "<text>This board is empty, yet...</text>";
	DOM.classList.add("center_h");
}

</script>