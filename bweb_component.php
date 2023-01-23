<?php
/*
Plugin Name: Bweb Component
Plugin URI: https://github.com/EdoardoDevelop/bweb_component/
Description: Custom Post Type, Custom Fields, Contact Form, Custom Maintenance, Custom Theme, Custom page Login, Custom access role
Author: Edoardo Monti (Bweb)
Version: 1.0.1
Author URI: https://www.bwebagency.it/
*/
if (!defined("ABSPATH")) {
exit; // Exit if accessed directly
}

define('PLUGIN_FILE_URL', __FILE__);

require plugin_dir_path( __FILE__ ) ."inc/change_name_file_log.php";
require plugin_dir_path( __FILE__ ) ."inc/big_image_size_threshold.php";
require plugin_dir_path( __FILE__ ) ."inc/disabled_comment.php";
require plugin_dir_path( __FILE__ ) ."inc/get_component_data.php";
require plugin_dir_path( __FILE__ ) ."inc/settings.php";
require plugin_dir_path( __FILE__ ) ."inc/active_component.php";

if( ! class_exists( 'bc_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'inc/update.php' );
}
$updater = new bc_Updater( __FILE__ );
$updater->set_username( 'EdoardoDevelop' );
$updater->set_repository( 'bweb_component' );
$updater->authorize( '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' ); // Your auth code goes here for private repos

$updater->initialize();


