<!DOCTYPE html>
<html>

<head>
	<style>
		#COLORFUL_BANNER {
			background-size: 100% 213%;
			background-image: repeating-conic-gradient(from 180deg at 50% 50%, #09F 25%, #F00 75%);
			box-shadow: inset 0 0 15vh rgba(0,0,0,0.25);
		}
	</style>
</head>

<?php \Internals\Stc\HTMLElements\Head(); \Internals\Stc\HTMLElements\Top(); ?>

<block>
	<flex_rows id = "COLORFUL_BANNER" class = "center_v">
		<img src = "<?php echo \Internals\Stc\Accounts\GetAccountFilePath("Sasakowski", "", "Catmask.svg"); ?>" style = "height: 32vh;">
		<text_l>„For what you believe in, you shall live and die for!“</text_l>
		<space_l></space_l>
	</flex_rows>
</block>

<?php \Internals\Stc\HTMLElements\Footer(); ?>