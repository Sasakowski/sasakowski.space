<?php namespace Internals\UserStyleSettings;

// Only relevant to Prepend.php and Static/Settings/

function Theme() {
	$DEFAULT = "Void";
	$RANGE = ["Void", "Light"];

	$THEME = \Internals\Cookies\Get("Theme", null);

	// Cookie doesn't exist.
	if ($THEME === null) {
		\Internals\Cookies\Create("Theme", $DEFAULT);
		$THEME = $DEFAULT;
	}
	// Cookie isn't within its range.
	elseif (!in_array($THEME, $RANGE)) {
		\Internals\Cookies\Edit("Theme", $DEFAULT);
		$THEME = $DEFAULT;
	}
	// Checking for XSS is unncessary, because it'd always fail the range check.

	return $THEME;

}

function AltTheme() {
	$DEFAULT = "None";
	$RANGE = ["None", "Ellie"];

	$ALT_THEME = \Internals\Cookies\Get("AltTheme", null);

	// Cookie doesn't exist.
	if ($ALT_THEME === null) {
		\Internals\Cookies\Create("AltTheme", $DEFAULT);
		$ALT_THEME = $DEFAULT;
	}
	// Cookie isn't within its range.
	elseif (!in_array($ALT_THEME, $RANGE)) {
		\Internals\Cookies\Edit("AltTheme", $DEFAULT);
		$ALT_THEME = $DEFAULT;
	}
	// Checking for XSS is unncessary, because it'd always fail the range check.

	return $ALT_THEME;
}

function TextSize() {
	$MIN = 2;
	$MAX = 3;
	$DEFAULT = $MIN;

	$TEXT_SIZE = \Internals\Cookies\Get("TextSize", null);

	// Cookie doesn't exist.
	if ($TEXT_SIZE === null) {
		\Internals\Cookies\Create("TextSize", $DEFAULT);
		$TEXT_SIZE = $DEFAULT;
	}
	// Cookie isn't a number.
	elseif (!is_numeric($TEXT_SIZE)) {
		\Internals\Cookies\Edit("TextSize", $DEFAULT);
		$TEXT_SIZE = $DEFAULT;
	}
	// Cookie is below its MIN or above its MAX
	elseif ($TEXT_SIZE < $MIN or $TEXT_SIZE > $MAX) {
		\Internals\Cookies\Edit("TextSize", $DEFAULT);
		$TEXT_SIZE = $DEFAULT;
	}
	// Checking for XSS is unncessary, because it'd always fail the range check.

	return $TEXT_SIZE;
}

?>