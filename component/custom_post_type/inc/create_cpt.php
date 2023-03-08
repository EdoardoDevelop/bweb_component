<?php


class BcCustomPostTypeCreate {
    private $custompost;

	public function __construct() {
        if(isset(get_option( 'bc_settings_cpt' )['custom-post-type'])){
            $this->custompost = get_option( 'bc_settings_cpt' )['custom-post-type'];
            add_action( 'init', array($this,'dynamic_custom_post_type') );
            add_filter('post_type_link', array($this,'_permalink_structure'), 10, 3);
            //add_action( 'parse_request', array($this, '_parse_taxonomy_root_request' ));
            //add_action('template_redirect', array($this,'_post_type_redirect'));

            
            add_action('restrict_manage_posts',array($this,'dropdown_filter_by_tax'));
            add_filter('parse_query',array($this,'filter_taxonomy_term_in_query'));
        }
    }


    // Register Custom Post Type
    function dynamic_custom_post_type() {
        $custompost = $this->custompost;
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
                    'slug'                  => $slug.'/%tax%',
                    'with_front'            => true,
                    'pages'                 => true,
                    'feeds'                 => true,
                );
                $taxArr = array();
                if(isset($v['tax']) && is_array($v['tax'])) {
                    foreach($v['tax'] as $narraycustompost2 => $v2 ){
                        array_push($taxArr,$slug.'-'.sanitize_title($v2['name']) );
                    }
                }
                $args = array(
                    'label'                 => $v['name'],
                    'description'           => '',
                    'labels'                => $labels,
                    'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                    'taxonomies'            => $taxArr,
                    'hierarchical'          => true,
                    'public'                => true,
                    'show_ui'               => true,
                    'show_in_menu'          => true,
                    'menu_position'         => 5,
                    'menu_icon'             => $menuicon,
                    'show_in_admin_bar'     => true,
                    'show_in_nav_menus'     => true,
                    'can_export'            => true,
                    'has_archive'           => $slug,
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
                        $show_admin_column = true;
                        if($v2['type']=='tag'){
                            $hierarchical = false;
                            $show_admin_column = false;
                        }
                        $argsTax = array(
                            'labels' => $labelsTax,
                            'hierarchical' => $hierarchical,
                            'query_var' => true,
                            'rewrite' => array(
                                'slug'          => $slug.'/'.sanitize_title($v2['name']),
                                'hierarchical'  => $hierarchical,
                                'with_front'    => true
                            ),
                            'show_admin_column' => $show_admin_column,
                            'show_in_rest' => true,
                            //'meta_box_sanitize_cb' => array($this, '_rewrite_rule')
                        );
                    
                        register_taxonomy( $slug.'-'.sanitize_title($v2['name']), $slug, $argsTax );
                        

                        /*add_rewrite_rule(
                            '^'.$slug.'/'.sanitize_title($v2['name']).'/?$',
                            'index.php?post_type='.$slug.'&taxonomy='.sanitize_title($v2['name']),
                            'top'
                        );*/


                        $this->rules_custom_taxonomy($slug,$slug.'-'.sanitize_title($v2['name']));
                        add_action( "created_".$slug.'-'.sanitize_title($v2['name']), array($this, '_rewrite_rule'), 10, 2 );
                        add_action( "edited_".$slug.'-'.sanitize_title($v2['name']), array($this, '_rewrite_rule'), 10, 2 );

                    }
                }
                
                
                add_rewrite_rule(
                    '^'.$slug.'/(.*)/?$',
                    'index.php?post_type='.$slug.'&name=$matches[1]',
                    'top'
                );
            }
        }
    
    }
    public function dropdown_filter_by_tax(){
        global $typenow;
	    global $wp_query;
        $custompost = $this->custompost;
        if(isset($custompost) && is_array($custompost)) {
            foreach($custompost as $narraycustompost => $v ){

                if ($typenow==sanitize_title($v['name'])) {
                    if(isset($v['tax']) && is_array($v['tax'])) {
                        foreach($v['tax'] as $narraycustompost2 => $v2 ){
                            if($v2['type']!='tag'){
                                $taxonomy = sanitize_title($v['name']).'-'.sanitize_title($v2['name']);
                                $business_taxonomy = get_taxonomy($taxonomy);
                                wp_dropdown_categories(array(
                                    'show_option_all' =>  __("Visualizza tutto {$business_taxonomy->label}"),
                                    'taxonomy'        =>  $taxonomy,
                                    'name'            =>  $taxonomy,
                                    'orderby'         =>  'name',
                                    'selected'        =>  (isset($wp_query->query[$taxonomy])?$wp_query->query[$taxonomy]:''),
                                    'hierarchical'    =>  false,
                                    'depth'           =>  3,
                                    'show_count'      =>  false,  // This will give a view
                                    'hide_empty'      =>  true,   // This will give false positives, i.e. one's not empty related to the other terms. TODO: Fix that
                                ));
                            }
                        }
                    }

                }
            }
        }


    }
    public function filter_taxonomy_term_in_query($query) {
        global $pagenow;
        $q_vars    = &$query->query_vars;
        
        $custompost = $this->custompost;
        if(isset($custompost) && is_array($custompost)) {
            foreach($custompost as $narraycustompost => $v ){
                if(isset($v['tax']) && is_array($v['tax'])) {
                    foreach($v['tax'] as $narraycustompost2 => $v2 ){
                        $post_type = sanitize_title($v['name']);
                        $taxonomy = $post_type.'-'.sanitize_title($v2['name']);
                        

                        if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
                            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
                            $q_vars[$taxonomy] = $term->slug;
                        }
                    }
                }
            }
        }
    }

    public function rules_custom_taxonomy($slug,$taxonomy){
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);
        foreach ($terms as $term){
            add_rewrite_rule(
                '^'.$slug.'/'.$term->slug.'/(.*)/?$',
                'index.php?post_type='.$slug.'&name=$matches[1]',
                'top'
            );
            add_rewrite_rule(
                '^'.$slug.'/'.str_replace($slug.'-','',$term->taxonomy).'/'.$term->slug.'/?$',
                'index.php?post_type='.$slug.'&'.$term->taxonomy.'='.$term->slug,
                'top'
            );
            

        }
        
        //print_r('^'.$slug.'/'.str_replace($slug.'-','',$taxonomy).'/?$');
    }
    public function _rewrite_rule(){
        flush_rewrite_rules();
    }
    
    public function _parse_taxonomy_root_request( $wp ) {
        $tax_name      = $wp->query_vars['post_type'].'-'.$wp->query_vars['taxonomy'];
      
        // Bail out if no taxonomy QV was present, or if the term QV is.
        if( empty( $tax_name ) || isset( $wp->query_vars['term'] ) ){
            return;
        }
        
        $tax           = get_taxonomy( $tax_name );
        $tax_query_var = $tax->query_var;
      
        // Bail out if a tax-specific qv for the specific taxonomy is present.
        if( isset( $wp->query_vars[ $tax_query_var ] ) ){
            return;
        }
        
        $tax_term_slugs = get_terms(
          [
            'taxonomy' => $tax_name,
            'fields'   => 'slugs'
          ]
        );
      
        print_r($tax_query_var);
        // Unlike "taxonomy"/"term" QVs, tax-specific QVs can specify an AND/OR list of terms.
        $wp->set_query_var( $tax_query_var, implode( ',', $tax_term_slugs ) );
    }

    public function _permalink_structure($post_link, $id = 0) {
        $custompost = $this->custompost;
        $post = get_post($id);
        
        if(isset($custompost) && is_array($custompost)) {
        
            foreach($custompost as $narraycustompost => $v ){
                if ( is_object( $post ) && $post->post_type == sanitize_title($v['name']) ){
                    
                    if(isset($v['tax']) && is_array($v['tax'])) {
                        foreach($v['tax'] as $narraycustompost2 => $v2 ){
                            if($v2['type']!='tag'){
                                if (false !== strpos($post_link, '%tax%')) {
                                    $type_term = get_the_terms( $post->ID, sanitize_title($v['name']).'-'.sanitize_title($v2['name']) );
                                    
                                    if (!empty($type_term)){
                                        $post_link = str_replace('%tax%', array_pop($type_term)->slug, $post_link);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $post_link =  str_replace('/%tax%', '', $post_link);
        return $post_link;
    }
    
    public function _post_type_redirect() {
        $custompost = $this->custompost;
        if(isset($custompost) && is_array($custompost)) {
        
            foreach($custompost as $narraycustompost => $v ){
                
                global $post, $wp_rewrite;
                if( get_post_type( $post->ID ) == sanitize_title($v['name'])){
                    if (is_single($post->ID)) {


                        global $wp;
echo $wp->matched_query;
                        //wp_redirect( site_url(), 301);
                        //exit();
                    }                        
                }
                    
            
                        
                        //wp_redirect( site_url() . '/' . $wp_rewrite->front . '/' . $terms[0]->slug . '/' . $post->post_name, 301 );
                        // wp_redirect( get_permalink( $post->ID ), 301 ); // depends on the previous code from this post
            
                        //exit();
                
            }
        }
    
    }

}
$bc_custom_post_type = new BcCustomPostTypeCreate();


?>