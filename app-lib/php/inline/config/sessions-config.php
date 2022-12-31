<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */



//////////////////////////////////////////////////////////////////
// SESSIONS CONFIG
//////////////////////////////////////////////////////////////////


// server should keep session data for AT LEAST 6 hours
ini_set('session.gc_maxlifetime', (6 * 3600) );


// PHP session cookie defaults
// each client should remember their session id for EXACTLY 6 hours
$php_sess_time = (6 * 3600);
$php_sess_secure = ( $app_edition == 'server' ? true : false );

if ( PHP_VERSION_ID >= 70300 ) {
	
	session_set_cookie_params([
                                'lifetime' => $php_sess_time,
                                'path' => $app_path,
                                'domain' => '',  // LEAVE DOMAIN BLANK, SO session_set_cookie_params AUTO-SETS PROPERLY (IN CASE OF EDGE-CASE REDIRECTS)
                                'secure' => $php_sess_secure,
                                'httponly' => false,
                                'samesite' => 'Strict',
                    	       ]);

}
else {
	
	session_set_cookie_params([
                                $php_sess_time,
                                $app_path . '; samesite=Strict',
                                '',  // LEAVE DOMAIN BLANK, SO session_set_cookie_params AUTO-SETS PROPERLY (IN CASE OF EDGE-CASE REDIRECTS)
                                $php_sess_secure, // secure
                                false, //httponly
                              ]);

}


//////////////////////////////////////////////////////////////////
// END SESSIONS CONFIG
//////////////////////////////////////////////////////////////////

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!
 
?>