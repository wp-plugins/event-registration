=== Event Registration ===
Contributors: David Fleming
Donate link: http://www.edgetechweb.com/
Tags: event management, event registration
Requires at least: 2.0.2
Tested up to: 2.71
Stable tag: 4.0

Provides the ability to setup event list and accept online registrations for events and administer them via WordPress. Supports paypal and international currency via paypal.
Provides the ability to upload events via CSV format.
Provides the ability to have a single event or multiple events.

== Description ==

Allows you to register people online for events. Very flexible. Provides the ability to setup event list and accept online registrations for events and administer them via WordPress. Supports paypal and international currency via paypal. Provides the ability to upload events via CSV format. Provides the ability to have a single event or multiple events.

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

Also if you could rate the plugin that would also be helpful.

= Support =

Thanks for all your suggestions and feedback.  I have begun setting up a dedicated site for the plugin www.edgetechweb.com primarily for support issues.  There is a page with installation directions  

Documentation included in the document (link on first tab of plugin Admin Panel) as well as http://edgetechweb.com/instructions/

Please continue to email questions or comments to consultant@avdude.com.  

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

Changes:
3.05 - Fixed Issue with ShortCode not calling correct event
	   Fixed Issue with Order of Events in listing - now list by start date
	   Fixed Issue with Edit Attendee Records and Extra Questions Erasing/Not updating
	   Fixed Issue with Folder location on Export Reports - no longer requires custom configs for subdirectory installations
	   Fixed Issue with Events Table Installation - Date format
	   Fixed Issue with Registration Form Validation on Extra Questions
	   Fixed Issue with blank image on Events list when no image was identified
	   Fixed Issue where # of registered attendees also includes additional people on a persons registration.
	   Added Admin Page with inline documenation and support	   
	   Added Admin Page for Uploading Events via CSV file.
	   Added support for start & end times
	   Added support for event location
	   Added support to display # of open registrations left
	   Added support for More Info link to link to another page.
	   Added support to select currency format per event (still have default currency if none selected at event level)
	   Added support to copy an event in the system so duplicates dont have to be re-entered
	   Added confirmation popup when select edit, copy or delete an event.
	   Changed layout of Events list

	   
3.048 - Sql Bug fix when changing organization details
		Adjusted table format when no image is assigned to event
		Added additional Admin panel to provide support feedback about database and also link to online documentation
3.047 - Fixed issue where checks always shows yes on edit
	Fixed issues where allow multiple always shows yes on edit
	Fixed validation issue on regform where added fields wouldnt validate

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
