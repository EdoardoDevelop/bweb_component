<?php
class bcmaintenance {
    private $bc_maintenance_page;
    private $bc_maintenance_active;

	public function __construct(){
		$this->bc_maintenance_page = get_option( 'bc_maintenance_page' ); 
		$this->bc_maintenance_active = get_option( 'bc_maintenance_active' ); 
		add_action( 'admin_menu', array( $this, 'bc_maintenance_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_maintenance_page_init' ) );
        add_filter( 'display_post_states', array($this, 'bc_display_post_states'), 10, 2 );
        add_filter ('page_template', array($this, 'bc_redirect_page_template'));
        register_activation_hook(PLUGIN_FILE_URL, array($this, 'active_plugin' ));
        register_deactivation_hook(PLUGIN_FILE_URL, array($this, 'deactive_plugin' ));
        if ( isset( $this->bc_maintenance_page ) ) {
            if(intval( $this->bc_maintenance_page ) > 0){
                update_post_meta( intval( $this->bc_maintenance_page ), '_wp_page_template', plugin_dir_path( __FILE__ ).'template/template.php' );
            }
        }
        
    }

	public function bc_maintenance_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Sito in manutenzione', // page_title
			'Sito in manutenzione', // menu_title
			'manage_options', // capability
			'bc-maintenance', // menu_slug
			array( $this, 'bc_maintenance_create_admin_page' ) // function
		);
	}

	public function bc_maintenance_create_admin_page() {
        ?>

		<div class="wrap">
			<h2>Sito in manutenzione</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'bc_maintenance_option_group' );
					do_settings_sections( 'bc_maintenance-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function bc_maintenance_page_init() {
		register_setting(
			'bc_maintenance_option_group', // option_group
			'bc_maintenance_active' // option_name
		);
		register_setting(
			'bc_maintenance_option_group', // option_group
			'bc_maintenance_page', // option_name
            array($this,'sanitize_maintenance')
		);

		add_settings_section(
			'bc_maintenance_active_section', // id
			'', // title
			'', // callback
			'bc_maintenance-admin' // page
		);
		add_settings_section(
			'bc_maintenance_page_section', // id
			'', // title
			'', // callback
			'bc_maintenance-admin' // page
		);

		

        add_settings_field(
            'active_maintenance', // id
            'Attiva sito in manutenzione', // title
            array($this,'chk_callback'), // callback
            'bc_maintenance-admin', // page
            'bc_maintenance_active_section' // section
        );
        add_settings_field(
            'select_page', // id
            'Pagina', // title
            array($this,'select_callback'), // callback
            'bc_maintenance-admin', // page
            'bc_maintenance_page_section' // section
        );

        
	}

    public function sanitize_maintenance($input){
        delete_post_meta( intval( $this->bc_maintenance_page ), '_wp_page_template');
        return $input;
    }

	public function select_callback(){
        wp_dropdown_pages( array(
            'name'              => 'bc_maintenance_page',
            'show_option_none'  => '&mdash; Seleziona &mdash;',
            'option_none_value' => '0',
            'selected'          => $this->bc_maintenance_page,
        ) );
	}
    public function chk_callback() {
		printf(
			'<input type="checkbox" name="bc_maintenance_active" id="bc_maintenance_active" value="true" %s>',
			( $this->bc_maintenance_active == 'true' ) ? 'checked' : ''
		);
	}

    public function bc_display_post_states( $states, $post ){
        if ( intval( $this->bc_maintenance_page ) === $post->ID ) {
            $states['bc_maintenance_page'] = __( 'Pagina sito in manutenzione' );
        }
    
        return $states;
    }
    public function bc_redirect_page_template ($template) {
        $post = get_post(); 
        $page_template = get_post_meta( $post->ID, '_wp_page_template', true ); 
        if ('template.php' == basename ($page_template ))
            $template = plugin_dir_path( __FILE__ ).'template/template.php';
        return $template;
    }

    public function active_plugin(){
        $newpostId = 0;
        $page = get_page_by_path( 'sito-in-manutenzione' , OBJECT );
        if ( !isset($page) ){
            $new_page = array(
                'post_title' => __( 'Sito in manutenzione' ),
                'post_name' => 'sito-in-manutenzione',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'page',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_content' => '
                <!-- wp:cover {"url":"https://s.w.org/images/core/5.8/forest.jpg","dimRatio":60,"minHeight":100,"minHeightUnit":"vh","align":"full"} -->
                <div class="wp-block-cover alignfull" style="min-height:100vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="https://s.w.org/images/core/5.8/forest.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","align":"wide","style":{"color":{"text":"#ffe074"},"typography":{"fontSize":"64px"}}} -->
                <h2 class="alignwide has-text-align-center has-text-color" style="color:#ffe074;font-size:64px">SITO IN MANUTENZIONE</h2>
                <!-- /wp:heading --></div></div>
                <!-- /wp:cover -->
                ',
                'menu_order' => 0,
                // Assign page template
                'page_template' => plugin_dir_path( __FILE__ ).'template/template.php'
            );
            
            // insert the post into the database
            $newpostId = wp_insert_post( $new_page );
        }else{
            $newpostId = $page->ID;
        }
        update_option('bc_maintenance_page',$newpostId);
    }
    public function deactive_plugin(){
        delete_post_meta( intval( $this->bc_maintenance_page ), '_wp_page_template');
        update_option('bc_maintenance_page',0);
    }


}
$bcmaintenance = new bcmaintenance();