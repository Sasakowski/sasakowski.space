<?php

\Internals\XSS\EnsureGet(["ID"]);
$ID = $_GET["ID"];
\Internals\XSS\SQL([$ID]);
\Internals\XSS\KillIfMarkup($ID);

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
?>

<span style = "font-size: 200%;">⚠️ <b>WARNING</b> ⚠️</span>
<br><br>
<span style = "font-size: 150%;">The comment you're about to delete could be unrecoverable!</span>
<br><br>
<span>The comment could still be within backups and failsaves. If you want this comment to be purged fully, get in touch with this website's administration. Oh, and don't forget this comment's ID: <b><?php echo $ID; ?></b></span>
<br><br>
<a href = "<?php echo "https://sasakowski.space/Forum/Board.php?Board=" . $COMMENT[0]["Board"]; ?>">Go back</a>
&emsp;
<button onclick = "Delete();">Delete this comment</button>

<script>
function Delete() {
	let CONFIRM = confirm("Here's the point of no return. Are you sure?");
	if (!CONFIRM) {
		window.location.href = "<?php echo "https://sasakowski.space/Forum/Board.php?Board=" . $COMMENT[0]["Board"]; ?>";
		return;
	} else {
		window.location.href = "https://sasakowski.space/Forum/DeleteSubmit.php?ID=<?php echo $ID; ?>";
	}
}
</script>