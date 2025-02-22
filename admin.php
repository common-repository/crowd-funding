<?php

class CFAdmin_Controller extends Origin_Controller{
	public function __construct(){
		return parent::__construct(false, 'cfa');
	}
	
	static function single(){
		return parent::single(__CLASS__);
	}
	
	////////////////////////////////////////////////////////////
	// Action Functions
	////////////////////////////////////////////////////////////
	
	function action_admin_menu(){
		add_submenu_page(
			'options-general.php',
			__('Crowd Funding Settings', 'crowdfunding'),
			'Crowd Funding',
			'manage_options',
			'crowd-funding-settings',
			array(__CLASS__, 'page_settings')
		);
	}
	
	/**
	 * Enqueue admin scripts
	 */
	function action_admin_enqueue_scripts(){
		global $pagenow, $post;
		if(isset($post->post_type) && $post->post_type == 'project'){
			wp_enqueue_style('cf-admin', plugins_url('admin/css/admin.css', __FILE__));
		}
		
		if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && @ $post->post_type == 'project'){
			wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', array('jquery'));
			wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css');
			
			wp_enqueue_script('jquery.json', plugins_url('admin/js/jquery.json.min.js', __FILE__), array('jquery'));
			wp_enqueue_script('cf-project', plugins_url('admin/js/project.js', __FILE__), array('jquery'));
			
			$project_settings = get_post_meta($post->ID, 'settings', true);
			
			wp_localize_script('cf-project', 'crowdFunding', array(
				'site_url' => site_url(),
				'charge_nonce' => wp_create_nonce('charge_nonce'),
				'currency' => isset($project_settings['currency']) ? $project_settings['currency'] : 'USD',
			));
		}
	}
	
	/**
	 * Donate modal in the footer, for when the user successfully funds a project
	 */
	function action_admin_footer(){
		global $pagenow, $post;
		if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && @ $post->post_type == 'project'){
			include(dirname(__FILE__).'/admin/modal-donate.php');
		}
	}
	
	/**
	 * Display an admin message
	 */
	function action_admin_notices(){
		global $pagenow, $post;
		
		$message = get_transient('cf_admin_message');
		if($message === false){
			$message = file_get_contents('http://somessages.s3.amazonaws.com/crowd-funding/admin-message.html');
			set_transient('cf_admin_message', $message, 60);
		}
		$md5 = md5($message);
		
		global $current_user;
		get_currentuserinfo();
		$hidden = get_user_meta($current_user->ID, 'cf_admin_message_hide', $md5);
		
		if($hidden == $md5 || empty($message)) return;
		
		if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && @ $post->post_type == 'project'){
			?><div id="cf-admin-message" class="update-nag"><?php print $message ?> <a href="<?php print add_query_arg(array('cfa' => 'hide_admin_message'), site_url()) ?>" title="close" class="close">x</a></div><?php
		}
	}
	
	/**
	 * Delete the children when we delete a project or rewards
	 *
	 * @param int $post_id The post ID.
	 */
	function action_delete_post($post_id){
		$post = get_post($post_id);
		if($post->post_type == 'project'){
			$rewards = get_children(array(
				'post_parent' => $post->ID,
				'post_type' => 'reward',
			));
			if(empty($rewards)) return;
			foreach($rewards as $reward){
				wp_delete_post($reward->ID);
			}
		}
		elseif($post->post_type == 'reward'){
			$funders = get_children(array(
				'post_parent' => $post->ID,
				'post_type' => 'funder',
			));
			if(empty($funders)) return;
			foreach($funders as $funder){
				wp_delete_post($funder->ID);
			}
		}
	}
	
	/**
	 * Save the post
	 */
	function action_save_post($post_id){
		global $post;
		if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  return;
		if(empty($post) || $post->ID != $post_id) return;
		if($post->post_type != 'project') return;
		if(!current_user_can('edit_post', $post_id)) return;
		if(@$_REQUEST['action'] == 'trash') return;
		
		$rewards = json_decode(stripslashes($_POST['rewards']), true);
		$deleted = json_decode(stripslashes($_POST['rewards_deleted']), true);
		
		if(!empty($deleted)) { foreach($deleted as $to_delete){
			wp_delete_post($to_delete, false);
		}}
		
		if(!empty($rewards)) { foreach($rewards as $id => $reward){
			if(substr($id, 0, 4) == 'new-'){
				// Create a new reward
				$id = wp_insert_post(array(
					'post_title' => $reward['title'],
					'post_parent' => $post_id,
					'post_content' => $reward['description'],
					'post_type' => 'reward',
					'post_status' => 'publish',
					'comment_status' => 'open'
				));
				update_post_meta($id, 'available', intval($reward['available']), true);
				update_post_meta($id, 'funding_amount', intval($reward['amount']), true);
			}
			else{
				// Update an existing reward
				$post = get_post(intval($id));
				
				if($post->post_type != 'reward') continue;
				wp_update_post(array(
					'ID' => $post->ID,
					'post_title' => $reward['title'],
					'post_content' => $reward['description'],
				));
				update_post_meta($id, 'reward', array(
					'available' => $reward['available'],
					'amount' => $reward['amount']
				));
			}
		}}
		
		// Update the settings
		global $cf_currencies;
		$funders = CF_Controller::get_funders($post_id);
		$project_settings = get_post_meta($post_id, 'settings', true);
		$new = array(
			'date' => date('m/d/Y', strtotime($_REQUEST['cf_target_date'])),
			'target' => floatval($_REQUEST['cf_target_amount']),
		);
		if(empty($funders)) $new['currency'] = isset($cf_currencies[$_REQUEST['cf_target_currency']]) ? $_REQUEST['cf_target_currency'] : 'USD';
		else $new['currency'] = $project_settings['currency'];
		
		update_post_meta($post_id, 'settings', $new);
	}
	
	/**
	 * 
	 */
	function action_admin_init(){
		add_meta_box( 
			'project_rewards',
			__( 'Rewards', 'crowdfunding' ),
			array(__CLASS__, 'metabox_rewards'),
			'project'
		);
		
		add_meta_box(
			'project_settings',
			__( 'Project Settings', 'crowdfunding' ),
			array(__CLASS__, 'metabox_settings'),
			'project',
			'side'
		);
		
		add_meta_box(
			'project_funders',
			__( 'Funders', 'crowdfunding' ),
			array(__CLASS__, 'metabox_funders'),
			'project'
		);
	}
	
	////////////////////////////////////////////////////////////
	// Meta Boxes and Their Handlers
	////////////////////////////////////////////////////////////
	
	function metabox_rewards(){
		global $post;
		$project = $post;
		
		$rewards = get_children(array(
			'post_parent' => $project->ID,
			'post_type' => 'reward',
			
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_key' => 'funding_amount',
		));
		
		//
		$rewards_keyed = array();
		foreach($rewards as $reward){
			$funding_amount = get_post_meta($reward->ID, 'funding_amount', true);
			$available = get_post_meta($reward->ID, 'available', true);
			
			
			$rewards_keyed[$reward->ID] = array(
				'title' => $reward->post_title,
				'description' => $reward->post_content,
				'amount' => !empty($funding_amount) ? floatval($funding_amount) : 0,
				'available' => intval($available) == 0 ? __('Unlimited', 'crowdfunding') : intval($available)
			);
		}
		
		?><script><?php print 'var rewards = ' . (empty($rewards_keyed) ? '{}' : json_encode($rewards_keyed)).';'; ?></script><?php
		
		$project_settings = (array) get_post_meta($post->ID, 'settings', true);
		if(empty($project_settings['currency'])) $project_settings['currency'] = 'USD';
		global $cf_currency_signs;
		$project_currency_sign = $cf_currency_signs[$project_settings['currency']];
		
		include(dirname(__FILE__).'/admin/metabox-reward.php');
	}
	
	/**
	 * Targets for the project
	 */
	function metabox_settings(){
		global $post;
		
		$funders = CF_Controller::get_funders($post->ID);
		
		$settings = get_post_meta($post->ID, 'settings', true);
		$settings = array_merge(array(
			'currency' => 'USD',
			'date' => date('m/d/Y', time() + 86400*14),
			'target' => 1000,
		), (array) $settings);
		
		include(dirname(__FILE__).'/admin/metabox-settings.php');
	}
	
	function metabox_funders(){
		global $post;
		$project = $post;
		$funders = CF_Controller::get_funders($project->ID);
		
		$project_settings = (array) get_post_meta($post->ID, 'settings', true);
		global $cf_currency_signs;
		$project_currency_sign = !empty($project_settings['currency']) ? $cf_currency_signs[$project_settings['currency']] : '$';
		
		// Check if this project is ready for funding
		$ready = true;
		
		include(dirname(__FILE__).'/admin/metabox-funders.php');
	}
	
	/**
	 * render and process the settings page
	 */
	function page_settings(){
		global $cf_paypal;
		if(isset($_REQUEST['submit']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'crowdfunding_settings')){
			// The signature
			if(is_email($_REQUEST['email'])) $cf_paypal['email'] = $_REQUEST['email'];
			$cf_paypal['mode'] = $_REQUEST['mode'];
			$cf_paypal['app_id'] = $_REQUEST['app_id'];
			$cf_paypal['api_username'] = $_REQUEST['api_username'];
			$cf_paypal['api_password'] = $_REQUEST['api_password'];
			$cf_paypal['api_signature'] = $_REQUEST['api_signature'];
			
			update_option('crowdfunding_paypal', $cf_paypal);
			?><div id="updated" class="updated"><p><strong><?php _e('Settings saved.', 'fundit') ?></strong></p></div><?php
		}
		
		include(dirname(__FILE__).'/admin/page-settings.php');
	}
	
	////////////////////////////////////////////////////////////
	// Method handlers
	////////////////////////////////////////////////////////////
	
	/**
	 * Charge the user with the amount they comitted to fund.
	 */
	function method_charge_funder(){
		if(!current_user_can('edit_post', $_REQUEST['project_id'])) return false;
		if(!wp_verify_nonce($_REQUEST['_wpnonce'], 'charge_nonce')) return false;
		
		$project = get_post($_REQUEST['project_id']);
		if($project->post_type != 'project') return false;
		$project_settings = get_post_meta($project->ID, 'settings', true);
		
		$funder = get_post($_REQUEST['funder_id']);
		
		header('Content-Type: application/json', true);
		
		$paypal = new CF_PayPal();
		try{
			$paypal->charge_funder($funder);
			print json_encode(array(
				'status' => 'success',
				'amount' => get_post_meta($funder->ID, 'funding_amount', true),
			));
		}
		catch(Exception $e){
			print json_encode(array(
				'status' => 'fail',
				'message' => $e->getMessage(),
			));
		}
		
		
		
		return true;
	}
	
	/**
	 * Export funders to a CSV
	 */
	function method_export_funders(){
		if(!current_user_can('edit_post', $_REQUEST['project'])) return false;
		if(!wp_verify_nonce($_REQUEST['_wpnonce'], 'export_funders')) return false;
		
		$project = get_post($_REQUEST['project']);
		if($project->post_type != 'project') return false;
		$project_settings = get_post_meta($project->ID, 'settings', true);
		
		header("HTTP/1.0 200 OK", true, 200);
		header('Content-Type: text/csv', true);
		header('Content-Disposition: attachment; filename="funders.csv"', true);
		
		$csv = fopen('php://output', 'w');
		fputcsv($csv, array(
			'name',
			'email',
			'website',
			'project',
			'project_id',
			'reward',
			'reward_id',
			'currency',
			'funding_amount',
			'paypal_email',
			'preapproval_key',
			'charged',
		));
		
		$funders = CF_Controller::get_funders($project->ID);
		foreach($funders as $funder){
			$reward = get_post($funder->post_parent);
			$funder_info = get_post_meta($funder->ID, 'funder', true);
			
			$charged = get_post_meta($funder->ID, 'charged', true);
			
			fputcsv($csv, array(
				$funder_info['name'],
				$funder_info['email'],
				$funder_info['website'],
				$project->post_title,
				$project->ID,
				$reward->post_title,
				$reward->ID,
				$project_settings['currency'],
				get_post_meta($funder->ID, 'funding_amount', true),
				get_post_meta($funder->ID, 'paypal_email', true),
				get_post_meta($funder->ID, 'preapproval_key', true),
				!empty($charged) ? 'true' : 'false',
			));
		}
		
		return true;
	}
	
	function method_hide_admin_message(){
		global $current_user;
		get_currentuserinfo();
		
		if(empty($current_user)) return true;
		
		$message = get_transient('cf_admin_message');
		if($message === false){
			$message = file_get_contents('http://somessages.s3.amazonaws.com/crowd-funding/admin-message.html');
			set_transient('cf_admin_message', $message, 60);
		}
		$md5 = md5($message);
		
		update_user_meta($current_user->ID, 'cf_admin_message_hide', $md5);
		
		return true;
	}
}

CFAdmin_Controller::single();