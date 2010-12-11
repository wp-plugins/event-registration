<?php

/**
 * @author Edge Technology Consulting
 * @copyright 2009
 */

//This runs the Additional Questions Admin Page

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

<form name="newquestion" method="post" action="<?php request_uri();?>"><input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
	<table width="100%" cellspacing="2" cellpadding="5">
	<tr valign="top">
	<th width="33%" scope="row">Question:</th>
	<td><input name="question" type="text" id="question" size="50" value="" /></td>
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
				
	<?php		echo "<p><form name='form' method='post' action='";
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
<META HTTP-EQUIV="refresh" content="0;URL=<?php request_uri();?>admin.php?page=form&event_id=<?php echo $event_id . "&event_name=" . $event_name;?>">
<?php			
		break;
		
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
		
?>

<META HTTP-EQUIV="refresh" content="0;URL=<?php request_uri();?>admin.php?page=form&event_id=<?php echo $event_id . "&event_name=" . $event_name;?>">

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
?>

<META HTTP-EQUIV="refresh" content="0;URL=<?php request_uri();?>admin.php?page=form&event_id=<?php echo $event_id . "&event_name=" . $event_name;?>">

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
			
			echo "<hr />";

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

?>