<?php

class BcFavicon {
	private $bc_favicon_options;

    public function __construct() {
		$this->bc_favicon_options = get_option( 'bc_favicon_options' ); 
        add_filter( 'wp_head' , array( $this, 'public_favicon' ));
    }
    public function init_admin() {
        add_action( 'admin_menu', array( $this, 'bcfavicon_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bcfavicon_settings_page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'bcfavicon_load_scripts_admin' ));
    }

	public function bcfavicon_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Favicon', // page_title
			'Favicon', // menu_title
			'manage_options', // capability
			'favicon', // menu_slug
			array( $this, 'bcfavicon_settings_create_admin_page' ) // function
		);

	}

    public function bcfavicon_settings_create_admin_page() {
		
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Generatore di favicon</h2>
			<p></p>
			<?php settings_errors(); ?>

			<div class="upload">
                
                <form method="post" action="options.php">
                    <?php
					settings_fields( 'bc_favicon_options_group' );
					do_settings_sections( 'bc_favicon-settings-admin' );
					submit_button();
				    ?>
                </form>
                
            </div>
		</div>
	<?php }


    public function bcfavicon_settings_page_init() {
        register_setting(
			'bc_favicon_options_group', // option_group
			'bc_favicon_options', // option_name
			array( $this, 'bc_favicon_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_favicon_settings_setting_section', // id
			'', // title
			function(){}, // callback
			'bc_favicon-settings-admin' // page
		);

		add_settings_field(
			'src_img_favicon', // id
			'<button type="submit" class="upload_image_button button">Seleziona immagine</button>', // title
			array( $this, 'src_img_favicon_callback' ), // callback
			'bc_favicon-settings-admin', // page
			'bc_favicon_settings_setting_section' // section
		);

    }

    public function bc_favicon_settings_sanitize($input){
        $sanitary_values = array();
        
        if ( isset( $input['id_img_favicon'] ) ) {
            if ( !empty( $input['id_img_favicon'] ) ){

                $source = get_attached_file($input['id_img_favicon']);
                $destination = wp_upload_dir()['basedir'] . '/favicon.ico';
                $sanitary_values['id_img_favicon'] = $input['id_img_favicon'] ;
                $sizes = array(
                    array( 16, 16 ),
                    array( 24, 24 ),
                    array( 32, 32 ),
                    array( 48, 48 ),
                );
                
                $ico_lib = new PHP_ICO( $source, $sizes );
                $ico_lib->save_ico( $destination );

            }
        }
        return $sanitary_values;
    }

    public function src_img_favicon_callback(){
        $default_image = plugins_url('assets/default_image.png', __FILE__);

        $src = $default_image;
        if(isset( $this->bc_favicon_options['id_img_favicon'] )){
            if ( !empty( $this->bc_favicon_options['id_img_favicon'] ) ) {
                $src = wp_get_attachment_url($this->bc_favicon_options['id_img_favicon']);
            }
        }
        
        ?>
            <img src="<?php echo $src; ?>" id="bc_favicon_img" style="width: 300px;">
            
        <?php
        
        printf(
			'<input type="hidden" name="bc_favicon_options[id_img_favicon]" id="bc_favicon_options" value="%s">',
            isset( $this->bc_favicon_options['id_img_favicon'] ) ? esc_attr( $this->bc_favicon_options['id_img_favicon']) : ''
		);
    }

    public function bcfavicon_load_scripts_admin(){
        wp_enqueue_media();
		wp_enqueue_script( 'bcfavicon_settings_js', plugin_dir_url( __FILE__ ).'assets/script.js');
    }

    public function public_favicon(){
		if ( file_exists(wp_upload_dir()['basedir'] . '/favicon.ico') ) {
			echo '<link rel="icon" type="image/x-icon" href="'.wp_upload_dir()['baseurl'] . '/favicon.ico'.'">';
		}
        
    }

}
$bc_favicon = new BcFavicon();
if ( is_admin() ):
    $bc_favicon->init_admin();
endif;