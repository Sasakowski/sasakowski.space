<?php namespace Internals\Redirect;

function Redirect($URL) {
	header("Location: {$URL}");
	exit();
}

function RedirectSkwSpace($URL) {
	header("Location: https://sasakowski.space/{$URL}");
	exit();
}

function RedirectBack() {
	header("Location: {$_SERVER["HTTP_REFERER"]}");
	exit();
}