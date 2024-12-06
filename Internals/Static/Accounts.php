<?php namespace Internals\_Static\Accounts;

use BadFunctionCallException;

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
	if (empty($RESULT)) { trigger_error("Account {$ID}/{$USERNAME} not found in database.", E_USER_WARNING); }
	else { return dirname(__DIR__) . "/{$RESULT[0]["ID"]} {$RESULT[0]["Username"]}/"; }
}

?>