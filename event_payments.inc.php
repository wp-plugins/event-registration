<?php

function event_process_payments(){

	function list_attendee_payments() {
		//Displays attendee information from current active event.
		global $wpdb;
		$events_detail_tbl = get_option ( 'events_detail_tbl' );
		$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
		$event_id = $_REQUEST ['event_id'];
		
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$event_id'";
		$result = mysql_query ( $sql );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$event_id = $row ['id'];
			$event_name = $row ['event_name'];
			$event_desc = $row ['event_desc'];
			$event_description = $row ['event_desc'];
			$identifier = $row ['event_identifier'];
			$cost = $row ['event_cost'];
			$checks = $row ['allow_checks'];
			$active = $row ['is_active'];
			$question1 = $row ['question1'];
			$question2 = $row ['question2'];
			$question3 = $row ['question3'];
			$question4 = $row ['question4'];
		}
		
		$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
		$result = mysql_query ( $sql );
		echo "<p><b>Current Active Event is: " . $event_name . " - " . $identifier . "</b>";
		define ( "EVNT_RGR_PLUGINPATH", "/" . plugin_basename ( dirname ( __FILE__ ) ) . "/" );
		define ( "EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );
		$url = EVNT_RGR_PLUGINFULLURL;
		
		?>
<button style="background-color: lightgreen"
	onclick="window.location='<?php
		echo $url . "event_registration_export.php?id=" . $event_id . "&action=payment";
		?>'"
	style="width:180; height: 30">Export Event Payment List To Excel</button>
<?php
		echo "</p><hr><table>";
		echo "<tr><td width='15'></td><td> ID </td><td> Name </td><td> Email </td><td width='15'></td><td> Pay Status </td><td> TXN Type </td>
						<td> TXN ID </td><td> Amount Pd </td><td> Date Paid </td><tr>";
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$id = $row ['id'];
			$lname = $row ['lname'];
			$fname = $row ['fname'];
			$address = $row ['address'];
			$city = $row ['city'];
			$state = $row ['state'];
			$zip = $row ['zip'];
			$email = $row ['email'];
			$phone = $row ['phone'];
			$date = $row ['date'];
			$paystatus = $row ['paystatus'];
			$txn_type = $row ['txn_type'];
			$txn_id = $row ['txn_id'];
			$amt_pd = $row ['amount_pd'];
			$date_pd = $row ['paydate'];
			$event_id = $row ['event_id'];
			$custom1 = $row ['custom_1'];
			$custom2 = $row ['custom_2'];
			$custom3 = $row ['custom_3'];
			$custom4 = $row ['custom_4'];
			
			echo "<tr><td width='15'></td><td>" . $id . "</td><td align='left'>" . $lname . ", " . $fname . "</td><td>" . $email . "</td><td width='15'>
									</td><td>" . $paystatus . "</td><td>" . $txn_type . "</td><td>" . $txn_id . "</td><td> $" . $amt_pd . "</td><td>" . $date_pd . "</td>";
			echo "<td>";
			echo "<form name='form' method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
			echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
			echo "<input type='hidden' name='attendee_pay' value='paynow'>";
			echo "<input type='hidden' name='form_action' value='payment'>";
			echo "<input type='hidden' name='id' value='" . $id . "'>";
			// echo "<INPUT TYPE='SUBMIT' VALUE='ENTER PAYMENT' ONCLICK=\"return confirm('Are you sure you want to enter a payment for 	".$fname." ".$lname."?')\"></form>";
			echo "<INPUT TYPE='SUBMIT' VALUE='ENTER PAYMENT'></form>";
			
			echo "</td></tr>";
		}
		echo "</table>";
	}

	function enter_attendee_payments() {
		global $wpdb;
		$events_detail_tbl = get_option ( 'events_detail_tbl' );
		$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
		$event_id = $_REQUEST ['event_id'];
		$today = date ( "m-d-Y" );
		
		if ($_REQUEST ['form_action'] == 'payment') {
			
			if ($_REQUEST ['attendee_action'] == 'post_payment') {
				
				$id = $_REQUEST ['id'];
				$paystatus = $_REQUEST ['paystatus'];
				$txn_type = $_REQUEST ['txn_type'];
				$txn_id = $_REQUEST ['txn_id'];
				$amt_pd = $_REQUEST ['amt_pd'];
				$date_pd = $_REQUEST ['date_pd'];
				
				$sql = "UPDATE " . $events_attendee_tbl . " SET paystatus = '$paystatus', txn_type = '$txn_type', 
									   txn_id = '$txn_id', amount_pd = '$amt_pd', paydate ='$date_pd' WHERE id ='$id'";
				$wpdb->query ( $sql );
				//	Send Payment Recieved Email
				

				if ($_REQUEST ['send_payment_rec'] == "send_message") {
					
					$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
					$result = mysql_query ( $sql );
					while ( $row = mysql_fetch_assoc ( $result ) ) {
						$id = $row ['id'];
						$lname = $row ['lname'];
						$fname = $row ['fname'];
						$address = $row ['address'];
						$city = $row ['city'];
						$state = $row ['state'];
						$zip = $row ['zip'];
						$email = $row ['email'];
						$phone = $row ['phone'];
						$date = $row ['date'];
						$paystatus = $row ['paystatus'];
						$txn_type = $row ['txn_type'];
						$txn_id = $row ['txn_id'];
						$amt_pd = $row ['amount_pd'];
						$date_pd = $row ['paydate'];
						$event_id = $row ['event_id'];
						$custom1 = $row ['custom_1'];
						$custom2 = $row ['custom_2'];
						$custom3 = $row ['custom_3'];
						$custom4 = $row ['custom_4'];
					}
					
					$events_organization_tbl = get_option ( 'events_organization_tbl' );
					$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
					// $sql  = "SELECT * FROM wp_events_organization WHERE id='1'"; 
					$result = mysql_query ( $sql );
					while ( $row = mysql_fetch_assoc ( $result ) ) {
						$return_url = $row ['return_url'];
					}
					$payment_link = $return_url . "?id=" . $id;
					$subject = "Event Payment Received";
					$distro = $email;
					$message = ("***This Is An Automated Response***   Thank You $fname $lname.  We have received a payment in the amount of $ $amt_pd for your event registration.  To make payment or view your payment information go to: " . $payment_link);
					
					wp_mail ( $distro, $subject, $message );
					
					echo "<p>Payment Received notification sent to $fname $lname.</p>";
				
				}
				
			//echo "<meta http-equiv='refresh' content='0'>";
			

			} else {
				$id = $_REQUEST ['id'];
				$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
				$result = mysql_query ( $sql );
				while ( $row = mysql_fetch_assoc ( $result ) ) {
					$id = $row ['id'];
					$lname = $row ['lname'];
					$fname = $row ['fname'];
					$address = $row ['address'];
					$city = $row ['city'];
					$state = $row ['state'];
					$zip = $row ['zip'];
					$email = $row ['email'];
					$phone = $row ['phone'];
					$date = $row ['date'];
					$paystatus = $row ['paystatus'];
					$txn_type = $row ['txn_type'];
					$txn_id = $row ['txn_id'];
					$amt_pd = $row ['amount_pd'];
					$date_pd = $row ['paydate'];
					$event_id = $row ['event_id'];
					$custom1 = $row ['custom_1'];
					$custom2 = $row ['custom_2'];
					$custom3 = $row ['custom_3'];
					$custom4 = $row ['custom_4'];
				}
				
				echo "<form method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
				
				echo "<p>Payment For: " . $fname . " " . $lname . "</p>";
				?>
				
													PayStatus
<input name="paystatus" size="45"
	value="<?php
				echo $paystatus;
				?>">
<br />
Transaction Type:
<input name="txn_type" size="45"
	value="<?php
				echo $txn_type;
				?>">
<br />
Transaction ID:
<input name="txn_id" size="45" value="<?php
				echo $txn_id;
				?>">
<br />
Amount Paid:
<input name="amt_pd" size="45" value="<?php
				echo $amt_pd;
				?>">
<br />
Date Paid:
<input name="date_pd" size="45"
	value="<?php
				if ($date_pd != "") {
					echo $date_pd;
				}
				if ($date_pd == "") {
					echo $today;
				}
				?>">
<br />
<p>Do you want to send a payment recieved notice to registrant?
<INPUT TYPE='radio' NAME='send_payment_rec' CHECKED VALUE='send_message'>
Yes
<INPUT TYPE='radio' NAME='send_payment_rec' VALUE='N'>
No
</p>
<?php
				echo "<input type='hidden' name='id' value='" . $id . "'>";
				?>
													<?php
				echo "<input type='hidden' name='form_action' value='payment'>";
				?>
													<?php
				echo "<input type='hidden' name='attendee_pay' value='paynow'>";
				?>
													<?php
				echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
				?>
													<?php
				echo "<input type='hidden' name='attendee_action' value='post_payment'>";
				?>
<p><input type="submit" name="Submit" value="POST PAYMENT"></p>
</form>
<hr>
<?php
			
			}
		}
	
	}
	global $wpdb;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$sql = "SELECT * FROM " . $events_detail_tbl;
	Echo "<p align='center'><p align='left'>SELECT EVENT TO ENTER ATTENDEE PAYMENTS:</p><table width = '400'>";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		
		echo "<tr><td width='25'></td><td><form name='form' method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
		echo "<input type='hidden' name='event_id' value='" . $row ['id'] . "'>";
		echo "<input type='hidden' name='attendee_pay' value='paynow'>";
		echo "<INPUT TYPE='SUBMIT' VALUE='" . $event_name . "'></form></td><tr>";
	}
	echo "</table>";
	
	if ($_REQUEST ['attendee_pay'] == "paynow") {
		enter_attendee_payments ();
		list_attendee_payments ();
	}
}

function event_regis_pay() {
	
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$paypal_cur = get_option ( 'paypal_cur' );
	$id = "";
	$id = $_GET ['id'];
	if ($id == "") {
		echo "Please check your email for payment information.";
	} else {
		$query = "SELECT * FROM $events_attendee_tbl WHERE id='$id'";
		$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$attendee_id = $row ['id'];
			$lname = $row ['lname'];
			$fname = $row ['fname'];
			$address = $row ['address'];
			$city = $row ['city'];
			$state = $row ['state'];
			$zip = $row ['zip'];
			$num_people ['num_people'];
			$email = $row ['email'];
			$phone = $row ['phone'];
			$date = $row ['date'];
			$paystatus = $row ['paystatus'];
			$txn_type = $row ['txn_type'];
			$amt_pd = $row ['amount_pd'];
			$date_pd = $row ['paydate'];
			$event_id = $row ['event_id'];
			$custom1 = $row ['custom_1'];
			$custom2 = $row ['custom_2'];
			$custom3 = $row ['custom_3'];
			$custom4 = $row ['custom_4'];
			$attendee_name = $fname . " " . $lname;
		
		}
		
		$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
		$result = mysql_query ( $sql );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$org_id = $row ['id'];
			$Organization = $row ['organization'];
			$Organization_street1 = $row ['organization_street1'];
			$Organization_street2 = $row ['organization_street2'];
			$Organization_city = $row ['organization_city'];
			$Organization_state = $row ['organization_state'];
			$Organization_zip = $row ['organization_zip'];
			$contact = $row ['contact_email'];
			$registrar = $row ['contact_email'];
			$paypal_id = $row ['paypal_id'];
			$paypal_cur = $row ['currency_format'];
			$events_listing_type = $row ['events_listing_type'];
			$return_url = $row ['return_url'];
			$message = $row ['message'];
				$return_url = $row['return_url'];
				$cancel_return = $row['cancel_return'];
				$notify_url = $row['notify_url'];
				$return_method = $row['return_method'];
				$image_url = $row['image_url'];
				$use_sandbox = $row['use_sandbox'];
			if ($paypal_cur == "USD" || $paypal_cur == "") {
				$paypal_cur = "$";
			}
		}
		
		//Query Database for Active event and get variable
		

		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$event_id'";
		$result = mysql_query ( $sql );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			//$event_id = $row['id'];
			$event_name = $row ['event_name'];
			$event_desc = $row ['event_desc'];
			$event_description = $row ['event_desc'];
			$identifier = $row ['event_identifier'];
			$event_cost = $row ['event_cost'];
			$allow_checks = $row ['allow_checks'];
			$active = $row ['is_active'];
			$question1 = $row ['question1'];
			$question2 = $row ['question2'];
			$question3 = $row ['question3'];
			$question4 = $row ['question4'];
		}
		
		echo "<p><b>Thank You " . $fname . " " . $lname . " for registering for " . $event_name . "</b></p>";
		
		if ($amt_pd != "") {
			echo "<p><b><u><i><font color='red' size='3'>Our records indicate you have paid " . $paypal_cur . " " . $amt_pd . "</font></u></i></b></p>";
		}
		if ($event_cost != "") {
			$total_cost = $event_cost * $num_people;
			$current_due = $total_cost - $amt_pd;
			if ($allow_checks == "yes") {
				echo "<p><b>PLEASE MAKE CHECKS PAYABLE TO: <u>$Organization</u></b></p>"; // BHC Changed for clarity.
				echo "<p><b>IN THE AMOUNT OF <u>$paypal_cur $current_due</u></b></p>";
				echo "<p>$Organization" . BR;
				echo $Organization_street1 . " " . $Organization_street2 . BR;
				echo $Organization_city . ", " . $Organization_state . "   " . $Organization_zip . "</p>";
				echo "<hr>";
			}
			
			if ($paypal_id != "") {
				//Payment Selection with data hidden - forwards to paypal
				

				?>
<p align="left"><b>Payment By Credit Card, Debit Card or Pay Pal Account<br />
(a PayPal account is not required to pay by credit card).</b></p>
<p>Payment will be in the amount of <?php
	$total_cost = $event_cost * $num_people;
	$current_due = $total_cost - $amt_pd;
				echo $paypal_cur . " " . $current_due;
				?>.</p>
<p>PayPal Payments will be sent to: <?php
				echo $Organization . " (" . $paypal_id;
				?>)</p>
<?php
				if ($paypal_cur == "$" || $paypal_cur == "") {
					$paypal_cur = "USD";
				}
				?>
</p>

<table width="500">
	<tr>
		<td VALIGN='MIDDLE' ALIGN='CENTER'>&nbsp;<br />
		<B><?php
				echo $event_name . " - " . $paypal_cur . " " . $current_due;
				if ($current_due < $event_cost){$payment = "- Partial";}
				if ($current_due == $event_cost){$payment = "- Full";}
				?></b>&nbsp;</td>
		<td WIDTH="150" VALIGN='MIDDLE' ALIGN='CENTER'>
		<? 
/*	  if ($use_sandbox == 1){ 
      		echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>";
       }else{
      		echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
	   }
	   */
	   ?>
     
		<form action="https://www.paypal.com/cgi-bin/webscr" target="paypal"
			method="post"><font face="Arial"> <input type="hidden" name="bn"
			value="AMPPFPWZ.301" style="font-weight: 700"> <input type="hidden"
			name="cmd" value="_xclick" style="font-weight: 700"> <input
			type="hidden" name="business"
			value="<?php
				echo $paypal_id;
				?>" style="font-weight: 700"> <input type="hidden" name="item_name"
			value="<?php
				echo $event_name . " - " . $attendee_id . " - " . $attendee_name . $payment;
				?>"
			style="font-weight: 700"> <input type="hidden" name="item_number"
			value="<?php
				echo $event_identifier;
				?>"
			style="font-weight: 700"> <input type="hidden" name="amount"
			value="<?php
				echo $current_due;
				?>" style="font-weight: 700"> <input type="hidden"
			name="currency_code" value="<?php
				echo $paypal_cur;
				?>"
			style="font-weight: 700"> <input type="hidden"
			name="undefined_quantity" value="0" style="font-weight: 700"> <input
			type="hidden" name="custom"
			value="<?php
				echo $attendee_id;
				?>"
			style="font-weight: 700"> <input type="hidden" name="image_url"
			style="font-weight: 700"> </font><b><font face="Arial" size="2">&nbsp;<br />
		<input type="image"
			src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif"
			border="0" align='middle' name="submit"><br />
		&nbsp; </font></b></form>
		</td>
	</tr>
</table><?php
			}
		}
	}
}

function events_payment_paypal() {
	//you can load your paypal IPN processing script here
	//change the above if statement to the actual paypal word for this function to work
	echo "PayPal Info Here.\n\n"; // BHC
}

function events_payment_page($event_id) {
	
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$attendee_id = get_option ( 'attendee_id' );
	$attendee_name = get_option ( 'attendee_name' );
	$paypal_cur = get_option ( 'paypal_cur' );
	
		$query = "SELECT * FROM $events_attendee_tbl WHERE id='$attendee_id'";
		$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$attendee_id = $row ['id'];
			$lname = $row ['lname'];
			$fname = $row ['fname'];
			$address = $row ['address'];
			$city = $row ['city'];
			$state = $row ['state'];
			$zip = $row ['zip'];
			$num_people ['num_people'];
			$email = $row ['email'];
			$phone = $row ['phone'];
			$date = $row ['date'];
			$paystatus = $row ['paystatus'];
			$txn_type = $row ['txn_type'];
			$amt_pd = $row ['amount_pd'];
			$date_pd = $row ['paydate'];
			$event_id = $row ['event_id'];
			$custom1 = $row ['custom_1'];
			$custom2 = $row ['custom_2'];
			$custom3 = $row ['custom_3'];
			$custom4 = $row ['custom_4'];
			$attendee_name = $fname . " " . $lname;
		}
	
	//query event database for organization information
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$org_id = $row ['id'];
		$Organization = $row ['organization'];
		$Organization_street1 = $row ['organization_street1'];
		$Organization_street2 = $row ['organization_street2'];
		$Organization_city = $row ['organization_city'];
		$Organization_state = $row ['organization_state'];
		$Organization_zip = $row ['organization_zip'];
		$contact = $row ['contact_email'];
		$registrar = $row ['contact_email'];
		$paypal_id = $row ['paypal_id'];
		$paypal_cur = $row ['currency_format'];
		$events_listing_type = $row ['events_listing_type'];
		$message = $row ['message'];
				$return_url = $row['return_url'];
				$cancel_return = $row['cancel_return'];
				$notify_url = $row['notify_url'];
				$return_method = $row['return_method'];
				$image_url = $row['image_url'];
				$use_sandbox = $row['use_sandbox'];
	}
	
	//Query Database for Active event and get variable
	

	$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id ='$event_id'";
	
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$event_desc = $row ['event_desc'];
		$event_description = $row ['event_desc'];
		$identifier = $row ['event_identifier'];
		$event_cost = $row ['event_cost'];
		$allow_checks = $row ['allow_checks'];
		$send_mail = $row ['send_mail'];
		$active = $row ['is_active'];
		$question1 = $row ['question1'];
		$question2 = $row ['question2'];
		$question3 = $row ['question3'];
		$question4 = $row ['question4'];
		$conf_mail = $row ['conf_mail'];
	}
	
	if ($event_cost != "") {
		$total_cost = $event_cost * $num_people;
				
		if ($allow_checks == "yes") {
			echo "<p><b>PLEASE MAKE CHECKS IN THE AMOUNT OF: <u>$total_cost</u></b></p>";
			echo  "<p><b>PLEASE MAKE CHECKS PAYABLE TO: <u>$Organization</u></b></p>"; // BHC Changed for clarity.
			echo "<p>$Organization" . BR;
			echo $Organization_street1 . " " . $Organization_street2 . BR;
			echo $Organization_city . ", " . $Organization_state . "   " . $Organization_zip . "</p>";
			echo "<hr />";
		}
		
		if ($paypal_id != "") {
			//Payment Selection with data hidden - forwards to paypal
			if ($paypal_cur == "USD" || $paypal_cur == "") {
				$paypal_cur = "$";
			}
			?>
<p align="left"><b>Payment By Credit Card, Debit Card or Pay Pal Account<br />
(a pay pal account is not required to pay by credit card).</b></p>
<p>PayPal Payments will be sent to: <?php
			echo $paypal_id;
			?></p>
</p>

<table width="500">
	<tr><? /*
	  if ($use_sandbox == 1){ 
      		echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>";
       }else{
      		echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
	   }*/
	  ?>
		<td VALIGN='MIDDLE' ALIGN='CENTER'>&nbsp;<br />
		<B><?php
			echo $event_name . " - " . $paypal_cur . " " . $total_cost;
			?></b>&nbsp;</td>
			
			<?php
			if ($paypal_cur == "$" || $paypal_cur == "") {
				$paypal_cur = "USD";
			}
	/*		
			Additional attendees?
      <select name="quantity" style="width:70px;margin-top:4px">
        <option value="1" selected>None</option>
        <option value="2">1</option>
        <option value="3">2</option>
        <option value="4">3</option>
        <option value="5">4</option>
        <option value="6">5</option>
      </select>
      <input type="hidden" name="bn" value="AMPPFPWZ.301">
      <input type="hidden" name="cmd" value="_ext-enter">
      <input type="hidden" name="redirect_cmd" value="_xclick">
      <input type="hidden" name="business" value="<?=$paypal_id;?>" >
      <input type="hidden" name="item_name" value="<?=$event_name." - ".$attendee_id." - ".$attendee_name;?>">
      <input type="hidden" name="item_number" value="<?=$event_identifier;?>">
      <input type="hidden" name="amount" value="<?=$event_cost;?>">
      <input type="hidden" name="currency_code" value="<?=$paypal_cur;?>">
      <input type="hidden" name="undefined_quantity" value="0">
      <input type="hidden" name="custom" value="<?=$attendee_id;?>">
      <input type="hidden" name="image_url" value="<?=$image_url;?>">
      <input type="hidden" name="email" value="<?=$attendee_email;?>">
      <input type="hidden" name="first_name" value="<?=$attendee_first;?>">
      <input type="hidden" name="last_name" value="<?=$attendee_last;?>">
      <input type="hidden" name="address1" value="<?=$attendee_address;?>">
      <input type="hidden" name="address2" value="">
      <input type="hidden" name="city" value="<?=$attendee_city;?>">
      <input type="hidden" name="state" value="<?=$attendee_state;?>">
      <input type="hidden" name="zip" value="<?=$attendee_zip;?>">
      <input type="hidden" name="return" value="<?=$return_url;?>">
      <input type="hidden" name="cancel_return" value="<?=$cancel_return;?>">
      <input type="hidden" name="notify_url" value="<?=$notify_url;?>?id=<?=$attendee_id;?>&event_id=<?=$event_id?>&attendee_action=post_payment&form_action=payment">
      <input type="hidden" name="rm" value="<?=$return_method?>">
      <input type="hidden" name="add" value="1">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" align='middle' name="submit">
      </form>
      */ ?>
			<td WIDTH="150" VALIGN='MIDDLE' ALIGN='CENTER'>
		<form action="https://www.paypal.com/cgi-bin/webscr" target="paypal"
			method="post"><font face="Arial"> <input type="hidden" name="bn"
			value="AMPPFPWZ.301" style="font-weight: 700"> <input type="hidden"
			name="cmd" value="_xclick" style="font-weight: 700"> <input
			type="hidden" name="business"
			value="<?php
			echo $paypal_id;
			?>" style="font-weight: 700"> <input type="hidden" name="item_name"
			value="<?php
			echo $event_name . " - " . $attendee_id . " - " . $attendee_name;
			?>"
			style="font-weight: 700"> <input type="hidden" name="item_number"
			value="<?php
			echo $event_identifier;
			?>"
			style="font-weight: 700"> <input type="hidden" name="amount"
			value="<?php
			echo $total_cost;
			?>" style="font-weight: 700"> <input type="hidden"
			name="currency_code" value="<?php
			echo $paypal_cur;
			?>"
			style="font-weight: 700"> <input type="hidden"
			name="undefined_quantity" value="0" style="font-weight: 700"> <input
			type="hidden" name="custom"
			value="<?php
			echo $attendee_id;
			?>" style="font-weight: 700"> <input type="hidden" name="image_url"
			style="font-weight: 700"> </font><b><font face="Arial" size="2">&nbsp;<br />
			<p><input type="image"
			src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif"
			border="0" align='middle' name="submit"></p>
		&nbsp; </font></b></form>
		</td>
	</tr>
</table>
<?php
		}
	}
}
?>