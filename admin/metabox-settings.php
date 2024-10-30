<ul>
	<li>
		<label for="cf_target_currency">Currency</label>
		<select name="cf_target_currency" id="cf_target_currency" <?php disabled(!empty($funders)) ?>>
			<?php global $cf_currencies; foreach($cf_currencies as $key => $name) : ?>
				<option value=<?php print $key ?> <?php selected($settings['currency'], $key) ?>><?php print $name ?></option>
			<?php endforeach; ?>
		</select>
	</li>
	<li>
		<label for="cf_target_amount">Amount</label>
		<input type="text" name="cf_target_amount" id="cf_target_amount" class="widefat" value="<?php esc_attr_e($settings['target']) ?>" />
		<div class="description"><?php _e('The minimum amount you need.', 'crowdfunding') ?></div>
	</li>
	<li>
		<label for="cf_target_date">Date</label>
		<input type="text" name="cf_target_date" id="cf_target_date" class="widefat" value="<?php esc_attr_e($settings['date']) ?>" />
		<div class="description"><?php _e('Date that funding ends.', 'crowdfunding') ?></div>
	</li>
</ul>