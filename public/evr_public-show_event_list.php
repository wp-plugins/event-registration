<?php

function evr_show_event_list(){
    
     global $wpdb,$evr_date_format;
	
    $curdate = date ( "Y-m-j" );

	$sql = "SELECT * FROM " . get_option('evr_event')." WHERE str_to_date(end_date, '%Y-%m-%e') >= curdate() ORDER BY str_to_date(start_date, '%Y-%m-%e')";
    
   //$sql = "SELECT * FROM " . get_option('evr_event');
    $result = mysql_query ( $sql );
    
?>
<style>
.thickbox{height:300px;width:300px;}
</style>
<div class="evr_event_list">
<b>Click on Event Name for description/registration</b>
<table class="evr_events">
<thead>
    <tr><th>EVENT</th><th></th><th width="8"><?php echo "     ";?></th><th>START</th><th>-</th><th>END</th></tr>
</thead>
<tbody>
<?php
   $color_row= "1";
   $month_no = $end_month_no = '01';  
   $start_date = $end_date = '';
   while ( $row = mysql_fetch_assoc ( $result ) ) {
		            $event_id= $row['id'];
			        $event_name =  stripslashes($row ['event_name']);
					$event_identifier =  stripslashes($row ['event_identifier']); 
					$event_desc =  stripslashes($row ['event_desc']);  
					$start_date = $row['start_date'];
                    $end_date = $row['end_date'];
					$start_month = $row ['start_month'];
					$start_day = $row ['start_day'];
					$start_year = $row ['start_year'];
					$end_month = $row ['end_month'];
					$end_day = $row ['end_day'];
					$end_year = $row ['end_year'];
					$start_time = $row ['start_time'];
					$end_time = $row ['end_time'];
                    $outside_reg = $row['outside_reg'];  // Yor N
                            $external_site = $row['external_site'];  
					
		          
	    
		$sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
		$result2 = mysql_query($sql2);
                $num = 0;   
		while($row = mysql_fetch_array($result2)){$num =  $row['SUM(quantity)'];};
        
        $available_spaces = 0;  
		if ($reg_limit != ""){$available_spaces = $reg_limit - $num;}
	    if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "UNLIMITED";}
     
     


        if($color_row==1){ ?> <tr class="odd"> <?php } else if($color_row==2){ ?> <tr class="even"> <?php } 
        ?>
            <td class="er_title er_ticket_info"><b>
            <?php $company_options = get_option('evr_company_settings');
            if ($company_options['event_pop']=="N"){
                if ($outside_reg == "Y"){  echo '<a href="'.$external_site.'">' ;
	}  else {
                echo '<a href="'.evr_permalink($company_options['evr_page_id']).'action=register&event_id='.$event_id.'">';
                
                
                
                }}
            else {?>
            
           <a class="thickbox" href="#TB_inline?height=640&width=650&inlineId=popup<?php echo $event_id;?>&modal=false"  title="<?php echo $event_name;?>">
          <!--  //use this for fancybox window
          <a href="#?w=800" rel="popup<?php echo $event_id;?>" class="poplight"> -->
            
            <?php } echo $event_name;?></a></b></td>
            <td></td><td></td>
            <td class="er_date"><?php echo date($evr_date_format,strtotime($start_date))." ".$start_time;?> </td><td>-</td>
            <td class="er_date"><?php if ($end_date != $start_date) {echo date($evr_date_format,strtotime($end_date));} echo " ".$end_time;?></td></tr>
            
           
            <?php  if ($color_row ==1){$color_row = "2";} else if ($color_row ==2){$color_row = "1";}
        }
        ?>
    </tbody></table></div>
   
    
    <?php 
    $company_options = get_option('evr_company_settings');
    //Section for popup listings
    
    //$sql = "SELECT * FROM " . get_option('evr_event') ." WHERE str_to_date(start_date, '%Y-%m-%e') >= curdate() ORDER BY str_to_date(start_date, '%Y-%m-%e')";
      
      //$sql = "SELECT * FROM " . get_option('evr_event');
                    	//	$result = mysql_query ($sql);
                        	$sql = "SELECT * FROM " . get_option('evr_event');
    
   //$sql = "SELECT * FROM " . get_option('evr_event');
    $result = mysql_query ( $sql );
                            while ($row = mysql_fetch_assoc ($result)){  
                            $event_id = $row['id'];
                            $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            if ($reg_form_defaults !=""){
                            if (in_array("Address", $reg_form_defaults)) {$inc_address = "Y";}
                            if (in_array("City", $reg_form_defaults)) {$inc_city = "Y";}
                            if (in_array("State", $reg_form_defaults)) {$inc_state = "Y";}
                            if (in_array("Zip", $reg_form_defaults)) {$inc_zip = "Y";}
                            if (in_array("Phone", $reg_form_defaults)) {$inc_phone = "Y";}
                            }
                        $use_coupon = $row['use_coupon'];
                        $reg_limit = $row['reg_limit'];
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
                            $event_postal=$row['event_postcode'];
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
                        
                            
                            $sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
                             $result2 = mysql_query($sql2);
            			     //$num = mysql_num_rows($result2);
                             //$number_attendees = $num;
                             while($row = mysql_fetch_array($result2)){
                                $number_attendees = $row['SUM(quantity)'];
                                }
            				
            				if ($number_attendees == '' || $number_attendees == 0){
            					$number_attendees = '0';
            				}
            				
            				if ($reg_limit == "" || $reg_limit == " "){
            					$reg_limit = "Unlimited";}
                               $available_spaces = $reg_limit;
                               
                               //div for popup goes here.
                            include "evr_event_popup_pop.php";
                              }         
                               
            				
            					
            			
}

function evr_show_event_accordian(){
      
global $wpdb,$evr_date_format;
$curdate = date ( "Y-m-j" );
$sql = "SELECT * FROM " . get_option('evr_event')." WHERE str_to_date(end_date, '%Y-%m-%e') >= curdate() ORDER BY str_to_date(start_date, '%Y-%m-%e')";
   
?>
<style>
*, * focus {
	outline: none;
	margin: 0;
	padding: 0;
}

.evr_acrdn_container {
	width: 95%;
	margin: 0 auto;
    padding: 0;
	line-height: 1.7em;
}
h1 {
	font: 4em normal Georgia, 'Times New Roman', Times, serif;
	text-align:center;
	padding: 20px 0;
	color: #aaa;
}
h1 span { color: #666; }
h1 small{
	font: 0.3em normal Verdana, Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	letter-spacing: 0.5em;
	display: block;
	color: #666;
}

h2.evr_acrdn_trigger {
	padding: 0;	margin: 0 0 5px 0;
	background: url(h2_trigger_1.gif) no-repeat;
    background-color: black;
	height: 46px;	line-height: 46px;
	width: 95%;
	font-size: 2em;
	font-weight: normal;
	float: left;
}
h2.evr_acrdn_trigger a {
	color: #fff;
	text-decoration: none;
	display: block;
	padding: 0 0 0 50px;
}
h2.evr_acrdn_trigger a:hover {
	color: #ccc;
}
h2.evr_acrdn_active {background-position: left bottom;}
.evr_acrdn_sub_container {
	margin: 0 0 5px; padding: 0;
	overflow: hidden;
	font-size: 1.2em;
	width: 90%;
	clear: both;
	background: #f0f0f0;
	border: 1px solid #d6d6d6;
	-webkit-border-bottom-right-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	-moz-border-radius-bottomright: 5px;
	-moz-border-radius-bottomleft: 5px;
	border-bottom-right-radius: 5px;
	border-bottom-left-radius: 5px; 
}
.evr_acrdn_sub_container .block {
	padding: 20px;
}
.evr_acrdn_sub_container .block p {
	padding: 5px 0;
	margin: 5px 0;
}
.evr_acrdn_sub_container h3 {
	font: 2.5em normal Georgia, "Times New Roman", Times, serif;
	margin: 0 0 10px;
	padding: 0 0 5px 0;
	border-bottom: 1px dashed #ccc;
}
.evr_acrdn_sub_container img {
	float: left;
	margin: 10px 15px 15px 0;
	padding: 5px;
	background: #ddd;
	border: 1px solid #ccc;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function() {
	
//Set default open/close settings
jQuery('.evr_acrdn_sub_container').hide(); //Hide/close all containers
jQuery('.evr_acrdn_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
jQuery('.evr_acrdn_trigger').click(function(){
	if( jQuery(this).next().is(':hidden') ) { //If immediate next container is closed...
		jQuery('.evr_acrdn_trigger').removeClass('evr_acrdn_active').next().slideUp(); //Remove all .evr_acrdn_trigger classes and slide up the immediate next container
		jQuery(this).toggleClass('evr_acrdn_active').next().slideDown(); //Add .evr_acrdn_trigger class to clicked trigger and slide down the immediate next container
	}
	return false; //Prevent the browser jump to the link anchor
});

});
</script>


<div class="evr_acrdn_container">

<?php
   $company_options = get_option('evr_company_settings');
   $month_no = $end_month_no = '01';  
   $start_date = $end_date = '';
   $result = mysql_query ( $sql );
   while ($row = mysql_fetch_assoc ($result)){  
                            $event_id = $row['id'];
                            $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            if ($reg_form_defaults !=""){
                            if (in_array("Address", $reg_form_defaults)) {$inc_address = "Y";}
                            if (in_array("City", $reg_form_defaults)) {$inc_city = "Y";}
                            if (in_array("State", $reg_form_defaults)) {$inc_state = "Y";}
                            if (in_array("Zip", $reg_form_defaults)) {$inc_zip = "Y";}
                            if (in_array("Phone", $reg_form_defaults)) {$inc_phone = "Y";}
                            }
                        $use_coupon = $row['use_coupon'];
                        $reg_limit = $row['reg_limit'];
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
                            $event_postal=$row['event_postcode'];
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
                        
                            
                            $sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
                             $result2 = mysql_query($sql2);
            			     //$num = mysql_num_rows($result2);
                             //$number_attendees = $num;
                             while($row = mysql_fetch_array($result2)){
                                $number_attendees = $row['SUM(quantity)'];
                                }
            				
            				if ($number_attendees == '' || $number_attendees == 0){
            					$number_attendees = '0';
            				}
            				
            				if ($reg_limit == "" || $reg_limit == " "){
            					$reg_limit = "Unlimited";}
                               $available_spaces = $reg_limit;
                               
                               //div for popup goes here.
                            include "evr_public_event_accordian.php";
                              }         
                               
            				
            					
?>

</div>

<?php
            			
}
?>