<?php
function evr_attendee_event_listing(){
//define # of records to display per page
$record_limit = 15;
//get today's date to sort records between current & expired'
$curdate = date("Y-m-d");
//initiate connection to wordpress database.
global $wpdb;

?>
<div class="wrap">
<div id="icon-plugins" class="icon32"></div><h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Attendee Management','evr_language');?></h2>
<div id="dashboard-widgets-wrap">
<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:90%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('Active Events','evr_language');?></span></h3>
                <?php
                //check database for number of records with date of today or in the future
                $sql = "SELECT * FROM ".get_option('evr_event');
                $records = mysql_query($sql);
                $items = mysql_num_rows($records); // number of total rows in the database
                
                	if($items > 0) {
                		$p = new evr_pagination;
                		$p->items($items);
                		$p->limit($record_limit); // Limit entries per page
                		$p->target("admin.php?page=attendee");
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
                            <?php if($items > 0) { echo $p->show();}  // Echo out the list of paging. ?>
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
                            <th>Manage</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        	                            
                          $rows = $wpdb->get_results( "SELECT * FROM ". get_option('evr_event') ." ORDER BY date(start_date) DESC ".$limit );
                          if ($rows){
                            foreach ($rows as $event){
                            
                                        $event_id       = $event->id;
                        				$event_name     = stripslashes($event->event_name);
                        				$event_location = stripslashes($event->event_location);
                                        $event_address  = $event->event_address;
                                        $event_city     = $event->event_city;
                                        $event_postal   = $event->event_postal;
                                        $reg_limit      = $event->reg_limit;
                                		$start_time     = $event->start_time;
                                		$end_time       = $event->end_time;
                                		$conf_mail      = $event->conf_mail;
                                        $custom_mail    = $event->custom_mail;
                                		$start_date     = $event->start_date;
                                		$end_date       = $event->end_date;
                                        
                            
                            $number_attendees = $wpdb->get_var($wpdb->prepare("SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id';"));
                            
                                      				
            				if ($number_attendees == '' || $number_attendees == 0){
            					$number_attendees = '0';
            				}
            				
            				if ($reg_limit == "" || $reg_limit == " "){
            					$reg_limit = "Unlimited";}
                               $available_spaces = $reg_limit;
            				
            					
            			if ($start_date <= date('Y-m-d')){
            					$active_event = '<span style="color: #F00; font-weight:bold;">EXPIRED EVENT</span>';
            				} else{
            					$active_event = '<span style="color: #090; font-weight:bold;">ACTIVE EVENT</span>';
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
                            <td>
                            <div style="float:left">
                              <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" name="action" value="view_attendee"/>
                                <input type="hidden" name="event_id" value="<?php echo $event_id?>">
                                <input class="button-secondary" type="submit" name="Attendees" value="<?php _e('Attendees','evr_language');?>" />
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
                            <?php if($items > 0) { echo $p->show();  }// Echo out the list of paging. ?>
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