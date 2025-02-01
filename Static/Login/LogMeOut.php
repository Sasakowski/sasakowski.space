<?php

if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE html><html>
	You're not logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>
	";
	exit();
}

// Delete the session cookie and the DB entry

$SESSION_KEY = \Internals\Cookies\Get("SessionKey", "None");
\Internals\XSS\SQL([$SESSION_KEY]);

\Internals\Cookies\Delete("SessionKey");
\Internals\MySQL\Delete("DELETE FROM `session_keys` WHERE `Session Key` = '$SESSION_KEY'");

\Internals\Redirect\Redirect("https://sasakowski.space/Static/Sitemap.php");

?>