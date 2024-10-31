=== Plugin Name ===
Contributors: blazingtorch
Tags: paypal, business listings, business directory, advertising, advertisers, paid
Requires at least: 2.7
Tested up to: 3.9
Stable tag: 1.0.5

Allow business to pay to add themselves to directory on your WordPress website

== Description ==

This is a plugin that allows businesses to pay to add themselves to a category-based business listing directory on your WordPress site using package parameters that you have set up.  Install the plugin, fill in your settings, and paste shortcode into WordPress pages or posts.


== Installation ==

1. Upload 'paid-business-listings' folder to the '/content/plugins/' directory or use the 'Add New' option under the 'Plugins' menu in your WordPress backend and 'Upload' 'paid-business-listings.zip'.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure settings for Paid Business Listings in the WordPress dashboard by clicking on the 'Paid Listings' option in your WordPress dashboard.
4. Enter the appropriate information into the form fields on the 'Paid Business Listings General Settings' page.
5. On the 'Listings Packages' page, create the packages that you would like to offer advertisers on your website. ***There should always be at least one package set up for this plugin to work***
6. On the 'Listings Categories' page, create any categories that you would like to use for your listings.
7. On the 'Business Listings' page, manage or delete specific listings or activate any listings that haven't been activated correctly.
5. Paste shortcodes accordingly:
	* Paste this shortcode into the page you would like to use to display your listings: [pbl-listings]
	* Paste this shortcode into the page you would like to use to display your submission form: [pbl-form]
	* Paste this shortcode into the page you would like to use as your "Submission Status" page: [pbl-substatus]

== FAQ ==
= My email address is showing at checkout instead of my business name =
Make sure you have a PayPal business account, and have entered your paypal ID instead of your paypal email address. You may also need to configure PayPal to show the business name instead.

== Screenshots ==

== Changelog ==

= March 25, 2011 - 0.1 =
* Plugin base.

= April 4, 2011 - 0.2 =
* Small revisions to aid in better performance.

= April 7, 2011 - 0.3 =
* Fixed bug in code that displays package list in business listing submission form.
* Changed top-level menu name from 'GD Listings' to 'GDPB Listings'
* Fixed icon path.

= April 11, 2011 - 0.4 =
* Fixed bug in code that displays category list in business listing submission form.

= May 5, 2011 - 0.5 =
* Fixed problem with signing up for packages that cost 0 (they now bypass PayPal payment process and activate upon submission completion).
* Fixed issue with location of plugin assets.
* Fixed issue for listing with no logo graphic
* Categories can now be deleted

= June 8, 2011 - 0.6 =
* Fixed issue with categories/packages/listings not populating the db in certain installations
* Added paypal ID input for paypal business accounts, added text for clairification

= September 30, 2011 - 0.7 =
* Minor interface modifications

= December 29, 2011 - 0.8 =
* Fixes to functions.php file and code cleanup for more efficiency and bug management

= January 14, 2012 - 1.0 =
* Added Form Validation
* Added Support for Multiple Currencies

= February 6, 2012 - 1.0.1 =
* Added Choices for State/Province field
* Fixed Bug with State dropdown while editing listings in the dashboard

= June 28, 2012 - 1.0.2 =
* Fixed bug with MySQL syntax

= July 10, 2012 - 1.0.3 =
* Edited db queries for increased MySQL injection protection

= August 24, 2012 - 1.0.4 =
* "Submission status" page deprecated... shortcode [pbl-substatus] is no longer necessary
* Implemented PayPal IPN listener for more secure activation of listings
* Added Transaction Log to PBL Admin Interface
* Added functions that disallow HTML content to be added to text fields for increased security

= January 21, 2013 - 1.0.5 =
* Small fixes related to WP 3.5 launch