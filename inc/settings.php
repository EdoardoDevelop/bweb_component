<?php

class BwebComponentSettings {
	private $bweb_component_settings_options;
	private $arraymodulegit;

	public function __construct() {	}

    public function load_setting_page(){
		if(isset($_GET['checkupdate']) && $_GET['checkupdate']==1){
			$this->checkupdate();
		}
		$this->arraymodulegit = get_option( 'arraymodulegit' ); 
		add_action( 'admin_menu', array( $this, 'bweb_component_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bweb_component_settings_page_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue' ) );
		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
            add_filter( 'block_categories_all', array($this, 'register_bwebcomponent_category' ));
        } else {
            add_filter( 'block_categories', array($this, 'register_bwebcomponent_category' ));
        }

    }

	public function bweb_component_settings_add_plugin_page() {
		add_menu_page(
			'Bweb Component', // page_title
			'Bweb Component', // menu_title
			'manage_options', // capability
			'bweb-component', // menu_slug
			array( $this, 'bweb_component_settings_create_admin_page' ), // function
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0NiIgaGVpZ2h0PSI0Ni4wMDkiIHZpZXdCb3g9IjAgMCA0NiA0Ni4wMDkiPg0KICA8cGF0aCBpZD0iTW9kdWxlLTU5NWI0MGI3NWJhMDM2ZWQxMTdkNjc5MyIgZD0iTTI1LDJhMS4wNTIsMS4wNTIsMCwwLDAtLjUuMTI1TDE3LjAzMSw2LjI4MSwyNSwxMC42MjVsOC00LjMxMkwyNS41LDIuMTI1QTEuMDUyLDEuMDUyLDAsMCwwLDI1LDJaTTE2LDh2Mi44NDRMNi41LDE2LjEyNUExLDEsMCwwLDAsNiwxN3Y4LjYyNUwyLjk2OSwyNy4zMTMsMTEsMzEuNjI1bDcuOTM4LTQuMzQ0TDExLjUsMjMuMTI1YTEuMDU1LDEuMDU1LDAsMCwwLTEsMEw4LDI0LjVWMTcuNTk0bDgtNC40Mzd2My4xODhhLjk4OS45ODksMCwwLDAsLjUuODc1TDI0LDIxLjM3NXYtOVptMTgsLjA2My04LDQuMzEzdjlsNy41LTQuMTU2YS45ODcuOTg3LDAsMCwwLC41LS44NzVWMTMuMTU2bDgsNC40Mzh2Ni45MzhsLTIuNS0xLjQwNmExLjA1NSwxLjA1NSwwLDAsMC0xLDBsLTcuNDY5LDQuMTU2TDM5LDMxLjYyNWw3LjkzOC00LjM0NEw0NCwyNS42MjVWMTdhLjk4Ny45ODcsMCwwLDAtLjUtLjg3NUwzNCwxMC44NDRaTTIwLDI4Ljk2OWwtOCw0LjQwNnY5bDEuMzEzLS43MTlMMjQuNSw0Ny44NzVhMSwxLDAsMCwwLDEsMGwxMS4xODgtNi4yMTlMMzgsNDIuMzc1di05TDMwLDI5djguMzQ0YS45ODguOTg4LDAsMCwwLC41Ljg3NUwzNC42MjUsNDAuNSwyNSw0NS44NDQsMTUuMzc1LDQwLjUsMTkuNSwzOC4yMTlhLjk4OS45ODksMCwwLDAsLjUtLjg3NVptMjgsMC04LDQuNDA2djlsNy41LTQuMTU2YS45ODguOTg4LDAsMCwwLC41LS44NzVaTTIsMjkuMDYzdjguMjgxYS45OS45OSwwLDAsMCwuNS44NzVMMTAsNDIuMzc1di05WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIgLTIpIiBmaWxsPSIjNDY0NjQ2Ii8+DQo8L3N2Zz4NCg==', // icon_url
			80 // position
		);
	}

	public function bweb_component_settings_create_admin_page() {
		$this->bweb_component_settings_options = get_option( 'bweb_component_active' ); 
		
		?>

		<div class="wrap bc_settings_table">
			<h2 class="wp-heading-inline">Bweb Component</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php if(isset($_GET['download_update'])): ?>
				<div id="download_update">
					<?php
					
						$component = $_GET['download_update'];
						$dir = plugin_dir_path( PLUGIN_FILE_URL )."component/".$component;
						$this->scrivi('Aggiornamento '.$component.'<br>');
						$remotecomponents = array();
						$argsGit = array();
						$argsGit['headers']['Authorization'] = "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"; // Set the headers
						$responseGit = json_decode( wp_remote_retrieve_body( wp_remote_get( "https://api.github.com/repos/EdoardoDevelop/bweb_component/git/trees/master?recursive=1", $argsGit ) ), true );
						
						foreach($responseGit as $s){
							if(is_array($s)){
								foreach($s as $x){
									$p = explode("/",$x['path']);
									if($p[0] == 'component'){
										if(!empty($p[1]) && !empty($p[2])){
											$remotecomponents += array($p[1] => '');
											if(!empty($remotecomponents[$p[1]])){
												$remotecomponents[$p[1]] .= ',';
											}
											if(isset($p[1])){
												$remotecomponents[$p[1]] .= str_replace($p[0].'/'.$p[1].'/','',$x['path']);
											}
										}
									}
								}
							}
						}


						$cd = explode(",",$remotecomponents[$component]);
						
						$this->deleteAll($dir);
						$this->scrivi('Svuoto cartella '.$component.'<br>');
						foreach($cd as $path){
							if ( !file_exists( $dir ) || !is_dir( $dir ) ) {
								mkdir($dir);
							}
							if(pathinfo($path, PATHINFO_EXTENSION) == ''){
								//cartella
								if ( !file_exists( $dir.'/'.$path ) || !is_dir( $dir.'/'.$path) ) {
									mkdir($dir.'/'.$path);
								}
								$this->scrivi('Cartella creata ' . $path.'<br>');
							}else{
								//file
								$url = 'https://raw.githubusercontent.com/EdoardoDevelop/bweb_component/master/component/'.$component.'/'.$path;
								
								if (file_put_contents($dir.'/'.$path, fopen($url, 'r'))){
									//echo "File downloaded successfully";
									$this->scrivi('Download file '.$path.'<br>');
								}else{
									$this->scrivi('Download fallito file '.$path.'<br>');
								}
								
							}
		
						}
						echo '<br><br>Aggiornamento eseguito. <a href="admin.php?page=bweb-component">Torna indietro</a>';
					
					?>
				</div>
				<?php else: ?>
				<div class="table_module">
					
					<?php
					settings_fields( 'bweb_component_settings_option_group' );
					do_settings_sections( 'bweb-component-settings-admin' );
					submit_button('Abilita selezionati');
					?>
				</div>
				<?php endif; ?>
			</form>			
			
		</div>
	<?php }

	
	public function bweb_component_settings_page_init() {
		global $submenu;
		register_setting(
			'bweb_component_settings_option_group', // option_group
			'bweb_component_active'
		);
		
		add_settings_section(
			'bweb_component_check_section', // id
			'Moduli', // title
			function(){echo '<a href="admin.php?page=bweb-component&checkupdate=1" class="button">Controlla aggiornamenti</a>';}, // callback
			'bweb-component-settings-admin' // page
		);


		$argsGit = array();
		$httpGit = "https://raw.githubusercontent.com/EdoardoDevelop/bweb_component/master/component/";
		$argsGit['headers']['Authorization'] = "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"; // Set the headers
		$responseGit = json_decode( wp_remote_retrieve_body( wp_remote_get( $httpGit."modules.json", $argsGit ) ), true ); // Get JSON and parse it
		foreach($responseGit["modules"] as $s){
			
			$foldername = $httpGit.$s["folder"];
			$BCdatacomponent = new BCdatacomponent();
			$data = $BCdatacomponent->get_component_data( $foldername . '/index.php', $argsGit);
			$icon = '';
			if($data['Icon']!=''){
				if (str_starts_with( $data['Icon'], 'dashicons-' ) ) {
					$icon = '<span class="dashicons '.$data['Icon'].'"></span>';
				}
				if ( str_starts_with( $data['Icon'], 'data:image' ) ) {
					$icon = '<img src="'.$data['Icon'].'" class="icon">';
				}
			}
			
			$updatemodule = false;
			if(isset($_GET['checkupdate']) && $_GET['checkupdate']==1){
				if(isset($this->arraymodulegit)){
					if(version_compare($data['Version'],$BCdatacomponent->get_component_data( 'https://raw.githubusercontent.com/EdoardoDevelop/bweb_component/master/component/' . pathinfo($foldername, PATHINFO_BASENAME) . '/index.php')['Version'], '<') ){
						$updatemodule = true;
					}
				}
			}
			$h = '<label class="component_title">'.$icon.'<span>'.$data['Name'].'</span></label>';
			
			if ( $this->find_my_menu_item($data['ID'], true) ) {
				$h = '<a href="admin.php?page='.$data['ID'].'" class="component_title">'.$icon.'<span>'.$data['Name'].'</span></a>';
			}
			$d = '';
			if ( !empty($data['Description']) ) {
				$d = '<div class="c_descr">'.$data['Description'].'</div>';
			}
			add_settings_field(
				'c_'.$data['ID'], // id
				$h.$d, // title
				array($this,'chk_callback'), // callback
				'bweb-component-settings-admin', // page
				'bweb_component_check_section', // section
				array('ID'=>$data['ID'],'Description'=>$data['Description'],'foldername'=>basename($foldername),'update' => $updatemodule)
			);
			
            
        }

		
	}
	

	public function chk_callback( $data ) {
		$foldername = $data['foldername'];
		if(file_exists(plugin_dir_path( __DIR__ ) ."component/" . $foldername . '/index.php')){
			printf(
				'<label><input type="checkbox" name="bweb_component_active[]" id="%s" value="%s" %s> %s</label>',
				'component_'.$data['ID'],
				$foldername,
				( isset( $this->bweb_component_settings_options ) && is_array( $this->bweb_component_settings_options) && in_array( $foldername,$this->bweb_component_settings_options) ) ? 'checked' : '',
				'Abilita'
			);
			if($data['update']){
				echo '<a href="admin.php?page=bweb-component&download_update='.pathinfo($foldername, PATHINFO_BASENAME).'">Aggiorna</a>';
			}
		}else{
			echo '<a href="admin.php?page=bweb-component&download_update='.$foldername.'" class="badge">Scarica</a>';
		}
		
	}
	
	


    public function load_enqueue($hook){
		if($hook == 'toplevel_page_bweb-component'){
			wp_enqueue_style( 'bc_settings_css', plugin_dir_url( PLUGIN_FILE_URL ).'assets/css/style.css');
			wp_enqueue_script( 'bc_settings_js', plugin_dir_url( PLUGIN_FILE_URL ).'assets/script/script.js');
		}
    }

	private function register_bwebcomponent_category( $categories ) {
	
        $categories[] = array(
            'slug'  => 'bweb-component',
            'title' => 'Bweb Component'
        );
    
        return $categories;
    }

	private function scrivi($testo){
		print_r($testo);
		ob_flush();
		flush();
		usleep(50000);
	}
	private function deleteAll($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				$this->deleteAll($file);
			else
				unlink($file);
		}
		if (file_exists($dir)) {
			rmdir($dir);
		}
	}
	private function find_my_menu_item( $handle, $sub = false ){
		if( !is_admin() || (defined('DOING_AJAX') && DOING_AJAX) )
		  	return false;
		global $menu, $submenu;
		$check_menu = $sub ? $submenu : $menu;
		if( empty( $check_menu ) )
		  	return false;
		foreach( $check_menu as $k => $item ){
			if( $sub ){
				foreach( $item as $sm ){
				if($handle == $sm[2])
					return true;
				}
			} else {
				if( $handle == $item[2] )
				return true;
			}
		}
		return false;
	}


	private function checkupdate(){
		$arraymodulegit = get_option('arraymodulegit');
		$check = true;
		if($check == true){

			$ch = curl_init();
			// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
			// in most cases, you should set it to true
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/EdoardoDevelop/bweb_component/git/trees/master?recursive=1');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: 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'
			)
			);
			$result = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($result,true);
			$components = array();
			foreach($data as $s){
				if(is_array($s)){
					foreach($s as $x){
						$p = explode("/",$x['path']);
						if($p[0] == 'component'){
							if(!empty($p[1]) && !empty($p[2])){
								$components += array($p[1] => '');
								if(!empty($components[$p[1]])){
									$components[$p[1]] .= ',';
								}
								if(isset($p[1])){
									$components[$p[1]] .= str_replace($p[0].'/'.$p[1].'/','',$x['path']);
								}
							}
						}
					}
				}
			}
			update_option('arraymodulegit',$components);
		}
	}

}
if ( is_admin() ):
	$bweb_component_settings = new BwebComponentSettings();
    $bweb_component_settings->load_setting_page();
endif;


