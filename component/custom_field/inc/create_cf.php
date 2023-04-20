<?php

class BcCustomFieldCreate {

	public function __construct() {
        if(isset(get_option( 'bc_settings_cf' )['custom_field_group'])){
           
            add_action( 'add_meta_boxes', array($this,'metabox_easyparent_add_meta_box' ));  
            add_action( 'save_post',  array($this,'metabox_easyparent_save' ));
            add_action( 'edit_form_after_title', array($this,'edit_form_after_title'));

        }
    }
    public function metabox_easyparent_add_meta_box() {
        global $post;
        $custombox_group = get_option( 'bc_settings_cf' )['custom_field_group'];
        if(isset($custombox_group) && is_array($custombox_group)) {
            foreach($custombox_group as $narray => $v ){
            //print_r($custombox_group[$narray]['typepost']);
                if(isset($v['typepost'])){
                    add_meta_box(
                        sanitize_title($v['namegroup']),
                        $v['namegroup'],
                        array($this,'print_html'),
                        $v['typepost'],
                        $v['position'],
                        'default',
                        $v
                    );
                }
                if(isset($v['select_posts']) && is_array($v['select_posts'])){
                    foreach ( $v['select_posts'] as $idpost ){
                        if($post->ID ==$idpost){
                            add_meta_box(
                                sanitize_title($v['namegroup']),
                                $v['namegroup'],
                                array($this,'print_html'),
                                get_post_type( $idpost ),
                                $v['position'],
                                'default',
                                $v
                            );
                        }
                    }
                }
            }
        }

        
    }
    public function metabox_easyparent_get_meta( $value ) {
        global $post;
    
        $field = get_post_meta( $post->ID, $value, true );
        if ( ! empty( $field ) ) {
            return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
        } else {
            return false;
        }
    }
    public function print_html( $post, $args ) {
        global $post;
        $v = $args['args'];
        //print_r($v['namegroup']);
        wp_nonce_field( '_'.sanitize_title($v['namegroup']).'_nonce', sanitize_title($v['namegroup']).'_nonce' );
        if(isset($v['field']) && is_array($v['field'])) {
            foreach($v['field'] as $narray2 => $v2 ){
                $field = $v2;
                
                $namefield = sanitize_title($v['namegroup']) . '_' . sanitize_title($field['namefield']);
                $valuefield = $this->metabox_easyparent_get_meta( $namefield );
                
                
                if($field['type'] == 'text'){
                ?>
                <p>
                    <label><strong><?php echo $field['namefield']; ?></strong><br>
                        <input type="text" class="<?php echo (isset( $v['position'] ) && $v['position'] === 'side' ) ? '' : 'regular-text'; ?>" name="<?php echo $namefield; ?>" value="<?php echo $valuefield; ?>">
                    </label>
                </p>
                <?php
                }
                if($field['type'] == 'textarea'){
                    ?>
                    <p>
                        <label><strong><?php echo $field['namefield']; ?></strong></label><br>
                        <textarea class="<?php echo (isset( $v['position'] ) && $v['position'] === 'side' ) ? '' : 'regular-text'; ?>" rows="10" cols="50" name="<?php echo $namefield; ?>"><?php echo $valuefield; ?></textarea>
                    </p>
                    <?php
                }
                if($field['type'] == 'checkbox'){
                    ?>
                    <p>
                        <label><strong><?php echo $field['namefield']; ?></strong> 
                            
                            <?php
                            printf(
                                '<input type="checkbox" name="'. $namefield .'" value="true" %s>',
                                ( isset( $valuefield ) && $valuefield === 'true' ) ? 'checked' : ''
                            );
                            ?>
                        </label>
                    </p>
                    <?php
                }
                if($field['type'] == 'calendario'){
                    wp_enqueue_script('jquery');
                    wp_enqueue_script( 'bc_datepickerjs', plugin_dir_url( __FILE__ ).'../assets/jquery.datetimepicker.js' );
                    wp_enqueue_style( 'bc_datepickercss', plugin_dir_url( __FILE__ ).'../assets/jquery.datetimepicker.css');
                    add_action('admin_footer',  array($this,'cusotm_calendar_admin_footer'));
                ?>
                    <p><strong><?php echo $field['namefield']; ?></strong> - Seleziona la data.<br/>
                        <input name="<?php echo $namefield; ?>" class="datetimepicker" readonly value="<?php echo $valuefield; ?>" style="border: 1px solid #ccc; margin: 10px 10px 0 0"/>
                    </p>
                <?php
                }
                if($field['type'] == 'editor'){
                    ?>
                        <label><strong><?php echo $field['namefield']; ?></strong></label><br>
                        
                    <?php
                    wp_editor (
                        html_entity_decode($valuefield ),
                        $namefield,
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
                if($field['type'] == 'allegato'){
                    wp_enqueue_script('jquery');
                    wp_enqueue_script('bc_field_allegati_js', plugin_dir_url( __FILE__ ).'../assets/field_allegati.js', array('jquery', 'jquery-ui-sortable'));
                    wp_enqueue_style('bc_field_allegati_css', plugin_dir_url( __FILE__ ).'../assets/field_allegati.css');
                    $allegati_data = $valuefield;
                    //print_r($allegati_data);
                    ?>
                        <label><strong><?php echo $field['namefield']; ?></strong></label><br>
                        
                        
    
    
                        <table class="form-table">
                            <tr><td>
                                <div class="cloneliallegato hidden">
                                    <li>
                                        <input type="hidden" _name="<?php echo $namefield; ?>[]" value="attachment.url">attachment.filename 
                                        <a class="remove-allegato button button-small" href="#">
                                            <small>Rimuovi documento</small>
                                        </a>
                                    </li>
                                </div>
                                <a class="allegato-add button" href="#" data-uploader-title="Aggiungi documento" data-uploader-button-text="Aggiungi documento">Aggiungi documento</a>
    
                                
                                <ul class="allegato-metabox-list">
                                <?php if(isset($allegati_data) && is_array($allegati_data)) : 
                                    for( $i = 0; $i < count( $allegati_data ); $i++ ) : 
                                    ?>
    
                                <li>
                                    <input type="hidden" name="<?php echo $namefield; ?>[]" value="<?php echo $allegati_data[$i]; ?>">
                                    <?php echo basename($allegati_data[$i]); ?> <a class="remove-allegato button button-small" href="#"><small>Rimuovi documento</small></a>
                                </li>
    
                                <?php endfor; 
                                endif;?>
                                </ul>
    
                            </td></tr>
                        </table>
                    <?php
                    
                }
                
                if($field['type'] == 'img'){
                    wp_enqueue_script('bc_img-metabox', plugin_dir_url( __FILE__ ).'../assets/field_img.js', array('jquery'));
                    //wp_enqueue_style('bc_gallery-metabox', plugin_dir_url( __FILE__ ).'../assets/gallery-metabox.css');
                    ?>
                    <table class="form-table">
                        <tr>
                            <td><?php echo $field['namefield']; ?></td>
                        </tr>
                        <tr><td>
                            
                        <?php
                        $urlimg = wp_get_attachment_image_src( $valuefield, 'thumbnail' );
                        if( $urlimg ){
                            $urlimg = $urlimg[0];
                        }else{
                            $urlimg = '';
                        }
                        ?>
                        <img id="img-preview-<?php echo $namefield; ?>" src="<?php echo $urlimg; ?>">
                        <br>
                        <input type="hidden" name="<?php echo $namefield; ?>" id="<?php echo $namefield; ?>" value="<?php echo $valuefield; ?>" class="small-text" />
                        <a href="#" class="button-primary single_image_add" <?php if($urlimg!='') echo 'style="display:none"'; ?> data-id="<?php echo $namefield; ?>">Seleziona</a>
                        <a href="#" class="button-primary single_image_del" <?php if($urlimg=='') echo 'style="display:none"'; ?> data-id="<?php echo $namefield; ?>">Rimuovi</a>

                        </td></tr>
                    </table>

                    <?php
                    
                }
                if($field['type'] == 'multipleimg'){
                    wp_enqueue_script('bc_gallery-metabox', plugin_dir_url( __FILE__ ).'../assets/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
                    wp_enqueue_style('bc_gallery-metabox', plugin_dir_url( __FILE__ ).'../assets/gallery-metabox.css');
                    ?>
                    <table class="form-table">
                        <tr>
                            <td><?php echo $field['namefield']; ?></td>
                        </tr>
                        <tr><td>
                            <a class="gallery-add button" href="#" data-uploader-title="Add image(s) to gallery" data-uploader-button-text="Add image(s)">Aggiungi immagini</a>

                            <div class="cloneligallery hidden">
                                <li>
                                    <input type="hidden" _name="<?php echo $namefield; ?>[]" value="attachment.id">
                                    <img class="image-preview" _src="attachment.sizes.thumbnail.url">
                                    <a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Cambia immagine</a><br><br>
                                    <small><a class="remove-image button button-small" href="#">Elimina immagine</a></small>
                                </li>
                            </div>
                            <ul class="gallery-metabox-list">
                            <?php if ($valuefield) : 
                            if(isset($valuefield) && is_array($valuefield)):
                                foreach ($valuefield as $key => $value) : 
                                $image = wp_get_attachment_image_src($value, 'thumbnail'); 
                                ?>

                            <li>
                                <input type="hidden" name="<?php echo $namefield; ?>[]" value="<?php echo $value; ?>">
                                <img class="image-preview" src="<?php echo $image[0]; ?>">
                                <a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Cambia immagine</a><br><br>
                                <small><a class="remove-image button button-small" href="#">Elimina immagine</a></small>
                            </li>

                            <?php endforeach; endif; endif; ?>
                            </ul>

                        </td></tr>
                    </table>

                    <?php
                    
                }
                if($field['type'] == 'checkbox_post'){
                    // How to use 'get_post_meta()' for multiple checkboxes as array?
                    
                    $postmeta = maybe_unserialize( $valuefield );

                    // Our associative array here. id = value
                    $get_posts = get_posts(array('post_type' => $field['checkbox_post'], 'posts_per_page' => -1,));
                    ?>
                    <div class="components-base-control">
                        <strong><?php echo $field['namefield']; ?></strong>
                        <?php
                        foreach ($get_posts as $get_post){ 
                            if ( is_array( $postmeta ) && in_array( $get_post->ID, $postmeta ) ) {
                                $checked = 'checked="checked"';
                            } else {
                                $checked = null;
                            }
                            ?>
                                <div class="components-base-control__field">
                                    <?php
                                    printf(
                                        '<label class="rwp-checkbox-label"><input %s id="%s" name="%s" value="%s" type="checkbox">%s</label>',
                                        $checked,
                                        'get_post_'.$get_post->ID, 
                                        $namefield.'[]',
                                        $get_post->ID,
                                        get_the_title($get_post)
                                    );
                                    ?>
                                </div>
                            <?php
                        }?>
                    </div>
                <?php
                }

            }
        }
    }

    public function metabox_easyparent_save( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        $custombox_group = get_option( 'bc_settings_cf' )['custom_field_group'];

        if(isset($custombox_group) && is_array($custombox_group)) {
            foreach($custombox_group as $narray => $v ){

                if((isset($_POST['post_type']) && isset($v['typepost']) && in_array($_POST['post_type'], $v['typepost']) || isset($v['select_posts']) && in_array($post_id,$v['select_posts']))){
                
                    if ( ! isset( $_POST[sanitize_title($v['namegroup']).'_nonce'] ) || ! wp_verify_nonce( $_POST[sanitize_title($v['namegroup']).'_nonce'], '_'.sanitize_title($v['namegroup']).'_nonce' ) ) return;
                    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
                    if(isset($v['field']) && is_array($v['field'])) {
                        foreach($v['field'] as $narray2 => $v2 ){
                            $field = $v2;
                            $valuepost = $_POST[sanitize_title($v['namegroup']) . '_' . sanitize_title($field['namefield'])];
                            if(isset($valuepost)){
                                if(!is_array($valuepost)){
                                    $valuepost = esc_attr($valuepost); 
                                }
                            }else{
                                delete_post_meta($post_id, sanitize_title($v['namegroup']) . '_' . sanitize_title($field['namefield']));
                            }
                            update_post_meta( $post_id, sanitize_title($v['namegroup']) . '_' . sanitize_title($field['namefield']), $valuepost );
                        }
                    }
                }
                
            }
        }
    }

    public function edit_form_after_title() {
        // get globals vars
        global $post, $wp_meta_boxes;
    
        do_meta_boxes( get_current_screen(), 'after_title', $post );
    
        // unset 'ai_after_title' context from the post's meta boxes
        unset( $wp_meta_boxes['post']['after_title'] );
    }
    

    public function cusotm_calendar_admin_footer() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.datetimepicker').datetimepicker({
                i18n:{
                en:{
                months:[
                    'Gennaio','Febbraio','Marzo','Aprile',
                    'Maggio','Giugno','Luglio','Agosto',
                    'Settembre','Ottobre','Novembre','Dicembre',
                ],
                dayOfWeek:[
                    "Do", "Lu", "Ma", "Me", 
                    "Gio", "Ve", "Sa",
                ]
                }
                },
                timepicker:false,
                format:'d/m/Y'
                });
            });
        </script>
        <?php
    }

}
$bc_custom_post_type = new BcCustomFieldCreate();