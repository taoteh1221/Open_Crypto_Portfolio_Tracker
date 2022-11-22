<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


// Runtime mode
$runtime_mode = 'webhook';


// Load app config / etc
require("app-lib/php/init.php");


header('Content-type: text/html; charset=' . $ct_conf['dev']['charset_default']);

header('Access-Control-Allow-Headers: *'); // Allow ALL headers

// Allow access from ANY SERVER (AS THIS IS A WEBHOOK ACCESS POINT)
header('Access-Control-Allow-Origin: *');


// Webhook security check (hash must match our concatenated [service name + webhook key]'s hash, or we abort runtime)
// Using the hash of the concatenated [service name + webhook key] keeps our webhook key a secret, that only we know (for security)!
$webhook_hash = explode('/', $_GET['webhook_hash']); // Remove any data after the webhook hash



///////////////////////////////////////////////////////////////////////////////
// Telegram
elseif ( $webhook_hash[0] == $ct_gen->nonce_digest('telegram', $webhook_key) ) {

// https://core.telegram.org/bots/api

// https://core.telegram.org/bots/api#making-requests

// https://api.telegram.org/bot{my_bot_token}/setWebhook?url={url_to_send_updates_to}

// https://api.telegram.org/bot{my_bot_token}/deleteWebhook

// https://api.telegram.org/bot{my_bot_token}/getWebhookInfo


}
///////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////
// Test only
elseif ( $webhook_hash[0] == $ct_gen->nonce_digest('test-only', $webhook_key) ) {

$test_params = array('api_key' => $api_key);
						
$test_data = @$ct_cache->ext_data('params', $test_params, 0, $base_url . 'api/market_conversion/eur/kraken-btc-usd,coinbase-dai-usd,coinbase-eth-usd', 2);

// Already json-encoded
echo $test_data;

}
///////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////
// No service
else {
$result = array('error' => "No service match for webhook: " . $webhook_hash[0]);
}
///////////////////////////////////////////////////////////////////////////////



// Return any results in json format
if ( isset($result) ) {
echo json_encode($result, JSON_PRETTY_PRINT);
}

//echo $ct_gen->nonce_digest('test-only', $webhook_key) . ' -- ';


// Log errors / debugging, send notifications
$ct_cache->error_log();
$ct_cache->debug_log();
$ct_cache->send_notifications();

flush(); // Clean memory output buffer for echo
gc_collect_cycles(); // Clean memory cache

// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>