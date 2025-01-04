<!DOCTYPE html>
<html>

<?php
// Get the ID parameter
$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "No ID given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Get the user info
$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
if ($LOGIN_STATUS["Login"] === 0) {
	echo "You're not logged in.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Load the comment and check wether the user can actually delete this comment
$COMMENT = \Internals\MySQL\Read("SELECT `Username` FROM `forum_comments` WHERE `ID` = '$ID'");
if (empty($COMMENT)) {
	echo "Comment doesn't exist.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
if ($COMMENT[0]["Username"] !== $LOGIN_STATUS["Username"]) {
	echo "You're not the owner of this comment.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
?>

<span style = "font-size: 200%;">⚠️ <b>WARNING</b> ⚠️</span>
<br><br>
<span style = "font-size: 150%;">The comment you're about to delete could be unrecoverable!</span>
<br><br>
<span>The comment could still be within backups and failsaves. If you want this comment to be purged from these as well, get in touch with this website's administration. If so, please write down this comment's ID: <b><?php echo $ID; ?></b></span>
<br><br>
<a href = "https://sasakowski.space/Forum/Forum.php">Go back</a>
&emsp;
<button onclick = "Delete();">Delete this comment</button>

<script>
function Delete() {
	let CONFIRM = confirm("Here's the point of no return. Are you sure?");
	if (!CONFIRM) {
		window.location.href = "https://sasakowski.space/Forum/Forum.php";
		return;
	} else {
		window.location.href = "https://sasakowski.space/Forum/DeleteSubmit.php?ID=<?php echo $ID; ?>";
	}
}
</script>