<?php namespace Internals\Stc\Accounts;

use BadFunctionCallException;
use OutOfBoundsException;

function GetAccountDirectoryPath($USERNAME = "", $ID = -1) {
	if ($USERNAME === "" && $ID === 0) { throw new BadFunctionCallException("No username or ID given."); }

	$RESULT = null;
	if ($USERNAME === "") {
		// Go with ID
		$RESULT = \Internals\MySQL\Query("SELECT `ID`,`Username` FROM `Accounts` WHERE `ID` = '{$ID}'");
	} else {
		// Go with USERNAME
		$RESULT = \Internals\MySQL\Query("SELECT `ID`,`Username` FROM `Accounts` WHERE `Username` = '{$USERNAME}'");
	}
	if (empty($RESULT)) {
		throw new OutOfBoundsException("Account {$USERNAME}/{$ID} not found.");
	} else {
		$POINTER = "{$RESULT[0]["ID"]} {$RESULT[0]["Username"]}";
		if (strlen($RESULT[0]["ID"]) === 1) { $POINTER = "0" . $POINTER; }
		return "https://sasakowski.space/Stc/Accounts/{$POINTER}/";
	}
}

function GetAccountFilePath($USERNAME = "", $ID = -1, $FILE = "") {
	if ($FILE === "") { throw new BadFunctionCallException("No file given."); }
	$PATH = GetAccountDirectoryPath($USERNAME, $ID);
	$POINTER = $PATH . $FILE;
	if (file_exists($POINTER)) { throw new OutOfBoundsException("File {$FILE} not found."); }
	return $POINTER;
}