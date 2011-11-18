<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

function EVR_Offset($dt,$year_offset='',$month_offset='',$day_offset='') 
{ 
return ($dt=='0000-00-00') ? '' : 
date ("Y-m-d", mktime(0,0,0,substr($dt,5,2)+$month_offset,substr($dt,8,2)+ 
$day_offset,substr($dt,0,4)+$year_offset)); 
} 



function evr_upgrade_tables(){
    global $wpdb;
    $upgrade_version = "0.10";
    $new_attendee_tbl = $wpdb->prefix . "evr_attendee";
    $old_attendee_tbl = $wpdb->prefix."events_attendee";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_attendee_tbl'") != $new_attendee_tbl) {
        $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_attendee_tbl." SELECT * FROM ".$old_attendee_tbl);
    //create option in the wordpress options tale for the event attendee table name
				$option_name = 'evr_attendee' ;
				$newvalue =  $new_attendee_tbl;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
		

                //create option in the wordpress options table for the event attendee table version
				$option_name = 'evr_attendee_version' ;
				$newvalue = $upgrade_version;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
                  
         // copy num_people to quantity then drop num_people
         
         $wpdb->query ( "UPDATE ".$new_attendee_tbl." SET quantity = num_people") or die(mysql_error());
         $wpdb->query ( "ALTER TABLE ".$new_attendee_tbl." ADD reg_type VARCHAR (45) DEFAULT NULL AFTER zip" )  or die(mysql_error());       
         $wpdb->query ( "ALTER TABLE ".$new_attendee_tbl." ADD tickets MEDIUMTEXT DEFAULT NULL AFTER quantity" )  or die(mysql_error()); 
         $wpdb->query ( "ALTER TABLE ".$new_attendee_tbl." ADD payment_status VARCHAR(45) DEFAULT NULL AFTER payment" )  or die(mysql_error());  
         //$wpdb->query ( "UPDATE ".$new_attendee_tbl." SET payment_status = paystatus") or die(mysql_error());
         
        


                
   }         
    
    
    $new_event_tbl = $wpdb->prefix . "evr_event";
    $old_event_tbl = $wpdb->prefix."events_detail";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_event_tbl'") != $new_event_tbl) {
    $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_event_tbl." SELECT * FROM ".$old_event_tbl);
    //create option for table name
			$option_name = 'evr_event' ;
			$newvalue = $new_event_tbl;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
        //create option for table version
			$option_name = 'evr_event_version' ;
			$newvalue = $upgrade_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
		}
        
        //Add new fields to table
        //ALTER TABLE contacts ADD email VARCHAR(60) AFTER name;

        
        
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD event_address VARCHAR(100) DEFAULT NULL AFTER event_location" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD event_city VARCHAR(100) DEFAULT NULL AFTER event_address" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD event_state VARCHAR(100) DEFAULT NULL AFTER event_city" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD event_postal VARCHAR(100) DEFAULT NULL AFTER event_state" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD google_map VARCHAR (4) DEFAULT NULL AFTER event_postal" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD outside_reg VARCHAR (4) DEFAULT NULL AFTER google_map" )  or die(mysql_error());
        $wpdb->query ( "ALTER TABLE ".$new_event_tbl." ADD external_site VARCHAR (100) DEFAULT NULL AFTER outside_reg" )  or die(mysql_error());
  }
    
    $new_question_tbl = $wpdb->prefix . "evr_question";
    $old_question_tbl = $wpdb->prefix."events_question_tbl";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_question_tbl'") != $new_question_tbl) {
    $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_question_tbl." SELECT * FROM ".$old_question_tbl);
    //create option in the wordpress options tale for the event question table name
    	$option_name = 'evr_question' ;
    	$newvalue = $new_question_tbl;
     	if ( get_option($option_name) ) {
    	   update_option($option_name, $newvalue);
    	} else {
    	   $deprecated=' ';
    	   $autoload='no';
    	   add_option($option_name, $newvalue, $deprecated, $autoload);
    	} 
    //create option in the wordpress options table for the event question table version
    	$option_name = 'evr_question_version' ;
    	$newvalue = $upgrade_version;
    	if ( get_option($option_name) ) {
    	update_option($option_name, $newvalue);
    	 } else {
    	  $deprecated=' ';
    	  $autoload='no';
    	  add_option($option_name, $newvalue, $deprecated, $autoload);
    	 }
    
    }
    
    $new_answer_tbl = $wpdb->prefix . "evr_answer";
    $old_answer_tbl = $wpdb->prefix."events_answer_tbl";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_answer_tbl'") != $new_answer_tbl) {
        
    $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_answer_tbl." SELECT * FROM ".$old_answer_tbl);
    //create option in the wordpress options tale for the event answer table name
		$option_name = 'evr_answer' ;
    	$newvalue = $new_answer_tbl;
     	if ( get_option($option_name) ) {
    	   update_option($option_name, $newvalue);
    	} else {
    	   $deprecated=' ';
    	   $autoload='no';
    	   add_option($option_name, $newvalue, $deprecated, $autoload);
    	} 
   //create option in the wordpress options table for the event answer table version    
        $option_name = 'evr_answer_version' ;
    	$newvalue = $upgrade_version;
    	if ( get_option($option_name) ) {
    	update_option($option_name, $newvalue);
    	 } else {
    	  $deprecated=' ';
    	  $autoload='no';
    	  add_option($option_name, $newvalue, $deprecated, $autoload);
    	 }
    }
    
    $new_category_tbl = $wpdb->prefix . "evr_category";
    $old_category_tbl = $wpdb->prefix."events_cat_detail_tbl";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_category_tbl'") != $new_category_tbl) {
        
    $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_category_tbl." SELECT * FROM ".$old_category_tbl);
    //create option in the wordpress options table for the event category table 
				$option_name = 'evr_category' ;
				$newvalue = $new_category_tbl;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }	
                //create option in the wordpress options table for the event attendee table version
				$option_name = 'evr_category_version' ;
				$newvalue = $upgrade_version;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
    }
    
    $new_payment_tbl = $wpdb->prefix . "evr_payment";
    $old_payment_tbl = $wpdb->prefix."events_payment_transactions";
    if($wpdb->get_var("SHOW TABLES LIKE '$new_payment_tbl'") != $new_payment_tbl) {
    $wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_payment_tbl." SELECT * FROM ".$old_payment_tbl);
    //create option in the wordpress options tale for the event payment transaction table name
        $option_name = 'evr_payment' ;
			$newvalue = $new_payment_tbl;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
              
    //create option in the wordpress options table for the event payment transaction table version             
			$option_name = 'evr_payment_version' ;
			$newvalue = $upgrade_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
        }
     
    $new_cost_tbl = $wpdb->prefix . "evr_cost";
    $old_cost_tbl = $wpdb->prefix."events_detail";
    //$wpdb->query("CREATE TABLE IF NOT EXISTS ".$new_cost_tbl." SELECT * FROM ".$old_cost_tbl); 
    //Need to run query of events detail and create cost table based on that.
    if($wpdb->get_var("SHOW TABLES LIKE '$new_cost_tbl'") !=  $new_cost_tbl) {
      
                			$sql = "CREATE TABLE " . $new_cost_tbl . " (
                			id MEDIUMINT NOT NULL auto_increment,
                			sequence int(11) NOT NULL default '0',
                			event_id int(11) NOT NULL default '0',
                            item_title VARCHAR(75) DEFAULT NULL,
                            item_description VARCHAR(150) DEFAULT NULL,
                            item_cat VARCHAR (10) DEFAULT NULL,
                            item_limit VARCHAR (10) DEFAULT NULL,
                            item_price decimal(7,2) DEFAULT NULL,
                            free_item VARCHAR (4) DEFAULT NULL,
                            item_available_start_date VARCHAR (15) DEFAULT NULL,
                            item_available_end_date VARCHAR (15) DEFAULT NULL,
                            item_custom_cur VARCHAR(10) DEFAULT NULL,
                            PRIMARY KEY  (id)
                			) DEFAULT CHARSET=utf8;";
                	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                	dbDelta($sql);
                //create option in the wordpress options tale for the event question table name
            	$option_name = 'evr_cost' ;
            	$newvalue = $new_cost_tbl;
             	if ( get_option($option_name) ) {
            	   update_option($option_name, $newvalue);
            	} else {
            	   $deprecated=' ';
            	   $autoload='no';
            	   add_option($option_name, $newvalue, $deprecated, $autoload);
            	} 
            //create option in the wordpress options table for the event question table version
            	$option_name = 'evr_cost_version' ;
            	$newvalue = $upgrade_version;
            	if ( get_option($option_name) ) {
            	update_option($option_name, $newvalue);
            	 } else {
            	  $deprecated=' ';
            	  $autoload='no';
            	  add_option($option_name, $newvalue, $deprecated, $autoload);
                  }
               
       //Now get the pricing information from the events.
       
       $old_events = $wpdb->get_results("SELECT * from  ".$old_cost_tbl." ORDER BY id");
        if ($old_events) {
        foreach ($old_events as $old_event) {
				    //put old event into new table
                    $event_id = $old_event->id;
                    $item_start_date =  EVR_Offset($old_event->start_date,0,-2,0);
                    $sequence = '1';
                    $title = 'Registration Fee';
                    $description = 'Cost for registration for this event';
                    $category = 'REG';
                    $limit = '10';
                    if ($old_event->event_cost == "" ||$old_event->event_cost == "0") {$free_item = "Y";}else{$free_item="N";}
                    
                    
                    $sql=array('sequence'=>$sequence,'event_id'=>$event_id, 'item_title'=>$title, 'item_description'=>$description, 
                            'item_cat'=>$category, 'item_limit'=>$limit, 'item_price'=>$old_event->event_cost, 'free_item'=>$free_item,'item_available_start_date'=>$item_start_date,  
                            'item_available_end_date'=>$old_event->end_date, 'item_custom_cur'=>$old_event->custom_cur); 
    		
                    $sql_data = array('%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s');
                    $wpdb->insert( $new_cost_tbl, $sql, $sql_data ) or die(mysql_error());;
                    }
                    }
                    
          //Now update the ticket information for each attendee
          
          //Get attendee 
          $attendees = $wpdb->get_results("SELECT * FROM " . get_option('evr_attendee')." ORDER by id" );
          if ($attendees){
                foreach ($attendees as $attendee){
                    $attendee_id =  $attendee->id;
                    $num_people = $attendee->quantity;
                    $event_id = $attendee->event_id;
                    $item_order = array();
                    
                    $costs = $wpdb->get_results("SELECT * FROM " . get_option('evr_cost')." WHERE event_id = " . $event_id. " ORDER BY sequence ASC" );
                    if ($costs){
                        foreach($costs as $cost){
                            $item_info = array('ItemID' => $cost->id, 'ItemEventID' => $cost->event_id, 'ItemCat'=>$cost->item_cat,
                                            'ItemName' => $cost->item_title, 'ItemCost' => $cost->item_price, 'ItemCurrency' =>
                                            $cost->item_custom_cur, 'ItemFree' => $cost->free_item, 'ItemStart' => $cost->item_available_start_date,
                                            'ItemEnd' => $cost->item_available_end_date, 'ItemQty' => $num_people);
                                        array_push($item_order, $item_info);
                                        $cost = $cost->item_price;
                                        }
                            }
                    $ticket_data = serialize($item_order);
                    $payment = $num_people * $cost;
                    
                    $wpdb->update( get_option('evr_attendee'), array( 'reg_type' => 'RGLR', 'payment' => $payment, 'tickets' => $ticket_data ), 
                    array( 'id' => $attendee_id ), array( '%s', '%s','%s' ), array( '%d' ) ) or die(mysql_error());;
                }
          }
    }
    
    $old_organization_tbl = $wpdb->prefix."events_organization"; 
    
    $ER_org_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $old_organization_tbl . " WHERE id='1'" ), ARRAY_A )or die(mysql_error());

   
    
    
            $company_options['company']           = $ER_org_data ['organization'];
    		$company_options['company_street1']   = $ER_org_data ['organization_street1'];
    		$company_options['company_street2']   = $ER_org_data ['organization_street2'];
    		$company_options['company_city']      = $ER_org_data ['organization_city'];;
    		$company_options['company_state']     = $ER_org_data ['organization_state'];
    		$company_options['company_postal']    = $ER_org_data ['organization_zip'];
    		$company_options['company_email']     = $ER_org_data ['contact_email'];
    		$company_options['evr_page_id']       = "";
    		$company_options['splash']            = "";
            $company_options['send_confirm']      = $ER_org_data ['default_mail'];
    		$company_options['message']           = htmlentities2($ER_org_data ['message']);
            $company_options['thumbnail']         = $ER_org_data ['show_thumb'];
            $company_options['calendar_url']      = "";            //$_POST['calendar_url';
            $company_options['default_currency']  = $ER_org_data ['currency_format'];
            $company_options['donations']         = $ER_org_data ['accept_donations']; 
            $company_options['checks']            = ""; 
            $company_options['pay_now']           = "";    
            $company_options['payment_vendor']    = $ER_org_data ['payment_vendor'];
            $company_options['payment_vendor_id'] = $ER_org_data ['payment_vendor_id'];
            $company_options['payment_vendor_key']= $ER_org_data ['txn_key'];
            $company_options['return_url']        = "";
            $company_options['notify_url']        = "";
            $company_options['cancel_return']     = "";
            $company_options['return_method']     = "";
            $company_options['use_sandbox']       = "N";
            $company_options['image_url']         =  $ER_org_data ['image_url'];
            $company_options['admin_message']     = "";
            $company_options['payment_subj']      = "Payment Received";
            $company_options['payment_message']   = "We recieved your event payment";
            $company_options['captcha']           = $ER_org_data ['captcha'];
   
   	update_option( 'evr_company_settings', $company_options);
    
}


function evr_attendee_db () {
            //Define global variables
            global $wpdb, $cur_build;
            global $evr_attendee_version;
            //Create new variables for this function            
            $table_name = $wpdb->prefix . "evr_attendee";
            $evr_attendee_version = $cur_build;
            //check the SQL database for the existence of the Event Attendee Database - if it does not exist create it.            
            if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                $sql = "CREATE TABLE " . $table_name . " (
					  id MEDIUMINT NOT NULL AUTO_INCREMENT,
					  lname VARCHAR(45) DEFAULT NULL,
					  fname VARCHAR(45) DEFAULT NULL,
					  address VARCHAR(45) DEFAULT NULL,
					  city VARCHAR(45) DEFAULT NULL,
					  state VARCHAR(45) DEFAULT NULL,
					  zip VARCHAR(45) DEFAULT NULL,
					  reg_type VARCHAR (45) DEFAULT NULL,
					  email VARCHAR(65) DEFAULT NULL,
					  phone VARCHAR(45) DEFAULT NULL,
					  date timestamp NOT NULL default CURRENT_TIMESTAMP,
					  event_id VARCHAR(45) DEFAULT NULL,
                      coupon VARCHAR(45) DEFAULT NULL,
					  quantity VARCHAR(45) DEFAULT NULL,
                      attendees MEDIUMTEXT DEFAULT NULL,
                      tickets MEDIUMTEXT DEFAULT NULL,
                      payment VARCHAR(45) DEFAULT NULL,
                      payment_status VARCHAR(45) DEFAULT NULL,
                      amount_pd VARCHAR (45) DEFAULT NULL,
                      payment_date varchar(30) DEFAULT NULL,
                      UNIQUE KEY id (id)
					) DEFAULT CHARSET=utf8;";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);

                //create option in the wordpress options tale for the event attendee table name
				$option_name = 'evr_attendee' ;
				$newvalue = $table_name;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
		

                //create option in the wordpress options table for the event attendee table version
				$option_name = 'evr_attendee_version' ;
				$newvalue = $evr_attendee_version;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
        	}
            // Code here with new database upgrade info/table Must change version number to work.
            // Note: SQL syntex should be the same in both places to ensure new table/ table update match.
            // Retrieve the installed version of the events attendee table and assign a variable		 
		 $installed_ver = get_option( "evr_attendee_version" );
            //check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.
	     if( $installed_ver != $evr_attendee_version ) {
			$sql = "CREATE TABLE " . $table_name . " (
					  id MEDIUMINT NOT NULL AUTO_INCREMENT,
					  lname VARCHAR(45) DEFAULT NULL,
					  fname VARCHAR(45) DEFAULT NULL,
					  address VARCHAR(45) DEFAULT NULL,
					  city VARCHAR(45) DEFAULT NULL,
					  state VARCHAR(45) DEFAULT NULL,
					  zip VARCHAR(45) DEFAULT NULL,
					  reg_type VARCHAR (45) DEFAULT NULL,
					  email VARCHAR(65) DEFAULT NULL,
					  phone VARCHAR(45) DEFAULT NULL,
					  date timestamp NOT NULL default CURRENT_TIMESTAMP,
					  event_id VARCHAR(45) DEFAULT NULL,
                      coupon VARCHAR(45) DEFAULT NULL,
					  quantity VARCHAR(45) DEFAULT NULL,
                      attendees MEDIUMTEXT DEFAULT NULL,
                      tickets MEDIUMTEXT DEFAULT NULL,
                      payment VARCHAR(45) DEFAULT NULL,
                      payment_status VARCHAR(45) DEFAULT NULL,
                      amount_pd VARCHAR (45) DEFAULT NULL,
                      payment_date varchar(30) DEFAULT NULL,
                      UNIQUE KEY id (id)
					) DEFAULT CHARSET=utf8;";
	      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	      dbDelta($sql);
            //update the table version number to match the updated sql
	      update_option( "evr_attendee_version", $evr_attendee_version );
	      }
}

function evr_category_db() {
            //Define global variables
		   global $wpdb, $cur_build;
		   global $evr_category_version;
            //Create new variables for this function 			
		   $table_name = $wpdb->prefix . "evr_category";
		   $evr_category_version = $cur_build;
            //check the SQL database for the existence of the Event Category Table - if it does not exist create it.     	
		   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				   $sql = "CREATE TABLE " . $table_name . " (
					  id MEDIUMINT NOT NULL AUTO_INCREMENT,
					  category_name VARCHAR(100) DEFAULT NULL,
					  category_identifier VARCHAR(45) DEFAULT NULL,
					  category_desc TEXT,
					  display_desc VARCHAR (4) DEFAULT NULL,
                      category_color VARCHAR(30) NOT NULL ,
                      font_color VARCHAR(30) NOT NULL DEFAULT '#000000',
					   UNIQUE KEY id (id)
					) DEFAULT CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
                //create option in the wordpress options table for the event category table 
				$option_name = 'evr_category' ;
				$newvalue = $table_name;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }	
                //create option in the wordpress options table for the event attendee table version
				$option_name = 'evr_category_version' ;
				$newvalue = $evr_category_version;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
        }
        // Code here with new database upgrade info/table Must change version number to work.
        // Note: SQL syntex should be the same in both places to ensure new table/ table update match.
        // Retrieve the installed version of the events category table and assign a variable	
		 $installed_ver = get_option( "evr_category_version" );
        //check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.
		 if( $installed_ver != $evr_category_version ) {
	
				   $sql = "CREATE TABLE " . $table_name . " (
					  id MEDIUMINT NOT NULL AUTO_INCREMENT,
					  category_name VARCHAR(100) DEFAULT NULL,
					  category_identifier VARCHAR(45) DEFAULT NULL,
					  category_desc TEXT,
					  display_desc VARCHAR (4) DEFAULT NULL,
                      category_color VARCHAR(30) NOT NULL ,
                      font_color VARCHAR(30) NOT NULL DEFAULT '#000000',
					   UNIQUE KEY id (id)
					) DEFAULT CHARSET=utf8;";
	
		  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		  dbDelta($sql);
        //update the table version number to match the updated sql		  
		  update_option( "evr_category_version", $evr_category_version );
		  }
		
		
}

function evr_event_db() {
//Define global variables
	   global $wpdb, $cur_build;
	   global $evr_event_version;
//Create new variables for this function  
	   $table_name = $wpdb->prefix . "evr_event";
       $evr_event_version = $cur_build;
//check the SQL database for the existence of the Event Details Database - if it does not exist create it.        
       if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			   $sql = "CREATE TABLE " . $table_name . " (
				  id MEDIUMINT NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc TEXT DEFAULT NULL,
				  event_location VARCHAR(300) DEFAULT NULL,
                  event_address VARCHAR(100) DEFAULT NULL,
                  event_city VARCHAR(100) DEFAULT NULL,
                  event_state VARCHAR(100) DEFAULT NULL,
                  event_postal VARCHAR(100) DEFAULT NULL,
                  google_map VARCHAR (4) DEFAULT NULL,
                  outside_reg VARCHAR (4) DEFAULT NULL,
                  external_site VARCHAR (100) DEFAULT NULL,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  image_link VARCHAR(100) DEFAULT NULL,
				  header_image VARCHAR(100) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  more_info VARCHAR(100) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
                  start_time VARCHAR (15) DEFAULT NULL,
				  start_date VARCHAR (15) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_date VARCHAR (15) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
                  custom_cur VARCHAR(10) DEFAULT NULL,
				  reg_form_defaults VARCHAR(100) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  send_mail VARCHAR (2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  conf_mail VARCHAR (1000) DEFAULT NULL,
                  use_coupon VARCHAR(1) DEFAULT NULL,
				  coupon_code VARCHAR(50) DEFAULT NULL,
				  coupon_code_price decimal(7,2) DEFAULT NULL,
				  category_id TEXT,
				  UNIQUE KEY id (id)
				) DEFAULT CHARSET=utf8;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

        //create option for table name
			$option_name = 'evr_event' ;
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
        //create option for table version
			$option_name = 'evr_event_version' ;
			$newvalue = $evr_event_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
		}
    }
// Code here with new database upgrade info/table Must change version number to work.
// Note: SQL syntex should be the same in both places to ensure new table/ table update match.
// Retrieve the installed version of the events detail table and assign a variable	 
     $installed_ver = get_option( "$evr_event_version" );
//check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.    
     if( $installed_ver != $evr_event_version ) {
 			  $sql = "CREATE TABLE " . $table_name . " (
				  id MEDIUMINT NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc TEXT DEFAULT NULL,
				  event_location VARCHAR(300) DEFAULT NULL,
                  event_address VARCHAR(100) DEFAULT NULL,
                  event_city VARCHAR(100) DEFAULT NULL,
                  event_state VARCHAR(100) DEFAULT NULL,
                  event_postal VARCHAR(100) DEFAULT NULL,
                  google_map VARCHAR (4) DEFAULT NULL,
                  outside_reg VARCHAR (4) DEFAULT NULL,
                  external_site VARCHAR (100) DEFAULT NULL,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  image_link VARCHAR(100) DEFAULT NULL,
				  header_image VARCHAR(100) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  more_info VARCHAR(100) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
                  start_time VARCHAR (15) DEFAULT NULL,
				  start_date VARCHAR (15) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_date VARCHAR (15) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
                  custom_cur VARCHAR(10) DEFAULT NULL,
				  reg_form_defaults VARCHAR(100) DEFAULT NULL,
				  allow_checks VARCHAR(45) DEFAULT NULL,
				  send_mail VARCHAR (2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  conf_mail VARCHAR (1000) DEFAULT NULL,
                  use_coupon VARCHAR(1) DEFAULT NULL,
				  coupon_code VARCHAR(50) DEFAULT NULL,
				  coupon_code_price decimal(7,2) DEFAULT NULL,
				  category_id TEXT,
				  UNIQUE KEY id (id)
				) DEFAULT CHARSET=utf8;";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
//update the table version number to match the updated sql
      update_option( "evr_event_version", $evr_event_version );
      }
}

function evr_cost_db() {
//Define global variables
   global $wpdb, $cur_build;
   global $evr_cost_version;
//Create new variables for this function   
   $table_name = $wpdb->prefix . "evr_cost";
   $evr_cost_version = $cur_build;
//check the SQL database for the existence of the Event Question Table - if it does not exist create it. 
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			id MEDIUMINT NOT NULL auto_increment,
			sequence int(11) NOT NULL default '0',
			event_id int(11) NOT NULL default '0',
            item_title VARCHAR(75) DEFAULT NULL,
            item_description VARCHAR(150) DEFAULT NULL,
            item_cat VARCHAR (10) DEFAULT NULL,
            item_limit VARCHAR (10) DEFAULT NULL,
            item_price decimal(7,2) DEFAULT NULL,
            free_item VARCHAR (4) DEFAULT NULL,
            
            item_available_start_date VARCHAR (15) DEFAULT NULL,
            item_available_end_date VARCHAR (15) DEFAULT NULL,
            item_custom_cur VARCHAR(10) DEFAULT NULL,
            PRIMARY KEY  (id)
			) DEFAULT CHARSET=utf8;";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
//create option in the wordpress options tale for the event question table name
    	$option_name = 'evr_cost' ;
    	$newvalue = $table_name;
     	if ( get_option($option_name) ) {
    	   update_option($option_name, $newvalue);
    	} else {
    	   $deprecated=' ';
    	   $autoload='no';
    	   add_option($option_name, $newvalue, $deprecated, $autoload);
    	} 
    //create option in the wordpress options table for the event question table version
    	$option_name = 'evr_cost_version' ;
    	$newvalue = $evr_cost_version;
    	if ( get_option($option_name) ) {
    	update_option($option_name, $newvalue);
    	 } else {
    	  $deprecated=' ';
    	  $autoload='no';
    	  add_option($option_name, $newvalue, $deprecated, $autoload);
    	 }
 }
// Code here with new database upgrade info/table Must change version number to work.
// Note: SQL syntex should be the same in both places to ensure new table/ table update match.
// Retrieve the installed version of the events attendee table and assign a variable
    $installed_ver = get_option( "evr_cost_version" );
//check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.    
    if( $installed_ver != $evr_cost_version ) {
        $sql = "CREATE TABLE " . $table_name . " (
			id MEDIUMINT NOT NULL auto_increment,
			sequence int(11) NOT NULL default '0',
			event_id int(11) NOT NULL default '0',
            item_title VARCHAR(75) DEFAULT NULL,
            item_description VARCHAR(150) DEFAULT NULL,
            item_cat VARCHAR (10) DEFAULT NULL,
            item_limit VARCHAR (10) DEFAULT NULL,
            item_price decimal(7,2) DEFAULT NULL,
            free_item VARCHAR (4) DEFAULT NULL,
            item_available_start_date VARCHAR (15) DEFAULT NULL,
            item_available_end_date VARCHAR (15) DEFAULT NULL,
            item_custom_cur VARCHAR(10) DEFAULT NULL,
            PRIMARY KEY  (id)
			)DEFAULT CHARSET=utf8;";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
//update the table version number to match the updated sql
    update_option( "evr_cost_version", $evr_cost_version );
    }
}

function evr_payment_db() {
//Define global variables
	   global $wpdb, $cur_build;
	   global $evr_payment_version;
//Create new variables for this function  
	   $table_name = $wpdb->prefix . "evr_payment";
	   $evr_payment_version = $cur_build;
//check the SQL database for the existence of the Event Attendee Database - if it does not exist create it. 
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			   $sql = "CREATE TABLE " . $table_name . " (
				  id MEDIUMINT NOT NULL AUTO_INCREMENT,
				  payer_id varchar(15) NOT NULL,
                  event_id varchar (15) NOT NULL,
				  payment_date varchar(30) DEFAULT NULL,
				  txn_id varchar(20) NOT NULL,
				  first_name varchar(50) NOT NULL,
				  last_name varchar(50) NOT NULL,
				  payer_email varchar(100) NOT NULL,
				  payer_status varchar(10) NOT NULL,
				  payment_type varchar(20) NOT NULL,
				  memo text NOT NULL,
				  item_name text NOT NULL,
				  item_number varchar(50) NOT NULL,
				  quantity int(3) NOT NULL,
				  mc_gross decimal(10,2) NOT NULL,
				  mc_currency varchar(3) NOT NULL,
				  address_name varchar(32) DEFAULT NULL,
				  address_street varchar(64) DEFAULT NULL,
				  address_city varchar(32) DEFAULT NULL,
				  address_state varchar(32) DEFAULT NULL,
				  address_zip varchar(10) DEFAULT NULL,
				  address_country varchar(64) DEFAULT NULL,
				  address_status varchar(11) DEFAULT NULL,
				  payer_business_name varchar(64) DEFAULT NULL,
				  payment_status varchar(17) NOT NULL,
				  pending_reason varchar(14) DEFAULT NULL,
				  reason_code varchar(15) DEFAULT NULL,
				  txn_type varchar(20) NOT NULL,
				  PRIMARY KEY (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

//create option in the wordpress options tale for the event payment transaction table name
        $option_name = 'evr_payment' ;
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
              
//create option in the wordpress options table for the event payment transaction table version             
			$option_name = 'evr_payment_version' ;
			$newvalue = $evr_payment_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		}
// Code here with new database upgrade info/table Must change version number to work.
// Note: SQL syntex should be the same in both places to ensure new table/ table update match.
// Retrieve the installed version of the events attendee table and assign a variable	 
     $installed_ver = get_option( "$evr_payment_version" );
//check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.
     if( $installed_ver != $evr_payment_version ) {

 			   $sql = "CREATE TABLE " . $table_name . " (
				  id MEDIUMINT NOT NULL AUTO_INCREMENT,
				  payer_id varchar(15) NOT NULL,
                  event_id varchar (15) NOT NULL,
				  payment_date varchar(30) DEFAULT NULL,
				  txn_id varchar(20) NOT NULL,
				  first_name varchar(50) NOT NULL,
				  last_name varchar(50) NOT NULL,
				  payer_email varchar(100) NOT NULL,
				  payer_status varchar(10) NOT NULL,
				  payment_type varchar(20) NOT NULL,
				  memo text NOT NULL,
				  item_name text NOT NULL,
				  item_number varchar(50) NOT NULL,
				  quantity int(3) NOT NULL,
				  mc_gross decimal(10,2) NOT NULL,
				  mc_currency varchar(3) NOT NULL,
				  address_name varchar(32) DEFAULT NULL,
				  address_street varchar(64) DEFAULT NULL,
				  address_city varchar(32) DEFAULT NULL,
				  address_state varchar(32) DEFAULT NULL,
				  address_zip varchar(10) DEFAULT NULL,
				  address_country varchar(64) DEFAULT NULL,
				  address_status varchar(11) DEFAULT NULL,
				  payer_business_name varchar(64) DEFAULT NULL,
				  payment_status varchar(17) NOT NULL,
				  pending_reason varchar(14) DEFAULT NULL,
				  reason_code varchar(15) DEFAULT NULL,
				  txn_type varchar(20) NOT NULL,
				  PRIMARY KEY (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
//update the table version number to match the updated sql
      update_option( "evr_payment_version", $evr_payment_version );
      }
}

function evr_question_db() {
//Define global variables
   global $wpdb, $cur_build;
   global $evr_question_version;
//Create new variables for this function   
   $table_name = $wpdb->prefix . "evr_question";
   $evr_question_version = $cur_build;
//check the SQL database for the existence of the Event Question Table - if it does not exist create it. 
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			id MEDIUMINT NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question text NOT NULL,
			response text NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
//create option in the wordpress options tale for the event question table name
    	$option_name = 'evr_question' ;
    	$newvalue = $table_name;
     	if ( get_option($option_name) ) {
    	   update_option($option_name, $newvalue);
    	} else {
    	   $deprecated=' ';
    	   $autoload='no';
    	   add_option($option_name, $newvalue, $deprecated, $autoload);
    	} 
    //create option in the wordpress options table for the event question table version
    	$option_name = 'evr_question_version' ;
    	$newvalue = $evr_question_version;
    	if ( get_option($option_name) ) {
    	update_option($option_name, $newvalue);
    	 } else {
    	  $deprecated=' ';
    	  $autoload='no';
    	  add_option($option_name, $newvalue, $deprecated, $autoload);
    	 }
 }
// Code here with new database upgrade info/table Must change version number to work.
// Note: SQL syntex should be the same in both places to ensure new table/ table update match.
// Retrieve the installed version of the events attendee table and assign a variable
    $installed_ver = get_option( "evr_question_version" );
//check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below.    
    if( $installed_ver != $evr_question_version ) {
			$sql = "CREATE TABLE " . $table_name . " (
			id MEDIUMINT NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question text NOT NULL,
			response text NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
//update the table version number to match the updated sql
    update_option( "evr_question_version", $evr_question_version );
    }
}
//
//Create the table for the answers for the questions
function evr_answer_db() {
//Define global variables
   global $wpdb, $cur_build;
   global $evr_answer_version;
//Create new variables for this function    
    $table_name = $wpdb->prefix . "evr_answer";
    $evr_answer_version = $cur_build;
//check the SQL database for the existence of the Event Answer Database - if it does not exist create it. 
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
//create option in the wordpress options tale for the event answer table name
		$option_name = 'evr_answer' ;
    	$newvalue = $table_name;
     	if ( get_option($option_name) ) {
    	   update_option($option_name, $newvalue);
    	} else {
    	   $deprecated=' ';
    	   $autoload='no';
    	   add_option($option_name, $newvalue, $deprecated, $autoload);
    	} 
   //create option in the wordpress options table for the event answer table version    
        $option_name = 'evr_answer_version' ;
    	$newvalue = $evr_answer_version;
    	if ( get_option($option_name) ) {
    	update_option($option_name, $newvalue);
    	 } else {
    	  $deprecated=' ';
    	  $autoload='no';
    	  add_option($option_name, $newvalue, $deprecated, $autoload);
    	 }
    }
// Code here with new database upgrade info/table Must change version number to work.
// Note: SQL syntex should be the same in both places to ensure new table/ table update match.
// Retrieve the installed version of the events attendee table and assign a variable
    $installed_ver = get_option( "evr_answer_version" );
//check the installed version to the version defined tin the top of this file, if version is different - update to the sql structure below. 
    if( $installed_ver != $evr_answer_version ) {
	$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
//update the table version number to match the updated sql
    update_option( "evr_answer_version", $evr_answer_version );
    }
}
?>