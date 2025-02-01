<?php

if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE html><html>
	You need to log in first to use this feature.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>
	";
	exit();
}

\Internals\XSS\EnsurePost(["Markup"]);
$PROFILE = $_POST["Markup"];
if (strlen($PROFILE) > 4000) {
	echo "<!DOCTYPE html><html>
	Markup is too long.<br><br>
	<a href = 'https://sasakowski.space/Static/Accounts/Profile.php'>Profile</a>
	";
	exit();
}
\Internals\XSS\Presets\Profile($PROFILE);

$USERNAME = $__GLOBAL__LOGIN["Username"];
$PROFILE = str_replace("'", "\'", $PROFILE);
\Internals\MySQL\Write("UPDATE `profiles` SET `Markup` = '$PROFILE' WHERE `Username` = '$USERNAME'");

\Internals\Redirect\Redirect("https://sasakowski.space/Accounts/Profile.php");