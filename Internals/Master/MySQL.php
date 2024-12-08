<?php namespace Internals\MySQL;

use mysqli;
use mysqli_sql_exception;

// FYI: the webserver has only ports 80 and 443 open.
// I'll create a .php page to view the db data directly in the future.
function Query($QUERY) {
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.read", "$@nBt568ht#D&YJa", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new mysqli_sql_exception("The webserver failed to connect to its database. This is NOT supposed to occur!"); }
	$RESULT = mysqli_query($CONNECTION, $QUERY);
	return mysqli_fetch_all($RESULT, MYSQLI_ASSOC);
}