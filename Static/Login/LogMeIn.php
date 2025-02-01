<?php

if ($__GLOBAL__LOGIN["Login"] === 1) {
	echo "<!DOCTYPE html><html>
	You're already logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/LogMeOut.php'>Log out</a>
	";
	exit();
}

// Get the POST data from Login.php
\Internals\XSS\EnsurePost(["Username","Password","Key1","Key2","Key3"]);
$USERNAME = strval($_POST["Username"]);
$PASSWORD = strval($_POST["Password"]);
$KEY_1 = strval($_POST["Key1"]);
$KEY_2 = strval($_POST["Key2"]);
$KEY_3 = strval($_POST["Key3"]);
\Internals\XSS\SQL([$USERNAME, $PASSWORD, $KEY_1, $KEY_2, $KEY_3]);

// Check for excessive logins (session_keys contains a username more than 5 times)
$DB = \Internals\MySQL\Read("SELECT `Username` FROM `session_keys` WHERE `Username` = '$USERNAME'");
if (sizeof($DB) >= 5) {
	echo "<!DOCTYPE html><html>
	You've logged in too many times. Please wait 24 hours before attempting a new login.<br><br>
	<a href = 'https://sasakowski.space/Static/Sitemap.php'>Sitemap</a>
	";
	exit();
}

// Actually attempt to log the user in now
$DB = \Internals\MySQL\Read("SELECT `Password`,`Key1`,`Key2`,`Key3` FROM `accounts` WHERE `Username` = '$USERNAME'");
if (empty($DB)) {
	echo "<!DOCTYPE html><html>
	Username not found.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Go back and try again</a>
	";
	exit();
}
$DB_PASSWORD = strval($DB[0]["Password"]);
$DB_KEY_1 = strval($DB[0]["Key1"]);
$DB_KEY_2 = strval($DB[0]["Key2"]);
$DB_KEY_3 = strval($DB[0]["Key3"]);

$CAN_LOG_IN = [
	password_verify($PASSWORD, $DB_PASSWORD),
	$KEY_1 === $DB_KEY_1,
	$KEY_2 === $DB_KEY_2,
	$KEY_3 === $DB_KEY_3
];

if (in_array(false, $CAN_LOG_IN)) {
	echo "<!DOCTYPE html><html>
	The credentials are incorrect.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Go back and try again</a>
	";
	exit();
}

$SESSION_KEY = uniqid();
$NOW = date('Y-m-d H:i:s');

\Internals\MySQL\Write("INSERT INTO `session_keys` (`Session Key`,`Username`,`Timestamp`) VALUES ('$SESSION_KEY', '$USERNAME', '$NOW')");

$EXPIRY_DATE = time() + (60*60*24); // seconds_in_a_minute, minutes_in_an_hour, hours_in_a_day
\Internals\Cookies\Create("SessionKey", $SESSION_KEY, $EXPIRY_DATE);

\Internals\Redirect\Redirect("https://sasakowski.space/Static/Sitemap.php");

?>