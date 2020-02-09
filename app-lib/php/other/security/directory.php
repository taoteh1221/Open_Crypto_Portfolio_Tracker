<?php
/*
 * Copyright 2014-2020 GPLv3, DFD Cryptocoin Values by Mike Kilday: http://DragonFrugal.com
 */


if ( $force_exit != 1 ) {

    
    ///////////////////////////////////////////
    
    // Recreate /.htaccess for optional password access restriction / mod rewrite etc
    if ( !file_exists($base_dir . '/.htaccess') ) {
    store_file_contents($base_dir . '/.htaccess', file_get_contents($base_dir . '/templates/back-end/root-app-directory-htaccess.template') ); 
    }
    
    ///////////////////////////////////////////
    
    // Recreate /cache/.htaccess to restrict web snooping of cache contents, if the cache directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/.htaccess') ) {
    store_file_contents($base_dir . '/cache/.htaccess', file_get_contents($base_dir . '/templates/back-end/deny-all-htaccess.template') ); 
    }
    
    // Recreate /cache/index.php to restrict web snooping of backup contents, if the cache directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/index.php') ) {
    store_file_contents($base_dir . '/cache/index.php', file_get_contents($base_dir . '/templates/back-end/403-directory-index.template')); 
    }
    
    // Recreate /cache/htaccess_security_check.dat to test htaccess activation, if the cache directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/htaccess_security_check.dat') ) {
    store_file_contents($base_dir . '/cache/htaccess_security_check.dat', file_get_contents($base_dir . '/templates/back-end/access_test.template')); 
    }
    
    ///////////////////////////////////////////
    
    // Recreate /cache/secured/.htaccess to restrict web snooping of backup contents, if the cache directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/.htaccess') ) {
    store_file_contents($base_dir . '/cache/secured/.htaccess', file_get_contents($base_dir . '/templates/back-end/deny-all-htaccess.template')); 
    }
    
    // Recreate /cache/secured/index.php to restrict web snooping of backup contents, if the cache directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/index.php') ) {
    store_file_contents($base_dir . '/cache/secured/index.php', file_get_contents($base_dir . '/templates/back-end/403-directory-index.template')); 
    }
    
    ///////////////////////////////////////////
    
    // Recreate /cache/secured/apis/.htaccess to restrict web snooping of cache contents, if the apis directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/apis/.htaccess') ) {
    store_file_contents($base_dir . '/cache/secured/apis/.htaccess', file_get_contents($base_dir . '/templates/back-end/deny-all-htaccess.template') ); 
    }
    
    // Recreate /cache/secured/apis/index.php to restrict web snooping of backup contents, if the apis directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/apis/index.php') ) {
    store_file_contents($base_dir . '/cache/secured/apis/index.php', file_get_contents($base_dir . '/templates/back-end/403-directory-index.template')); 
    }
    
    ///////////////////////////////////////////
    
    // Recreate /cache/secured/backups/.htaccess to restrict web snooping of cache contents, if the backups directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/backups/.htaccess') ) {
    store_file_contents($base_dir . '/cache/secured/backups/.htaccess', file_get_contents($base_dir . '/templates/back-end/deny-all-htaccess.template') ); 
    }
    
    // Recreate /cache/secured/backups/index.php to restrict web snooping of backup contents, if the backups directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/backups/index.php') ) {
    store_file_contents($base_dir . '/cache/secured/backups/index.php', file_get_contents($base_dir . '/templates/back-end/403-directory-index.template')); 
    }
    
    ///////////////////////////////////////////
    
    // Recreate /cache/secured/messages/.htaccess to restrict web snooping of cache contents, if the messages directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/messages/.htaccess') ) {
    store_file_contents($base_dir . '/cache/secured/messages/.htaccess', file_get_contents($base_dir . '/templates/back-end/deny-all-htaccess.template') ); 
    }
    
    // Recreate /cache/secured/messages/index.php to restrict web snooping of backup contents, if the messages directory was deleted / recreated
    if ( !file_exists($base_dir . '/cache/secured/messages/index.php') ) {
    store_file_contents($base_dir . '/cache/secured/messages/index.php', file_get_contents($base_dir . '/templates/back-end/403-directory-index.template')); 
    }
    
    ///////////////////////////////////////////


}

 
?>