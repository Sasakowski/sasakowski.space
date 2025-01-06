<!DOCTYPE html>
<html>

<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<?php
// Load active accounts (this excludes inactive and banned accounts).
// The displaying is handled by the frontend
$DB = \Internals\MySQL\Read("SELECT `Username`,`Rank` FROM `accounts` WHERE `Status` = 'Active'");
$DB = json_encode($DB);
echo "<script>let ACCOUNTS = $DB;</script>";
?>

<block><flex_rows>
	
	<block2>
		<flex_rows class = "center_h">
			<text_l>Registered accounts</text_l>
			<space></space>
			<text>(active accounts only)</text>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows id = "so">
			<text_l class = "rank_so">Superorchestrators</text_l>
			<space></space>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows id = "o">
			<text_l class = "rank_o">Orchestrators</text_l>
			<space></space>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows id = "a">
			<text_l class = "rank_a">Authors</text_l>
			<space></space>
		</flex_rows>
	</block2>

	<space_xl></space_xl>

	<block2>
		<flex_rows id = "r">
			<text_l class = "rank_r">Readers</text_l>
			<space></space>
		</flex_rows>
	</block2>

</flex_rows</block>

<script>
let SO = document.getElementById("so");
let O = document.getElementById("o");
let A = document.getElementById("a");
let R = document.getElementById("r");

for (let i = 0; i < ACCOUNTS.length; i++) {
	let RANK = ACCOUNTS[i]["Rank"];
	let USERNAME = ACCOUNTS[i]["Username"];
	let DOM;

	switch (RANK) {
		
		case "Reader":
			DOM = R;
			break;

		case "Author":
			DOM = A;
			break;

		case "Orchestrator":
			DOM = O;
			break;

		case "Superorchestrator":
			DOM = SO;
			break;
	}

	DOM.innerHTML += `<a href = 'Profile.php?Profile=${USERNAME}'>${USERNAME}</a>`;

	if (i !== ACCOUNTS.length - 1) {
		DOM.innerHTML += "<space_s></space_s>";
	}
}
</script>