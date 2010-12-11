<?php
  
function register_attendees($event_single_id) {
    

    
	global $wpdb, $events_lang,$events_lang_flag;
	$paypal_cur = get_option ( 'paypal_cur' );
	if ($event_single_id == ""){$event_id = $_REQUEST ['event_id'];}
	if ($event_single_id != ""){$event_id = $event_single_id;}	
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
	

	if ($event_id == "") {
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
	} else {
		$sql = "SELECT * FROM " . $events_detail_tbl . " WHERE id = $event_id";
	}
	$result = mysql_query ( $sql );
	while ( $row = mysql_fetch_assoc ( $result ) ) {
	                $event_id= $row['id'];
			        $event_name =  stripslashes($row ['event_name']);
					$event_identifier =  stripslashes($row ['event_identifier']);
					$event_desc =  stripslashes($row ['event_desc']);
					$image_link = $row ['image_link'];
					$header_image = $row ['header_image'];
					$display_desc = $row ['display_desc'];
					$event_location =  stripslashes($row ['event_location']);
					$more_info = $row ['more_info'];
					$reg_limit = $row ['reg_limit'];
					$event_cost = $row ['event_cost'];
					$custom_cur = $row ['custom_cur'];
					$multiple = $row ['multiple'];
					$allow_checks = $row ['allow_checks'];
					$is_active = $row ['is_active'];
					$start_month = $row ['start_month'];
					$start_day = $row ['start_day'];
					$start_year = $row ['start_year'];
					$end_month = $row ['end_month'];
					$end_day = $row ['end_day'];
					$end_year = $row ['end_year'];
					$start_time = $row ['start_time'];
					$end_time = $row ['end_time'];
					$conf_mail = stripslashes($row ['conf_mail']);
					$send_mail = $row ['send_mail'];
                    $use_coupon=$row ['use_coupon'];
            		$coupon_code=$row ['coupon_code'];
            		$coupon_code_price=$row ['coupon_code_price'];
            		$use_percentage=$row ['use_percentage'];
            		$event_category =  $row ['event_category'];
						if ($start_month == "Jan"){$month_no = '01';}
						if ($start_month == "Feb"){$month_no = '02';}
						if ($start_month == "Mar"){$month_no = '03';}
						if ($start_month == "Apr"){$month_no = '04';}
						if ($start_month == "May"){$month_no = '05';}
						if ($start_month == "Jun"){$month_no = '06';}
						if ($start_month == "Jul"){$month_no = '07';}
						if ($start_month == "Aug"){$month_no = '08';}
						if ($start_month == "Sep"){$month_no = '09';}
						if ($start_month == "Oct"){$month_no = '10';}
						if ($start_month == "Nov"){$month_no = '11';}
						if ($start_month == "Dec"){$month_no = '12';}
					$start_date = $start_year."-".$month_no."-".$start_day;
						if ($end_month == "Jan"){$end_month_no = '01';}
						if ($end_month == "Feb"){$end_month_no = '02';}
						if ($end_month == "Mar"){$end_month_no = '03';}
						if ($end_month == "Apr"){$end_month_no = '04';}
						if ($end_month == "May"){$end_month_no = '05';}
						if ($end_month == "Jun"){$end_month_no = '06';}
						if ($end_month == "Jul"){$end_month_no = '07';}
						if ($end_month == "Aug"){$end_month_no = '08';}
						if ($end_month == "Sep"){$end_month_no = '09';}
						if ($end_month == "Oct"){$end_month_no = '10';}
						if ($end_month == "Nov"){$end_month_no = '11';}
						if ($end_month == "Dec"){$end_month_no = '12';}
					$end_date = $end_year."-".$end_month_no."-".$end_day;
                    $reg_form_defaults = unserialize($row['reg_form_defaults']);
                    if ($reg_form_defaults !=""){
                        if (in_array("Address", $reg_form_defaults)) {$inc_address = "Y";}
                        if (in_array("City", $reg_form_defaults)) {$inc_city = "Y";}
                        if (in_array("State", $reg_form_defaults)) {$inc_state = "Y";}
                        if (in_array("Zip", $reg_form_defaults)) {$inc_zip = "Y";}
                        if (in_array("Phone", $reg_form_defaults)) {$inc_phone = "Y";}
                        }
   		            if ($reg_limit == ''){$reg_limit = 999;}
                    if ($event_cost == ''){$event_cost= 0;}
                    if ($coupon_code_price == ''){$coupon_code_price = 0;}
             }
			
            	$sql2= "SELECT SUM(num_people) FROM " . get_option('events_attendee_tbl') . " WHERE event_id='$event_id'";
				$result2 = mysql_query($sql2);
	
				while($row = mysql_fetch_array($result2)){
					$number_attendees =  $row['SUM(num_people)'];
				}
				
				if ($number_attendees == '' || $number_attendees == 0){
					$number_attendees = '0';
				}
				
			/*	if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){
					$reg_limit = "&#8734;";
				}
	       */
	
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
		$payment_vendor_id = $row ['payment_vendor_id'];
		$currency_format = $row ['currency_format'];
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
	
	
		
		?>
<?php //JavaScript for Registration Form Validation 

		?>
<SCRIPT>

function checkInternationalPhone(strPhone){

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function trim(s)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not a whitespace, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (c != " ") returnString += c;
    }
    return returnString;
}
function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

var bracket=3
strPhone=trim(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

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

function testIsValidObject(objToTest) {
if (objToTest == null || objToTest == undefined) {
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

if(form.phone) {
	if (form.phone.value == "" || form.phone.value==null) {  msg += "\n " +"Please enter your phone number."; 
   		form.phone.focus( ); 
   		}
    if (checkInternationalPhone(form.phone.value)==false){
		msg += "\n " +"Please use correct format for your phone number."; 
		form.value=""
		form.phone.focus()
        }
}
	
if(form.address) {
if (form.address.value == "") {  msg += "\n " +"Please enter your address."; 
   		form.address.focus( ); 
   		}
        }
if(form.city) {
if (form.city.value == "") {  msg += "\n " +"Please enter your city."; 
   		form.city.focus( ); 
   		}  }
if(form.state) {
if (form.state.value == "") { msg += "\n " + "Please enter your state."; 
   		form.state.focus( ); 
   	 }
     }

if(form.zip) {   	    
if (form.zip.value == "") {  msg += "\n " +"Please enter your zip code."; 
   		form.zip.focus( ); 
   		 }
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
<?php 
	
if ($event_cost == ""||$event_cost =="0"||$event_cost=="0.00"){$event_cost = "FREE";}

if ($header_image != ""){echo "<p align='center'><img src='".$header_image."'  width='450' align='center'></p>";}
    	if ( $reg_limit > "$num" || $reg_limit == "") {
		echo "<p align='center'><b>".$events_lang['eventFormHeader'] . $event_name .  " - ".$event_identifier."</b></p>";
		echo "<table width='100%'><td>";
		if ($display_desc == "Y") {
			echo "<td span='2'>" . $event_desc ."</td>";
		}
		echo "</table>";
		echo "<table width='500'><td>";
		if ($custom_cur == ""){if ($currency_format == "USD" || $currency_format == "") {$currency_format = "$";}			}
		if ($custom_cur != "" || $custom_cur != "USD"){$currency_format = $custom_cur;}
		if ($custom_cur == "USD") {$currency_format = "$";}
			
		if ($event_cost == "FREE"){
		  echo "<b>" . $event_name . " - FREE EVENT </b></p></p>";
          }
          else if ($event_cost != "") {if ($events_lang_flag=='de')
				echo "<b>" . $event_name . " - Kosten " .$event_cost . " " .  $currency_format . "</b></p></p>";
      		else
			  	echo "<b>" . $event_name . " - Cost " . $currency_format . " " . $event_cost . "</b></p></p>";
			}
            
?>

</td>
<tr>
	<td>
	<form method="post"
		action="<?php
		echo $_SERVER ['REQUEST_URI'];
		?>"
		onSubmit="return validateForm(this)">
	<p align="left"><b><?php
		echo $events_lang ['firstName'];
		?>: <br />
	<input tabIndex="1" maxLength="40" size="47" name="fname"></b></p>
	<p align="left"><b><?php
		echo $events_lang ['lastName'];
		?>:<br />
	<input tabIndex="2" maxLength="40" size="47" name="lname"></b></p>
	<p align="left"><b><?php
		echo $events_lang ['email'];
		?>:<br />
	<input tabIndex="3" maxLength="40" size="47" name="email"></b></p>
	
        
<?php if ($inc_phone == "Y"){ ?>
	<p align="left"><b><?php
		echo $events_lang ['phone'];
		?>:<br />
  <input tabIndex="4" maxLength="20" size="25" name="phone"></b></p>
<?php } 
if ($inc_address == "Y"){  ?> 
        <p align="left"><b>
     <?php  echo $events_lang ['address'];	?>:<br />
       	<input tabIndex="5" maxLength="35" size="49" name="address"></b></p>
<?php } 

if ($inc_city == "Y"){ ?>
        <p align="left"><b>
    <?php echo $events_lang ['city'];?>:<br />
        <input tabIndex="6" maxLength="25" size="35" name="city"> </b></p>
<?php } 

if ($inc_state == "Y"){ ?>
    <?php //no state necessary in germany
      if ($events_lang_flag!="de")
      {  ?>  
      <p align="left"><b>
    <?php  echo $events_lang ['state'];}	?>:<br />
    	<input tabIndex="7" maxLength="20" size="18" name="state"></b></p>
<?php } 

if ($inc_zip == "Y"){	?>
	<p align="left"><b>
<?php echo $events_lang ['zip'];?>:<br />
	<input tabIndex="8" maxLength="10" size="15" name="zip"></b></p>
<?php } 

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
			<b><?php echo $events_lang['payingPlan'];?></b><br />
	    <select tabIndex="10" size="1" name="payment">
		  <option value="pickone" selected><?php echo $events_lang['pickone']; ?></option>
			<?php
			if ($payment_vendor_id != "") {
				echo "<option value=\"Paypal\">$events_lang[paypal]</option>";
			}
			
			echo "<option value=\"Cash\">$events_lang[cash]</option>";
			
			if ($checks == "yes" && $events_lang_flag!='de') {  //very unusual in germany
        echo "<option value=\"Check\">$events_lang[check]</option>";
			}
			?>
			</select></font></p>
			<?php
		} else {
			?><input type="hidden" name="payment" value="free event"><?
		}
*/
			
if ($use_coupon =="Y"){
    echo "<p align='left'><b>Please enter coupon code for discount?".
    	"<input maxLength='10' size='12' name='coupon'></b></p>";
}
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
	<p align="center"><input type="submit" name="Submit" value="<?php echo $events_lang['submit']; ?>"> <font
		color="#FF0000"><b><?php echo $events_lang['submitHint'];?></b></font>
	
	</form>
	</td>
</tr>
</table>
</body>
<?php
	} else {
		echo $events_lang ['maxAttendeesInfo'];
		echo "<p>Current Number of Attendees: " . $num . "</p>";
	}


}

function add_attendees_to_db() {
	global $wpdb, $events_lang;
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
    $coupon = $_POST['coupon'];
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
	
$sql = "INSERT INTO " . $events_attendee_tbl . " (lname ,fname ,address ,city ,state ,zip ,email ,phone ,hear ,coupon,num_people, payment, event_id) VALUES ('$lname', '$fname', '$address', '$city', '$state', '$zip', '$email', '$phone', '$hear', '$coupon','$num_people', '$payment', '$event_id')";

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
		$payment_vendor_id = $row ['payment_vendor_id'];
		$currency_format = $row ['currency_format'];
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
	
	//Get registrars id from the data table .
	

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
	

	echo $events_lang ['registrationConfirm'];
	
	events_payment_page ( $event_id );
}

?>