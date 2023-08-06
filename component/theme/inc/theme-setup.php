<?php
/*  Theme setup
/* ------------------------------------ */


if ( ! function_exists( 'bcTheme_setup' ) ) {
    function bcTheme_setup() {

        // Custom menu areas
		register_nav_menus( array(
            'header' => esc_html__( 'Header', 'bcTheme' )
        ) );

        add_theme_support( 'align-wide' );

        // Enable featured image
		add_theme_support( 'post-thumbnails' );

        add_theme_support( "title-tag" );
        /*  Remove P in description output
        /* ------------------------------------ */
        remove_filter('term_description','wpautop');

        add_post_type_support( 'page', 'excerpt' );
        add_theme_support( 'woocommerce' );
        
        function bcTheme_enable_more_buttons($buttons) {
            $buttons[] = 'hr';
            return $buttons;
        }
        add_filter("mce_buttons", "bcTheme_enable_more_buttons");
      
        // Thumbnail sizes
        add_image_size( 'image_thumb', 350, 350, true ); //(cropped)
        add_image_size( 'image_single', 1200, 675, true ); 	//(cropped)
        add_image_size( 'image_big', 1400, 928, true ); 	//(cropped)
        add_image_size( 'image_HD', 1920, 1080, true ); 	//(cropped)

        add_filter( 'image_size_names_choose', '_custom_sizes_for_gut' );
 
        function _custom_sizes_for_gut( $sizes ) {
            return array_merge( $sizes, array(
                'image_thumb' => __( 'Thumb' ),
                'image_single' => __( 'Single' ),
                'image_big' => __( 'Big' ),
                'image_HD' => __( 'HD' )
            ) );
        }

        /*  Register sidebars
        /* ------------------------------------ */
        if ( ! function_exists( 'bcTheme_sidebars' ) ) {

            function bcTheme_sidebars()	{
                
                register_sidebar(array( 
                    'name' => esc_html__( 'Primary', 'bcTheme' ),
                    'id' => 'sidebar',
                    'description' => esc_html__( 'Normal full width sidebar.', 'bcTheme' ), 
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h4 class="widget-title">',
                    'after_title' => '</h4>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'shop-sidebar', 'bcTheme' ),
                    'id' => 'shop-sidebar',
                    'description' => esc_html__( 'shop-sidebar.', 'bcTheme' ), 
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h4 class="widget-title">',
                    'after_title' => '</h4>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 1', 'bcTheme' ),
                    'id' => 'footer1',
                    'description' => esc_html__( 'Footer 1.', 'bcTheme' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 2', 'bcTheme' ),
                    'id' => 'footer2',
                    'description' => esc_html__( 'Footer 2.', 'bcTheme' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 3', 'bcTheme' ),
                    'id' => 'footer3',
                    'description' => esc_html__( 'Footer 3.', 'bcTheme' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                
            }

        }
        add_action( 'widgets_init', 'bcTheme_sidebars' );
    }

}

add_action( 'after_setup_theme', 'bcTheme_setup' );


if ( ! function_exists( 'bcTheme_enqueue' ) ) {

	function bcTheme_enqueue() {
        
        $bctheme_settings_option = get_option( 'bctheme_settings_option' );
        /** JS **/
        wp_enqueue_script( 'bcTheme-bootstrap', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/bootstrap.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( 'bcTheme-bootstrap-select', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js', array( 'jquery' ),'', true  );
        
        wp_enqueue_script( 'bcTheme-magnificpopup-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ),'', true );

        wp_enqueue_script( 'bcTheme-script', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/script.js', array( 'jquery' ),'', true );
        
        wp_enqueue_script( 'bcTheme-front-script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ),'', true );

        /** CSS **/
        wp_enqueue_style( 'bcTheme-bootstrap-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/bootstrap.min.css');
        wp_enqueue_style( 'bcTheme-magnificpopup-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/magnific-popup.css');
        
		wp_enqueue_style( 'bcTheme-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/style.css');
		wp_enqueue_style( 'bcTheme-front-style', get_template_directory_uri().'/assets/css/style.css');


    }
}
add_action( 'wp_enqueue_scripts', 'bcTheme_enqueue' );
