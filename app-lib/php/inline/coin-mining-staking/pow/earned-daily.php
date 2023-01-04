<?php
/*
 * Copyright 2014-2020 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */
	

?>				
				<br />
				<br />
				<b>Current <?=$pow_asset_data['name']?> Value Per Coin:</b> 
				
				<?php
				$val_per_unit = round( $mined_asset_val * $sel_opt['sel_btc_prim_currency_val'] , 8);
				
				$val_per_unit = ( $ct_var->num_to_str($val_per_unit) >= 1 ? round($val_per_unit, 2) : round($val_per_unit, $ct_conf['gen']['prim_currency_dec_max']) );
				
				echo ( $pow_asset_data['symbol'] == 'btc' ? number_format($sel_opt['sel_btc_prim_currency_val'], 2) . ' ' . strtoupper($ct_conf['gen']['btc_prim_currency_pair']) : number_format($mined_asset_val, 8) . ' BTC (' . $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . $val_per_unit . ' '.strtoupper($ct_conf['gen']['btc_prim_currency_pair']).')' );
				?>
				
				<br />
				<br />
				 ###################################################
				<br />
				<br />
				
				<?php
				if ( $pow_asset_data['symbol'] != 'btc' ) {
				?>
				<b>Average <?=strtoupper($pow_asset_data['symbol'])?> Earned Daily (block reward only):</b> 
				
				
				<?php
				echo number_format( $daily_avg , 8) . ' ' . strtoupper($pow_asset_data['symbol']);
				?>
				
				<br />
				<br />
				<?php
				}
				?>
				
				<b>Average BTC Value Earned Daily:</b> 
				
				<?php
				$prim_currency_daily_avg_raw = ( $ct_var->num_to_str($prim_currency_daily_avg_raw) >= 1 ? round($prim_currency_daily_avg_raw, 2) : round($prim_currency_daily_avg_raw, $ct_conf['gen']['prim_currency_dec_max']) );
				
				echo number_format( $btc_daily_avg_raw, 8 ) . ' BTC (' . $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . $prim_currency_daily_avg_raw . ' '.strtoupper($ct_conf['gen']['btc_prim_currency_pair']).')';
				?>
				
				<br />
				<br />
				
				<span class='red'><b>Power Cost Daily:</b> 
				
				<?php
				echo $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format($kwh_cost_daily, 2);
				?>
				
				</span> 
				
				<br />
				<br />
				
				<span class='red'><b>Pool Fee Daily:</b> 
				
				<?php
				echo $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format($pool_fee_daily, 2);
				?>
				
				</span> 
				
				<br />
				<br />
				
				<?php
				
				$mining_daily_profit = $ct_var->num_to_str($prim_currency_daily_avg_raw - $kwh_cost_daily - $pool_fee_daily); // Better decimal support
				
				if ( $mining_daily_profit >= 0 ) {
				$mining_daily_profit_span = 'green';
				}
				else {
				$mining_daily_profit_span = 'red';
				}
				
				?>
				
				<b><span class="<?=$mining_daily_profit_span?>">Daily Profit:</span></b> 
				
				<?php
				echo '<span class="'.$mining_daily_profit_span.'">' . $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format($mining_daily_profit, 2) . '</span>';
				?>
				
				<br />
				<br />
				 ###################################################
				<br />
				<br />
				
				<?php
				if ( $pow_asset_data['symbol'] != 'btc' ) {
				?>
				<b>Average <?=strtoupper($pow_asset_data['symbol'])?> Earned Weekly (block reward only):</b> 
				
				
				<?php
				echo number_format( $daily_avg * 7 , 8) . ' ' . strtoupper($pow_asset_data['symbol']);
				?>
				
				<br />
				<br />
				<?php
				}
				?>
				
				<b>Average BTC Value Earned Weekly:</b> 
				
				<?php
				echo number_format( $btc_daily_avg_raw * 7 , 8) . ' BTC (' . $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format( $prim_currency_daily_avg_raw * 7 , 2) . ' '.strtoupper($ct_conf['gen']['btc_prim_currency_pair']).')';
				?>
				
				<br />
				<br />
				
				<span class='red'><b>Power Cost Weekly:</b> 
				
				<?php
				echo $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format($kwh_cost_daily * 7, 2);
				?>
				
				</span>
				
				<br />
				<br />
				
				<span class='red'><b>Pool Fee Weekly:</b> 
				
				<?php
				echo $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format($pool_fee_daily * 7, 2);
				?>
				
				</span>
				
				<br />
				<br />
				
				<b><span class="<?=$mining_daily_profit_span?>">Weekly Profit:</span></b> 
				
				<?php
				echo '<span class="'.$mining_daily_profit_span.'">' . $ct_conf['power']['btc_currency_mrkts'][ $ct_conf['gen']['btc_prim_currency_pair'] ] . number_format( ($mining_daily_profit * 7) , 2) . '</span>';
				?>
				
				<br />
				<br />
				 ###################################################
				<br />
				<br />
				
		