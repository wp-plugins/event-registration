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
 

function evr_form_build(&$question, $answer = "") {

	$required = '';
	if ($question->required == "Y") {
		$required = ' class="r"';
	}
	switch ($question->question_type) {
		case "TEXT" :
			echo "<input type=\"text\"$required id=\"TEXT_$question->id\"  name=\"TEXT_$question->id\" size=\"40\" title=\"$question->question\" value=\"$answer\" />\n";
			break;
		
		case "TEXTAREA" :
			echo "<textarea id=\"TEXTAREA_$question->id\"$required name=\"TEXTAREA_$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">$answer</textarea>\n";
			break;
		
		case "SINGLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				echo "<label><input id=\"SINGLE_$question->id_$key\"$required name=\"SINGLE_$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;
		
		case "MULTIPLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
			/*	echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE_$question->id_$key\" name=\"MULTIPLE_$question->id_$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n"; */
			echo "<label><input id=\"$value\"$required name=\"MULTIPLE_$question->id[]\" title=\"$question->question\" type=\"checkbox\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;
		
		case "DROPDOWN" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $answer );
			echo "<select name=\"DROPDOWN_$question->id\"$required id=\"DROPDOWN_$question->id\" title=\"$question->question\" />".BR;
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
			echo "<input type=\"text\"$required id=\"TEXT_$question->id\"  name=\"TEXT_$question->id\" size=\"40\" title=\"$question->question\" value=\"$edits\" />\n";
			break;
		
		case "TEXTAREA" :
			echo "<textarea id=\"TEXTAREA_$question->id\"$required name=\"TEXTAREA_$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">".$edits."</textarea>\n";
			break;
		
		case "SINGLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $edits );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
				echo " <label><input id=\"SINGLE_$question->id_$key\"$required name=\"SINGLE_$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</label>  ";
			}
			echo "</br>\n";
			break;
		
		case "MULTIPLE" :
			$values = explode ( ",", $question->response );
			$answers = explode ( ",", $edits );
			foreach ( $values as $key => $value ) {
				$checked = in_array ( $value, $answers ) ? " checked=\"checked\"" : "";
			/*	echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE_$question->id_$key\" name=\"MULTIPLE_$question->id_$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n"; */
			echo " <label><input id=\"$value\"$required name=\"MULTIPLE_$question->id[]\" title=\"$question->question\" type=\"checkbox\" value=\"$value\"$checked /> $value</label>  ";
			}
			echo "</br>\n";
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
?>