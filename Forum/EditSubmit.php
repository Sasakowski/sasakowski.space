<?php

\Internals\XSS\EnsureGet(["ID"]);
$ID = $_GET["ID"];
\Internals\XSS\EnsurePost(["COMMENT"]);
$COMMENT = $_POST["COMMENT"];
\Internals\XSS\Presets\Forum($COMMENT);

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
$COMMENT = str_replace("'", "\'", $COMMENT);
\Internals\MySQL\Write("UPDATE `forum_comments` SET `Comment` = '$COMMENT' WHERE `ID` = '$ID'");

\Internals\Redirect\Redirect("Board.php?Board={$OLD_COMMENT[0]["Board"]}");
?>