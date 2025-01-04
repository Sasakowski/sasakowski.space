<?php
// Load the GET and POST data
$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "No ID given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}
$COMMENT = isset($_POST["COMMENT"]) ? $_POST["COMMENT"] : null;
if ($COMMENT === null) {
	echo "No new comment given.<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Check AGAIN wether the user can actually edit this comment
$OLD_COMMENT = \Internals\MySQL\Read("SELECT `Username`,`Comment` FROM `forum_comments` WHERE `ID` = '$ID'");
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

// Check the comment itself
$_ = \Internals\HTMLElements\CheckHTML($COMMENT, 500,
	[], ["b","i","text_l","text_s"], [], [], [], [], false
);
if ($_[0] !== 1) {
	echo "This comment failed to post. If you believe that this is an error write down the following:<br><br>
	Code: $_[0]<br>
	Failure: $_[1]<br><br>
	<a href = 'Forum.php'>Go back</a>";
	exit();
}

// Write to the db
\Internals\MySQL\Write("UPDATE `forum_comments` SET `Comment` = '$COMMENT' WHERE `ID` = '$ID'");

\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Forum.php");
?>