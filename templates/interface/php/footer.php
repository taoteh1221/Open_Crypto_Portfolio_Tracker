<?php


    	// Proxy alerts (if setup by user, and any of them failed, test the failed proxies and log/alert if they seem offline)
		if ( $ct_conf['comms']['proxy_alert'] != 'off' ) {
	
			foreach ( $proxy_checkup as $problem_proxy ) {
			$ct_gen->test_proxy($problem_proxy);
			sleep(1);
			}

		}
          	
          	
		// Log errors, send notifications BEFORE runtime stats
		$error_log = $ct_cache->error_log();
		$ct_cache->send_notifications();
		
		
		// Calculate script runtime length
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$total_runtime = round( ($time - $start_runtime) , 3);


		// If debug mode is 'all' / 'all_telemetry' / 'stats'
		if ( $ct_conf['dev']['debug_mode'] == 'all' || $ct_conf['dev']['debug_mode'] == 'all_telemetry' || $ct_conf['dev']['debug_mode'] == 'stats' ) {
		
			foreach ( $system_info as $key => $val ) {
			$system_telemetry .= $key . ': ' . $val . '; ';
			}
			
		// Log system stats
		$ct_gen->log(
					'system_debug',
					'Hardware / software stats (requires log_verbosity set to verbose)',
					$system_telemetry
					);
			
		// Log user agent
		$ct_gen->log('system_debug', 'USER AGENT is "' . $_SERVER['HTTP_USER_AGENT'] . '"');
			
		// Log runtime stats
		$ct_gen->log('system_debug', strtoupper($runtime_mode).' runtime was ' . $total_runtime . ' seconds');
		
		}
		
		
		// Process debugging logs AFTER runtime stats
		$debug_log = $ct_cache->debug_log();
        

?>


<!-- footer.php START -->

    
    <br class='clear_both' />
    
    <p class='align_center' style='margin: 15px;'><a href='javascript:scroll(0,0);' title='Return to the top of the page.'>Back To Top</a></p>
            	
    <div id="app_error_alert" style='display: none;'><?php echo $alerts_gui_errors . ( isset($alerts_gui_debugging) && $alerts_gui_debugging != '' ? '============<br />DEBUGGING:<br />============<br />' . $alerts_gui_debugging : '' ); ?></div>
            	
    <p class='align_center'><a href='https://taoteh1221.github.io' target='_blank' title='Check for upgrades to the latest version here.'>Running <?=ucfirst($app_edition)?> Edition<?=( $ct_gen->admin_logged_in() ? ' v' . $app_version : '' )?></a>
    

    <p class='align_center'><a title='Click to show / hide donation addresses.' href='javascript: show_more("donate");'>Donations Support Development</a></p>
    
            	<div style='display: none;' id='donate' class='align_center'>
            	
            	<span class='bitcoin' style='font-weight: bold;'>Open Crypto Tracker <i>WILL ALWAYS REMAIN 100% FREE / OPEN SOURCE SOFTWARE</i> (<a href='https://en.wikipedia.org/wiki/Free_and_open-source_software' target='_blank'>FOSS</a>),<br />so please consider donating any amount <i>large or small</i> to help support time spent on this project...</span>
            	
            	<br /><br /><b>Bitcoin:</b> <br /><span class='underline_pointer' id='btc_donate' title='Click to show / hide address copying details.'>3Nw6cvSgnLEFmQ1V4e8RSBG23G7pDjF3hW</span>
            	
            	<br /><br /><b>Ethereum:</b> <br /><span class='underline_pointer' id='eth_donate' title='Click to show / hide address copying details.'>0x644343e8D0A4cF33eee3E54fE5d5B8BFD0285EF8</span>
            	
            	<br /><br /><b>Helium:</b> <br /><span class='underline_pointer' id='hnt_donate' title='Click to show / hide address copying details.'>13xs559435FGkh39qD9kXasaAnB8JRF8KowqPeUmKHWU46VYG1h</span>
            	
            	<br /><br /><b>Solana:</b> <br /><span class='underline_pointer' id='sol_donate' title='Click to show / hide address copying details.'>GvX4AU4V9atTBof9dT9oBnLPmPiz3mhoXBdqcxyRuQnU</span>
            	
            	<br /><br /><b>Github:</b> <br /><a href='https://github.com/sponsors/taoteh1221' target='_blank'>https://github.com/sponsors/taoteh1221</a>
            	
            	<br /><br /><b>PayPal:</b> <br /><a href='https://www.paypal.me/dragonfrugal' target='_blank'>https://www.paypal.me/dragonfrugal</a>
            	
            	<br /><br /><b>Patreon:</b> <br /><a href='https://www.patreon.com/dragonfrugal' target='_blank'>https://www.patreon.com/dragonfrugal</a>
            	
	 <script>
			
			 // Info ballon only opens / closes when clicked (for a different UX on certain elements)
	
			var btc_donate_content = '<h5 class="align_center yellow tooltip_title">Bitcoin (BTC) Donation Address</h5>'
			
			+'<p id="copy_btc_address" class="coin_info align_center pointer" style="white-space: nowrap;" onclick="copy_text(\'copy_btc_address\', \'copy_btc_address_alert\')">3Nw6cvSgnLEFmQ1V4e8RSBG23G7pDjF3hW</p>'
			
			+'<p id="copy_btc_address_alert" class="coin_info align_center bitcoin">(click address above, to copy to clipboard)</p>'
			
			+'<p class="coin_info align_center"><b>QR Code For Phones:</b></p>'
			
			+'<p class="coin_info align_center"><img src="templates/interface/media/images/auto-preloaded/btc-donations.png" width="200" title="Bitcoin (BTC) Donation Address" /></p>'
			
			+'<p> </p>';
			
			
			// If the target of the click doesn't have the 'leave_open' class (clicking elsewhere on page)
			$(document).click(function(e) {
				
				if ( btc_shown ) {
			
    		 	var btc_container = $("#btc_donate");
    		 	
    		 	// Add 'leave_open' class to parent / all child elements reursively
    		 	add_css_class_recursively( $(".btc_click_to_open") , 'btc_leave_open');

    		 		if ( !btc_container.is(e.target) && btc_container.has(e.target).length === 0 && $(e.target).hasClass('btc_leave_open') == false ) {
        	 		btc_container.hideBalloon();
        	 		btc_shown = false;
    		 		}
    		 		
        	 	}
    		 	
			});
			
			
			// Open / close via target element
			 var btc_shown = false;
			 
          $("#btc_donate").on("click", function(e) {
          	
            btc_shown ? $(this).hideBalloon() : $(this).showBalloon({
            	
			html: true,
			position: "top",
  			classname: 'btc_click_to_open',
			contents: btc_donate_content,
			css: {
					fontSize: "<?=$default_font_size?>em",
					minWidth: "450px",
					padding: ".3rem .7rem",
					border: "2px solid rgba(212, 212, 212, .4)",
					borderRadius: "6px",
					boxShadow: "3px 3px 6px #555",
					color: "#eee",
					backgroundColor: "#111",
					opacity: "0.99",
					zIndex: "999",
					textAlign: "left"
					}
					
			 	});
			 	
            btc_shown = !btc_shown;
            
			
			
			// Open / close via target element
          }).hideBalloon();
	
	
			
			 // Info ballon only opens / closes when clicked (for a different UX on certain elements)
	
			var eth_donate_content = '<h5 class="align_center yellow tooltip_title">Ethereum (ETH) Donation Address</h5>'
			
			+'<p id="copy_eth_address" class="coin_info align_center pointer" style="white-space: nowrap;" onclick="copy_text(\'copy_eth_address\', \'copy_eth_address_alert\')">0x644343e8D0A4cF33eee3E54fE5d5B8BFD0285EF8</p>'
			
			+'<p id="copy_eth_address_alert" class="coin_info align_center bitcoin">(click address above, to copy to clipboard)</p>'
			
			+'<p class="coin_info align_center"><b>QR Code For Phones:</b></p>'
			
			+'<p class="coin_info align_center"><img src="templates/interface/media/images/auto-preloaded/eth-donations.png" width="200" title="Ethereum (ETH) Donation Address" /></p>'
			
			+'<p> </p>';
			
			
			// If the target of the click doesn't have the 'leave_open' class (clicking elsewhere on page)
			$(document).click(function(e) {
				
				if ( eth_shown ) {
			
    		 	var eth_container = $("#eth_donate");
    		 	
    		 	// Add 'leave_open' class to parent / all child elements reursively
    		 	add_css_class_recursively( $(".eth_click_to_open") , 'eth_leave_open');

    		 		if ( !eth_container.is(e.target) && eth_container.has(e.target).length === 0 && $(e.target).hasClass('eth_leave_open') == false ) {
        	 		eth_container.hideBalloon();
        	 		eth_shown = false;
    		 		}
    		 		
        	 	}
    		 	
			});
			
			
			// Open / close via target element
			 var eth_shown = false;
			 
          $("#eth_donate").on("click", function(e) {
          	
            eth_shown ? $(this).hideBalloon() : $(this).showBalloon({
            	
			html: true,
			position: "top",
  			classname: 'eth_click_to_open',
			contents: eth_donate_content,
			css: {
					fontSize: "<?=$default_font_size?>em",
					minWidth: "450px",
					padding: ".3rem .7rem",
					border: "2px solid rgba(212, 212, 212, .4)",
					borderRadius: "6px",
					boxShadow: "3px 3px 6px #555",
					color: "#eee",
					backgroundColor: "#111",
					opacity: "0.99",
					zIndex: "999",
					textAlign: "left"
					}
					
			 	});
			 	
            eth_shown = !eth_shown;
            
          }).hideBalloon();
	
	
			
			 // Info ballon only opens / closes when clicked (for a different UX on certain elements)
	
			var hnt_donate_content = '<h5 class="align_center yellow tooltip_title">Helium (HNT) Donation Address</h5>'
			
			+'<p id="copy_hnt_address" class="coin_info align_center pointer" style="white-space: nowrap;" onclick="copy_text(\'copy_hnt_address\', \'copy_hnt_address_alert\')">13xs559435FGkh39qD9kXasaAnB8JRF8KowqPeUmKHWU46VYG1h</p>'
			
			+'<p id="copy_hnt_address_alert" class="coin_info align_center bitcoin">(click address above, to copy to clipboard)</p>'
			
			+'<p class="coin_info align_center"><b>QR Code For Phones:</b></p>'
			
			+'<p class="coin_info align_center"><img src="templates/interface/media/images/auto-preloaded/hnt-donations.png" width="200" title="Helium (HNT) Donation Address" /></p>'
			
			+'<p> </p>';
			
			
			// If the target of the click doesn't have the 'leave_open' class (clicking elsewhere on page)
			$(document).click(function(e) {
				
				if ( hnt_shown ) {
			
    		 	var hnt_container = $("#hnt_donate");
    		 	
    		 	// Add 'leave_open' class to parent / all child elements reursively
    		 	add_css_class_recursively( $(".hnt_click_to_open") , 'hnt_leave_open');

    		 		if ( !hnt_container.is(e.target) && hnt_container.has(e.target).length === 0 && $(e.target).hasClass('hnt_leave_open') == false ) {
        	 		hnt_container.hideBalloon();
        	 		hnt_shown = false;
    		 		}
    		 		
        	 	}
    		 	
			});
			
			
			// Open / close via target element
			 var hnt_shown = false;
			 
          $("#hnt_donate").on("click", function(e) {
          	
            hnt_shown ? $(this).hideBalloon() : $(this).showBalloon({
            	
			html: true,
			position: "top",
  			classname: 'hnt_click_to_open',
			contents: hnt_donate_content,
			css: {
					fontSize: "<?=$default_font_size?>em",
					minWidth: "450px",
					padding: ".3rem .7rem",
					border: "2px solid rgba(212, 212, 212, .4)",
					borderRadius: "6px",
					boxShadow: "3px 3px 6px #555",
					color: "#eee",
					backgroundColor: "#111",
					opacity: "0.99",
					zIndex: "999",
					textAlign: "left"
					}
					
			 	});
			 	
            hnt_shown = !hnt_shown;
            
          }).hideBalloon();
	
	
			
			 // Info ballon only opens / closes when clicked (for a different UX on certain elements)
	
			var sol_donate_content = '<h5 class="align_center yellow tooltip_title">Solana (SOL) Donation Address</h5>'
			
			+'<p id="copy_sol_address" class="coin_info align_center pointer" style="white-space: nowrap;" onclick="copy_text(\'copy_sol_address\', \'copy_sol_address_alert\')">GvX4AU4V9atTBof9dT9oBnLPmPiz3mhoXBdqcxyRuQnU</p>'
			
			+'<p id="copy_sol_address_alert" class="coin_info align_center bitcoin">(click address above, to copy to clipboard)</p>'
			
			+'<p class="coin_info align_center"><b>QR Code For Phones:</b></p>'
			
			+'<p class="coin_info align_center"><img src="templates/interface/media/images/auto-preloaded/sol-donations.png" width="200" title="Solana (SOL) Donation Address" /></p>'
			
			+'<p> </p>';
			
			
			// If the target of the click doesn't have the 'leave_open' class (clicking elsewhere on page)
			$(document).click(function(e) {
				
				if ( sol_shown ) {
			
    		 	var sol_container = $("#sol_donate");
    		 	
    		 	// Add 'leave_open' class to parent / all child elements reursively
    		 	add_css_class_recursively( $(".sol_click_to_open") , 'sol_leave_open');

    		 		if ( !sol_container.is(e.target) && sol_container.has(e.target).length === 0 && $(e.target).hasClass('sol_leave_open') == false ) {
        	 		sol_container.hideBalloon();
        	 		sol_shown = false;
    		 		}
    		 		
        	 	}
    		 	
			});
			
			
			// Open / close via target element
			 var sol_shown = false;
			 
          $("#sol_donate").on("click", function(e) {
          	
            sol_shown ? $(this).hideBalloon() : $(this).showBalloon({
            	
			html: true,
			position: "top",
  			classname: 'sol_click_to_open',
			contents: sol_donate_content,
			css: {
					fontSize: "<?=$default_font_size?>em",
					minWidth: "450px",
					padding: ".3rem .7rem",
					border: "2px solid rgba(212, 212, 212, .4)",
					borderRadius: "6px",
					boxShadow: "3px 3px 6px #555",
					color: "#eee",
					backgroundColor: "#111",
					opacity: "0.99",
					zIndex: "999",
					textAlign: "left"
					}
					
			 	});
			 	
            sol_shown = !sol_shown;
            
          }).hideBalloon();
	
	
	
	
		 </script>
		 
            	
            	<br /><br />
            	
            	</div>
     
    <?php
          
        // IF WE HAVE A LOG WRITE ERROR FOR ANY LOGS, PRINT IT IN THE FOOTER HERE
		
		if ( $error_log != true ) {
		?>
		<div class="red" style='font-weight: bold;'><?=$error_log?></div>
		<?php
		}
		
		if ( $ct_conf['dev']['debug_mode'] != 'off' && $debug_log != true ) {
		?>
		<div class="red" style='font-weight: bold;'><?=$debug_log?></div>
		<?php
		}
    		
    	echo '<p class="align_center '.( $total_runtime > 25 ? 'red' : 'green' ).'"> Runtime: '.$total_runtime.' seconds</p>';
    	
    ?>
        
        
        
   		 </div>
    </div>

</div> <!-- .wrapper -->

<br clear='all' /> <br />
     
            	
<!--
Workaround for #VERY ODD# PHP v8.0.1 BUG, WHEN TRYING TO ECHO $ui_upgrade_alert['message'] IN HEADER.PHP
(so we render it in footer.php, near the end of rendering)
-->
<div id="app_upgrade_alert" style='display: none;'>
<?php
// For security, only display if a UI upgrade alert notice was triggered
if ( $display_upgrade_alert ) {
echo nl2br($ui_upgrade_alert['message']);
}
?>
</div>


<!-- https://jsfiddle.net/TheAL/ednxgwrj/ -->

<style>

.cookies_button {
    background: none;
    padding: 0;
    border: none;
}
.cookies_button:hover {
    text-decoration: underline;
    cursor: pointer;
}
.cookie-notice {
    font-size: 15px;
    line-height: 30px;
    padding: 10px 5px;
    position: fixed;
    bottom: 0;
    left: 0;
    display: none;
    width: 100%;
    text-align: center;
    color: #000;
    background: #efc551;
    z-index: 9999;
}
.cookie-notice .cookies_button {
    display: inline-block;
    line-height: 30px;
    margin-left: 10px;
    padding: 0 15px;
    color: #000;
    background: #b9ff35;
}

</style>

<div class="cookie-notice">This web app requires cookies for admin logins (browser cookie / server session). The option to ENABLE ADDITIONAL FEATURES requiring cookies is also available on the SETTINGS page.<button class='cookies_button'>I Understand</button></div>

<script>

/**
 * Creates Cookie notice
 */

var cookies_notice_status = localStorage.cookies_notice_status;
var cookies_notice = $('.cookie-notice');

if (cookies_notice_status != "agreed") {
    cookies_notice.slideDown(500);
}

$('.cookie-notice .cookies_button').click(function () {
    cookies_notice.slideUp(500);
    localStorage.cookies_notice_status = "agreed";
});

</script>


<!-- https://getbootstrap.com/docs/5.3/getting-started/download/ -->
<script src="app-lib/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>

<!-- /*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */ -->
 
 <?php
 
flush(); // Clean memory output buffer for echo
gc_collect_cycles(); // Clean memory cache

 // In case we are redirected to a login template, we include this exit...
 // IN #ANY# CASE, WE SHOULD BE COMPLETELY DONE RENDERING AT THIS POINT
 exit;
 ?>