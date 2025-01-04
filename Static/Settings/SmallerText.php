<?php
$MIN = 2;
$SUBTRAHEND = 0.2;

$TEXT_SIZE = \Internals\Cookies\Get("TextSize", $MIN);
if (($TEXT_SIZE - $SUBTRAHEND) < $MIN) {
	\Internals\Cookies\Edit("TextSize", $MIN);
} else {
	\Internals\Cookies\Edit("TextSize", $TEXT_SIZE - $SUBTRAHEND);
}

\Internals\Redirect\Redirect("https://sasakowski.space/Static/Settings/Settings.php");