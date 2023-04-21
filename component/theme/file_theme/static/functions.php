<?php


if ( ! function_exists( '!######!_theme_setup' ) ) :
    function !######!_theme_setup(){
        
    }
    add_action( 'after_setup_theme', '!######!_theme_setup' );
endif;

if ( ! function_exists( '!######!_enqueue' ) ) :
    add_action( 'wp_enqueue_scripts', '!######!_enqueue' );
    function !######!_enqueue() {
        //wp_enqueue_script( '!######!-front-script', get_template_directory_uri() . '/namefile.js', array( 'jquery' ),'', true );
		//wp_enqueue_style( '!######!-style', get_template_directory_uri().'/namefile.css');
   }
endif;