function addClassActiveMenu(){
  jQuery('#navbarTop .menu-item').each(function(){
    var a = jQuery(this).find(".nav-link");
    var href = a.attr('href');
    jQuery(this).removeClass('active');
    jQuery(a).removeClass('active');
    if(href == window.location){
        jQuery(this).addClass('active');
        jQuery(a).addClass('active');
    }
  });
}
const options = {
    animateHistoryBrowsing: false,
    animationSelector: '[class*="site-main"]',
    containers: ["#primary"],
    cache: false,
    plugins: [
        new SwupGaPlugin(),
        new SwupScrollPlugin(),
        new SwupBodyClassPlugin(),
        new SwupHeadPlugin(),
    ],
    linkSelector:
      'a[href^="' +
      window.location.origin +
      '"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), a[href^="#"]:not([data-no-swup]), a[href^="^"]:not([data-no-swup]), a[href^="^"]:not([target="_blank"])',
    skipPopStateHandling: function(event) {
      if (event.state && event.state.source == "swup") {
        return false;
      }
      return true;
    }
  };
const swup = new Swup(options);
swup.on('contentReplaced', function() {
  addClassActiveMenu();
  initalilizeMagnificPopup();
});
/*swup.on('clickLink', function() {
  jQuery( ".navbar-toggler:not(.collapsed)" ).trigger( "click" );
})*/
addClassActiveMenu();
