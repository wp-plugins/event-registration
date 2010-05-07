<?php

/**
 * @author Edge Technology Consulting
 * @copyright 2009
 */

//Event Registration Subpage 2 - Configure Organization

function event_config_mnu() {
    er_plugin_menu();
	
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
//	$show_thumb = get_option ('show_thumb');
	
	if (isset ( $_POST ['Submit'] )) {
		
		$org_id = $_REQUEST ['org_id'];
		$org_name = $_REQUEST ['org_name'];
		$org_street1 = $_REQUEST ['org_street1'];
		$org_street2 = $_REQUEST ['org_street2'];
		$org_city = $_REQUEST ['org_city'];
		$org_state = $_REQUEST ['org_state'];
		$org_zip = $_REQUEST ['org_zip'];
		$email = $_REQUEST ['email'];
		$show_thumb = $_REQUEST['show_thumb'];
        $payment_vendor = $_REQUEST['payment_vendor'];
		$payment_vendor_id = $_REQUEST ['payment_vendor_id'];
        $txn_key = $_REQUEST['txn_key'];
		$currency_format = $_REQUEST ['currency_format'];
        $accept_donations = $_REQUEST ['accept_donations'];
		$return_url = $_REQUEST ['return_url'];
					   $cancel_return = $_REQUEST['cancel_return'];
					   $notify_url = $_REQUEST['notify_url'];
					   $return_method = $_REQUEST['return_method'];
					   $use_sandbox = $_REQUEST['use_sandbox'];
					   $image_url = $_REQUEST['image_url'];
		$events_listing_type = $_REQUEST['events_listing_type'];
        $calendar_url = $_REQUEST['calendar_url'];
		$default_mail = $_REQUEST ['default_mail'];
		$message = $_REQUEST['message'];
        $payment_subj = $_REQUEST['payment_subj'];
        $payment_message = $_REQUEST['payment_message'];
        
$sql = "UPDATE " . $events_organization_tbl . 
" SET organization='$org_name',
 organization_street1='$org_street1',
 organization_street2='$org_street2',
 organization_city='$org_city', 
 organization_state='$org_state', 
 organization_zip='$org_zip', 
 contact_email='$email',
 show_thumb='$show_thumb',
 payment_vendor ='$payment_vendor',
 payment_vendor_id ='$payment_vendor_id',
 txn_key = '$txn_key',
 currency_format='$currency_format', 
 accept_donations = '$accept_donations',
 events_listing_type='$events_listing_type',
 default_mail='$default_mail',
 return_url = '$return_url',
 cancel_return= '$cancel_return',
 notify_url= '$notify_url',
 return_method= '$return_method',
 use_sandbox ='$use_sandbox',
 image_url='$image_url', 
 calendar_url = '$calendar_url',
 message='$message', 
 payment_subj='$payment_subj',
 payment_message='$payment_message'
 WHERE id ='1'";
		
		$wpdb->query ( $sql ) or die(mysql_error());
		
	//create option for payment vendor id
		

		$option_name = 'payment_vendor_id';
		$newvalue = $payment_vendor_id;
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
		
  $option_name = 'er_link_for_calendar_url';
		$newvalue = $calendar_url;
		if (get_option ( $option_name )) {
		  	update_option ( $option_name, $newvalue );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option ( $option_name, $newvalue, $deprecated, $autoload );
		}



	$option_name = 'currency_format';
		$newvalue = $currency_format;
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
		
		$option_name = 'currency_format';
		$newvalue = $currency_format;
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
                    $payment_vendor = $row['payment_vendor'];
					$payment_vendor_id =$row['payment_vendor_id'];
					$currency_format =$row['currency_format'];
					$return_url = $row['return_url'];
					$cancel_return = $row['cancel_return'];
                    $accept_donations = $row['accept_donations'];
                    $txn_key = $row['txn_key'];
					$notify_url = $row['notify_url'];
					$return_method = $row['return_method'];
					$use_sandbox = $row['use_sandbox'];
					$image_url = $row['image_url'];
					$events_listing_type =$row['events_listing_type'];
                    $calendar_url = $row['calendar_url'];
					$default_mail = $row['default_mail'];
					$message =$row['message'];
                    $show_thumb=$row['show_thumb'];
                    $payment_subj=$row['payment_subj'];
                    $payment_message=$row['payment_message'];
					}
	
?>

<div id="configure_organization_form" class=wrap>
  <div id="icon-options-event" class="icon32"><br />
  </div>
  <h2>Event Registration Organization Settings</h2>
<div id="event_regis-col-left">

<form method="post" action="<?php $_SERVER['REQUEST_URI']?>"> 
<ul id="event_regis-sortables">

			<li>
				<div class="box-mid-head">
					<h2 class="events_reg f-wrench">Set up Your Organization Contact Info</h2>
				</div>

				<div class="box-mid-body" id="toggle2">
					<div class="padding">
                    
                   
                 
<?php
	echo "<p align='center'><b>This information is required to provide email confirmations, <br>";
	echo "'Make Check Payable' and online payment integration information. All areas marked by  *  must be filled in.</b></p>";
    
    echo " <ul>";
     
    echo "<li>Organization Name: <input name='org_name' size='45' value='" . $Organization . "'>*</li>";
	echo "<li>Organization Street 1: <input name='org_street1' size='45' value='" . $Organization_street1 . "'>*</li>";
	echo "<li>Organization Street 2: <input name='org_street2' size='45' value='" . $Organization_street2 . "'></li>";
	echo "<li>Organization City: <input name='org_city' size='45' value='" . $Organization_city . "'>*</li>";
	echo "<li>Organization State: <input name='org_state' size='3' value='" . $Organization_state . "'>* ";
	echo "Organization Zip Code: <input name='org_zip' size='10' value='" . $Organization_zip . "'>*</li>";
	echo "<li>Primary contact email: <input name='email' size='45' value='" . $contact . "'>*</li>";
   ?>
   </ul></div></div></li>




<li>
   <div class="box-mid-head">
		<h2 class="events_reg f-wrench"><a href="#" id="m_general_OnOff" onClick="return doMore('general_OnOff')">Set up Your Organization Payment Info</a></h2>
				</div>
                
   <div style="display:none" id="general_OnOff_ex">
<div class="box-mid-body" id="toggle2">
 <!-- All the hidden HTML goes right here-->
 <p><b>Online Payment Vendor</b> If you want to accept payments online you will need to provide an online vendor for collection of payments.  This plugin currently supports: PAYPAL, GOOGLE, AUTHORIZE.NET and the ability to add your own custom payment button.</p>
 <p><b>Online Payment ID</b> The online payment id will be your email address you use to setup your paypal account or your Google account ID number or your authorize.net ID.</p>
 <p><a href="https://ems.authorize.net/oap/home.aspx?SalesRepID=98&ResellerID=16334"><img src="http://www.authorize.net/images/reseller/oap_sign_up.gif" height="38" width="135" border="0" /></a></p>
 <p><b>Transaction Key</b> Authorized.Net Accounts require a unique transaction key that was given when you created your account.
 <p><b>Currency Format </b>  Is uesed by all payment methods for determining the local currency for transactions.</p>
 <p><b>Accept Donations</b> If you would like to take online donations for free events, select yes and the online payment links will be displayed in the registration confirmation page.</p>
 <p><b>Return URL</b> Create a page on your site and use the code <font color="red">{EVENTREGPAY}</font> to create a return page for collecting online payments from registered attendees.  This url will be transmitted in the confirmation email if you inclue the information, providing a link to click and return to make additional payments.</p>
 <p><b>Image URL</b> Used by Paypal to display your personal logo on the PayPal website page.
 <br /> 
 
 <!-- End Help Contents--> 

 <br />
 <a href="#" onClick="return doHide('general_OnOff')">Close Help</a>
</div>	
</div>
<div class="box-mid-body" id="toggle2">
	<div class="padding">
   <ul>
  <?php
   
	echo "<li>Online Payment Vendor: <select name='payment_vendor'>";
    echo "<option value='" . $payment_vendor . "'>" . $payment_vendor . "</option>";
	echo "<option value='NONE'>NONE</option>
          <option value='GOOGLE'>GOOGLE</option>
		  <option value='PAYPAL'>PAYPAL</option>
          <option value='AUTHORIZE.NET'>AUTHORIZE.NET</option>
          <option value='CUSTOM'>CUSTOM</option>
		  </select> 
     <a href='https://ems.authorize.net/oap/home.aspx?SalesRepID=98&ResellerID=16334'><img src='http://www.authorize.net/images/reseller/oap_sign_up.gif' height='38' width='135' border='0' /></a>
    </li>";
	echo "<li>Online Payment ID(typically payment@yourdomain.com for paypal - leave blank if you are not accepting online payments):";
	echo "<input name='payment_vendor_id' size='45' value='" . $payment_vendor_id . "'></li>";
     echo "<li>Transaction Key (for Authorized.Net Accounts):";
    echo "<input name='txn_key' size='45' value='" . $txn_key . "'></li>";
	echo "<li>Currency Format: <select name = 'currency_format'>";
	echo "<option value='" . $currency_format . "'>" . $currency_format . "</option>";
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
				<option value='CHF'>CHF</option></select></li>";
    echo "<li>Will you accept donations for free events: <select name = 'accept_donations'>";
	echo "<option value='" . $accept_donations . "'>" . $accept_donations . "</option>";
	echo "<option value='Yes'>Yes</option>
				<option value='No'>No</option></select></li>";           

                
echo "<li>Return URL (used for attendee to return to make online payments.):<input name='return_url' size='75' value='" . $return_url . "'></li>";
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
*/
echo "<li>Image URL (used for your personal logo on the PayPal page):<input name='image_url' size='75' value='".$image_url."'></li>";
	echo "<input type='hidden' value='' name='cancel_return'>";	
	echo "<input type='hidden' value='' name='notify_url'>";
	echo "<input type='hidden' value='' name='return_method'>";
	echo "<input type='hidden' value='' name='use_sandbox'>";
//	echo "<input type='hidden' value='' name='image_url'>";	
  ?>
  </ul></div></div></li><li>
     				<div class="box-mid-head">
					<h2 class="events_reg f-wrench"><a href="#" id="m_general_OnOff1" onClick="return doMore('general_OnOff1')">Set up Your Organization Registration Defaults</a></h2>
				</div>
  
<div style="display:none" id="general_OnOff1_ex">
<div class="box-mid-body" id="toggle2">
 <!-- All the hidden HTML goes right here-->
<p><b>Show a single event or all events</b>This allows you to show only 1 event on the events listing page.  This feature is mostly legacy and should be set to all for most organizations.  For specific events use the shortcode as displayed on the event or use event categories for custom regitration pages.</p>
<p><b>Show thumbnails</b> By selecting yes, you can have thumbnail images (links noted under the event setup) next to each event in the event listing pages.</p>
<p><b>Send Confirmation Emails</b> This option must be enable to send emails. Each event has the ability to add custom emails for that event.  When custom emails are not entered under the event setup, the default mail as entered here will be used.  This must be set to yes for any emails to be sent from the plugin.</p>
<p><b>Confirmation Email Text</b> You have the ability to utilize data from the registration process in the emails. For customized confirmation emails, the following tags can be placed in the email form and they will pull data from the database to include in the email.</p>
<p>[fname], [lname], [phone], [event],[description], [cost], [company], [co_add1], [co_add2], [co_city],[co_state], [co_zip],[contact], [payment_url], [start_date], [start_time], [end_date], [end_time]</p>
<hr /><strong><em>Sample Mail Send:</em></strong></p>
<p>***This is an automated response - Do Not Reply***<br />
Thank you [fname] [lname] for registering for [event]. <br />
We hope that you will find this event both informative and enjoyable. <br />
Should have any questions, please contact [contact].</p>
<p>If you have not done so already, please submit your payment in the amount of [cost].</p>
<p>Click here to reveiw your payment information [payment_url].</p>
<p>Thank You.</p>
<hr /> As a side note, I use the wordpress built-in mail send to send mails, so you will probably see mail from <a href="mailto:wordpress@yourdomain.com">wordpress@yourdomain.com</a>.  The email thing is a default Wordpress thing, not related to my plugin.  There is a great little plugin that resolves that issue.  <a href="http://wordpress.org/extend/plugins/mail-from/"><span style="color: #2255aa;">http://wordpress.org/extend/plugins/mail-from/</span></a></p>
<p> </p> :               
   <!-- End Help Contents--> 

 <br />
 <a href="#" onClick="return doHide('general_OnOff1')">Close Help</a>
</div>
</div> 
  
   
   <div class="box-mid-body" id="toggle2">
	<div class="padding"><ul>
   <?php
     echo "<li>Do you want to show a single event or all events on the registration page?* ";
	echo "<select name='events_listing_type'><option value='" . $events_listing_type . "'>" . $events_listing_type . "</option>";
	echo "<option value='single'>Single Event</option>";
	echo "<option value='all'>All Events</option></select></li>";
	echo "<li>Do you want to show thumbnails on the Event Listing Page? ";
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
	
	echo "</li>";
	
    echo "<li>Calendar URL (used for registration links on the calendar page.):<input name='calendar_url' size='75' value='" . $calendar_url . "'></li>";
										
			
	echo "<li>Do You Want To Send Confirmation Emails? (This option must be enable to send custom mails in events)";
	
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
	
	echo "</li>";
	echo "<li>Default Confirmation Email Text: </li>";
	echo "<textarea rows='5' cols='125' name='message' >" . $message . "</textarea></li>";
	echo "<input type='hidden' value='" . $org_id . "' name='org_id'>";
	echo "<input type='hidden' name='update_org' value='update'>";
	echo "<li><input type='submit' name='Submit' value='Update'></li></form>";
   	echo "</ul> </div></div></li></div>";

}

?>