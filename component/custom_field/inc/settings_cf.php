<?php

class BcCustomFieldOptions {
	private $bc_custom_field_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bc_custom_field_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_custom_field_page_init' ) );
        global $pagenow;
        if($pagenow=='admin.php' && $_GET['page']=='bc_custom_field'){
            add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue') );
            add_action('admin_footer', array($this, 'custombox_callback_script'));
        }
	}

	public function bc_custom_field_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Custom Field', // page_title
			'Custom Field', // menu_title
			'manage_options', // capability
			'bc_custom_field', // menu_slug
			array( $this, 'bc_custom_field_create_admin_page' ) // function
		);
	}

	public function bc_custom_field_create_admin_page() {
		$this->bc_custom_field_options = get_option( 'bc_settings_cf' ); 
        
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Custom Field</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'bc_custom_field_option_group' );
					do_settings_sections( 'bc-custom-field-admin' );
					submit_button();
				?>
                
			</form>
		</div>

	<?php }

	public function bc_custom_field_page_init() {
		register_setting(
			'bc_custom_field_option_group', // option_group
			'bc_settings_cf', // option_name
			array( $this, 'bc_custom_field_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_custom_field_setting_section', // id
			'Settings', // title
			'', // callback
			'bc-custom-field-admin' // page
		);

		add_settings_field(
			'custom_field_group', // id
            '<a class="add_group_metabox_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi Gruppo</a>', // title
			array( $this, 'settings_cf_callback' ), // callback
			'bc-custom-field-admin', // page
			'bc_custom_field_setting_section' // section
		);
	}

	public function bc_custom_field_sanitize($input) {
		
        if ( isset( $input['custom_field_group'] ) ) {
			$input ['custom_field_group'] =  $input['custom_field_group'];
        }

		return $input;
	}


	public function settings_cf_callback() {
		require 'settings_cf_callback.php';
	}

    public function load_enqueue(){
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script( 'jquery-ui-sortable' );
		add_thickbox();
    }
    public function custombox_callback_script(){
        require 'settings_cf_callback_script.php';
    }

}
if ( is_admin() ):
	$bc_custom_field = new BcCustomFieldOptions();
endif;