<?php
function er_show_calendar(){
    $url = EVNT_RGR_PLUGINFULLURL;
?>

<script>

function goLastMonth(month, year){

	// If the month is January, decrement the year

	if(month == 1){

		--year;

		month = 13;

	}

	document.location.href = '<?php echo get_page_link();?>&month='+(month-1)+'&year='+year;

}

//next function

function goNextMonth(month, year){

	// If the month is December, increment the year

	if(month == 12){

	++year;

	month = 0;

	}

	document.location.href = '<?php echo get_page_link();?>&month='+(month+1)+'&year='+year;

}  



function remChars(txtControl, txtCount, intMaxLength)

{

if(txtControl.value.length > intMaxLength)

	txtControl.value = txtControl.value.substring(0, (intMaxLength-1));

else

	txtCount.value = intMaxLength - txtControl.value.length;

}



function checkFilled() {

var filled = 0

var x = document.form1.calName.value;

//x = x.replace(/^\s+/,"");  // strip leading spaces

if (x.length > 0) {filled ++}



var y = document.form1.calDesc.value;

//y = y.replace(/^s+/,"");  // strip leading spaces

if (y.length > 0) {filled ++}



if (filled == 2) {

document.getElementById("Submit").disabled = false;

}

else {document.getElementById("Submit").disabled = true}  // in case a field is filled then erased



}



</script>

<style>

body{

	font-family:Georgia, "Times New Roman", Times, serif;

	font-size:12px;

}

.today{

	/*background-color:#00CCCC;*/

	font-weight:bold;

	background-image:url(<?php echo $url; ?>images/calBg.jpg);

	background-repeat:no-repeat;
    
	background-position:center;

	position:relative;

}

.today span{

	position:absolute;

	left:0;

	top:0;	

}



.today a{

	color:#000000;

	padding-top:10px;

}

.selected {

color: #FFFFFF;

background-color: #C00000;

}

.event {

/*	background-color: #C6D1DC; */
    font-weight:bold;
    background-image:url(<?php echo $url; ?>images/events_icon_32.png);
    background-repeat:no-repeat;
	background-position:center;
    border:3px solid #ffffff;

} 

.normal {



} 

table{

	border:1px solid #cccccc;

	padding:3px;

}

th{

	width:36px;

	background-color:#cccccc;

	text-align:center;

	color:#ffffff;

	border-left:1px solid #ffffff;

}

td{

	text-align:center;

	padding:10px;

	margin:0;

}

table.tableClass{

	width:350px;

	border:none;

	border-collapse: collapse;

	font-size:85%;

	border:1px dotted #cccccc;

}

table.tableClass input,textarea{

	font-size:90%;

}

#form1{

	margin:5px 0 0 0;

}

#greyBox{

	height:10px;

	width:10px;

	background-color:#C6D1DC;

	border:1px solid #666666;

	margin:5px;

}

#legend{

	margin:5 0 10px 50px;

	width:200px;

}

#hr{border-bottom:1px solid #cccccc;width:300px;}

.output{width:300px;border-bottom:1px dotted #ccc;margin-bottom:5px;padding:6px;}

h5{margin:0;}

</style>
<hr />
<div id="legend"> 

<img src="<?php echo EVNT_RGR_PLUGINFULLURL;?>images/events_icon_32.png" height="17"/> Scheduled Events<br/><img src="<?php echo EVNT_RGR_PLUGINFULLURL;?>images/calBg.jpg" height="10"/> Todays Date</div>

<?php
global $wpdb;
$events_detail_tbl = get_option ( 'events_detail_tbl' );
$events_calendar_url = get_option ( 'er_calendar_url');
$url = EVNT_RGR_PLUGINFULLURL;

	//$todaysDate = date("n/j/Y");

	//echo $todaysDate;

	// Get values from query string

	$day = (isset($_GET["day"])) ? $_GET['day'] : "";

	$month = (isset($_GET["month"])) ? $_GET['month'] : "";

	$year = (isset($_GET["year"])) ? $_GET['year'] : "";

	//comparaters for today's date

	//$todaysDate = date("n/j/Y");

	//$sel = (isset($_GET["sel"])) ? $_GET['sel'] : "";

	//$what = (isset($_GET["what"])) ? $_GET['what'] : "";

	

	//$day = (!isset($day)) ? $day = date("j") : $day = "";

	if(empty($day)){ $day = date("j"); }

	

	if(empty($month)){ $month = date("n"); }

	

	if(empty($year)){ $year = date("Y"); } 

	//set up vars for calendar etc

	$currentTimeStamp = strtotime("$year-$month-$day");

	$monthName = date("F", $currentTimeStamp);

	$numDays = date("t", $currentTimeStamp);

	$counter = 0;

	//$numEventsThisMonth = 0;

	//$hasEvent = false;

	//$todaysEvents = ""; 

	//run a selec statement to hi-light the days

function hiLightEvt($eMonth,$eDay,$eYear){
    global $wpdb;
    $events_detail_tbl = get_option ( 'events_detail_tbl' );
    $url = EVNT_RGR_PLUGINFULLURL;
		//$tDayName = date("l");

		$todaysDate = date("n-j-Y");
        
    $today = date("j"); 
    $thisMonth = date("n"); 
	$thisYear = date("Y"); 

		if ($today == $eDay && $thisMonth == $eMonth && $thisYear == $eYear){$aClass='class="today"';}
        else
        {
	
            $month_no = $eMonth;
                        if($month_no =="1"){$month_name ="01";}
                        if($month_no =="2"){$month_name ="02";}
                        if($month_no =="3"){$month_name ="03";}
                        if($month_no =="4"){$month_name ="04";}
                        if($month_no =="5"){$month_name ="05";}
                        if($month_no =="6"){$month_name ="06";}
                        if($month_no =="7"){$month_name ="07";}
                        if($month_no =="8"){$month_name ="08";}
                        if($month_no =="9"){$month_name ="09";}
                        if($month_no =="10"){$month_name ="10";}
                        if($month_no =="11"){$month_name ="11";}
                        if($month_no =="11"){$month_name ="12";}


			//$sql="select count(calDate) as eCount from calTbl where calDate = '" . $eMonth . '/' . $eDay . '/' . $eYear . "'";
            $sql = "SELECT count(start_date) as eCount FROM " . $events_detail_tbl .
            " where start_date = '"  .$eYear ."-". $month_name . "-" . $eDay .  "'";;
			
			//return;

			$result = mysql_query($sql);

			while($row= mysql_fetch_array($result)){

				if($row['eCount'] >=1){

					$aClass = 'class="event"';

				}elseif($row['eCount'] ==0){

					$aClass ='class="normal"';

				}

			}

		}

		echo $aClass;

	}

?>

<table width="490" cellpadding="0" cellspacing="0">

<tr>

<td width="70" colspan="1">

<input type="button" value=" < " onClick="goLastMonth(<?php echo $month . ", " . $year; ?>);">

</td>

<td width="350" colspan="5">

<span class="title"><?php echo $monthName . " " . $year; ?></span><br>

</td>

<td width="70" colspan="1" align="right">

<input type="button" value=" > " onClick="goNextMonth(<?php echo $month . ", " . $year; ?>);">

</td>

</tr> 

<tr>

    <th>Sun</td>

    <th>Mon</td>

    <th>Tue</td>

    <th>Wed</td>

    <th>Thurs</td>

    <th>Fri</td>

    <th>Sst</td>

</tr>

<tr>

<?php

	for($i = 1; $i < $numDays+1; $i++, $counter++){

		$dateToCompare = $month . '/' . $i . '/' . $year;

		$timeStamp = strtotime("$year-$month-$i");

		//echo $timeStamp . '<br/>';

		if($i == 1){

			// Workout when the first day of the month is

			$firstDay = date("w", $timeStamp);

			for($j = 0; $j < $firstDay; $j++, $counter++){

				echo "<td>&nbsp;</td>";

			} 

		}

		if($counter % 7 == 0){

		?>

			</tr><tr>

        <?php

		}
        
        
		?>

        <!--right here--><td width="50" <?php hiLightEvt($month,$i,$year);?>><a href="<?php echo get_page_link() . '&month='. $month . '&day=' . $i . '&year=' . $year;?>&v=1"><?php echo $i;?></a></td> 

    <?php

	}

?>

</table>

<?php
  if(isset($_GET['v'])){  
                        $month_no = $month;
                        if($month_no =="1"){$month_name ="Jan";}
                        if($month_no =="2"){$month_name ="Feb";}
                        if($month_no =="3"){$month_name ="Mar";}
                        if($month_no =="4"){$month_name ="Apr";}
                        if($month_no =="5"){$month_name ="May";}
                        if($month_no =="6"){$month_name ="Jun";}
                        if($month_no =="7"){$month_name ="Jul";}
                        if($month_no =="8"){$month_name ="Aug";}
                        if($month_no =="9"){$month_name ="Sep";}
                        if($month_no =="10"){$month_name ="Oct";}
                        if($month_no =="11"){$month_name ="Nov";}
                        if($month_no =="12"){$month_name ="Dec";}
    
                       

$sql="select * from ".$events_detail_tbl." where start_month = '" . $month_name ."' AND start_day ='".$day. "' AND start_year = '".$year."'" ;

//return;

$result = mysql_query($sql);

$numRows = mysql_num_rows($result);


if($numRows == 0 ){

	echo '<h3>No Events Scheduled For '.$month_name.' '.$day.'</h3>';

}else{

//echo '<ul>';

echo '<h3>Events Scheduled For '.$month_name.' '.$day.'</h3>';
echo '';
	while($row = mysql_fetch_array($result)){

?>
<div class="output">

	<?php /*	<h5><?php echo $row['event_name'];?></h5>

    	<?php echo $row['event_desc'];?><br/>

    	Start Time: <?php echo $row['start_time'];?>
        */

        
        if ($events_calendar_url != "")
        {echo "<p align=left><b><u><a href='".$events_calendar_url."&regevent_action=register&event_id=".$row['id'].
        "&name_of_event=".$row['event_name']."'>".$row['event_name']."</a></u></b></p>";}
        else {echo "<p align=left><b><u>".$row['event_name']."</u></b></p>";}
        
		echo "Location:<b>  ".$row['event_location']."</b><br>";
		echo "Start Date:<b>  ".$row['start_date']."</b><br>";
		echo "Price:<b>  ";
		if ($event_cost != "0" || $event_cost != ""||$event_cost != "FREE" ||$event_cost != "0.00" ){echo $row['currency_format'];
		echo " ".$row['event_cost'];}
        else {echo "Free Event";}
        echo "</b><br>";
		if ($more_info != ""){
			echo '<a href="'.$row['more_info'].'"> More Info...</a>';
		}
		 
     if ($events_calendar_url != ""){
		echo "<form name='form' method='post' action='".$events_calendar_url."'>";
		echo "<input type='hidden' name='regevent_action' value='register'>";
       	echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
        echo "<input type='SUBMIT' value='$lang[register]'></form></td></tr>"; }

?>


    </div>
   

<?php
}
	

  }


}
echo "<hr>";
}
?>