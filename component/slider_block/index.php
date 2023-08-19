<?php
/**
* ID: slider_block
* Name: Slider Block
* Description: Slider in Gutenberg
* Icon: dashicons-slides
 * Version: 1.2
* 
*/

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }


// Constant
define( 'BSB_PLUGIN_VERSION', 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.0.0' );
define( 'BSB_DIR', plugin_dir_url( __FILE__ ) );
define( 'BSB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );


// Block Directory
class BSBSlider{
	function __construct(){
		add_action( 'enqueue_block_assets', [$this, 'bc_slide_gutenberg_block_front'] );
		add_action( 'init', [$this, 'onInit'] );
		add_action( 'enqueue_block_editor_assets', [$this, 'bc_slide_gutenberg_block_assets' ]);
        add_filter( 'image_size_names_choose', [$this, '_custom_sizes_for_gut'] );
        add_action('after_setup_theme', [$this, 'check_registered_image_size']);
	}


	function onInit() {
        wp_register_script( 'bc-slide', BSB_DIR.'dist/editor.min.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ),'',true );
		register_block_type('bc/slide', array(
			'api_version'     => 2,
			'editor_script' => array('bc-slide')
		));
		
	}
    public function bc_slide_gutenberg_block_front(){
        if(! is_admin()){
            
            wp_enqueue_style(
                'bcs-bootstrap-carousel-css',
                BSB_ASSETS_DIR . 'carousel.css',
                array( 'wp-edit-blocks' ),
                time()
            );
            wp_enqueue_style(
                'bcs-front-css',
                BSB_ASSETS_DIR . 'front.css',
                array( 'wp-edit-blocks' ),
                time()
            );
            
            wp_enqueue_script(
                'bcs-bootstrap-carousel-js',
                BSB_ASSETS_DIR . 'carousel.js',
                array( 'jquery' ),
                time()
            );
            
        }
    }
	public function bc_slide_gutenberg_block_assets(){
        wp_enqueue_style(
            'bcs-bootstrap-carousel-css',
            BSB_ASSETS_DIR . 'carousel.css',
            array( 'wp-edit-blocks' ),
            time()
        );
        wp_enqueue_style(
            'bcs-block-slide-css',
            BSB_ASSETS_DIR . 'front.css',
            array( 'wp-edit-blocks' ),
            time()
        );
        wp_enqueue_script(
            'bcs-bootstrap-carousel-js',
            BSB_ASSETS_DIR . 'carousel.js',
            array( 'jquery' ),
            time(),
            true
        );
    }
    public function check_registered_image_size(){
        if ( !has_image_size( 'image_HD' ) ) {
            add_image_size( 'image_HD', 1920, 1080, true );
        }
    }
    public function _custom_sizes_for_gut($sizes){
        if ( !isset( $sizes[ 'image_HD' ] ) ) {
            return array_merge( $sizes, array(
                'image_HD' => __( 'HD' )
            ) );
        }
    }
    
}
new BSBSlider();