<!DOCTYPE html>
<html>

<?php \Internals\HTML\Head(); \Internals\HTML\Top(); ?>

<block>
	<flex_rows>

	<block2 class = "center_h">
		<text_l>Display settings</text_l>
	</block2>

	<?php
		if ($__GLOBAL__STYLE["Theme"] === "Light") {
			echo "<space_xl></space_xl>
			<img style = 'margin: auto; height: 30vh;' src = 'https://imageproxy.ifunny.co/crop:x-20,resize:640x,quality:90x75/images/b4541c34ee1b7b4590d713ae421c8a00214bb622d80248ee6dd721e9b8c74002_1.jpg'>
			";
		}
	?>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Theme</text_l>
			<space></space>
			<text>Currently selected: <i><?php echo $__GLOBAL__STYLE["Theme"]; ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = "ThemeVoid.php">Void</a>
				<a href = "ThemeLight.php">Light</a>
				<a href = "ThemeDefault.php">Default</a>
			</flex_columns>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Text size</text_l>
			<space></space>
			<text>Current value: <i><?php echo $__GLOBAL__STYLE["TextSize"]; ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = 'TextSizeBigger.php'>+ 0.2</a>
				<a href = 'TextSizeSmaller.php'>- 0.2</a>
				<a href = "TextSizeDefault.php">Default</a>
			</flex_columns>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows>
			<text_l>Alternate theme <text>(AltTheme)</text></text_l>
			<space></space>
			<text>Currently selected: <i><?php echo $__GLOBAL__STYLE["AltTheme"]; ?></i></text>
			<space></space>
			<flex_columns style = "column-gap: 1vw;">
				<text>Selection:</text>
				<a href = "AltThemeNone.php">None</a>
				<a href = "AltThemeEllie.php">Ellie</a>
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
			<text>This website utilizes cookies to make these settings work. Read the <a href = "https://sasakowski.space/Static/CookiePolicy.php">Cookie Policy</a>.</text>
			<space_s></space_s>
			<text>The new settings might only apply after a refresh <i>(if on a computer: press F5)</i>.</text>
			<space_s></space_s>
			<text>If you're logged in, <i>deleting all cookies</i> will log you out.</text>
		</flex_rows>
	</block2>