<?php namespace Internals\Style;

function Init() {
	$ECHO = "";

	// Repair
	$TEXT_SIZE = _RepairTextSize();
	$THEME = _RepairTheme();
	_RepairAltTheme(); // Returned value isn't used

	// Text size
	$ECHO .= "<style>:root { --textPHP: {$TEXT_SIZE}vh; }</style>";
	$ECHO .= "<link rel = 'stylesheet' href = 'https://sasakowski.space/Static/Stylesheets/Master.css'>";

	// Theme
	$ECHO .= "<link rel = 'stylesheet' href = 'https://sasakowski.space/Static/Stylesheets/{$THEME}.css'>";
	
	return $ECHO;
}

function GetTextSize() {
	$MIN = 2;
	$TEXT_SIZE = \Internals\Cookies\Get("TextSize", $MIN);
	return $TEXT_SIZE;
}
function GetTheme() {
	$DEFAULT = "Void";
	$THEME = \Internals\Cookies\Get("Theme", $DEFAULT);
	return $THEME;
}
function GetAltTheme() {
	$DEFAULT = "None";
	$ALT_THEME = \Internals\Cookies\Get("AltTheme", $DEFAULT);
	return $ALT_THEME;
}



function _RepairTextSize() {
	$MAX_SIZE = 3;
	$MIN_SIZE = 2;
	$TEXT_SIZE = \Internals\Cookies\Get("TextSize", $MIN_SIZE);

	if (!is_numeric($TEXT_SIZE)) {
		$TEXT_SIZE = $MIN_SIZE;
		\Internals\Cookies\Edit("TextSize", $MIN_SIZE);
	}
	else {
		if ($TEXT_SIZE > $MAX_SIZE) {
			$TEXT_SIZE = $MAX_SIZE;
			\Internals\Cookies\Edit("TextSize", $MAX_SIZE);
		}
		elseif ($TEXT_SIZE < $MIN_SIZE) {
			$TEXT_SIZE = $MIN_SIZE; 
			\Internals\Cookies\Edit("TextSize", $MIN_SIZE);
		}
	}
	return $TEXT_SIZE;
}
function _RepairTheme() {
	$THEME = \Internals\Cookies\Get("Theme", "Void");
	$DEFAULT = "Void";
	$THEMES = ["Void","Light"];

	if (!in_array($THEME, $THEMES)) {
		$THEME = $DEFAULT; 
		\Internals\Cookies\Edit("Theme", $DEFAULT);
	}
	return $THEME;
}
// AltTheme is just for fun
function _RepairAltTheme() {
	$THEME = \Internals\Cookies\Get("AltTheme", "None");
	$DEFAULT = "None";
	$THEMES = ["None","Ellie"];

	if (!in_array($THEME, $THEMES)) {
		$THEME = $DEFAULT; 
		\Internals\Cookies\Edit("AltTheme", $DEFAULT);
	}
	return $THEME;
}