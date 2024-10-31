<?php

function pbl_settings_page() {
?>
<div class="wrap">
<img src="<?php echo plugins_url()."/paid-business-listings/images/paid-business-listings.png"; ?>" />
<h2>General Settings</h2>

<h3>About Paid Business Listings</h3>
<p>This plugin provides site owners with new opportunities for monetizing their websites. For sites with good keyword search page ranking, you can bet that site owners who are trying to get ranked for those keywords are looking at your sites and would love to get a link back to their site.</p>
<p>Since you can display listings based on the category in which they are listed, the package they are paying for, or both, you can play around with creative ways of showing listings. Try creating a "featured" package and charge for high visibility placement on the category's page and show the featured listings at the top!</p>

<p>Before using this plugin, make sure the correct information is listed in the fields below and paste the following shortcodes into the appropriate pages as indicated below:</p>

<ul style="list-style-type:disc; margin-left: 30px;">
	<li>Paste this shortcode into the page you would like to use to display your listings: [pbl-listings]</li>
	<li>Paste this shortcode into the page you would like to use to display your submission form: [pbl-form]</li>
</ul>

<p><strong>We hope you enjoy using this plugin and if you have any questions, requests, or positive feedback, we would love to hear from you at <a href="http://www.blazingtorch.com/contact/" target="_blank">Blazing Torch, Inc.</a>. We are constantly making updates to this plugin and looking for opportunities to develop new applications, so please do not hesitate to contact us.</strong></p>

<div style="float:left; width:70%;">
<div class="postbox">
<form method="post" action="options.php">
    <?php settings_fields('pbl_options_group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Business/Organization Name</th>
        <td><input type="text" name="pbl_ppbizname" value="<?php echo get_option('pbl_ppbizname'); ?>" size="75" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">PayPal Email Address or ID</th>
        <td><input type="text" name="pbl_ppemail" value="<?php echo get_option('pbl_ppemail'); ?>" size="75" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal Checkout Button</th>
    <td>
        <table cellspacing="4">
        <?php
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_buynow_SM.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif");
        echo pp_image_option_radios("https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif");
        ?>
        </table>
	</td></tr>

        <tr valign="top">
        <th scope="row">PayPal Currency</th>
        <td>
		   <select name="pbl_ppcurrency">
		   	<option value="USD" <?php if(get_option('pbl_ppcurrency')=="USD"){echo "selected ";}else{echo "";} ?>>USD (U.S. Dollar)</option>
		   	<option value="AUD" <?php if(get_option('pbl_ppcurrency')=="AUD"){echo "selected ";}else{echo "";} ?>>AUD (Australian Dollar)</option>
		   	<option value="CAD" <?php if(get_option('pbl_ppcurrency')=="CAD"){echo "selected ";}else{echo "";} ?>>CAD (Canadian Dollar)</option>
		   	<option value="CZK" <?php if(get_option('pbl_ppcurrency')=="CZK"){echo "selected ";}else{echo "";} ?>>CZK (Czech Koruna)</option>
		   	<option value="DKK" <?php if(get_option('pbl_ppcurrency')=="DKK"){echo "selected ";}else{echo "";} ?>>DKK (Danish Krone)</option>
		   	<option value="EUR" <?php if(get_option('pbl_ppcurrency')=="EUR"){echo "selected ";}else{echo "";} ?>>EUR (Euro)</option>
		   	<option value="HKD" <?php if(get_option('pbl_ppcurrency')=="HKD"){echo "selected ";}else{echo "";} ?>>HKD (Hong Kong Dollar)</option>
		   	<option value="HUF" <?php if(get_option('pbl_ppcurrency')=="HUF"){echo "selected ";}else{echo "";} ?>>HUF (Hungarian Forint)</option>
		   	<option value="ILS" <?php if(get_option('pbl_ppcurrency')=="ILS"){echo "selected ";}else{echo "";} ?>>ILS (Israeli New Sheqel)</option>
		   	<option value="JPY" <?php if(get_option('pbl_ppcurrency')=="JPY"){echo "selected ";}else{echo "";} ?>>JPY (Japanese Yen)</option>
		   	<option value="MXN" <?php if(get_option('pbl_ppcurrency')=="MXN"){echo "selected ";}else{echo "";} ?>>MXN (Mexican Peso)</option>
		   	<option value="NOK" <?php if(get_option('pbl_ppcurrency')=="NOK"){echo "selected ";}else{echo "";} ?>>NOK (Norwegian Krone)</option>
		   	<option value="NZD" <?php if(get_option('pbl_ppcurrency')=="NZD"){echo "selected ";}else{echo "";} ?>>NZD (New Zealand Dollar)</option>
		   	<option value="PHP" <?php if(get_option('pbl_ppcurrency')=="PHP"){echo "selected ";}else{echo "";} ?>>PHP (Philippine Peso)</option>
		   	<option value="PLN" <?php if(get_option('pbl_ppcurrency')=="PLN"){echo "selected ";}else{echo "";} ?>>PLN (Polish Zloty)</option>
		   	<option value="GBP" <?php if(get_option('pbl_ppcurrency')=="GBP"){echo "selected ";}else{echo "";} ?>>GBP (Pound Sterling)</option>
		   	<option value="SGD" <?php if(get_option('pbl_ppcurrency')=="SGD"){echo "selected ";}else{echo "";} ?>>SGD (Singapore Dollar)</option>
		   	<option value="SEK" <?php if(get_option('pbl_ppcurrency')=="SEK"){echo "selected ";}else{echo "";} ?>>SEK (Swedish Krona)</option>
		   	<option value="CHF" <?php if(get_option('pbl_ppcurrency')=="CHF"){echo "selected ";}else{echo "";} ?>>CHF (Swiss Franc)</option>
		   	<option value="TWD" <?php if(get_option('pbl_ppcurrency')=="TWD"){echo "selected ";}else{echo "";} ?>>TWD (Taiwan New Dollar)</option>
		   	<option value="THB" <?php if(get_option('pbl_ppcurrency')=="THB"){echo "selected ";}else{echo "";} ?>>THB (Thai Baht)</option>
		   	<option value="TRY" <?php if(get_option('pbl_ppcurrency')=="TRY"){echo "selected ";}else{echo "";} ?>>TRY (Turkish Lira)</option>		   	
		   </select>
		   
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">State/Province Field</th>
        <td>
		   <select name="pbl_state_province_field">
		   	<option value="TEXT" <?php if(get_option('pbl_state_province_field')=="TEXT"){echo "selected ";}else{echo "";} ?>>Text Entry (No Pull-Down List) </option>
		   	<option value="US" <?php if(get_option('pbl_state_province_field')=="US"){echo "selected ";}else{echo "";} ?>>United States</option>
		   	<option value="AU" <?php if(get_option('pbl_state_province_field')=="AU"){echo "selected ";}else{echo "";} ?>>Australian States</option>
		   	<option value="CA" <?php if(get_option('pbl_state_province_field')=="CA"){echo "selected ";}else{echo "";} ?>>Canadian Provinces</option>
		   </select>
		   
        </td>
        </tr>

        <tr valign="top">

        <tr valign="top">
        <th scope="row">Step 1 Message</th>
        <td>
	        This message is displayed above the form that allows potential advertisers to select a package.<br />
	        <textarea  name="pbl_step_one_message" rows="3" cols="75"><?php echo get_option('pbl_step_one_message'); ?></textarea>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Listing Form Button Text</th>
        <td><input type="text" name="pbl_butttext" size="75" value="<?php echo get_option('pbl_butttext'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Step 2 Message</th>
        <td>
	        This message is displayed above the PayPal button that advertisers will click on to pay you after they have submitted their information.<br />
	        <textarea  name="pbl_step_two_message" rows="3" cols="75"><?php echo get_option('pbl_step_two_message'); ?></textarea>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Thank You Message</th>
        <td>
	        This message is displayed to advertisers who have successfully submitted and paid for a listing on your site.<br />
	        <textarea  name="pbl_thank_you_message" rows="3" cols="75"><?php echo get_option('pbl_thank_you_message'); ?></textarea>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Bail Message</th>
        <td>
	        This message is displayed when someone has filled out a form and cancelled the PayPal payment process before submitting payment.<br />
	        <textarea  name="pbl_bail_message" rows="3" cols="75"><?php echo get_option('pbl_bail_message'); ?></textarea>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Listings Primary Color</th>
        <td>
        Insert the hex code for the color that you would like to use as the primary color for the aspects of this plugin:<br />
        <input type="text" name="pbl_primary_hex_color" size="8" value="<?php echo get_option('pbl_primary_hex_color'); ?>" /> Current Primary Color: <span style="background-color: <?php echo get_option('pbl_primary_hex_color'); ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br /> (make sure the hex number begins with '#')
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Listings Secondary Color</th>
        <td>
        Insert the hex code for the color that you would like to use as the secondary color for the aspects of this plugin:<br />
        <input type="text" name="pbl_secondary_hex_color" size="8" value="<?php echo get_option('pbl_secondary_hex_color'); ?>" /> Current Secondary Color: <span style="background-color: <?php echo get_option('pbl_secondary_hex_color'); ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br /> (make sure the hex number begins with '#')
        </td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
<div style="clear:both"></div></div>
<div style="clear:both"></div></div>

<div class="rightcol">
<div class="postbox featured">
<h3 align="center">Upgrade to<br />Paid Business Listings +</h3>
	<p>Looking for more functionality or support? Purchase Paid Business Listings +, the paid premium version of Paid Business Listings with advanced features, such as:</p>
	<ul>
		<li>Add Custom Submission Form Fields</li>
		<li>Create Multiple Submission Forms</li>
		<li>Create Multiple Listing Templates</li>
		<li>Category Links Shortcode</li>
		<li>Future Premium Upgrades</li>
		<li>...and future improvements recommended by Paid Business Listings + users!</li>
	</ul>
	<p>For just a few bucks, you can enjoy these advanced features and start monetizing your site in new ways! Thank you!</p>
	<p><a href="http://www.blazingtorch.com/products/paid-business-listings-business-directory/" target="_blank">Click here for more info or to upgrade to Paid Business Listings +</a></p>
</div>
<div style="clear:both;"></div></div>


<?php }
