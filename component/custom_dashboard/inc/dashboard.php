<?php
/**
 * Our custom dashboard page
 */
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
