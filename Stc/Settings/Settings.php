<!DOCTYPE html>
<html>

<?php \Internals\Stc\HTMLElements\Head(); \Internals\Stc\HTMLElements\Top();
$IS_LIGHT_THEME = \Internals\Stc\Style\GetTheme() === "Light";
$ACCOUNT_INFO = \Internals\Stc\Accounts\GetAccountInfo();
?>

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
			<?php
			if ($ACCOUNT_INFO["Username"] === "None") {
				echo "<a href = 'https://sasakowski.space/Stc/Login/Login.php'>Not logged in.</a>";
			} else {
				$PFP = \Internals\Stc\Accounts\GetAccountFilePath($ACCOUNT_INFO['Username'], "PFP.png");

				echo "<flex_columns>
					<img src = '{$PFP}' style = 'max-width: 128px; background-color: black; border: 0.2vw solid white; border-radius: 32%;'>
					<space_l></space_l>
					<flex_rows>
						<text>Username: <i>{$ACCOUNT_INFO['Username']}</i></text>
						<space></space>
						<text>Rank: <i>{$ACCOUNT_INFO['Rank']}</i></text>
						<space></space>
						<text>Status: <i>{$ACCOUNT_INFO['Status']}</i></text>
						<space></space>
						<text>Age: <i>{$ACCOUNT_INFO['Age']}</i></text>
					</flex_rows>	
				</flex_columns>
				<space></space>
				<a href = 'https://sasakowski.space/Stc/Login/LogMeOut.php'>Log out</a>
				";
			}
			?>
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
			<text>This website utilizes cookies to make these settings work. Read the <a href = "https://sasakowski.space/Stc/Footer/CookiePolicy.php">Cookie Policy</a>.</text>
			<space_s></space_s>
			<text>The new settings might only apply after a refresh <i>(if on a computer: press F5)</i>.</text>
		</flex_rows>
	</block2>

<!--
<body>
	Sasakowski.space utilizes cookies to make these settings work. Another page of this website might need a refresh for the new settings to take effect.
	<br>