<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package  easyparent
 */

if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
} ?>

<div class="nv-sidebar-wrap col-sm-12 nv-right cont-shop-sidebar">
	<aside id="secondary" class="shop-sidebar" role="complementary">
		<?php dynamic_sidebar( 'shop-sidebar' ); ?>
	</aside>
</div>
