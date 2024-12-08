<?php namespace Internals\Stc\Style;

function Init() {
	$ECHO_BUFFER = "";

	// Repair
	$COOKIE_TEXT = \Internals\Cookies\Get("Text", 2);
	$COOKIE_TEXT_MAXSIZE = 3;
	$COOKIE_TEXT_MINSIZE = 2;
	if (!is_numeric($COOKIE_TEXT)) { $COOKIE_TEXT = 2; \Internals\Cookies\Edit("Text", "2"); }
	else {
		if ($COOKIE_TEXT > $COOKIE_TEXT_MAXSIZE) { $COOKIE_TEXT = $COOKIE_TEXT_MAXSIZE; \Internals\Cookies\Edit("Text", $COOKIE_TEXT_MAXSIZE); }
		if ($COOKIE_TEXT < $COOKIE_TEXT_MINSIZE) { $COOKIE_TEXT = $COOKIE_TEXT_MINSIZE; \Internals\Cookies\Edit("Text", $COOKIE_TEXT_MINSIZE); }
	}

	$COOKIE_THEME = \Internals\Cookies\Get("Theme", "Void");
	$DEFAULT_THEME = "Void";
	$LEGAL_THEMES = ["Void","Light"];
	if (!in_array($COOKIE_THEME, $LEGAL_THEMES)) { \Internals\Cookies\Edit("Theme", $DEFAULT_THEME); }

	// Text
	$ECHO_BUFFER .= "<style>:root { --text: {$COOKIE_TEXT}vh; }</style>";
	$ECHO_BUFFER .= "<link rel = 'stylesheet' href = 'https://sasakowski.space/Stc/Stylesheets/Master.css'>";

	// Theme
	$ECHO_BUFFER .= "<link rel = 'stylesheet' href = 'https://sasakowski.space/Stc/Stylesheets/{$COOKIE_THEME}.css'>";
	
	return $ECHO_BUFFER;
}