<?php

if ($__GLOBAL__LOGIN["Login"] === 0) {
	echo "<!DOCTYPE html><html>
	You need to log in first to use this feature.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/Login.php'>Log in</a>
	";
	exit();
}

$MARKUP = isset($_POST["Markup"]) ? $_POST["Markup"] : "";
if ($MARKUP === "") {
	// Load the profile from the db
	$USERNAME = $__GLOBAL__LOGIN["Username"];
	$DB = \Internals\MySQL\Read("SELECT `Markup` FROM `profiles` WHERE `Username` = '$USERNAME'");
	if (empty($DB)) {
		$MARKUP = "NOT_FOUND";
	} else {
		$MARKUP = $DB[0]["Markup"];
	}
}
\Internals\XSS\Presets\Profile($MARKUP);

\Internals\HTML\Head(); \Internals\HTML\UseJS();
?>

<flex_rows> <!-- This <flex_rows> is usually given by Top(), but this function isn't being called here. -->

<space_l></space_l>

<script>
function SF(LINK) {
    let FORM = document.getElementById("FORM");
    FORM.action = LINK;
    FORM.submit();
}
</script>

<form method = "POST" id = "FORM">
	<flex_columns>
		<textarea maxlength = 4000 name = "Markup" id = "INPUT" cols = 128 rows = 16 placeholder = "Something!"></textarea>
		<space></space>
		<flex_rows style = "margin-bottom: auto;">
			<button style = "font-size: 125%;" type = "Submit" onclick = "SF('ProfileSubmit.php');">Submit!</button>
			<space_l></space_l>
			<button style = "font-size: 125%;" type = "Submit" onclick = "SF('');">Preview!</button>
			<space_l></space_l>
			<flex_columns class = "center_h">
				<a href = "Profile.php">Profile</a>
				<space_l></space_l>
				<a href = "https://sasakowski.space/Static/Sitemap.php">Sitemap</a>
			</flex_columns>
			<text_l>Notes</text_l>
			<space></space>
			<text>JS is disabled on profiles.</text>
			<space></space>
			<text>Line breaks are considered.</text>
		</flex_rows>
	</flex_columns>
</form>

<space_xl></space_xl>

<block><flex_rows>

		<block2 class = "center_h">
			<text_l><b><?php echo $__GLOBAL__LOGIN["Username"]; ?></b></text_l>
		</block2>

		<space_l></space_l>
		
			<?php
			if ($MARKUP === "NOT_FOUND") {
				echo "<block2 class = 'center_h'>
					<text_l>Your profile doesn't have a database entry. Please get in touch with this website's administration.</text_l>
					</block2>
					";
				exit();
			} elseif ($MARKUP === "") {
				echo "<block2><text_l>Waiting for preview, or it was empty.</text_l></block2>";
			} else {
				echo "<block2>$MARKUP";
			}
			?>

</flex_rows></block>

<?php
if ($MARKUP !== "") {
	echo "<script>
	document.getElementById('INPUT').innerHTML = `$MARKUP`;
	</script>";
}
?>