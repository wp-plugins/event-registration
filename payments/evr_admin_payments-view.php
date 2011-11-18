<?php
function evr_admin_view_payments(){
    global $wpdb;
    //$event_id = $_REQUEST['event_id'];
    (is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
    $sql = "SELECT * FROM ". get_option('evr_event') ." WHERE id = $event_id";
                    		$result = mysql_query ($sql);
    while ($row = mysql_fetch_assoc ($result)){  
    $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            if ($reg_form_defaults !=""){
                            if (in_array("Address", $reg_form_defaults)) {$inc_address = "Y";}
                            if (in_array("City", $reg_form_defaults)) {$inc_city = "Y";}
                            if (in_array("State", $reg_form_defaults)) {$inc_state = "Y";}
                            if (in_array("Zip", $reg_form_defaults)) {$inc_zip = "Y";}
                            if (in_array("Phone", $reg_form_defaults)) {$inc_phone = "Y";}
                            }
    $use_coupon = $row['use_coupon'];
    $reg_limit = $row['reg_limit'];
    $event_name = stripslashes($row['event_name']);
    
                            }
?>
<div class="wrap">
<h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Payment Management','evr_language');?></h2>
<form name="form" method="post" action="admin.php?page=payments">
                                    <input class="button-secondary" type="submit" name="Select Different" value="<?php _e('Select A Different Event','evr_language');?>" />
                                </form>  
    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
        	<div class='postbox-container' style='width:85%;'>
                <div id='normal-sortables' class='meta-box-sortables'>
                    <div id="dashboard_right_now" class="postbox " >
                         
                        <h3 class='hndle'><span><?php _e('View Payments:','evr_language');?><?php echo "  ".$event_name;?></span></h3>
                        <?php
                            $record_limit = 15;
                            //check database for number of records with date of today or in the future
                            $sql = "SELECT * FROM ".get_option('evr_attendee');
                            $records = mysql_query($sql);
                            $items = mysql_num_rows($records); // number of total rows in the database
                            
                            	if($items > 0) {
                            		$p = new evr_pagination;
                            		$p->items($items);
                            		$p->limit($record_limit); // Limit entries per page
                            		$p->target("admin.php?page=payments&action=view_payments&event_id=".$event_id);
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
                            <?php echo $p->show();  // Echo out the list of paging. ?>
                        </div>
                    </div>       
                            <table class="widefat">
                                <thead>
                                <tr><th><?php _e('# People','evr_language');?></th><th><?php _e('Name','evr_language');?> </th><th><?php _e('Total','evr_language');?></th><th><?php _e('Order Detail','evr_language');?></th><th><?php _e('Payments','evr_language');?></th><th><?php _e('Action','evr_language');?></th></tr>
                                </thead>
                                <tfoot>
                                <tr><th><?php _e('# People','evr_language');?></th><th><?php _e('Name','evr_language');?> </th><th><?php _e('Total','evr_language');?></th><th><?php _e('Order Detail','evr_language');?></th><th><?php _e('Payments','evr_language');?></th><th><?php _e('Action','evr_language');?></th></tr>
                                </tfoot>
                                <tbody>
                                <?php
                
                            $sql = "SELECT * FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id' ORDER BY lname ASC ".$limit;
                            $result = mysql_query ( $sql );
                            while ( $row = mysql_fetch_assoc ( $result ) ) {
                                    $attendee_id = $row['id'];
                                    $lname = $row ['lname'];
                        			$fname = $row ['fname'];
                        			$address = $row ['address'];
                        			$city = $row ['city'];
                        			$state = $row ['state'];
                        			$zip = $row ['zip'];
                        			$email = $row ['email'];
                        			$phone = $row ['phone'];
                        			$quantity = $row ['quantity'];
                        			$date = $row ['date'];
                        			$reg_type = $row['reg_type'];
                                    $ticket_order = unserialize($row['tickets']);
                                    $payment= $row['payment'];
                                    $event_id = $row['event_id'];
                                    $coupon = $row['coupon'];
                                    
                    			echo "<tr><td>".$quantity."</td><td align='left'>" . $lname . ", " . $fname . "</td><td>" . $payment . "</td><td>";
                                $row_count = count($ticket_order);
                                    for ($row = 0; $row < $row_count; $row++) {
                                       echo $ticket_order[$row]['ItemQty']." ".$ticket_order[$row]['ItemCat']."-".$ticket_order[$row]['ItemName']." ".$ticket_order[$row]['ItemCurrency'] . " " . $ticket_order[$row]['ItemCost']."<br \>";
                                       } 
                                echo "</td>";
                                echo "<td>";
                                $sql3 = "SELECT * FROM " . get_option('evr_payment') . " WHERE payer_id='$attendee_id' ";
                             
                             $result3 = mysql_query ( $sql3 );
                             $made_payments = mysql_num_rows($result3); // number of total rows in the database
                            if($made_payments > 0)  { 
                            while ( $row3 = mysql_fetch_assoc ( $result3 ) ) {
                                echo  $row3['mc_currency']." ".$row3['mc_gross']." ".$row3['txn_type']." ".$row3['txn_id']." (".$row3['payment_date'].")"."     ".
                                '<a href="admin.php?page=payments&action=delete_payment&event_id='.$event_id.'&id='.$row3['id'].'">'.__('Delete','evr_language').'</a>   |  '.
                                '<a href="admin.php?page=payments&action=edit_payment&event_id='.$event_id.'&id='.$row3['id'].'">'.__('Edit','evr_language').'</a><br />';
                                }}
                                else {
                                    echo '<font color="red">';
                                _e('No Payments Received!','evr_language');
                                echo '</font>';}
                                
                                             		        
                                ?>
                                </td><td>
                                <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" name="action" value="add_payment"/>
                                <input type="hidden" name="event_id" value="<?php echo $event_id?>">
                                <input type="hidden" name="attendee_id" value="<?php echo $attendee_id?>">
                                <input class="button-secondary" type="submit" name="Add Payment" value="<?php _e('Add Payment','evr_language');?>" />
                                </form>
                                </td> </tr>
                                <?php   }  
                            echo "</table>";
                            ?>
                            <button style="background-color: lightgreen" onclick="window.location='<?php echo EVR_PLUGINFULLURL . "evr_admin_export.php?id=" . $event_id. "&action=payment";?>'" style="width:180; height: 30">Export Payment to Excel</button>            

                            <div class="tablenav">
                        <div class='tablenav-pages'>
                            <?php echo $p->show();  // Echo out the list of paging. ?>
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
<?php
}
?>