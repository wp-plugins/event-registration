<?php

/**
 * @author David Fleming
 * @copyright 2011
 */

/*
Plugin Name: Event Registration
Plugin URI: http://www.wordpresseventregister.com
Description: This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event or class. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to either a Paypal, Google Pay, or Authorize.net online payment site for online collection of event fees.   Detailed payment management system to track and record event payments.  
Reporting features provide a list of events, list of attendees, and excel export. 
Version: 6.00.06
Author: David Fleming - Edge Technology Consulting
Author URI: http://www.wordpresseventregister.com
*/
/*  Copyright 2011  DAVID_FLEMING  (email : support@wordpresseventregister.com)

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
$evr_ver = "6.00.06";

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

error_reporting(E_ALL ^ E_NOTICE);
//Define path variables
define("EVR_PLUGINPATH", "/" . plugin_basename(dirname(__file__)) . "/");
define("EVR_PLUGINFULLURL", WP_PLUGIN_URL . EVR_PLUGINPATH);

if ( isset( $_POST['uninstall'], $_POST['uninstall_confirm'] ) ) {evr_uninstall();}


//Dependencies
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
//require ("evr_pdf.php"); //creates pdf of reg details

//Install/Update Tables when plugin is activated
register_activation_hook(__file__, 'evr_install');
## uncomment the next line to completely remove the plugin including all data files when deactivated
//register_deactivation_hook( __FILE__, 'evr_uninstall' );

//Add page headers for client and admin pages, Add Admin menu for plugin, Add widgets
add_action('admin_head', 'evr_admin_header');
add_action('wp_head', 'evr_public_header');
add_action('admin_menu', 'evr_admin_menu');
add_action('plugins_loaded', 'evr_widgets');

function evr_init()
{
    //if (!is_admin()) {wp_enqueue_script('jquery');}

  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable'); 
  wp_enqueue_script('jquery-ui-draggable'); 
  wp_enqueue_script('jquery-ui-droppable');
  wp_enqueue_script('jquery-ui-selectable');
  wp_enqueue_script('jquery-ui-core');
    load_plugin_textdomain('evr_language', false, dirname(plugin_basename(__file__)) .
        '/lang/');
}
add_action('init', 'evr_init');


// Add a settings link to the Plugins page, so people can go straight from the plugin page to the settings page.
add_filter('plugin_action_links', 'evr_quick_action', 10, 2);

// Content filter and shortcodes
add_filter('the_content', 'evr_content_replace');
add_filter('the_content', 'evr_calendar_replace');
add_filter('the_content', 'evr_upcoming_event_list');

add_shortcode('EVR_PAYMENT', 'evr_payment_page');
add_shortcode('EVR_CALENDAR', 'evr_calendar_page');
add_shortcode('EVR_SINGLE', 'evr_single_event');
add_shortcode('EVR_CATEGORY', 'evr_by_category');
add_shortcode('EVR_ATTENDEE', 'evr_attendee_short');


//Function List
//function to install plugin - load tables and wp_options
function evr_install()
{

    global $evr_date_format, $evr_ver, $wpdb, $cur_build;

    $old_event_tbl = $wpdb->prefix . "events_detail";

    if ($wpdb->get_var("SHOW TABLES LIKE '$old_event_tbl'") == $old_event_tbl) {
        evr_upgrade_tables();
?>
        <div id="message" class="updated fade"><p><strong><?php _e('The tables have been upgraded.',
'evr_language'); ?> </strong></p></div>
        <?php

    }
    $cur_build = "6.00.05";
    evr_attendee_db();
    evr_category_db();
    evr_event_db();
    evr_cost_db();
    evr_payment_db();
    evr_question_db();
    evr_answer_db();

}
//function to remove plugin - remove tables and wp_options


function evr_uninstall()
{
   
    global $wpdb;
    //Drop Attendee Table
    $thetable = $wpdb->prefix . "evr_attendee";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_attendee');
    delete_option('evr_attendee_version');

    //Drop Events Detail Table
    $thetable = $wpdb->prefix . "evr_event";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_event');
    delete_option('evr_event_version');

    //Drop Events Question Table
    $thetable = $wpdb->prefix . "evr_question";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_question');
    delete_option('evr_question_version');

    //Drop Events Answer Table
    $thetable = $wpdb->prefix . "evr_answer";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_answer');
    delete_option('evr_answer_version');

    //Drop Events Category Table
    $thetable = $wpdb->prefix . "evr_category";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_category');
    delete_option('evr_category_version');

    //Drop Events Cost Table
    $thetable = $wpdb->prefix . "evr_cost";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_cost');
    delete_option('evr_cost_version');

    //Drop Attendee Payment Table
    $thetable = $wpdb->prefix . "evr_payment";
    $wpdb->query("DROP TABLE IF EXISTS $thetable");
    delete_option('evr_payment');
    delete_option('evr_payment_version');
    
    //Remove Company Settings
    
    delete_option('evr_company_settings');

?>
        
<?php
    $current = get_settings('active_plugins');    
    array_splice($current, array_search( $_POST['plugin'], $current), 1 ); // Array-function!    
    update_option('active_plugins', $current); 
    ?><meta http-equiv="Refresh" content="0; url=plugins.php">
<div id="message" class="error"><p><strong><?php _e('Now deleting data tables and options for Event Registration','evr_language');?></strong></p>
            </div>
   
    <div id="message" class="error"><p><strong><?php _e('All Event Registration Data Tables and Options have been deleted!','evr_language');?>
                </strong></p></div> 
                <meta http-equiv="Refresh" content="1; url=plugins.php?deactivate=true">
                
                <?php 
    }

function evr_remove_db_menu(){
    
    ?>
<div class="wrap"><br />
<a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a>
<br />
<br />
<style>/* for advertising sponsor module */
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
	} </style>
<div class="evr_plugin">
    <div class="content">
    	<div class="evr_content_third">
    		<h3>Permanently Remove All Data</h3>
    		<div class="inside">
                <form method="post">
                <input id="plugin" name="plugin" type="hidden" value="EVENTREG.php" />     
             <?php if ( isset( $_POST['uninstall'] ) && ! isset( $_POST['uninstall_confirm'] ) ) { 
                ?>
                <div id="message" class="error"><p><strong><?php _e('You must check the confirm box before continuing!','evr_language');?>
                </strong></p></div>
                <?php  } ?>
             <p>The options and data for this plugin are not removed on deactivation to ensure that no data is lost unintentionally.</p> 
             <p>If you wish to remove all Event Registration plugin information from your database, be sure to run this uninstall utility first.</p>
              <p><input name="uninstall_confirm" type="checkbox" value="1" />Yes, I want to remove all Event Registration Data. Please confirm before proceeding </p>
              <input class="button-secondary" name="uninstall" type="submit" value="Uninstall" onclick="return confirm('<?php _e('Are you sure you want to delete all Event Registratin data','evr_language');?>')"/>
             </form>
             </div>
        </div>  		
    </div>
   </div>  		
</div>        
<?php }


//function to load items to header of wordpress admin
function evr_admin_header()
{
    echo '<link rel="stylesheet" type="text/css" media="all" href="' .
        EVR_PLUGINFULLURL . 'evr_admin_style.css' . '" />';
        //wp_enqueue_script( array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists", "jquery-ui-sortable") );
?>
    
    <script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL ?>scripts/evr.js"></script>
    
   <script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL ?>scripts/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
     
    <script type="text/javascript">
    	function myEdToolbar(obj) {
    	   	document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/paragraph.gif\" name=\"btnPara\" title=\"Paragraph\" onClick=\"doAddTags('<p>','</p>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/bold.gif\" name=\"btnBold\" title=\"Bold\" onClick=\"doAddTags('<strong>','</strong>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/italic.gif\" name=\"btnItalic\" title=\"Italic\" onClick=\"doAddTags('<em>','</em>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/underline.gif\" name=\"btnUnderline\" title=\"Underline\" onClick=\"doAddTags('<u>','</u>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/link.gif\" name=\"btnLink\" title=\"Insert Link\" onClick=\"doURL('" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/email.gif\" name=\"btnEmail\" title=\"Insert Email\" onClick=\"doMailto('" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/image.gif\" name=\"btnPicture\" title=\"Insert Picture\" onClick=\"doImage('" + obj + "')\" />");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/ordered.gif\" name=\"btnList\" title=\"Ordered List\" onClick=\"doList('<ol>','</ol>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/unordered.gif\" name=\"btnList\" title=\"Unordered List\" onClick=\"doList('<ul>','</ul>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/list_item.gif\" name=\"btnList_Item\" title=\"List Item\" onClick=\"doAddTags('<li>','</li>','" + obj + "')\">");
    		document.write("<img class=\"my_button\" src=\"<?php echo
EVR_PLUGINFULLURL ?>images/quote.gif\" name=\"btnQuote\" title=\"Quote\" onClick=\"doAddTags('<blockquote>','</blockquote>','" + obj + "')\">"); 
    	}
    
        $j = jQuery.noConflict();
        jQuery(document).ready(function($j) {
        $j("a.ev_reg-fancylink").fancybox({
        		'padding':		10,
        		'imageScale':	true,
        		'zoomSpeedIn':	250, 
        		'zoomSpeedOut':	250,
        		'zoomOpacity':	true, 
        		'overlayShow':	false,
        		'frameHeight':	250,
        		'hideOnContentClick': false
        	});
        });
    </script>
    <?php
}
/*********************************   HEAD   CSS   ********************************/

//function to load items to public pages of wordpress site
function evr_public_header()
{
    echo '<link rel="stylesheet" type="text/css" media="all" href="' .
        EVR_PLUGINFULLURL . 'evr_public_style.css' . '" />';
    echo '<link rel="stylesheet" type="text/css" media="all" href="' .
        EVR_PLUGINFULLURL . 'evr_calendar.css' . '" />';
        include "evr_event_popup_layout.php";

}
//function to load plugin admin menu to sidebar
function evr_admin_menu()
{
    global $evr_date_format, $evr_ver;
    $version = "EVNTRG_" . $evr_ver;
    add_menu_page($version, $version, 8, __file__, 'evr_splash');
    add_submenu_page(__file__, 'Setup Company', 'Company', 8, 'company','evr_admin_company');
    add_submenu_page(__file__, 'Categories', 'Categories', 8, 'categories','evr_admin_categories');
    add_submenu_page(__file__, 'Manage Events', 'Events', 8, 'events','evr_admin_events');
    add_submenu_page(__file__, 'Questions', 'Questions', 8, 'questions','evr_admin_questions');
    add_submenu_page(__file__, 'Manage Attendees', 'Attendees', 8, 'attendee','evr_attendee_admin');
    add_submenu_page(__file__, 'Manage Payments', 'Payments', 8, 'payments','evr_admin_payments');
    add_submenu_page(__file__, 'Delete All Data', 'Remove', 8, 'remove','evr_remove_db_menu');
    
    //add_submenu_page ( __FILE__, 'Data Import', 'Import Data', 8, 'import', 'evr_admin_import' );
    //add_submenu_page ( __FILE__, 'Data Export', 'Export Data', 8, 'export', 'evr_admin_export' );
    //add_submenu_page ( __FILE__, 'Send Mail', 'Mail', 8, 'mail', 'evr_mail_followup' );
    //add_submenu_page ( __FILE__, 'Sample Events', 'Sample Events', 8, 'sample', 'evr_create_events_sample_page' );
    //add_submenu_page ( __FILE__, 'Reports', 'Reports', 8, 'reports', 'evr_admin_reports' );
    //add_submenu_page ( __FILE__, 'Support', 'Support', 8, 'support', 'evr_admin_support' );


}
//function to load widgets to the widgets menu
//function to load widgets to the widgets menu
function evr_widgets(){
register_sidebar_widget("Event Registraion", "evr_widget_content"); 
//register_sidebar_widget("Event Reg Calendar", "events_calendar_widget");
}
//function to add quick link to Plugin Activation Menu - used as a filter
function evr_quick_action($links, $file)
{
    // Static so we don't call plugin_basename on every plugin row.
    static $this_plugin;
    if (!$this_plugin)
        $this_plugin = plugin_basename(__file__);

    if ($file == $this_plugin) {
        $org_settings_link = '<a href="admin.php?page=' . __file__ . '">' . __('Settings',
            'evr_language') . '</a>';
        $events_link = '<a href="admin.php?page=events">' . __('Events', 'evr_language') .
            '</a>';
        array_unshift($links, $org_settings_link, $events_link); // before other links
    }
    return $links;
}
//function to replace content on public page for plugin
function evr_content_replace($content)
{
    if (preg_match('{EVRREGIS}', $content)) {
        ob_start();
        //event_regis_run($event_single_ID);
        evr_registration_main(); //function with main content
        $buffer = ob_get_contents();
        ob_end_clean();
        $content = str_replace('{EVRREGIS}', $buffer, $content);
    }
    return $content;
}
?>