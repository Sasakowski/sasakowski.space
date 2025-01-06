<?php

if ($__GLOBAL__STYLE["Theme"] === "Void") {

	// Do nothing

} else {

	\Internals\Cookies\Edit("Theme", "Void");
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>