<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


//////////////////////////////////////////////////////////////////
// LOAD CONFIG
//////////////////////////////////////////////////////////////////


// Default config, used for upgrade checks
// (#MUST# BE SET BEFORE load-config-by-security-level.php)
// WE MODIFY / RUN THIS AND UPGRADE LOGIC, WITHIN load-config-by-security-level.php
$default_ct_conf = $ct_conf; 


// Used for quickening runtimes on app config upgrading checks
// (#MUST# BE SET BEFORE load-config-by-security-level.php)
if ( file_exists($base_dir . '/cache/vars/default_ct_conf_md5.dat') ) {
$check_default_ct_conf = trim( file_get_contents($base_dir . '/cache/vars/default_ct_conf_md5.dat') );
}
else {
$check_default_ct_conf = null;
}


// load_cached_config() LOADS *BEFORE* PLUGIN CONFIGS IN *ENHANCED / NORMAL* ADMIN SECURITY MODES
// (UNLESS IT'S A CT_CONF USER-INITIATED RESET)
if ( $admin_area_sec_level != 'high' && !$reset_ct_conf ) {
$ct_cache->load_cached_config();
}


// Configs for any plugins activated in ct_conf
foreach ( $ct_conf['power']['activate_plugins'] as $key => $val ) {
			
$this_plug = $key;

	
	if ( $val == 'on' ) {
		
	$key = trim($key);
	
	$plug_conf_file = $base_dir . '/plugins/' . $key . '/plug-conf.php'; // Loaded NOW to have ready for any cached app config resets (for ANY runtime)


		if ( file_exists($plug_conf_file) ) {
		
		// SET SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS
		$plug_conf[$this_plug] = array();
		
		require_once($plug_conf_file); // Populate $plug_conf[$this_plug] with the defaults
     		
     	$default_ct_conf['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's HARD-CODED config into the DEFAULT app config
     		
     		
     	    // If this plugin has not been added to the ACTIVELY-USED ct_conf yet, add it now (from HARD-CODED config)
     	    if ( !isset($ct_conf['plug_conf'][$this_plug]) ) {
     		        
     	    $ct_conf['plug_conf'][$this_plug] = $plug_conf[$this_plug]; // Add each plugin's config into the GLOBAL app config
     		    
     		   if ( $admin_area_sec_level != 'high' && !$reset_ct_conf ) {
         		   $ct_gen->log('conf_error', 'plugin "'.$this_plug.'" ADDED, refreshing CACHED ct_conf');
                  $refresh_config = true;
     		   }
     		        
     	    }
     	    // WE *MUST* RESET $plug_conf[$this_plug] TO USE *CACHED* CONFIG DATA HERE,
     	    // AS IN THIS CASE WE ALREADY HAVE IT ACTIVATED IN THE *CACHED* CONFIG!
		    // *RESET* SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS
     	    else {
     	    $plug_conf[$this_plug] = $ct_conf['plug_conf'][$this_plug];
     	    }
     		      
     		     
          //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// AT THIS POINT $ct_conf['plug_conf'][$this_plug] AND $plug_conf[$this_plug] ARE THE SAME
		// (ONE IS GLOBAL CT_CONF, ONE IS SIMPLIFIED / MINIMIZED PLUG_CONF ONLY FOR USE *INSIDE* PLUGIN LOGIC / PLUGIN INIT LOOPS)
          //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          
          
          // Trim stanardized plugin config values (basic error auto-correcting)
          $ct_conf['plug_conf'][$this_plug]['runtime_mode'] = trim($ct_conf['plug_conf'][$this_plug]['runtime_mode']);
          $plug_conf[$this_plug]['runtime_mode'] = trim($plug_conf[$this_plug]['runtime_mode']);
          
          $ct_conf['plug_conf'][$this_plug]['ui_location'] = trim($ct_conf['plug_conf'][$this_plug]['ui_location']);
          $plug_conf[$this_plug]['ui_location'] = trim($plug_conf[$this_plug]['ui_location']);
          
          $ct_conf['plug_conf'][$this_plug]['ui_name'] = trim($ct_conf['plug_conf'][$this_plug]['ui_name']);
          $plug_conf[$this_plug]['ui_name'] = trim($plug_conf[$this_plug]['ui_name']);
		         
		
		    // Check MANDATORY 'runtime_mode' plugin config setting		
		    if ( !isset($plug_conf[$this_plug]['runtime_mode']) || isset($plug_conf[$this_plug]['runtime_mode']) && !in_array($plug_conf[$this_plug]['runtime_mode'], $plugin_runtime_mode_check) ) {
     	    unset($plug_conf[$this_plug]);
     	    unset($ct_conf['plug_conf'][$this_plug]);
     	    unset($default_ct_conf['plug_conf'][$this_plug]);
         	    $ct_gen->log('conf_error', 'plugin "'.$this_plug.'" has an INVALID "runtime_mode" configuration setting (' . ( isset($plug_conf[$this_plug]['runtime_mode']) ? $plug_conf[$this_plug]['runtime_mode'] : 'NOT SET' ) . '), skipping activation until fixed');
		    }
		    // Cleared for takeoff
		    else {
		         
		         
		          // Set to DEFAULT 'ui_location' IF not set 
		          // (UPDATE *BOTH* GLOBAL AND PLUGIN CONFIGS FOR CLEAN / RELIABLE CODE)
		          if ( !isset($plug_conf[$this_plug]['ui_location']) || isset($plug_conf[$this_plug]['ui_location']) && $plug_conf[$this_plug]['ui_location'] == '' ) {
		          $ct_conf['plug_conf'][$this_plug]['ui_location'] = 'tools';
		          $plug_conf[$this_plug]['ui_location'] = 'tools';
		          }
		         
		         
		          // Set to DEFAULT 'ui_name' IF not set
		          // (UPDATE *BOTH* GLOBAL AND PLUGIN CONFIGS FOR CLEAN / RELIABLE CODE)
		          if ( !isset($plug_conf[$this_plug]['ui_name']) || isset($plug_conf[$this_plug]['ui_name']) && $plug_conf[$this_plug]['ui_name'] == '' ) {
		          $ct_conf['plug_conf'][$this_plug]['ui_name'] = $this_plug;
		          $plug_conf[$this_plug]['ui_name'] = $this_plug;
		          }
     		
     		
     			// Each plugin is allowed to run in more than one runtime, if configured for that (some plugins may run in the UI and cron runtimes, etc)
     		
     			// Add to activated cron plugins 
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'cron' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			$activated_plugins['cron'][$this_plug] = $base_dir . '/plugins/' . $this_plug . '/plug-lib/plug-init.php'; // Loaded LATER at bottom of cron.php (if cron runtime)
     			ksort($activated_plugins['cron']); // Alphabetical order (for admin UI)
     			$plugin_activated = true;
     			}
     			
     			// Add to activated UI plugins
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'ui' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			$activated_plugins['ui'][$this_plug] = $base_dir . '/plugins/' . $this_plug . '/plug-lib/plug-init.php';
     			ksort($activated_plugins['ui']); // Alphabetical order (for admin UI)
     			$plugin_activated = true;
     			}
     			
     			// Add to activated webhook plugins
     			if ( $plug_conf[$this_plug]['runtime_mode'] == 'webhook' || $plug_conf[$this_plug]['runtime_mode'] == 'all' ) {
     			     
     			$activated_plugins['webhook'][$this_plug] = $base_dir . '/plugins/' . $this_plug . '/plug-lib/plug-init.php';
     
     			ksort($activated_plugins['webhook']); // Alphabetical order (for admin UI)
     
             	
                  	     // If NOT A FAST RUNTIME, and we don't have webhook keys set yet for this webhook plugin
                         if ( !$is_fast_runtime && !isset($int_webhooks[$this_plug]) ) {
                    	
                         $secure_128bit_hash = $ct_gen->rand_hash(16); // 128-bit (16-byte) hash converted to hexadecimal, used for suffix
                         $secure_256bit_hash = $ct_gen->rand_hash(32); // 256-bit (32-byte) hash converted to hexadecimal, used for var
                         	
                         	
                         	// Halt the process if an issue is detected safely creating a random hash
                         	if ( $secure_128bit_hash == false || $secure_256bit_hash == false ) {
                         		
                         	$ct_gen->log(
                         				'security_error',
                         				'Cryptographically secure pseudo-random bytes could not be generated for webhook key (in secured cache storage), webhook key creation aborted to preserve security'
                         				);
                         	
                         	}
                         	else {
                         	$ct_cache->save_file($base_dir . '/cache/secured/'.$this_plug.'_webhook_key_'.$secure_128bit_hash.'.dat', $secure_256bit_hash);
                         	$int_webhooks[$this_plug] = $secure_256bit_hash;
                         	}
                         	
                            	
                         }
                         
     
     			$plugin_activated = true;
     			
     			}
     		
        	
        		     // Add this plugin's default class (only if activated / the file exists)
        		     if ( $plugin_activated == true && file_exists($base_dir . '/plugins/'.$this_plug.'/plug-lib/plug-class.php') ) {
                    include($base_dir . '/plugins/'.$this_plug.'/plug-lib/plug-class.php');
        		     }
        	
     	    
     	    $plugin_activated = false; // RESET

		    }
		
		
		}
		// If plugin has been removed AND we are running the NORMAL SECURITY admin pages, then remove any ct_conf entry
		// (THIS AUTOMATICALLY #CANNOT# HAPPEN IF WE ARE #NOT# IN NORMAL SECURITY ADMIN MODE)
          // (if NO USER-INITIATED CT_CONF RESET)
		elseif ( $admin_area_sec_level != 'high' && !$reset_ct_conf ) {
		unset($ct_conf['plug_conf'][$this_plug]);
		unset($plug_conf[$this_plug]);
    	     $ct_gen->log('conf_error', 'plugin "'.$this_plug.'" REMOVED, refreshing CACHED ct_conf');
          $refresh_config = true;
		}
	
	
	unset($plug_conf_file); // Reset
	
	}


unset($this_plug);  // Reset

}


// IF ADMIN-USER-INITIATED ct_conf CACHE RESET (ALSO LOADS CT_CONF [WITH ACTIVATED PLUGIN CONFIGS])
if ( $reset_ct_conf ) {
$ct_conf = $ct_cache->refresh_cached_ct_conf(false, false, true); // Admin-user-initiated reset flag
sleep(2); // Give recache file save a couple seconds breather, BEFORE load_cached_config() READS FROM IT
}
// We use the $refresh_config flag, to avoid multiple calls in the loop
elseif ( $refresh_config == true ) {
$ct_conf = $ct_cache->refresh_cached_ct_conf($ct_conf);
unset($refresh_config); // Unset, since this is an inline global var
}
// Otherwise we are clear to check for and run any upgrades instead, on the CACHED ct_conf
elseif ( $admin_area_sec_level != 'high' ) {
//$ct_conf = $ct_cache->refresh_cached_ct_conf($ct_conf, true); // THROWS ERROR...SEE TODO.txt
}


// load_cached_config() LOADS *AFTER* PLUGIN CONFIGS IN *HIGH* ADMIN SECURITY MODE
// (AND IF THERE IS A USER-INITIATED CT_CONF RESET)
if ( $admin_area_sec_level == 'high' || $reset_ct_conf ) {
$ct_cache->load_cached_config();
}


//////////////////////////////////////////////////////////////////
// END LOAD CONFIG
//////////////////////////////////////////////////////////////////

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>