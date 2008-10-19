<?php
/*
Plugin Name: Events Registration
Plugin URI: http://www.avdude.com/wp
Description: This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to your paypal payment site for online collection of event fees. Reporting features provide a list of events, list of attendees, and excel export.
Version: 2.1
Author: David Fleming - Edge Technology Consulting
Author URI: http://www.avdude.com
*/
/*  Copyright 2008  DAVID_FLEMING  (email : CONSULTANT@AVDUDE.COM)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*
Things I still need to do:
	Add start/end date for active registration
	incorporate description into registration page & add form entry slot for description
	Finish the main menu page - see below
	version checker
	this uses wpmail plugin to send mail, please install and activate
	
	*/
	

//Define the table versions for unique tables required in Events Registration

$events_attendee_tbl_version = "1.0";
$events_detail_tbl_version = "1.0";
$events_organization_tbl_version = "1.0";


//Function to install/update data tables in the Wordpress database

function events_data_tables_install () {

	function events_attendee_tbl_install () {
	   global $wpdb;
	   global $events_attendee_tbl_version;
	  	
	   $table_name = $wpdb->prefix . "events_attendee";
	   
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			
			$sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  lname VARCHAR(45) DEFAULT NULL,			  
				  fname VARCHAR(45) DEFAULT NULL,
				  address VARCHAR(45) DEFAULT NULL,
				  city VARCHAR(45) DEFAULT NULL,
				  state VARCHAR(45) DEFAULT NULL,
				  zip VARCHAR(45) DEFAULT NULL,
				  email VARCHAR(45) DEFAULT NULL,
				  phone VARCHAR(45) DEFAULT NULL,
				  hear VARCHAR(45) DEFAULT NULL,
				  payment VARCHAR(45) DEFAULT NULL,
				  date timestamp NOT NULL default CURRENT_TIMESTAMP,
				  paystatus VARCHAR(45) DEFAULT NULL,
				  txn_type VARCHAR(45) DEFAULT NULL,
				  txn_id VARCHAR(45) DEFAULT NULL,
				  amount_pd VARCHAR(45) DEFAULT NULL,
				  paydate VARCHAR(45) DEFAULT NULL,
				  event_id VARCHAR(45) DEFAULT NULL,
				  UNIQUE KEY id (id)
				);";
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
						
		}
		//create option for table version		
			$option_name = 'events_attendee_tbl_version' ; 
			$newvalue = $events_attendee_tbl_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		//create option for table name	  
			$option_name = 'events_attendee_tbl' ; 
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
	}
	
	function events_detail_tbl_install  () {
	   global $wpdb;
	   global $events_detail_tbl_version;
	   	
	   $table_name = $wpdb->prefix . "events_detail";
	   
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(45) DEFAULT NULL,
				  event_desc VARCHAR(500) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  event_cost VARCHAR(45) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  UNIQUE KEY id (id)
				);";
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			}
		
		//create option for table version		
			$option_name = 'events_detail_tbl_version' ; 
			$newvalue = $events_detail_tbl_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		//create option for table name	  
			$option_name = 'events_detail_tbl' ; 
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }

	}
			  			  
	
	function events_organization_tbl_install () {
	   global $wpdb;
	   global $events_organization_tbl_version;
	
	   $table_name = $wpdb->prefix . "events_organization";
	   
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  organization VARCHAR(45) DEFAULT NULL,
				  organization_street1 VARCHAR(45) DEFAULT NULL,
				  organization_street2 VARCHAR(45) DEFAULT NULL,
				  organization_city VARCHAR(45) DEFAULT NULL,
				  organization_state VARCHAR(45) DEFAULT NULL,
				  organization_zip VARCHAR(45) DEFAULT NULL,
				  contact_email VARCHAR(55) DEFAULT NULL,
				  paypal_id VARCHAR(55) DEFAULT NULL,
				  UNIQUE KEY id (id)
				);";
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			$sql="INSERT into $table_name (organization) values ('Your Company')";
			$wpdb->query($sql);
			
		}
				//create option for table version		
			$option_name = 'events_organization_tbl_version' ; 
			$newvalue = $events_attendee_tbl_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		//create option for table name	  
			$option_name = 'events_organization_tbl' ; 
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
	}
	
events_attendee_tbl_install();
events_detail_tbl_install(); 
events_organization_tbl_install();

}

//Install/Update Tables when plugin is activated

register_activation_hook(__FILE__,'events_data_tables_install');

//ADMIN MENU 

add_action('admin_menu', 'add_event_registration_menus');



// Enable the ability for the event_funct to be loaded from pages
		
add_filter('the_content','event_regis_insert');

// Function to deal with loading the events into pages

function event_regis_insert($content)
		{
			  if (preg_match('{EVENTREGIS}',$content))
			    {
			      $content = str_replace('{EVENTREGIS}',event_regis_run(),$content);
			    }
			  return $content;
		}



function event_regis_run(){
	if ($_REQUEST['regevent_action'] == "post_attendee")
	{add_attedees_to_db();
	}
	else {
	register_attendees();
	}
}

//ADD EVENT_REGIS PLUGIN - ACTIVATED

function add_event_registration_menus() {

		    

    add_menu_page('Event Registration', 'Event Registration', 8, __FILE__, 'event_regis_main_mnu');
	
    add_submenu_page(__FILE__, 'Configure Organization', 'Configure Organization', 8, 'organization', 'event_config_mnu');
   
    add_submenu_page(__FILE__, 'Event Setup', 'Event Setup', 8, 'events', 'event_regis_events');
}
  
//Event Registration Main Admin Page

function event_regis_main_mnu(){

/*  The following functions are what I wish to add to the main menu page
	1. Display current count of attendees for active event (show event name, description and id)- shows by default
	2. Display current attendees with edit/delete option - requires button press
	3. Allow manual payment processing - requires button press
	4. Export current event list attendees to excel - requires button press
*/
event_registration_reports();

}  

//Event Registration Subpage 1 - Configure Organization

function event_config_mnu()	{
		
		global $wpdb;
		$events_attendee_tbl = get_option('events_attendee_tbl');
		$events_detail_tbl = get_option('events_detail_tbl');
	    $events_organization_tbl = get_option('events_organization_tbl');
		
				
				
		if (isset($_POST['Submit'])) { 
			
					   $org_id		= $_POST['org_id'];
					   $org_name	= $_POST['org_name'];
					   $org_street1 = $_POST['org_street1'];
					   $org_street2 = $_POST['org_street2'];
					   $org_city	= $_POST['org_city'];
					   $org_state	= $_POST['org_state'];
					   $org_zip		= $_POST['org_zip'];
					   $email		= $_POST['email'];
					   $paypal_id	= $_POST['paypal_id'];
					   $paypal_cur  = $_POST['currency_format'];
					   
					   $sql = "UPDATE " . $events_organization_tbl . " SET organization = '$org_name', organization_street1='$org_street1', organization_street2='$org_street2', organization_city='$org_city',
					   organization_state='$org_state', organization_zip='$org_zip', contact_email='$email', paypal_id='$paypal_id' WHERE id ='$org_id'";
					      
		  

					 $wpdb->query($sql);
					 
					//create option for paypal id	  
				    
				    $option_name = 'paypal_id' ; 
					$newvalue = $paypal_id;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					 
				    
				    
	
					
					 //create option for registrar	  
				 
					$option_name = 'registrar' ; 
					$newvalue = $email;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					 
					
					
					$option_name = 'paypal_cur' ; 
					$newvalue = $paypal_cur;
					  if ( get_option($option_name) ) {
						    update_option($option_name, $newvalue);
						  } else {
						    $deprecated=' ';
						    $autoload='no';
						    add_option($option_name, $newvalue, $deprecated, $autoload);
					  }
					 
			
		   		 }  
		  
	  

			$sql  = "SELECT * FROM ". $events_organization_tbl ." WHERE id='1'";
	   		
	   	
	   		$result = mysql_query($sql);
			
	   		list($org_id, $Organization, $Organization_street1, $Organization_street2, $Organization_city, $Organization_state, $Organization_zip, $contact, $paypal_id ) = mysql_fetch_array($result, MYSQL_NUM);
	   		
	   		echo "<br><br><p align='center'><b>This information is used to provide 'Make Check Payable' and paypal integration information</b></p><br><br><br>";
	   		echo "<p align='center'><table width='850'><tr><td><p align='left'>";
	   		echo "<form method='post' action=".$_SERVER['REQUEST_URI'].">";
	   		echo "Organization Name: <input name='org_name' size='45' value='".$Organization."'><br>";
	   		echo "Organization Street 1: <input name='org_street1' size='45' value='".$Organization_street1."'><br>";
	   		echo "Organization Street 2: <input name='org_street2' size='45' value='".$Organization_street2."'><br>";
	   		echo "Organization City: <input name='org_city' size='45' value='".$Organization_city."'><br>";
	   		echo "Organization State: <input name='org_state' size='3' value='".$Organization_state."'>    ";
	   		echo "Organization Zip Code: <input name='org_zip' size='10' value='".$Organization_zip."'><br>";
	   		echo "Primary contact email: <input name='email' size='45' value='".$contact."'><br>";
	   		echo "Paypal I.D. (typically payment@yourdomain.com): <input name='paypal_id' size='45' value='".$paypal_id."'><br>";
			echo "Paypal Currency: <select name = 'currency_format'><option value='". $paypal_cur . "'>" . $paypal_cur . "</option>";
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
				<option value='CHF'>CHF</option></select><br><br>";
	   		echo "<input type='hidden' value='".$org_id."' name='org_id'>";
	   		echo "<input type='hidden' name='update_org' value='update'>";
	   		echo "<input type='submit' name='Submit' value='Update'></form>";
	   		echo "</td></tr></p></table></p>";
	   
 
}

//Event Registration Subpage 2 - Add/Delete/Edit Events

function event_regis_events(){
	



		  	//function to display events
			function display_event_details($all = 0) {
				global $wpdb;
				$events_detail_tbl = get_option('events_detail_tbl');

									
				$curdate = date("Y-m-d");
				
					  	$sql = "SELECT * FROM ". $events_detail_tbl;
					  	
					    $result = mysql_query ($sql);
					  					echo "<table><tr><td><input name='' size='45' value='EVENT NAME'>";
								        echo "<input name='' value='EVENT ID'>";
								        echo "<input name='' size='10' value='COST'>";
								        echo "<input name='' value='ALLOW CHECKS?'>";
								        echo "<input name='' value='IS ACTIVE?'></td><td></td></tr></table><table>";
								        
								        
					       		while ($row = mysql_fetch_assoc ($result))
					       		{ 
					       			    $event_name=$row['event_name'];
					       			    $identifier=$row['event_identifier'];
					       			    $cost=$row['event_cost'];
					       			    $checks=$row['allow_checks'];
					       			    $active=$row['is_active'];
					       			            
								        echo "<tr><td><input name='event_name' size='45' value='".$event_name."'>";
								        echo "<input name='identifier' value='".$identifier."'>";
								        echo "<input name='cost' size='10' value='".$cost."'>";
								        echo "<input name='checks' value='".$checks."'>";
								        echo "<input name='active' value='".$active."'></td><td>";
								        echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='action' value='delete'>";
										echo "<input type='hidden' name='id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='DELETE' ONCLICK=\"return confirm('Are you sure you want to delete ".$row['event_name']."?')\"></form></td></tr>";
								}
							echo "</table>";
					  }
					  
			//function to delete event
			function delete_event()
					{
						global $wpdb;
						$events_detail_tbl = get_option('events_detail_tbl');

												
						if ( $_REQUEST['action'] == 'delete' ){
							$id=$_REQUEST['id'];
							$sql="DELETE FROM $events_detail_tbl WHERE id='$id'";
							$wpdb->query($sql);

							?><META HTTP-EQUIV="refresh" content="0;URL=<?echo $_SERVER['REQUEST_URI'];?>"><?
							}
					}				  
										
  			// Adds an Event or Function to the Event Database
	   		function add_event_funct_to_db()
	   				{
	   					global $wpdb;
	   					$events_detail_tbl = get_option('events_detail_tbl');

						
												
				   	if (isset($_POST['Submit'])){
				   		if ( $_REQUEST['action'] == 'add' ){
					   			$event_name=$_REQUEST['event'];
					   			$ident = $_REQUEST['ident'];
					   			$cost = $_REQUEST['cost'];
					   			$accept_checks = $_REQUEST['checks'];
					   			$is_active = $_REQUEST['is_active'];
					   			
					   			//When the posted record is set to active, this checks records and deactivates them to set the current record as active
					   			
					   			if ($is_active == "yes"){
						   			$sql="UPDATE ". $events_detail_tbl . " SET is_active = 'no' WHERE is_active='$is_active'";
						   			$wpdb->query($sql);
;
					   			}
					   			
					   			//Post the new event into the database
					   			
					   			$sql="INSERT INTO $events_detail_tbl (event_name, event_identifier, event_cost, allow_checks, is_active) 
					   			VALUES('$event_name','$ident','$cost','$accept_checks','$is_active')";
					   			
								$wpdb->query($sql);

								echo "<meta http-equiv='refresh' content='0'>";}
								
	   				}	   			
	   			     else {	   			
					   			?>
						   			<form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>"
						   			<br><br>EVENT NAME: <input name="event" size="45">      ID FOR EVENT (used for paypal reference)<input name="ident"><br><br>
						   			COST FOR EVENT  $<input name="cost" size="10">     WILL YOU ACCEPT CHECKS? <select name="checks"><option>yes</option><option>no</option></select><br><br>
						   			DO YOU WANT THIS EVENT TO BE THE ACTIVE EVENT? <select name="is_active"><option>no</option><option>yes</option></select><br>
						   			<?echo "<input type='hidden' name='action' value='add'>";?>
						   			<br><br><input type="submit" name="Submit" value="ADD EVENT"></form> 
					   			<?	   			
	   						}
	   				
	   				}
	   
	//Display Options
		   
	if ( $_REQUEST['action'] == 'delete' ){delete_event();}
	
	Echo"<br><br><hr><b><u>ADD AN EVENT OR FUNCTION TO THE DATABASE</b></u><br><br>";
	
	add_event_funct_to_db();
	
	Echo "<hr><hr>";
	
	display_event_details();
	
}	

//how to add global variables  add_option("events_attendee_tbl_version", $events_attendee_tbl_version);
//how to call global variables   global $events_attendee_tbl_version;


function register_attendees(){
			global $wpdb;
			$events_detail_tbl = get_option('events_detail_tbl');
			$paypal_cur = get_option('paypal_cur');
			
			
			//Query Database for Active event and get variable
			$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
	   		$result = mysql_query($sql);
	   		list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $allow_checks, $is_active) = mysql_fetch_array($result, MYSQL_NUM);
			
			update_option("current_event", $event_name);

						
			echo "<table width='780'><td>";	
			echo "<b>".$event_name." - Cost ".$paypal_cur." ".$event_cost.".00</b></p></p>";			
			?>
			<br></td><tr><td>
			<form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>" >
			<p align="left"><font face="Arial" size="2"><b>First Name<input tabIndex="1" maxLength="35" size="47" name="fname"></b><font color="#ff0000">*</font></font></p>
			<p align="left"><font face="Arial" size="2"><b>Last Name<input tabIndex="2" maxLength="35" size="47" name="lname"></b><font color="#ff0000">*</font></font></p>
			<p align="left"><b><font face="Arial" size="2">Email:<input tabIndex="3" maxLength="37" size="37" name="email"></font></b><font face="Arial">&nbsp;</font><font face="Arial" color="#ff0000" size="2">*<br>
			</font><b><font face="Arial" size="2"><br>
			Phone:<input tabIndex="4" maxLength="15" size="28" name="phone"></font></b><font face="Arial" color="#ff0000" size="2">*</font></p>
			<p align="left"><b><font face="Arial" size="2">Address:&nbsp;<input tabIndex="5" maxLength="35" size="49" name="address"></b><font color="#ff0000">*</font></font></p>
			<p align="left"><font face="Arial" size="2"><b>City:<input tabIndex="6" maxLength="20" size="33" name="city"> </b>
			<font color="#ff0000">*</font></font></p>
			<p align="left"><font face="Arial" size="2"><b>State or Province:<input tabIndex="7" maxLength="30" size="18" name="state"></b><font color="#ff0000">*</font></font></p>
			<p align="left"><font face="Arial" size="2"><b>Zip:<input tabIndex="8" maxLength="10" size="16" name="zip"></b><font color="#ff0000">*</font><b><br>
			<br>
			How did you hear about this event?</b></font><font face="Arial">&nbsp;<select tabIndex="9" size="1" name="hear">
			<option value="pick one" selected>pick one</option>
			<option value="Website">Website</option>
			<option value="A Friend">A Friend</option>
			<option value="Brochure">A Brochure</option>
			<option value="Announcment">An Announcment</option>
			<option value="Other">Other</option>
			</select></font></p>
			<p align="left"><font face="Arial" size="2"><b>How do you plan on paying for 
			your Registration?</b> <select tabIndex="10" size="1" name="payment">
			<option value="pickone" selected>pickone</option>
			<option value="Paypal">Credit Card or Paypal</option>
			<option value="Cash/Check">Cash or Check</option>
			</select></font></p>
			<input type="hidden" name="regevent_action" value="post_attendee">
			<input type="hidden" name="event_id" value="<?echo $event_id;?>">
			<p align="center"><input type="submit" name="Submit" value="Submit"> 
			<font color="#FF0000"><b>(Only click the Submit Button Once)</b></font></form></td></tr></table></body>
			<?
}
			
function add_attedees_to_db(){
			 global $wpdb;
			 $current_event = get_option('current_event');
			 $registrar = get_option('registrar');
			 $events_attendee_tbl = get_option('events_attendee_tbl');
			
			   $fname = $_POST['fname'];
			   $lname = $_POST['lname'];
			   $address = $_POST['address'];
			   $city = $_POST['city'];
			   $state = $_POST['state'];
			   $zip = $_POST['zip'];
			   $phone = $_POST['phone'];
			   $email = $_POST['email'];
			   $hear = $_POST['hear'];
			   $event_id=$_POST['event_id'];
			   $payment = $_POST['payment'];
			   update_option("attendee_first", $fname);
			   update_option("attendee_last", $lname);
			   update_option("attendee_name", $fname." ".$lname);
			   update_option("attendee_email", $email);

		   
		  $sql = "INSERT INTO $events_attendee_tbl (lname, fname, address, city, state, zip, email, phone, hear, payment, event_id)
		       VALUES ('$lname', '$fname', '$address', '$city', '$state', '$zip', '$phone', '$email','$hear','$payment', '$event_id')"; 
	
		$wpdb->query($sql);
		
		//Email Confirmation to Registrar
		
			$event_name = $current_event; 
			
			$distro=$registrar;
			$message=("I, $fname $lname  have signed up on-line for $event_name .  My email address is  $email.  My selected method of payment was $payment");
			wp_mail($distro, $event_function, $message); 
		
		//Email Confirmation to Attendee
			
			$distro="$email";
			$message=("**This is an automated response***  Thank you, $fname for signing up for $event_name. If you have not done so already, please mail your check today or pay online using our Paypal interface.");
			wp_mail($distro, $event_name, $message); 
		
		
		//Get registrars id from the data table and assign to a session variable for PayPal.
		
			$query  = "SELECT * FROM $events_attendee_tbl WHERE fname='$fname' AND lname='$lname' AND email='$email'";
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		list($id, $fname, $lname, $address, $city, $state, $zip, $email, $phone, 
	   		$hear, $payment, $date) = mysql_fetch_array($result, MYSQL_NUM);
				
			update_option("attendee_id", $id);
			
			//Send screen confirmation & forward to paypal if selected.
			
			echo "Your Registration has been added. Please watch your email for a confirmation of registration."; 
			echo "<br><br>";
			if ( $payment == "" ) {events_payment_paypal();}
			else {events_payment_page();}
			}

function events_payment_paypal(){
//you can load your paypal IPN processing script here
//change the above if statement to the actual paypal word for this function to work

}

function events_payment_page()
			{
			global $wpdb;
			$events_organization_tbl = get_option('events_organization_tbl');
			$events_detail_tbl = get_option('events_detail_tbl');			
			$attendee_id = get_option('attendee_id');
			$attendee_name = get_option('attendee_name');
			$paypal_cur = get_option('paypal_cur');
			
				//query event database for organization information
			$sql  = "SELECT * FROM ". $events_organization_tbl . " WHERE id='1'";
			
			$result = mysql_query($sql);
			
	   		list($org_id, $Organization, $Organization_street1, $Organization_street2, $Organization_city, $Organization_state, $Organization_zip, $registrar, $paypal_id ) = mysql_fetch_array($result, MYSQL_NUM);
	   		
			
			//Query Database for Active event and get variable
			
			
			
			$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";
						
			$result = mysql_query($sql);
	   			   		
	   		list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $allow_checks, $is_active) = mysql_fetch_array($result, MYSQL_NUM);
				

			if ($allow_checks == "yes"){
						echo "<b><u>MAKE CHECKS PAYABLE TO:</b></u><br></P><br>";
						echo $Organization."<br>";
						echo $Organization_street1." ".$Organization_street2."<br>";
						echo $Organization_city.", ".$Organization_state."   ".$Organization_zip."<br><br>";
						echo "<hr>";
						}
			
			//Payment Selection with data hidden - forwards to paypal
			?>
			<p align="left"><b>Payment By Credit Card, Debit Card or Pay Pal Account<br>(a pay 
			pal account is not required to pay by credit card).</b></p>
			
			<img border="0" src="https://www.paypalobjects.com/WEBSCR-540-20080922-1/en_US/i/logo/logo_ccVisa.gif" alt="Visa"><img border="0" src="https://www.paypalobjects.com/WEBSCR-540-20080922-1/en_US/i/logo/logo_ccMC.gif" alt="Mastercard"><img border="0" src="https://www.paypalobjects.com/WEBSCR-540-20080922-1/en_US/i/logo/logo_ccAmex.gif" alt="American Express"><img border="0" src="https://www.paypalobjects.com/WEBSCR-540-20080922-1/en_US/i/logo/logo_ccDiscover.gif" alt="Discover"><img border="0" src="https://www.paypalobjects.com/WEBSCR-540-20080922-1/en_US/i/logo/logo_ccBank.gif" alt="Bank">
			</p><Br><BR>
			<table width="750"><tr><td width="200">
			<B><h3><? echo $event_name." - ".$paypal_cur." ".$event_cost;?>.00</b></h3></td><td>
			<form action="https://www.paypal.com/cgi-bin/webscr" target="paypal" method="post">
			
			<font face="Arial">
			<input type="hidden" name="bn" value="AMPPFPWZ.301" style="font-weight: 700">
			<input type="hidden" name="cmd" value="_xclick" style="font-weight: 700">
			<input type="hidden" name="business" value="<?echo $paypal_id;?>" style="font-weight: 700" > 
			<input type="hidden" name="item_name" value="<?echo $event_name." - ".$attendee_name;?>" style="font-weight: 700">
			<input type="hidden" name="item_number" value="<?echo $event_identifier;?>" style="font-weight: 700">
			<input type="hidden" name="amount" value="<? echo $event_cost;?>" style="font-weight: 700">
			<input type="hidden" name="currency_code" value="<?echo $paypal_cur;?>" style="font-weight: 700">
			<input type="hidden" name="undefined_quantity" value="1" style="font-weight: 700">
			<input type="hidden" name="custom" value="<?echo $attendee_id;?>" style="font-weight: 700">
			<input type="hidden" name="image_url" style="font-weight: 700">
			</font><b><font face="Arial" size="2">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" width="69" height="32">
			</font></b>
			</form></td></tr></table>
<?
}

function event_registration_reports(){

global $wpdb;
$events_detail_tbl = get_option('events_detail_tbl');
$current_event = get_option('current_event');
$events_attendee_tbl = get_option('events_attendee_tbl');
define("EVNT_RGR_PLUGINPATH", "/" . plugin_basename( dirname(__FILE__) ) . "/");
define("EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );

$url = EVNT_RGR_PLUGINFULLURL;

Echo "<p align='center'><table width = '400'><tr><td>";
Echo "<b><h3>Current Event Is: ".$current_event."</td></tr><tr><td>";
  	
//Echo "<br><a href='http://".$_SERVER['SERVER_NAME']."/event_registration_export.php?atnd=".$events_attendee_tbl."&id=1'>Export Current Attendee List To Excel</a>";

Echo "<br><a href='". $url ."event_registration_export.php?atnd=".$events_attendee_tbl."&id=1'>Export Current Attendee List To Excel</a></td><tr></table>";


/*
if ( $run_reports == "" ) {events_reports_menu();}
if ( $run_reports == "excel_export" ) {event_resigration_export.php}
if ( $run_reports == "events_list" ) {events_reports_listing();}
if ( $run_reports == "current_attendees" ) {events_reports_current_attendee();}
			else {
			
			
			}

*/



}
?>