<?php namespace Internals\Stc\HTMLElements;

// TOP		(header)
// MIDDLE
// BOTTOM	(footer)

function Top() {
	$CATMASK = \Internals\Stc\Accounts\GetAccountFilePath("Sasakowski","","Catmask.svg");
	echo "<flex_h>
	<block class = 'Block_IsInCorner'><flex_v class = 'Flex_CenterV'>
		<img src = '{$CATMASK}' style = 'height: var(--text_xl);' id = 'TOP_LOGO' onclick = 'window.open(`https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia.giphy.com%2Fmedia%2FLXONhtCmN32YU%2Fgiphy.gif`);' target = '_blank'></img>
		<space></space>
		<texth_l>Sasakowski.space</texth_l>
		<space_amap></space_amap>
		<text>⚙️<a href = 'https://sasakowski.space/Internals/Landing/Settings.html'>Settings</a></text>
	</flex_v>";
}

function DefaultHead() {
	$FAVICON = \Internals\Stc\Favicons\Catmask();
	$STYLE = \Internals\Stc\Style\Init();
	echo "<head>
	<title>Sasakowski.space</title>
	<meta name = 'robots' content = 'noindex, nofollow'/>
	{$FAVICON}
	{$STYLE}
	</head>";
}