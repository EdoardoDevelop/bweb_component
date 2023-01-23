<?php

class bcroles {
	private $bcrole_settings_option;
	public function __construct(){

        add_action( 'admin_menu', array( $this, 'bc_roles_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bcrole_settings_page_init' ) );
    }
    public function bc_roles_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Roles Editor', // page_title
			'Roles Editor', // menu_title
			'manage_options', // capability
			'bc-roles', // menu_slug
			array( $this, 'bc_roles_create_admin_page' ) // function
		);
	}
    public function bc_roles_create_admin_page() {
		$this->bcrole_settings_option = get_option( 'bcrole_settings_option' );
    ?>
		<div class="wrap">
			<h2>Roles Editor</h2>
			<p></p>
			<?php settings_errors(); ?>
            
				<form method="post" action="options.php">
					<?php
						settings_fields( 'bcrole_settings_option_group' );
						do_settings_sections( 'bcrole-settings-admin' );
						submit_button();
					?>
				</form>

		</div>
        
    <?php
    }
	
	public function bcrole_settings_page_init() {
		register_setting(
			'bcrole_settings_option_group', // option_group
			'bcrole_settings_option', // option_name
			array( $this, 'bcrole_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bcrole_settings_setting_section', // id
			'Nascondi menu', // title
			array( $this, 'bcrole_settings_section_info' ), // callback
			'bcrole-settings-admin' // page
		);

		add_settings_field(
			'select_menu_admin', // id
			'Menu', // title
			array( $this, 'select_menu_admin_callback' ), // callback
			'bcrole-settings-admin', // page
			'bcrole_settings_setting_section' // section
		);

	}
	public function bcrole_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['menu_admin'] ) ) {
			$sanitary_values['menu_admin'] = $input['menu_admin'];
		}
		return $sanitary_values;

	}
	public function bcrole_settings_section_info() {
		
	}

	public function select_menu_admin_callback() {
		global $menu, $submenu;
		/*$role = get_role( $_GET['role'] );*/

		foreach($this->get_editable_roles() as $x => $x_value) :
			if ( $x != 'administrator' ) :
				echo '<div style="border: 1px solid #ccc; display: inline-block; margin: 10px; min-width: 300px; padding: 20px">';
                echo '<h2>'.$x_value['name'].'</h2>';
				foreach($menu as $m => $m_value) : 
					/*
						[0] => Bacheca 
						[1] => read 
						[2] => index.php 
						[3] => 
						[4] => menu-top menu-top-first menu-icon-dashboard menu-top-last 
						[5] => menu-dashboard 
						[6] => dashicons-dashboard 
					*/
					if($m_value[4] != 'wp-menu-separator'){
                        printf(
                            '<label><input type="checkbox" name="bcrole_settings_option[menu_admin][%s][]" id="menu_admin" value="%s" %s>%s</label><br>',
                            $x,
                            $m_value[2],
                            ( isset( $this->bcrole_settings_option['menu_admin'][$x] ) && in_array( $m_value[2], $this->bcrole_settings_option['menu_admin'][$x]) ) ? 'checked' : '',
                            $m_value[0]
                        );
                        if(isset( $submenu[$m_value[2]] ) ){
                            foreach($submenu[$m_value[2]] as $sm => $sm_value) : 
                                if($sm_value[2]!=$m_value[2]):
                                    printf(
                                        '<label style="margin-left:20px"><input type="checkbox" name="bcrole_settings_option[menu_admin][%s][]" id="menu_admin" value="%s" %s>%s</label><br>',
                                        $x,
                                        $sm_value[2],
                                        ( isset( $this->bcrole_settings_option['menu_admin'][$x] ) && in_array( $sm_value[2], $this->bcrole_settings_option['menu_admin'][$x]) ) ? 'checked' : '',
                                        $sm_value[0]
                                    );
                                endif;
                            endforeach;
                        }
					}
				endforeach;
				echo '</div>';
			endif;
		endforeach;

	}

	public function get_editable_roles() {
		global $wp_roles;
	
		$all_roles = $wp_roles->roles;
		$editable_roles = apply_filters('editable_roles', $all_roles);
	
		return $editable_roles;
	}

}
$bcroles = new bcroles();