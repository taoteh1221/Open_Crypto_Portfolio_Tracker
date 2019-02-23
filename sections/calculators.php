<?php
/*
 * Copyright 2014-2019 GPLv3, DFD Cryptocoin Values by Mike Kilday: http://DragonFrugal.com
 */


?>

			<div style='border: 2px dotted red; font-weight: bold; padding: 9px; color: red;'><a href='index.php' style='color: red;'>Click Here To Reset Default Tab / Calculators</a></div>
			
			<p style='font-weight: bold; color: red;'> Chain data (block height, difficulty, etc) on this page is cached for <?=$chainstats_cache?> minute(s). </p>
			
			<fieldset class='calculators'>
				<legend style='color: blue;'> <b>Monero Mining Calculator</b> </legend>
		    
				<?php require("app.lib/php/calculators/monero-mining-calculator.php"); ?>
				
				
			</fieldset>
			
			<fieldset class='calculators'>
				<legend style='color: blue;'> <b>Ethereum Mining Calculator</b> </legend>
		    
				<?php require("app.lib/php/calculators/ethereum-mining-calculator.php"); ?>
				
				
			</fieldset>
			
			<fieldset class='calculators'>
				<legend style='color: blue;'> <b>Decred Mining Calculator</b> </legend>
		    
				<?php require("app.lib/php/calculators/decred-mining-calculator.php"); ?>
				
				
			</fieldset>
			
			<fieldset class='calculators'>
				<legend style='color: blue;'> <b>Ravencoin Mining Calculator</b> </legend>
		    
				<?php require("app.lib/php/calculators/ravencoin-mining-calculator.php"); ?>
				
				
			</fieldset>
			
			<fieldset class='calculators'>
				<legend style='color: blue;'> <b>STEEM Power Interest Rate / Power Down Weekly Payout Calculator</b> </legend>
				
				<?php require("app.lib/php/calculators/steem-power-interest-calculator.php"); ?>
				
			</fieldset>
		    