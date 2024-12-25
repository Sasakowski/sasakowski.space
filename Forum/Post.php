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
if (strlen($COMMENT) > 500) { // The limit is actually 512, but just in case
	echo "Your comment is too long.<br><br>
	<a href = 'https://sasakowski.space/Forum/Board.php?Board=$BOARD'>Go back and try again</a>";
	exit();
}
if (str_contains($COMMENT, "<") or str_contains($COMMENT, ">")) {
	// Check for tags
	$RESULT = [];
	preg_match_all("/<[^>,\s]+/", $COMMENT, $RESULT);
	$RESULT = $RESULT[0];
	foreach ($RESULT as $R) {
		$R = substr($R, 1); // Always the < (which is useless now)
		if (!in_array($R, ["i","b","br","text_l","text_s", "/i", "/b", "/br", "/text_l", "/text_s"])) {
			echo "Your comment contains a disallowed HTML tag (closing tags included). This failed the check: < $R<br><br>
			<a href = 'https://sasakowski.space/Forum/Board.php?Board=$BOARD'>Go back and try again</a><br><br>
			Allowed tags:<br>
			- < i > and < /i ><br>
			- < b > and < /b ><br>
			- < br > and < /br ><br>
			- < text_l > and < /text_l ><br>
			- < text_s > and < /text_s ><br>
			";
			exit();
		}
	}
	// Check for attributes
	$RESULT = [];
	preg_match_all("/[A-za-z0-9]+\s*\=/", $COMMENT, $RESULT);
	$RESULT = $RESULT[0];
	if (!empty($RESULT)) {
		echo "Your comment contains an HTML attribute, which are completely disallowed. This failed the check: $RESULT[0]<br><br>
		<a href = 'https://sasakowski.space/Forum/Board.php?Board=$BOARD'>Go back and try again</a>";
		exit();
	}
}
$COMMENT = str_replace(["\r\n","\n","\r"],"<br>", $COMMENT);

// The user CAN comment on this board
$COMMENT = str_replace("'", "\'", $COMMENT);
\Internals\MySQL\Write("INSERT INTO `forum_comments` (`ID`,`Board`,`Username`,`Comment`,`Date`) VALUES (LAST_INSERT_ID(),'$BOARD','$USERNAME','$COMMENT',NOW())");

\Internals\Redirect\Redirect("https://sasakowski.space/Forum/Board.php?Board=$BOARD");
?>