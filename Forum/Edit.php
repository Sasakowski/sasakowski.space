<?php

\Internals\XSS\EnsureGet(["ID"]);
$ID = $_GET["ID"];
\Internals\XSS\SQL([$ID]);
\Internals\XSS\KillIfMarkup($ID);
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
\Internals\XSS\Presets\Forum($COMMENT[0]["Comment"]);

?>

<!-- FRONTEND -->

<form action = "EditSubmit.php?ID=<?php echo $ID; ?>" method = "POST">
<textarea name = "COMMENT" rows = 12 cols = 96 maxlength = 500 required><?php echo $COMMENT[0]["Comment"]; ?></textarea>
<br><br>
<input style = "font-size: 150%;" type = "submit" value = "Edit!">
</form>

<a href = 'Forum.php'>Go back</a>