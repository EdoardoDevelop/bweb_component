
jQuery(function($){
    
    
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


