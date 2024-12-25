<?php

if (\Internals\Accounts\GetLoginStatus()["Login"] === 1) {
	echo "You're already logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/LogMeOut.php'>Log out</a>&emsp;
	<a href = 'https://sasakowski.space/'>Frontpage</a>";
	exit();
}

// This file attempts to log the user in

// Get the POST data given by Login.php

$PARAMETERS = ["Username","Password","Key1","Key2","Key3"];
foreach ($PARAMETERS as $PARAMETER)  {
	if (!isset($_POST[$PARAMETER])) {
		\Internals\Redirect\Redirect("https://sasakowski.space/Static/Login/Login.php");
	}
}

$USERNAME = strval($_POST["Username"]);
$PASSWORD = strval($_POST["Password"]);
$KEY_1 = strval($_POST["Key1"]);
$KEY_2 = strval($_POST["Key2"]);
$KEY_3 = strval($_POST["Key3"]);

// Check for exessive logins (session_keys has at least 5 entries with the same username)
$DB = \Internals\MySQL\Read("SELECT `Username` FROM `session_keys` WHERE `Username` = '$USERNAME'");
if (sizeof($DB) >= 5) {
	echo "You've logged in too many times. Please wait 24 hours before attempting a new login.";
	exit();
}

// Get the db info

$DB = \Internals\MySQL\Read("SELECT `Password`,`Key1`,`Key2`,`Key3` FROM `accounts` WHERE `Username` = '$USERNAME'");
if (empty($DB)) {
	echo "Username <i>$USERNAME</i> not found.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Go back and try again</a>";
	exit();
}

$DB_PASSWORD = strval($DB[0]["Password"]);
$DB_KEY_1 = strval($DB[0]["Key1"]);
$DB_KEY_2 = strval($DB[0]["Key2"]);
$DB_KEY_3 = strval($DB[0]["Key3"]);

// And compare the two

$LOGMEIN = password_verify($PASSWORD, $DB_PASSWORD) && $KEY_1 === $DB_KEY_1 && $KEY_2 === $DB_KEY_2 && $KEY_3 === $DB_KEY_3;
if (!$LOGMEIN) {
	// The credentials aren't correct

	echo "Wrong credentials.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Go back and try again</a>";
	exit();

} else {
	// The credentials are correct
	
	$SESSION_KEY = uniqid();
	$NOW = date('Y-m-d H:i:s');

	\Internals\MySQL\Write("INSERT INTO `session_keys` (`Session Key`,`Username`,`Timestamp`) VALUES ('$SESSION_KEY', '$USERNAME', '$NOW')");
	
	$EXPIRYDATE = time() + (60*60*24);
	setcookie(
		"Session", $SESSION_KEY,
		$EXPIRYDATE,
		"/", "sasakowski.space",
		true, true
	);

	\Internals\Redirect\Redirect("https://sasakowski.space/");
}
?>