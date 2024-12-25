<!DOCTYPE html>
<html

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<?php
// Find out which forums the user has access to

$USERNAME = \Internals\Accounts\GetLoginStatus()["Username"];
$DB = \Internals\MySQL\Read("SELECT `Board` FROM `forum_viewpermissions` WHERE `Username` = '$USERNAME'");
$BOARDS = [];
foreach ($DB as $V) {
	array_push($BOARDS, $V["Board"]);
}
?>

<block>
	<block2>
		<flex_rows>
			<?php
			if (empty($BOARDS)) {
				echo "<text style = 'margin: auto;'>You're either not logged in or you haven't been given access to any board.</text>";
			} else {
				foreach ($BOARDS as $BOARD) {
					echo "<a href = 'Board.php?Board=$BOARD'>$BOARD</a>";
					if (end($BOARDS) !== $BOARD) {
						echo "<space></space>";
					}
				}
			}
			?>
		</flex_rows>
	</block2>
</block>