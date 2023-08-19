<nav class="navbar navbar-light navbar-expand-lg">
    <button class="navbar-toggler collapsed ml-auto" type="button" data-toggle="collapse" data-target="#navbarTop">
        <span> </span>
        <span> </span>
        <span> </span>
    </button>

    <?php wp_nav_menu([
            'menu'            => 'header',
            'theme_location'  => 'header',
            'container'       => 'div',
            'container_id'    => 'navbarTop',
            'container_class' => 'collapse navbar-collapse',
            'menu_id'         => false,
            'depth' => 4,
            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
            'walker'          => new WP_Bootstrap_Navwalker(),
            'menu_class'      => 'navbar-nav m-auto'
    ]);?>

</nav>