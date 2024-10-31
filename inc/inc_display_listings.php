<?php

function display_pbl_listings($atts) {
	global $wpdb;
	
	$return.="<style>";
	$return.="#pbl-listing-wrapper {border-bottom: 1px dotted $primary_color;}";
	$return.="#pbl-listing-wrapper .pbl-content a {color: $secondary_color;}";
	$return.="#pbl-listing-wrapper .pbl-content a:hover {color: $primary_color;}";
	$return.="</style>";

if($atts[category]!=""){$category="cat_id='".$atts[category]."' AND ";}	
if($atts[package]!=""){$package="pkg_id='".$atts[package]."' AND ";}
$timenow=time();	
	$listings=$wpdb->get_results("SELECT id,name,logo_url,description,phone,url,email,address,city,state,zip FROM ".$wpdb->prefix."pbl_listings WHERE $package $category time_expired>$timenow AND active=1");
	
	foreach($listings as $listing){
		$id=$listing->id;
		$name=stripslashes($listing->name);
		if($listing->logo_url!=""){$logo="<img src=\"".stripslashes($listing->logo_url)."\" />";}else{$logo="<img src=\"".plugins_url()."/paid-business-listings/images/no-image-available.png\" />";}
		$description=stripslashes($listing->description);
		$phone=stripslashes($listing->phone);
		$url=stripslashes($listing->url);
		$email=stripslashes($listing->email);
		$address=stripslashes($listing->address);
		$city=stripslashes($listing->city);
		$state=stripslashes($listing->state);
		$zip=stripslashes($listing->zip);
		$return.="<div id='pbl-listing-wrapper'>";
		$return.="<div class='pbl-logo'>";
		$return.="<a href='$url' target='_blank'>$logo</a>";
		$return.="<div style='clear:both;'></div></div>";
		$return.="<div class='pbl-content'>";
		$return.="<div class='listing-title'><a href='$url' target='_blank'>$name</a></div>";
		$return.="<div class='listing-description'>$description</div>";
		$return.="<div class='listing-contact-left'>$address<br />$city, $state $zip</div>";
		$return.="<div class='listing-contact-right'>$phone<br /><a href='mailto:$email' >$email</a></div>";
		$return.="<div class='listing-contact-bottom'><a href='$url' target='_blank'>";
		$return.=str_replace("http://","",$url);
		$return.="</a></div>";
		$return.="<div style='clear:both;'></div></div>";
		$return.="<div style='clear:both;'></div></div>";
	}
	return $return;
}
