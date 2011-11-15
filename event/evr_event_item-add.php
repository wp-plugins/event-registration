<?php
//function to add sale items
function evr_add_item(){
    
//get today's date to sort records between current & expired'
$curdate = date("Y-m-d");
//initiate connection to wordpress database.
global $wpdb;
$company_options = get_option('evr_company_settings');

?>
<style>
#fade { /*--Transparent background layer--*/
	display: none; /*--hidden by default--*/
	background: #000;
	position: fixed; left: 0; top: 0;
	width: 100%; height: 100%;
	opacity: .80;
	z-index: 9999;
}
.popup_block{
	display: none; /*--hidden by default--*/
	background: #fff;
	padding: 20px;
	border: 20px solid #ddd;
	float: left;
	font-size: .8em;
	position: fixed;
	top: 50%; left: 50%;
    
	z-index: 99999;
	/*--CSS3 Box Shadows--*/
	-webkit-box-shadow: 0px 0px 20px #000;
	-moz-box-shadow: 0px 0px 20px #000;
	box-shadow: 0px 0px 20px #000;
	/*--CSS3 Rounded Corners--*/
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
}
img.btn_close {
	float: right;
	margin: -55px -55px 0 0;
}
/*--Making IE6 Understand Fixed Positioning--*/
*html #fade {
	position: absolute;
}
*html .popup_block {
	position: absolute;
}
</style>
<script type="text/javascript">

jQuery(document).ready(function($){
	 					   		   
							   		   
	//When you click on a link with class of poplight and the href starts with a # 
	$('a.poplight[href^=#]').click(function() {
		var popID = $(this).attr('rel'); //Get Popup Name
		var popURL = $(this).attr('href'); //Get Popup href to define size
				
		//Pull Query & Variables from href URL
		var query= popURL.split('?');
		var dim= query[1].split('&');
		var popWidth = dim[0].split('=')[1]; //Gets the first query string value

		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="<?php echo EVR_PLUGINFULLURL;?>images/btn-close.png" class="btn_close" title="Close Window" alt="Close" /></a>');
		
		//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		
		//Apply Margin to Popup
		$('#' + popID).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		//Fade in Background
		$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
		
		return false;
	});
	
	   
	//Close Popups and Fade Layer
	$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
	  	$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();  
	}); //fade them both out
		
		return false;
	});

	
});
</script>


<?php
$currency_format = $company_options['default_currency'];;
    $curdate = date("Y-m-d");
 	$event_id = $_REQUEST ['event_id'];
	$sql = "SELECT * FROM " . get_option ( 'evr_event' ). " WHERE id =" . $event_id;
	$result = mysql_query ( $sql );
	while ($row = mysql_fetch_assoc ($result)){
				            $event_id       = $row['id'];
                    	    $event_name = stripslashes($row['event_name']);
        					$event_identifier = stripslashes($row['event_identifier']);
        					$display_desc = $row['display_desc'];  // Y or N
                            $event_desc = stripslashes($row['event_desc']);
                            $event_category = unserialize($_REQUEST['event_category']);
        					$reg_limit = $row['reg_limit'];
        					$event_location = $row['event_location'];
                            $event_address = $row['event_address'];
                            $event_city = $row['event_city'];
                            $event_state =$row['event_state'];
                            $event_postal=$row['event_postcode'];
                            $google_map = $row['google_map'];  // Y or N
                            $start_month = $row['start_month'];
        					$start_day = $row['start_day'];
        					$start_year = $row['start_year'];
                            $end_month = $row['end_month'];
        					$end_day = $row['end_day'];
        					$end_year = $row['end_year'];
                            $start_time = $row['start_time'];
        					$end_time = $row['end_time'];
                            $allow_checks = $row['allow_checks'];
                            $outside_reg = $row['outside_reg'];  // Yor N
                            $external_site = $row['external_site'];
                            $reg_form_defaults = unserialize($row['reg_form_defaults']);
                            $more_info = $row['more_info'];
        					$image_link = $row['image_link'];
        					$header_image = $row['header_image'];
                            $event_cost = $row['event_cost'];
                            $allow_checks = $row['allow_checks'];
        					$is_active = $row['is_active'];
        					$send_mail = $row['send_mail'];  // Y or N
        					$conf_mail = stripslashes($row['conf_mail']);
        					$start_date = $row['start_date'];
                            $end_date = $row['end_date'];
                            $use_coupon = $row['use_coupon'];
                            $coupon_code = $row['coupon_code'];
                            $coupon_code_price = $row['coupon_code_price'];
                            
                    
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

?>



<div class="wrap">
<div id="icon-plugins" class="icon32"></div><h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Event Management','evr_language');?></h2>
<div id="dashboard-widgets-wrap">




<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:55%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('Event Items:','evr_language');?><?php echo $event_name." at ".$event_location."  ".$start_date."-".$end_date;?></span></h3>
                 <div class="inside">
                    <div class="padding">
                    
<?php

$start = strtotime('6:00am');
$end = strtotime('11:45pm');


?>
<style>
.tooltip a{
    cursor:default!important;
    background:url(<?php echo EVR_PLUGINFULLURL;?>images/red.png) no-repeat bottom left;
    text-decoration:none;
    position:relative;top:-1px
}

.tooltip a span{
    padding:0 5px;
    visibility:hidden
}

.tooltip a:hover{
    text-decoration:none!important
}
.er_ticket_info a{
    cursor:default!important;
    background:url(<?php echo EVR_PLUGINFULLURL;?>images/info-icon.png) no-repeat bottom left;
    text-decoration:none;
    position:relative;top:-1px
}

.er_ticket_info a span{
    padding:0 5px;
    visibility:hidden
}

.er_ticket_info a:hover{
    text-decoration:none!important
}

/*------------------POPUPS------------------------*/
#fade {
	display: none;
	background: #000; 
	position: fixed; left: 0; top: 0; 
	z-index: 10;
	width: 100%; height: 100%;
	opacity: .80;
	z-index: 9999;
}
.popup_block{
	display: none;
	background: #fff;
	padding: 20px; 	
	border: 20px solid #ddd;
	float: left;
	font-size: 1.2em;
	position: fixed;
	top: 50%; left: 50%;
	z-index: 99999;
	-webkit-box-shadow: 0px 0px 20px #000;
	-moz-box-shadow: 0px 0px 20px #000;
	box-shadow: 0px 0px 20px #000;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
}
img.btn_close {
	float: right; 
	margin: -55px -55px 0 0;
}
.popup p {
	padding: 5px 10px;
	margin: 5px 0;
}
/*--Making IE6 Understand Fixed Positioning--*/
*html #fade {
	position: absolute;
}
*html .popup_block {
	position: absolute;
}
</style>

       <div class="postbox " style='width:98%;'>
			<h2><span><img src="<?php echo EVR_PLUGINFULLURL;?>images/icon_ticket.png" alt="tickets" style="vertical-align:middle" /> REGISTRATION/TICKET TYPES</span></h2>
			<p> Add tickets to set pricing for your event (Adult, Child, VIP, etc.) </p>
            <br /><br />
            
			<table class="widefat">
            
				<thead>
					<tr>
						<th class="full first" width="250"> <span class="cufon"> <?php _e('Name','evr_language');?> </span> </th>
						<th class="center" width="100"> <span class="cufon"> <?php _e('Price','evr_language');?> </span> </th>
						<th class="center" width="150"> <span class="cufon"> <?php _e('Start','evr_language');?> </span> </th>
                        <th class="center" width="150"> <span class="cufon"> <?php _e('End','evr_language');?> </span> </th>
						<th class="center" colspan="2">
							<div> <span class="cufon"><?php _e('Actions','evr_language');?></span> </div>
						</th>
					</tr>
				</thead>
				<tfoot>
                  	<tr>
						<th class="full first" width="250"> <span class="cufon"> <?php _e('Name','evr_language');?> </span> </th>
						<th class="center" width="100"> <span class="cufon"> <?php _e('Price','evr_language');?> </span> </th>
						<th class="center" width="150"> <span class="cufon"> <?php _e('Start','evr_language');?> </span> </th>
                        <th class="center" width="150"> <span class="cufon"> <?php _e('End','evr_language');?> </span> </th>
						<th class="center" colspan="2">
							<div> <span class="cufon"><?php _e('Actions','evr_language');?></span> </div>
						</th>
					</tr>  
                    
               </tfoot>
         <tbody>
               
    <?php
    $sql = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
    $result = mysql_query ( $sql );
	while ($row = mysql_fetch_assoc ($result)){
                      //<a href='admin.php?page=events&action=edit_item&event_id=".$event_id."&item_id=".$item_id."&end_date=".$end_date."'
            //do not update sequence - leave as is
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
            echo "<tr><td class='er_ticket_info' title='".$item_description."'>";
            if ($free_item == "Y"){?><img src="<?php echo EVR_PLUGINFULLURL;?>images/free_icon.png" alt="free" style="vertical-align:middle" />&nbsp;<?php }
            if ($free_item == "N"){ ?><img src="<?php echo EVR_PLUGINFULLURL;?>images/dollar_icon.png" alt="free" style="vertical-align:middle" /> <?php }
            echo $item_cat." | ".$item_title." <a><span>?</span></a></td><td align='right'>".$item_custom_cur." ".$item_price."</td><td align='center'>".$item_start_date."</td><td align='center'>".$item_end_date."</td>";
            ?>
            <td width="75" align="right"><a href="#?w=700" rel="popup<?php echo $item_id;?>" class="poplight"><img src="<?php echo EVR_PLUGINFULLURL;?>images/small_gear.png" alt="Edit" /></td>
            <td width="75" align="left"><a href="admin.php?page=events&action=delete_item&event_id=<?php echo $event_id;?>&item_id=<?php echo $item_id;?>&end_date=<?php echo $end_date;?>&end=<?php echo $end_date;?>"><img src="<?php echo EVR_PLUGINFULLURL;?>images/redx.png" alt="Delete" />
            </td><tr>
            <?php }      ?>
			</tbody></table>
            
            <br />
            <div style="float: left;">
            <div class="padding">
            <a href="#?w=500" rel="popup0" class="poplight"><button class="button-secondary"><?php _e('ADD COST/ITEM','evr_language');?></button></a>
            </div></div>
            <div style="float: right;">
            <div class="padding">
            <a class="button-secondary" href="admin.php?page=events&action=reorder_item&event_id=<?php echo $event_id;?>" title="REARRANGE ITEMS"><?php _e('RE-ARRANGE ITEMS','evr_language');?></a>
            </div></div>
            <br /><br />
         </div>
          <div class="postbox" style='width:98%;' ><div class="inside">
                    <div class="padding">
         
         <h2><span><img src="<?php echo EVR_PLUGINFULLURL;?>images/discount_icon.png" alt="tickets" style="vertical-align:middle" /> <?php _e('COUPON CODE','evr_language');?></span></h2>
         <form name="discount" method="post" action="<?php echo "admin.php?page=events&action=update_coupon&event_id=". $event_id."&end_date=".$_REQUEST['end'];?>">
         
        <ul><li>
        
        <label class="tooltip" title="<?php _e('A coupon code is a promotional code you can tie to your event.  The code is valid for a discount off the total registration cost.">
	       Do you want to use a coupon code for this event? ','evr_language');?><a><span>?</span></a></label>
            <input type="radio" class="radio" name="use_coupon" value="Y" <?php if ($use_coupon == "Y") { echo "checked";}?>/> <?php _e('Yes','evr_language');?> 
            <input type="radio" class="radio" name="use_coupon" value="N" <?php if ($use_coupon == "N") { echo "checked";}?>/><?php _e('No','evr_language');?> 
            </li>
            <li>
            <label class="tooltip" title="<?php _e('This should be a one word code with no spaces or extra characters. Recomend ALL CAPS.','evr_language');?>">
					<?php _e('Enter the Code','evr_language');?> <a><span> ?</span></a></label> 
					<input id="coupon_code" name="coupon_code" type="text" value="<?php echo $coupon_code;?>"/></li>
				    
                     <li><label class="tooltip" title="<?php _e('Enter the amount with two decimal places.  Do not put a - sign, as that is done during calculations  ','evr_language');?>">
					<?php _e('Discount amount for Coupon Code','evr_language');?> <a><span> ?</span></a></label>
					<input id="coupon_code_price" name="coupon_code_price" type="text" value="<?php echo $coupon_code_price;?>"/>
				     </li>
                   
        
        </u>
         <br /><br /><br />
    <input type="hidden" name="page" value="events"/>
    <input type="hidden" name="action" value="update_coupon"/>
    <input type="hidden" name="id" value="<?php echo $event_id;?>"/>
    <input type="hidden" name="end" value="<?php echo $end_date;?>"?>
    <button type="submit" style="font-size:110%; border-color:RED; background-color: #BBBBBB; color: #GGG; font-weight: bolder;"><?php _e('UPDATE COUPON CODE','evr_language');?></button><br /></form>
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
</div> 
<!-- PopUp Window Form for Event Cost -->
<!--POPUP START-->
<div id="popup0" class="popup_block">

<form action="" method="POST" >
    <input type="hidden" name="page" value="events">
    <input type="hidden" name="action" value="post_item">
    <input type="hidden" name="event_id" value="<?php echo $_REQUEST['event_id'];?>"/>
    <input type="hidden" name="event_end" value="<?php echo $end_date;?>"/>
    
    
    
    <h3><?php _e('Add Event Cost/Item for ','evr_language'); echo $event_name;?></h3>					
                <br /><ul>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Select a Item/Cost category.  Note that category REG is used for attendance count, all others are not included in attendance count.','evr_language');?>">
                        <?php _e('What type of Item/Cost is this?','evr_language');?> <a><span>?</span></a> </label>
                        <select class="title" name="item_cat">
                        <option value="REG">REG - <?php _e('Registration Attendee','evr_language');?></option>
                        <option value="MDS">MDS - <?php _e('Merchandise','evr_language');?></option>
                        <option value="DSC">DSC - <?php _e('Discount','evr_language');?></option>
                        <option value="WRK">WRK - <?php _e('Workshop','evr_language');?></option>
                        <option value="MLS">MLS - <?php _e('Meal or Food','evr_language');?></option>
                        </select>
                    </li>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Use a concise but descriptive name.','evr_language');?>" ><?php _e('Name of Cost/Item','evr_language');?> <a><span>?</span></a></label>
                        <input class="title" name="item_name"/>
                    </li>
                    <li>
                        <label for="cost_desc" class="er_ticket_info" title="<?php _e('Provide a description of the cost/ticket.','evr_language');?>"><?php _e('Description of Cost','evr_language');?> <a><span>?</span></a></label>
                        <input class="desc"  name="item_desc" id="cost_desc"/> 
                    </li>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Provide the number of available item/cost types per registration form. If it is a REG item, available seats will impact overall amount available. Leave blank if no limit.','evr_language');?>"><?php _e('Available items/cost per registration/order?','evr_language');?> <a><span>?</span></a></label>
                        <input class="title" name="item_limit"/>
                    </li>
                    <hr />
   					<h3><?php _e('VALUE/COST','evr_language');?></h3>
				    <li>
                        <label  class="er_ticket_info" title="<?php _e('Please select no for event pricing setup, select yes for free event','evr_language');?>">
        					<?php _e('Will this be a free item?','evr_language');?><a><span><img src="http://localhost/test/wp-content/plugins/EVR/images/info-icon.png"/></span></a></label>
                        <input type="radio" name="item_free" class="radio" id="free_yes" value="Y"   checked > <?php _e('Yes','evr_language');?> 
                        <input type="radio" name="item_free" class="radio" id="free_no" value="N"  /><?php _e('No','evr_language');?>  
                    </li>
                    <li>
                        <label  class="er_ticket_info" title="<?php _e('Please select the country in which the currency format will be used','evr_language');?>"><?php _e('Custom Currency','evr_language');?><a><span>?</span></a></label>
        					<select class="select" name = "custom_cur">
                                <?php if ($currency_format !=""){echo "<option value='" . $currency_format . "'>" . $currency_format . "</option>";} ?>
                                    <option value="USD">USD</option>
                                    <option value="AUD">AUD</option>
                                    <option value="GBP">GBP</option>
                                    <option value="CAD">CAD</option>
                                    <option value="CZK">CZK</option>
                                    <option value="DKK">DKK</option>
                                    <option value="EUR">EUR</option>
                                    <option value="HKD">HKD</option>
                                    <option value="HUF">HUF</option>
                                    <option value="ILS">ILS</option>
                                    <option value="JPY">JPY</option>
                                    <option value="MXN">MXN</option>
                                    <option value="NZD">NZD</option>
                                    <option value="NOK">NOK</option>
                                    <option value="PLN">PLN</option>
                                    <option value="SGD">SGD</option>
                                    <option value="SEK">SEK</option>
                                    <option value="CHF">CHF</option></select>
                    </li>
        			<li>
                    
                        <label  class="er_ticket_info" title="<?php _e('Please enter the amount using 2 decimal point (i.e. 10.00) for the registration cost.  Use minus symbol before for discount amounts (i.e. -5.00).','evr_language');?>">
    				    <?php _e('Item/Cost Value','evr_language');?> <a><span>?</span></a></label>
       					<input class="price" id="item_price" name="item_price" type="text" maxlength="10" value="0.00" />
                    </li>
                    <hr />
        			<?php $popup_date_end = strtotime($_REQUEST['end']);?>
					<h3><?php _e('AVAILABILITY TIMES OF COST/ITEM','evr_language');?></h3>
                    <li>
                        <label  for="item_start_date"><b>Start Date</b></label><?php evr_DateSelector( "\"item_start"); ?>
                    </li>
                    <li>
                        <label for="item_end_date"><b>End Date</b></label><?php evr_DateSelector( "\"item_end","$popup_date_end"); ?>
                    </li>
                </ul>
                <hr />
                <br />
                <input type="hidden" name="end" value="<?php echo $end_date;?>"/>
                <input class="button-primary" type="SUBMIT" value="<?php _e('ADD NEW COST/TICKET','evr_language');?>">
            </form>	 
        </div>
        
        
<!-- Begin Popup for Edit Items  --->

<?php 
 $sql = "SELECT * FROM " . get_option('evr_cost');
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
                        ?>

<div id="popup<?php echo $item_id;?>" class="popup_block">
<form action="admin.php?page=events" method="POST" >
    <input type="hidden" name="action" value="update_item"/>
    <input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
    <input type="hidden" name="item_id" value="<?php echo $item_id;?>"/>
    <input type="hidden" name="event_end" value="<?php echo $end_date;?>"/>
    
   
    
    
    
    <h3><?php _e('Edit Event Cost/Item for ','evr_language'); echo $event_name;?></h3>					
                <br /><ul>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Select a Item/Cost category.  Note that category REG is used for attendance count, all others are not included in attendance count.','evr_language');?>">
                        <?php _e('What type of Item/Cost is this?','evr_language');?> <a><span>?</span></a> </label>
                        <select class="title" name="item_cat">
                        <option value="<?php echo $item_cat;?>">
                        <?php if ($item_cat == "REG"){
                            echo "REG - ";
                            _e('Registration Attendee','evr_language');
                            }
                            elseif ($item_cat == "MDS"){
                            echo "MDS - ";
                            _e('Merchandise','evr_language');
                            }
                            elseif ($item_cat == "DSC"){
                            echo "DSC - ";
                            _e('Discount','evr_language');
                            }
                            elseif ($item_cat == "WRK"){
                            echo "WRK - ";
                            _e('Workshop','evr_language');
                            }
                            elseif ($item_cat == "MLS"){
                            echo "MLS - ";
                            _e('Meal or Food','evr_language');
                            }
                        ?>
                        
                        </option>
                        <option value="REG">REG - <?php _e('Registration Attendee','evr_language');?></option>
                        <option value="MDS">MDS - <?php _e('Merchandise','evr_language');?></option>
                        <option value="DSC">DSC - <?php _e('Discount','evr_language');?></option>
                        <option value="WRK">WRK - <?php _e('Workshop','evr_language');?></option>
                        <option value="MLS">MLS - <?php _e('Meal or Food','evr_language');?></option>
                        </select>
                    </li>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Use a concise but descriptive name.','evr_language');?>" ><?php _e('Name of Cost/Item','evr_language');?> <a><span>?</span></a></label>
                        <input class="title" name="item_name" value="<?php echo $item_title;?>"/>
                    </li>
                    <li>
                        <label for="cost_desc" class="er_ticket_info" title="<?php _e('Provide a description of the cost/ticket.','evr_language');?>"><?php _e('Description of Cost','evr_language');?> <a><span>?</span></a></label>
                        <input class="desc"  name="item_desc" id="cost_desc" value="<?php echo $item_description;?>"/> 
                    </li>
                    <li>
                        <label class="er_ticket_info" title="<?php _e('Provide the number of available item/cost types per registration form. If it is a REG item, available seats will impact overall amount available. Leave blank if no limit.','evr_language');?>">
                        <?php _e('Available items/cost per registration/order?','evr_language');?> <a><span>?</span></a></label>
                        <input class="title" name="item_limit" value="<?php echo $item_limit;?>"/>
                    </li>
                    <hr />
   					<h3><?php _e('VALUE/COST','evr_language');?></h3>
				    <li>
                        <label  class="er_ticket_info" title="<?php _e('Please select no for event pricing setup, select yes for free event','evr_language');?>">
        					<?php _e('Will this be a free item?','evr_language');?><a><span><img src="http://localhost/test/wp-content/plugins/EVR/images/info-icon.png"/></span></a></label>
                        <input type="radio" name="item_free" class="radio" id="free_yes" value="Y"  <?php if ($free_item =="Y"){echo "checked";} ?> /><?php _e('Yes','evr_language');?> 
                        <input type="radio" name="item_free" class="radio" id="free_no" value="N" <?php if ($free_item =="N"){echo "checked";} ?> /><?php _e('No','evr_language');?> 
                    </li> <?php
    /*
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
    */
    ?>
                    <li>
                        <label  class="er_ticket_info" title="<?php _e('Please select the country in which the currency format will be used','evr_language');?>"><?php _e('Custom Currency','evr_language');?><a><span>?</span></a></label>
        					<select class="select" name = "custom_cur">
                                <?php if ($item_custom_cur !=""){echo "<option value='" . $item_custom_cur . "'>" . $item_custom_cur . "</option>";} ?>
                                    <option value="USD">USD</option>
                                    <option value="AUD">AUD</option>
                                    <option value="GBP">GBP</option>
                                    <option value="CAD">CAD</option>
                                    <option value="CZK">CZK</option>
                                    <option value="DKK">DKK</option>
                                    <option value="EUR">EUR</option>
                                    <option value="HKD">HKD</option>
                                    <option value="HUF">HUF</option>
                                    <option value="ILS">ILS</option>
                                    <option value="JPY">JPY</option>
                                    <option value="MXN">MXN</option>
                                    <option value="NZD">NZD</option>
                                    <option value="NOK">NOK</option>
                                    <option value="PLN">PLN</option>
                                    <option value="SGD">SGD</option>
                                    <option value="SEK">SEK</option>
                                    <option value="CHF">CHF</option></select>
                    </li>
        			<li>
                    
                        <label  class="er_ticket_info" title="<?php _e('Please enter the amount using 2 decimal point (i.e. 10.00) for the registration cost.  Use minus symbol before for discount amounts (i.e. -5.00).','evr_language');?>">
    				    <?php _e('Item/Cost Value','evr_language');?> <a><span>?</span></a></label>
       					<input class="price" id="item_price" name="item_price" type="text" maxlength="10" value="<?php echo $item_price;?>" />
                    </li>
                    <hr />
        			<?php $popup_date_end = strtotime($_REQUEST['end']);?>
					<h3><?php _e('AVAILABILITY TIMES OF COST/ITEM','evr_language');?></h3>
                    <li>
                        <label  for="item_start_date"><b>Start Date</b></label><?php evr_DateSelector( "\"item_start",strtotime($item_start_date)); ?>
                    </li>
                    <li>
                        <label for="item_end_date"><b>End Date</b></label><?php evr_DateSelector( "\"item_end",strtotime($item_end_date)); ?>
                    </li>
                </ul>
                <hr />
                <br />
                <input type="hidden" name="end" value="<?php echo $end_date;?>"/>
                <input class="button-primary" type="SUBMIT" value="<?php _e('UPDATE COST/TICKET','evr_language');?>"/>
            </form>	 
	
</div>   
<?php }  ?>
     
<!--END POPUP-->
<?php
}
?>