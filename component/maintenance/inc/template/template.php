<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Meta for IE support -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile;?>
        <?php
        wp_reset_query();
        wp_reset_postdata();
        ?>
    <?php endif;?>

<?php wp_footer();?>
</body>
</html>