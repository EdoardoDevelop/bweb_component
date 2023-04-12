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
        if( isset( $bctheme_settings_option['include_scrollreveal'] ) && $bctheme_settings_option['include_scrollreveal'] === 'include_scrollreveal' ){
            wp_enqueue_script( 'bcTheme-scrollreveal-scripts', plugin_dir_url( PLUGIN_FILE_URL ) .'component/theme/assets/js/scrollreveal.min.js', array( 'jquery' ),'', true );
            if( isset( $bctheme_settings_option['item_scrollreveal'] ) && is_array($bctheme_settings_option['item_scrollreveal'])){
                $item_scrollreveal = $bctheme_settings_option['item_scrollreveal'];
                wp_register_script( 'scrollreveal-scripts', '', array("jquery"), '', true );
                wp_enqueue_script( 'scrollreveal-scripts'  );
                $script_scrollreveal = "";
                foreach($item_scrollreveal as $x => $value ){
                    $script_scrollreveal .= "ScrollReveal().reveal('".$value['class']."',{";
                    $script_scrollreveal .= "distance: '".$value['distance']."',";
                    $script_scrollreveal .= "duration: ".$value['duration'].",";
                    $script_scrollreveal .= "origin: '".$value['origin']."',";
                    $script_scrollreveal .= "easing: '".$value['easing']."',";
                    $script_scrollreveal .= "interval: ".$value['interval'];
                    $script_scrollreveal .= "});" . PHP_EOL;
                }
                wp_add_inline_script( 'scrollreveal-scripts',$script_scrollreveal);
            }
        }
        wp_enqueue_script( 'bcTheme-magnificpopup-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ),'', true );

        wp_enqueue_script( 'bcTheme-script', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/script.js', array( 'jquery' ),'', true );
        
        if( isset( $bctheme_settings_option['include_swup'] ) && $bctheme_settings_option['include_swup'] === 'include_swup' ){
            wp_enqueue_script( 'swup-dist-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/swup-all.js', array( 'jquery' ),'', true );
            /*wp_enqueue_script( 'swup-SwupGaPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupGaPlugin.min.js', array( 'jquery' ),'', true );
            wp_enqueue_script( 'swup-SwupScrollPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupScrollPlugin.min.js', array( 'jquery' ),'', true );
            wp_enqueue_script( 'swup-SwupBodyClassPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupBodyClassPlugin.min.js', array( 'jquery' ),'', true );
            wp_enqueue_script( 'swup-SwupHeadPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupHeadPlugin.min.js', array( 'jquery' ),'', true );*/

            if( isset( $bctheme_settings_option['script_swup'] )){
                wp_register_script( 'swup-scripts', '', array("jquery"), '', true );
                wp_enqueue_script( 'swup-scripts'  );
                wp_add_inline_script( 'swup-scripts', get_option( 'bctheme_settings_option' )['script_swup']);
            }
        }
        if( isset( $bctheme_settings_option['include_pagetransition'] ) && $bctheme_settings_option['include_pagetransition'] === 'include_pagetransition' ){
            wp_enqueue_script( 'pagetransition-dist-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/animsition.min.js', array( 'jquery' ),'', false );

        }
        wp_enqueue_script( 'bcTheme-front-script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ),'', true );


        /** CSS **/
        wp_enqueue_style( 'bcTheme-bootstrap-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/bootstrap.min.css');
        wp_enqueue_style( 'bcTheme-magnificpopup-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/magnific-popup.css');
        if( isset( $bctheme_settings_option['include_pagetransition'] ) && $bctheme_settings_option['include_pagetransition'] === 'include_pagetransition' ){
            wp_enqueue_style( 'pagetransition-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/animsition.min.css');
                
        }
		wp_enqueue_style( 'bcTheme-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/style.css');
		wp_enqueue_style( 'bcTheme-front-style', get_template_directory_uri().'/assets/css/style.css');

        if( isset( $bctheme_settings_option['include_swup'] ) && $bctheme_settings_option['include_swup'] === 'include_swup' ){
            //wp_enqueue_style( 'swup-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/swup-style.css');
            if( isset( $bctheme_settings_option['css_swup'] )){
                add_action('wp_head', function(){
                    ?>
                        <style>
                            <?php echo get_option( 'bctheme_settings_option' )['css_swup'];?>
                        </style>
                    <?php
                });
            }
        }


    }
}
add_action( 'wp_enqueue_scripts', 'bcTheme_enqueue' );

$bctheme_settings_option = get_option( 'bctheme_settings_option' );
if( isset( $bctheme_settings_option['include_pagetransition'] ) && $bctheme_settings_option['include_pagetransition'] === 'include_pagetransition' ){
    add_filter( 'body_class', 'pagetransition_body_class_names', 100 );
    add_action( 'wp_head', 'pagetransition_head_scripts',100 );
    add_action( 'wp_footer', 'pagetransition_footer_scripts',100 );

    function pagetransition_body_class_names( $classes ) {
		$classes[] = 'animsition';
		return $classes;
	}

    function pagetransition_head_styles() {
        
        $bctheme_settings_option = get_option( 'bctheme_settings_option' );
		?>
		<style type="text/css">
		<?php if ( empty( $bctheme_settings_option['page_in_transition'] ) ) { ?>
		.animsition{opacity: 1;}
		<?php } ?>
		
		</style>
		<?php
	}

    function pagetransition_head_scripts() {
        
        $bctheme_settings_option = get_option( 'bctheme_settings_option' );
        global $wp;
		if ( empty( $_SERVER['QUERY_STRING'] ) ){
			$current_url = trailingslashit( home_url( $wp->request ) );
        }else{
			$current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', trailingslashit( home_url( $wp->request ) ) );
        }
		$overlay = 'false';
        if (
            $bctheme_settings_option['page_in_transition'] == 'overlay-slide-in-top'
            ||
            $bctheme_settings_option['page_in_transition'] == 'overlay-slide-in-bottom'
            ||
            $bctheme_settings_option['page_in_transition'] == 'overlay-slide-in-left'
            ||
            $bctheme_settings_option['page_in_transition'] == 'overlay-slide-in-right'
            ){
                $overlay = 'true';
            }
        if (
            $bctheme_settings_option['page_out_transition'] == 'overlay-slide-out-top'
            ||
            $bctheme_settings_option['page_out_transition'] == 'overlay-slide-out-bottom'
            ||
            $bctheme_settings_option['page_out_transition'] == 'overlay-slide-out-left'
            ||
            $bctheme_settings_option['page_out_transition'] == 'overlay-slide-out-right'
            ){
                $overlay = 'true';
            }
            $loading = 'false';
            if( isset( $bctheme_settings_option['show_loading'] ) && $bctheme_settings_option['show_loading'] === 'true' ){
                $loading = 'true';
            }
		?>
		<script type="text/javascript">
            jQuery(function($){
                jQuery( document ).ready( function($) {
                    $('.animsition').animsition({
                        inClass : '<?php echo $bctheme_settings_option['page_in_transition']; ?>',
                        outClass : '<?php echo $bctheme_settings_option['page_out_transition']; ?>',
                        inDuration : <?php echo $bctheme_settings_option['page_in_duration']; ?>,
                        outDuration : <?php echo $bctheme_settings_option['page_out_duration']; ?>,
                        loading : <?php echo $loading; ?>,
                        loadingInner: '<img src="<?php echo plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/loading.svg' ?>" />', // e.g '<img src="loading.svg" />'
                        touchSupport: false,
                        overlay : <?php echo $overlay; ?>,
                        overlayClass : 'animsition-overlay-slide',
                        linkElement: '.animsition-link, a[href]:not([target="_blank"])a[href]:not([href=""]):not([href^="<?php echo $current_url;?>#"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([class="no-animation"])'
                    });
                });
            })
		</script>
		<?php
	}
    function pagetransition_footer_scripts() {
		?>
		<script type="text/javascript">
		jQuery( 'body' ).wrapInner( '<div class="animsition"></div>' ).removeClass( 'animsition' );
		</script>
		<?php
	}
}