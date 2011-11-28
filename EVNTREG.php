<?php

/**
 * @author David Fleming
 * @copyright 2008 - 2012
 */

/*
Plugin Name: Event Registration
Plugin URI: http://www.wordpresseventregister.com
Description: This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event or class. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to either a Paypal, Google Pay, or Authorize.net online payment site for online collection of event fees.   Detailed payment management system to track and record event payments.  
Reporting features provide a list of events, list of attendees, and excel export. 
Version: 6.00.07
Author: David Fleming - Edge Technology Consulting
Author URI: http://www.wordpresseventregister.com
*/
/*  Copyright 2008 - 2012  DAVID_FLEMING  (email : support@wordpresseventregister.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $evr_date_format, $evr_ver, $wpdb;
$evr_date_format = "M j,Y";
$evr_ver = "6.00.07";

/*
to change date format in event listing display

Tuesday, Jan 23, 2011  -  "l, M j,Y"
January 23, 2011       -  "F j,Y"
Jan 23, 2011  -  "M j,Y"
01/12/2011 (December 1, 2011) - "d/m/Y"


Month:
F - A full textual representation of a month, such as January or March January through December 
m - Numeric representation of a month, with leading zeros 01 through 12 
M - A short textual representation of a month, three letters Jan through Dec 
n - Numeric representation of a month, without leading zeros 1 through 12 

Day:
d - Day of the month, 2 digits with leading zeros 01 to 31 
j - Day of the month without leading zeros 1 to 31
D - A textual representation of a day, three letters Mon through Sun 
l - (lowercase 'L') A full textual representation of the day of the week Sunday through Saturday 

Year:
Y - A full numeric representation of a year, 4 digits Examples: 1999 or 2003 
y - A two digit representation of a year Examples: 99 or 03 

*/
/*********************************   ERROR REPORTING   ********************************/
error_reporting(E_ALL ^ E_NOTICE);
function evr_save_error(){
    update_option('plugin_error',  ob_get_contents());
}
/*********************************   PATH VARIABLES   ********************************/
//Define path variables
define("EVR_PLUGINPATH", "/" . plugin_basename(dirname(__file__)) . "/");
define("EVR_PLUGINFULLURL", WP_PLUGIN_URL . EVR_PLUGINPATH);
//
//
//
/*********************************   DEPENDENCIES   ********************************/
//
require ("evr_admin_menu.php"); //holds function used in the admin menu
require ("evr_support_functions.php"); //holds functions used throughout the plugin
require ("evr_content.php"); //holds functions that replaces the content in main page
require ("evr_install.php"); //holds functions that install options and databases
require ("evr_company.php"); //holds function that has form and array posting for company
require ("evr_admin_event.php"); //holds function that creates/edits/manages event
require ("pagination.class.php"); //holds function that does paging on admin listings
require ("evr_admin_questions.php"); //holds function for the admin questions page
require ("evr_admin_category.php"); //holds function for the admin category page
require ("evr_admin_attendee.php"); //holds functions for the admin attendee management
require ("evr_admin_payments.php"); //holds function for event payments and admin payment management
require ("evr_public_registration.php"); //holds functions that display the registration page forms
require ("paypal.class.php"); //used for paypal IPN
require ("evr_ipn.php"); //used for paypal IPN
require ("evr_calendar.php"); //holds functions for calendar page
require ("evr_clean_db.php");
//require ("evr_pdf.php"); //creates pdf of reg details
//
//
/*********************************   HOOKS   ********************************/
//Install/Update Tables when plugin is activated
register_activation_hook(__file__, 'evr_install');
## uncomment the next line to completely remove the plugin including all data files when deactivated
//register_deactivation_hook( __FILE__, 'evr_uninstall' );
//
/*********************************   ACTIONS   ********************************/
//
add_action('activated_plugin','evr_save_error');
add_action('init', 'evr_init');
add_action('admin_menu', 'evr_admin_menu');
add_action('plugins_loaded', 'evr_widgets');
//admin header
add_action("admin_head","evr_load_tiny_mce");
add_action('admin_head', 'evr_admin_header');
add_action('admin_print_styles', 'evr_admin_css_all_page');
add_action('admin_print_scripts', 'evr_admin_scripts_all_page');
//admin footer
add_action('admin_footer', 'evr_footer_text');
//public header
add_action('wp_head', 'evr_public_header');
add_action('wp_print_styles', 'evr_public_stylesheets');
add_action('wp_print_scripts', 'evr_public_scripts');
//
//
/*********************************   FILTERS   ********************************/
//
// Add a settings link to the Plugins page, so people can go straight from the plugin page to the settings page.
add_filter('plugin_action_links', 'evr_quick_action', 10, 2);
add_filter('the_content', 'evr_content_replace');
add_filter('the_content', 'evr_calendar_replace');
add_filter('the_content', 'evr_upcoming_event_list');
//
/*********************************   SHORTCODES  *****************************/
//
add_shortcode('EVR_PAYMENT', 'evr_payment_page');
add_shortcode('EVR_CALENDAR', 'evr_calendar_page');
add_shortcode('EVR_SINGLE', 'evr_single_event');
add_shortcode('EVR_CATEGORY', 'evr_by_category');
add_shortcode('EVR_ATTENDEE', 'evr_attendee_short');
//
//
/*********************************   STARTUP FUNCTIONS   ********************************/
//
function evr_init(){
  //if (!is_admin()) {wp_enqueue_script('jquery');}
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable'); 
  wp_enqueue_script('jquery-ui-draggable'); 
  wp_enqueue_script('jquery-ui-droppable');
  wp_enqueue_script('jquery-ui-selectable');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script(array('tiny_mce','editor','editor-functions', 'thickbox', 'media-upload'));
  //Text Domain support for other languages
  load_plugin_textdomain('evr_language', false, dirname(plugin_basename(__file__)).'/lang/');      
}
//
function evr_load_tiny_mce() {
    //for help with this http://dannyvankooten.com/450/tinymce-wysiwyg-editor-in-wordpress-plugin/
   global $wp_version;
      //for older versions we need this script.
   if (!version_compare($wp_version, '3.2', '>=')) {
       if (function_exists('wp_tiny_mce_preload_dialogs')) {
           add_action('admin_print_footer_scripts', 'wp_tiny_mce_preload_dialogs');
       }
  	}
    //wp_tiny_mce( false ); // true gives you a stripped down version of the editor
    wp_tiny_mce( false , array( "editor_selector" => "edit_class", 
    'height' => 200,
    'plugins' => 'inlinepopups,wpdialogs,wplink,media,wpeditimage,wpgallery,paste,tabfocus',        
    'forced_root_block' => false,        
    'force_br_newlines' => true,        
    'force_p_newlines' => false,        
    'convert_newlines_to_brs' => true));
}
//
//
/*********************************   ADMIN HEAD   ********************************/
//              
//function to enqueue styles in admin pages
function evr_admin_css_all_page() {
       wp_register_style($handle = 'evr_admin_css', $src = plugins_url('/evr_admin_style.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
       wp_enqueue_style('evr_admin_css');
}
//function to enqueue scripts in admin pages
function evr_admin_scripts_all_page() {
       wp_register_script($handle = 'evr_admin_script', $src = plugins_url('/scripts/evr.js', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
       wp_register_script($handle = 'evr_admin_fancy', $src = plugins_url('/scripts/fancybox/jquery.fancybox-1.2.5.pack.js', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
       wp_register_script($handle = 'evr_tab_script', $src = plugins_url('/scripts/evr_tabs.js', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
       wp_enqueue_script('evr_admin_script');
       wp_enqueue_script('evr_admin_fancy');
       wp_enqueue_script('evr_tab_script');
       
}
//function to load items to header of wordpress admin
function evr_admin_header(){
  //special code for header - should put all css in css admin and all script in script admin
}
/*********************************   END ADMIN HEAD   ********************************/
//
//
/*********************************   PUBLIC HEAD     ********************************/
//
//function to enqueue styles in public pages
function evr_public_stylesheets() {
    wp_register_style($handle = 'evr_public', $src = plugins_url('/evr_public_style.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
	wp_register_style($handle = 'evr_calendar', $src = plugins_url('/evr_calendar.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
    wp_register_style($handle = 'evr_pop_style', $src = plugins_url('/evr_pop_style.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');		
            wp_enqueue_style('evr_public');
            wp_enqueue_style('evr_calendar');
            wp_enqueue_style('evr_pop_style');
}
// function to enqueue scripts in public pages
function evr_public_scripts() {
 wp_register_script($handle = 'evr_public_script', $src = plugins_url('/evr_public_script.js', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
 wp_enqueue_script('evr_public_script');		
 }
//function to load items to public pages of wordpress site
function evr_public_header(){
}
/*********************************   END PUBLIC HEAD   *****************************/
//
//
/*********************************   ADMIN MENUE   ********************************/
//
//function to load plugin admin menu to Admin sidebar

function evr_admin_menu()
{
    global $evr_date_format, $evr_ver;
    $version = "EVNTRG_" . $evr_ver;
    $role = 'manage_options';
    
    add_menu_page($version, $version, $role, __file__, 'evr_splash');
    add_submenu_page(__file__, 'Setup Company', 'Company', $role, 'company','evr_admin_company');
    add_submenu_page(__file__, 'Categories', 'Categories',$role, 'categories','evr_admin_categories');
    add_submenu_page(__file__, 'Manage Events', 'Events', $role, 'events','evr_admin_events');
    add_submenu_page(__file__, 'Questions', 'Questions', $role, 'questions','evr_admin_questions');
    add_submenu_page(__file__, 'Manage Attendees', 'Attendees', $role, 'attendee','evr_attendee_admin');
    add_submenu_page(__file__, 'Manage Payments', 'Payments', $role, 'payments','evr_admin_payments');
    add_submenu_page(__file__, 'UnInstall Plugin', 'Uninstall', $role, 'uninstall','evr_remove_db_menu');
    add_submenu_page(__file__, 'Remove Old Data', 'Remove Old Data', $role, 'purge','evr_clean_old_db');
    add_submenu_page(__file__, 'Disable Popup', 'Disable Popup', $role, 'popup','evr_validate_key');
    //add_submenu_page ( __FILE__, 'Data Import', 'Import Data', 8, 'import', 'evr_admin_import' );
    //add_submenu_page ( __FILE__, 'Data Export', 'Export Data', 8, 'export', 'evr_admin_export' );
    //add_submenu_page ( __FILE__, 'Send Mail', 'Mail', 8, 'mail', 'evr_mail_followup' );
    //add_submenu_page ( __FILE__, 'Sample Events', 'Sample Events', 8, 'sample', 'evr_create_events_sample_page' );
    //add_submenu_page ( __FILE__, 'Reports', 'Reports', 8, 'reports', 'evr_admin_reports' );
    //add_submenu_page ( __FILE__, 'Support', 'Support', 8, 'support', 'evr_admin_support' );
    


}
/*********************************   END ADMIN MENU   ********************************/
//
//
//function to load widgets to the widgets menu
function evr_widgets(){

wp_register_sidebar_widget(
    'EVNTRG LST',        // your unique widget id
    'Event List',          // widget name
    'evr_widget_content',  // callback function
    array(                  // options
        'description' => 'Lists all the active events currently in Event Registration Plugin'
    )
);

}


function evr_check_usage_time(){
			if ((get_option('evr_dontshowpopup')!= "Y")&&(get_option('evr_donated') == "Y")){update_option('evr_dontshowpopup', "Y");}
			if(!get_option('evr_date_installed') ) {
                  $installed_date = strtotime('now');
             	  update_option('evr_date_installed', $installed_date);
                } 
            elseif ((get_option('evr_dontshowpopup')!= "Y")&&(get_option('evr_date_installed')< strtotime('-29 days'))){
                // plugin has been installed for over 30 days
                evr_donate_popup();
                }
}

function evr_footer_text() 
{
	echo "<p id='footer' style=\"text-align:center;\">Event Registration created by <a href='http://www.WordpressEventRegister.com'>WordpressEventRegister.com</a></p>";
} 
?>