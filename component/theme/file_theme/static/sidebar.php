<?php
/**
 * The sidebar containing the main widget area.
 *
 *
 * @package easyParent
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>

<div class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</div>
