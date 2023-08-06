<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcomponent
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				single_term_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				if(is_single()) :
					get_template_part( 'template-parts/content', 'single' );
				elseif(is_archive()):
					get_template_part( 'template-parts/content', 'archive' );
				elseif(is_page()) :
					get_template_part( 'template-parts/content', 'page' );
				else:
					get_template_part( 'template-parts/content', get_post_type() );
				endif;

			endwhile;

			if (function_exists('wp_pagenavi')){wp_pagenavi();};

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
