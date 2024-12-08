<?php

$TEXT = \Internals\Cookies\Get("Text", 2);
$BIGGER = 0.2;
if (($TEXT + $BIGGER) > 3) {
	\Internals\Cookies\Edit("Text", 3);
} else {
	\Internals\Cookies\Edit("Text", $TEXT + $BIGGER);
}

\Internals\Redirect\RedirectBack();

?>