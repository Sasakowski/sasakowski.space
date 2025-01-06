<?php
$PROFILE = isset($_GET["Profile"]) ? $_GET["Profile"] : "";
\Internals\XSS\DisallowMarkup($PROFILE);

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
			<text_l>The profile feature isn't yet implemented.</text_l>
		</block2>

	</flex_rows>
</block>