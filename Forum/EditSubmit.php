<?php

$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "<!DOCTYPE><html>
	No ID given.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}
$COMMENT = isset($_POST["COMMENT"]) ? $_POST["COMMENT"] : null;
if ($COMMENT === null) {
	echo "<!DOCTYPE><html>
	Malformed POST data.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}
\Internals\XSS\FilterTags($COMMENT, [], ["b", "i", "text_l", "text_s"], false);

// Load the comment and check wether the user can actually edit it.
$OLD_COMMENT = \Internals\MySQL\Read("SELECT `Board`,`Username`,`Comment` FROM `forum_comments` WHERE `ID` = '$ID'");
if (empty($OLD_COMMENT)) {
	echo "<!DOCTYPE><html>
	Comment doesn't exist.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}
if ($OLD_COMMENT[0]["Username"] !== $__GLOBAL__LOGIN["Username"]) {
	echo "<!DOCTYPE><html>
	You're not the owner of this comment.<br><br>
	<a href = 'Board.php?Board={$OLD_COMMENT[0]["Board"]}'>Return to the comment's board</a>";
	exit();
}

// Write to the db
\Internals\MySQL\Write("UPDATE `forum_comments` SET `Comment` = '$COMMENT' WHERE `ID` = '$ID'");

\Internals\Redirect\Redirect("Board.php?Board={$OLD_COMMENT[0]["Board"]}");
?>