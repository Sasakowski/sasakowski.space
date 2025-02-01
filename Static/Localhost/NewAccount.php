<?php

if ($_SERVER["REMOTE_ADDR"] !== "127.0.0.1") {
	exit();
}

?>

If new account:<br>
- do stuff inside `accounts`<br>
- maybe `forum_viewpermissions`?<br>
- DEFINITELY `profiles`