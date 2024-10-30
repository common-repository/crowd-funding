<?php
/*
Plugin Name: Crowd Funding
Plugin URI: http://siteorigin.com/wordpress-crowd-funding/
Description: Gives you an all or nothing crowdfunding system that you can run from your blog.
Version: 0.5
Author: Greg Priday
Author URI: http://siteorigin.com/
*/

// Include the origin controller
require_once(dirname(__FILE__).'/lib/Controller.php');
require_once dirname(__FILE__).'/paypal.php';
require_once dirname(__FILE__).'/globals.php';
require_once dirname(__FILE__).'/admin.php';

function siteorigin_crowdfunding_activate(){
	CF_Controller::action_init();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'siteorigin_crowdfunding_activate');

/**
 * Front end controller
 */
class CF_Controller extends Origin_Controller{
	public function __construct(){
		return parent::__construct(false, 'cf');
	}
	
	static function single(){
		return parent::single(__CLASS__);
	}
	
	///////////////////////////////////////////////////////////////////
	// Action Functions
	///////////////////////////////////////////////////////////////////
	
	function action_init(){
		global $cf_paypal;
		if(empty($cf_paypal)){
			$cf_paypal = array(
				'mode' => 'sandbox',
				'app_id' => 'APP-80W284485P519543T',
				'api_username' => 'platfo_1255077030_biz_api1.gmail.com',
				'api_password' => '1255077037',
				'api_signature' => 'Abg0gYcQyxQvnf2HDJkKtA-p6pqhA1k-KTYE0Gcy1diujFio4io5Vqjf',
			);
			update_option('crowdfunding_paypal', $cf_paypal);
		}
		$cf_paypal = get_option('crowdfunding_paypal');
		
		define(
			'X_PAYPAL_API_BASE_ENDPOINT',
			$cf_paypal['mode'] == 'sandbox' ? 'https://svcs.sandbox.paypal.com/' : 'https://svcs.paypal.com/'
		);
		
		// This is dirty, but the Paypal API likes constants
		define('SOCF_API_USERNAME', $cf_paypal['api_username']);
		define('SOCF_API_PASSWORD', $cf_paypal['api_password']);
		define('SOCF_API_SIGNATURE', $cf_paypal['api_signature']);
		
		define('SOCF_APPLICATION_ID', $cf_paypal['app_id']);
		
		// Some more PayPal settings
		define('X_PAYPAL_ADAPTIVE_SDK_VERSION','PHP_SOAP_SDK_V1.4_MODIFIED');
		define('X_PAYPAL_REQUEST_DATA_FORMAT','SOAP11');
		define('X_PAYPAL_RESPONSE_DATA_FORMAT','SOAP11');
		
		// Create project custom post type
		register_post_type('project',array(
			'label' => __('Projects'),
			'labels' => array(
				'name' => __('Projects'),
				'singular_name' => __('Project'),
				'add_new' => _x('Create Project', 'fundit project'),
				'edit_item' => _x('Edit Project', 'fundit project'),
				'add_new_item' => _x('Add New Project', 'fundit project'),
				'edit_item' => _x('Edit Project', 'fundit project'),
				'new_item' => _x('New Project', 'fundit project'),
				'view_item' => _x('View Project', 'fundit project'),
				'search_items' => _x('Search Projects', 'fundit project'),
				'not_found' => _x('No Projects Found', 'fundit project'),
			),
			'description' => __('A fundable project.'),
			'public' => true,
			'_builtin' =>  false,
			'supports' => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
			),
			'rewrite' => true,
			'query_var' => 'project',
			'menu_icon' =>  plugins_url('admin/images/project.png', __FILE__),
		));
		register_taxonomy_for_object_type('tag', 'project');
		
		// Create reward custom post type
		register_post_type('reward',array(
			'label' => __('Reward'),
			'description' => __('A reward for funding a project.'),
			'public' => false,
		));
		
		// Create funder custom post type
		register_post_type('funder',array(
			'label' => __('Funder'),
			'description' => __('A reward for funding a project.'),
			'public' => false,
		));
	}
	
	/**
	 * Render the project page.
	 */
	function action_template_redirect(){
		global $post;
		if(is_single() && $post->post_type == 'project'){
			$step = isset($_GET['step']) ? intval($_GET['step']) : 0;
			
			$project_settings = (array) get_post_meta($post->ID, 'settings', true);
			
			$project_expired = strtotime($project_settings['date']) < time();
			global $cf_currency_signs;
			$project_currency_sign = $cf_currency_signs[$project_settings['currency']];
			
			$rewards = get_children(array(
				'post_parent' => $post->ID,
				'post_type' => 'reward',
				
				'order' => 'ASC',
				'orderby' => 'meta_value_num',
				'meta_key' => 'funding_amount',
			));
			
			if(!empty($rewards)){
				$keys = array_keys($rewards);
				$lowest_reward = $keys[0];
				$funding_minimum = get_post_meta($lowest_reward, 'funding_amount', true);
			}
			
			// Get all funders
			$funders = array();
			$funded_amount = 0;
			$chosen_reward = null;
			
			foreach($rewards as $reward){
				$these_funders = get_children(array(
					'post_parent' => $reward->ID,
					'post_type' => 'funder',
					'post_status' => 'publish'
				));
				foreach($these_funders as $this_funder){
					$funding_amount = get_post_meta($this_funder->ID, 'funding_amount', true);
					$funders[] = $this_funder;
					$funded_amount += $funding_amount;
				}
			}
			
			// The chosen reward
			$reward = null;
			if(isset($_REQUEST['chosen_reward'])){
				$reward = get_post(intval($_REQUEST['chosen_reward']));
				$reward_funding_amount = get_post_meta($reward->ID, 'funding_amount', true);
				$reward_available = get_post_meta($reward->ID, 'available', true);
			}
			
			if($project_expired && $step > 0) {
				header('Location: '.get_permalink($post->ID), true, 301);
				exit();
			}
			
			if($step == 2){
				
				$funders = get_posts(array(
					'numberposts'     => -1,
					'post_type' => 'funder',
					'post_parent' => $reward->ID,
					'post_status' => 'publish'
				));
				
				$valid = false;
				$step = 1;
				
				if(empty($reward)){
					$message = __('Please choose a valid reward.', 'crowdfund');
				}
				elseif(empty($_REQUEST['amount'])){
					$message = __('Please choose an amount.', 'crowdfund');
				}
				elseif(empty($reward)){
					$message = __('Please choose a valid reward.', 'crowdfund');
				}
				elseif(floatval($_REQUEST['amount']) < $reward_funding_amount){
					$message = __('You need to fund more for this reward.', 'crowdfund');
					$_REQUEST['amount'] = $reward_funding_amount;
				}
				elseif(!empty($reward_available) && count($funders) >= $reward_available){
					$message = __('The reward you chose is no longer available.', 'crowdfund');
				}
				else{
					$valid = true;
					$step = 2;
					
					// Create funder post
					$funding_id = wp_insert_post(array(
						'post_parent' => $reward->ID,
						'post_type' => 'funder',
						'post_status' => 'draft',
						
						'post_content' => $_REQUEST['message'],
					));
					
					add_post_meta($funding_id, 'funder', array(
						'name' => $_REQUEST['name'],
						'email' => $_REQUEST['email'],
						'website' => $_REQUEST['website'],
					), true);
					add_post_meta($funding_id, 'funding_amount', floatval($_REQUEST['amount']), true);
					
					// Redirect to PayPal
					$paypal = new CF_PayPal();
					$funding = get_post($funding_id);
					
					// Redirect
					$url = $paypal->get_auth_url($post, $reward, $funding);
					header('Location : '.$url, true, 303);
					exit();
				}
			}
			
			$templates = array(
				0 => 'cf-project.php',
				1 => 'cf-fund-project.php',
				2 => 'cf-user-details.php',
			);
			
			$template = $templates[$step];
			$file = locate_template($template);
			if(empty($file)) $file = dirname(__FILE__).'/tpl/'.$template;
			
			// Include the CSS and Javascript
			if(file_exists(STYLESHEETPATH.'/cf/cf.css')) wp_enqueue_style('crowdfunding', get_stylesheet_directory_uri().'/cf/cf.css');
			elseif(file_exists(TEMPLATEPATH.'/cf/cf.css')) wp_enqueue_style('crowdfunding', get_template_directory_uri().'/cf/cf.css');
			else wp_enqueue_style('crowdfunding', plugins_url('tpl/cf.css', __FILE__));
			
			if(file_exists(STYLESHEETPATH.'/cf/cf.js')) wp_enqueue_script('crowdfunding', get_stylesheet_directory_uri().'/cf/cf.js', array('jquery'));
			elseif(file_exists(TEMPLATEPATH.'/cf/cf.js')) wp_enqueue_script('crowdfunding', get_template_directory_uri().'/cf/cf.js', array('jquery'));
			else wp_enqueue_script('crowdfunding', plugins_url('tpl/cf.js', __FILE__), array('jquery'));
			
			include($file);
			do_action('wp_shutdown');
			exit();
		}
	}
	
	/**
	 * Handle IPN from PayPal
	 */
	function method_paypal_ipn(){
		$this->method_funded();
	}
	
	/**
	 * Handle a user returning from PayPal
	 */
	function method_funded($funder_id = null){
		if(empty($funder_id)) $funder_id = intval($_REQUEST['funder_id']);
		
		$paypal = new CF_PayPal();
		$funder = get_post($funder_id);
		
		// Check authentication and update the funder status
		$auth = $paypal->check_auth($funder);
		
		$reward = get_post($funder->post_parent);
		$project = get_post($reward->post_parent);
		$project_settings = (array) get_post_meta($project->ID, 'settings', true);
		
		$notified = get_post_meta($funder->ID, 'notified', true);
		
		global $cf_currency_signs;
		$project_currency_sign = $cf_currency_signs[$project_settings['currency']];
		
		if($auth && empty($notified)){
			// Email the  and the author
			$author = get_userdata($project->post_author);
			
			$rewards = get_children(array(
				'post_parent' => $project->ID,
				'post_type' => 'reward',
				
				'order' => 'ASC',
				'orderby' => 'meta_value_num',
				'meta_key' => 'funding_amount',
			));
			
			$funders = array();
			$funded_amount = 0;
			$chosen_reward = null;
			
			foreach($rewards as $this_reward){
				$these_funders = get_children(array(
					'post_parent' => $this_reward->ID,
					'post_type' => 'funder',
					'post_status' => 'publish'
				));
				foreach($these_funders as $this_funder){
					$funding_amount = get_post_meta($this_funder->ID, 'funding_amount', true);
					$funders[] = $this_funder;
					$funded_amount += $funding_amount;
				}
			}
			
			$site = get_current_site();
			$funder_details = get_post_meta($funder->ID, 'funder', true);
			$funding_amount = get_post_meta($funder->ID, 'funding_amount', true);
			$preapproval_key = get_post_meta($funder->ID, 'preapproval_key',true);
			
			// Send an email to the post author
			$to_author = file_get_contents(dirname(__FILE__).'/emails/funded_to_author.txt');
			$to_author = wordwrap(sprintf(
				$to_author,
				$author->user_nicename,
				ucfirst($funder_details['name']),
				$project->post_title,
				$project_currency_sign.$funded_amount,
				round($funded_amount/$project_settings['target']*100),
				$project_currency_sign.$project_settings['target'],
				self::timesince(time(), strtotime($project_settings['date']), 2, ' and '),
				$funder->ID,
				$funder_details['name'],
				$funder_details['email'],
				$project_currency_sign.$funding_amount,
				$preapproval_key,
				$reward->post_title,
				$funder->post_content
			), 75);
			@wp_mail(
				$author->user_email,
				sprintf(__('New Funder For %s'), $project->post_title),
				$to_author,
				'From: "'.$site->site_name.'" <funding@'.$site->domain.'>'."\r\n"
			);
			
			// Send an email to the funder
			$funder_paypal_email = get_post_meta($funder->ID, 'paypal_email', true);
			$to_funder = file_get_contents(dirname(__FILE__).'/emails/funded_to_funder.txt');
			$to_funder = wordwrap(sprintf(
				$to_funder,
				$funder_details['name'],
				$project->post_title,
				round($funded_amount/$project_settings['target']*100),
				$project_currency_sign.$project_settings['target'],
				self::timesince(time(), strtotime($project_settings['date']), 2, ' and '),
				$funder->ID,
				$funder_details['name'],
				$funder_details['email'],
				$funding_amount,
				$preapproval_key,
				$reward->post_title,
				$funder->post_content,
				get_permalink($project->ID),
				get_bloginfo('name'),
				site_url()
			),75);
			@wp_mail(
				$funder_paypal_email,
				sprintf(__('Thanks For Funding %s'), $project->post_title),
				$to_funder,
				'From: "'.$site->site_name.'" <funding@'.$site->domain.'>'."\r\n"
			);
			
			update_post_meta($funder->ID, 'notified', true);
		}
		
		$url = add_query_arg('thanks', 1, get_post_permalink($project->ID));
		header("Location: ".$url, true, 303);
	}
	
	///////////////////////////////////////////////////////////////////
	// Support functions
	///////////////////////////////////////////////////////////////////
	
	/**
	* Returns a string representation of the time between $time and $time2
	* 
	* @param int $time A unix timestamp of the start time.
	* @param int $time2 A unix timestamp of the end time.
	* @param int $precision How many parts to include
	*/
	static function timesince($time, $time2 = null, $precision = 2, $separator = ' '){
		if(empty($time2)) $time2 = time();
		
		$seconds_in = array(
			'week' => 604800,
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1,
		);
		
		$time_diff = $time2 - $time;
		$diff = array();
		
		foreach($seconds_in as $key => $seconds){
			$diff[$key] = floor($time_diff/$seconds);
			$time_diff -= $diff[$key]*$seconds;
		}
		
		$return = array();
		foreach($diff as $key => $count){
			if($count > 0){
				$precision--;
				$return[] = $count.' '.$key.($count == 1 ? '' : 's');
			}
			
			if($precision == 0) break;
		}
		
		return trim(implode($separator,$return));
	}
	
	static function get_funders($project_id){
		$rewards = get_children(array(
			'post_parent' => $project_id,
			'post_type' => 'reward',
			
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_key' => 'funding_amount',
		));
		
		$funders = array();
		foreach($rewards as $this_reward){
			$these_funders = get_children(array(
				'post_parent' => $this_reward->ID,
				'post_type' => 'funder',
				'post_status' => 'publish'
			));
			$funders = array_merge($funders, (array) $these_funders);
		}
		
		return $funders;
	}
}

CF_Controller::single();