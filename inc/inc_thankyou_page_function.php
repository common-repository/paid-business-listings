<?php

function thankyou_page_function($atts) {
	$site_url=get_site_url();
	$return="<p><a href='$site_url'>click here</a></p>";
	return $return;
}