<?php namespace Internals\Accounts;

use OutOfBoundsException;

// Get the URL of an account's directory
function GetDirectoryURL($USERNAME) {

	$DB = \Internals\MySQL\Read("SELECT `Username` FROM `accounts` WHERE `Username` = '$USERNAME'");
	if (empty($DB)) {
		
		throw new OutOfBoundsException("Account not found.");
	
	} else {

		$USERNAME = $DB[0]["Username"];
		return "https://sasakowski.space/Accounts/Contents/$USERNAME/";
	}
}

// Get the URL of an account's file (for an src/href attribute or something)
function GetFileURL($USERNAME, $FILE) {
	return GetDirectoryURL($USERNAME) . $FILE;
}

// Get the data of any account
function GetInfo($USERNAME) {
	
	\Internals\XSS\SQL([$USERNAME]);
	\Internals\XSS\KillIfMarkup($USERNAME);
	$DB = \Internals\MySQL\Read("SELECT `Rank`,`Status`,`Age`,`Timezone` FROM `accounts` WHERE `Username` = '$USERNAME'");
	
	if (empty($DB)) {
		throw new OutOfBoundsException("Account not found.");
	}

	return [
		"Username" => $USERNAME,
		"Rank" => $DB[0]["Rank"],
		"Status" => $DB[0]["Status"],
		"Age" => $DB[0]["Age"],
		"Timezone" => $DB[0]["Timezone"],
	];
}



// Only relevant to Prepend.php
function _GetLogin() {

	$SESSION_KEY = \Internals\Cookies\Get("SessionKey", null);

	if ($SESSION_KEY === null) {
		// The session key doesn't exist, so make no further efforts to log the user in.
		return [
			"Login" => 0, // 0 means no session key exists, aka anonymous login.
			"Username" => "None",
			"Rank" => "None",
			"Status" => "None",
			"Age" => "None",
			"Timezone" => "None",
		];
		
	} else {

		// A session key does exist, so continue the effort.
		\Internals\XSS\SQL([$SESSION_KEY === null ? "" : $SESSION_KEY]);
		$DB = \Internals\MySQL\Read("SELECT `Username` FROM `session_keys` WHERE `Session Key` = '$SESSION_KEY'");

		if (empty($DB) and !str_starts_with($GLOBALS["__GLOBAL__URL"], "/Static/Login/")) {
			echo "<!DOCTYPE html><html>
			Your session key has expired. Log in again to get a new key.<br>
			(If you edited it, change it back and it should just work again.)<br><br>
			<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>
			";
			exit();
		}

		$USERNAME = $DB[0]["Username"];

		// Now that we have a username, load the user's account data.
		$DB = \Internals\MySQL\Read("SELECT `Rank`,`Status`,`Age`,`Timezone` FROM `accounts` WHERE `Username` = '$USERNAME'");
		
		$RANK = $DB[0]["Rank"];
		$STATUS = $DB[0]["Status"];
		$AGE = $DB[0]["Age"];
		$TIMEZONE = $DB[0]["Timezone"];

		// Check wether the account should be able to log in
		if ($STATUS === "Inactive") {
			
			echo "<!DOCTYPE html><html>
			Your account is inactive. Please get into contact with this website's administration to activate it again.";
			exit();

		} elseif ($STATUS === "Banned") {

			echo "<!DOCTYPE html><html>
			Your account is banned, so have a nice day.<br><br>
			Oh, and before you go, I'd like to say that <audio src = 'https://sasakowski.space/Static/Login/Ylvis.ogg' controls loop>
			";
			exit();
		}

		return [
			"Login" => 1, // 1 means successful log-in.
			"Username" => $USERNAME,
			"Rank" => $RANK,
			"Status" => $STATUS,
			"Age" => $AGE,
			"Timezone" => $TIMEZONE,
		];
	}
}

?>