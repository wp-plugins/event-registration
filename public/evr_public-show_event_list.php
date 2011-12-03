<?php

function evr_show_event_list(){
    
     global $wpdb,$evr_date_format;
	
    $curdate = date ( "Y-m-j" );

	$sql = "SELECT * FROM " . get_option('evr_event')." WHERE str_to_date(end_date, '%Y-%m-%e') >= curdate() ORDER BY str_to_date(start_date, '%Y-%m-%e')";
    
   //$sql = "SELECT * FROM " . get_option('evr_event');
    $result = mysql_query ( $sql );
?>
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
            <a href="#TB_inline?&height=600&width=800&inlineId=popup<?php echo $event_id;?>&modal=false" class="thickbox" title="<?php echo $event_name;?>">
            <?php echo $event_name;?></a></b></td>
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
?>