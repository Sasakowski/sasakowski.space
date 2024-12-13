<?php
if (!isset($_GET["Theme"])) { $THEME = "Void"; }
else { $THEME = $_GET["Theme"]; }

\Internals\Cookies\Edit("Theme", $THEME);
\Internals\Stc\Style\_RepairTheme();

\Internals\Redirect\RedirectBack();