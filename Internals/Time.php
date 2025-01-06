<?php namespace Internals\Time;

use BadFunctionCallException;
use DateTime;
use DateTimeZone;

// UTC+3 to +0300.
function UTCToNumerical($UTC) {

	// First verify the input.
	if (!str_starts_with($UTC, "UTC+") and !str_starts_with($UTC, "UTC-")) {
		throw new BadFunctionCallException("Timezone is malformed.");
	}
	// UTC+3 to +3.
	$UTC = substr($UTC, 3);
	if (!is_numeric($UTC) or $UTC < -12 or $UTC > 14) {
		throw new BadFunctionCallException("Timezone is malformed.");
	}

	$PLUS_MINUS = $UTC[0];
	$UTC = substr($UTC, 1); // Now it's only a number.

	if ($UTC === "0") { $PLUS_MINUS = "+"; } // This is for UTC-0, which is actually UTC+0.
	
	if (strlen($UTC) === 2) {
		return $PLUS_MINUS . $UTC . "00";
	} else {
		return $PLUS_MINUS . "0" . $UTC . "00";
	}
}

function SetTimezoneOffset($DATE, $TIMEZONE, $NEW_TIMEZONE) {

	$TIMEZONE = new DateTimeZone(UTCToNumerical($TIMEZONE));
	$NEW_TIMEZONE = new DateTimeZone(UTCToNumerical($NEW_TIMEZONE));
	$DATE = new DateTime($DATE, $TIMEZONE);

	$DATE -> setTimezone($NEW_TIMEZONE);
	return $DATE -> format('Y-m-d H:i:s');
}

?>