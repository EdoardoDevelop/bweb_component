<?php
add_action( 'wp_enqueue_scripts', '_print_scripts_styles' );
//delete_option('_print_scripts_styles');
function _print_scripts_styles() {

    $result = [];
    $result['scripts'] = [];
    $result['styles'] = [];

    // Print all loaded Scripts
    global $wp_scripts;
    foreach( $wp_scripts->queue as $script ) :
       $result['scripts'][] =  $wp_scripts->registered[$script]->src . ";";
    endforeach;

    // Print all loaded Styles (CSS)
    global $wp_styles;
    foreach( $wp_styles->queue as $style ) :
       $result['styles'][] =  $wp_styles->registered[$style]->src . ";";
    endforeach;
    update_option('_print_scripts_styles', $result);
    //return $result;
}