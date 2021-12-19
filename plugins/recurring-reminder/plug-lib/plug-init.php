<?php
/*
 * Copyright 2014-2022 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


// ###########################################################################################
// SEE /DOCUMENTATION-ETC/PLUGINS-README.txt FOR CREATING YOUR OWN CUSTOM PLUGINS
// ###########################################################################################


// DEBUGGING ONLY (checking logging capability)
//$ct_cache->check_log('plugins/' . $this_plug . '/plug-lib/plug-init.php:start');


// Remove any stale cache files
$loop = sizeof($plug_conf[$this_plug]['reminders']);
while ( file_exists( $ct_plug->event_cache('alert-' . $loop . '.dat') ) ) {
unlink( $ct_plug->event_cache('alert-' . $loop . '.dat') );
$loop = $loop + 1;
}
$loop = null;


foreach ( $plug_conf[$this_plug]['reminders'] as $key => $val ) {
	
	
	if ( preg_match("/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/", $plug_conf[$this_plug]['do_not_dist']['on'])
	&& preg_match("/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/", $plug_conf[$this_plug]['do_not_dist']['off']) ) {
	$do_not_dist = true;
	}


// Recurring reminder time in minutes
// 1439 minutes instead (minus 1 minute), to try keeping daily recurrences at same exact runtime (instead of moving up the runtime daily)
$in_minutes = round( $ct_var->num_to_str(1439 * $val['days']) );


// Offset -1 anything 20 minutes or higher, so recurring reminder is triggered at same EXACT cron job interval consistently 
// (example: every 2 days at 12:00pm...NOT same cron job interval + 1, like 12:20pm / 12:40pm / etc)
$in_minutes_offset = ( $in_minutes >= 20 ? ($in_minutes - 1) : $in_minutes );

	
	// If it's time to send a reminder...
	if ( $ct_cache->update_cache( $ct_plug->event_cache('alert-' . $key . '.dat') , $in_minutes_offset ) == true ) {
		
		
		// If 'do not disturb' enabled
		if ( $do_not_dist ) {
		
		// Human-readable year-month-date for today, ADJUSTED FOR USER'S TIME ZONE OFFSET FROM APP CONFIG
		$offset_date = $ct_gen->time_date_format($ct_conf['gen']['loc_time_offset'], 'standard_date');
		
		// Time of day in decimals (as hours) for dnd on/off config settings
		$dnd_on_dec = $plug_class[$this_plug]->time_dec_hours($plug_conf[$this_plug]['do_not_dist']['on'], 'to');
		$dnd_off_dec = $plug_class[$this_plug]->time_dec_hours($plug_conf[$this_plug]['do_not_dist']['off'], 'to');
		
			
			// Time of day in hours:minutes for dnd on/off (IN UTC TIME), ADJUSTED FOR USER'S TIME ZONE OFFSET FROM APP CONFIG
			if ( $ct_conf['gen']['loc_time_offset'] < 0 ) {
			$offset_dnd_on = $plug_class[$this_plug]->time_dec_hours( ( $dnd_on_dec + abs($ct_conf['gen']['loc_time_offset']) ) , 'from');
			$offset_dnd_off = $plug_class[$this_plug]->time_dec_hours( ( $dnd_off_dec + abs($ct_conf['gen']['loc_time_offset']) ) , 'from');
			}
			else {
			$offset_dnd_on = $plug_class[$this_plug]->time_dec_hours( ( $dnd_on_dec - $ct_conf['gen']['loc_time_offset'] ) , 'from');
			$offset_dnd_off = $plug_class[$this_plug]->time_dec_hours( ( $dnd_off_dec - $ct_conf['gen']['loc_time_offset'] ) , 'from');
			}
		
		
		// UTC timestamps for dnd on/off values, ADJUSTED FOR USER'S TIME ZONE OFFSET FROM APP CONFIG
		$dnd_on = strtotime($offset_date . ' ' . $offset_dnd_on); 
		$dnd_off = strtotime($offset_date . ' ' . $offset_dnd_off); 
		
		// UTC timestamp of current time right now
		$now_timestamp = time();
		
		
			if ( $now_timestamp >= $dnd_off && $now_timestamp < $dnd_on ) {
			$send_msg = true;
			}
			else {
			$send_msg = false;
			}
		
		
		}
		else {
		$send_msg = true;
		}
		
		
		// Send message, if checks pass
		if ( $send_msg ) {
		
		$format_msg = "This is a recurring ~" . round($val['days']) . " day reminder: " . $val['message'];

  		// Message parameter added for desired comm methods (leave any comm method blank to skip sending via that method)
  					
  		// Minimize function calls
  		$encoded_text_msg = $ct_gen->charset_encode($format_msg); // Unicode support included for text messages (emojis / asian characters / etc )
  					
  	 	$send_params = array(

  	        						'notifyme' => $format_msg,

  	        						'telegram' => $format_msg,
  	        						
  	        						'text' => array(
  	        										'message' => $encoded_text_msg['content_output'],
  	        										'charset' => $encoded_text_msg['charset']
  	        										),
  	        										
  	        						'email' => array(
  	        										'subject' => 'Your Recurring Reminder Message (sent every ~' . round($val['days']) . ' days)',
  	        										'message' => $format_msg
  	        										)
  	        										
  	        				 );
  	        						
   	       	
		// Send notifications
		@$ct_cache->queue_notify($send_params);
	
		// Update the event tracking for this alert
		$ct_cache->save_file( $ct_plug->event_cache('alert-' . $key . '.dat') , $ct_gen->time_date_format(false, 'pretty_date_time') );
		
		$send_msg = false; // Reset
		
		}
		

	}
	// END sending reminder


}


// DEBUGGING ONLY (checking logging capability)
//$ct_cache->check_log('plugins/' . $this_plug . '/plug-lib/plug-init.php:end');


// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>