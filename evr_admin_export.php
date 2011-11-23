<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);
 
if ($_REQUEST['key'] != '5678'){
    echo "Failure!!";
    exit;
}	
if ( file_exists( '../../../wp-config.php') ) {

require_once( '../../../wp-config.php'); 
	
	
global $wpdb;

(is_numeric($_REQUEST['id'])) ? $event_id = $_REQUEST['id'] : $event_id = "0";

if ($event_id == '0'){exit;}



$events_attendee_tbl = $_REQUEST['atnd'];
$today = date("Y-m-d_Hi",time()); 

$events_answer_tbl = get_option('evr_answer');
$events_question_tbl = get_option('evr_question');
$events_detail_tbl = get_option('evr_event');
$events_attendee_tbl = get_option('evr_attendee');
$events_payment_tbl = get_option ('evr_payment');

$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$event_id'";
$result = mysql_query($sql);
list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $allow_checks, $is_active) = mysql_fetch_array($result, MYSQL_NUM);


switch ($_REQUEST['action']) {
	case "excel";
				$st = "";
			$et = "\t";
			$s = $et . $st;
	
			$basic_header = array('Reg ID', 'Reg Date','Type','Last Name', 'First Name', 'Attendees', 'Email', 'Address', 
					'City', 'State', 'Zip', 'Phone','Num People', 'Payment','Tickets');
			$question_sequence = array();
			
				$questions = $wpdb->get_results("select question, sequence from ".$events_question_tbl." where event_id = '$event_id' order by sequence");
			foreach ($questions as $question) {
				array_push($basic_header, $question->question);
				array_push($question_sequence, $question->sequence);
			}

			$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
           
            $file = urlencode(stripslashes($event_name));

         $filename = $file."-Attendees_". $today . ".xls";
		
		  header("Content-Disposition: attachment; filename=\"$filename\"");
		  header("Content-Type: application/vnd.ms-excel");
		  header("Pragma: no-cache"); 
		  header("Expires: 0"); 

			//echo header
			echo implode($s, $basic_header) . $et . "\r\n";

			//echo data
			if ($participants) {
				foreach ($participants as $participant) {
					echo $participant->id
					. $s . $participant->date
                    . $s . $participant->reg_type
                    . $s . $participant->lname
					. $s . $participant->fname;
                    
                                      
                   $attendee_array = unserialize($participant->attendees);
                    if ( count($attendee_array)>"0"){
                                $attendee_names="";
                                $i = 0;
                                 do {
                                    $attendee_names .= $attendee_array[$i]["first_name"]." ".$attendee_array[$i]['last_name'].", ";
                                    
                                   
                                 ++$i;
                                 } while ($i < count($attendee_array));
                            }
                           
                    
					echo   $s . $attendee_names
                    . $s . $participant->email
					. $s . $participant->address
					. $s . $participant->city
					. $s . $participant->state
					. $s . $participant->zip
					. $s . $participant->phone
                    . $s . $participant->quantity
					. $s . $participant->payment
                    . $s;
                    
                    $ticket_order = unserialize($participant->tickets);
                    
                   $row_count = count($ticket_order);
                   echo "||";
                                    for ($row = 0; $row < $row_count; $row++) {
                                       echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."||";
                                       } 
					
					$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on " .
							"q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");
	
					foreach($answers as $answer) {
						echo $s . $answer->answer;
					}
	
					echo $et . "\r\n";
				}
			} else {
				echo "<tr><td>";
                _e('No participant data has been collected.','evr_language');
                echo "</td></tr>";
			}
			exit;
	break;

	case "csv";
			$st = "";
			$et = ",";
			$s = $et . $st;
	
		$basic_header = array('Reg ID', 'Reg Date','Type','Last Name', 'First Name', 'Attendees','Email', 'Address', 
					'City', 'State', 'Zip', 'Phone','Num People', 'Payment','Tickets');
			$question_sequence = array();
			$questions = $wpdb->get_results("select question, sequence from ".$events_question_tbl." where event_id = '$event_id' order by sequence");
			foreach ($questions as $question) {
				array_push($basic_header, $question->question);
				array_push($question_sequence, $question->sequence);
			}

			$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
            $file = urlencode(stripslashes($event_name));
            
			//echo header
			header("Content-type: application/x-msdownload"); 
			header("Content-Disposition: attachment; filename=".$file."_".$today.".csv"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 	
			echo implode($s, $basic_header) . "\r\n";

			//echo data
			if ($participants) {
				foreach ($participants as $participant) {
					echo $participant->id
                    . $s . $participant->date
                    . $s . $participant->reg_type
                    . $s . $participant->lname
					. $s . $participant->fname;
                    
                    $attendee_array = unserialize($participant->attendees);
                    if ( count($attendee_array)>"0"){
                                $attendee_names='"';
                                $i = 0;
                                 do {
                                    $attendee_names .= $attendee_array[$i]["first_name"]." ".$attendee_array[$i]['last_name'].', ';
                                    
                                   
                                 ++$i;
                                 } while ($i < count($attendee_array));
                                  $attendee_names .='"';
                            }
                    
					echo   $s . $attendee_names
					. $s . $participant->email
					. $s . $participant->address
					. $s . $participant->city
					. $s . $participant->state
					. $s . $participant->zip
					. $s . $participant->phone
                    . $s . $participant->quantity
					. $s . $participant->payment
                    . $s;
                    
                    $ticket_order = unserialize($participant->tickets);
                    
                   $row_count = count($ticket_order);
                   echo "||";
                                    for ($row = 0; $row < $row_count; $row++) {
                                       echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."||";
                                       } 
					$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on " .
							"q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");
	
					foreach($answers as $answer) {
						echo $s . $answer->answer;
					}
	
					echo "\r\n";
				}
			} else {
				echo "<tr><td>";
                _e('No participant data has been collected.','evr_language');
                echo "</td></tr>";
			}


		
			$filename = $event_name."-Attendees_".date("Y-m-d_H-i",time());
			print $csv_output;
			exit;
	break;
	
	
	case "payment";
			$st = "";
			$et = "\t";
			$s = $et . $st;
			$file = urlencode(stripslashes($event_name));
			$filename = $file."-Payments_". $today . ".xls";
            $participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id' ORDER BY lname DESC");
	
			$basic_header = array('Participant ID', 'Name (Last, First)', 'Email', 'Order Total', 'Order Detail', 'Balance Due',  'Payment Details' );
			
		
		  header("Content-Disposition: attachment; filename=\"$filename\"");
		  header("Content-Type: application/vnd.ms-excel");
		  header("Pragma: no-cache"); 
		  header("Expires: 0"); 

			//echo header
			echo implode($s, $basic_header) . $et . "\r\n";

        if ($participants) {
				 foreach ($participants as $participant) 
                 {
    				$participant_id = $participant->id;
                    $first_name =$participant->fname;
                    $last_name =$participant->lname;
                    $name = $last_name.", ".$first_name;
                    $email = $participant->email;
                    $num_people = $participant->quantity;
                    $total_due = $participant->payment;
                    
                    
                  
                     $sql2= "SELECT SUM(mc_gross) FROM $events_payment_tbl WHERE payer_id='$participant_id'";
                    				$result2 = mysql_query($sql2);
                    	
                    				while($row = mysql_fetch_array($result2)){
                    					$total_paid =  $row['SUM(mc_gross)'];
                                       	}
                         $balance = "0";
                         if ($total_due >"0"){$balance = ($total_due-$total_paid);
                         }  
                         
                          echo $participant_id
            					. $s . $name
            					. $s . $email
                                . $s . $total_due
                                . $s;
                          $ticket_order = unserialize($participant->tickets);
                    
                   $row_count = count($ticket_order);
                   echo "||";
                                    for ($row = 0; $row < $row_count; $row++) {
                                       echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."||";
                                       }       
                      echo $s . $balance .$s;    			
                    //$sql = "SELECT * from $events_payment_tbl WHERE payer_id = '$participant_id' AND item_number = '$event_id'";
        			$payments = $wpdb->get_results("SELECT * from $events_payment_tbl WHERE payer_id = '$participant_id'");
                    //$result = mysql_query($sql);
                    //while ($row = mysql_fetch_assoc ($result))
        			if ($payments){ 
        			  foreach ($payments as $payment){
                            
                                echo  $payment->mc_currency." ".$payment->mc_gross." ".$payment->txn_type." ".$payment->txn_id." (".$payment->payment_date.")";
                                }}
                                else { _e('No Payments Received!','evr_language');}
                    
                    
                    
                     
                    
            					echo $et . "\r\n"; 
                    }
                    
                }
                                        
            
                              
            
              
              else 
              {
				_e('No Attendees Have Registered','evr_language');
              }
              
			exit;
	break;
	
	
	default:
	_e('This Is Not A Valid Selection!','evr_language');
}
}

else {_e('Report Folder configuration is not correct, please email consultant@avdude.com for configuration assistance.','evr_language');}

?>