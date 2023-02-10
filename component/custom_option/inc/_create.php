<?php

class BcCustomOptionFieldCreate {
	private $bc_custom_option_field_options;

	public function __construct() {
        if(isset(get_option( 'bc_custom_option_field' )['custom_option_field'])){
            $this->bc_custom_option_field_options = get_option( 'bc_custom_option_field' )['custom_option_field'];
            add_action("admin_init", array($this, "custom_option_field_settings"));
        }
	}

    public function custom_option_field_settings(){
        if(isset($this->bc_custom_option_field_options) && is_array($this->bc_custom_option_field_options)) {
            foreach($this->bc_custom_option_field_options as $narraycustomfield => $v ){
                register_setting("general", sanitize_title($v['name']) );
                add_settings_field(sanitize_title($v['name']) , $v['name'], array($this,'render_fields'), "general",'default', $v); 
            }
        } 
    }
    public function render_fields( $v){
        $valuefield = get_option(sanitize_title($v['name']));
        
        if($v['type'] == 'text'){
        ?>
        <p>
            <label>
                <input type="text" class="regular-text" name="<?php echo sanitize_title($v['name']); ?>" value="<?php echo $valuefield; ?>">
            </label>
        </p>
        <?php
        }
        if($v['type'] == 'textarea'){
        ?>
        <p>
            <label>
                <textarea class="regular-text" rows="10" cols="50" name="<?php echo sanitize_title($v['name']); ?>"><?php echo $valuefield; ?></textarea>
            </label>
        </p>
        <?php
        }
        if($v['type'] == 'editor'){
            
            wp_editor (
                html_entity_decode($valuefield ),
                sanitize_title($v['name']),
                array (
                        'quicktags' => false,
                        'teeny'=>false,
                        'media_buttons'=>false,
                        'tinymce' => array(
                                'toolbar1' => 'bold, italic, underline,|,fontsizeselect',
                                'toolbar2'=>false,
                                'autoresize_min_height' => 150,
                                'wp_autoresize_on'      => true,
                                'plugins'               => 'wpautoresize',
                        ),
                )
            );
        }
    }
    

}
if ( is_admin() )
	$bc_custom_option_field = new BcCustomOptionFieldCreate();

/* 
 * Retrieve this value with:
 * $bc_custom_option_field_options = get_option( 'bc_custom_option_field_option_name' ); // Array of All Options
 * $text_0 = $bc_custom_option_field_options['text_0']; // text
 */