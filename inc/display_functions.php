<?php
//Paid Business Listings Display Functions

function displayFormTable($instructions,$form_id,$err,$form_array){
	$return.="<p>$instructions</p>";
	$return.="<div id='$form_id'>";
	$return.="<form method='post'><table>";
	
	if(isset($err)){
		$return.="<tr><td class='err' colspan='2'>
			<p>The following errors were encountered:</p>
			<ul>$err</ul>
			<p>Please correct these errors and resumbit the form. Thank you.</p>
			</td></tr>";
	}
	
	
	foreach($form_array as $value){
		switch($value['type']){
		case hidden:
			$return.="<input type='hidden' name='".$value['name']."' value='".$value['value']."' />";	
		break;
		case text:
			$return.="<tr><td class='label'>".$value['label']."</td>";
			$return.="<td class='input'><input type='text' name='".$value['name']."' value='".$value['value']."' /></td></tr>";		
			(isset($value['note']))? $return.="<tr><td>&nbsp;</td><td class='formnote'>".$value['note']."</td></tr>" : null;
		break;
		case textarea:
			$return.="<tr><td class='label'>".$value['label']."</td>";
			$return.="<td class='input'><textarea name='".$value['name']."' >".$value['value']."</textarea></td></tr>";
			(isset($value['note']))? $return.="<tr><td>&nbsp;</td><td class='formnote'>".$value['note']."</td></tr>" : null;
		break;
		case select:
			$return.="<tr><td class='label'>".$value['label']."</td>";
			$return.="<td class='input'>";
			$return.="<select name='".$value['name']."'>";
			$return.="<option value=''>Select Your State/Province</option>";
			$return.=$value['options'];
			$return.="</select>";
			$return.="</td></tr>";
			(isset($value['note']))? $return.="<tr><td>&nbsp;</td><td class='formnote'>".$value['note']."</td></tr>" : null;
		break;
		case taxonomy:
			$return.="<tr><td class='label'>".$value['label']."</td>";
			$return.="<td class='input'>";
			$return.= ($value['taxonomy-type']=="category") ? getCategoryList($value['value']) : getPackageList($value['value']);
			$return.="</td></tr>";
		break;
		case submit:
			$return.="<tr><td>&nbsp;</td><td class='submit'><input type='submit' value='".$value['value']."' /></td></tr>";
		break;
		}
	}

	$return.="</table></form>";	
	$return.="<div style='clear:both;'></div></div>";
	
	return $return;
}

function displayPayPalForm($instruction,$package_id,$package_name,$package_cost,$submission_id,$url){
	$pbl_pp_button=get_option('pbl_buttimg');
	$pbl_ppemail=get_option('pbl_ppemail');
	$pbl_submit_button_text=get_option('pbl_butttext');
	$pbl_package_currency=get_option('pbl_ppcurrency');
	$pretty_permalinks=(strpos($url,"?") === false)? 1 : 0;

	$return.="<p>$instruction</p>";
	$return.="<div id='pbl-form-wrapper'>";
	$return.="<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
	$return.="<input type='hidden' name='cmd' value='_xclick'>";
	$return.="<input type='hidden' name='business' value='$pbl_ppemail'>";
	$return.="<input type='hidden' name='lc' value='US'>";
	$return.="<input type='hidden' name='item_number' value='$package_id'>";
	$return.="<input type='hidden' name='item_name' value='$package_name'>";
	$return.="<input type='hidden' name='amount' value='$package_cost'>";
	$return.="<input type='hidden' name='custom' value='$submission_id'>";
	$return.="<input type='hidden' name='currency_code' value='$pbl_package_currency'>";
	$return.="<input type='hidden' name='button_subtype' value='services'>";
	$return.="<input type='hidden' name='no_note' value='1'>";
	$return.="<input type='hidden' name='no_shipping' value='1'>";
	$return.="<input type='hidden' name='shipping' value='0.00'>";
	$return.="<input type='hidden' name='shipping2' value='0.00'>";
	$return.="<input type='hidden' name='rm' value='1'>";
	if($pretty_permalinks==1){
		$return.="<input type='hidden' name='return' value='$url?subid=$submission_id&sc=1'>";
		$return.="<input type='hidden' name='cancel_return' value='$url?subid=$submission_id&sc=0'>";
		$return.="<input type='hidden' name='notify_url' value='$url?ppn=1'>";
	}else{
		$return.="<input type='hidden' name='return' value='$url&subid=$submission_id&sc=1'>";
		$return.="<input type='hidden' name='cancel_return' value='$url&subid=$submission_id&sc=0'>";
		$return.="<input type='hidden' name='notify_url' value='$url&ppn=1'>";
	}
	$return.="<input type='hidden' name='bn' value='PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted'>";
	$return.="<input type='image' src='$pbl_pp_button' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>";
	$return.="<img alt='' border='0' src='https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/scr/pixel.gif' width='1' height='1'>";
	$return.="</form>";
	$return.="<div style='clear:both;'></div></div>";
	
	return $return;
}