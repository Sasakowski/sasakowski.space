<?php

$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
if ($ID === null) {
	echo "<!DOCTYPE><html>
	No ID given.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}
\Internals\XSS\DisallowMarkup($ID);
if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE><html>
	You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Login</a>";
	exit();
}

// Load the comment and check wether the user can actually edit it.
$COMMENT = \Internals\MySQL\Read("SELECT `Board`,`Username`,`Comment` FROM `forum_comments` WHERE `ID` = '$ID'");
if (empty($COMMENT)) {
	echo "<!DOCTYPE><html>
	Comment doesn't exist.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}
if ($COMMENT[0]["Username"] !== $__GLOBAL__LOGIN["Username"]) {
	echo "<!DOCTYPE><html>
	You're not the owner of this comment.<br><br>
	<a href = 'Board.php?Board={$COMMENT[0]["Board"]}'>Return to the comment's board</a>";
	exit();
}

// Write to the db
\Internals\MySQL\Delete("DELETE FROM `forum_comments` WHERE `ID` = '$ID'");

\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Board.php?Board={$COMMENT[0]["Board"]}");
?>