<?php

if ($__GLOBAL__STYLE["TextSize"] === 2) {

	// Do nothing

} else {
	
	\Internals\Cookies\Edit("TextSize", 2);
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>