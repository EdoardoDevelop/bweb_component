<?php
/**
 * ID: light_theme_admin
 * Name: Light/Blue Admin
 * Description: 
 * Icon: dashicons-admin-customizer
 */

function b_admin_admin_color_scheme() {  
    //b_admin
    wp_admin_css_color( 'b_admin', __( 'b_admin' ),
    plugin_dir_url( __file__ ) . '/b_admin.css',
      array( '#ffffff', '#3b4b5d', '#48ad10' , '#3791d3'),
      array( 'base' => '#3791d3', 'focus' => '#fff', 'current' => '#fff' )
    );
}
add_action('admin_init', 'b_admin_admin_color_scheme');

add_filter( 'get_user_option_admin_color', 'update_user_option_admin_color', 5 );

function update_user_option_admin_color( $color_scheme ) {
    $color_scheme = 'b_admin';

    return $color_scheme;
}

add_action( 'admin_footer', 'margin_top_menu' );
function margin_top_menu() {
?>
    <script type="text/javascript">
        jQuery('#adminmenu').css('margin-top',jQuery('#wpadminbar').height()+30)
    </script>
<?php
}