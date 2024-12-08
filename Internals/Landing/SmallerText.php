<?php

$TEXT = \Internals\Cookies\Get("Text", 2);
$SMALLER = 0.2;
if (($TEXT - $BIGGER) <= 2) {
	\Internals\Cookies\Edit("Text", 2);
} else {
	\Internals\Cookies\Edit("Text", $TEXT - $SMALLER);
}

\Internals\Redirect\RedirectBack();

?>