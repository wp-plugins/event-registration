<?php
/*
Plugin Name: Events Registration
Plugin URI: http://www.avdude.com/wp
Description: This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to your paypal payment site for online collection of event fees. Reporting features provide a list of events, list of attendees, and excel export.
Version: 2.7
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
Changes:
	Changed email confirmation to use wp_mail() (built into wordpress) default instead of smtp plugin.
	Changed mail header to use registrars email address instead of wordpress default
	Added funtion for single or multiple event display on registration.
	Fixed paypal to say PayPal
	Removed broken image links from PayPal
	Droped in codeblocks to update tables
	Change buy now button to PAY NOW
	Added ability to edit existing events
	added ability to edit confirmation email sent to registrants
	Added ability to add 4 custom form questions to registration page - only visible is used.
	Added description for events  and display description of registration page


Things I still need to do:
	Add start/end date for active registration
	incorporate description into registration page & add form entry slot for description
	Finish the main menu page - see below
	version checker
	this uses wpmail plugin to send mail, please install and activate

	*/


//Define the table versions for unique tables required in Events Registration

$events_attendee_tbl_version = "2.2";
$events_detail_tbl_version = "2.2";
$events_organization_tbl_version = "2.2";


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
					  custom_1 VARCHAR(500) DEFAULT NULL,
	                  custom_2 VARCHAR(500) DEFAULT NULL,
	                  custom_3 VARCHAR(500) DEFAULT NULL,
	                  custom_4 VARCHAR(500) DEFAULT NULL,
					  UNIQUE KEY id (id)
					);";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);


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
	// Code here with new database upgrade info/table Must change version number to work.
		 $events_attendee_tbl_version = "2.2";
		 $installed_ver = get_option( "events_attendee_tbl_version" );
	     if( $installed_ver != $events_attendee_tbl_version ) {


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
					  custom_1 VARCHAR(500) DEFAULT NULL,
	                  custom_2 VARCHAR(500) DEFAULT NULL,
	                  custom_3 VARCHAR(500) DEFAULT NULL,
	                  custom_4 VARCHAR(500) DEFAULT NULL,
					  UNIQUE KEY id (id)
					);";


	      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	      dbDelta($sql);

	      update_option( "events_attendee_tbl_version", $events_attendee_tbl_version );
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
				  question1 VARCHAR(200) DEFAULT NULL,
				  question2 VARCHAR(200) DEFAULT NULL,
				  question3 VARCHAR(200) DEFAULT NULL,
				  question4 VARCHAR(200) DEFAULT NULL,
				  				  UNIQUE KEY id (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);


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
	 $events_detail_tbl_version = "2.2";
     $installed_ver = get_option( "$events_detail_tbl_version" );
     if( $installed_ver != $events_detail_tbl_version ) {

 			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(45) DEFAULT NULL,
				  event_desc VARCHAR(500) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  event_cost VARCHAR(45) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  question1 VARCHAR(200) DEFAULT NULL,
				  question2 VARCHAR(200) DEFAULT NULL,
				  question3 VARCHAR(200) DEFAULT NULL,
				  question4 VARCHAR(200) DEFAULT NULL,
				  				  UNIQUE KEY id (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      update_option( "events_detail_tbl_version", $events_detail_tbl_version );
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
				  currency_format VARCHAR(45) DEFAULT NULL,
				  events_listing_type VARCHAR(45) DEFAULT NULL,
				  message VARCHAR(500) DEFAULT NULL,
				  UNIQUE KEY id (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

			$message=("Enter your custom confirmation message here."); //BHC


			$sql="INSERT into $table_name (organization, message) values ('Your Company', '".$message."')";
			$wpdb->query($sql);


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

//Upgrade Info Here
	$events_organization_tbl_version = "2.2";

     $installed_ver = get_option( "events_organization_tbl_version" );
     if( $installed_ver != $events_organization_tbl_version ) {

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
				  currency_format VARCHAR(45) DEFAULT NULL,
				  events_listing_type VARCHAR(45) DEFAULT NULL,
				  message VARCHAR(500) DEFAULT NULL,
				  UNIQUE KEY id (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);


      		$message=("**This is an automated response - DO NOT REPLY! A contact email address is listed below.***\n\nThank you, $fname for signing up for $event_name. If you have not done so already, please mail your check today or pay online using our Paypal interface. If you have selected payment by check, you can mail your check to:\n\n==========\n\n$Organization\n$Organization_street1\n$Organization_street2\n$Organization_city\n$Organization_state $Organization_zip\n\n==========\n\nIf you have any questions, you can contact the organizer at $registrar"); //BHC


			$sql="UPDATE $table_name SET message ='".$message."' WHERE id = '1')";
			$wpdb->query($sql);


      update_option( "events_organization_tbl_version", $events_organization_tbl_version );
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
  /*	if ($_REQUEST['regevent_action'] == "post_attendee")
	{add_attedees_to_db();
	}
	else {
	register_attendees();
	}
	*/
	$events_listing_type = get_option('events_listing_type');

	if ($events_listing_type == 'single'){
		if ($_REQUEST['regevent_action'] == "post_attendee"){add_attedees_to_db();}
		else if ($_REQUEST['regevent_action'] == "pay"){event_regis_pay();}
		else if ($_REQUEST['regevent_action'] == "register"){register_attendees();}
		else if ($regevent_action == "process"){}
		else {register_attendees();}
	}

	if ($events_listing_type == 'all'){
		if ($_REQUEST['regevent_action'] == "post_attendee"){add_attedees_to_db();}
		else if ($_REQUEST['regevent_action'] == "pay"){event_regis_pay();}
		else if ($_REQUEST['regevent_action'] == "register"){register_attendees();}
		else if ($regevent_action == "process"){}
		else {display_all_events();}
	}
}

//ADD EVENT_REGIS PLUGIN - ACTIVATED

function add_event_registration_menus() {



    add_menu_page('Event Registration', 'Event Registration', 8, __FILE__, 'event_regis_main_mnu');

    add_submenu_page(__FILE__, 'Configure Organization', 'Configure Organization', 8, 'organization', 'event_config_mnu');

    add_submenu_page(__FILE__, 'Event Setup', 'Event Setup', 8, 'events', 'event_regis_events');

    add_submenu_page(__FILE__, 'Process Payments', 'Process Payments', 8, 'attendee', 'event_process_payments');
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
					   $events_listing_type = $_POST['events_listing_type'];
					   $message = $_POST['message'];

					   $sql = "UPDATE " . $events_organization_tbl . " SET organization = '$org_name', organization_street1='$org_street1', organization_street2='$org_street2', organization_city='$org_city', organization_state='$org_state', organization_zip='$org_zip',
					   contact_email='$email', paypal_id='$paypal_id', currency_format='$paypal_cur', events_listing_type='$events_listing_type', message='$message' WHERE id ='$org_id'";



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


					$option_name = 'events_listing_type' ;
					$newvalue = $events_listing_type;
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
					$events_listing_type =$row['events_listing_type'];
					$message =$row['message'];
					}

	   		echo "<br><br><p align='center'><b>This information is used to provide 'Make Check Payable' and paypal integration information</b></p><br><br>";
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
			echo "Do you want to show a single event or all events on the regisration page? <select name='events_listing_type'><option value='".$events_listing_type."'>".$events_listing_type ."</option>";
			echo "<option value='single'>Single Event</option>
			      <option value='all'>All Events</option></select><br><br>";
			echo "Confirmation Email Text: (See Readme for help) <br><textarea rows='5' cols='125' name='message' >".$message."</textarea><br><br>";
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
					  				/* 	echo "<table><tr><td width='60'></td><td><input name='' size='45' value='EVENT NAME'>";
									echo "<input name='' value='EVENT ID'>";
									echo "<input name='' size='22' value='DESCRIPTION/DETAILS'>"; //BHC
								        echo "<input name='' size='10' value='COST'>";
								        echo "<input name='' value='ALLOW CHECKS?'>";
								        echo "<input name='' value='IS ACTIVE?'></td><td></td></tr></table><table>"; */
								      echo "<table><tr><b>EVENTS LISTING:</b></tr>";

					       		while ($row = mysql_fetch_assoc ($result))
					       		{
								    $event_name=$row['event_name'];
								    $event_desc=$row['event_desc']; // BHC
					       			    $identifier=$row['event_identifier'];
					       			    $cost=$row['event_cost'];
					       			    $checks=$row['allow_checks'];
					       			    $active=$row['is_active'];
					       			    $question1= $row['question1'];
					       			    $question2= $row['question2'];
					       			    $question3= $row['question3'];
					       			    $question4= $row['question4'];

					       			    echo "<tr><td></td><td valign='top'><form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='action' value='edit'>";
										echo "<input type='hidden' name='id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='EDIT' ONCLICK=\"return confirm('Are you sure you want to edit ".$row['event_name']."?')\"></form>";
										echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='action' value='delete'>";
										echo "<input type='hidden' name='id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='DELETE' ONCLICK=\"return confirm('Are you sure you want to delete ".$row['event_name']."?')\"></form></td><td valign='top'>";
					       			    echo "Event ID <b><u>".$identifier."</b></u><td>Event Name <b><u>".$event_name."</b></u> Cost <b><u>$ ".$cost."</b></u><br><br>";
					       			    echo "Description <b><u>".$event_desc."</b></u><br><br>";
					       			    echo "Accept Checks <b><u>".$checks."</b></u> Is This Event Active? <b><u>".$active."</b></u><br><br>";
                                        echo "Custom Question 1 <b><u>".$question1."</b></u><br>";
                                        echo "Custom Question 2 <b><u>".$question2."</b></u><br>";
                                        echo "Custom Question 3 <b><u>".$question3."</b></u><br>";
                                        echo "Custom Question 4 <b><u>".$question4."</b></u><br>";
                                        echo "<hr></td></tr>";

					       			 /*   echo "<tr><td>";
								        echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='action' value='edit'>";
										echo "<input type='hidden' name='id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='EDIT' ONCLICK=\"return confirm('Are you sure you want to edit ".$row['event_name']."?')\"></form></td>";
								        echo "<td><input name='event_name' size='45' value='".$event_name."'>";
								        echo "<input name='identifier' value='".$identifier."'>";

								        echo "<input name='cost' size='10' value='".$cost."'>";
								        echo "<input name='checks' value='".$checks."'>";
								        echo "<input name='active' value='".$active."'></td><td>";
								        echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='action' value='delete'>";
										echo "<input type='hidden' name='id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='DELETE' ONCLICK=\"return confirm('Are you sure you want to delete ".$row['event_name']."?')\"></form></td></tr>";
								echo "<tr><td></td><td><textarea rows='2' cols='130' name='event_desc' >".$event_desc."</textarea></td></tr>";

*/
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

			//function to edit event
			function edit_event()
					{
						global $wpdb;
						$events_detail_tbl = get_option('events_detail_tbl');


	   			     $id=$_REQUEST['id'];
                     //Query Database for Active event and get variable
			$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id =".$id;
	   		$result = mysql_query($sql);
	   		while ($row = mysql_fetch_assoc ($result))
				{
			$id = $row['id'];
			$event_name = $row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$identifier = $row['event_identifier'];
			$cost = $row['event_cost'];
			$checks = $row['allow_checks'];
			$active = $row['is_active'];
			$question1 = $row['question1'];
			$question2 = $row['question2'];
			$question3 = $row['question3'];
			$question4 = $row['question4'];
				}

			update_option("current_event", $event_name);

					   			?>
						   			<form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>"
									<br><br>EVENT NAME: <input name="event" size="45" value ="<? echo $event_name;?>">      ID FOR EVENT (used for paypal reference)<input name="ident" value ="<? echo $event_identifier;?>"><br>
									<br><br>EVENT DESCRIPTION: <textarea rows='2' cols='125' name='desc' ><? echo $event_desc;?></textarea><br>
                                    COST FOR EVENT  $<input name="cost" size="10" value ="<? echo $event_cost;?>">     WILL YOU ACCEPT CHECKS? <select name="checks"><option>yes</option><option>no</option></select><br><br>
						   			DO YOU WANT THIS EVENT TO BE THE ACTIVE EVENT? <select name="is_active"><option>yes</option><option>no</option></select><br><br> <!-- BHC -->
                                    CUSTOM QUESTION 1: <textarea rows='1' cols='125' name='quest1' ><? echo $question1;?></textarea><br>
                                    CUSTOM QUESTION 2: <textarea rows='1' cols='125' name='quest2' ><? echo $question2;?></textarea><br>
                                    CUSTOM QUESTION 3: <textarea rows='1' cols='125' name='quest3' ><? echo $question3;?></textarea><br>
                                    CUSTOM QUESTION 4: <textarea rows='1' cols='125' name='quest4' ><? echo $question4;?></textarea><br>

                                       <?echo "<input type='hidden' name='action' value='update'>";?>
                                        <?echo "<input type='hidden' name='id' value='".$id."'>";?>
						   			<br><br><input type="submit" name="Submit" value="UPDATE EVENT"></form>
					   			<?
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
								$desc=$_REQUEST['desc']; //BHC
					   			$cost = $_REQUEST['cost'];
					   			$accept_checks = $_REQUEST['checks'];
					   			$is_active = $_REQUEST['is_active'];
					   			$quest1 = $_REQUEST['quest1'];
                                $quest2 = $_REQUEST['quest2'];
                                $quest3 = $_REQUEST['quest3'];
                                $quest4 = $_REQUEST['quest4'];


					   			//When the posted record is set to active, this checks records and deactivates them to set the current record as active
					   			update_option("current_event", $event_name);

					   			if ($is_active == "yes"){
						   			$sql="UPDATE ". $events_detail_tbl . " SET is_active = 'no' WHERE is_active='$is_active'";
						   			$wpdb->query($sql);
;
					   			}

					   			//Post the new event into the database

								/* BHC */ $sql="INSERT INTO $events_detail_tbl (event_name, event_identifier, event_desc, event_cost, allow_checks, is_active, question1, question2,
                                question3, question4)
					   			VALUES('$event_name','$ident','$desc','$cost','$accept_checks','$is_active', '$quest1', '$quest2', '$quest3', '$quest4')"; //BHC

								$wpdb->query($sql);

								echo "<meta http-equiv='refresh' content='0'>";}

	   				}
	   				if ( $_REQUEST['action'] == 'update' ){
                                $id=$_REQUEST['id'];
					   			$event_name=$_REQUEST['event'];
								$ident = $_REQUEST['ident'];
								$desc=$_REQUEST['desc']; //BHC
					   			$cost = $_REQUEST['cost'];
					   			$accept_checks = $_REQUEST['checks'];
					   			$is_active = $_REQUEST['is_active'];
					   			$quest1 = $_REQUEST['quest1'];
                                $quest2 = $_REQUEST['quest2'];
                                $quest3 = $_REQUEST['quest3'];
                                $quest4 = $_REQUEST['quest4'];


					   			//When the posted record is set to active, this checks records and deactivates them to set the current record as active
					   			update_option("current_event", $event_name);

					   			if ($is_active == "yes"){
						   			$sql="UPDATE ". $events_detail_tbl . " SET is_active = 'no' WHERE is_active='$is_active'";
						   			$wpdb->query($sql);
;
					   			}

					   			//Post the new event into the database

								/* BHC */ $sql="UPDATE $events_detail_tbl SET event_name='$event_name', event_identifier='$ident',
                                event_desc='$desc', event_cost='$cost', allow_checks='$accept_checks', is_active='$is_active', question1='$quest1',
                                 question2='$quest2', question3='$quest3', question4='$quest4'  WHERE id = $id";

								$wpdb->query($sql);

								echo "<meta http-equiv='refresh' content='0'>";

								}


	   			     else {
					   			?>
						   			<form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>"
									<br><br>EVENT NAME: <input name="event" size="45">      ID FOR EVENT (used for paypal reference)<input name="ident"><br>
									<br><br>EVENT DESCRIPTION: <textarea rows='2' cols='125' name='desc' ></textarea><br> <? //BHC ?>
						   			COST FOR EVENT  $<input name="cost" size="10">     WILL YOU ACCEPT CHECKS? <select name="checks"><option>yes</option><option>no</option></select><br><br>
						   			DO YOU WANT THIS EVENT TO BE THE ACTIVE EVENT? <select name="is_active"><option>yes</option><option>no</option></select><br><br> <!-- BHC -->
                                    CUSTOM QUESTION 1: <textarea rows='1' cols='125' name='quest1' ></textarea><br>
                                    CUSTOM QUESTION 2: <textarea rows='1' cols='125' name='quest2' ></textarea><br>
                                    CUSTOM QUESTION 3: <textarea rows='1' cols='125' name='quest3' ></textarea><br>
                                    CUSTOM QUESTION 4: <textarea rows='1' cols='125' name='quest4' ></textarea><br>

                                       <?echo "<input type='hidden' name='action' value='add'>";?>
						   			<br><br><input type="submit" name="Submit" value="ADD EVENT"></form>
					   			<?
	   						}

	   				}

	//Display Options

	if ( $_REQUEST['action'] == 'delete' ){delete_event();}
	if ( $_REQUEST['action'] == 'edit' ){edit_event();}

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
			$event_id = $_REQUEST['event_id'];
		    $events_listing_type = get_option('events_listing_type');

			//Query Database for Active event and get variable

			if ($events_listing_type == 'single'){$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";}
			else {$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id = $event_id";}
	   		$result = mysql_query($sql);
	   		while ($row = mysql_fetch_assoc ($result))
				{
			$event_id = $row['id'];
			$event_name = $row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$identifier = $row['event_identifier'];
			$cost = $row['event_cost'];
			$checks = $row['allow_checks'];
			$active = $row['is_active'];
			$question1 = $row['question1'];
			$question2 = $row['question2'];
			$question3 = $row['question3'];
			$question4 = $row['question4'];
				}

			update_option("current_event", $event_name);
			//Query Database for Event Organization Info to email registrant BHC
			$sql  = "SELECT * FROM wp_events_organization WHERE id='1'"; //BHC NEED TO CHANGE: Table name should be a variable but $events_organization_tbl gave an error as it is undefined at this point.
			$result = mysql_query($sql); //BHC

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
				$events_listing_type =$row['events_listing_type'];
				$message =$row['message'];
				}


			echo "<p align='center'><b>Event Registration for ".$event_name."</p>"; //BHC
			echo "<table width='100%'><td>"; //BHC
			echo "<b>Details/Description</b></td><td>".$event_desc."</td>"; //BHC
			echo "</table>"; //BHC
			echo "<table width='500'><td>";	//BHC changed to fit theme.
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

			<?
            if ($question1 != ""){ ?>
			<p align="left"><font face="Arial" size="2"><b><?echo $question1; ?><input size="33" name="custom_1"> </b></font></p>
			<? } else { ?><input type="hidden" name="custom1" value=""><?}

			if ($question2 != ""){ ?>
			<p align="left"><font face="Arial" size="2"><b><?echo $question2; ?><input size="33" name="custom_2"> </b></font></p>
			<? } else { ?><input type="hidden" name="custom2" value=""><?}

            if ($question3 != ""){ ?>
			<p align="left"><font face="Arial" size="2"><b><?echo $question3; ?><input size="33" name="custom_3"> </b></font></p>
			<? } else { ?><input type="hidden" name="custom3" value=""><?}

            if ($question4 != ""){ ?>
			<p align="left"><font face="Arial" size="2"><b><?echo $question4; ?><input size="33" name="custom_4"> </b></font></p>
			<? }  else { ?><input type="hidden" name="custom1" value=""><?}
			?>

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
			   $custom_1 =$_POST['custom_1'];
			   $custom_2 =$_POST['custom_2'];
			   $custom_3 =$_POST['custom_3'];
			   $custom_4 =$_POST['custom_4'];
               update_option("attendee_first", $fname);
			   update_option("attendee_last", $lname);
			   update_option("attendee_name", $fname." ".$lname);
			   update_option("attendee_email", $email);


		  $sql = "INSERT INTO $events_attendee_tbl (lname, fname, address, city, state, zip, email, phone, hear, payment, event_id, custom_1, custom_2, custom_3, custom_4)
		       VALUES ('$lname', '$fname', '$address', '$city', '$state', '$zip', '$email,'$phone', '$hear','$payment', '$event_id', '$custom_1',
               '$custom_2', '$custom_3', '$custom_4')";



		$wpdb->query($sql);


	//Query Database for Event Organization Info to email registrant BHC
			   $sql  = "SELECT * FROM wp_events_organization WHERE id='1'"; //BHC NEED TO CHANGE: Table name should be a variable but $events_organization_tbl gave an error as it is undefined at this point.
			   $result = mysql_query($sql); //BHC
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
				$events_listing_type =$row['events_listing_type'];
				$conf_message =$row['message'];
				}


			   //list($org_id, $Organization, $Organization_street1, $Organization_street2, $Organization_city, $Organization_state, $Organization_zip, $registrar, $paypal_id ) = mysql_fetch_array($result, MYSQL_NUM); // BHC
		//Email Confirmation to Registrar

			$event_name = $current_event;

			$distro=$registrar;
			$message=("I, $fname $lname  have signed up on-line for $event_name.\n\nMy email address is  $email.\n\nMy selected method of payment was $payment.\n\n"); //BHC
			wp_mail($distro, $event_name, $message);


		//Email Confirmation to Attendee

			$distro="$email";
			//$message=("**This is an automated response - DO NOT REPLY! A contact email address is listed below.***\n\nThank you, $fname for signing up for $event_name. If you have not done so already, please mail your check today or pay online using our Paypal interface. If you have selected payment by check, you can mail your check to:\n\n==========\n\n$Organization\n$Organization_street1\n$Organization_street2\n$Organization_city\n$Organization_state $Organization_zip\n\n==========\n\nIf you have any questions, you can contact the organizer at $registrar"); //BHC

			wp_mail($distro, $event_name, $conf_message);


		//Get registrars id from the data table and assign to a session variable for PayPal.

			$query  = "SELECT * FROM $events_attendee_tbl WHERE fname='$fname' AND lname='$lname' AND email='$email'";
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		while ($row = mysql_fetch_assoc ($result))
				{
	  		    	$id = $row['id'];
				$lname = $row['lname'];
				$fname = $row['fname'];
				$address = $row['address'];
				$city = $row['city'];
				$state = $row['state'];
				$zip = $row['zip'];
				$email = $row['email'];
				$phone = $row['phone'];
				$date = $row['date'];
				$paystatus = $row['paystatus'];
				$txn_type = $row['txn_type'];
				$amt_pd = $row['amount_pd'];
				$date_pd = $row['paydate'];
				$event_id = $row['event_id'];
				$custom1 = $row['custom_1'];
				$custom2 = $row['custom_2'];
				$custom3 = $row['custom_3'];
				$custom4 = $row['custom_4'];
				}



			update_option("attendee_id", $id);

			//Send screen confirmation & forward to paypal if selected.

			echo "Your Registration has been added. Please watch your email for a confirmation of registration.";
			echo "<br><br>";
			/* if ( $payment == "Paypal" ) {events_payment_paypal();}
			else {events_payment_page();}
			} */
			events_payment_page();
			}

function events_payment_paypal(){
//you can load your paypal IPN processing script here
//change the above if statement to the actual paypal word for this function to work
echo "PayPal Info Here.\n\n"; // BHC
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
				$events_listing_type =$row['events_listing_type'];
				$message =$row['message'];
				}


			//Query Database for Active event and get variable



			$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";

			$result = mysql_query($sql);
			while ($row = mysql_fetch_assoc ($result))
							{
						$event_id = $row['id'];
						$event_name = $row['event_name'];
						$event_desc = $row['event_desc'];
						$event_description = $row['event_desc'];
						$identifier = $row['event_identifier'];
						$cost = $row['event_cost'];
						$allow_checks = $row['allow_checks'];
						$active = $row['is_active'];
						$question1 = $row['question1'];
						$question2 = $row['question2'];
						$question3 = $row['question3'];
						$question4 = $row['question4'];
							}


		  	if ($allow_checks == "yes"){
						echo "<b>PLEASE MAKE CHECKS PAYABLE TO: <u>$Organization</b></u><br></P><br>"; // BHC Changed for clarity.
						echo $Organization."<br>";
						echo $Organization_street1." ".$Organization_street2."<br>";
						echo $Organization_city.", ".$Organization_state."   ".$Organization_zip."<br><br>";
						echo "<hr>";
						}

			//Payment Selection with data hidden - forwards to paypal
			?>
			<p align="left"><b>Payment By Credit Card, Debit Card or Pay Pal Account<br>(a pay
			pal account is not required to pay by credit card).</b></p>
			<p>PayPal Payments will be sent to: <?echo $paypal_id;?></p>

			</p><Br><BR>
			<table width="500"><tr><td VALIGN='MIDDLE' ALIGN='CENTER'>&nbsp;<br>
			<B><h3><? echo $event_name." - ".$paypal_cur." ".$event_cost;?>.00</b></h3>&nbsp;</td><td WIDTH="150" VALIGN='MIDDLE' ALIGN='CENTER' >
			<form action="https://www.paypal.com/cgi-bin/webscr" target="paypal" method="post">
			<font face="Arial">
			<input type="hidden" name="bn" value="AMPPFPWZ.301" style="font-weight: 700">
			<input type="hidden" name="cmd" value="_xclick" style="font-weight: 700">
			<input type="hidden" name="business" value="<?echo $paypal_id;?>" style="font-weight: 700" >
			<input type="hidden" name="item_name" value="<?echo $event_name." - ".$attendee_id." - ".$attendee_name;?>" style="font-weight: 700">
			<input type="hidden" name="item_number" value="<?echo $event_identifier;?>" style="font-weight: 700">
			<input type="hidden" name="amount" value="<? echo $event_cost;?>" style="font-weight: 700">
			<input type="hidden" name="currency_code" value="<?echo $paypal_cur;?>" style="font-weight: 700">
			<input type="hidden" name="undefined_quantity" value="0" style="font-weight: 700">
			<input type="hidden" name="custom" value="<?echo $attendee_id;?>" style="font-weight: 700">
			<input type="hidden" name="image_url" style="font-weight: 700">
			</font><b><font face="Arial" size="2">&nbsp;<br>
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" align='middle' name="submit"><br>&nbsp; </font></b>
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

Echo "</td><tr></table>";
?>
<button style="background-color:lightgreen" onclick="window.location='<?echo $url."event_registration_export.php?atnd=".$events_attendee_tbl."&id=1";  ?>'" style="width:180; height: 30">Export Current Attendee List To Excel</button>
<br><br><?
//view_attendee_list();
attendee_display_edit();
/*
if ( $run_reports == "" ) {events_reports_menu();}
if ( $run_reports == "excel_export" ) {event_resigration_export.php}
if ( $run_reports == "events_list" ) {events_reports_listing();}
if ( $run_reports == "current_attendees" ) {events_reports_current_attendee();}
			else {


			}

*/



}

function display_all_events(){
				global $wpdb;
				$events_detail_tbl = get_option('events_detail_tbl');
				$curdate = date("Y-m-d");
				$paypal_cur = get_option('paypal_cur');

				$sql = "SELECT * FROM ". $events_detail_tbl;

					    $result = mysql_query ($sql);

								echo "<table width = '450'>";
					       		while ($row = mysql_fetch_assoc ($result))
					       		{
					       			    $event_id = $row['id'];
										$event_name=$row['event_name'];
					       			    $identifier=$row['event_identifier'];
					       			    $cost=$row['event_cost'];
					       			    $checks=$row['allow_checks'];
					       			    $active=$row['is_active'];

								        echo "<tr><td width='400'>".$event_name." - ".$paypal_cur." ".$cost.".00</p><hr></td><td>";
								        echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
								        echo "<input type='hidden' name='regevent_action' value='register'>";
										echo "<input type='hidden' name='event_id' value='".$row['id']."'>";
										echo "<INPUT TYPE='SUBMIT' VALUE='REGISTER' ONCLICK=\"return confirm('Are you sure you want to register for ".$row['event_name']."?')\"></form></td></tr>";
								        }
							echo "</table>";
	}

function view_attendee_list(){
	//Displays attendee information from current active event.
				global $wpdb;
				$events_detail_tbl = get_option('events_detail_tbl');
				$events_attendee_tbl = get_option('events_attendee_tbl');


	$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc ($result))
				{
			$event_id = $row['id'];
			$event_name = $row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$identifier = $row['event_identifier'];
			$cost = $row['event_cost'];
			$checks = $row['allow_checks'];
			$active = $row['is_active'];
			$question1 = $row['question1'];
			$question2 = $row['question2'];
			$question3 = $row['question3'];
			$question4 = $row['question4'];
				}

	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	$result = mysql_query($sql);

	echo "<table>";
	while ($row = mysql_fetch_assoc ($result))
				{
	  		    $id = $row['id'];
				$lname = $row['lname'];
				$fname = $row['fname'];
				$address = $row['address'];
				$city = $row['city'];
				$state = $row['state'];
				$zip = $row['zip'];
				$email = $row['email'];
				$phone = $row['phone'];
				$date = $row['date'];
				$paystatus = $row['paystatus'];
				$txn_type = $row['txn_type'];
				$amt_pd = $row['amount_pd'];
				$date_pd = $row['paydate'];
				$event_id = $row['event_id'];
				$custom1 = $row['custom_1'];
				$custom2 = $row['custom_2'];
				$custom3 = $row['custom_3'];
				$custom4 = $row['custom_4'];


				echo "<tr><td align='left'>".$lname.", ".$fname."</td><td>".$email."</td><td>".$phone."</td>";
				echo "<td>";
				echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
				echo "<input type='hidden' name='attendee_action' value='edit'>";
				echo "<input type='hidden' name='attendee_id' value='".$id."'>";
				echo "<INPUT TYPE='SUBMIT' VALUE='EDIT' ONCLICK=\"return confirm('Are you sure you want to edit record for ".$fname." ".$lname."?')\"></form>";
				echo "</td></tr>";
				}
				echo "</table>";
}

function event_process_payments(){

		function list_attendee_payments(){
						//Displays attendee information from current active event.
									global $wpdb;
									$events_detail_tbl = get_option('events_detail_tbl');
									$events_attendee_tbl = get_option('events_attendee_tbl');
					
					
						$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";
							$result = mysql_query($sql);
							while ($row = mysql_fetch_assoc ($result))
									{
								$event_id = $row['id'];
								$event_name = $row['event_name'];
								$event_desc = $row['event_desc'];
								$event_description = $row['event_desc'];
								$identifier = $row['event_identifier'];
								$cost = $row['event_cost'];
								$checks = $row['allow_checks'];
								$active = $row['is_active'];
								$question1 = $row['question1'];
								$question2 = $row['question2'];
								$question3 = $row['question3'];
								$question4 = $row['question4'];
									}
					
						$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
						$result = mysql_query($sql);
						Echo "<br><b>Current Active Event is: ".$event_name." - ".$identifier."</b><br><hr>";
						echo "<table>";
						echo "<tr><td width='15'></td><td> ID </td><td> Name </td><td> Email </td><td width='15'></td><td> Pay Status </td><td> TXN Type </td>
						<td> TXN ID </td><td> Amount Pd </td><td> Date Paid </td><tr>";
						while ($row = mysql_fetch_assoc ($result))
									{
						  		    $id = $row['id'];
									$lname = $row['lname'];
									$fname = $row['fname'];
									$address = $row['address'];
									$city = $row['city'];
									$state = $row['state'];
									$zip = $row['zip'];
									$email = $row['email'];
									$phone = $row['phone'];
									$date = $row['date'];
									$paystatus = $row['paystatus'];
									$txn_type = $row['txn_type'];
									$txn_id = $row['txn_id'];
									$amt_pd = $row['amount_pd'];
									$date_pd = $row['paydate'];
									$event_id = $row['event_id'];
									$custom1 = $row['custom_1'];
									$custom2 = $row['custom_2'];
									$custom3 = $row['custom_3'];
									$custom4 = $row['custom_4'];
					
					
									echo "<tr><td width='15'></td><td>".$id."</td><td align='left'>".$lname.", ".$fname."</td><td>".$email."</td><td width='15'>
									</td><td>".$paystatus."</td><td>".$txn_type.
									"</td><td>".$txn_id."</td><td> $".$amt_pd."</td><td>".$date_pd."</td>";
									echo "<td>";
									echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
									echo "<input type='hidden' name='form_action' value='payment'>";
									echo "<input type='hidden' name='id' value='".$id."'>";
									echo "<INPUT TYPE='SUBMIT' VALUE='ENTER PAYMENT' ONCLICK=\"return confirm('Are you sure you want to enter a payment for 
									".$fname." ".$lname."?')\"></form>";
									echo "</td></tr>";
									}
									echo "</table>";
					}
					
					
		function enter_attendee_payments(){
						global $wpdb;
						$events_detail_tbl = get_option('events_detail_tbl');
						$events_attendee_tbl = get_option('events_attendee_tbl');
		
						if ( $_REQUEST['form_action'] == 'payment' ){
		
								if ( $_REQUEST['attendee_action'] == 'post_payment' ){
									echo $_REQUEST['id'];
										    $id = $_REQUEST['id'];
											$paystatus = $_REQUEST['paystatus'];
											$txn_type = $_REQUEST['txn_type'];
											$txn_id = $_REQUEST['txn_id'];
											$amt_pd = $_REQUEST['amt_pd'];
											$date_pd = $_REQUEST['date_pd'];
				
								   	$sql="UPDATE ". $events_attendee_tbl . " SET paystatus = '$paystatus', txn_type = '$txn_type', 
									   txn_id = '$txn_id', amount_pd = '$amt_pd', paydate ='$date_pd' WHERE id ='$id'";
									$wpdb->query($sql);
				
									echo "<meta http-equiv='refresh' content='0'>";
				
									}
					   			    else {
					   			     	 $id = $_REQUEST['id'];
					   			     	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
										$result = mysql_query($sql);
										while ($row = mysql_fetch_assoc ($result))
												{
									  		    $id = $row['id'];
												$lname = $row['lname'];
												$fname = $row['fname'];
												$address = $row['address'];
												$city = $row['city'];
												$state = $row['state'];
												$zip = $row['zip'];
												$email = $row['email'];
												$phone = $row['phone'];
												$date = $row['date'];
												$paystatus = $row['paystatus'];
												$txn_type = $row['txn_type'];
												$txn_id = $row['txn_id'];
												$amt_pd = $row['amount_pd'];
												$date_pd = $row['paydate'];
												$event_id = $row['event_id'];
												$custom1 = $row['custom_1'];
												$custom2 = $row['custom_2'];
												$custom3 = $row['custom_3'];
												$custom4 = $row['custom_4'];
												}
				
				
											echo "<form method='post' action='".$_SERVER['REQUEST_URI']."'>";
				
											echo "<br><br>Payment For: ".$fname." ".$lname."<br>";
											 ?>
				
													PayStatus <input name="paystatus" size="45" value ="<?echo $paystatus;?>" > <br />
													Transaction Type: <input name="txn_type" size="45" value ="<?echo $txn_type;?>" > <br />
													Transaction ID: <input name="txn_id" size="45" value ="<?echo $txn_id;?>" > <br />
													Amount Paid: <input name="amt_pd" size="45" value ="<?echo $amt_pd;?>" > <br />
													Date Paid: <input name="date_pd" size="45" value ="<?echo $date_pd;?>" > <br />
													<?echo "<input type='hidden' name='id' value='".$id."'>";?>
													<?echo "<input type='hidden' name='form_action' value='payment'>";?>
													<?echo "<input type='hidden' name='attendee_action' value='post_payment'>";?>
										   			<br><br><input type="submit" name="Submit" value="POST PAYMENT"></form><hr><hr><br>
									   			<?
				
				
					   						}
			}
		
		}

enter_attendee_payments();
list_attendee_payments();
}


function attendee_display_edit(){

		function event_list_attendees(){
						//Displays attendee information from current active event.
									global $wpdb;
									$events_detail_tbl = get_option('events_detail_tbl');
									$events_attendee_tbl = get_option('events_attendee_tbl');
					
					
						$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";
							$result = mysql_query($sql);
							while ($row = mysql_fetch_assoc ($result))
									{
								$event_id = $row['id'];
								$event_name = $row['event_name'];
								$event_desc = $row['event_desc'];
								$event_description = $row['event_desc'];
								$identifier = $row['event_identifier'];
								$cost = $row['event_cost'];
								$checks = $row['allow_checks'];
								$active = $row['is_active'];
								$question1 = $row['question1'];
								$question2 = $row['question2'];
								$question3 = $row['question3'];
								$question4 = $row['question4'];
									}
					
						$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
						$result = mysql_query($sql);
						Echo "<br><b>Current Attendee List is from: ".$event_name." - ".$identifier."</b><br><hr>";
						echo "<table>";
						echo "<tr><td width='15'></td><td> ID </td><td> Name </td><td> Email </td><td width='15'>City</td><td>State </td><td> Phone </td>
						<td></td><td> </td><tr>";
						while ($row = mysql_fetch_assoc ($result))
									{
						  		    $id = $row['id'];
									$lname = $row['lname'];
									$fname = $row['fname'];
									$address = $row['address'];
									$city = $row['city'];
									$state = $row['state'];
									$zip = $row['zip'];
									$email = $row['email'];
									$phone = $row['phone'];
									$date = $row['date'];
									$paystatus = $row['paystatus'];
									$txn_type = $row['txn_type'];
									$txn_id = $row['txn_id'];
									$amt_pd = $row['amount_pd'];
									$date_pd = $row['paydate'];
									$event_id = $row['event_id'];
									$custom1 = $row['custom_1'];
									$custom2 = $row['custom_2'];
									$custom3 = $row['custom_3'];
									$custom4 = $row['custom_4'];
					
					
									echo "<tr><td width='15'></td><td>".$id."</td><td align='left'>".$lname.", ".$fname."</td><td>".$email."</td><td width='15'>
									".$city."</td><td>".$state."</td><td>".$phone."</td>";
									echo "<td>";
									echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
									echo "<input type='hidden' name='form_action' value='edit_attendee'>";
									echo "<input type='hidden' name='id' value='".$id."'>";
									echo "<INPUT TYPE='SUBMIT' style='background-color:yellow' VALUE='EDIT RECORD' ONCLICK=\"return confirm('Are you sure you want to edit record for 
									".$fname." ".$lname."?')\"></form>";
									echo "</td><td>";
									echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
										echo "<input type='hidden' name='form_action' value='edit_attendee'>";
										echo "<input type='hidden' name='attendee_action' value='delete_attendee'>";
										echo "<input type='hidden' name='id' value='".$id."'>";
										echo "<INPUT TYPE='SUBMIT' style='background-color:pink' VALUE='DELETE' ONCLICK=\"return confirm
										('Are you sure you want to delete record for ".$fname." ".$lname."?')\"></form>
									</td></tr>";
									}
									echo "</table>";
					}
					
					
		function edit_attendee_record(){
						global $wpdb;
						$events_detail_tbl = get_option('events_detail_tbl');
						$events_attendee_tbl = get_option('events_attendee_tbl');
		
						if ( $_REQUEST['form_action'] == 'edit_attendee' ){
							
								if ( $_REQUEST['attendee_action'] == 'delete_attendee' ){
									$id = $_REQUEST['id'];
									$sql= " DELETE FROM ". $events_attendee_tbl . "WHERE id ='$id'";
									echo $sql;
									//$wpdb->query($sql);
									//echo "<meta http-equiv='refresh' content='0'>";
									}
					
									
								else if ( $_REQUEST['attendee_action'] == 'update_attendee' ){
									
											   $id = $_REQUEST['id'];
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
											   $custom_1 =$_POST['custom_1'];
											   $custom_2 =$_POST['custom_2'];
											   $custom_3 =$_POST['custom_3'];
											   $custom_4 =$_POST['custom_4'];
				
								   	$sql="UPDATE ". $events_attendee_tbl . " SET fname='$fname', lname='$lname', address='$address', city='$city', state='$state',
								   	zip='$zip', phone='$phone', email='$email', payment='$payment', hear='$hear', custom_1='$custom_1', custom_2='$custom_2',
								   	custom_3='$custom_3', custom_4='$custom_4' WHERE id ='$id'";
									$wpdb->query($sql);
				
									echo "<meta http-equiv='refresh' content='0'>";
				
									}
					   			    else {
					   			     	
										   		$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE is_active='yes'";
												$result = mysql_query($sql);
												while ($row = mysql_fetch_assoc ($result))
														{
													$event_id = $row['id'];
													$event_name = $row['event_name'];
													$event_desc = $row['event_desc'];
													$event_description = $row['event_desc'];
													$identifier = $row['event_identifier'];
													$cost = $row['event_cost'];
													$checks = $row['allow_checks'];
													$active = $row['is_active'];
													$question1 = $row['question1'];
													$question2 = $row['question2'];
													$question3 = $row['question3'];
													$question4 = $row['question4'];
														}
					   			     	
										$id = $_REQUEST['id'];
					   			     	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
										$result = mysql_query($sql);
										while ($row = mysql_fetch_assoc ($result))
												{
									  		    $id = $row['id'];
												$lname = $row['lname'];
												$fname = $row['fname'];
												$address = $row['address'];
												$city = $row['city'];
												$state = $row['state'];
												$zip = $row['zip'];
												$email = $row['email'];
												$hear = $row['hear'];
												$payment = $row['payment'];
												$phone = $row['phone'];
												$date = $row['date'];
												$paystatus = $row['paystatus'];
												$txn_type = $row['txn_type'];
												$txn_id = $row['txn_id'];
												$amt_pd = $row['amount_pd'];
												$date_pd = $row['paydate'];
												$event_id = $row['event_id'];
												$custom_1 = $row['custom_1'];
												$custom_2 = $row['custom_2'];
												$custom_3 = $row['custom_3'];
												$custom_4 = $row['custom_4'];
												}
				
				
											echo "<table><tr><td width='25'></td><td align='left'><hr><form method='post' action='".$_SERVER['REQUEST_URI']."'>";
				
											?>
												<b>First Name<input tabIndex="1" maxLength="45" size="47" name="fname" value ="<?echo $fname;?>"></b> 
												<b>Last Name<input tabIndex="2" maxLength="45" size="47" name="lname" value ="<?echo $lname;?>"></b><br />
												<b>Address:&nbsp;<input tabIndex="5" maxLength="45" size="49" name="address" value ="<?echo $address;?>"></b><br>
												<b>City:<input tabIndex="6" maxLength="20" size="33" name="city" value ="<?echo $city;?>"> </b>   
												<b>State or Province:<input tabIndex="7" maxLength="30" size="18" name="state" value ="<?echo $state;?>"></b>
												<b>Zip:<input tabIndex="8" maxLength="10" size="16" name="zip" value ="<?echo $zip;?>"></b><br>
												<b>Email:<input tabIndex="3" maxLength="37" size="37" name="email" value ="<?echo $email;?>"></b>   
												<b>Phone:<input tabIndex="4" maxLength="15" size="28" name="phone" value ="<?echo $phone;?>"></b><br/><br>
												<b>How did you hear about this event?</b></font><font face="Arial">&nbsp;
												<select tabIndex="9" size="1" name="hear">
																<option value ="<?echo $hear;?>" selected><?echo $hear;?></option>
																<option value="Website">Website</option>
																<option value="A Friend">A Friend</option>
																<option value="Brochure">A Brochure</option>
																<option value="Announcment">An Announcment</option>
																<option value="Other">Other</option>
																</select></font><br />
													<b>How do you plan on paying for your Registration?</b> <select tabIndex="10" size="1" name="payment">
																<option value="="<?echo $payment;?>" selected><?echo $payment;?></option>
																<option value="Paypal">Credit Card or Paypal</option>
																<option value="Cash/Check">Cash or Check</option>
																</select></font><br />
									
												<?
									            if ($question1 != ""){ ?>
												<p align="left"><b>
												<?echo $question1; ?><input  tabIndex="11" size="33" name="custom_1" value="<?echo $custom_1;?>"> </b></p>
												<? } 
									
												if ($question2 != ""){ ?>
												<p align="left"><b>
												<?echo $question2; ?><input  tabIndex="12" size="33" name="custom_2" value="<?echo $custom_2;?>"> </b></p>
												<? } 
									
									            if ($question3 != ""){ ?>
												<p align="left"><b>
												<?echo $question_3; ?><input tabIndex="13" size="33" name="custom_3" value="<?echo $custom_3;?>"> </b></p>
												<? }
									
									            if ($question4 != ""){ ?>
												<p align="left"><b>
												<?echo $question4; ?><input  tabIndex="14" size="33" name="custom_4" value="<?echo $custom_4;?>"> </b></p>
												<? } ?>
										
													<?echo "<input type='hidden' name='id' value='".$id."'>";?>
													<?echo "<input type='hidden' name='form_action' value='edit_attendee'>";?>
													<?echo "<input type='hidden' name='attendee_action' value='update_attendee'>";?>
										   			<br><br><input type="submit" name="Submit" value="UPDATE RECORD"></form><hr></td></tr></table>
									   			<?
									   			
					   						}
			}
		
		}

edit_attendee_record();
event_list_attendees();
}
?>