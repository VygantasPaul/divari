/**
 * WP Alpha Theme Framework
 * Alpha Single Product and Quickview
 * 
 * @package WP Alpha Framework
 * @since 1.2.0
 */

window.theme = window.theme || {};

( function ( $ ) {

	/**
	 * Initialize product gallery
	 * 
	 * @class ProductGallery
	 * @since 1.0
	 * @param {string|jQuery} selector
	 * @return {void}
	 */
	theme.initProductGallery = function () {
		function onClickImageFull ( e ) {
			var $btn = $( e.currentTarget );
			e.preventDefault();

			// Default or horizontal type
			if ( $btn.siblings( '.product-single-carousel' ).length ) {
				$btn.parent().find( '.slider-slide-active a' ).trigger( 'click' );
				theme.isMobile && $btn.parent().find( '.slider-slide-active a' ).trigger( 'click' );
			} else {
				$btn.prev( 'a' ).trigger( 'click' );
				theme.isMobile && $btn.parent().find( '.slider-slide-active a' ).trigger( 'click' );
			}
		}

		// Image lightbox toggle
		theme.$body.on( 'click', '.product-image-full', onClickImageFull );
	}

	/**
	 * Initilize single product page, and register events for single product.
	 *
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.initProductSingle = ( function () {

		/**
		 * Initiazlie variable product
		 * 
		 * @since 1.0
		 */
		/*
		function initVariableProduct() {
			function onClickListVariation( e ) {
				var $btn = $( e.currentTarget );
				if ( $btn.hasClass( 'disabled' ) ) {
					return;
				}
				if ( $btn.hasClass( 'active' ) ) {
					$btn.removeClass( 'active' )
						.parent().next().val( '' ).change();
				} else {
					$btn.addClass( 'active' ).siblings().removeClass( 'active' );
					$btn.parent().next().val( $btn.attr( 'name' ) ).change();
				}
			}

			function onClickResetVariation( e ) {
				$( e.currentTarget ).closest( '.variations_form' ).find( '.active' ).removeClass( 'active' );
			}

			function onToggleResetVariation() {
				var $reset = $( theme.byClass( 'reset_variations', this ) );
				$reset.css( 'visibility' ) == 'hidden' ? $reset.hide() : $reset.show();
			}

			function onFoundVariation( e, variation ) {

				var $product = $( e.currentTarget ).closest( '.product' );
				// Display product of matched variation.
				var gallery = $product.find( '.woocommerce-product-gallery' ).data( 'alpha_product_gallery' );
				if ( gallery ) {
					gallery.changePostImage( variation );
				}

				// Display sale countdown of matched variation.
				var $counter = $product.find( '.countdown-variations' );
				if ( $counter.length ) {
					if ( variation && variation.is_purchasable && variation.alpha_date_on_sale_to ) {
						var $countdown = $counter.find( '.countdown' );
						if ( $countdown.data( 'until' ) != variation.alpha_date_on_sale_to ) {
							theme.countdown( $countdown, { until: new Date( variation.alpha_date_on_sale_to ) } );
							$countdown.data( 'until', variation.alpha_date_on_sale_to );
						}
						$counter.slideDown();
					} else {
						$counter.slideUp();
					}
				}
			}

			function onResetVariation( e ) {
				var $product = $( e.currentTarget ).closest( '.product' );
				var $gallery = $product.find( '.woocommerce-product-gallery' );

				if ( $gallery.length ) {
					var gallery = $gallery.data( 'alpha_product_gallery' );
					if ( gallery ) {
						gallery.changePostImage( 'reset' );
					}
				}

				$product.find( '.countdown-variations' ).slideUp();
			}

			function onUpdateVariation() {
				var $form = $( this );
				$form.find( '.product-variations>button' ).addClass( 'disabled' );

				// Loop through selects and disable/enable options based on selections.
				$form.find( 'select' ).each( function () {
					var $this = $( this );
					var $buttons = $this.closest( '.variations > *' ).find( '.product-variations' );
					$this.children( '.enabled' ).each( function () {
						$buttons.children( '[name="' + this.getAttribute( 'value' ) + '"]' ).removeClass( 'disabled' );
					} );
					$this.children( ':selected' ).each( function () {
						$buttons.children( '[name="' + this.getAttribute( 'value' ) + '"]' ).addClass( 'active' );
					} );
				} );
			}

			// Variation
			theme.$body.on( 'click', '.variations .product-variations button', onClickListVariation )
				.on( 'click', '.reset_variations', onClickResetVariation )
				.on( 'check_variations', '.variations_form', onToggleResetVariation )
				.on( 'found_variation', '.variations_form', onFoundVariation )
				.on( 'reset_image', '.variations_form', onResetVariation )
				.on( 'update_variation_values', '.variations_form', onUpdateVariation )
		}
		*/
		/**
		 * Initalize guide link
		 * 
		 * @since 1.0
		 */
		function initGuideLink () {
			// Guide Link
			theme.$body.on( 'click', '.guide-link', function () {
				var $link = $( this.getAttribute( 'href' ) + '>a' );
				$link.length && $link.trigger( 'click' );
			} );

			if ( theme.hash.toLowerCase().indexOf( 'tab-title-alpha_pa_block_' ) ) {
				$( theme.hash + '>a' ).trigger( 'click' );
			}
		}

		/**
		 * Initialize woocommerce product data
		 * 
		 * @since 1.0
		 */
		function initProductData () {
			// Init data tab accordion
			theme.$body.on( 'init', '.woocommerce-tabs.accordion', function () {
				var $tabs = $( this );
				setTimeout( function () {
					var selector = '';
					if ( theme.hash.toLowerCase().indexOf( 'comment-' ) >= 0 ||
						theme.hash === '#reviews' || theme.hash === '#tab-reviews' ||
						location.href.indexOf( 'comment-page-' ) > 0 || location.href.indexOf( 'cpage=' ) > 0 ) {

						selector = '.reviews_tab a';
					} else if ( theme.hash === '#tab-additional_information' ) {
						selector = '.additional_information_tab a';
					} else {
						selector = '.card:first-child > .card-header a';
					}
					$tabs.find( selector ).trigger( 'click' );
				}, 100 );
			} )
		}

		/**
		 * Initialize woocommerce compatility
		 * 
		 * @since 1.0
		 * @param {string|jQuery} selector
		 */
		function initWooCompatibility ( selector ) {

			// Initialize product gallery again for skeleton screen.
			if ( alpha_vars.skeleton_screen ) {
				// wc product gallery
				if ( $.fn.wc_product_gallery ) {
					$( selector + ' .woocommerce-product-gallery' ).each( function () {
						var $this = $( this );
						typeof $this.data( 'product_gallery' ) == 'undefined' && $this.wc_product_gallery();
					} )
				}
			}

			// Initialize variation form
			if ( $.fn.wc_variation_form && typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				theme.$( selector, '.variations_form' ).each( function () {
					var $form = $( this );
					if ( theme.status != 'load' || $form.closest( '.summary' ).length ) {
						var data_a = jQuery._data( this, 'events' );
						if ( !data_a || !data_a[ 'show_variation' ] ) {
							$form.wc_variation_form();
						} else {
							theme.requestTimeout( function () {
								$form.trigger( 'check_variations' );
							}, 100 );
						}
					}
				} );
			}

			if ( alpha_vars.skeleton_screen && !theme.$body.hasClass( 'alpha-use-vendor-plugin' ) ) {
				// init - wc tab
				$( '.wc-tabs-wrapper, .woocommerce-tabs' ).trigger( 'init' );
				// init - wc rating
				theme.$( selector, '#rating' ).trigger( 'init' );
			} else {
				$( '.woocommerce-tabs.accordion' ).trigger( 'init' );

				// Compatibility with lazyload
				var $image = theme.$( '.woocommerce-product-gallery .wp-post-image' );
				if ( $image.length ) {
					if ( $image.attr( 'data-lazy' ) && $image.attr( 'data-o_src' ) && $image.attr( 'data-o_src' ).indexOf( 'lazy.png' ) >= 0 ) {
						$image.attr( 'data-o_src', $image.attr( 'data-lazy' ) );
					}

					if ( $image.attr( 'data-lazyset' ) && $image.attr( 'data-o_srcset' ) && $image.attr( 'data-o_srcset' ).indexOf( 'lazy.png' ) >= 0 ) {
						$image.attr( 'data-o_srcset', $image.attr( 'data-lazyset' ) );
					}
				}
			}
		}

		return function ( selector ) {
			if ( typeof selector == 'undefined' ) {
				selector = '';
			}

			initProductData();
			initWooCompatibility();


			// Single product page
			theme.createProductSingle( selector + '.product-single' );
			theme.initProductGallery();

			// initVariableProduct();
			initGuideLink();
		}
	} )();

	$( window ).on( 'alpha_load', function () {
		theme.initProductSingle();                           // Initialize single product
	} );
} )( window.jQuery );