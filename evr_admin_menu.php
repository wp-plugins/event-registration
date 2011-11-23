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
    evr_check_usage_time();
    
?>

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
</form></p>
    		</div>
    	</div>		
		<div class="clear"></div>
	</div>
	
</div>
 <hr />
 <div class="content">
  
     	<div class="evr_content_third" style="margin-right:0; float:left;">
        <div class="alert"><h3>ALERT</h3></div>
    		
    		<div class="inside">
            <?php echo get_option('plugin_error');
            if (get_option('evr_was_upgraded')== "Y") {?>
      <div id="message" class="error"><p><strong><?php 
      _e('You upgraded from a previous version of Event Registration.  All existing data has been imported.  Please verify data before deleting old tables!','evr_language');?></strong></p>
            </div>
            <a href="admin.php?page=purge">Remove Old Data Tables</a>
            <?php }?>
    			
    	</div>		
		<div class="clear"></div>
        <p align="center">
<a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=7673_0_1_7" target="_blank">
<img border="0" src="http://www.elegantthemes.com/affiliates/banners/468x60.gif" width="468" height="60"></a>
</p>
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

function evr_footer_ad(){
?>
<style>
.evr_foot_add{
    width:400px;
    
}
</style>
<div class="evr_foot_ad"><
<p align="center">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="VN9FJEHPXY6LU">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></p>
<p align="center">
<a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=7673_0_1_7" target="_blank">
<img border="0" src="http://www.elegantthemes.com/affiliates/banners/468x60.gif" width="468" height="60"></a>
</p>
/div>
<?php
}

function evr_donate_popup()
		{
			?>
			<div id="evr-donate-box">
					<div id="evr-donate-box-content">
						<img width="32" height="32" class="evr-close" src="images/btn-close.png" alt="X">
						<a href="http://www.wordpresseventregister.com"><img src="images/evr_icon.png" alt="Event Registration for Wordpress" /></a>
                        <h3>Support Event Registration</h3>
						<p align="justify">I noticed you've been using Event Registration for WordPress for at least 30 days.</p>  
                        <p align="justify">If you find Evnet Registration useful, please consider donating to show your appreciation for the time and money this product is saving you.</p>
						<p align="center">
						
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="VN9FJEHPXY6LU">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form></p>

						<a class="evr-dontshow" href="&dontshowpopup=1">(do not show me this pop-up again)</a>
					</div>
				</div>
				<?php

}
?>