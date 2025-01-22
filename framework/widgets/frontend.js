( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	**/

	var SliderSyncingHandler = function( $scope, $ ) {
		// console.log($scope);
    var slideFor = $scope.find('.bt-slide-for-js'),
        slideNav = $scope.find('.bt-slide-nav-js');

		 slideFor.slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 5000,
		  arrows: false,
		  fade: true,
		  asNavFor: '.bt-slide-nav-js'
		});

		slideNav.slick({
			centerMode: true,
		  centerPadding: '0px',
		  slidesToShow: 3,
			asNavFor: '.bt-slide-for-js',
		  focusOnSelect: true,
			arrows: true,
			prevArrow: '<button type="button" class="slick-prev"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="10" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg></button>',
			nextArrow: '<button type="button" class="slick-next"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="10" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg></button>',
			responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        centerMode: true,
	        slidesToShow: 3
	      }
	    },
	    {
	      breakpoint: 768,
	      settings: {
	        centerMode: true,
	        slidesToShow: 1
	      }
	    }
	  ]
		});

 	};

	function lineProgressStep($scope) {
		var listStep = $scope.find('.bt-step-list-js'),
				listInfo = {top: listStep.offset().top, height: listStep.innerHeight()},
				lineProgress = $scope.find('.bt-line-progress-js'),
				currentScroll = $(window).scrollTop() + ($(window).height() / 2),
				percent = ((currentScroll - listInfo.top) / listInfo.height) * 100;

		if (percent > 0){
			if(percent > 100) {
				lineProgress.css('height', '100%');
			} else {
				lineProgress.css('height', percent.toFixed(2) + '%');
			}
		} else {
			lineProgress.css('height', '0%');
		}
	}

	var MoreStepsHandler = function( $scope, $ ) {
		// console.log($scope);
		var moreBtn = $scope.find('.bt-show-more-btn-js'),
				listStep = $scope.find('.bt-step-list-js');

		lineProgressStep($scope);
		$(window).scroll(function() {
    	lineProgressStep($scope);
    });

		if($scope.find('.bt-has-show-more').length > 0) {

			moreBtn.on('click', function(e) {
				e.preventDefault();

				$(this).parent().hide();
				listStep.children().removeClass('bt-hide-item');

				lineProgressStep($scope);
				$(window).scroll(function() {
		    	lineProgressStep($scope);
		    });
			});
		}

 	};

	var TabsHandler = function( $scope, $ ) {
		// console.log($scope);

		$scope.find('.bt-nav-item').on('click', function(e) {
			e.preventDefault();
			$(this).addClass('bt-is-active').siblings().removeClass('bt-is-active');
			$($.attr(this, 'href')).addClass('bt-is-active').siblings().removeClass('bt-is-active');
		});

 	};

	var ImageSliderHandler = function ($scope, $) {
		const $imageslider = $scope.find('.bt-elwg-image-slider--default');
		if ($imageslider.length > 0) {
			const $direction = $imageslider.data('direction');
			const $item = $imageslider.data('item');
			const $itemTablet = $imageslider.data('item-tablet');
			const $itemMobile = $imageslider.data('item-mobile');
			const $speed = $imageslider.data('speed');
			const $spaceBetween = $imageslider.data('spacebetween');

			const $swiper = new Swiper($imageslider[0], {
				slidesPerView: $itemMobile,
				loop: true,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay:
				{
					delay: 0,
					reverseDirection: $direction == 'rtl' ? true : false,
					disableOnInteraction: false,
				},
				breakpoints: {
					1024: {
						slidesPerView: $item,
					},
					768: {
						slidesPerView: $itemTablet,
					},
				},
			});
		}
	};

	var ReviewSliderHandler = function ($scope, $) {
		const $reviewlider = $scope.find('.bt-elwg-review-slider--default');
		if ($reviewlider.length > 0) {
			const $direction = $reviewlider.data('direction');
			const $item = 3;
			const $speed = $reviewlider.data('speed');
			const $spaceBetween = $reviewlider.data('spacebetween');

			const $swiper = new Swiper($reviewlider[0], {

				direction: 'vertical',
				slidesPerView: $item,
				loop: true,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: {
					delay: 0,
					reverseDirection: $direction == 'rtl' ? true : false,
					disableOnInteraction: false,
				}
			});
		}
	};

	var TextSliderHandler = function ($scope, $) {
		const $textslider = $scope.find('.bt-elwg-text-slider--default');
		if ($textslider.length > 0) {
			const $direction = $textslider.data('direction');
			const $speed = $textslider.data('speed');
			const $spaceBetween = $textslider.data('spacebetween');

			const $swiper = new Swiper($textslider[0], {
				slidesPerView: 'auto',
				loop: true,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay:
				{
					delay: 0,
					reverseDirection: $direction == 'rtl' ? true : false,
					disableOnInteraction: false,
				}
			});
		}
	};

	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/bt-testimonial-slider.default', SliderSyncingHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/bt-step-list.default', MoreStepsHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/bt-pricing-tabs.default', TabsHandler );

		elementorFrontend.hooks.addAction('frontend/element_ready/bt-image-slider.default', ImageSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-review-slider.default', ReviewSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-text-slider.default', TextSliderHandler);

	} );

} )( jQuery );
