<?php

if ($_SERVER["REMOTE_ADDR"] !== "127.0.0.1") {
	exit();
}

if (isset($_GET["PW"])) {
	$PW = $_GET["PW"];
	echo "Password: " . password_hash($PW, PASSWORD_DEFAULT);
} else {
	echo "For a password, the PW parameter is neccessary.<br><br>";
}

?>