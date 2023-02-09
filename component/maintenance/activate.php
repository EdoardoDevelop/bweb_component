<?php
$newpostId = 0;
$page = get_page_by_path( 'sito-in-manutenzione' , OBJECT );
if ( !isset($page) ){
    $new_page = array(
        'post_title' => __( 'Sito in manutenzione' ),
        'post_name' => 'sito-in-manutenzione',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'page',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_content' => '
        <!-- wp:cover {"url":"https://s.w.org/images/core/5.8/forest.jpg","dimRatio":60,"minHeight":100,"minHeightUnit":"vh","align":"full"} -->
        <div class="wp-block-cover alignfull" style="min-height:100vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="https://s.w.org/images/core/5.8/forest.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","align":"wide","style":{"color":{"text":"#ffe074"},"typography":{"fontSize":"64px"}}} -->
        <h2 class="alignwide has-text-align-center has-text-color" style="color:#ffe074;font-size:64px">SITO IN MANUTENZIONE</h2>
        <!-- /wp:heading --></div></div>
        <!-- /wp:cover -->
        ',
        'menu_order' => 0,
        // Assign page template
        'page_template' => plugin_dir_path( __FILE__ ).'inc/template/template.php'
    );
    
    // insert the post into the database
    $newpostId = wp_insert_post( $new_page );
}else{
    $newpostId = $page->ID;
}
update_option('bc_maintenance_page',$newpostId);