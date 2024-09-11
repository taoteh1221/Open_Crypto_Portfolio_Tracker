<?php
/*
 * Copyright 2014-2024 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com (leave this copyright / attribution intact in ALL forks / copies!)
 */


header('Content-type: text/html; charset=' . $ct['dev']['charset_default']);

header('Access-Control-Allow-Headers: *'); // Allow ALL headers

// Allow access from ANY SERVER (primarily in case the end-user has a server misconfiguration)
if ( $ct['conf']['sec']['access_control_origin'] == 'any' ) {
header('Access-Control-Allow-Origin: *');
}
// Strict access from THIS APP SERVER ONLY (provides tighter security)
else {
header('Access-Control-Allow-Origin: ' . $ct['app_host_address']);
}


// If we are not admin logged in, OR fail the CSRF security token check, exit
if ( !$ct['gen']->admin_logged_in() || !$ct['gen']->pass_sec_check($_GET['gen_nonce'], 'general_csrf_security') ) {
     
// Log errors / debugging, send notifications
$ct['cache']->app_log();
$ct['cache']->send_notifications();

?>

<p class='red' style='font-weight: bold;'>Invalid security token, please <a href='admin.php' target='_parent'>login again</a>.</p>

<?php

exit; // Exit for security!

}

?>


<script>

disable_nav_save_buttons = 'Disabled when using the setup wizard system.';

console.log('disable_nav_save_buttons = ' + disable_nav_save_buttons);

</script>


<?php


if ( $_GET['type'] == 'add_markets' ) {
require_once($ct['base_dir'] . '/app-lib/php/inline/ajax/setup-wizards/markets/markets-add/add-markets-init.php');
}
elseif ( $_GET['type'] == 'remove_markets' ) {
require_once($ct['base_dir'] . '/app-lib/php/inline/ajax/setup-wizards/markets/markets-remove/remove-markets-init.php');
}


// DEBUGGING POST DATA...
if ( $ct['conf']['power']['debug_mode'] == 'setup_wizards_io' ) {
    
    if ( isset($_POST) && is_array($_POST) ) {
    $ct['gen']->array_debugging($_POST, true);
    }

}


// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>