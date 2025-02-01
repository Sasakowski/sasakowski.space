<?php
// Do not EnsureGet() because it's always required.
$PROFILE = isset($_GET["Profile"]) ? $_GET["Profile"] : "";
\Internals\XSS\KillIfMarkup($PROFILE);
\Internals\XSS\SQL([$PROFILE]);

if ($PROFILE === "" and $__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE html><html>
	You're not logged in and there's no profile to load.<br><br>
	<a href = 'RegisteredAccounts.php'>Registered accounts</a>
	";
	exit();
}

// If no PROFILE is given, load the user's own profile.
try {

	// "" means view-my-own-profile.
	if ($PROFILE !== "") {
		$PROFILE = \Internals\Accounts\GetInfo($PROFILE);
	} else {
		$PROFILE = $__GLOBAL__LOGIN;
	}
	
} catch (Exception $E) {

	echo "<!DOCTYPE><html>
	Account not found.<br><br>
	<a href = 'RegisteredAccounts.php'>Registered accounts</a>
	";
	exit();
}

// Now load it!
$DB = \Internals\MySQL\Read("SELECT `Markup` FROM `profiles` WHERE `Username` = '{$PROFILE["Username"]}'");
if (empty($DB)) {
	$MARKUP = "NOT_FOUND";
} else {
	$MARKUP = $DB[0]["Markup"];
}
\Internals\XSS\Presets\Profile($MARKUP);

?>

<!DOCTYPE html>
<html>

<?php \Internals\HTML\Head(); \Internals\HTML\Top(); ?>

<block>
	<flex_rows>
		<block2>
			<flex_columns class = "center_h center_v">
				<?php
				$RANK_CSS = \Internals\HTML\RankToCSS($PROFILE["Rank"]);
				$PFP = \Internals\Accounts\GetFileURL($PROFILE["Username"], "PFP.png");

				if ($PROFILE["Username"] === $__GLOBAL__LOGIN["Username"]) {
					
					// The user is viewing their own profile.
					echo "<text_l>Welcome,</text_l>
					<space></space>
					<text_l class = '$RANK_CSS'><b>{$PROFILE["Rank"]}</b></text_l>
					<space></space>
					<text_l><i>{$PROFILE["Username"]}!</i></text_l>
					<space_l></space_l>
					<img src = '$PFP' style = 'height: var(--text_xl); border-radius: var(--text_s);'>
					<space_l></space_l>
					<a href = 'ProfileEdit.php' style = 'text-decoration: none;'>✏️</a>
					";
					
				} else {

					// The user is viewing someone else's profile.
					echo "<text_l class = '$RANK_CSS'><b>{$PROFILE["Rank"]}</b></text_l>
					<space></space>
					<text_l>{$PROFILE["Username"]}</text_l>
					<space_l></space_l>
					<img src = '$PFP' style = 'height: var(--text_xl); border-radius: var(--text_s);'>
					";
				}
				?>
			</flex_columns>
		</block2>

		<space_xl></space_xl>

		<block2 class = "center_h">
			<?php
			if ($MARKUP === "NOT_FOUND") {
				echo "<text_l>This profile has no database entry.</text_l>";
			} elseif ($MARKUP === "") {
				echo "<text_l>This profile is empty.</text_l>";
			} else {
				echo "$MARKUP";
			}
			?>
		</block2>

	</flex_rows>
</block>