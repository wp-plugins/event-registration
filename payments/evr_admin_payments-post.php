<?php

function evr_admin_payment_post(){
    global $wpdb;
   
   


                $payer_id = $_REQUEST['attendee_id'];
                //$event_id = $_REQUEST['event_id'];
                (is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
                $first_name = $_REQUEST['first_name'];
                $last_name = $_REQUEST['last_name'];
                $payer_email = $_REQUEST['payer_email'];
                $txn_id = $_REQUEST['txn_id'];
                $payment_type = $_REQUEST['payment_type'];
                $item_name = $_REQUEST['item_name'];
                $item_number = $_REQUEST['item_number'];
                $quantity = $_REQUEST['quantity'];
                $payment_amount = $row['amt_pd'];
				$payer_status = $_REQUEST['payer_status'];
                $payment_status = $_REQUEST['payment_status'];
                $txn_type = $_REQUEST['txn_type'];
                $mc_currency = $_REQUEST['mc_currency'];
                $currency_format =$_REQUEST['mc_currency'];
				$memo = $_REQUEST['memo'];
                $payment_date = $_REQUEST['payment_date'];
                if (isset($_REQUEST['mc_gross'])){
				    $amount_pd = $_REQUEST['mc_gross'];
                    }else{
				    $amount_pd = $_REQUEST['payment_gross'];
   					}
     			$mc_gross=$amount_pd;
     			$address_name = $_REQUEST['address_name'];
     			$address_street = $_REQUEST['address_street'];
     			$address_city = $_REQUEST['address_city'];
     			$address_state = $_REQUEST['address_state'];
     			$address_zip = $_REQUEST['address_zip'];
     			$address_country = $_REQUEST['address_country'];
     			$address_status = $_REQUEST['address_status'];
     			$payer_business_name = $_REQUEST['payer_business_name'];
     			$pending_reason = $_REQUEST['pending_reason'];
     			$reason_code = $_REQUEST['reason_code'];
                
                
                $send_payment_rec = $_REQUEST['send_payment_rec'];                
                
                $sql=array('payer_id'=>$payer_id, 'event_id'=>$event_id, 'payment_date'=>$payment_date, 'txn_id'=>$txn_id, 
                            'first_name'=>$first_name, 'last_name'=>$last_name, 'payer_email'=>$payer_email, 'payer_status'=>$payer_status,
                            'payment_type'=>$payment_type, 'memo'=>$memo, 'item_name'=>$item_name, 'item_number'=>$item_number,
                            'quantity'=>$quantity, 'mc_gross'=>$mc_gross, 'mc_currency'=>$mc_currency, 'address_name'=>$address_name,
                            'address_street'=>$address_street, 'address_city'=>$address_city, 'address_state'=>$address_state, 'address_zip'=>$address_zip,
                            'address_country'=>$address_country, 'address_status'=>$address_status, 'payer_business_name'=>$payer_business_name, 'payment_status'=>$payment_status,
                            'pending_reason'=>$pending_reason, 'reason_code'=>$reason_code, 'txn_type'=>$txn_type);
					  
	   
        		
     $sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s',
                        '%s','%s','%s','%s','%s','%s','%s','%s','%s',
                       '%s','%s','%s','%s','%s','%s','%s','%s','%s');
        	
        
            if ($wpdb->insert( get_option('evr_payment'), $sql, $sql_data )){ ?>
            	<div id="message" class="updated fade"><p><strong><?php _e('The payment has been added.','evr_language');?> </strong></p></div>
                
                <?php }else { ?>
        		<div id="message" class="error"><p><strong><?php _e('There was an error in your submission, please try again. The payment was not saved!','evr_language');?><?php print mysql_error() ?>.</strong></p>
                <p><strong><?php _e(' . . .Now returning you to the payment section . . ','evr_language');?><meta http-equiv="Refresh" content="3; url=admin.php?page=payments&event_id=<?php echo $event_id;?>"></strong></p>
                </div>
                <?php } 
    			
       
                
 		if ($send_payment_rec == "Y") {					
					$company_options = get_option('evr_company_settings');
                    
                    $sql = "SELECT * FROM " . get_option('evr_attendee') . " WHERE id ='$payer_id'";
					$result = mysql_query ( $sql );
					$attendee_dtl = mysql_fetch_assoc ( $result );
					
                    $sql= "SELECT * FROM ". get_option('evr_event')." WHERE id=".$event_id; 
                    $result = mysql_query ( $sql );
                    $event_dtl = mysql_fetch_assoc ($result);  
				
					//get return URL
                   $return_url = $company_options['return_url'];
					
					if($return_url !=""){$payment_link = $return_url . "&id=" . $attendee_id;}
                    $payment_cue = __("To make payment or view your payment information go to",'evr_language');
                    $payment_text = $payment_cue.": " . $payment_link;
					$subject = $company_options['payment_subj'];
					$distro = $email;
                    
                    $ticket_order = unserialize($attendee_dtl['tickets']);
                    
                    $row_count = count($ticket_order);
                                    for ($row = 0; $row < $row_count; $row++) {
                                       echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."<br \>";
                                       } 
                    
					$message = $company_options['payment_message'];
                    
                    
                    $payment_link = evr_permalink($company_options['return_url']). "id=".$reg_id."&fname=".$reg_form['fname'];
                    
                    
                    //search and replace tags
                    $SearchValues = array("[id]","[fname]", "[lname]", "[phone]", "[event]",
                        "[description]", "[cost]", "[currency]","[payment]",
                        "[contact]", "[company]", "[co_add1]", "[co_add2]", 
                        "[co_city]", "[co_state]", "[co_zip]", "[payment_url]", 
                        "[start_date]", "[start_time]", "[end_date]",
                        "[end_time]", "[num_people]");
                
                    $ReplaceValues = array($attendee_dtl['id'], $attendee_dtl['fname'], $attendee_dtl['lname'], $attendee_dtl['phone'], stripslashes($event_dtl['event_name']),
                    stripslashes($event_dtl['event_desc']), evr_moneyFormat($attendee_dtl['payment']), $currency_format, evr_moneyFormat($amount_pd),
                    $company_options['company_email'], $company_options['company'], $company_options['company_street1'], $company_options['company_street2'],
                    $company_options['city'], $company_options['state'], $company_options['postal'],$payment_link , 
                    $event_dtl['start_date'], $event_dtl['start_time'],$event_dtl['end_date'],$event_dtl['end_time'],
                    $attendee_dtl['quantity']);
                    
                    echo "<pre>";
                    print_r($ReplaceValues);
                    echo "</pre>";
                
                    $email_content = str_replace($SearchValues, $ReplaceValues, $message);
                    $email_content .= $payment_text;
                    $message_top = "<html><body>"; 
                    $message_bottom = "</html></body>";
                   
                    
                    
                    $email_body = $message_top.$email_content.$message_bottom;
                            
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                    $headers .= 'From: "' . $company_options['company'] . '" <' . $company_options['company_email'] . ">\r\n";
                    
                    wp_mail($attendee_dtl['email'], $subject, html_entity_decode($email_body)."Do It!", $headers);
                    
                   ?>
				<div id="message" class="updated fade"><p><strong><?php _e('Payment Received Notification sent.','evr_language');?> </strong></p></div>
                <?php
				}
				
			
            ?>

            <META HTTP-EQUIV="refresh" content="3;URL=admin.php?page=payments&action=view_payments&event_id=<?php echo $event_id;?>">
            <?php
        
}
?>