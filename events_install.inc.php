<?php
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
					  num_people (45) DEFAULT NULL,
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
		 $events_attendee_tbl_version = "3.042";
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
					  num_people (45) DEFAULT NULL,
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
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc VARCHAR(500) DEFAULT NULL,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  image_link VARCHAR(100) DEFAULT NULL,
				  header_image VARCHAR(100) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
				  start_time VARCHAR (15) DEFAULT NULL,
				  start_date DATE (25) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_date DATE (25) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
				  event_cost VARCHAR(45) DEFAULT NULL,
				  multiple VARCHAR(45) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  send_mail VARCHAR (2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  question1 VARCHAR(200) DEFAULT NULL,
				  question2 VARCHAR(200) DEFAULT NULL,
				  question3 VARCHAR(200) DEFAULT NULL,
				  question4 VARCHAR(200) DEFAULT NULL,
				  conf_mail text DEFAULT NULL,
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
	 $events_detail_tbl_version = "3.042";
     $installed_ver = get_option( "$events_detail_tbl_version" );
     if( $installed_ver != $events_detail_tbl_version ) {

 			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc VARCHAR(500) DEFAULT NULL,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  image_link VARCHAR(100) DEFAULT NULL,
				  header_image VARCHAR(100) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
				  start_date DATE DEFAULT NULL,
				  start_time VARCHAR (15) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  end_date DATE DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
				  event_cost VARCHAR(45) DEFAULT NULL,
				  multiple VARCHAR(45) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  send_mail VARCHAR(2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  question1 VARCHAR(200) DEFAULT NULL,
				  question2 VARCHAR(200) DEFAULT NULL,
				  question3 VARCHAR(200) DEFAULT NULL,
				  question4 VARCHAR(200) DEFAULT NULL,
				  conf_mail text  DEFAULT NULL,
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
				  id int(10) unsigned NOT NULL auto_increment,
				  organization varchar(45) default NULL,
				  organization_street1 varchar(45) default NULL,
				  organization_street2 varchar(45) default NULL,
				  organization_city varchar(45) default NULL,
				  organization_state varchar(45) default NULL,
				  organization_zip varchar(45) default NULL,
				  contact_email varchar(55) default NULL,
				  paypal_id varchar(55) default NULL,
				  currency_format varchar(45) default NULL,
				  events_listing_type varchar(45) default NULL,
				  default_mail varchar(2) default NULL,
				  message varchar(500) default NULL,
				  return_url varchar(100) default NULL,
				  cancel_return varchar(100) default NULL,
				  notify_url varchar(100) default NULL,
				  return_method varchar(100) default NULL,
				  use_sandbox int(1) default 0,
				  image_url varchar(100) default NULL,
				  UNIQUE KEY id (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

			$message=("Enter your custom confirmation message here.");


			$sql="INSERT into $table_name (organization, default_mail, message) values ('Your Company', 'Y', '".$message."')";
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
	$events_organization_tbl_version = "3.042";

     $installed_ver = get_option( "events_organization_tbl_version" );
     if( $installed_ver != $events_organization_tbl_version ) {

			$sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL auto_increment,
				  organization varchar(45) default NULL,
				  organization_street1 varchar(45) default NULL,
				  organization_street2 varchar(45) default NULL,
				  organization_city varchar(45) default NULL,
				  organization_state varchar(45) default NULL,
				  organization_zip varchar(45) default NULL,
				  contact_email varchar(55) default NULL,
				  paypal_id varchar(55) default NULL,
				  currency_format varchar(45) default NULL,
				  events_listing_type varchar(45) default NULL,
				  default_mail varchar(2) default NULL,
				  message varchar(500) default NULL,
				  return_url varchar(100) default NULL,
				  cancel_return varchar(100) default NULL,
				  notify_url varchar(100) default NULL,
				  return_method varchar(100) default NULL,
				  use_sandbox int(1) default 0,
				  image_url varchar(100) default NULL,
				  UNIQUE KEY id (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);


      		$message=("**This is an automated response - DO NOT REPLY! A contact email address is listed below.***\n\nThank you for signing up. Your registration has been recieved.  If you have not already done so, please submit payment.\n\nIf you have any questions, you can contact the organizer at "); 


			$sql="UPDATE $table_name SET default_mail='Y', message ='".$message."' WHERE id = '1')";
			$wpdb->query($sql);


      update_option( "events_organization_tbl_version", $events_organization_tbl_version );
      }
	}

function events_question_tbl_install() {
   global $wpdb;
   global $events_question_tbl_version;
   $table_name = $wpdb->prefix . "events_question_tbl";

   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			id int(11) unsigned NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question tinytext NOT NULL,
			response tinytext NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

//create option for table version
	$option_name = 'events_question_tbl_version' ;
	$newvalue = $events_question_tbl_version;
	if ( get_option($option_name) ) {
	update_option($option_name, $newvalue);
	 } else {
	  $deprecated=' ';
	  $autoload='no';
	  add_option($option_name, $newvalue, $deprecated, $autoload);
	 }
//create option for table name
	$option_name = 'events_question_tbl' ;
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

    $installed_ver = get_option( "events_question_tbl_version" );
    if( $installed_ver != $events_question_tbl_version ) {
	$sql = "CREATE TABLE " . $table_name . " (
			id int(11) unsigned NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question tinytext NOT NULL,
			response tinytext NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
			
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option( "events_question_tbl_version", $events_question_tbl_version );
    }
	}


function events_answer_tbl_install() {
   global $wpdb;
   global $events_answer_tbl_version;
   $table_name = $wpdb->prefix . "events_answer_tbl";

   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

//create option for table version
	$option_name = 'events_answer_tbl_version' ;
	$newvalue = $events_question_tbl_version;
	if ( get_option($option_name) ) {
	update_option($option_name, $newvalue);
	 } else {
	  $deprecated=' ';
	  $autoload='no';
	  add_option($option_name, $newvalue, $deprecated, $autoload);
	 }
//create option for table name
	$option_name = 'events_answer_tbl' ;
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

    $installed_ver = get_option( "events_answer_tbl_version" );
    if( $installed_ver != $events_answer_tbl_version ) {
	$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
			
		
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option( "events_answer_tbl_version", $events_answer_tbl_version );
    }
	}


events_attendee_tbl_install();
events_detail_tbl_install();
events_organization_tbl_install();
events_question_tbl_install();
events_answer_tbl_install();
}
?>