<?php

function pbl_edit_listing_page() {
global $wpdb;

	if($_POST['action']=="update_listing"){
		$id=$_POST['id'];
		$name=$_POST['pbl_listing_name'];
		$logo_url=$_POST['pbl_listing_logo_url'];
		$description=$_POST['pbl_listing_description'];
		$phone=$_POST['pbl_listing_phone'];
		$url=$_POST['pbl_listing_url'];
		$email=$_POST['pbl_listing_email'];
		$address=$_POST['pbl_listing_address'];
		$city=$_POST['pbl_listing_city'];
		$state=$_POST['pbl_listing_state'];
		$zip=$_POST['pbl_listing_zip'];
		$cat_id=$_POST['pbl_listing_cat_id'];
		$pkg_id=$_POST['pbl_listing_pkg_id'];
		$init_pkg_id=$_POST['initial_pkg_id'];
		
		if($pkg_id!=$init_pkg_id){
			$time_listed=$_POST['initial_time_listed'];
	
			$durmonths=getPackageDuration($pkg_id);
			$time_expired=strtotime(date("Y-m-d",strtotime($durmonths)));
		}else{
			$time_listed=$_POST['initial_time_listed'];
			$time_expired=$_POST['initial_time_expired'];
		}
		
		$wpdb->update($wpdb->prefix.'pbl_listings',array('name'=>$name,'logo_url'=>$logo_url,'description'=>$description,'phone'=>$phone,'url'=>$url,'email'=>$email,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'cat_id'=>$cat_id,'pkg_id'=>$pkg_id,'time_listed'=>$time_listed,'time_expired'=>$time_expired),array('id'=>$id));
	
	}


	if($_POST['action']=="delete_listing"){
		$id=$_POST['pbl_listing_id'];
		$wpdb->query("DELETE FROM ".$wpdb->prefix."pbl_listings WHERE id=$id");
	}

?>

<div class="wrap">
<h2>Paid Business Listing Editor</h2>

<?php
global $wpdb;
if($_POST['action']=="edit_listing"){
$id=$_POST['pbl_listing_id'];
$listing=$wpdb->get_row("SELECT name,logo_url,description,phone,url,email,address,city,state,zip,cat_id,pkg_id,time_listed,time_expired FROM ".$wpdb->prefix."pbl_listings WHERE id='$id'");

	$name=stripslashes($listing->name);
	$logo=stripslashes($listing->logo_url);
	$description=stripslashes($listing->description);
	$phone=stripslashes($listing->phone);
	$url=stripslashes($listing->url);
	$email=stripslashes($listing->email);
	$address=stripslashes($listing->address);
	$city=stripslashes($listing->city);
	$state=stripslashes($listing->state);
	$zip=stripslashes($listing->zip);
	$cat_id=$listing->cat_id;
	$pkg_id=$listing->pkg_id;
	$time_listed=$listing->time_listed;
	$time_expired=$listing->time_expired;
?>

<h3>Edit Current Listing</h3>
<p><a href="?page=pbl_settings_listings">Back to All Listings</a></p>
<form method="post"><input type="hidden" name="action" value="update_listing" /><input type="hidden" name="id" value="<?php echo $id; ?>" />
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Company Name</th>
        <td><input type="text" name="pbl_listing_name" value="<?php echo $name; ?>" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Logo URL</th>
        <td><input type="text" name="pbl_listing_logo_url" value="<?php echo $logo; ?>" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Business Description</th>
        <td><textarea name="pbl_listing_description" cols="50" rows="2"><?php echo $description; ?></textarea></td>
        </tr>

        <tr valign="top">
        <th scope="row">Business Phone</th>
        <td><input type="text" name="pbl_listing_phone" value="<?php echo $phone; ?>" size="56" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Website URL</th>
        <td><input type="text" name="pbl_listing_url" value="<?php echo $url; ?>" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Business Email Address</th>
        <td><input type="text" name="pbl_listing_email" value="<?php echo $email; ?>" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Street Address</th>
        <td><input type="text" name="pbl_listing_address" value="<?php echo $address; ?>" size="56" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">City/State/Zip</th>
        <td>
        <input type="text" name="pbl_listing_city" value="<?php echo $city; ?>" size="20" /> 

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

        <input type="text" name="pbl_listing_zip" value="<?php echo $zip; ?>" size="10" /> 
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Category</th>
        <td>
        <?php echo getCategoryList($cat_id); ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Package</th>
        <td>
        <input type="hidden" name="initial_pkg_id" value="<?php echo $pkg_id; ?>" />
        <?php echo getPackageList($pkg_id); ?>
        </td>
        </tr>
        <input type="hidden" name="initial_time_listed" value="<?php echo $time_listed; ?>" />
        <input type="hidden" name="initial_time_expired" value="<?php echo $time_expired; ?>" />

    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="Update Listing" />
    </p>

</form>
<?php }else{ ?>

<p>Listing Updated! <a href="?page=pbl_settings_listings">Click here to go back to All Listings</a></p>

<?php } ?>

</div>
<?php }
