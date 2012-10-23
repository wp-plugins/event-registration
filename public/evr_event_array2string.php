<?php
/**
 * @author David Fleming
 * @copyright 2012
 * This file takes an array from an event row and turns it into strings
 */
#Begin string generation
$event_id = $event->id;
$reg_form_defaults = unserialize($event->reg_form_defaults);
if ($reg_form_defaults != "") {
    if (in_array("Address", $reg_form_defaults)) {
        $inc_address = "Y";
    }
    if (in_array("City", $reg_form_defaults)) {
        $inc_city = "Y";
    }
    if (in_array("State", $reg_form_defaults)) {
        $inc_state = "Y";
    }
    if (in_array("Zip", $reg_form_defaults)) {
        $inc_zip = "Y";
    }
    if (in_array("Phone", $reg_form_defaults)) {
        $inc_phone = "Y";
    }
}
$use_coupon = $event->use_coupon;
$reg_limit = $event->reg_limit;
$event_name = stripslashes($event->event_name);
$event_identifier = stripslashes($event->event_identifier);
$display_desc = $event->display_desc; // Y or N
$event_desc = stripslashes($event->event_desc);
$event_category = unserialize($event->event_category);
$reg_limit = $event->reg_limit;
$event_location = stripslashes($event->event_location);
$event_address = $event->event_address;
$event_city = $event->event_city;
$event_state = $event->event_state;
$event_postal = $event->event_postcode;
$google_map = $event->google_map; // Y or N
$start_month = $event->start_month;
$start_day = $event->start_day;
$start_year = $event->start_year;
$end_month = $event->end_month;
$end_day = $event->end_day;
$end_year = $event->end_year;
$start_time = $event->start_time;
$end_time = $event->end_time;
$allow_checks = $event->allow_checks;
$outside_reg = $event->outside_reg; // Yor N
$external_site = $event->external_site;
$more_info = $event->more_info;
$image_link = $event->image_link;
$header_image = $event->header_image;
$event_cost = $event->event_cost;
$allow_checks = $event->allow_checks;
$is_active = $event->is_active;
$send_mail = $event->send_mail; // Y or N
$conf_mail = stripslashes($event->conf_mail);
$start_date = $event->start_date;
$end_date = $event->end_date;
#In order to get the number of seats we need to count all attendees for this event
#Retrieve the number of registered attendees for this event from attendee db
$sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event->id'";
$result2 = mysql_query($sql2);
$num = 0;   
$available_spaces = 0;
while($row = mysql_fetch_array($result2)){$num =  $row['SUM(quantity)'];};
$attendee_count = $num;                            
if ($event->reg_limit != ""){$available_spaces = $event->reg_limit - $num;}
if ($event->reg_limit == "" || $event->reg_limit == " " || $event->reg_limit == "999"){$available_spaces = "UNLIMITED";}
#End of string generation
?>