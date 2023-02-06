<?php

header('Content-type: text/html; charset=' . $ct_conf['dev']['charset_default']);

header('Access-Control-Allow-Headers: *'); // Allow ALL headers

// Allow access from ANY SERVER (primarily in case the end-user has a server misconfiguration)
if ( $ct_conf['sec']['access_control_origin'] == 'any' ) {
header('Access-Control-Allow-Origin: *');
}
// Strict access from THIS APP SERVER ONLY (provides tighter security)
else {
header('Access-Control-Allow-Origin: ' . $app_host_address);
}

?><!DOCTYPE html>
<html lang="en">
<!-- /*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */ -->

<head>


	<title>Open Crypto Tracker<?=( $is_admin ? ' - Admin Config' : '' )?></title>
    

     <meta charset="<?=$ct_conf['dev']['charset_default']?>">
   
     <meta name="viewport" content="width=device-width"> <!-- Mobile compatibility -->
   
	<meta name="robots" content="noindex,nofollow"> <!-- Keeps this URL private (search engines won't add this URL to their search indexes) -->
	
	<meta name="referrer" content="same-origin"> <!-- Keeps this URL private (BROWSER referral data won't be sent when clicking external links) -->
	
	
	<!-- Preload a few UI-related files -->
	
	<link rel="preload" href="templates/interface/media/images/auto-preloaded/login-<?=$sel_opt['theme_selected']?>-theme.png" as="image">
	
	<link rel="preload" href="templates/interface/media/images/auto-preloaded/notification-<?=$sel_opt['theme_selected']?>-line.png" as="image">
	
	<link rel="preload" href="templates/interface/media/images/auto-preloaded/loader.gif" as="image">
    
    
	<link rel="preload" href="templates/interface/desktop/css/bootstrap/bootstrap.min.css" as="style" />

	<link rel="preload" href="templates/interface/desktop/css/modaal.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/jquery-ui/jquery-ui.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/jquery.mCustomScrollbar.min.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/sidebar-style.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/style.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/<?=$sel_opt['theme_selected']?>.style.css" as="style" />
	
	
	<?php
	if ( $is_admin ) {
	?>
	
	<link rel="preload" href="templates/interface/desktop/css/admin.css" as="style" />
	
	<link rel="preload" href="templates/interface/desktop/css/<?=$sel_opt['theme_selected']?>.admin.css" as="style" />
	
	<?php
	}
	?>


	<link rel="preload" href="app-lib/js/jquery/jquery-3.6.0.min.js" as="script" />

	<link rel="preload" href="app-lib/js/jquery/jquery.tablesorter.min.js" as="script" />

	<link rel="preload" href="app-lib/js/jquery/jquery.tablesorter.widgets.min.js" as="script" />

	<link rel="preload" href="app-lib/js/jquery/jquery.balloon.min.js" as="script" />
	
	<link rel="preload" href="app-lib/js/jquery/jquery-ui/jquery-ui.js" as="script" />

     <link rel="preload" href="app-lib/js/jquery/jquery.repeatable.js" as="script" />

     <link rel="preload" href="app-lib/js/jquery/jquery.mCustomScrollbar.concat.min.js" as="script" />

	<link rel="preload" href="app-lib/js/modaal.js" as="script" />

	<link rel="preload" href="app-lib/js/base64-decode.js" as="script" />

	<link rel="preload" href="app-lib/js/autosize.min.js" as="script" />

	<link rel="preload" href="app-lib/js/popper.min.js" as="script" />
	
	<link rel="preload" href="app-lib/js/zingchart.min.js" as="script" />
	
	<link rel="preload" href="app-lib/js/crypto-js.js" as="script" />

	<link rel="preload" href="app-lib/js/functions.js" as="script" />
	
	
	<!-- END Preload a few UI-related files -->
	
	
	<script>
	
	// Set the modal windows array (to dynamically populate)
	var modal_windows = [];
	
	// Install ID (derived from this app's server path)
	var ct_id = '<?=$ct_gen->id()?>';
	
	var app_edition = '<?=$app_edition?>';
	
	var min_fiat_val_test = '<?=$min_fiat_val_test?>';
	
	var min_crypto_val_test = '<?=$min_crypto_val_test?>';
	
	var watch_only_flag_val = '<?=$watch_only_flag_val?>';
	
	var logs_csrf_sec_token = '<?=base64_encode( $ct_gen->admin_hashed_nonce('logs_csrf_security') )?>';
	
	var notes_storage = ct_id + "notes";
	
	var background_tasks_status = 'wait'; // Default
	
	var background_tasks_recheck; // Default
	
	var reload_recheck; // Default
    
     window.is_admin = false; // Default
    
     window.form_submit_queued = false; // Default
	
	window.reload_countdown = false; // Default
	
	// Preload /images/auto-preloaded/ images VIA JAVASCRIPT TOO (WAY MORE RELIABLE THAN META TAG PRELOAD)
	
	<?php
	$preloaded_files_dir = 'templates/interface/media/images/auto-preloaded';
	$preloaded_files = $ct_gen->list_files($preloaded_files_dir);
	
	$loop = 0;
	foreach ( $preloaded_files as $preload_file ) {
	?>
	
	var loader_image_<?=$loop?> = new Image();
	loader_image_<?=$loop?>.src = '<?=$preloaded_files_dir?>/<?=$preload_file?>';
	
	<?php
	$loop = $loop + 1;
	}
	?>
	
	</script>
    
    
	<link rel="stylesheet" href="templates/interface/desktop/css/bootstrap/bootstrap.min.css" type="text/css" />

	<link rel="stylesheet" href="templates/interface/desktop/css/modaal.css" type="text/css" />
	
	<link rel="stylesheet" href="templates/interface/desktop/css/jquery-ui/jquery-ui.css" type="text/css" />
	
	<link rel="stylesheet" href="templates/interface/desktop/css/jquery.mCustomScrollbar.min.css" type="text/css" />
	
	<link rel="stylesheet" href="templates/interface/desktop/css/sidebar-style.css" type="text/css" />
	
	<!-- Load theme styling last to over rule -->
	<link rel="stylesheet" href="templates/interface/desktop/css/style.css" type="text/css" />
	
	<link rel="stylesheet" href="templates/interface/desktop/css/<?=$sel_opt['theme_selected']?>.style.css" type="text/css" />
	
	
	<?php
	if ( $is_admin ) {
	?>
	
	<link rel="stylesheet" href="templates/interface/desktop/css/admin.css" type="text/css" />
	
	<link rel="stylesheet" href="templates/interface/desktop/css/<?=$sel_opt['theme_selected']?>.admin.css" type="text/css" />
	
	<?php
	}
	?>
	
	
	<style>

	@import "templates/interface/desktop/css/tablesorter/theme.<?=$sel_opt['theme_selected']?>.css";
	
	.tablesorter-<?=$sel_opt['theme_selected']?> .header, .tablesorter-<?=$sel_opt['theme_selected']?> .tablesorter-header {
     white-space: nowrap;
	}
	
	</style>


	<script src="app-lib/js/jquery/jquery-3.6.0.min.js"></script>

	<script src="app-lib/js/jquery/jquery.tablesorter.min.js"></script>

	<script src="app-lib/js/jquery/jquery.tablesorter.widgets.min.js"></script>

	<script src="app-lib/js/jquery/jquery.balloon.min.js"></script>
	
	<script src="app-lib/js/jquery/jquery-ui/jquery-ui.js"></script>

     <script src="app-lib/js/jquery/jquery.repeatable.js"></script>

	<script src="app-lib/js/jquery/jquery.mCustomScrollbar.concat.min.js"></script>

	<script src="app-lib/js/modaal.js"></script>

	<script src="app-lib/js/base64-decode.js"></script>

	<script src="app-lib/js/autosize.min.js"></script>

	<script src="app-lib/js/popper.min.js"></script>
	
	<script src="app-lib/js/zingchart.min.js"></script>
	
	<script src="app-lib/js/crypto-js.js"></script>

	<script src="app-lib/js/functions.js"></script>
	
	<?php
	// MSIE doesn't like highlightjs (LOL)
	if ( $ct_gen->is_msie() == false ) {
	?>
	
	<link rel="stylesheet" href="templates/interface/desktop/css/highlightjs.min.css" type="text/css" />
	
	<script src="app-lib/js/highlight.min.js"></script>
	
	<script>
	// Highlightjs configs
	hljs.configure({useBR: false}); // Don't use  <br /> between lines
	hljs.initHighlightingOnLoad(); // Load on page load
	</script>
	
	<?php
	}
	// Fix some minor MSIE CSS stuff
	else {
	?>
	<style>
	
	pre {
	color: #808080;
	}
	
	</style>
	<?php
	}
	?>
	
	<script>
    
    window.is_admin = false; // Default
	
	<?php
	// Flag admin area in js
	if ( $is_admin == true ) {
	?>	
	
    window.is_admin = true;
	
	<?php
	}
	?>
	
	// Set the global JSON config to asynchronous 
	// (so JSON requests run in the background, without pausing any of the page render scripting)
	$.ajaxSetup({
    async: true
	});
	

	<?=( isset($system_info['portfolio_cookies']) ? '// CURRENT COOKIES SIZE TOTAL: ' . $ct_var->num_pretty( ($system_info['portfolio_cookies'] / 1000) , 2) . ' kilobytes' : '' )?>
	
	
	// Main js vars
	var cookies_size_warning = '<?=( isset($system_warnings['portfolio_cookies_size']) ? $system_warnings['portfolio_cookies_size'] : 'none' )?>';
	
	var theme_selected = '<?=$sel_opt['theme_selected']?>';
	
	var feeds_num = <?=( isset($sel_opt['show_feeds'][0]) && $sel_opt['show_feeds'][0] != '' ? sizeof($sel_opt['show_feeds']) : 0 )?>;
	var feeds_loaded = new Array();
	
	var charts_num = <?=( isset($sel_opt['show_charts'][0]) && $sel_opt['show_charts'][0] != '' ? sizeof($sel_opt['show_charts']) : 0 )?>;
	var charts_loaded = new Array();
	
	var sorted_by_col = <?=( $sel_opt['sorted_by_col'] ? $sel_opt['sorted_by_col'] : 0 )?>;
	var sorted_asc_desc = <?=( $sel_opt['sorted_asc_desc'] ? $sel_opt['sorted_asc_desc'] : 0 )?>;
	
	var charts_background = '<?=$ct_conf['power']['charts_background']?>';
	var charts_border = '<?=$ct_conf['power']['charts_border']?>';
	
	var btc_prim_currency_val = '<?=number_format( $sel_opt['sel_btc_prim_currency_val'], 2, '.', '' )?>';
	var btc_prim_currency_pair = '<?=strtoupper($ct_conf['gen']['btc_prim_currency_pair'])?>';
	
	
	<?php
	foreach ( $ct_conf['dev']['limited_apis'] as $api ) {
	$js_limited_apis .= '"'.strtolower( preg_replace("/\.(.*)/i", "", $api) ).'", ';
	}
	$js_limited_apis = trim($js_limited_apis);
	$js_limited_apis = rtrim($js_limited_apis,',');
	$js_limited_apis = trim($js_limited_apis);
	$js_limited_apis = '['.$js_limited_apis.']';
	?>

	var limited_apis = <?=$js_limited_apis?>;
	
	<?php
	foreach ( $ct_conf['power']['crypto_pair_pref_mrkts'] as $key => $unused ) {
	$secondary_mrkt_currencies .= '"'.strtolower($key).'", ';
	}
	foreach ( $ct_conf['power']['btc_currency_mrkts'] as $key => $unused ) {
	$secondary_mrkt_currencies .= '"'.strtolower($key).'", ';
	}
	$secondary_mrkt_currencies = trim($secondary_mrkt_currencies);
	$secondary_mrkt_currencies = rtrim($secondary_mrkt_currencies,',');
	$secondary_mrkt_currencies = trim($secondary_mrkt_currencies);
	$secondary_mrkt_currencies = '['.$secondary_mrkt_currencies.']';
	?>

	var secondary_mrkt_currencies = <?=$secondary_mrkt_currencies?>;
	
	var pref_bitcoin_mrkts = []; // Set the array
	
	<?php
	foreach ( $ct_conf['power']['btc_pref_currency_mrkts'] as $pref_bitcoin_mrkts_key => $pref_bitcoin_mrkts_val ) {
	?>
	pref_bitcoin_mrkts["<?=strtolower( $pref_bitcoin_mrkts_key )?>"] = "<?=strtolower( $pref_bitcoin_mrkts_val )?>";
	<?php
	}
	// If desktop edition, cron emulation is enabled, and NOT on login form submission pages, run emulated cron
	if ( $app_edition == 'desktop' && $ct_conf['power']['desktop_cron_interval'] > 0 && !$is_login_form ) {
	?>	
	
    // Emulate a cron job every 20 minutes...
    var cron_loaded = false;
    
    emulated_cron(); // Initial load (RELOADS from WITHIN it's OWN logic every minute AFTER)
	
	<?php
	}
	else {
	?>
	
	// Register as no-action-needed (saying it's already loaded turns off UI notices)
    var cron_loaded = true;
    
	<?php
	}	
	?>
	
	
	// 'Loading X...' UI notices
	background_tasks_check();
    
	
	</script>

	<script src="app-lib/js/init.js"></script>

	<script src="app-lib/js/random-tips.js"></script>


	<link rel="shortcut icon" href="templates/interface/media/images/favicon.png">
	<link rel="icon" href="templates/interface/media/images/favicon.png">


</head>
<body>


<audio preload="metadata" id="audio_alert">
      <source src="templates/interface/media/audio/Intruder_Alert-SoundBible.com-867759995.mp3">
      <source src="templates/interface/media/audio/Intruder_Alert-SoundBible.com-867759995.ogg">
</audio>


<div id="primary_wrapper" class="wrapper">

   <!-- hamburger menu toggle icon -->
   <img src='templates/interface/media/images/auto-preloaded/icons8-hamburger-menu-96-<?=$sel_opt['theme_selected']?>.png' class='sidebar_toggle' id="menu_hamburger" />


    <!-- Sidebar -->
    <nav id="sidebar">
        
        <img src='templates/interface/media/images/auto-preloaded/icons8-close-window-50-<?=$sel_opt['theme_selected']?>.png' class='sidebar_toggle' id="dismiss" />

        <div class="sidebar-header">
            <h3>Open Crypto Tracker</h3>
        </div>

        <ul class="list-unstyled components">
            <p><i>Privately</i> track <i>ANY</i> Crypto on your home network or internet website for <a class='sidebar_secondary_link' href='https://taoteh1221.github.io/' target='_blank'><i>FREE</i></a>.</p>
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle active">Home</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li class='sidebar-item'>
                        <a href="#">Home 1</a>
                    </li>
                    <li class='sidebar-item'>
                        <a href="#">Home 2</a>
                    </li>
                    <li class='sidebar-item'>
                        <a href="#">Home 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li class='sidebar-item'>
                        <a href="#">Page 1</a>
                    </li>
                    <li class='sidebar-item'>
                        <a href="#">Page 2</a>
                    </li>
                    <li class='sidebar-item'>
                        <a href="#">Page 3</a>
                    </li>
                </ul>
            </li>
            <li class='sidebar-item active'>
                <a href="#">Portfolio</a>
            </li>
            <li class='sidebar-item'>
                <a href="#">Contact</a>
            </li>
        </ul>

    </nav>
    
    
    <!-- content body -->
    <div class='align_center' id='secondary_wrapper' style='<?=( $login_template == 1 ? 'min-width: 720px; max-width: 800px;' : '' )?>'>
    

        <?php
        if ( $app_edition == 'desktop' ) {
        ?>
        
        <div class='blue' id='change_font_size'>
        
        <img id="zoom_info" src="templates/interface/media/images/info-red.png" alt="" width="30" style="position: relative; right: -5px;" />
        
        Zoom (<span id='zoom_show_ui'></span>): <span id='minusBtn' class='red'>-</span> <span id='plusBtn' class='green'>+</span>
        
        </div>
        
        
        <script>
        
        
        		
        			var zoom_info_content = '<h5 class="yellow tooltip_title">Desktop Edition Page Zoom</h5>'
        			
        			+'<p class="coin_info" style="max-width: 600px; white-space: normal;">This zoom feature allows Desktop Editions to zoom the app interface to be larger or smaller.</p>'
        			
        			+'<p class="coin_info bitcoin" style="max-width: 600px; white-space: normal;">Chart crosshairs and tooltip windows may be significantly off-center, if you go too far above or below the 100% zoom level. Hopefully someday we will have a fix for this, but for now just be aware of what effects the current zoom feature has on the app.</p>'
        			
        			+'<p class="coin_info red" style="max-width: 600px; white-space: normal;">We depend on the 3rd-party Open Source project <a href="https://github.com/cztomczak/phpdesktop" target="_blank">PHPdesktop</a>, for the Desktop Editions.</p>';
        			
        		
        			$('#zoom_info').balloon({
        			html: true,
        			position: "left",
          			classname: 'balloon-tooltips',
        			contents: zoom_info_content,
        			css: {
        					fontSize: ".8rem",
        					minWidth: "450px",
        					padding: ".3rem .7rem",
        					border: "2px solid rgba(212, 212, 212, .4)",
        					borderRadius: "6px",
        					boxShadow: "3px 3px 6px #555",
        					color: "#eee",
        					backgroundColor: "#111",
        					opacity: "0.99",
        					zIndex: "32767",
        					textAlign: "left"
        					}
        			});
        		
        
        
        </script>


        
        <?php
        }
        ?>
        
        <div id='header_size_warning'></div>
    
    
		<div class='align_center' id='body_top_nav' style='<?=( $login_template == 1 ? 'min-width: 720px; max-width: 800px;' : '' )?>'>
		
		
			<!-- START #topnav-content -->
			<nav id='topnav' class="navbar navbar-expand align_center" style='<?=( $login_template == 1 ? 'min-width: 720px; max-width: 800px;' : '' )?>'>
			   
				<?php
				// Filename info, to dynamically render active menu link displaying
			   $script_file_info = pathinfo($_SERVER['SCRIPT_FILENAME']);
				?>
				
			  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  
					<ul id='admin_nav' class="navbar-nav" style='right: 4px; bottom: 4px;'>
					
				  		<li class="nav-item dropdown align_center">
					
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src='templates/interface/media/images/auto-preloaded/login-<?=$sel_opt['theme_selected']?>-theme.png' height='27' border='0' /></a>
					
							<div class="dropdown-menu shadow-lg p-3 mb-5 bg-white rounded" aria-labelledby="navbarDropdown">
							
					  			<a class="dropdown-item<?=( $script_file_info['basename'] == 'admin.php' ? ' active' : '' )?>" href="admin.php">Admin Config</a>
					  			
					  			<a class="dropdown-item<?=( $script_file_info['basename'] == 'index.php' ? ' active' : '' )?>" href="index.php">Portfolio</a>
					  			
					  			<?php
					  			if ( $ct_gen->admin_logged_in() ) {
					  			?>
					  			<a class="dropdown-item" href="?logout=1&admin_hashed_nonce=<?=$ct_gen->admin_hashed_nonce('logout')?>">Logout</a>
					  			<?php
					  			}
					 			?>
					  
							</div>
					
				  		</li>
				  		
					</ul>
				
				
				<h2>Open Crypto Tracker<?=( $is_admin ? ' - Admin Config' : '' )?></h2>
				
				
					<div id="navbarDropdownBell" class="navbar-nav dropleft" style='left: 12px;'>
				
  						<a class="nav-link" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id='alert_bell_image' src='templates/interface/media/images/auto-preloaded/notification-<?=$sel_opt['theme_selected']?>-line.png' height='30' border='0' /></a>
  
  						<!-- Alerts div centering wrapper -->
  						<div id='alert_bell_wrapper' style='position:absolute; top: 46px; left: 50%;'>
  
  							<div id='alert_bell_area' class="dropdown-menu red" aria-labelledby="navbarDropdown2">
 							<!-- alerts output dynamically here -->
  							</div>
  	
  						</div>
  
					</div>
				
			  	</div>
				
			</nav>
  	
  	
  	<script>
  	
  	// Get how far from left edge of PARENT containers we are, on relevent containers
  	var pos_topnav = document.getElementById('topnav').getBoundingClientRect();
  	var pos_bell = document.getElementById('navbarDropdownBell').getBoundingClientRect();
	
	 // Amount left of #navbarDropdownBell from #topnav edge, MINUS amount left of #topnav from page edge
	var alerts_window_to_left = Math.round(pos_bell.left - pos_topnav.left);
	
	// Dynamically move alerts window further left (using left position, MINUS left MORE)
	$("#alert_bell_wrapper").css({ "left": '-' + alerts_window_to_left + 'px' });
	
  	</script>
  	
  	
				<!-- END #topnav-content -->
		
		
		</div>
		
    
	 	<div class='align_center loading bitcoin' id='app_loading'>
	 	<img src="templates/interface/media/images/auto-preloaded/loader.gif" height='57' alt="" style='vertical-align: middle;' /> <span id='app_loading_span'>Loading...</span>
	 	</div>
	 	
	 	<script>
	 	
        // For UX, set proper page zoom for 'loading...' and zoom GUI on desktop editions
        // (we can't set body zoom until it's fully loaded, which we do via init.js)
        if ( app_edition == 'desktop' ) {
            
             // Page zoom logic
             if ( localStorage.getItem('currzoom') ) {
             currzoom = localStorage.getItem('currzoom');
             }
             else {
             currzoom = 100;
             }
            
        // Just zoom #topnav and #app_loading and #change_font_size / show zoom level in GUI
        // (we'll reset them to 100% before we zoom the whole body in init.js)
        $('#topnav').css('zoom', ' ' + currzoom + '%');
        $('#change_font_size').css('zoom', ' ' + currzoom + '%');
        $('#app_loading').css('zoom', ' ' + currzoom + '%');
        $("#zoom_show_ui").html(currzoom + '%');
                         
        }
    
	 	</script>
	 
		
		<div class='align_left' id='content_wrapper'>
				
				<?php

                // If we are queued to run a UI alert that an upgrade is available
                // VAR MUST BE SET RIGHT BEFORE CHECK ON DATA FROM THIS CACHE FILE, AS IT CAN BE UPDATED #AFTER# APP INIT!
                if ( file_exists($base_dir . '/cache/events/ui_upgrade_alert.dat') ) {
                $ui_upgrade_alert = json_decode( file_get_contents($base_dir . '/cache/events/ui_upgrade_alert.dat') , true);
                }
                
                
			    // show the upgrade notice one time until the next reminder period, IF ADMIN LOGGED IN
				if ( isset($ui_upgrade_alert) && $ui_upgrade_alert['run'] == 'yes' && $ct_gen->admin_logged_in() ) {
				    
                // Workaround for #VERY ODD# PHP v8.0.1 BUG, WHEN TRYING TO ECHO $ui_upgrade_alert['message'] IN HEADER.PHP
                // (so we render it in footer.php, near the end of rendering)
    			$display_upgrade_alert = true;
    			
				?>
				    
                <script>
                // Render after page loads
                $(document).ready(function(){
                $('#ui_upgrade_message').html( $('#app_upgrade_alert').html() );
                });
                </script>
	
    			<div class="alert alert-warning" role="alert">
      				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        				<span aria-hidden="true">&times;</span>
      				</button>
    			  	<div id='ui_upgrade_message'></div>
    			</div>
				
			    <?php
				
    			// Set back to 'run' => 'no' 
    			// (will automatically re-activate in upgrade-check.php at a later date, if another reminder is needed after X days)
    			$ui_upgrade_alert['run'] = 'no';
    						
    			$ct_cache->save_file($base_dir . '/cache/events/ui_upgrade_alert.dat', json_encode($ui_upgrade_alert, JSON_PRETTY_PRINT) );
					
				}
				
				?>
		 
				<div id='background_loading' class='align_center loading bitcoin'><img src="templates/interface/media/images/auto-preloaded/loader.gif" height='17' alt="" style='vertical-align: middle;' /> <span id='background_loading_span'></span></div>
		
					
		<!-- header.php END -->
			
	
