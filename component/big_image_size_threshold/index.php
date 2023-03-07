<?php
/**
 * ID: big_image_size_threshold
 * Name: Image size threshold
 * Description: Modifica soglia massima risoluzione upload immagine
 * Icon: dashicons-upload
 * Version: 1.0
 * 
 */


 
// completely disable image size threshold
add_filter( 'big_image_size_threshold', '__return_false' );

// increase the image size threshold
function bcomponent_upload_big_image_size_threshold( $threshold ) {
	return 6000; // new threshold
}
add_filter('big_image_size_threshold', 'bcomponent_upload_big_image_size_threshold', 999, 1);
