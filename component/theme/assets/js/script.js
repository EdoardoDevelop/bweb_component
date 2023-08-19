
jQuery(function($){
    $(document).ready(function(){
        $('.dropdown-menu > li > .dropdown-menu').parent().addClass('dropdown-submenu').find(' > .dropdown-item').attr('href', 'javascript:;').addClass('dropdown-toggle');
        $('.dropdown-submenu > a').on("click", function(e) {
            var dropdown = $(this).parent().find(' > .show');
            //$('.dropdown-submenu .dropdown-menu').not(dropdown).removeClass('show');
            $(this).next('.dropdown-menu').toggleClass('show');
            e.stopPropagation();
        });
        $('.dropdown').on("hidden.bs.dropdown", function() {
            $('.dropdown-menu.show').removeClass('show');
        });
    });
    
    initalilizeMagnificPopup();
    
    
});

function initalilizeMagnificPopup(){
    jQuery('.wp-block-gallery').each(function() { // the containers for all your galleries
        jQuery(this).magnificPopup({
            gallery:{enabled:true},
            preloader: true,
            delegate: 'a:not(figcaption a)', // child items selector, by clicking on it popup will open
            type: 'image',
            image: {
                titleSrc: function(item) {
                    return item.el.siblings('figcaption').html();
                }
            },
            zoom: {
                enabled: true,
                easing: 'ease-in-out',
                duration: 300, // don't foget to change the duration also in CSS
                opener: function(element) {
                    return element.find('img');
                }
            }
        });
    });

    jQuery('.woocommerce-product-gallery').magnificPopup({
        gallery:{enabled:true},
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
		zoom: {
			enabled: true,
            easing: 'ease-in-out',
			duration: 300, // don't foget to change the duration also in CSS
			opener: function(element) {
				return element.find('img');
			}
		}
        // other options
    });
}


