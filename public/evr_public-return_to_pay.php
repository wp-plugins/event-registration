<?php

function evr_retun_to_pay(){
 
		global $wpdb;
        $company_options = get_option('evr_company_settings');
        $id="";
        $passed_id="";
        $passed_id = $_GET['id'];
       
        if (is_numeric($passed_id)){$id = $passed_id;}
        else {
            $passed_id = "";
            echo "Failure - please retry!"; 
            exit;}
            
        if ($passed_id ==""){echo "Please check your email for payment information.";}
        else{
			$query  = "SELECT * FROM ".get_option('evr_attendee')." WHERE id='$passed_id'";
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		while ($row = mysql_fetch_assoc ($result))
				{
	  		    $attendee_id = $row['id'];
				$lname = $row['lname'];
				$fname = $row['fname'];
				$address = $row['address'];
				$city = $row['city'];
				$state = $row['state'];
				$zip = $row['zip'];
				$email = $row['email'];
				$phone = $row['phone'];
				$date = $row['date'];
				$payment = $row['payment'];
				$event_id = $row['event_id'];
                $quantity = $row ['quantity'];
 			    $reg_type = $row['reg_type'];
                $ticket_order = unserialize($row['tickets']);
                $coupon = $row['coupon'];
				$attendee_name = $fname." ".$lname;
				}

			/*	$company =$company_options['company'];
				$company_street1 =$company_options['company_street1'];
				$company_street2=$company_options['company_street2'];
				$company_city =$company_options['company_city'];
				$company_state=$company_options['company_state'];
				$company_zip =$company_options['company_zip'];
				$contact =$company_options['contact_email'];
 				$registrar = $company_options['contact_email'];
				$paypal_id =$company_options['paypal_id'];
				$paypal_cur =$company_options['currency_format'];
				$events_listing_type =$company_options['events_listing_type'];
				$message =$company_options['message'];
				$return_url = $company_options['return_url'];
				$cancel_return = $company_options['cancel_return'];
				$notify_url = $company_options['notify_url'];
				$use_sandbox = $company_options['use_sandbox'];
				$image_url = $company_options['image_url'];
				$currency_symbol = $company_options['currency_symbol'];
			
*/

			//Query Database for event and get variable

			$sql = "SELECT * FROM ". get_option('evr_event') . " WHERE id='$event_id'";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_assoc ($result))
			{
						//$event_id = $row['id'];
						$event_name = stripslashes($row['event_name']);
						$event_desc = stripslashes($row['event_desc']);
						$event_description = stripslashes($row['event_desc']);
						$event_identifier = $row['event_identifier'];
						
					
							}
echo "<br><br><strong>".__('Payment Page for','evr_language')." " .$fname." ".$lname." ".__('for event','evr_language')." ".$event_name."</strong><br><br>";

// Print the Order Verification to the screen.
        ?>				  
                        <p align="left"><strong><?php _e('Registration Detail Summary:','evr_language');?></strong></p>
                            <table width="95%" border="0">
                              <tr>
                                <td><strong><?php _e('Event Name/Cost:','evr_language');?></strong></td>
                                <td><?php echo $event_name;?> - <?php echo $ticket_order[0]['ItemCurrency'];?><?php echo $payment;?></td>
                              </tr>
                              <tr>
                                <td><strong><?php _e('Attendee Name:','evr_language');?></strong></td>
                                <td><?php echo $attendee_name?></td>
                              </tr>
                              <tr>
                                <td><strong><?php _e('Email Address:','evr_language');?></strong></td>
                                <td><?php echo $email?></td>
                              </tr>
                               <tr>
                                <td><strong><?php _e('Number of Attendees:','evr_language');?></strong></td>
                                <td><?php echo $quantity?></td>
                              </tr>
                               <tr>
                                <td><strong><?php _e('Order Details:','evr_language');?></strong></td>
                                <td><?php $row_count = count($ticket_order);
            for ($row = 0; $row < $row_count; $row++) {
            if ($ticket_order[$row]['ItemQty'] >= "1"){ echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."<br \>";}
            } ?></td>
                              </tr>
                            </table><br />
        <?php
//End Verification

$sql3 = "SELECT * FROM " . get_option('evr_payment') . " WHERE payer_id='$attendee_id' ";
                             
                             $result3 = mysql_query ( $sql3 );
                             $made_payments = mysql_num_rows($result3); // number of total rows in the database
                            if($made_payments > 0)  { 
                                $payment_made="0";
                                echo '<p align="left"><strong>';
                                _e('Payments Received:','evr_language');
                                echo "</strong></p>";
                            while ( $row3 = mysql_fetch_assoc ( $result3 ) ) {
                                echo  __('Payment','evr_language')." ".$row3['mc_currency']." ".$row3['mc_gross']." ".$row3['txn_type']." ".$row3['txn_id']." (".$row3['payment_date'].")"."<br />";
                                $payment_made = $payment_made + $row3['mc_gross'];
                                }
                                echo '<font color="red">';
                                echo "<br/>";
                                
                                _e('Total Outstanding Payment Due*:','evr_language');
                                $total_due = $payment - $payment_made;
                                echo $ticket_order[0]['ItemCurrency']." ".$total_due;
                                echo '</font><br/><br/>';
                                }
                                else {
                                    echo '<font color="red">';
                                _e('No Payments Received!','evr_language');
                                echo "<br/>";
                                _e('Total Payment Due*:','evr_language');
                                $total_due = $payment;
                                echo $ticket_order[0]['ItemCurrency']." ".$total_due;
                                echo '</font><br/><br/>';}
                                
_e('*Payments could take several days to post to this page. Please check back in several days if you made a payment and your payment is not showing at this time.','evr_language');
echo "<br><br>";
//Set payment value for return payments

$payment=$total_due;
//Paypal 
    if ($company_options['payment_vendor']=="PAYPAL"){
    $p = new paypal_class;// initiate an instance of the class
    if ($use_sandbox == "Y") {
		$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // testing paypal url
		echo "<h3 style=\"color:#ff0000;\" title=\"Payments will not be processed\">Sandbox Mode Is Active</h3>";
	}else {
		$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; // paypal url
	}
    	if ($payment != "0.00" || $payment != "" || $payment != " "){
			 			
			
			
				  $p->add_field('business', $company_options['payment_vendor_id']);
				  $p->add_field('return', evr_permalink($company_options['return_url']));
				  $p->add_field('cancel_return', evr_permalink($company_options['cancel_return']));
				  $p->add_field('notify_url', evr_permalink($company_options['evr_page_id']).'id='.$attendee_id.'&event_id='.$event_id.'&action=paypal_txn');
				  $p->add_field('item_name', $event_name . ' | Reg. ID: '.$attendee_id. ' | Name: '. $attendee_name .' | Total Registrants: '.$quantity);
				  $p->add_field('amount', $payment);
				  $p->add_field('currency_code', $ticket_order[0]['ItemCurrency']);
				  
				  //Post variables
				  $p->add_field('first_name', $fname);
				  $p->add_field('last_name', $lname);
				  $p->add_field('email', $email);
				  $p->add_field('address1', $address);
				  $p->add_field('city', $city);
				  $p->add_field('state', $state);
				  $p->add_field('zip', $zip);				 
                  $p->submit_paypal_post(); // submit the fields to paypal
				  if ($company_options['use_sandbox'] == "Y") {
					  $p->dump_fields(); // for debugging, output a table of all the fields
				  }   
			
			}
	  
    
 }
 //End Paypal Section
 
 
//Authorize.Net Payment Section
if ($company_options['payment_vendor']=="AUHTHORIZE"){
        //Authorize.Net Payment 
        // This sample code requires the mhash library for PHP versions older than
        // 5.1.2 - http://hmhash.sourceforge.net/
        // the parameters for the payment can be configured here
        // the API Login ID and Transaction Key must be replaced with valid values
        $loginID		= $company_options['payment_vendor_id'];
        $transactionKey = $company_options['$txn_key'];
        $amount 		= $payment;
        $description 	= $event_name . ' | Reg. ID: '.$attendee_id. ' | Name: '. $attendee_name .' | Total Registrants: '.$quantity;
        $label 			= "Submit Payment"; // The is the label on the 'submit' button
        if ($company_options['use_sandbox'] == "Y") {$testMode		= "true";}
        if ($company_options['use_sandbox'] == "N") {$testMode		= "false";}
        // By default, this sample code is designed to post to our test server for
        // developer accounts: https://test.authorize.net/gateway/transact.dll
        // for real accounts (even in test mode), please make sure that you are
        // posting to: https://secure.authorize.net/gateway/transact.dll
        $url			= "https://secure.authorize.net/gateway/transact.dll";
        
        // If an amount or description were posted to this page, the defaults are overidden
        if ($_REQUEST["amount"])
        	{ $amount = $_REQUEST["amount"]; }
        if ($_REQUEST["description"])
        	{ $description = $_REQUEST["description"]; }
        
        // an invoice is generated using the date and time
        $invoice	= date(YmdHis);
        // a sequence number is randomly generated
        $sequence	= rand(1, 1000);
        // a timestamp is generated
        $timeStamp	= time ();
        
        // The following lines generate the SIM fingerprint.  PHP versions 5.1.2 and
        // newer have the necessary hmac function built in.  For older versions, it
        // will try to use the mhash library.
        if( phpversion() >= '5.1.2' )
        {	$fingerprint = hash_hmac("md5", $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey); }
        else 
        { $fingerprint = bin2hex(mhash(MHASH_MD5, $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey)); }
        
             
        // Create the HTML form containing necessary SIM post values
        echo "<FORM method='post' action='$url' >";
        // Additional fields can be added here as outlined in the SIM integration guide
        // at: http://developer.authorize.net
        echo "	<INPUT type='hidden' name='x_login' value='$loginID' />";
        if ($price == "0"){echo "Enter Amount $<INPUT type='text' name='x_amount' value='10.00' />";}
        else { echo "	<INPUT type='hidden' name='x_amount' value='$amount' />";}
        echo "	<INPUT type='hidden' name='x_description' value='$description' />";
        echo "	<INPUT type='hidden' name='x_invoice_num' value='$invoice' />";
        echo "	<INPUT type='hidden' name='x_fp_sequence' value='$sequence' />";
        echo "	<INPUT type='hidden' name='x_fp_timestamp' value='$timeStamp' />";
        echo "	<INPUT type='hidden' name='x_fp_hash' value='$fingerprint' />";
        echo "	<INPUT type='hidden' name='x_test_request' value='$testMode' />";
        echo "	<INPUT type='hidden' name='x_show_form' value='PAYMENT_FORM' />";
        echo "	<input type='submit' value='$label' />";
        echo "</FORM>";

// This is the end of the code generating the "submit payment" button.    -->
}
//End Authorize.Net Section 

//GooglePay Payment Section
    if ($company_options['payment_vendor']=="GOOGLE"){
          
        // Create the HTML Payment Button
    
    //Google Payment Button
    ?>
     <form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/<?php echo $company_options['payment_vendor_id'];?>" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
    <input name="item_name_1" type="hidden" value="<?php echo $event_name."-".$attendee_name;?>"/>
    <input name="item_description_1" type="hidden" value="<?php echo $event_name . ' | Reg. ID: '.$attendee_id. ' | Name: '. $attendee_name .' | Total Registrants: '.$quantity;?>"/>
    <input name="item_quantity_1" type="hidden" value="1"/>
    <input name="item_price_1" type="hidden" value="<?php echo $payment;?>"/>
        <input name="item_currency_1" type="hidden" value="<?php echo $ticket_order[0]['ItemCurrency'];?>"/>
    <input name="_charset_" type="hidden" value="utf-8"/>
    <input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=<?php echo $company_options['payment_vendor_id'];?>&amp;w=117&amp;h=48&amp;style=trans&amp;variant=text&amp;loc=en_US" type="image"/>
    </form>
    <?php
 
}
//End Google Pay Section

//Begin Monster Pay Section
if ($company_options['payment_vendor']=="MONSTER"){

//Display Payment Button
?>    
<form action="https://www.monsterpay.com/secure/index.cfm" method="POST" enctype="APPLICATION/X-WWW-FORM-URLENCODED" target="_BLANK">
<input type="hidden" name="ButtonAction" value="buynow">
<input type="hidden" name="MerchantIdentifier" value="<?php echo $company_options['payment_vendor_id'];?>">
<input type="hidden" name="LIDDesc" value="<?php echo $event_name . ' | Reg. ID: '.$attendee_id. ' | Name: '. $attendee_name .' | Total Registrants: '.$quantity;?>">
<input type="hidden" name="LIDSKU" value="<?php echo $event_name."-".$attendee_name;?>">
<input type="hidden" name="LIDPrice" value="<?php echo $payment;?>">
<input type="hidden" name="LIDQty" value="1">
<input type="hidden" name="CurrencyAlphaCode" value="<?php echo $ticket_order[0]['ItemCurrency'];?>">
<input type="hidden" name="ShippingRequired" value="0">
<input type="hidden" name="MerchRef" value="">
<input type="submit" value="Buy Now" style="background-color: #DCDCDC; font-family: Arial; font-size: 11px; color: #000000; font-weight: bold; border: 1px groove #000000;">
</form> 
<?php   

}
//End Monster Pay Section



	}
}
?>