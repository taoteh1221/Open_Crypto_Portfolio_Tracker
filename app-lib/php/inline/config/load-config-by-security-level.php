<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


//////////////////////////////////////////////////////////////////
// LOAD CONFIG
//////////////////////////////////////////////////////////////////


// load_cached_config() LOADS *BEFORE* PLUGIN CONFIGS IN *ENHANCED / NORMAL* ADMIN SECURITY MODES
// (UNLESS IT'S A CT_CONF USER-INITIATED RESET)
// ALSO QUEUE ANY REQUESTED UPDATE AFTER LOADING, IF AUTHORIZED
// (WE PROCESS IT AT THE BOTTOM OF THIS FILE [SAVE IT TO FILE STORAGE])
if ( $admin_area_sec_level != 'high' && !$reset_config ) {
$ct['cache']->load_cached_config();
}


// Configs for any plugins activated in ct_conf
foreach ( $ct['conf']['plugins']['plugin_status'] as $key => $val ) {
			
$this_plug = $key;

	
	if ( $val == 'on' ) {
		
	$key = trim($key);
	
	$plug_conf_file = $ct['base_dir'] . '/plugins/' . $key . '/plug-conf.php'; // Loaded NOW to have ready for any cached app config resets (for ANY runtime)


		if ( file_exists($plug_conf_file) ) {
		
		// SET SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS
		$plug_conf[$this_plug] = array();
		
		require_once($plug_conf_file); // Populate $plug_conf[$this_plug] with the defaults
     		
     	$default_ct_conf['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's HARD-CODED config into the DEFAULT app config
     		
     		
     	    // If this plugin has not been added to the ACTIVELY-USED ct_conf yet, add it now (from HARD-CODED config)
     	    if ( !isset($ct['conf']['plug_conf'][$this_plug]) ) {
     		        
     	    $ct['conf']['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's config into the GLOBAL app config
     		   
     		   // If were're not resetting, flag an update to occurr
     		   if ( !$reset_config ) {
         	        $ct['gen']->log('conf_error', 'plugin "'.$this_plug.'" ADDED, updating CACHED ct_conf');
                  $update_config = true;
                  }
     		        
     	    }
     	    // WE *MUST* RESET $plug_conf[$this_plug] TO USE *CACHED* CONFIG DATA HERE,
     	    // AS IN THIS CASE WE ALREADY HAVE IT ACTIVATED IN THE *CACHED* CONFIG!
     	    else {
     	    $plug_conf[$this_plug] = $ct['conf']['plug_conf'][$this_plug];
     	    }
     		      
     		     
          //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// AT THIS POINT $ct['conf']['plug_conf'][$this_plug] AND $plug_conf[$this_plug] ARE THE SAME
		// (ONE IS GLOBAL CT_CONF, ONE IS SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS)
          //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          
          
          // Trim stanardized plugin config values (basic error auto-correcting)
          $ct['conf']['plug_conf'][$this_plug]['runtime_mode'] = trim($ct['conf']['plug_conf'][$this_plug]['runtime_mode']);
          $plug_conf[$this_plug]['runtime_mode'] = trim($plug_conf[$this_plug]['runtime_mode']);
          
          $ct['conf']['plug_conf'][$this_plug]['ui_location'] = trim($ct['conf']['plug_conf'][$this_plug]['ui_location']);
          $plug_conf[$this_plug]['ui_location'] = trim($plug_conf[$this_plug]['ui_location']);
          
          $ct['conf']['plug_conf'][$this_plug]['ui_name'] = trim($ct['conf']['plug_conf'][$this_plug]['ui_name']);
          $plug_conf[$this_plug]['ui_name'] = trim($plug_conf[$this_plug]['ui_name']);
		         
		
		    // Check MANDATORY 'runtime_mode' plugin config setting		
		    if ( !isset($plug_conf[$this_plug]['runtime_mode']) || isset($plug_conf[$this_plug]['runtime_mode']) && !in_array($plug_conf[$this_plug]['runtime_mode'], $plugin_runtime_mode_check) ) {
     	    
     	    unset($plug_conf[$this_plug]);

     	    unset($ct['conf']['plug_conf'][$this_plug]);

     	    unset($default_ct_conf['plug_conf'][$this_plug]);

         	    $ct['gen']->log('conf_error', 'plugin "'.$this_plug.'" has an INVALID "runtime_mode" configuration setting (' . ( isset($plug_conf[$this_plug]['runtime_mode']) ? $plug_conf[$this_plug]['runtime_mode'] : 'NOT SET' ) . '), skipping activation until fixed');

		    }
		    // Cleared for takeoff
		    else {
		         
		         
		          // Set to DEFAULT 'ui_location' IF not set 
		          // (UPDATE *BOTH* GLOBAL AND PLUGIN CONFIGS FOR CLEAN / RELIABLE CODE)
		          if ( !isset($plug_conf[$this_plug]['ui_location']) || isset($plug_conf[$this_plug]['ui_location']) && $plug_conf[$this_plug]['ui_location'] == '' ) {
		          $ct['conf']['plug_conf'][$this_plug]['ui_location'] = 'tools';
		          $plug_conf[$this_plug]['ui_location'] = 'tools';
		          }
		         
		         
		          // Set to DEFAULT 'ui_name' IF not set
		          // (UPDATE *BOTH* GLOBAL AND PLUGIN CONFIGS FOR CLEAN / RELIABLE CODE)
		          if ( !isset($plug_conf[$this_plug]['ui_name']) || isset($plug_conf[$this_plug]['ui_name']) && $plug_conf[$this_plug]['ui_name'] == '' ) {
		          $ct['conf']['plug_conf'][$this_plug]['ui_name'] = $this_plug;
		          $plug_conf[$this_plug]['ui_name'] = $this_plug;
		          }
     		
     		
     			// Each plugin is allowed to run in more than one runtime, if configured for that (some plugins may run in the UI and cron runtimes, etc)
     		
     			// Add to activated cron plugins 
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'cron' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			     
     			$activated_plugins['cron'][$this_plug] = $ct['base_dir'] . '/plugins/' . $this_plug . '/plug-lib/plug-init.php'; // Loaded LATER at bottom of cron.php (if cron runtime)
     			
     			ksort($activated_plugins['cron']); // Alphabetical order (for admin UI)
     			
     			$plugin_activated = true;
     			
     			}
     			
     			// Add to activated UI plugins
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'ui' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			     
     			$activated_plugins['ui'][$this_plug] = $ct['base_dir'] . '/plugins/' . $this_plug . '/plug-lib/plug-init.php';
     			
     			ksort($activated_plugins['ui']); // Alphabetical order (for admin UI)

     			$plugin_activated = true;

     			}
     			
     			// Add to activated webhook plugins
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'webhook' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			     
     			$activated_plugins['webhook'][$this_plug] = $ct['base_dir'] . '/plugins/' . $this_plug . '/plug-lib/plug-init.php';
     
     			ksort($activated_plugins['webhook']); // Alphabetical order (for admin UI)
     
             	
                  	     // If NOT A FAST RUNTIME, and we don't have webhook keys set yet for this webhook plugin,
                  	     // OR a webhook secret key reset from authenticated admin is verified (STRICT 2FA MODE ONLY)
                         if (
                         !$is_fast_runtime && !isset($int_webhooks[$this_plug])
                         || $_POST['reset_' . $this_plug . '_webhook_key'] == 1 && $ct['gen']->pass_sec_check($_POST['admin_hashed_nonce'], 'reset_' . $this_plug . '_webhook_key') && $ct['gen']->valid_2fa('strict')
                         ) {
                    	
                         $secure_128bit_hash = $ct['gen']->rand_hash(16); // 128-bit (16-byte) hash converted to hexadecimal, used for suffix
                         $secure_256bit_hash = $ct['gen']->rand_hash(32); // 256-bit (32-byte) hash converted to hexadecimal, used for var
                         	
                         	
                         	// Halt the process if an issue is detected safely creating a random hash
                         	if ( $secure_128bit_hash == false || $secure_256bit_hash == false ) {
                         		
                         	$ct['gen']->log(
                         				'security_error',
                         				'Cryptographically secure pseudo-random bytes could not be generated for webhook key (in secured cache storage), webhook key creation aborted to preserve security'
                         				);
                         	
                         	}
                              // WE AUTOMATICALLY DELETE OUTDATED CACHE FILES SORTING BY DATE WHEN WE LOAD IT, SO NO NEED TO DELETE THE OLD ONE
                         	else {
                         	$ct['cache']->save_file($ct['base_dir'] . '/cache/secured/'.$this_plug.'_webhook_key_'.$secure_128bit_hash.'.dat', $secure_256bit_hash);
                         	$int_webhooks[$this_plug] = $secure_256bit_hash;
                         	}
                         	
                         $admin_reset_success = 'The "' . $this_plug . '" webhook key was reset successfully.'; 
                         
                         }
                         
     
     			$plugin_activated = true;
     			
     			}
     		
        	
        		     // Add this plugin's default class (only if activated / the file exists)
        		     if ( $plugin_activated == true && file_exists($ct['base_dir'] . '/plugins/'.$this_plug.'/plug-lib/plug-class.php') ) {
                    include($ct['base_dir'] . '/plugins/'.$this_plug.'/plug-lib/plug-class.php');
        		     }
        	
     	    
     	    $plugin_activated = false; // RESET

		    }
		
		
		}
		// If plugin has been removed, then remove any ct_conf entry
     	// If were're not resetting, flag an update to occurr
		elseif ( !$reset_config ) {
		unset($plug_conf[$this_plug]);
		unset($ct['conf']['plug_conf'][$this_plug]);
		unset($default_ct_conf['plug_conf'][$this_plug]);
    	     $ct['gen']->log('conf_error', 'plugin "'.$this_plug.'" REMOVED, updating CACHED ct_conf');
          $update_config = true;
		}
	
	
	unset($plug_conf_file); // Reset
	
	}


unset($this_plug);  // Reset

}


// Queue up any user updates to the config (sets $update_config flag if there are any)
// MUST RUN AFTER SCANNING PLUGIN CONFIGS
if ( $admin_area_sec_level != 'high' && !$reset_config ) {
$ct['admin']->queue_config_update();
}


// IF ADMIN-USER-INITIATED ct_conf CACHE RESET (ALSO LOADS CT_CONF [WITH ACTIVATED PLUGIN CONFIGS])
if ( $reset_config ) {
$ct['conf'] = $ct['cache']->update_cached_config(false, false, true); // Admin-user-initiated reset flag
sleep(3); // Give recache file save a few seconds breather, BEFORE load_cached_config() READS FROM IT
}
// We use the $update_config flag, to avoid multiple calls in the loop
// THIS CAN BE ANY SECURITY MODE
elseif ( $update_config ) {
$ct['conf'] = $ct['cache']->update_cached_config($ct['conf']);
$update_config = false; // Set back to false, since this is a global var
sleep(3); // Chill for a second, since we just refreshed the conf
}
// Otherwise we are clear to run any queued upgrades instead, on the CACHED ct_conf
elseif ( $admin_area_sec_level != 'high' && $app_was_upgraded ) {
$ct['conf'] = $ct['cache']->update_cached_config($ct['conf'], true);
}


// load_cached_config() LOADS *AFTER* PLUGIN CONFIGS IN *HIGH* ADMIN SECURITY MODE
// (AND IF THERE IS A USER-INITIATED CT_CONF RESET)
if ( $admin_area_sec_level == 'high' || $reset_config ) {
$ct['cache']->load_cached_config();
}


gc_collect_cycles(); // Clean memory cache


//////////////////////////////////////////////////////////////////
// END LOAD CONFIG
//////////////////////////////////////////////////////////////////

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>