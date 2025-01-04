<!DOCTYPE html>
<html>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<?php
$DB = \Internals\MySQL\Read("SELECT `Username`,`Rank` FROM `accounts`");

$ALL_ACCOUNTS = [
	"Superorchestrator" => [],
	"Orchestrator" => [],
	"Author" => [],
	"Reader" => []
];
foreach ($DB as $ACCOUNT) {
	$RANK = $ACCOUNT["Rank"];
	$USERNAME = $ACCOUNT["Username"];
	array_push($ALL_ACCOUNTS[$RANK], $USERNAME);
}
$ALL_ACCOUNTS = json_encode($ALL_ACCOUNTS);
echo "<script>let ALL_ACCOUNTS = $ALL_ACCOUNTS</script>";
?>

<block>
	<flex_rows>

		<block2>
			<flex_rows>
				<text_l class = "superorchestrator">Superorchestrators</text_l>
				<space></space>
				<flex_rows id = "_0"></flex_rows>
			</flex_rows>
		</block2>

		<space_xl></space_xl>

		<block2>
			<flex_rows>
				<text_l class = "orchestrator">Orchestrators</text_l>
				<space></space>
				<flex_rows id = "_1"></flex_rows>
			</flex_rows>
		</block2>

		<space_xl></space_xl>

		<block2>
			<flex_rows>
				<text_l class = "author">Authors</text_l>
				<space></space>
				<flex_rows id = "_2"></flex_rows>
			</flex_rows>
		</block2>

		<space_xl></space_xl>

		<block2>
			<flex_rows>
				<text_l class = "reader">Readers</text_l>
				<space></space>
				<flex_rows id = "_3"></flex_rows>
			</flex_rows>
		</block2>

	</flex_rows>
</block>

<script>
let KEYS = Object.keys(ALL_ACCOUNTS);

for (let i = 0; i < KEYS.length; i++) {
	const KEY = KEYS[i];
	const THESE_ACCOUNTS = ALL_ACCOUNTS[KEY];
	let DOM = document.getElementById("_" + i);
	
	for (let x = 0; x < THESE_ACCOUNTS.length; x++) {
		const THIS_ACCOUNT = THESE_ACCOUNTS[x];
		DOM.innerHTML += `<a href = 'Profile.php?Profile=${THIS_ACCOUNT}'>${THIS_ACCOUNT}</a>`;

		if (x < THESE_ACCOUNTS.length - 1) {
			DOM.innerHTML += "<space></space>";
		}
	}
}
</script>