<?php namespace Internals\Cookies;

function Get(mixed $NAME, mixed $FALLBACK) {
	if (!isset($_COOKIE[$NAME])) {
		$EXPIRYDATE = time() + (60*60*24*36500); // Expire as late as possible
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
	$EXPIRYDATE = time() + (60*60*24*36500); // Expire as late as possible
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

// Deletes all known cookie entries possible from the site
function Wipe() {
	Delete("Theme");
	Delete("Text");
}