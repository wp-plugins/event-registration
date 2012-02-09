<?php

function evr_process_confirmation(){
     
    global $wpdb;
    $company_options = get_option('evr_company_settings');
    $num_people = 0;
    
    $reg_form = unserialize(urldecode($_POST["reg_form"]));
    $qanda = unserialize(urldecode($_POST["questions"]));

    
    $passed_event_id = $reg_form["event_id"];
    if (is_numeric($passed_event_id)){$event_id = $passed_event_id;}
    else {echo "Failure - please retry!"; exit;}
    
    $attendee_array = $_POST['attendee'];
    $ticket_array = unserialize($reg_form['tickets']);
    $attendee_list = serialize($attendee_array);
       
    
    $sql=array('lname'=>$reg_form['lname'], 'fname'=>$reg_form['fname'], 'address'=>$reg_form['address'], 'city'=>$reg_form['city'], 
                'state'=>$reg_form['state'], 'zip'=>$reg_form['zip'], 'reg_type'=>$reg_form['reg_type'], 'email'=>$reg_form['email'],
                'phone'=>$reg_form['phone'], 'email'=>$reg_form['email'], 'coupon'=>$reg_form['coupon'], 'event_id'=>$reg_form['event_id'],
                'quantity'=>$reg_form['num_people'], 'tickets'=>$reg_form['tickets'], 'payment'=>$reg_form['payment'], 'tax'=>$reg_form['tax'],'attendees'=>$attendee_list);
 
    $sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
    if ($wpdb->insert( get_option('evr_attendee'), $sql, $sql_data )){ 
    // Insert Extra From Post Here
            $reg_id = $wpdb->get_var("SELECT LAST_INSERT_ID()");
          
            if ( count($qanda)>"0"){
                $i = 0;
                 do {
                    $question_id = $qanda[$i]['question'];
                    $response  = $qanda[$i]["response"];
                    $wpdb->query("INSERT into ".get_option('evr_answer')." (registration_id, question_id, answer)
                	values ('$reg_id', '$question_id', '$response')");
                    
                                      
                 ++$i;
                 } while ($i < (count($qanda)+1));
            }
    } 
    
    
   _e("Your information has been received.",'evr_language');
   echo "<br/>";
   

    
   $sql= "SELECT * FROM ". get_option('evr_event')." WHERE id=".$event_id; 
   
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
                   	    $event_name = html_entity_decode(stripslashes($row['event_name']));
                        $invoice_event = $row['event_name'];
        					$event_identifier = stripslashes($row['event_identifier']);
        					$display_desc = $row['display_desc'];  // Y or N
                            $event_desc = html_entity_decode(stripslashes($row['event_desc']));
                            $event_category = unserialize($_REQUEST['event_category']);
        					$reg_limit = $row['reg_limit'];
        					$event_location = $row['event_location'];
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
                            //added 6.00.13
                            $send_coord = $row['send_coord'];
                            $coord_email = $row['coord_email'];
                            $coord_msg = stripcslashes($row['coord_msg']);
                            $coord_pay_msg = stripslashes($row['coord_pay_msg']);
                            
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
                               }
 
 //create array for invoice
$invoice_data = array('reg_id'=>$reg_id,'lname'=>$reg_form['lname'], 'fname'=>$reg_form['fname'], 'address'=>$reg_form['address'], 
                'city'=>$reg_form['city'], 'state'=>$reg_form['state'], 'zip'=>$reg_form['zip'], 'reg_type'=>$reg_form['reg_type'], 
                'email'=>$reg_form['email'], 'phone'=>$reg_form['phone'], 'coupon'=>$reg_form['coupon'], 'event_id'=>$reg_form['event_id'],
                'event_name'=>$invoice_event, 'quantity'=>$reg_form['num_people'], 'tickets'=>$reg_form['tickets'], 
                'payment'=>$reg_form['payment'], 'tax'=>$reg_form['tax'],'attendees'=>$attendee_list);
                
$invoice_post = urlencode(serialize($invoice_data));

/* Comment Out PDF confirmation Option

?>
<form id="pdf out" class="evr_regform" method="post" action="<?php echo get_bloginfo('wpurl') . '/wp-content/plugins/event-registration/evr_pdf_out.php'?>">

<input type="hidden" name="reg_form" value="<?php echo $_POST["reg_form"];?>" />
<input type="hidden" name="attendee_list" value="<?php echo $attendee_list;?>" />
<input type="submit" name="mySubmit" id="mySubmit" value="<?php _e('PDF Confirmation','evr_language');?>" /> 
</form>
<?php
 
 */   
//Send Confirmation Email   
   //Select the default message
   if ($company_options['send_confirm']=="Y"){
      if ($send_mail == "Y"){
            $confirmation_email_body = $conf_mail;
           }
        else{ $confirmation_email_body = $company_options['message'];}
       
    
    if ( count($attendee_array)>"0"){
                $attendee_names="";
                $i = 0;
                 do {
                    $attendee_names .= $attendee_array[$i]["first_name"]." ".$attendee_array[$i]['last_name'].",";
                    
                   
                 ++$i;
                 } while ($i < count($attendee_array));
            }
            
    $row_count = count($ticket_array);
    for ($row = 0; $row < $row_count; $row++) {
    if ($ticket_array[$row]['ItemQty'] >= "1"){ $ticket_list.= $ticket_array[$row]['ItemQty']." ".$ticket_array[$row]['ItemCat']."-".$ticket_array[$row]['ItemName']." ".$ticket_array[$row]['ItemCurrency'] . " " . $ticket_array[$row]['ItemCost']."<br \>";}
    } 
      
                           
         
    $payment_link = evr_permalink($company_options['return_url']). "id=".$reg_id."&fname=".$reg_form['fname'];
    //search and replace tags
    $SearchValues = array(  "[id]","[fname]", "[lname]", "[phone]", 
                            "[address]","[city]","[state]","[zip]","[email]",
                            "[event]","[description]", "[cost]", "[currency]",
                            "[contact]", "[coordinator]","[company]", "[co_add1]", "[co_add2]", "[co_city]", "[co_state]","[co_zip]", 
                            "[payment_url]", "[start_date]", "[start_time]", "[end_date]","[end_time]", 
                            "[num_people]","[attendees]","[tickets]");

    $ReplaceValues = array($reg_id, $reg_form['fname'], $reg_form['lname'], $reg_form['phone'], 
                            $reg_form['address'], $reg_form['city'], $reg_form['state'], $reg_form['zip'], $reg_form['email'],
                            $event_name, $event_desc, $reg_form['payment'],$company_options['default_currency'], 
                            $company_options['company_email'], $coord_email, $company_options['company'], $company_options['company_street1'], $company_options['company_street2'],$company_options['company_city'], $company_options['company_state'], $company_options['company_postal'],
                            $payment_link , $start_date,$start_time, $end_date, $end_time, 
                            $reg_form['num_people'],$attendee_names, $ticket_list);

    $email_content = str_replace($SearchValues, $ReplaceValues, $confirmation_email_body);
    $message_top = "<html><body>"; 
    $message_bottom = "</html></body>";
   if ($company_options['wait_message'] != ""){ $wait_message = $company_options['wait_message'];}
    else {
    $wait_message =  '<font color="red"><p>'.__("Thank you for registering for",'evr_language')." ".$event_name.". ".__("At this time, all seats for the event have been taken.  
    Your information has been placed on our waiting list.  
    The waiting list is on a first come, first serve basis.  
    You will be notified by email should a seat become available.",'evr_language').'</p><p>'.__("Thank You",'evr_language').'</p></font>';}
    
    if ($reg_form['reg_type']=="WAIT"){$email_content = $wait_message;}
    $email_body = $email_content;
            
    
    
    $email_body = $message_top.$email_content.$message_bottom;        
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= 'From: "' . html_entity_decode($company_options['company']) . '" <' . $company_options['company_email'] . ">\r\n";
    
    wp_mail($reg_form['email'], html_entity_decode($event_name), html_entity_decode(nl2br($email_body)), $headers);
    
    _e("A confirmation email has been sent to:",'evr_language'); 
    echo " ";
    echo $reg_form['email']."<br/>";
    
}
//End Send Confirmation Email    

//Send Coordinator AlertEmail   
   //Select the default message
if ($send_coord =="Y"){
      
    
    if ( count($attendee_array)>"0"){
                $attendee_names="";
                $i = 0;
                 do {
                    $attendee_names .= $attendee_array[$i]["first_name"]." ".$attendee_array[$i]['last_name'].",";
                    
                   
                 ++$i;
                 } while ($i < count($attendee_array));
            }
         
    $payment_link = evr_permalink($company_options['return_url']). "id=".$reg_id."&fname=".$reg_form['fname'];
    //search and replace tags
    $SearchValues = array(  "[id]","[fname]", "[lname]", "[phone]", 
                            "[address]","[city]","[state]","[zip]","[email]",
                            "[event]","[description]", "[cost]", "[currency]",
                            "[contact]", "[coordinator]","[company]", "[co_add1]", "[co_add2]", "[co_city]", "[co_state]","[co_zip]", 
                            "[payment_url]", "[start_date]", "[start_time]", "[end_date]","[end_time]", 
                            "[num_people]","[attendees]","[tickets]");

    $ReplaceValues = array($reg_id, $reg_form['fname'], $reg_form['lname'], $reg_form['phone'], 
                            $reg_form['address'], $reg_form['city'], $reg_form['state'], $reg_form['zip'], $reg_form['email'],
                            $event_name, $event_desc, $reg_form['payment'],$company_options['default_currency'], 
                            $company_options['company_email'], $coord_email, $company_options['company'], $company_options['company_street1'], $company_options['company_street2'],$company_options['company_city'], $company_options['company_state'], $company_options['company_postal'],
                            $payment_link , $start_date,$start_time, $end_date, $end_time, 
                            $reg_form['num_people'],$attendee_names, $ticket_list);

    $email_content = str_replace($SearchValues, $ReplaceValues, $coord_msg);
    $message_top = "<html><body>"; 
    $message_bottom = "</html></body>";
    
    $email_body = $message_top.$email_content.$message_bottom;
            
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= 'From: "' . $company_options['company'] . '" <' . $company_options['company_email'] . ">\r\n";
    
    wp_mail($coord_email, html_entity_decode($event_name), html_entity_decode(nl2br($email_body)), $headers);
  
}
//End Send Coordinator Email     
   
//Provide screen feedback on registration process   
//If registration is at capacity and attendee is waitlisted, notify attendee of waitlist.
   if($reg_form['reg_type']=="WAIT"){
    echo "<p>";
    _e("At this time, all seats for the event have been taken.  Your information has been placed on our waiting list.  The waiting list is on a first come, first serve basis.  You will be notified by email should a seat become available.",'evr_language');
    echo "</p>";
   }
//If there is a balance of payment over 0, then notify attendee of payment need.  
   if ($reg_form['payment'] > "0"){
             _e("Registration, however, is not complete until we have received your payment.",'evr_language'); 
           echo " ";
           if ($company_options['checks'] == "Yes"){
                _e("You may pay online or by check.  If you are paying by check, please mail your check today to:",'evr_language');
                echo "<p>".
                $company_options['company']."<br />".
                $company_options['company_street1']."<br />";
                
                if ($company_options['company_street2']!=""){echo $company_options['company_street2']."<br />";}
                echo $company_options['company_city']." ".$company_options['company_state']." ".$company_options['company_postal']."</p>";
                 _e("Reference ",'evr_language');
                 echo "<b>".$event_name." - ID: ".$reg_id."</b><br/><br/>";
            }     
           _e("To pay online, please select the Pay Now button to be taken to our payment vendor's site.",'evr_language'); 
           echo "<hr/>";
           evr_registration_payment($event_id, $reg_id);
           }
           
 // If Accept Donations is yes and Event Fees are 0, then make Donation Offer
          
        if (($company_options['donations']=="Yes") && (($reg_form['payment'] < "1")||($reg_form['payment'] == ""))) {
            _e("While there is no fee for this event, we gladly accept donations.",'evr_language');
              echo "<br/>";
              if ($company_options['checks']=="Yes"){
                _e("You may donate online or by check.  If you are donating by check, please mail your check to:",'evr_language');
                echo "<p>".
                $company_options['company']."<br />".
                $company_options['company_street1']."<br />";
                if ($company_options['company_street2']!=""){echo $company_options['company_street2']."<br />";}
                echo $company_options['company_city']." ".$company_options['company_state']." ".$company_options['company_postal']."</p>";
                _e("Reference: Donation - ",'evr_language');
                 echo "<b>".$event_name."</b><br/><br/>";
            }    
                               
           _e("Please select the Donate button to be taken to our payment vendor's site for online-donations.",'evr_language');
           echo "<hr/>";
           evr_registration_donation($event_id, $reg_id);
           }

/*
?>
<form id="invoice" class="evr_regform" method="post" target=_blank action="<?php echo get_bloginfo('wpurl') . '/wp-content/plugins/event-registration/evr_invoice.php'?>">
<input type="hidden" name="reg_form" value="<?php echo $invoice_post;?>" />
<input type="submit" name="mySubmit" id="mySubmit" value="<?php _e('Print Invoice','evr_language');?>" /> 
</form>
<?php 
*/
}
?>