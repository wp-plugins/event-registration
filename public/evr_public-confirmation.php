<?php

function evr_confirm_form(){

    global $wpdb, $qanda, $posted_data;
    $company_options = get_option('evr_company_settings');
    $num_people = 0;
    $item_order = array();
        
    $passed_event_id = $_POST['event_id'];
    if (is_numeric($passed_event_id)){$event_id = $passed_event_id;}
    else {echo "Failure - please retry!"; exit;}
    
    //Begin gather registrtion data for database input
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $payment = $_POST['total'];
    $coupon = $_POST['coupon'];
    $reg_type = $_POST['reg_type'];
    $attendee_name = $fname." ".$lname;
    
    echo "Registration Type is: ".$reg_type."!";
    
    
   
    $sql = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
    $result = mysql_query ( $sql );
	while ($row = mysql_fetch_assoc ($result)){
            $item_id          = $row['id'];
            $item_sequence    = $row['sequence'];
			$event_id         = $row['event_id'];
            $item_title       = $row['item_title'];
            $item_description = $row['item_description']; 
            $item_cat         = $row['item_cat'];
            $item_limit       = $row['item_limit'];
            $item_price       = $row['item_price'];
            $free_item        = $row['free_item'];
            $item_start_date  = $row['item_available_start_date'];
            $item_end_date    = $row['item_available_end_date'];
            $item_custom_cur  = $row['item_custom_cur'];
                 
            $item_post = str_replace(".", "_", $row['item_price']);
            $item_qty = $_REQUEST['PROD_' . $event_id . '-' . $item_id . '_' . $item_post];
            
            if ($item_cat == "REG"){$num_people = $num_people + $item_qty;}
            
            $item_info = array('ItemID' => $item_id, 'ItemEventID' => $event_id, 'ItemCat'=>$item_cat,
                'ItemName' => $item_title, 'ItemCost' => $item_price, 'ItemCurrency' =>
                $item_custom_cur, 'ItemFree' => $free_item, 'ItemStart' => $item_start_date,
                'ItemEnd' => $item_end_date, 'ItemQty' => $item_qty);
            array_push($item_order, $item_info);
            
            }
    if ($reg_type == "WAIT"){$quantity = "1";}
    else {$quantity = $num_people;}
    
    $ticket_data = serialize($item_order);

     $posted_data =array('lname'=>$lname, 'fname'=>$fname, 'address'=>$address, 'city'=>$city, 
                'state'=>$state, 'zip'=>$zip, 'reg_type'=>$reg_type, 'email'=>$email,
                'phone'=>$phone, 'email'=>$email, 'coupon'=>$coupon, 'event_id'=>$event_id,
                'num_people'=>$quantity, 'tickets'=>$ticket_data, 'payment'=>$payment);
                
                
     $reg_id = $wpdb->get_var("SELECT LAST_INSERT_ID()");
     $qanda=array();
            $questions = $wpdb->get_results("SELECT * from ".get_option('evr_question')." where event_id = '$event_id'");
            if ($questions) {
                  foreach ($questions as $question) {
                    switch ($question->question_type) {
                        case "TEXT":
                        case "TEXTAREA":
                        case "DROPDOWN":
                            $post_val = $_POST[$question->question_type . '_' . $question->id];
                            
                            $custom_response = array( 'email'=>$email, 'question' => $question->id, 'response'=>$post_val);
                            array_push($qanda,$custom_response);
                            break;
                        case "SINGLE":
                            $post_val = $_POST[$question->question_type . '_' . $question->id];
                            $custom_response = array( 'email'=>$email, 'question' => $question->id, 'response'=>$post_val);
                            array_push($qanda,$custom_response);
                            break;
                        case "MULTIPLE":
                            $value_string = '';
                            for ($i = 0; $i < count($_POST[$question->question_type . '_' . $question->id]);
                                $i++) {
                                $value_string .= $_POST[$question->question_type . '_' . $question->id][$i] .",";
                            }
                            $custom_response = array( 'email'=>$email, 'question' => $question->id, 'response'=>$value_string);
                            array_push($qanda,$custom_response);
                            break;
                        }
                    }
                }    
                
$sql = "SELECT * FROM ". get_option('evr_event') ." WHERE id=". $event_id;
                    		$result = mysql_query ($sql);
                            while ($row = mysql_fetch_assoc ($result)){  
                         
                            $event_id       = $row['id'];
            				$event_name     = $row['event_name'];
            				$event_location = $row['event_location'];
                            $event_address  = $row['event_address'];
                            $event_city     = $row['event_city'];
                            $event_postal   = $row['event_postal'];
                            $reg_limit      = $row['reg_limit'];
                    		$start_time     = $row['start_time'];
                    		$end_time       = $row['end_time'];
                    		$start_date     = $row['start_date'];
                    		$end_date       = $row['end_date'];
                            }
       

?>

<p align="left"><strong>Please verify your registration details:</strong></p>
                    <table width="95%" border="0">
                      <tr>
                        <td><strong>Event Name/Cost:</strong></td>
                        <td><?php echo $event_name?> - <?php echo $item_order[0]['ItemCurrency'];?><?php echo $payment?></td>
                      </tr>
                      <tr>
                        <td><strong>Attendee Name:</strong></td>
                        <td><?php echo $attendee_name?></td>
                      </tr>
                      <tr>
                        <td><strong>Email Address:</strong></td>
                        <td><?php echo $email?></td>
                      </tr>
                       <tr>
                       <td><strong>Number of Attendees:</strong></td>
                        <td><?php echo $quantity?></td>
                      </tr>
                       <tr>
                        <td><strong>Order Details:</strong></td>
                        <td><?php if ($reg_type == "WAIT"){echo "WAIT LIST";}
                        else {
                        $row_count = count($item_order);
    for ($row = 0; $row < $row_count; $row++) {
    if ($item_order[$row]['ItemQty'] >= "1"){ echo $item_order[$row]['ItemQty']." ".$item_order[$row]['ItemCat']."-".$item_order[$row]['ItemName']." ".$item_order[$row]['ItemCurrency'] . " " . $item_order[$row]['ItemCost']."<br \>";}
    } }?></td>
                      </tr>
                    </table>
                    
<p align="left"><strong><?php if ($reg_type == "WAIT"){$type = "You are on the waiting list.";}
                                if ($reg_type == "REG"){$type = "You are registering for ".$quantity." people.   Please provide the first and last name of each person:" ;}
                                echo $type;
                                ?></strong><br />
<form id="attendee_confirm" class="evr_regform" method="post" action="<?php echo evr_permalink($company_options['evr_page_id']);?>" onSubmit="mySubmit.disabled=true;return validateForm(this)">
<p>
<?php

if ( $quantity >"0"){
$i = 0;
 do {
    $person = $i + 1;
    echo 'Attendee #'.$person.' First Name: <input name="attendee['.$i.'][first_name]"';
    if ($i == 0){ echo 'value ="'.$fname.'"';}
    echo '/>';
    echo '  Last Name: <input name="attendee['.$i.'][last_name]"';
    if ($i == 0){ echo 'value ="'.$lname.'"';}
    echo '/></br>';
    
 ++$i;
 } while ($i < $quantity);
 
 }
 $form_post = urlencode(serialize($posted_data));
 $question_post = urlencode(serialize($qanda));

?>
<br /><input type="button" value=" &lt;-- BACK " onclick="history.go(-1);return false;" />
<input type="hidden" name="reg_form" value="<?php echo $form_post;?>" />
<input type="hidden" name="questions" value="<?php echo $question_post;?>" />
<input type="hidden" name="action" value="post"/>
<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
<div style="margin-left: 150px;">
<input type="submit" name="mySubmit" id="mySubmit" value="<?php _e('Confirmed','evr_language');?>" /> 
</form>


<?php
}

?>