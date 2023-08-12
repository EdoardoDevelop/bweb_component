<?php


class BcFormsOptions {
	private $bc_forms_options;

    public function __construct() {
		$this->bc_forms_options = get_option( 'bc_settings_forms' ); 
		add_action( 'admin_menu', array( $this, 'bc_forms_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_forms_page_init' ) );


		add_action( 'init', array( $this, 'bc_forms_add_form_db' ) );
		


        global $pagenow;
        if($pagenow=='admin.php' && isset($_GET['page']) && $_GET['page']=='forms'){
            add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue') );
            add_action('admin_footer', array($this, 'forms_callback_script'));
        }
    }
    
    public function bc_forms_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Forms', // page_title
			'Forms', // menu_title
			'manage_options', // capability
			'forms', // menu_slug
			array( $this, 'bc_forms_create_admin_page' ) // function
		);
	}

    public function bc_forms_create_admin_page() {
        ?>
		<div class="wrap">
			<h2 class="wp-heading-inline">Forms</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'bc_forms_option_group' );
					do_settings_sections( 'bc-forms-admin' );
					submit_button();
				?>
                
			</form>
		</div>
        <?php
    }

    public function bc_forms_page_init() {
		register_setting(
			'bc_forms_option_group', // option_group
			'bc_settings_forms', // option_name
			array( $this, 'bc_forms_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_forms_setting_section', // id
			'', // title
			'', // callback
			'bc-forms-admin' // page
		);

		add_settings_field(
			'forms', // id
            '<a class="add_field_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi</a>', // title
			array( $this, 'settings_forms_callback' ), // callback
			'bc-forms-admin', // page
			'bc_forms_setting_section' // section
		);
        
	}

    public function bc_custom_post_type_sanitize($input) {
		
        if ( isset( $input['forms'] ) ) {
			$input['forms'] =  $input['forms'];
        }
        if ( isset( $input['log'] ) ) {
			$input['log'] =  $input['log'];
        }
        
		return $input;
	}

	public function settings_forms_callback() {
		require 'settings_forms_callback.php';
	}

    public function load_enqueue(){
        /*wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script( 'jquery-ui-sortable' );*/
		//wp_enqueue_script('jquery');
		wp_enqueue_style( 'bc_jquery-ui-css', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css' );
		wp_enqueue_script( 'bc_jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' );
    }

    public function forms_callback_script(){
        require 'settings_forms_callback_script.php';
    }


	public function bc_forms_add_form_db(){
		if(isset($this->bc_forms_options['forms'])):
			$option_forms = $this->bc_forms_options['forms'];
			if(isset($option_forms) && is_array($option_forms)) {
				//print_r($array_forms);
				foreach($option_forms as $narray => $v ){
					if(isset($v['db']['active']) && $v['db']['active'] == 'on'){


						$labels = array(
							'name'                  => 'Forms '.$v['name'],
							'singular_name'         => 'Forms '.$v['name'],
							'menu_name'             => 'Forms '.$v['name'],
							'name_admin_bar'        => 'Forms '.$v['name'],
							'not_found'             => '',
							/*'archives'              => __( 'Item Archives', 'easyParent' ),
							'attributes'            => __( 'Item Attributes', 'easyParent' ),
							'parent_item_colon'     => __( 'Parent Item:', 'easyParent' ),
							'all_items'             => __( 'All Items', 'easyParent' ),
							'add_new_item'          => __( 'Add New Item', 'easyParent' ),
							'add_new'               => __( 'Add New', 'easyParent' ),
							'new_item'              => __( 'New Item', 'easyParent' ),
							'edit_item'             => __( 'Edit Item', 'easyParent' ),
							'update_item'           => __( 'Update Item', 'easyParent' ),
							'view_item'             => __( 'View Item', 'easyParent' ),
							'view_items'            => __( 'View Items', 'easyParent' ),
							'search_items'          => __( 'Search Item', 'easyParent' ),
							'not_found_in_trash'    => __( 'Not found in Trash', 'easyParent' ),
							'featured_image'        => __( 'Featured Image', 'easyParent' ),
							'set_featured_image'    => __( 'Set featured image', 'easyParent' ),
							'remove_featured_image' => __( 'Remove featured image', 'easyParent' ),
							'use_featured_image'    => __( 'Use as featured image', 'easyParent' ),
							'insert_into_item'      => __( 'Insert into item', 'easyParent' ),
							'uploaded_to_this_item' => __( 'Uploaded to this item', 'easyParent' ),
							'items_list'            => __( 'Items list', 'easyParent' ),
							'items_list_navigation' => __( 'Items list navigation', 'easyParent' ),
							'filter_items_list'     => __( 'Filter items list', 'easyParent' ),*/
						);
						$args = array(
							'label'                 => 'Forms '.$v['name'],
							'description'           => '',
							'labels'                => $labels,
							'supports'              => array( 'title', 'editor' ),
							'hierarchical'          => false,
							'public'                => false,
							'show_ui'               => true,
							'show_in_menu'          => true,
							'menu_position'         => 5,
							'menu_icon'             => 'dashicons-forms',
							'show_in_admin_bar'     => true,
							'show_in_nav_menus'     => true,
							'can_export'            => false,
							'has_archive'           => false,
							'exclude_from_search'   => true,
							'publicly_queryable'    => true,
							'rewrite'               => false,
							'capability_type'       => 'page',
							'capabilities' => array(
								'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
							),
							'map_meta_cap' 			=> true, // Set to `false`, if users are not allowed to edit/delete existing posts
							'show_in_rest'          => false,
						);
						register_post_type( 'forms_'.sanitize_title($v['name']), $args );


					}
				}
			}
		endif;
	}

}
if ( is_admin() ):
	$BcFormsOptions = new BcFormsOptions();
endif;

