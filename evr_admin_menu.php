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
add_submenu_page ( __FILE__, 'Manage Payments', 'Payments', 8, 'payments', 'awr_admin_payments' );
add_submenu_page ( __FILE__, 'Data Import', 'Import Data', 8, 'import', 'evr_admin_import' );
add_submenu_page ( __FILE__, 'Data Export', 'Export Data', 8, 'export', 'evr_admin_export' );
add_submenu_page ( __FILE__, 'Reports', 'Reports', 8, 'reports', 'evr_admin_reports' );    
add_submenu_page ( __FILE__, 'Support', 'Support', 8, 'support', 'evr_admin_support' );
*/


//function for testing


//function for the splash page of the plugin
function evr_splash(){
    
?>
<div class="wrap">
<div id="icon-plugins" class="icon32"></div><h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Event Registration Plugin - Current Information','evr_language');?></h2>
<div id="dashboard-widgets-wrap">

<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:49%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('Data Table Information','evr_language');?></span></h3>
                <div class="inside">
                    <div class="padding">
                    <table class="table">
                        <tr valign="top" align="left"><th scope="row"><?php _e('Attendee Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_attendee'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Attendee Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_attendee_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Event Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_event'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Event Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_event_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Question Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_question'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Question Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_question_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Answer Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_answer'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Answer Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_answer_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Category Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_category'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Category Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_category_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Cost Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_cost'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Cost Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_cost_version'); ?></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Payment Table Name:','evr_language');?></th>
                        <td><?php echo get_option('evr_payment'); ?></td></tr>
                        <tr></tr>
                        <tr valign="top" align="left"><th scope="row"><?php _e('Payment Table Version:','evr_language');?></th>
                        <td><?php echo get_option('evr_payment_version'); ?></td></tr>
                    </table>
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