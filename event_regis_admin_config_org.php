<?php

/**
 * @author Edge Technology Consulting
 * @copyright 2009
 */

//Event Registration Subpage 2 - Configure Organization


function event_config_mnu() {
	
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$show_thumb = get_option ('show_thumb');
	
	if (isset ( $_POST ['Submit'] )) {
		
		$org_id = $_POST ['org_id'];
		$org_name = $_POST ['org_name'];
		$org_street1 = $_POST ['org_street1'];
		$org_street2 = $_POST ['org_street2'];
		$org_city = $_POST ['org_city'];
		$org_state = $_POST ['org_state'];
		$org_zip = $_POST ['org_zip'];
		$email = $_POST ['email'];
		$show_thumb = $_POST['show_thumb'];
		$paypal_id = $_POST ['paypal_id'];
		$paypal_cur = $_POST ['currency_format'];
		$return_url = $_POST ['return_url'];
					   $cancel_return = $_POST['cancel_return'];
					   $notify_url = $_POST['notify_url'];
					   $return_method = $_POST['return_method'];
					   $use_sandbox = $_POST['use_sandbox'];
					   $image_url = $_POST['image_url'];
		$events_listing_type = $_POST ['events_listing_type'];
		$default_mail = $_POST ['default_mail'];
		$message = $_POST ['message'];
		
/*		$sql = "UPDATE " . $events_organization_tbl . " SET organization='$org_name', organization_street1='$org_street1', organization_street2='$org_street2', organization_city='$org_city', organization_state='$org_state', organization_zip='$org_zip', contact_email='$email', paypal_id='$paypal_id', currency_format='$paypal_cur', events_listing_type='$events_listing_type', return_url = '$return_url', cancel_return = '$cancel_return', notify_url = '$notify_url', return_method = '$return_method', use_sandbox = '$use_sandbox', image_url = '$image_url', default_mail='$default_mail', message='$message' WHERE id ='1'";
*/
$sql = "UPDATE " . $events_organization_tbl . " SET organization='$org_name', organization_street1='$org_street1', organization_street2='$org_street2', organization_city='$org_city', organization_state='$org_state', organization_zip='$org_zip', contact_email='$email', paypal_id='$paypal_id', currency_format='$paypal_cur', events_listing_type='$events_listing_type', return_url = '$return_url',  default_mail='$default_mail', message='$message' WHERE id ='1'";
		
		$wpdb->query ( $sql );
		
		//create option for paypal id
		

		$option_name = 'paypal_id';
		$newvalue = $paypal_id;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
		
		
		$option_name = 'show_thumb';
		$newvalue = $show_thumb;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
		
		$option_name = 'events_listing_type';
		$newvalue = $events_listing_type;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
		
		$option_name = 'return_url';
		$newvalue = $return_url;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
		
		$option_name = 'cancel_return' ;
					$newvalue = $cancel_return;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					  
					$option_name = 'notify_url' ;
					$newvalue = $notify_url;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					  
					$option_name = 'return_method' ;
					$newvalue = $return_method;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					  
					$option_name = 'use_sandbox' ;
					$newvalue = $use_sandbox;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					  
					$option_name = 'image_url' ;
					$newvalue = $image_url;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }


		//create option for registrar
		

		$option_name = 'registrar';
		$newvalue = $email;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
		
		$option_name = 'paypal_cur';
		$newvalue = $paypal_cur;
		if (get_option ( $option_name )) {
			update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}
	
	}
	
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	
		   		$result = mysql_query($sql);
		   	while ($row = mysql_fetch_assoc ($result))
					{
		  			$org_id =$row['id'];
					$Organization =$row['organization'];
					$Organization_street1 =$row['organization_street1'];
					$Organization_street2=$row['organization_street2'];
					$Organization_city =$row['organization_city'];
					$Organization_state=$row['organization_state'];
					$Organization_zip =$row['organization_zip'];
					$contact =$row['contact_email'];
	 				$registrar = $row['contact_email'];
					$paypal_id =$row['paypal_id'];
					$paypal_cur =$row['currency_format'];
					$return_url = $row['return_url'];
					$cancel_return = $row['cancel_return'];
					$notify_url = $row['notify_url'];
					$return_method = $row['return_method'];
					$use_sandbox = $row['use_sandbox'];
					$image_url = $row['image_url'];
					$events_listing_type =$row['events_listing_type'];
					$default_mail = $row['default_mail'];
					$message =$row['message'];
					}
	echo $lang['defaultmail']. $default_mail;
	echo "<p align='center'><b>This information is required to provide email confirmations, ";
	echo "'Make Check Payable' and paypal integration information. All areas marked by  *  must be filled in.</b></p>";
	echo "<p align='center'><table width='850'><tr><td><p align='left'>";



	echo "<form method='post' action='";
	request_uri();
	echo "'>";
	echo "Organization Name: <input name='org_name' size='45' value='" . $Organization . "'>*" . BR;
	echo "Organization Street 1: <input name='org_street1' size='45' value='" . $Organization_street1 . "'>*" . BR;
	//IJ: eliminated star. a second street name is never necessary in germany...
	echo "Organization Street 2: <input name='org_street2' size='45' value='" . $Organization_street2 . "'>" . BR;
	echo "Organization City: <input name='org_city' size='45' value='" . $Organization_city . "'>*" . BR;
	echo "Organization State: <input name='org_state' size='3' value='" . $Organization_state . "'>* ";
	echo "Organization Zip Code: <input name='org_zip' size='10' value='" . $Organization_zip . "'>*" . BR;
	echo "Primary contact email: <input name='email' size='45' value='" . $contact . "'>*" . BR;
	
	echo "Paypal I.D. (typically payment@yourdomain.com - leave blank if you do not want to accept paypal):" . BR;
	echo "<input name='paypal_id' size='45' value='" . $paypal_id . "'>" . BR;
	echo "<p>Paypal Currency: <select name = 'currency_format'>";
	echo "<option value='" . $paypal_cur . "'>" . $paypal_cur . "</option>";
	echo "<option value='USD'>USD</option>
				<option value='AUD'>AUD</option>
				<option value='GBP'>GBP</option>
				<option value='CAD'>CAD</option>
				<option value='CZK'>CZK</option>
				<option value='DKK'>DKK</option>
				<option value='EUR'>EUR</option>
				<option value='HKD'>HKD</option>
				<option value='HUF'>HUF</option>
				<option value='ILS'>ILS</option>
				<option value='JPY'>JPY</option>
				<option value='MXN'>MXN</option>
				<option value='NZD'>NZD</option>
				<option value='NOK'>NOK</option>
				<option value='PLN'>PLN</option>
				<option value='SGD'>SGD</option>
				<option value='SEK'>SEK</option>
				<option value='CHF'>CHF</option></select></p>";
	echo "<p>Do you want to show a single event or all events on the registration page?* ";
	echo "<select name='events_listing_type'><option value='" . $events_listing_type . "'>" . $events_listing_type . "</option>";
	echo "<option value='single'>Single Event</option>";
	echo "<option value='all'>All Events</option></select></p>";
	echo "<p>Do you want to show thumbnails on the Event Listing Page? ";
	if ($show_thumb == "") {
		echo "<input type='radio' NAME='show_thumb' value='Y'>Yes";
		echo "<input type='radio' NAME='show_thumb' value='N'>No";
	}
	if ($show_thumb == "Y") {
		echo "<input type='radio' NAME='show_thumb' CHECKED value='Y'>Yes";
		echo "<input type='radio' NAME='show_thumb' value='N'>No";
	}
	if ($show_thumb == "N") {
		echo "<input type='radio' NAME='show_thumb' value='Y'>Yes";
		echo "<input type='radio' NAME='show_thumb' CHECKED value='N'>No";
	}
	
	echo "</p>";
	echo "<p>Return URL (used for return to make payments): <input name='return_url' size='75' value='" . $return_url . "'></p>";
/*	echo "Cancel Return URL (used for cancelled payments): <input name='cancel_return' size='75' value='".$cancel_return."'><br /><br />";
			echo "Notify URL (used to process payments): <input name='notify_url' size='75' value='".$notify_url."'><br /><br />";
			echo "Return Method: <select name='return_method'>";
			if ($return_method ==""){
				echo "<option value='2'>POST</option>";
				echo "<option value='1'>GET</option>";}
			if ($return_method =="2"){
				echo "<option value='2' selected='selected'>POST</option>";
				echo "<option value='1'>GET</option>";}
			if ($return_method =="1"){
				echo "<option value='2'>POST</option>";
				echo "<option value='1' selected='selected'>GET</option>";}		
			echo "</select><br /><br />";
			
			echo "Use PayPal Sandbox? ";
			if ($use_sandbox =="1"){
				echo "<input name='use_sandbox' type='checkbox' value='1' checked='checked' /><br><br />";
			}else{
				echo "<input name='use_sandbox' type='checkbox' value='1' /><br><br />";
				}
echo "Image URL (used for your personal logo on the PayPal page): <input name='image_url' size='75' value='".$image_url."'><br>";
*/


	echo "<input type='hidden' value='' name='cancel_return'>";	
	echo "<input type='hidden' value='' name='notify_url'>";
	echo "<input type='hidden' value='' name='return_method'>";
	echo "<input type='hidden' value='' name='use_sandbox'>";
	echo "<input type='hidden' value='' name='image_url'>";	
										
			
	echo "<p>Do You Want To Send Confirmation Emails? (This option must be enable to send custom mails in events)";
	
	if ($default_mail == "") {
		echo "<input type='radio' NAME='default_mail' value='Y'>Yes";
		echo "<input type='radio' NAME='default_mail' value='N'>No";
	}
	if ($default_mail == "Y") {
		echo "<input type='radio' NAME='default_mail' CHECKED value='Y'>Yes";
		echo "<input type='radio' NAME='default_mail' value='N'>No";
	}
	if ($default_mail == "N") {
		echo "<input type='radio' NAME='default_mail' value='Y'>Yes";
		echo "<input type='radio' NAME='default_mail' CHECKED value='N'>No";
	}
	
	echo "</p>";
	echo "<p>Default Confirmation Email Text: " . BR;
	echo "<textarea rows='5' cols='125' name='message' >" . $message . "</textarea></p>";
	echo "<input type='hidden' value='" . $org_id . "' name='org_id'>";
	echo "<input type='hidden' name='update_org' value='update'>";
	echo "<input type='submit' name='Submit' value='Update'></form>";
	echo "</td></tr></p></table></p>";

}

?>