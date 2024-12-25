<?php

if (\Internals\Accounts\GetLoginStatus()["Login"] === 0) {
	echo "You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>&emsp;
	<a href = 'https://sasakowski.space/'>Frontpage</a>";
	exit();
}

// Delete the session cookie and the DB entry

\Internals\Cookies\Delete("Session");
\Internals\MySQL\Delete("DELETE FROM `session_keys` WHERE `Session Key` = '$SESSION'");

\Internals\Redirect\Redirect("https://sasakowski.space/Static/Login/Login.php");

?>