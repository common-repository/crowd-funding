<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php _e('Crowd Funding Settings', 'crowdfunding') ?></h2>
	
	<form action="" method="POST">
		<h3>Fundit Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="paypal-email"><?php _e('PayPal Email Address') ?></label></th>
					<td>
						<input type="text" name="email" id="paypal-email" class="regular-text" value="<?php print @$cf_paypal['email']; ?>" />
						<div class="description">
							<?php print __('The PayPal email address you want to be paid into.') ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3>PayPal API Credentials</h3>
		<div class="description"><?php printf(__('%s for help acquiring credentials.', 'crowdfunding'), '<a href="http://siteorigin.com/docs/crowd-funding/paypal-api-credentials/" target="_blank">'.__('Read This', 'crowdfunding').'</a>') ?></div>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="paypal-mode"><?php _e('Mode') ?></label></th>
					<td>
						<select name="mode">
							<option value="sandbox" <?php selected('sandbox', @$cf_paypal['mode']) ?>>Sandbox</option>
							<option value="production" <?php selected('production', @$cf_paypal['mode']) ?>>Production</option>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="paypal-app-id"><?php _e('PayPal Application ID') ?></label></th>
					<td>
						<input type="text" name="app_id" id="paypal-app-id" class="regular-text" value="<?php print @$cf_paypal['app_id']; ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="paypal-api-username"><?php _e('PayPal API Username') ?></label></th>
					<td>
						<input type="text" name="api_username" id="paypal-api-username" class="regular-text" value="<?php print @$cf_paypal['api_username']; ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="paypal-api-password"><?php _e('PayPal API Password') ?></label></th>
					<td>
						<input type="text" name="api_password" id="paypal-api-password" class="regular-text" value="<?php print @$cf_paypal['api_password']; ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="paypal-api-signature"><?php _e('PayPal API Signature') ?></label></th>
					<td>
						<input type="text" name="api_signature" id="paypal-api-signature" class="regular-text" value="<?php print @$cf_paypal['api_signature']; ?>" />
					</td>
				</tr>
				
			</tbody>
		</table>
		
		<p>
			<?php wp_nonce_field('crowdfunding_settings') ?>
			<input class="button-primary" type="submit" value="Save Changes" name="submit" />
		</p>
	</form>
</div>