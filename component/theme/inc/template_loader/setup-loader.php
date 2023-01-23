<?php

if( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require PLUGIN_THEME_DIR . 'inc/template_loader/class-gamajo-template-loader.php';
}

class BC_Template_Loader extends Gamajo_Template_Loader {

	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'bct';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'bct-templates';

	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = PLUGIN_THEME_DIR;

}



function get_c_template($templ, $data  = array()) {
 
    $templates = new BC_Template_Loader;

    if($templ === 'menu'){
        $data += ['depth' => 2];
        $data += ['fallback_cb' => 'bs4navwalker::fallback'];
        $data += ['walker' => new bs4navwalker()];
    }
    
    $templates->set_template_data( $data )->get_template_part( $templ );
   
}
