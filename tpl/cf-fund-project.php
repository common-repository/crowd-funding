<?php

/**
 * This is the default template for rendering a funding page.
 *
 * The user chooses the amount they want to fund and the reward they'd like.
 */

?>

<?php get_header(); the_post(); ?>

<div id="primary">
	<div id="content" role="main">
		<h1 class="entry-title"><?php printf('Fund %s', get_the_title()) ?></h1>
		
		<p><?php _e('Thanks for funding this project! ') ?></p>
		
		<?php if(!empty($message)) : ?>
			<div id="form-error-message"><?php print $message ?></div>
		<?php endif; ?>
		
		<form id="funding-form" method="post" action="<?php print add_query_arg(array('step' => 2), get_post_permalink()) ?>">
			<h3><?php _e('Who Are You?', 'crowdfund'); ?></h3>
			<dl>
				<lh><label for="field-name"><?php _e('Your Name', 'crowdfund') ?></label></lh>
				<dt><input type="text" name="name" id="field-name" value="<?php esc_attr_e(@$_REQUEST['name']) ?>" /></dt>
				
				<lh><label for="field-email"><?php _e('Your Email', 'crowdfund') ?></label></lh>
				<dt><input type="text" name="email" id="field-email" value="<?php esc_attr_e(@$_REQUEST['email']) ?>" /></dt>
				
				<lh><label for="field-website"><?php _e('Website', 'crowdfund') ?></label></lh>
				<dt><input type="text" name="website" id="field-website" value="<?php esc_attr_e(@$_REQUEST['website']) ?>" /></dt>
			</dl>
			
			<h3><?php _e('Amount?', 'crowdfund'); ?></h3>
			<ul id="project-rewards-list">
				<li>
					<span><?php print $project_currency_sign ?></span>
					<input type="text" name="amount" id="field-amount" value="<?php esc_attr_e(@$_REQUEST['amount']) ?>" />
				</li>
			</ul>
			
			<h3><?php _e('Choose Your Reward', 'crowdfund'); ?></h3>
			<ul id="project-rewards-list">
				<?php foreach($rewards as $reward) : ?>
					<?php
						$reward_funding_amount = get_post_meta($reward->ID, 'funding_amount', true);
						$reward_available = get_post_meta($reward->ID, 'available', true);
						$funders = get_posts(array(
							'numberposts'     => -1,
							'post_type' => 'funder',
							'post_parent' => $reward->ID,
							'post_status' => 'publish'
						));
					?>
					
					<?php if(empty($reward_available) || count($funders) < $reward_available) : ?>
						<li>
							<label for="<?php print 'reward-'.$reward->ID ?>">
								<h5><input type="radio" name="chosen_reward" value="<?php print $reward->ID ?>" id="<?php print 'reward-'.$reward->ID ?>" <?php checked($reward->ID, @$_REQUEST['chosen_reward']) ?> /> <?php print $reward->post_title ?></h5>
								<div class="min-amount"><?php printf('Pledge %s%s or more', $project_currency_sign, money_format('%.2n', $reward_funding_amount));?></div>
							</label>
							<p><?php print $reward->post_content ?></p>
						</li>
					<?php endif; ?>
					
				<?php endforeach ?>
			</ul>
			
			<h3><?php _e('Comment', 'crowdfund'); ?></h3>
			<ul id="project-rewards-list">
				<li>
					<textarea name="message"><?php esc_attr_e(@$_REQUEST['message']) ?></textarea>
				</li>
			</ul>
			
			<div class="submit">
				<input type="submit" class="cf-button" value="<?php _e('Commit To Funding') ?>" />
				<div><a href="#" id="funding-information-toggle"><?php _e('How does this work?') ?></a></div>
			</div>
			
			<div id="funding-information">
				<?php include(dirname(__FILE__).'/info.php') ?>
			</div>
			
			<div class="payments">
				<!-- PayPal Logo -->
				<table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr>
				<tr><td align="center"><a href="#" onclick="javascript:window.open('https://www.paypal.com/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img  src="https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif" border="0" alt="Solution Graphics"></a>
				</td></tr></table><!-- PayPal Logo -->
			</div>
		</form>
		
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer() ?>