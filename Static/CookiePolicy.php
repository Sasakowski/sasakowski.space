<!DOCTYPE html>
<html>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<block>
	<flex_rows>

	<block2 class = "center_h">
		<text_l>Cookie Policy of <i>https://sasakowski.space/</i></text_l>
	</block2>
	
	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<texth_l>1 - Context</texth_l>
			<space></space>
			<text><quote>HTTP cookies <i>(also called web cookies, Internet cookies, browser cookies, or simply cookies)</i> are small blocks of data created by a web server while a user is browsing a website and placed on the user's computer or other device by the user's web browser. Cookies are placed on the device used to access a website, and more than one cookie may be placed on a user's device during a session.
			
			Cookies serve useful and sometimes essential functions on the web. They enable web servers to store stateful information <i>(such as items added in the shopping cart in an online store)</i> on the user's device or to track the user's browsing activity <i>(including clicking particular buttons, logging in, or recording which pages were visited in the past)</i>. They can also be used to save information that the user previously entered into form fields, such as names, addresses, passwords, and payment card numbers for subsequent use. [...]</quote></text>
			<flex_columns class = "hugright">
				<a href = "https://en.wikipedia.org/wiki/HTTP_cookie">- Wikipedia, December 2024</a>
			</flex_columns>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<texth_l>2 - Summary</texth_l>
			<space></space>
			<text>This website currently utilizes cookies only for asthetical and login purposes. It does not use cookies for data collection <i>(of any kind)</i>, targeting or advertising.
		
			You're more than welcome to view the cookies yourself: if on a computer, press F12 or 'inspect the page'. Also, this website's code is viewable on <a href = "https://github.com/Sasakowski/sasakowski.space">GitHub</a>. If you're still suspicious, turn around, leave and do not look back.
			</text>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<texth_l>3 - Asthetical cookies</texth_l>
			<space></space>
			<text>These make the great majority of all the possible cookies this website may use. This website would be unviewable without them.

			These cookies can be changed within the <a href = "https://sasakowski.space/Static/Settings/Settings.php">Settings</a>, which includes a button that deletes all cookies currently present.
			This website will automatically 'fix' broken cookies, as in: if it detects that a cookie is missing or a cookie's value isn't within a specific range of possible values defined by the webserver.
			</text>
		
			<space_l></space_l>
		
			<block3>
				<flex_rows>
					<texth>3a - <i>TextSize</i></texth>
					<space_s></space_s>
					<text>A numerical cookie that tells the website how large the text should be.</text>
				</flex_rows>
			</block3>

			<space></space>
			
			<block3>
				<flex_rows>
					<texth>3b - <i>Theme</i></texth>
					<space_s></space_s>
					<text>A text cookie that tells the website how the website should be presented overall (color design).</text>
				</flex_rows>
			</block3>

			<space></space>
			
			<block3>
				<flex_rows>
					<texth>3c - <i>AltTheme (Alternate Theme)</i></texth>
					<space_s></space_s>
					<text>A text cookie that complements the <i>Theme</i> cookie. Note: just for fun.</text>
				</flex_rows>
			</block3>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<texth_l>4 - Session cookie</texth_l>
			<space></space>
			<text>This is a lone cookie meant to handle the user's login. It either contains some random characters, or 'None'. It's named <i>Session</i>.

			Upon login, the webserver generates a session key, which is sent to an internal <a href = "https://en.wikipedia.org/wiki/MySQL">MySQL database</a> and the user in the form of the session cookie.
			This cookie is set to expire 24 hours after the login. The database will clear its entry after 24 hours as well, which'll invalidate a user's session key by force.
			The website will read this session key (cookie) and attempt to match it with an entry inside its database. If a match is found, the user's identity is verified.
			</text>

		</flex_rows>
	</block2>

</flex_rows></block>