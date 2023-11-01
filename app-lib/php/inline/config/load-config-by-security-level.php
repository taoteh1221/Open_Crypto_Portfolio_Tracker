<?php
/*
 * Copyright 2014-2024 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com (leave this copyright / attribution intact in ALL forks / copies!)
 */


//////////////////////////////////////////////////////////////////
// LOAD CONFIG
//////////////////////////////////////////////////////////////////


// load_cached_config() LOADS *BEFORE* PLUGIN CONFIGS IN *MEDIUM / NORMAL* ADMIN SECURITY MODES
// (UNLESS IT'S A CT_CONF USER-INITIATED RESET)
// ALSO QUEUE ANY REQUESTED UPDATE AFTER LOADING, IF AUTHORIZED
// (WE PROCESS IT AT THE BOTTOM OF THIS FILE [SAVE IT TO FILE STORAGE])
if ( $admin_area_sec_level != 'high' && !$reset_config ) {
$ct['cache']->load_cached_config();
require_once('app-lib/php/inline/config/after-load-config.php'); // MUST BE IMMEADIATELY AFTER CACHED CONFIG LOADING
}


// Dynamically revise available plugins config, by scanning the plugins directory
// (also triggers a config update if any changes / not a config reset happening)
$ct['gen']->refresh_plugins_list();


// Check for VALIDATED / SECURE config updates IN PROGRESS
$valid_secure_config_update_request = $ct['admin']->valid_secure_config_update_request();


// Configs for any plugins activated in ct_conf
foreach ( $ct['conf']['plugins']['plugin_status'] as $key => $val ) {
			
$this_plug = trim($key);


     // If we are mid-flight on activating / deactivating a plugin in the admin interface, then use that value instead
     if ( $valid_secure_config_update_request && isset($valid_secure_config_update_request['plugin_status'][$this_plug]) ) {
     $val = $valid_secure_config_update_request['plugin_status'][$this_plug];
     $plugin_status_is_updating = true;
     }
	
	
	if ( $val == 'on' ) {
	
	$plug_conf_file = $ct['base_dir'] . '/plugins/' . $this_plug . '/plug-conf.php'; // Loaded NOW to have ready for any cached app config resets (for ANY runtime)

     // SET SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS
	$plug_conf[$this_plug] = array();
		
	require_once($plug_conf_file); // Populate $plug_conf[$this_plug] with the defaults
     		
     $default_ct_conf['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's HARD-CODED config into the DEFAULT app config
     		
     		
          // If this plugin has not been added to the ACTIVELY-USED ct_conf yet, add it now (from HARD-CODED config)
     	if ( !isset($ct['conf']['plug_conf'][$this_plug]) ) {
     		        
     	$ct['conf']['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's config into the GLOBAL app config
     		   
     	    // If were're not high security mode / resetting / updating plugin status, flag a cached config update to occurr
     	    if ( $admin_area_sec_level != 'high' && !$reset_config && !$plugin_status_is_updating ) {
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
		    
	
	unset($plug_conf_file); // Reset
	
	}


unset($this_plug);  // Reset

}


// Flag active plugins as checked / registered BEFORE ANYTHING ELSE
$active_plugins_registered = true;


// If no comparison digest of the default config yet, save it now to the cache
// (MUST be done AFTER registering active plugins)
if ( $check_default_ct_conf == null ) {
$check_default_ct_conf = md5( serialize($default_ct_conf) );
$ct['cache']->save_file($ct['base_dir'] . '/cache/vars/state-tracking/default_ct_conf_md5.dat', $check_default_ct_conf);
sleep(1); // Chill for a second, since we just saved the default conf digest
}


// Queue up any user updates to the config (sets $update_config flag if there are any)
// (MUST be done AFTER registering active plugins)
if ( $admin_area_sec_level != 'high' ) {
$ct['admin']->queue_config_update();
}


// IF ct_conf CACHE RESET
// (MUST be done AFTER registering active plugins / OVERRIDE ANY $update_config)
if ( $reset_config ) {
$ct['conf'] = $ct['cache']->update_cached_config(false, false, true); // Reset flag
require_once('app-lib/php/inline/config/after-load-config.php'); // MUST BE IMMEADIATELY AFTER CACHED CONFIG LOADING
}
// Updating cached config (APP OR USER INITIATED...SO THIS CAN BE ANY SECURITY MODE)
else if ( $update_config ) {
$ct['conf'] = $ct['cache']->update_cached_config($ct['conf']);
$update_config = false; // Set back to false IMMEADIATELY, since this is a global var
require_once('app-lib/php/inline/config/after-load-config.php'); // MUST BE IMMEADIATELY AFTER CACHED CONFIG LOADING
}


// load_cached_config() IN *HIGH* ADMIN SECURITY MODE
// (MUST be done AFTER registering active plugins / AFTER any $reset_config)
// (ONLY IF NO $reset_config WAS ALREADY TRIGGERED [IN WHICH CASE WE'D ALREADY HAVE THE CACHED CONFIG LOADED])
if ( $admin_area_sec_level == 'high' && !$reset_config ) {
$ct['cache']->load_cached_config();
require_once('app-lib/php/inline/config/after-load-config.php'); // MUST BE IMMEADIATELY AFTER CACHED CONFIG LOADING
}


gc_collect_cycles(); // Clean memory cache


//////////////////////////////////////////////////////////////////
// END LOAD CONFIG
//////////////////////////////////////////////////////////////////

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>