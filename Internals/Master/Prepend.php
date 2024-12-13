<?php

$SETTINGS = json_decode(file_get_contents(__DIR__ . "/Settings.json"), true);
if ($SETTINGS["Maintenance"] === true) {
	echo "
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

// Internals is a special directory that contains the site's code in the form of PHP files.
// A direct view of these files would cause PHP to run into errors, the most likely being 'cannot redeclare this function'.
// Try it out yourself! https://sasakowski.space/Internals/Master/Prepend.php - you'll be greeted by a pallas' cat.
if ( str_starts_with($_SERVER["REQUEST_URI"], "/Internals") ) {
	echo "<img src = 'https://i.huffpost.com/gen/2691324/images/o-PALLAS-CAT-facebook.jpg' style = 'width: 90%;'><br>";
	exit();
}

require_once(dirname(__DIR__) . "/Stc/Stc.php");
require_once(dirname(__DIR__) . "/Master/MySQL.php");
require_once(dirname(__DIR__) . "/Master/Cookies.php");
require_once(dirname(__DIR__) . "/Master/Redirect.php");