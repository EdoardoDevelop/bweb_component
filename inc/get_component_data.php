<?php
class BCdatacomponent {

	public function __construct() {	

    }
    public function get_component_data( $file, $argsGit = [] ) {
        $file_data = "";
        if (str_starts_with( $file, 'http' ) ) {
            $file_data = wp_remote_retrieve_body( wp_remote_get( $file, $argsGit ) );
        }else{
            $fp = fopen( $file, 'r' );
            $file_data = fread( $fp, 8192 );
            fclose( $fp );
        }
        
        $file_data = str_replace( "\r", "\n", $file_data );
        $all_headers = array(
            'ID'        => 'ID',
            'Name'        => 'Name',
            'Description' => 'Description',
            'Icon' => 'Icon',
			'Autoload' => 'Autoload',
			'Version' => 'Version'
        );
        foreach ( $all_headers as $field => $regex ) {
            if (preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) 
                && $match[1])
                $all_headers[ $field ] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
            else
                $all_headers[ $field ] = '';
        }

        return $all_headers;
    }

}
//$BCdatacomponent = new BCdatacomponent();
