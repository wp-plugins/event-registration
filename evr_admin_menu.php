<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

/*
add_menu_page ( 'EVNTRG', 'EVNTRG', 8, __FILE__ ,'evr_splash' );
add_submenu_page ( __FILE__, 'Setup Company', 'Company', 8, 'company', 'evr_company_setup' );
add_submenu_page ( __FILE__, 'Manage Attendees', 'Attendees', 8, 'attendee', 'evr_admin_attendee' );
add_submenu_page ( __FILE__, 'Manage Events', 'Events', 8, 'events', 'evr_admin_events' );
add_submenu_page ( __FILE__, 'Manage Payments', 'Payments', 8, 'payments', 'evr_admin_payments' );
add_submenu_page ( __FILE__, 'Data Import', 'Import Data', 8, 'import', 'evr_admin_import' );
add_submenu_page ( __FILE__, 'Data Export', 'Export Data', 8, 'export', 'evr_admin_export' );
add_submenu_page ( __FILE__, 'Reports', 'Reports', 8, 'reports', 'evr_admin_reports' );    
add_submenu_page ( __FILE__, 'Support', 'Support', 8, 'support', 'evr_admin_support' );
*/


//function for testing


//function for the splash page of the plugin
function evr_splash(){
    global $wpdb, $sponsorship_promo;
    
    
?>
<style>

/* for advertising sponsor module */
.evr_plugin .spsn-container {
	background: #ECECEC !important;
	border: 1px solid #DFDFDF !important;
	text-shadow: rgba(255, 255, 255, 0.796875) 0px 1px 0px;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	position: relative;
	padding:.5em !important;
	margin: 0.4em 0 0.5em 0 !important;
	font-size: 0.95em;
}

.evr_plugin .spsn-sponsor-heading {/* paragraph carrying a heading for the sponsorship message */}

.evr_plugin .spsn-sponsor-text {/* paragraph containing the sponsorship message */}

.evr_plugin .spsn-credit {
	position: absolute;
	top: 0;
	right: 0;
	padding:.8em !important;
	color: #999;
}
.evr_plugin .spsn-sponsor-text a {
	color: #21759B !important;
}



/*  DEFINES CONTENT */
.evr_plugin .content {
	width: 99.5%;
	color: #999;
}


/* DEFINES 50% CONTENT */
.evr_plugin .evr_content_half {
	border-color: #FF5050;
	border-bottom-left-radius: 6px 6px;
	border-bottom-right-radius: 6px 6px;
	border-style: solid;
	border-width: 1px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	line-height: 1;
	margin-bottom: 20px;
	min-width: 399px;
	position: relative;
	width: 49%;
	float: left;
	margin-right: 2%;
	background: #fff;
	color: #464646;
	margin-bottom: 1em;
	margin-top: 0.5em;
	}
.evr_plugin .evr_content_half .inside {
	padding: 10px;
/*	height: 300px; */
	overflow: auto;
}
.evr_plugin .content .alert h3 {
	color: #464646;
	background: #FF5050 ;
	text-shadow: white 0px 1px 0px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	font-size: 12px;
	font-weight: bold;
	line-height: 1;
	margin: 0px;
	padding: 7px 9px;
	cursor: default !important;
}
.evr_plugin .evr_content_half ul {
	list-style: none;
	margin: 0px;
	padding: 0px;
	font-size: 11px;
}
.evr_plugin .evr_content_half li, .evr_plugin .evr_content_half p {
	line-height: 1.5em;
	margin-bottom: 12px;
	margin-top: 0;
}

/* DEFINES 33% CONTENT */
.evr_plugin .evr_content_third {
	border-color: #DFDFDF;
	border-bottom-left-radius: 6px 6px;
	border-bottom-right-radius: 6px 6px;
	border-style: solid;
	border-width: 1px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	line-height: 1;
	margin-bottom: 20px;
	min-width: 255px;
	position: relative;
	width: 32%;
	float: left;
	margin-right: 2%;
	background: #fff;
	color: #464646;
	margin-bottom: 1em;
	margin-top: 0.5em;
	}
.evr_plugin .evr_content_third .inside {
	padding: 10px;
	height: 200px;
	overflow: auto;
}
.evr_plugin .content h3 {
	color: #464646;
	background: #99CCFF url(../img/gray-grad.png) repeat-x 0% 0%;
	text-shadow: white 0px 1px 0px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	border-top-left-radius: 6px 6px;
	border-top-right-radius: 6px 6px;
	font-size: 12px;
	font-weight: bold;
	line-height: 1;
	margin: 0px;
	padding: 7px 9px;
	cursor: default !important;
}
.evr_plugin .evr_content_third ul {
	list-style: none;
	margin: 0px;
	padding: 0px;
	font-size: 11px;
}
.evr_plugin .evr_content_third li, .evr_plugin .evr_content_third p {
	line-height: 1.5em;
	margin-bottom: 12px;
	margin-top: 0;
}
.evr_plugin .content a {
	text-decoration: none;
	font-family: Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;
	font-size: 13px;
	line-height: 1.7em;
	}
.evr_plugin .content .rss-date {
	color: #666;
}
.clear {
	clear: both;
}
.evr_plugin hr {
	border: 1px solid #ccc !important;
	border-left: 0 !important;
	border-right: 0 !important;
	background: transparent;
	margin: 0.5em 0 !important;
	padding: 0;
	width: 99.5%;
	}
</style>


<div class="wrap"><br />
<a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a>
<br />
<br />
<div class="evr_plugin">
<?php //Sponsor Add Goes here  ?>
<div class="content">
    	<div class="evr_content_third">
    		<h3>Event Registration Installation Info</h3>
    		<div class="inside">
    		<div class="padding">
                    <table class="table">
                        <tr><th valign="top" align="left" scope="row"><?php _e('Attendee Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_attendee'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Attendee Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_attendee_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Event Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_event'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Event Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_event_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Question Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_question'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Question Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_question_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Answer Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_answer'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Answer Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_answer_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Category Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_category'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Category Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_category_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Cost Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_cost'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Cost Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_cost_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Payment Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_payment'); ?></td></tr>
                        <tr></tr>
                        <tr><th scope="row" valign="top" align="left"><?php _e('Payment Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_payment_version'); ?></td></tr>
                    </table>
                    </div>
                </div>  		
            </div>
    	      
    	<div class="evr_content_third" style="margin-right:0;">
    		<h3>Links &amp; Documentation</h3>
    		<div class="inside">
    			<p>Need help? FAQ, Usage instructions and other notes can be found on the WordPress.org plugin page.</p>    			<ul>
    				<li><a href="http://wordpress.org/extend/plugins/event-registration/">Download Event Registration on WordPress.org</a></li>
    				<li><a href="http://wordpresseventregister.com/wp-content/uploads/2011/11/EventRegistration6Guide.pdf">Download Event Registration Guide</a></li>
    				<li><a href="http://www.wordpresseventregister.com">View Online Documentation</a></li>
    			</ul>            
    		</div>
    	</div> 
        
    	<div class="evr_content_third" style="margin-right:0; float:right;">
    		<h3>Support Event Registration</h3>
    		<div class="inside">
    			<div style="clear: both; display: block; padding: 10px 0; text-align:center;">If you find this plugin useful, please contribute to enable its continued development!<br />
<p align="center">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="VN9FJEHPXY6LU">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
    		</div>
    	</div>		
		<div class="clear"></div>
	</div>
	
</div>
 <hr />
 <div class="content">
     	<div class="evr_content_half" style="margin-right:0; float:left;">
        <div class="alert"><h3>ALERT</h3></div>
    		
    		<div class="inside">
    			
    	</div>		
		<div class="clear"></div>
	   </div>
         	<div class="evr_content_half" style="margin-right:0; float:right;">
        <h3>Event Registration News</h3>
    		
    		<div class="inside">
    		 <script language="JavaScript" src="http://itde.vccs.edu/rss2js/feed2js.php?src=http%3A%2F%2Fwww.wordpresseventregister.com%2Ffeed&chan=y&num=3&desc=1&date=y&targ=y" type="text/javascript"></script>

<noscript>
<a href="http://itde.vccs.edu/rss2js/feed2js.php?src=http%3A%2F%2Fwww.wordpresseventregister.com%2Ffeed&chan=y&num=3&desc=1&date=y&targ=y&html=y">View RSS feed</a>
</noscript>
	
    	</div>		
		<div class="clear"></div>
	   </div>
   
    
</div> 
</div>
<?php  
}
?>