<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


class ct_api {
	
// Class variables / arrays
var $ct_var1;
var $ct_var2;
var $ct_var3;
var $ct_array1 = array();

      

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function bitcoin($request) {
    
   global $ct_conf, $ct_cache;
         
       
      if ( $request == 'height' ) {
      $url = 'https://blockchain.info/q/getblockcount';
      }
      elseif ( $request == 'difficulty' ) {
      $url = 'https://blockchain.info/q/getdifficulty';
      }
         
   $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['chainstats_cache_time']);
       
   return (float)$response;
     
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function coingecko($force_prim_currency=null) {
      
   global $base_dir, $ct_conf, $ct_cache;
   
   $data = array();
   $sub_arrays = array();
   $result = array();
   
   // Don't overwrite global
   $coingecko_prim_currency = ( $force_prim_currency != null ? strtolower($force_prim_currency) : strtolower($ct_conf['gen']['btc_prim_currency_pair']) );
   
         
   // DON'T ADD ANY ERROR CHECKS HERE, OR RUNTIME MAY SLOW SIGNIFICANTLY!!
      
   
      // Batched / multiple API calls, if 'mcap_ranks_max' is greater than 'coingecko_api_batched_max'
      if ( $ct_conf['power']['mcap_ranks_max'] > $ct_conf['power']['coingecko_api_batched_max'] ) {
      
          $loop = 0;
          $calls = ceil($ct_conf['power']['mcap_ranks_max'] / $ct_conf['power']['coingecko_api_batched_max']);
         
          while ( $loop < $calls ) {
         
          $url = 'https://api.coingecko.com/api/v3/coins/markets?per_page=' . $ct_conf['power']['coingecko_api_batched_max'] . '&page=' . ($loop + 1) . '&vs_currency=' . $coingecko_prim_currency . '&price_change_percentage=1h,24h,7d,14d,30d,200d,1y';
            
              // Wait 6.55 seconds between consecutive calls, to avoid being blocked / throttled by external server
              // (coingecko #ABSOLUTELY HATES# DATA CENTER IPS [DEDICATED / VPS SERVERS], BUT GOES EASY ON RESIDENTIAL IPS)
              if ( $loop > 0 && $ct_cache->update_cache($base_dir . '/cache/secured/external_data/' . md5($url) . '.dat', $ct_conf['power']['mcap_cache_time']) == true ) {
              sleep(6);
              usleep(550000); 
              }
         
          $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['mcap_cache_time']);
   
          $sub_arrays[] = json_decode($response, true);
         
          $loop = $loop + 1;
         
          }
      
      }
      else {
      	
      $response = @$ct_cache->ext_data('url', 'https://api.coingecko.com/api/v3/coins/markets?per_page='.$ct_conf['power']['mcap_ranks_max'].'&page=1&vs_currency='.$coingecko_prim_currency.'&price_change_percentage=1h,24h,7d,14d,30d,200d,1y', $ct_conf['power']['mcap_cache_time']);
      
      $sub_arrays[] = json_decode($response, true);
      
      }
         
         
   // DON'T ADD ANY ERROR CHECKS HERE, OR RUNTIME MAY SLOW SIGNIFICANTLY!!
   
      
      // Merge any sub arrays into one data set
      foreach ( $sub_arrays as $sub ) {
          if ( is_array($sub) ) {
          $data = array_merge($data, $sub);
          }
      }
      
   
      if ( is_array($data) ) {
         
          foreach ($data as $key => $unused) {
            
              if ( isset($data[$key]['symbol']) && $data[$key]['symbol'] != '' ) {
              $result[strtolower($data[$key]['symbol'])] = $data[$key];
              }
       
          }
        
      }
           
           
   gc_collect_cycles(); // Clean memory cache
   
   return $result;
     
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   // https://core.telegram.org/bots/api
   
   // https://core.telegram.org/bots/api#making-requests
   
   // https://api.telegram.org/bot{my_bot_token}/setWebhook?url={url_to_send_updates_to}
   
   // https://api.telegram.org/bot{my_bot_token}/deleteWebhook
   
   // https://api.telegram.org/bot{my_bot_token}/getWebhookInfo
   
   function telegram($mode) {
      
   global $ct_conf, $ct_cache;
   
      if ( $mode == 'updates' ) {
      
      // Don't cache data, we are storing it as a specific (secured) cache var instead
      $response = @$ct_cache->ext_data('url', 'https://api.telegram.org/bot'.$ct_conf['ext_apis']['telegram_bot_token'].'/getUpdates', 0);
         
      $telegram_chatroom = json_decode($response, true);
   
      $telegram_chatroom = $telegram_chatroom['result']; 
   
          foreach( $telegram_chatroom as $chat_key => $chat_unused ) {
      
              // Overwrites any earlier value while looping, so we have the latest data
              if ( $telegram_chatroom[$chat_key]['message']['chat']['username'] == trim($ct_conf['ext_apis']['telegram_your_username']) ) {
              $user_data = $telegram_chatroom[$chat_key];
              }
      
          }
   
      return $user_data;
      
      }
      elseif ( $mode == 'webhook' ) {
         
      // Don't cache data, we are storing it as a specific (secured) cache var instead
      $get_telegram_webhook_data = @$ct_cache->ext_data('url', 'https://api.telegram.org/bot'.$ct_conf['ext_apis']['telegram_bot_token'].'/getWebhookInfo', 0);
         
      $telegram_webhook = json_decode($get_telegram_webhook_data, true);
      
      // logic here
      
      }
      
      
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function etherscan($block_info) {
    
   global $base_dir, $ct_conf, $ct_cache;
   
      if ( trim($ct_conf['ext_apis']['etherscan_key']) == '' ) {
      return false;
      }
   
   $url = 'https://api.etherscan.io/api?module=proxy&action=eth_blockNumber&apikey=' . $ct_conf['ext_apis']['etherscan_key'];
     
   $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['chainstats_cache_time']);
       
   $data = json_decode($response, true);
     
   $block_number = $data['result'];
       
       
      if ( !$block_number ) {
      return;
      }
      else {
            
          // Non-dynamic cache file name, because filename would change every recache and create cache bloat
          if ( $ct_cache->update_cache('cache/secured/external_data/eth-stats.dat', $ct_conf['power']['chainstats_cache_time'] ) == true ) {
            
          $url = 'https://api.etherscan.io/api?module=proxy&action=eth_getBlockByNumber&tag='.$block_number.'&boolean=true&apikey=' . $ct_conf['ext_apis']['etherscan_key'];
          $response = @$ct_cache->ext_data('url', $url, 0); // ZERO TO NOT CACHE DATA (WOULD CREATE CACHE BLOAT)
            
          $ct_cache->save_file($base_dir . '/cache/secured/external_data/eth-stats.dat', $response);
            
          $data = json_decode($response, true);
            
          return $data['result'][$block_info];
            
          }
          else {
               
          $cached_data = trim( file_get_contents('cache/secured/external_data/eth-stats.dat') );
            
          $data = json_decode($cached_data, true);
            
          return $data['result'][$block_info];
   
          }
     
      }

     
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function coinmarketcap($force_prim_currency=null) {
      
   global $ct_conf, $ct_cache, $ct_gen, $coinmarketcap_currencies, $mcap_data_force_usd, $cmc_notes;
   
   $result = array();
   
   
      if ( trim($ct_conf['ext_apis']['coinmarketcap_key']) == null ) {
      	
      $ct_gen->log(
      		    'notify_error',
      		    '"coinmarketcap_key" (free API key) is not configured in Admin Config API section',
      		    false,
      		    'coinmarketcap_key'
      		    );
      
      return false;
      
      }
      
   
   // Don't overwrite global
   $coinmarketcap_prim_currency = strtoupper($ct_conf['gen']['btc_prim_currency_pair']);
      
         
      if ( $force_prim_currency != null ) {
      $convert = strtoupper($force_prim_currency);
      $mcap_data_force_usd = null;
      }
      elseif ( in_array($coinmarketcap_prim_currency, $coinmarketcap_currencies) ) {
      $convert = $coinmarketcap_prim_currency;
      $mcap_data_force_usd = null;
      }
      // Default to USD, if currency is not supported
      else {
      $cmc_notes = 'Coinmarketcap.com does not support '.$coinmarketcap_prim_currency.' stats,<br />showing USD stats instead.';
      $convert = 'USD';
      $mcap_data_force_usd = 1;
      }
         
      
   $headers = [
               'Accepts: application/json',
               'X-CMC_PRO_API_KEY: ' . $ct_conf['ext_apis']['coinmarketcap_key']
      	      ];
   
      
   $cmc_params = array(
                       'start' => '1',
                       'limit' => $ct_conf['power']['mcap_ranks_max'],
                       'convert' => $convert
                       );
   
   
   $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
         
   $qs = http_build_query($cmc_params); // query string encode the parameters
      
   $request = "{$url}?{$qs}"; // create the request URL
   
   $response = @$ct_cache->ext_data('url', $request, $ct_conf['power']['remote_api_timeout'], null, null, null, $headers);
      
   $data = json_decode($response, true);
           
   $data = $data['data'];
              
   
      if ( is_array($data) ) {
         
          foreach ($data as $key => $unused) {
            
              if ( isset($data[$key]['symbol']) && $data[$key]['symbol'] != '' ) {
              $result[strtolower($data[$key]['symbol'])] = $data[$key];
              }
          
          }
        
      gc_collect_cycles(); // Clean memory cache
      return $result;
      
      }
   
           
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   // Credit: https://www.alexkras.com/simple-rss-reader-in-85-lines-of-php/
   function rss($url, $theme_selected, $feed_size, $cache_only=false, $email_only=false) {
      
   global $base_dir, $ct_conf, $ct_var, $ct_cache, $ct_gen, $fetched_feeds, $precache_feeds_count, $runtime_mode, $daily_tasks_offset;
   
   
      if ( !isset($_SESSION[$fetched_feeds]['all']) ) {
      $_SESSION[$fetched_feeds]['all'] = 0;
      }
      // Never re-cache FROM LIVE more than 'news_feed_batched_max' (EXCEPT for cron runtimes pre-caching), 
      // to avoid overloading low resource devices (raspi / pine64 / etc) and creating long feed load times
      elseif ( $_SESSION[$fetched_feeds]['all'] >= $ct_conf['power']['news_feed_batched_max'] && $cache_only == false && $runtime_mode != 'cron' ) {
      return '<span class="red">Live data fetching limit reached (' . $_SESSION[$fetched_feeds]['all'] . ').</span>';
      }
      // Avoid overloading low power devices with the precache hard limit
      elseif ( $cache_only == true && $precache_feeds_count >= $ct_conf['power']['news_feed_precache_hard_limit'] ) {
      return false;
      }
      
   
   $news_feed_cache_min_max = explode(',', $ct_conf['power']['news_feed_cache_min_max']);
   // Cleanup
   $news_feed_cache_min_max = array_map('trim', $news_feed_cache_min_max);
      
   $rss_feed_cache_time = rand($news_feed_cache_min_max[0], $news_feed_cache_min_max[1]);
                                    
         
      // If we will be updating the feed (live data will be retreived)
      if ( $ct_cache->update_cache($base_dir . '/cache/secured/external_data/' . md5($url) . '.dat', $rss_feed_cache_time) == true ) {
          
          
          // IF WE ARE PRECACHING, COUNT TO STOP AT THE HARD LIMIT
          if ( $cache_only == true ) {
          $precache_feeds_count = $precache_feeds_count + 1;
          }
      
      
      $_SESSION[$fetched_feeds]['all'] = $_SESSION[$fetched_feeds]['all'] + 1; // Mark as a fetched feed, since it's going to update
      
      $endpoint_tld_or_ip = $ct_gen->get_tld_or_ip($url);
   
         
          if ( $ct_conf['power']['debug_mode'] == 'all' || $ct_conf['power']['debug_mode'] == 'all_telemetry' || $ct_conf['power']['debug_mode'] == 'memory_usage_telemetry' ) {
         	
          $ct_gen->log(
         			  'system_debug',
         			  $endpoint_tld_or_ip . ' news feed updating ('.$_SESSION[$fetched_feeds]['all'].'), CURRENT script memory usage is ' . $ct_gen->conv_bytes(memory_get_usage(), 1) . ', PEAK script memory usage is ' . $ct_gen->conv_bytes(memory_get_peak_usage(), 1) . ', php_sapi_name is "' . php_sapi_name() . '"'
         			   );
         
          }
      
      
      // Throttling multiple requests to same server
      $tld_session = strtr($endpoint_tld_or_ip, ".", "");
   
            
          if ( !isset($_SESSION[$fetched_feeds][$tld_session]) ) {
          $_SESSION[$fetched_feeds][$tld_session] = 0;
          }
          // If it's a consecutive feed request to the same server, sleep X seconds to avoid rate limiting request denials
          elseif ( $_SESSION[$fetched_feeds][$tld_session] > 0 ) {
            
              if ( $endpoint_tld_or_ip == 'reddit.com' ) {
              sleep(7);
              usleep(100000); // 0.1 seconds (Reddit only allows rss feed connections every 7 seconds from ip addresses ACCORDING TO THEM)
              }
              else {
              usleep(550000); // 0.55 seconds
              }
            
          }
   
               
      $_SESSION[$fetched_feeds][$tld_session] = $_SESSION[$fetched_feeds][$tld_session] + 1;	
   
         
      } // END if updating feed
         
               
   // Get feed data (whether cached or re-caching live data)
   $response = @$ct_cache->ext_data('url', $url, $rss_feed_cache_time); 
         
      
      // Format output (UNLESS WE ARE ONLY CACHING DATA)
      if ( !$cache_only ) {
         
      $rss = simplexml_load_string($response);
      
          if ( $rss == false ) {
          gc_collect_cycles(); // Clean memory cache
          return '<span class="red">Error retrieving feed data.</span>';
          }
                     
      $html .= '<ul>';
      
      $html_hidden .= '<ul class="hidden" id="'.md5($url).'">';
      
      $mark_new = ' &nbsp; <img alt="" src="templates/interface/media/images/auto-preloaded/twotone_fiber_new_' . $theme_selected . '_theme_48dp.png" height="25" title="New Article (under ' . $ct_conf['power']['news_feed_entries_new'] . ' days old)" />';
             
      $now_timestamp = time();
             
      $count = 0;
             
	      // Atom format
	      if ( is_object($rss->entry) && sizeof($rss->entry) > 0 ) {
	             
	      $sortable_feed = array();
	               
		      foreach($rss->entry as $item) {
		      $sortable_feed[] = $item;
		      }
		               
		  $usort_results = usort($sortable_feed,  array($ct_gen, 'timestamps_usort_newest') );
		               
		      if ( !$usort_results ) {
		      $ct_gen->log( 'other_error', 'RSS feed failed to sort by newest items (' . $url . ')');
		      }
		             
		            
		      foreach($sortable_feed as $item) {
		                  
			     // If data exists, AND we aren't just caching data during a cron job
			     if ( isset($item->title) && trim($item->title) != '' && $feed_size > 0 ) {
			               
				     if ( $item->pubDate != '' ) {
				     $item_date = $item->pubDate;
				     }
				     elseif ( $item->published != '' ) {
				     $item_date = $item->published;
				     }
				     elseif ( $item->updated != '' ) {
				     $item_date = $item->updated;
				     }
				               
				     if ( !$item->link['href'] && $item->enclosure['url'] ) {
				     $item_link = $item->enclosure['url'];
				     }
				     elseif ( $item->link['href'] != '' ) {
				     $item_link = $item->link['href'];
				     }
			                  
			     $date_array = date_parse($item_date);
			                  
			     $month_name = date("F", mktime(0, 0, 0, $date_array['month'], 10));
			                  
			     $date_ui = $month_name . ' ' . $ct_gen->ordinal($date_array['day']) . ', ' . $date_array['year'] . ' @ ' . substr("0{$date_array['hour']}", -2) . ':' . substr("0{$date_array['minute']}", -2);
			            
			                  
				     // If publish date is OVER 'news_feed_entries_new' days old, DONT mark as new
				     // With offset, to try to catch any that would have been missed from runtime
				     if ( $ct_var->num_to_str($now_timestamp) > $ct_var->num_to_str( strtotime($item_date) + ($ct_conf['power']['news_feed_entries_new'] * 86400) + $daily_tasks_offset ) ) {
				     $mark_new = null;
				     }
				     // If running as $email_only, we only want 'new' posts anyway (less than 'news_feed_email_freq' days old)
				     // With offset, to try to catch any that would have been missed from runtime
				     elseif ( $email_only && $ct_var->num_to_str($now_timestamp) <= $ct_var->num_to_str( strtotime($item_date) + ($ct_conf['comms']['news_feed_email_freq'] * 86400) + $daily_tasks_offset ) ) { 
				     
    				     if ($count < $ct_conf['comms']['news_feed_email_entries_show']) {
    				     $html .= '<li style="padding: 8px;"><a style="color: #00b6db;" href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> </li>';
    				     }
    				     
			         $count++;   
			         
				     }
				     
				     
				     if ( !$email_only ) {
				         
    				     if ($count < $feed_size) {
    				     $html .= '<li class="links_list"><a href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> '.$mark_new.'</li>';
    				     }
    				     else {
    				     $html_hidden .= '<li class="links_list"><a href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> '.$mark_new.'</li>';
    				     }
			                       
			         $count++;   
    				     
				     }
			               
			               
			     }

		               
		      }
	               
	             
	      }
	      // Standard RSS format
	      elseif ( is_object($rss->channel->item) && sizeof($rss->channel->item) > 0 ) {
	             
	      $sortable_feed = array();
	               
	          foreach($rss->channel->item as $item) {
	          $sortable_feed[] = $item;
	          }
	               
	      $usort_results = usort($sortable_feed, array($ct_gen, 'timestamps_usort_newest') );
	               
	          if ( !$usort_results ) {
	          $ct_gen->log( 'other_error', 'RSS feed failed to sort by newest items (' . $url . ')');
	          }
	            
	             
	          foreach($sortable_feed as $item) {
	                  
	                  
		         // If data exists, AND we aren't just caching data during a cron job
		         if ( isset($item->title) && trim($item->title) != '' && $feed_size > 0 ) {
		               
			         if ( $item->pubDate != '' ) {
			         $item_date = $item->pubDate;
			         }
			         elseif ( $item->published != '' ) {
			         $item_date = $item->published;
			         }
			         elseif ( $item->updated != '' ) {
			         $item_date = $item->updated;
			         }
			               
			         if ( !$item->link && $item->enclosure['url'] ) {
			         $item_link = $item->enclosure['url'];
			         }
			         elseif ( $item->link != '' ) {
			         $item_link = $item->link;
			         }
		                  
		         $date_array = date_parse($item_date);
		                  
		         $month_name = date("F", mktime(0, 0, 0, $date_array['month'], 10));
		                  
		         $date_ui = $month_name . ' ' . $ct_gen->ordinal($date_array['day']) . ', ' . $date_array['year'] . ' @ ' . substr("0{$date_array['hour']}", -2) . ':' . substr("0{$date_array['minute']}", -2);
		                  
		         $item_link = preg_replace("/web\.bittrex\.com/i", "bittrex.com", $item_link); // Fix for bittrex blog links
		                  
		                  
			         // If publish date is OVER 'news_feed_entries_new' days old, DONT mark as new
				     // With offset, to try to catch any that would have been missed from runtime
			         if ( $ct_var->num_to_str($now_timestamp) > $ct_var->num_to_str( strtotime($item_date) + ($ct_conf['power']['news_feed_entries_new'] * 86400) + $daily_tasks_offset ) ) {
			         $mark_new = null;
			         }
				     // If running as $email_only, we only want 'new' posts anyway (less than 'news_feed_email_freq' days old)
				     // With offset, to try to catch any that would have been missed from runtime
				     elseif ( $email_only && $ct_var->num_to_str($now_timestamp) <= $ct_var->num_to_str( strtotime($item_date) + ($ct_conf['comms']['news_feed_email_freq'] * 86400) + $daily_tasks_offset ) ) {
    			     
    				     if ($count < $ct_conf['comms']['news_feed_email_entries_show']) {
    				     $html .= '<li style="padding: 8px;"><a style="color: #00b6db;" href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> </li>';
    				     }
    				     
			         $count++;   
			         
				     }
				     
				     
				     if ( !$email_only ) {
				         
    			         if ($count < $feed_size) {
    			         $html .= '<li class="links_list"><a href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> '.$mark_new.'</li>';
    			         }
    			         else {
    			         $html_hidden .= '<li class="links_list"><a href="'.htmlspecialchars($item_link).'" target="_blank" title="'.htmlspecialchars($date_ui).'">'.htmlspecialchars($item->title).'</a> '.$mark_new.'</li>';
    			         }
		                        
		             $count++;     
    			         
				     }
		                        
		               
		         }
	               
	               
	          }
	             
	      }
             
      
      $rand_id = 'more_' . rand();
      $html .= '</ul>';
      $html_hidden .= '</ul>';
      $show_more_less = "<p><a id='".$rand_id."' href='javascript: show_more(\"".md5($url)."\", \"".$rand_id."\");' style='font-weight: bold;' title='Show more / less RSS feed entries.'>Show More</a></p>";
         
      }
      
      
   gc_collect_cycles(); // Clean memory cache
   
      
       if ( $feed_size == 0 || $cache_only ) {
       return true;
       }
       else {
	       
	       if ( !$email_only ) {
           return $html . "\n" . $show_more_less . "\n" . $html_hidden;
	       }
	       else {
	       return $html;
	       }
	       
       }
      
       
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   // We only need $pair data if our function call needs 24hr trade volumes, so it's optional overhead
   function market($asset_symb, $sel_exchange, $mrkt_id, $pair=false) {
   
   global $ct_conf, $ct_var, $ct_cache, $ct_gen, $ct_asset, $sel_opt, $jupiter_ag_pairs, $kraken_pairs, $upbit_pairs, $coingecko_pairs, $coingecko_assets, $throttled_api_cache_time;
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      if ( strtolower($sel_exchange) == 'alphavantage_stock' ) {
   
   
          if ( trim($ct_conf['ext_apis']['alphavantage_key']) == null ) {
          	
          $ct_gen->log(
          		    'notify_error',
          		    '"alphavantage_key" (free API key) is not configured in Admin Config API section',
          		    false,
          		    'alphavantage_key'
          		    );
          
          return false;
          
          }
      
         
      $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $mrkt_id . '&apikey=' . $ct_conf['ext_apis']['alphavantage_key'];
         
      $response = @$ct_cache->ext_data('url', $url, $throttled_api_cache_time['alphavantage.co']);
         
      $data = json_decode($response, true);
      
      $data = $data["Global Quote"];
       
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( $key == '05. price' && trim($val) != '' ) {
	               
	              $result = array(
	                              'last_trade' => $val,
	                              '24hr_asset_vol' => null,
	                              '24hr_pair_vol' => $data["06. volume"]
	                     		    );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'binance' ) {
         
      $url = 'https://www.binance.com/api/v3/ticker/24hr';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
       
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["lastPrice"],
	                              '24hr_asset_vol' => $val["volume"],
	                              '24hr_pair_vol' => $val["quoteVolume"]
	                     		    );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'binance_us' ) {
         
      $url = 'https://api.binance.us/api/v3/ticker/24hr';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
       
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["lastPrice"],
	                              '24hr_asset_vol' => $val["volume"],
	                              '24hr_pair_vol' => $val["quoteVolume"]
	                     			);
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bit2c' ) {
      
      $url = 'https://bit2c.co.il/Exchanges/'.$mrkt_id.'/Ticker.json';
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
      
      $data = json_decode($response, true);
      
      $result = array(
                     'last_trade' => $data["ll"],
                     '24hr_asset_vol' => $data["a"],
                     '24hr_pair_vol' => null // Unavailable, set null
                	   );
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bitbns' ) {
         
      $url = 'https://bitbns.com/order/getTickerWithVolume';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( $key == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last_traded_price"],
	                              '24hr_asset_vol' => $val["volume"]["volume"],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                    		  );
	     
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bitfinex' || strtolower($sel_exchange) == 'ethfinex' ) {
         
      $url = 'https://api-pub.bitfinex.com/v2/tickers?symbols=ALL';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
	          if ( is_array($data) ) {
	      
	            foreach ( $data as $object ) {
	              
	              if ( is_array($object) && $object[0] == $mrkt_id ) {
	                      
	               
	              $result = array(
	                              'last_trade' => $object[( sizeof($object) - 4 )],
	                              '24hr_asset_vol' => $object[( sizeof($object) - 3 )],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     		  );
	               
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bitforex' ) {
      
      $url = 'https://api.bitforex.com/api/v1/market/ticker?symbol=' . $mrkt_id;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
      
      $data = json_decode($response, true);
      
      $result = array(
                     'last_trade' => $data["data"]["last"],
                     '24hr_asset_vol' => $data["data"]["vol"],
                     '24hr_pair_vol' => null // Unavailable, set null
                       );
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bitflyer' ) {
      
      $url = 'https://api.bitflyer.com/v1/getticker?product_code=' . $mrkt_id;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
      
      $data = json_decode($response, true);
      
      $result = array(
                     'last_trade' => $data["ltp"],
                     '24hr_asset_vol' => $data["volume_by_product"],
                     '24hr_pair_vol' => null // Seems to be an EXACT duplicate of asset volume in MANY cases, skipping to be safe
               	     );
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bitmart' ) {
         
      $url = 'https://api-cloud.bitmart.com/spot/v1/ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data']['tickers'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last_price"],
	                              '24hr_asset_vol' => $val["base_volume_24h"],
	                              '24hr_pair_vol' => $val["quote_volume_24h"]
	                    		  );
	               
	              }
	          
	            }
	          
	          }
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bitmex' || strtolower($sel_exchange) == 'bitmex_u20' || strtolower($sel_exchange) == 'bitmex_z20' ) {
      
      // GET NEWEST DATA SETS (25 one hour buckets, SINCE WE #NEED# THE CURRENT PARTIAL DATA SET, 
      // OTHERWISE WE DON'T GET THE LATEST TRADE VALUE AND CAN'T CALCULATE REAL-TIME VOLUME)
      $url = 'https://www.bitmex.com/api/v1/trade/bucketed?binSize=1h&partial=true&count=25&symbol='.$mrkt_id.'&reverse=true'; // Sort NEWEST first
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
       
      
	         if ( is_array($data) ) {
	      
	             foreach ($data as $key => $val) {
	                
			         // We only want the FIRST data set for trade value
			         if ( !$last_trade && isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
			         $last_trade = $val['close'];
			         $asset_vol = $val['homeNotional'];
			         $pair_vol = $val['foreignNotional'];
			         }
			         elseif ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
			                   
			         $asset_vol = $ct_var->num_to_str($asset_vol + $val['homeNotional']);
			         $pair_vol = $ct_var->num_to_str($pair_vol + $val['foreignNotional']);
			                 
			         // Average of 24 hours, since we are always between 23.5 and 24.5
			         // (least resource-intensive way to get close enough to actual 24 hour volume)
			         // Overwrites until it's the last values
			         $half_oldest_hour_asset_vol = round($val['homeNotional'] / 2);
			         $half_oldest_hour_pair_vol = round($val['foreignNotional'] / 2);
			                 
			         }
	              
	             }
	          
	          
	          $result = array(
	                           'last_trade' => $last_trade,
	                           // Average of 24 hours, since we are always between 23.5 and 24.5
	                           // (least resource-intensive way to get close enough to actual 24 hour volume)
	                           '24hr_asset_vol' => $ct_var->num_to_str($asset_vol - $half_oldest_hour_asset_vol),
	                           '24hr_pair_vol' =>  $ct_var->num_to_str($pair_vol - $half_oldest_hour_pair_vol)
	                    	   );
	      
	      
	         }
          
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bitpanda' ) {
         
      $url = 'https://api.exchange.bitpanda.com/public/v1/market-ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
       
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val['instrument_code']) && $val['instrument_code'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last_price"],
	                              '24hr_asset_vol' => $val["base_volume"],
	                              '24hr_pair_vol' => $val["quote_volume"]
	                     	       );
	     
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'bitso' ) {
      
      $url = 'https://api.bitso.com/v3/ticker/?book='.$mrkt_id;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
      
      $data = json_decode($response, true);
      
      $data = $data['payload'];
      
      $result = array(
                     'last_trade' => $data["last"],
                     '24hr_asset_vol' => $data["volume"],
                     '24hr_pair_vol' => null // Unavailable, set null
               	    );
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bitstamp' ) {
      
      $url = 'https://www.bitstamp.net/api/v2/ticker/' . $mrkt_id;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
        
      $data = json_decode($response, true);
        
      $result = array(
                     'last_trade' => number_format( $data['last'], $ct_conf['gen']['crypto_dec_max'], '.', ''),
                     '24hr_asset_vol' => $data["volume"],
                     '24hr_pair_vol' => null // Unavailable, set null
      	           );
        
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bittrex' || strtolower($sel_exchange) == 'bittrex_global' ) {
      
      $result = array();
         
      $url = 'https://api.bittrex.com/v3/markets/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
	              $result['last_trade'] = $val["lastTradeRate"];
	              }
	          
	            }
	          
	          }
         
         
      usleep(55000); // Wait 0.055 seconds before fetching volume data
         
      // 24 HOUR VOLUME
      $url = 'https://api.bittrex.com/v3/markets/summaries';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
	          if ( is_array($data) ) {
	      
		        foreach ($data as $key => $val) {
		              
			       if ( isset($val['symbol']) && $val['symbol'] == $mrkt_id ) {
			       $result['24hr_asset_vol'] = $val["volume"];
			       $result['24hr_pair_vol'] = $val["quoteVolume"];
			       }
		          
		        }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'btcmarkets' ) {
      
      $url = 'https://api.btcmarkets.net/market/'.$mrkt_id.'/tick';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
    
      $result = array(
                     'last_trade' => $data['lastPrice'],
                     '24hr_asset_vol' => $data["volume24h"],
                     '24hr_pair_vol' => null // Unavailable, set null
                  	 );
       
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'btcturk' ) {
         
      $url = 'https://api.btcturk.com/api/v2/ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val['pair']) && $val['pair'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last"],
	                              '24hr_asset_vol' => $val["volume"],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                    		  );
	               
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'buyucoin' ) {
         
      $url = 'https://api.buyucoin.com/ticker/v1.0/liveData';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val["marketName"]) && $val["marketName"] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["LTRate"],
	                              '24hr_asset_vol' => $val["v24"], 
	                              '24hr_pair_vol' => $val["tp24"] 
	                     		  );
	               
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'bybit' ) {
         
      $url = 'https://api-testnet.bybit.com/v2/public/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['result'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              if ( isset($val["symbol"]) && $val["symbol"] == $mrkt_id ) {
	                   
	                   // If FLAGGED AS A '1000XXXXX' BYBIT MARKET ID, DIVIDE BY 1000
	                   if ( stristr($mrkt_id, '1000') == true ) {
	                   $val["last_price"] = $val["last_price"] / 1000;
	                   }
	               
	              $result = array(
	                              'last_trade' => $val["last_price"],
	                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
	                              '24hr_pair_vol' => $val["volume_24h"] 
	                     		  );
	               
	              }
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'cex' ) {
         
      $url = 'https://cex.io/api/tickers/BTC/USD/USDT/EUR/GBP';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( isset($val["pair"]) && $val["pair"] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last"],
	                              '24hr_asset_vol' => $val["volume"],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     	       );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
    
      elseif ( strtolower($sel_exchange) == 'coinbase' ) {
      
      $url = 'https://api.pro.coinbase.com/products/'.$mrkt_id.'/ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
    
      $result = array(
                     'last_trade' => $data['price'],
                     '24hr_asset_vol' => $data["volume"],
                     '24hr_pair_vol' => null // Unavailable, set null
                  	 );
       
       
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'coindcx' ) {
         
      $url = 'https://public.coindcx.com/exchange/ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( isset($val["market"]) && $val["market"] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last_price"],
	                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
	                              '24hr_pair_vol' => $val["volume"]
	                     		  );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'coinex' ) {
         
      $url = 'https://api.coinex.com/v1/market/ticker/all';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data']['ticker'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( $key == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last"],
	                              '24hr_asset_vol' => $val["vol"],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     		  );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'coinspot' ) {
         
      $url = 'https://www.coinspot.com.au/pubapi/latest';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['prices'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( $key == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last"],
	                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     		  );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'crypto.com' ) {
         
      $url = 'https://api.crypto.com/v2/public/get-ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['result']['data'];
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( isset($val['i']) && $val['i'] == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["a"],
	                              '24hr_asset_vol' => $val["v"],
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     		  );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'gateio' ) {
    
      $url = 'https://api.gateio.ws/api/v4/spot/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["currency_pair"]) && $val["currency_pair"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => $val["base_volume"],
                              '24hr_pair_vol' => $val["quote_volume"]
                              );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'gemini' ) {
      
      $url = 'https://api.gemini.com/v1/pubticker/' . $mrkt_id;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
        
      $data = json_decode($response, true);
        
      $result = array(
                     'last_trade' => $data['last'],
                     '24hr_asset_vol' => $data['volume'][strtoupper($asset_symb)],
                     '24hr_pair_vol' => $data['volume'][strtoupper($pair)]
      	              );
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
      
      elseif ( strtolower($sel_exchange) == 'graviex' ) {
    
      $url = 'https://graviex.net//api/v2/tickers.json';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $unused) {
              
              if ( isset($data[$mrkt_id]) && $data[$mrkt_id] != '' ) {
               
              $result = array(
                              'last_trade' => $data[$mrkt_id]['ticker']['last'],
                              '24hr_asset_vol' => $data[$mrkt_id]['ticker']['vol'],
                              '24hr_pair_vol' => null // Weird pair volume always in BTC according to array keyname, skipping
                     	      );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'hitbtc' ) {
    
      $url = 'https://api.hitbtc.com/api/2/public/ticker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["symbol"]) && $val["symbol"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => $val["volume"],
                              '24hr_pair_vol' => $val["volumeQuote"]
                              );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'huobi' ) {
         
      $url = 'https://api.huobi.pro/market/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['data'];
         
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["symbol"]) && $val["symbol"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["close"],
                              '24hr_asset_vol' => $val["amount"],
                              '24hr_pair_vol' => $val["vol"]
                              );
     
              }
          
            }
          
          }
      
      
      }
     
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'idex' ) {
         
     	$url = 'https://api.idex.market/returnTicker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              // ARRAY KEY SEMANTICS BACKWARDS COMPARED TO OTHER EXCHANGES
                              '24hr_asset_vol' => $val["quoteVolume"],
                              '24hr_pair_vol' => $val["baseVolume"]
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'jupiter_ag' ) {
          
        
            // If not set globally yet (for faster runtime / less API calls),
            // set the $jupiter_ag_pairs var for jupiter_ag API calls
            if ( sizeof($jupiter_ag_pairs) == 0 ) {
                 
        
              foreach ( $ct_conf['assets'] as $markets ) {
              
         	         foreach ( $markets['pair'] as $exchange_pairs ) {
         	            
         		        if ( isset($exchange_pairs['jupiter_ag']) && $exchange_pairs['jupiter_ag'] != '' ) { // In case user messes up Admin Config, this helps
         		        
         		        $jup_pairs = explode('/', $exchange_pairs['jupiter_ag']);
         		        
         		        $jupiter_ag_pairs[ $jup_pairs[1] ] .= $jup_pairs[0] . ',';
         		        
         		        }
         	            
         	         }
                
              }
            
              
              foreach ( $jupiter_ag_pairs as $key => $val ) {
              $jupiter_ag_pairs[$key] = substr($val, 0, -1);
              }
            
            
            }
            
          
      $jup_pairs = explode('/', $mrkt_id);
      
      $url = 'https://price.jup.ag/v4/price?ids=' . $jupiter_ag_pairs[ $jup_pairs[1] ] . '&vsToken=' . $jup_pairs[1];
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
        
      $data = json_decode($response, true);
      
      $data = $data['data'];
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == $jup_pairs[0] ) {
               
              $result = array(
                              'last_trade' => number_format( $data[$key]['price'], $ct_conf['gen']['crypto_dec_max'], '.', ''),
                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
                              '24hr_pair_vol' => null // Unavailable, set null
                    	      );
               
              }
          
            }
          
          }
        
      }
     
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'korbit' ) {
         
      $url = 'https://api.korbit.co.kr/v1/ticker/detailed/all';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => $val["volume"],
                              '24hr_pair_vol' => null // Unavailable, set null
                    	      );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'kraken' ) {
          
        
            // If not set globally yet (for faster runtime / less API calls),
            // set the $kraken_pairs var for kraken API calls
            if ( $kraken_pairs == null ) {
        
              foreach ( $ct_conf['assets'] as $markets ) {
              
    	         foreach ( $markets['pair'] as $exchange_pairs ) {
    	            
    		        if ( isset($exchange_pairs['kraken']) && $exchange_pairs['kraken'] != '' ) { // In case user messes up Admin Config, this helps
    		        $kraken_pairs .= $exchange_pairs['kraken'] . ',';
    		        }
    	            
    	         }
                
              }
    
            $kraken_pairs = substr($kraken_pairs, 0, -1);
            
            }
            
       
      $url = 'https://api.kraken.com/0/public/Ticker?pair=' . $kraken_pairs;
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
      
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == 'result' ) {
              
               foreach ($val as $key2 => $unused) {
                 
                 if ( $key2 == $mrkt_id ) {
                  
                 $result = array(
                                 'last_trade' => $val[$key2]["c"][0],
                                 '24hr_asset_vol' => $val[$key2]["v"][1],
                                 '24hr_pair_vol' => null // Unavailable, set null
                       		     );
                  
                 }
             
               }
            
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'kucoin' ) {
    
      $url = 'https://api.kucoin.com/api/v1/market/allTickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      $data = $data['data']['ticker'];
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["symbol"]) && $val['symbol'] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => $val["vol"],
                              '24hr_pair_vol' => $val["volValue"]
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'liquid' ) {
         
      $url = 'https://api.liquid.com/products';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["currency_pair_code"]) && $val["currency_pair_code"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last_traded_price"],
                              '24hr_asset_vol' => $val["volume_24h"],
                              '24hr_pair_vol' => null // Unavailable, set null
                     	        );
     
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
     // https://github.com/Loopring/protocols/wiki/Loopring-Exchange-Data-API
     
      elseif ( strtolower($sel_exchange) == 'loopring' || strtolower($sel_exchange) == 'loopring_amm' ) {
         
      $url = 'https://api3.loopring.io/api/v3/allTickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
         
	     if ( substr($mrkt_id, 0, 4) == "AMM-" ) {
	     $data = $data['pools'];
	     }
	     else {
	     $data = $data['markets'];
	     }
	             
	      
	     if ( is_array($data) ) {
	      
	         foreach ($data as $key => $val) {
	             
	              if ( $key == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["last_price"],
	                              '24hr_asset_vol' => $val["base_volume"],
	                              '24hr_pair_vol' => $val["quote_volume"]
	                     	       );
	     
	              }
	          
	         }
	          
	     }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'luno' ) {
         
      $url = 'https://api.mybitx.com/api/1/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data['tickers'];
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["pair"]) && $val["pair"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $ct_var->num_to_str($val["last_trade"]), // Handle large / small values better with $ct_var->num_to_str()
                              '24hr_asset_vol' => $val["rolling_24_hour_volume"],
                              '24hr_pair_vol' => null // Unavailable, set null
                     		  );
     
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'okcoin' ) {
      
      $url = 'https://www.okcoin.com/api/spot/v3/instruments/ticker';
        
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
        
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
             
              
              if ( isset($val['instrument_id']) && $val['instrument_id'] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val['last'],
                              '24hr_asset_vol' => $val['base_volume_24h'],
                              '24hr_pair_vol' => $val['quote_volume_24h']
                              );
     
              }
            
          
            }
          
          }
      
        
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'okex' ) {
      
      $url = 'https://www.okx.com/api/v5/market/tickers?instType=SPOT';
      
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
        
      $data = json_decode($response, true);
      
      $data = $data['data'];
       
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val['instId']) && $val['instId'] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
                              '24hr_pair_vol' => $val['volCcy24h']
                     		  );
     
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'poloniex' ) {
    
      $url = 'https://poloniex.com/public?command=returnTicker';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == $mrkt_id ) {
               
              $result = array(
                              'last_trade' =>$val["last"],
                              // ARRAY KEY SEMANTICS BACKWARDS COMPARED TO OTHER EXCHANGES
                              '24hr_asset_vol' => $val["quoteVolume"],
                              '24hr_pair_vol' => $val["baseVolume"]
                     	        );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
    
    
      elseif ( strtolower($sel_exchange) == 'southxchange' ) {
    
      $url = 'https://www.southxchange.com/api/prices';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val["Market"]) && $val["Market"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["Last"],
                              '24hr_asset_vol' => $val["Volume24Hr"],
                              '24hr_pair_vol' => null // Unavailable, set null
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
      
      
      
      elseif ( strtolower($sel_exchange) == 'tradeogre' ) {
    
      $url = 'https://tradeogre.com/api/v1/markets';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val[$mrkt_id]) && $val[$mrkt_id] != '' ) {
               
              $result = array(
                              'last_trade' => $val[$mrkt_id]["price"],
                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
                              '24hr_pair_vol' => $val[$mrkt_id]["volume"]
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'unocoin' ) {
         
      $url = 'https://api.unocoin.com/api/trades/in/all/all';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      
	          if ( is_array($data) ) {
	      
	            foreach ($data as $key => $val) {
	              
	              
	              if ( $key == $mrkt_id ) {
	               
	              $result = array(
	                              'last_trade' => $val["average_price"],
	                              '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
	                              '24hr_pair_vol' => null // Unavailable, set null
	                     		  );
	     
	              }
	            
	          
	            }
	          
	          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'upbit' ) {
          
        
            // If not set globally yet (for faster runtime / less API calls),
            // set the $upbit_pairs var for upbit API calls
            if ( $upbit_pairs == null ) {
                
              foreach ( $ct_conf['assets'] as $markets ) {
              
    	         foreach ( $markets['pair'] as $exchange_pairs ) {
    	            
    		        if ( isset($exchange_pairs['upbit']) && $exchange_pairs['upbit'] != '' ) { // In case user messes up Admin Config, this helps
    		        $upbit_pairs .= $exchange_pairs['upbit'] . ',';
    		        }
    	            
    	         }
                
              }
    
            $upbit_pairs = substr($upbit_pairs, 0, -1);
            
            }
            
    
      $url = 'https://api.upbit.com/v1/ticker?markets=' . $upbit_pairs;
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ( $data as $key => $val ) {
              
              if ( isset($val["market"]) && $val["market"] == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["trade_price"],
                              '24hr_asset_vol' => $val["acc_trade_volume_24h"],
                              '24hr_pair_vol' => null // No 24 hour trade volume going by array keynames, skipping
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'wazirx' ) {
    
      $url = 'https://api.wazirx.com/api/v2/tickers';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( $key == $mrkt_id ) {
               
              $result = array(
                              'last_trade' => $val["last"],
                              '24hr_asset_vol' => $val["volume"],
                              '24hr_pair_vol' => null // Unavailable, set null
                     		  );
               
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'zebpay' ) {
    
      $url = 'https://www.zebapi.com/pro/v1/market';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
      
          if ( is_array($data) ) {
      
            foreach ($data as $key => $val) {
              
              if ( isset($val['pair']) && $val['pair'] == $mrkt_id ) {
                  
                  // Workaround for weird zebpay API bug, where they include a second
                  // array object with same 'pair' property, that's mostly a null data set
                  if ( isset($val["market"]) && $val["market"] > 0 && $zebapi_bug_workaround != true ) {
                  
                  $zebapi_bug_workaround = true;
                   
                  $result = array(
                                  'last_trade' => $val["market"],
                                  '24hr_asset_vol' => $val["volume"],
                                  '24hr_pair_vol' => null // Unavailable, set null
                         		  );
               
                  }
                  
              }
          
            }
          
          }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'misc_assets' || strtolower($sel_exchange) == 'alt_nfts' ) {
      
      // BTC value of 1 unit of the default primary currency
      $currency_to_btc = $ct_var->num_to_str(1 / $sel_opt['sel_btc_prim_currency_val']);	
      
         // BTC pair
         if ( $mrkt_id == 'btc' ) {
         $result = array(
     		            'last_trade' => $currency_to_btc
     		            );
         }
         // All other pair
     	 else {
     		        
         $pair_btc_val = $ct_asset->pair_btc_val($mrkt_id);
     		      
     		      
          	if ( $pair_btc_val == null ) {
          				          	
          	$ct_gen->log(
          				'market_error',
          				'ct_asset->pair_btc_val() returned null',
          				'market_id: ' . $mrkt_id
          				);
          				          
            }
     		      
           
            if ( $ct_var->num_to_str($pair_btc_val) > 0 && $ct_var->num_to_str($currency_to_btc) > 0 ) {
            $calc = ( 1 / $ct_var->num_to_str($pair_btc_val / $currency_to_btc) );
            }
            else {
            $calc = 0;
            }     		      
     
     			      
         $result = array(
     		            'last_trade' => $calc
     		            );
     		                  		
         }
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'btc_nfts' ) {
      
      // BTC value of 1 unit of BTC
      $currency_to_btc = 1;	
      
         // BTC pair
         if ( $mrkt_id == 'btc' ) {
         $result = array(
     		            'last_trade' => $currency_to_btc
     		            );
         }
         // All other pair
         else {
     		        
         $pair_btc_val = $ct_asset->pair_btc_val($mrkt_id);
     		      
     		      
          	if ( $pair_btc_val == null ) {
          				          	
          	$ct_gen->log(
          				'market_error',
          				'ct_asset->pair_btc_val() returned null',
          				'market_id: ' . $mrkt_id
          				);
          				          
            }
     		      
           
            if ( $ct_var->num_to_str($pair_btc_val) > 0 && $ct_var->num_to_str($currency_to_btc) > 0 ) {
            $calc = ( 1 / $ct_var->num_to_str($pair_btc_val / $currency_to_btc) );
            }
            else {
            $calc = 0;
            }     		      
     
     			      
         $result = array(
     		            'last_trade' => $calc
     		            );
     		                  		
         }
      
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'eth_nfts' ) {
      
      // BTC value of 1 unit of ETH
      $currency_to_btc = $ct_asset->pair_btc_val('eth');	
      
         // BTC pair
         if ( $mrkt_id == 'btc' ) {
         $result = array(
     		            'last_trade' => $currency_to_btc
     		            );
         }
         // All other pair
         else {
     		        
         $pair_btc_val = $ct_asset->pair_btc_val($mrkt_id);
     		      
     		      
          	if ( $pair_btc_val == null ) {
          				          	
          	$ct_gen->log(
          				'market_error',
          				'ct_asset->pair_btc_val() returned null',
          				'market_id: ' . $mrkt_id
          				);
          				          
            }
     		      
           
            if ( $ct_var->num_to_str($pair_btc_val) > 0 && $ct_var->num_to_str($currency_to_btc) > 0 ) {
            $calc = ( 1 / $ct_var->num_to_str($pair_btc_val / $currency_to_btc) );
            }
            else {
            $calc = 0;
            }     		      
     
     			      
         $result = array(
     		            'last_trade' => $calc
     		            );
     		                  		
         }
      
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( strtolower($sel_exchange) == 'sol_nfts' ) {
      
      // BTC value of 1 unit of SOL
      $currency_to_btc = $ct_asset->pair_btc_val('sol');	
      
         // BTC pair
         if ( $mrkt_id == 'btc' ) {
         $result = array(
     		            'last_trade' => $currency_to_btc
     		            );
         }
         // All other pair
         else {
     		        
         $pair_btc_val = $ct_asset->pair_btc_val($mrkt_id);
     		      
     		      
          	if ( $pair_btc_val == null ) {
          				          	
          	$ct_gen->log(
          				'market_error',
          				'ct_asset->pair_btc_val() returned null',
          				'market_id: ' . $mrkt_id
          				);
          				          
            }
     		      
           
            if ( $ct_var->num_to_str($pair_btc_val) > 0 && $ct_var->num_to_str($currency_to_btc) > 0 ) {
            $calc = ( 1 / $ct_var->num_to_str($pair_btc_val / $currency_to_btc) );
            }
            else {
            $calc = 0;
            }     		      
     
     			      
         $result = array(
     		            'last_trade' => $calc
     		            );
     		                  		
         }
      
      
      
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
      elseif ( stristr( strtolower($sel_exchange) , 'coingecko_') ) {
          
            
            // If not set globally yet (for faster runtime / less API calls),
            // set the $coingecko_pairs / $coingecko_assets vars for coingecko API calls
            if ( $coingecko_pairs == null || $coingecko_assets == null ) {
        
            $coingecko_pairs = null;
            $coingecko_assets = null;
                
            $check_pairs = array();
            $check_assets = array();
            
                   
                  foreach ( $ct_conf['assets'] as $mrkts_conf ) {
                  
        	         foreach ( $mrkts_conf['pair'] as $pair_conf ) {
                  
            	         foreach ( $pair_conf as $exchange_key => $exchange_val ) {
            	            
            		        if ( stristr($exchange_key, 'coingecko_') != false && trim($exchange_val) != '' ) { // In case user messes up Admin Config, this helps
            		        
                            $paired_conf = explode('_', strtolower($exchange_key) );
                            $paired_conf = $paired_conf[1];
      
            		           if ( !in_array($paired_conf, $check_pairs) ) {
            		           $coingecko_pairs .= $paired_conf . ',';
            		           $check_pairs[] = $paired_conf;
            		           }
      
            		           if ( !in_array($exchange_val, $check_assets) ) {
            		           $coingecko_assets .= $exchange_val . ',';
            		           $check_assets[] = $exchange_val;
            		           }
            		        
            		        }
            	            
            	         }
        	         
        	         }
                    
                  }
            
            
             $coingecko_pairs = substr($coingecko_pairs, 0, -1);
             $coingecko_assets = substr($coingecko_assets, 0, -1);
             
             }
          
	         
      $url = 'https://api.coingecko.com/api/v3/simple/price?ids=' . $coingecko_assets . '&vs_currencies='.$coingecko_pairs.'&include_24hr_vol=true';
         
      $response = @$ct_cache->ext_data('url', $url, $ct_conf['power']['last_trade_cache_time']);
         
      $data = json_decode($response, true);
         
      $data = $data[$mrkt_id];

      $paired_with = explode('_', strtolower($sel_exchange) );
      $paired_with = $paired_with[1];

	         // Use data from coingecko, if API ID / base currency exists
             if ( isset($data[$paired_with]) ) {
	     
	         $result = array(
	                        'last_trade' => $ct_var->num_to_str($data[$paired_with]),
	                        '24hr_asset_vol' => 0, // Unavailable, set 0 to avoid 'price_alert_block_vol_error' supression
	                        '24hr_pair_vol' => $ct_var->num_to_str($data[$paired_with . "_24h_vol"])
	                        );
	                     		  
             }
         
	     
      }
     
     
     
     ////////////////////////////////////////////////////////////////////////////////////////////////
    
    
      if ( strtolower($sel_exchange) != 'misc_assets' && strtolower($sel_exchange) != 'btc_nfts' && strtolower($sel_exchange) != 'eth_nfts' && strtolower($sel_exchange) != 'sol_nfts' && strtolower($sel_exchange) != 'alt_nfts' ) {
        
      // Better large / small number support
      $result['last_trade'] = $ct_var->num_to_str($result['last_trade']);
        
        
            // SET FIRST...emulate pair volume if non-existent
            // If no pair volume is available for this market, emulate it within reason with: asset value * asset volume
    		if ( is_numeric($result['24hr_pair_vol']) != true && is_numeric($result['last_trade']) == true && is_numeric($result['24hr_asset_vol']) == true ) {
            $result['24hr_pair_vol'] = $ct_var->num_to_str($result['last_trade'] * $result['24hr_asset_vol']);
    		}
		      
		      
    		// Set primary currency volume value
    		if ( isset($pair) && $pair == $ct_conf['gen']['btc_prim_currency_pair'] ) {
    		$result['24hr_prim_currency_vol'] = $ct_var->num_to_str($result['24hr_pair_vol']); // Save on runtime, if we don't need to compute the fiat value
    		}
    		else {
    		$result['24hr_prim_currency_vol'] = $ct_var->num_to_str( $ct_asset->prim_currency_trade_vol($asset_symb, $pair, $result['last_trade'], $result['24hr_pair_vol']) );
    		}
        
      
      }
   
      
   // Convert any scientific vals to string (so we can process correctly)
   $result['last_trade'] = ( $result['last_trade'] != null ? $ct_var->num_to_str($result['last_trade']) : null );
   $result['24hr_asset_vol'] = ( $result['24hr_asset_vol'] != null ? $ct_var->num_to_str($result['24hr_asset_vol']) : null );
   $result['24hr_pair_vol'] = ( $result['24hr_pair_vol'] != null ? $ct_var->num_to_str($result['24hr_pair_vol']) : null );
   
   return $result;
   
   }
   

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
      
   
}


// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>