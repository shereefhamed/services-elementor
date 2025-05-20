/* (function($){
    elementorFrontend.hooks.addAction('frontend/element_ready/elevate_services.default', function($scope){
        var $carousel = $scope.find('#news-slider');
        console.log($carousel);
        // Make sure it exists and isn't already initialized
        if ( $carousel.length && ! $carousel.hasClass('owl-loaded') ) {
            $carousel.owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,2],
                itemsMobile : [600,1],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:true
            });
        }
    });
})(jQuery);  */


(function($){
	elementorFrontend.hooks.addAction('frontend/element_ready/elevate_services.default', function($scope){
		var $carousel = $scope.find('#news-slider');

		// If content loaded via AJAX
		if ($carousel.length) {
			// Wait for AJAX injection from content_template
			setTimeout(function(){
				if ($carousel.find('.post-slide').length && !$carousel.hasClass('owl-loaded')) {
					$carousel.owlCarousel({
						items : 3,
						itemsDesktop:[1199,3],
						itemsDesktopSmall:[980,2],
						itemsMobile : [600,1],
						navigation:true,
						navigationText:["",""],
						pagination:true,
						autoPlay:true
					});
				}
			}, 500); // adjust if necessary
		}
	});
})(jQuery);


