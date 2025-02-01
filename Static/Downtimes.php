<!DOCTYPE html><html>

<?php echo \Internals\HTML\Head(); echo \Internals\HTML\Top(); ?>

<?php

$STEP = 1; // -4 -3 -2 -1 | 1 2 3 4 ; there is no zero. If it's -4, go to 1; if it's 4, go to -1.
$DELOREAN = strtotime("2025-01-25"); // this day had step 1. The following three days were uptime, making one uptime cycle.
$NOW = time() - 60*60*24;
while ($DELOREAN < $NOW) {
	$DELOREAN += 60*60*24;
	$STEP = Step($STEP);
}

$ARRAY = [];
for ($i = 0; $i < 14; $i += 1) {
	$ARRAY[date("jS \of F, Y", $DELOREAN)] = $STEP;
	$STEP = Step($STEP);
	$DELOREAN += 60*60*24;
}

function Step($STEP) {
	if ($STEP > 0 and $STEP < 4) {
		return $STEP + 1;
	} elseif ($STEP < 0 and $STEP > -4) {
		return $STEP - 1;
	} elseif ($STEP === 4) {
		return -1;
	} elseif ($STEP === -4) {
		return 1;
	}
}

?>

<block><text_l>WARNING: THIS FILE EXISTS FOR ARCHIVAL PURPOSES. NOTHING HERE APPLIES!</text_l></block>

<block><flex_rows>

	<block2 class = "center_h"><text_l>Downtimes</text_l></block2>

	<space_xl></space_xl>

	<block2><flex_rows>

	<text>Due to a problem of unknown origin, the webserver cannot connect to the internet on a periodic basis. These forced downtimes apparently last for four days, followed by four days uptime.</text>
	<text_s>Note: the webeserver isn't neccessarily running 24/7, so it may be unreachable regardless.</text_s>

	<space></space>
	<text>You can manually check this by <text_s>(if you're on Windows)</text_s> opening up <i>CMD</i> and executing <i>nslookup sasakowski.space</i>.</text>
	<space_s></space_s>
	<text>For a less programm-y approach, go to <a href = "https://dnschecker.org/">DNS Checker</a> and enter <i>sasakowski.space</i>.</text>
	<space></space>
	<text>In both approaches, if the responding IP address goes 100.92.<text_s>[...]</text_s>.<text_s>[...]</text_s> , then the connection is NOT working.
	</text>

	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows>

	<text>The forecast, assuming ideal conditions:</text>

	<space></space>

	<flex_rows>
		<?php
		$ECHO = "";
		foreach ($ARRAY as $K => $V) {
			if ($V > 0) {
				$ECHO .= "<flex_columns class = 'center_v'><text_l>✔️</text_l><space></space><text>$K</text></flex_columns>";
			} else {
				$ECHO .= "<flex_columns class = 'center_v'><text_l>❌</text_l><space></space><text>$K</text></flex_columns>";
			}
		}
		echo $ECHO;
		?>
	</flex_rows>

	</flex_rows></block2>

</flex_rows></block>