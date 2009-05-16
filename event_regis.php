<?php
/*
 *  TODO: Wordpress EMAIL FROM
 *  TODO: instead of active Event allow parameter {EVENTREGIX seminarid} 
 *  TODO: Ask more options: including payment
 *  TODO: also the payment question should be optional
 * 
Plugin Name: Events Registration
Plugin URI: http://www.edgetechweb.com
Description: This wordpress plugin is designed to run on a Wordpress webpage 
and provide registration for an event. It allows you to capture the registering 
persons contact information to a database and provides an association to an 
events database. It provides the ability to send the register to your 
paypal payment site for online collection of event fees. Reporting features 
provide a list of events, list of attendees, and excel export.
Version: 3.047
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
 * TODO-LIST

	TODO: Add start/end date for active registration
	TODO: decide for wishes of users in wordpress forum

*/

//Define the table versions for unique tables required in Events Registration


$events_attendee_tbl_version = "3.047";
$events_detail_tbl_version = "3.047";
$events_organization_tbl_version = "3.047";
$events_answer_tbl_version = "3.047";
$events_question_tbl_version = "3.047";

/** this does not only affect language but also format of date, and which fields are displayes in the form */
$lang_flag = "en"; //switch to en for changing language and form 


/** defines the line break */
define ( 'BR', '<br />' );

require_once ("event_language-$lang_flag.inc.php");

//Function to install/update data tables in the Wordpress database
require_once ("events_install.inc.php");

//Event Registration Subpage 2 - Add/Delete/Edit Events
require_once ('event_registration_forms.inc.php');

require_once ('event_register_attendees.inc.php');
require_once ('event_payments.inc.php');
require_once ('event_attendee_edit.inc.php');

//Install/Update Tables when plugin is activated


register_activation_hook ( __FILE__, 'events_data_tables_install' );

//ADMIN MENU


add_action ( 'admin_menu', 'add_event_registration_menus' );

// Enable the ability for the event_funct to be loaded from pages


add_filter ( 'the_content', 'event_regis_insert' );
add_filter ( 'the_content', 'event_regis_attendees_insert' );
add_filter ( 'the_content', 'event_regis_pay_insert' );
add_filter ('the_content','event_paypal_txn_insert');

// Function to deal with loading the events into pages

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


function event_regis_insert($content) {
	if (preg_match ( '{EVENTREGIS}', $content )) { //[(.*)]
		$content = str_replace ( '{EVENTREGIS}', event_regis_run ($event_single_ID), $content );
	}
	return $content;
}

function event_regis_attendees_insert($content) {
	if (preg_match ( '{EVENTATTENDEES}', $content )) {
		$content = str_replace ( '{EVENTATTENDEES}', event_attendee_list_run (), $content );
	}
	return $content;
}

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
add_shortcode('Event_Registration_Single', 'event_regis_run');

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
	
	add_menu_page ( 'Event Registration', 'Event Registration', 8, __FILE__, 'event_regis_main_mnu' );
	
	add_submenu_page ( __FILE__, 'Configure Organization', 'Configure Organization', 8, 'organization', 'event_config_mnu' );
	
	add_submenu_page ( __FILE__, 'Event Setup', 'Event Setup', 8, 'events', 'event_regis_events' );
	
	add_submenu_page ( __FILE__, 'Regform Setup', 'Regform Setup', 8, 'form', 'event_form_config' );
	
	add_submenu_page ( __FILE__, 'Process Payments', 'Process Payments', 8, 'attendee', 'event_process_payments' );
}

//Event Registration Main Admin Page


function event_regis_main_mnu() {
	
	/*  The following functions are what I wish to add to the main menu page
	1. Display current count of attendees for active event (show event name, description and id)- shows by default
*/
	event_registration_reports ();

}

function event_form_config() {
	
	global $lang;
	$form_question_build = $_REQUEST ['form_question_build'];
	
	switch ($form_question_build) {
		
		case "write_question" :
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			
			echo $lang ['addQuestionDesc'];
			?>

<form name="newquestion" method="post"
	action="<?php
			request_uri();?>"><input type="hidden" name="event_id"
	value="<?php
			echo $event_id;
			?>" />
<table width="100%" cellspacing="2" cellpadding="5">
	<tr valign="top">
		<th width="33%" scope="row">Question:</th>
		<td><input name="question" type="text" id="question" size="50"
			value="" /></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Type:</th>
		<td><select name="question_type" id="question_type">
			<option value="TEXT">Text</option>
			<option value="TEXTAREA">Text Area</option>
			<option value="SINGLE">Single</option>
			<option value="MULTIPLE">Multiple</option>
			<option value="DROPDOWN">Drop Down</option>
		</select></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Values:</th>
		<td><input name="values" type="text" id="values" size="50" value="" /></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Required:</th>
		<td><input name="required" type="checkbox" id="required" /></td>
	</tr>
</table>
			<?php
			echo "<p><form name='form' method='post' action='";
			request_uri();
			echo "'>";
			echo "<input type='hidden' name='form_question_build' value='post_new_question'>";
			echo "<input type='hidden' name='event_name' value='" . $event_name . "'>";
			echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
			?>	
			<p><input type="submit" name="Submit" value="POST QUESTION" /></p>
</form>
<?php
			break;
		
		case "edit" :
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			$question_id = $_REQUEST ['question_id'];
			
			$questions = $wpdb->get_results ( "SELECT * from $events_question_tbl where id = $question_id" );
			
			if ($questions) {
				foreach ( $questions as $question ) {
					echo $lang ['editQuestionDesc'];
					?>
<form name="newquestion" method="post"
	action="<?php
					request_uri();?>"><input type="hidden"
	name="form_question_build" value="post_edit" /> <input type="hidden"
	name="event_id" value="<?php
					echo $event_id;
					?>" /> <input type="hidden" name="question_id"
	value="<?php
					echo $question->id;
					?>" />

<table width="100%" cellspacing="2" cellpadding="5">
	<tr valign="top">
		<th width="33%" scope="row">Question:</th>
		<td><input name="question" type="text" id="question" size="50"
			value="<?php
					echo $question->question;
					?>" /></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Type:</th>
		<td><select name="question_type" id="question_type">
			<option value="<?php
					echo $question->question_type;
					?>"><?php
					echo $question->question_type;
					?></option>
			<option value="TEXT">Text</option>
			<option value="TEXTAREA">Text Area</option>
			<option value="SINGLE">Single</option>
			<option value="MULTIPLE">Multiple</option>
			<option value="DROPDOWN">Drop Down</option>
		</select></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Values:</th>
		<td><input name="values" type="text" id="values" size="50"
			value="<?php
					echo $question->response;
					?>" /></td>
	</tr>
	<tr valign="top">
		<th width="33%" scope="row">Required:</th>
		<td>
			
			<?php
					if ($question->required == "N") {
						echo '<input name="required" type="checkbox" id="required" />';
					}
					if ($question->required == "Y") {
						echo '<input name="required" type="checkbox" id="required" CHECKED />';
					}
				}
			}
			?>
			</td>
	</tr>
</table>
<p><input type="submit" name="Submit" value="UPDATE QUESTION" /></p>
</form>
<?php
			break;
		
		case "post_new_question" :
			
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			
			$question = $_POST ['question'];
			$question_type = $_POST ['question_type'];
			$values = $_POST ['values'];
			$required = $_POST ['required'] ? 'Y' : 'N';
			$sequence = $wpdb->get_var ( "SELECT max(sequence) FROM $events_question_tbl where event_id = '$event_id'" ) + 1;
			
			$wpdb->query ( "INSERT INTO $events_question_tbl (`event_id`, `sequence`, `question_type`, `question`, `response`, `required`)" . " values('$event_id', '$sequence', '$question_type', '$question', '$values', '$required')" );
			
			//echo "<meta http-equiv='refresh' content='0'>";
	/*		?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();
			?>&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php
*/

?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();?>admin.php?page=form&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php			break;
		
		case "post_edit" :
			
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			$question_text = $_POST ['question'];
			
			$question_id = $_POST ['question_id'];
			$question_type = $_POST ['question_type'];
			$values = $_POST ['values'];
			$required = $_POST ['required'] ? 'Y' : 'N';
			
			$wpdb->query ( "UPDATE $events_question_tbl set `question_type` = '$question_type', `question` = '$question_text', " . " `response` = '$values', `required` = '$required' where id = $question_id " );
			//echo "<meta http-equiv='refresh' content='0'>";
	/*		?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();
			?>&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php */
?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();?>admin.php?page=form&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php
			break;
		
		case "delete" :
			
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			$question_id = $_REQUEST ['question_id'];
			
			$wpdb->query ( "DELETE from $events_question_tbl where id = '$question_id'" );
			//echo "<meta http-equiv='refresh' content='0 URL=>";
		/*	?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();
			?>&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php
*/?>
<META HTTP-EQUIV="refresh"
	content="0;URL=<?php
			request_uri();?>admin.php?page=form&event_id=<?php
			echo $event_id . "&event_name=" . $event_name;
			?>">
<?php
			break;
		
		default :
			//query event list with select option
			global $wpdb;
			$events_detail_tbl = get_option ( 'events_detail_tbl' );
			$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
			$events_question_tbl = get_option ( 'events_question_tbl' );
			$event_id = $_REQUEST ['event_id'];
			$event_name = $_REQUEST ['event_name'];
			
			echo $lang ['selectEvent'];
			
			$sql = "SELECT * FROM " . $events_detail_tbl;
			$result = mysql_query ( $sql );
			while ( $row = mysql_fetch_assoc ( $result ) ) {
				$id = $row ['id'];
				$name = $row ['event_name'];
				
				echo "<p align='left'><form name='form' method='post' action='";
				request_uri();
				echo "'>";
				echo "<input type='hidden' name='event_id' value='" . $id . "'>";
				echo "<input type='hidden' name='event_name' value='" . $name . "'>";
				echo "<input type='SUBMIT' style='height: 30px; width: 300px' value='" . $name . "-" . $id . "'></form></p>";
			}
			?>
<hr />
<?php
			echo "<p>$lang[eventQuestions]- $event_name</p>";
			echo $lang ['addQuestionsBelowDesc'];
			
			$questions = $wpdb->get_results ( "SELECT * from $events_question_tbl where event_id = $event_id order by sequence" );
			echo "<table>";
			if ($questions) {
				foreach ( $questions as $question ) {
					echo "<tr><td><li><p><strong>" . $question->question . " (" . $question->response . ") TYPE - " . $question->question_type;
					if ($question->required == "N") {
						echo '</strong></li>';
					}
					if ($question->required == "Y") {
						echo ' - REQUIRED</strong></li>';
					}
					
					echo "<td width='15'></td><td><form name='form' method='post' action='";
					request_uri();
					echo "'>";
					echo "<input type='hidden' name='form_question_build' value='edit'>";
					echo "<input type='hidden' name='question_id' value='" . $question->id . "'>";
					echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
					echo "<input type='hidden' name='event_name' value='" . $event_name . "'>";
					echo "<input type='SUBMIT' style='background-color:yellow' value='EDIT QUESTION'></form></td>";
					
					echo "<td><form name='form' method='post' action='";
					request_uri();
					echo "'>";
					echo "<input type='hidden' name='form_question_build' value='delete'>";
					echo "<input type='hidden' name='question_id' value='" . $question->id . "'>";
					echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
					echo "<input type='hidden' name='event_name' value='" . $event_name . "'>";
					echo "<input type='SUBMIT' style='background-color:pink' value='DELETE' " . "onclick=\"return confirm('Are you sure you want to delete this question?')\"></form></td></tr>";
				
				}
			}
			
			echo "</table><hr />";
			
			if (isset ( $event_id ) && $event_id > 0) { //added isset to hide button if event has not been selected
				echo "<p><form name='form' method='post' action='";
				request_uri();
				echo "'>";
				echo "<input type='hidden' name='form_question_build' value='write_question'>";
				echo "<input type='hidden' name='event_name' value='" . $event_name . "'>";
				echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
				echo "<input type='SUBMIT' style='background-color:lightgreen'value='ADD QUESTIONS TO " . $event_name . "'></form></p>";
			}
			
			break;
	}

}

//Event Registration Subpage 1 - Configure Organization


function event_config_mnu() {
	
	global $wpdb;
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	
	if (isset ( $_POST ['Submit'] )) {
		
		$org_id = $_POST ['org_id'];
		$org_name = $_POST ['org_name'];
		$org_street1 = $_POST ['org_street1'];
		$org_street2 = $_POST ['org_street2'];
		$org_city = $_POST ['org_city'];
		$org_state = $_POST ['org_state'];
		$org_zip = $_POST ['org_zip'];
		$email = $_POST ['email'];
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
		
		$sql = "UPDATE " . $events_organization_tbl . " SET organization='$org_name', organization_street1='$org_street1', organization_street2='$org_street2', organization_city='$org_city', organization_state='$org_state', organization_zip='$org_zip', contact_email='$email', paypal_id='$paypal_id', currency_format='$paypal_cur', events_listing_type='$events_listing_type', return_url = '$return_url', cancel_return = '$cancel_return', notify_url = '$notify_url', return_method = '$return_method', use_sandbox = '$use_sandbox', image_url = '$image_url', default_mail='$default_mail', message='$message' WHERE id ='1'";
		
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

//how to add global variables  add_option("events_attendee_tbl_version", $events_attendee_tbl_version);
//how to call global variables   global $events_attendee_tbl_version;


function event_form_build(&$question, $answer = "") {
	$required = '';
	if ($question->required == "Y") {
		$required = ' class="r"';
	}
	switch ($question->question_type) {
		case "TEXT" :
			echo "<input type=\"text\"$required id=\"TEXT-$question->id\"  name=\"TEXT-$question->id\" size=\"40\" title=\"$question->question\" value=\"$answer\" />\n";
			break;
		
		case "TEXTAREA" :
			echo "<textarea id=\"TEXTAREA-$question->id\"$required name=\"TEXTAREA-$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">$answer</textarea>\n";
			break;
		
		case "SINGLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				echo "<label><input id=\"MULTIPLE-$question->id-$key\"$required name=\"SINGLE-$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;
		
		case "MULTIPLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE-$question->id-$key\" name=\"MULTIPLE-$question->id-$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;
		
		case "DROPDOWN" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			echo "<select name=\"DROPDOWN-$question->id\" id=\"DROPDOWN-$question->id\" title=\"$question->question\" />".BR;
			echo "<option value=''>Select One </option><br/>";
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " selected =\" selected\"" : "";
				echo "<option value=\"$value\" /> $value</option><br/>\n";
			}
			echo "</select>";
			break;
		
		default :
			break;
	}
}

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
		echo "<tr><td width='100'><img src='".$image."' width='75' height='56'></td><td width='300'><b>" . $event_name . " - " . $paypal_cur . "  " . $cost . "   </b></p><p>Start<b>  ".$row['start_date']."</b></p>
		<p>End<b>  ".$row['end_date']."</b></p>
		<hr></td><td>";
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

function displayMonths() {
    ?>
<option value="Jan">January</option>
<option value="Feb">February</option>
<option value="Mar">March</option>
<option value="Apr">April</option>
<option value="May">May</option>
<option value="Jun">June</option>
<option value="Jul">July</option>
<option value="Aug">August</option>
<option value="Sep">September</option>
<option value="Oct">October</option>
<option value="Nov">November</option>
<option value="Dec">December</option>
<?php
}
  

function displaySelectionBox($start_month = '', $start_day = '', $start_year = '', $end_month = '', $end_day = '', $end_year = '') {

	$currentyear = date ( 'Y' );
	
	?>Start Date:
<SELECT NAME="start_month">
    <?php
	if ($start_month != '') {
		echo "<option value=\"$start_month\">$start_month</option>";
	}
	displayMonths ();
	?>
	</SELECT>

<SELECT NAME="start_day">
    <?php
	if ($start_day != '') {
		echo "<option value=\"$start_day\">$start_day</option>";
	}
	for($i = 1; $i <= 31; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

<SELECT NAME="start_year">
    <?php
	if ($start_year != '') {
		echo "<option value=\"$start_year\">$start_year</option>";
	}
	for($i = $currentyear; $i <= $currentyear + 5; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

- End Date:
<SELECT NAME="end_month">
     <?php
	if ($end_month != '') {
		echo "<option value=\"$end_month\">$end_month</option>";
	}
	displayMonths ();
	?>
	for($i = $currentyear; $i <= $currentyear + 5; $i ++) {
		echo "<option value=\"$i\">$i</option>
	"; }
</SELECT>

<SELECT NAME="end_day">
    <?php
	if ($end_day != '') {
		echo "<option value=\"$end_day\">$end_day</option>";
	}
	for($i = 1; $i <= 31; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

<SELECT NAME="end_year">
    <?php
	if ($end_year != '') {
		echo "<option value=\"$end_year\">$end_year</option>";
	}
	for($i = $currentyear; $i <= $currentyear + 5; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>
<?php
}
?>