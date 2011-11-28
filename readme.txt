=== Event Registration ===
Contributors: David Fleming
Donate link: http://www.wordpresseventregister.com/donations
Tags:   event, events, event registration, event management,events managment, events registration, event calendar, calendar, class,events calendar, events, event, class registration, class schedule, classes
Requires at least: 2.0.2
Tested up to: 3.2.1
Stable tag: 6.00.07

This plugin is designed to allow you to take online registrations for events and classes. 
Supports Paypal, Google Pay, MonsterPay or Authorize.net online payment sites for online collection of event fees.

== Description ==

This wordpress plugin is designed to run on a Wordpress website and provide registration events, classes, or parties. It is designed to be easy to navigate.
It allows you to capture the registering persons contact information and any additional infromation you request to a database and provides an association to an events database. 
It provides the ability to send the register to either a Paypal, Google Pay, Monster Pay,  or Authorize.net online payment site for online collection of event fees.
Additionally it allows support for checks and cash payments.  
Optional Captcha field on registration form.
Detailed payment management system to track and record event payments and support for PayPal payment notification.  
Reporting features provide a export list(s) of events, attendees, payments in excel or csv.  

If you like the plugin and find it useful, please donate.  
Your donations help me keep it going and improve it.  
You can find online information at http://wordpresseventregister.com/

Also if you could rate the plugin that would also be helpful.

== Upgrading ==

If you have used event registration in the past and desire to keep your data, version 6.0 will create new data tables and copy all your data upon activation.  
If you are unsatisfied with the upgrade, simply deactivate and delete the plugin.  You can then download the prior version and mannually upload to your system.  
All your old data will still be in tact as the upgrade copies and creates new tables, and leaves the existing ones for easy rollback.

Please note that because of conflicts with other plugins (people copying my work!), I have changed many of the shortcodes and functions, so you will need to update all your shortcodes on your pages.


* {EVENTREGIS}   Now -> {EVRREGIS}
* [Event_Registration_Calendar] Now -> {EVR_CALENDAR}
* {EVENTREGPAY}  Now -> [EVR_PAYMENT]
* [EVENT_REGIS_CATEGORY event_category_id="??"]  Now -> [EVR_CATEGORY event_category_id="????"] where ???? is your custom identfier - see category listing.
* [Event_Registration_Single event_id="??"] Now -> [EVR_SINGLE event_id="??"] where ?? is the ID number of the event.
* [EVENT_ATTENDEE_LIST event_id="??"]  Now -> 



If you are upgrading from a version prior to 6.0, I have made some major changes to the database and depending on your configuration, it may or may not upgrade the first attempt.  
I recommend activating and deactivating the new version several times. if you are having issues.


== Installation ==

= How to Use: = 

1. If you are upgrading from a previous version, please see upgrading directions.

2. Download and install the plugin.

3. Activate the plugin.

4. Create a new page on your site and title it Registration. On that page, in html view, put this text:   {EVRREGIS}  Save the page.

5. Create another page on your site and title it Calendar. On that page, in html view, put this text:  {EVR_CALENDAR}  Save the page.

6. Create another page on your side and title it Event Payments.  Make the page hidden from navigation.  On that page, in the html view, put this text:  [EVR_PAYMENT]  Save the page

7. Now you are ready to configure the plugin for operation.  To get started, once you activate the plugin, please go into the Company settings and complete the information as it is requested.  In the company information , Under page settings, the main registration page, there will be  a dropdown box, select the page you setup as Registration.
In the company information, under page settings, the events payment page, there will be a dropdown box, select the page you setup as Payment. 

8. Next go to the Category section. In the Categories section, create a few categories for your events.

9. Now you are ready to create events.  Go to the Events section and select add new event.  Complete the requested information in all tabs.  The submit button is located in the last tab.

10. Event creation and event pricing are handled as separate tasks.   You are able to create multiple pricing levels and optional pricing items with this version.  Once you have created an event, view the event listing and you will see a button to add tickets/items.  Add items such as registation fees, sales items or whatever you want to charge for or give away.  You must create an item in order to take registrations.

11. Once you have created your pricing items, you are now ready to take registrations.  Go to your registrations and click the event and try it out. 

* If you want to setup a page for a single event, use this shortcode on the page: [EVR_SINGLE event_id="??"] where ?? is the ID number of the event (you can only use one shortcode per page!)
* If you want to setup a page for a particular category of events, use this shortcode on the page: [EVR_CATEGORY event_category_id="????"] where ???? is your custom identfier - see category listing (you can only use one shortcode per page!)




== Support ==


How to Use:
Create a new page on your site and title it Registration.
On that page, in html view, put this text:   {EVRREGIS}
Save the page.

Create another page on your site and title it Calendar
On that page, in html view, put this text:  {EVR_CALENDAR}

Create another page on your side and title it Event Payments
Make the page hidden from navigation
On that page, in the html view, put this text:  [EVR_PAYMENT]

Now you are ready to configure the plugin for operation.
To get started, once you activate the plugin, please go into the Company settings and complete the information. 
In the company information , Under page settings, the main registration page, there will be  a dropdown box, select the page you setup as Registration.
In the company information, under page settings, the events payment page, there will be a dropdown box, select the page you setup as Payment.
Create a few categories for your events,  Then create a few events.  Make sure you add items to your events. Event creation and event pricing are handled as separate tasks.  You are able to create multiple pricing levels and optional pricing items with this version.


== Change Log ==

= Version 6.00.07 = 
* Changed DB Installation and Upgrade to simplfly and condition upgrading
* Added sponsor section
* Moved all admin scripts and style to enqueue.
* Resolved depricated options issue
* Added system alerts

= Version 6.00.06 = 
* changed DB uninstall feature from a hidden deactivate feature to a menu choice.
* Added more information and links to the splash page
* Changed logo
* Added donation links throughout

= Version 6.00.05.01 = 
* Fixed help window on Company-->Page Settings to display proper shortcode

= Version 6.00.05 = 
* added product branding
* resolved issue jquery tabs

= Version 6.00.04.01 = 
* jquery on from wordpress default all the time
* resolved issue with image folder I vs. i


= Version 6.00.04 = 
* Fixed issues with AutoIncrement new events and new attendee records
* changed textbox edit bar in add event and company settings

= Version 6.00.03 = 
* Fixed security hole in registration from data posting

= Version 6.00.02 = 
* changed jquery to use wordpress builtin jquery

= Version 6.00.01 = 
* Minor Jquery fixes

= Version 6.00.00 = 
* Add jquery popup feature to plugin

= Version 5.98 = 
* Created function to convert Event Registration data tables from version 5.43/earlier to version 5.99/6.00 format and import old data

= Version 5.97 = 
* Created language file and added ,'evr_language' to all echo'd text

= Version 5.96 = 
* Fixed mail send issue on payment IPN
* corrected typo in database name in ipn validation page
* Added help for payment confirmation email in Company Settings
* Repaired code issue where drag and drop on questions and event fees was broken
* Repaired code issue where popup for new event didnt tab - now works properly
* Added ability to edit Event Pay Button in Company Settings
* Added fname field to return payment url to reduce hackability


= Version 5.95 = 
* updated IPN link in registration paypal section to post properly.
* updated IPN link in Return to Pay for paypal
* added require file for ipn data posting file
* made changes to attendee table - added 3 columns
* Fixed IPN script to add information to payment table
* Fixed IPN script to post payment amount correctly
* Changed function name form_build and form_build_edit to evr_form_build and evr_form edit to prevent conflict with earlier versions
* Added Reg ID to attendee list display in admin panel
* fixed code bug in [id] replacement


= Version 5.94 = 
* Added Global variable $evr_date_format
* Changed date format for UK of d/m/Y i.e. 24/03/2011 for March 24, 2011 for event listings
* added [id] tag in custom email format for sending mail to attendee
* Added version number to Menu Head on sidebar
* changed moneyFormat function to evr_moneyFormat to prevent confilict with earlier versions of Event Registration
* Updated the js folder with the CSS and images for reordering items

= Version 5.93 = 
* Removed unused menu items
* Fixed Attendee Export to Excel and CSV
* Fixed Event Name display in Admin Payment Panel
* Added Export to Excel in Payment Panel
* Fixed issue where extra questions would not reorder - now drag and drop order
* Fixed issue where event ticket/prices would not reorder - now drag and drop order
* Fixed popup close button not visible on event popups
* Replaced all jquery calls to use internal wordpress Jquery instead of external jquery
* Added custom function to fix permalink issue with ? or & automatically called
* Fixed permalink for page links on regform to use permalink instead of page id.
* Fixed permalink for page links fon calendar to use permalink instead of page id.
* Fixed bug in using Single Page shortcode where event id would erase.


= Version 5.92 = 
* completed function for return payment page/shortcode [EVR_PAYMENT]
* fixed Notify/Cancel URL fields in Company Settings
* Clairified shortcode/Filter on Company settings for pages
* Changed button label on Items to Fees/Items
* fixed ics generator to support events with symbols in name.
* Fixed tooltip not working in Company tab

= Version 5.91 = 
* Added £ symbol to currency display when GBP is selected as currency
* Added $ symbol to currency display when USD is selected as currency
* fixed / escaping characters issue in event creation and editing where it was adding extra /
* added submit button disabled when submit pressed to prevent multiple submissions on same form
* changed display layout of popup window on events listing - customer side
* fixed close icon not displaying on popup window - customer side
* fixed spacing issue on event listing page for all events
* changed "Registration Form Here" to event title on registration form.


= Version 5.90 = 

--Revamped all the code to change functions names to prevent conflict with those who used my code and was too lazy to rewrite it.


. . . See changelog.txt for more changes


To Do List:


Excel export code page
Event Import Tool
Reports Tool
Support tool
Send Mail tool





