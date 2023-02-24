<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bcomponent
 */

get_header();
?>
<main id="primary" class="site-main">
    <?php
		while ( have_posts() ) :
			the_post();

			if(is_single()) :
                get_template_part( 'template-parts/content', 'single' );
            elseif(is_page()) :
                get_template_part( 'template-parts/content', 'page' );
            else:
                get_template_part( 'template-parts/content', get_post_type() );
            endif;
			
		endwhile; // End of the loop.
		?>

</main>

<?php
get_sidebar();
get_footer();
