=== Event Registration ===
Contributors: davidfleming
Donate link: http://www.avdude.com/
Tags: event management, event registration
Requires at least: 2.0.2
Tested up to: 2.7
Stable tag: 2.9.7

Provides the ability to setup event list and accept online registrations for events and administer them via WordPress. Supports paypal and international currency via paypal

== Description ==

This plugin provides a way to take online registrations for events such as conference and seminars that are held live.
This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the register to your paypal payment site for online collection of event fees. 
Reporting features provide a list of events, list of attendees, and excel export.
I have added the ability to edit events and to allow single event or event listing on the registration page.

= Support =

I will be working on this to improve as I have a list of improvements I need right away, but I thought I would get it out there and see if others liked/could use it.  email questions or comments to consultant@avdude.com.  

Changes:

2.97
	Enabled registration form validation - checks for data in field only.
	Commented out "Are you sure"" on entry and edit buttons, left in tact on all "DELETE" buttons
	Set Default currency to display "$" when set to USD or when it is blank.  Blank currency is set to USD for paypal.
2.96
	Fixed SQL code errors.
2.95
 Added the ability to send retun link in email for payment - setup a new page and place {EVENTREGPAY}.  Store page link in Organization options in admin panel.  Email link includes page name and attendees unique registration ID.  If payment has already been posted in the payment section, the page will notify attendee of payments previously made.

2.94
	Added support to send custom confirmation email for each event or default email for organization or no confirmation mail at all.	
	Paypal ID required to display creditcard/paypal info on payment screen.	
	Modified the Event Report Page to choose which event to view/export from list of all events.	
	Added support to have the event description display or not display on the registration page.  Option on the Event Setup Page.	
	Added support to limit the number of attendees for an event.  Option on the Event Setup Page.	
	Added support for free/no cost events.  If the fee is left blank on the event setup page, payment options and cost are not displayed on the reg form and 
	payment information is not displayed on reg confirmation page.
	Added ability to display attendee list on page or post {EVENTATTENDEES} - displays event name, description and list of attendeeds by order of registration.  
	To change sort order of attendees change line 399 to  $sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id' ORDER BY lname";
2.93
	Resolved potential Mysql error due to database call
2.92
	Some minor bug fixes
	changed event name from 45 to 100 characters
2.91
	Resolved attendee posting error (no data in attendee datatable)
	Resolved EVENT ID deletion when editing event	
2.9
	Resolved Confirmation mail not sending text
	Resolved amount not shown on registration page, registration confirmation page, and paypal site
	Resolved payment paypal & check information display properly

2.6	Changed email confirmation to use wp_mail() (built into wordpress) default instead of smtp plugin.
	Changed mail header to use registrars email address instead of wordpress default
	Added funtion for single or multiple event display on registration.
	Fixed paypal to say PayPal
	Removed broken image links from PayPal
	Droped in codeblocks to update tables
	Change buy now button to PAY NOW
	Added ability to edit existing events
	added ability to edit confirmation email sent to registrants
	Added ability to add 4 custom form questions to registration page - only visible is used.
	Added description for events  and display description of registration page


If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at www.avdude.com/wp


== Installation ==

1. After unzipping, upload everything in the `Events Registration` folder to your `/wp-content/plugins/` directory (preserving directory structure).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Event Registration Menu and Configure Organization and enter your company info - note you will need a paypal id if you plan on accepting paypal payments
4. Go to the Event Setup and create a new event, make sure you select 'make active'.
5. Create a new page (not post) on your site. Put `{EVENTREGIS}` in it on a line by itself.
6. Note: if you are upgradings from a previous version please backup your data prior to upgrade.

All done. 


= License =

This plugin is provided "as is" and without any warranty or expectation of function. I'll probably try to help you if you ask nicely, but I can't promise anything. You are welcome to use this plugin and modify it however you want, as long as you give credit where it is due. 

But please don't redistribute this plugin from anywhere other than right here. But send me your improvements and I'll add them in and include a shout-out to you here.

== Screenshots ==

www.avdude.com/wp/events

== Frequently Asked Questions ==

There are none yet!  Please feel free to send them.