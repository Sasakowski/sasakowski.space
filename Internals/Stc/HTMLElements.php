<?php namespace Internals\Stc\HTMLElements;

// TOP		(header)
// MIDDLE
// BOTTOM	(footer)

function NoScript() {
	echo "<noscript id = 'NO_SCRIPT'><block style = 'z-index: 999; position: absolute; height: 98vh; width: 99vw; border-radius: 0px;'>
		<flex_rows class = 'center_v'>
			<space_xl></space_xl>
			<text_xl>This website requires JavaScript to function.</text_xl>
			<space_l></space_l>
			<img style = 'height: 10vh;' src = 'https://www.nyan.cat/cats/original.gif'>
		</flex_rows>
	</block></noscript>
	<script>document.getElementById('NO_SCRIPT').style.display = 'none';</script>";
}

function Top() {
	$LOGO = null;
	$TITLE = null;
	$ALT_THEME = \Internals\Stc\Style\GetAltTheme();
	switch ($ALT_THEME) {
		case "Ellie":
			$LOGO = \Internals\Stc\Accounts\GetAccountFilePath("Henry","Ellie Logo.png");
			$TITLE = "Ellie.bluemoon";
			break;
		default:
			$LOGO = \Internals\Stc\Accounts\GetAccountFilePath("Sasakowski","Catmask.svg");
			$TITLE = "Sasakowski.space";
			break;	
	}

	echo "<flex_rows>
	<block class = 'corner'>
		<flex_columns class = 'center_v'>
			<img src = '{$LOGO}' style = 'height: var(--text_xl);' id = 'TOP_LOGO' onclick = 'window.open(`https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia.giphy.com%2Fmedia%2FLXONhtCmN32YU%2Fgiphy.gif`);' target = '_blank'></img>
			<space></space>
			<text_l><a href = 'https://sasakowski.space'>{$TITLE}</a></text_l>
		</flex_columns>
	</block><space_l></space_l>";
}

function Footer() {
	$ECHO = "<space_l></space_l>
	<block><flex_rows>
		<flex_columns style = 'column-gap: 1vw;'>
			<a href = 'https://sasakowski.space/Stc/Settings/Settings.php'>Settings</a>
			<a href = 'https://sasakowski.space/Stc/Footer/CookiePolicy.php'>Cookie Policy</a>
			<a href = 'https://sasakowski.space/Stc/Footer/Sitemap.php'>Sitemap</a>
		</flex_columns><space_s></space_s><flex_columns style = 'column-gap: 1vw;'>
	";
	$LOGGED_IN = \Internals\Stc\Accounts\GetLoginStatus();
	if ($LOGGED_IN[0] !== 1) {
		$ECHO .= "<a href = 'https://sasakowski.space/Stc/Login/Login.php'>Login</a>";
	} else {
		$ECHO .= "<a href = 'https://sasakowski.space/Stc/Login/LogMeOut.php'>Logout</a>";
	}
	if ($LOGGED_IN[0] === 1) {
		$INFO = \Internals\Stc\Accounts\GetAccountInfo();
		$ECHO .= "<text>Logged in: <i>{$INFO['Username']}</i></text>";
	}
	
	echo $ECHO;
}

function Head() {
	$FAVICON = \Internals\Stc\Favicons\Catmask();
	$STYLE = \Internals\Stc\Style\Init();
	echo "<head>
	<title>Sasakowski.space</title>
	<meta name = 'robots' content = 'noindex, nofollow'/>
	{$FAVICON}
	{$STYLE}
	</head>";
}