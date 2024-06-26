<?php
class BwebActiveComponent {
	private $bweb_component_settings_options;

	public function __construct() {	
        $this->bweb_component_settings_options = get_option( 'bweb_component_active' );
    }

    public function load_setting_page(){
        
        if ( is_array( $this->bweb_component_settings_options ) ) {
            foreach ($this->bweb_component_settings_options as $foldername){
                if(file_exists(DIR_COMPONENT. $foldername . '/index.php')){
                    require DIR_COMPONENT. $foldername . '/index.php';
                }
            }
        }
        
        if( is_array(get_option( '_component_compare' )) && is_array($this->bweb_component_settings_options) ){
            $c_activate = array_diff($this->bweb_component_settings_options,get_option( '_component_compare' ));
            $c_deactivate = array_diff(get_option( '_component_compare' ),$this->bweb_component_settings_options);

            foreach ($c_activate as $foldername){
                $_a = DIR_COMPONENT. $foldername . '/activate.php';
                //print_r($_a);
                if(file_exists($_a)){
                    require $_a;
                }
            }
            foreach ($c_deactivate as $foldername){
                $_d = DIR_COMPONENT. $foldername . '/deactivate.php';
                //print_r($_d);
                if(file_exists($_d)){
                    require $_d;
                }
            }


            update_option( '_component_compare', $this->bweb_component_settings_options );
            //$_component_compare = $this->bweb_component_settings_options;
        }

        
        /**********CUSTOM SCRIPT INTO THEME */
        foreach (glob(get_template_directory() ."/component/*.php") as $filename){
            require $filename;
        }

    }



}
$BwebActiveComponent = new BwebActiveComponent();
$BwebActiveComponent->load_setting_page();





