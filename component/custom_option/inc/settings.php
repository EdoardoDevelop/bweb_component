<?php

class BcCustomOptionField {
	private $bc_custom_option_field;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bc_custom_option_field_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_custom_option_field_page_init' ) );
        global $pagenow;
        if($pagenow=='admin.php' && isset($_GET['page']) && $_GET['page']=='bc_custom_option_field'){
            add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue') );
            add_action('admin_footer', array($this, '_script'));
        }
	}

	public function bc_custom_option_field_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Custom Option Field', // page_title
			'Custom Option Field', // menu_title
			'manage_options', // capability
			'bc_custom_option_field', // menu_slug
			array( $this, 'bc_custom_option_field_create_admin_page' ) // function
		);
	}

	public function bc_custom_option_field_create_admin_page() {
		$this->bc_custom_option_field = get_option( 'bc_custom_option_field' ); 
        ?>


		<div class="wrap">
			<h2 class="wp-heading-inline">Custom Option Field</h2>
			<p></p>
			<?php settings_errors(); ?>
            
			<form method="post" action="options.php">
				<?php
					settings_fields( 'bc_custom_option_field_option_group' );
					do_settings_sections( 'bc-custom-option-field-admin' );
					submit_button();
				?>
                
			</form>
		</div>

	<?php }

	public function bc_custom_option_field_page_init() {
		register_setting(
			'bc_custom_option_field_option_group', // option_group
			'bc_custom_option_field', // option_name
			array( $this, 'bc_custom_option_field_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_custom_option_field_setting_section', // id
			'Settings', // title
			'', // callback
			'bc-custom-option-field-admin' // page
		);

		add_settings_field(
			'custom_option_field', // id
            $this->htmlth(), // title
			array( $this, '_callback' ), // callback
			'bc-custom-option-field-admin', // page
			'bc_custom_option_field_setting_section' // section
		);
	}
	public function htmlth(){
		
		$html ='<a class="add_field_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi</a><br><br>';
		/*$html .= '<div id="draggable" class="ui-widget-content">';
		$html .= '<p>Drag me to my target</p>';
		$html .= '</div>';*/
		return $html;
	}
	public function bc_custom_option_field_sanitize($input) {
		
        if ( isset( $input['custom_option_field'] ) ) {
			$input['custom_option_field'] =  $input['custom_option_field'];
        }
		
		return $input;
	}

	public function _callback() {
		require '_callback.php';
	}

    public function load_enqueue(){
        /*wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script( 'jquery-ui-sortable' );*/
		//wp_enqueue_script('jquery');
		add_thickbox();
		wp_enqueue_style( 'bc_jquery-ui-css', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css' );
		wp_enqueue_script( 'bc_jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' );
    }

    public function _script(){
        require '_script.php';
    }
	

}
if ( is_admin() ):
	$bc_custom_option_field = new BcCustomOptionField();
endif;