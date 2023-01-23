<?php


// completely disable image size threshold
add_filter( 'big_image_size_threshold', '__return_false' );

// increase the image size threshold to 6000px
function bcomponent_upload_big_image_size_threshold( $threshold ) {
	return 6000; // new threshold
}
add_filter('big_image_size_threshold', 'bcomponent_upload_big_image_size_threshold', 999, 1);


