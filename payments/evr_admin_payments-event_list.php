<?php
function evr_payment_event_listing(){
//define # of records to display per page
$record_limit = 15;
//get today's date to sort records between current & expired'
$curdate = date("Y-m-d");
//initiate connection to wordpress database.
global $wpdb;

?>
<div class="wrap">
<div id="icon-plugins" class="icon32"></div><h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Payment Management','evr_language');?></h2>
<div id="dashboard-widgets-wrap">
<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:90%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('Events','evr_language');?></span></h3>
                <?php
                //check database for number of records with date of today or in the future
                $sql = "SELECT * FROM ".get_option('evr_event');
                $records = mysql_query($sql);
                $items = mysql_num_rows($records); // number of total rows in the database
                
                	if($items > 0) {
                		$p = new evr_pagination;
                		$p->items($items);
                		$p->limit($record_limit); // Limit entries per page
                		$p->target("admin.php?page=payments");
                		$p->currentPage($_GET[$p->paging]); // Gets and validates the current page
                		$p->calculate(); // Calculates what to show
                		$p->parameterName('paging');
                		$p->adjacents(1); //No. of page away from the current page
                
                		if(!isset($_GET['paging'])) {
                			$p->page = 1;
                		} else {
                			$p->page = $_GET['paging'];
                		}
                
                		//Query for limit paging
                		$limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
                
                } else {
                	echo "No Record Found";
                }//End pagination
                ?>
                <div class="inside">
                    <div class="padding">
                    <div class="tablenav">
                        <div class='tablenav-pages'>
                            <?php if($items > 0) {echo $p->show();}  // Echo out the list of paging. ?>
                        </div>
                    </div>
                         <table class="widefat">
                         <thead>
                          <tr>
                            <th>Start Date</th>
                            <th>Event ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>Status</th>
                            <th># Attendees</th>
                            <th>Sales</th>
                            <th>Manage</th>
                            </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Start Date</th>
                            <th>Event ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>Status</th>
                            <th># Attendees</th>
                            <th>Sales</th>
                            <th>Manage</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        	$sql = "SELECT * FROM ". get_option('evr_event') ." ORDER BY date(start_date) DESC ".$limit;
                    		$result = mysql_query ($sql);
                            if ($items > 0 ) {
                    		while ($row = mysql_fetch_assoc ($result)){  
                         
                            $event_id       = $row['id'];
            				$event_name     = stripslashes($row['event_name']);
            				$event_location = stripslashes($row['event_location']);
                            $event_address  = $row['event_address'];
                            $event_city     = $row['event_city'];
                            $event_postal   = $row['event_postal'];
                            $reg_limit      = $row['reg_limit'];
                    		$start_time     = $row['start_time'];
                    		$end_time       = $row['end_time'];
                    		$conf_mail      = $row['conf_mail'];
                            $custom_mail    = $row['custom_mail'];
                    		$start_date     = $row['start_date'];
                    		$end_date       = $row['end_date'];
                            
                            $sql2= "SELECT SUM(quantity),SUM(payment) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
                             $result2 = mysql_query($sql2);
            			     //$num = mysql_num_rows($result2);
                             //$number_attendees = $num;
                             while($row = mysql_fetch_array($result2)){
                                $number_attendees = $row['SUM(quantity)'];
                                $payment_due = $row['SUM(payment)'];
                                }

            				
            				if ($number_attendees == '' || $number_attendees == 0){
            					$number_attendees = '0';
            				}
            				
            				if ($reg_limit == "" || $reg_limit == " "){
            					$reg_limit = "Unlimited";}
                               $available_spaces = $reg_limit;
            				
            			$expired = __( 'EXPIRED EVENT','evr_language' );
                        $active = __( 'ACTIVE EVENT','evr_language' );		
            			if ($start_date <= date('Y-m-d')){
            					$active_event = '<span style="color: #F00; font-weight:bold;">'.$expired.'</span>';
            				} else{
            					$active_event = '<span style="color: #090; font-weight:bold;">'.$active.'</span>';
            				} 
                        	?>
                            <tr></tr>
                          <tr>
                            <td><?php echo $start_date; ?></td>
                            <td><?php echo $event_id; ?></td>
                            <td><?php echo $event_name; ?></td>
                            <td><?php echo $event_location; ?></td>
                            <td><?php echo $event_city; ?></td>
                            <td><?php echo $active_event ; ?></td>
                            <td><?php echo $number_attendees?> / <?php echo $reg_limit?></td>
                            <td><?php echo $payment_due?></td>
                            <td>
                            <div style="float:left">
                              <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" name="action" value="view_payments"/>
                                <input type="hidden" name="event_id" value="<?php echo $event_id?>">
                                <input class="button-secondary" type="submit" name="Payments" value="<?php _e('Payments','evr_language');?>" />
                              </form>
                            </div>
                            </td>
                            </tr>
                            <tr></tr>
                          <?php
                        	}
                         } else { ?>
                          <tr>
                            <td>No Record Found!</td>
                          <tr>
                            <?php	}?>
                          </tbody>
                        </table>
                        <div class="tablenav">
                        <div class='tablenav-pages'>
                            <?php if($items > 0) {echo $p->show();}  // Echo out the list of paging. ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
 <?php $company_options = get_option('evr_company_settings');?>
<?php
}
?>