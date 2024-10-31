<?php
//DATABASE TABLE CREATION FUNCTIONS

global $pbl_db_version;
$pbl_db_version = "1.2";

function pbl_db_install() {
   global $wpdb;
   global $pbl_db_version;

   $table_name = $wpdb->prefix."pbl_listings";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !=$table_name) {
      
      $sql = "CREATE TABLE " .$table_name. " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(55) NOT NULL,
	  logo_url VARCHAR(128) NOT NULL,
	  description text NOT NULL,
	  phone VARCHAR(20) NOT NULL,
	  url VARCHAR(128) NOT NULL,
	  email VARCHAR(64) NOT NULL,
	  address VARCHAR(64) NOT NULL,
	  city VARCHAR(32) NOT NULL,
	  state VARCHAR(64) NOT NULL,
	  zip VARCHAR(5) NOT NULL,
	  cat_id mediumint(9) NOT NULL,
	  pkg_id mediumint(9) NOT NULL,
	  time_listed bigint(11) DEFAULT '0' NOT NULL,
	  time_expired bigint(11) DEFAULT '0' NOT NULL,
	  active tinyint(1) DEFAULT '0' NOT NULL,
	  UNIQUE KEY id (id)
	);";

      	$wpdb->query($sql); 
		$wpdb->insert($wpdb->prefix.'pbl_listings',array('name'=>'Blazing Torch, Inc.','logo_url'=>'http://www.blazingtorch.com/wp-content/uploads/2012/01/blazing-torch-web-development.png','description'=>'Blazing Torch, Inc. develops custom web applications, specializing in WordPress plugin development and customization.','phone'=>'123-456-7890','url'=>'http://www.blazingtorch.com','email'=>'support@blazingtorch.com','address'=>'1234 Blazing Torch Drive','city'=>'Nashville','state'=>'Tennessee','zip'=>'37211','cat_id'=>1,'pkg_id'=>1,'time_listed'=>0,'time_expired'=>1609477199,'active'=>1));
   }

   $table_name = $wpdb->prefix."pbl_packages";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
      
      $sql = "CREATE TABLE ".$table_name." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(55) NOT NULL,
	  description text NOT NULL,
	  cost DECIMAL(6,2) NOT NULL,
	  duration INT(3) NOT NULL,
	  UNIQUE KEY id (id)
	);";

      	$wpdb->query($sql);
      	$wpdb->insert($wpdb->prefix.'pbl_packages',array('name'=>'Sample Package','description'=>'This is a sample package. You should edit it or delete it and create a new one. It is important that you remember to keep a package listed here at all times.','cost'=>'4.00','duration'=>'1'));
   }

   $table_name = $wpdb->prefix."pbl_categories";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
      
      $sql = "CREATE TABLE ".$table_name." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(55) NOT NULL,
	  description text NOT NULL,
	  UNIQUE KEY id (id)
	);";

	$wpdb->query($sql);
	$wpdb->insert($wpdb->prefix.'pbl_categories',array('name'=>'General','description'=>'General business listings.'));
    }

   $table_name = $wpdb->prefix."pbl_trans_log";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
	   $sql = "CREATE TABLE ".$table_name." (
	   		id mediumint(9) NOT NULL AUTO_INCREMENT,
	   		listing_id mediumint(9) NOT NULL,
	   		package_id mediumint(9) NOT NULL,
	   		trans_type VARCHAR(32) NOT NULL,
	   		payment_status VARCHAR(32) NOT NULL,
	   		payment_amount VARCHAR(32) NOT NULL,
	   		trans_id VARCHAR(32) NOT NULL,
	   		timestamp INT(11) NOT NULL,
	   		email VARCHAR(64) NOT NULL,
	   		UNIQUE KEY id (id)
	   );";
	   $wpdb->query($sql);
	   add_option("pbl_db_version",$pbl_db_version);
   }
      
   //DB UPDATE
   switch (get_option('pbl_db_version')){
	   case 1.0:
		   $table_name = $wpdb->prefix."pbl_listings";
		   $sql = "ALTER TABLE " .$table_name. " MODIFY state VARCHAR(64)";
		   $wpdb->query($sql); 
		   
		   $table_name = $wpdb->prefix."pbl_trans_log";
		   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
			   $sql = "CREATE TABLE ".$table_name." (
			   		id mediumint(9) NOT NULL AUTO_INCREMENT,
			   		package_id mediumint(9) NOT NULL,
			   		trans_type VARCHAR(32) NOT NULL,
			   		payment_status VARCHAR(32) NOT NULL,
			   		payment_amount VARCHAR(32) NOT NULL,
			   		trans_id VARCHAR(32) NOT NULL,
			   		timestamp INT(11) NOT NULL,
			   		email VARCHAR(64) NOT NULL,
			   		UNIQUE KEY id (id)
			   );";
			   $wpdb->query($sql);
		   }
		   delete_option('pbl_db_version');
		   add_option("pbl_db_version",$pbl_db_version);
	   break;
	   case 1.1:
		   $table_name = $wpdb->prefix."pbl_trans_log";
		   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
			   $sql = "CREATE TABLE ".$table_name." (
			   		id mediumint(9) NOT NULL AUTO_INCREMENT,
			   		listing_id mediumint(9) NOT NULL,
			   		package_id mediumint(9) NOT NULL,
			   		trans_type VARCHAR(32) NOT NULL,
			   		payment_status VARCHAR(32) NOT NULL,
			   		payment_amount VARCHAR(32) NOT NULL,
			   		trans_id VARCHAR(32) NOT NULL,
			   		timestamp INT(11) NOT NULL,
			   		email VARCHAR(64) NOT NULL,
			   		UNIQUE KEY id (id)
			   );";
			   $wpdb->query($sql);
		   }
		   delete_option('pbl_db_version');
		   add_option("pbl_db_version",$pbl_db_version);
	   break;
   }
   if(get_option('pbl_db_version')=="1.0"){
	   $table_name = $wpdb->prefix."pbl_listings";
	      
	      $sql = "ALTER TABLE " .$table_name. " MODIFY state VARCHAR(64)";
	
	      	$wpdb->query($sql); 
   
   	delete_option('pbl_db_version');
   	add_option("pbl_db_version",$pbl_db_version);
   }   
   
   //clean up old gd_ options if present
   if(get_option('gd_pbl_ppbizname')!=""){
   	$gd_pbl_ppbizname=get_option('gd_pbl_ppbizname');
   	add_option("pbl_ppbizname",$gd_pbl_ppbizname);
   	delete_option('gd_pbl_ppbizname');
   }else{
   	add_option("pbl_ppbizname","My Organization");
   }
   
   if(get_option('gd_pbl_ppemail')!=""){
   	$gd_pbl_ppemail=get_option('gd_pbl_ppemail');
   	add_option("pbl_ppemail",$gd_pbl_ppemail);
   	delete_option('gd_pbl_ppemail');
   }else{
   	add_option("pbl_ppemail","my@paypalemailaddr.ess");
   }
   
   if(get_option('gd_pbl_buttimg')!=""){
   	$gd_pbl_buttimg=get_option('gd_pbl_buttimg');
   	add_option("pbl_buttimg",$gd_pbl_buttimg);
   	delete_option('gd_pbl_buttimg');
   }else{
   	add_option("pbl_buttimg","https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif");
   }
   
   if(get_option('gd_step_one_message')!=""){
   	$gd_step_one_message=get_option('gd_step_one_message');
   	add_option("pbl_step_one_message",$gd_step_one_message);
   	delete_option('gd_step_one_message');
   }else{
   	add_option("pbl_step_one_message","Fill out the form below if you'd like for your business to be posted on this website.");
   }
   
   if(get_option('gd_pbl_butttext')!=""){
   	$gd_pbl_butttext=get_option('gd_pbl_butttext');
   	add_option("pbl_butttext",$gd_pbl_butttext);
   	delete_option('gd_pbl_butttext');
   }else{
   	add_option("pbl_butttext","List Your Business");
   }
   
   if(get_option('gd_step_two_message')!=""){
   	$gd_step_two_message=get_option('gd_step_two_message');
   	add_option("pbl_step_two_message",$gd_step_two_message);
   	delete_option('gd_step_two_message');
   }else{
   	add_option("pbl_step_two_message","In order to complete your purchase, click on the button below.");
   }
   
   if(get_option('gd_thank_you_message')!=""){
   	$gd_thank_you_message=get_option('gd_thank_you_message');
   	add_option("pbl_thank_you_message",$gd_thank_you_message);
   	delete_option('gd_thank_you_message');
   }else{
   	add_option("pbl_thank_you_message","Thank you for becoming a business partner. Your submission has been placed in our directory.");
   }
   
   if(get_option('gd_bail_message')!=""){
   	$gd_bail_message=get_option('gd_bail_message');
   	add_option("pbl_bail_message",$gd_bail_message);
   	delete_option('gd_bail_message');
   }else{
   	add_option("pbl_bail_message","You have chosen to cancel payment for your submission, but your information has been saved. If you want to discuss activating your submission, contact the administrators of this website.");
   }
   
   if(get_option('gd_primary_hex_color')!=""){
   	$gd_primary_hex_color=get_option('gd_primary_hex_color');
   	add_option("pbl_primary_hex_color",$gd_primary_hex_color);
   	delete_option('gd_primary_hex_color');
   }else{
   	add_option("pbl_primary_hex_color","#000000");
   }
   
   if(get_option('gd_secondary_hex_color')!=""){
   	$gd_secondary_hex_color=get_option('gd_secondary_hex_color');
   	add_option("pbl_secondary_hex_color",$gd_secondary_hex_color);
   	delete_option('gd_secondary_hex_color');
   }else{
   	add_option("pbl_secondary_hex_color","#0000FF");
   }

   if(get_option('gd_page_id')!=""){
   	$gd_page_id=get_option('gd_page_id');
   	add_option("pbl_page_id",$gd_page_id);
   	delete_option('gd_page_id');
   }
}