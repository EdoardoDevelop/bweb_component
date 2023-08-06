<?php
/**
 * ID: popUp
 * Name: PopUp
 * Description: 
 * Icon: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD9klEQVR4nO2V3WscVRiHD6X20iJ4KQheCP4LUqlXtmnSppDdrG6MCSZuS22q9aNqsW5S08wku8k22aDUC0EoelFMkX6npGl355wz0CIKoQZCNJ39aK0gtngjUt7yLkwgy76dzczO7sxmHnhgf2fec86Pc7OMBQQEBAQEVM1f+h7wssxt7ul7wcu6/gABG42FhfCWZdkxuixDxd/1EPjBZb2jsKyHVOzu+AGW9JC6pIfBpyqOH2BR7yws6hH4jUdeZj5hUYa3YWfs7viwBf11QJnPqFnvX/U3ADXzSuEyPElqznERh71t87PsAtTM54wb8CSpOcdFHPa2zU35JqDMZ9Sst5RvAcp8Rs16a7IH/KzjB7ghe8HPOn6Aa/JtQJnPqFnvq7IPUOYzatb7kuwHtDx7Vaq3bc7LGKDl2atSvW3zk9wHKJW9gms9Z+R+QKnsFVzreUYeAJTKXsG1nj/IdwGlciXuFy/u+rN4IYfeL15oKd+7Xt3qWRWn5QCgVK7E7fxs7nZ+FkrmZo3yvevVrZ5V8Z08BCiVK5Ex5nKZ3DUoacytPoCb2OlZFd/K9wClciVm/si2zKxkDPRHI7OT1QE7PaviG3kYUCqvB3NvtTaq5xq+Fh8ASuX1YO6t1kb1XMO0+BBQKlM8uHseUFYn7Pa0ZFJ8DCiVKYrFi4CyOmG3pyUT4gigVKZYKlwBtNJZVtazpyVj4lNAqUzxS/4qoJXOsrKePS1RxGeAUpmC5+YAZXXCbk9LhsVRQKlMMWtcB5TVCbs9LRkSnwNKZYqzRgbQSmdRNqKnJcfEMUCpTHH6jgZopbMoG9HTkqPiC0Cp7BVc6/mJGASUyl7BtZ4fiSFAqewVXOt5WBwHdDXz4zlzzWu+z4cMqrdtBsQwoGY+KIdbBviwYa57xlKnL3dSvW1zQJwAlPmMmvWOiZHCPqFATKrbmE/Yr514pdSZK3nHh/ULVekXKtiSq//1c3W+T6ovVXsfzvZx5Xppr917V+9XRhw/QHghvqVXG1V6uFro5aNgR9wbm08+a3UXzji5Z1VNzffw0RHszhpJlz75dDdPZLp5Arq1sbNW8zhTmuWJDO5lzUCXrj4X5cm/ozwJ0Wyij5qLamPvlGa05D9RnnieNROdWrIrwsehk4//G8kkXyz/Hs1OvBDh4w9xJiLGo6wZCWkT34d4CkI8dTN269RT5vr2+fjmEE9J/Nahpc6wZiV8S93arqVW9vKT0M5Tg+Z6Oz85VFrTUrnW7FfPsGamNZt+tU2berSbT/2/h0+17ubpNvyNa21icjvbCLRoaWUXT8Nap5z/X/uFOMQ37eDpwR18+g76mjYdx7VG9woICAgIYBuQx7KwSQm6qvc3AAAAAElFTkSuQmCC
 * Version: 1.0
 * 
 */
if (!defined("ABSPATH")) {
    exit; // Exit if accessed directly
}

class bc_popup {
    public function __construct(){}

    public function load_admin(){
        add_action( 'init', array( $this, 'cpt_popup' ) );

        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );

        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_enqueue' ));
    }

    public function cpt_popup(){
        $labels = array(
            'name'                  => 'PopUp',
            'singular_name'         => 'PopUp',
            'menu_name'             => 'PopUp',
            'name_admin_bar'        => 'PopUp',
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
            'label'                 => 'PopUp',
            'description'           => '',
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-pressthis',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => false,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'bc_popupmaker', $args );
    }


    public function add_meta_boxes(){
		
			add_meta_box(
				'popupsettings', /* The id of our meta box. */
				'Popup Settings', /* The title of our meta box. */
				[ $this, 'add_meta_box_callback' ], /* The callback function that renders the metabox. */
				'bc_popupmaker', /* The screen on which to show the box. */
				'normal', /* The placement of our meta box. */
				'core', /* The priority of our meta box. */
			);
		
	}

    public function save_post( $post_id ) {
		
        if ( isset( $_POST[ 'popup_trigger_add_type' ] ) ) {
            update_post_meta( $post_id, 'popup_trigger_add_type', $_POST[ 'popup_trigger_add_type' ] );
        }else{
            delete_post_meta($post_id, 'popup_trigger_add_type');
        }
        if ( isset( $_POST[ 'class_open' ] ) ) {
            update_post_meta( $post_id, 'class_open', $_POST[ 'class_open' ] );
        }else{
            delete_post_meta($post_id, 'class_open');
        }
        if ( isset( $_POST[ 'ms_open' ] ) ) {
            update_post_meta( $post_id, 'ms_open', $_POST[ 'ms_open' ] );
        }else{
            delete_post_meta($post_id, 'ms_open');
        }
        if ( isset( $_POST[ 'id_trigger' ] ) ) {
            update_post_meta( $post_id, 'id_trigger', $_POST[ 'id_trigger' ] );
        }else{
            delete_post_meta($post_id, 'id_trigger');
        }
	
        if ( isset( $_POST[ 'popup_template' ] ) ) {
            update_post_meta( $post_id, 'popup_template', $_POST[ 'popup_template' ] );
        }else{
            delete_post_meta($post_id, 'popup_template');
        }
	
	}

    public function add_meta_box_callback() {
        ?>
            <div class="pupupsettings_tabs">
                
                    <input type="radio" id="tab-1" name="tab-group-1" checked>
                    <label for="tab-1">Trigger</label>
                    <input type="radio" id="tab-2" name="tab-group-1">
                    <label for="tab-2">Targeting</label>
                    <input type="radio" id="tab-3" name="tab-group-1">
                    <label for="tab-3">Aspetto</label>
                
                
                <div class="pupupsettings_tab">
                    
                    
                    <div class="pupupsettings_content">
                        <a href="#" class="add_trigger_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi</a>
                        <div class="clear"></div>
                        <table id="cont_trigger">
                            <?php 
                            $s = get_post_meta( get_the_ID(), 'popup_trigger_add_type', true ); 
                            $sC = get_post_meta( get_the_ID(), 'class_open', true ); 
                            $sM = get_post_meta( get_the_ID(), 'ms_open', true ); 
                            if(isset($s) && is_array($s)) {
                                foreach($s as $n => $v ){
                                    ?>
                                    <tr>
                                        <td>
                                            <select class="popup_trigger_add_type" name="popup_trigger_add_type[]">
                                                <option value="click_open" <?php if($v == 'click_open') echo 'selected'; ?>>Fare clic su Apri</option>
                                                <option value="auto_open" <?php if($v == 'auto_open') echo 'selected'; ?>>Ritardo / Apertura automatica</option>
                                            </select>
                                        </td>
                                        <td class="imp">
                                            <?php 
                                            if($v == 'click_open') : 
                                                ?>
                                                    Classe <input type="text" value="<?php echo $sC[$n]; ?>" name="class_open[]">
                                                    <input type="hidden" name="ms_open[]">
                                                <?php
                                            else: 
                                                ?>
                                                    Tempo ms <input type="text" value="<?php echo $sM[$n]; ?>" name="ms_open[]">
                                                    <input type="hidden" name="class_open[]">
                                                <?php
                                            endif; 
                                            ?>
                                        </td>
                                        <td><a href="#" class="remove_row button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></td>
                                    </tr>
                                    <?php
                                }

                            }
                            ?>
                        </table>
                        <div class="clear"></div>
                    </div> 
                    <div class="pupupsettings_content">
                        <?php
                            echo $this->generate_post_select('targeting_post', $selected = 0);
                        ?>
                        <a href="#" class="add_targeting_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi</a>
                        <table id="cont_targeting">
                            <?php
                            $idT = get_post_meta( get_the_ID(), 'id_trigger', true ); 
                            if(isset($idT) && is_array($idT)) {
                                foreach($idT as $n => $v ){
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="id_trigger[]" value="<?php echo $v; ?>">Pagina/post: <?php echo get_the_title($v); ?> (<?php echo $v; ?>)
                                        </td>
                                        <td><a href="#" class="remove_row button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div> 
                    <div class="pupupsettings_content">
                        <!--<div>
                            <strong>impostazioni predefinite</strong>
                            <div id="pupupsettings-popup-settings-display-subtabs_preset" class="tab-content active">
					
                                <div class="pupupsettings-field pupupsettings-field-html explain-wrapper " data-id="explain" data-pupupsettings-dynamic-desc="null">
                                
                                
                                
                                
                                <p>Select one of the types below to get started! Once selected, you can adjust the display settings using the tabs above.</p>
                            
                                
                                </div>
                            
                                <div class="pupupsettings-field pupupsettings-field-section type_section-wrapper popup-types " data-id="type_section" data-pupupsettings-dynamic-desc="null">
                                
                                
                                
                                
                                <div class="pupupsettings-field-section popup-types ">
                                    
                                    <div class="popup-type" data-popup-type="center-popup"><img src="http://localsite.ddns.net/test/wp-content/plugins/popup-maker/assets/images/admin/display-switcher/center-popup.png" alt="Centra popup"><button class="button">Centra popup</button></div>
                                    
                                    <div class="popup-type" data-popup-type="right-bottom-slidein"><img src="http://localsite.ddns.net/test/wp-content/plugins/popup-maker/assets/images/admin/display-switcher/right-bottom-slidein.png" alt="Entrata a scorrimento in basso a destra"><button class="button">Entrata a scorrimento in basso a destra</button></div>
                                    
                                    <div class="popup-type" data-popup-type="top-bar"><img src="http://localsite.ddns.net/test/wp-content/plugins/popup-maker/assets/images/admin/display-switcher/top-bar.png" alt="Barra superiore"><button class="button">Barra superiore</button></div>
                                    
                                    <div class="popup-type" data-popup-type="left-bottom-notice"><img src="http://localsite.ddns.net/test/wp-content/plugins/popup-maker/assets/images/admin/display-switcher/left-bottom-notice.png" alt="Avviso in basso a sinistra"><button class="button">Avviso in basso a sinistra</button></div>
                                    
                                </div>
                            
                                
                                </div>
                            
                            </div>
                        </div>-->
                            <?php
                            $popup_template = get_post_meta( get_the_ID(), 'popup_template', true ); 
                            if(!isset($popup_template) || empty($popup_template)) {
                                $popup_template = '<div id="bc_popup[postid]" class="bc_popup">'.PHP_EOL;
                                $popup_template .= '    <div class="bc_popup_overlay">'.PHP_EOL;
                                $popup_template .= '        <div class="bc_popup_container">'.PHP_EOL;
                                $popup_template .= '            <div class="bc_popup_main">'.PHP_EOL;
                                $popup_template .= '                <div class="bc_popup_close">X</div>'.PHP_EOL;
                                $popup_template .= '                [contentpoup]'.PHP_EOL;
                                $popup_template .= '            </div>'.PHP_EOL;
                                $popup_template .= '        </div>'.PHP_EOL;
                                $popup_template .= '    </div>'.PHP_EOL;
                                $popup_template .= '</div>';
                            }
                            ?>
                        <strong>Template</strong><br>
                        <textarea name="popup_template" id="popup_template" cols="30" rows="10"><?php echo $popup_template; ?></textarea>
                    </div> 

                </div>

                
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        <?php
    }
    public function generate_post_select($select_id, $selected = 0) {
		
        $sel = '<select name="'. $select_id .'" id="'.$select_id.'">';
        $sel .= '<option value="0"'. ($selected == '0' ? ' selected="selected"' : ''). '>Seleziona e aggiungi</option>';
        $get_post_types = get_post_types(array('public' => true), 'object', 'and');
        foreach ($get_post_types as $key => $post_type_object) {
            if( $post_type_object->name != 'attachment' ){
                $sel .= '<optgroup label="'.$post_type_object->label.'">';
                $posts = get_posts(array('post_type'=> $post_type_object->name, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
                foreach ($posts as $post) {
                    $sel .= '<option value="'. $post->ID. '"'. ($selected == $post->ID ? ' selected="selected"' : ''). '>'. $post->post_title. '</option>';
                }
                $sel .= '</optgroup>';
            }
        }
        $sel .= '</select>';
		return $sel;
    }

    public function load_admin_enqueue(){
        wp_enqueue_script( 'bcadminpopupjs', plugin_dir_url(PLUGIN_FILE_URL).'component/popUp/assets/script.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'bcadminpopupcss', plugin_dir_url( PLUGIN_FILE_URL ).'component/popUp/assets/style.css');
    }

    public function load_front(){
        add_action( 'wp_enqueue_scripts', array( $this, 'load_front_enqueue' ));
        add_action('wp_footer', array( $this, 'inject_popup')); 
    }
    public function load_front_enqueue(){
        //wp_enqueue_script( 'bcpopupjs', plugin_dir_url(PLUGIN_FILE_URL).'component/popUp/assets/script.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'bcpopupss', plugin_dir_url( PLUGIN_FILE_URL ).'component/popUp/assets/frontend.css');
    }

    public function inject_popup(){
        $popup_posts = get_posts(array('post_type'=> 'bc_popupmaker', 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
        foreach ($popup_posts as $popup_post) {
            $idT = get_post_meta( $popup_post->ID, 'id_trigger', true ); 
            if(isset($idT) && is_array($idT)) {
                foreach($idT as $id){
                    if(get_the_ID() == $id){
                        $popup_template = get_post_meta( $popup_post->ID, 'popup_template', true ); 
                        $popup_template = str_replace('[postid]',$popup_post->ID,$popup_template);
                        $popup_template = str_replace('[contentpoup]',$popup_post->post_content,$popup_template);
                        echo $popup_template;

                        $s = get_post_meta( $popup_post->ID, 'popup_trigger_add_type', true ); 
                        $sC = get_post_meta( $popup_post->ID, 'class_open', true ); 
                        $sM = get_post_meta( $popup_post->ID, 'ms_open', true ); 
                        ?>
                        <script>
                            jQuery(function($){
                                $('.bc_popup_close').click(function (e) { 
                                    e.preventDefault();
                                    $('#bc_popup<?php echo $popup_post->ID; ?> .bc_popup_overlay').hide();
                                });
                            <?php
                            if(isset($s) && is_array($s)) {
                                foreach($s as $n => $v ){
                                    if($v == 'auto_open') :
                                    ?>
                                    
                                    setTimeout(function() {
                                        $('#bc_popup<?php echo $popup_post->ID; ?> .bc_popup_overlay').show();
                                    }, <?php echo $sM[$n]; ?>);
                                        
                                    <?php
                                    else:
                                    ?>
                                    
                                    $('.<?php echo $sC[$n]; ?>').click(function (e) { 
                                        e.preventDefault();
                                        $('#bc_popup<?php echo $popup_post->ID; ?> .bc_popup_overlay').show();
                                    });
                                        
                                    <?php
                                    endif;
                                }
                            }
                            ?>
                            });
                        </script>
                        <?php
                    }
                }
            }
        }
    }

}

$bc_popup = new bc_popup();
$bc_popup->load_admin();
if ( !is_admin() ){
    $bc_popup->load_front();
}