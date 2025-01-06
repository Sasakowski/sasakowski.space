<?php
$_ = $__GLOBAL__STYLE["TextSize"] + 0.2;

if ($_ > 3) {

	// Do nothing

} else {
	
	\Internals\Cookies\Edit("TextSize", $_);
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/DisplaySettings/Settings.php");

?>