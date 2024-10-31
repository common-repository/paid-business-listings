<?php

//DEFINE VARIABLES USED IN MULTIPLE PLACES
$primary_color=get_option('pbl_primary_hex_color');
$secondary_color=get_option('pbl_secondary_hex_color');

function pbl_clean($string){
	return strip_tags(nl2br($string),"<br>");
}

function getCategoryName($id){
	global $wpdb;
	$category = $wpdb->get_row("SELECT name FROM ".$wpdb->prefix."pbl_categories WHERE id = $id");
	if($category->name==""){
		$return.="--";
	}else{
		$return.=$category->name;
	}
	return $return;
}

function getPackageName($id){
	global $wpdb;
	$package = $wpdb->get_row("SELECT name FROM ".$wpdb->prefix."pbl_packages WHERE id = $id");
	if($package->name==""){
		$return="--";
	}else{
		$return=$package->name;
	}
	return $return;
}

function getPackageDuration($id){
	global $wpdb;
	$package = $wpdb->get_row("SELECT duration FROM ".$wpdb->prefix."pbl_packages WHERE id = $id");
	if($package->duration==0){
		$return.=0;
	}else{
		if($package->duration==1){
			$return.="+1 month";
		}else{
			$return.="+".$package->duration." months";
		}
	}
	return $return;
}

function getCategoryList($selected=""){
global $wpdb;
	$categories = $wpdb->get_results("SELECT id,name FROM ".$wpdb->prefix."pbl_categories");
	if(count($categories)==0){
		$return.="No categories are currently set up.";
	}elseif(count($categories)==1){
		foreach($categories as $cat){
			$id=$cat->id;
			$name=stripslashes($cat->name);
			$return.="<em>$name</em><input type='hidden' name='pbl_listing_cat_id' value='$id' />";
		}
	}else{
		$return.="<select name='pbl_listing_cat_id'>";
		$return.="<option value=''>Select a Category</option>";
		foreach($categories as $cat){
			$id=$cat->id;
			$name=stripslashes($cat->name);
			if($id==$selected){$sel="selected ";}else{$sel="";}
			$return.="<option value='$id' $sel>$name</option>";
		}
		$return.="</select>";
		
	}
	return $return;
}

function getPackageList($selected=""){
global $wpdb;
	$pbl_package_currency=get_option('pbl_ppcurrency');
	$packages = $wpdb->get_results("SELECT id,name,cost,duration FROM ".$wpdb->prefix."pbl_packages");
	if(count($packages)==0){
		$return.="No packages are currently set up.";
	}elseif(count($packages)==1){
		foreach($packages as $pkg){
			$id=$pkg->id;
			$name=stripslashes($pkg->name);
			$cost=stripslashes($pkg->cost);
			$duration=stripslashes($pkg->duration);
			if($duration==1){$monthtense="month";}else{$monthtense="months";}
			$return.="<em>$name - $cost $pbl_package_currency/$duration $monthtense</em><input type='hidden' name='pbl_listing_pkg_id' value='$id' />";
		}
	}else{
		$multi_pkg_display="<select name='pbl_listing_pkg_id'>";
		$multi_pkg_display.="<option value=''>Select a Package</option>";
		foreach($packages as $pkg){
			$id=$pkg->id;
			$name=stripslashes($pkg->name);
			$cost=stripslashes($pkg->cost);
			$duration=stripslashes($pkg->duration);
			if($duration==1){$monthtense="month";}else{$monthtense="months";}
			if($id==$selected){$sel="selected ";}else{$sel="";}
			$multi_pkg_display.="<option value='$id' $sel>$name - $cost $pbl_package_currency/$duration $monthtense</option>";
		}
		$multi_pkg_display.="</select>";

		$return.=$multi_pkg_display;
	}
	return $return;
}

function getCurrentPackageList($current){
global $wpdb;
	$packages = $wpdb->get_results("SELECT id,name FROM ".$wpdb->prefix."pbl_packages");
	if(count($packages)==0){
		$return.="No packages are currently set up. You MUST set up at least one package for this plugin to work properly.";
	}elseif(count($packages)==1){
		foreach($packages as $pkg){
			$id=$pkg->id;
			$name=stripslashes($pkg->name);
			$return.="<em>$name</em><input type='hidden' name='pbl_listing_pkg_id' value='$id' />";
		}
	}else{
		$return.="<select name='pbl_listing_pkg_id'>";
		foreach($packages as $pkg){
			$id=$pkg->id;
			if($id==$current){$sel= "selected='selected'";}else{$sel= "";}
			$name=stripslashes($pkg->name);
			$return.="<option value='$id' $sel>$name</option>";
		}
		$return.="</select>";
	}
	return $return;
}

function getCurrentCategoryList($current){
global $wpdb;
	$categories = $wpdb->get_results("SELECT id,name FROM ".$wpdb->prefix."pbl_categories");
	if(count($categories)==0){
		$return.="No categories are currently set up.";
	}elseif(count($categories)==1){
		foreach($categories as $cat){
			$id=$cat->id;
			$name=stripslashes($cat->name);
			$return.="<em>$name</em><input type='hidden' name='pbl_listing_cat_id' value='$id' />";
		}
	}else{
		$return.="<select name='pbl_listing_cat_id'>";
		foreach($categories as $cat){
			$id=$cat->id;
			if($id==$current){$sel= "selected='selected'";}else{$sel= "";}
			$name=stripslashes($cat->name);
			$return.="<option value='$id' $sel>$name</option>";
		}
		$return.="</select>";
	}
	return $return;
}

function pp_image_option_radios($imgurl){
	if(get_option('pbl_buttimg')==$imgurl){$status="checked";}
	$option="<tr><td><input type=\"radio\" name=\"pbl_buttimg\" value=\"$imgurl\" $status /></td><td style=\"padding:10px; background-color: #CCCCCC; text-align: center;\"><img src=\"$imgurl\" align=\"middle\" /></td></tr>";
	return $option;
}

function stateSelect($state_province_field,$selected=""){
	$us_state_array=array(''=>'Select Your State', 'AK'=>'Alaska', 'AL'=>'Alabama', 'AR'=>'Arkansas', 'AZ'=>'Arizona', 'CA'=>'California', 'CO'=>'Colorado', 'CT'=>'Connecticut', 'DC'=>'District of Columbia', 'DE'=>'Delaware', 'FL'=>'Florida', 'GA'=>'Georgia', 'HI'=>'Hawaii', 'IA'=>'Iowa', 'ID'=>'Idaho', 'IL'=>'Illinois', 'IN'=>'Indiana', 'KS'=>'Kansas', 'KY'=>'Kentucky', 'LA'=>'Louisiana', 'MA'=>'Massachusetts', 'MD'=>'Maryland', 'ME'=>'Maine', 'MI'=>'Michigan', 'MN'=>'Minnesota', 'MO'=>'Missouri', 'MS'=>'Mississippi', 'MT'=>'Montana', 'NC'=>'North Carolina', 'ND'=>'North Dakota', 'NE'=>'Nebraska', 'NH'=>'New Hampshire', 'NJ'=>'New Jersey', 'NM'=>'New Mexico', 'NV'=>'Nevada', 'NY'=>'New York', 'OH'=>'Ohio', 'OK'=>'Oklahoma', 'OR'=>'Oregon', 'PA'=>'Philadelphia', 'RI'=>'Rhode Island', 'SC'=>'South Carolina', 'SD'=>'South Dakota', 'TN'=>'Tennessee', 'TX'=>'Texas', 'UT'=>'Utah', 'VA'=>'Virginia', 'VT'=>'Vermont', 'WA'=>'Washington', 'WI'=>'Wisconsin', 'WV'=>'West Virginia', 'WY'=>'Wyoming');

	$au_state_array=array(''=>'Select Your Province', 'ACT'=>'Australian Capital Territory', 'NSW'=>'New South Wales', 'VIC'=>'Victoria', 'QLD'=>'Queensland', 'SA'=>'South Australia', 'WA'=>'Western Australia', 'TAS'=>'Tasmania', 'NT'=>'Northern Territory');

	$ca_state_array=array(''=>'Select Your Province', 'ON'=>'Ontario', 'QC'=>'Quebec', 'NS'=>'Nova Scotia', 'NB'=>'New Brunswick', 'MB'=>'Manitoba', 'BC'=>'British Columbia', 'PE'=>'Prince Edward Island', 'SK'=>'Saskatchewan', 'AB'=>'Alberta', 'NL'=>'Newfoundland and Labrador');

	if($state_province_field=="US"){$array_to_use=$us_state_array;}
	if($state_province_field=="AU"){$array_to_use=$au_state_array;}
	if($state_province_field=="CA"){$array_to_use=$ca_state_array;}
	
	foreach($array_to_use as $state_abbr=>$state_name){
		if(($selected==$state_abbr)||($selected==$state_name)){$select_status="selected ";}else{$select_status="";}
		$return.="<option $select_status value='$state_name'>$state_name</option>\n";
	}
	
	return $return;
}
