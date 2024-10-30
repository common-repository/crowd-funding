<?php

/**
 * This is the default template for rendering a single project page
 */

?>

<?php get_header(); the_post(); global $post; ?>

<div id="primary">
	<div id="content" role="main">
		<?php if(!empty($_GET['thanks'])) : ?>
			<div class="cf-thanks">
				<p>
					<?php _e('Thanks for committing to fund our project. We appreciate your support.', 'crowdfunding') ?>	
					<?php printf(__("We'll contact you when we reach our target of %s%s.", 'crowdfunding'), $project_currency_sign, round($project_settings['target'])) ?>
					<?php _e('Please share this project with your friends and followers. We need your help to reach our target.', 'crowdfunding') ?>
				</p>
				
				<div class="cf-thanks-addthis">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php print get_permalink() ?>">
						<a class="addthis_button_preferred_1"></a>
						<a class="addthis_button_preferred_2"></a>
						<a class="addthis_button_preferred_3"></a>
						<a class="addthis_button_compact"></a>
						<a class="addthis_counter addthis_bubble_style"></a>
					</div>
					<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee61a4871100016"></script>
					<!-- AddThis Button END -->
				</div>
			</div>
		<?php endif; ?>
		
		<h1 class="entry-title"><?php the_title() ?></h1>
		
		<div id="project-sidebar">
			<ul id="project-details">
				<li>
					<?php if(!$project_expired) : ?>
						<h3><?php print CF_Controller::timesince(time(), strtotime($project_settings['date']), 2, ' and ') ?></h3>
						<small><?php _e('To reach our target') ?></small>
					<?php else : ?>
						<h3><?php _e('Project Closed', 'crowdfunding') ?></h3>
					<?php endif; ?>
				</li>
				
				<li>
					<h3><?php print count($funders) ?></h3> <small><?php _e('Funders') ?></small>
				</li>
				
				<li>
					<h3><?php print $project_currency_sign.round($funded_amount) ?></h3>
					<small><?php printf(__('%u%% of our %s%s target'), round($funded_amount/$project_settings['target']*100), $project_currency_sign, round($project_settings['target'])) ?></small>
				</li>
				
				<?php if(!$project_expired) : ?>
					<li>
						<h3><a href="<?php print add_query_arg('step', 1) ?>"><?php _e('Fund This Project') ?></a></h3>
						<small><?php printf(__("%s minimum", 'crowdfunding'),$project_currency_sign.$funding_minimum) ?></small>
					</li>
				<?php endif; ?>
			</ul>
			
			<h2><?php _e('Rewards') ?></h2>
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
					<li>
						<?php if(!$project_expired && (empty($reward_available) || count($funders) < $reward_available)) : ?>
							<?php $url = add_query_arg(array('step' => 1, 'chosen_reward' => $reward->ID, 'amount' => $reward_funding_amount)); ?>
							<a href="<?php print $url ?>"><h4><?php print $reward->post_title ?></h4></a>
							<a href="<?php print $url ?>"><div class="min-amount"><?php printf('Fund %s%s or more', $project_currency_sign, round($reward_funding_amount));?></div></a>
						<?php else : ?>
							<h4><?php print $reward->post_title ?></h4>
							<div class="min-amount"><?php printf('Fund %s%s or more', $project_currency_sign, round($reward_funding_amount));?></div>
						<?php endif; ?>
						
						<?php if(!empty($reward_available)) : ?>
							<div class="available"><?php printf(__('%d of %d available', 'crowdfunding'), $reward_available - count($funders), $reward_available) ?></div>
						<?php endif; ?>
						
						<p><?php print $reward->post_content ?></p>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		
		<div id="project-content">
			<?php the_content() ?>
		</div>
		<div style="clear:both"></div>
		
		<?php comments_template() ?>
		
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer() ?>