<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */


?>

<div class='max_1200px_wrapper'>
				
				<span class='red countdown_notice'></span>
			
	
	<p style='margin-top: 15px; margin-bottom: 15px;'> &nbsp; </p>		
			
	
	<div class="accordion" id="accordionHelp" style='margin: 20px; margin-top: 35px;'> <!-- Accordion START -->
	
	  
	
	<?php
	$accord_var = 1;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="true" aria-controls="collapse_<?=$accord_var?>">
	          
	          Feature Requests / Reporting Issues / Help
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="collapse show" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	        
			  Web server setup / install (for Server Edition) is available for $30 hourly if needed (see 'Manual Install' section for managed hosting, or try the auto-install bash script for self-hosted). PM me on Twitter / Skype / Telegram @ taoteh1221, or get a hold of me using the below-listed contact methods.<br /><br />
	      
	      
	        <span class='blue'>Have a question, feature you'd like to see added, or an issue to report? You can do that at the following URLs...</span><br /><br />
	        
	        <span class='bitcoin'>Issue Reporting (Features / Issues / Help):</span> <a href='https://github.com/taoteh1221/Open_Crypto_Tracker/issues' target='_blank'>https://github.com/taoteh1221/Open_Crypto_Tracker/issues</a><br /><br />
	        
	        <span class='bitcoin'>Discord:</span> <a href='https://discord.gg/WZVK2nm' target='_blank'>https://discord.gg/WZVK2nm</a><br /><br />
	        
	        <span class='bitcoin'>Telegram:</span> <a href='https://t.me/dragonfrugal' target='_blank'>https://t.me/dragonfrugal</a><br /><br />
	        
	        <span class='bitcoin'>Twitter:</span> <a href='https://twitter.com/taoteh1221' target='_blank'>https://twitter.com/taoteh1221</a><br /><br />
	        
	        <span class='bitcoin'>Private Contact:</span> <a href='https://dragonfrugal.com/contact' target='_blank'>https://dragonfrugal.com/contact</a>
												
<br /><br />

<span class='blue'>Donations support further development...</span> <br /><br />

<span class='bitcoin'>Bitcoin:</span>  3Nw6cvSgnLEFmQ1V4e8RSBG23G7pDjF3hW<br /><br />

<span class='bitcoin'>Ethereum:</span>  0x644343e8D0A4cF33eee3E54fE5d5B8BFD0285EF8<br /><br />

<span class='bitcoin'>Helium:</span>  13xs559435FGkh39qD9kXasaAnB8JRF8KowqPeUmKHWU46VYG1h<br /><br />

<span class='bitcoin'>Solana:</span>  GvX4AU4V9atTBof9dT9oBnLPmPiz3mhoXBdqcxyRuQnU<br /><br />

<span class='bitcoin'>Github Sponsors:</span>  <a href='https://github.com/sponsors/taoteh1221' target='_blank'>https://github.com/sponsors/taoteh1221</a><br /><br />

<span class='bitcoin'>Patreon:</span>   <a href='https://www.patreon.com/dragonfrugal' target='_blank'>https://www.patreon.com/dragonfrugal</a><br /><br />

<span class='bitcoin'>PayPal:</span>    <a href='https://www.paypal.me/dragonfrugal' target='_blank'>https://www.paypal.me/dragonfrugal</a><br /><br />

<span class='bitcoin'>Venmo:</span>    <a href='https://account.venmo.com/u/taoteh1221' target='_blank'>https://account.venmo.com/u/taoteh1221</a><br /><br />
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	<?php
	$accord_var = 'desktop_install';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Setting Up The 'Desktop Edition' <span class='bitcoin'>(runs very easily, like any other normally-downloaded native app)</span>
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">


To install as a normal native app on your laptop / desktop, download the "Desktop Edition" of the app here:
	    <br /><br />
	    
<a href='https://github.com/taoteh1221/Open_Crypto_Tracker/releases' target='_blank' title='Download The Desktop Edition Of This App.'>https://github.com/taoteh1221/Open_Crypto_Tracker/releases</a>

	    <br /><br />

After downloading, unzip the contents of the download to your desktop or other preferred file location (it doesn't matter, put it wherever you want to). Now use your operating system's file browser to enter the app's main directory, and click on "RUN_CRYPTO_TRACKER" to launch the app. <span class='red'>TO USE PRICE CHARTS AND PRICE ALERTS TO EMAIL / TEXT / ALEXA / TELEGRAM, YOU #MUST# LEAVE THE APP RUNNING UNLESS YOU MANUALLY SETUP A CRON JOB! (see: "Setting Up Price Charts And Email / Text / Telegram / Alexa Price Alerts")</span>
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	
	<?php
	$accord_var = 'raspi_install';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
Automatic Setup For 'Server Edition' With Debian / Ubuntu / DietPi OS / RaspberryPi OS / Armbian, On Home / Internal Network <span class='red' style="display: block;">(recommended way to PRIVATELY / CHEAPLY use this app)</span>
	          
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	

	<div align='center'>
	
	<h5><span class='bitcoin'>Recommended MINIMUM system specs:</span> <span class='blue' style="display: block;">1 Gigahertz CPU / 512 Megabytes RAM / HIGH QUALITY 32 Gigabyte MicroSD card</span> <span style="display: block;">(running Nginx or Apache headless with PHP v7.2+)</span></h5>
	    <br />
	 
	 <a href='https://www.raspberrypi.org/products/raspberry-pi-zero-w/' target='_blank' title='Visit the Raspberry Pi Zero W product page.'><img class='image_border' src='templates/interface/media/images/pi-zero.jpg' width='550' alt='' /></a> 
	    <br /><br />
	 
	 <a href='https://www.raspberrypi.org/products/raspberry-pi-zero-w/' target='_blank' title='Visit the Raspberry Pi Zero W product page.'>Compatible With Raspberry Pi Zero W</a>
	 
    
   </div>
    
	    <br /><br />
	      
	       To install / upgrade everything automatically on <a href='https://www.debian.org/download' target='_blank' title='Download Debian operating system for your PC.'>Debian</a> / <a href='https://ubuntu.com/#download' target='_blank' title='Download Ubuntu operating system for your PC.'>Ubuntu</a> / <a href='https://www.raspberrypi.org/products/' target='_blank' title='View RaspberryPi Hardware Products.'>RaspberryPi OS</a> / <a href='https://dietpi.com/docs/hardware/' target='_blank' title='View Hardware Products Supported By DietPi.'>DietPi OS</a> / <a href='https://www.armbian.com/download/' target='_blank' title='Download Armbian operating system for your PC.'>Armbian</a>, copy => paste => run the command below in a terminal program (using the 'Terminal' app in the system menu, or over remote SSH), while logged in AS THE USER THAT WILL RUN THE APP (user must have sudo privileges):
	       

	    <br /><br />
<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>wget --no-cache -O FOLIO-INSTALL.bash https://tinyurl.com/install-crypto-tracker;chmod +x FOLIO-INSTALL.bash;sudo ./FOLIO-INSTALL.bash</code></pre>


	    <br /><br />

Follow the prompts. This automated script gives you the options to: install / uninstall a PHP web server automatically, download / install / configure / uninstall the latest version of the Open Crypto Tracker app automatically, setup a cron job automatically (for price alerts / price charts), and setup SSH (to update / install web site files remotely to the web server via SFTP) automatically. 
	    <br /><br />

<span class='bitcoin'>When the auto-install is completed, it will display addresses / logins to access the app (write these down / save them for future use).</span>

	    <br /><br />
SEE <a href='https://github.com/taoteh1221/Open_Crypto_Tracker/tree/main/DOCUMENTATION-ETC/RASPBERRY-PI' target='_blank'>DOCUMENTATION-ETC/RASPBERRY-PI</a> for additional information on securing and setting up Raspberry Pi OS (disabling bluetooth, firewall setup, remote login, hostname, etc). 
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	<?php
	$accord_var = 'website_install';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Installing On A Website / Manual Installation <span class='bitcoin'>('Server Edition')</span>
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	      
	        
	        Just upload this app's files to your PHP-based web server (with an FTP client like <a href='https://filezilla-project.org/download.php?type=client' target='_blank'>FileZilla</a>) and you should be all set, unless your host is a strict setup related to file writing permissions, in which case the 'cache' directory permissions should be set to '770' chmod on unix / linux systems (or 'readable / writable' on windows systems). 
	    <br /><br />
	        
	        Your web host must have CURL modules activated on your HTTP server. Most web hosting companies provide this "out-of-the-box" already. This app will detect whether or not CURL is setup on your website server (and also alert you to any other missing required system components / configurations). 
	    <br /><br />

WINDOWS 10 USERS WHO ARE USING XAMPP WILL NEED TO ENABLE GD FOR PHP (FOR THE ADMIN LOGIN CAPTCHA SECURITY) BEFORE USING THIS APP. PLEASE SEE THE SCREENSHOT LOCATED AT <a href='https://raw.githubusercontent.com/taoteh1221/Open_Crypto_Tracker/main/DOCUMENTATION-ETC/XAMPP-ENABLE-GD.png' target='_blank'>/DOCUMENTATION-ETC/XAMPP-ENABLE-GD.png</a> FOR A VISUAL ON SETTING THIS UP EASILY.<br /><br />

See "<span class='bitcoin'>Setting Up Price Charts And Email / Text / Telegram / Alexa Price Alerts</span>"</a>, for how to setup a cron job for additional features. 
	        
	      </div>
	    </div>
	  </div>
	  
	  
	  
	  
	  
	
	
	<?php
	$accord_var = 3;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">

Setting Up Price Charts And Email / Text / Telegram / Alexa Price Alerts
	          
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
          <span class='red'>IMPORTANT NOTES: THIS IS FOR 'SERVER EDITION' ONLY, UNLESS YOU DISABLE 'desktop_cron_interval' IN THE POWER USER CONFIG IN THE 'DESKTOP EDITION'...IN WHICH CASE READ THE MANUAL CRON JOB INSTALL SECTIONS BELOW THAT ARE RELEVANT TO YOUR OPERATING SYSTEM.</span>
	    <br /><br />

	      You can setup price charts or price alerts in your app install. Price alerts can be sent to email, mobile phone text, Telegram, and Alexa notifications. You will be alerted when the [configured default primary currency] price of an asset goes up or down a certain percent or more (whatever percent you choose in the settings), for specific exchange / base pair combinations for that asset. You can even setup alerts and charts for multiple exchanges / base pairs for the same asset.
	    <br /><br />
	    
Running price charts or price alerts requires setting up a cron job or scheduled task on the Debian / Ubuntu / DietPi OS / RaspberryPi OS / Armbian / Windows 10 machine or website server (this is automated for Debian / Ubuntu / DietPi OS / RaspberryPi OS / Armbian users using the automated FOLIO-INSTALL.bash script / Windows 10 users who run the ADD-WIN10-SCHEDULER-JOB.bat file), otherwise charts / alerts will not work. Also see the related settings in Admin Config for charts / alerts. 
	    <br /><br />

Once a cron job or scheduled task is setup ON YOUR APP SERVER, there is no need to keep your PC / Laptop turned on. The price charts and price alerts run automatically from your Open Crypto Tracker app server installation. If you encounter errors or the charts / alerts don't work during setup, check the error logs file at /cache/logs/error.log for errors in your configuration setup. Basic checks are performed and errors are reported there, and on the Settings page. 
	    <br /><br />

If you decide to turn on cron job / scheduled task based features (chart data backups, new RSS news feed entries emails, error log emails / etc), then the file cron.php (located in the primary directory of this app) must be setup as a cron job or scheduled task on your Debian / Ubuntu / DietPi OS / RaspberryPi OS / Armbian / Windows 10 / website server device. 
	    <br /><br />

As mentioned previously, if you run the automated setup / install script for Debian / Ubuntu / DietPi OS / RaspberryPi OS / Armbian / Windows 10 devices on home / internal networks, automatic cron job / scheduled task setup is offered as an option during this process. If you are using a full stack website host for hosting a TLD website domain name remotely, consult your web server host's documentation or help desk for their particular method of setting up a cron job. 
	    <br /><br />

Note that you should have the cron job run every 5, 10, 15, 20, or 30 minutes 24/7, based on how often you want chart data points / alerts / any other cron based features to run. Setting up the cron job to run every 20 minutes is the RECOMMENDED lowest time interval. IF SET BELOW 20 MINUTES, light chart disk writes may be excessive for lower end hardware (Raspberry PI MicroSD cards etc). IF SET #VERY LOW# (5 / 10 minutes), the free exchange APIs may throttle / block your data requests temporarily on occasion for requesting data too frequently (negatively affecting your alerts / charts). 
	    <br /><br />

FOR WINDOWS 10 USERS, just click / run the file 'ADD-WIN10-SCHEDULER-JOB.bat' found in the main directory of the app, follow the prompts, and everything will be automatically setup for you. As long as you login into your Windows account after system startup, the scheduled task will run until your computer is shut off OR you logout of that user account.<br /><br />

FOR LINUX / MAC USERS, here is an example cron job command line for reference below (NOT including any cron parameters your host interface may require), to setup as the "command" within a cron job. Replace system paths in the example with the correct ones for your server (TIP - A very common path to PHP on a server is /usr/bin/php):
	    <br /><br />
	    
<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>/path/to/php -q /home/username/path/to/website/this_app/cron.php</code></pre>


	    <br /><br />

Here is another example of a COMPLETE cron command that can be added by creating the following file (you'll need sudo/root permissions): /etc/cron.d/cryptocoin on a linux-based machine with systemd (to run every 20 minutes 24/7)...play it safe and add a newline after it as well if you install examples like these:
	    <br /><br />

	    
<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>*/20 * * * * WEBSITE_USERNAME_GOES_HERE /usr/bin/php -q /var/www/html/cron.php > /dev/null 2>&1</code></pre>


	    <br /><br />

If your system DOES NOT have the directory /etc/cron.d/ on it, then NEARLY the same format (minus the username) can be installed via the legacy 'crontab -e' command (YOU MUST BE logged in as the user you want running the cron job):
	    <br /><br />

	    
<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>*/20 * * * * /usr/bin/php -q /var/www/html/cron.php > /dev/null 2>&1</code></pre>



	    <br /><br />
<span class='bitcoin'>Important Cron Job Notes:</span> 
	    <br />

MAKE SURE YOU ONLY USE EITHER /etc/cron.d/, or 'crontab -e', NOT BOTH...ANY OLD DUPLICATE CRONTAB ENTRIES WILL RUN YOUR CRON JOB TOO OFTEN. If everything is setup properly, and the cron job still does NOT run, your particular server may require the cron.php file permissions to be set as 'executable' ('750' chmod on unix / linux systems) to allow running it.
	        
	      </div>
	    </div>
	  </div>
	  
	  
	  
	
	
	<?php
	$accord_var = 6;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Adding Your Own Coins
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	      
	       <span class='red'>Important Note:</span> <span class='bitcoin'>In the v6 release (Coming Soon™), doing this manually in a text editor won't be necassary. You will be able to do it in the <span class='blue'>"Admin Config => Portfolio Assets"</span> interface much easier.</span>
	    <br /><br />

Below is an example for editing your assets / markets into the portfolio assets in the file config.php (located in the primary directory of this app), in the PORTFOLIO ASSETS section. It's very quick / easy to do (after you get the hang of it, lol). Also see the text file <a href='https://raw.githubusercontent.com/taoteh1221/Open_Crypto_Tracker/main/DOCUMENTATION-ETC/CONFIG-EXAMPLE.txt' target='_blank'>DOCUMENTATION-ETC/CONFIG-EXAMPLE.txt</a>, for a pre-configured set of default settings and example assets / markets. 

	    <br /><br />

Contact any supported exchange's help desk if you are unaware of the correct formatting of the trading pair naming you are adding in the configuration file (examples: Kraken has arbitrary Xs inserted in SOME older pair names, HitBTC sometimes has tether pairs without the "T" in the symbol name).

	    <br /><br />


Support for over 80 trading pairs (country fiat currency or secondary crypto, contact me to request more): 
	    <br /><br />

<span class='blue'>AED / ARS / AUD / BAM / BDT / BOB / BRL / BTC / BWP / BYN / CAD / CHF / CLP / CNY / COP / CRC / CZK / DAI / DKK / DOP / EGP / ETH / EUR / GBP / GEL / GHS / GTQ / HKD / HUF / IDR / ILS / INR / IRR / JMD / JOD / JPY / KES / KRW / KWD / KZT / LKR / MAD / MKR / MUR / MWK / MXN / MYR / NGN / NIS / NOK / NZD / PAB / PEN / PHP / PKR / PLN / PYG / QAR / RON / RSD / RUB / RWF / SAMO / SAR / SEK / SGD / SLC / SOL / THB / TRY / TUSD / TWD / TZS / UAH / UGX / UNI / USD / USDC / USDT / UYU / VES / VND / XAF / XOF / ZAR / ZMW</span>

	    <br /><br />

Support for over 40 exchanges (contact me to request more): 
	    <br /><br />

<span class='blue'>alphavantage_stock binance / binance_us / bit2c / bitbns / bitfinex / bitflyer / bitmart / bitmex / bitmex_u20 / bitmex_z20 / bitpanda / bitso / bitstamp / bittrex / bittrex_global / btcmarkets / btcturk / buyucoin / bybit / cex / coinbase / coindcx / coinex / coingecko_btc / coingecko_eth / coingecko_eur / coingecko_gbp / coingecko_usd / coinspot / crypto.com / ethfinex / gateio / gemini / hitbtc / hotbit / huobi / jupiter_ag / korbit / kraken / kucoin / liquid / localbitcoins / localbitcoins / loopring_amm / luno / okcoin / okex / poloniex / southxchange / unocoin / upbit / wazirx / zebpay</span>
	    <br /><br />


Nearly Unlimited Assets Supported (whatever assets exist on supported exchanges).
	    <br /><br />


Ethereum ICO subtoken support (pre-exchange listing) has been built in (values are static ICO values in ETH).
	    <br /><br />
 

<span class='bitcoin'>USAGE (ADDING / UPDATING COINS):</span>
	    <br /><br />
 
 
<pre class='rounded'><code class='hide-x-scroll less' style='width: 100%; height: 750px;'>
            // UPPERCASE_COIN_TICKER_HERE
            'UPPERCASE_COIN_TICKER_HERE' => array(
                
                'name' => 'COIN_NAME_HERE',
                // Website slug (URL data) on coinmarketcap / coingecko, leave blank if not listed there
                'mcap_slug' => 'WEBSITE_SLUG_HERE', 
                // MARKET IDS ARE CASE-SENSITIVE!
                'pair' => array(
                            
                            
                     	'lowercase_pair_abrv' => array(
                                  'lowercase_exchange1' => 'MARKETIDHERE',
                                  'lowercase_exchange2' => 'ASSET/PAIR',
                                  'lowercase_exchange3' => 'ASSET-PAIR',
                                  'lowercase_exchange4' => 'ASSET_PAIR',
                                  'lowercase_exchange5' => 'ASSETPAIR',
                                  // GENERIC PAIR PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION) 
                                  // LOWERCASE_PAIR_ABRV MUST BE SUPPORTED BY COINGECKO'S 'vs_currencies' API PARAMETER!
                                  'coingecko_LOWERCASE_PAIR_ABRV' => 'coingecko_api_id_here',
                                  ),
                                            
                                            
                     	'eth' => array(
                                  'lowercase_exchange1' => 'MARKETIDHERE',
                                  'lowercase_exchange2' => 'ASSET/ETH',
                                  'lowercase_exchange3' => 'ASSET-ETH',
                                  'lowercase_exchange4' => 'ASSET_ETH',
                                  'lowercase_exchange5' => 'ASSETETH',
                                  // ETH ICOs...ETHSUBTOKENNAME MUST be defined in 'eth_erc20_icos' (Admin Config POWER USER section)
                                  'ico_erc20_value' => 'ETHSUBTOKENNAME', 
                                  // GENERIC ETH PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION)
                                  'coingecko_eth' => 'coingecko_api_id_here',
                                  ),

                                                    
                        'btc' => array(
                                  // GENERIC BTC PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE SET COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION) 
                                  'coingecko_btc' => 'coingecko_api_id_here',
                                  ),

                                                    
                        'usd' => array(
                                  // GENERIC USD PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION) 
                                  'coingecko_usd' => 'coingecko_api_id_here',
                                  ),

                                                    
                        'eur' => array(
                                  // GENERIC EUR PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION) 
                                  'coingecko_eur' => 'coingecko_api_id_here',
                                  ),

                                                    
                        'gbp' => array(
                                  // GENERIC GBP PRICE (IF NO EXHANGE APIs AVAILABLE)
                                  // USE COINGECKO'S API ID FOR THIS ASSET (SEE COINGECKO ASSET PAGE'S INFO SECTION) 
                                  'coingecko_gbp' => 'coingecko_api_id_here',
                                  ),

                                            
                ) // pair END
            	   
            ), // Asset END
 
 
 
            // UPPERCASE_STOCK_TICKER_HERESTOCK
            // (*ALWAYS* APPEND WORD "STOCK" TO THE TICKER HERE, to designate as a stock [NOT crypto / fiat])
            'UPPERCASE_STOCK_TICKER_HERESTOCK' => array(
                        
                'name' => 'STOCK_NAME_HERE',
                // Website slug (URL data) on Google Finance, leave blank if not listed there
                'mcap_slug' => 'UPPERCASE_STOCK_TICKER_HERE:EXCHANGE_NAME_HERE', 
                // MARKET IDS ARE CASE-SENSITIVE!
                'pair' => array(

                        
                        'usd' => array(
                                 'alphavantage_stock' => 'ALPHAVANTAGE_TICKER_ID_HERE',
                                       ),
                                       
                                       
                /*
                ///////////////////////////////////////////////////
                'ALPHAVANTAGE_TICKER_ID_HERE' EXAMPLES FOR STOCKS...
                (SEE EXAMPLES IN CONFIG.PHP FOR MORE DETAILS ON ADDING STOCKS)
                ///////////////////////////////////////////////////
                
                IBM (United States):
                IBM
                
                Tesco PLC (UK - London Stock Exchange):
                TSCO.LON
                
                Shopify Inc (Canada - Toronto Stock Exchange):
                SHOP.TR
                
                GreenPower Motor Company Inc (Canada - Toronto Venture Exchange):
                GPV.TRV
                
                Daimler Truck Holding AG (Germany - XETRA):
                DTG.DEX
                
                Reliance Industries Limited (India - BSE):
                RELIANCE.BSE
                
                SAIC Motor Corporation (China - Shanghai Stock Exchange):
                600104.SHH
                
                China Vanke Company Ltd (China - Shenzhen Stock Exchange):
                000002.SHZ
                
                ///////////////////////////////////////////////////
                */

                                                    
                ) // pair END
                        
            ), // Asset END
</code></pre>
      
	    <br /><br />
 
    
 SEE <a href='https://raw.githubusercontent.com/taoteh1221/Open_Crypto_Tracker/main/DOCUMENTATION-ETC/CONFIG-EXAMPLE.txt' target='_blank'>DOCUMENTATION-ETC/CONFIG-EXAMPLE.txt</a> FOR A FULL EXAMPLE OF THE DEFAULT CONFIGURATION (ESPECIALLY IF YOU MESS UP config.php, lol)
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	  
	
	
	<?php
	$accord_var = 2;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Layout / Functions / Assets Not Running Properly, After Reconfiguring Or Upgrading
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	      
	        If the portfolio assets settings are re-configured or re-ordered in Admin Config, reload / refresh the page before updating any coin values, or the submission form may not be configured properly and may not submit or display data correctly. Also, you may need to uncheck "Use cookies to save data" on the Settings page, to temporarily clear out old cookie data that may conflict with the new configuration...then you can re-enable cookies again afterwards. 
	    <br /><br />
	    If you recently upgraded to a newer version of this app, and layout or features don't work properly anymore, you may need to clear your browser cache (temporary files) and restart you browser / refresh the page afterwards. This will assure your browser is loading any newly-updated layout styling or javascript-based features.
	    <br /><br />
	    If your problems still persist even after clearing your browser cache (temporary files) and restarting your browser, your config.php setup may be corrupt IF YOU EDITED IT BY HAND. If you did edit it by hand, try backing up you old config.php file, and replacing it with the default config.php file included with the latest release. This will ensure your configuration setup is not corrupt from messed up file formatting.
	    <br /><br />
	    If none of the above solutions work, your last resort (before contacting me for support) is to wipe out all data in your cache directory folder within the app. THIS WILL ERASE YOUR CHART DATA, SO YOU MAY WANT TO BE SURE YOU HAVE A BACKUP FIRST. After your chart data is backed up, delete the folder named 'cache' in the main directory of this app. Reloading the app web page should re-create the cache folder, with new / clean cache files.
	    <br /><br />
	    If you are still having issues after trying everything, file an issue here at the github project account, and I will help you troubleshoot the problems: <a href='https://github.com/taoteh1221/Open_Crypto_Tracker/issues' target='_blank'>https://github.com/taoteh1221/Open_Crypto_Tracker/issues</a>
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	<?php
	$accord_var = 5;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Coinmarketcap.com / Coingecko.com Data Not Available For An Asset
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	       
	        Either the asset has not been added to <a href='https://coinmarketcap.com' target='_blank'>Coinmarketcap.com</a> or <a href='https://Coingecko.com' target='_blank'>Coingecko.com</a> yet, you forgot to add the URL slug in it's config section, or you need to increase the number of rankings to fetch in Admin Config in the POWER USER section (300 rankings is the safe maximum to avoid getting your API requests throttled / blocked). 
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	<?php
	$accord_var = 7;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          SMTP Email Sending Doesn't Work
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	       
	        If you have enabled SMTP emailing (to send emails) but it doesn't work, check the error logs files at /cache/logs/error.log and /cache/logs/smtp_error.log for error responses from the SMTP server connection attempt(s). 
	    <br /><br />
	        
	        If you are sure your username / password / host:port setup are valid, try disabling SMTP email sending by blanking out your username / password / host:port (in the Admin Config COMMUNICATIONS section), and see if PHP's built-in mail function sends emails OK (no setup required, other than SMTP settings must be blanked out). 
	        
	    <br /><br />
<span class='bitcoin'>Important Note:</span> 
	    <br />

SMTP email sending is REQUIRED if you are running this app on a home network, or if reverse DNS hasn't been properly setup for the TLD domain hosted on this device (servers receiving email from this machine would likely blackhole it, or mark it as junk email).
	        
	        
	      </div>
	    </div>
	  </div>
	  
	  
	
	
	<?php
	$accord_var = 8;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Page Loads Slowly Or Throws Errors With Proxies Enabled
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	        If page loads are sluggish or throw API connection errors without clearing up, and you have enabled proxy ip addresses, check the error logs file at /cache/logs/error.log for error responses from the proxy server connection attempt(s). If there are no errors log entries related to the issue that help diagnose the problem, disable using proxies (in the Admin Config PROXY section) and try loading the web page again.
	    <br /><br />
	      If it is a bad or misconfigured proxy setup causing the issue, and everything runs great after disabling proxies, you probably have either (a) a bad proxy or proxy configuration, or (b) an API server / endpoint address is not responding properly when routed through proxies (example: HTTP used instead of HTTPS can cause this error). <i>If you are absolutely sure your proxy setup is ok</i>, and that an API connection built-in to this app is the issue, please <a href='https://github.com/taoteh1221/Open_Crypto_Tracker/issues' target='_blank'>report it</a>. 
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 9;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Backup Archives Don't Work
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	        This app will automatically detect and alert you if your system doesn't support zip file creating or secure random number generation, which are both used in creating the zip archive backups. So if you have issues with your backup archives working, it's most likely related to file / folder permissions. Make sure the /cache/secured/backups/ directory access permissions are set to readable and writable. This assures the ZIP archive has permission to be created in this directory.
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 10;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Write Errors In Error Log For Charts / Other Data
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
If you are getting a lot of messages in the error logs like "file_write_error: File write failed for file X", you may need to free up disk space quota on your device, OR change directory permissions on your /cache/ folder. Check to make sure you have not used up all your ALLOWED disk space quota, AND that your /cache/ folder permissions are readable / writable (770 on unix / linux systems).
<br /><br />
If you already have plenty of disk space quota freed up / your cache folder permissions are readable / writable, and you still have file write issues on linux-based operating systems, you MAY need to setup a higher "open files" limit for your website user account. If you have shell access you can login and run this command to check your current limits:
<br /><br />
<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>ulimit -n</code></pre>

<br /><br />
If it's a low number like 1024, this MAY be the cause of your file write error issue (especially if you run multiple web apps that write a lot of data on the same account). If you are running a dedicated or VPS server, you can easily change this limit. 
<br /><br />
Running a google search for "set permanently ulimit -n linux", you'll find tons of articles on permanently upping your user's open files limit:
<br /><br />
<a href='https://www.google.com/search?q=set+permanently+ulimit+-n+linux' target='_blank'>https://www.google.com/search?q=set+permanently+ulimit+-n+linux</a>
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 11;
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Partial API Data Failure, When Running Behind Slow Internet Connections
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	        If you installed this application on a device on your home network, or on any other network WITH A SLOW INTERNET CONNECTION, you may need to increase the default timeout for retrieving API data IF YOU #FREQUENTLY# RECEIVE #PARTIAL# API DATA IN THE APP FOR SOME API DATA SETS (the error logs will alert you if this is happening, so check there). 
<br /><br />
	        
	        To adjust the API timeout, go to the Admin Config POWER USER section. Adjust the 'remote_api_timeout' setting much higher, save the setup in the app, and run the app again to see if this fixes the issue. Adjust higher again if the issue still occurs frequently. DON'T SET 'remote_api_timeout' TOO HIGH though, or any unresponsive connections may cause the app to take a very long time to load / reload.
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 'os_stability_issues';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Data Errors, Data Not Updating
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	        Restart the device running this app. If this fixes the problem, you may have crond / systemd crashes ocurring on your system. Make sure you are using a WELL-MAINTAINED version of a debian-based operating system for maximum compatibility with this app (Ubuntu or Raspberry Pi OS are VERY stable an reliable).
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 'php_session_issues';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Server Edition Error: "Captcha image code was not correct"
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	        If you cannot register a new admin user during a new installation of the SERVER EDITION of this app, because you ALWAYS get the error alert "Captcha image code was not correct" NO MATTER WHAT YOU DO, the issue is most-likely an error in the way you web host provider configured the directory for saving PHP SESSION DATA FILES.
<br /><br /> 

Luckily EVEN ON SHARED HOSTING some web host companies allow you to set the PHP sessions directory location. See the screenshot in <a href='https://raw.githubusercontent.com/taoteh1221/Open_Crypto_Tracker/main/DOCUMENTATION-ETC/PHP-SESSIONS-DIRECTORY-SETTING.png' target='_blank'>/DOCUMENTATION-ETC/PHP-SESSIONS-DIRECTORY-SETTING.png</a> in the main directory of this app, for details on using your own directory (AFTER YOU CREATE IT IN A FILE MANAGER) on the correct php.ini setting.
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 'shared_library_issues';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          LINUX Desktop Edition Error: "CGI program sent malformed or too big"
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	       If you are using the LINUX Desktop Edition, and you get an error at startup like "CGI program sent malformed or too big", you probably need to compile a custom "php-cgi" binary file on the system you are using, and replace the "php-cgi-custom" binary in the Desktop Edition main folder. Sometimes compiled PHP binaries aren't very portable between different linux systems. To see if this is really the problem by command-line, open a terminal and use the "cd" (change directory) command to go to the main directory of the Desktop Edition, and then type this command:
	    <br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>./php-cgi-custom INSTALL_CRYPTO_TRACKER_HERE/index.php</code></pre>
	    <br /><br />

If you see an error like this below, you system is NOT compatible with the included "php-cgi-custom" PHP binary, and you'll need to build a new one for your system:
	    <br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>./php-cgi-custom: error while loading shared libraries: XXXXX.so.X: cannot open shared object file: No such file or directory</code></pre>
	    <br /><br />

Try running the script "BUILD-PHP-FOR-LINUX-DESKTOP.bash" in the Desktop Edition main folder, which should fix things automatically for you. Just make sure it's file permissions are set to "executable" (chmod +x, OR chmod 755 should do that). 
	    <br /><br />

Open a terminal and use the "cd" (change directory) command to go to the main directory of the Desktop Edition, and then type this command:
	    <br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>./BUILD-PHP-FOR-LINUX-DESKTOP.bash</code></pre>
	    <br /><br />

If this automated script gives you issues, see manual PHP build instructions below...
	    <br /><br />

Documentation for manually building custom PHP binaries on linux can be found here (as well as the source code to download to build it with):
	    <br /><br />

<a href='https://github.com/php/php-src/blob/master/README.md' target='_blank'>https://github.com/php/php-src/blob/master/README.md</a>
	    <br /><br />

Here is the SPECIFIC "./configure" command (mentioned in the above documentation link) you will need to build PHP with the REQUIRED extensions that the Desktop Edition of this crypto tracker app NEEDS:
	    <br /><br />

<pre class='rounded'><code class='hide-x-scroll less' style='width: 100%; height: 500px;'>./configure \
  --enable-bcmath \
  --enable-gd \
  --enable-calendar \
  --enable-dba \
  --enable-exif \
  --enable-ftp \
  --enable-fpm \
  --enable-mbstring \
  --enable-shmop \
  --enable-sigchild \
  --enable-soap \
  --enable-sockets \
  --enable-sysvmsg \
  --with-libdir=lib64 \
  --with-zip \
  --with-bz2 \
  --with-curl \
  --with-gettext \
  --with-openssl \
  --with-pdo-mysql \
  --with-zlib \
  --with-libxml \
  --with-freetype \
  --prefix=$HOME/customphp</code></pre>
	    <br /><br />
  
After using the above configuration, and then running "make", when you then run "make install" AFTERWARDS, your custom PHP binaries with be installed to a new directory in your home folder called "customphp". Inside this folder you will find a subdirectory named "bin". Inside this subdirectory you'll find the custom PHP binary named "php-cgi". Copy this file "php-cgi" over into the main directory of your linux Desktop Edition of the crypto tracker app. Now delete the old "php-cgi-custom" file in there, and rename the new "php-cgi" file to be named "php-cgi-custom" instead. The linux Desktop Edition of this crypto tracker app should now work fine, if it was indeed a shared library problem.
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 'custom_plugins';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          Creating A Custom Plugin For This App
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      

<span class='bitcoin'>IMPORTANT NOTICE:</span> PLUGINS *MAY REQUIRE* A CRON JOB (OR SCHEDULED TASK) RUNNING ON YOUR WEB SERVER (see <a href='README.txt' target='_blank'>README.txt</a> for cron job setup information).
<br /><br />


Take advantage of this app's built-in functions / classes, and your config settings (alert comm channels setup, etc) to create your own custom plugins WITH MINIMAL CODING REQUIRED, to add features to this app.
<br /><br />


<span class='blue'>STEPS TO CREATE YOUR OWN PLUGIN...</span>
<br /><br />


<span class='blue'>1)</span> Create a new subdirectory inside the main /plugins/ directory of this app, and name it after your plugin name.
<br /><br />

Example: "/plugins/my-app-plugin/" (must be lowercase)
<br /><br /><br />



<span class='blue'>2)</span> Create a new subdirectory inside the new plugin directory created in step #1, named "plug-lib".
<br /><br />

Example: "/plugins/my-app-plugin/plug-lib/" (must be lowercase)
<br /><br /><br />



<span class='blue'>3)</span> OPTIONALLY, create a new subdirectory inside the new plugin directory created in step #1, named "plug-assets".
<br /><br />

Example: "/plugins/my-app-plugin/plug-assets/" (must be lowercase)
<br /><br />

THIS IS #REQUIRED TO BYPASS THE USUAL SECURITY# OF OTHER-NAMED DIRECTORIES, SO IMAGES / JAVASCRIPT / CSS / ETC CAN BE LOADED #ONLY FROM HERE#...OTHERWISE ANY DIFFERENT-NAMED ASSETS DIRECTORY #WILL BE DENIED ACCESS# OVER HTTP / HTTPS!
<br /><br /><br />



<span class='blue'>4)</span> Create a blank INIT file (plugin runtime starts here) inside the new "plug-lib" directory created in step #2, with the name "plug-init.php".
<br /><br />

Example: "/plugins/my-app-plugin/plug-lib/plug-init.php" (must be lowercase)
<br /><br /><br />



<span class='blue'>5)</span> OPTIONALLY create a blank CLASS file (custom class logic goes here), inside the new "plug-lib" directory created in step #2, with the name "plug-class.php".
<br /><br />

Example: "/plugins/my-app-plugin/plug-lib/plug-class.php" (must be lowercase)
<br /><br /><br />



<span class='blue'>6)</span> All ADDED LOGIC in this "plug-class.php" file is AUTO-INCLUDED IN A NEW CLASS NAMED "$plug_class[$this_plug]" USING THIS FORMAT BELOW...
<br /><br />


CREATES THIS PLUGIN'S CLASS OBJECT DYNAMICALLY AS:
<br /><br />

<pre class='rounded'><code class='hide-x-scroll less' style='width: auto; height: auto;'>
$plug_class[$this_plug] = new class() {

var my_var_1 = 'Testing 123';
var my_var_2 = 'World';

	function my_function_1($var) {
	return ' Hello ' . $var . '! ';
	}
				
};
// END class

</code></pre>

<br /><br /><br />



Examples of calling plugin class objects (ANYWHERE FROM WITHIN "plug-init.php" ONWARDS):
<br /><br />

<pre class='rounded'><code class='hide-x-scroll less' style='width: auto; height: auto;'>
echo $plug_class[$this_plug]->my_var_1;

echo $plug_class[$this_plug]->my_function_1( $plug_class[$this_plug]->my_var_2 );

echo $plug_class[$this_plug]->my_function_1('Kitty');

</code></pre>

<br /><br /><br />



<span class='blue'>7)</span> Create a blank CONFIG file (plugin configs go here) inside the new plugin directory created in step #1, with the name "plug-conf.php".
<br /><br />

Example: "/plugins/my-app-plugin/plug-conf.php" (must be lowercase)
<br /><br /><br />



<span class='blue'>8)</span> All "plug-conf.php" PLUGIN CONFIG settings MUST BE INSIDE THE ARRAY "$plug_conf[$this_plug]" (sub-arrays are allowed).
<br /><br />

<pre class='rounded'><code class='hide-x-scroll less' style='width: auto; height: auto;'>
$plug_conf[$this_plug]['SETTING_NAME_HERE'] = 'mysetting';


$plug_conf[$this_plug]['SETTING_NAME_HERE'] = array('mysetting1', 'mysetting2');

</code></pre>

<br /><br /><br />



<span class='blue'>9)</span> The "plug-conf.php" PLUGIN CONFIG SETTING 'runtime_mode' IS MANDATORY, to determine WHEN the plugin should run (during cron jobs / user interface loading / all runtimes / etc).
<br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>$plug_conf[$this_plug]['runtime_mode'] = 'cron'; // 'cron', 'ui', 'all'</code></pre>
<br /><br /><br />



<span class='blue'>10)</span> The "plug-conf.php" PLUGIN CONFIG SETTING 'ui_location' IS OPTIONAL, to determine WHERE the plugin should run (on the tools page, in the 'more stats' section, etc...defaults to 'tools' if not set).
<br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>$plug_conf[$this_plug]['ui_location'] = 'tools'; // 'tools', 'more_stats'</code></pre>
<br /><br /><br />



<span class='blue'>11)</span> The "plug-conf.php" PLUGIN CONFIG SETTING 'ui_name' IS OPTIONAL, to determine THE NAME the plugin should show as to end-users (defaults to $this_plug if not set).
<br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>$plug_conf[$this_plug]['ui_name'] = 'My Plugin Name';</code></pre>
<br /><br /><br />



<span class='blue'>12)</span> We are now done setting up plugin files, now we need to activate the new plugin. IN THE MAIN APP "Admin Config" POWER USER section. Locate the configuration variable named: 'activate_plugins'
<br /><br />


<span class='blue'>13)</span> To add / activate your new plugin, add your plugin MAIN FOLDER name (example: 'my-app-plugin') as a new value within 'activate_plugins', and set to 'on'...ALSO INCLUDE A COMMA AT THE END.
<br /><br />

<pre class='rounded' style='display: inline-block;<?=( $ct_gen->is_msie() == false ? ' padding-top: 1em !important;' : '' )?>'><code class='hide-x-scroll less' style='white-space: nowrap; width: auto; display: inline-block;'>'my-app-plugin' => 'on',</code></pre>
<br /><br /><br />



Now you are ready to write your custom plugin code in PHP, inside the new plugin files you created. See the example code in the included plugins inside the /plugins/ directory, for useful code snippets to speed up your plugin development.
<br /><br />


<span class='bitcoin'>IMPORTANT NOTES:</span>
<br /><br />

!!NEVER ADD A PLUGIN SOMEBODY ELSE WROTE, UNLESS YOU OR SOMEONE YOU TRUST HAVE REVIEWED THE CODE AND ARE ABSOLUTELY SURE IT IS NOT MALICIOUS!!
<br /><br />

"plug-conf.php" files are loaded on main app initiation, so they can be included in the GLOBAL cached app config (allowing the editing of these config settings in the admin interface, etc). 
<br /><br />

"plug-init.php" files are where plugins first start loading from, so you edit these files like you would the first file containing the programming logic for your plugin. You are free to add and include more files / folders inside your plugin main folder, in the same way you would build an ordinary application. Any config settings / class functions and variables you have in "plug-conf.php" and "plug-lib/plug-class.php" are automatically available to use in "plug-init.php", and in any other plugin files you create that run within / after the initial "plug-init.php" logic.
<br /><br />

CRON-DESIGNATED PLUGINS (PLUGINS FLAGGED TO RUN DURING CRON JOBS) DO RUN #LAST# WITHIN THE CRON RUNTIME (AND THEREFORE ARE #NOT# INCLUDED IN RUNTIME STATS DATA LIKE HOW MANY SECONDS IT RAN / SYSTEM LOAD), SO EVEN IF YOUR CUSTOM PLUGIN CRASHES, #EVERYTHING ELSE# IMPORTANT RAN BEFOREHAND ANYWAY.
<br /><br />

<span class='red'>ALWAYS TEST YOUR CODE, TO MAKE SURE IT DOESN'T CRASH THE APP.</span>
<br /><br />


	      </div>
	    </div>
	  </div>
	  
	
	<?php
	$accord_var = 'about';
	?>
	
	  <div class="card z-depth-0 bordered">
	    <div class="card-header" id="heading_<?=$accord_var?>">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?=$accord_var?>"
	          aria-expanded="false" aria-controls="collapse_<?=$accord_var?>">
	          
	          About Open Crypto Tracker
	          
	        </button>
	      </h5>
	    </div>
	    <div id="collapse_<?=$accord_var?>" class="faq_bg collapse" aria-labelledby="heading_<?=$accord_var?>"
	      data-parent="#accordionHelp">
	      <div class="card-body">
	      
	         
	       <div style='float:left; position: relative; padding-right: 20px; padding-bottom: 20px;'>
	       <a href="https://twitter.com/taoteh1221/status/1562521606895050752" target="_blank"><img src='templates/interface/media/images/twitter-1562521606895050752.jpg' style='display: block;' width='425' class='image_border' alt='' /></a>
	       </div>
	      
	         
	       <div style=''>
	       
	       Open Crypto Tracker (previously known as 'DFD Cryptocoin Values') has been in active development since August of 2014. The source code was <a href='https://github.com/taoteh1221/Open_Crypto_Tracker' target='_blank'>released on github.com</a> later in September of 2015, under the GPLv3 license. 
	       
	       <br /><br />The primary goal of this project is to provide a 100% FREE / Open Source cryptocurrency tracker to the crypto community, that 'just works' AND maintains a high level of user privacy / security. More information on project ethos and contributing to this project can be found in <a href='CONTRIBUTING.txt' target='_blank'>CONTRIBUTING.txt</a> (in the app's main directory).
	       
	       </div>
	        
	        
	      </div>
	    </div>
	  </div>
	  
	
	  
	  
	  
	  
	  
	</div> <!-- Accordion END -->
	
	
			    
			    
</div> <!-- max_1200px_wrapper END -->




		    