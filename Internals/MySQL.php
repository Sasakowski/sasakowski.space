<?php namespace Internals\MySQL;

use mysqli;
use mysqli_sql_exception;

// The webserver has only ports 80 and 443 open.
// The webserver does NOT use laragon, which is a WNMP stack. It's a loving tribute to its crucial contributions before this website existed.
// I'll create an API page that allows direct access to the db (within limits)

function Read($QUERY) {

	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.read", "eehB6LS9S&KP@CaD", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	
	$RESULT = mysqli_query($CONNECTION, $QUERY);
	return mysqli_fetch_all($RESULT, MYSQLI_ASSOC);
}

function Write($QUERY) {
	
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.write", "eehB6LS9S&KP@CaD", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	
	mysqli_query($CONNECTION, $QUERY);
	// No return because this delete query don't return any data
}

function Delete($QUERY) {
	
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.delete", "eehB6LS9S&KP@CaD", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	
	mysqli_query($CONNECTION, $QUERY);
	// No return because this delete query don't return any data
}

?>