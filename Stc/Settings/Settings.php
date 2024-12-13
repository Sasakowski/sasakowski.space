<!DOCTYPE html>
<html>

<?php \Internals\Stc\HTMLElements\Head(); \Internals\Stc\HTMLElements\Top();
$IS_LIGHT_THEME = \Internals\Stc\Style\GetTheme() === "Light"; ?>

<block>
	<flex_rows>

	<block2 class = "center_h">
		<text_l>Page & Account Settings</text_l>
	</block2>

	<?php
		if ($IS_LIGHT_THEME) {
			echo "<space_xl></space_xl>
			<img style = 'margin: auto; height: 30vh;' src = 'https://imageproxy.ifunny.co/crop:x-20,resize:640x,quality:90x75/images/b4541c34ee1b7b4590d713ae421c8a00214bb622d80248ee6dd721e9b8c74002_1.jpg'>
			";
		}
	?>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Account</text_l>
			<space></space>
			<text style = "background-color: black; color: red;">This feature isn't available yet.</text>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Theme</text_l>
			<space></space>
			<text>Currently selected: <i><?php echo \Internals\Stc\Style\GetTheme(); ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = "SetTheme.php?Theme=Void">Void</a>
				<a href = "SetTheme.php?Theme=Light">Light</a>
				<a href = "SetTheme.php?Theme=Void">Default</a>
			</flex_columns>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Text Size</text_l>
			<space></space>
			<text>Current value: <i><?php echo \Internals\Stc\Style\GetTextSize(); ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = "BiggerText.php">+ 0.2</a>
				<a href = "SmallerText.php">- 0.2</a>
				<a href = "ResetText.php">Default</a>
			</flex_columns>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Alternate Theme <i>(AltTheme)</i></text_l>
			<space></space>
			<text>Currently selected: <i><?php echo \Internals\Stc\Style\GetAltTheme(); ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = "SetAltTheme.php?AltTheme=Ellie">Ellie</a>
				<a href = "SetAltTheme.php?AltTheme=None">None</a>
			</flex_columns>
		</flex_rows>
	</block2>
	
	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Miscellaneous</text_l>
			<space></space>
			<a href = "WipeCookies.php">Delete all cookies</a>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Notes</text_l>
			<space></space>
			<text>This website utilizes cookies to make these settings work. Read the <a href = "../Footer/CookiePolicy.php">Cookie Policy</a>.</text>
			<space_s></space_s>
			<text>The new settings might only apply after a refresh <i>(if on a computer: press F5)</i>.</text>
		</flex_rows>
	</block2>

<!--
<body>
	Sasakowski.space utilizes cookies to make these settings work. Another page of this website might need a refresh for the new settings to take effect.
	<br>