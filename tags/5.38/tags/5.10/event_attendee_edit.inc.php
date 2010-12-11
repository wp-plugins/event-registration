<?php
function attendee_display_edit() {
er_plugin_menu();
    $er_attendee_action = $_REQUEST ['action'];
    global $wpdb, $events_lang,$events_lang_flag;
    $events_detail_tbl = get_option ( 'events_detail_tbl' );
    $events_attendee_tbl = get_option ( 'events_attendee_tbl' );
  ?>  
<div id="event_reg_theme" class="wrap">
<h2>Manage Attendees</h2>

<div style="float:left; margin-right:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"];?>">
    <input type="hidden" name="action" value="">
    <input class="button-primary" type="submit" name="Submit" value="SELECT EVENT"/>
  </form>
</div> 
<div style="clear:both;"></div><hr /><div style="clear:both;">
    <?php
    
    switch ($er_attendee_action){
        case "view":
            $event_id = $_REQUEST['event'];
            $sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$event_id'";
    		$result = mysql_query ( $sql );
    		while ( $row = mysql_fetch_assoc ( $result ) ) {
    		     $event_id = $row ['id'];
			     $event_name = $row ['event_name'];
			     $event_desc = $row ['event_desc'];
                 $reg_limit = $row ['reg_limit'];
                 if ($reg_limit == ''){$reg_limit = 999;}
                 if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "Unlimited";}
                 }
  		$sql2= "SELECT SUM(num_people) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
		$result2 = mysql_query($sql2);
		while($row = mysql_fetch_array($result2)){$num =  $row['SUM(num_people)'];};
           ?>   <h3>Attendee Listing For <?php echo $event_name;?>  - <?php 
           if ($num !=""){echo "<font color='green'>".$num."/".$available_spaces." Attendees</font>";}
           else {echo "<font color='red'>No Attendees</font>";}
           ?>
     </h3>
                <table class="widefat">
                <thead>
                <tr><th># People</th><th>Name </th><th>Email</th><th>Phone</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php

            $sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
            $result = mysql_query ( $sql );
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
    			$num_people = $row ['num_people'];
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
		        echo "<tr><td>".$num_people."</td><td align='left'>" . $lname . ", " . $fname . "</td><td>" . $email . "</td><td>" . $phone . "</td>";
		        echo "<td>";
                ?>
                <a href="<?php echo request_uri()."&action=edit&event=".$event_id."&attendee=".$id; ?>">EDIT</a>  |
                <a href="<?php echo request_uri()."&action=delete&event=".$event_id."&attendee=".$id; ?>" 
                ONCLICK="return confirm('Are you sure you want to delete attendee <?php echo $fname." ".$lname;?>?')">DELETE</a></td> </tr>
                <?php   }  
            echo "</table>";
            ?>
            
            <br />
            <div style="clear:both;"></div>
            <button style="background-color: lightgreen"  onclick="window.location='<?php echo ER_PLUGINFULLURL . "event_registration_export.php?id=" . $event_id . "&action=excel";?>'">Export Excel</button>
            <button style="background-color: lightgreen" onclick="window.location='<?php echo ER_PLUGINFULLURL . "event_registration_export.php?id=" . $event_id. "&action=csv";?>'" style="width:180; height: 30">Export CSV</button>            
<?php
    	
        break;
        
        case "edit":
        		$event_id = $_REQUEST['event'];
				$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='" . $event_id . "'";
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
				
				$attendee_id = $_REQUEST ['attendee'];
				$sql = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$attendee_id'";
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
					$num_people = $row ['num_people'];
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
				?>
                <div class="metabox-holder">
                <div class="postbox">
                <h3>Edit Attendee Information: <?php echo $fname." ".$lname; ?></h3>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
                <input type="hidden" name="event" value="<?php echo $event_id; ?>">
                <input type="hidden" name="attendee" value="<?php echo $attendee_id; ?>">
                <input type="hidden" name="action" value="post">
                <ul>
                <?php
				echo "<table><tr><td width='25'></td><td align='left'><hr>";
				echo "<form method='post' action='" . $_SERVER ['REQUEST_URI'] . "'>";
				echo "<p><b>".$events_lang['firstName'].":";
				echo "<input tabIndex=\"1\" maxLength=\"45\" size=\"47\" name=\"fname\" value=\"$fname\"></b>";
				echo "<b>".$events_lang['lastName'].":";
				echo "<input tabIndex=\"2\" maxLength=\"45\" size=\"47\" name=\"lname\" value=\"$lname\"></b></p>";
				
				echo "<b>".$events_lang['address'].":";
				echo "<input tabIndex=\"5\" maxLength=\"45\" size=\"49\" name=\"address\" value=\"$address\"></b>" . BR;
				
				echo "<b>".$events_lang['city'].":";
				echo "<input tabIndex=\"6\" maxLength=\"20\" size=\"33\" name=\"city\" value=\"$city\"></b>";
				
				if ($events_lang_flag!='de')
				{
					echo "<b>".$events_lang['state'].":";
					echo "<input tabIndex=\"7\" maxLength=\"30\" size=\"18\" name=\"state\"	value=\"$state\"></b>";
				}
				echo "<b>".$events_lang['zip'].":";
				echo "<input tabIndex=\"8\" maxLength=\"10\" size=\"16\" name=\"zip\" value=\"$zip\"></b>" . BR;
				
				echo "<b>".$events_lang['email'].":";
				echo "<input tabIndex=\"3\" maxLength=\"37\" size=\"37\" name=\"email\" value=\"$email\"></b>" . BR;
				
				echo "<b>".$events_lang['phone'].":";
				
				echo "<input tabIndex=\"4\" maxLength=\"15\" size=\"28\" name=\"phone\" value=\"$phone\"></b>" . BR;
						
				echo "<b>".$events_lang['people'].":";
				
				echo "<input tabIndex=\"5\" maxLength=\"15\" size=\"4\" name=\"num_people\" value=\"$num_people\"></b>" . BR;	
				/* <b>How did you hear about this event?</b></font><font face="Arial">&nbsp;
												<select tabIndex="9" size="1" name="hear">
																<option value ="<?php echo $hear;?>" selected><?php echo $hear;?></option>
																<option value="Website">Website</option>
																<option value="A Friend">A Friend</option>
																<option value="Brochure">A Brochure</option>
																<option value="Announcment">An Announcment</option>
																<option value="Other">Other</option>
																</select></font><br />
																
        if ($events_lang_flag!='de')
        {
  				echo "<b>$events_lang[payPlan]</b>";
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

<?php 
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
			
				if ($questions) {
					for($i = 0; $i < count ( $questions ); $i ++) {
						
						echo "<p><b>" . $questions [$i]->question . "</b>";
						
						$question_id = $questions [$i]->id;
						$query = "SELECT * FROM $events_answer_tbl WHERE registration_id = '$id' AND question_id = '$question_id'";
						$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
						while ( $row = mysql_fetch_assoc ( $result ) ) {
							$answers = $row ['answer'];
							
						}
						event_form_build_edit ( $questions [$i], $answers );
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
</table></ul></div><div>
<?php
			
		
        
        
        break;
        
        case "post";
				$id = $_POST ['attendee'];
                $event_id = $_POST['event'];
				
				$fname = $_POST ['fname'];
				$lname = $_POST ['lname'];
				$address = $_POST ['address'];
				$city = $_POST ['city'];
				$state = $_POST ['state'];
				$zip = $_POST ['zip'];
				$phone = $_POST ['phone'];
				$email = $_POST ['email'];
				$hear = $_POST ['hear'];
				$num_people = $_POST ['num_people'];
				$event_id = $_POST ['event_id'];
				$payment = $_POST ['payment'];
				
				$sql = "UPDATE " . $events_attendee_tbl . " SET fname='$fname', lname='$lname', address='$address', city='$city', 
                state='$state', zip='$zip', phone='$phone', email='$email', payment='$payment', hear='$hear', 
                num_people='$num_people' WHERE id ='$id'";
				$wpdb->query ( $sql );
                echo "<div id='message' class='updated fade'><p><strong>
                The basic attendee information has been successfully updated.  Now updating additional question information.</strong></p></div>";
                
 			// Insert Extra From Post Here
            	$events_question_tbl = get_option ( 'events_question_tbl' );
            	$events_answer_tbl = get_option ( 'events_answer_tbl' );
            	$reg_id = $id;
            	
            	$questions = $wpdb->get_results ( "SELECT * from `$events_question_tbl` where event_id = '$event_id'" );
            	if ($questions) {
            		foreach ( $questions as $question ) {
            			switch ($question->question_type) {
            				case "TEXT" :
            				case "TEXTAREA" :
            				case "DROPDOWN" :
            					$post_val = $_POST [$question->question_type . '_' . $question->id];
            					$sql = "UPDATE " . $events_answer_tbl . " SET answer='$post_val' WHERE registration_id = '$reg_id' 
                                AND question_id ='$question->id'";
            					$wpdb->query ($sql);
            					break;
            				case "SINGLE" :
            					$post_val = $_POST [$question->question_type . '_' . $question->id];
            					$sql = "UPDATE " . $events_answer_tbl . " SET answer='$post_val' WHERE registration_id = '$reg_id' 
                                AND question_id ='$question->id'";
            					$wpdb->query ($sql);
            					break;
            				case "MULTIPLE" :
            					$value_string = '';
            					for ($i=0; $i<count($_POST[$question->question_type.'_'.$question->id]); $i++){ 
            					//$value_string = $value_string +","+ ($_POST[$question->question_type.'_'.$question->id][$i]); 
            					$value_string .= $_POST[$question->question_type.'_'.$question->id][$i].","; 
            					}
            					echo "Value String - ".$value_string;
            					/*$values = explode ( ",", $question->response );
            					$value_string = '';
            					foreach ( $values as $key => $value ) {
            						$post_val = $_POST [$question->question_type . '_' . $question->id . '_' . $key];
            						if ($key > 0 && ! empty ( $post_val )) $value_string .= ',';
            						$value_string .= $post_val;
            					}*/
            					$sql = "UPDATE " . $events_answer_tbl . " SET answer='$value_string' WHERE registration_id = '$reg_id' 
                                AND question_id ='$question->id'";
            					$wpdb->query ($sql);
            					
            					break;
            			}
            		}
            	}
                echo "<div id='message' class='updated fade'><p><strong>
                The attendee information has been successfully updated.</strong></p></div>";
                echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=attendees&action=view&event=".$event_id."'>";
   
        break;
        
        
        case "delete":
            	$attendee = $_REQUEST ['attendee'];
                $event = $_REQUEST['event'];
				$sql = " DELETE FROM " . $events_attendee_tbl . " WHERE id ='$attendee'";
				$wpdb->query ( $sql );
                echo "<div id='message' class='updated fade'><p><strong>
                The attendee information has been successfully deleted from the event.</strong></p></div>";
                echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=attendees&action=view&event=".$event."'>";
			
		 
        break;
        default:
        
        	global $wpdb;
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$current_event = get_option ( 'current_event' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	define ( "EVNT_RGR_PLUGINPATH", "/" . plugin_basename ( dirname ( __FILE__ ) ) . "/" );
	define ( "EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );
	$url = EVNT_RGR_PLUGINFULLURL;
	
	//$this->wp_content_dir.'/plugins/'.plugin_basename(dirname(__FILE__)); » TO $plugin_path = dirname(__FILE__);
	?>   <h3>Event Listing</h3>
                <table class="widefat">
                <thead>
                <tr><th>Event</th><th>Attendees</th><th>Identifier</th><th>Description</th></tr>
                </thead>
                <tbody>
                <?php

	$sql = "SELECT * FROM " . $events_detail_tbl;
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
        $event_desc = $row['event_desc'];
        $reg_limit = $row ['reg_limit'];
        if ($reg_limit == ''){$reg_limit = 999;}
        if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "Unlimited";}
                 
  		$sql2= "SELECT SUM(num_people) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2)){$num =  $row2['SUM(num_people)'];}
		echo "<tr><td><a href='".request_uri()."&action=view&event=".$event_id."'>".$event_name."</a></td><td>";
        if ($num !=""){echo "<font color='green'>".$num."/".$available_spaces." Attendees</font>";}
           else {echo "<font color='red'>No Attendees</font>";}
        echo "</td><td>".$event_identifier."</td><td>".$event_desc."</td></tr>";
        
        
       
	}
	echo "</table>";
        break;
}

}
?>