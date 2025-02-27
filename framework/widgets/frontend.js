(function ($) {
	/**
	   * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	**/

	var SliderSyncingHandler = function ($scope, $) {
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
			listInfo = { top: listStep.offset().top, height: listStep.innerHeight() },
			lineProgress = $scope.find('.bt-line-progress-js'),
			currentScroll = $(window).scrollTop() + ($(window).height() / 2),
			percent = ((currentScroll - listInfo.top) / listInfo.height) * 100;

		if (percent > 0) {
			if (percent > 100) {
				lineProgress.css('height', '100%');
			} else {
				lineProgress.css('height', percent.toFixed(2) + '%');
			}
		} else {
			lineProgress.css('height', '0%');
		}
	}

	var MoreStepsHandler = function ($scope, $) {
		// console.log($scope);
		var moreBtn = $scope.find('.bt-show-more-btn-js'),
			listStep = $scope.find('.bt-step-list-js');

		lineProgressStep($scope);
		$(window).scroll(function () {
			lineProgressStep($scope);
		});

		if ($scope.find('.bt-has-show-more').length > 0) {

			moreBtn.on('click', function (e) {
				e.preventDefault();

				$(this).parent().hide();
				listStep.children().removeClass('bt-hide-item');

				lineProgressStep($scope);
				$(window).scroll(function () {
					lineProgressStep($scope);
				});
			});
		}

	};

	var ImageSliderHandler = function ($scope, $) {
		var imageSlider = $scope.find('.bt-elwg-image-slider--default');
		if (imageSlider.length > 0) {
			var direction = imageSlider.data('direction') || 'ltr';
			var item = imageSlider.data('item') || 1;
			var itemTablet = imageSlider.data('item-tablet') || 1;
			var itemMobile = imageSlider.data('item-mobile') || 1;
			var speed = imageSlider.data('speed') || 300;
			var spaceBetween = imageSlider.data('spacebetween') || 10;

			new Swiper(imageSlider[0], {
				slidesPerView: itemMobile,
				loop: true,
				spaceBetween: spaceBetween,
				speed: speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: {
					delay: 0,
					reverseDirection: direction === 'rtl',
					disableOnInteraction: false,
				},
				breakpoints: {
					1024: {
						slidesPerView: item,
					},
					768: {
						slidesPerView: itemTablet,
					},
				},
			});
		}
	};

	var ImageSliderVerticalHandler = function ($scope, $) {
		var $imageslider = $scope.find('.bt-elwg-image-slider-vertical--default');
		if ($imageslider.length > 0) {
			var $direction = $imageslider.data('direction');
			var $item = 5;
			var $speed = $imageslider.data('speed');
			var $spaceBetween = $imageslider.data('spacebetween');
			var $autoplay = $imageslider.data('autoplay');
			var $swiper = new Swiper($imageslider[0], {
				lazy: true,
				direction: 'vertical',
				slidesPerView: 5,
				loop: true,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: $autoplay ? {
					delay: 300,
					reverseDirection: $direction == 'rtl',
					disableOnInteraction: false,
				} : false,
			});
		}
	};
	var ReviewSliderHandler = function ($scope, $) {
		var reviewlider = $scope.find('.bt-elwg-review-slider--default');
		if (reviewlider.length > 0) {
			var direction = reviewlider.data('direction');
			var item = reviewlider.data('item') || 3;
			var speed = reviewlider.data('speed');
			var spaceBetween = reviewlider.data('spacebetween');

			var swiper = new Swiper(reviewlider[0], {
				direction: 'vertical',
				slidesPerView: item,
				loop: true,
				spaceBetween: spaceBetween,
				speed: speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: {
					delay: 0,
					reverseDirection: direction == 'rtl' ? true : false,
					disableOnInteraction: false,
				}
			});
		}
	};

	var TextSliderHandler = function ($scope, $) {
		var $textslider = $scope.find('.bt-elwg-text-slider--default');
		if ($textslider.length > 0) {
			var $direction = $textslider.data('direction');
			var $speed = $textslider.data('speed');
			var $spaceBetween = $textslider.data('spacebetween');

			var $swiper = new Swiper($textslider[0], {
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
	function BedemoAnimateText(selector, delayFactor = 50) {
		var $text = $(selector);
		var textContent = $text.text();
		$text.empty();

		let letterIndex = 0;

		textContent.split(" ").forEach((word) => {
			var $wordSpan = $("<span>").addClass("bt-word");

			word.split("").forEach((char) => {
				var $charSpan = $("<span>").addClass("bt-letter").text(char);
				$charSpan.css("animation-delay", `${letterIndex * delayFactor}ms`);
				$wordSpan.append($charSpan);
				letterIndex++;
			});

			$text.append($wordSpan).append(" ");
		});
	}
	function headingAnimationHandler($scope) {
		var headingAnimationContainer = $scope.find('.bt-elwg-heading-animation');
		var animationElement = headingAnimationContainer.find('.bt-heading-animation-js');
		var animationClass = headingAnimationContainer.data('animation');
		var animationDelay = headingAnimationContainer.data('delay');

		if (animationClass === 'none') {
			return;
		}
		function checkIfElementInView() {
			var windowHeight = $(window).height();
			var elementOffsetTop = animationElement.offset().top;
			var elementOffsetBottom = elementOffsetTop + animationElement.outerHeight();

			var isElementInView =
				elementOffsetTop < $(window).scrollTop() + windowHeight &&
				elementOffsetBottom > $(window).scrollTop();

			if (isElementInView) {
				if (!animationElement.hasClass('bt-animated')) {
					animationElement
						.addClass('bt-animated')
						.addClass(animationClass);
					BedemoAnimateText(animationElement, animationDelay);
				}
			}
		}
		jQuery(window).on('scroll', function () {
			checkIfElementInView();
		});
		jQuery(document).ready(function () {
			checkIfElementInView();
		});
	}
	var ImageFeatureSliderHandler = function ($scope, $) {
		var $imageslider = $scope.find('.bt-feature-slider-js');
		if ($imageslider.length > 0) {
			var $direction = $imageslider.data('direction');
			var $item = $imageslider.data('item');
			var $itemTablet = $imageslider.data('item-tablet');
			var $itemMobile = $imageslider.data('item-mobile');
			var $speed = $imageslider.data('speed');
			var $spaceBetween = $imageslider.data('spacebetween');
			var $autoplay = $imageslider.data('autoplay');
			var $dots = $imageslider.data('dots');
			var $swiper = new Swiper($imageslider[0], {
				slidesPerView: $itemMobile,
				loop: false,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: $autoplay ? {
					delay: 300,
					reverseDirection: $direction == 'rtl',
					disableOnInteraction: false,
				} : false,
				pagination: $dots ? {
					el: ".swiper-pagination",
					clickable: true,
				} : false,
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
	var ThemeFilterHandler = function ($scope, $) {
		var $themeFilter = $scope.find('.bt-elwg-theme-filter--default'),
			$JsonFilter = $themeFilter.find('.bt-category-list'),
			$itemFilter = $themeFilter.find('.bt-category-list li'),
			$buttonShowMore = $themeFilter.find('.bt-button-all a');
			
		$itemFilter.on('click', function (e) {
			e.preventDefault();
			$itemFilter.removeClass('active');
			$(this).addClass('active');
			var cat_id = $(this).data('id');
			var jsonData = $JsonFilter.data('json');
			
			var param_ajax = {
				action: 'bt_filter_themes',
				cat_id: cat_id,
				json_data: jsonData
			};
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: option_ob.ajaxurl, 
				data: param_ajax,
				context: this,
				beforeSend: function () {
					$themeFilter.find('.bt-content-theme').addClass('loading');
					$buttonShowMore.text('See all Demos').prop('disabled', false);
				},
				success: function (response) {
					if (response.success) {
						setTimeout(function () {
							$themeFilter.find('.bt-content-theme').removeClass('loading');
							$themeFilter.find('.bt-load-theme-list').html(response.data['items']).fadeIn('slow');
						}, 30000);
						if (cat_id && cat_id !== 0) {
							jsonData.category = [cat_id];
							$JsonFilter.attr("data-json", JSON.stringify(jsonData));
						}else{
							jsonData.category = "";
							$JsonFilter.attr("data-json", JSON.stringify(jsonData));
						}
						$buttonShowMore.attr("data-page", 2);
						if (!response.data['has_more']) {
							$buttonShowMore.hide();
						} else {
							$buttonShowMore.show();
						}
					} else {
						console.log('error');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log('The following error occured: ' + textStatus, errorThrown);
				}
			});

		});
		$buttonShowMore.on('click', function (e) {
			e.preventDefault();
			var idpage = parseInt($(this).attr('data-page'));
			var jsonData = $JsonFilter.data('json');
			var param_ajax = {
				action: 'bt_load_more_themes',
				page: idpage,
				json_data: jsonData
			};
			console.log(idpage);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: option_ob.ajaxurl,
				data: param_ajax,
				beforeSend: function () {
					$buttonShowMore.text('Loading...').prop('disabled', true);
				},
				success: function (response) {
					if (response.success) {
						$themeFilter.find('.bt-load-theme-list').append(response.data['items']);
						$buttonShowMore.attr("data-page", response.data['pages']);
						if (!response.data['has_more']) {
							$buttonShowMore.hide();
						} else {
							$buttonShowMore.text('See all Demos').prop('disabled', false);
						}
					} else {
						console.log('error');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log('The following error occurred: ' + textStatus, errorThrown);
					$buttonShowMore.text('See all Demos').prop('disabled', false);
				}
			});
		});
	}
	var FeatureSliderVerticalHandler = function ($scope, $) {
		var $featureslider = $scope.find('.bt-elwg-features-slider-vertical--default');
		if ($featureslider.length > 0) {
			var $direction = $featureslider.data('direction');
			var $item = 5;
			var $speed = $featureslider.data('speed');
			var $spaceBetween = $featureslider.data('spacebetween');
			var $autoplay = $featureslider.data('autoplay');
			var $swiper = new Swiper($featureslider[0], {
				lazy: true,
				direction: 'vertical',
				slidesPerView: 5,
				loop: true,
				spaceBetween: $spaceBetween,
				speed: $speed,
				freeMode: true,
				allowTouchMove: true,
				autoplay: $autoplay ? {
					delay: 300,
					reverseDirection: $direction == 'rtl',
					disableOnInteraction: false,
				} : false,
			});
		}
	};
	// Make sure you run this code under Elementor.
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-testimonial-slider.default', SliderSyncingHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-step-list.default', MoreStepsHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-heading-animation.default', headingAnimationHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-image-slider.default', ImageSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-image-slider-vertical.default', ImageSliderVerticalHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-review-slider.default', ReviewSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-text-slider.default', TextSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-image-feature-slider.default', ImageFeatureSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-theme-filter.default', ThemeFilterHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/bt-features-slider-vertical.default', FeatureSliderVerticalHandler);
	});

})(jQuery);
