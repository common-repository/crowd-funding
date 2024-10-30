<?php

define('WP_USE_THEMES', false);
require(dirname(__FILE__).'/../../../../wp-blog-header.php');

$user_id = get_current_user_id();
$project = get_post($_GET['project']);

header('content-type: application/json');

if($project->post_type == 'project' && user_can_edit_post($user_id, $project->ID)){
	update_post_meta($project->ID, 'project_closed',true);
	// Return a response message
}