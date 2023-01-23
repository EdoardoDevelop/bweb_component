<?php
/**
 * ID: post_order
 * Name: Post Order
 * Description: Intuitively, Order Items( Posts, Pages, ,Custom Post Types, Custom Taxonomies, Sites ) using a Drag and Drop Sortable JavaScript.
 * Icon: dashicons-sort
 * 
 */
if (!defined("ABSPATH")) {
    exit; // Exit if accessed directly
}


define( 'BCPO_URL', plugins_url( '', __FILE__ ).'/inc' );
define( 'BCPO_DIR', plugin_dir_path( __FILE__ ).'inc/' );

require plugin_dir_path( __FILE__ ) ."inc/load.php";
