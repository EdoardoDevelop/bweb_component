<?php
/**
* ID: swup    
* Name: Swup
* Description: Libreria di transizione di pagina avanzata
* Icon: data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 157.5 157.5' style='enable-background:new 0 0 157.5 157.5;' xml:space='preserve'%3E%3Cstyle type='text/css'%3E .st0%7Bfill:%232D2E82;%7D .st1%7Bfill:%23FE5B6A;%7D .st2%7Bfill:%2360DDCD;%7D%0A%3C/style%3E%3Ctitle%3Eswup-logo-icon%3C/title%3E%3Cpath class='st0' d='M21,0h115.5c11.6,0,21,9.4,21,21v115.5c0,11.6-9.4,21-21,21H21c-11.6,0-21-9.4-21-21V21C0,9.4,9.4,0,21,0z'/%3E%3Cg%3E%3Cpath class='st1' d='M73.2,97.7c0,10.8-9.2,19.7-20.3,19.7c-10.9,0-19.7-8.8-19.7-19.7c0-11.4,8.9-20.3,19.7-20.3 c11.2,0,20.3,9,20.3,20.2C73.2,97.7,73.2,97.7,73.2,97.7z'/%3E%3Cpath class='st2' d='M124.3,60.3c0,10.8-9.2,19.7-20.3,19.7c-10.9,0-19.7-8.9-19.7-19.7c0-11.4,8.9-20.3,19.7-20.3 c11.2,0,20.3,9,20.3,20.2C124.3,60.2,124.3,60.3,124.3,60.3z'/%3E%3C/g%3E%3C/svg%3E
* Version: 1.0
* 
*/


class bc_swupSettings {
	private $swup_settings_options;

	public function __construct() {
		$this->swup_settings_options = get_option( 'swup_settings_option' ); 
		add_action( 'admin_menu', array( $this, 'swup_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'swup_settings_page_init' ) );
		add_action('admin_enqueue_scripts', array( $this, '_enqueue_scripts' ));
		add_action('admin_footer-bweb-component_page_swup', array( $this, 'admin_js_theme' ));
        add_action( 'wp_enqueue_scripts', array( $this, 'load_swup') );
	}

	public function swup_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Swup', // page_title
			'Swup', // menu_title
			'manage_options', // capability
			'swup', // menu_slug
			array( $this, 'swup_settings_create_admin_page' ) // function
		);

	}

	public function swup_settings_create_admin_page() {
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">SWUP</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'swup_settings_option_group' );
				?>
					<?php
						do_settings_sections( 'swup-settings' );
						?>
					
					<?php
					submit_button();
				?>
				
			</form>
		</div>
	<?php }

	public function swup_settings_page_init() {
		register_setting(
			'swup_settings_option_group', // option_group
			'swup_settings_option', // option_name
			array( $this, 'swup_settings_sanitize' ) // sanitize_callback
		);

		
		add_settings_section(
			'swup_settings_section', // id
			'', // title
			'', // callback
			'swup-settings' // page
		);
		
		
		
		add_settings_field(
			'css_swup', // id
			'CSS Swup', // title
			array( $this, 'css_swup_callback' ), // callback
			'swup-settings', // page
			'swup_settings_section' // section
		);

		add_settings_field(
			'script_swup', // id
			'JS Swup', // title
			array( $this, 'script_swup_callback' ), // callback
			'swup-settings', // page
			'swup_settings_section' // section
		);

		
	}

	public function swup_settings_sanitize($input) {
		$sanitary_values = array();
        

		
		if ( isset( $input['css_swup'] ) ) {
			$sanitary_values['css_swup'] = $input['css_swup'];
		}
		if ( isset( $input['script_swup'] ) ) {
			$sanitary_values['script_swup'] = $input['script_swup'];
		}


		return $sanitary_values;
	}

	
	public function css_swup_callback() {
				
		printf(
			'<textarea name="swup_settings_option[css_swup]" id="css_swup">%s</textarea>',
			( isset( $this->swup_settings_options['css_swup'] )) ? esc_attr( $this->swup_settings_options['css_swup']) : ''
			
		);
	}
	public function script_swup_callback() {
		
		printf(
			'<textarea name="swup_settings_option[script_swup]" id="script_swup">%s</textarea>',
			( isset( $this->swup_settings_options['script_swup'] )) ? esc_attr( $this->swup_settings_options['script_swup']) : ''
			
		);
	}

	public function _enqueue_scripts($hook){
		

		if($hook == 'bweb-component_page_swup'){
			wp_enqueue_code_editor(array('type' => 'text/html'));
			
		
			wp_enqueue_script('wp-theme-plugin-editor');
			wp_enqueue_style('wp-codemirror');
			
		}
	}

	public function admin_js_theme($hook){
		?>
		<script>
			jQuery(document).ready(function($) {
				var editorSettingsJS = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettingsJS.codemirror = _.extend(
					{},
					editorSettingsJS.codemirror,
					{
						indentUnit: 2,
						tabSize: 2,
						mode: 'javascript',
					}
				);
				

				var editorSettingsCSS = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettingsCSS.codemirror = _.extend(
					{},
					editorSettingsCSS.codemirror,
					{
						indentUnit: 2,
						tabSize: 2,
						mode: 'css',
					}
				);
				
                wp.codeEditor.initialize( $('#script_swup'), editorSettingsJS );
                wp.codeEditor.initialize( $('#css_swup'), editorSettingsCSS );
				

				
			})
		</script>
		<?php
	}

	public function load_swup(){
        wp_enqueue_script( 'swup-dist-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/swup/assets/swup-all.js', array( 'jquery' ),'', true );
        /*wp_enqueue_script( 'swup-SwupGaPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupGaPlugin.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( 'swup-SwupScrollPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupScrollPlugin.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( 'swup-SwupBodyClassPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupBodyClassPlugin.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( 'swup-SwupHeadPlugin-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/SwupHeadPlugin.min.js', array( 'jquery' ),'', true );*/

        if( isset( $this->swup_settings_options['script_swup'] )){
            wp_register_script( 'swup-scripts', '', array("jquery"), '', true );
            wp_enqueue_script( 'swup-scripts'  );
            wp_add_inline_script( 'swup-scripts', $this->swup_settings_options['script_swup']);
        }
        if( isset( $this->swup_settings_options['css_swup'] )){
            add_action('wp_head', function(){
                ?>
                    <style>
                        <?php echo $this->swup_settings_options['css_swup'];?>
                    </style>
                <?php
            });
        }
    }

}
new bc_swupSettings();

