<?php
//function to create a new event
function evr_new_event(){
    global $wpdb, $wp_version;
   
    $editor_settings= array('wpautop','media_buttons' => false,'textarea_rows' => '4');               
    
?>
<script>
 var tinymceConfigs = [ {
                        theme : "advanced",        
                        mode : "none",        
                        language : "en",        
                        height:"200",        
                        width:"100%",        
                        theme_advanced_layout_manager : "SimpleLayout",        
                        theme_advanced_toolbar_location : "top",        
                        theme_advanced_toolbar_align : "left",        
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",        
                        theme_advanced_buttons2 : "",        
                        theme_advanced_buttons3 : "" },
                            { 
                                theme : "advanced",        
                                mode : "none",        
                                language : "en",        
                                height:"200",        
                                width:"100%",        
                                theme_advanced_layout_manager : "SimpleLayout",        
                                theme_advanced_toolbar_location : "top",        
                                theme_advanced_toolbar_align : "left"
                                }];
 function tinyfy(settingid,el_id) {    
                        tinyMCE.settings = tinymceConfigs[settingid];    
                        tinyMCE.execCommand('mceAddControl', true, el_id);}
</script>


                    
<a href="#?w=900" rel="popup0" class="poplight evr_button evr_add"><?php _e('ADD EVENT','evr_language');?></a>

<?php //evr_check_form_submission();?>

<div id="popup0" class="popup_block" style="width:950px;height:80%;overflow:auto;">
<form id="er_popup_Form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">                        
<div class="evr_container">
	<h1><?php _e('ADD NEW EVENT','evr_language');?></h1>
    <ul class="tabs">
        <li><a href="#tab1"><?php _e('Event Description','evr_language');?></a></li>
        <li><a href="#tab2"><?php _e('Event Venue','evr_language');?></a></li>
        <li><a href="#tab3"><?php _e('Event Date/Time','evr_language');?></a></li>
        <li><a href="#tab4"><?php _e('Options','evr_language');?></a></li>
        <li><a href="#tab5"><?php _e('Coordinator','evr_language');?></a></li>
        <li><a href="#tab6"><?php _e('Confirmation Mail','evr_language');?></a></li>
    </ul>
    <div class="evr_tab_container">
        <div id="tab1" class="tab_content">
            
            <input type="hidden" name="action" value="post">
            <table>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Use a concise but descriptive name.','evr_language');?>">
                    <?php _e('Event Name/Title ','evr_language');?><a><span>?</span></a></label>
                    </td>
                    <td>
                    <input class="title" name="event_name" size="50"/>
                    </td>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Provide a short Unique ID for this event. i.e. BOB001','evr_language');?>">
                    <?php _e('Unique Event Identifier','evr_language');?>  <a><span>?</span></a></label> 
                    </td>
                    <td>
                    <input name="event_identifier" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <label class="tooltip" title="<?php _e('If you want the description to display under the event title on the registration form, select yes.','evr_language');?>">
                    <?php _e('Display description on registration form page? ','evr_language');?><a><span>?</span></a></label>
                    <label for="display_desc"><input type="radio" class="radio" name="display_desc" value="Y"><?php _e('Yes','evr_language');?></label>
                    <label for="display_desc"><input type="radio" class="radio" name="display_desc" value="N"><?php _e('No','evr_language');?></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <label for="event_desc" class="tooltip" title="<?php _e('Provide a detailed description of the event, 
                    include key details other than when and where. Do not use any html code. This is a text only display.
                    To create new display lines just press Enter.','evr_language');?>">
                    <?php _e('Detailed Event Description','evr_language');?> <a><span>?</span></a>
                    
                    <?php
                   	if (function_exists('wp_editor')){
					echo "</td></tr></table>";
                    wp_editor( '', 'event_desc', $editor_settings );
                                     
				    }else{ ?>
					
                    <a href="javascript:void(0)" onclick="tinyfy(1,'event_desc')"><input type="button" value="WYSIWG"/></a>
                    </td></tr></table>
                    <textarea name="event_desc" id="event_desc" style="width: 100%; height: 200px;"></textarea>
                    <?php }  ?>
                    
                                    
                    
              <br>      
              <hr />
              <table><tr></tr>
                
                <tr>
                    <td colspan="2">
                    <label class="tooltip" title="<?php _e('Select one or many categories for an event','evr_language');?>">
                    <strong><?php _e('Event Categories','evr_language');?> </strong> <a><span> ?</span></a></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <?php 
                    $sql = "SELECT * FROM ". get_option('evr_category');
                    $result = mysql_query ($sql);
                    while ($row = mysql_fetch_assoc ($result)){
                    $category_id= $row['id'];
                    $category_name=$row['category_name'];
                    echo '<label for="in-event-category-'.$category_id.'"><input class="checkbox" value="'.$category_id.'" type="checkbox" name="event_category[]" id="in-event-category-'.$category_id.'"'. ($checked ? ' checked="checked"' : "" ). '/>  '."&nbsp;". $category_name. "</label>&nbsp;&nbsp;&nbsp; ";
                    }
                    ?>
                    </td>
                </tr>
            </table>
            <hr />
    </div>
    <div id="tab2" class="tab_content">
            <h2><?php _e('EVENT VENUE','evr_language');?></h2>
            <table>
                   <tr>
                    <td>
                    <label  class="tooltip" title="<?php _e('Enter the number of available seats at your event venue. Leave blank if their is no limit on registrations.','evr_language');?>" for="reg_limit">
                    <?php _e('Event Seating Capacity','evr_language');?> <a><span>?</span></a>
                    </td>
                    <td>
                    <input  class="count" name="reg_limit">
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Enter the name of the business or facility where the event is being held','evr_language');?>" for="event_location">
                    <?php _e('Event Location/Venue','evr_language');?><a><span> ?</span></a></label>
                    </td>
                    <td>
                    <input class= "title" id="event_location" name="event_location" type="text" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="first" for="event_street"><?php _e('Street','evr_language');?></label>
                    </td>
                    <td>
                    <input  class= "title" id="event_street" name="event_street" type="text" value="Street" />
                    </td>
                </tr>		
				<tr>
                    <td><label for="event_city">
					<?php _e('City','evr_language');?></label></td><td><input id="event_city" name="event_city" type="text" value="City" /></td></tr>
                <tr>
                    <td><label for="event_state">
					<?php _e('State','evr_language');?></label></td><td><input id="event_state" name="event_state" type="text" value="State" /></td></tr>
                <tr>
                    <td>
                    <label for="event_postcode">
					<?php _e('Postcode','evr_language');?></label>
                    </td>
                    <td>
                    <input id="event_postcode" name="event_postcode" type="text" value="Postcode" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <legend class="tooltip" title="<?php _e('All location information must be complete for Google Map feature to work.','evr_language');?>">
					<?php _e('Use Google Maps On Registration Page','evr_language');?> <a><span>?</span></a></legend>
                    </td>
                    <td>
                    <label for="google_map_yes"><input type="radio" class="radio" name="google_map" value="Y" checked><?php _e('Yes','evr_language');?></label>
                    <label for="google_map_no"><input type="radio" class="radio" name="google_map" value="N"><?php _e('No','evr_language');?>
                    </label>
                    </td>
                </tr> </table>
        </div>
        <div id="tab3" class="tab_content">
            <h2><?php _e('EVENT TIMES','evr_language');?></h2>
          	              <table><tr>
                        <td><b><?php _e('Start Date','evr_language');?></b></td>
                        <?php 
                        $start = strtotime('6:00am');
                        $end = strtotime('11:45pm');
                        ?>
                        <td><label  for="start_date"><?php evr_DateSelector( "\"start"); ?></label></td>
                        <td><b><?php _e('Start Time','evr_language');?></b></td><td><label for="start_time"><?php 
                            echo '<select name="start_time">';
                            for ($i = $start; $i <= $end; $i += 900)
                            {echo '<option>' . date('g:i a', $i);}
                            echo '</select>';
                            ?></label></td>
                        </tr>
                        <tr><td><b><?php _e('End Date','evr_language');?></b></td><td><label for="end_date"><?php evr_DateSelector( "\"end"); ?></label></td>
                        <td><b><?php _e('End Time','evr_language');?></b></td><td><label for="end_time"><?php
                            echo '<select name="end_time">';
                            for ($i = $start; $i <= $end; $i += 900)
                            { echo '<option>' . date('g:i a', $i); }
                            echo '</select>';?></label></td>
                        </tr>
                    </table>
        </div>

        <div id="tab4" class="tab_content">
            <table>
                <tr>
                    <td colspan="2">
                    <br />
                    <label class="tooltip" title="<?php _e('If you will accept checks or cash, usually when accepting payment at event/on-site.','evr_language');?>">
   					<?php _e('Will you accept checks/cash for this event? ','evr_language');?><a><span>?</span></a></label>
                    <label for="accept_checks"><input type="radio" name="allow_checks" class="radio" id="accept_checks_yes" value="Y" /><?php _e('Yes','evr_language');?></label>
                    <label for="accept_chacks"><input type="radio" name="allow_checks" class="radio" id="accept_checks_no" value="N" checked /><?php _e('No ','evr_language');?></label>
                    </td>
                </tr>
            
            
                <tr>
                    <td colspan="2">
                    <br />
                    <label class="tooltip" title="<?php _e('You can point your register now button to an external registration site/page by selecting yes and entering the url!','evr_language');?>">
                    <?php _e('Are you using an external registration?','evr_language');?> <a><span>?</span></a></label>
                    <label><input type="radio" name="outside_reg" class="radio" id="outside_reg_yes" value="Y" /><?php _e('Yes','evr_language');?> 
                    </label><label><input type="radio" name="outside_reg" class="radio" id="outside_reg_no" value="N" checked /><?php _e('No','evr_language');?> 
                    </label></td>
                </tr>
                <tr>
                    <td  colspan="2">
                    <label class="tooltip" title="<?php _e('Enter the url hyperlink to another webpage or website external registration','evr_language');?>">
                    <?php _e('External registration URL','evr_language');?> <a><span> ?</span></a><input class= "title" id="external_site" name="external_site" type="text" /></label> 
                    </td>
                </tr>
                <tr></tr>
                 <tr></tr>
                  <tr></tr>
                <tr>
                    <td colspan="2">
                    <legend class="tooltip" title="<?php _e('Select the default fields for the registration form.  Note that name and email or not optional','evr_language');?>" >
                    <?php _e('Default Registration Information (Name and Email Required)','evr_language');?><a><span> ?</span></a></legend>
                    </td>
                </tr>
                <tr>
                   <td colspan="2">
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Address" checked /><?php _e('Street Address','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="City" checked /><?php _e('City','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="State" checked /><?php _e('State or Province','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Zip" checked /><?php _e('Zip or Postal Code','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Phone" checked /><?php _e('Phone Number','evr_language');?></label>
                 </tr>
                 <tr>
                   <td colspan="2">
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Company" checked /><?php _e('Company','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="CoAddress" checked /><?php _e('Co. Addr','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="CoCity" checked /><?php _e('Co. City','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="CoState" checked /><?php _e('Co. State/Prov','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="CoPostal" checked /><?php _e('Co. Postal','evr_language');?></label>
                   </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                
                
        </table>
        <hr />
        <br />
        <h3><?php _e('Event Listing Options','evr_language');?>  <font color="red"><?php _e('Optional','evr_language');?></font></h3>
        <table>
                 <tr>
                <td>
                <label class="tooltip" title="<?php _e('Enter the url hyperlink to another webpage or website with more event information','evr_language');?>">
                <?php _e('More Info URL','evr_language');?> <a><span> ?</span></a>
                </td>
                <td>
                <input class= "title" id="event_location" name="more_info" type="text" /></label>
                </td>
            </tr>
            <tr>
                <td><label class="tooltip" title="<?php _e('Enter the url to an image you would like displayed next to the event in the event listings. Size should be 150 x112','evr_language');?>">
                <?php _e('Thumbnail Image URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="event_location" name="image_link" type="text" />
				    </label>
                </td>
            </tr>
            <tr>
                <td><label class="tooltip" title="<?php _e('Enter the url of an image you wish displayed above the registration form.  The image should be no wider than 450.','evr_language');?>">
                <?php _e('Header Image URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="event_location" name="header_image" type="text" /></label>
                </td>
            </tr>
        </table>
    </div>
    
    <?php if (get_option('evr_coordinator_active')=="Y"){ ?>
        <div id="tab5" class="tab_content">
            <h2><?php _e('Coordinator Options','evr_language');?></h2>
            <label  class="tooltip" title="<?php _e('If you want to send alerts to a unique event coordinator','evr_language');?>">
            <?php _e('Do you want to send alerts to a coordinator for this event?','evr_language');?> <a><span>?</span></a></label>
            <label><input type="radio" name="send_coord" class="radio" id="send_coord_yes" value="Y" /><?php _e('Yes','evr_language');?>
            </label><label><input type="radio" name="send_coord" class="radio" id="send_coord_no" value="N" checked /><?php _e('No','evr_language');?> 
            </label><br />
            <br /> 
            <table>
            <tr>
            <td><label for="contact"><?php _e('Coordinator email:','evr_language');?></label></td>
            <td><input name="coord_email" type="text" size="65" value="<?php echo $company_options['company_email'];?>" class="regular-text" /></td>
        </tr></table>
            <br />
            <br />
            <label  class="tooltip" title="<?php _e('Enter the text for the registration alert email.  This email will be sent in text format.  See User Manual for data tags.','evr_language');?>" >
            <?php _e('Coordinator Registration Alert Email','evr_language');?> <a><span>?</span></a></label>
            <?php
                $body = "***This is an automated response - Do Not Reply***<br />
                        [fname] [lname] has registered for [event].<br />
                        Registration is for [num_people] person(s) for a total of [cost].";     
                
            if (function_exists('wp_editor')){
					wp_editor( $body, 'coord_msg', $editor_settings );
                                     
				    }else{ ?>
					<a href="javascript:void(0)" onclick="tinyfy(1,'coord_msg')"><input type="button" value="WYSIWG"/></a>
                        <textarea name="coord_msg" id="coord_msg" style="width: 100%; height: 200px;"><?php echo $body;?></textarea>
                    
                    <?php }  ?>   
               
               
                          
            
            <br />
            <br />
            
            <label  class="tooltip" title="<?php _e('Enter the text for the payment alert email.  This email will be sent in text format.  See User Manual for data tags.','evr_language');?>" >
            <?php _e('Coordinator Payment Alert Email','evr_language');?> <a><span>?</span></a></label>
            <?php
                $body = "***This is an automated response - Do Not Reply***<br />An instant payment notification was 
                successfully posted from [payer_email] on behalf of [fname] [lname] ([attendee_email])  for event 
                [event_name]([event_id]) on [pay_date] at [pay_time].<br />Details: [details]";    
                
                
                	if (function_exists('wp_editor')){
					wp_editor( $body, 'coord_pay_msg', $editor_settings );
                                     
				    }else{ ?>
					<a href="javascript:void(0)" onclick="tinyfy(1,'coord_pay_msg')"><input type="button" value="WYSIWG"/></a>
                        <textarea name="coord_pay_msg" id="coord_pay_msg" style="width: 100%; height: 200px;"><?php echo $body;?></textarea>
                    
                    <?php }  ?>
                
                
                     
        </div>
        <?php } else { ?>
             <div id="tab5" class="tab_content">
                <h2><?php _e('Coordinator Options','evr_language');?></h2>
                <font color="red">This feature is available in an add on module.</font>
                <ul>
                <li>Option to send unique email to a unique coordinators email address for each event registration.</li>
                <li>WYSIWYG editor for coordinator's email registration alert.</li>
                <li>Option to send unique email to a unique coordinators email address for each event payment recieved via PayPal IPN.</li>
                <li>WYSIWYG editor for coordinator's email payment notification alert.</li>
                </ul>
            </div>
      <?php  } ?>
                <div id="tab6" class="tab_content">
            <h2><?php _e('Confirmation eMail','evr_language');?></h2>
            <label  class="tooltip" title="<?php _e('If you want to use a custom email for confirmation','evr_language');?>">
            <?php _e('Do you want to use a custom email for this event?','evr_language');?> <a><span>?</span></a></label>
            <label><input type="radio" name="custom_mail" class="radio" id="accept_checks_yes" value="Y" /><?php _e('Yes','evr_language');?>
            </label><label><input type="radio" name="custom_mail" class="radio" id="accept_checks_no" value="N" checked /><?php _e('No','evr_language');?> 
            </label><br />
            <br />          
            <label  class="tooltip" title="<?php _e('Enter the text for the confirmation email.  This email will be sent in text format.  See User Manual for data tags.','evr_language');?>" >
            <?php _e('Custom Confirmation Email','evr_language');?> <a><span>?</span></a></label>
            <?php
            $body = "***This is an automated response - Do Not Reply***<br />
                        Thank you [fname] [lname] for registering for [event].<br />
                        We hope that you will find this event both informative and enjoyable.
                        Should have any questions, please contact [contact].
                        If you have not done so already, please submit your payment in the amount of [cost].
                        Click here to review your payment information [payment_url].<br />
                        Thank You.";     
                
              
           	if (function_exists('wp_editor')){
					wp_editor( $body, 'conf_mail', $editor_settings );
                                     
				    }else{ ?>
					<a href="javascript:void(0)" onclick="tinyfy(1,'conf_mail')"><input type="button" value="WYSIWG"/></a>
                        <textarea name="conf_mail" id="conf_mail" style="width: 100%; height: 200px;"><?php echo $body;?></textarea>
                    
                    <?php }  ?>
                 
            <br />
            <br />         
            <input  type="submit" name="Submit" value="<?php _e('Submit New Event','evr_language'); ?>" id="add_new_event" />
            </form>
        </div>
    </div>
</div>
<div style="clear: both; display: block; padding: 10px 0; text-align:center;"><font color="blue"><?php _e('Please make sure you complete each section before submitting!','evr_language');?></font></div>

</div>
<?php
}

function evr_prep_content($content='') {
    return wpautop(stripslashes_deep(html_entity_decode($content, ENT_QUOTES, "UTF-8")));
}
?>