
// Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com



/////////////////////////////////////////////////////////////


function force_2_digits(num) {
return ("0" + num).slice(-2);
}
	

/////////////////////////////////////////////////////////////


function delete_cookie( name ) {
document.cookie = name + '=; SameSite=Strict; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


/////////////////////////////////////////////////////////////


function array_byte_size(val) {
return new Blob([JSON.stringify(val)]).size;
}


/////////////////////////////////////////////////////////////


function set_target_action(obj_id, set_target, set_action) {
document.getElementById(obj_id).target = set_target;
document.getElementById(obj_id).action = set_action;
}


/////////////////////////////////////////////////////////////


function toTimestamp(year,month,day,hour,minute,second) {
 var datum = new Date(Date.UTC(year,month-1,day,hour,minute,second));
 return datum.getTime()/1000;
}


/////////////////////////////////////////////////////////////


function background_loading_notices(message) {

    if ( $("#background_loading_span").html() != 'Please wait, finishing background tasks...' ) {
    $("#background_loading_span").html(message).css("color", "#dd7c0d", "important");
    }

}


/////////////////////////////////////////////////////////////


function isInt(value) {
  if (isNaN(value)) {
    return false;
  }
  var x = parseFloat(value);
  return (x | 0) === x;
}


/////////////////////////////////////////////////////////////


function refreshImage(imgElement, imgURL) {   
     
// create a new timestamp, to force-refresh image
timestamp = new Date().getTime();        
el = document.getElementById(imgElement);        
queryString = "?t=" + timestamp;           
el.src = imgURL + queryString;    
 
}    


/////////////////////////////////////////////////////////////


function autoresize_update() {
    
const all_autosize_textareas = document.querySelectorAll("[data-autoresize]");

    all_autosize_textareas.forEach(function(textarea) {
    autosize.update(textarea);
    });

}


/////////////////////////////////////////////////////////////


function setCookie(cname, cvalue, exdays) {
d = new Date();
d.setTime(d.getTime() + (exdays*24*60*60*1000));
expires = "expires="+d.toUTCString();
document.cookie = cname + "=" + cvalue + "; SameSite=Strict; " + expires;
}


/////////////////////////////////////////////////////////////


function store_scroll_position() {

// IN CASE we are loading / POSTING DATA ON a different start page than the portfolio page,
// STORE the current scroll position before the page reload
// WE ONLY CALL THIS FUNCTION ONCE PER PAGE UNLOAD (body => onbeforeunload)
sessionStorage['scroll_position'] = window.scrollY;

//console.log('scroll_position set to: ' + window.scrollY); // DEBUGGING ONLY

}


/////////////////////////////////////////////////////////////


var sort_extraction = function(node) {

// Sort with the .app_sort_filter CSS class as the primary sorter
sort_target = $(node).find(".app_sort_filter").text();

// Remove any commas from number sorting
return sort_target.replace(/,/g, '');

}


/////////////////////////////////////////////////////////////


function update_alert_percent() {

	if ( document.getElementById("alert_percent").value == "yes" ) {
	document.getElementById("use_alert_percent").value = document.getElementById("alert_source").value + "|"
	+ document.getElementById("percent_change_amnt").value + "|" + document.getElementById("percent_change_filter").value + "|" 
	+ document.getElementById("percent_change_time").value + "|" + document.getElementById("percent_change_alert_type").value;
	}
	else {
	document.getElementById("use_alert_percent").value = "";
	}

}


/////////////////////////////////////////////////////////////


function start_utc_time() {

today = new Date();
date = today.getUTCFullYear() + '-' + force_2_digits(today.getUTCMonth() + 1) + '-' + force_2_digits( today.getUTCDate() );
time = force_2_digits( today.getUTCHours() ) + ":" + force_2_digits( today.getUTCMinutes() ) + ":" + force_2_digits( today.getUTCSeconds() );

$("span.utc_timestamp").text('[' + date + ' ' + time + '.000]');

utc_time = setTimeout(start_utc_time, 1000);

}


/////////////////////////////////////////////////////////////


function addCSSClassRecursively(topElement, CssClass) {

$(topElement).addClass(CssClass);

    $(topElement).children().each(
            function() {
                 $(this).addClass(CssClass);
                 addCSSClassRecursively($(this), CssClass);
            });
            
}


/////////////////////////////////////////////////////////////


// https://mottie.github.io/tablesorter/docs/
function reset_tablesorter(priv_pmode) {
    
col = priv_pmode == 'on' ? 0 : sorted_by_col;

$("#coins_table").find("th:eq("+col+")").trigger("sort");

    // Reverse the sort, if it's decending (1)
    if ( priv_pmode != 'on' && sorted_asc_desc > 0 ) {
    $("#coins_table").find("th:eq("+col+")").trigger("sort");
    }

}


/////////////////////////////////////////////////////////////


function iframe_adjust(elm) {


    // Set proper page zoom on the iframe
    if ( app_edition == 'desktop' ) {
    elm.contentWindow.document.body.style.zoom = currzoom + '%';
    }


    // Now that we've set any required zoom level, adjust the height
    if ( elm.id == 'iframe_system_stats' || elm.id == 'iframe_security' ) {
    extra = 1000;
    }
    else {
    extra = 100;
    }


elm.height = (elm.contentWindow.document.body.scrollHeight + extra) + "px";
              
}


/////////////////////////////////////////////////////////////


const iframe_adjuster = new IntersectionObserver(entries => {
    
    entries.forEach(entry => {
      
    const intersecting = entry.isIntersecting;
      
        if ( intersecting ) {
        iframe_adjust(entry.target);
        //console.log(entry.target.id + ' showing.');
        }
        
    });

});


/////////////////////////////////////////////////////////////


function validateForm(form_id, field) {
	
x = document.forms[form_id][field].value;

  if (x == "") {
  alert(field + " must be populated.");
  return false;
  }
  else {
  $("#" + form_id).submit();
  }
  
}


/////////////////////////////////////////////////////////////


function chart_toggle(obj_var) {
  
show_charts = $("#show_charts").val();
	
	if ( obj_var.checked == true ) {
	$("#show_charts").val("[" + obj_var.value + "]" + "," + show_charts);
	}
	else {
	$("#show_charts").val( show_charts.replace("[" + obj_var.value + "],", "") );
	}
	
  
show_charts = $("#show_charts").val(); // Reset var with any new data

// Error checking
$("#show_charts").val( show_charts.replace(",,", ",") );
	
}


/////////////////////////////////////////////////////////////


function crypto_val_toggle(obj_var) {
  
show_crypto_val = $("#show_crypto_val").val();
	
	if ( obj_var.checked == true ) {
	$("#show_crypto_val").val("[" + obj_var.value + "]" + "," + show_crypto_val);
	}
	else {
	$("#show_crypto_val").val( show_crypto_val.replace("[" + obj_var.value + "],", "") );
	}
	
  
show_crypto_val = $("#show_crypto_val").val(); // Reset var with any new data

// Error checking
$("#show_crypto_val").val( show_crypto_val.replace(",,", ",") );
	
}


/////////////////////////////////////////////////////////////


function feed_toggle(obj_var) {
  
show_feeds = $("#show_feeds").val();
	
	if ( obj_var.checked == true ) {
	$("#show_feeds").val("[" + obj_var.value + "]" + "," + show_feeds);
	}
	else {
	$("#show_feeds").val( show_feeds.replace("[" + obj_var.value + "],", "") );
	}
	
  
show_feeds = $("#show_feeds").val(); // Reset var with any new data

// Error checking
$("#show_feeds").val( show_feeds.replace(",,", ",") );
	
}


/////////////////////////////////////////////////////////////


function human_time(timestamp) {
    
date = new Date(timestamp),
datevalues = [
   date.getFullYear(),
   date.getMonth()+1,
   date.getDate(),
   date.getHours(),
   date.getMinutes(),
   date.getSeconds(),
];

return datevalues[0] + '/' + datevalues[1] + '/' + datevalues[2] + ' @ ' + datevalues[3] + ':' + datevalues[4] + ':' + datevalues[5];

}


/////////////////////////////////////////////////////////////


function ajax_placeholder(px_size, align, message=null, display_mode=null){
    
    
    if ( display_mode ) {
    display_mode = 'display: ' + display_mode + '; ';
    }


	if ( message ) {
	img_height = px_size - 2;
	return '<div class="align_' + align + '" style="'+display_mode+'white-space: nowrap; font-size: ' + px_size + 'px;"><img src="templates/interface/media/images/auto-preloaded/loader.gif" height="' + img_height + '" alt="" style="position: relative; vertical-align:middle;" /> ' + message + ' </div>';
	}
	else {
	img_height = px_size;
	return '<div class="align_' + align + '" style="'+display_mode+'"><img src="templates/interface/media/images/auto-preloaded/loader.gif" height="' + img_height + '" alt="" /></div>';
	}
	

}


/////////////////////////////////////////////////////////////


function set_admin_security(obj) {

		if ( obj.value == "normal" || obj.value == "enhanced" ) {
	    var int_api_key_reset = confirm("'Enhanced' and 'Normal' admin security modes are currently BETA (TEST) FEATURES, AND USING THEM MAY LEAD TO ISSUES UPDATING YOUR APP CONFIGURATION (editing from the PHP config files will be DISABLED).\n\nYou can RE-DISABLE these BETA features AFTER activating them (by setting the security mode back to 'High'), and you will be able to update your app configuration from the PHP config files again.");
		}
		else {
	    var int_api_key_reset = confirm("High security admin mode requires you to update your app configuration from the PHP config files.");
		}
		
		if ( int_api_key_reset ) {
		$("#toggle_admin_security").submit(); // Triggers iframe "reloading" sequence
		}
		else {
		$('input[name=opt_admin_sec]:checked').prop('checked',false);
		$('#opt_admin_sec_' + $("#sel_admin_sec").val() ).prop('checked',true);
		}

}


/////////////////////////////////////////////////////////////


function show_more(id, change_text=0) {
	
	if ( $("#"+id).is(":visible") ) {
	$("#"+id).hide(250, 'linear'); // 0.25 seconds
	}
	else {
	$("#"+id).show(250, 'linear'); // 0.25 seconds
	}
	
	if ( $("#" + change_text).text() == 'Show More' ) {
	$("#" + change_text).text('Show Less');
	}
	else if (  $("#" + change_text).text() == 'Show Less' ) {
	$("#" + change_text).text('Show More');
	}

}


/////////////////////////////////////////////////////////////


// JAVASCRIPT COOKIE ENCODING / DECODING IS #NOT# COMPATIBLE 
// WITH PHP COOKIE AUTO ENCODING / DECODING!! 
// ONLY USE THIS FOR CHECKS ON COOKIE VALS EXISTING ETC ETC!!
function getCookie(cname) {
	
name = cname + "=";
ca = document.cookie.split(';');

    for(i=0; i<ca.length; i++) {
        c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    
return false;

}

	
/////////////////////////////////////////////////////////////


function app_reloading_check(form_submission=0) {
        
    // Disable form updating in privacy mode
    if ( getCookie('priv_toggle') == 'on' && form_submission == 1 ) {
    alert('Submitting data is not allowed in privacy mode.');
    return 'no'; // WE NORMALLY DON'T RETURN DATA HERE BECAUSE WE ARE REFRESHING OR SUBMITTING, SO WE CANNOT USE RETURN FALSE RELIABLY
    }
    else {
    app_reload(form_submission);
    }

}


/////////////////////////////////////////////////////////////


function cron_loading_check(cron_loaded) {
	
//console.log('loaded charts = ' + window.charts_loaded.length + ', all charts = ' + window.charts_num);

	if ( window.cron_loaded == true ) {
	return 'done';
	}
	else {
	background_loading_notices("Checking / Running Scheduled Tasks...");
	$("#background_loading").show(250); // 0.25 seconds
	return 'active';
	}

}


/////////////////////////////////////////////////////////////


function charts_loading_check(charts_loaded) {
	
//console.log('loaded charts = ' + window.charts_loaded.length + ', all charts = ' + window.charts_num);

    // NOT IN ADMIN AREA (UNLIKE CRON EMULATION)
	if ( charts_loaded.length >= window.charts_num || window.is_admin == true ) {
	return 'done';
	}
	else {
	background_loading_notices("Loading Charts...");
	$("#background_loading").show(250); // 0.25 seconds
	return 'active';
	}

}


/////////////////////////////////////////////////////////////


function feeds_loading_check(feeds_loaded) {
	
//console.log('loaded feeds = ' + window.feeds_loaded.length + ', all feeds = ' + window.feeds_num);

    // NOT IN ADMIN AREA (UNLIKE CRON EMULATION)
	if ( feeds_loaded.length >= window.feeds_num || window.is_admin == true ) {
	return 'done';
	}
	else {
	background_loading_notices("Loading News Feeds...");
	$("#background_loading").show(250); // 0.25 seconds
	return 'active';
	}

}


/////////////////////////////////////////////////////////////


function get_scroll_position(tracing) {

	// If we are using a different start page than the portfolio page,
	// RETRIEVE any stored scroll position we were at before the page reload
    if ( $(location).attr('hash') != '' && !isNaN(sessionStorage['scroll_position']) ) {
        
    	$('html, body').animate({
       	scrollTop: sessionStorage['scroll_position']
    	}, 'slow');
    		
    }
    // Reset if we're NOT starting on a secondary page
    else {
	sessionStorage['scroll_position'] = 0;
    }

}


/////////////////////////////////////////////////////////////


function is_msie() {

// MSIE 10 AND UNDER
ua = window.navigator.userAgent;
msie = ua.indexOf('MSIE');

	if (msie > 0) {
   return true;
   }

// MSIE 11
ua = window.navigator.userAgent;
trident = ua.indexOf('Trident');

	if (trident > 0) {
   return true;
   }

// If we get this far, return false
return false;
	
}


/////////////////////////////////////////////////////////////


function safe_add_remove_class(class_name, element, mode) {
    
    if ( mode == 'add' ) {
    
        if ( document.getElementById(element) ) {
        document.getElementById(element).classList.add(class_name); 
        }
        
    }
    else if ( mode == 'remove' ) {
    
        if ( document.getElementById(element) ) {
        document.getElementById(element).classList.remove(class_name); 
        }
        
    }

    
}


/////////////////////////////////////////////////////////////


function text_to_download(textToWrite, fileNameToSaveAs)
    {
    	var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'}); 
    	var downloadLink = document.createElement("a");
    	downloadLink.download = fileNameToSaveAs;
    	downloadLink.innerHTML = "Download File";
    	if (window.webkitURL != null)
    	{
    		// Chrome allows the link to be clicked
    		// without actually adding it to the DOM.
    		downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
    	}
    	else
    	{
    		// Firefox requires the link to be added to the DOM
    		// before it can be clicked.
    		downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
    		downloadLink.onclick = destroyClickedElement;
    		downloadLink.style.display = "none";
    		document.body.appendChild(downloadLink);
    	}
    
    	downloadLink.click();
}


/////////////////////////////////////////////////////////////


function play_audio_alert() {

audio_alert = document.getElementById('audio_alert');
				
				
	if ( audio_alert.canPlayType('audio/mpeg') ) {
	audio_alert.setAttribute('src','templates/interface/media/audio/Intruder_Alert-SoundBible.com-867759995.mp3');
	}
	else if ( audio_alert.canPlayType('audio/ogg') ) {
	audio_alert.setAttribute('src','templates/interface/media/audio/Intruder_Alert-SoundBible.com-867759995.ogg');
	}
				
	
	// If subsections are still loading, wait until they are finished
   if ( $("#background_loading").is(":visible") ) {
   setTimeout(play_audio_alert, 1000); // Wait 1000 millisecnds then recheck
   return;
   }
   else {
	audio_alert.autoplay = true;
	audio_alert.play();
   }
    				


}


/////////////////////////////////////////////////////////////


function selectAll(toggle, form_name) {
	
    var checkbox, i=0;
    while ( checkbox=document.getElementById(form_name).elements[i++] ) {
    	
        if ( checkbox.type == "checkbox" ) {
            
            if ( form_name == 'activate_charts' && checkbox.checked != toggle.checked ) {
        		checkbox.checked = toggle.checked;
            chart_toggle(checkbox);
            }
            
            else if ( form_name == 'activate_feeds' && checkbox.checked != toggle.checked ) {
        		checkbox.checked = toggle.checked;
            feed_toggle(checkbox);
            }
            
            else if ( form_name == 'coin_amnts' && checkbox.checked != toggle.checked ) {
        		checkbox.checked = toggle.checked;
            watch_toggle(checkbox);
            }
            
        }
        
    }
     
}


/////////////////////////////////////////////////////////////


function copy_text(elm_id, alert_id) {
	
  elm = document.getElementById(elm_id);

  // for Internet Explorer
  if(document.body.createTextRange) {
    range = document.body.createTextRange();
    range.moveToElementText(elm);
    range.select();
    document.execCommand("Copy");
	 document.getElementById(alert_id).innerHTML = 'Copied to clipboard.';
  }
  // other browsers
  else if(window.getSelection) {
    selection = window.getSelection();
    range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("Copy");
	 document.getElementById(alert_id).innerHTML = 'Copied to clipboard.';
  }
  
}


/////////////////////////////////////////////////////////////


function emulated_cron() {
    
window.cron_loaded = false;

background_tasks_check(); 


      $.ajax({
            type: 'GET',
            url: 'cron.php?cron_emulate=1',
            async: true,
            contentType: "application/json",
            dataType: 'json',
            success: function(response) {
                
                if ( typeof response.result != 'undefined' ) {
                console.log( "cron emulation RESULT: " + response.result + ', at ' + human_time( new Date().getTime() ) );
                }
            
            window.cron_loaded = true;
            
                // If flagged to display error in GUI
                if ( typeof response.display_error != 'undefined' ) {
                
                    if ( $('#alert_bell_area').html() == 'No new runtime alerts.' ) {
                    $('#alert_bell_area').html( response.result );
                    }
                    else {
                    $('#alert_bell_area').html( $('#alert_bell_area').html() + '<br />' + response.result );
                    }
                
                $("#alert_bell_image").attr("src","templates/interface/media/images/auto-preloaded/notification-" + theme_selected + "-fill.png");
                
                }
            
            background_tasks_check();  
            
            },
            error: function(e) {
            console.log( "cron emulation: ERROR at " + human_time( new Date().getTime() ) );
            window.cron_loaded = true;
            background_tasks_check(); 
            }
        });
    
setTimeout(emulated_cron, 60000); // Re-check every minute (in milliseconds...cron.php will know if it's time)
    
}  


/////////////////////////////////////////////////////////////


function app_reload(form_submission) {
    
    
    // Wait if anything is running in the background
    // (emulated cron / charts / news feeds / etc)
    if ( window.background_tasks_status == 'wait' ) {
        
    $("#background_loading_span").html("Please wait, finishing background tasks...").css("color", "#ff4747", "important");
            
    reload_recheck = setTimeout(app_reload, 1500, form_submission);  // Re-check every 1.5 seconds (in milliseconds)
    
    return;
    
    }
    // ADD ANY LOGIC HERE, TO RUN BEFORE THE APP RELOADS
    else if ( window.background_tasks_status == 'done' ) {
    
    clearTimeout(reload_recheck);
    
    
        if ( form_submission == 0 || window.form_submit_queued == true ) {
            
        $("#app_loading").show(250, 'linear'); // 0.25 seconds
        $("#app_loading_span").html("Reloading...");
            
        // Transition effects
        $("#content_wrapper").hide(250, 'linear'); // 0.25 seconds
            
        // Close any open modal windows
        $(".show_chart_settings").modaal("close");
        $(".show_feed_settings").modaal("close");
        $(".show_portfolio_stats").modaal("close");
        $(".show_system_stats").modaal("close");
        $(".show_access_stats").modaal("close");
        $(".show_logs").modaal("close");
        
        }
    
    
        // Reload, ONLY IF WE ARE NOT #ALREADY RELOADING# VIA SUBMITTING DATA (so we don't cancel data submission!)
        if ( form_submission == 0 ) {
        location.reload(true);
        }
    
    
    }
    

}


/////////////////////////////////////////////////////////////


function watch_toggle(obj_var) {
	
num_val = $("#"+obj_var.value+"_amnt").val();
num_val = num_val.replace(/,/g, '');
		
		if ( obj_var.checked == true ) {
			
			// If there is a valid coin amount OR this is MISCASSETS, uncheck it
			if ( num_val >= 0.00000001 || obj_var.value == 'miscassets' || obj_var.value == 'ethnfts' || obj_var.value == 'solnfts' ) {
			obj_var.checked = false;
			}
			else {
			$("#"+obj_var.value+"_amnt").val("0.000000001");
			$("#"+obj_var.value+"_amnt").attr("readonly", "readonly");
			}
		
		}
		else {
			
			if ( num_val < 0.00000001 ) {
			$("#"+obj_var.value+"_amnt").val("");
			}
			
		$("#"+obj_var.value+"_amnt").removeAttr("readonly");
		$("#"+obj_var.value+"_amnt").val( $("#"+obj_var.value+"_restore").val() );
		}
	
}


/////////////////////////////////////////////////////////////


// https://codepen.io/kkoutoup/pen/zxmGLE
function random_tips() {
	
	if ( typeof quoteSource == 'undefined' ) {
	return;
	}
	
//getting a new random number to attach to a quote and setting a limit
randomNumber= Math.floor(Math.random() * quoteSource.length);
			
//set a new quote

newQuoteText = quoteSource[randomNumber].quote;
newQuoteGenius = quoteSource[randomNumber].name;
			
quoteContainer = $('#quoteContainer');
      
quoteContainer.html( ajax_placeholder(15, 'left') );

	//fade out animation with callback
   quoteContainer.fadeOut(250, function(){
	
	quoteContainer.html('<p>'+newQuoteText+'</p>'+'<p id="quoteGenius">'+'-'+newQuoteGenius+'</p>');
   
   //fadein animation.
   quoteContainer.fadeIn(250);
        
   });  


}
	
	
/////////////////////////////////////////////////////////////


function render_names(name) {
	
render = name.charAt(0).toUpperCase() + name.slice(1);


	Object.keys(secondary_mrkt_currencies).forEach(function(currency) {
	re = new RegExp(currency,"gi");
    render = render.replace(re, currency.toUpperCase() );
	});
		
		
render = render.replace(/btc/gi, "BTC");
render = render.replace(/nft/gi, "NFT");
render = render.replace(/coin/gi, "Coin");
render = render.replace(/bitcoin/gi, "Bitcoin");
render = render.replace(/exchange/gi, "Exchange");
render = render.replace(/market/gi, "Market");
render = render.replace(/forex/gi, "Forex");
render = render.replace(/finex/gi, "Finex");
render = render.replace(/stamp/gi, "Stamp");
render = render.replace(/flyer/gi, "Flyer");
render = render.replace(/panda/gi, "Panda");
render = render.replace(/pay/gi, "Pay");
render = render.replace(/swap/gi, "Swap");
render = render.replace(/iearn/gi, "iEarn");
render = render.replace(/pulse/gi, "Pulse");
render = render.replace(/defi/gi, "DeFi");
render = render.replace(/ring/gi, "Ring");
render = render.replace(/amm/gi, "AMM");
render = render.replace(/ico/gi, "ICO");
render = render.replace(/erc20/gi, "ERC-20");
render = render.replace(/okex/gi, "OKex");
render = render.replace(/mart/gi, "Mart");
render = render.replace(/gateio/gi, "Gate.io");
render = render.replace(/dex/gi, "DEX");
render = render.replace(/coingecko/gi, "CoinGecko.com");
render = render.replace(/alphavantage/gi, "AlphaVantage");

return render;

}


/////////////////////////////////////////////////////////////


function background_tasks_check() {
        
        
        if (
		feeds_loading_check(window.feeds_loaded) == 'done' && charts_loading_check(window.charts_loaded) == 'done' && cron_loading_check(window.cron_loaded) == 'done'
		) {
		    
		$("#background_loading").hide(250); // 0.25 seconds
		
    		// Run setting scroll position AGAIN if we are on the news page,
    		// as we start out with no scroll height before the news feeds load
    		if ( $(location).attr('hash') == '#news' ) {
    		get_scroll_position('news'); 
    		}
    		// Run setting scroll position AGAIN if we are on the charts page,
    		// as we start out with no scroll height before the charts load
    		else if ( $(location).attr('hash') == '#charts' ) {
    		get_scroll_position('charts'); 
    		}
    	
    	window.background_tasks_status = 'done';
    	
    	clearTimeout(background_tasks_recheck);
		
		}
		else {
		    
		background_tasks_recheck = setTimeout(background_tasks_check, 1000); // Re-check every 1 seconds (in milliseconds)
	
    	window.background_tasks_status = 'wait';
    
		}
		
    	
//console.log('background_tasks_check: ' + window.background_tasks_status);

}


/////////////////////////////////////////////////////////////


window.pw_prompt = function(options) {
    
promptCount = 0;
    
    var lm = options.lm || "Password:",
        bm = options.bm || "Submit";
    if(!options.callback) { 
        alert("No callback function provided! Please provide one.") 
    };
                   
    var prompt = document.createElement("div");
    prompt.className = "pw_prompt";
    
    var submit = function() {
        options.callback(input.value);
        document.body.removeChild(prompt);
    };

    var label = document.createElement("label");
    label.innerHTML = lm;
    label.for = "pw_prompt_input" + (++promptCount);
    prompt.appendChild(label);

    var input = document.createElement("input");
    input.id = "pw_prompt_input" + (promptCount);
    input.type = "password";
    input.addEventListener("keyup", function(e) {
        if (e.keyCode == 13) submit();
    }, false);
    prompt.appendChild(input);

    var button = document.createElement("button");
    button.textContent = bm;
    button.addEventListener("click", submit, false);
    prompt.appendChild(button);

    document.body.appendChild(prompt);
    
	setTimeout(function(){
    $(input).filter(':visible').focus();
	}, 1000);
    
};


/////////////////////////////////////////////////////////////


function sats_val(sat_increase) {

to_trade_amnt = Number(document.getElementById("to_trade_amnt").value);

sat_target = Number(document.getElementById("sat_target").value);


	if ( sat_increase == 'refresh' ) {
	num_total = (sat_target).toFixed(8);
	}
	else {
	sat_increase = Number(sat_increase);
	
	num_total = (sat_increase + sat_target).toFixed(8);
	
	document.getElementById("sat_target").value = num_total;
	}


target_prim_currency = ( num_total * btc_prim_currency_val );

target_total_prim_currency = ( (to_trade_amnt * num_total) * btc_prim_currency_val );


	document.getElementById("target_prim_currency").innerHTML = target_prim_currency.toLocaleString(undefined, {
    minimumFractionDigits: 8,
    maximumFractionDigits: 8
	});

document.getElementById("target_btc").innerHTML = num_total;

	document.getElementById("target_total_prim_currency").innerHTML = target_total_prim_currency.toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
	});

document.getElementById("target_total_btc").innerHTML = (to_trade_amnt * num_total).toFixed(8);

}


/////////////////////////////////////////////////////////////


function alphanumeric(doc_id_alert, elm_id, ui_name) { 

regex_is_lowercase_alphanumeric = /^[0-9a-z]+$/;
regex_starts_letter = /^[a-z]/;

var1 = document.getElementById(elm_id);
message = document.getElementById(doc_id_alert);
    
goodColor = "#10d602";
badColor = "#ff4747";


	if ( !var1 ) {
    message.style.color = badColor;
    message.innerHTML = "Enter " + ui_name + "."
    return false;
	}
	else if( !var1.value.match(regex_is_lowercase_alphanumeric) ) {
    var1.style.backgroundColor = badColor;
    message.style.color = badColor;
	message.innerHTML = ui_name + ' MUST contain ONLY LOWERCASE alphanumeric characters.';
	return false;
	}
	else if( !var1.value.match(regex_starts_letter) ) {
    var1.style.backgroundColor = badColor;
    message.style.color = badColor;
	message.innerHTML = ui_name + ' MUST START with a letter.';
	return false;
	}
	else if ( var1.value.length < 4 || var1.value.length > 30 ) {
    var1.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = ui_name + ' MUST be between 4 and 30 characters long.';
    return false;
	}
	else {
    var1.style.backgroundColor = goodColor;
    message.style.color = goodColor;
    message.innerHTML = ui_name + " OK.";
	return true;
	}

}


/////////////////////////////////////////////////////////////


function sorting_portfolio_table() {

	
    // https://mottie.github.io/tablesorter/docs/
	// Table data sorter config
	if ( document.getElementById("coins_table") ) {
	        
	// Set default sort, based on whether privacy mode is on        
	set_sort_list = getCookie('priv_toggle') == 'on' ? [0,0] : [sorted_by_col, sorted_asc_desc];
		
		
    	$("#coins_table").tablesorter({
    			
    			sortList: [ set_sort_list ],
    			theme : theme_selected, // theme "jui" and "bootstrap" override the uitheme widget option in v2.7+
    			textExtraction: sort_extraction,
    			widgets: ['zebra'],
    		    headers: {
    				
            			// disable sorting (we can use column number or the header class name)
            			'.no-sort' : {
            			// disable it by setting the property sorter to false
            			sorter: false
            			},
            			// disable sorting (we can use column number or the header class name)
            			'.num-sort' : {
            			sorter: 'sortprices'
            			}
    			
    			}
    			
    	});
		
		
		// add parser through the tablesorter addParser method 
		$.tablesorter.addParser({ 
			// set a unique id 
			id: 'sortprices', 
			is: function(s) { 
			// return false so this parser is not auto detected 
			return false; 
			}, 
			format: function(s) { 
			// format your data for normalization 
			return s.toLowerCase().replace(/\,/,'').replace(/ggggg/,'').replace(/\W+/,''); 
			}, 
			// set type, either numeric or text 
			type: 'numeric' 
		}); 
	
	
	}


}


/////////////////////////////////////////////////////////////


function system_logs(elm_id) {

$('#' + elm_id + '_alert').text('Refreshing, please wait...');
        	
var log_area = $('#' + elm_id); // Needs to be set as a global var, for the initial page load
      
// Blank out existing logs that are showing
log_area.text('');
    
log_file = elm_id.replace(/_log/ig, '.log');
        	
log_lines = $('#' + elm_id + '_lines').val();

not_whole_num = (log_lines - Math.floor(log_lines)) !== 0;


	if ( not_whole_num ) {
	set_lines = 100;
	$('#' + elm_id + '_lines').val(set_lines);
	}
	else {
	set_lines = log_lines;
	}
    	  
    	  	
   // Get log data
	$.getJSON("ajax.php?token=" + Base64.decode(logs_csrf_sec_token) + "&type=log&logfile=" + log_file + '&lines=' + set_lines, function( data ) {
      
   	data_length = data.length;
   	
   	loop = 0;
		$.each( data, function(key, val) {
			
   		if ( $('#' + elm_id + '_space').is(":checked") ) {
      	log_area.append(val + "\n"); // For UX / readability, add an extra space between log lines
   		}
   		else {
      	log_area.append(val); // For raw log format
   		}
   		
      
      loop = loop + 1;
      
      	// Finished looping
    		if (loop == data_length) {
   		
   			// Wait 4 seconds for it to fully load in the html element, then set scroll to bottom	
				setTimeout(function(){
				log_area.scrollTop(log_area[0].scrollHeight);
					
					// MSIE doesn't like highlightjs
					if ( is_msie() == false ) {
   				log_area.each(function(i, e) {hljs.highlightBlock(e)}); // Re-initialize highlighting text
					}
   			
				$('#' + elm_id + '_alert').text('');
				}, 4000);
	
    		}
    		
      });
              
	});
	
}


/////////////////////////////////////////////////////////////


function check_pass(doc_id_alert, doc_id_pass1, doc_id_pass2) {
	
pass1 = document.getElementById(doc_id_pass1);
pass2 = document.getElementById(doc_id_pass2);
message = document.getElementById(doc_id_alert);


regex_has_space = /\s/;
regex_has_number = /\d+/;
regex_has_lowercase = /[a-z]/;
regex_has_uppercase = /[A-Z]/;
regex_has_symb = /[!@#$%^&*]/;
    
    
goodColor = "#10d602";
badColor = "#ff4747";
    
    
    // Check length / compare values
   if ( !pass1 ) {
        message.style.color = badColor;
        message.innerHTML = "Enter your password."
        return false;
    }
   else if ( pass1.value.match(regex_has_space) ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password MUST NOT not contain any spaces."
        return false;
    }
	else if ( pass1.value.length < 12 || pass1 && pass1.value.length > 40 ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password must be between 12 and 40 characters long."
        return false;
	}
   else if ( !pass1.value.match(regex_has_number) ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password MUST contain at least 1 number."
        return false;
    }
   else if ( !pass1.value.match(regex_has_lowercase) ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password MUST contain at least 1 LOWERCASE letter."
        return false;
    }
   else if ( !pass1.value.match(regex_has_uppercase) ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password MUST contain at least 1 UPPERCASE letter."
        return false;
    }
   else if ( !pass1.value.match(regex_has_symb) ) {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password MUST contain at least 1 symbol."
        return false;
    }
   else if ( !pass2 || pass1 && pass2 && pass1.value != pass2.value ) {
        pass1.style.backgroundColor = goodColor;
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords do not match."
        return false;
    }
   else {
        pass1.style.backgroundColor = goodColor;
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Password OK."
        return true;
   }

}


/////////////////////////////////////////////////////////////


function row_alert(tr_id, alert_type, color, theme) {


    $( document ).ready(function() {
    	
      
			if ( color == 'yellow' ) {
			zebra_odd_loss = ( theme == 'light' ? '#d3bb5b' : '#6d5a29' );
			zebra_even_loss = ( theme == 'light' ? '#efd362' : '#564a1e' );
			}
			
			if ( color == 'green' ) {
			zebra_odd_gain = ( theme == 'light' ? '#7dc67d' : '#3d603d' );
			zebra_even_gain = ( theme == 'light' ? '#93ea93' : '#2d492d' );
			}
					
		 
			if ( color != 'no_cmc' ) {
			
				if ( color == 'yellow' && !window.alert_color_loss ) {
				window.alert_color_loss = zebra_odd_loss;
				}
				
				
				if ( color == 'green' && !window.alert_color_gain ) {
				window.alert_color_gain = zebra_odd_gain;
				}
					
				
				if ( color == 'yellow' ) {
				
				$('.tablesorter tr#' + tr_id).css("background", window.alert_color_loss);
				$('.tablesorter tr#' + tr_id + ' td').css("background", window.alert_color_loss);
				$('.tablesorter tr#' + tr_id).css("background-color", window.alert_color_loss);
				$('.tablesorter tr#' + tr_id + ' td').css("background-color", window.alert_color_loss);
				
				}
				
				
				if ( color == 'green' ) {
				
				$('.tablesorter tr#' + tr_id).css("background", window.alert_color_gain);
				$('.tablesorter tr#' + tr_id + ' td').css("background", window.alert_color_gain);
				$('.tablesorter tr#' + tr_id).css("background-color", window.alert_color_gain);
				$('.tablesorter tr#' + tr_id + ' td').css("background-color", window.alert_color_gain);
				
				}
					
					
				// Zebra stripes
				if ( color == 'yellow' ) {
				
					if ( window.alert_color_loss == zebra_odd_loss ) {
					window.alert_color_loss = zebra_even_loss;
					}
					else if ( window.alert_color_loss == zebra_even_loss ) {
					window.alert_color_loss = zebra_odd_loss;
					}
				
				}
				else if ( color == 'green' ) {
				
					if ( window.alert_color_gain == zebra_odd_gain ) {
					window.alert_color_gain = zebra_even_gain;
					}
					else if ( window.alert_color_gain == zebra_even_gain ) {
					window.alert_color_gain = zebra_odd_gain;
					}
					
				}
				
			
				// Audio, if chosen in settings
				if ( !window.is_alerted && alert_type == 'visual_audio' ) {
				play_audio_alert();
				window.is_alerted = 1;
				}
			
			
			}

    
    });
    

}


/////////////////////////////////////////////////////////////


function auto_reload() {


	if ( window.reload_time ) {
	time = window.reload_time;
	}
	else if ( getCookie("coin_reload") ) {
	time = getCookie("coin_reload");
	}
	else {
	return;
	}
	

	if ( document.getElementById("set_use_cookies") ) {
		
		
		if ( window.reload_countdown ) {
		clearInterval(window.reload_countdown);
		}

		
		if ( time >= 1 ) {
			
			
			if ( document.getElementById("set_use_cookies").checked == false ) {
				
			use_cookies = confirm(' You must enable "Use cookies to save data" on the "Settings" page before using this auto-refresh feature. \n \n Click OK below to enable "Use cookies to save data" automatically NOW, or click CANCEL to NOT enable cookie data storage for this app.');
			
				if ( use_cookies == true ) {
					
				setCookie("coin_reload", time, 365);
				
				$("#use_cookies").val(1);
				
				document.getElementById("reload_countdown").innerHTML = "(reloading app, please wait...)";
				
					setTimeout(function () {
						$("#coin_amnts").submit();
					}, 2000);
				
				}
				else{
				$("#select_auto_refresh").val('');
				return false;
				}
			
			}
			else {
				

                // If subsections are still loading, wait until they are finished
                if ( $("#background_loading").is(":visible") || window.charts_loaded.length < window.charts_num || window.feeds_loaded.length < window.feeds_num ) {
                setTimeout(auto_reload, 1000); // Wait 1000 milliseconds then recheck
                return;
                }
                else {
                   
               	setCookie("coin_reload", time, 365);
               	
    				int_time = time - 1; // Remove a second for the 1000 millisecond (1 second) recheck interval
    			
                	window.reload_countdown = setInterval(function () {
                          
                    
                    	if ( int_time >= 60 ) {
                    
                    	round_min = Math.floor(int_time / 60);
                    	sec = ( int_time - (round_min * 60) );
                    
                   	    $("#reload_countdown").html("<b>(" + round_min + " minutes " + sec + " seconds)</b>"); // Portfolio page
                   	    $("span.countdown_notice").html("<b>(auto-reload in " + round_min + " minutes " + sec + " seconds)</b>"); // Secondary pages
                      
                    	}
                    	else {
                    	$("#reload_countdown").html("<b>(" + int_time + " seconds)</b>"); // Portfolio page
                    	$("span.countdown_notice").html("<b>(auto-reload in " + int_time + " seconds)</b>"); // Secondary pages
                    	}
            				
            				if ( int_time == 0 ) {
                 		    app_reloading_check(0);
            				}
                
                
                 	int_time-- || clearInterval(window.reload_countdown);  // Clear if 0 reached
                 
                 	}, 1000);
    	    
                   
                }
   
   
			}
		
		
		}
		else {
		setCookie("coin_reload", '', 365);
		$("#reload_countdown").html(""); // Portfolio page
		$("span.countdown_notice").html(""); // Secondary pages
		}
	
	
	}


}


/////////////////////////////////////////////////////////////


// https://stackoverflow.com/questions/14458819/simplest-way-to-obfuscate-and-deobfuscate-a-string-in-javascript
function privacy_mode(click=false) {
    
    
    // Failsafe (if no PIN cookie, delete toggle cookie)
    if ( getCookie('priv_sec') == false ) {
    delete_cookie('priv_toggle');
    }
    
    
private_data = document.getElementsByClassName('private_data');


    if ( getCookie('priv_toggle') == 'on' && click == true ) {
        
        
        if ( getCookie('priv_sec') == null ) {
        delete_cookie('priv_toggle');
        }
        else {
        

            pw_prompt({
                lm:"Enter your PIN:", 
                callback: function(pin_check) {
                

                    if ( atob( getCookie('priv_sec') ) == pin_check ) {
                        
                        
                    	// Put configged markets into a multi-dimensional array, calculate number of markets total
                    	Object.keys(private_data).forEach(function(element) {
                    	    
                        //console.log( private_data[element].nodeName );
                    		
                    		if ( private_data[element].nodeName == "INPUT" || private_data[element].nodeName == "TEXTAREA" ) {
                    		    
                            //console.log( private_data[element].nodeName + ': ' + private_data[element].value );
                            
                            decrypted = CryptoJS.AES.decrypt(private_data[element].value, pin_check);
            	    
            	            private_data[element].value = decrypted.toString(CryptoJS.enc.Utf8);
        
                    		}
                    		else if ( private_data[element].nodeName == "DIV" || private_data[element].nodeName == "SPAN" ) {
        
                            //console.log( private_data[element].nodeName + ': ' + private_data[element].innerHTML );
        
                            decrypted = CryptoJS.AES.decrypt(private_data[element].innerHTML, pin_check);
        
                    	    private_data[element].innerHTML = decrypted.toString(CryptoJS.enc.Utf8);
        
                    		}
                        
                        // Show
                        private_data[element].classList.remove("obfuscated");
                    			
                    	});
                
                
                    //console.log('Privacy Mode: Off');
                    
                    setCookie('priv_toggle', 'off', 365); 


                        // Any stats are added to document title
                        if ( typeof doc_title_stats !== 'undefined' ) {
                        document.title = doc_title_stats; 
                        }
            		
            		
                    safe_add_remove_class('green', 'pm_link', 'remove');
                    safe_add_remove_class('bitcoin', 'pm_link', 'add');
                    
                        if ( document.getElementById("pm_link") ) {
                        document.getElementById("pm_link").setAttribute('title', 'Turn privacy mode ON. This encrypts / hides RENDERED personal portfolio data with the PIN you setup (BUT DOES #NOT# encrypt RAW source code). It ALSO disables opposite-clicking.');
                        }
                    
                    safe_add_remove_class('disable_click', 'update_link', 'remove');
                    
                        if ( document.getElementById("update_link") ) {
                        document.getElementById("update_link").setAttribute('title', 'Update your portfolio data.');
                        }
        
                    safe_add_remove_class('hidden', 'crypto_val', 'remove');
                    safe_add_remove_class('hidden', 'fiat_val', 'remove');
                    safe_add_remove_class('hidden', 'portfolio_gain_loss', 'remove');
                    safe_add_remove_class('hidden', 'balance_stats', 'remove');
                    
                    // https://mottie.github.io/tablesorter/docs/
                    $("#coins_table").find("th:eq(7)").removeClass("no-sort");
                    $("#coins_table").find("th:eq(9)").removeClass("no-sort");
                    $("#coins_table").find("th:eq(10)").removeClass("no-sort");
                    
                    $("#coins_table").find("th:eq(7)").addClass("num-sort");
                    $("#coins_table").find("th:eq(9)").addClass("num-sort");
                    $("#coins_table").find("th:eq(10)").addClass("num-sort");
                    
                    //$("#coins_table").find("th:eq(10)").data('sorter', 'sortprices');
                    
                    reset_tablesorter('off');
                    
                    var leverage_info = document.querySelectorAll(".leverage_info");
                        
                        leverage_info.forEach(function(info, index){
                        info.style.visibility = "visible";
                        });
                        
                        
                    document.oncontextmenu = document.body.oncontextmenu = function() {return true;};
                    
                    autoresize_update();
        
                    $("#pm_link").text('Privacy Mode Is Off');
                                
                    }
                    else {
                    alert("Wrong PIN, please try again.");
                    return;
                    }
                
                
                }
            });
        
        
        }
    
    
    }
    else {
        
        
        if ( getCookie('priv_sec') == false && click == true ) {
    

            pw_prompt({
                
                lm:"Create PIN <span style='font-weight: bold;' class='bitcoin'>(requires / uses cookies)</span>:", 
                callback: function(pin) {
                    
                    
                    // If page reload before entering pin (or left blank), or non-numeric, or less than 6 numbers
                    if ( typeof pin == 'undefined' || isInt(pin) == false || pin.length != 6 ) {
                    alert("PIN must be 6 numeric characters, please try again.");
                    return;
                    }
                    else {
                    

                        pw_prompt({
                            
                            lm:"Verify PIN:", 
                            callback: function(pin_check) {
                                
        
                                if ( pin == pin_check ) {
                                setCookie('priv_sec', btoa(pin), 365);
                                privacy_mode(click);
                                }
                                else {
                                alert("PIN mis-match, please try again.");
                                return;
                                }
    
    
                            }
                            
                        });
                        
                    
                    }


                }
            });
            
            
        }
        
        
        // Check again, that 'priv_sec' cookie set
        if ( getCookie('priv_sec') != false && click == true || getCookie('priv_sec') != false && click == false && getCookie('priv_toggle') == 'on' ) {
                    
        pin = atob( getCookie('priv_sec') );
        
            
            // Put configged markets into a multi-dimensional array, calculate number of markets total
            Object.keys(private_data).forEach(function(element) {
            	    
            //console.log( private_data[element].nodeName );
            		
            		if ( private_data[element].nodeName == "INPUT" || private_data[element].nodeName == "TEXTAREA" ) {

                    //console.log( private_data[element].nodeName + ': ' + private_data[element].value );
            	    
            	    private_data[element].value = CryptoJS.AES.encrypt(private_data[element].value, pin);

            		}
            		else if ( private_data[element].nodeName == "DIV" || private_data[element].nodeName == "SPAN" ) {

                    //console.log( private_data[element].nodeName + ': ' + private_data[element].innerHTML );

            	    private_data[element].innerHTML = CryptoJS.AES.encrypt(private_data[element].innerHTML, pin);

            		}
            
            
            // Hide 
            private_data[element].classList.add("obfuscated");
            			
            });
        
        
        //console.log('Privacy Mode: On');
        
        setCookie('priv_toggle', 'on', 365);
        
        document.title = ''; // Blank out document title
            		
        safe_add_remove_class('bitcoin', 'pm_link', 'remove');
        safe_add_remove_class('green', 'pm_link', 'add');
                    
            if ( document.getElementById("pm_link") ) {
            document.getElementById("pm_link").setAttribute('title', 'Turn privacy mode OFF. This reveals your personal portfolio data, using the PIN you setup. It ALSO re-enables opposite-clicking / data submission, and allows admin logins.');
            }
                    
        safe_add_remove_class('disable_click', 'update_link', 'add');
                    
            if ( document.getElementById("update_link") ) {
            document.getElementById("update_link").setAttribute('title', 'Disabled in privacy mode.');
            }
        
        safe_add_remove_class('hidden', 'crypto_val', 'add');
        safe_add_remove_class('hidden', 'fiat_val', 'add');
        safe_add_remove_class('hidden', 'portfolio_gain_loss', 'add');
        safe_add_remove_class('hidden', 'balance_stats', 'add');
        
        // https://mottie.github.io/tablesorter/docs/
        $("#coins_table").find("th:eq(7)").addClass("no-sort");
        $("#coins_table").find("th:eq(9)").addClass("no-sort");
        $("#coins_table").find("th:eq(10)").addClass("no-sort");
                    
        $("#coins_table").find("th:eq(7)").removeClass("num-sort");
        $("#coins_table").find("th:eq(9)").removeClass("num-sort");
        $("#coins_table").find("th:eq(10)").removeClass("num-sort");
                    
        //$("#coins_table").find("th:eq(10)").data('sorter', false);
        
        reset_tablesorter('on');
                    
        var leverage_info = document.querySelectorAll(".leverage_info");
                        
             leverage_info.forEach(function(info, index){
             info.style.visibility = "hidden";
             });
             
        document.oncontextmenu = document.body.oncontextmenu = function() {return false;};    
        
        $("#pm_link").text('Privacy Mode Is On');
        
        // Delete any existing admin auth (login) cookie
        // (we force admin logout when privacy mode is on)
        delete_cookie('admin_auth_' + ct_id); 
            
        
        }
        else {
        
            // Any stats are added to document title
            if ( typeof doc_title_stats !== 'undefined' ) {
            document.title = doc_title_stats; 
            }
        
        }
        
    
    }


}


/////////////////////////////////////////////////////////////





