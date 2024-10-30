<?php

add_filter("manage_edit-project_columns", "fundit_project_columns");
/**
 * Custom columns for the project post type
 * @param array() $columns
 */
function fundit_project_columns($columns){
	return array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Project Title",
		"funding-progress" => "Progress",
		"funding-time" => "Time Remaining",
		"comments" => '<img src="'.get_bloginfo('url').'/wp-admin/images/comment-grey-bubble.png" alt="Comments" />',
		'date' => 'Date',
	);
}

add_filter("manage_edit-reward_columns", "fundit_reward_columns");
/**
 * Custom columns for the reward post type
 * @param array() $columns
 */
function fundit_reward_columns($columns){
	return array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Reward Title",
		'reward-project' => 'Project',
		'reward-contribution' => 'Min Contribution',
		'reward-available' => 'Available',
		"author" => "Author",
		'comments' => '<img src="'.get_bloginfo('url').'/wp-admin/images/comment-grey-bubble.png" alt="Comments" />',
		'date' => 'Date',
	);
}

add_filter("manage_edit-funder_columns", "fundit_funder_columns");
/**
 * Custom columns for the funder post type
 * @param array() $columns
 */
function fundit_funder_columns($columns){
	return array(
		"cb" => "<input type=\"checkbox\" />",
		"funder-name" => "Name",
		"funder-amount" => "Amount",
		"funder-reward" => "Reward",
		"funder-project" => "Project",
		"funder-email" => "Email",
		'funder-status' => 'Status',
	);
}

add_action("manage_posts_custom_column", "fundit_custom_columns");
/**
 * Custom column display
 * @param string $column The name of the column
 */
function fundit_custom_columns($column){
	global $post;
	
	switch($column){
		case 'funding-progress':
			$project = new Fundit_Model_Project($post);
			
			$currency = $project->get_currency_sign();
			$funders = $project->get_funders();
			
			// The portion of the project that's been funded
			$portion = $project->funded/max($project->target,1);
			
			?><img src="<?php print WP_PLUGIN_URL ?>/fundit/images/dialog/pie-timer.php?portion=<?php print $portion?>&size=10" width="10" /> <?php
			print $currency.(empty($project->funded) ? '0' : $project->funded ).' of '.$currency.$project->target.' ';
			?>
			<span style="color:#888">
				(<?php
					print $project->funder_count.' '.($project->funder_count == 1 ? 'funder' : 'funders');
					if($project->funder_count) print ', '.$project->funder_count.' already funded'?>)
			</span>
			<?php
			
			if($project->funded >= $project->target || empty($project->target)){
				?><br /><a href="<?php print admin_url('edit.php?post_type=project&page=fundit-collect-page&project_id='.$project->ID) ?>"><?php _e('Ready to Collect!', 'fundit') ?></a><?php
			}
			
			break;
			
		case 'funding-time':
			$project = new Fundit_Model_Project($post);
			
			$start_time = strtotime($post->post_date);
			$end_time = strtotime($project->end_date);
			
			if(empty($end_time)) print 'No End Date';
			else{
				$time_portion = min((time() - $start_time)/($end_time-$start_time),1); // percent of time that's passed
				?><img src="<?php print WP_PLUGIN_URL ?>/fundit/images/dialog/pie-timer.php?portion=<?php print round($time_portion,2) ?>&size=10" width="10" /> <?php
				if($end_time - time() < 0) print 'Project closed';
				else print fundit_timesince(time(),$end_time);
			}
			break;
		
		// Stuff for the rewards
		case 'reward-project':
			$reward = new Fundit_Model_Reward($post);
			$project = $reward->get_project();
			?><a href="<?php print admin_url('post.php?action=edit&post='.$project->ID) ?>"><?php print $project->post_title ?></a><?php
			break;
		case 'reward-contribution':
			$reward = new Fundit_Model_Reward($post);
			$project = $reward->get_project();
			
			if(empty($project->contribution)){
				print 'No minimum'; break;
			}
			print $project->get_currency_sign().$project->contribution;
			break;
		case 'reward-available':
			$reward = new Fundit_Model_Reward($post);
			$funders = count($reward->get_funders());
			if($reward->available == 0) {
				print 'Unlimited';
			}
			else{
				print ($reward->available - $funders).' of '.$reward->available;
			}
			print ' <span style="color:#888">('.$funders.' '.($funders == 1 ? 'funder' : 'funders').')</span>';
			break;
		
		// Stuff for the funders
		case 'funder-name':
			$funder = new Fundit_Model_Funder($post);
			?><strong><a href="mailto:<?php print $funder->email ?>"><?php print $funder->post_title ?></a></strong><?php
			break;
		case 'funder-reward':
			$funder = new Fundit_Model_Funder($post);
			$reward = $funder->get_reward();
			?><a href="<?php print admin_url('post.php?action=edit&post='.$reward->ID) ?>"><?php print $reward->post_title ?></a><?php
			break;
		case 'funder-project':
			$funder = new Fundit_Model_Funder($post);
			$project = $funder->get_project();
			?><a href="<?php print admin_url('post.php?action=edit&post='.$project->ID) ?>"><?php print $project->post_title ?></a><?php
			break;
		case 'funder-amount':
			$funder = new Fundit_Model_Funder($post);
			print $funder->get_currency_sign().$funder->amount;
			break;
		case 'funder-email':
			$funder = new Fundit_Model_Funder($post);
			?><a href="mailto:<?php print $funder->email ?>"><?php print $funder->email ?></a><?php
			break;
		case 'funder-status':
			$funder = new Fundit_Model_Funder($post);
			if($funder->fund_status == 'cancelled'){
				print 'Cancelled';
			}
			else{
				if($funder->post_status == 'draft') print '<strong>'.__('Awaiting Confirmation', 'fundit').'</strong>';
				elseif($funder->post_status == 'publish'){
					if($funder->fund_status == 'funded') print 'Funded';
					else print 'Approved';
				}
			}
			
			?> &nbsp; <a href="<?php print FUNDIT_PLUGIN_URL_ROOT.'/admin/refresh-funder.php?funder_id='.$funder->ID.'&return='.esc_attr(add_query_arg(null,null)) ?>">Refresh</a><?php
			
			if($_GET['funder_updated'] == $funder->ID){
				?><div id="updated" class="updated"><p>Funder "<?php print $funder->post_title ?>" status updated.</p></div><?php
			}
			
			break;
	}
}