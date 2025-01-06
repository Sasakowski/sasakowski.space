<?php namespace Internals\Cookies;

// Be sure to check for XSS

use DateException;

// Get a cookie
// Won't create a cookie if it doesn't exist
// Will return the fallback value if the key doesn't exist
function Get($KEY, $FALLBACK_VALUE) {
	$VALUE = isset($_COOKIE[$KEY]) ? $_COOKIE[$KEY] : $FALLBACK_VALUE;
	return $VALUE;
}

// Create a cookie
// Won't return a value
function Create($KEY, $VALUE, $EXPIRY_DATE = null) {

	// Default: expire as late as possible
	if ($EXPIRY_DATE === null) {
		$EXPIRY_DATE = time() + (60*60*24*365.25*100); // seconds_in_a_minute, minutes_in_an_hour, hours_in_a_day, 365.25_days_in_a_year, 100_years
	}
	// If not default, $EXPIRY_DATE should be something like time() + (some_time_equation)
	if (!is_numeric($EXPIRY_DATE)) {
		throw new DateException("Invalid expiry date given.");
		exit();
	}

	setcookie(
		$KEY, $VALUE,
		$EXPIRY_DATE,
		"/", "sasakowski.space",
		true, true // secure, http_only
	);
}

// Editing is really just overriding a cookie by creating it again.
// Exists to make code more readable (creating IS NOT EQUAL TO editing).
function Edit($KEY, $NEW_VALUE) {

	if (!isset($_COOKIE[$KEY])) { return; } // The cookie doesn't exist, so do nothing.

	Create($KEY, $NEW_VALUE, null);
}

// A cookie is deleted by giving it an expiry date past the current date.
// Here, 01.01.1970 00:00:00+1 is used
function Delete($KEY) {

	setcookie($KEY, "", 1, "/", "sasakowski.space");
}

// A special function that will delete all currently present cookies.
function Wipe() {
	foreach ($_COOKIE as $K => $V) {
		Delete($K);
	}
}

?>