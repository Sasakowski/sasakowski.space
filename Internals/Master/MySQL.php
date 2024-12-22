<?php namespace Internals\MySQL;

use mysqli;
use mysqli_sql_exception;

// FYI: the webserver has only ports 80 and 443 open.
// I'll create a .php page to view the db data directly in the future.
function Read($QUERY) {
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.read", "laragon", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	$RESULT = mysqli_query($CONNECTION, $QUERY);
	return mysqli_fetch_all($RESULT, MYSQLI_ASSOC);
}

function Write($QUERY) {
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.write", "laragon", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	mysqli_query($CONNECTION, $QUERY);
}

function Delete($QUERY) {
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.delete", "laragon", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	mysqli_query($CONNECTION, $QUERY);
}