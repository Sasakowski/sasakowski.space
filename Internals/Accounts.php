<?php namespace Internals\Accounts;

use OutOfBoundsException;

function GetAccountDirectoryPath($USERNAME) {
	$DB = \Internals\MySQL\Read("SELECT `Username` FROM `accounts` WHERE `Username` = '{$USERNAME}'");
	if (empty($DB)) {
		throw new OutOfBoundsException("Account {$USERNAME} not found.");
	} else {
		$USERNAME = $DB[0]["Username"];
		return "https://sasakowski.space/Accounts/Content/{$USERNAME}/";
	}
}

function GetAccountFilePath($USERNAME, $FILE) {
	$PATH = GetAccountDirectoryPath($USERNAME);
	$POINTER = $PATH . $FILE;
	if (file_exists($POINTER)) { throw new OutOfBoundsException("File {$FILE} not found."); }
	return $POINTER;
}

function GetLoginStatus() {
	// A session cookie must be there
	$SESSION_KEY = \Internals\Cookies\Get("Session", "None");
	if ($SESSION_KEY === "None") {
		return ["Login" => 0, "Username" => "None", "Rank" => "None", "Status" => "None", "Age" => "None", "Timezone" => "None"];
	}

	// An entry inside session_keys must be there
	$DB = \Internals\MySQL\Read("SELECT `Username` FROM `session_keys` WHERE `Session Key` = '$SESSION_KEY'");
	if (empty($DB)) {
		return ["Login" => -1, "Username" => "None", "Rank" => "None", "Status" => "None", "Age" => "None", "Timezone" => "None"];
	}

	// Get account info
	$USERNAME = $DB[0]["Username"];
	$DB = \Internals\MySQL\Read("SELECT `Rank`,`Status`,`Age`,`Timezone` FROM `accounts` WHERE `Username` = '$USERNAME'");
	$RANK = $DB[0]["Rank"];
	$STATUS = $DB[0]["Status"];
	$AGE = $DB[0]["Age"];
	$TIMEZONE = $DB[0]["Timezone"];
	return ["Login" => 1, "Username" => $USERNAME, "Rank" => $RANK, "Status" => $STATUS, "Age" => $AGE, "Timezone" => $TIMEZONE];
}

function GetAccountInfo($USERNAME) {
	$DB = \Internals\MySQL\Read("SELECT `Rank`,`Status`,`Age`,`Timezone` FROM `accounts` WHERE `Username` = '{$USERNAME}'");
	if (empty($RESULT)) {
		throw new OutOfBoundsException("Account {$USERNAME} not found.");
	} else {
		$RANK = $DB[0]["Rank"];
		$STATUS = $DB[0]["Status"];
		$AGE = $DB[0]["Age"];
		$TIMEZONE = $DB[0]["Timezone"];
		return ["Username" => $USERNAME, "Rank" => $RANK, "Status" => $STATUS, "Age" => $AGE, "Timezone" => $TIMEZONE];
	}
}