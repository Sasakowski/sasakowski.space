<?php

$SETTINGS = json_decode(file_get_contents(__DIR__ . "/Settings.json"), true);
if ($SETTINGS["Maintenance"] === true) {

	echo "
	<body style = 'background-color: #C0C0C0;'>
	<flex style = 'width: 99vw; display: flex; justify-content: center;'>
	<img src = 'https://sasakowski.space/Static/Accounts/01 Sasakowski/Catmask.svg' style = 'height: 16vh;'>
	<div style = 'font-size: 12vh;'>☕</div>
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

// These are internal files that WILL cause PHP to run into errors, the most likely being 'cannot redeclare this function'.
switch ($_SERVER["REQUEST_URI"]) {
	case "/Internals/Master/MySQL.php":
	case "/Internals/Master/Prepend.php":
	case "/Internals/Static/Accounts.php":
	case "/Internals/Static/Static.php":
		echo "lmao";
		exit();
}

require_once(dirname(__DIR__) . "/Static/Static.php");
require_once(dirname(__DIR__) . "/Master/MySQL.php");
?>