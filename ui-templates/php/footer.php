
<p align='center' style='margin: 15px;'><a href='javascript:scroll(0,0);'>Back To Top</a></p>


    <!-- footer START -->
<?php

	foreach ( $_SESSION['cache_error'] as $error ) {
	$other_error_logs .= $error;
	}
	
	$other_error_logs .= $_SESSION['security_error'];
	
	$other_error_logs .= $_SESSION['cmc_config_error'];
	
	$other_error_logs .= $_SESSION['other_error'];
	

?>
            	
    <div id="api_error_alert"><?php echo $_SESSION['config_error'] . $_SESSION['api_data_error'] . $other_error_logs . $_SESSION['cmc_error']; ?></div>
            	
    <p align='center'><a href='https://dfd-cryptocoin-values.sourceforge.io/' target='_blank' title='Download the latest version here.'>Latest Releases (running v<?=$app_version?>)</a>
    

    <p align='center'><a class='show' id='donate' href='#show_donation_addresses' title='Click to show donation addresses.' onclick='return false;'>Donations Support Development</a></p>
    
            	<div style='display: none;' class='show_donate' align='center'>
            	
            	<b>PayPal:</b> <br /><a href='https://www.paypal.me/dragonfrugal' target='_blank'>https://www.paypal.me/dragonfrugal</a>
            	<br /><br /><b>Patreon:</b> <br /><a href='https://www.patreon.com/dragonfrugal' target='_blank'>https://www.patreon.com/dragonfrugal</a>
            	<br /><br /><b>Monero (XMR):</b> <br /><span class='long_linebreak'>47mWWjuwPFiPD6t2MaWcMEfejtQpMuz9oj5hJq18f7nvagcmoJwxudKHUppaWnTMPaMWshMWUTPAUX623KyEtukbSMdmpqu</span>
            	<br /><b>Monero Address QR Code (for phones)</b><br /><img src='ui-templates/media/images/xmr-donations-qr-code.png' border='0' />
            
            	</div>
     
    <?php
    
		if ( $proxy_alerts != 'none' ) {
	
			foreach ( $_SESSION['proxy_checkup'] as $problem_proxy ) {
			test_proxy($problem_proxy);
			sleep(1);
			}

		}

		// Log errors, send notifications, destroy session data
		error_logs();
		send_notifications();

    	// Calculate script runtime BEFORE clearing session data
    	$script_runtime = script_runtime('finish');
    	echo '<p align="center" class="'.( $script_runtime <= 10 ? 'green' : 'red' ).'"> Page generated in '.$script_runtime.' seconds. </p>';
    
		hardy_session_clearing();
	
    ?>
        
   		 </div>
    </div>
     <br /> <br />
     
 


<!-- https://v4-alpha.getbootstrap.com/getting-started/introduction/#starter-template -->
<script src="app-lib/js/jquery/bootstrap.min.js"></script>

</body>
</html>

<!-- /*
 * Copyright 2014-2020 GPLv3, DFD Cryptocoin Values by Mike Kilday: http://DragonFrugal.com
 */ -->
 
 