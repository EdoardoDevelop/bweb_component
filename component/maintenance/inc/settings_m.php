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
			'maintenance', // menu_slug
			array( $this, 'bc_maintenance_create_admin_page' ) // function
		);
	}

	public function bc_maintenance_create_admin_page() {
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Sito in manutenzione</h2>
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

    

}
$bcmaintenance = new bcmaintenance();