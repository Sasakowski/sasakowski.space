<?php namespace Internals\Cookies;

function Get(mixed $NAME, mixed $FALLBACK) {
	if (!isset($_COOKIE[$NAME])) {
		$EXPIRYDATE = time() + (60*60*24*365.25*100);
		setcookie(
			$NAME, $FALLBACK,
			$EXPIRYDATE,
			"/", "sasakowski.space",
			true, true
		);
		return $FALLBACK;
	}
	return $_COOKIE[$NAME];
}

function Edit(mixed $NAME, mixed $NEW_VALUE) {
	$EXPIRYDATE = time() + (60*60*24*365.25*100);
	setcookie(
		$NAME, $NEW_VALUE,
		$EXPIRYDATE,
		"/", "sasakowski.space",
		true, true
	);
}

function Delete(mixed $NAME) {
	$TIME = time() - 3600;
	setcookie($NAME, "", $TIME, "/", "sasakowski.space");
}

// Deletes all cookies from the site
function Wipe() {
	foreach ($_COOKIE as $K => $V) {
		Delete($K);
	}
}