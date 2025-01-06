<?php namespace Internals\XSS;

// https://stackoverflow.com/questions/1732348/regex-match-open-tags-except-xhtml-self-contained-tags
// NOTE: Only really relevant where the frontend takes some new input. All backend variables are checked through different methods already.
// NOTE: NEVER trust ANY user input.
// These functions will do nothing if nothing's found. They'll kill the connection instantly if something IS found.
// These functions contain a DISALLOW bool, which is an additional safety switch in case the programmer makes a critical oversight.

// Replaces the < and > with &lt; and &gt; respectively. This way, XSS can be safely displayed without it triggering anything.
function LTGT($RAW_HTML) {
	// less than <
	// greater than >
	$RAW_HTML = str_replace("<", "&lt;", $RAW_HTML);
	$RAW_HTML = str_replace(">", "&gt;", $RAW_HTML);
	return $RAW_HTML;
}



function _Blacklist($NEEDLE, $HAYSTACK) {
	return in_array($NEEDLE, $HAYSTACK);
}
function _Whitelist($NEEDLE, $HAYSTACK) {
	return !in_array($NEEDLE, $HAYSTACK);
}

function _FindAllElements($RAW_HTML) {
	$MATCHES = [];
	preg_match_all("/<[^\/][^<]*>/", $RAW_HTML, $MATCHES);
	return !empty($MATCHES) ? $MATCHES[0] : [];
}
function _FindTagname($RAW_HTML) {
	$MATCH = [];
	preg_match("/<[\s]*[^\s>]*/", $RAW_HTML, $MATCH);
	return !empty($MATCH) ? $MATCH[0] : [];
}
function _FindAttributes($RAW_HTML) {
	$MATCHES = [];
	preg_match_all("/[^\s]*[\s]*=[\s]*\"[^\"]*\"|[^\s]+/", $RAW_HTML, $MATCHES);
	return !empty($MATCHES) ? $MATCHES[0] : [];
}
function _FindAttributeKey($RAW_HTML) {
	$MATCH = [];
	preg_match("/[^\s]*[\s]*=/", $RAW_HTML, $MATCH);
	return !empty($MATCH) ? $MATCH[0] : [];
}



// Will hammer down if it detects ANY markup.
function DisallowMarkup($RAW_HTML) {

	// Only one needs to appear to trigger the failure.
	$ELEMENT = _FindAllElements($RAW_HTML);

	if (!empty($ELEMENT)) {
		$LTGT = LTGT($ELEMENT[0]);
		echo "<!DOCTYPE html><html>
		Found markup, which is completely disallowed here: $LTGT<br>
		";
		exit();
	}
}

// Will filter markup: check all tags ( <TAGNAME ... )
function FilterTags($RAW_HTML, $BLACKLIST = [], $WHITELIST = [], $DISALLOW = true) {

	// First find all markup
	$ELEMENTS = _FindAllElements($RAW_HTML);
	if (empty($ELEMENTS)) { return; }
	
	if ($DISALLOW) {
		$LTGT = LTGT($ELEMENTS[0]);
		echo "<!DOCTYPE html><html>
		Found markup, which is completely disallowed here: $LTGT<br>
		";
		exit();
	}

	foreach ($ELEMENTS as $ELEMENT) {
		$TAGNAME = _FindTagname($ELEMENT);
		$TAGNAME = substr($TAGNAME, 1); // Remove the <
		$TAGNAME = trim($TAGNAME);

		if (_Blacklist($TAGNAME, $BLACKLIST)) {
			$LTGT = LTGT("<" . $TAGNAME);
			echo "<!DOCTYPE html><html>
			Detected markup. This tag is blacklisted: $LTGT
			";
			exit();
		}
		if (_Whitelist($TAGNAME, $WHITELIST)) {
			$LTGT = LTGT("<" . $TAGNAME);
			echo "<!DOCTYPE html><html>
			Detected markup. This tag isn't whitelisted: $LTGT
			";
			exit();
		}
	}
}

function FilterAttributes($RAW_HTML, $BLACKLIST = [], $WHITELIST = [], $SPECIFIC_BLACKLIST = [], $SPECIFIC_WHITELIST = [], $DISALLOW = true) {

	// First find all markup
	$ELEMENTS = _FindAllElements($RAW_HTML);
	if (empty($ELEMENTS)) { return; }

	if ($DISALLOW) {
		$LTGT = LTGT($ELEMENTS[0]);
		echo "<!DOCTYPE html><html>
		Found markup, which is completely disallowed here: $LTGT<br>
		";
		exit();
	}

	// Getting the attributes is a little trickier than finding tagnames.
	foreach ($ELEMENTS as $ELEMENT) {
		
		// Get and store the tagname (this is for the specifics section).
		$TAGNAME = _FindTagname($ELEMENT);
		$TAGNAME = substr($TAGNAME, 1); // Remove the <
		$TAGNAME = trim($TAGNAME);
		// Remove the <TAGNAME and > at the end.
		$ELEMENT = str_replace(_FindTagname($ELEMENT), "", $ELEMENT);
		$ELEMENT = substr($ELEMENT, 0, -1);
		$ELEMENT = trim($ELEMENT);

		// Now get all the attributes.
		$ATTRIBUTES = _FindAttributes($ELEMENT);
		if (empty($ATTRIBUTES)) { continue; }

		foreach ($ATTRIBUTES as $ATTRIBUTE) {

			$ATTRIBUTE = trim($ATTRIBUTE);

			// Now there's attributes with and without an equals:	src=""	required
			$KEY = _FindAttributeKey($ATTRIBUTE);
			if (!empty($KEY)) {

				$KEY = str_replace("=", "", $KEY);
				$KEY = trim($KEY);
				$TARGET = $KEY;

			} else {

				// This attribute has no equals, so go with the entire string instead.
				$TARGET = $ATTRIBUTE;
			}

			echo LTGT($TAGNAME) . ", " . LTGT($TARGET) . "<br>";

			// Finally do the list check, per-tag checks are first.
			if (in_array($TAGNAME, array_keys($SPECIFIC_BLACKLIST))) {

				if (_Blacklist($TARGET, $SPECIFIC_BLACKLIST[$TAGNAME])) {

					$LTGT = LTGT("<" . $TAGNAME);
					$LTGT2 = LTGT($TARGET);
					echo "<!DOCTYPE html><html>
					Detected markup. This attribute of $LTGT is blacklisted: $LTGT2
					";
					exit();
				}
			} else {

				if (_Blacklist($TARGET, $BLACKLIST)) {
					
					$LTGT = LTGT($TARGET);
					echo "<!DOCTYPE html><html>
					Detected markup. This attribute is blacklisted: $TARGET
					";
					exit();
				}
			}

			if (in_array($TAGNAME, array_keys($SPECIFIC_WHITELIST))) {

				if (_Whitelist($TARGET, $SPECIFIC_WHITELIST[$TAGNAME])) {

					$LTGT = LTGT("<" . $TAGNAME);
					$LTGT2 = LTGT($TARGET);
					echo "<!DOCTYPE html><html>
					Detected markup. This attribute of $LTGT isn't whitelisted: $LTGT2
					";
					exit();
				}
			} else {

				if (_Whitelist($TARGET, $WHITELIST)) {

					$LTGT = LTGT($TARGET);
					echo "<!DOCTYPE html><html>
					Detected markup. This attribute isn't whitelisted: $TARGET
					";
					exit();
				}
			}
		}
	}
}


?>