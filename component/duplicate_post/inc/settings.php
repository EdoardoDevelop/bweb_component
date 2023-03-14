<?php

class bc_duplicate_post{
    private $bc_duplicate_post_options;

    function __construct(){
        add_action( 'admin_menu', array( $this, 'bc_duplicate_post_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bc_duplicate_post_page_init' ) );

        add_filter( 'post_row_actions',  array( $this, 'bc_duplicate_post_link'), 10, 2 );
        add_filter( 'page_row_actions',  array( $this, 'bc_duplicate_post_link'), 10, 2 );
        
        add_action( 'admin_action_bc_duplicate_post_as_draft', array( $this, 'bc_duplicate_post_as_draft' ));
        add_action( 'admin_notices', array( $this, 'bcdp_duplication_admin_notice' ));

        add_filter( 'display_post_states', array($this, 'bc_display_post_states'), 10, 2 );

        add_action( 'manage_posts_extra_tablenav', array($this, 'top_form_edit') );
        add_filter('pre_get_posts', array($this, 'remove_post_list_table'));

        $this->bc_duplicate_post_options = get_option( 'bc_settings_bcdp' ); 
    }
    public function bc_duplicate_post_add_plugin_page(){
        add_submenu_page(
            'bweb-component',
			'Duplicate post/page', // page_title
			'Duplicate post/page', // menu_title
			'manage_options', // capability
			'duplicate_post', // menu_slug
			array( $this, 'duplicate_post_create_admin_page' ) // function
		);
    }
    public function duplicate_post_create_admin_page(){
        ?>

        <div class="wrap">

            <h2 class="wp-heading-inline"><?php _e( 'Duplicate post/page Settings', 'bcdp' ); ?></h2>

            <form method="post" action="options.php">
                <?php
                    settings_fields( 'bc_duplicate_post_option_group' );
                    do_settings_sections( 'bc-duplicate-post-admin' );
                    submit_button();
                ?>
            </form>

        </div>

        
        <?php
    }
    
    public function bc_duplicate_post_page_init(){
        register_setting(
			'bc_duplicate_post_option_group', // option_group
			'bc_settings_bcdp'
		);

		add_settings_section(
			'bc_duplicate_post_setting_section', // id
			'Settings', // title
			'', // callback
			'bc-duplicate-post-admin' // page
		);

		add_settings_field(
			'duplicate-post', // id
            '', // title
			array( $this, 'settings_bcdp_callback' ), // callback
			'bc-duplicate-post-admin', // page
			'bc_duplicate_post_setting_section' // section
		);
        add_settings_field(
            'select_page', // id
            'Template', // title
            array($this,'select_callback'), // callback
            'bc-duplicate-post-admin', // page
            'bc_duplicate_post_setting_section' // section
        );
    }

    public function settings_bcdp_callback(){
        //print_r(get_option( 'bc_settings_bcdp' ));
        ?>
        <div id="bcdp_select_objects" style="display: inline-block; border: 1px solid #ccc; padding: 0 20px 20px; background-color: #fff;">

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <td>
                        
                    <?php
                        $post_types = get_post_types( array (
                            'show_ui' => true,
                            'show_in_menu' => true,
                        ), 'objects' );
                        
                        foreach ( $post_types  as $post_type ) {
                            if ( $post_type->name == 'attachment' ) continue;
                            ?>
                            <label style="margin-right: 20px;"><input type="checkbox" name="bc_settings_bcdp[post][]" value="<?php echo $post_type->name; ?>" <?php if ( isset( $this->bc_duplicate_post_options['post'] ) && is_array( $this->bc_duplicate_post_options['post'] ) ) { if ( in_array( $post_type->name, $this->bc_duplicate_post_options['post'] ) ) { echo 'checked="checked"'; } } ?>>&nbsp;<?php echo $post_type->label; ?></label>
                            <?php
                        }
                    ?>
                        <br><br><hr>
                        <label><input type="checkbox" id="bcdp_allcheck_objects"> <?php _e( 'Seleziona tutto', 'bcdp' ) ?></label>
                    </td>
                </tr>
            </tbody>
        </table>

        </div>
        <script>
        (function($){
            
            $("#bcdp_allcheck_objects").on('click', function(){
                var items = $("#bcdp_select_objects input");
                if ( $(this).is(':checked') ) $(items).prop('checked', true);
                else $(items).prop('checked', false);	
            });

            $("#bcdp_allcheck_tags").on('click', function(){
                var items = $("#bcdp_select_tags input");
                if ( $(this).is(':checked') ) $(items).prop('checked', true);
                else $(items).prop('checked', false);	
            });
            
        })(jQuery)
        </script>
        <?php
    }


    public function bc_duplicate_post_link( $actions, $post ) {

        if( ! current_user_can( 'edit_posts' ) ) {
            return $actions;
        }

        $post_options = get_option( 'bc_settings_bcdp' );
        if ( isset( $post_options ) && isset( $post_options['post'] ) && is_array( $post_options['post'] ) ) { 
            if ( in_array( $post->post_type, $post_options['post'] ) ) {
    
                $url = wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'bc_duplicate_post_as_draft',
                            'post' => $post->ID,
                        ),
                        'admin.php'
                    ),
                    basename(__FILE__),
                    'duplicate_nonce'
                );
            
                $actions[ 'duplicate' ] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplica</a>';
            }
        }
    
        return $actions;
    }

    public function bc_duplicate_post_as_draft(){

        // check if post ID has been provided and action
        if ( empty( $_GET[ 'post' ] ) ) {
            wp_die( 'No post to duplicate has been provided!' );
        }
    
        // Nonce verification
        if ( ! isset( $_GET[ 'duplicate_nonce' ] ) || ! wp_verify_nonce( $_GET[ 'duplicate_nonce' ], basename( __FILE__ ) ) ) {
            return;
        }
    
        // Get the original post id
        $post_id = absint( $_GET[ 'post' ] );
    
        // And all the original post data then
        $post = get_post( $post_id );
    
        /*
         * if you don't want current user to be the new post author,
         * then change next couple of lines to this: $new_post_author = $post->post_author;
         */
        $current_user = wp_get_current_user();
        $new_post_author = $current_user->ID;
    
        // if post data exists (I am sure it is, but just in a case), create the post duplicate
        if ( $post ) {
    
            // new post data array
            $args = array(
                'comment_status' => $post->comment_status,
                'ping_status'    => $post->ping_status,
                'post_author'    => $new_post_author,
                'post_content'   => $post->post_content,
                'post_excerpt'   => $post->post_excerpt,
                'post_name'      => $post->post_name,
                'post_parent'    => $post->post_parent,
                'post_password'  => $post->post_password,
                'post_status'    => 'draft',
                'post_title'     => $post->post_title,
                'post_type'      => $post->post_type,
                'to_ping'        => $post->to_ping,
                'menu_order'     => $post->menu_order
            );
    
            // insert the post by wp_insert_post() function
            $new_post_id = wp_insert_post( $args );
    
            /*
             * get all current post terms ad set them to the new post draft
             */
            $taxonomies = get_object_taxonomies( get_post_type( $post ) ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
            if( $taxonomies ) {
                foreach ( $taxonomies as $taxonomy ) {
                    $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
                    wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
                }
            }
    
            // duplicate all post meta
            $post_meta = get_post_meta( $post_id );
            if( $post_meta ) {
    
                foreach ( $post_meta as $meta_key => $meta_values ) {
    
                    if( '_wp_old_slug' == $meta_key ) { // do nothing for this meta key
                        continue;
                    }
    
                    foreach ( $meta_values as $meta_value ) {
                        add_post_meta( $new_post_id, $meta_key, $meta_value );
                    }
                }
            }
    
            // finally, redirect to the edit post screen for the new draft
            wp_safe_redirect(
                add_query_arg(
                    array(
                        'action' => 'edit',
                        'post' => $new_post_id
                    ),
                    admin_url( 'post.php' )
                )
            );
            exit;
            // or we can redirect to all posts with a message
            /*wp_safe_redirect(
                add_query_arg(
                    array(
                        'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
                        'saved' => 'post_duplication_created' // just a custom slug here
                    ),
                    admin_url( 'edit.php' )
                )
            );
            exit;*/
    
        } else {
            wp_die( 'Post creation failed, could not find original post.' );
        }
    
    }

    public function bcdp_duplication_admin_notice() {

        // Get the current screen
        $screen = get_current_screen();
    
        if ( 'edit' !== $screen->base ) {
            return;
        }
    
        //Checks if settings updated
        if ( isset( $_GET[ 'saved' ] ) && 'post_duplication_created' == $_GET[ 'saved' ] ) {
    
             echo '<div class="notice notice-success is-dismissible"><p>Post copy created.</p></div>';
             
        }
    }

    public function select_callback(){
        $s = '';
        foreach (get_post_types(array( 'public' => true )) as $value) {
            $pt = get_post_type_object( $value );

            if($value == 'post'){
                $s .= '<label>';
                $s .= $pt->label.': <br>';
                $s .= $this->generate_post_select('bc_settings_bcdp[template_'.$value.']','template_'.$value, $value, $selected = $this->bc_duplicate_post_options['template_'.$value]);
                $s .= '</label>';
                if($this->bc_duplicate_post_options['template_'.$value]>0){
                    $s .= ' &mdash; <a class="edit_post" href="post.php?post='.$this->bc_duplicate_post_options['template_'.$value].'&action=edit">Modifica selezionato</a>';
                }
                $s .= '<br><br>';
                }
            if( $value !== 'post' && $value !== 'attachment'){
                $s .= '<label>';
                $s .= $pt->label.': <br>';
                $d = wp_dropdown_pages(
                    array(
                        'post_type'=>$value,
                        'post_status' => array('draft'),
                        'name' => 'bc_settings_bcdp[template_'.$value.']',
                        'id' => 'template_'.$value,
                        'echo'=>false,
                        'show_option_none'  => '&mdash; Seleziona &mdash;',
                        'option_none_value' => '0',
                        'selected'          => (isset($this->bc_duplicate_post_options['template_'.$value])?$this->bc_duplicate_post_options['template_'.$value]:''),
                    )
                );
                if(empty($d)){
                    $s .= '<select name="bc_settings_bcdp[template_'.$value.']" id="template_'.$value.'"><option value="0">&mdash; Seleziona &mdash;</option></select>';
                }else{
                    $s .= $d;
                }
                $s .= '</label>';
                if(isset($this->bc_duplicate_post_options['template_'.$value]) && $this->bc_duplicate_post_options['template_'.$value]>0){
                    $s .= ' &mdash; <a class="edit_post" href="post.php?post='.$this->bc_duplicate_post_options['template_'.$value].'&action=edit">Modifica selezionato</a>';
                }
                $s .= '<br><br>';
                }
        }
        echo $s;
        
        
	}
    public function generate_post_select($select_name, $select_id, $post_type, $selected = 0) {
        $post_type_object = get_post_type_object($post_type);
        $label = $post_type_object->label;
		$sel = '';
        $posts = get_posts(array('post_type'=> $post_type,'post_status' => array('draft'), 'suppress_filters' => false, 'posts_per_page'=>-1));
        $sel .= '<select name="'. $select_name .'" id="'.$select_id.'">';
        $sel .= '<option value="0">&mdash; Seleziona &mdash;</option>';
        foreach ($posts as $post) {
            $sel .= '<option value="'. $post->ID. '"'. ($selected == $post->ID ? ' selected="selected"' : ''). '>'. $post->post_title. '</option>';
        }
        $sel .= '</select>';
		return $sel;
    }

    public function top_form_edit( $views ) {
        if (!isset($this->bc_duplicate_post_options['template_'.get_current_screen()->post_type]) || (isset($this->bc_duplicate_post_options['template_'.get_current_screen()->post_type]) && $this->bc_duplicate_post_options['template_'.get_current_screen()->post_type] == 0)){
            return;
        }
        $url = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'bc_duplicate_post_as_draft',
                    'post' => $this->bc_duplicate_post_options['template_'.get_current_screen()->post_type],
                ),
                'admin.php'
            ),
            basename(__FILE__),
            'duplicate_nonce'
        );

        echo '<a class="button" href="'.$url.'">Aggiungi nuovo da template</a>';
    }

    public function bc_display_post_states( $states, $post ){
        if(isset($this->bc_duplicate_post_options['template_'.$post->post_type] )){
            if ( intval( $this->bc_duplicate_post_options['template_'.$post->post_type] ) === $post->ID ) {
                $states['bc_duplicate_page'] = __( 'Pagina template' );
            }
        }
    
        return $states;
    }
    
    public function remove_post_list_table($query) {
        global $pagenow;

        if( 'edit.php' != $pagenow || !$query->is_admin ) return $query;

        if(isset($this->bc_duplicate_post_options['template_'.$query->get('post_type')] )){
            $query->set( 'post__not_in', array( 
                $this->bc_duplicate_post_options['template_'.$query->get('post_type')] 
            ) );
        }

        return $query;
    }
}
if ( is_admin() ):
	new bc_duplicate_post();
endif;
