<?php
// This file takes a comment as input, checks if the comment can be posted and finally stores it in the DB

$PARAMETERS = ["Board","Comment"];
foreach ($PARAMETERS as $PARAMETER)  {
	if (!isset($_POST[$PARAMETER])) {
		\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Forum.php");
	}
}

// Get all neccessary info
$BOARD = $_POST["Board"];
$COMMENT = $_POST["Comment"];
$USERNAME = \Internals\Accounts\GetLoginStatus()["Username"];

// Check again if the user can post into this board (viewpermissions)
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Board` = '$BOARD' AND `Username` = '$USERNAME'");
if (empty($DB)) {
	echo "You don't have the permissions to comment on this board.<br><br>
	<a href = 'https://sasakowski.space/Forum/Forum.php'>Forum</a>";
	exit();
}

// Check the comment itself
\Internals\HTMLElements\CheckHTMLSubmission_Forum($COMMENT);

// The user CAN comment on this board
$COMMENT = \Internals\HTMLElements\PrepareHTMLSubmissionForDB($COMMENT);
\Internals\MySQL\Write("INSERT INTO `forum_comments` (`ID`,`Board`,`Username`,`Comment`,`Date`) VALUES (LAST_INSERT_ID(),'$BOARD','$USERNAME','$COMMENT',NOW())");

\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Board.php?Board=$BOARD");
?>