<?php
if (!isset($_GET["AltTheme"])) { $ALT_THEME = "None"; }
else { $ALT_THEME = $_GET["AltTheme"]; }

\Internals\Cookies\Edit("AltTheme", $ALT_THEME);
\Internals\Style\_RepairAltTheme();

\Internals\Redirect\RedirectBack();