<?php
function dwwp_load_templates( $original_template ) {

    if(wp_get_theme()->Name === 'btheme'):
        $current_queried_post_type = get_post_type( get_queried_object_id() );




        if ( is_archive() || is_search() ) {
            if( file_exists( get_stylesheet_directory().'/archive-job.php' ) ){
                return get_stylesheet_directory().'/archive-job.php';
            }else{
                return plugin_dir_path( PLUGIN_FILE_URL ).'component/theme/template/archive-job.php';
            }
        } elseif( is_singular('job') ) {
            if( file_exists( get_stylesheet_directory().'/single-job.php' ) ){
                return get_stylesheet_directory().'/single-job.php';
            }else{
                return plugin_dir_path( PLUGIN_FILE_URL ).'component/theme/template/single-job.php';
            }

        } else {
            return get_page_template();
        }


        return plugin_dir_path( PLUGIN_FILE_URL ) . 'component/theme/template/index.php';
    else:
        return $original_template;
    endif;

}
add_filter( 'template_include', 'dwwp_load_templates' );