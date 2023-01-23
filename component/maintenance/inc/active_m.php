<?php
class bcmaintenance_active {
    private $bc_maintenance_page;
    private $bc_maintenance_active;

    public function __construct(){
        $this->bc_maintenance_page = get_option( 'bc_maintenance_page' ); 
        $this->bc_maintenance_active = get_option( 'bc_maintenance_active' );
        add_action('template_redirect', array($this, 'bc_recirect'));
    }

    public function bc_recirect(){
        if ( ! is_page( $this->bc_maintenance_page ) ) {   
            if($this->bc_maintenance_active == 'true'){       
                if(!current_user_can('edit_themes') || !is_user_logged_in()){                                                                        
                    wp_redirect( home_url( 'index.php?page_id=' . $this->bc_maintenance_page ) ); 
                }
            }
        }  
    }

}

$bcmaintenance_active = new bcmaintenance_active();