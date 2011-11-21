<?php
//function to create a new event
function evr_new_event(){
    
?>


<a href="#?w=800" rel="popup0" class="poplight"><input type="button" value="<?php _e('ADD EVENT','evr_language');?>"/></a>

<?php //evr_check_form_submission();?>

<div id="popup0" class="popup_block">


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
                        
<div class="container">
	<h1><?php _e('ADD NEW EVENT','evr_language');?></h1>
    <ul class="tabs">
        <li><a href="#tab1"><?php _e('Event Description','evr_language');?></a></li>
        <li><a href="#tab2"><?php _e('Event Venue','evr_language');?></a></li>
        <li><a href="#tab3"><?php _e('Event Date/Time','evr_language');?></a></li>
        <li><a href="#tab4"><?php _e('Options','evr_language');?></a></li>
        <li><a href="#tab5"><?php _e('Confirmation Mail','evr_language');?></a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
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
                    <label for="event_desc" class="tooltip" title="<?php _e('Provide a detailed description of the event, include key details other than when and where. Do not use any html code. This is a text only display. 
To create new display lines just press Enter.','evr_language');?>">
                    <?php _e('Detailed Event Description','evr_language');?> <a><span>?</span></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <a id="descButtonHTML"><button type="button">HTML CODE</button></a>    
                   <a id="descButtonPreview" class="active"><button type="button">WYSIWYG</button></a>
                   
                    <textarea rows="5" cols="90" name="event_desc" id="event_desc"  class="edit_class"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <p align="left">
                    
                    
                    </p>
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
                    <label for="google_map_yes"><input type="radio" class="radio" name="google_map" value="Y"><?php _e('Yes','evr_language');?></label>
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
                    <legend  class="tooltip" title="<?php _e('If you will accept checks or cash, usually when accepting payment at event/on-site.','evr_language');?>">
   					<?php _e('Will you accept checks/cash for this event? ','evr_language');?><a><span>?</span></a></legend>
                    <label for="accept_checks"><input type="radio" name="allow_checks" class="radio" id="accept_checks_yes" value="Y" /><?php _e('Yes','evr_language');?></label>
                    <label for="free_event_no"><input type="radio" name="allow_checks" class="radio" id="accept_checks_no" value="N" checked /><?php _e('No ','evr_language');?></label>
                    </td>
                </tr>
            
            
                <tr>
                    <td colspan="2">
                    <br />
                    <label class="tooltip" title="<?php _e('You can point your register now button to an external registration site/page by selecting yes and entering the url!','evr_language');?>">
                    <?php _e('Are you using an external registration?','evr_language');?> <a><span>?</span></a></label>
                    <input type="radio" name="outside_reg" class="radio" id="outside_reg_yes" value="Y" /><?php _e('Yes','evr_language');?> 
                    <input type="radio" name="outside_reg" class="radio" id="outside_reg_no" value="N" checked /><?php _e('No','evr_language');?> 
                    </td>
                </tr>
                <tr>
                    <td>
                    <label class="tooltip" title="<?php _e('Enter the url hyperlink to another webpage or website external registration','evr_language');?>">
                    <?php _e('External registration URL','evr_language');?> <a><span> ?</span></a></td><td><input class= "title" id="external_site" name="external_site" type="text" /></label> 
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
        <div id="tab5" class="tab_content">
            <h2><?php _e('Confirmation eMail','evr_language');?></h2>
            <label  class="tooltip" title="<?php _e('If you want to use a custom email for confirmation','evr_language');?>">
            <?php _e('Do you want to use a custom email for this event?','evr_language');?> <a><span>?</span></a></label>
            <input type="radio" name="custom_mail" class="radio" id="accept_checks_yes" value="Y" /><?php _e('Yes','evr_language');?>
            <input type="radio" name="custom_mail" class="radio" id="accept_checks_no" value="N" checked /><?php _e('No','evr_language');?> 
            <br />
            <br />          
            <label  class="tooltip" title="<?php _e('Enter the text for the confirmation email.  This email will be sent in text format.  See User Manual for data tags.','evr_language');?>" >
            <?php _e('Custom Confirmation Email','evr_language');?> <a><span>?</span></a></label>
            <br />
            
            <a id="mailButtonHTML"><button type="button">HTML CODE</button></a>    
                   <a id="mailButtonPreview" class="active"><button type="button">WYSIWYG</button></a>
                   
            <textarea rows='10' cols='90' name='conf_mail' id="conf_mail" class="edit_class">
            ***This is an automated response - Do Not Reply***<br />
            Thank you [fname] [lname] for registering for [event].<br />
            We hope that you will find this event both informative and enjoyable.
            Should have any questions, please contact [contact].
            If you have not done so already, please submit your payment in the amount of [cost].
            Click here to reveiw your payment information [payment_url].<br />
            Thank You.
            </textarea>
            
            
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
?>