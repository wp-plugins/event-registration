=== Event Registration ===
Contributors: David Fleming
Donate link: http://www.edgetechweb.com/
Tags: event management, event registration, events managment, events registration, event calendar, events calendar, events, event
Requires at least: 2.0.2
Tested up to: 2.9.2
Stable tag: 5.0

This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to either a Paypal, Google Pay, or Authorize.net online payment site for online collection of event fees.

== Description ==

This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to either a Paypal, Google Pay, or Authorize.net online payment site for online collection of event fees..  Additionally it allows support for checks and cash payments.  Detailed payment management system to track and record event payments.  Reporting features provide a list of events, list of attendees, and excel export.  Events can be created in an Excel spreadsheet and uploaded via the event upload tool.  Dashboard widget allows for quick reference to events from the dashboard.  Inline menu navigation allows for ease of use.

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

Also if you could rate the plugin that would also be helpful.

= Support =

Thanks for all your suggestions and feedback.  I have begun setting up a dedicated site for the plugin www.edgetechweb.com primarily for support issues.  There is a page with installation directions  

Documentation included in the document (link on first tab of plugin Admin Panel) as well as http://edgetechweb.com/instructions/

Please continue to email questions or comments to consultant@avdude.com.  

If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://edgetechweb.com/

Changes:
5.0 - Add CSS for the admin panels
      Revised look and usability of admin panels
      Revised admin accounting features
      Modified registration form to provide ability to use or not use default fields
      Added dashboard widget
      Added calendar
      Added Sample Creation for getting started
      Fixed issue where text would only appear below registration form.
      Fixed other minor bugs.
      
4.0 -  Fixed Issue with ShortCode not calling correct event

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


