<?php

function evr_process_regform(){
     
    global $wpdb;
    $company_options = get_option('evr_company_settings');
    $num_people = 0;
    $item_order = array();
    //$event_id = $_REQUEST['event_id'];
    (is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
    //Begin gather registrtion data for database input
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $address = $_REQUEST['address'];
    $city = $_REQUEST['city'];
    $state = $_REQUEST['state'];
    $zip = $_REQUEST['zip'];
    $phone = $_REQUEST['phone'];
    $email = $_REQUEST['email'];
    $payment = $_REQUEST['total'];
    $coupon = $_REQEUST['coupon'];
    $reg_type = $_REQUEST['reg_type'];
    
    
   
    $sql = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
    $result = mysql_query ( $sql );
	while ($row = mysql_fetch_assoc ($result)){
            $item_id          = $row['id'];
            $item_sequence    = $row['sequence'];
			$event_id         = $row['event_id'];
            $item_title       = $row['item_title'];
            $item_description = $row['item_description']; 
            $item_cat         = $row['item_cat'];
            $item_limit       = $row['item_limit'];
            $item_price       = $row['item_price'];
            $free_item        = $row['free_item'];
            $item_start_date  = $row['item_available_start_date'];
            $item_end_date    = $row['item_available_end_date'];
            $item_custom_cur  = $row['item_custom_cur'];
                 
            $item_post = str_replace(".", "_", $row['item_price']);
            $item_qty = $_REQUEST['PROD_' . $event_id . '-' . $item_id . '_' . $item_post];
            
            if ($item_cat == "REG"){$num_people = $num_people + $item_qty;}
            
            $item_info = array('ItemID' => $item_id, 'ItemEventID' => $event_id, 'ItemCat'=>$item_cat,
                'ItemName' => $item_title, 'ItemCost' => $item_price, 'ItemCurrency' =>
                $item_custom_cur, 'ItemFree' => $free_item, 'ItemStart' => $item_start_date,
                'ItemEnd' => $item_end_date, 'ItemQty' => $item_qty);
            array_push($item_order, $item_info);
            
            }
    
    $ticket_data = serialize($item_order);

     $sql=array('lname'=>$lname, 'fname'=>$fname, 'address'=>$address, 'city'=>$city, 
                'state'=>$state, 'zip'=>$zip, 'reg_type'=>$reg_type, 'email'=>$email,
                'phone'=>$phone, 'email'=>$email, 'coupon'=>$coupon, 'event_id'=>$event_id,
                'quantity'=>$num_people, 'tickets'=>$ticket_data, 'payment'=>$payment);
					  
					  
            
                          
        		
     $sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
        	
        
    if ($wpdb->insert( get_option('evr_attendee'), $sql, $sql_data )){ 
                
                // Insert Extra From Post Here
            $reg_id = $wpdb->get_var("SELECT LAST_INSERT_ID()");
            $questions = $wpdb->get_results("SELECT * from ".get_option('evr_question')." where event_id = '$event_id'");
            if ($questions) {
                  foreach ($questions as $question) {
                    switch ($question->question_type) {
                        case "TEXT":
                        case "TEXTAREA":
                        case "DROPDOWN":
                            $post_val = $_POST[$question->question_type . '_' . $question->id];
                            $wpdb->query("INSERT into ".get_option('evr_answer')." (registration_id, question_id, answer)
        					values ('$reg_id', '$question->id', '$post_val')");
                            break;
                        case "SINGLE":
                            $post_val = $_POST[$question->question_type . '_' . $question->id];
                            $wpdb->query("INSERT into ".get_option('evr_answer')." (registration_id, question_id, answer)
        					values ('$reg_id', '$question->id', '$post_val')");
                            break;
                        case "MULTIPLE":
                            $value_string = '';
                            for ($i = 0; $i < count($_POST[$question->question_type . '_' . $question->id]);
                                $i++) {
                                $value_string .= $_POST[$question->question_type . '_' . $question->id][$i] .",";
                            }
                            
                            $wpdb->query("INSERT into ".get_option('evr_answer')." (registration_id, question_id, answer)
        					values ('$reg_id', '$question->id', '$value_string')");
                            break;
                        }
                    }
                }    
                
    }else { ?>
        		<div id="message" class="error"><p><strong><?php _e('There was an error in your submission, please try again.','evr_language');?><?php print mysql_error() ?>.</strong></p>
          
                </div>
                <?php break;
                } 
    
  
   _e("You're information has been recieved.",'evr_language');
   echo " ";
   
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
                   	    $event_name = stripslashes($row['event_name']);
        					$event_identifier = stripslashes($row['event_identifier']);
        					$display_desc = $row['display_desc'];  // Y or N
                            $event_desc = stripslashes($row['event_desc']);
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
   
//Send Confirmation Email   
   //Select the default message
   if ($company_options['send_confirm']=="Y"){
      if ($send_mail == "Y"){
            $confirmation_email_body = $conf_mail;
           }
        else{ $confirmation_email_body = $company_options['message'];}
        
            
    $payment_link = evr_permalink($company_options['return_url']). "id=".$reg_id."&fname=".$fname;
    //search and replace tags
    $SearchValues = array("[id]","[fname]", "[lname]", "[phone]", "[event]",
        "[description]", "[cost]", "[currency]",
        "[contact]", "[company]", "[co_add1]", "[co_add2]", "[co_city]", "[co_state]",
        "[co_zip]", "[payment_url]", "[start_date]", "[start_time]", "[end_date]",
        "[end_time]", "[snum]", "[num_people]");

    $ReplaceValues = array($reg_id, $fname, $lname, $phone, $event_name, $event_desc, $payment,
        $custom_cur, $company_options['company_email'], $company_options['company'], $company_options['company_street1'], $company_options['company_street2'],
        $company_options['city'], $company_options['state'], $company_options['postal'],$payment_link , $start_date,
        $start_time, $end_date, $end_time, $attnum, $quantity);

    $email_content = str_replace($SearchValues, $ReplaceValues, $confirmation_email_body);
    $message_top = "<html><body>"; 
    $message_bottom = "</html></body>";
    $wait_message =  '<font color="red"><p>'.__("Thank you for registering for",'evr_language')." ".$event_name.". ".__("At this time, all seats for the event have been taken.  
    Your information has been placed on our waiting list.  
    The waiting list is on a first come, first serve basis.  
    You will be notified by email should a seat become available.",'evr_language').'</p><p>'.__("Thank You",'evr_language').'</p></font>';
    
    if ($reg_type=="WAIT"){$email_content = $wait_message;}
    $email_body = $message_top.$email_content.$message_bottom;
            
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= 'From: "' . $company_options['company'] . '" <' . $company_options['company_email'] . ">\r\n";
    
    wp_mail($email, $event_name, html_entity_decode($email_body), $headers);
    
}
//End Send Confirmation Email    
   
   
//Provide screen feedback on registration process   
   if($reg_type=="WAIT"){
    echo "<p>";
    _e("At this time, all seats for the event have been taken.  Your information has been placed on our waiting list.  The waiting list is on a first come, first serve basis.  You will be notified by email should a seat become available.",'evr_language');
    echo "</p>";
   }
   
   if ($payment > "0"){
             _e("Registration, however, is not complete until we have recieved your payment.",'evr_language'); 
           echo " ";
           if ($company_options['accept_checks']=="Y"){
                _e("You may pay online or by check.  If you are paying by check, please mail your check today to:",'evr_language');
                echo "<p>".
                $company_options['company']."<br />".
                $company_options['company_street1']."<br />".
                $company_options['company_street2']."<br />".
                $company_options['company_city']." ".$company_options['company_state']." ".$company_options['company_postal']."</p>";
            }     
           _e("Please select the Pay Now button to be taken to our payment vendor's site for online-payment.",'evr_language'); $company_options['company_email']     = $_POST['email'];
           evr_registration_payment($event_id, $reg_id);
           }
}
?>