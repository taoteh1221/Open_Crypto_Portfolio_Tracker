<?php
/*
 * DFD Cryptocoin Values by Mike Kilday: http://DragonFrugal.com
 */

require("templates/default/header.php");

?>


		<ul class='tabs'>
			<li><a href='#values'>Your Coin Values</a></li>
			<li><a href='#links'>External Resource Links</a></li>
			<li><a href='#calculators'>Mining and Interest Calculators</a></li>
			<li><a href='#amounts'>Update Coin Amounts</a></li>
			<li><a href='#settings'>Program Settings</a></li>
			<li><a style='color:red;' href='#help'>Help</a></li>
		</ul>
		<div id='values' class='tabdiv'>
			<h3 style='display: inline;'> &nbsp; Your Coin Values</h3> (real-time exchange data)
			<?php
			if ( sizeof($alert_percent) > 1 ) {
			?>
			 &nbsp; &nbsp; &nbsp; <span style='color: <?=( stristr($alert_percent[0], '-') == false ? 'green' : '#ea6b1c' )?>; font-weight: bold;'>Coinmarketcap alerts enabled (<?=$alert_percent[0]?>% / <?=$alert_percent[1]?>)</span>
			<?php
			}
			?> &nbsp; &nbsp; &nbsp; <a href='javascript:location.reload(true);' style='font-weight: bold;'>Reload Values</a> &nbsp; <select name='select_auto_refresh' id='select_auto_refresh' onchange='auto_reload(this.value);'>
				<option value=''> Manually </option>
				<option value='120' <?=( $_COOKIE['coin_reload'] == '120' ? 'selected' : '' )?>> Every 2 Minutes </option>
				<option value='300' <?=( $_COOKIE['coin_reload'] == '300' ? 'selected' : '' )?>> Every 5 Minutes </option>
				<option value='600' <?=( $_COOKIE['coin_reload'] == '600' ? 'selected' : '' )?>> Every 10 Minutes </option>
				<option value='900' <?=( $_COOKIE['coin_reload'] == '900' ? 'selected' : '' )?>> Every 15 Minutes </option>
				<option value='1800' <?=( $_COOKIE['coin_reload'] == '1800' ? 'selected' : '' )?>> Every 30 Minutes </option>
			</select> &nbsp; <span id='reload_countdown' style='color: red;'></span>
			<p><?php require("sections/coin.values.php"); ?></p>
		</div>
		<div id='links' class='tabdiv'>
			<h3>External Resource Links</h3>
			<?php require("sections/external-resource-links.php"); ?>
		</div>
		<div id='calculators' class='tabdiv'>
			<h3>Mining and Interest Calculators</h3>
			<?php require("sections/calculators.php"); ?>
		</div>
		<div id='amounts' class='tabdiv'>
			<h3>Update Coin Amounts</h3>
			<p><?php require("sections/form.php"); ?></p>
		</div>
		<div id='settings' class='tabdiv'>
			<h3>Program Settings</h3>
			<?php require("sections/settings.php"); ?>
		</div>
		<div id='help' class='tabdiv'>
			<h3 style='color: red;'>Help</h3>
			<?php require("sections/help.php"); ?>
		</div>


<?php
require("templates/default/footer.php");
?>

