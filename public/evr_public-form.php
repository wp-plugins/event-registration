<?php
function evr_regform_new($event_id){
    global $wpdb;
    $company_options = get_option('evr_company_settings');
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
                            if (in_array("Company", $reg_form_defaults)) {$inc_comp = "Y";}
                            if (in_array("CoAddress", $reg_form_defaults)) {$inc_coadd = "Y";}
                            if (in_array("CoCity", $reg_form_defaults)) {$inc_cocity = "Y";}
                            if (in_array("CoState", $reg_form_defaults)) {$inc_costate = "Y";}
                            if (in_array("CoPostal", $reg_form_defaults)) {$inc_copostal = "Y";}
                            if (in_array("CoPhone", $reg_form_defaults)) {$inc_cophone = "Y";}
                            }
            $use_coupon = $row['use_coupon'];
            $reg_limit = $row['reg_limit'];
            $event_name = stripslashes($row['event_name']);
   	        $event_desc =  stripslashes($row ['event_desc']); 
            $display_desc = $row['display_desc'];  // Y or N
            $start_date = $row['start_date'];
                    $end_date = $row['end_date'];
					$start_month = $row ['start_month'];
					$start_day = $row ['start_day'];
					$start_year = $row ['start_year'];
					$end_month = $row ['end_month'];
					$end_day = $row ['end_day'];
					$end_year = $row ['end_year'];
					$start_time = $row ['start_time'];
					$end_time = $row ['end_time'];
    }
    $cap_url = EVR_PLUGINFULLURL . "cimg/";
    $md5_url = EVR_PLUGINFULLURL . "md5.js";
//Begin Page Content    
    echo "<h3>".$event_name."</h3>";
 //echo date($evr_date_format,strtotime($start_date))." ".$start_time." - ";
 //if ($end_date != $start_date) {echo date($evr_date_format,strtotime($end_date));} echo " ".$end_time;
 //echo "<br />";
    if ($display_desc =="Y"){ echo "<blockquote>".html_entity_decode($event_desc)."</blockquote>"; }
    ?>
<script type="text/javascript" src="<?php echo $md5_url; ?>"></script>
<?php if ($company_options['captcha'] == 'Y') { ?>
    <script type="text/javascript"> var imgdir = "<?php echo $cap_url; ?>"; </script>
    <script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL;?>public/captcha.js.php"></script>
<?php } 
if ($company_options['captcha'] == 'Y') {$captcha = "Y";} else {$captcha="N";}
?>
<script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL;?>public/validate.js.php?captcha=<?php echo $captcha;?>"></script> 
    <?php
    $tax_rate = .0;
    if ($company_options['use_sales_tax'] == "Y"){ 
        $tax_rate = .0875;
        if ($company_options['sales_tax_rate'] != "") { 
            $tax_rate = $company_options['sales_tax_rate'];
            echo '<script type="text/javascript" src="'. EVR_PLUGINFULLURL.'public/calculator.js.php?tax='.$tax_rate.'"></script>';
        }
    } 
    else {
        echo '<script type="text/javascript" src="'. EVR_PLUGINFULLURL.'public/calculator.js.php?tax='.$tax_rate.'"></script>';
        } 
        ?>
   
<style>
    <?php echo   $company_options['form_css'];?>
</style>


<div id="evrRegForm">
<?php

$exp_date = $end_date;
$todays_date = date("Y-m-d");
$today = strtotime($todays_date);
$expiration_date = strtotime($exp_date);
                               
if ($expiration_date <= $today){
    echo '<br/><font color="red">Registration is closed for this event.  <br/>For more information or questions, please email: </font><a href="mailto:'.$company_options['company_email'].'">'.$company_options['company_email'].'</a>';
    } 
    else {?> 
    <form    class="evr_regform" method="post" action="<?php echo evr_permalink($company_options['evr_page_id']);?>" onSubmit="mySubmit.disabled=true;return validateForm(this)">

        <ul>
        <li>
        <label for="fname"><?php _e('First Name','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="fname" name="fname" value="" /></span>
        </li>
        
        <li>
        <label for="lname"><?php _e('Last Name','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="lname" name="lname" value="" /></span>
        </li>
        
        <li>
        <label for="emailaddress"><?php _e('Email Address','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="email" name="email" value="" /></span>
        </li>
        
        
        <?php if ($inc_phone == "Y") { ?>
        <li>
        <label for="phone"><?php _e('Phone Number','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="phone" name="phone" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_address == "Y") { ?>
        <li>
        <label for="address"><?php _e('Street/PO Address','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="address" name="address" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_city == "Y") { ?>
        <li>
        <label for="city"><?php _e('City','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="city" name="city" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_state == "Y") { ?>
        <li>
        <label for="state"><?php _e('State','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="state" name="state" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_zip == "Y") { ?>
        <li>
        <label for="zip"><?php _e('Postal/Zip Code','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="zip" name="zip" value="" /></span>
        </li>
        <?php } ?>
        <hr />
        
        <?php if ($inc_comp == "Y") { ?>
        
        <li>
        <label for="company"><?php _e('Company Name','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="company" name="company" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_coadd == "Y") { ?>
        <li>
        <label for="co_address"><?php _e('Company Address','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="co_address" name="co_address" value="" /></span>
        </li>
        <?php } ?>
        
        <?php if ($inc_cocity == "Y") { ?>
        <li>
        <label for="co_city"><?php _e('Company City','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="co_city" name="co_city" value="" /></span>
        </li>
        <?php } ?>
        <?php if ($inc_costate == "Y") { ?>
        <li>
        <label for="co_state"><?php _e('Company State/Province','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="co_state" name="co_state" value="" /></span>
        </li>
        <?php } ?>
        <?php if ($inc_copostal == "Y") { ?>
        <li>
        <label for="co_zip"><?php _e('Company Postal Code','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="co_zip" name="co_zip" value="" /></span>
        </li>
        <?php } ?>
        <?php if ($inc_cophone == "Y") { ?>
        <li>
        <label for="co_phone"><?php _e('Company Phone','evr_language');?></label>
        <span class="fieldbox"><input type="text" id="co_phone" name="co_phone" value="" /></span>
        </li>
        <?php } ?>
        <hr />
        
        
        <?php
        //Additional Questions
            $questions = $wpdb->get_results("SELECT * from ".get_option('evr_question')." where event_id = '$event_id' order by sequence");
            if ($questions) {
                foreach ($questions as $question) {
                    ?>
                    <li>
                    <label for="question-<?php echo $question->id;?>">
                    <?php
                    echo $question->question;
                    ?>
                    </label>
                    <?php evr_form_build($question);?>
                    </li>
                    <?php
                }
            }
        ?>
        
        
        <?php if ($use_coupon == "Y") { ?>
        <li>
        <label for="coupon"><?php _e('Enter coupon code for discount','evr_language');?></label> 
        <span class="couponbox"><input type="text" id="coupon" name="coupon" value="" /></span>
        </li> 
        <?php } ?>
        </ul><br />
        <?php 
        
        /* df change	$sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
                                    		$result2 = mysql_query($sql2);
                                            $num = 0;   
                                    		while($row = mysql_fetch_array($result2)){$num =  $row['SUM(quantity)'];};
                                            
                                            $available = $reg_limit - $num;
                                            */
        $num = 0;                              
        $sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
        $attendee_count  = $wpdb->get_var($sql2);
        If ($attendee_count >= 1) {$num = $attendee_count;}
        $available = $reg_limit - $num;
        //echo "count is ". $attendee_count." !";
                                         
        if ($available >= "1"){ 
                                                
                                        $sql = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
                                        $result = mysql_query ( $sql );
        if (mysql_num_rows($result) != 0) {
                                        
                                                ?>                
                                    <hr />
                                    <br /><h2 ><?php _e('REGISTRATION FEES','evr_language');?></h2><br />
                                    <p><font color="red">You must select at least one item!</font></p>
                                     <?php
                                        
                                        $open_seats = $available;
                                        $curdate = date("Y-m-d");
                                        $fee_count = 0;
                                        $isfees = "N";
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
                                           
                                            
                                    if((evr_greaterDate($curdate,$item_start_date))&& (evr_greaterDate($item_end_date,$curdate))){
                                        $req = '';
                                        $isfees="Y";
                                       
                                    ?>
                                    <input type="hidden" name="reg_type" value="RGLR"/>
                                    <div align="left">
                                    <?php if ($company_options['use_sales_tax'] == "Y"){ ?>
                                    <select name="PROD_<?php echo $event_id . "-" . $item_id . "_" . $item_price; ?>" id = "PROD_<?php echo
                                            $event_id . "-" . $item_id . "_" . $item_price; ?>" onChange="CalculateTotalTax(this.form)"  >
                                     <?php } else { ?>
                                    <select name="PROD_<?php echo $event_id . "-" . $item_id . "_" . $item_price; ?>" id = "PROD_<?php echo
                                            $event_id . "-" . $item_id . "_" . $item_price; ?>" onChange="CalculateTotal(this.form)"  >
                                     <?php } ?>      
                                            
                                    <option value="0">0</option>
                                    <?php
                                    if ($item_cat == "REG"){
                                     if ($item_limit != ""){
                                        if ($available >= $item_limit){$units_available = $item_limit;} else {$units_available = $available;}
                                        }
                                     for($i=1; $i<=$units_available; $i++) { ?>
                                            <option value="<?php echo($i); ?>"><?php echo($i); ?></option>
                                    	<?php } }
                                        
                                    if ($item_cat != "REG"){
                                    $num_select = "10";    
                                    if ($item_limit != ""){
                                        $num_select = $item_limit;}
                                        
                                     for($i=1; $i<$num_select+1; $i++) { ?>
                                            <option value="<?php echo($i); ?>"><?php echo($i); ?></option>
                                    	<?php } } 
                                    ?>
                                    </select>
                                    
                                    
                                    <?php if ($item_custom_cur == "GBP"){$item_custom_cur = "&pound;";}
                                    if ($item_custom_cur == "USD"){$item_custom_cur = "$";}
                                    echo $item_title . "    " . $item_custom_cur . " " . $item_price; ?></div>
                                    <?php 
                                    
                                    } 
                                    
                                        
                                    
                                    }
                                    if ($isfees == "N"){
                                        echo "<br/>";
                                        echo "<hr><font color='red'>";
                                        
                                        _e('No Fees/Items available for todays date!','evr_language');
                                        echo "<br/>";
                                        _e('Please update fee dates!','evr_language');
                                        echo "<br/>";
                                        echo "</font>";
                                        ?>
                                        <input type="hidden" name="reg_type" value="WAIT" />
                                        <?php
                                        }?>
                                    
                                    <br />

<?php if ($company_options['use_sales_tax'] == "Y"){ ?>
                                    <table>
                                    <tr><td><b><?php _e('Registration Fees','evr_language');?></b></td><td><input type="text" name="fees" id="fees" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
                                    <tr><td><b><?php _e('Sales Tax','evr_language');?></b></td><td><input type="text" name="tax" id="tax" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
                                    <tr><td><b><?php _e('Total','evr_language');?></b></td><td><input type="text" name="total" id="total" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
                                    </table>
<?php } else { ?>
                                    <br />
                                    <b><?php _e('Total   ','evr_language');?><input type="text" name="total" id="total" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></b>
<?php } ?>
                                    <br />
                                    <?php
                                       
                                    } else {
                                        echo "<br/>";
                                        echo "<hr><font color='red'>";
                                        
                                        _e('No Fees Have Been Setup For This Event!','evr_language');
                                        echo "<br/>";
                                        _e('Registrations will be placed on the wait list!','evr_language');
                                        echo "<br/></font>";
                                        ?>
                                        <input type="hidden" name="reg_type" value="WAIT" />
                                        <?php
                                        }
                                    } else {
                                        echo '<hr><br><b><font color="red">';
                                        _e('This event has reached registration capacity.','evr_language');
                                        echo "<br>";
                                        _e('Please provide your information to be placed on the waiting list.','evr_language');
                                        echo '</b></font>';
                                        ?>
                                        <input type="hidden" name="reg_type" value="WAIT" />
                                        <?php   
                                    }
                                    ?>
                                    
                                    
                                     
                                    <hr />
        
        <br />
        <?php if ($company_options['captcha'] == 'Y') { ?>
        <p><?php _e('Enter the security code as it is shown (required)','evr_language');?>:
        <script type="text/javascript">sjcap("altTextField");</script></p>
        <noscript><p>[<?php _e('This resource requires a Javascript enabled browser.','evr_language');?>]</p></noscript>
        <?php } ?>
        
        <input type="hidden" name="action" value="confirm"/>
        <input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
        <div style="margin-left: 150px;">
        <input type="submit" name="mySubmit" id="mySubmit" value="<?php _e('Submit','evr_language');?>" disabled="true"/> <input type="reset" value="<?php _e('Reset','evr_language');?>"  />
        </div>
        </form>
<?php } ?>
</div>
<?php
}
?>