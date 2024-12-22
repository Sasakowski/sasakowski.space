<?php namespace Internals\Stc\Accounts;

use BadFunctionCallException;
use OutOfBoundsException;

function GetAccountDirectoryPath($USERNAME) {
	$RESULT = \Internals\MySQL\Read("SELECT `Username` FROM `accounts` WHERE `Username` = '{$USERNAME}'");
	if (empty($RESULT)) {
		throw new OutOfBoundsException("Account {$USERNAME} not found.");
	} else {
		$USERNAME = $RESULT[0]["Username"];
		return "https://sasakowski.space/Stc/Accounts/{$USERNAME}/";
	}
}

function GetAccountFilePath($USERNAME, $FILE) {
	$PATH = GetAccountDirectoryPath($USERNAME);
	$POINTER = $PATH . $FILE;
	if (file_exists($POINTER)) { throw new OutOfBoundsException("File {$FILE} not found."); }
	return $POINTER;
}

function GetLoginStatus() {
	// Returns an array of [CODE, VALUE]

	// A session cookie must be there
	$SESSION_KEY = \Internals\Cookies\Get("Session", "NONE");
	if ($SESSION_KEY === "NONE") { return [0, "NOT_LOGGED_IN"]; }

	// An entry inside session_keys must be there
	$DB = \Internals\MySQL\Read("SELECT `Username` FROM `session_keys` WHERE `Session Key` = '$SESSION_KEY'");
	if (empty($DB)) { return [-1, "EXPIRED_SESSION"]; }

	return [1, $DB[0]["Username"]];
}

function GetAccountInfo() {
	$LOGGED_IN = GetLoginStatus();
	if ($LOGGED_IN[0] !== 1) {
		return ["Username" => "None", "Rank" => "None", "Status" => "None", "Age" => "None"];
	}
	$USERNAME = $LOGGED_IN[1];

	$DB = \Internals\MySQL\Read("SELECT `Rank`,`Status`,`Age` FROM `accounts` WHERE `Username` = '$USERNAME'");
	$RANK = $DB[0]["Rank"];
	$STATUS = $DB[0]["Status"];
	$AGE = $DB[0]["Age"];

	return ["Username" => $USERNAME, "Rank" => $RANK, "Status" => $STATUS, "Age" => $AGE];
}