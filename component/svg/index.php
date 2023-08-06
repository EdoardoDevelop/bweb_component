<?php
/**
 * ID: svg
 * Name: WP SVG
 * Description: Abilita il supporto SVG.
 * Icon: dashicons-smiley
 * Version: 1.0
 * 
 */
class BCsvg {

	public function __construct() {	
        add_filter( 'wp_check_filetype_and_ext', array($this, 'check_filetype'), 10, 4 );
        add_filter( 'upload_mimes', array($this, 'cc_mime_types') );
        add_action( 'admin_head', array($this, 'fix_svg') );
    }
    public function check_filetype($data, $file, $filename, $mimes){
        global $wp_version;
        if ( $wp_version !== '4.7.1' ) {
           return $data;
        }
      
        $filetype = wp_check_filetype( $filename, $mimes );
      
        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];
    }
    public function cc_mime_types( $mimes ){
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    public function fix_svg() {
        echo '<style type="text/css">
              .attachment-266x266, .thumbnail img {
                   width: 100% !important;
                   height: auto !important;
              }
              </style>';
      }
}

new BCsvg();