<?php
/*
Plugin Name: Paid Business Listings
Plugin URI: http://www.paidbusinesslistings.com
Description: This is a plugin that allows businesses to add themselves to a category-based business listing directory on your Wordpress site using package parameters that you have set up.  Install the plugin, fill in your settings, and paste shortcode into WordPress pages or posts.
Version: 1.0.5
Author: Bryan Haddock
Author URI: http://www.paidbusinesslistings.com/
*/

/*  Copyright 2011-2012 Bryan Haddock

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include("inc/functions.php");
include("inc/display_functions.php");

function includeAdminCSS() {
	echo '<link type="text/css" rel="stylesheet" href="'.plugins_url().'/paid-business-listings/css/pbl-admin.css" />' . "\n";
}
function includePublicCSS() {
	echo '<link type="text/css" rel="stylesheet" href="'.plugins_url().'/paid-business-listings/css/pbl-sc.css" />' . "\n";
}
add_action('admin_head','includeAdminCSS');
add_action('wp_head','includePublicCSS');

include("inc/inc_install_func.php");

register_activation_hook(__FILE__,'pbl_db_install');

include("inc/inc_admin_menu_hooks.php");

function register_pbl_settings() { // whitelist options
  register_setting( 'pbl_options_group', 'pbl_ppbizname' );
  register_setting( 'pbl_options_group', 'pbl_ppemail' );
  register_setting( 'pbl_options_group', 'pbl_ppcurrency' );
  register_setting( 'pbl_options_group', 'pbl_state_province_field' );
  register_setting( 'pbl_options_group', 'pbl_buttimg' );
  register_setting( 'pbl_options_group', 'pbl_butttext' );
  register_setting( 'pbl_options_group', 'pbl_page_id' );
  register_setting( 'pbl_options_group', 'pbl_step_one_message' );
  register_setting( 'pbl_options_group', 'pbl_step_two_message' );
  register_setting( 'pbl_options_group', 'pbl_thank_you_message' );
  register_setting( 'pbl_options_group', 'pbl_bail_message' );
  register_setting( 'pbl_options_group', 'pbl_primary_hex_color' );
  register_setting( 'pbl_options_group', 'pbl_secondary_hex_color' );
}

include("inc/inc_pbl_settings_page.php");
include("inc/inc_pbl_packages_page.php");
include("inc/inc_pbl_categories_page.php");
include("inc/inc_pbl_listings_page.php");
include("inc/inc_pbl_trans_log_page.php");
include("inc/inc_pbl_edit_listing_page.php");
include("inc/inc_display_listings.php");
include("inc/inc_display_form.php");
//include("inc/inc_thankyou_page_function.php"); - removed in v. 1.0.4

add_shortcode('pbl-listings','display_pbl_listings');
add_shortcode('pbl-form','display_pbl_form');
add_shortcode('pbl-substatus','display_pbl_listings');
/*legacy shortcodes*/
add_shortcode('gd-listings','display_pbl_listings');
add_shortcode('gd-form','display_pbl_form');
add_shortcode('gd-substatus','display_pbl_listings');