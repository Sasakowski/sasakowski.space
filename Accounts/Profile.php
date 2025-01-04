<!DOCTYPE html>
<html>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<?php

$LOGIN_STATUS = \Internals\Accounts\GetLoginStatus();
$PROFILE = (isset($_GET["Profile"])) ? $_GET["Profile"] : null;

if ($LOGIN_STATUS["Login"] === 0 and $PROFILE === null) {
	echo "<block class = 'center_h'>
	<text_l>Either log in to view your own profile or select one to view from <a href = 'Accounts.php'>here</a>.</text_l>
	</block>";
	exit();
}

if ($PROFILE === null) {
	$DISPLAY_ACCOUNT = $LOGIN_STATUS;
} else {
	try {
		\Internals\Accounts\GetAccountDirectoryPath($PROFILE);
		$DISPLAY_ACCOUNT = \Internals\Accounts\GetAccountInfo($PROFILE);
	} catch (Exception $E) {
		echo "<block class = 'center_h'>
		<text_l>Account not found.</text_l>
		</block>";
		exit();
	}
}

?>

<block>
	<flex_rows>
		<block2>
			<flex_columns class = "center_h">
				<text_l class = "<?php echo strtolower($DISPLAY_ACCOUNT["Rank"]); ?>"><?php echo $DISPLAY_ACCOUNT["Rank"]; ?></text_l>
				<space_l></space_l>
				<text_l><?php echo $DISPLAY_ACCOUNT["Username"]; ?></text_l>
			</flex_columns>
		</block2>

	</flex_rows>
</block>