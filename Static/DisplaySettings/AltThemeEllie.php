<?php

if ($__GLOBAL__STYLE["AltTheme"] === "Ellie") {

	// Do nothing

} else {

	\Internals\Cookies\Edit("AltTheme", "Ellie");
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>