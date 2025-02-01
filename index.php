<!DOCTYPE html><html>
</html>

<?php \Internals\HTML\Head(); \Internals\HTML\Top(); ?>

<style>
	#COLORFUL_BANNER {
		background-size: 100% 213%;
		background-image: repeating-conic-gradient(from 180deg at 50% 50%, #09F 25%, #F00 75%);
		box-shadow: inset 0 0 15vh rgba(0,0,0,0.25);
	}
</style>

<block>
	<flex_rows id = "COLORFUL_BANNER" class = "center_h">
		<img src = "<?php echo \Internals\Accounts\GetFileURL("Sasakowski", "Catmask.svg"); ?>" style = "height: 32vh;">
		<text_l><quote>For what you believe in, you shall live and die for!</quote></text_l>
		<space></space>
	</flex_rows>
</block>