<?php
//function to edit an existing event built into event listing page.
function evr_edit_event(){
    global $wpdb;
    require ("evr_tab_incl.php");
	$event_id = $_REQUEST['id'];
	$sql = "SELECT * FROM ". get_option('evr_event') ." WHERE id = $event_id";
                    		$result = mysql_query ($sql);
                            while ($row = mysql_fetch_assoc ($result)){  
                         
                            $event_id       = $row['id'];
                    	    $event_name = stripslashes($row['event_name']);
        					$event_identifier = stripslashes($row['event_identifier']);
        					$display_desc = $row['display_desc'];  // Y or N
                            $event_desc = stripslashes($row['event_desc']);
                            $event_category = unserialize($_REQUEST['event_category']);
        					$reg_limit = $row['reg_limit'];
        					$event_location = stripslashes($row['event_location']);
                            $event_address = $row['event_address'];
                            $event_city = $row['event_city'];
                            $event_state =$row['event_state'];
                            $event_postal=$row['event_postal'];
                            $google_map = $row['google_map'];  // Y or N
                            $start_month = $row['start_month'];
        					$start_day = $row['start_day'];
        					$start_year = $row['start_year'];
                            $end_month = $row['end_month'];
        					$end_day = $row['end_day'];
        					$end_year = $row['end_year'];
                            $start_time = $row['start_time'];
        					$end_time = $row['end_time'];
                            $allow_checks = $row['allow_checks'];
                            $outside_reg = $row['outside_reg'];  // Yor N
                            $external_site = $row['external_site'];
                            $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            $more_info = $row['more_info'];
        					$image_link = $row['image_link'];
        					$header_image = $row['header_image'];
                            $event_cost = $row['event_cost'];
                            
                            $allow_checks = $row['allow_checks'];
                            
        					$is_active = $row['is_active'];
        					$send_mail = $row['send_mail'];  // Y or N
        					$conf_mail = stripslashes($row['conf_mail']);
        					
                            $start_date = $row['start_date'];
                            $end_date = $row['end_date'];
                            
                            $event_category =  unserialize($row ['category_id']);
                            if ($event_category ==""){$event_category = array();}
             
                            
                            $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            if ($reg_form_defaults !=""){
                            if (in_array("Address", $reg_form_defaults)) {$inc_address = "Y";}
                            if (in_array("City", $reg_form_defaults)) {$inc_city = "Y";}
                            if (in_array("State", $reg_form_defaults)) {$inc_state = "Y";}
                            if (in_array("Zip", $reg_form_defaults)) {$inc_zip = "Y";}
                            if (in_array("Phone", $reg_form_defaults)) {$inc_phone = "Y";}
                            }
                        
                            //set reg limit if not set
                            if ($reg_limit == ''){$reg_limit = 999;} 
                            
                            $sql2= "SELECT * FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
                             $result2 = mysql_query($sql2);
            			     $num = mysql_num_rows($result2);
                             $number_attendees = $num;
            				
            				if ($number_attendees == '' || $number_attendees == 0){
            					$number_attendees = '0';
            				}
            				
            				if ($reg_limit == "" || $reg_limit == " "){
            					$reg_limit = "Unlimited";}
                               $available_spaces = $reg_limit;
            				
            					
            			if ($start_date <= date('Y-m-d')){
            					$active_event = '<span style="color: #F00; font-weight:bold;">'.__('EXPIRED EVENT','evr_language').'</span>';
            				} else{
            					$active_event = '<span style="color: #090; font-weight:bold;">'.__('ACTIVE EVENT','evr_language').'</span>';
            				} 
                            
                            }
                            
	
	
	    
?>
	

<br />
<div class="container">
	<h2><?php _e('EDIT','evr_language');?> <?php echo $event_name." ".$active_event;?></h2>
    <ul class="tabs">
        <li><a href="#tab1"><?php _e('Event Description','evr_language');?></a></li>
        <li><a href="#tab2"><?php _e('Event Venue','evr_language');?></a></li>
        <li><a href="#tab3"><?php _e('Event Date/Time','evr_language');?></a></li>
        <li><a href="#tab4"><?php _e('Options','evr_language');?></a></li>
        <li><a href="#tab5"><?php _e('Confirmation Mail','evr_language');?></a></li>
    </ul>
    <div class="tab_container">
 <div id="tab1"class="tab_content">
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="event_id" value="<?php echo $event_id;?>">
            <table>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Use a concise but descriptive name.','evr_language');?>">
                    <?php _e('Event Name/Title ','evr_language');?><a><span>?</span></a></label>
                    </td>
                    <td>
                    <input class="title" name="event_name" size="50" value="<?php echo $event_name;?>"/>
                    </td>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Provide a short Unique ID for this event. i.e. BOB001','evr_language');?>">
                    <?php _e('Unique Event Identifier','evr_language');?>  <a><span>?</span></a></label> 
                    </td>
                    <td>
                    <input name="event_identifier" value="<?php echo $event_identifier;?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <label class="tooltip" title="<?php _e('If you want the description to display under the event title on the registration form, select yes.','evr_language');?>">
                    <?php _e('Display description on registration form page? ','evr_language');?><a><span>?</span></a></label>
                    <label for="display_desc"><input type="radio" class="radio" name="display_desc" value="Y" <?php if ($display_desc == "Y"){echo "checked";}?> /><?php _e('Yes','evr_language');?></label>
                    <label for="display_desc"><input type="radio" class="radio" name="display_desc" value="N" <?php if ($display_desc == "N"){echo "checked";}?> /><?php _e('No','evr_language');?></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <label for="event_desc" class="tooltip" title="<?php _e('Provide a detailed description of the event, include key details other than when and where. Do not use any html code. This is a text only display. 
To create new display lines just press Enter.','evr_language');?>">
                    <?php _e('Detailed Event Description','evr_language');?> <a><span>?</span></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                                       
                       <script type="text/javascript">    
                       jQuery(document).ready(function($) {        
                        idi = 'event_desc';        
                        jQuery('#descButtonPreview').click(            
                        function() {                
                            tinyMCE.execCommand('mceAddControl', false, idi);                
                            jQuery('#descButtonPreview').addClass('active');                
                            jQuery('#descButtonHTML').removeClass('active');            
                            }        
                            );        
                            jQuery('#descButtonHTML').click(            
                            function() {                
                                tinyMCE.execCommand('mceRemoveControl', false, idi);                
                                jQuery('#descButtonPreview').removeClass('active');                
                                jQuery('#descButtonHTML').addClass('active');            
                                }        
                                );    
                                });    
                        </script>

                    
                      
                   <a id="descButtonHTML"><button type="button">HTML CODE</button></a>    
                   <a id="descButtonPreview" class="active"><button type="button">WYSIWYG</button></a>
                   
                    <textarea rows="5" cols="90" name="event_desc" id="event_desc"  class="edit_class">
          
                    <?php echo $event_desc?></textarea>
                    
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    
                    </td>
                </tr>
              <tr></tr></table>
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
                   /* $sql = "SELECT * FROM ". get_option('evr_category');
                    $result = mysql_query ($sql);
                    
                    while ($row = mysql_fetch_assoc ($result)){
                        $category_id= $row['id'];
                        $category_name=$row['category_name'];
                        $checked = in_array( $category_id, $event_category );
                        echo '<label for="in-event-category-'.$category_id.'"> <input class="checkbox" value="'.$category_id.'" type="checkbox" name="event_category[]" id="in-event-category-'.$category_id.'"'. ($checked ? ' checked="checked"' : "" ). '/>  '."&nbsp;". $category_name. " </label>";
                    
                        }
                        */
                      global $wpdb;
                      $sql = "SELECT * FROM ". get_option('evr_category') ." ORDER BY id ASC";
                      $result = mysql_query ($sql);
                      if (mysql_num_rows($result) > 0 ) {
                      while ($row = mysql_fetch_assoc ($result)){
                 					$category_id= $row['id'];
                 					$category_name=$row['category_name'];
                 					$category_identifier=$row['category_identifier'];
                 					$category_desc=$row['category_desc'];
                 					$display_category_desc=$row['display_desc'];
                                    $category_color = $row['category_color'];
                                    $font_color = $row['font_color'];
                                    $style = "background-color:".$category_color." ; color:".$font_color." ;"; 
                                    $checked = in_array( $category_id, $event_category );
                                    
                        echo '<label for="in-event-category-'.$category_id.'"> <input class="checkbox" value="'.$category_id.'" type="checkbox" name="event_category[]" id="in-event-category-'.$category_id.'"'. ($checked ? ' checked="checked"' : "" ). '/>  '."&nbsp;". $category_name. " </label>";
                     }} else{ _e('No Categories Created!','evr_language');}
                        
                        
                    ?>
                    
                    </td>
                </tr>
            </table>
            <hr />
    </div>
    <div id="tab2"class="tab_content">
            <h2><?php _e('EVENT VENUE','evr_language');?></h2>
            <table>
                   <tr>
                    <td>
                    <label  class="tooltip" title="<?php _e('Enter the number of available seats at your event venue. Leave blank if their is no limit on registrations.','evr_language');?>" for="reg_limit">
                    <?php _e('Event Seating Capacity','evr_language');?> <a><span>?</span></a>
                    </td>
                    <td>
                    <input  class="count" name="reg_limit" value="<?php echo $reg_limit;?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Enter the name of the business or facility where the event is being held','evr_language');?>" for="event_location">
                    <?php _e('Event Location/Venue','evr_language');?><a><span> ?</span></a></label>
                    </td>
                    <td>
                    <input class= "title" id="event_location" name="event_location" type="text" size="50" value="<?php echo $event_location;?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="first" for="event_street"><?php _e('Street','evr_language');?></label>
                    </td>
                    <td>
                    <input  class= "title" id="event_street" name="event_street" type="text" value="<?php echo $event_address;?>" />
                    </td>
                </tr>		
				<tr>
                    <td><label for="event_city">
					<?php _e('City','evr_language');?></label></td><td><input id="event_city" name="event_city" type="text" value="<?php echo $event_city;?>" /></td></tr>
                <tr>
                    <td><label for="event_state">
					<?php _e('State','evr_language');?></label></td><td><input id="event_state" name="event_state" type="text" value="<?php echo $event_state;?>" /></td></tr>
                <tr>
                    <td>
                    <label for="event_postcode">
					<?php _e('Postcode','evr_language');?></label>
                    </td>
                    <td>
                    <input id="event_postcode" name="event_postcode" type="text" value="<?php echo $event_postal;?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <legend class="tooltip" title="<?php _e('All location information must be complete for Google Map feature to work.','evr_language');?>">
					<?php _e('Use Google Maps On Registration Page','evr_language');?> <a><span>?</span></a></legend>
                    </td>
                    <td>
                    <label for="google_map_yes"><input type="radio" class="radio" name="google_map" value="Y" <?php if ($google_map == "Y"){echo "checked";}?> /><?php _e('Yes','evr_language');?></label>
                    <label for="google_map_no"><input type="radio" class="radio" name="google_map" value="N"  <?php if ($google_map == "N"){echo "checked";}?> /><?php _e('No','evr_language');?>
                    </label>
                    </td>
                </tr> </table>
        </div>
        <div id="tab3"class="tab_content">
            <h2>EVENT TIMES</h2>
          	              <table><tr>
                        <td><b><?php _e('Start Date','evr_language');?></b></td>
                        <?php 
                        $start = strtotime('6:00am');
                        $end = strtotime('11:45pm');
                        
                        
                        ?>
                        <td><label  for="start_date"><?php evr_DateSelector( "\"start", strtotime($start_date));?></label></td>
                        <td><b><?php _e('Start Time','evr_language');?></b></td><td><label for="start_time"><?php 
                        echo '<select name="start_time">';
                        
                        if ($start_time != ""){echo '<option>'.$start_time.'</option>';}
                        for ($i = $start; $i <= $end; $i += 900)
                        	{echo '<option>' . date('g:i a', $i);}
                        echo '</select>';
                        ?></label></td>
                        </tr>
                        <tr><td><b><?php _e('End Date','evr_language');?></b></td><td><label for="end_date"><?php evr_DateSelector( "\"end",strtotime($end_date)); ?></label></td>
                        <td><b><?php _e('End Time','evr_language');?></b></td><td><label for="end_time"><?php
                        echo '<select name="end_time">';
                        if ($end_time != ""){echo '<option>'.$end_time.'</option>';}
                        for ($i = $start; $i <= $end; $i += 900)
                        	{ echo '<option>' . date('g:i a', $i); }
                        echo '</select>';?></label></td>
                        </tr>
                    </table>
        </div>

        <div id="tab4"class="tab_content">
            <table>
                <tr>
                    <td colspan="2">
                    <br />
                    <legend  class="tooltip" title="<?php _e('If you will accept checks or cash, usually when accepting payment at event/on-site.','evr_language');?>">
   					<?php _e('Will you accept checks/cash for this event? ','evr_language');?><a><span>?</span></a></legend>
                    <label for="accept_checks"><input type="radio" name="allow_checks" class="radio" id="accept_checks_yes" value="Y" <?php if ($allow_checks == "Y"){echo "checked";};?>/><?php _e('Yes','evr_language');?></label>
                    <label for="free_event_no"><input type="radio" name="allow_checks" class="radio" id="accept_checks_no" value="N" <?php if ($allow_checks == "N"){echo "checked";};?> /><?php _e('No ','evr_language');?></label>
                    </td>
                </tr>
            
            
                <tr>
                    <td colspan="2">
                    <br />
                    <label class="tooltip" title="<?php _e('You can point your register now button to an external registration site/page by selecting yes and entering the url!','evr_language');?>">
                    <?php _e('Are you using an external registration?','evr_language');?> <a><span>?</span></a></label>
                    <input type="radio" name="outside_reg" class="radio" id="outside_reg_yes" value="Y" <?php if ($outside_reg == "Y"){echo "checked";};?>/><?php _e('Yes','evr_language');?> 
                    <input type="radio" name="outside_reg" class="radio" id="outside_reg_no" value="N" <?php if ($outside_reg == "N"){echo "checked";};?> /><?php _e('No','evr_language');?> 
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Enter the url hyperlink to another webpage or website external registration','evr_language');?>">
                    <?php _e('External registration URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="external_site" name="external_site" type="text" value="<?php echo $external_site;?>" /></label> 
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
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Address" <?php if ($inc_address == "Y"){echo "checked";};?> /><?php _e('Street Address','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="City" <?php if ($inc_city == "Y"){echo "checked";};?> /><?php _e('City','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="State" <?php if ($inc_state == "Y"){echo "checked";};?> /><?php _e('State or Province','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Zip" <?php if ($inc_zip == "Y"){echo "checked";};?> /><?php _e('Zip or Postal Code','evr_language');?></label>
                    <label><INPUT class="radio" type="checkbox" name="reg_form_defaults[]" value="Phone" <?php if ($inc_phone == "Y"){echo "checked";};?> /><?php _e('Phone Number','evr_language');?></label>
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
                <input class= "title" id="event_location" name="more_info" type="text" value="<?php echo $more_info;?>" /></label>
                </td>
            </tr>
            <tr>
                <td><label class="tooltip" title="<?php _e('Enter the url to an image you would like displayed next to the event in the event listings. Size should be 150 x112','evr_language');?>">
                <?php _e('Thumbnail Image URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="image_link" name="image_link" type="text" value="<?php echo $image_link;?>" />
				    </label>
                </td>
            </tr>
            <tr>
                <td><label class="tooltip" title="<?php _e('Enter the url of an image you wish displayed above the registration form.  The image should be no wider than 450.','evr_language');?>">
                <?php _e('Header Image URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="header_image" name="header_image" type="text" value="<?php echo $header_image;?>" /></label>
                </td>
            </tr>
        </table>
    </div>
        <div id="tab5"class="tab_content">
            <h2><?php _e('Confirmation eMail','evr_language');?></h2>
            <label  class="tooltip" title="<?php _e('If you have send mail option enabled in the company settings, you can override the default mail by creating a custom mail for this event.','evr_language');?>">
            <?php _e('Do you want to use a custom email for this event?','evr_language');?> <a><span>?</span></a></label>
            <input type="radio" name="send_mail" class="radio" value="Y" <?php if($send_mail == "Y"){echo "checked";};?> /><?php _e('Yes','evr_language');?>
            <input type="radio" name="send_mail" class="radio" value="N" <?php if($send_mail == "N"){echo "checked";};?> /><?php _e('No','evr_language');?> 
            <br />
            <br />          
            <label  class="tooltip" title="<?php _e('Enter the text for the confirmation email.  This email will be sent in text format.  See User Manual for data tags.','evr_language');?>" >
            <?php _e('Custom Confirmation Email','evr_language');?> <a><span>?</span></a></label>
            
            <script type="text/javascript">    
                       jQuery(document).ready(function($) {        
                        id = 'conf_mail';        
                        jQuery('#mailButtonPreview').click(            
                        function() {                
                            tinyMCE.execCommand('mceAddControl', false, id);                
                            jQuery('#mailButtonPreview').addClass('active');                
                            jQuery('#mailButtonHTML').removeClass('active');            
                            }        
                            );        
                            jQuery('#mailButtonHTML').click(            
                            function() {                
                                tinyMCE.execCommand('mceRemoveControl', false, id);                
                                jQuery('#mailButtonPreview').removeClass('active');                
                                jQuery('#mailButtonHTML').addClass('active');            
                                }        
                                );    
                                });    
                        </script>

                    
                       
                   <a id="mailButtonHTML"><button type="button">HTML CODE</button></a>    
                   <a id="mailButtonPreview" class="active"><button type="button">WYSIWYG</button></a>
                   
            <textarea rows='10' cols='90' name='conf_mail' id="conf_mail" class="edit_class">
            <?php echo $conf_mail;?></textarea>
              <br />
            <br />         
            <input  type="submit" name="Submit" value="<?php _e('Update Event','evr_language'); ?>" id="add_new_event" />
            </form>
        </div>
    </div>
</div>
<div style="clear: both; display: block; padding: 10px 0; text-align:center;"><font color="blue"><?php _e('Please make sure you complete each section before submitting!','evr_language');?></font></div>
<div style="clear: both; display: block; padding: 10px 0; text-align:center;">If you find this plugin useful, please contribute to enable its continued development: <a href="http://www.edgetechweb.com/donate">Donate!</div>
<?php 
}
?>