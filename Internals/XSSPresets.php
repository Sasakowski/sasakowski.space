<?php namespace Internals\XSS\Presets;

function Profile($RAW_HTML) {
	\Internals\XSS\KillIfTags($RAW_HTML, [], [
		"flex_columns", "flex_rows",
		"block", "block2", "block3",
		"space_s", "space", "space_l", "space_xl", "space_xxl", "space_amap",
		"text_s", "text", "text_l", "text_xl", "text_xxl",
		"a", "quote", "b", "i",
		"style", "div", "img",
	]);
	\Internals\XSS\KillIfAttributes($RAW_HTML, [], ["class", "style", "target", "href", "src"]);
	\Internals\XSS\KillIfSpecificAttributes($RAW_HTML, [], [
		"flex_columns" => ["class", "style"],
		"flex_rows" => ["class", "style"],
		"block" => ["class", "style"],
		"block2" => ["class", "style"],
		"block3" => ["class", "style"],
		"text_s" => ["class", "style"],
		"text" => ["class", "style"],
		"text_l" => ["class", "style"],
		"text_xl" => ["class", "style"],
		"text_xxl" => ["class", "style"],
		"a" => ["class", "style", "target", "href"],
		"quote" => ["class", "style"],
		"b" => ["class", "style"],
		"i" => ["class", "style"],
		"style" => ["class", "src"],
		"div" => ["class", "style"],
		"img" => ["class", "style", "src"],
	]);
	\Internals\XSS\SQL([$RAW_HTML]);
}

function Forum($RAW_HTML) {
	\Internals\XSS\KillIfTags($RAW_HTML, [], ["b", "i", "text_l", "text_s"]);
	\Internals\XSS\KillIfAttributes($RAW_HTML, [], []);
	\Internals\XSS\SQL([$RAW_HTML]);
}



?>