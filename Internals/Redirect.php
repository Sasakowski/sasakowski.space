<?php namespace Internals\Redirect;

function Redirect($URL) {
	header("Location: {$URL}");
	exit();
}