<?php

class BcCustomPostTypeOptions {
	private $bc_custom_post_type_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bc_custom_post_type_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_custom_post_type_page_init' ) );
        global $pagenow;
        if($pagenow=='admin.php' && isset($_GET['page']) && $_GET['page']=='bc_custom_post_type'){
            add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue') );
            add_action('admin_footer', array($this, 'custombox_callback_script'));
        }
	}

	public function bc_custom_post_type_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Custom Post Type', // page_title
			'Custom Post Type', // menu_title
			'manage_options', // capability
			'bc_custom_post_type', // menu_slug
			array( $this, 'bc_custom_post_type_create_admin_page' ) // function
		);
	}

	public function bc_custom_post_type_create_admin_page() {
		$this->bc_custom_post_type_options = get_option( 'bc_settings_cpt' ); 
        ?>

		<div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: #000; opacity: 0.8; z-index: 99999;" id="pre_bg">
			<img src="<?php echo plugin_dir_url( PLUGIN_FILE_URL )."component/custom_post_type/assets/loading.gif"?>" style="width: 32px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, 50%);" />
		</div>

		<div class="wrap">
			<h2 class="wp-heading-inline">Custom Post Type</h2>
			<p></p>
			<?php settings_errors(); ?>
            
			<form method="post" action="options.php">
				<?php
					settings_fields( 'bc_custom_post_type_option_group' );
					do_settings_sections( 'bc-custom-post-type-admin' );
					submit_button();
				?>
                
			</form>
		</div>

	<?php }

	public function bc_custom_post_type_page_init() {
		register_setting(
			'bc_custom_post_type_option_group', // option_group
			'bc_settings_cpt', // option_name
			array( $this, 'bc_custom_post_type_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_custom_post_type_setting_section', // id
			'Settings', // title
			'', // callback
			'bc-custom-post-type-admin' // page
		);

		add_settings_field(
			'custom-post-type', // id
            $this->htmlth(), // title
			array( $this, 'settings_cpt_callback' ), // callback
			'bc-custom-post-type-admin', // page
			'bc_custom_post_type_setting_section' // section
		);
	}
	public function htmlth(){
		
		$html ='<a class="add_field_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi</a><br><br>';
		/*$html .= '<div id="draggable" class="ui-widget-content">';
		$html .= '<p>Drag me to my target</p>';
		$html .= '</div>';*/
		return $html;
	}
	public function bc_custom_post_type_sanitize($input) {
		
        if ( isset( $input['custom-post-type'] ) ) {
			$input['custom-post-type'] =  $input['custom-post-type'];
        }
		flush_rewrite_rules();
		return $input;
	}

	public function settings_cpt_callback() {
		require 'settings_cpt_callback.php';
	}

    public function load_enqueue(){
        /*wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script( 'jquery-ui-sortable' );*/
		//wp_enqueue_script('jquery');
		add_thickbox();
		wp_enqueue_style( 'bc_jquery-ui-css', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css' );
		wp_enqueue_script( 'bc_jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' );
		wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css', '', '6.2.0', 'all');
		wp_enqueue_style( 'settings_cpt-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_post_type/assets/style.css');
    }

    public function custombox_callback_script(){
        require 'settings_cpt_callback_script.php';
    }
	

}
if ( is_admin() ):
	$bc_custom_post_type = new BcCustomPostTypeOptions();
endif;