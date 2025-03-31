!(function ($) {
	"use strict";

	/* Toggle submenu align */
	function BeDemoSubmenuAuto() {
		if ($('.bt-site-header .bt-container').length > 0) {
			var container = $('.bt-site-header .bt-container'),
				containerInfo = { left: container.offset().left, width: container.innerWidth() },
				contLeftPos = containerInfo.left,
				contRightPos = containerInfo.left + containerInfo.width;

			$('.children, .sub-menu').each(function () {
				var submenuInfo = { left: $(this).offset().left, width: $(this).innerWidth() },
					smLeftPos = submenuInfo.left,
					smRightPos = submenuInfo.left + submenuInfo.width;

				if (smLeftPos <= contLeftPos) {
					$(this).addClass('bt-align-left');
				}

				if (smRightPos >= contRightPos) {
					$(this).addClass('bt-align-right');
				}

			});
		}
	}

	/* Toggle menu mobile */
	function BeDemoToggleMenuMobile() {
		$('.bt-site-header .bt-menu-toggle').on('click', function (e) {
			e.preventDefault();

			if ($(this).hasClass('bt-menu-open')) {
				$(this).addClass('bt-is-hidden');
				$('.bt-site-header .bt-primary-menu').addClass('bt-is-active');
			} else {
				$('.bt-menu-open').removeClass('bt-is-hidden');
				$('.bt-site-header .bt-primary-menu').removeClass('bt-is-active');
			}
		});
	}

	/* Toggle sub menu mobile */
	function BeDemoToggleSubMenuMobile() {
		var hasChildren = $('.bt-site-header .page_item_has_children, .bt-site-header .menu-item-has-children');

		hasChildren.each(function () {
			var $btnToggle = $('<div class="bt-toggle-icon"></div>');

			$(this).append($btnToggle);

			$btnToggle.on('click', function (e) {
				e.preventDefault();
				$(this).toggleClass('bt-is-active');
				$(this).parent().children('ul').toggle();
			});
		});
	}

	/* Tabs */
	function BeDemoTabs() {
		$('.bt-tabs-js .bt-nav-item').on('click', function (e) {
			e.preventDefault();
			$(this).addClass('bt-is-active').siblings().removeClass('bt-is-active');
			$($.attr(this, 'href')).addClass('bt-is-active').siblings().removeClass('bt-is-active');
		});
	}

	/* Close section */
	function BeDemoCloseSection() {
		if ($('.bt-close-btn').length > 0) {
			$('.bt-close-btn').on('click', function (e) {
				e.preventDefault();

				$(this).parents('.e-parent').hide();
			});
		}
	}

	/* Orbit effect */
	function BeDemoOrbitEffect() {
		if ($('.bt-orbit-enable').length > 0) {
			var html = '<div class="bt-orbit-effect">' +
				'<div class="bt-orbit-wrap">' +
				'<div class="bt-orbit red"><span></span></div>' +
				'<div class="bt-orbit blue"><span></span></div>' +
				'<div class="bt-orbit yellow"><span></span></div>' +
				'<div class="bt-orbit purple"><span></span></div>' +
				'<div class="bt-orbit green"><span></span></div>' +
				'</div>' +
				'</div>';

			$('.bt-site-main').append(html);
		}
	}

	/* Cursor effect */
	function BeDemoCursorEffect() {
		if ($('.bt-bg-pattern-enable').length > 0) {
			var html = '<div class="bt-bg-pattern-effect"></div>';

			$('.bt-site-main').append(html);
		}
	}

	/* Buble effect */
	function BeDemoBubleEffect() {
		if ($('.bt-bg-buble-enable').length > 0) {
			var html = '<div class="bt-bg-buble-effect">' +
				'<div class="bt-bubles-beblow"></div>' +
				'<div class="bt-bubles-above"></div>'
			'</div>';

			$('.bt-social-mcn-ss').append(html);

			for (let i = 0; i < 40; i++) {
				$('.bt-bubles-beblow').append('<span class="buble"></span>');
				$('.bt-bubles-above').append('<span class="buble"></span>');
			}
		}
	}

	/* Shop */
	function BeDemoShop() {
		if ($('.single-product').length > 0) {
			$('.woocommerce-product-zoom__image').zoom();

			$('.woocommerce-product-gallery__slider').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				asNavFor: '.woocommerce-product-gallery__slider-nav',
				prevArrow: '<button type=\"button\" class=\"slick-prev\">Prev</button>',
				nextArrow: '<button type=\"button\" class=\"slick-next\">Next</button>'
			});
			$('.woocommerce-product-gallery__slider-nav').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				arrows: false,
				focusOnSelect: true,
				asNavFor: '.woocommerce-product-gallery__slider'
			});
		}
		if ($('.quantity input').length > 0) {
			/* Plus Qty */
			$(document).on('click', '.qty-plus', function () {
				var parent = $(this).parent();
				$('input.qty', parent).val(parseInt($('input.qty', parent).val()) + 1);
				$('input.qty', parent).trigger('change');
			});
			/* Minus Qty */
			$(document).on('click', '.qty-minus', function () {
				var parent = $(this).parent();
				if (parseInt($('input.qty', parent).val()) > 1) {
					$('input.qty', parent).val(parseInt($('input.qty', parent).val()) - 1);
					$('input.qty', parent).trigger('change');
				}
			});
		}

	}

	/* Copyright Current Year */
	function BeDemoCopyrightCurrentYear() {
		var searchTerm = '{Year}',
			replaceWith = new Date().getFullYear();

		$('.bt-elwg-site-copyright').each(function () {
			this.innerHTML = this.innerHTML.replace(searchTerm, replaceWith);
		});
	}
	// hover button 
	function BeDemoButtonHover() {
		// Cache selectors
		const buttons = $('.bt-button-elm-hover .elementor-button, .bt-button-elm-hover-style1 .elementor-button,.bt-button-hover,.bt-button-hover-style1');
		// Add hover span only if it doesn't exist
		buttons.each(function () {
			if (!$(this).find('.bt-span-hover').length) {
				$(this).append('<span class="bt-span-hover"></span>');
			}
		});

		// Handle mouse events
		buttons.on('mouseenter mouseout', function (e) {
			const $this = $(this);
			const parentOffset = $this.offset();
			const relX = e.pageX - parentOffset.left;
			const relY = e.pageY - parentOffset.top;

			$this.find('.bt-span-hover').css({
				top: relY,
				left: relX
			});
		});
	}
	function BeDemoSearchCheck() {
		if ($('.search').length > 0) {
			// Get search term from URL
			const urlParams = new URLSearchParams(window.location.search);
			const searchTerm = urlParams.get('s');

			// If search term exists, populate input field
			if (searchTerm) {
				const searchInput = document.querySelector('.e-search-form input.e-search-input');
				if (searchInput) {
					searchInput.value = searchTerm;
				}
			}
		}
	}
	jQuery(document).ready(function ($) {
		BeDemoSubmenuAuto();
		BeDemoToggleMenuMobile();
		BeDemoToggleSubMenuMobile();
		BeDemoTabs();
		BeDemoCloseSection();
		BeDemoOrbitEffect();
		BeDemoCursorEffect();
		BeDemoBubleEffect();

		BeDemoShop();

		BeDemoCopyrightCurrentYear();
		BeDemoButtonHover();
		BeDemoSearchCheck();
	});

	jQuery(window).on('resize', function () {
		BeDemoSubmenuAuto();
	});

	jQuery(window).on('scroll', function () {

	});

})(jQuery);
