<?php

/**
 * @author Edge Technology Consulting
 * @copyright 2009
 */

function events_view_widget() {

	global $wpdb,$events_lang;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$curdate = date ( "Y-m-j" );
	$month = date ('M');
	$day = date('j');
	$year = date('Y');
	$currency_format = get_option ( 'currency_format' );

	
	$sql = "SELECT * FROM " . $events_detail_tbl ." WHERE start_date >= '".date ( 'Y-m-j' )."' ORDER BY start_date";
		
	$result = mysql_query ( $sql );
	
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$identifier = $row ['event_identifier'];
		$image = $row ['image_link'];
		$event_location = $row ['event_location'];
		$more_info = $row ['more_info'];
		$start_date = $row ['start_date'];
		$end_date = $row ['end_date'];
		$start_time = $row ['start_time'];
		$end_time = $row ['end_time'];
		$cost = $row ['event_cost'];
		$custom_cur = $row ['custom_cur'];
		$checks = $row ['allow_checks'];
		$active = $row ['is_active'];
		$reg_limit = $row ['reg_limit'];
		$timestamp = strtotime($start_date);
		$new_start_date = date("M d, Y", $timestamp);
		;
 
		
		if ($cost == ""){$cost = "FREE";}
		
	    
		$sql2= "SELECT SUM(num_people) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
		$result2 = mysql_query($sql2);
		while($row = mysql_fetch_array($result2)){$num =  $row['SUM(num_people)'];}
		
				
		if ($custom_cur == ""){if ($currency_format == "USD" || $currency_format == "") {$currency_format = "$";}}
		if ($custom_cur != "" || $custom_cur != "USD"){$currency_format = $custom_cur;}
		if ($custom_cur == "USD") {$currency_format = "$";}
		if ($reg_limit != ""){$available_spaces = $reg_limit - $num;}
	    if ($reg_limit == ""){$available_spaces = "Unlimited";}

		
		echo "<br></hr><B>" . $event_name . "   </b><br>";
		echo "Location:<b>  ".$event_location."</b><br>";
		echo "Start Date:<b>  ".$new_start_date."</b><br>";
	//	echo "Start Time:<b>  ".$start_time."</b><br>";
	/*	echo "Price:<b>  ";
		if ($cost != "FREE"){echo $currency_format;}
		echo " ".$cost."</b><br>";
	*/	
	//	echo "Spaces Available:<b>  ".$available_spaces."</b><br>";
		if ($more_info != ""){echo '<a href="'.$more_info.'"> More Info...</a>';}
	/*	echo "<form name='form' method='post' action='".request_uri()."'>";
		echo "<input type='hidden' name='regevent_action' value='register'>";
		echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
		echo "<input type='SUBMIT' value='$events_lang[register]'></form><br>";
		*/
		echo "<br>----------------<br>";

}}
 
function init_er_widget(){
register_sidebar_widget("Events Registraion", "events_view_widget");     
}
 

?>