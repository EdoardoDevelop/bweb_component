<?php

class BcCustomFieldOptions {
	private $bc_custom_field_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bc_custom_field_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_custom_field_page_init' ) );
        global $pagenow;
        if($pagenow=='admin.php' && isset($_GET['page']) && $_GET['page']=='bc_custom_field'){
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
		wp_enqueue_script( 'settings_cf-vanillaSelectBox_js', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_field/assets/vanillaSelectBox.js' );

		wp_enqueue_style( 'settings_cf-vanillaSelectBox_css', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_field/assets/vanillaSelectBox.css');
		wp_enqueue_style( 'settings_cf-css', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_field/assets/style.css');
    }
    public function custombox_callback_script(){
        require 'settings_cf_callback_script.php';
    }

	public function generate_all_posts() {
        $post_type_object = get_post_types( array( 'public' => true, ), 'objects' );
		$sel = [];
		foreach ( $post_type_object as $post_type_obj ):
			$labels = get_post_type_labels( $post_type_obj );
			array_push($sel,$post_type_obj->label);
			$posts = get_posts(array('post_type'=> $post_type_obj->name, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
			foreach ($posts as $post) {
				array_push($sel,$post->ID);
			}
		endforeach;
		return $sel;
    }

}
if ( is_admin() ):
	$bc_custom_field = new BcCustomFieldOptions();
endif;