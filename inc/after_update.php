<?php
class BwebComponentinstallactive {
    private $bweb_component_settings_options;

	public function __construct() {	
        $this->bweb_component_settings_options = get_option( 'bweb_component_active' );
    }

    public function load_setting_page(){
        
        if ( is_array( $this->bweb_component_settings_options ) ) {
            foreach ($this->bweb_component_settings_options as $component){
                
                if ( !file_exists( plugin_dir_path( PLUGIN_FILE_URL )."component" ) || !is_dir( plugin_dir_path( PLUGIN_FILE_URL )."component" ) ) {
                    mkdir(plugin_dir_path( PLUGIN_FILE_URL )."component");
                }
                
                $dir = plugin_dir_path( PLUGIN_FILE_URL )."component/".$component;
                
                $remotecomponents = array();
                $argsGit = array();
                $argsGit['headers']['Authorization'] = "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"; // Set the headers
                $responseGit = json_decode( wp_remote_retrieve_body( wp_remote_get( "https://api.github.com/repos/EdoardoDevelop/component/git/trees/master?recursive=1", $argsGit ) ), true );
                
                
                foreach($responseGit as $s){
                    if(is_array($s)){
                        foreach($s as $x){
                            $p = explode("/",$x['path']);
                            if(!empty($p[0]) && !empty($p[1])){
                                    $remotecomponents += array($p[0] => '');
                                    if(!empty($remotecomponents[$p[0]])){
                                        $remotecomponents[$p[0]] .= ',';
                                    }
                                    if(isset($p[0])){
                                        $remotecomponents[$p[0]] .= str_replace($p[0].'/','',$x['path']);
                                    }
                            }
                            
                        }
                    }
                }
                
                $cd = explode(",",$remotecomponents[$component]);
                
                
                foreach($cd as $path){
                    if ( !file_exists( $dir ) || !is_dir( $dir ) ) {
                        mkdir($dir);
                    }
                    if(pathinfo($path, PATHINFO_EXTENSION) == ''){
                        //cartella
                        if ( !file_exists( $dir.'/'.$path ) || !is_dir( $dir.'/'.$path) ) {
                            mkdir($dir.'/'.$path);
                        }
                    }else{
                        //file
                        $url = 'https://raw.githubusercontent.com/EdoardoDevelop/component/master/'.$component.'/'.$path;
                        
                        if (!file_put_contents($dir.'/'.$path, fopen($url, 'r'))){
                            break;
                        }
                        
                    }

                }
                
            }
        }
        

    }
    
}
if ( is_admin() ):
	new BwebComponentinstallactive();
endif;