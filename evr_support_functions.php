<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

//functinos used by EVR for various things

function evr_moneyFormat($number, $currencySymbol = '', $decPoint = '.', $thousandsSep = ',', $decimals = 2) {
return $currencySymbol . number_format($number, $decimals,
$decPoint, $thousandsSep);
}

function evr_DateSelector($inName, $useDate=0) 
                    { 
                        
                    /* create array so we can name months */ 
                    $monthName = array(1=> "January", "February", "March", 
                    "April", "May", "June", "July", "August", 
                    "September", "October", "November", "December"); 
                    
                    /* if date invalid or not supplied, use current time */ 
                    if($useDate == 0){$useDate = Time();} 
                    
                    /* make month selector */ 
                    echo "<SELECT NAME=" . $inName . "_month\">\n"; 
                    for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) 
                    { 
                    echo "<OPTION VALUE=\""; 
                    echo intval($currentMonth); 
                    echo "\""; 
                    if(intval(date( "m", $useDate))==$currentMonth) 
                    { 
                    echo " SELECTED"; 
                    } 
                    echo ">" . $monthName[$currentMonth] . "\n"; 
                    } 
                    echo "</SELECT>"; 
                    
                    /* make day selector */ 
                    echo "<SELECT NAME=" . $inName . "_day\">\n"; 
                    for($currentDay=1; $currentDay <= 31; $currentDay++) 
                    { 
                    echo "<OPTION VALUE=\"$currentDay\""; 
                    if(intval(date( "d", $useDate))==$currentDay) 
                    { 
                    echo " SELECTED"; 
                    } 
                    echo ">$currentDay\n"; 
                    } 
                    echo "</SELECT>"; 
                    
                    /* make year selector */ 
                    echo "<SELECT NAME=" . $inName . "_year\">\n"; 
                    $startYear = date( "Y", $useDate); 
                    for($currentYear = $startYear - 5; $currentYear <= $startYear+5;$currentYear++) 
                    { 
                    echo "<OPTION VALUE=\"$currentYear\""; 
                    if(date( "Y", $useDate)==$currentYear) 
                    { 
                    echo " SELECTED"; 
                    } 
                    echo ">$currentYear\n"; 
                    } 
                    echo "</SELECT>"; 

} 

function evr_check_form_submission(){
echo "Check POST/GET/REQUEST Variables<br>";
foreach ($_REQUEST as $key => $val)
echo "$key = $val<br>";
}

function utf8_to_html ($data)
 {
 return preg_replace("/([\\xC0-\\xF7]{1,1}[\\x80-\\xBF]+)/e", '_utf8_to_html("\\1")', $data);
 }
 
function _utf8_to_html ($data)
 {
 $ret = 0;
 foreach((str_split(strrev(chr((ord($data{0}) % 252 % 248 % 240 % 224 % 192) + 128) . substr($data, 1)))) as $k => $v)
 $ret += (ord($v) % 128) * pow(64, $k);
 return "&#$ret;";
 }
 

function evr_form_build($question, $answer = "") {

	$required = '';
	if ($question->required == "Y") {
		$required = ' class="r"';
	}
	switch ($question->question_type) {
		case "TEXT" :
			echo "<span class=\"fieldbox\"><input type=\"text\"$required id=\"TEXT_$question->id\"  name=\"TEXT_$question->id\" size=\"40\" title=\"$question->question\" value=\"$answer\" /></span>\n";
			break;
		
		case "TEXTAREA" :
			echo "<span class=\"msgbox\"><textarea id=\"TEXTAREA_$question->id\"$required name=\"TEXTAREA_$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">$answer</textarea></span>\n";
			break;
		
		case "SINGLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				//echo "<label><input id=\"SINGLE_$question->id_$key\"$required name=\"SINGLE_$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</label><br/>\n";
			 echo "<p class=\"hanging-indent\"><input id=\"SINGLE_$question->id_$key\"$required name=\"SINGLE_$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</p>\n";
			
            }
			break;
		
		case "MULTIPLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
			/*	echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE_$question->id_$key\" name=\"MULTIPLE_$question->id_$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n"; */
			//echo "<label><input id=\"$value\"$required name=\"MULTIPLE_$question->id[]\" title=\"$question->question\" type=\"checkbox\" value=\"$value\"$checked /> $value</label><br/>\n";
			echo "<p class=\"hanging-indent\"><input id=\"$value\"$required name=\"MULTIPLE_$question->id[]\" title=\"$question->question\" type=\"checkbox\" value=\"$value\"$checked /> $value</p>\n";
			
            }
			break;
		
		case "DROPDOWN" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			echo "<select name=\"DROPDOWN_$question->id\"$required id=\"DROPDOWN_$question->id\" title=\"$question->question\" />";
			echo "<option value=''>Select One </option><br/>";
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " selected =\" selected\"" : "";
				echo "<option value=\"$value\" /> $value</option><br/>\n";
			}
			echo "</select>";
			break;
		
		default :
			break;
	}
}


function evr_form_build_edit ($question, $edits) {
	$required = '';
	if ($question->required == "Y") {
		$required = ' class="r"';
	}
	switch ($question->question_type) {
		case "TEXT" :
			echo "<span class=\"fieldbox\"><input type=\"text\"$required id=\"TEXT_$question->id\"  name=\"TEXT_$question->id\" size=\"40\" title=\"$question->question\" value=\"$edits\" /></span>";
			break;
		
		case "TEXTAREA" :
			echo "<span class=\"msgbox\"><textarea id=\"TEXTAREA_$question->id\"$required name=\"TEXTAREA_$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">".$edits."</textarea></span>";
			break;
		
		case "SINGLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $edits );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				echo "<p class=\"hanging-indent radio_rows\"><input id=\"SINGLE_$question->id_$key\"$required name=\"SINGLE_$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value  </p>";
			}
			
			break;
		
		case "MULTIPLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $edits );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
			/*	echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE_$question->id_$key\" name=\"MULTIPLE_$question->id_$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n"; */
			echo " <p class=\"hanging-indent radio_rows\"><input id=\"$value\"$required name=\"MULTIPLE_$question->id[]\" title=\"$question->question\" type=\"checkbox\" value=\"$value\"$checked /> $value  </p>";
			}
			break;
		
		case "DROPDOWN" :
			$values = explode ( ",", $question->response );
			//$answers = explode ( ",", $edits );
			echo "<select name=\"DROPDOWN_$question->id\"$required id=\"DROPDOWN_$question->id\" title=\"$question->question\" />".BR;
			echo "<option value=\"$edits\">$edits</option><br/>";
			foreach ( $values as $key => $value ) {
				//$checked = in_array ( $value, $answers ) ? " selected =\" selected\"" : "";
					echo "<option value=\"$value\" /> $value</option><br/>\n";
			}
			echo "</select>";
			break;
		
		default :
			break;
	}
}
function evr_greaterDate($start_date,$end_date)
{
  $start = strtotime($start_date);
  $end = strtotime($end_date);
  if ($start-$end >= 0)
    return 1;
  else
   return 0;
}

function evr_validate_key(){
    
    
    global $wpdb;
    if (get_option('evr_dontshowpopup')=="Y"){$alert = '<div id="message" class="updated"><p><strong>'.__('POPUP IS DISABLED','evr_language').'</strong></p></div>';}
    else {$alert = '<div id="message" class="updated"><p><strong>Please enter a key.</strong></p></div>';}
   
   
    
    if ( isset( $_POST['key'], $_POST['donated'] ) ) {
        $cur_key = get_option('plug-evr-activate');
        $submitted_key = $_POST['key'];
        if ($cur_key == $submitted_key){ 
            update_option('evr_dontshowpopup', "Y"); 
            $alert =  '<div id="message" class="updated highlight"><p><strong>Popup Donate Message has been disabled!</strong></p></div>';       
            }
        elseif ($cur_key != $submitted_key){
            $alert = '<div id="message" class="error"><p><strong>Invalid key.  Please re-enter your key.</strong></p></div>';
            update_option('evr_dontshowpopup', "N");
        }
     
    }
    ?>
        <div class="wrap"><br />
        <a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a>
        <br />
        <br />
        <div class="evr_plugin">
            <div class="content">
            	<div class="evr_content_half">
            		<h3>Disable Donate Popup</h3>
            		<div class="inside">
                    <?php echo $alert;?> 
                    <form method="POST"  action="admin.php?page=popup">
                        
                        
                      
                     <p>Thank you for donating to support Event Registration.  To disable the popup alert, you will need an activation key. Please send an email to support@wordpresseventregister to request the activation key.  Please include your website and paypal reciept #.</p>
                     <p>Note: Each key is specific to your website/installation.</p>
                     <p><input name="donated" type="checkbox" value="1" />Yes, I have donated to Event Registration.</p>
                     <p>Paste Activation Key<input name="key"/></p>
                      <input class="button-secondary" name="disable_pop" type="submit" value="Disable Popup"/>
                     </form>
                     </div>
                </div>
                    	<div class="evr_content_third" style="margin-right:0; float:right;">
    		<h3>Support Event Registration</h3>
    		<div class="inside">
    			<div style="clear: both; display: block; padding: 10px 0; text-align:center;">If you find this plugin useful,<br /> please contribute to enable its continued development!<br />
                <br /><p align="center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="VN9FJEHPXY6LU">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form></p>
    		</div>
           </div>		
		<div class="clear"></div>
	</div>
	  		
            </div>
           </div>  		
        </div>        
        <?php
    
    
    
}
?>