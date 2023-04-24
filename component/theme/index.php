<?php
/**
* ID: theme    
* Name: Tema
* Description:
* Icon: dashicons-admin-appearance
 * Version: 1.3
* 
*/

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }
define( 'PLUGIN_THEME_DIR', plugin_dir_path( __FILE__ ) );
if(isset(get_option( 'bctheme_settings_option' )['nome'])){
$bctheme_settings_name = get_option( 'bctheme_settings_option' )['nome'];
if(wp_get_theme()->Name === $bctheme_settings_name):
    if ( !is_admin() ):
        require plugin_dir_path( __FILE__ ) ."inc/bootstrap_navwalker.php";
    endif;
    require plugin_dir_path( __FILE__ ) ."inc/theme-setup.php";
    //require plugin_dir_path( __FILE__ ) ."inc/template_loader/setup-loader.php";
    require plugin_dir_path( __FILE__ ) ."inc/template-tags.php";
    //require plugin_dir_path( __FILE__ ) ."inc/template_include/setup.php";
endif;
}
require plugin_dir_path( __FILE__ ) ."inc/settings.php";
