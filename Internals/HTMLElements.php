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

function CheckHTML($RAW_HTML_INPUT, $MAX_LENGTH = 0,
		$TAG_BLACKLIST = [],
		$TAG_WHITELIST = [],
		$ATTRIBUTE_BLACKLIST = [],
		$ATTRIBUTE_WHITELIST = [],
		$SPECIFIC_ATTRIBUTE_BLACKLIST = [],
		$SPECIFIC_ATTRIBUTE_WHITELIST = [],
		$ALLOW_ATTRIBUTES = false
		) {
	
	if (strlen($RAW_HTML_INPUT) > $MAX_LENGTH) {
		return [0, "Too long"];
	}

	// Find all elements and their attributes
	$FULL_ELEMENTS = [];
	preg_match_all("/\<[^\>]*\>/", $RAW_HTML_INPUT, $FULL_ELEMENTS);

	foreach ($FULL_ELEMENTS[0] as $FULL_ELEMENT) {
		
		// Get the tag
		$TAG = "";
		preg_match("/<[\s]*[^\>\s]*/", $FULL_ELEMENT, $TAG);
		$TAG = substr($TAG[0], 1);
		$TAG = trim($TAG, " ");
		if ($TAG === "") { continue; } // literally just < or >
		if ($TAG[0] === "/") { continue; } // Ignore closing tags (they don't work if there's no matching opening tag before them)
		
		$_ = _CheckHTMLBlacklist(-1, $TAG, $TAG_BLACKLIST);
		if ($_ !== null) { return $_; }
		$_ = _CheckHTMLWhitelist(-2, $TAG, $TAG_WHITELIST);
		if ($_ !== null) { return $_; }
		
		// Now do the attributes
		$FULL_ATTRIBUTES = [];
		preg_match_all("/[^\s]*[\s]*\=[\s]*[^\s\>]*/", $FULL_ELEMENT, $FULL_ATTRIBUTES);
		if (!empty($FULL_ATTRIBUTES[0]) and !$ALLOW_ATTRIBUTES) {
			return [-7, "Attributes are completely disallowed."];
		}

		foreach ($FULL_ATTRIBUTES[0] as $FULL_ATTRIBUTE) {
			// Split into key and value
			$__ = explode("=", $FULL_ATTRIBUTE);
			$KEY = trim($__[0], " ");
			$VALUE = $__[1]; // Currently unused, but might be useful later
			
			$_ = _CheckHTMLBlacklist(-3, $KEY, $ATTRIBUTE_BLACKLIST);
			if ($_ !== null) { return $_; }
			$_ = _CheckHTMLWhitelist(-4, $KEY, $ATTRIBUTE_WHITELIST);
			if ($_ !== null) { return $_; }
			
			// Finally the specific attributes
			// [
			//	"tag" => ["attributes", "only", "for", "this", "specific", "tag"],
			// 	"tag2" => ["same", "thing", "but", "only", "for", "tag2"],
			// 	"tag3" => ["also", "same", "thing", "but", "only", "for", "tag3"],
			//	...
			// ]

			if (in_array($TAG, array_keys($SPECIFIC_ATTRIBUTE_BLACKLIST))) {
				$_ = _CheckHTMLBlacklist(-5, $KEY, $SPECIFIC_ATTRIBUTE_BLACKLIST[$TAG]);
				if ($_ !== null) { return $_; }
			}
			if (in_array($TAG, array_keys($SPECIFIC_ATTRIBUTE_WHITELIST))) {
				$_ = _CheckHTMLWhitelist(-6, $KEY, $SPECIFIC_ATTRIBUTE_WHITELIST[$TAG]);
				if ($_ !== null) { return $_; }
			}
		}
	}

	// Do another run, but this time check for malformed elements
	// Here, only check the tags
	$BROKEN_ELEMENTS = [];
	preg_match_all("/\<[^\>\s]*/", $RAW_HTML_INPUT, $BROKEN_ELEMENTS);

	foreach ($BROKEN_ELEMENTS[0] as $BROKEN_ELEMENT) {

		// Get the tag
		$TAG = substr($BROKEN_ELEMENT, 1);
		if ($TAG === "") { continue; } // literally just < or >
		if ($TAG[0] === "/") { continue; } // Ignore closing tags (they don't work if there's no matching opening tag before them)

		$_ = _CheckHTMLBlacklist(-1, $TAG, $TAG_BLACKLIST);
		if ($_ !== null) { return $_; }
		$_ = _CheckHTMLWhitelist(-2, $TAG, $TAG_WHITELIST);
		if ($_ !== null) { return $_; }
	}
	
	// Just return the rawHTMLinput, because any check failure stops this function before it can reach this point
	return [1, $RAW_HTML_INPUT];
}
function _CheckHTMLBlacklist($CODE, $NEEDLE, $HAYSTACK) {
	if (!empty($HAYSTACK) and in_array($NEEDLE, $HAYSTACK)) {
		return [$CODE, "'$NEEDLE' is blacklisted."];
	} else {
		return null;
	}
}
function _CheckHTMLWhitelist($CODE, $NEEDLE, $HAYSTACK) {
	if (!empty($HAYSTACK) and !in_array($NEEDLE, $HAYSTACK)) {
		return [$CODE, "'$NEEDLE' isn't of the whitelisted."];
	} else {
		return null;
	}
}