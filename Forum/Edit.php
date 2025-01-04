<!DOCTYPE html>
<html>

<?php
// Get the ID parameter
$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "No ID given.<br><br>
	<a href = 'Forum.php'>Go back.</a>";
	exit();
}

// Get the user info
$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
if ($LOGIN_STATUS["Login"] === 0) {
	echo "You're not logged in.<br><br>
	<a href = 'Forum.php'>Go back.</a>";
	exit();
}

// Load the comment and check wether the user can actually edit this comment
$COMMENT = \Internals\MySQL\Read("SELECT `Username`,`Comment` FROM `forum_comments` WHERE `ID` = '$ID'");
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

<!-- FRONTEND -->

<form action = "EditSubmit.php?ID=<?php echo $ID; ?>" method = "POST">
<textarea name = "COMMENT" rows = 12 cols = 96 maxlength = 500 required><?php echo $_COMMENT; ?></textarea>
<br><br>
<input style = "font-size: 150%;" type = "submit" value = "Edit!">
</form>

<a href = 'Forum.php'>Go back</a>