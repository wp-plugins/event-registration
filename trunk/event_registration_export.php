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

$events_detail_tbl = $_GET['id'];
$events_attendee_tbl = $_GET['atnd'];
$today = date("Y-m-d"); 



$events_detail_tbl = get_option('events_detail_tbl');
$current_event = get_option('current_event');
$events_attendee_tbl = get_option('events_attendee_tbl');
$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE is_active='yes'";
$result = mysql_query($sql);
list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $allow_checks, $is_active) = mysql_fetch_array($result, MYSQL_NUM);






//counts number of fields so we can properly organize our columns and rows in excel

 
$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	   		               
$export = mysql_query($sql);  
$fields = mysql_num_fields($export); 
$header="";
$data="";
//starting a loop and extracting all the field names from our database
for ($i = 0; $i < $fields; $i++) { 
    $header.=mysql_field_name($export, $i) . "\t"; 
} 
//export the values from the database and write them into the correct columns of spreadsheet


while($row = mysql_fetch_row($export)) { 
    $line = ''; 
    foreach($row as $value) {                                             
        if ((!isset($value)) OR ($value == "")) { 
            $value = "\t"; 
        } else { 
            $value = str_replace('"', '""', $value); 
            $value = '"' . $value . '"' . "\t"; 
        } 
        $line .= $value; 
    } 
    $data .= trim($line)."\n"; 
} 
$data = str_replace("\r","",$data); 
//Examines if any data was even found.
// If no data was found or extracted, set the $data variable to tell the user there are no records
if ($data == "") { 
    $data = "\n(0) Records Found!\n";                         
} 
//Uses the header() function to tell the browser  a file that needs to be downloaded. 
//The user will see a pop-up asking them to save the spreadsheet
header("Content-type: application/x-msdownload"); 
header("Content-Disposition: attachment; filename=".$current_event."_".$today.".xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
print "$header\n$data";  
?>