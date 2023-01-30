<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Dashboard</h1>
    <div id="cont_widget">
        <?php
        if(isset( $this->bc_custom_dashboard_options['html_dash'] ) && $this->bc_custom_dashboard_options['html_dash'] != ''){
            echo $this->bc_custom_dashboard_options['html_dash'];
        }
        ?>
    </div>
</div>

<?php include( ABSPATH . 'wp-admin/admin-footer.php' );