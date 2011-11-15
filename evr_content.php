<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

//function that provides the content in the content replacement for main public page
function evr_main_content(){
    
}
//function that provides the content in the content replacement for widget
function evr_widget_content(){
    echo "This feature currently not available";
    
}
//function to add payment shortcode option page on public page for plugin
function evr_payment_page(){
        global $wpdb;
		$id="";
        $first = "";
        $first = $_GET['fname'];
		$id=$_GET['id'];
        if ($id =="") {_e('Please check your email for payment information. Click the link provided in the registration confirmation.','evr_language');}
        else if ($first ==""){_e('Please check your email for payment information. Click the link provided in the registration confirmation.','evr_language');}
        else {
            
            
			$query  = "SELECT * FROM ".get_option('evr_attendee')." WHERE id='$id' AND fname = '$first'";
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

				
			$company_options = get_option('evr_company_settings');
				$company =$company_options['company'];
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
                        <p align="left"><strong>Registration Detail Summary:</strong></p>
                            <table width="95%" border="0">
                              <tr>
                                <td><strong>Event Name/Cost:</strong></td>
                                <td><?php echo $event_name;?> - <?php echo $ticket_order[0]['ItemCurrency'];?><?php echo $payment;?></td>
                              </tr>
                              <tr>
                                <td><strong>Attendee Name:</strong></td>
                                <td><?php echo $attendee_name?></td>
                              </tr>
                              <tr>
                                <td><strong>Email Address:</strong></td>
                                <td><?php echo $email?></td>
                              </tr>
                               <tr>
                                <td><strong>Number of Attendees:</strong></td>
                                <td><?php echo $quantity?></td>
                              </tr>
                               <tr>
                                <td><strong>Order Details:</strong></td>
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
                                _e('Payments Recieved:','evr_language');
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
    //Get Payment Info
    if ($company_options['pay_now']!=""){$pay_now = $company_options['pay_now'];} else {$pay_now = "PAY NOW";}
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
				  $p->add_field('notify_url', evr_permalink($company_options['notify_url']).'id='.$attendee_id.'&event_id='.$event_id.'&attendee_action=post_payment&form_action=payment');
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
                  $p->submit_paypal_post($pay_now); // submit the fields to paypal
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
        $label 			= $pay_now; // The is the label on the 'submit' button
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
<input type="submit" value="<?php echo $pay_now;?>" style="background-color: #DCDCDC; font-family: Arial; font-size: 11px; color: #000000; font-weight: bold; border: 1px groove #000000;">
</form> 
<?php   

}
//End Monster Pay Section



	}
    
   

}
//function to add calendar shortcode page on public page for plugin
function evr_calendar_page(){}
//function to add single event shortcode page on public page for plugin
function evr_single_event($atts){
    extract(shortcode_atts(array('event_id' => 'No ID Supplied'), $atts));
	$id = "{$event_id}";
	//register_attendees($single_event_id);
    ob_start();
    evr_regform_new($id);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;

}
/*
function display_events_by_category($atts, $content=null) {
	extract(shortcode_atts(array('event_category_id' => 'No Category ID Supplied'), $atts));
	$event_category_id = "{$event_category_id}";
    //$event_id = $_REQUEST['event_id'];
    (is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
    ob_start();
    if ($event_id !=""){
         $id=$event_id;
         event_regis_run($id);
    } else { 
	display_all_events($event_category_id);}
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

*/

//function to add events by category page on public page for plugin
function evr_by_category($atts, $content=null){
    extract(shortcode_atts(array('event_category_id' => 'No Category ID Supplied'), $atts));
	$event_category_id = "{$event_category_id}";
    global $wpdb;
    ob_start();
	$curdate = date ( "Y-m-j" );
    $category_id = null;    
    $sql = null;    
		if ($event_category_id != ""){
		  $sql2  = "SELECT * FROM " . get_option('evr_category') . " WHERE category_identifier = '".$event_category_id."'";
          
					$result = mysql_query($sql2);
					while ($row = mysql_fetch_assoc ($result)){
					$category_id= $row['id'];
                                    	$category_name=$row['category_name'];
                                    	$category_identifier=$row['category_identifier'];
                                    	$category_desc=$row['category_desc'];
                                    	$display_category_desc=$row['display_desc'];
                                        $category_color = $row['category_color'];
                                        $font_color = $row['font_color'];
					echo "<p><b>".$category_name."</b><br>".$category_desc."</p>";
                    }
                  	$sql = "SELECT * FROM " . get_option('evr_event') ." WHERE category_id LIKE '%\"$category_id\"%' AND str_to_date(end_date, '%Y-%m-%e') >= curdate() ORDER BY str_to_date(start_date, '%Y-%m-%e')"; 
                    
   //$sql = "SELECT * FROM " . get_option('evr_event');
    $result = mysql_query ( $sql );
?>
<div class="evr_event_list">
<table class="evr_events">
<thead>
    <tr><th>EVENT</th><th></th><th></th><th>START</th><th>-</th><th>END</th></tr>
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
            <td class="er_title er_ticket_info"><b><a href="#?w=800" rel="popup<?php echo $event_id;?>" class="poplight"><?php echo $event_name;?></a></b></td>
            <td></td><td></td>
            <td class="er_date"><?php echo date('M d, Y',strtotime($start_date));?></td>
            <td class="er_date"><?php echo date('M d, Y',strtotime($end_date));?></td></tr>
            <?php  if ($color_row ==1){$color_row = "2";} else if ($color_row ==2){$color_row = "1";}
        }
        ?>
    </tbody></table></div>
<style>
#fade { /*--Transparent background layer--*/
	display: none; /*--hidden by default--*/
	background: #000;
	position: fixed; left: 0; top: 0;
	width: 100%; height: 100%;
	opacity: .80;
	z-index: 9999;
}
.popup_block{
	display: none; /*--hidden by default--*/
	background: #fff;
	padding: 20px;
	border: 20px solid #ddd;
	float: left;
	font-size: 12px;
	position: fixed;
	top: 50%; left: 50%;
    
	z-index: 99999;
	/*--CSS3 Box Shadows--*/
	-webkit-box-shadow: 0px 0px 20px #000;
	-moz-box-shadow: 0px 0px 20px #000;
	box-shadow: 0px 0px 20px #000;
	/*--CSS3 Rounded Corners--*/
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
}
img.btn_close {
	float: right;
	margin: -55px -55px 0 0;
}
/*--Making IE6 Understand Fixed Positioning--*/
*html #fade {
	position: absolute;
}
*html .popup_block {
	position: absolute;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function($){
	 					   		   
							   		   
	//When you click on a link with class of poplight and the href starts with a # 
	$('a.poplight[href^=#]').click(function() {
		var popID = $(this).attr('rel'); //Get Popup Name
		var popURL = $(this).attr('href'); //Get Popup href to define size
				
		//Pull Query & Variables from href URL
		var query= popURL.split('?');
		var dim= query[1].split('&');
		var popWidth = dim[0].split('=')[1]; //Gets the first query string value

		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="<?php echo EVR_PLUGINFULLURL;?>images/btn-close.png" class="btn_close" title="Close Window" alt="Close" /></a>');
		
		//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		
		//Apply Margin to Popup
		$('#' + popID).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		//Fade in Background
		$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
		
		return false;
	});
	
	   
	//Close Popups and Fade Layer
	$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
	  	$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();  
	}); //fade them both out
		
		return false;
	});

	
});
</script>    
    
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
                               
                               //div for popup goes here.
                            ?>
                            <style>
                            table.evr_evntpop {
                                width:100%;
                                border-collapse:collapse;
                                font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                            }
                            .evr_evntpop.th{
                                border-collapse:collapse;
                                font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                                
                            }
                            .evr_evntpop.td{
                                border-collapse:collapse;
                                font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                            }
                            </style>
                            <div id="popup<?php echo $event_id;?>" class="popup_block">
                            	<?php if ($header_image !=""){?><img src="<?php echo $header_image;?>" alt="Header Image" style="float: center; margin: 20px 0 0 20px;" /><?php } ?>
                                <br /><table class="evr_evntpop">
                                <tr><th rowspan="5" valign="top">
                                <?php if ($image_link !=""){?><img src="<?php echo $image_link;?>" alt="Thumbnail Image" style="float: left; margin: 20px 0 0 20px;" /><?php } ?>
                                </th><td>&nbsp;&nbsp;&nbsp;&nbsp; </td><td colspan="2"><h3><?php echo $event_name;?></h3></td></tr>
                                <tr><td></td><td colspan="2"><font color="green"><pre><?php echo $start_date." ".$start_time." through ".$end_date." ".$end_time;?></pre></font></td></tr>
                                <tr><td></td><td colspan="2"><?php echo html_entity_decode($event_desc);?></td></tr><tr></tr>
                                <tr><td></td><td colspan="2"><b><u><?php _e('Event Fees','evr_language');?>:</u></b><br /><?php
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
                                        
                                        echo $item_title.'   '.$item_custom_cur.' '.$item_price.'<br />';
                                        
                                        }
                                
                                 ?>
                              
                                </td></tr>
                                <tr><td colspan="2"></td><td><?php echo $event_location;?><br />
                                <?php echo $event_address;?><br />
                                <?php echo $event_city.", ".$event_state." ".$event_postal;?><br />
                                </td><td align="center"><img border="0" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $event_address.",".$event_city.",".$event_state;?>&zoom=14&size=240x120&maptype=roadmap&markers=size:mid|color:0xFFFF00|label:*|<?php echo $event_address.",".$event_city;?>,Austria&sensor=false" />
                                </td></tr>
                                <tr><td colspan="4" align="center"><br><a href="<?php echo evr_permalink($company_options['evr_page_id']);?>action=register&event_id=<?php echo $event_id;?>"><?php _e('REGISTER','evr_language');?></a>
                                <a href="<?php echo EVR_PLUGINFULLURL."evr_ics.php";?>?event_id=<?php echo $event_id;?>"><?php _e('Add To Calendar','evr_language');?></a></td>
                                </tr></table>
                            </div>
                            <?php
                               
                 }         
                               
            				
            					
            			
}
$buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
    
}


//Shortcode functions for Attendee List
function evr_attendee_short($atts){
    extract(shortcode_atts(array('event_id' => 'No ID Supplied'), $atts));
	$id = "{$event_id}";
	ob_start();
    evr_attendee_list($id);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

function evr_attendee_list($event_id){
    
    global $wpdb;
    $event = $wpdb->get_row('SELECT * FROM ' . get_option('evr_event') . ' WHERE id = ' . $event_id);
    echo "<h2>";
    _e('Attendee List for ','evr_language');
    echo stripslashes($event->event_name)."</h2>";
    $participants = $wpdb->get_results("SELECT * from ".get_option('evr_attendee')." where event_id = '$event_id'");

    
//get attendeeds from each registration and put them into a single array    
    if ($participants) {
        $people = array();
       	foreach ($participants as $participant) {
            $attendee_array = unserialize($participant->attendees);
            if ( count($attendee_array)>"0"){
                $i = 0;
                 do {
                    array_push($people,$attendee_array[$i]);
                    
                    ++$i;
                 } while ($i < count($attendee_array));
            }
        }
    }
    
//sort array of all attendees

 $tmp = Array();
 foreach($people as &$aSingleArray)    $tmp[] = &$aSingleArray["last_name"];
 $tmp = array_map('strtolower', $tmp);
 array_multisort($tmp, $people);
 if ( count($people)>"0"){
                $i = 0;
                 do {
                    $digit = $i + 1;
                    echo $digit.".)  ".$people[$i]["first_name"]." ".$people[$i]['last_name']."<br/>";
                    ++$i;
                 } while ($i < count($people));
            }
  

}

?>