<?php
function attendee_display_edit() {

	function event_list_attendees() {
		//Displays attendee information from current active event.
		global $wpdb, $lang,$lang_flag;
		$events_detail_tbl = get_option ( 'events_detail_tbl' );
		$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
		define ( "EVNT_RGR_PLUGINPATH", "/" . plugin_basename ( dirname ( __FILE__ ) ) . "/" );
		define ( "EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );
		$url = EVNT_RGR_PLUGINFULLURL;
		if ($_REQUEST ['event_id'] != "") {
			$view_event = $_REQUEST ['event_id'];
		}
		if ($_REQUEST ['view_event'] != "") {
			$view_event = $_REQUEST ['view_event'];
		}
		
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$view_event'";
		$result = mysql_query ( $sql );
		while ( $row = mysql_fetch_assoc ( $result ) ) {
			$event_id = $row ['id'];
			$event_name = $row ['event_name'];
			$event_desc = $row ['event_desc'];
			$event_description = $row ['event_desc'];
			$identifier = $row ['event_identifier'];
			$cost = $row ['event_cost'];
			$checks = $row ['allow_checks'];
			$active = $row ['is_active'];
			$question1 = $row ['question1'];
			$question2 = $row ['question2'];
			$question3 = $row ['question3'];
			$question4 = $row ['question4'];
		}
		
		$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$view_event'";
		$result = mysql_query ( $sql );
		echo "<hr><p><b>Current Attendee List is from: " . $event_name . " - " . $identifier . "</b></p>";
		?>
<button style="background-color: lightgreen"
	onclick="window.location='<?php
		echo $url . "event_registration_export.php?id=" . $view_event . "&action=excel";
		?>'"
	style="width:180; height: 30">Export Current Attendee List To Excel</button>
<button style="background-color: lightgreen"
	onclick="window.location='<?php
		echo $url . "event_registration_export.php?id=" . $view_event . "&action=csv";
		?>'"
	style="width:180; height: 30">Export Current Attendee List To CSV</button>
<br>
<hr>
<?php
		echo "<table>";
		echo "<tr><td width='15'></td><td> ID </td><td> Name </td><td> Email </td><td width='15'>City</td><td>State </td><td> Phone </td>
						<td></td><td> </td><tr>";
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
			$txn_id = $row ['txn_id'];
			$amt_pd = $row ['amount_pd'];
			$date_pd = $row ['paydate'];
			$event_id = $row ['event_id'];
			$custom1 = $row ['custom_1'];
			$custom2 = $row ['custom_2'];
			$custom3 = $row ['custom_3'];
			$custom4 = $row ['custom_4'];
			
			echo "<tr><td width='15'></td><td>" . $id . "</td><td align='left'>" . $lname . ", " . $fname . "</td><td>" . $email . "</td><td width='15'>
									" . $city . "</td><td>" . $state . "</td><td>" . $phone . "</td>";
			echo "<td>";
			echo "<form name='form' method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
			echo "<input type='hidden' name='display_action' value='view_list'>";
			echo "<input type='hidden' name='view_event' value='" . $view_event . "'>";
			echo "<input type='hidden' name='form_action' value='edit_attendee'>";
			echo "<input type='hidden' name='id' value='" . $id . "'>";
			// echo "<input type='SUBMIT' style='background-color:yellow' value='EDIT RECORD' ONCLICK=\"return confirm('Are you sure you want to edit record for ".$fname." ".$lname."?')\"></form>";
			echo "<input type='SUBMIT' style='background-color:yellow' value='EDIT RECORD'></form>";
			echo "</td><td>";
			
			echo "<form name='form' method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
			echo "<input type='hidden' name='form_action' value='edit_attendee'>";
			echo "<input type='hidden' name='display_action' value='view_list'>";
			echo "<input type='hidden' name='attendee_action' value='delete_attendee'>";
			echo "<input type='hidden' name='view_event' value='" . $view_event . "'>";
			echo "<input type='hidden' name='id' value='" . $id . "'>";
			echo "<input type='SUBMIT' style='background-color:pink' value='DELETE' ONCLICK=\"return confirm
										('Are you sure you want to delete record for " . $fname . " " . $lname . "-ID" . $id . "?')\"></form>
									</td></tr>";
		}
		echo "</table>";
	}

	function edit_attendee_record() {
		global $wpdb;
		$events_detail_tbl = get_option ( 'events_detail_tbl' );
		$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
		
		if ($_REQUEST ['event_id'] != "") {
			$view_event = $_REQUEST ['event_id'];
		}
		if ($_REQUEST ['view_event'] != "") {
			$view_event = $_REQUEST ['view_event'];
		}
		
		if ($_REQUEST ['form_action'] == 'edit_attendee') {
			
			if ($_REQUEST ['attendee_action'] == 'delete_attendee') {
				$id = $_REQUEST ['id'];
				$sql = " DELETE FROM " . $events_attendee_tbl . " WHERE id ='$id'";
				$wpdb->query ( $sql );
				//echo "<meta http-equiv='refresh' content='0'>";
			} 

			else if ($_REQUEST ['attendee_action'] == 'update_attendee') {
				
				$id = $_REQUEST ['id'];
				
				$regisration_id = $row ['id'];
				$fname = $_POST ['fname'];
				$lname = $_POST ['lname'];
				$address = $_POST ['address'];
				$city = $_POST ['city'];
				$state = $_POST ['state'];
				$zip = $_POST ['zip'];
				$phone = $_POST ['phone'];
				$email = $_POST ['email'];
				$hear = $_POST ['hear'];
				$event_id = $_POST ['event_id'];
				$payment = $_POST ['payment'];
				$custom_1 = $_POST ['custom_1'];
				$custom_2 = $_POST ['custom_2'];
				$custom_3 = $_POST ['custom_3'];
				$custom_4 = $_POST ['custom_4'];
				
				$sql = "UPDATE " . $events_attendee_tbl . " SET fname='$fname', lname='$lname', address='$address', city='$city', state='$state',
								   	zip='$zip', phone='$phone', email='$email', payment='$payment', hear='$hear', custom_1='$custom_1', custom_2='$custom_2',
								   	custom_3='$custom_3', custom_4='$custom_4' WHERE id ='$id'";
				$wpdb->query ( $sql );
				echo "<p>basic is added </p>";
				//echo "<meta http-equiv='refresh' content='0'>";
				

				// Insert Extra From Post Here
				$events_question_tbl = get_option ( 'events_question_tbl' );
				$events_answer_tbl = get_option ( 'events_answer_tbl' );
				$reg_id = $id;
				$wpdb->query ( "DELETE FROM $events_answer_tbl where registration_id = '$reg_id'" );
				
				$questions = $wpdb->get_results ( "SELECT * from `$events_question_tbl` where event_id = '$event_id'" );
				
				if ($questions) {
					foreach ( $questions as $question ) {
						switch ($question->question_type) {
							case "TEXT" :
							case "TEXTAREA" :
							case "SINGLE" :
								$post_val = $_POST [$question->question_type . '-' . $question->id];
								$wpdb->query ( "INSERT into $events_answer_tbl (registration_id, question_id, answer)
					values ('$reg_id', '$question->id', '$post_val')" );
								break;
							case "MULTIPLE" :
								$values = explode ( ",", $question->response );
								$value_string = '';
								foreach ( $values as $key => $value ) {
									$post_val = $_POST [$question->question_type . '-' . $question->id . '-' . $key];
									if ($key > 0 && ! empty ( $post_val )) $value_string .= ',';
									$value_string .= $post_val;
								}
								$wpdb->query ( "INSERT into $events_answer_tbl (registration_id, question_id, answer)
					values ('$reg_id', '$question->id', '$value_string')" );
								
								break;
						}
					}
				}
			
			} else {
				
				$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='" . $view_event . "'";
				$result = mysql_query ( $sql );
				while ( $row = mysql_fetch_assoc ( $result ) ) {
					$event_id = $row ['id'];
					$event_name = $row ['event_name'];
					$event_desc = $row ['event_desc'];
					$event_description = $row ['event_desc'];
					$identifier = $row ['event_identifier'];
					$cost = $row ['event_cost'];
					$checks = $row ['allow_checks'];
					$active = $row ['is_active'];
					$question1 = $row ['question1'];
					$question2 = $row ['question2'];
					$question3 = $row ['question3'];
					$question4 = $row ['question4'];
				}
				
				$id = $_REQUEST ['id'];
				$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
				$result = mysql_query ( $sql );
				while ( $row = mysql_fetch_assoc ( $result ) ) {
					$id = $row ['id'];
					$regisration_id = $row ['id'];
					$lname = $row ['lname'];
					$fname = $row ['fname'];
					$address = $row ['address'];
					$city = $row ['city'];
					$state = $row ['state'];
					$zip = $row ['zip'];
					$email = $row ['email'];
					$hear = $row ['hear'];
					$payment = $row ['payment'];
					$phone = $row ['phone'];
					$date = $row ['date'];
					$paystatus = $row ['paystatus'];
					$txn_type = $row ['txn_type'];
					$txn_id = $row ['txn_id'];
					$amt_pd = $row ['amount_pd'];
					$date_pd = $row ['paydate'];
					$event_id = $row ['event_id'];
					$custom_1 = $row ['custom_1'];
					$custom_2 = $row ['custom_2'];
					$custom_3 = $row ['custom_3'];
					$custom_4 = $row ['custom_4'];
				}
				
				echo "<table><tr><td width='25'></td><td align='left'><hr>";
				echo "<form method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
				
				echo "<p><b>$lang[firstName] ";
				echo "<input tabIndex=\"1\" maxLength=\"45\" size=\"47\" name=\"fname\" value=\"$fname\"></b>";
				echo "<b>$lang[lasttName] ";
				echo "<input tabIndex=\"2\" maxLength=\"45\" size=\"47\" name=\"lname\" value=\"$lname\"></b></p>";
				
				echo "<b>$lang[address]:&nbsp;";
				echo "<input tabIndex=\"5\" maxLength=\"45\" size=\"49\" name=\"address\" value=\"$address\"></b>" . BR;
				
				echo "<b>$lang[city]:";
				echo "<input tabIndex=\"6\" maxLength=\"20\" size=\"33\" name=\"city\" value=\"$city\"></b>";
				
				if ($lang_flag!='de')
				{
					echo "<b>$lang[state]:";
					echo "<input tabIndex=\"7\" maxLength=\"30\" size=\"18\" name=\"state\"	value=\"$state\"></b>";
				}
				echo "<b>$lang[zip]:";
				echo "<input tabIndex=\"8\" maxLength=\"10\" size=\"16\" name=\"zip\" value=\"$zip\"></b>" . BR;
				
				echo "<b>$lang[email]:";
				echo "<input tabIndex=\"3\" maxLength=\"37\" size=\"37\" name=\"email\" value=\"$email\"></b>" . BR;
				
				echo "<b>$lang[phone]:";
				
				echo "<input tabIndex=\"4\" maxLength=\"15\" size=\"28\" name=\"phone\" value=\"$phone\"></b>" . BR;
				
				/* <b>How did you hear about this event?</b></font><font face="Arial">&nbsp;
												<select tabIndex="9" size="1" name="hear">
																<option value ="<?php echo $hear;?>" selected><?php echo $hear;?></option>
																<option value="Website">Website</option>
																<option value="A Friend">A Friend</option>
																<option value="Brochure">A Brochure</option>
																<option value="Announcment">An Announcment</option>
																<option value="Other">Other</option>
																</select></font><br />
																*/
        if ($lang_flag!='de')
        {
  				echo "<b>$lang[payPlan]</b>";
        }
				?>
<select tabIndex="10" size="1" name="payment">
	<option value="=" <?php
				echo $payment;
				?>" selected><?php
				echo $payment;
				?></option>
	<option value="Paypal">Credit Card or Paypal</option>
	<option value="Cash">Cash</option>
	<option value="Check">Check</option>
</select>
</font>
<br />

<?php /*
									            if ($question1 != ""){ ?>
												<p align="left"><b>
												<?php echo $question1; ?><input  tabIndex="11" size="33" name="custom_1" value="<?php echo $custom_1;?>"> </b></p>
												<?php } 
									
												if ($question2 != ""){ ?>
												<p align="left"><b>
												<?php echo $question2; ?><input  tabIndex="12" size="33" name="custom_2" value="<?php echo $custom_2;?>"> </b></p>
												<?php } 
									
									            if ($question3 != ""){ ?>
												<p align="left"><b>
												<?php echo $question_3; ?><input tabIndex="13" size="33" name="custom_3" value="<?php echo $custom_3;?>"> </b></p>
												<?php }
									
									            if ($question4 != ""){ ?>
												<p align="left"><b>
												<?php echo $question4; ?><input  tabIndex="14" size="33" name="custom_4" value="<?php echo $custom_4;?>"> </b></p>
												<?php } 
												
												*/
				$events_question_tbl = get_option ( 'events_question_tbl' );
				$events_answer_tbl = get_option ( 'events_answer_tbl' );
				
				$questions = $wpdb->get_results ( "SELECT * from `$events_question_tbl` where event_id = '$event_id' order by sequence" );
				
				/* $answers = $wpdb->get_results("SELECT a.answer from $events_answer_tbl a " 
				. "inner join $events_question_tbl q on a.question_id = q.id " 
				. "where a.registration_id = $registration_id " 
				. "order by q.sequence"); 
*/
				
				if ($questions) {
					for($i = 0; $i < count ( $questions ); $i ++) {
						
						echo "<p><b>" . $questions [$i]->question . "</b>".BR;
						
						$question_id = $questions [$i]->id;
						$query = "SELECT * FROM $events_answer_tbl WHERE registration_id = '$id' AND question_id = '$question_id'";
						$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
						while ( $row = mysql_fetch_assoc ( $result ) ) {
							$answers = $row ['answer'];
						}
						
						event_form_build ( $questions [$i], $answers );
						echo "</p>";
					
					}
				}
				
				echo "<input type='hidden' name='id' value='" . $id . "'>";
				echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
				echo "<input type='hidden' name='display_action' value='view_list'>";
				echo "<input type='hidden' name='view_event' value='" . $view_event . "'>";
				echo "<input type='hidden' name='form_action' value='edit_attendee'>";
				echo "<input type='hidden' name='attendee_action' value='update_attendee'>";
				?>
<p><input type="submit" name="Submit" value="UPDATE RECORD"></p>
</form>
<hr />
</td>
</tr>
</table>
<?php
			
			}
		}
	
	}
	
	edit_attendee_record ();
	event_list_attendees ();
}
?>