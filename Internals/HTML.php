<?php namespace Internals\HTML;

use OutOfBoundsException;

// ALWAYS manually write <!DOCTYPE html><html> at the start of every document intended to be an HTML file.

// The <head> file. Execute this directly after the <!DOCTYPE html><html>
function Head() {

	// The <head> element is heavily dependant on the user's selected styles.

	$THEME = $GLOBALS["__GLOBAL__STYLE"]["Theme"];
	$ALT_THEME = $GLOBALS["__GLOBAL__STYLE"]["AltTheme"];
	$TEXT_SIZE = $GLOBALS["__GLOBAL__STYLE"]["TextSize"];
	
	$ECHO_BUFFER = "<head>
	<meta name = 'robots' content = 'noindex, nofollow'/>";

	// First the title, which is affected by AltTheme
	switch ($ALT_THEME) {
		case "Ellie":
			$ECHO_BUFFER .= "<title>Ellie.bluemoon</title>";
			break;
		default:
			$ECHO_BUFFER .= "<title>Sasakowski.space</title>";
			break;
	}
	
	// Second is the favicon, which is also affected AltTheme
	switch ($ALT_THEME) {
		case "Ellie":
			$_ = \Internals\Accounts\GetFileURL("Henry", "Ellie Favicon.ico");
			break;
		default:
			$_ = \Internals\Accounts\GetFileURL("Sasakowski", "Catmask Favicon.ico");
			break;
	}
	$ECHO_BUFFER .= "<link rel = 'icon' href = '$_'>";
	
	// Third is the theme, which is affected by Theme
	$ECHO_BUFFER .= "<link rel = 'stylesheet' href = 'https://sasakowski.space/Static/Stylesheets/Master.css'>
	<link rel = 'stylesheet' href = 'https://sasakowski.space/Static/Stylesheets/$THEME.css'>";

	// Last is the text size, which is affected by TextSize. Master.css makes use of this.
	$ECHO_BUFFER .= "<style>:root { --textPHP: {$TEXT_SIZE}vh; }</style>";
	
	// Finally...
	echo $ECHO_BUFFER . "</head>";
}

// The top bar is partially affected by the user's style settings.
function Top() {

	// Only the AltTheme is relevant.
	$ALT_THEME = $GLOBALS["__GLOBAL__STYLE"]["AltTheme"];
	switch ($ALT_THEME) {
		case "Ellie":
			$LOGO = \Internals\Accounts\GetFileURL("Henry","Ellie Logo.png");
			$TITLE = "Ellie.bluemoon";
			break;
		default:
			$LOGO = \Internals\Accounts\GetFileURL("Sasakowski","Catmask.svg");
			$TITLE = "Sasakowski.space";
			break;
	}
	
	// The right is for log-in, log-out and hello!
	$LOGIN_STATUS = $GLOBALS["__GLOBAL__LOGIN"]["Login"];
	if ($LOGIN_STATUS === 1) {
		$USERNAME = $GLOBALS["__GLOBAL__LOGIN"]["Username"];
		$LOGIN = "<text>Hello, <i>$USERNAME!</i></text>
		<a href = 'https://sasakowski.space/Static/Login/LogMeOut.php'>Log out</a>
		";
	} else {
		$LOGIN = "<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>";
	}

	echo "<body><flex_rows>
	<block class = 'corner'>
		<flex_columns class = 'center_v'>
			<img src = '{$LOGO}' style = 'height: var(--text_xl);' id = 'TOP_LOGO' onclick = 'window.open(`https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia.giphy.com%2Fmedia%2FLXONhtCmN32YU%2Fgiphy.gif`);' target = '_blank'></img>
			<space></space>
			<text_l>$TITLE</text_l>	
			<space_l></space_l>
			<flex_columns class = 'center_v' style = 'justify-content: space-between;'>
				<flex_columns style = 'column-gap: var(--space);'>
					<a href = 'https://sasakowski.space'>Frontpage</a>
					<a href = 'https://sasakowski.space/Static/Sitemap.php'>Sitemap</a>
				</flex_columns>
				<flex_rows class = 'noflex center_h' style = 'min-width: fit-content;'>
					$LOGIN
				</flex_rows>
			</flex_columns>
		</flex_columns>
	</block><space_l></space_l>
	";
}

// Should be used if the page uses client-sided functions.
// Should occur after Head(); and before Top();
// Can also be called without Head(); and Top(); but the two must never be present if so.
function UseJS() {

	echo "<body>
	<noscript id = 'NO_SCRIPT'>
		<block style = 'z-index: 999; position: absolute; height: 98vh; width: 99vw; border-radius: 0px;'>
			<flex_rows class = 'center_v'>
				<space_xl></space_xl>
				<text_xl>This website requires JavaScript to function.</text_xl>
				<space_l></space_l>
				<img style = 'height: 10vh;' src = 'https://www.nyan.cat/cats/original.gif'>
				<space_l></space_l>
				<audio src = 'https://www.nyan.cat/music/daft.ogg' controls>
			</flex_rows>
		</block>
	</noscript>
	<script src = 'https://sasakowski.space/Internals/Collapsibles.js'></script>
	<script>
	document.addEventListener('readystatechange', function () {
		if (document.readyState === 'interactive') {
			document.getElementById('NO_SCRIPT').style.display = 'none';
			document.getElementById('DOMinic_Toretto').style.display = 'block';
			PageInit();
		}
	});
	</script><div id = 'DOMinic_Toretto' style = 'display: none;'>
	";
}

// Superorchestrator to rank_so, and the other three
function RankToCSS($RANK) {
	switch ($RANK) {
		case "Superorchestrator":
		case "superorchestrator":
		case "rank_so":
			return "rank_so";
			break;

		case "Orchestrator":
		case "orchestrator":
		case "rank_o":
			return "rank_o";
			break;

		case "Author":
		case "author":
		case "rank_a":
			return "rank_a";
			break;

		case "Reader":
		case "reader":
		case "rank_r":
			return "rank_r";
			break;
		
		default:
			throw new OutOfBoundsException("Rank not found.");
			break;
	}
}

?>