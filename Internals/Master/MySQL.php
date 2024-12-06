<?php namespace Internals\MySQL;

use RuntimeException;
use mysqli;

// FYI: the linux machine only has ports 80 and 443 open. The database should only be accessible through the webserver itself (localhost).
// I'll create a .php page to access the db data directly in the future.
function Query($QUERY) {
	$CONNECTION = new mysqli("127.0.0.1:3306", "laragon.read", "$@nBt568ht#D&YJa", "sasakowski.space");
	if ($CONNECTION -> connect_error) { throw new RuntimeException("Failed to connect to the MySQL@localhost database. This is NOT supposed to occur!"); }
	$RESULT = mysqli_query($CONNECTION, $QUERY);
	return mysqli_fetch_all($RESULT, MYSQLI_ASSOC);
}

?>