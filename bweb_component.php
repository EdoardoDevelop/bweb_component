<?php
/*
Plugin Name: Bweb Component
Plugin URI: https://github.com/EdoardoDevelop/bweb_component/
Description: Plugin per Wordpress per lo sviluppo di siti web. Il plugin contiene componenti/moduli scaricabili e attivabili su necessità.
Author: Edoardo Monti (Bweb)
Version: 1.2.0
Author URI: https://www.bwebagency.it/
requires: 6.0.0
tested: 6.3
*/
if (!defined("ABSPATH")) {
exit; // Exit if accessed directly
}

define('PLUGIN_FILE_URL', __FILE__);
define('DIR_COMPONENT', WP_PLUGIN_DIR . '/bweb_component_functions/');
define('TOKEN_GTHUB', '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');


class BwebComponentRun {
	public function __construct() {	
		register_activation_hook( __FILE__, function(){
			update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		});

		register_deactivation_hook( __FILE__, function(){
			delete_option('bc_version');
		});
		add_action( 'upgrader_process_complete', function($upgrader_object, $options){
			update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		}, 10, 2 );

		$this->run();
		
		add_filter('admin_footer_text', array($this, 'change_footer_admin' ));

		add_filter( 'update_footer', array($this, 'change_footer_version' ), 9999 );
	}
	public function run(){
		require plugin_dir_path( __FILE__ ) ."inc/get_component_data.php";
		require plugin_dir_path( __FILE__ ) ."inc/settings.php";
		require plugin_dir_path( __FILE__ ) ."inc/active_component.php";

		if( ! class_exists( 'bc_Updater' ) ){
			include_once( plugin_dir_path( __FILE__ ) . 'inc/update.php' );
		}
		$updater = new bc_Updater( __FILE__ );
		$updater->set_username( 'EdoardoDevelop' );
		$updater->set_repository( 'bweb_component' );
		//$updater->authorize( TOKEN_GTHUB ); // Your auth code goes here for private repos
		$updater->initialize();
	}
	public function change_footer_admin () {
		echo 'Wordpress. <img style="height: 20px; vertical-align: top; " src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0NiIgaGVpZ2h0PSI0Ni4wMDkiIHZpZXdCb3g9IjAgMCA0NiA0Ni4wMDkiPg0KICA8cGF0aCBpZD0iTW9kdWxlLTU5NWI0MGI3NWJhMDM2ZWQxMTdkNjc5MyIgZD0iTTI1LDJhMS4wNTIsMS4wNTIsMCwwLDAtLjUuMTI1TDE3LjAzMSw2LjI4MSwyNSwxMC42MjVsOC00LjMxMkwyNS41LDIuMTI1QTEuMDUyLDEuMDUyLDAsMCwwLDI1LDJaTTE2LDh2Mi44NDRMNi41LDE2LjEyNUExLDEsMCwwLDAsNiwxN3Y4LjYyNUwyLjk2OSwyNy4zMTMsMTEsMzEuNjI1bDcuOTM4LTQuMzQ0TDExLjUsMjMuMTI1YTEuMDU1LDEuMDU1LDAsMCwwLTEsMEw4LDI0LjVWMTcuNTk0bDgtNC40Mzd2My4xODhhLjk4OS45ODksMCwwLDAsLjUuODc1TDI0LDIxLjM3NXYtOVptMTgsLjA2My04LDQuMzEzdjlsNy41LTQuMTU2YS45ODcuOTg3LDAsMCwwLC41LS44NzVWMTMuMTU2bDgsNC40Mzh2Ni45MzhsLTIuNS0xLjQwNmExLjA1NSwxLjA1NSwwLDAsMC0xLDBsLTcuNDY5LDQuMTU2TDM5LDMxLjYyNWw3LjkzOC00LjM0NEw0NCwyNS42MjVWMTdhLjk4Ny45ODcsMCwwLDAtLjUtLjg3NUwzNCwxMC44NDRaTTIwLDI4Ljk2OWwtOCw0LjQwNnY5bDEuMzEzLS43MTlMMjQuNSw0Ny44NzVhMSwxLDAsMCwwLDEsMGwxMS4xODgtNi4yMTlMMzgsNDIuMzc1di05TDMwLDI5djguMzQ0YS45ODguOTg4LDAsMCwwLC41Ljg3NUwzNC42MjUsNDAuNSwyNSw0NS44NDQsMTUuMzc1LDQwLjUsMTkuNSwzOC4yMTlhLjk4OS45ODksMCwwLDAsLjUtLjg3NVptMjgsMC04LDQuNDA2djlsNy41LTQuMTU2YS45ODguOTg4LDAsMCwwLC41LS44NzVaTTIsMjkuMDYzdjguMjgxYS45OS45OSwwLDAsMCwuNS44NzVMMTAsNDIuMzc1di05WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIgLTIpIiBmaWxsPSIjNDY0NjQ2Ii8+DQo8L3N2Zz4NCg==" > Bweb Component plugin';
	}
	public function change_footer_version() {
		global $wp_version;
		return 'Version WP '.$wp_version.' - B.C. '.get_plugin_data( __FILE__ )['Version'];
	}

	
}
New BwebComponentRun();

