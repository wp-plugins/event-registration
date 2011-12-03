<?php 
//Payment processing - Used for onsite payment processing. Used with the {EVENTPAYPALTXN} tag
function evr_paypal_txn(){
	global $wpdb;
    $today = date("m-d-Y");
    $company_options = get_option('evr_company_settings');
    $events_attendee_tbl = get_option('evr_attendee');
		
	$id="";
	$id=$_REQUEST['id'];//This is the id of the registrant
	if ($id ==""){
		echo "ID not supplied.";
	}else{
		if ($company_options['use_sandbox'] == 'Y'){
			evr_sandbox_using_ipn($id=$_REQUEST['id']);
		}else{
			$p = new paypal_class;// initiate an instance of the class
			if ($p->validate_ipn()) {
				//store the results in reusable variables
				$payer_id = $p->ipn_data['payer_id'];
				$payment_date = $p->ipn_data['payment_date'];
				$txn_id = $p->ipn_data['txn_id'];
				$first_name = $p->ipn_data['first_name'];
				$last_name = $p->ipn_data['last_name'];
				$payer_email = $p->ipn_data['payer_email'];
				$payer_status = $p->ipn_data['payer_status'];
				$payment_type = $p->ipn_data['payment_type'];
				$memo = $p->ipn_data['memo'];
				$item_name = $p->ipn_data['item_name'];
				$item_number = $p->ipn_data['item_number'];
				$quantity = $p->ipn_data['quantity'];
				if (isset($_REQUEST['mc_gross'])){
							$amount_pd = $_REQUEST['mc_gross'];
						}else{
							$amount_pd = $_REQUEST['payment_gross'];
						}
				$mc_currency = $p->ipn_data['mc_currency'];
				$address_name = $p->ipn_data['address_name'];
				$address_street = nl2br($p->ipn_data['address_street']);
				$address_city = $p->ipn_data['address_city'];
				$address_state = $p->ipn_data['address_state'];
				$address_zip = $p->ipn_data['address_zip'];
				$address_country = $p->ipn_data['address_country'];
				$address_status = $p->ipn_data['address_status'];
				$payer_business_name = $p->ipn_data['payer_business_name'];
				$payment_status = $p->ipn_data['payment_status'];
				$pending_reason = $p->ipn_data['pending_reason'];
				$reason_code = $p->ipn_data['reason_code'];
				$txn_type = $p->ipn_data['txn_type'];
			
				
				$sql="UPDATE ". $events_attendee_tbl . " SET payment_status = '$payment_status', amount_pd = '$amount_pd', payment_date ='$payment_date' WHERE id ='$id'";
				$wpdb->query($wpdb->prepare($sql));
                
                
                //Works fine to here!!  the breaks??
                
				
				 $query  = "SELECT * FROM ". $events_attendee_tbl ." WHERE id ='".$id."'";
				 $result = mysql_query($query) or die('Error : ' . mysql_error());
					while ($row = mysql_fetch_assoc ($result)){
						$attendee_email = $row['email'];
                        $fname = $row['fname'];
				 }
				 
				    	$email_subject = $company_options['payment_subj'];
						$email_body = $company_options['payment_message'];
						$default_mail=$company_options['send_confirm'];
						$Organization = $company_options['company'];
						$contact =$company_options['company_email'];
				 
               
				//$event_id = $_REQUEST['event_id'];
				(is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
                $events_detail_tbl = get_option('evr_event');
				$query  = "SELECT * FROM ".$events_detail_tbl." WHERE id='$event_id'";
					$result = mysql_query($query) or die('Error : ' . mysql_error());
					while ($row = mysql_fetch_assoc ($result)){
						$event_id       = $row['id'];
            				$event_name     = stripslashes($row['event_name']);
            				$event_location = stripslashes($row['event_location']);
                            $event_address  = $row['event_address'];
                            $event_city     = $row['event_city'];
                            $event_postal   = $row['event_postal'];
                            $reg_limit      = $row['reg_limit'];
                    		$start_time     = $row['start_time'];
                    		$end_time       = $row['end_time'];
                    		$start_date     = $row['start_date'];
                    		$end_date       = $row['end_date'];
                            
					}
				
                $payment_link = evr_permalink($company_options['return_url']). "id=".$id."&fname=".$fname;	
                    						
				//Replace the tags
				$tags = array("[id]","[fname]", "[lname]", "[payer_email]", "[event_name]", "[amnt_pd]", "[txn_id]", "[address_street]", "[address_city]", "[address_state]", "[address_zip]", "[address_country]", "[start_date]", "[start_time]", "[end_date]", "[end_time]", "[payment_url]" );
				$vals = array($id, $first_name, $last_name, $payer_email, $event_name, $amount_pd, $txn_id, $address_street, $address_city, $address_state, $address_zip, $address_country, $start_date, $start_time, $end_date, $end_time, $payment_link);
				
                
                
                
				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "From: " . $Organization . " <". $contact . ">\r\n";
				$headers .= "Reply-To: " . $Organization . "  <" . $contact . ">\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
				$message_top = "<html><body>"; 
				$message_bottom = "</html></body>";
				$email_body = $message_top.$email_body.$message_bottom;
				
				$subject = str_replace($tags,$vals,$email_subject);
				$body    = str_replace($tags,$vals,$email_body);
				if ($default_mail == 'Y'){ if($email_body != ""){ wp_mail($attendee_email, html_entity_decode($subject), html_entity_decode($body), $headers);}}
                
                
                
                
                
                
				
				$events_paypal_transactions_tbl = get_option('evr_payment');
				//Store transaction details in the database
			              
                 $sql=array('payer_id'=>$id, 'event_id'=>$event_id, 'payment_date'=>$payment_date, 'txn_id'=>$txn_id, 'first_name'=>$first_name,
                 'last_name'=>$last_name, 'payer_email'=>$payer_email, 'payer_status'=>$payer_status, 'payment_type'=>$payment_type, 'memo'=>$memo, 
                 'item_name'=>$item_name, 'item_number'=>$item_number, 'quantity'=>$quantity,
                 'mc_gross'=>$amount_pd, 'mc_currency'=>$mc_currency, 'address_name'=>$address_name, 'address_street'=>$address_street, 
                 'address_city'=>$address_city, 'address_state'=>$address_state, 
                 'address_zip'=>$address_zip, 'address_country'=>$address_country, 'address_status'=>$address_status, 
                 'payer_business_name'=>$payer_business_name, 'payment_status'=>$payment_status, 
                 'pending_reason'=>$pending_reason, 'reason_code'=>$reason_code, 'txn_type'=>$txn_type );
					  
					  
            
                          
        		
     $sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
     '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
        	
        
    //$wpdb->insert( get_option('evr_payment'), $sql, $sql_data );
      if ($wpdb->insert( get_option('evr_payment'), $sql, $sql_data )){ 
                $subject = 'Instant Payment Notification - Success';
				 $body =  "An instant payment notification was successfully posted\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);} 
                 else {
                     $subject = 'Instant Payment Notification - Failure';
				 $body =  "An instant payment notification was received but not posted!\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);
                 };         
				 
			}
		}
	}

}

//Using Sandbox
function evr_sandbox_using_ipn($id){
	$company_options = get_option('evr_company_settings');
        $email_subject = $company_options['payment_subj'];
    	$email_body = $company_options['payment_message'];
    	$default_mail=$company_options['send_confirm'];
    	$Organization = $company_options['company'];
    	$contact =$company_options['company_email'];
					
    $events_detail_tbl = get_option('evr_event');
	$id=$id;
	$p = new paypal_class;// initiate an instance of the class
			$p->validate_ipn();  
			//store the results in reusable variables
			$payer_id = $p->ipn_data['payer_id'];
			$payment_date = $p->ipn_data['payment_date'];
			$txn_id = $p->ipn_data['txn_id'];
			$first_name = $p->ipn_data['first_name'];
			$last_name = $p->ipn_data['last_name'];
			$payer_email = $p->ipn_data['payer_email'];
			$payer_status = $p->ipn_data['payer_status'];
			$payment_type = $p->ipn_data['payment_type'];
			$memo = $p->ipn_data['memo'];
			$item_name = $p->ipn_data['item_name'];
			$item_number = $p->ipn_data['item_number'];
			$quantity = $p->ipn_data['quantity'];
			if (isset($_REQUEST['mc_gross'])){
						$amount_pd = $_REQUEST['mc_gross'];
					}else{
						$amount_pd = $_REQUEST['payment_gross'];
					}
			$mc_currency = $p->ipn_data['mc_currency'];
			$address_name = $p->ipn_data['address_name'];
			$address_street = nl2br($p->ipn_data['address_street']);
			$address_city = $p->ipn_data['address_city'];
			$address_state = $p->ipn_data['address_state'];
			$address_zip = $p->ipn_data['address_zip'];
			$address_country = $p->ipn_data['address_country'];
			$address_status = $p->ipn_data['address_status'];
			$payer_business_name = $p->ipn_data['payer_business_name'];
			$payment_status = $p->ipn_data['payment_status'];
			$pending_reason = $p->ipn_data['pending_reason'];
			$reason_code = $p->ipn_data['reason_code'];
			$txn_type = $p->ipn_data['txn_type'];
		
			//Debugging option
			$email_paypal_dump = true;
			if ($email_paypal_dump == true) {
				 // For this, we'll just email ourselves ALL the data as plain text output.
				 $subject = 'Instant Payment Notification - PayPal Variable Dump';
				 $body =  "An instant payment notification was successfully received\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);
			}
			
			global $wpdb;
			$events_attendee_tbl = get_option('evr_attendee');
			
			$today = date("m-d-Y");	
			$sql="UPDATE ". $events_attendee_tbl . " SET payment_status = '$payment_status', amount_pd = '$amount_pd', payment_date ='$payment_date' WHERE id ='$id'";
            $wpdb->query($wpdb->prepare($sql));
			
			 $query  = "SELECT * FROM ". $events_attendee_tbl ." WHERE id ='".$id."'";
			 $result = mysql_query($query) or die('Error : ' . mysql_error());
				while ($row = mysql_fetch_assoc ($result)){
					$attendee_email = $row['email'];
			 }
			 			 
			//$event_id = $_REQUEST['event_id'];
			(is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
            $query  = "SELECT * FROM ".$events_detail_tbl." WHERE id='$event_id'";
				$result = mysql_query($query) or die('Error : ' . mysql_error());
				while ($row = mysql_fetch_assoc ($result)){
								$event_id       = $row['id'];
            				$event_name     = stripslashes($row['event_name']);
            				$event_location = stripslashes($row['event_location']);
                            $event_address  = $row['event_address'];
                            $event_city     = $row['event_city'];
                            $event_postal   = $row['event_postal'];
                            $reg_limit      = $row['reg_limit'];
                    		$start_time     = $row['start_time'];
                    		$end_time       = $row['end_time'];
                    		$start_date     = $row['start_date'];
                    		$end_date       = $row['end_date'];
                            
					}
											
				//Replace the tags
				$tags = array("[id]","[fname]", "[contact]","[lname]", "[payer_email]", "[event_name]", "[amnt_pd]", "[txn_id]", "[address_street]", "[address_city]", "[address_state]", "[address_zip]", "[address_country]", "[start_date]", "[start_time]", "[end_date]", "[end_time]" );
				$vals = array($id, $first_name, $company_options('company_email'),$last_name, $payer_email, $event_name, $amount_pd, $txn_id, $address_street, $address_city, $address_state, $address_zip, $address_country, $start_date, $start_time, $end_date, $end_time);
				
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "From: " . $Organization . " <". $contact . ">\r\n";
			$headers .= "Reply-To: " . $Organization . "  <" . $contact . ">\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			$message_top = "<html><body>"; 
			$message_bottom = "</html></body>";
			$email_body = $message_top.$email_body.$message_bottom;
			
			$subject = str_replace($tags,$vals,$email_subject);
			$body    = str_replace($tags,$vals,$email_body);
			if ($default_mail =='Y'){ if($email_body != ""){ wp_mail($attendee_email, html_entity_decode($subject), html_entity_decode($body), $headers);}}
			
			$events_paypal_transactions_tbl = get_option('evr_payment');
				//Store transaction details in the database
			              
                 $sql=array('payer_id'=>$id, 'event_id'=>$event_id, 'payment_date'=>$payment_date, 'txn_id'=>$txn_id, 'first_name'=>$first_name,
                 'last_name'=>$last_name, 'payer_email'=>$payer_email, 'payer_status'=>$payer_status, 'payment_type'=>$payment_type, 'memo'=>$memo, 
                 'item_name'=>$item_name, 'item_number'=>$item_number, 'quantity'=>$quantity,
                 'mc_gross'=>$amount_pd, 'mc_currency'=>$mc_currency, 'address_name'=>$address_name, 'address_street'=>$address_street, 
                 'address_city'=>$address_city, 'address_state'=>$address_state, 
                 'address_zip'=>$address_zip, 'address_country'=>$address_country, 'address_status'=>$address_status, 
                 'payer_business_name'=>$payer_business_name, 'payment_status'=>$payment_status, 
                 'pending_reason'=>$pending_reason, 'reason_code'=>$reason_code, 'txn_type'=>$txn_type );
					  
					  
            
                          
        		
     $sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
     '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
        	
        
    if ($wpdb->insert( get_option('evr_payment'), $sql, $sql_data )){ 
                $subject = 'Instant Payment Notification - Success';
				 $body =  "An instant payment notification was successfully posted\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);} 
                 else {
                     $subject = 'Instant Payment Notification - Failure';
				 $body =  "An instant payment notification was received but not posted!\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);
                 };
}
?>