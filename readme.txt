=== Event Registration ===
Contributors: david fleming &  Inna Janssen
Donate link: http://www.avdude.com/
Tags: event management, event registration
Requires at least: 2.0.2
Tested up to: 2.7
Stable tag: 3.04

Provides the ability to setup event list and accept online registrations for events and administer them via WordPress. Supports paypal and international currency via paypal

== Description ==

**I do not recommend upgrading to this version on a site you are currently taking registrations on.

You will need to edit/save all existing events to update them to the database changes to work properly**

This plugin provides a way to take online registrations for events such as conference and seminars that are held live.
This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to your paypal payment site for online collection of event fees. 
Reporting features provide a list of events, list of attendees, and excel export.
I have added the ability to edit events and to allow single event or event listing on the registration page.

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

= Support =

Thanks for all your suggestions and feedback.  I have begun setting up a dedicated site for the plugin www.edgetechweb.com primarily for support issues.  

Please continue to email questions or comments to consultant@avdude.com.  

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

Changes:

3.04 Resolved issue where email sends mail to someone it shouldnt! Sorry for that!
     Added image support for events you can use a thumbnail for the event listings and a header image on registration page
    A few other tweeks.
3.03 Changed Request URI to work with IIS as well as apache servers.
	Added date sort to only display current/future events when listing all events.
	Added support for quick tags using a page for single event by ID (you can create different pages for different events at the same time.)
	Example Use this code in page [Event_Registration_Single id="1"] where id is the event id, instead of {EVENTREGIS} *Note you must have all events enabled in the organization configuration for this to work.
	
3.02 Changed table structure: email_conf: varchar 1000 not possible.  changed to text.

3.01 split files to several files to have a better structure. 
	startet outsourcing the language and providing german and english language. This is done for
	the registration form the user sees on the webpage
	changed double-BR to valid XHTML-Style <p>...</p> Tags
	some small code and html style changes

3.0
	Resolved Default mail not replacing key tags [] with data variables.
	Resolved You can add questions to event 0 by not selection the big event button first
	Resolved DROPDOWN type not working - missing enum type in table creation script (only shows on new install)

. . . See changelog.txt for more changes





== Installation ==

1. After unzipping, upload everything in the `Events Registration` folder to your `/wp-content/plugins/` directory (preserving directory structure).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Event Registration Menu and Configure Organization and enter your company info - note you will need a paypal id if you plan on accepting paypal payments
4. Go to the Event Setup and create a new event, make sure you select 'make active'.
5. Create a new page (not post) on your site. Put `{EVENTREGIS}` in it on a line by itself.
6. Note: if you are upgradings from a previous version please backup your data prior to upgrade.

If you would like to put a specific event on a page use `[Event_Registration_Single id="1"]` where 1 is the event id number.  Make sure that you have display all events active in the Configure Organization Tab.  Yes you can still use `{EVENTREGIS}` at the same time!

All done. 

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/
= License =

This plugin is provided "as is" and without any warranty or expectation of function. I'll probably try to help you if you ask nicely, but I can't promise anything. You are welcome to use this plugin and modify it however you want, as long as you give credit where it is due. 

Please feel free to email me your changes and modifications and I will gladly try to incorporate them in.

== Screenshots ==

www.edgetechweb.com

== Frequently Asked Questions ==

Q: Do you do custom modifications?
A: Yes, for a resonable fee.

Q: Why does email sent by the plugin say wordpress@yourdomain.com?
A: This is a default wordpress thing.  There is a great little plugin that resolves that issue. http://wordpress.org/extend/plugins/mail-from/ 

Q: Why doesn't the export to CSV or Excel work?
A: The plugin was written assuming it would be in the root installation. In the plugin folder there is a file called event_registration export.php you will need to change line 3. Current: 3. define( ‘ABSPATH’, $_SERVER['DOCUMENT_ROOT'] . ‘/’ );  Modified: 3. define( ‘ABSPATH’, $_SERVER['DOCUMENT_ROOT'] . ‘/your_subdirectory_name
