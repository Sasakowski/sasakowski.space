<!DOCTYPE html>
<html>

<?php
if (\Internals\Accounts\GetLoginStatus()["Login"] === 1) {
	echo "You're already logged in.<br><br>
	<a href = 'https://sasakowski.space/Static/Login/LogMeOut.php'>Log out</a>&emsp;
	<a href = 'https://sasakowski.space/'>Frontpage</a>";
	exit();
}
?>

<?php \Internals\HTMLElements\Head(); \Internals\HTMLElements\Top(); ?>

<?php
function KeyOptions() {
	return "
	<option value = 'Ant'>Ant 🐜</option>
	<option value = 'Badger'>Badger 🦡</option>
	<option value = 'Bat'>Bat 🦇</option>
	<option value = 'Bee'>Bee 🐝</option>
	<option value = 'Butterfly'>Butterfly 🦋</option>
	<option value = 'Cat'>Cat 🐈</option>
	<option value = 'Crab'>Crab 🦀</option>
	<option value = 'Crocodile'>Crocodile 🐊</option>
	<option value = 'Dog'>Dog 🐕</option>
	<option value = 'Eagle'>Eagle 🦅</option>
	<option value = 'Elephant'>Elephant 🐘</option>
	<option value = 'Fish'>Fish 🐟</option>
	<option value = 'Goat'>Goat 🐐</option>
	<option value = 'Hedgehog'>Hedgehog 🦔</option>
	<option value = 'Hippopotamus'>Hippopotamus 🦛</option>
	<option value = 'Horse'>Horse 🐎</option>
	<option value = 'Kangoroo'>Kangoroo 🦘</option>
	<option value = 'Llama'>Llama 🦙</option>
	<option value = 'Lobster'>Lobster 🦞</option>
	<option value = 'Owl'>Owl 🦉</option>
	<option value = 'Pig'>Pig 🐖</option>
	<option value = 'Pinguin'>Pinguin 🐧</option>
	<option value = 'Rhinoceros'>Rhinoceros 🦏</option>
	<option value = 'Shark'>Shark 🦈</option>
	<option value = 'Shrimp'>Shrimp 🦐</option>
	<option value = 'Snail'>Snail 🐌</option>
	<option value = 'Snake'>Snake 🐍</option>
	<option value = 'Squid'>Squid 🦑</option>
	<option value = 'Swan'>Swan 🦢</option>
	<option value = 'Turkey'>Turkey 🦃</option>
	<option value = 'Turtle'>Turtle 🐢</option>
	<option value = 'Whale'>Whale 🐳</option>
	";
}
?>

<style>
	input, select { font-size: var(--text_l); font-family: Bahnschrift; }
</style>

<block>
	<flex_rows>
		
		<block2 class = "center_h">
			<text_l>Login Page</text_l>
		</block2>

		<space_xl></space_xl>

		<form action = "https://sasakowski.space/Static/Login/LogMeIn.php" method = "POST">
			
			<flex_rows>

			<block2>
				<flex_rows>
					<input type = "text" name = "Username" placeholder = "Username" size = 32 required>

					<space></space>

					<input type = "password" name = "Password" placeholder = "Password" size = 32 required>
				</flex_rows>
			</block2>
			
			<space_l></space_l>

			<block2>
				<flex_columns class = "center_v">

					<text_l>Keys: </text_l>

					<space_l></space_l>

					<input type = "text" name = "Key1" hidden required>
					<select name = "Key1" id = "KEY_1" oninput = "OnKeyInput(1);">
						<?php echo KeyOptions(); ?>
					</select>
					
					<space></space>

					<input type = "text" name = "Key2" hidden required>
					<select name = "Key2" id = "KEY_2" oninput = "OnKeyInput(2);">
						<?php echo KeyOptions(); ?>
					</select>

					<space></space>
					
					<input type = "text" name = "Key3" hidden required>
					<select name = "Key3" id = "KEY_3" oninput = "OnKeyInput(3);">
						<?php echo KeyOptions(); ?>
					</select>
				</flex_columns>
			</block2>

			<space_l></space_l>

			<input type = "submit" value = "Log in!">
			
			</flex_rows>
		</form>
	</flex_rows>
</block>

<script>
OnKeyInput(1);
OnKeyInput(2);
OnKeyInput(3);
function OnKeyInput(ID) {
	let SELECT = document.getElementById("KEY_" + ID);
	let INPUT = document.getElementsByName("Key" + ID)[0];
	INPUT.value = SELECT.value;
}
</script>