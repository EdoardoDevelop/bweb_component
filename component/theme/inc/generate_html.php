<?php
$head = "<!DOCTYPE html>" . PHP_EOL;
$head .= '<html lang="it">' . PHP_EOL;
$head .= '<head>' . PHP_EOL;
$head .= '	<meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">' . PHP_EOL;
$head .= '	<title>Document</title>' . PHP_EOL.PHP_EOL;
$head .= '	<!--CSS-->' . PHP_EOL;
$head .= '	<link rel="stylesheet" href="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/css/bootstrap.min.css" type="text/css" media="all" />' . PHP_EOL;
$head .= '	<link rel="stylesheet" href="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/css/magnific-popup.css" type="text/css" media="all" />' . PHP_EOL;
$head .= '	<link rel="stylesheet" href="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/css/style.css" type="text/css" media="all" />' . PHP_EOL;
$head .= '	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />' . PHP_EOL;
if( isset( $input['include_swup'] ) && $input['include_swup'] === 'include_swup' ){
    //wp_enqueue_style( 'swup-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/theme/assets/css/swup-style.css');
    if( isset( $input['css_swup'] )){
        $head .= '<style>' . PHP_EOL;
        $head .= $input['css_swup'] . PHP_EOL;
        $head .= '</style>' . PHP_EOL;
    }
}
$head .= '	<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/jquery-3.3.1.min.js" ></script>' . PHP_EOL.PHP_EOL;
$head .= '</head>' . PHP_EOL;
$head .= '<body>' . PHP_EOL.PHP_EOL;

$menu = '<!--HEADER/MENU-->' . PHP_EOL;
$menu .= '<header id="masthead" class="site-header">' . PHP_EOL;
$menu .= '	<nav class="navbar navbar-light navbar-expand-lg">' . PHP_EOL;
$menu .= '		<button class="navbar-toggler collapsed ml-auto" type="button" data-toggle="collapse" data-target="#navbarTop">' . PHP_EOL;
$menu .= '			<span> </span><span> </span><span> </span>' . PHP_EOL;
$menu .= '		</button>' . PHP_EOL;
$menu .= '		<div id="navbarTop" class="collapse navbar-collapse">' . PHP_EOL;
$menu .= '			<ul id="menu-menu" class="navbar-nav m-auto">' . PHP_EOL;
$menu .= '				<li class="menu-item active"><a href="' . get_template_directory_uri() . '/template_index.html" class="nav-link active"><span class="menu-text">Home</span></a></li>' . PHP_EOL;
$menu .= '				<li class="menu-item"><a href="' . get_template_directory_uri() . '/template_loop.html" class="nav-link"><span class="menu-text">Loop</span></a></li>' . PHP_EOL;
$menu .= '				<li class="menu-item"><a href="' . get_template_directory_uri() . '/template_single.html" class="nav-link"><span class="menu-text">Single</span></a></li>' . PHP_EOL;
$menu .= '			</ul>' . PHP_EOL;
$menu .= '		</div>' . PHP_EOL;
$menu .= '	</nav>' . PHP_EOL;
$menu .= '</header><!-- #masthead -->' . PHP_EOL.PHP_EOL;

$footer = '<!--FOOTER-->' . PHP_EOL;
$footer .= '<footer id="colophon" class="site-footer">' . PHP_EOL;
$footer .= '  <div class="container">' . PHP_EOL;
$footer .= '      <div class="row">' . PHP_EOL;
$footer .= '          <div class="col-md-4">' . PHP_EOL.PHP_EOL;
$footer .= '          </div>' . PHP_EOL;
$footer .= '          <div class="col-md-4">' . PHP_EOL.PHP_EOL;
$footer .= '          </div>' . PHP_EOL;
$footer .= '          <div class="col-md-4">' . PHP_EOL.PHP_EOL;
$footer .= '              <p class="text-right">Powered by <a href="https://www.bwebinformatica.com" target="_blank">Bweb Agency</a><p>' . PHP_EOL;
$footer .= '          </div>' . PHP_EOL;
$footer .= '      </div>' . PHP_EOL;
$footer .= '  </div>' . PHP_EOL;
$footer .= '</footer><!-- #colophon -->' . PHP_EOL;
$footer .= PHP_EOL.PHP_EOL.'<!--JS-->' . PHP_EOL;
$footer .= '<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/bootstrap.min.js" ></script>' . PHP_EOL;
$footer .= '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js" ></script>' . PHP_EOL;
if( isset( $input['include_scrollreveal'] ) && $input['include_scrollreveal'] === 'include_scrollreveal' ){
    $footer .= '<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/scrollreveal.min.js" ></script>' . PHP_EOL;
    if( isset( $input['item_scrollreveal'] ) && is_array($input['item_scrollreveal'])){
        $footer .= '<script type="text/javascript">' . PHP_EOL;
        foreach($input['item_scrollreveal'] as $x => $value ){
            $footer .= "ScrollReveal().reveal('".$value['class']."',{" . PHP_EOL;
            $footer .= "  distance: '".$value['distance']."'," . PHP_EOL;
            $footer .= "  duration: ".$value['duration']."," . PHP_EOL;
            $footer .= "  origin: '".$value['origin']."'," . PHP_EOL;
            $footer .= "  easing: '".$value['easing']."'," . PHP_EOL;
            $footer .= "  interval: ".$value['interval'] . PHP_EOL;
            $footer .= "});" . PHP_EOL;
        }
        $footer .= '</script>' . PHP_EOL;
    }
}
$footer .= '<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/jquery.magnific-popup.min.js" ></script>' . PHP_EOL;
$footer .= '<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/script.js" ></script>' . PHP_EOL;
if( isset( $input['include_swup'] ) && $input['include_swup'] === 'include_swup' ){
    $footer .= '<script type="text/javascript" src="'.plugin_dir_url( PLUGIN_FILE_URL ) . 'component/theme/assets/js/swup-all.js" ></script>' . PHP_EOL;
    if( isset( $input['script_swup'] )){
            $footer .= '<script type="text/javascript">' . PHP_EOL;
            $footer .= $input['script_swup'] . PHP_EOL;
            $footer .= '</script>' . PHP_EOL;
        }
}
$footer .= '<script type="text/javascript" src="assets/js/script.js" ></script>' . PHP_EOL;
$footer .= PHP_EOL.'</body>' . PHP_EOL;
$footer .= '</html>' . PHP_EOL;



/**
 * template_index.html
 */
$main = '<main id="primary" class="site-main">' . PHP_EOL;
$main .= '' . PHP_EOL;
$main .= '</main><!-- #main -->' . PHP_EOL.PHP_EOL;

$template_index = $head . $menu . $main . $footer;

$file_template_index = fopen($folder_theme."/template_index.html", "w") or die("Unable to open file!");
fwrite($file_template_index, $template_index);
fclose($file_template_index);


/**
 * template_loop.html
 */
$main = '<main id="primary" class="site-main">' . PHP_EOL;
$main .= '  <header class="page-header">' . PHP_EOL;
$main .= '      <h1 class="page-title">Titolo</h1>' . PHP_EOL;
$main .= '      <div class="archive-description">' . PHP_EOL;
$main .= '          <strong>Lorem Ipsum</strong>&nbsp;è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo.' . PHP_EOL;
$main .= '      </div>' . PHP_EOL;
$main .= '  </header><!-- .page-header -->' . PHP_EOL;

for ($i=0; $i < 3; $i++) { 
    
$main .= '  <article>' . PHP_EOL;
$main .= '      <header class="entry-header">' . PHP_EOL;
$main .= '          <h2 class="entry-title"><a href="' . get_template_directory_uri() . '/template_single.html" rel="bookmark">Single title</a></h2>' . PHP_EOL;
$main .= '      </header><!-- .entry-header -->' . PHP_EOL;
$main .= '      <div class="post-thumbnail">' . PHP_EOL;
$main .= '          <img src="https://source.unsplash.com/random/1920x1080/?hd,nature" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" />' . PHP_EOL;
$main .= '      </div><!-- .post-thumbnail -->' . PHP_EOL;
$main .= '      <div class="entry-content">' . PHP_EOL;
$main .= '          <p><strong>Lorem Ipsum</strong>&nbsp;è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo, quando un anonimo tipografo prese una cassetta di caratteri e li assemblò per preparare un testo campione. È sopravvissuto non solo a più di cinque secoli, ma anche al passaggio alla videoimpaginazione, pervenendoci sostanzialmente inalterato. Fu reso popolare, negli anni ’60, con la diffusione dei fogli di caratteri trasferibili “Letraset”, che contenevano passaggi del Lorem Ipsum, e più recentemente da software di impaginazione come Aldus PageMaker, che includeva versioni del Lorem Ipsum.</p>' . PHP_EOL;
$main .= '      </div><!-- .entry-content -->' . PHP_EOL;
$main .= '  </article>' . PHP_EOL;

}
$main .= '</main><!-- #main -->' . PHP_EOL.PHP_EOL;

$template_loop = $head . $menu . $main . $footer;

$file_template_loop = fopen($folder_theme."/template_loop.html", "w") or die("Unable to open file!");
fwrite($file_template_loop, $template_loop);
fclose($file_template_loop);


/**
 * template_single.html
 */
$main = '<main id="primary" class="site-main">' . PHP_EOL;
$main .= '  <article>' . PHP_EOL;
$main .= '      <header class="entry-header">' . PHP_EOL;
$main .= '          <h1 class="entry-title">Titolo</h1>' . PHP_EOL;
$main .= '      </header><!-- .entry-header -->' . PHP_EOL;
$main .= '      <div class="post-thumbnail">' . PHP_EOL;
$main .= '          <img src="https://source.unsplash.com/random/1920x1080/?hd,nature" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" />' . PHP_EOL;
$main .= '      </div><!-- .post-thumbnail -->' . PHP_EOL;
$main .= '      <div class="entry-content">' . PHP_EOL;
$main .= '          <p><strong>Lorem Ipsum</strong>&nbsp;è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo....</p>' . PHP_EOL;
$main .= '      </div><!-- .entry-content -->' . PHP_EOL;
$main .= '  </article>' . PHP_EOL;
$main .= '</main><!-- #main -->' . PHP_EOL.PHP_EOL;

$template_single = $head . $menu . $main . $footer;

$file_template_single = fopen($folder_theme."/template_single.html", "w") or die("Unable to open file!");
fwrite($file_template_single, $template_single);
fclose($file_template_single);


if ( is_array( get_option( 'bweb_component_active' ) ) ) {
    foreach (get_option( 'bweb_component_active' ) as $foldername){
        $_a = plugin_dir_path( PLUGIN_FILE_URL ) .'component/'. $foldername . '/render.html';
        if(file_exists($_a)){
            copy($_a,$folder_theme.'/template_'.$foldername.'.html');
        }
    }
}