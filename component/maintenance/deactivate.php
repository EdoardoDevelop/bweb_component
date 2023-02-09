<?php
delete_post_meta( intval( get_option( 'bc_maintenance_page' ) ), '_wp_page_template');
update_option('bc_maintenance_page',0);