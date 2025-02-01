<!DOCTYPE html>
<html>

<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<block>
	<flex_rows>

	<block2 class = "center_h">
		<text_l>Cookie Policy of <i>https://sasakowski.space/</i></text_l>
	</block2>
	
	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">1 - Context</text_l>
		<space></space>
		<block3><flex_rows>
			<text><quote>HTTP cookies <text_s>(also called web cookies, Internet cookies, browser cookies, or simply cookies)</text_s> are small blocks of data created by a web server while a user is browsing a website and placed on the user's computer or other device by the user's web browser. Cookies are placed on the device used to access a website, and more than one cookie may be placed on a user's device during a session.
			
			Cookies serve useful and sometimes essential functions on the web. They enable web servers to store stateful information <text_s>(such as items added in the shopping cart in an online store)</text_s> on the user's device or to track the user's browsing activity <text_s>(including clicking particular buttons, logging in, or recording which pages were visited in the past)</text_s>. They can also be used to save information that the user previously entered into form fields, such as names, addresses, passwords, and payment card numbers for subsequent use. [...]</quote>
			</text>
			<space></space>
			<flex_columns class = "hugright">
				<a href = "https://en.wikipedia.org/wiki/HTTP_cookie">Wikipedia (Dec 2024)</a>
			</flex_columns>
		</flex_rows></block3>
	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">2 - Summary</text_l>
		<space></space>
		<block3><flex_rows>
			<text>This website currently utilizes cookies only for asthetical and login purposes. It does not use cookies for data collection <text_s>(of any kind)</text_s>, targeting or advertising.</text>
			<space_s></space_s>
			<text>You're more than welcome to view the cookies yourself: if on a computer, press F12 or <i>inspect the page</i>. Also, this website's code is viewable on <a href = "https://github.com/Sasakowski/sasakowski.space">GitHub</a>.</text>
			<space></space>
			<text>If you're still suspicious, turn around, leave and do not look back.</text>
		</flex_rows></block3>
	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">3 - Asthetical cookies</text_l>
		<space></space>
		<block3><flex_rows>
			<text>These make the majority of all the possible cookies this website may use. This website would be unviewable without them.</text>
			<space_s></space_s>
			<text>These cookies can be changed within the <a href = "https://sasakowski.space/Static/DisplaySettings/Settings.php">Settings</a>, which includes a button that deletes all cookies currently present.</text>
			<space_s></space_s>
			<text>This website will automatically 'fix' broken cookies, as in: if it detects that a cookie is missing or a cookie's value isn't within a specific range of possible values defined by the webserver.</text>
		</flex_rows></block3>

		<space_l></space_l>
	
		<block3>
			<flex_rows>
				<text>3a - <i>TextSize</i></text>
				<space_s></space_s>
				<text>A numerical cookie that tells the website how large the text should be.</text>
			</flex_rows>
		</block3>

		<space></space>
		
		<block3>
			<flex_rows>
				<text>3b - <i>Theme</i></text>
				<space_s></space_s>
				<text>A text cookie that tells the website how the website should be presented overall (color design).</text>
			</flex_rows>
		</block3>

		<space></space>
		
		<block3>
			<flex_rows>
				<text>3c - <i>AltTheme (AlternateTheme)</i></text>
				<space_s></space_s>
				<text>A text cookie that complements the <i>Theme</i> cookie. Note: just for fun.</text>
			</flex_rows>
		</block3>
	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">4 - Session cookie</text_l>
		<space></space>
		<block3><flex_rows>
			<text>Named <i>SessionKey</i>, this is a lone cookie meant to handle the user's login. It either contains some random characters, or <i>None</i>.</text>
			<space></space>
			<text>Upon a successful login, the webserver generates a session key, which is sent to an internal <a href = "https://en.wikipedia.org/wiki/MySQL">MySQL database</a> and to the user in the form of the afromentioned session cookie. This cookie is set to expire 24 hours after the login. The database will clear its entry after 24 hours as well, which'll invalidate a user's session key by force <text_s>(as in: the user editing the cookie to not expire after 24 hours)</text_s>. The website will read this session key (cookie) and attempt to match it with an entry inside its database. If a match is found, the user's identity is verified.</text>
			<space></space>
			<text>Due to how session keys are handled, multiple devices can share session keys, but no user can have more than 5 session keys associated with them at a time.</text>
			<space_s></space_s>
			<text>Also, session keys should NOT be shared with strangers!</text>
		</flex_rows></block3>
	</flex_rows></block2>

</flex_rows></block>