<?php
// Any variable declared here is accessable to all other files
// Hence the __GLOBAL__ prefix


// First is maintenance mode
$__GLOBAL__MAINTENANCE_MODE = false;
if ($__GLOBAL__MAINTENANCE_MODE) {
	echo "<!DOCTYPE html><html>
	<head>
		<title>Sasakowski.space</title>
		<meta name = 'robots' content = 'noindex, nofollow'/>
	</head>
	<body style = 'background-color: #C0C0C0;'>
	<flex style = 'width: 99vw; display: flex; justify-content: center;'>
		<div style = 'font-size: 16vh;'>☕</div>
	</flex>
	<br>
	<flex style = 'width: 99vw; display: flex; justify-content: center;'>
		<div style = 'font-size: 4vh;'><b>Maintenance</b></div>
	</flex>
	<br>
	<flex style = 'width: 99vw; display: flex; justify-content: center;'>
		<div style = 'font-size: 2vh;'>Come back later!</div>
	</flex>
	";
	exit();
}


// Internals is a special directory that contains vital code of this website.
// Viewing any .php file manually inside this directory will cause PHP-errors.
$__GLOBAL__URL = $_SERVER["REQUEST_URI"];
if (str_starts_with($__GLOBAL__URL, "/Internals/")) {
	echo "<!DOCTYPE html><html>
	<body style = 'margin: 0px;'>
		<img src = 'https://i.huffpost.com/gen/2691324/images/o-PALLAS-CAT-facebook.jpg' style = 'width: 99vw;'>";
	exit();
}


// Import the other internals, which are also globally usable
require_once(__DIR__ . "/" . "Accounts.php"); // Allow interactions between the webserver and account data (of everyone).
require_once(__DIR__ . "/" . "Cookies.php"); // Allow interactions between the webserver and the user's cookies.
require_once(__DIR__ . "/" . "MySQL.php"); // Allow interactions between the webserver and the db.
require_once(__DIR__ . "/" . "Redirect.php"); // Redirect the user. Also exit()s to stop the old script from continuing.
require_once(__DIR__ . "/" . "UserStyleSettings.php"); // Allow interactions between the webserver and the user's style cookies.
require_once(__DIR__ . "/" . "XSS.php"); // Functions to combat XSS (actually to verify user input).
require_once(__DIR__ . "/" . "HTML.php"); // Mostly just large preset ECHOs that contain whole HTML segments.
require_once(__DIR__ . "/" . "Time.php"); // Allow the webserver to juggle time and dates around.
require_once(__DIR__ . "/" . "XSSPresets.php"); // Some pages share XSS checks.

// Attempt to log the user in, then use the result array as a __GLOBAL__ variable.
// Do NOT store the session key in a separate variable, to avoid leaking it by accident or XSS.
$__GLOBAL__LOGIN = \Internals\Accounts\_GetLogin();

// Load the user's style (theme, alttheme, textsize) and store all settings as a __GLOBAL__ variable.
// These functions verify and repair themselves (they're cookies) if given.
$__GLOBAL__STYLE = [
	"Theme" => \Internals\UserStyleSettings\_Theme(),
	"AltTheme" => \Internals\UserStyleSettings\_AltTheme(),
	"TextSize" => \Internals\UserStyleSettings\_TextSize(),
];

// __GLOBAL__MAINTENANCE_MODE -> if the page is in maintenance mode (actually only false because execution stops if its true).
// __GLOBAL__URL -> the URL the user has specified
// __GLOBAL__LOGIN -> the login status of the user
// __GLOBAL__STYLE -> the user's style settings

?>