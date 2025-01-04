<?php
// Load the GET data
$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "No ID given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Check AGAIN wether the user can actually edit this comment
$OLD_COMMENT = \Internals\MySQL\Read("SELECT `Username` FROM `forum_comments` WHERE `ID` = '$ID'");
if (empty($OLD_COMMENT)) {
	echo "Comment doesn't exist.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
if ($OLD_COMMENT[0]["Username"] !== $LOGIN_STATUS["Username"]) {
	echo "You're not the owner of this comment.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Write to the db
\Internals\MySQL\Delete("DELETE FROM `forum_comments` WHERE `ID` = '$ID'");

\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Forum.php");
?>