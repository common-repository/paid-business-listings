<?php

function pbl_trans_log_page() {
global $wpdb;

	if($_POST['action']=="delete_trans"){
		$id=$_POST['trans_id'];
		$wpdb->query("DELETE FROM ".$wpdb->prefix."pbl_trans_log WHERE id=$id");
	}

?>

<div class="wrap">
<h2>Transaction Log</h2>

<table class="pbladmin">
<tr class="headrow"><td>ID</td><td>Listing ID</td><td>Package ID</td><td>Type</td><td>Payment Status</td><td>Payment Amount</td><td>Trans ID</td><td>Payment Date</td><td>Payment Email</td><td>&nbsp;</td></tr>

<?php
global $wpdb;
$transactions=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."pbl_trans_log");

foreach($transactions as $trans){
	$id=$trans->id;
	$listing_id=$trans->listing_id;
	$package_id=$trans->package_id;
	$trans_type=$trans->trans_type;
	$payment_status=$trans->payment_status;
	$payment_amount=$trans->payment_amount;
	$trans_id=$trans->trans_id;
	$timestamp=date("M j, Y",$trans->timestamp);
	$email=$trans->email;
	
	echo "<tr class='datarow'><td>$id</td><td>$listing_id</td><td>$package_id</td><td>$trans_type</td><td>$payment_status</td><td>$payment_amount</td><td>$trans_id</td><td>$timestamp</td><td>$email</td><td align='center'>";
	echo "<form method='post'><input type='hidden' name='action' value='delete_trans' /><input type='hidden' name='trans_id' value='$id' /><input type='submit' class='button-secondary' value='Delete Transaction' /></form>";
	echo "</td></tr>";
}

?>

</table>


</div>
<?php }
