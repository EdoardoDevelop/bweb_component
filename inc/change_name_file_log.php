<?php
$date = date('Y-m-d');
 
$error_log_file = trailingslashit( WP_CONTENT_DIR ) . 'debug-' . $date . '.log';
 
ini_set('error_reporting', E_ERROR);
ini_set( 'error_log', $error_log_file );