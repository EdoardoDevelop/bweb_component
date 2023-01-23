<?php
/**
 * The template for displaying 404 pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcomponent
 */

get_header();
?>
<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bcomponent' ); ?></h1>
        </header><!-- .page-header -->
    </section>
</main><!-- #main -->
<?php
get_footer();
