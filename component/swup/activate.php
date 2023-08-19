<?php
$sanitary_values = array();

$defaultscript = 'function addClassActiveMenu(){' . PHP_EOL;
$defaultscript .= '    jQuery(\'#navbarTop .menu-item\').each(function(){' . PHP_EOL;
$defaultscript .= '        var a = jQuery(this).find(".nav-link");' . PHP_EOL;
$defaultscript .= '        var href = a.attr(\'href\');' . PHP_EOL;
$defaultscript .= '        jQuery(this).removeClass(\'active\');' . PHP_EOL;
$defaultscript .= '        jQuery(a).removeClass(\'active\');' . PHP_EOL;
$defaultscript .= '        if(href == window.location){' . PHP_EOL;
$defaultscript .= '            jQuery(this).addClass(\'active\');' . PHP_EOL;
$defaultscript .= '            jQuery(a).addClass(\'active\');' . PHP_EOL;
$defaultscript .= '        }' . PHP_EOL;
$defaultscript .= '    });' . PHP_EOL;
$defaultscript .= '}' . PHP_EOL;
$defaultscript .= 'const options = {' . PHP_EOL;
$defaultscript .= '    animateHistoryBrowsing: false,' . PHP_EOL;
$defaultscript .= '    animationSelector: \'[class*="site-main"]\',' . PHP_EOL;
$defaultscript .= '    containers: ["#primary"],' . PHP_EOL;
$defaultscript .= '    cache: false,' . PHP_EOL;
$defaultscript .= '    plugins: [' . PHP_EOL;
$defaultscript .= '        new SwupGaPlugin(),' . PHP_EOL;
$defaultscript .= '        new SwupScrollPlugin(),' . PHP_EOL;
$defaultscript .= '        new SwupBodyClassPlugin(),' . PHP_EOL;
$defaultscript .= '        new SwupHeadPlugin(),' . PHP_EOL;
$defaultscript .= '    ],' . PHP_EOL;
$defaultscript .= '    linkSelector:' . PHP_EOL;
$defaultscript .= '    \'a[href^="\' +' . PHP_EOL;
$defaultscript .= '    window.location.origin +' . PHP_EOL;
$defaultscript .= '    \'"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), a[href^="#"]:not([data-no-swup]), a[href^="^"]:not([data-no-swup]), a[href^="^"]:not([target="_blank"])\',' . PHP_EOL;
$defaultscript .= '    skipPopStateHandling: function(event) {' . PHP_EOL;
$defaultscript .= '    if (event.state && event.state.source == "swup") {' . PHP_EOL;
$defaultscript .= '        return false;' . PHP_EOL;
$defaultscript .= '    }' . PHP_EOL;
$defaultscript .= '    return true;' . PHP_EOL;
$defaultscript .= '    }' . PHP_EOL;
$defaultscript .= '};' . PHP_EOL;
$defaultscript .= 'const swup = new Swup(options);' . PHP_EOL;
$defaultscript .= 'swup.on(\'contentReplaced\', function() {' . PHP_EOL;
$defaultscript .= '    addClassActiveMenu();' . PHP_EOL;
$defaultscript .= '    initalilizeMagnificPopup();' . PHP_EOL;
$defaultscript .= '});' . PHP_EOL;
$defaultscript .= '/*swup.on(\'clickLink\', function() {' . PHP_EOL;
$defaultscript .= '    jQuery( ".navbar-toggler:not(.collapsed)" ).trigger( "click" );' . PHP_EOL;
$defaultscript .= '})*/' . PHP_EOL;
$defaultscript .= 'addClassActiveMenu();' . PHP_EOL;


$defaultstyle = '.site-main{' . PHP_EOL;
$defaultstyle .= '    transition: 0.6s;' . PHP_EOL;
$defaultstyle .= '    opacity: 1;' . PHP_EOL;
$defaultstyle .= '    position: relative;' . PHP_EOL;
$defaultstyle .= '    top: 0;' . PHP_EOL;
$defaultstyle .= '    left: 0;' . PHP_EOL;
$defaultstyle .= '}' . PHP_EOL . PHP_EOL;
$defaultstyle .= '/* In */' . PHP_EOL;
$defaultstyle .= 'html.is-animating .site-main{' . PHP_EOL;
$defaultstyle .= '    opacity: 0;' . PHP_EOL;
$defaultstyle .= '    top: -20px;' . PHP_EOL;
$defaultstyle .= '}' . PHP_EOL . PHP_EOL;
$defaultstyle .= '/* Out */' . PHP_EOL;
$defaultstyle .= 'html.is-leaving .site-main{' . PHP_EOL;
$defaultstyle .= '    opacity: 0;' . PHP_EOL;
$defaultstyle .= '    top: 70px;' . PHP_EOL;
$defaultstyle .= '}' . PHP_EOL;


$sanitary_values['css_swup'] = $defaultstyle;

$sanitary_values['script_swup'] = $defaultscript;


add_option('swup_settings_option', $sanitary_values);

