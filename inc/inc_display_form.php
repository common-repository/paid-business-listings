<?php

function display_pbl_form($atts) {
	global $wpdb;
	
	$this_url=get_permalink($post->ID);
	$pbl_step_one_message=get_option('pbl_step_one_message');
	$pbl_step_two_message=get_option('pbl_step_two_message');
	$pbl_submit_button_text=get_option('pbl_butttext');
	
	//FORM VALIDATION
	if($_POST['action']=="paypal_form"){
		$name=pbl_clean($_POST['pbl_listing_name']);
		$logo_url=$_POST['pbl_listing_logo_url'];
		$description=pbl_clean($_POST['pbl_listing_description']);
		$phone=pbl_clean($_POST['pbl_listing_phone']);
		$url=pbl_clean($_POST['pbl_listing_url']);
		$email=pbl_clean($_POST['pbl_listing_email']);
		$address=pbl_clean($_POST['pbl_listing_address']);
		$city=pbl_clean($_POST['pbl_listing_city']);
		$state=pbl_clean($_POST['pbl_listing_state']);
		$zip=pbl_clean($_POST['pbl_listing_zip']);
		$cat_id=$_POST['pbl_listing_cat_id'];
		$pkg_id=$_POST['pbl_listing_pkg_id'];
		
		if($name==""){$err.="<li>You must enter your Company's name</li>";}
		if($description==""){$err.="<li>Your Business Description must not be blank</li>";}
		if($phone==""){$err.="<li>Your Business Phone cannot be blank</li>";}
		if($url==""){$err.="<li>Your Website URL cannot be blank</li>";}
		if($email==""){$err.="<li>Your Business Email Address cannot be blank</li>";}
		if($address==""){$err.="<li>Your Street Address cannot be blank</li>";}
		if($city==""){$err.="<li>Your City cannot be blank</li>";}
		if($state==""){$err.="<li>Your State/Province cannot be blank</li>";}
		if($zip==""){$err.="<li>Your Postal Code cannot be blank</li>";}
		if($cat_id==""){$err.="<li>You must select a category</li>";}
		if($pkg_id==""){$err.="<li>You must select a package</li>";}
	}
	
	if((isset($_GET['subid']))&&(isset($_GET['sc']))){
		$return.=($_GET['sc']==1) ? "<p>".get_option('pbl_thank_you_message')."</p>" : "<p>".get_option('pbl_bail_message')."</p>";
		
	}

	if(isset($_GET['ppn'])){
		// PAYPAL IPN LISTENER
		$req = 'cmd=' . urlencode('_notify-validate');
		 
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.paypal.com'));
		$res = curl_exec($ch);
		curl_close($ch);
		 
		// assign posted variables to local variables
		$item_number = $_POST['item_number'];
		$item_name = $_POST['item_name'];
		$submission_id = $_POST['custom'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		 
		if (strcmp ($res, "VERIFIED") == 0) {
			($payment_status=="Completed")? $wpdb->update($wpdb->prefix.'pbl_listings',array('active'=>1),array('id'=>$submission_id)) : null;
		}
		else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
		}
		$time=time();
		$wpdb->insert($wpdb->prefix.'pbl_trans_log',array('listing_id'=>$submission_id,'package_id'=>$item_number,'trans_type'=>'paypal','payment_status'=>$payment_status,'payment_amount'=>$payment_amount,'trans_id'=>$txn_id,'timestamp'=>$time,'email'=>$payer_email));
	}

	if(($_POST['action']=="paypal_form")&&(!isset($err))){

		$time_listed=time();
		$durmonths=getPackageDuration($pkg_id);
		$time_expired=strtotime($durmonths);
	
		$wpdb->insert($wpdb->prefix.'pbl_listings',array('name'=>$name,'logo_url'=>$logo_url,'description'=>$description,'phone'=>$phone,'url'=>$url,'email'=>$email,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'cat_id'=>$cat_id,'pkg_id'=>$pkg_id,'time_listed'=>$time_listed,'time_expired'=>$time_expired,'active'=>0));
					
		$package_info = $wpdb->get_row("SELECT id,name,cost,duration FROM ".$wpdb->prefix."pbl_packages WHERE id='$pkg_id'");
		$submission_info = $wpdb->get_row("SELECT id FROM ".$wpdb->prefix."pbl_listings WHERE time_listed='$time_listed'");
		$submission_id=$submission_info->id;
	
		if($package_info->cost=="0"){ //SHOW THIS FORM IF COST IS 0
		
			$wpdb->update($wpdb->prefix.'pbl_listings',array('active'=>1),array('id'=>$submission_id));
			$return.="<p>".get_option('pbl_thank_you_message')."</p>";
			
			
		}else{ //SHOW THIS FORM IF COST IS NOT 0
		
			$pbl_package_id=$package_info->id;
			$pbl_package_name=$package_info->name;
			$pbl_package_cost=$package_info->cost;
			
			$return.=displayPayPalForm($pbl_step_two_message,$pbl_package_id,$pbl_package_name,$pbl_package_cost,$submission_id,$this_url);
		}
	
	}else{
		
		if((!isset($_GET['subid']))&&(!isset($_GET['sc']))){	
		$form_array[] = array('type'=>"hidden", 'name'=>"action", 'value'=>"paypal_form");
		$form_array[] = array('type'=>"text", 'label'=>"Company Name", 'name'=>"pbl_listing_name", 'value'=>$name);
		$form_array[] = array('type'=>"text", 'label'=>"Logo URL", 'name'=>"pbl_listing_logo_url", 'value'=>$logo_url, 'note'=>"NOTE: If no logo is provided, a placeholder graphic will be displayed.");
		$form_array[] = array('type'=>"textarea", 'label'=>"Business Description", 'name'=>"pbl_listing_description", 'value'=>$description);
		$form_array[] = array('type'=>"text", 'label'=>"Business Phone", 'name'=>"pbl_listing_phone", 'value'=>$phone);
		$form_array[] = array('type'=>"text", 'label'=>"Website URL", 'name'=>"pbl_listing_url", 'value'=>$url);
		$form_array[] = array('type'=>"text", 'label'=>"Business Email Address", 'name'=>"pbl_listing_email", 'value'=>$email);
		$form_array[] = array('type'=>"text", 'label'=>"Street Address", 'name'=>"pbl_listing_address", 'value'=>$address);
		$form_array[] = array('type'=>"text", 'label'=>"City", 'name'=>"pbl_listing_city", 'value'=>$city);
		$state_field=(get_option('pbl_state_province_field')=="") ? "TEXT" : get_option('pbl_state_province_field');
		switch($state_field){ case TEXT:
				$form_array[] = array('type'=>"text", 'label'=>"State/Province", 'name'=>"pbl_listing_state", 'value'=>$state);
			break;
			default:
				$form_array[] = array('type'=>"select", 'label'=>"State/Province", 'name'=>"pbl_listing_state", 'options'=>stateSelect($state_field,$state));			
		}
		$form_array[] = array(
			'type'=>"text", 'label'=>"Postal Code", 'name'=>"pbl_listing_zip", 'value'=>$zip);
		$form_array[] = array('type'=>"taxonomy", 'taxonomy-type'=>"category", 'value'=>$cat_id,);			
		$form_array[] = array('type'=>"taxonomy", 'taxonomy-type'=>"package", 'value'=>$pkg_id,);			
		$form_array[] = array('type'=>"submit", 'value'=>$pbl_submit_button_text,);			
		$return.=displayFormTable($pbl_step_one_message,"pbl-form-wrapper",$err,$form_array);
		}
	}
	
	return $return;
} 