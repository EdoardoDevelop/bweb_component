<?php


class BcCustomPostTypeCreate {

	public function __construct() {
        if(isset(get_option( 'bc_settings_cpt' )['custom-post-type'])){
            add_action( 'init', array($this,'dynamic_custom_post_type') );
        }
    }


    // Register Custom Post Type
    function dynamic_custom_post_type() {
        $custompost = get_option( 'bc_settings_cpt' )['custom-post-type'];
        $menuicon = 'dashicons-admin-post';
        
        if(isset($custompost) && is_array($custompost)) {
        
            foreach($custompost as $narraycustompost => $v ){
        
                if($v['icon'] != ''){
                    $menuicon = $v['icon'];
                }
                
                $slug =  sanitize_title($v['name']);
        
                $labels = array(
                    'name'                  => $v['name'],
                    'singular_name'         => $v['name'],
                    'menu_name'             => $v['name'],
                    'name_admin_bar'        => $v['name'],
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
                    'not_found'             => __( 'Not found', 'easyParent' ),
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
                $rewrite = array(
                    'slug'                  => $slug,
                    'with_front'            => true,
                    'pages'                 => true,
                    'feeds'                 => true,
                );
                $args = array(
                    'label'                 => $v['name'],
                    'description'           => '',
                    'labels'                => $labels,
                    'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'post-formats', 'excerpt' ),
                    //'taxonomies'            => array( 'category', 'post_tag' ),
                    'hierarchical'          => false,
                    'public'                => true,
                    'show_ui'               => true,
                    'show_in_menu'          => true,
                    'menu_position'         => 5,
                    'menu_icon'             => $menuicon,
                    'show_in_admin_bar'     => true,
                    'show_in_nav_menus'     => true,
                    'can_export'            => true,
                    'has_archive'           => true,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'rewrite'               => $rewrite,
                    'capability_type'       => 'page',
                    'show_in_rest'          => filter_var($v['show_in_rest'], FILTER_VALIDATE_BOOLEAN),
                );
                register_post_type( $slug, $args );
                /* this adds your post categories to your custom post type */
                //register_taxonomy_for_object_type($slug.'-category', $slug);
                /* this adds your post tags to your custom post type */
                //register_taxonomy_for_object_type('post_tag', $slug);
        
                if(isset($v['tax']) && is_array($v['tax'])) {
                    foreach($v['tax'] as $narraycustompost2 => $v2 ){
                        $labelsTax = array(
                            'name'              => $v2['name'],
                            'singular_name'     => $v2['name'],
                            'search_items'      => 'Cerca',
                            'all_items'         => 'Tutti',
                            /*'parent_item'       => 'Parent Location',
                            'parent_item_colon' => 'Parent Location:',*/
                            'edit_item'         => 'Modifica',
                            'update_item'       => 'Aggiorna',
                            'add_new_item'      => 'Aggiungi nuovo',
                            'new_item_name'     => 'Nuovo nome',
                            'menu_name'         => $v2['name'],
                        );
                        $hierarchical = true;
                        if($v2['type']=='tag') $hierarchical = false;
                        $argsTax = array(
                            'labels' => $labelsTax,
                            'hierarchical' => $hierarchical,
                            'query_var' => 'true',
                            'rewrite' => 'true',
                            'show_admin_column' => 'true',
                            'show_in_rest' => true,
                        );
                    
                        register_taxonomy( $slug.'-'.sanitize_title($v2['name']), $slug, $argsTax );
                    }
                }
            }
        }
    
    }



}
$bc_custom_post_type = new BcCustomPostTypeCreate();




?>