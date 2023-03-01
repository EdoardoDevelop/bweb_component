<?php
/**
* ID: slider_block
* Name: Slider Block
* Description: Slider in Gutenberg
* Icon: dashicons-slides
 * Version: 1.0
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
		add_action( 'enqueue_block_editor_assets', array($this, 'bc_slide_gutenberg_block_assets' ));
	}


	function onInit() {
        wp_register_script( 'bc-slide', BSB_DIR.'dist/editor.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components','wp-server-side-render' ) );
		register_block_type('bc/slide', array(
			'api_version'     => 2,
			'editor_script' => 'bc-slide',
			'render_callback' => array($this,'render'),
			'attributes'  => array(
				'mode'=> array(
					'type' => 'string',
					'default' => 'horizontal'
				),
				'infiniteLoop' => array(
					'type' =>  'boolean',
					'default' =>  1
				),
				'auto' => array(
					'type' =>  'boolean',
					'default' =>  0
				),
				'autoHover' => array(
					'type' =>  'boolean',
					'default' =>  1
				),
				'pager' => array(
					'type' =>  'boolean',
					'default' =>  false
				),
				'valueH' => array(
					'type' =>  'string',
					'default' =>  '438px'
				),
			)
		));
		
	}
    public function bc_slide_gutenberg_block_front(){
        if(! is_admin()){
            wp_enqueue_style(
                'bcs-bxslider-css',
                BSB_ASSETS_DIR . 'css/jquery.bxslider.css',
                array( 'wp-edit-blocks' ),
                time()
            );
            
            wp_enqueue_script(
                'bcs-bxslider-js',
                BSB_ASSETS_DIR . 'js/jquery.bxslider.min.js',
                array( 'jquery' ),
                time()
            );
            
        }
    }
	public function bc_slide_gutenberg_block_assets(){
       
        wp_enqueue_style(
            'bcs-block-slide-css',
            BSB_ASSETS_DIR . 'css/style.css',
            array( 'wp-edit-blocks' ),
            time()
        );
    }
	function render( $attributes, $content ){
		wp_enqueue_script(
			'bcs-block-slide-js',
			BSB_ASSETS_DIR . 'js/script.js',
			array( 'bcs-bxslider-js' ),
			time()
		);
		wp_localize_script( 'bcs-block-slide-js', 'attributes', $attributes );
		return $content;
		
	} // Render
}
new BSBSlider();