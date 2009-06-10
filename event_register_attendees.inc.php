<?php

function register_attendees($event_single_ID) {
	global $wpdb, $lang,$lang_flag;
	
	$paypal_cur = get_option ( 'paypal_cur' );
	if ($event_single_ID == ""){$event_id = $_REQUEST ['event_id'];}
	if ($event_single_ID != ""){
		extract( shortcode_atts( array('id' => '0'), $event_single_ID ) );
		echo $event_single_ID['id'];
		$event_id = $event_single_ID['id'];
		}
	
	$events_listing_type = get_option ( 'events_listing_type' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$events_listing_type = get_option ( 'events_listing_type' );
	
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$events_listing_type = $row ['events_listing_type'];
	}
	
	//Query Database for Active event and get variable
	

	if ($events_listing_type == 'single') {
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
	} else {
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id = $event_id";
	}
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_id = $row ['id'];
		$event_name = $row ['event_name'];
		$event_desc = $row ['event_desc'];
		$display_desc = $row ['display_desc'];
		$image = $row ['image_link'];
		$header = $row ['header_image'];
		$multiple = $row ['multiple'];
		$event_description = $row ['event_desc'];
		$identifier = $row ['event_identifier'];
		$event_cost = $row ['event_cost'];
		$event_location = $row ['event_location'];
		$more_info = $row ['more_info'];
		$custom_cur = $row ['custom_cur'];
		$checks = $row ['allow_checks'];
		$active = $row ['is_active'];
		$question1 = $row ['question1'];
		$question2 = $row ['question2'];
		$question3 = $row ['question3'];
		$question4 = $row ['question4'];
		$reg_limit = $row ['reg_limit'];
	}
	
	update_option ( "current_event", $event_name );
	//Query Database for Event Organization Info to email registrant BHC
	//$sql  = "SELECT * FROM wp_events_organization WHERE id='1'"; 
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	$result = mysql_query ( $sql );
	
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$org_id = $row ['id'];
		$Organization = $row ['organization'];
		$Organization_street1 = $row ['organization_street1'];
		$Organization_street2 = $row ['organization_street2'];
		$Organization_city = $row ['organization_city'];
		$Organization_state = $row ['organization_state'];
		$Organization_zip = $row ['organization_zip'];
		$contact = $row ['contact_email'];
		$registrar = $row ['contact_email'];
		$paypal_id = $row ['paypal_id'];
		$paypal_cur = $row ['currency_format'];
		$events_listing_type = $row ['events_listing_type'];
		$message = $row ['message'];
	}
	
	//get attendee count	
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );

	$sql= "SELECT SUM(num_people) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$num =  $row['SUM(num_people)'];
		};
	
	if ($header != ""){echo "<p align='center'><img src='".$header."'  width='450' align='center'></p>";}
	if ( $reg_limit > "$num" || $reg_limit == "") {
		echo "<p align='center'><b>".$lang['eventFormHeader'] . $event_name . "</b></p>";
		echo "<table width='100%'><td>";
		if ($display_desc == "Y") {
			echo "<td span='2'>" . $event_desc . "</td>";
		}
		echo "</table>";
		echo "<table width='500'><td>";
		if ($custom_cur == ""){if ($paypal_cur == "USD" || $paypal_cur == "") {$paypal_cur = "$";}			}
		if ($custom_cur != "" || $custom_cur != "USD"){$paypal_cur = $custom_cur;}
		if ($custom_cur == "USD") {$paypal_cur = "$";}
			
			
		if ($event_cost != "") {if ($lang_flag=='de')
				echo "<b>" . $event_name . " - Kosten " .$event_cost . " " .  $paypal_cur . "</b></p></p>";
      		else
			  	echo "<b>" . $event_name . " - Cost " . $paypal_cur . " " . $event_cost . "</b></p></p>";
			}
		
		?>
<?php //JavaScript for Registration Form Validation 

		?>
<SCRIPT>



function echeck(str) {
		var at="@"
		var dot="."
		var em = ""
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		    return false;
		    }

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		    return false;
		    
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		     return false;
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		      return false;
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		     return false;
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    return false;
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false;
		 }

 		 return true;					
}


function validateForm(form) { 
	
var msg = "";

if (form.fname.value == "") {  msg += "\n " +"Please enter your first name."; 
   		form.fname.focus( ); 
   	 }
if (form.lname.value == "") {  msg += "\n " +"Please enter your last name."; 
   		form.lname.focus( ); 
   		}
	
if (echeck(form.email.value)==false){
		msg += "\n " + "Email format not correct!";
		}
		
if (form.phone.value == "") {  msg += "\n " +"Please enter your phone number."; 
   		form.phone.focus( ); 
   		}
if (form.address.value == "") {  msg += "\n " +"Please enter your address."; 
   		form.address.focus( ); 
   		}
if (form.city.value == "") {  msg += "\n " +"Please enter your city."; 
   		form.city.focus( ); 
   		}  
 
if (form.state.value == "") { msg += "\n " + "Please enter your state."; 
   		form.state.focus( ); 
   	 }
if (form.zip.value == "") {  msg += "\n " +"Please enter your zip code."; 
   		form.zip.focus( ); 
   		 }
    
//Validate Extra Questions
function trim(s) {if (s) {return s.replace(/^\s*|\s*$/g,"");} return null;}
				
	var inputs = form.getElementsByTagName("input");
	var e;

//Start Extra Questions Check
	for( var i = 0, e; e = inputs[i]; i++ )
	{
		var value = e.value ? trim(e.value) : null;
	
		if (e.type == "text" && e.title && !value && e.className == "r")
		{msg += "\n " + e.title;}
		
	
	if ((e.type == "radio" || e.type == "checkbox") && e.className == "r") {
				var rd =""
				var controls = form.elements;
				function getSelectedControl(group) 
					{
					for (var i = 0, n = group.length; i < n; ++i)
						if (group[i].checked) return group[i];
						return null;
					}
				if (!getSelectedControl(controls[e.name]))
								{msg += "\n " + e.title;}
			} 
			

	}

	var inputs = form.getElementsByTagName("textarea");
	var e;
	
	//Start Extra TextArea Questions Check
	for( var i = 0, e; e = inputs[i]; i++ )
	{
		var value = e.value ? trim(e.value) : null;
		if (!value && e.className == "r")
		{msg += "\n " + e.title;}
	}
	var inputs = form.getElementsByTagName("select");
	var e;
	
	//Start Extra TextArea Questions Check
	for( var i = 0, e; e = inputs[i]; i++ )
	{
		var value = e.value ? trim(e.value) : null;
		if ((!value || value =='') && e.className == "r")
		{msg += "\n " + e.title;}
	}

if (msg.length > 0) {
			msg = "The following fields need to be completed before you can submit.\n\n" + msg;
			alert(msg);
			return false;
		}
	
	return true;   

}



</SCRIPT>

</td>
<tr>
	<td>
	<form method="post"
		action="<?php
		echo $_SERVER ['REQUEST_URI'];
		?>"
		onSubmit="return validateForm(this)">
	<p align="left"><b><?php
		echo $lang ['firstName'];
		?>: <br />
	<input tabIndex="1" maxLength="40" size="47" name="fname"></b></p>
	<p align="left"><b><?php
		echo $lang ['lastName'];
		?>:<br />
	<input tabIndex="2" maxLength="40" size="47" name="lname"></b></p>
	<p align="left"><b><?php
		echo $lang ['email'];
		?>:<br />
	<input tabIndex="3" maxLength="40" size="47" name="email"></b></p>
	<p align="left"><b><?php
		echo $lang ['phone'];
		?>:<br />
	<input tabIndex="4" maxLength="20" size="25" name="phone"></b></p>
	<p align="left"><b><?php
		echo $lang ['address'];
		?>:<br />
	<input tabIndex="5" maxLength="35" size="49" name="address"></b></p>
	<p align="left"><b><?php
		echo $lang ['city'];
		?>:<br />
	<input tabIndex="6" maxLength="25" size="35" name="city"> </b></p>
<?php
  //no state necessary in germany
  if ($lang_flag!="de")
  { 
  ?><p align="left"><b><?php
 echo $lang ['state'];
		?>:<br />
	<input tabIndex="7" maxLength="20" size="18" name="state"></b></p>
 <?php } ?>
	
	<p align="left"><b><?php
		echo $lang ['zip'];
		?>:<br />
	<input tabIndex="8" maxLength="10" size="15" name="zip"></b></p>
<?php
if ($multiple == "Y"){?>			
			
<p align="left"><b>	Additional attendees?
      <select name="num_people" style="width:70px;margin-top:4px">
        <option value="1" selected>None</option>
        <option value="2">1</option>
        <option value="3">2</option>
        <option value="4">3</option>
        <option value="5">4</option>
        <option value="6">5</option>
      </select>		
      </b></p>
      
      <?php
	  }
if ($multiple == "N"){?>
<input type="hidden" name="num_people" value="1"> 
<?php
}
		/*
			<p align="left"><b>How did you hear about this event?</b><br /><select tabIndex="9" size="1" name="hear">
			<option value="pick one" selected>pick one</option>
			<option value="Website">Website</option>
			<option value="A Friend">A Friend</option>
			<option value="Brochure">A Brochure</option>
			<option value="Announcment">An Announcment</option>
			<option value="Other">Other</option>
			</select></p>
			*/
		
			/* TODO IJ not for everyone nesseccary...
			if ($event_cost != "") {
			?>
			<p align="left">
			<b><?php echo $lang['payingPlan'];?></b><br />
	    <select tabIndex="10" size="1" name="payment">
		  <option value="pickone" selected><?php echo $lang['pickone']; ?></option>
			<?php
			if ($paypal_id != "") {
				echo "<option value=\"Paypal\">$lang[paypal]</option>";
			}
			
			echo "<option value=\"Cash\">$lang[cash]</option>";
			
			if ($checks == "yes" && $lang_flag!='de') {  //very unusual in germany
        echo "<option value=\"Check\">$lang[check]</option>";
			}
			?>
			</select></font></p>
			<?php
		} else {
			?><input type="hidden" name="payment" value="free event"><?
		}
*/
		/*
		
            if ($question1 != ""){ ?>
			<p align="left"><b><?php echo $question1; ?><input size="33" name="custom_1"> </b></p>
			<?php } else { ?><input type="hidden" name="custom1" value=""><?}

			if ($question2 != ""){ ?>
			<p align="left"><b><?php echo $question2; ?><input size="33" name="custom_2"> </b></p>
			<?php } else { ?><input type="hidden" name="custom2" value=""><?}

            if ($question3 != ""){ ?>
			<p align="left"><b><?php echo $question3; ?><input size="33" name="custom_3"> </b></p>
			<?php } else { ?><input type="hidden" name="custom3" value=""><?}

            if ($question4 != ""){ ?>
			<p align="left"><b><?php echo $question4; ?><input size="33" name="custom_4"> </b></p>
			<?php }  else { ?><input type="hidden" name="custom1" value=""><?}
			*/
		//This in the Form
		

		$events_question_tbl = get_option ( 'events_question_tbl' );
		$questions = $wpdb->get_results ( "SELECT * from `$events_question_tbl` where event_id = '$event_id' order by sequence" );
		if ($questions) {
			foreach ( $questions as $question ) {
				
				echo "<p align='left'><b>" . $question->question . BR;
				event_form_build ( $question );
				echo "</b></p>";
			}
		}
		
		?>


		<input type="hidden" name="regevent_action" value="post_attendee"> <input
		type="hidden" name="event_id" value="<?php
		echo $event_id;
		?>">
	<p align="center"><input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>"> <font
		color="#FF0000"><b><?php echo $lang['submitHint'];?></b></font>
	
	</form>
	</td>
</tr>
</table>
</body>
<?php
	} else {
		echo $lang ['maxAttendeesInfo'];
		echo "<p>Current Number of Attendees: " . $num . "</p>";
	}
}

function add_attendees_to_db() {
	global $wpdb, $lang;
	$current_event = get_option ( 'current_event' );
	$registrar = get_option ( 'registrar' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	
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
	$custom_1 = $_POST ['custom_1'];
	$custom_2 = $_POST ['custom_2'];
	$custom_3 = $_POST ['custom_3'];
	$custom_4 = $_POST ['custom_4'];
	update_option ( "attendee_first", $fname );
	update_option ( "attendee_last", $lname );
	update_option ( "attendee_name", $fname . " " . $lname );
	update_option ( "attendee_email", $email );
	
	$sql = "INSERT INTO " . $events_attendee_tbl . " (lname ,fname ,address ,city ,state ,zip ,email ,phone ,hear ,num_people, payment, event_id, custom_1, custom_2, custom_3, custom_4 ) VALUES ('$lname', '$fname', '$address', '$city', '$state', '$zip', '$email', '$phone', '$hear', '$num_people', '$payment', '$event_id', '$custom_1', '$custom_2', '$custom_3', '$custom4')";
	
	$wpdb->query ( $sql );
	

	
	// Insert Extra From Post Here
	$events_question_tbl = get_option ( 'events_question_tbl' );
	$events_answer_tbl = get_option ( 'events_answer_tbl' );
	$reg_id = $wpdb->get_var ( "SELECT LAST_INSERT_ID()" );
	
	$questions = $wpdb->get_results ( "SELECT * from `$events_question_tbl` where event_id = '$event_id'" );
	if ($questions) {
		foreach ( $questions as $question ) {
			switch ($question->question_type) {
				case "TEXT" :
				case "TEXTAREA" :
				case "DROPDOWN" :
					$post_val = $_POST [$question->question_type . '_' . $question->id];
					$wpdb->query ( "INSERT into `$events_answer_tbl` (registration_id, question_id, answer)
					values ('$reg_id', '$question->id', '$post_val')" );
					break;
				case "SINGLE" :
					$post_val = $_POST [$question->question_type . '_' . $question->id];
					$wpdb->query ( "INSERT into `$events_answer_tbl` (registration_id, question_id, answer)
					values ('$reg_id', '$question->id', '$post_val')" );
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
					$wpdb->query ( "INSERT into `$events_answer_tbl` (registration_id, question_id, answer)
					values ('$reg_id', '$question->id', '$value_string')" );
					break;
			}
		}
	}
	
	
	//Added by IJ: get the attendee-number and add to subject of email for having a unique attendee-number
	$sql = "select max(id) as attnum from $events_attendee_tbl ";
	$result = mysql_query ( $sql );
	$row = mysql_fetch_array ( $result );
	$attnum = $row ['attnum'];	
	
	
	//Query Database for Event Organization Info to email registrant BHC
	$events_organization_tbl = get_option ( 'events_organization_tbl' );
	$sql = "SELECT * FROM " . $events_organization_tbl . " WHERE id='1'";
	// $sql  = "SELECT * FROM wp_events_organization WHERE id='1'"; 
	

	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$org_id = $row ['id'];
		$Organization = $row ['organization'];
		$Organization_street1 = $row ['organization_street1'];
		$Organization_street2 = $row ['organization_street2'];
		$Organization_city = $row ['organization_city'];
		$Organization_state = $row ['organization_state'];
		$Organization_zip = $row ['organization_zip'];
		$contact = $row ['contact_email'];
		$registrar = $row ['contact_email'];
		$paypal_id = $row ['paypal_id'];
		$paypal_cur = $row ['currency_format'];
		$return_url = $row ['return_url'];
		$events_listing_type = $row ['events_listing_type'];
		$default_mail = $row ['default_mail'];
		$conf_message = $row ['message'];
	}
	
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	
	$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id='" . $event_id . "'";
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$event_name = $row ['event_name'];
		$event_desc = $row ['event_desc']; // BHC
		$display_desc = $row ['display_desc'];
		$image = $row ['image_link'];
		$identifier = $row ['event_identifier'];
		$reg_limit = $row ['reg_limit'];
		$cost = $row ['event_cost'];
		$start_month = $row ['start_month'];
		$start_day = $row ['start_day'];
		$start_year = $row ['start_year'];
		$multiple = $row ['multiple'];
		$end_month = $row ['end_month'];
		$end_day = $row ['end_day'];
		$end_year = $row ['end_year'];
		$start_time = $row ['start_time'];
		$end_time = $row ['end_time'];
		$checks = $row ['allow_checks'];
		$active = $row ['is_active'];
		$question1 = $row ['question1'];
		$question2 = $row ['question2'];
		$question3 = $row ['question3'];
		$question4 = $row ['question4'];
		$send_mail = $row ['send_mail'];
		$conf_mail = $row ['conf_mail'];
				$event_location = $row ['event_location'];
		$more_info = $row ['more_info'];
		$custom_cur = $row ['custom_cur'];
		$start_date = $start_month . " " . $start_day . ", " . $start_year;
		$end_date = $end_month . " " . $end_day . ", " . $end_year;
	}
	
	// Email Confirmation to Registrar
	
	$event_name = $current_event;
	
	$distro = $registrar;
	$message = ("$fname $lname  has signed up on-line for $event_name.\n\nMy email address is  $email.");
	
	wp_mail ( $distro, $event_name . " Number: $attnum", $message );
  
	
	//Email Confirmation to Attendee
	$query = "SELECT * FROM $events_attendee_tbl WHERE fname='$fname' AND lname='$lname' AND email='$email'";
	$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$id = $row ['id'];
	}
	
	$payment_link = $return_url . "?id=" . $id;
	
	//Email Confirmation to Attendee
	$SearchValues = array ("[fname]", "[lname]", "[phone]", "[event]", "[description]", "[cost]", "[currency]", "[qst1]", "[qst2]", "[qst3]", "[qst4]", "[contact]", "[company]", "[co_add1]", "[co_add2]", "[co_city]", "[co_state]", "[co_zip]", "[payment_url]", "[start_date]", "[start_time]", "[end_date]", "[end_time]","[snum]", "[num_people]" );
	
	$ReplaceValues = array ($fname, $lname, $phone, $event_name, $event_desc, $cost, $custom_cur, $question1, $question2, $question3, $question4, $contact, $Organization, $Organization_street1, $Organization_street2, $Organization_city, $Organization_state, $Organization_zip, $payment_link, $start_date, $start_time, $end_date, $end_time, $attnum, $num_people);
	
	$custom = str_replace ( $SearchValues, $ReplaceValues, $conf_mail );
	$default_replaced = str_replace ( $SearchValues, $ReplaceValues, $conf_message );
	
	$distro = $email;
	
	if ($default_mail == 'Y') {
		if ($send_mail == 'Y') {
			wp_mail ( $distro, $event_name, $custom );
		}
	}
	
	if ($default_mail == 'Y') {
		if ($send_mail == 'N') {
			wp_mail ( $distro, $event_name, $default_replaced );
		}
	}
	
	//Get registrars id from the data table and assign to a session variable for PayPal.
	

	$query = "SELECT * FROM $events_attendee_tbl WHERE fname='$fname' AND lname='$lname' AND email='$email'";
	$result = mysql_query ( $query ) or die ( 'Error : ' . mysql_error () );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
		$id = $row ['id'];
		$lname = $row ['lname'];
		$fname = $row ['fname'];
		$address = $row ['address'];
		$city = $row ['city'];
		$state = $row ['state'];
		$zip = $row ['zip'];
		$email = $row ['email'];
		$num_people = $row ['num_people'];
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
	}
	
	update_option ( "attendee_id", $id );
	
	//Send screen confirmation & forward to paypal if selected.
	

	echo $lang ['registrationConfirm'];
	
	events_payment_page ( $event_id );
}

?>