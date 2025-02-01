<?php namespace Internals\XSS;

use BadFunctionCallException;

// Tools to validate inputs from users. NEVER trust ANY input from ANY user.
// A validating function will kill a session, should it find something that's not supposed to be, by calling exit();
// Whitelists that are only ["*"] will permit anything it encounters.

function LGT($MARKUP) { // No backslash because this isn't an internal function (but is also used like one)
	$MARKUP = str_replace("<", "&lt;", $MARKUP);
	$MARKUP = str_replace(">", "&gt;", $MARKUP);
	return $MARKUP;
}

function _Blacklist($NEEDLE, $HAYSTACK) {
	return in_array($NEEDLE, $HAYSTACK);
}
function _Whitelist($NEEDLE, $HAYSTACK) {
	return !in_array($NEEDLE, $HAYSTACK) and $HAYSTACK !== ["*"];
}
function _GetAllElements($MARKUP) {
	$MATCHES = [];
	preg_match_all("/<[^><]*>/", $MARKUP, $MATCHES);
	return !empty($MATCHES) ? $MATCHES[0] : [];
}
function _TrimBrackets($ELEMENTS) {
	$_ = [];
	foreach ($ELEMENTS as $ELEMENT) {
		
		// Trim brackets and filler =>		<     ////////      [...]       ///////       >
		$ELEMENT = substr($ELEMENT, 1); // Remove the opening <
		$ELEMENT = substr($ELEMENT, 0, -1); // Remove the closing >
		if ($ELEMENT === "") { continue; } // If literally just <>
		
		// Remove filler
		while ($ELEMENT[0] === " " or $ELEMENT[0] === "/" or ctype_space($ELEMENT[0])) {
			$ELEMENT = substr($ELEMENT, 1);
		}
		while ($ELEMENT[-1] === " " or $ELEMENT[-1] === "/" or ctype_space($ELEMENT[0])) {
			$ELEMENT = substr($ELEMENT, 0, -1);
		}
		array_push($_, $ELEMENT);
	}
	return $_;
}
function _GetTags($ELEMENTS) {
	$_ = [];
	foreach ($ELEMENTS as $ELEMENT) {
		$ARRAY = explode(" ", $ELEMENT);
		array_push($_, $ARRAY[0]);
	}
	return $_;
}
function _TrimTags($ELEMENTS) {
	// This removes the tag name from the element only leaving =>		key=value key=value key=value key key key
	$_ = [];
	foreach ($ELEMENTS as $ELEMENT) {
		$ARRAY = explode(" ", $ELEMENT);
		array_shift($ARRAY);
		$ARRAY = implode(" ", $ARRAY);
		array_push($_, $ARRAY);
	}
	return $_;
}
function _GetAttributes($ELEMENTS) {
	// Assume that the tags have already been removed

	$_ = [];
	foreach ($ELEMENTS as $ELEMENT) {
		// == = = =  					value key == = key == =  === = == value key key value    = key == =
		if ($ELEMENT === "") {
			// An element can have no attributes
			array_push($_, []);
			continue; }

		// Repair shit
		$ELEMENT = preg_replace("/=[\s]*/", "= ", $ELEMENT);
		$ELEMENT = preg_replace("/[\s]*=/", "=", $ELEMENT);
		$ELEMENT = preg_replace("/=+/", "=", $ELEMENT);
		while ($ELEMENT[0] === "=" or ctype_space($ELEMENT[0])) {
			$ELEMENT = substr($ELEMENT, 1);
		}
		while (ctype_space($ELEMENT[-1])) {
			$ELEMENT = substr($ELEMENT, 0, -1);
		}
		// Things in quotation marks will cause issues, so replace them with placeholders
		$Qs = [];
		$QsReconstruct = [];
		preg_match_all("/[\"][^\"]*[\"]|[`][^`]*[`]|['][^']*[']/", $ELEMENT, $Qs);
		$Qs = $Qs[0];
		foreach($Qs as $Q) {
			$KEY = random_int(1111111111111111, 9999999999999999);
			$ELEMENT = str_replace($Q, "|||$KEY|||", $ELEMENT);
			$QsReconstruct["|||" . $KEY . "|||"] = $Q;
		}
		$ELEMENT = preg_replace("/=[\s]*(?![^\s]*[\s]*=)/", "=", $ELEMENT);

		// Now comes the splitting
		$ELEMENT = explode(" ", $ELEMENT);
		$ELEMENT = array_filter($ELEMENT, function($value) { return $value !== ""; });
		foreach ($ELEMENT as $K => $V) {
			if (str_contains($V, "=")) {
				$X = explode("=", $V);
				$KEY = $X[0] === null ? "" : $X[0];
				$VALUE = $X[1] === null ? "" : $X[1];
				$ELEMENT[$K] = ["Key" => $KEY, "Value" => $VALUE];
			} else {
				$ELEMENT[$K] = ["Key" => $V, "Value" => ""];
			}
		}

		// QsReconstruct now
		foreach ($ELEMENT as $K => $V) {
			if (in_array($V["Value"], array_keys($QsReconstruct))) {
				$ELEMENT[$K]["Value"] = $QsReconstruct[$V["Value"]];
			}
		}
		array_push($_, $ELEMENT);
	}
	return $_;
}



function KillIfMarkup($MARKUP) {
	
	$KILL = _GetAllElements($MARKUP);
	if (empty($KILL)) { return; }
	
	if (!empty($KILL)) {
		$KILL = LGT($KILL[0]);
		echo "<!DOCTYPE html><html>Detected disallowed markup: $KILL";
		exit();
	}
}
function KillIfTags($MARKUP, $BLACKLIST = [], $WHITELIST = []) {
	
	$ELEMENTS = _GetAllElements($MARKUP);
	if (empty($ELEMENTS)) { return; }

	$ELEMENTS = _TrimBrackets($ELEMENTS);
	$TAGS = _GetTags($ELEMENTS);

	foreach ($TAGS as $TAG) {
		if (_Blacklist($TAG, $BLACKLIST)) {
			$KILL = LGT($TAG);
			echo "<!DOCTYPE html><html>Detected a disallowed tag (is blacklisted): &lt;$KILL";
			exit();
		}
		if (_Whitelist($TAG, $WHITELIST)) {
			$KILL = LGT($TAG);
			echo "<!DOCTYPE html><html>Detected a disallowed tag (isn't whitelisted): &lt;$KILL";
			exit();
		}
	}

}
function KillIfAttributes($MARKUP, $BLACKLIST = [], $WHITELIST = []) {

	$ELEMENTS = _GetAllElements($MARKUP);
	if (empty($ELEMENTS)) { return; }

	$ELEMENTS = _TrimBrackets($ELEMENTS);
	$ELEMENTS = _TrimTags($ELEMENTS);
	$ATTRIBUTES = _GetAttributes($ELEMENTS);

	foreach ($ATTRIBUTES as $ATTRIBUTE) {
		foreach ($ATTRIBUTE as $A) {
			$KEY = $A["Key"];
			if (_Blacklist($KEY, $BLACKLIST)) {
				$KILL = LGT($KEY);
				echo "<!DOCTYPE html><html>Detected a disallowed attribute key (is blacklisted): $KILL=";
				exit();
			}
			if (_Whitelist($KEY, $WHITELIST)) {
				$KILL = LGT($KEY);
				echo "<!DOCTYPE html><html>Detected a disallowed attribute key (isn't whitelisted): $KILL=";
				exit();
			}
		}
	}
}
function KillIfSpecificAttributes($MARKUP, $BLACKLIST = [], $WHITELIST = []) {

	$ELEMENTS = _GetAllElements($MARKUP);
	if (empty($ELEMENTS)) { return; }

	$ELEMENTS = _TrimBrackets($ELEMENTS);
	$TAGS = _GetTags($ELEMENTS);
	$ELEMENTS = _TrimTags($ELEMENTS);
	$ATTRIBUTES = _GetAttributes($ELEMENTS);

	$_i = 0;
	foreach ($TAGS as $TAG) {
		foreach ($ATTRIBUTES[$_i] as $ATTRIBUTE) {
			$KEY = $ATTRIBUTE["Key"];
			if (in_array($TAG, array_keys($BLACKLIST)) and _Blacklist($KEY, $BLACKLIST[$TAG])) {
				$KILL = LGT($KEY);
				echo "<!DOCTYPE html><html>Detected a disallowed attribute key (is blacklisted): $KILL=";
				exit();
			}
			if (in_array($TAG, array_keys($WHITELIST)) and _Whitelist($KEY, $WHITELIST[$TAG])) {
				$KILL = LGT($KEY);
				echo "<!DOCTYPE html><html>Detected a disallowed attribute key (isn't whitelisted): $KILL=";
				exit();
			}	
		}

		$_i += 1;
	}
}



function EnsureGet(array $_GETS) {
	foreach ($_GETS as $G) {
		if (!isset($_GET[$G])) {
			$KILL = LGT($G);
			echo "<!DOCTYPE html><html>Parameter is missing: $KILL";
			exit();
		}
	}
}
function EnsurePost(array $_POSTS) {
	foreach ($_POSTS as $P) {
		if (!isset($_POST[$P])) {
			$KILL = LGT($P);
			echo "<!DOCTYPE html><html>Malformed POST data: $KILL";
			exit();
		}
	}
}



function SQL(array $QUERY_PARTS) {
	foreach ($QUERY_PARTS as $QP) {
		$FAULTY = false;

		if (str_starts_with($QP, "'")) { $FAULTY = true; }
		if (!$FAULTY) {
			$FAULTY = preg_match("/--.*$|\/\*.*$/", $QP) === 1 ? true : false;
		}
		
		if ($FAULTY) {
			foreach (
				["SELECT", "INSERT", "UPDATE", "DELETE", "DROP", "EXECUTE", "--", "/*", "AND", "OR", "TRUE", "FALSE"]
				as $x) {

				if (str_contains($QP, $x)) {
					$KILL = LGT($QP);
					echo "<!DOCTYPE html><html>Detected suspicious SQL: $KILL";
					exit();
				}
			}
		}
	}
}

?>