<?php
/**
 * ID: minify
 * Name: Minify css/js
 * Description: minimizza automaticamente i file css e js
 * Icon: data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M21.71,20.29,15.41,14H17a1,1,0,0,0,0-2H13.41l5.66-5.66a1,1,0,1,0-1.41-1.41L12,10.59V7a1,1,0,0,0-2,0V8.59L3.71,2.29A1,1,0,0,0,2.29,3.71L8.59,10H7a1,1,0,0,0,0,2h3.59L4.93,17.66a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0L12,13.41V17a1,1,0,0,0,2,0V15.41l6.29,6.3a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29Z'/%3E%3C/svg%3E
 * Version: 1.0
 * 
 */

class bc_minify {
    

	public function __construct() {	
        add_action( 'wp_print_scripts', array( $this, 'load_minify_scripts') );
        add_action( 'wp_print_styles', array( $this, 'load_minify_styles') );
    }
    public function load_minify_scripts(){
        global $wp_scripts;
        $head_items = $wp_scripts->do_head_items();
        if(!function_exists('get_admin_page_parent')){
            foreach( $wp_scripts->queue as $script ) :
                if(empty($wp_scripts->registered[$script]->src)){
                    wp_dequeue_script( $wp_scripts->registered[$script]->handle );
                    wp_enqueue_script( $wp_scripts->registered[$script]->handle );
                }else{
                    wp_dequeue_script( $wp_scripts->registered[$script]->handle );
                    wp_enqueue_script( 
                        $wp_scripts->registered[$script]->handle.'-minify', 
                        plugin_dir_url( PLUGIN_FILE_URL ) . 'component/minify/out_js.php?handle='.$wp_scripts->registered[$script]->handle.'&file='.base64_encode($wp_scripts->registered[$script]->src), $wp_scripts->registered[$script]->deps,
                        '', !in_array($wp_scripts->registered[$script]->handle, $head_items)
                    );
                    
                }
            
            endforeach;
        }
        
        
    }
    
    public function load_minify_styles(){
        global $wp_styles;
        if(!function_exists('get_admin_page_parent')){
            foreach( $wp_styles->queue as $style ) :
                if(empty($wp_styles->registered[$style]->src)){
                    wp_dequeue_style( $wp_styles->registered[$style]->handle );
                    wp_enqueue_style( $wp_styles->registered[$style]->handle );
                }else{
                    wp_dequeue_style( $wp_styles->registered[$style]->handle );
                    wp_enqueue_style( 
                        $wp_styles->registered[$style]->handle.'-minify', 
                        plugin_dir_url( PLUGIN_FILE_URL ) . 'component/minify/out_css.php?handle='.$wp_styles->registered[$style]->handle.'&file='.base64_encode($wp_styles->registered[$style]->src), $wp_styles->registered[$style]->deps
                    );
                }
            endforeach;
            
        }
    }

}
New bc_minify();