<?php

if ($__GLOBAL__STYLE["AltTheme"] === "None") {

	// Do nothing

} else {

	\Internals\Cookies\Edit("AltTheme", "None");
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>