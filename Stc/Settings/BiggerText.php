<?php
$MIN = 2;
$MAX = 3;
$ADDEND = 0.2;

$TEXT_SIZE = \Internals\Cookies\Get("TextSize", $MIN);
if (($TEXT_SIZE + $BIGGER) >= $MAX) {
	\Internals\Cookies\Edit("TextSize", $MAX);
} else {
	\Internals\Cookies\Edit("TextSize", $TEXT_SIZE + $ADDEND);
}

\Internals\Redirect\RedirectBack();