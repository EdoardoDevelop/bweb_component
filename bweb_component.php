<?php
/*
Plugin Name: Bweb Component
Plugin URI: https://github.com/EdoardoDevelop/bweb_component/
Description: Plugin per Wordpress per lo sviluppo di siti web. Il plugin contiene componenti/moduli scaricabili e attivabili su necessità.
Author: Edoardo Monti (Bweb)
Version: 1.2.0
Author URI: https://www.bwebagency.it/
requires: 6.0.0
tested: 6.2.2
*/
if (!defined("ABSPATH")) {
exit; // Exit if accessed directly
}

define('PLUGIN_FILE_URL', __FILE__);
define('TOKEN_GTHUB', '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');


class BwebComponentRun {
	public function __construct() {	
		register_activation_hook( __FILE__, function(){
			update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		});

		register_deactivation_hook( __FILE__, function(){
			delete_option('bc_version');
		});
		add_action( 'upgrader_process_complete', array($this, 'after_update'), 10, 2 );

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
		echo 'Wordpress. Bweb Component plugin';
	}
	public function change_footer_version() {
		global $wp_version;
		return 'Version WP '.$wp_version.' - B.C. '.get_plugin_data( __FILE__ )['Version'];
	}

	public function after_update($upgrader_object, $options){
		update_option('bc_version',get_plugin_data( __FILE__ )['Version']);
		$bweb_component_settings_options = get_option( 'bweb_component_active' );
		if ( is_array( $bweb_component_settings_options ) ) {
            foreach ($bweb_component_settings_options as $component){
                
                if ( !file_exists( plugin_dir_path( PLUGIN_FILE_URL )."component" ) || !is_dir( plugin_dir_path( PLUGIN_FILE_URL )."component" ) ) {
                    mkdir(plugin_dir_path( PLUGIN_FILE_URL )."component");
                }
                
                $dir = plugin_dir_path( PLUGIN_FILE_URL )."component/".$component;
                
                $remotecomponents = array();
                $argsGit = array();
                $argsGit['headers']['Authorization'] = TOKEN_GTHUB; // Set the headers
                $responseGit = json_decode( wp_remote_retrieve_body( wp_remote_get( "https://api.github.com/repos/EdoardoDevelop/component/git/trees/master?recursive=1", $argsGit ) ), true );
                
                
                foreach($responseGit as $s){
                    if(is_array($s)){
                        foreach($s as $x){
                            $p = explode("/",$x['path']);
                            if(!empty($p[0]) && !empty($p[1])){
                                    $remotecomponents += array($p[0] => '');
                                    if(!empty($remotecomponents[$p[0]])){
                                        $remotecomponents[$p[0]] .= ',';
                                    }
                                    if(isset($p[0])){
                                        $remotecomponents[$p[0]] .= str_replace($p[0].'/','',$x['path']);
                                    }
                            }
                            
                        }
                    }
                }
                
                $cd = explode(",",$remotecomponents[$component]);
                
                
                foreach($cd as $path){
                    if ( !file_exists( $dir ) || !is_dir( $dir ) ) {
                        mkdir($dir);
                    }
                    if(pathinfo($path, PATHINFO_EXTENSION) == ''){
                        //cartella
                        if ( !file_exists( $dir.'/'.$path ) || !is_dir( $dir.'/'.$path) ) {
                            mkdir($dir.'/'.$path);
                        }
                    }else{
                        //file
                        $url = 'https://raw.githubusercontent.com/EdoardoDevelop/component/master/'.$component.'/'.$path;
                        
                        if (!file_put_contents($dir.'/'.$path, fopen($url, 'r'))){
                            break;
                        }
                        
                    }

                }
                
            }
        }

	}
}
New BwebComponentRun();

