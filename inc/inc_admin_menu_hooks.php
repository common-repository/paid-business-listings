<?php

//ADMIN MENU INTERFACES

add_action('admin_menu','pbl_menu');

function pbl_menu() {

	//create new top-level menu
	add_menu_page('Business Listings','Paid Listings','administrator','pbl_settings','pbl_settings_page',plugins_url().'/paid-business-listings/images/btflame-sm.png');
	//create new submenus
	add_submenu_page('pbl_settings','Packages','Listings Packages','administrator','pbl_settings_packages','pbl_packages_page');
	add_submenu_page('pbl_settings','Categories','Listings Categories','administrator','pbl_settings_categories','pbl_categories_page');
	add_submenu_page('pbl_settings','Listings','Business Listings','administrator','pbl_settings_listings','pbl_listings_page');
	add_submenu_page('pbl_settings','Transactions','Transactions','administrator','pbl_settings_trans_log','pbl_trans_log_page');
	add_submenu_page('','Edit Listings','Edit Listings','administrator','pbl_settings_edit_listings','pbl_edit_listing_page');

	//call register settings function
	add_action('admin_init','register_pbl_settings');
}
