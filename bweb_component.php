<?php
/*
Plugin Name: Bweb Component
Plugin URI: https://github.com/EdoardoDevelop/bweb_component/
Description: Plugin per Wordpress per lo sviluppo di siti web. Il plugin contiene componenti/script attivabili su necessità.
Author: Edoardo Monti (Bweb)
Version: 1.0.6
Author URI: https://www.bwebagency.it/
*/
if (!defined("ABSPATH")) {
exit; // Exit if accessed directly
}

define('PLUGIN_FILE_URL', __FILE__);


class BwebComponentRun {
	public function __construct() {	
		register_activation_hook( __FILE__, function(){
			update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		});

		register_deactivation_hook( __FILE__, function(){
			delete_option('bc_version');
		});
		add_action( 'upgrader_process_complete', function( $upgrader_object, $options ) {
			update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		}, 10, 2 );
		$this->load_scripts();
		
		add_filter('admin_footer_text', array($this, 'change_footer_admin' ));

		add_filter( 'update_footer', array($this, 'change_footer_version' ), 9999 );
	}
	public function load_scripts(){
		require plugin_dir_path( __FILE__ ) ."inc/get_component_data.php";
		require plugin_dir_path( __FILE__ ) ."inc/settings.php";
		require plugin_dir_path( __FILE__ ) ."inc/active_component.php";

		if( ! class_exists( 'bc_Updater' ) ){
			include_once( plugin_dir_path( __FILE__ ) . 'inc/update.php' );
		}
		$updater = new bc_Updater( __FILE__ );
		$updater->set_username( 'EdoardoDevelop' );
		$updater->set_repository( 'bweb_component' );
		//$updater->authorize( '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' ); // Your auth code goes here for private repos
		$updater->initialize();
	}
	public function change_footer_admin () {
		echo 'Wordpress. Bweb Component plugin';
	}
	public function change_footer_version() {
		global $wp_version;
		return 'Version WP '.$wp_version.' - B.C. '.get_option('bc_version');
	}
}
New BwebComponentRun();







  

