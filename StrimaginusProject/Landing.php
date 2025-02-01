<?php \Internals\HTML\Head(); \Internals\HTML\Top(); ?>

<style>
#LOGO_ROTATE { animation: LOGO_ROTATE 64s linear infinite; }
.SHADOW { filter: drop-shadow(var(--space_s) var(--space_s) var(--space_s) rgba(0,0,0,0.333)); }
@keyframes LOGO_ROTATE { from { transform: rotate(0deg); } to { transform: rotate(-360deg); } }
#BANNER {
	background-image: linear-gradient(#FFF, #000);
	border-width: var(--text);
	border-style: solid;
	border-image: linear-gradient(#09F, #F00) 90;
}
</style>

<block id = "BANNER"><flex_rows class = "center_h">
	
	<space_l></space_l>
	<flex_columns>
		<img style = "width: 16vw; filter:drop-shadow();" id = "LOGO_ROTATE" src = "StrimaginusLogo.svg" class = "SHADOW">
		<space_l></space_l>
		<img style = "width: 16vw;" src = "StrimaginusStylizedSlogan.png" class = "SHADOW">
	</flex_columns>
	<space_l></space_l>
	<img style = "width: 32vw; margin-left: auto; margin-right: auto;" src = "StrimaginusStylizedName.png" class = "SHADOW">
	<space_l></space_l>

</flex_rows></block>