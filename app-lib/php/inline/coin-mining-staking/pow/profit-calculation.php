<?php
/*
 * Copyright 2014-2020 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */
				
$mined_asset_val = $ct['api']->market(strtoupper($pow_asset_data['symbol']), $pow_asset_data['exchange_name'], $pow_asset_data['exchange_mrkt'])['last_trade'];
				
$btc_daily_avg_raw = ( $pow_asset_data['symbol'] == 'btc' ? $daily_avg : $daily_avg * $mined_asset_val );

$prim_currency_daily_avg_raw = $btc_daily_avg_raw * $ct['sel_opt']['sel_btc_prim_currency_val'];
				
$kwh_cost_daily = ( ( trim($_POST['watts_used']) / 1000 ) * 24 ) * trim($_POST['watts_rate']);
				
$pool_fee_daily = $prim_currency_daily_avg_raw * ( trim($_POST['pool_fee']) / 100 );

?>