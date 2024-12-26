<?php namespace Internals\HTMLElements;

// TOP		(header)
// MIDDLE
// BOTTOM	(footer)

function Top() {
	$LOGO = null;
	$TITLE = null;
	$ALT_THEME = \Internals\Style\GetAltTheme();
	switch ($ALT_THEME) {
		case "Ellie":
			$LOGO = \Internals\Accounts\GetAccountFilePath("Henry","Ellie Logo.png");
			$TITLE = "Ellie.bluemoon";
			break;
		default:
			$LOGO = \Internals\Accounts\GetAccountFilePath("Sasakowski","Catmask.svg");
			$TITLE = "Sasakowski.space";
			break;	
	}

	$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
	$LOGIN_ROW = "";
	if ($LOGIN_STATUS["Login"] === 1) {
		$LOGIN_ROW = "
		<text>Hello, <i>{$LOGIN_STATUS['Username']}!</i></text>
		<a href = 'https://sasakowski.space/Static/Login/LogMeOut.php'>Log out</a>
		";
	} else {
		$LOGIN_ROW = "<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>";
	}
	echo "<flex_rows>
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
					<a href = 'https://sasakowski.space/Static/Settings/Settings.php'>Settings</a>
				</flex_columns>
				<flex_rows class = 'noflex center_h' style = 'min-width: fit-content;'>
					$LOGIN_ROW
				</flex_rows>
			</flex_columns>
		</flex_columns>
	</block><space_l></space_l>";
}

function Head() {
	$FAVICON = \Internals\Favicons\Catmask();
	$STYLE = \Internals\Style\Init();
	echo "<head>
	<title>Sasakowski.space</title>
	<meta name = 'robots' content = 'noindex, nofollow'/>
	{$FAVICON}
	{$STYLE}
	</head>";
}

function CheckHTMLSubmission_Forum($SUBMISSION) {
	if (strlen($SUBMISSION) > 500) {
		echo "Your comment is too long.<br><br>
		<a href = 'https://sasakowski.space/Forum/Forum.php'>Go back and try again</a>";
		exit();
	}

	if (str_contains($SUBMISSION, "<") or str_contains($SUBMISSION, ">")) {
		// Check for tags
		$RESULT = [];
		preg_match_all("/<[^>,\s]+/", $SUBMISSION, $RESULT);
		$RESULT = $RESULT[0];
		foreach ($RESULT as $R) {
			$R = substr($R, 1); // Always the < (which is useless now)
			if (!in_array($R, ["i","b","br","text_l","text_s", "/i", "/b", "/br", "/text_l", "/text_s"])) {
				echo "Your comment contains a disallowed HTML tag (closing tags included). This failed the check: < $R<br><br>
				<a href = 'https://sasakowski.space/Forum/Forum.php'>Go back and try again</a><br><br>
				Allowed tags:<br>
				- < i > and < /i ><br>
				- < b > and < /b ><br>
				- < br > and < /br ><br>
				- < text_l > and < /text_l ><br>
				- < text_s > and < /text_s ><br>
				";
				exit();
			}
		}
		// Check for attributes
		$RESULT = [];
		preg_match_all("/[A-za-z0-9]+\s*\=/", $SUBMISSION, $RESULT);
		$RESULT = $RESULT[0];
		if (!empty($RESULT)) {
			echo "Your comment contains an HTML attribute, which are completely disallowed. This failed the check: $RESULT[0]<br><br>
			<a href = 'https://sasakowski.space/Forum/Forum.php'>Go back and try again</a>";
			exit();
		}
	}
}
function PrepareHTMLSubmissionForDB($SUBMISSION) {
	$SUBMISSION = str_replace(["\r\n", "\r", "\n"], "<br>", $SUBMISSION);
	$SUBMISSION = str_replace("'", "\'", $SUBMISSION);
	return $SUBMISSION;
}