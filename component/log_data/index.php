<?php
/**
 * ID: log_data 
 * Name: Date on name file log
 * Description: 
 * Icon: dashicons-warning
 * Version: 1.0
 * 
 */

$date = date('Y-m-d');
 
$error_log_file = trailingslashit( WP_CONTENT_DIR ) . 'debug-' . $date . '.log';
 
ini_set('error_reporting', E_ERROR);
ini_set( 'error_log', $error_log_file );