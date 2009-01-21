<?
/** Define ABSPATH as the root directory */
define( 'ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/' );

error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);

if ( file_exists( ABSPATH . 'wp-config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'wp-config.php' );

} elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) ) {

	/** The config file resides one level below ABSPATH */
	require_once( dirname(ABSPATH) . '/wp-config.php' );
} 

global $wpdb;

$id= $_REQUEST['id'];
$events_attendee_tbl = $_REQUEST['atnd'];
$today = date("Y-m-d_Hi",time()); 

$events_answer_tbl = get_option('events_answer_tbl');
$events_question_tbl = get_option('events_question_tbl');
$events_detail_tbl = get_option('events_detail_tbl');
$current_event = get_option('current_event');
$events_attendee_tbl = get_option('events_attendee_tbl');
$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$id'";
$result = mysql_query($sql);
list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $allow_checks, $is_active) = mysql_fetch_array($result, MYSQL_NUM);


switch ($_REQUEST['action']) {
	case "excel";
				$st = "";
			$et = "\t";
			$s = $et . $st;
	
			$basic_header = array('Reg ID', 'Last Name', 'First Name', 'Email', 'Address', 
					'City', 'State', 'Zip', 'Phone', 'Payment Method', 'Reg Date');
			$question_sequence = array();
			
	//	$questions = $wpdb->get_results("SELECT * from `$events_question_tbl` where event_id = '$event_id' order by sequence");
			$questions = $wpdb->get_results("select question, sequence from ".$events_question_tbl." where event_id = '$event_id' order by sequence");
			foreach ($questions as $question) {
				array_push($basic_header, $question->question);
				array_push($question_sequence, $question->sequence);
			}

			$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
			$filename = $event_name."-Attendees_". $today . ".xls";
		
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
					. $s . $participant->lname
					. $s . $participant->fname
					. $s . $participant->email
					. $s . $participant->address
					. $s . $participant->city
					. $s . $participant->state
					. $s . $participant->zip
					. $s . $participant->phone
					. $s . $participant->payment
					. $s . $participant->date;
					$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on " .
							"q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");
	
					foreach($answers as $answer) {
						echo $s . $answer->answer;
					}
	
					echo $et . "\r\n";
				}
			} else {
				echo "<tr><td>No participant data has been collected.</td></tr>";
			}
			exit;
	break;

	case "csv";
			$st = "";
			$et = ",";
			$s = $et . $st;
	
			$basic_header = array('Reg ID', 'Last Name', 'First Name', 'Email', 'Address', 
					'City', 'State', 'Zip', 'Phone', 'Payment Method', 'Reg Date');
			$question_sequence = array();
			$questions = $wpdb->get_results("select question, sequence from ".$events_question_tbl." where event_id = '$event_id' order by sequence");
			foreach ($questions as $question) {
				array_push($basic_header, $question->question);
				array_push($question_sequence, $question->sequence);
			}

			$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
			//echo header
			header("Content-type: application/x-msdownload"); 
			header("Content-Disposition: attachment; filename=".$event_name."_".$today.".csv"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 	
			echo implode($s, $basic_header) . "\r\n";

			//echo data
			if ($participants) {
				foreach ($participants as $participant) {
					echo $participant->id
					. $s . $participant->lname
					. $s . $participant->fname
					. $s . $participant->email
					. $s . $participant->address
					. $s . $participant->city
					. $s . $participant->state
					. $s . $participant->zip
					. $s . $participant->phone
					. $s . $participant->payment
					. $s . $participant->date;
					$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on " .
							"q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");
	
					foreach($answers as $answer) {
						echo $s . $answer->answer;
					}
	
					echo "\r\n";
				}
			} else {
				echo "<tr><td>No participant data has been collected.</td></tr>";
			}


		
			$filename = $event_name."-Attendees_".date("Y-m-d_H-i",time());
			print $csv_output;
			exit;
	break;
	
	
	case "payment";
			$st = "";
			$et = "\t";
			$s = $et . $st;
			
			
	
			$basic_header = array('Reg ID', 'Last Name', 'First Name', 'Email', 'Phone', 'Payment Method', 'Reg Date', 'Pay Status', 'Type of Payment', 'Transaction ID', 'Payment', 'Date Paid' );
			$question_sequence = array();
			

			$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
			$filename = $event_name."-Payments_". $today . ".xls";
		
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
					. $s . $participant->lname
					. $s . $participant->fname
					. $s . $participant->email
					. $s . $participant->phone
					. $s . $participant->payment
					. $s . $participant->date
					. $s . $participant->paystatus
					. $s . $participant->txn_type
					. $s . $participant->txn_id
					. $s . $participant->amount_pd
					. $s . $participant->paydate
					;
						
					echo $et . "\r\n";
				}
			} else {
				echo "<tr><td>No participant data has been collected.</td></tr>";
			}
			exit;
	break;
	
	
	default:
	echo "This Is Not A Valid Selection!";
}

?>