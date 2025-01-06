<?php

if ($__GLOBAL__STYLE["Theme"] === "Light") {

	// Do nothing

} else {

	\Internals\Cookies\Edit("Theme", "Light");
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>