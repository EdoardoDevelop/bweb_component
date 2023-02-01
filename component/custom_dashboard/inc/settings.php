<?php

class Bccustom_dashboard {
	private $bc_custom_dashboard_options;

    public function __construct() {
		$this->bc_custom_dashboard_options = get_option( 'bc_custom_dashboard_options' );
    
        add_action( 'admin_menu', array( $this, 'bccustom_dashboard_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bccustom_dashboard_settings_page_init' ) );
        add_action('admin_menu', array( $this,'bccustom_dashboard_register_menu') );
	    add_action('load-index.php', array( $this,'bccustom_dashboard_redirect_dashboard') );
        add_action('admin_head', function(){
            remove_submenu_page('index.php', 'index.php' );
        });
        add_action( 'admin_enqueue_scripts', array( $this, 'bccustom_dashboard_load_scripts_admin' ));

	}
    public function bccustom_dashboard_redirect_dashboard() {

        if( is_admin() ) {
            $screen = get_current_screen();
            
            if( $screen->base == 'dashboard' ) {
    
                wp_redirect( admin_url( 'index.php?page=dashboard' ) );
                
            }
        }
    
    }
    public function bccustom_dashboard_register_menu() {
        add_dashboard_page( 'Dashboard', 'Dashboard', 'read', 'dashboard', array( $this,'bccustom_dashboard_create_dashboard'), 1 );
    }
    
    public function bccustom_dashboard_create_dashboard() {
        include_once( 'dashboard.php'  );
    }

	public function bccustom_dashboard_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Custom Dashboard', // page_title
			'Custom Dashboard', // menu_title
			'manage_options', // capability
			'custom_dashboard', // menu_slug
			array( $this, 'bccustom_dashboard_settings_create_admin_page' ) // function
		);

	}

    public function bccustom_dashboard_settings_create_admin_page() {
		
        ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Custom Dashboard</h2>
			<p></p>
			<?php settings_errors(); ?>

			<div class="custom_dash">
                
                <form method="post" action="options.php" id="form_dash">
                    <?php
					settings_fields( 'bc_custom_dashboard_options_group' );
					do_settings_sections( 'bc_custom_dashboard-settings-admin' );
					submit_button();
				    ?>
                </form>
                
            </div>
		</div>
	<?php }


    public function bccustom_dashboard_settings_page_init() {
        register_setting(
			'bc_custom_dashboard_options_group', // option_group
			'bc_custom_dashboard_options', // option_name
			array( $this, 'bc_custom_dashboard_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bc_custom_dashboard_settings_setting_section', // id
			'Trascina le voci del menù o gli elementi aggiuntivi', // title
			function(){}, // callback
			'bc_custom_dashboard-settings-admin' // page
		);

		add_settings_field(
			'custom_dashboard', // id
			$this->print_th(), // title
			array( $this, 'custom_dashboard_callback' ), // callback
			'bc_custom_dashboard-settings-admin', // page
			'bc_custom_dashboard_settings_setting_section' // section
		);

    }

    public function bc_custom_dashboard_settings_sanitize($input){
        $sanitary_values = array();
        if(isset( $input['html_dash'] )){
			$sanitary_values['html_dash'] = $input['html_dash'];
		}
        if(isset( $input['id_dash_bg'] )){
			$sanitary_values['id_dash_bg'] = $input['id_dash_bg'];
		}
        
        return $sanitary_values;
    }

    public function custom_dashboard_callback(){
        ?>
		<div id="trash_dash"><span class="dashicons dashicons-trash"></span></div>
		<div id="cont_n_col">Numero colonne: <input type="number" id="n_col" max="5" min="1"></div>

		<div id="cont_widget">
			<?php
			if(isset( $this->bc_custom_dashboard_options['html_dash'] ) && $this->bc_custom_dashboard_options['html_dash'] != ''){
				echo $this->bc_custom_dashboard_options['html_dash'];
			}else{
				?>
			<div class="boxwidget"></div><div class="boxwidget"></div><div class="boxwidget"></div><div class="boxwidget"></div>
				<?php
			}
			?>
		</div>
		<br>
		<a href="#" class="button-secondary button_box_icon">Apri Icone</a>
		<div class="select_dashicons hidden" id="select_dashicons">           
		<?php
		$icons_json = json_decode(file_get_contents(plugin_dir_path( __FILE__ ) .'icons.json'), false);
		foreach($icons_json->icon as $icon) {
			?>
				<span class="dashicons <?php echo $icon->class;?>" atr-class="<?php echo $icon->class;?>"></span>
			<?php
			
		}
		?>
			
		</div>
		<br><br>
		<a href="#TB_inline?&width=360&height=400&inlineId=cont_bg_dash" class="thickbox button-secondary">Cambia sfondo</a>
		<div id="cont_bg_dash">
		<div id="bg_dash">
		<?php
		$default_dash_bg = plugins_url('../assets/bg_dash.jpg', __FILE__);

        $src_dash_bg = $default_dash_bg;
        if(isset( $this->bc_custom_dashboard_options['id_dash_bg'] )){
            if ( !empty( $this->bc_custom_dashboard_options['id_dash_bg'] ) ) {
                $src_dash_bg = wp_get_attachment_url($this->bc_custom_dashboard_options['id_dash_bg']);
            }
        }
        
        ?>	
            <img src="<?php echo $src_dash_bg; ?>" id="preview_dash_bg">
			<br>
            <button type="submit" class="upload_image_button button">Seleziona immagine di sfondo</button>
			<br><br>
            <button type="submit" class="default_image_button button" attr-default="<?php echo $default_dash_bg; ?>">Ripristina immagine di sfondo</button>
        <?php
        
        printf(
			'<input type="hidden" name="bc_custom_dashboard_options[id_dash_bg]" id="id_dash_bg" value="%s">',
            isset( $this->bc_custom_dashboard_options['id_dash_bg'] ) ? esc_attr( $this->bc_custom_dashboard_options['id_dash_bg']) : ''
		);
		?>
		</div>
		</div>
		<?php


		printf(
			'<textarea name="bc_custom_dashboard_options[html_dash]" id="html_dash" class="hidden">%s</textarea>',
			( isset( $this->bc_custom_dashboard_options['html_dash'] )) ? esc_attr( $this->bc_custom_dashboard_options['html_dash']) : ''
			
		);
    }
	public function print_th(){
		$th = '';
		
		$th .= 'Elementi aggiuntivi:';
		$th .= '<br>';
		$th .= '<div class="add_element">';
		$th .= '<label>Testo/spazio vuoto:<span class="dashicons dashicons-move item_widget_text"></span><br><textarea id="input_widget_text"></textarea></label> ';
		$th .= '<label>Separatore:<br> <div class="item_widget separator"><hr></div></label>';
		
				foreach (get_post_types(array( 'public' => true )) as $value) {
					$pt = get_post_type_object( $value );

					if($value == 'post'){
						$th .= '<label>';
						$th .= $pt->label.': ';
						$th .= '<span class="dashicons dashicons-move item_widget_select" attr-type="'.$value.'"></span><br>';
						$th .= $this->generate_post_select('id'.$value, $value, $selected = 0);
						$th .= '</label>';
					}
					if($value !== 'post' && $value !== 'attachment'){
						$th .= '<label>';
						$th .= $pt->label.': ';
						$th .= '<span class="dashicons dashicons-move item_widget_select" attr-type="'.$value.'"></span><br>';
						$th .= wp_dropdown_pages(array('post_type'=>$value,'name' => 'id'.$value,'echo'=>false));
						$th .= '</label>';
					}
				}
				$th .= '</div>';
				return $th;
	}

	public function generate_post_select($select_id, $post_type, $selected = 0) {
        $post_type_object = get_post_type_object($post_type);
        $label = $post_type_object->label;
		$sel = '';
        $posts = get_posts(array('post_type'=> $post_type, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
        $sel .= '<select name="'. $select_id .'" id="'.$select_id.'">';
        foreach ($posts as $post) {
            $sel .= '<option value="'. $post->ID. '"'. ($selected == $post->ID ? ' selected="selected"' : ''). '>'. $post->post_title. '</option>';
        }
        $sel .= '</select>';
		return $sel;
    }

    public function bccustom_dashboard_load_scripts_admin(){
        global $pagenow;
		if($pagenow=='admin.php' && $_GET['page']=='custom_dashboard'){
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );
			add_thickbox();
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-touch', plugin_dir_url(PLUGIN_FILE_URL).'component/custom_dashboard/assets/jquery.ui.touch-punch.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'dashjs', plugin_dir_url(PLUGIN_FILE_URL).'component/custom_dashboard/assets/script.js', array( 'jquery' ), null, true );
			wp_enqueue_style( 'dashcss', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_dashboard/assets/style.css');
			
		}
		if(($pagenow=='index.php' || $pagenow=='admin.php') && $_GET['page']=='dashboard'){
			wp_enqueue_style( 'dashcss', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_dashboard/assets/style.css');
			add_action('admin_head', array($this,'src_dash_bg'));

			
		}
		//wp_enqueue_script( 'bccustom_dashboard_settings_js', plugin_dir_url( __FILE__ ).'assets/script.js');
    }

	public function src_dash_bg() {
		$default_dash_bg = plugins_url('../assets/bg_dash.jpg', __FILE__);
		$src_dash_bg = $default_dash_bg;
		
		if(isset( $this->bc_custom_dashboard_options['id_dash_bg'] )){
            if ( !empty( $this->bc_custom_dashboard_options['id_dash_bg'] ) ) {
                $src_dash_bg = wp_get_attachment_url($this->bc_custom_dashboard_options['id_dash_bg']);
            }
        }
		echo '<style>
			#wpwrap{
				background-image: url('.$src_dash_bg.');
				background-position: bottom right;
				background-size: cover;
				background-repeat: no-repeat;
			} 
		</style>';
	}

    

}
if ( is_admin() ):
    $bc_custom_dashboard = new Bccustom_dashboard();
endif;