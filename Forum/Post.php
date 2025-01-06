<?php
// This file takes a comment as input, checks if the comment can be posted and finally stores it in the DB

$PARAMETERS = ["Board","Comment"];
foreach ($PARAMETERS as $PARAMETER)  {
	if (!isset($_POST[$PARAMETER])) {
		echo "Malformed POST data.<br><br>
		<a href = 'Forum.php'>Forum</a>
		";
		exit();
	}
}
$BOARD = $_POST["Board"];
\Internals\XSS\DisallowMarkup($BOARD);
$COMMENT = $_POST["Comment"];
\Internals\XSS\FilterTags($COMMENT, [], ["b", "i", "text_l", "text_s"], false);
if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE><html>
	You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Login</a>";
	exit();
}

$USERNAME = $__GLOBAL__LOGIN["Username"];

// Check again if the user can post into this board (viewpermissions)
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '$USERNAME'");
if (empty($DB)) {
	echo "<!DOCTYPE html><html>
	You don't have the permissions to comment on this board.<br><br>
	<a href = 'Forum.php'>Forum</a>";
	exit();
}

// The user CAN comment on this board
\Internals\MySQL\Write("INSERT INTO `forum_comments` (`ID`,`Board`,`Username`,`Comment`,`Date`) VALUES (LAST_INSERT_ID(),'$BOARD','$USERNAME','$COMMENT',NOW())");

\Internals\Redirect\Redirect("Board.php?Board=$BOARD");
?>