<!DOCTYPE html>
<html

<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<?php
// Find out which (wether if any) forums the user has access to

$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Username` = '{$__GLOBAL__LOGIN["Username"]}'");
$BOARDS = [];
foreach ($DB as $V) {
	array_push($BOARDS, $V["Board"]);
}

if (empty($BOARDS)) {
	echo "<block class = 'center_h'><text_l>You're either not logged in or you haven't been given access to any board.</text_l></block>";
	exit();
}
$BOARDS = json_encode($BOARDS);
echo "<script>let BOARDS = $BOARDS;</script>";

?>

<block>
	<block2>
		<flex_rows id = "BOARDS">
			<text_l>Select a board you'd like to view.</text_l>
			<space></space>

		</flex_rows>
	</block2>
</block>

<script>
let _BOARDS = document.getElementById("BOARDS");
for (let i = 0; i < BOARDS.length; i++) {
	let x = BOARDS[i];
	_BOARDS.innerHTML += `<a href = 'Board.php?Board=${x}'>${x}</a>`;
	
	if (i < BOARDS.length - 1) {
		_BOARDS.innerHTML += "<space_s></space_s>";
	}
}
</script>