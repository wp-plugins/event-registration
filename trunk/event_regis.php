<?php
/*
Plugin Name: Events Registration
Plugin URI: http://www.edgetechweb.com
Description: This wordpress plugin is designed to run on a Wordpress webpage 
and provide registration for an event. It allows you to capture the registering 
persons contact information to a database and provides an association to an 
events database. It provides the ability to send the register to your 
paypal payment site for online collection of event fees. Reporting features 
provide a list of events, list of attendees, and excel export.
Version: 3.049
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
/* this does not only affect language but also format of date, and which fields are displayes in the form */
$lang_flag = "en"; //switch to en for changing language and form 

//Define the table versions for unique tables required in Events Registration
require_once ("event_regis_config.php");

//Calls language file
require_once ("event_language-$lang_flag.inc.php");

//Function to install/update data tables in the Wordpress database
require_once ("events_install.inc.php");



//Event Registration Subpage 1 - Reports
require_once ("event_config_info.inc.php");


//Event Registration Subpage 2 - Configure Organization
require_once ("event_regis_admin_config_org.php");

//Event Registration Subpage 3 - Add/Edit/Delete Events
require_once ('event_registration_forms.inc.php');
require_once ('event_register_attendees.inc.php');
require_once ('event_payments.inc.php');
require_once ('event_attendee_edit.inc.php');

//Event Registration Subpage 4 - Add Extra Questions
require_once ("event_regis_admin_questions.php");


//Install/Update Tables when plugin is activated
register_activation_hook ( __FILE__, 'events_data_tables_install' );

//ADMIN MENU
add_action ( 'admin_menu', 'add_event_registration_menus' );

// Enable the ability for the event_funct to be loaded from pages
add_filter ( 'the_content', 'event_regis_insert' );
add_filter ( 'the_content', 'event_regis_attendees_insert' );
add_filter ( 'the_content', 'event_regis_pay_insert' );
add_filter ('the_content','event_paypal_txn_insert');

//Enable the ability to use single event call for a page
add_shortcode('Event_Registration_Single', 'event_regis_run');


//Function to make compatible with Windows Servers as well as Apache

function request_uri() {
		  if (isset($_SERVER['REQUEST_URI'])) {
    			$uri = $_SERVER['REQUEST_URI'];
  				}
     	else {
    		if (isset($_SERVER['argv'])) {
      		$uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['argv'][0];
    		}
   			elseif (isset($_SERVER['QUERY_STRING'])) {
  				$uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['QUERY_STRING'];
  				}
    		else {
      			$uri = $_SERVER['SCRIPT_NAME'];
    			}
			}
		return $uri;
}


// Function to deal with loading the events into pages
function event_regis_insert($content) {
	if (preg_match ( '{EVENTREGIS}', $content )) { //[(.*)]
		$content = str_replace ( '{EVENTREGIS}', event_regis_run ($event_single_ID), $content );
	}
	return $content;
}

// Function to deal with loading the current event attendee list into pages or text widget
function event_regis_attendees_insert($content) {
	if (preg_match ( '{EVENTATTENDEES}', $content )) {
		$content = str_replace ( '{EVENTATTENDEES}', event_attendee_list_run (), $content );
	}
	return $content;
}

// Function to deal with loading the payment options on a page for return payment link
function event_regis_pay_insert($content) {
	if (preg_match ( '{EVENTREGPAY}', $content )) {
		$content = str_replace ( '{EVENTREGPAY}', event_regis_pay (), $content );
	}
	
	return $content;
}


function event_paypal_txn_insert($content)
		{
			  if (preg_match('{EVENTPAYPALTXN}',$content))
			    {
			      $content = str_replace('{EVENTPAYPALTXN}',event_paypal_txn(),$content);
			    }
			  return $content;
		}

// Function for Attendee List for Active Event

function event_attendee_list_run() {
	global $wpdb;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	
	$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$event_desc = $row ['event_desc'];
		echo "<h2>Attendee Listing For: <u>" . $event_name . "</u></h2>";
		echo "<p>$event_desc</p><hr />";
	}
	
	$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$id = $row ['id'];
		$lname = $row ['lname'];
		$fname = $row ['fname'];
		echo $fname . " " . $lname . "<br />";
	}
}

// Main Function for Script - selects what action to be taken when EVENTREGIS is run
function event_regis_run($event_single_ID) {
	/*	if ($_REQUEST['regevent_action'] == "post_attendee")
	{add_attendees_to_db();
	}
	else {
	register_attendees();
	}
	*/
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$events_listing_type = get_option ( 'events_listing_type' );
	
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$events_listing_type = $row ['events_listing_type'];
	}
	
	if ($events_listing_type == "") {
		echo "<p><b>Please setup Organization in the Admin Panel!</b></p>";
	}
	if ($events_listing_type == 'single') {
		$none="";
		if ($_REQUEST ['regevent_action'] == "post_attendee") {add_attendees_to_db ();}
		else if ($_REQUEST ['regevent_action'] == "pay") {event_regis_pay ();}
		else if ($_REQUEST['regevent_action'] == "paypal_txn"){event_regis_paypal_txn();}
		else if ($_REQUEST ['regevent_action'] == "register") {register_attendees ();}
		else if ($regevent_action == "process") {} 
		else {register_attendees ($none);
		}
	}
	
	if ($events_listing_type == 'all') {
		$none="";
		if ($_REQUEST ['regevent_action'] == "post_attendee") {add_attendees_to_db ();} 
		else if ($_REQUEST ['regevent_action'] == "pay") {event_regis_pay ();} 
		else if ($_REQUEST['regevent_action'] == "paypal_txn"){process_paypal_txn();}
		else if ($_REQUEST ['regevent_action'] == "register") {register_attendees ($none);} 
		else if ($regevent_action == "process") {} 
		else if ($event_single_ID !=""){register_attendees ($event_single_ID);} 
		else {display_all_events ();}
	}
}

//ADD EVENT_REGIS PLUGIN - ACTIVATED


function add_event_registration_menus() {
	
	add_menu_page ( 'Event Registration', 'Event Registration', 8, __FILE__, 'event_config_info' );
	
	add_submenu_page ( __FILE__, 'Event Reports', 'Event Reports', 8, 'reports', 'event_regis_main_mnu' );
	
	add_submenu_page ( __FILE__, 'Configure Organization', 'Configure Organization', 8, 'organization', 'event_config_mnu' );
	
	add_submenu_page ( __FILE__, 'Event Setup', 'Event Setup', 8, 'events', 'event_regis_events' );
	
	add_submenu_page ( __FILE__, 'Regform Setup', 'Regform Setup', 8, 'form', 'event_form_config' );
	
	add_submenu_page ( __FILE__, 'Process Payments', 'Process Payments', 8, 'attendee', 'event_process_payments' );
}

//Event Registration Main Admin Page

//This runs the Admin reports page
function event_regis_main_mnu() {
/*  The following functions are what I wish to add to the main menu page
1. Display current count of attendees for active event (show event name, description and id)- shows by default
*/
	event_registration_reports ();

}



//Event Registration

//how to add global variables  add_option("events_attendee_tbl_version", $events_attendee_tbl_version);
//how to call global variables   global $events_attendee_tbl_version;


include_once ("event_regis_form_build.inc.php");

function event_registration_reports() {
	
	global $wpdb;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$current_event = get_option ( 'current_event' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	define ( "EVNT_RGR_PLUGINPATH", "/" . plugin_basename ( dirname ( __FILE__ ) ) . "/" );
	define ( "EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );
	$url = EVNT_RGR_PLUGINFULLURL;
	
	//$this->wp_content_dir.'/plugins/'.plugin_basename(dirname(__FILE__)); » TO $plugin_path = dirname(__FILE__);
	

	$sql = "SELECT * FROM " . $events_detail_tbl;
	$result = mysql_query ( $sql );
	Echo "<p align='center'><p align='left'>SELECT EVENT TO VIEW ATTENDEES:</p><table width = '400'>";
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		
		echo "<tr><td width='25'></td><td><form name='form' method='post' action='";
		request_uri();
		echo "'>";
		echo "<input type='hidden' name='display_action' value='view_list'>";
		echo "<input type='hidden' name='event_id' value='" . $row ['id'] . "'>";
		echo "<input type='SUBMIT' value='" . $event_name . "'></form></td><tr>";
	}
	echo "</table>";
	
	//Echo "<br /><a href='http://".$_SERVER['SERVER_NAME']."/event_registration_export.php?atnd=".$events_attendee_tbl."&id=1'>Export Current Attendee List To Excel</a>";
	

	/*
?>
<button style="background-color:lightgreen" onclick="window.location='<?php echo $url."event_registration_export.php?atnd=".$events_attendee_tbl."&id=1";  ?>'" style="width:180; height: 30">Export Current Attendee List To Excel</button>
<?php */
	//view_attendee_list();
	if ($_REQUEST ['display_action'] == 'view_list') {
		attendee_display_edit ();
	}
	/*
if ( $run_reports == "" ) {events_reports_menu();}
if ( $run_reports == "excel_export" ) {event_resigration_export.php}
if ( $run_reports == "events_list" ) {events_reports_listing();}
if ( $run_reports == "current_attendees" ) {events_reports_current_attendee();}
			else {


			}

*/

}

function display_all_events() {
	global $wpdb,$lang;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$curdate = date ( "Y-m-j" );
	$month = date ('M');
	$day = date('j');
	$year = date('Y');
	$paypal_cur = get_option ( 'paypal_cur' );

	
$sql = "SELECT * FROM " . $events_detail_tbl ." WHERE start_date >= '".date ( 'Y-m-j' )."'";
		

		
	$result = mysql_query ( $sql );
	
	echo "<table width = '450'>";
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$identifier = $row ['event_identifier'];
		$image = $row ['image_link'];
		$cost = $row ['event_cost'];
		$checks = $row ['allow_checks'];
		$active = $row ['is_active'];

		
		
/*		echo "<tr><td width='400'>" . $event_name . " - " . $paypal_cur . "  " . $cost . "    <b>Event Start Date</b>  ".$row['start_date']."</p><hr></td><td>";
*/
	if ($image == ""){	echo "<tr><td width='400'><b>" . $event_name . " - " . $paypal_cur . "  " . $cost . "   </b></p><p>Start<b>  ".$row['start_date']."</b></p>
		<p>End<b>  ".$row['end_date']."</b></p>
		<hr></td><td>";}
	else {	echo "<tr><td width='100'><img src='".$image."' width='75' height='56'></td><td width='300'><b>" . $event_name . " - " . $paypal_cur . "  " . $cost . "   </b></p><p>Start<b>  ".$row['start_date']."</b></p>
		<p>End<b>  ".$row['end_date']."</b></p>
		<hr></td><td>";}
		
		echo "<form name='form' method='post' action='";
		request_uri();
		echo "'>";
		echo "<input type='hidden' name='regevent_action' value='register'>";
		echo "<input type='hidden' name='event_id' value='" . $row ['id'] . "'>";
		echo "<input type='SUBMIT' value='$lang[register]'></form></td></tr>";
		// echo "<input type='SUBMIT' value='REGISTER' ONCLICK=\"return confirm('Are you sure you want to register for ".$row['event_name']."?')\"></form></td></tr>";
	}
	echo "</table>";
}

function view_attendee_list() {
	//Displays attendee information from current active event.
	global $wpdb;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	
	$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$event_desc = $row ['event_desc'];
		$event_description = $row ['event_desc'];
		$image = $row ['image_link'];
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
	
	echo "<table>";
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
		$amt_pd = $row ['amount_pd'];
		$date_pd = $row ['paydate'];
		$event_id = $row ['event_id'];
		$custom1 = $row ['custom_1'];
		$custom2 = $row ['custom_2'];
		$custom3 = $row ['custom_3'];
		$custom4 = $row ['custom_4'];
		
		echo "<tr><td align='left'>" . $lname . ", " . $fname . "</td><td>" . $email . "</td><td>" . $phone . "</td>";
		echo "<td>";
		echo "<form name='form' method='post' action='";
		request_uri();
		echo "'>";
		echo "<input type='hidden' name='attendee_action' value='edit'>";
		echo "<input type='hidden' name='attendee_id' value='" . $id . "'>";
		// echo "<input type='SUBMIT' value='EDIT' ONCLICK=\"return confirm('Are you sure you want to edit record for ".$fname." ".$lname."?')\"></form>";
		echo "<input type='SUBMIT' value='EDIT'></form>";
		echo "</td></tr>";
	}
	echo "</table>";
}

include_once("event_regis_selections.inc.php");
?>