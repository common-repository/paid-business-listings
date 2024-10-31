<?php

function pbl_listings_page() {
global $wpdb;

	if($_POST['action']=="add_listing"){
		$name=mysql_real_escape_string(stripslashes($_POST['pbl_listing_name']));
		$logo_url=mysql_real_escape_string(stripslashes($_POST['pbl_listing_logo_url']));
		$description=mysql_real_escape_string(stripslashes($_POST['pbl_listing_description']));
		$phone=mysql_real_escape_string(stripslashes($_POST['pbl_listing_phone']));
		$url=mysql_real_escape_string(stripslashes($_POST['pbl_listing_url']));
		$email=mysql_real_escape_string(stripslashes($_POST['pbl_listing_email']));
		$address=mysql_real_escape_string(stripslashes($_POST['pbl_listing_address']));
		$city=mysql_real_escape_string(stripslashes($_POST['pbl_listing_city']));
		$state=$_POST['pbl_listing_state'];
		$zip=mysql_real_escape_string(stripslashes($_POST['pbl_listing_zip']));
		$cat_id=$_POST['pbl_listing_cat_id'];
		$pkg_id=$_POST['pbl_listing_pkg_id'];
		$time_listed=time();

		$durmonths=getPackageDuration($pkg_id);
		$time_expired=strtotime($durmonths);

		$wpdb->insert($wpdb->prefix.'pbl_listings',array('name'=>$name,'logo_url'=>$logo_url,'description'=>$description,'phone'=>$phone,'url'=>$url,'email'=>$email,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'cat_id'=>$cat_id,'pkg_id'=>$pkg_id,'time_listed'=>$time_listed,'time_expired'=>$time_expired,'active'=>1));
	}

	if($_POST['action']=="delete_listing"){
		$id=$_POST['pbl_listing_id'];
		$wpdb->query("DELETE FROM ".$wpdb->prefix."pbl_listings WHERE id=$id");
	}

	if($_POST['action']=="activate_listing"){
		$id=$_POST['pbl_listing_id'];
		$wpdb->update($wpdb->prefix.'pbl_listings',array('active'=>1),array('id'=>$id));
	}

?>

<div class="wrap">
<h2>Active Paid Business Listings</h2>

<h2>Create A New Listing</h2>
<p>NOTE: For listings that are added manually, payment is expected to have been obtained externally. In other words, this plugin doesn't send a bill or anything. You gotta get the money yourself.</p>
<form method="post"><input type="hidden" name="action" value="add_listing" />
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Company Name</th>
        <td><input type="text" name="pbl_listing_name" value="" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Logo URL</th>
        <td><input type="text" name="pbl_listing_logo_url" value="" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Business Description</th>
        <td><textarea name="pbl_listing_description" cols="50" rows="2"></textarea></td>
        </tr>

        <tr valign="top">
        <th scope="row">Business Phone</th>
        <td><input type="text" name="pbl_listing_phone" value="" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Website URL</th>
        <td><input type="text" name="pbl_listing_url" value="" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Business Email Address</th>
        <td><input type="text" name="pbl_listing_email" value="" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Street Address</th>
        <td><input type="text" name="pbl_listing_address" value="" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">City/State/Zip</th>
        <td>
        <input type="text" name="pbl_listing_city" value="" size="20" /> 



		<?php
		$state_province_field=get_option('pbl_state_province_field');
		
		if(($state_province_field=="TEXT")||($state_province_field=="")){
			echo "<input type='text' name='pbl_listing_state' value='$state' />";
		}else{
			echo "<select name='pbl_listing_state'>";
			echo "<option value=''>Select Your State/Province</option>";
			echo stateSelect($state_province_field,$state);
			echo "</select>";
		}
		?>

        <input type="text" name="pbl_listing_zip" value="" size="10" /> 
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Category</th>
        <td>
        <?php echo getCategoryList(); ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Package</th>
        <td>
        <?php echo getPackageList(); ?>
        </td>
        </tr>

    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="Create Listing" />
    </p>

</form>


<table class="pbladmin">
<tr class="headrow"><td>Company Name</td><td>Logo</td><td width="300">Listing Content</td><td>Category</td><td>Package</td><td>Listed</td><td>Expired</td><td>&nbsp;</td></tr>

<?php
global $wpdb;
$timenow=time();	
$listings=$wpdb->get_results("SELECT id,name,logo_url,description,phone,url,email,address,city,state,zip,cat_id,pkg_id,time_listed,time_expired FROM ".$wpdb->prefix."pbl_listings WHERE time_expired>$timenow AND active='1'");

foreach($listings as $listing){
	$id=$listing->id;
	$name=stripslashes($listing->name);
	$logo="<img src=\"".stripslashes($listing->logo_url)."\" width=\"100\" />";
	$description=stripslashes($listing->description);
	$phone=stripslashes($listing->phone);
	$url=stripslashes($listing->url);
	$email=stripslashes($listing->email);
	$address=stripslashes($listing->address);
	$city=stripslashes($listing->city);
	$state=stripslashes($listing->state);
	$zip=stripslashes($listing->zip);
	$cat_id=stripslashes(getCategoryName($listing->cat_id));
	$pkg_id=stripslashes(getPackageName($listing->pkg_id));
	$time_listed=date("M j, Y",$listing->time_listed);
	$time_expired=date("M j, Y",$listing->time_expired);
	
	echo "<tr class='datarow'><td>$name</td><td>$logo</td><td><strong>Description:</strong> $description<br /><strong>Phone:</strong> $phone<br /><strong>URL:</strong> $url<br /><strong>Email:</strong> $email<br /><strong>Address:</strong> $address, $city, $state $zip</td><td>$cat_id</td><td>$pkg_id</td><td>$time_listed</td><td>$time_expired</td><td align='center'>";
	echo "<form method='post' action='?page=pbl_settings_edit_listings'><input type='hidden' name='action' value='edit_listing' /><input type='hidden' name='pbl_listing_id' value='$id' /><input type='submit' class='button-secondary' value='Edit Listing' /></form>";
	echo "<form method='post'><input type='hidden' name='action' value='delete_listing' /><input type='hidden' name='pbl_listing_id' value='$id' /><input type='submit' class='button-secondary' value='Delete Listing' /></form>";
	echo "</td></tr>";
}

?>

</table>

<h2>Inactive Paid Business Listings</h2>

<table class="pbladmin">
<tr class="headrow"><td>Company Name</td><td>Logo</td><td width="300">Listing Content</td><td>Category</td><td>Package</td><td>Listed</td><td>Expired</td><td>&nbsp;</td></tr>

<?php
global $wpdb;
$listings=$wpdb->get_results("SELECT id,name,logo_url,description,phone,url,email,address,city,state,zip,cat_id,pkg_id,time_listed,time_expired FROM ".$wpdb->prefix."pbl_listings WHERE active='0'");

foreach($listings as $listing){
	$id=$listing->id;
	$name=stripslashes($listing->name);
	$logo="<img src=\"".stripslashes($listing->logo_url)."\" width=\"100\" />";
	$description=stripslashes($listing->description);
	$phone=stripslashes($listing->phone);
	$url=stripslashes($listing->url);
	$email=stripslashes($listing->email);
	$address=stripslashes($listing->address);
	$city=stripslashes($listing->city);
	$state=stripslashes($listing->state);
	$zip=stripslashes($listing->zip);
	$cat_id=stripslashes(getCategoryName($listing->cat_id));
	$pkg_id=stripslashes(getPackageName($listing->pkg_id));
	$time_listed=date("M j, Y",$listing->time_listed);
	$time_expired=date("M j, Y",$listing->time_expired);
	
	echo "<tr class='datarow'><td>$name</td><td>$logo</td><td><strong>Description:</strong> $description<br /><strong>Phone:</strong> $phone<br /><strong>URL:</strong> $url<br /><strong>Email:</strong> $email<br /><strong>Address:</strong> $address, $city, $state $zip</td><td>$cat_id</td><td>$pkg_id</td><td>$time_listed</td><td>$time_expired</td><td align='center'>";
	echo "<form method='post'><input type='hidden' name='action' value='activate_listing' /><input type='hidden' name='pbl_listing_id' value='$id' /><input type='submit' class='button-secondary' value='Activate Listing' /></form>";
	echo "<form method='post' action='?page=pbl_settings_edit_listings'><input type='hidden' name='action' value='edit_listing' /><input type='hidden' name='pbl_listing_id' value='$id' /><input type='submit' class='button-secondary' value='Edit Listing' /></form>";
	echo "<form method='post'><input type='hidden' name='action' value='delete_listing' /><input type='hidden' name='pbl_listing_id' value='$id' /><input type='submit' class='button-secondary' value='Delete Listing' /></form>";
	echo "</td></tr>";
}

?>

</table>
</div>
<?php }