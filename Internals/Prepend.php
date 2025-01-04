<?php

$___MAINTENANCE_MODE = false;
if ($___MAINTENANCE_MODE) {
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

// Internals is a special directory that contains the site's fundamental code in the form of PHP files.
// A direct view of these files would cause PHP to run into errors, the most likely error being 'cannot redeclare this function'.
// Try it out yourself! https://sasakowski.space/Internals/Master/Prepend.php - you'll be greeted by a pallas' cat.
$URI = $_SERVER["REQUEST_URI"];
if ( str_starts_with($URI, "/Internals") ) {
	echo "<img src = 'https://i.huffpost.com/gen/2691324/images/o-PALLAS-CAT-facebook.jpg' style = 'width: 90%;'><br>";
	exit();
}

require_once(__DIR__ . "/MySQL.php");
require_once(__DIR__ . "/Cookies.php");
require_once(__DIR__ . "/Redirect.php");
require_once(__DIR__ . "/Accounts.php");
require_once(__DIR__ . "/Favicons.php");
require_once(__DIR__ . "/Style.php");
require_once(__DIR__ . "/HTMLElements.php");
require_once(__DIR__ . "/Time.php");

$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
if ($LOGIN_STATUS["Login"] === -1 and !str_starts_with($_SERVER["REQUEST_URI"], "/Static/Login")) {
	echo "Your session key has expired.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in again</a>";
	exit();
}

echo "<!DOCTYPE html><html>
	<body id = 'NO_SCRIPT_BODY'><noscript id = 'NO_SCRIPT'>
	<style src = 'https://sasakowski.space/Static/Stylesheets/Master.css'></style>
	<style src = 'https://sasakowski.space/Static/Stylesheets/Void.css'></style>
	<block style = 'z-index: 999; position: absolute; height: 98vh; width: 99vw; border-radius: 0px;'>
		<flex_rows class = 'center_v'>
			<space_xl></space_xl>
			<text_xl>This website requires JavaScript to function.</text_xl>
			<space_l></space_l>
			<img style = 'height: 10vh;' src = 'https://www.nyan.cat/cats/original.gif'>
			<space_l></space_l>
			<audio src = 'https://www.nyan.cat/music/daft.ogg' controls>
		</flex_rows>
	</block>
</noscript>
<script src = 'https://sasakowski.space/Static/Collapsibles.js'></script>
<script>
document.addEventListener('readystatechange', function () {
	if (document.readyState === 'interactive') {
		document.getElementById('NO_SCRIPT').style.display = 'none';
		document.getElementById('EVERYTHING').style.display = 'block';
		PageInit();
	}
});
</script><div id = 'EVERYTHING' style = 'display: none;'>
";