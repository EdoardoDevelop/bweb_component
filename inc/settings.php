<?php

class BwebComponentSettings {
	private $bweb_component_settings_options;

	public function __construct() {	}

    public function load_setting_page(){
		add_action( 'admin_menu', array( $this, 'bweb_component_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bweb_component_settings_page_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue' ) );
		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
            add_filter( 'block_categories_all', array($this, 'register_bwebcomponent_category' ));
        } else {
            add_filter( 'block_categories', array($this, 'register_bwebcomponent_category' ));
        }
    }

	public function bweb_component_settings_add_plugin_page() {
		add_menu_page(
			'Bweb Component', // page_title
			'Bweb Component', // menu_title
			'manage_options', // capability
			'bweb-component', // menu_slug
			array( $this, 'bweb_component_settings_create_admin_page' ), // function
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0NiIgaGVpZ2h0PSI0Ni4wMDkiIHZpZXdCb3g9IjAgMCA0NiA0Ni4wMDkiPg0KICA8cGF0aCBpZD0iTW9kdWxlLTU5NWI0MGI3NWJhMDM2ZWQxMTdkNjc5MyIgZD0iTTI1LDJhMS4wNTIsMS4wNTIsMCwwLDAtLjUuMTI1TDE3LjAzMSw2LjI4MSwyNSwxMC42MjVsOC00LjMxMkwyNS41LDIuMTI1QTEuMDUyLDEuMDUyLDAsMCwwLDI1LDJaTTE2LDh2Mi44NDRMNi41LDE2LjEyNUExLDEsMCwwLDAsNiwxN3Y4LjYyNUwyLjk2OSwyNy4zMTMsMTEsMzEuNjI1bDcuOTM4LTQuMzQ0TDExLjUsMjMuMTI1YTEuMDU1LDEuMDU1LDAsMCwwLTEsMEw4LDI0LjVWMTcuNTk0bDgtNC40Mzd2My4xODhhLjk4OS45ODksMCwwLDAsLjUuODc1TDI0LDIxLjM3NXYtOVptMTgsLjA2My04LDQuMzEzdjlsNy41LTQuMTU2YS45ODcuOTg3LDAsMCwwLC41LS44NzVWMTMuMTU2bDgsNC40Mzh2Ni45MzhsLTIuNS0xLjQwNmExLjA1NSwxLjA1NSwwLDAsMC0xLDBsLTcuNDY5LDQuMTU2TDM5LDMxLjYyNWw3LjkzOC00LjM0NEw0NCwyNS42MjVWMTdhLjk4Ny45ODcsMCwwLDAtLjUtLjg3NUwzNCwxMC44NDRaTTIwLDI4Ljk2OWwtOCw0LjQwNnY5bDEuMzEzLS43MTlMMjQuNSw0Ny44NzVhMSwxLDAsMCwwLDEsMGwxMS4xODgtNi4yMTlMMzgsNDIuMzc1di05TDMwLDI5djguMzQ0YS45ODguOTg4LDAsMCwwLC41Ljg3NUwzNC42MjUsNDAuNSwyNSw0NS44NDQsMTUuMzc1LDQwLjUsMTkuNSwzOC4yMTlhLjk4OS45ODksMCwwLDAsLjUtLjg3NVptMjgsMC04LDQuNDA2djlsNy41LTQuMTU2YS45ODguOTg4LDAsMCwwLC41LS44NzVaTTIsMjkuMDYzdjguMjgxYS45OS45OSwwLDAsMCwuNS44NzVMMTAsNDIuMzc1di05WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIgLTIpIiBmaWxsPSIjNDY0NjQ2Ii8+DQo8L3N2Zz4NCg==', // icon_url
			80 // position
		);
	}

	public function bweb_component_settings_create_admin_page() {
		$this->bweb_component_settings_options = get_option( 'bweb_component_active' ); 
		
		?>

		<div class="wrap bc_settings_table">
			<h2>Bweb Component</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<div class="table_module">
					<?php
					settings_fields( 'bweb_component_settings_option_group' );
					do_settings_sections( 'bweb-component-settings-admin' );
					submit_button();
					?>
				</div>
				
			</form>
		</div>
	<?php }

	public function bweb_component_settings_page_init() {
		register_setting(
			'bweb_component_settings_option_group', // option_group
			'bweb_component_active' // option_name
		);
		
		add_settings_section(
			'bweb_component_check_section', // id
			'Moduli', // title
			function(){echo 'Abilita i seguenti moduli';}, // callback
			'bweb-component-settings-admin' // page
		);
		

        foreach (glob(plugin_dir_path( __DIR__ ) ."component\*", GLOB_ONLYDIR) as $foldername){
				$BCdatacomponent = new BCdatacomponent();
                $data = $BCdatacomponent->get_component_data( $foldername . '\index.php');
                $icon = '';
                if($data['Icon']!=''){
                    $icon = '<span class="dashicons '.$data['Icon'].'"></span>';
                }

				if(!filter_var($data['Autoload'], FILTER_VALIDATE_BOOLEAN)):
                    
					add_settings_field(
						'c_'.$data['ID'], // id
						'<label class="component_title" for="component_'.$data['ID'].'">'.$icon.'<span>'.$data['Name'].'</span></label>', // title
						array($this,'chk_callback'), // callback
						'bweb-component-settings-admin', // page
						'bweb_component_check_section', // section
						array('ID'=>$data['ID'],'Description'=>$data['Description'],'foldername'=>basename($foldername))
					);
				else:
					add_settings_field(
						'component_autoload_'.$data['ID'], // id
						'<div class="component_title">'.$icon.'<span>'.$data['Name'].'</span></div>', // title
						function(){echo '<input type="checkbox" disabled checked>';}, // callback
						'bweb-component-settings-admin', // page
						'bweb_component_check_section' // section
					);
				endif;
            
        }
		
		
	}


	public function chk_callback( $data ) {
		$foldername = $data['foldername'];
		printf(
			'<input type="checkbox" name="bweb_component_active[]" id="%s" value="%s" title="%s" %s>',
            'component_'.$data['ID'],
			$foldername,
			$data['Description'],
			( isset( $this->bweb_component_settings_options ) && is_array( $this->bweb_component_settings_options) && in_array( $foldername,$this->bweb_component_settings_options) ) ? 'checked' : ''
		);
	}
	public function enable_php_value_setting() {
		printf(
			'<input type="checkbox" name="enable_php_value" value="true" >',
		);
	}


    public function load_enqueue($hook){
		if($hook == 'toplevel_page_bweb-component'){
			wp_enqueue_style( 'bc_settings_css', plugin_dir_url( PLUGIN_FILE_URL ).'assets/css/style.css');
			wp_enqueue_script( 'bc_settings_js', plugin_dir_url( PLUGIN_FILE_URL ).'assets/script/script.js');
		}
    }

	public function register_bwebcomponent_category( $categories ) {
	
        $categories[] = array(
            'slug'  => 'bweb-component',
            'title' => 'Bweb Component'
        );
    
        return $categories;
    }

}
if ( is_admin() ):
	$bweb_component_settings = new BwebComponentSettings();
    $bweb_component_settings->load_setting_page();
endif;


