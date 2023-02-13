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
        $this->bc_duplicate_post_options = get_option( 'bc_settings_bcdp' )['post']; 
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
			'bc_settings_bcdp', // option_name
			array( $this, 'bc_duplicate_post_sanitize' ) // sanitize_callback
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
                            <label style="margin-right: 20px;"><input type="checkbox" name="bc_settings_bcdp[post][]" value="<?php echo $post_type->name; ?>" <?php if ( isset( $this->bc_duplicate_post_options ) && is_array( $this->bc_duplicate_post_options ) ) { if ( in_array( $post_type->name, $this->bc_duplicate_post_options ) ) { echo 'checked="checked"'; } } ?>>&nbsp;<?php echo $post_type->label; ?></label>
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

    public function bc_duplicate_post_sanitize($input) {
		$sanitary_values = array();
        if ( isset( $input['post'] ) ) {
			$sanitary_values['post'] =  $input['post'];
        }
		return $sanitary_values;
	}


    public function bc_duplicate_post_link( $actions, $post ) {

        if( ! current_user_can( 'edit_posts' ) ) {
            return $actions;
        }

        $post_options = get_option( 'bc_settings_bcdp' );
        if ( isset( $post_options ) && is_array( $post_options['post'] ) ) { 
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
            // wp_safe_redirect(
            // 	add_query_arg(
            // 		array(
            // 			'action' => 'edit',
            // 			'post' => $new_post_id
            // 		),
            // 		admin_url( 'post.php' )
            // 	)
            // );
            // exit;
            // or we can redirect to all posts with a message
            wp_safe_redirect(
                add_query_arg(
                    array(
                        'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
                        'saved' => 'post_duplication_created' // just a custom slug here
                    ),
                    admin_url( 'edit.php' )
                )
            );
            exit;
    
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


}
if ( is_admin() ):
	new bc_duplicate_post();
endif;