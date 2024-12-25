<?php namespace Internals\Time;

use BadFunctionCallException;
use DateTime;
use DateTimeZone;

function UTCOffsetFromWebserver($DATE, $NEW_TIMEZONE) {
	// $DATE -> something like 2024-12-18 00:22:59
	// $NEW_TIMEZONE -> something like UTC-9

	if(!str_starts_with($NEW_TIMEZONE, "UTC")) {
		$NEW_TIMEZONE = "UTC" . $NEW_TIMEZONE;
	}

	// Webserver dates are in UTC+3
	if ($NEW_TIMEZONE === "UTC+3") {
		return $DATE;
	}

	$DATETIME = new DateTime($DATE, new DateTimeZone( ConvertUTCToNumerical("UTC+3") ));
	$NEW_TIMEZONE = new DateTimeZone( ConvertUTCToNumerical($NEW_TIMEZONE) );
	
	$DATETIME -> setTimezone($NEW_TIMEZONE);
	return $DATETIME -> format('Y-m-d H:i:s');
}

function ConvertUTCToNumerical($UTC) {
	// $UTC -> something like UTC+3; we want it to be +0300 instead

	if(!str_starts_with($UTC, "UTC")) {
		throw new BadFunctionCallException("Timezone isn't in the UTC+?(?) or UTC-?(?) format");
	}
	
	$TIMEZONE = substr($UTC, 3); // Remove the UTC from UTC+3

	if($TIMEZONE[0] !== "+" and $TIMEZONE[0] !== "-") {
		throw new BadFunctionCallException("Timezone has no plus/minus.");
	}
	$PREPEND = $TIMEZONE[0]; // + or -

	$TIMEZONE = substr($TIMEZONE, 1); // Remove the plus/minus; now it's only a number, either 1-digit or 2-digits long

	if (strlen($TIMEZONE) === 1) {
		return $PREPEND . "0" . $TIMEZONE . "00";
	}
	elseif (strlen($TIMEZONE) === 2) {
		return $PREPEND . $TIMEZONE . "00";
	} else {
		throw new BadFunctionCallException("Timezone offset is malformed.");
	}
}

?>