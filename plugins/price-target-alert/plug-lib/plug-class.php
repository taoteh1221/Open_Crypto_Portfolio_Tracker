<?php
/*
 * Copyright 2014-2025 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com (leave this copyright / attribution intact in ALL forks / copies!)
 */
 
 
// CREATE THIS PLUGIN'S CLASS OBJECT DYNAMICALLY AS: $plug['class'][$this_plug]
$plug['class'][$this_plug] = new class() {
				
	
// Class variables / arrays

var $var1;
var $var2;
var $var3;
var $array1 = array();

	
	// Class functions
		
	////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////
		
     
     // Validating user input in the admin interface
	function admin_input_validation() {
		 
	global $ct, $plug, $this_plug;
     
     $update_config_error_seperator = '<br /> ';
     
		
     	foreach ( $_POST[$this_plug]['price_targets'] as $key => $price_target_data ) {
          
          // Auto-correct
          $_POST[$this_plug]['price_targets'][$key] = $ct['var']->auto_correct_str($price_target_data, 'lower');
          
          $price_target_data = $ct['var']->auto_correct_str($price_target_data, 'lower');
     	
     	$parse_attributes = explode('=', $price_target_data);
     	// Cleanup
     	$parse_attributes = array_map('trim', $parse_attributes);
     	
     	$target_market = $parse_attributes[0];
     
     	$target_price = $ct['var']->num_to_str($parse_attributes[1]);
     
     	$mrkt_conf = explode('-', $target_market);
     
     	$mrkt_asset = strtoupper($mrkt_conf[0]);
               
     	$mrkt_pair = $mrkt_conf[1];
               
     	$mrkt_exchange = $mrkt_conf[2];
     
     	$mrkt_id = $ct['conf']['assets'][$mrkt_asset]['pair'][$mrkt_pair][$mrkt_exchange];
               
     	$mrkt_val = $ct['var']->num_to_str( $ct['api']->market($mrkt_asset, $mrkt_exchange, $mrkt_id)['last_trade'] );
     	
     	     
     	     if ( sizeof($_POST[$this_plug]['price_targets']) == 1 && trim($price_target_data) == '' ) {
     	     // Do nothing (it's just the BLANK admin interface placeholder, TO ASSURE THE ARRAY IS NEVER EXCLUDED from the CACHED config during updating via interface)
     	     }
     	     elseif ( $ct['var']->begins_with_in_array($_POST[$this_plug]['price_targets'], $target_market)['count'] > 1 ) {
               $ct['update_config_error'] .= $update_config_error_seperator . 'Price target MARKET was USED TWICE (DUPLICATE): "'.$price_target_data.'" (no duplicate markets allowed)';
     	     }
     	     elseif ( !isset($mrkt_val) || isset($mrkt_val) && !is_numeric($mrkt_val) || isset($mrkt_val) && $mrkt_val == 0.00000000000000000000 ) {
     	     $ct['update_config_error'] .= $update_config_error_seperator . 'No market data found for ' . $mrkt_asset . ' / ' . strtoupper($mrkt_pair) . ' @ ' . $ct['gen']->key_to_name($mrkt_exchange) . ' (in submission: "'.$price_target_data.'")';
     	     }
     	     elseif ( !isset($target_price) || isset($target_price) && !is_numeric($target_price) ) {
     	     $ct['update_config_error'] .= $update_config_error_seperator . 'Please use a numeric value for target price (in submission: "'.$price_target_data.'")';
     	     }
     	     
     	
     	}
     	
     
     return $ct['update_config_error'];
     
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////

				
};
// END class
		

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>