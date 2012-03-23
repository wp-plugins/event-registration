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
                echo '<a href="'.evr_permalink($company_options['evr_page_id']).'action=evregister&event_id='.$event_id.'">';
                
                
                
                }}
            else {?>
            
         <!--   <a class="thickbox" href="#TB_inline?height=640&width=650&inlineId=popup<?php echo $event_id;?>&modal=false"  title="<?php echo $event_name;?>">
           //use this for fancybox window-->
          <a href="#?w=700" rel="popup<?php echo $event_id;?>" class="poplight"> 
            
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
section 
{
	display: block;
} 

.evr_accordion
{
	background-color: #eee;
 	border: 1px solid #ccc;
	width: 600px;
	padding: 10px;	
	margin: 50px auto;
	
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	
	-moz-box-shadow: 0 1px 0 #999;
	-webkit-box-shadow: 0 1px 0 #999;
	box-shadow: 0 1px 0 #999;
}
 
.evr_accordion section 
{
 	border-bottom: 1px solid #ccc;
	margin: 5px;
	
	background-color: #fff;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
    background-image: -webkit-linear-gradient(top, #fff, #eee);
    background-image:    -moz-linear-gradient(top, #fff, #eee);
    background-image:     -ms-linear-gradient(top, #fff, #eee);
    background-image:      -o-linear-gradient(top, #fff, #eee);
    background-image:         linear-gradient(top, #fff, #eee);
  
  	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

.evr_accordion h2,
 .evr_accordion p
{
	margin: 0;
	
}

.evr_accordion p
{
	padding: 10px;
}
 
.evr_accordion h2 a 
{
	display: block;
	position: relative;
	font: 14px/1 'Trebuchet MS', 'Lucida Sans';
	padding: 10px;
	color: #333;
	text-decoration: none;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

.evr_accordion h2 a:hover 
{
	background: #fff;
}
 
.evr_accordion h2 + div 
{
	height: 0;
	overflow: hidden;
	-moz-transition: height 0.3s ease-in-out;
	-webkit-transition: height 0.3s ease-in-out;
	-o-transition: height 0.3s ease-in-out;
	transition: height 0.3s ease-in-out;	
}

.evr_accordion :target h2 a:after 
{  
    content: '';
	position: absolute;
	right: 10px;
	top: 50%;
	margin-top: -3px;
	border-top: 5px solid #333;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;	
}

.evr_accordion :target h2 + div 
{
/*	height: 100px; */
height: auto;
}

</style>
<div class="evr_accordion">
		
<section id="close">
				<h2><a href="#Close">Click on Event for Details - Click Here to Collaspe All</a></h2>
				<div>
				</div>
			</section>			
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
                            //include "evr_public_event_accordian.php";
                            
                            echo '<section id="'.$event_id.'">';
                			echo '<h2><a href="#'.$event_id.'">'.strtoupper($event_name).'<br/><br/>'.date($evr_date_format,strtotime($start_date))."  -  ";
                        if ($end_date != $start_date) {echo date($evr_date_format,strtotime($end_date));}
                        echo __('&nbsp;&nbsp;&nbsp;&nbsp;Time: ','evr_language')." ".$start_time." - ".$end_time.
                            '</a></h2>';
                			?>	<div>

 <div class="evr_spacer"></div>    
 <div style="text-align: justify;">
    <p><?php echo html_entity_decode($event_desc);?></p>
</div>
<span style="float:right;">
        <a href="<?php echo EVR_PLUGINFULLURL."evr_ics.php";?>?event_id=<?php echo $event_id;?>"><img src="<?php echo EVR_PLUGINFULLURL;?>images/ical-logo.jpg" /></a>
    </span>

                                              
<div class="evr_spacer"><hr /></div>  


<div style="float: left;width: 310px;"><p><b><u>Location</u></b><br/><br/>
                        <?php echo stripslashes($event_location);?><br />
                        <?php echo $event_address;?><br />
                        <?php echo $event_city.", ".$event_state." ".$event_postal;?><br /></p>
                        </div>
<div style="float: right;width: 280px;"> <div id="evr_pop_map"><?php if ($google_map == "Y"){?>
                        <img border="0" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $event_address.",".$event_city.",".$event_state;?>&zoom=14&size=280x180&maptype=roadmap&markers=size:mid|color:0xFFFF00|label:*|<?php echo $event_address.",".$event_city;?>&sensor=false" />
                        <?php } ?>
                        </div></div>		                          
<div id="evr_pop_price"><p><b><u><?php _e('Event Fees','evr_language');?>:</u></b><br /><br />
                        <?php
                        $curdate = date("Y-m-d");
                        $sql2 = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
                        $result2 = mysql_query ( $sql2 );
                            while ($row2 = mysql_fetch_assoc ($result2)){
                                $item_id          = $row2['id'];
                                $item_sequence    = $row2['sequence'];
                                $event_id         = $row2['event_id'];
                                $item_title       = $row2['item_title'];
                                $item_description = $row2['item_description'];
                                $item_cat         = $row2['item_cat'];
                                $item_limit       = $row2['item_limit'];
                                $item_price       = $row2['item_price'];
                                $free_item        = $row2['free_item'];
                                $item_start_date  = $row2['item_available_start_date'];
                                $item_end_date    = $row2['item_available_end_date'];
                                $item_custom_cur  = $row2['item_custom_cur'];
                                if ($item_custom_cur == "GBP"){$item_custom_cur = "&pound;";}
                                if ($item_custom_cur == "USD"){$item_custom_cur = "$";}
                                echo $item_title.'   '.$item_custom_cur.' '.$item_price.'<br />';
                                } ?>
                        
                        </p></div><div class="evr_spacer"></div>
<div id="evr_pop_foot"><p align="center">

<?php if ($more_info !=""){ ?>
<input type="button" onClick="window.open('<?php echo $more_info;?>');" value='MORE INFO'/> 
<?php	} ?>

<?php if ($outside_reg == "Y"){ ?>
<input type="button" onClick="window.open('<?php echo $external_site;?>');" value='External Registration'/> 
<?php	}  else {?>
                        <input type="button" onClick="location.href='<?php echo evr_permalink($company_options['evr_page_id']);?>action=evregister&event_id=<?php echo $event_id;?>'" value='REGISTER'/> 
 <?php } ?>                       
                        
                        
                        </p></div>               	
                				</div>
                			</section>      
                            <?php
                            
                            
                              }         
                         
            				
            					
?>

</div>

<?php
            			
}
?>