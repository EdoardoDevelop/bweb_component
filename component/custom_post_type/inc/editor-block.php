<?php



class BcCptBlock {
	private $custom_field;

    public function __construct() {
        
        add_action( 'init', array($this, 'bc_cpt_gutenberg_block' ));
        add_action( 'enqueue_block_editor_assets', array($this, 'bc_cpt_gutenberg_block_assets' ));
    }

    public function bc_cpt_gutenberg_block() {
        // Skip block registration if Gutenberg is not enabled/merged.
        if (!function_exists('register_block_type')) {
            return;
        }

        $args_custom_post_types = array(
			'public' => true,
			'_builtin' => false
		);
		$custom_post_types = get_post_types( $args_custom_post_types, 'objects' );

        $this->custom_field = [];
        if(get_option( 'bc_settings_cf' ) !== null) {
            if(isset(get_option( 'bc_settings_cf' )['custom_field_group']) && is_array(get_option( 'bc_settings_cf' )['custom_field_group'])) {
                $this->custom_field = get_option( 'bc_settings_cf' )['custom_field_group'];
            }
        }
        
        //wp_register_script( 'cpt-gutenberg-server-side-render-x', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_post_type/inc/server-side-render-x.js');
        wp_register_script( 'cpt-gutenberg-block', plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_post_type/inc/cpt-block.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components','wp-server-side-render' ) );
        wp_localize_script( 'cpt-gutenberg-block', 'cpt', $custom_post_types );
        wp_localize_script( 'cpt-gutenberg-block', 'cf', $this->custom_field );
        wp_localize_script( 'cpt-gutenberg-block', 'imagesize', wp_get_registered_image_subsizes() );
        register_block_type('bc/cpt-block', array(
            'api_version'     => 2,
            'editor_script' => 'cpt-gutenberg-block',
            'render_callback' => array($this,'bc_render_cpt_block'),
            'skip_inner_blocks' => true,
            'attributes'  => array(
                'slug_cpt' => array(
                    'type' => 'string',
                    'default' => '---'
                ),
                'link_card' => array(
                    'type' => 'string'
                ),
                'n_card' => array(
                    'type' => 'number',
                    'default' => 3
                ),
                'n_column' => array(
                    'type' => 'number',
                    'default' => 3
                ),
                's_chk_field' => array(
                    'type' => 'string'
                ),
                'c_field_1' => array(
                    'type' => 'string'
                ),
                'c_field_2' => array(
                    'type' => 'string'
                ),
                'c_field_3' => array(
                    'type' => 'string'
                ),
                'el_title' => array(
                    'type' => 'string',
                    'default' => 'h2'
                ),
                'isImageShow' => array(
                    'type' => 'boolean',
                    'default' => 1
                ),
                'imgSize' => array(
                    'type' => 'string',
                    'default' => 'medium'
                ),
                'isTextShow' => array(
                    'type' => 'boolean',
                    'default' => 1
                ),
                'typeText' => array(
                    'type' => 'string',
                    'default' => 'excerpt'
                ),
                'isButtonShow' => array(
                    'type' => 'boolean',
                    'default' => 0
                ),
                'textButton' => array(
                    'type' => 'string',
                    'default' => 'Continua a leggere'
                )
            ),
        ));
    }

    public function bc_cpt_gutenberg_block_assets(){
        wp_enqueue_style(
            'cpt-block-css',
            plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_post_type/assets/cpt-block.css',
            array( 'wp-edit-blocks' ),
            time()
        );
        wp_enqueue_style(
            'cpt-block-bootstrap-grid-css',
            plugin_dir_url( PLUGIN_FILE_URL ).'component/custom_post_type/assets/bootstrap-grid.min.css',
            array( 'wp-edit-blocks' ),
            time()
        );
    }

    public function bc_render_cpt_block($atts){
        return $this->get_html($atts);
    }
    public function get_html($atts){
        $html = '';
        $is_editor = false;
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
            $is_editor = true;
        }
        
        $n = '-'. 12/$atts[ 'n_column' ];
        $onclik = '';
        if ( $is_editor ){
            $onclik = 'onclick="return false;"';
        }

        if(isset($atts[ 'slug_cpt' ]) && $atts[ 'slug_cpt' ] == '---'){
            if ( $is_editor ) {
                $html = 'Seleziona un custom post type';
            }
        }else{

            $args = array(
                'post_type'        => $atts[ 'slug_cpt' ],
                'post_status' => 'publish',
                'posts_per_page' => $atts[ 'n_card' ]
                );

            if(isset($atts[ 's_chk_field' ]) && $atts[ 's_chk_field' ] != '---'){
                $args['meta_query'] = array( array(
                    'key' => sanitize_title($atts[ 's_chk_field' ]),
                    'value' => 'true',
                    'compare' => '=='
                ));
            }
            $cpt_loop = new WP_Query( $args );
            if ($cpt_loop -> have_posts()) :
                $html .= '<div class="row card-home">';
                while($cpt_loop -> have_posts()) : $cpt_loop -> the_post();
                    $post_id = get_the_ID();
                    $el_card = 'div';
                    if(isset($atts[ 'link_card' ]) && $atts[ 'link_card' ] == 'post'){
                        
                        if ( $is_editor ) {
                            $el_card = 'div';
                            $html .= '<'.$el_card.'';
                        }else{
                            $el_card = 'a';
                            $html .= '<'.$el_card.' href="'.esc_url( get_permalink( $post_id ) ).'" '.$onclik;
                        }
                    }else{
                        $html .= '<'.$el_card.'';
                    }
                    
                    $html .= ' class="col-md'.$n.' card-home-item"><div class="card-home-item-cont">';
                    if(isset($atts[ 'c_field_1' ]) && $atts[ 'c_field_1' ] != '---'){
                        $html .= $this->get_val_custom_filed($post_id, $atts[ 'c_field_1' ]);
                    }
                    if(isset($atts[ 'isImageShow' ]) && $atts[ 'isImageShow' ]){
                        if( has_post_thumbnail($post_id) ) {
                        $html .= '<div class="image_card"><img src="'.wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $atts[ 'imgSize' ])[0].'" class="card-home-img" ></div>';
                        }
                    }
                    $title_link = '';
                    if( $atts[ 'el_title' ] == 'a' ){
                        $title_link = 'href="'.esc_url( get_permalink( $post_id ) ).'"'; 
                    }
                    $html .= '<'.$atts[ 'el_title' ].' '.$title_link.' '.$onclik.' class="title">'.esc_html( get_the_title( $post_id ) ).'</'.$atts[ 'el_title' ].'>';
                    if(isset($atts[ 'c_field_2' ]) && $atts[ 'c_field_2' ] != '---'){
                        $html .= $this->get_val_custom_filed($post_id, $atts[ 'c_field_2' ]);
                    }
                    if(isset($atts[ 'isTextShow' ]) && $atts[ 'isTextShow' ]){
                        if(isset($atts[ 'typeText' ]) && $atts[ 'typeText' ]=='excerpt'){
                            $html .= '<p>'.get_the_excerpt().'</p>';
                        }else{
                            $html .= '<p>'.get_the_content().'</p>';
                        }
                    }
                    if(isset($atts[ 'c_field_3' ]) && $atts[ 'c_field_3' ] != '---'){
                        $html .= $this->get_val_custom_filed($post_id, $atts[ 'c_field_3' ]);
                    }
                    if(isset($atts[ 'isButtonShow' ]) && $atts[ 'isButtonShow' ]){
                        $html .= '<a href="'.esc_url( get_permalink( $post_id ) ).'" '.$onclik.' class="btn btn_card">'.$atts[ 'textButton' ].'</a>';
                    }
                    
                        $html .= '</div></'.$el_card.'>';
                    
                endwhile; 
                $html .= '</div>';
                wp_reset_query();
                wp_reset_postdata();
            else:
                if ( $is_editor ) {
                    $html = 'Le impostazioni non hanno prodotto risultati';
                }
            endif;
        }
        
        return $html;
    }

    public function get_val_custom_filed($post_id, $c_field){
        $html = '';
        foreach($this->custom_field as $narray => $v ){
            foreach($v['field'] as $field ){
                $namefield = sanitize_title($v['namegroup']) . '_' . sanitize_title($field['namefield']);
                if($namefield == $c_field){
                    if($field['type'] == 'text'){
                        $html .= '<span>'.get_post_meta( $post_id, $namefield, true ).'</span>';
                    }
                    if($field['type'] == 'textarea'){
                        $html .= '<div>'.html_entity_decode(get_post_meta( $post_id, $namefield, true )).'</siv>';
                    }
                    if($field['type'] == 'checkbox'){
                        $html .= '<span class="chk_field_post '.$namefield.'">'.$field['namefield'].': '.get_post_meta( $post_id, $namefield, true ).'</span>';
                    }
                    if($field['type'] == 'calendario'){
                        $post_field = get_post_meta( $post_id, $namefield, true );

                        $dateD = date(" j", strtotime($post_field));
                        $dateM = date(" M", strtotime($post_field));
                        $dateY = date(" Y", strtotime($post_field));
                        $html .= '<span class="date_card">'.$post_field.'</span>';
                    }
                    if($field['type'] == 'editor'){
                        $html .= '<div>'.html_entity_decode(get_post_meta( $post_id, $namefield, true )).'</div>';
                    }
                    if($field['type'] == 'allegato'){
                        $post_field = get_post_meta( $post_id, $namefield, true );
                        if(isset($post_field) && is_array($post_field)):
                            for( $i = 0; $i < count( $post_field ); $i++ ):
                                $file_documenti = $post_field[$i];
                                $ext = substr($file_documenti, -4);
                                $arrtype = explode("/", $file_documenti);
                                $arrtype_more = explode(".", $arrtype[count($arrtype)-1]);
                                if(is_array($arrtype_more)) {
                                    $arrtype = $arrtype_more;
                                }
                                $type = "file";
                                if(is_array($arrtype)){
                                    $type = $arrtype[count($arrtype)-1];
                                }
                                $ptitle = str_replace("-", " ", basename($file_documenti, $ext));
                                $ptitle = str_replace("_", " ", $ptitle);
                                echo '<a target="_blank" href="'.$file_documenti.'">'.$ptitle.'</a>';
                            endfor;
                          endif;
                    }
                    if($field['type'] == 'checkbox_post'){
                        $post_field = get_post_meta( $post_id, $namefield, true );
                        if(isset($post_field) && is_array($post_field)):
                            $html .= '<div>';
                            for( $i = 0; $i < count( $post_field ); $i++ ):
                                $ID = $post_field[$i];
                                $html .= '<a href="'.esc_url( get_permalink( $ID ) ).'">'.get_the_title($ID).'</a>';
                                if($i < count( $post_field )){
                                    $html .= ' <span class="checkbox_post_separator">-</span> ';
                                }
                            endfor;
                            $html .= '</div>';
                        endif;
                    }
                }

            }
        }

        return $html;
    }


}
$BcCptBlock = new BcCptBlock();

