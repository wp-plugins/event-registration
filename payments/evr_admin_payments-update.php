<?php
function evr_admin_payment_update(){
    global $wpdb;
   
   

    $payment_id = $_REQUEST['payment_id'];
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
        	
        $update_id = array('id'=> $payment_id);
            
            if ($wpdb->update( get_option('evr_payment'), $sql, $update_id, $sql_data, array( '%d' ) )){?>
    
        	         	<div id="message" class="updated fade"><p><strong><?php _e('The payment has been updated.','evr_language');?> </strong></p></div>
                
                <?php }else { ?>
        		<div id="message" class="error"><p><strong><?php _e('There was an error in your submission, please try again. The payment was not updated!','evr_language');?><?php print mysql_error() ?>.</strong></p>
                <p><strong><?php _e(' . . .Now returning you to the payment section . . ','evr_language');?><meta http-equiv="Refresh" content="3; url=admin.php?page=payments&action=view_payments&event_id=<?php echo $event_id;?>"></strong></p>
                </div>
                <?php } 
    			
       
                
 		if ($send_payment_rec == "Y") {					
					$sql = "SELECT * FROM " . get_option('evr_attendee') . " WHERE id ='$payer_id'";
					$result = mysql_query ( $sql );
					while ( $row = mysql_fetch_assoc ( $result ) ) {
						$attendee_id = $row ['id'];
						$lname = $row ['lname'];
						$fname = $row ['fname'];
						$address = $row ['address'];
						$city = $row ['city'];
						$state = $row ['state'];
						$zip = $row ['zip'];
						$email = $row ['email'];
						$phone = $row ['phone'];
						$date = $row ['date'];
						$event_id = $row ['event_id'];
                        $coupon= $row['coupon'];
				
					}
					$company_options = get_option('evr_company_settings');
                    
				
					//get return URL
                   $return_url = $company_options['return_url'];
					
					if($return_url !=""){$payment_link = $return_url . "&id=" . $attendee_id;}
                    $payment_cue = __("To make payment or view your payment information go to",'evr_language');
                    $payment_text = $payment_cue.": " . $payment_link;
					$subject = $company_options['payment_subj'];
					$distro = $email;
                    
					$message = $company_options['payment_message'];
                    /*
                    ("***This Is An Automated Response***   Thank You $fname $lname.  We have received a payment in the amount of $ ".$amount_pd." for your event registration.  " . $payment_text);
					*/
					wp_mail ( $distro, $subject, $message );
					?>
				<div id="message" class="updated fade"><p><strong><?php _e('Payment Received Notification sent.','evr_language');?> </strong></p></div>
                <?php
				}
				
			
            ?>

            <META HTTP-EQUIV="refresh" content="3;URL=admin.php?page=payments&action=view_payments&event_id=<?php echo $event_id;?>">
            <?php
        
}
?>