<?php
/*
 * Copyright 2014-2023 GPLv3, Open Crypto Tracker by Mike Kilday: Mike@DragonFrugal.com
 */



class ct_admin {
	
// Class variables / arrays
var $ct_var1;
var $ct_var2;
var $ct_var3;

var $ct_array = array();


   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function repeatable_fields_template($field_array_base, $passed_key, $passed_val, $render_params) {
        
   global $ct, $repeatable_fields_tracking;
   
        
        // If an add / remove (repeatable) setup
        if ( is_array($render_params[$passed_key]['is_subarray']['is_repeatable']) ) {
        ?>
        
        <div class='subarray_<?=$field_array_base?>'>
        
             <?php
             // Subarray data can be mixed types of form fields, SO ALL CHECKS ARE 'IF' STATEMENTS
             foreach( $render_params[$passed_key]['is_subarray']['is_repeatable'] as $sub_key => $sub_val ) {

             // Tracking for rendering remove button
             $repeatable_fields_tracking[$passed_key][$sub_key] = 0;
             
             
                  if ( $sub_key === 'is_radio' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                  
                  // Tracking for rendering remove button
                  $repeatable_fields_tracking[$passed_key][$sub_key] = $repeatable_fields_tracking[$passed_key][$sub_key] + 1;

                  // Add radio button logic here   
                  
                  }
                  
                  if ( $sub_key === 'is_select' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                  
                  // Tracking for rendering remove button
                  $repeatable_fields_tracking[$passed_key][$sub_key] = $repeatable_fields_tracking[$passed_key][$sub_key] + 1;
                          
        
                       foreach( $render_params[$passed_key]['is_subarray']['is_repeatable']['is_select'] as $sub_key => $sub_val ) {
                       ?>
                  
                            <p>
                  
                       
                            <b class='blue'><?=$ct['gen']->key_to_name($sub_key)?>:</b> &nbsp; <select data-track-index='{?}' name='<?=$field_array_base?>[<?=$passed_key?>][{?}][<?=$sub_key?>]'>
                                
                                <?php
                                foreach( $sub_val as $setting_val ) {
                                ?>
                                
                                <option value='<?=$setting_val?>'> <?=$ct['gen']->key_to_name($setting_val)?> </option>
                                
                                <?php
                                }
                                ?>
                            
                            </select>
                           
                           123PLACEHOLDER_RIGHT123
                            
                            </p>
                       
                       <?php
                       }
             
                  }
                  
                  if ( $sub_key === 'is_text' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                  
                  // Tracking for rendering remove button
                  $repeatable_fields_tracking[$passed_key][$sub_key] = $repeatable_fields_tracking[$passed_key][$sub_key] + 1;
                  

                      foreach( $render_params[$passed_key]['is_subarray']['is_repeatable']['is_text'] as $sub_key => $unused ) {
                      ?>
                       
                      <p>
                   
                           <b class='blue'><?=$ct['gen']->key_to_name($sub_key)?>:</b> &nbsp; <input data-track-index='{?}' type='text' name='<?=$field_array_base?>[<?=$passed_key?>][{?}][<?=$sub_key?>]' value='' <?=( isset($render_params[$passed_key]['is_subarray']['is_repeatable']['text_field_size']) ? ' size="' . $render_params[$passed_key]['is_subarray']['is_repeatable']['text_field_size'] . '"' : '' )?> /> 
                           
                           123PLACEHOLDER_RIGHT123
          
                      </p>
                       
                      <?php
                      }
                      ?>
          	   
          	   123PLACEHOLDER_BOTTOM123
          	
          	
          	   <div class='repeatable_seperator'></div>
          	   
                  <?php
                  }
                  
             }
             ?>
        
        </div>
        
    <?php
        }
        
        
   }


   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function textarea_form_fields($field_array_base, $passed_key, $passed_val, $render_params, $subarray_key=false) {
        
   global $ct, $repeatable_fields_tracking;
   
   $repeatable_fields_tracking[$passed_key]['is_textarea'] = 0;
        
        
        // If a regular text area
        if ( isset($render_params[$passed_key]['is_textarea']) ) {
        ?>
         
         <p>
         
         <b class='blue'><?=$ct['gen']->key_to_name($passed_key)?>:</b> <br /> 
         
         <textarea data-autoresize name='<?=$field_array_base?>[<?=$passed_key?>]' style='height: auto; width: 100%;' <?=( isset($render_params[$passed_key]['is_password']) ? 'class="textarea_password" onblur="$(this).toggleClass(\'textarea_password\');autoresize_update();" onfocus="$(this).toggleClass(\'textarea_password\');autoresize_update();"' : '' )?>><?=$passed_val?></textarea>
         
              <?php
              if ( isset($render_params[$passed_key]['is_notes']) ) {
              ?>
              <span class='bitcoin random_tip' style='line-height: 1.7em;'><?=$render_params[$passed_key]['is_notes']?></span>
              <?php
              }
              ?>
              
         </p>
         
        <?php
        }
        
        
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function text_form_fields($field_array_base, $passed_key, $passed_val, $render_params, $subarray_key=false) {
        
   global $ct, $repeatable_fields_tracking;
   
   $repeatable_fields_tracking[$passed_key]['is_text'] = 0;
              
              
         if ( isset($render_params[$passed_key]['is_trim']) ) {
         $passed_val = trim($passed_val);
         }
         
         
         // If a regular text field (NOT a subarray)
         if ( !isset($render_params[$passed_key]['is_subarray']) ) {


              if ( isset($render_params[$passed_key]['is_password']) ) {
              ?>
                   
              <div class="password-container">
                   
              <?php
              }
              ?>
          
              <p>
              
              <b class='blue'><?=$ct['gen']->key_to_name($passed_key)?>:</b> &nbsp; <input type='<?=( isset($render_params[$passed_key]['is_password']) ? 'password' : 'text' )?>' data-name="<?=md5($conf_id . $passed_key)?>" name='<?=$field_array_base?>[<?=$passed_key?>]' value='<?=$passed_val?>' <?=( isset($render_params[$passed_key]['text_field_size']) ? ' size="' . $render_params[$passed_key]['text_field_size'] . '"' : '' )?> <?=( isset($render_params[$passed_key]['is_readonly']) ? 'readonly="readonly" placeholder="' . $render_params[$passed_key]['is_readonly'] . '"' : '' )?> />
              
              <?php
              if ( isset($render_params[$passed_key]['is_notes']) ) {
              ?>
          
              <br /><span class='bitcoin random_tip' style='line-height: 1.7em;'><?=$render_params[$passed_key]['is_notes']?></span>
                   
              <?php
              }
              ?>
              
              </p>
              
              <?php   
              if ( isset($render_params[$passed_key]['is_password']) ) {
              ?>
                   
                  <i class="gg-eye-alt toggle-show-password" data-name="<?=md5($field_array_base . $passed_key)?>"></i>
                      
              </div>
                   
              <?php
              }
                   
                   
         }
         // If a subarray text field  // PHP7.4 NEEDS !== HERE INSTEAD OF !=
         elseif ( $subarray_key !== 'is_repeatable' && is_array($render_params[$passed_key]['is_subarray'][$subarray_key]['is_text']) ) {


             foreach( $render_params[$passed_key]['is_subarray'][$subarray_key]['is_text'] as $sub_key => $sub_val ) {
             ?>
             
             <p>
         
                  <b class='blue'><?=$ct['gen']->key_to_name($sub_key)?>:</b> &nbsp; <input data-track-index='<?=$subarray_key?>' type='text' name='<?=$field_array_base?>[<?=$passed_key?>][<?=$subarray_key?>][<?=$sub_key?>]' value='<?=( isset($passed_val[$subarray_key][$sub_key]) ? $passed_val[$subarray_key][$sub_key] : '' )?>' <?=( isset($render_params[$passed_key]['is_subarray'][$subarray_key]['text_field_size']) ? ' size="' . $render_params[$passed_key]['is_subarray'][$subarray_key]['text_field_size'] . '"' : '' )?> />
                  
                  <?php
                  if ( isset($render_params[$passed_key]['is_subarray']['is_repeatable']['is_text']) ) {
                  $repeatable_fields_tracking[$passed_key]['is_text'] = $repeatable_fields_tracking[$passed_key]['is_text'] + 1;
                  echo '123PLACEHOLDER_RIGHT123';
                  }
                  ?>

             </p>
             
             <?php
             }
        
        
         }
         
                     
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function select_form_fields($field_array_base, $passed_key, $passed_val, $render_params, $subarray_key=false) {
        
   global $ct, $repeatable_fields_tracking;
   
   $repeatable_fields_tracking[$passed_key]['is_select'] = 0;
        
        
        // If a regular select field
        if ( isset($render_params[$passed_key]['is_select']) ) {
        ?>
        
        <p>
        
        <b class='blue'><?=$ct['gen']->key_to_name($passed_key)?>:</b> &nbsp; 
        
        <select name='<?=$field_array_base?>[<?=$passed_key?>]'>
        
             <?php
             foreach( $render_params[$passed_key]['is_select'] as $option_key => $option_val ) {
            
            // If it's flagged as an associative array
            if ( $option_key === 'is_assoc' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                 
                 foreach( $render_params[$passed_key]['is_select']['is_assoc'] as $assoc_val ) {
                 ?>
                 
                 <option value='<?=$assoc_val['key']?>' <?=( $passed_val == $assoc_val['key'] ? 'selected' : '' )?>> <?=$ct['gen']->key_to_name($assoc_val['val'])?> </option> 
                 
                 <?php
                 }
                 
            }
            else {
            ?>
            
            <option value='<?=$option_val?>' <?=( $passed_val == $option_val ? 'selected' : '' )?>> <?=$ct['gen']->key_to_name($option_val)?> </option> 
            
            <?php
            }
            
             }
             ?>
             
        </select>
        
             <?php
             if ( isset($render_params[$passed_key]['is_notes']) ) {
             ?>
             <br /><span class='bitcoin random_tip' style='line-height: 1.7em;'><?=$render_params[$passed_key]['is_notes']?></span>
             <?php
             }
             ?>
             
             </p>
        
        <?php
        }
        // If subarray select field // PHP7.4 NEEDS !== HERE INSTEAD OF !=
        elseif ( $subarray_key !== 'is_repeatable' && is_array($render_params[$passed_key]['is_subarray'][$subarray_key]['is_select']) ) {
        
        
             foreach( $render_params[$passed_key]['is_subarray'][$subarray_key]['is_select'] as $sub_key => $sub_val ) {
             ?>
        
                  <p>
        
             
                  <b class='blue'><?=$ct['gen']->key_to_name($sub_key)?>:</b> &nbsp; <select data-track-index='<?=$subarray_key?>' name='<?=$field_array_base?>[<?=$passed_key?>][<?=$subarray_key?>][<?=$sub_key?>]'>
                      
                      <?php
                      foreach( $sub_val as $setting_val ) {
                      ?>
                      
                      <option value='<?=$setting_val?>' <?=( isset($passed_val[$subarray_key][$sub_key]) && $passed_val[$subarray_key][$sub_key] == $setting_val ? 'selected' : '' )?> > <?=$ct['gen']->key_to_name($setting_val)?> </option>
                      
                      <?php
                      }
                      ?>
                  
                  </select>
                  
                      <?php
                      if ( isset($render_params[$passed_key]['is_subarray']['is_repeatable']['is_select']) ) {
                      $repeatable_fields_tracking[$passed_key]['is_select'] = $repeatable_fields_tracking[$passed_key]['is_select'] + 1;
                      echo '123PLACEHOLDER_RIGHT123';
                      }
                      ?>
                  
                  </p>
             
             <?php
             }
             
        }
        
        
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function radio_form_fields($field_array_base, $passed_key, $passed_val, $render_params, $subarray_key=false) {
        
   global $ct, $repeatable_fields_tracking;
   
   $repeatable_fields_tracking[$passed_key]['is_radio'] = 0;
        
        
        // If a regular radio button
        if ( isset($render_params[$passed_key]['is_radio']) ) {
        ?>
         
         <p>
         
         <b class='blue'><?=$ct['gen']->key_to_name($passed_key)?>:</b> &nbsp; 
         
              <?php
              foreach( $render_params[$passed_key]['is_radio'] as $radio_key => $radio_val ) {
                   
                   
                   // If it's flagged as an associative array
                   if ( $radio_key === 'is_assoc' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                        
                        foreach( $render_params[$passed_key]['is_radio']['is_assoc'] as $assoc_val ) {
                        ?>
                        
                        <input type='radio' name='<?=$field_array_base?>[<?=$passed_key?>]' value='<?=$assoc_val['key']?>' <?=( $passed_val == $assoc_val['key'] ? 'checked' : '' )?> /> <?=$ct['gen']->key_to_name($assoc_val['val'])?> &nbsp;
                        
                        <?php
                        }
                        
                   }
                   // Everything else
                   else {
                   ?>
                   
                   <input type='radio' name='<?=$field_array_base?>[<?=$passed_key?>]' value='<?=$radio_val?>' <?=( $passed_val == $radio_val ? 'checked' : '' )?> /> <?=$ct['gen']->key_to_name($radio_val)?> &nbsp;
                   
                   <?php
                   }
              
              
              }
              
              
              if ( isset($render_params[$passed_key]['is_notes']) ) {
              ?>
              <br /><span class='bitcoin random_tip' style='line-height: 1.7em;'><?=$render_params[$passed_key]['is_notes']?></span>
              <?php
              }
              ?>
              
              </p>
         
        <?php
        }
        // If subarray radio button // PHP7.4 NEEDS !== HERE INSTEAD OF !=
        elseif ( $subarray_key !== 'is_repeatable' && is_array($render_params[$passed_key]['is_subarray'][$subarray_key]['is_radio']) ) {
        ?>
        
        <p>
        
        <b class='blue'><?=$ct['gen']->key_to_name($subarray_key)?>:</b> &nbsp; 
             
             <?php
             foreach( $render_params[$passed_key]['is_subarray'][$subarray_key]['is_radio'] as $sub_key => $sub_val ) {
             ?>
                 
                 <input data-track-index='<?=$subarray_key?>' type='radio' name='<?=$field_array_base?>[<?=$passed_key?>][<?=$subarray_key?>]' value='<?=$sub_val?>' <?=( isset($passed_val[$subarray_key]) && $passed_val[$subarray_key] == $sub_val ? 'checked' : '' )?> /> <?=$ct['gen']->key_to_name($sub_val)?> &nbsp; 
                  
                    <?php
                    if ( isset($render_params[$passed_key]['is_subarray']['is_repeatable']['is_radio']) ) {
                    $repeatable_fields_tracking[$passed_key]['is_radio'] = $repeatable_fields_tracking[$passed_key]['is_radio'] + 1;
                    echo '123PLACEHOLDER_RIGHT123';
                    }
                    ?>
                 
             <?php
             }
             ?>
                 
        </p>
             
        <?php 
        }
   
        
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function admin_config_interface($conf_id, $interface_id, $render_params=false) {
        
   global $ct, $repeatable_fields_tracking, $update_config_success, $update_config_error;
   
   
      if ( !is_array($render_params) ) {
      return false;
      }
      
      
      if ( preg_match('/plug_conf\|/', $conf_id) ) {
           
      $is_plugin_config = true;
           
      $parse_plugin_data = explode('|', $conf_id);
      
      $field_array_base = $parse_plugin_data[1];
      
      $config_array_base = $ct['conf']['plug_conf'][ $parse_plugin_data[1] ];
      
      }
      else {
      $field_array_base = $conf_id;
      $config_array_base = $ct['conf'][$conf_id];
      }

	 
	 // Set which OTHER admin pages should be refreshed AFTER submission of this section's setting changes
	 if ( isset($render_params['is_refresh_admin']) ) {
	 $refresh_admin_sections = $render_params['is_refresh_admin'];
	 }
	 else {
	 $refresh_admin_sections = 'none';
	 }
	 
	 ?>
	
	
	<div style='min-height: 1em;'></div>

	 
	 <?php
	 if ( $update_config_success != null ) {
	 ?>
	 <div class='green green_dotted' style='font-weight: bold;'><?=$update_config_success?></div>
	 <div style='min-height: 1em;'></div>
	 <?php
	 }
	 elseif ( $update_config_error != null ) {
	 ?>
	 <div class='red red_dotted' style='font-weight: bold;'><?=$update_config_error?></div>
	 <div style='min-height: 1em;'></div>
	 <?php
	 }
	 ?>
	 
	 
   <div class='pretty_text_fields'>
   
	
	<form name='update_config' id='update_config' action='admin.php?iframe=<?=$ct['gen']->admin_hashed_nonce('iframe_' . $interface_id)?>&<?=( $is_plugin_config ? 'plugin' : 'section' )?>=<?=$interface_id?>&refresh=<?=$refresh_admin_sections?>' method='post'>
     
     <?php
     
     foreach( $config_array_base as $key => $val ) {
         
         // Radio buttons
         if ( is_array($render_params[$key]['is_radio']) ) {
         $this->radio_form_fields($field_array_base, $key, $val, $render_params);
         }
         // Select dropdowns
         elseif ( is_array($render_params[$key]['is_select']) ) {
         $this->select_form_fields($field_array_base, $key, $val, $render_params);
         }
         // Textareas
         elseif ( isset($render_params[$key]['is_textarea']) ) {
         $this->textarea_form_fields($field_array_base, $key, $val, $render_params);
         }
         // Subarray of ANY form field types (can be mixed)
         elseif ( is_array($render_params[$key]['is_subarray']) ) {


              if ( is_array($render_params[$key]['is_subarray']['is_repeatable']) ) {
                   
              $repeat_id = 'repeat_' . $field_array_base;
	         
	         $repeatable_seperator = "123PLACEHOLDER_BOTTOM123\n\n<div class='repeatable_seperator'></div>";
	         
	         $remove_button = '<input type="button" class="btn btn-danger span-2 delete" value="Remove" />';
	         
                   
                   // IF we need to reset the auto-indexing for this subarray,
                   // so no duplicates overwrite each other with the add / remove javascript in the UI
                   if ( isset($render_params[$key]['is_subarray']['is_repeatable']['reset_auto_index']) ) {
                        
                   $config_array_base[$key] = array_values($config_array_base[$key]);
                   
                   // If multidimensional PURE AUTO-INDEXING (NO ASSOCIATIVE SUBARRAYS), run this AFTER array_values()
                   //$config_array_base[$key] = array_map('array_values', $config_array_base[$key]);
                   
                   }
                   
              ?>

               <p class='<?=$field_array_base?>_add'><input type="button" value="<?=$render_params[$key]['is_subarray']['is_repeatable']['add_button']?>" class="btn btn-default add" align="center"></p>
              
     		<fieldset style='margin-bottom: 2em;' class="<?=$field_array_base?> subsection_fieldset"><legend class='subsection_legend'> <b class='bitcoin'><?=$ct['gen']->key_to_name($key)?></b> </legend>
                          
     		<div class="repeatable">
              
              <?php
              }
              else {         
              ?>
         
              <b class='bitcoin'><?=$ct['gen']->key_to_name($key)?></b> &nbsp; 

              <?php
              }
         
              
              // Subarray data can be mixed types of form fields, SO ALL CHECKS ARE 'IF' STATEMENTS
              foreach( $render_params[$key]['is_subarray'] as $subarray_key => $unused ) {
              
                   
                   // If this is an actual setting (NOT creating a repeatable BLANK TEMPLATE)
                   if ( $subarray_key !== 'is_repeatable' ) { // PHP7.4 NEEDS !== HERE INSTEAD OF !=
                   ?>
                   <div class='subarray_<?=$field_array_base?>'>
                   <?php
                   }
	         
	         
	         $field_count = 0;
	         $repeatable_fields_tracking[$key] = array(); // Reset counts                   
                                  
              ob_start();
               
               
                   // Radio buttons in subarray
                   if ( is_array($render_params[$key]['is_subarray'][$subarray_key]['is_radio']) ) {
                   $this->radio_form_fields($field_array_base, $key, $val, $render_params, $subarray_key);
                   }
                   
                   // Select dropdowns in subarray
                   if ( is_array($render_params[$key]['is_subarray'][$subarray_key]['is_select']) ) {
                   $this->select_form_fields($field_array_base, $key, $val, $render_params, $subarray_key);
                   }
                   
                   // Regular text fields in subarray
                   if ( is_array($render_params[$key]['is_subarray'][$subarray_key]['is_text']) ) {
                   $this->text_form_fields($field_array_base, $key, $val, $render_params, $subarray_key);
                   }
                   
	         
	         $rendered_form_fields = ob_get_contents();

	         ob_end_clean();
	          
	          
	              foreach ( $repeatable_fields_tracking[$key] as $count_val ) {
	              $field_count = $field_count + $count_val;
	              }
	                
	                
	              if ( $field_count > 1 ) {
	              $rendered_form_fields = $ct['gen']->str_replace_last('</p>', "</p>\n\n" . $repeatable_seperator . "\n\n", $rendered_form_fields);
	              $rendered_form_fields = preg_replace("/123PLACEHOLDER_BOTTOM123/i", $remove_button, $rendered_form_fields);
	              $rendered_form_fields = preg_replace("/123PLACEHOLDER_RIGHT123/i", "", $rendered_form_fields);
	              }
	              else {
	              $rendered_form_fields = preg_replace("/123PLACEHOLDER_RIGHT123/i", $remove_button, $rendered_form_fields);
	              $rendered_form_fields = preg_replace("/123PLACEHOLDER_BOTTOM123/i", "", $rendered_form_fields);
	              }
	                
	          
	         echo $rendered_form_fields;
	          
                   
                   // If this is an actual setting (NOT creating a repeatable BLANK TEMPLATE)
                   if ( $subarray_key !== 'is_repeatable' ) { // PHP7.4 NEEDS !== HERE INSTEAD OF !=
                   ?>
                   </div>
                   <?php
                   }
        
              
              }


              if ( is_array($render_params[$key]['is_subarray']['is_repeatable']) ) {
              ?>
              
     	     </div>
     
     		</fieldset>

               <p class='<?=$field_array_base?>_add'><input type="button" value="<?=$render_params[$key]['is_subarray']['is_repeatable']['add_button']?>" class="btn btn-default add" align="center"></p>

          	<!-- Scripting to run the form manipulations -->
          	
          
               <script type="text/template" id="<?=$repeat_id?>">
	          
	          <?php
	          
               // Add / remove (repeatable) form fields template
	          
	          $field_count = 0;
	          $repeatable_fields_tracking[$key] = array(); // Reset counts
               
               ob_start();
               
	          $this->repeatable_fields_template($field_array_base, $key, $val, $render_params);

	          $repeatable_template = ob_get_contents();

	          ob_end_clean();
	          
	          
	                foreach ( $repeatable_fields_tracking[$key] as $count_val ) {
	                $field_count = $field_count + $count_val;
	                }
	                
	                
	                if ( $field_count > 1 ) {
	                $repeatable_template = preg_replace("/123PLACEHOLDER_BOTTOM123/i", $remove_button, $repeatable_template);
	                $repeatable_template = preg_replace("/123PLACEHOLDER_RIGHT123/i", "", $repeatable_template);
	                }
	                else {
	                $repeatable_template = preg_replace("/123PLACEHOLDER_RIGHT123/i", $remove_button, $repeatable_template);
	                $repeatable_template = preg_replace("/123PLACEHOLDER_BOTTOM123/i", "", $repeatable_template);
	                }
	                
	          
	          echo $repeatable_template;
	                
		     ?>
         
         
          	</script>
          
          
          	<script>
          	
          		$(document).ready(function(){ 
          			$(".<?=$field_array_base?> .repeatable").repeatable({
          			     prefix: '',
          				addTrigger: ".<?=$field_array_base?>_add .add",
          				deleteTrigger: ".<?=$field_array_base?> .delete",
          				template: "#<?=$repeat_id?>",
          				itemContainer: ".subarray_<?=$field_array_base?>",
          				afterDelete: function () {
                              $("div.repeatable > div:first-child").css("border-top", "0.0em solid #808080");
                              $("div.repeatable > div:first-child").css("padding-top", "0.0em");
          				},
          				min: 1,
          				max: 999
          			});
          		});
          		
          	</script>
		
         
              <?php
              }
         

         }
         // Everything else should just render as a text field
         else {
         $this->text_form_fields($field_array_base, $key, $val, $render_params);
         }
         
     }
     ?>
     
	<input type='hidden' name='conf_id' id='conf_id' value='<?=$conf_id?>' />
     
	<input type='hidden' name='interface_id' id='interface_id' value='<?=$interface_id?>' />
	
	<input type='hidden' name='admin_hashed_nonce' value='<?=$ct['gen']->admin_hashed_nonce($interface_id)?>' />
	
	<?=$ct['gen']->input_2fa('strict')?>
			
	<p><input type='submit' value='Save <?=$ct['gen']->key_to_name($interface_id)?> Settings' /></p>
	
	</form>
     
     
   </div>
   
   <?php
   
   
   }

   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   
   function queue_config_update() {
        
   global $ct, $app_upgrade_check, $reset_config, $update_config, $check_2fa_error, $update_config_error, $update_config_success;
   
      
        if ( isset($_POST['conf_id']) && preg_match('/plug_conf\|/', $_POST['conf_id']) ) {
           
        $is_plugin_config = true;
           
        $parse_plugin_data = explode('|', $_POST['conf_id']);
      
        $field_array_base = $_POST[ $parse_plugin_data[1] ];
        
        $update_desc = 'plugin';
        
        }
        else {
        $field_array_base = $_POST[ $_POST['conf_id'] ];
        $update_desc = 'admin';
        }
      
        
        // Updating the admin config
        // (MUST run after primary-init, BUT BEFORE load-config-by-security-level.php)
        // (STRICT 2FA MODE ONLY)
        if ( isset($_POST['conf_id']) && isset($_POST['interface_id']) && is_array($field_array_base) && $ct['gen']->pass_sec_check($_POST['admin_hashed_nonce'], $_POST['interface_id']) && $ct['gen']->valid_2fa('strict') ) {
        
          
              if ( $app_upgrade_check ) {
              $update_config_error = 'The CACHED config is currently in the process of CHECKING FOR UPGRADES. Please wait a minute, and then try updating again.';
              }
              elseif ( $reset_config ) {
              $update_config_error = 'The CACHED config is currently in the process of RESETTING. Please wait a minute, and then try updating again.';
              }
              else {
               
               
                   // ADD VALIDATION CHECKS HERE, BEFORE ALLOWING UPDATE OF THIS CONFIG SECTION
                   if ( $_POST['conf_id'] === 'gen' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                        
                        
                      // Make sure primary currency conversion params are set properly
                      if ( !$ct['conf']['assets']['BTC']['pair'][ $_POST['gen']['bitcoin_primary_currency_pair'] ][ $_POST['gen']['bitcoin_primary_exchange'] ] ) {
                      $update_config_error = 'Bitcoin Primary Exchange "' . $ct['gen']->key_to_name($_POST['gen']['bitcoin_primary_exchange']) . '" does NOT have a "' . strtoupper($_POST['gen']['bitcoin_primary_currency_pair']) . '" market';
                      }
                      // If we made it this far, we passed all checks
                      else {
                      $update_config_valid = true;
                      }
                   
                   
                   }
                   elseif ( $_POST['conf_id'] === 'comms' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                   
                   $smtp_login_check = explode("||", $_POST['comms']['smtp_login']);
                   
                   $smtp_server_check = explode(":", $_POST['comms']['smtp_server']);
                   
                   $to_mobile_text_check = explode("||", $_POST['comms']['to_mobile_text']);
                        
                      // Make sure SMTP emailing params are set properly
                      if ( isset($_POST['comms']['smtp_login']) && $_POST['comms']['smtp_login'] != '' && sizeof($smtp_login_check) < 2 ) {
                      $update_config_error = 'SMTP Login formatting is NOT valid (format MUST be: username||password)';
                      }
                      elseif ( isset($_POST['comms']['smtp_server']) && $_POST['comms']['smtp_server'] != '' && sizeof($smtp_server_check) < 2 ) {
                      $update_config_error = 'SMTP Server formatting is NOT valid (format MUST be: domain_or_ip:port_number)';
                      }
                      // Mobile text check
                      elseif ( isset($_POST['comms']['to_mobile_text']) && $_POST['comms']['to_mobile_text'] != '' && sizeof($to_mobile_text_check) < 2 ) {
                      $update_config_error = 'To Mobile Text formatting is NOT valid (format MUST be: mobile_number||network_name)';
                      }
                      // Email FROM service check
                      elseif ( isset($_POST['comms']['from_email']) && $_POST['comms']['from_email'] != '' && $ct['gen']->valid_email($_POST['comms']['from_email']) != 'valid' ) {
                      $update_config_error = 'FROM Email is NOT valid: ' . $_POST['comms']['from_email'] . ' (' . $ct['gen']->valid_email($_POST['comms']['from_email']) . ')';
                      }
                      // Email TO service check
                      elseif ( isset($_POST['comms']['to_email']) && $_POST['comms']['to_email'] != '' && $ct['gen']->valid_email($_POST['comms']['to_email']) != 'valid' ) {
                      $update_config_error = 'TO Email is NOT valid: ' . $_POST['comms']['to_email'] . ' (' . $ct['gen']->valid_email($_POST['comms']['to_email']) . ')';
                      }
                      // If we made it this far, we passed all checks
                      else {
                      $update_config_valid = true;
                      }
                   
                   
                   }
                   elseif ( $_POST['conf_id'] === 'ext_apis' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                        
                      // Make sure Twilio number is set properly
                      if ( isset($_POST['ext_apis']['twilio_number']) && $_POST['ext_apis']['twilio_number'] != '' && !preg_match("/^\\d+$/", $_POST['ext_apis']['twilio_number']) ) {
                      $update_config_error = 'Twilio Number formatting is NOT valid: ' . $_POST['ext_apis']['twilio_number'] . ' (format MUST be ONLY NUMBERS)';
                      }
                      // If we made it this far, we passed all checks
                      else {
                      $update_config_valid = true;
                      }
                   
                   
                   }
                   elseif ( $_POST['conf_id'] === 'sec' ) { // PHP7.4 NEEDS === HERE INSTEAD OF ==
                   
                   
                      if ( isset($_POST['sec']['interface_login']) && $_POST['sec']['interface_login'] != '' ) {
                           
                      $is_interface_login = true;
                   
                      $interface_login_check = explode("||", $_POST['sec']['interface_login']);
                         
                      $htaccess_username_check = $interface_login_check[0];
                      $htaccess_password_check = $interface_login_check[1];
                        
                      $valid_username_check = $ct['gen']->valid_username($htaccess_username_check);
                        
                      // Password must be exactly 8 characters long for good htaccess security (htaccess only checks the first 8 characters for a match)
                      $password_strength_check = $ct['gen']->pass_strength($htaccess_password_check, 8, 8);
                        
                      }
                   
                        
                      // Make sure interface login params are set properly
                      if ( $is_interface_login && sizeof($interface_login_check) < 2 ) {
                      $update_config_error = 'Interface Login formatting is NOT valid (format MUST be: username||password)';
                      }
                      elseif ( $is_interface_login && $valid_username_check != 'valid' ) {
                      $update_config_error = 'Interface Login USERNAME requirements NOT met  (' . $valid_username_check . ')';
                      }
                      elseif ( $is_interface_login && $password_strength_check != 'valid' ) {
                      $update_config_error = 'Interface Login PASSWORD requirements NOT met  (' . $password_strength_check . ')';
                      }
                      // If we made it this far, we passed all checks
                      else {
                      $update_config_valid = true;
                      }
                   
                   
                   }
                   // If we are NOT forcing a particular validation check, flag as passed
                   else {
                   $update_config_valid = true;
                   }
                    
                    
                   // Update the corrisponding admin config section
                   if ( $update_config_valid ) {
                       
                       if ( $is_plugin_config ) {
                       $ct['conf']['plug_conf'][ $parse_plugin_data[1] ] = $field_array_base;
                       }
                       else {
                       $ct['conf'][ $_POST['conf_id'] ] = $field_array_base;
                       }
                    
                   $update_config = true; // Triggers saving updated config to disk
                   
                   $update_config_success = 'Updating of "' . $ct['gen']->key_to_name($_POST['interface_id']) . '" ' . $update_desc . ' settings SUCCEEDED.';
                   
                   }
                   else {
                   $update_config_error = 'Updating of "' . $ct['gen']->key_to_name($_POST['interface_id']) . '" ' . $update_desc . ' settings FAILED. ' . $update_config_error;
                   }
                   
                    
              }
                    
        }
        // General error messages to display at top of page for UX
        elseif ( isset($_POST['conf_id']) && isset($_POST['interface_id']) ) {
          
              if ( $check_2fa_error ) {
              $update_config_error =  'Updating of "' . $ct['gen']->key_to_name($_POST['interface_id']) . '" ' . $update_desc . ' settings FAILED. ' . $check_2fa_error . '.';
              }
          
        }
   
   
   }
   
   
   ////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////
   
   

}


// DON'T LEAVE ANY WHITESPACE AFTER THE CLOSING PHP TAG!

?>