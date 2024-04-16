/**
 * Alpha Custom js
 *
 * @author     D-THEMES
 * @package PandaStore
 * @version 1.0
 */
'use strict';
window.theme || (window.theme = {});

(function ($) {

	function frameworkCustomize() {
		/**
		 * Post Ajax Customize
		 *
		 * @since 1.0
		 */
		theme.initAjaxLoadPost = (function () {
			/**
			 * Alpha Ajax Filter
			 *
			 * @class AjaxLoadPost
			 * @since 1.0
			 * - Ajax load for products and posts in archive pages and widgets
			 * - Ajax filter products and posts
			 * - Load more by button or infinite scroll
			 * - Ajax pagination
			 * - Compatibility with YITH WooCommerce Ajax Navigation
			 */
			var AjaxLoadPost = {
				isAjaxShop: alpha_vars.shop_ajax ? $(document.body).hasClass('alpha-archive-product-layout') : false,
				isAjaxBlog: alpha_vars.blog_ajax ? $(document.body).hasClass('alpha-archive-post-layout') : false,
				scrollWrappers: false,
				ajax_tab_cache: {},

				/**
				 * Initialize
				 *
				 * @since 1.0
				 * @return {void}
				 */
				init: function () {

					if (AjaxLoadPost.isAjaxShop) {
						theme.$body
							.on('click', '.widget_product_categories a', this.filterByCategory)				// Product Category
							.on('click', '.widget_product_tag_cloud a', this.filterByLink)					// Product Tag Cloud
							.on('click', '.alpha-price-filter a', this.filterByLink)						// Alpha - Price Filter
							.on('click', '.woocommerce-widget-layered-nav a', this.filterByLink)			// Filter Products by Attribute
							.on('click', '.widget_price_filter .button', this.filterByPrice)				// Filter Products by Price
							.on('submit', '.alpha-price-range', this.filterByPriceRange)					// Filter Products by Price Range
							.on('click', '.widget_rating_filter a', this.filterByRating)					// Filter Products by Rating
							.on('click', '.filter-clean', this.filterByLink)								// Reset Filter
							.on('click', '.toolbox-show-type .btn-showtype', this.changeShowType)			// Change Show Type
							.on('change', '.toolbox-show-count .count', this.changeShowCount)				// Change Show Count
							.on('click', '.yith-woo-ajax-navigation a', this.saveLastYithAjaxTrigger)       // Compatibility with YITH ajax navigation
							.on('change', '.sidebar select.dropdown_product_cat', this.filterByCategory)    // Filter by category dropdown
							.on('click', '.categories-filter-shop .product-category a', this.filterByCategory) // Filter by product categories widget in shop page
							.on('click', '.product-archive + div .pagination a', this.loadmoreByPagination) // Load by pagination in shop page

						$('.toolbox .woocommerce-ordering')													// Orderby
							.off('change', 'select.orderby').on('change', 'select.orderby', this.sortProducts);

						$('.product-archive > .woocommerce-info').wrap('<ul class="products"></ul>');

						if (!alpha_vars.skeleton_screen) {
							$('.sidebar .dropdown_product_cat').off('change');
						}
					} else {
						theme.$body
							.on('change', '.toolbox-show-count .count', this.changeShowCountPage)            // Change Show Count when ajax disabled
							.on('change', '.sidebar select.dropdown_product_cat', this.changeCategory)		 // Change category by dropdown

						AjaxLoadPost.initSelect2();
					}

					AjaxLoadPost.isAjaxBlog && theme.$body
						.on('click', '.widget_categories a', this.filterPostsByLink)                    // Filter blog by categories
						.on('click', '.post-archive .post-filters a', this.filterPostsByLink)           // Filter blog by categories filter
						.on('click', '.post-archive .pagination a', this.loadmoreByPagination)          // Load by pagination in shop page

					theme.$body
						.on('click', '.btn-load', this.loadmoreByButton)						        // Load by button
						.on('click', '.products + .pagination a', this.loadmoreByPagination)              // Load by pagination in products widget
						.on('click', '.products .pagination a', this.loadmoreByPagination)              // Load by pagination in products widget
						.on('click', '.product-filters .nav-filter', this.filterWidgetByCategory)	    // Load by Nav Filter
						.on('click', '.filter-categories a', this.filterWidgetByCategory)		        // Load by Categories Widget's Filter
						.on('click', 'div:not(.post-archive) > .posts + .pagination a', this.loadmoreByPagination)				// Load by pagination in posts widget

					theme.$window.on('alpha_complete alpha_loadmore', this.startScrollLoad);	    // Load by infinite scroll
					this.startScrollLoad();


					// YITH AJAX Navigation Plugin Compatibility
					if (typeof yith_wcan != 'undefined') {
						$(document)
							.on('yith-wcan-ajax-loading', this.loadingPage)
							.on('yith-wcan-ajax-filtered', this.loadedPage);

						// Issue for multiple products in shop pages.
						$('.yit-wcan-container').each(function () {
							$(this).parent('.product-archive').length || $(this).children('.products').addClass('ywcps-products').unwrap();
						});
						yith_wcan.container = '.product-archive .products';
					}
				},

				/**
				 * Run select2 js plugin
				 */
				initSelect2: function () {
					if ($.fn.selectWoo) {
						$('.dropdown_product_cat').selectWoo({
							placeholder: alpha_vars.select_category,
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: true,
							language: {
								noResults: function () {
									return alpha_vars.no_matched
								}
							}
						})
					}
				},

				/**
				 * Event handler to change show count for non ajax mode.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				changeShowCountPage: function (e) {
					if (this.value) {
						location.href = theme.addUrlParam(location.href.replace(/\/page\/\d*/, ''), 'count', this.value);
					}
				},

				/**
				 * Event handler to change category by dropdown
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				changeCategory: function (e) {
					location.href = this.value ? theme.addUrlParam(alpha_vars.home_url, 'product_cat', this.value) : alpha_vars.shop_url;
				},

				/**
				 * Event handler to filter posts by link
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterPostsByLink: function (e) {

					// If link's toggle is clicked, return
					if ((e.target.tagName == 'I' || e.target.classList.contains('toggle-btn')) && e.target.parentElement == e.currentTarget) {
						return;
					}

					var $link = $(e.currentTarget);

					if ($link.is('.nav-filters .nav-filter')) {
						$link.closest('.nav-filters').find('.nav-filter').removeClass('active');
						$link.addClass('active')
					} else if ($link.hasClass('active') || $link.parent().hasClass('current-cat')) {
						return;
					}

					var $container = $('.post-archive .posts');

					if (!$container.length) {
						return;
					}

					if (AjaxLoadPost.isAjaxBlog && AjaxLoadPost.doLoading($container, 'filter')) {
						e.preventDefault();
						var url = theme.addUrlParam(e.currentTarget.getAttribute('href'), 'only_posts', 1);
						var postType = $container.data('post-type');
						if (postType) {
							url = theme.addUrlParam(url, 'post_style_type', postType);
						}
						$.get(encodeURI(decodeURIComponent(decodeURI(url.replace(/\/page\/(\d*)/, '')))), function (res) {
							res && AjaxLoadPost.loadedPage(0, res, url);
						});
					}
				},

				/**
				 * Event handler to filter products by price
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterByPrice: function (e) {
					e.preventDefault();
					var url = location.href,
						minPrice = $(e.currentTarget).siblings('#min_price').val(),
						maxPrice = $(e.currentTarget).siblings('#max_price').val();
					minPrice && (url = theme.addUrlParam(url, 'min_price', minPrice));
					maxPrice && (url = theme.addUrlParam(url, 'max_price', maxPrice));
					AjaxLoadPost.loadPage(url);
				},

				/**
				 * Event handler to filter products by price
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterByPriceRange: function (e) {
					e.preventDefault();
					var url = location.href,
						minPrice = $(e.currentTarget).find('.min_price').val(),
						maxPrice = $(e.currentTarget).find('.max_price').val();
					url = minPrice ? theme.addUrlParam(url, 'min_price', minPrice) : theme.removeUrlParam(url, 'min_price');
					url = maxPrice ? theme.addUrlParam(url, 'max_price', maxPrice) : theme.removeUrlParam(url, 'max_price');
					url != location.href && AjaxLoadPost.loadPage(url);
				},

				/**
				 * Event handler to filter products by rating
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterByRating: function (e) {
					var match = e.currentTarget.getAttribute('href').match(/rating_filter=(\d)/);
					if (match && match[1]) {
						e.preventDefault();
						AjaxLoadPost.loadPage(theme.addUrlParam(location.href, 'rating_filter', match[1]));
					}
				},

				/**
				 * Event handler to filter products by link
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterByLink: function (e) {
					e.preventDefault();
					AjaxLoadPost.loadPage(e.currentTarget.getAttribute('href'));
				},

				/**
				 * Event handler to filter products by category
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterByCategory: function (e) {
					e.preventDefault();

					var url;
					var isFromFilterWidget = false;

					if (e.type == 'change') { // Dropdown's event
						url = this.value ? theme.addUrlParam(alpha_vars.home_url, 'product_cat', this.value) : alpha_vars.shop_url;

					} else { // Link's event
						// If link's toggle is clicked, return
						if (e.target.parentElement == e.currentTarget) {
							return;
						}
						var $link = $(e.currentTarget);

						if ($link.is('.categories-filter-shop .product-category a')) {
							// Products categories widget
							var $category = $link.closest('.product-category');
							if ($category.hasClass('active')) {
								return;
							}
							$category.closest('.categories-filter-shop').find('.product-category').removeClass('active');
							$category.addClass('active');
							isFromFilterWidget = true;

						} else {
							// Product categories sidebar widget
							if ($link.hasClass('active') || $link.parent().hasClass('current-cat')) {
								// If it's active, return
								return;
							}
						}
						url = $link.attr('href');
					}

					// Make current category active in categories-filter-shop widgets
					if (!isFromFilterWidget) {
						theme.$body.one('alpha_ajax_shop_layout', function () {
							$('.categories-filter-shop .product-category a').each(function () {
								$(this).closest('.product-category').toggleClass('active', this.href == location.href);
							})
						});
					}

					AjaxLoadPost.loadPage(url);
				},

				/**
				 * Event handler to filter products by category.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				saveLastYithAjaxTrigger: function (e) {
					AjaxLoadPost.lastYithAjaxTrigger = e.currentTarget;
				},

				/**
				 * Event handler to change show type.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				changeShowType: function (e) {
					e.preventDefault();
					if (!this.classList.contains('active')) {
						var type = this.classList.contains(alpha_vars.theme_icon_prefix + '-icon-list') ? 'list' : 'grid';
						$('.product-archive .products').data('loading_show_type', type)	// For skeleton screen
						$(this).parent().children().toggleClass('active');				// Toggle active class
						AjaxLoadPost.loadPage(
							theme.addUrlParam(location.href, 'showtype', type),
							{ showtype: type }
						);
					}
				},

				/**
				 * Event handler to change order.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				sortProducts: function (e) {
					AjaxLoadPost.loadPage(theme.addUrlParam(location.href, 'orderby', this.value));
				},

				/**
				 * Event handler to change show count.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				changeShowCount: function (e) {
					AjaxLoadPost.loadPage(theme.addUrlParam(location.href, 'count', this.value));
				},

				/**
				 * Refresh widgets
				 *
				 * @since 1.0
				 * @param {string} widgetSelector
				 * @param {jQuery} $newContent
				 */
				refreshWidget: function (widgetSelector, $newContent) {
					var newWidgets = $newContent.find('.sidebar ' + widgetSelector),
						oldWidgets = $('.sidebar ' + widgetSelector);

					oldWidgets.length && oldWidgets.each(function (i) {
						// if new widget exists
						if (newWidgets.eq(i).length) {
							this.innerHTML = newWidgets.eq(i).html();
						} else {
							// else
							$(this).empty();
						}
					});
				},

				/**
				 * Refresh button
				 *
				 * @since 1.0
				 * @param {jQuery} $wrapper
				 * @param {jQuery} $newButton
				 * @param {object} options
				 */
				refreshButton: function ($wrapper, $newButton, options) {
					var $btn = $wrapper.siblings('.btn-load');

					if (typeof options != 'undefined') {
						if (typeof options == 'string' && options) {
							options = JSON.parse(options);
						}
						if (!options.args || !options.args.paged || options.max > options.args.paged) {
							if ($btn.length) {
								$btn[0].outerHTML = $newButton.length ? $newButton[0].outerHTML : '';
							} else {
								$newButton.length && $wrapper.after($newButton);
							}
							return;
						}
					}

					$btn.remove();
				},

				/**
				 * Process before load
				 *
				 * data can be {showtype: (boolean)} or omitted.
				 *
				 * @since 1.0
				 * @param {string} url
				 * @param {mixed} data
				 */
				loadPage: function (url, data) {
					AjaxLoadPost.loadingPage();

					// If it's not "show type change" load, remove page number from url
					if ('undefined' == typeof showtype) {
						url = encodeURI(decodeURIComponent(decodeURI(url.replace(/\/page\/(\d*)/, ''))));
					}

					// Add show type if current layout is list
					if (data && 'list' == data.showtype || (!data || 'undefined' == typeof data.showtype) && 'list' == theme.getUrlParam(location.href, 'showtype')) {
						url = theme.addUrlParam(url, 'showtype', 'list');
					} else {
						url = theme.removeUrlParam(url, 'showtype');
					}

					// Add show count if current show count is set, except show count change
					if (!theme.getUrlParam(url, 'count')) {
						var showcount = theme.getUrlParam(location.href, 'count');
						if (showcount) {
							url = theme.addUrlParam(url, 'count', showcount);
						}
					}

					$.get(theme.addUrlParam(url, 'only_posts', 1), function (res) {
						res && AjaxLoadPost.loadedPage(0, res, url);
					});
				},

				/**
				 * Process while loading.
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				loadingPage: function (e) {
					var $container = $('.product-archive .products');

					if ($container.length) {
						if (e && e.type == 'yith-wcan-ajax-loading') {
							$container.removeClass('yith-wcan-loading').addClass('product-filtering');
						}
						if (AjaxLoadPost.doLoading($container, 'filter')) {
							theme.scrollToFixedContent(
								($('.toolbox-top').length ? $('.toolbox-top') : $wrapper).offset().top - 20,
								400
							);
						}
					}
				},

				/**
				 * Process after load
				 *
				 * @since 1.0
				 * @param {Event} e
				 * @param {string} res
				 * @param {string} url
				 * @param {string} loadmore_type
				 */
				loadedPage: function (e, res, url, loadmore_type) {
					var $res = $(res);
					$res.imagesLoaded(function () {

						var $container, $newContainer;

						// Update browser history (IE doesn't support it)
						if (url && !theme.isIE && loadmore_type != 'button' && loadmore_type != 'scroll') {
							history.pushState({ pageTitle: res && res.pageTitle ? '' : res.pageTitle }, "", theme.removeUrlParam(url, 'only_posts'));
						}

						if (typeof loadmore_type == 'undefined') {
							loadmore_type = 'filter';
						}

						if (AjaxLoadPost.isAjaxBlog) {
							$container = $('.post-archive .posts');
							$newContainer = $res.find('.post-archive .posts');
							if (!$newContainer.length) {
								$res.each(function () {
									var $this = $(this);
									if ($this.hasClass('post-archive')) {
										$newContainer = $this.find('.posts');
										return false;
									}
								});
							}
						} else if (AjaxLoadPost.isAjaxShop) {
							$container = $('.product-archive .products');
							$newContainer = $res.find('.product-archive .products');
						} else {
							$container = $('.post-archive .posts');
							$newContainer = $res.find('.post-archive .posts');
							if (!$newContainer.length) {
								$newContainer = $res.find('.posts');
							}

							// Update Loadmore - Button
							if ($container.hasClass('posts')) { // Blog Archive
								AjaxLoadPost.refreshButton($container, $newContainer.siblings('.btn-load'), $container.attr('data-load'));
							} else {
								$container = $('.product-archive .products');
								$newContainer = $res.find('.product-archive .products');

								if ($container.hasClass('products')) { // Shop Archive
									var $parent = $('.product-archive'),
										$newParent = $res.find('.product-archive');
									AjaxLoadPost.refreshButton($parent, $newParent.siblings('.btn-load'), $container.attr('data-load'));
								}
							}
							return;
						}

						// Change content and update status.
						// When loadmore by button, scroll or pagination is performing, the 'loadmore' function performs this.
						if (loadmore_type == 'filter') {
							$container.html($newContainer.html());
							AjaxLoadPost.endLoading($container, loadmore_type);

							// Update Loadmore
							if ($newContainer.attr('data-load')) {
								$container.attr('data-load', $newContainer.attr('data-load'));
							} else {
								$container.removeAttr('data-load');
							}
						}

						// Change page title bar
						$('.page-title-bar').html($res.find('.page-title-bar').length ? $res.find('.page-title-bar').html() : '');


						if (AjaxLoadPost.isAjaxBlog) { // Blog Archive

							// Update Loadmore - Button
							AjaxLoadPost.refreshButton($container, $newContainer.siblings('.btn-load'), $container.attr('data-load'));

							// Update Loadmore - Pagination
							var $pagination = $container.siblings('.pagination'),
								$newPagination = $newContainer.siblings('.pagination');

							if ($pagination.length) {
								$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
							} else {
								$newPagination.length && $container.after($newPagination);
							}

							// Update sidebar widgets
							AjaxLoadPost.refreshWidget('.widget_categories', $res);
							AjaxLoadPost.refreshWidget('.widget_tag_cloud', $res);

							// Update nav filter
							var $newNavFilters = $res.find('.post-archive .nav-filters');
							$newNavFilters.length && $('.post-archive .nav-filters').html($newNavFilters.html());

							// Init posts
							AjaxLoadPost.fitVideos($container);
							theme.slider('.post-media-carousel');

							theme.$body.trigger('alpha_ajax_blog_layout', $container, res, url, loadmore_type);

						} else if (AjaxLoadPost.isAjaxShop) { // Products Archive

							var $parent = $('.product-archive'),
								$newParent = $res.find('.product-archive');

							// If new content is empty, show woocommerce info.
							if (!$newContainer.length) {
								$container.empty().append($res.find('.woocommerce-info'));
							}

							// Update Toolbox Title
							var $newTitle = $res.find('.main-content .toolbox .title');
							$newTitle.length && $('.main-content .toolbox .title').html($newTitle.html());

							// Update nav filter
							var $newNavFilters = $res.find('.main-content .toolbox .nav-filters');
							$newNavFilters.length && $('.main-content .toolbox .nav-filters').html($newNavFilters.html());

							// Update Show Count
							if (typeof loadmore_type != 'undefined' && (loadmore_type == 'button' || loadmore_type == 'scroll')) {
								var $span = $('.main-content .woocommerce-result-count > span');
								if ($span.length) {
									var newShowInfo = $span.html(),
										match = newShowInfo.match(/\d+\–(\d+)/);
									if (match && match[1]) {
										var last = parseInt(match[1]) + $newContainer.children().length,
											match = newShowInfo.replace(/\d+\–\d+/, '').match(/\d+/);
										$span.html(match && match[0] && last == match[0] ? alpha_vars.texts.show_info_all.replace('%d', last) : newShowInfo.replace(/(\d+)\–\d+/, '$1–' + last));
									}
								}
							} else {
								var $count = $('.main-content .woocommerce-result-count');
								var $toolbox = $count.parent('.toolbox-pagination');
								var newShowInfo = $res.find('.woocommerce-result-count').html();

								$count.html(newShowInfo ? newShowInfo : '');
								newShowInfo ? $toolbox.removeClass('no-pagination') : $toolbox.addClass('no-pagination');
							}

							// Update Toolbox Pagination
							var $toolboxPagination = $parent.siblings('.toolbox-pagination'),
								$newToolboxPagination = $newParent.siblings('.toolbox-pagination');

							if (!$toolboxPagination.length) {
								$newToolboxPagination.length && $parent.after($newToolboxPagination);

							} else { // Update Loadmore - Pagination
								var $pagination = $parent.siblings('.toolbox-pagination').find('.pagination'),
									$newPagination = $newParent.siblings('.toolbox-pagination').find('.pagination');

								if ($pagination.length) {
									$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
								} else {
									$newPagination.length && $parent.siblings('.toolbox-pagination').append($newPagination);
								}
							}

							// Update Loadmore - Button
							AjaxLoadPost.refreshButton($parent, $newParent.siblings('.btn-load'), $container.attr('data-load'));

							// Update Sidebar Widgets
							if (loadmore_type == 'filter') {
								AjaxLoadPost.refreshWidget('.alpha-price-filter', $res);

								AjaxLoadPost.refreshWidget('.widget_rating_filter', $res);
								theme.woocommerce.ratingTooltip('.widget_rating_filter')

								AjaxLoadPost.refreshWidget('.widget_price_filter', $res);
								theme.initPriceSlider();

								AjaxLoadPost.refreshWidget('.widget_product_categories', $res);

								AjaxLoadPost.refreshWidget('.widget_product_brands', $res);

								AjaxLoadPost.refreshWidget('.filter-actions', $res);

								// Refresh Filter Products by Attribute Widgets
								AjaxLoadPost.refreshWidget('.woocommerce-widget-layered-nav:not(.widget_product_brands)', $res);

								if (!e || e.type != "yith-wcan-ajax-filtered") {
									// Refresh YITH Ajax Navigation Widgets
									AjaxLoadPost.refreshWidget('.yith-woo-ajax-navigation', $res);
								} else {
									yith_wcan && $(yith_wcan.result_count).show();
									var $last = $(AjaxLoadPost.lastYithAjaxTrigger);
									$last.closest('.yith-woo-ajax-navigation').is(':hidden') && $last.parent().toggleClass('chosen');
									$('.sidebar .yith-woo-ajax-navigation').show();
								}

								AjaxLoadPost.initSelect2();
							}

							if (!$container.hasClass('skeleton-body')) {
								if ($container.data('loading_show_type')) {
									$container.toggleClass('list-type-products', 'list' == $container.data('loading_show_type'));
									$container.attr('class',
										$container.attr('class').replace(/row|cols\-\d|cols\-\w\w-\d/g, '').replace(/\s+/, ' ') +
										$container.attr('data-col-' + $container.data('loading_show_type'))
									);
									$('.main-content-wrap > .sidebar.closed').length && theme.shop.switchColumns(false);
								}
							}

							// Remove loading show type.
							$container.removeData('loading_show_type');

							// Init products
							theme.woocommerce.initProducts($container);

							theme.quantityInput('.qty');

							theme.$body.trigger('alpha_ajax_shop_layout', $container, res, url, loadmore_type);

							$container.removeClass('product-filtering');
						}


						$container.removeClass('skeleton-body load-scroll');
						$newContainer.hasClass('load-scroll') && $container.addClass('load-scroll');

						// Sidebar Widget Compatibility
						theme.menu.initCollapsibleWidgetToggle();

						// Isotope Refresh
						if ($container.hasClass('grid')) {
							theme.isotopes($container);
						}

						// countdown init
						theme.countdown($container.find('.countdown'));

						// Update Loadmore - Scroll
						theme.call(AjaxLoadPost.startScrollLoad, 50);

						// Refresh layouts
						theme.call(theme.refreshLayouts, 70);

						theme.$body.trigger('alpha_ajax_finish_layout', $container, res, url, loadmore_type);
					});
				},

				/**
				 * Check load
				 *
				 * @since 1.0
				 * @param {jQuery} $wrapper
				 * @param {string} type
				 */
				canLoad: function ($wrapper, type) {
					// check max
					if (type == 'button' || type == 'scroll') {
						var load = $wrapper.attr('data-load');
						if (load) {
							var options = JSON.parse($wrapper.attr('data-load'));
							if (options && options.args && options.max <= options.args.paged) {
								return false;
							}
						}
					}

					// If it is loading or active, return
					if ($wrapper.hasClass('loading-more') || $wrapper.hasClass('skeleton-body') || $wrapper.siblings('.d-loading').length) {
						return false;
					}

					return true;
				},

				/**
				 * Show loading effects.
				 *
				 * @since 1.0
				 * @param {jQuery} $wrapper
				 * @param {string} type
				 */
				doLoading: function ($wrapper, type) {
					if (!AjaxLoadPost.canLoad($wrapper, type)) {
						return false;
					}

					// "Loading start" effect
					if (alpha_vars.skeleton_screen && $wrapper.closest('.product-archive, .post-archive').length) {

						// Skeleton screen for archive pages

						var count = 12,
							template = '';

						if ($wrapper.closest('.product-archive').length) {
							// Shop Ajax
							count = parseInt(theme.getCookie('alpha_count'));
							if (!count) {
								var $count = $('.main-content .toolbox-show-count .count');
								$count.length && (count = $count.val());
							}
							count || (count = 12);
						} else if ($wrapper.closest('.post-archive').length) {

							// Blog Ajax
							$wrapper.children('.grid-space').remove();
							count = alpha_vars.posts_per_page;
						}

						if ($wrapper.hasClass('products')) {
							// product template
							var skelType = $wrapper.hasClass('list-type-products') ? 'skel-pro skel-pro-list' : 'skel-pro';
							if ($wrapper.data('loading_show_type')) {
								skelType = 'list' == $wrapper.data('loading_show_type') ? 'skel-pro skel-pro-list' : 'skel-pro';
							}
							template = '<li class="product-wrap"><div class="' + skelType + '"></div></li>';
						} else {
							// post template
							var skelType = 'skel-post';
							if ($wrapper.hasClass('list-type-posts')) {
								skelType = 'skel-post-list';
							}
							if ($wrapper.attr('data-post-type')) {
								skelType = 'skel-post-' + $wrapper.attr('data-post-type');
							}
							template = '<div class="post-wrap"><div class="' + skelType + '"></div></div>';
						}

						// Empty wrapper
						if (type == 'page' || type == 'filter') {
							$wrapper.html('');
						}

						if ($wrapper.data('loading_show_type')) {
							$wrapper.toggleClass('list-type-products', 'list' == $wrapper.data('loading_show_type'));
							$wrapper.attr('class',
								$wrapper.attr('class').replace(/row|cols\-\d|cols\-\w\w-\d/g, '').replace(/\s+/, ' ') +
								$wrapper.attr('data-col-' + $wrapper.data('loading_show_type'))
							);
						}

						if (theme.isIE) {
							var tmpl = '';
							while (count--) { tmpl += template; }
							$wrapper.addClass('skeleton-body').append(tmpl);
						} else {
							$wrapper.addClass('skeleton-body').append(template.repeat(count));
						}

					} else {
						// Widget or not skeleton in archive pages
						if (type == 'button' || type == 'scroll') {
							theme.showMore($wrapper);
						} else {
							theme.doLoading($wrapper.parent());
						}
					}

					// Scroll to wrapper's top offset
					if (type == 'page') {
						theme.scrollToFixedContent(($('.toolbox-top').length ? $('.toolbox-top') : $wrapper).offset().top - 20, 400);
					}

					if ($wrapper.data('isotope')) {
						$wrapper.isotope('destroy');
					}

					$wrapper.addClass('loading-more');

					return true;
				},

				/**
				 * End loading effect.
				 *
				 * @since 1.0
				 * @param {jQuery} $wrapper
				 * @param {string} type
				 */
				endLoading: function ($wrapper, type) {
					// Clear loading effect
					if (alpha_vars.skeleton_screen && $wrapper.closest('.product-archive, .post-archive').length) { // shop or blog archive
						if (type == 'button' || type == 'scroll') {
							$wrapper.find('.skel-pro,.skel-post').parent().remove();
						}
						$wrapper.removeClass('skeleton-body');
					} else {
						if (type == 'button' || type == 'scroll') {
							theme.hideMore($wrapper.parent());
						} else {
							theme.endLoading($wrapper.parent());
						}
					}
					$wrapper.removeClass('loading-more');
				},

				/**
				 * Filter widgets by category
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				filterWidgetByCategory: function (e) {
					var $filter = $(e.currentTarget);

					e.preventDefault();

					// If this is filtered by archive page's toolbox filter or this is active now, return.
					if ($filter.is('.toolbox .nav-filter') || $filter.is('.post-archive .nav-filter') || $filter.hasClass('active')) {
						return;
					}

					// Find Wrapper
					var filterNav, $wrapper, filterCat = $filter.attr('data-cat');

					filterNav = $filter.closest('.nav-filters');
					if (filterNav.length) {
						$wrapper = filterNav.parent().find(filterNav.hasClass('product-filters') ? '.products' : '.posts');
					} else {
						filterNav = $filter.closest('.filter-categories');
						if (filterNav.length) {
							if ($filter.closest('.elementor-top-section').length) {
								$wrapper = $filter.closest('.elementor-top-section').find('.products[data-load]').eq(0);
							} else if ($filter.closest('.vce-row').length) {
								$wrapper = $filter.closest('.vce-row').find('.products[data-load]').eq(0);
							} else if ($filter.closest('.wpb_row').length) {
								$wrapper = $filter.closest('.wpb_row').find('.products[data-load]').eq(0);

								// If there is no products to be filtered in vc row, just find it in the same section
								if (!$wrapper.length) {
									if ($filter.closest('.vc_section').length) {
										$wrapper = $filter.closest('.vc_section').find('.products[data-load]').eq(0);
									}
								}
							}
						}
					}

					if ($wrapper.length) {
						filterNav.length && (
							filterNav.find('.cat-type-icon').length
								? ( // if category type is icon
									filterNav.find('.cat-type-icon').removeClass('active'),
									$filter.closest('.cat-type-icon').addClass('active'))
								: ( // if not,
									filterNav.find('.product-category, .nav-filter').removeClass('active'),
									$filter.closest('.product-category, .nav-filter').addClass('active')
								)
						);
					}

					var section_id = $wrapper.closest('.elementor-top-section').data('id');
					if (section_id && AjaxLoadPost.ajax_tab_cache[section_id] && AjaxLoadPost.ajax_tab_cache[section_id][filterCat]) {
						var $content = AjaxLoadPost.ajax_tab_cache[section_id][filterCat];

						$wrapper.css('opacity', 0);
						$wrapper.animate(
							{
								'opacity': 1,
							},
							400,
							function () {
								$wrapper.css('opacity', '');
							}
						);
						$wrapper.empty();
						if ($content.length) {
							$wrapper.append($content.clone());
						} else {
							$wrapper.append($content);
						}
						if ($wrapper.hasClass('slider-wrapper')) {
							$wrapper.removeData('slider');
							theme.slider($wrapper);
						}
					} else {
						$wrapper.length &&
							AjaxLoadPost.loadmore({
								wrapper: $wrapper,
								page: 1,
								type: 'filter',
								category: filterCat
							})
					}
				},

				/**
				 * Load more by button
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				loadmoreByButton: function (e) {
					var $btn = $(e.currentTarget); // This will be replaced with new html of ajax content.
					e.preventDefault();

					AjaxLoadPost.loadmore({
						wrapper: $btn.siblings('.product-archive').length ? $btn.siblings('.product-archive').find('.products') : $btn.siblings('.products, .posts'),
						page: '+1',
						type: 'button',
						onStart: function () {
							$btn.data('text', $btn.html())
								.addClass('loading').blur()
								.html(alpha_vars.texts.loading);
						},
						onFail: function () {
							$btn.text(alpha_vars.texts.loadmore_error).addClass('disabled');
						}
					});
				},

				/**
				 * Event handler for ajax loading by infinite scroll
				 *
				 * @since 1.0
				 */
				startScrollLoad: function () {
					AjaxLoadPost.scrollWrappers = $('.load-scroll');
					if (AjaxLoadPost.scrollWrappers.length) {
						AjaxLoadPost.loadmoreByScroll();
						theme.$window.off('scroll resize', AjaxLoadPost.loadmoreByScroll);
						window.addEventListener('scroll', AjaxLoadPost.loadmoreByScroll, { passive: true });
						window.addEventListener('resize', AjaxLoadPost.loadmoreByScroll, { passive: true });
					}
				},

				/**
				 * Load more by scroll
				 *
				 * @since 1.0
				 * @param {jQuery} $scrollWrapper
				 */
				loadmoreByScroll: function ($scrollWrapper) {
					var target = AjaxLoadPost.scrollWrappers,
						loadOptions = target.attr('data-load'),
						maxPage = 1,
						curPage = 1;

					if (loadOptions) {
						loadOptions = JSON.parse(loadOptions);
						maxPage = loadOptions.max;
						if (loadOptions.args && loadOptions.args.paged) {
							curPage = loadOptions.args.paged;
						}
					}

					if (curPage >= maxPage) {
						return;
					}

					$scrollWrapper && $scrollWrapper instanceof jQuery && (target = $scrollWrapper);

					// load more
					target.length && AjaxLoadPost.canLoad(target, 'scroll') && target.each(function () {
						var rect = this.getBoundingClientRect();
						if (rect.top + rect.height > 0 &&
							rect.top + rect.height < window.innerHeight) {
							AjaxLoadPost.loadmore({
								wrapper: $(this),
								page: '+1',
								type: 'scroll',
								onDone: function ($result, $wrapper, options) {
									// check max
									if (options.max && options.max <= options.args.paged) {
										$wrapper.removeClass('load-scroll');
									}
									// continue loadmore again
									theme.call(AjaxLoadPost.startScrollLoad, 50);
								},
								onFail: function (jqxhr, $wrapper) {
									$wrapper.removeClass('load-scroll');
								}
							});
						}
					});

					// remove loaded wrappers
					AjaxLoadPost.scrollWrappers = AjaxLoadPost.scrollWrappers.filter(function () {
						var $this = $(this);
						$this.children('.post-wrap,.product-wrap').length || $this.removeClass('load-scroll');
						return $this.hasClass('load-scroll');
					});
					AjaxLoadPost.scrollWrappers.length || (
						window.removeEventListener('scroll', AjaxLoadPost.loadmoreByScroll),
						window.removeEventListener('resize', AjaxLoadPost.loadmoreByScroll)
					)
				},

				/**
				 * Fit videos
				 *
				 * @since 1.0
				 * @param {jQuery} $wrapper
				 */
				fitVideos: function ($wrapper, fitVids) {
					// Video Post Refresh
					if ($wrapper.find('.fit-video').length) {

						var defer_mecss = (function () {
							var deferred = $.Deferred();
							if ($('#wp-mediaelement-css').length) {
								deferred.resolve();
							} else {
								$(document.createElement('link')).attr({
									id: 'wp-mediaelement-css',
									href: alpha_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.css'),
									media: 'all',
									rel: 'stylesheet'
								}).appendTo('body').on(
									'load',
									function () {
										deferred.resolve();
									}
								);
							}
							return deferred.promise();
						})();

						var defer_mecss_legacy = (function () {
							var deferred = $.Deferred();
							if ($('#mediaelement-css').length) {
								deferred.resolve();
							} else {
								$(document.createElement('link')).attr({
									id: 'mediaelement-css',
									href: alpha_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css'),
									media: 'all',
									rel: 'stylesheet'
								}).appendTo('body').on(
									'load',
									function () {
										deferred.resolve();
									}
								);
							}
							return deferred.promise();
						})();

						var defer_mejs = (function () {
							var deferred = $.Deferred();

							if (typeof window.wp.mediaelement != 'undefined') {
								deferred.resolve();
							} else {

								$('<script>var _wpmejsSettings = { "stretching": "responsive" }; </script>').appendTo('body');

								var defer_mejsplayer = (function () {
									var deferred = $.Deferred();

									$(document.createElement('script')).attr('id', 'mediaelement-core-js')
										.appendTo('body')
										.on('load', function () {
											deferred.resolve();
										})
										.attr('src', alpha_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-and-player.min.js'));

									return deferred.promise();
								})();
								var defer_mejsmigrate = (function () {
									var deferred = $.Deferred();

									setTimeout(function () {
										$(document.createElement('script')).attr('id', 'mediaelement-migrate-js').appendTo('body').on(
											'load',
											function () {
												deferred.resolve();
											}
										).attr('src', alpha_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-migrate.min.js'));
									}, 100);

									return deferred.promise();
								})();
								$.when(defer_mejsplayer, defer_mejsmigrate).done(
									function (e) {
										$(document.createElement('script')).attr('id', 'wp-mediaelement-js').appendTo('body').on(
											'load',
											function () {
												deferred.resolve();
											}
										).attr('src', alpha_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.js'));
									}
								);
							}

							return deferred.promise();
						})();

						var defer_fitvids = (function () {
							var deferred = $.Deferred();
							if ($.fn.fitVids) {
								deferred.resolve();
							} else {
								$(document.createElement('script')).attr('id', 'jquery.fitvids-js')
									.appendTo('body')
									.on('load', function () {
										deferred.resolve();
									}).attr('src', alpha_vars.assets_url + '/vendor/jquery.fitvids/jquery.fitvids.min.js');
							}
							return deferred.promise();
						})();

						$.when(defer_mecss, defer_mecss_legacy, defer_mejs, defer_fitvids).done(
							function (e) {
								theme.call(function () {
									theme.fitVideoSize($wrapper);
								}, 200);
							}
						);
					}
				},

				/**
				 * Event handler for ajax loading by pagination
				 *
				 * @since 1.0
				 * @param {Event} e
				 */
				loadmoreByPagination: function (e) {
					var $btn = $(e.currentTarget); // This will be replaced with new html of ajax content

					if (theme.$body.hasClass('dokan-store') && $btn.closest('.dokan-single-store').length) {
						return;
					}
					e.preventDefault();

					var $pagination = $btn.closest('.toolbox-pagination').length ? $btn.closest('.toolbox-pagination') : $btn.closest('.pagination');

					AjaxLoadPost.loadmore({
						wrapper: $pagination.siblings('.product-archive').length ?
							$pagination.siblings('.product-archive').find('.products') :
							$pagination.siblings('.products, .posts'),

						page: $btn.hasClass('next') ? '+1' :
							($btn.hasClass('prev') ? '-1' : $btn.text()),
						type: 'page',
						onStart: function ($wrapper, options) {
							theme.doLoading($btn.closest('.pagination'), 'simple');
						}
					});
				},

				/**
				 * Load more ajax content
				 *
				 * @since 1.0
				 * @param {object} params
				 * @return {boolean}
				 */
				loadmore: function (params) {
					if (!params.wrapper ||
						1 != params.wrapper.length ||
						!params.wrapper.attr('data-load') ||
						!AjaxLoadPost.doLoading(params.wrapper, params.type)) {
						return false;
					}

					// Get wrapper
					var $wrapper = params.wrapper;

					// Get options
					var options = JSON.parse($wrapper.attr('data-load'));
					options.args = options.args || {};
					if (!options.args.paged) {
						options.args.paged = 1;

						// Get correct page number at first in archive pages
						if ($wrapper.closest('.product-archive, .post-archive').length) {
							var match = location.pathname.match(/\/page\/(\d*)/);
							if (match && match[1]) {
								options.args.paged = parseInt(match[1]);
							}
						}
					}
					if ('filter' == params.type) {
						options.args.paged = 1;
						if (params.category) {
							options.args.category = params.category; // filter category
						} else if (options.args.category) {
							delete options.args.category; // do not filter category
						}
					} else if ('+1' === params.page) {
						++options.args.paged;
					} else if ('-1' === params.page) {
						--options.args.paged;
					} else {
						options.args.paged = parseInt(params.page);
					}

					// Get ajax url
					var url = alpha_vars.ajax_url;
					if ($wrapper.closest('.product-archive, .post-archive').length) { // shop or blog archive
						var pathname = location.pathname;
						if (pathname.endsWith('/')) {
							pathname = pathname.slice(0, pathname.length - 1);
						}
						if (pathname.indexOf('/page/') >= 0) {
							pathname = pathname.replace(/\/page\/\d*/, '/page/' + options.args.paged);
						} else {
							pathname += '/page/' + options.args.paged;
						}

						url = theme.addUrlParam(location.origin + pathname + location.search, 'only_posts', 1);
						if (options.args.category && options.args.category != '*') {
							url = theme.addUrlParam(url, 'product_cat', category);
						}
					}

					// Add product-page param to set current page for pagination
					if ($wrapper.hasClass('products') && !$wrapper.closest('.product-archive').length) {
						url = theme.addUrlParam(url, 'product-page', options.args.paged);
					}

					// Add post type to blog posts' ajax pagination.
					if ($wrapper.closest('.post-archive').length) {
						var postType = $wrapper.data('post-type');
						if (postType) {
							url = theme.addUrlParam(url, 'post_style_type', postType);
						}
					}

					// Get ajax data
					var data = {
						action: $wrapper.closest('.product-archive, .post-archive').length ? '' : 'alpha_loadmore',
						nonce: alpha_vars.nonce,
						props: options.props,
						args: options.args,
						loadmore: params.type
					};
					if (params.type == 'page') {
						data.pagination = 1;
					}

					// Before start loading
					params.onStart && params.onStart($wrapper, options);

					// Do ajax
					$.post(url, data)
						.done(function (result) {
							// In case of posts widget's pagination, result's structure will be {html: '', pagination: ''}.
							var res_pagination = '';
							if ($wrapper.hasClass('posts') && !$wrapper.closest('.post-archive').length && params.type == 'page') {
								result = JSON.parse(result);
								res_pagination = result.pagination;
								result = result.html;
							}

							// In other cases, result will be html.
							var $result = $(result),
								$content;

							$result.imagesLoaded(function () {

								// Get content, except posts widget
								if ($wrapper.closest('.product-archive').length) {
									$content = $result.find('.product-archive .products');
								} else if ($wrapper.closest('.post-archive').length) {
									$content = $result.find('.posts.row');
									if (!$content.length) {
										$result.each(function () {
											var $this = $(this);
											if ($this.hasClass('post-archive')) {
												$content = $this.find('.posts');
												return false;
											}
										});
									}
								} else {
									$content = $wrapper.hasClass('products') ? $result.find('.products') : $result.children();
									var section_id = $wrapper.closest('.elementor-top-section').data('id');
									if (section_id) {
										if (undefined == AjaxLoadPost.ajax_tab_cache[section_id]) {
											AjaxLoadPost.ajax_tab_cache[section_id] = {};
										}

										AjaxLoadPost.ajax_tab_cache[section_id][params.category] = $content.children();
									}
								}

								// Change status and content
								if (params.type == 'page' || params.type == 'filter') {
									if ($wrapper.data('slider')) {
										$wrapper.data('slider').destroy();
										$wrapper.removeData('slider');
										$wrapper.data('slider-layout') && $wrapper.addClass($wrapper.data('slider-layout').join(' '));
									}
									$wrapper.data('isotope') && $wrapper.data('isotope').destroy();
									$wrapper.empty();
								}

								if (!$wrapper.hasClass('posts') || $wrapper.closest('.post-archive').length) {
									// Except posts widget, update max page and class
									var max = $content.attr('data-load-max');
									if (max) {
										options.max = parseInt(max);
									}
									$wrapper.append($content.children());
								} else {
									// For posts widget
									$wrapper.append($content);
								}

								// Update wrapper status.
								$wrapper.attr('data-load', JSON.stringify(options));

								if ($wrapper.closest('.product-archive').length || $wrapper.closest('.post-archive').length) {
									AjaxLoadPost.loadedPage(0, result, url, params.type);
								} else {
									// Change load controls for widget
									var loadmore_type = params.type == 'filter' ? options.props.loadmore_type : params.type;

									if (loadmore_type == 'button') {
										if (params.type != 'filter' && $wrapper.hasClass('posts')) {
											var $btn = $wrapper.siblings('.btn-load');
											if ($btn.length) {
												if (typeof options.args == 'undefined' || typeof options.max == 'undefined' ||
													typeof options.args.paged == 'undefined' || options.max <= options.args.paged) {
													$btn.remove();
												} else {
													$btn.html($btn.data('text'));
												}
											}
										} else {
											AjaxLoadPost.refreshButton($wrapper, $result.find('.btn-load'), options);
										}

									} else if (loadmore_type == 'page') {
										var $pagination = $wrapper.parent().find('.pagination')
										var $newPagination = $wrapper.hasClass('posts') ? $(res_pagination) : $result.find('.pagination');
										if ($pagination.length) {
											$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
										} else {
											$newPagination.length && $wrapper.after($newPagination);
										}

									} else if (loadmore_type == 'scroll') {
										$wrapper.addClass('load-scroll');
										if (params.type == 'filter') {
											theme.call(function () {
												AjaxLoadPost.loadmoreByScroll($wrapper);
											}, 50);
										}
									}
								}

								// Init products and posts
								$wrapper.hasClass('products') && theme.woocommerce.initProducts($wrapper);
								$wrapper.hasClass('posts') && AjaxLoadPost.fitVideos($wrapper);

								// Refresh layouts
								if ($wrapper.hasClass('grid')) {
									$wrapper.removeData('isotope');
									theme.isotopes($wrapper);
								}
								if ($wrapper.hasClass('slider-wrapper')) {
									theme.slider($wrapper);
								}

								params.onDone && params.onDone($result, $wrapper, options);

								// If category filter is not set in widget and loadmore has been limited to max, remove data-load attribute
								if (!$wrapper.hasClass('filter-products') &&
									!($wrapper.hasClass('products') && $wrapper.parent().siblings('.nav-filters').length) &&
									options.max && options.max <= options.args.paged && 'page' != params.type) {
									$wrapper.removeAttr('data-load');
								}

								AjaxLoadPost.endLoading($wrapper, params.type);
								params.onAlways && params.onAlways(result, $wrapper, options);
								theme.refreshLayouts();
							});
						}).fail(function (jqxhr) {
							params.onFail && params.onFail(jqxhr, $wrapper);
							AjaxLoadPost.endLoading($wrapper, params.type);
							params.onAlways && params.onAlways(result, $wrapper, options);
						});

					return true;
				}
			}
			return function () {
				AjaxLoadPost.init();
				theme.AjaxLoadPost = AjaxLoadPost;
			}
		})();

		/**
		 * Menu Customize
		 *
		 * @since 1.0
		 */
		theme.menu = (function () {

			function _showMobileMenu(e, callback) {
				var $mmenuContainer = $('.mobile-menu-wrapper .mobile-menu-container');
				theme.$body.addClass('mmenu-active');
				e.preventDefault();

				function initMobileMenu() {
					theme.liveSearch && theme.liveSearch('', $('.mobile-menu-wrapper .search-wrapper'));
					theme.menu.addToggleButtons('.mobile-menu li');
				}

				if (!$mmenuContainer.find('.mobile-menu').length) {
					var cache = theme.getCache(cache);

					// check cached mobile menu.
					if (cache.mobileMenu && cache.mobileMenuLastTime && alpha_vars.menu_last_time &&
						parseInt(cache.mobileMenuLastTime) >= parseInt(alpha_vars.menu_last_time)) {

						// fetch mobile menu from cache
						$mmenuContainer.append(cache.mobileMenu);
						initMobileMenu();
						theme.setCurrentMenuItems('.mobile-menu-wrapper');
					} else {
						// fetch mobile menu from server
						theme.doLoading($mmenuContainer);
						$.post(alpha_vars.ajax_url, {
							action: "alpha_load_mobile_menu",
							nonce: alpha_vars.nonce,
							load_mobile_menu: true,
						}, function (result) {
							result && (result = result.replace(/(class=".*)current_page_parent\s*(.*")/, '$1$2'));
							$mmenuContainer.css('height', '');
							theme.endLoading($mmenuContainer);

							// Add mobile menu search
							$mmenuContainer.append(result);
							initMobileMenu();
							theme.setCurrentMenuItems('.mobile-menu-wrapper');

							// save mobile menu cache
							cache.mobileMenuLastTime = alpha_vars.menu_last_time;
							cache.mobileMenu = result;
							theme.setCache(cache);

							if (typeof callback == 'function') {
								callback();
							}
						});
					}
				} else {
					initMobileMenu();

					if (typeof callback == 'function') {
						callback();
					}
				}
			}

			function _hideMobileMenu(e) {
				e.preventDefault();
				theme.$body.removeClass('mmenu-active');
			}

			var _initMegaMenu = function () {
				// calc megamenu position
				function _recalcMenuPosition() {
					$('nav .menu.horizontal-menu .megamenu').each(function () {
						var $this = $(this),
							o = $this.offset(),
							left = o.left - parseInt($this.css('margin-left')),
							outerWidth = $this.outerWidth(),
							offsetLeft = (left + outerWidth) - (window.innerWidth - 20);

						if ($this.hasClass('full-megamenu') && 0 == $this.closest('.container-fluid').length) {
							$this.css("margin-left", ($(window).width() - outerWidth) / 2 - left + 'px');
						} else if (offsetLeft > 0 && left > 20) {
							$this.css("margin-left", -offsetLeft + 'px');
						}

						$this.parent().addClass('loaded');
					});
				}

				if ($('.toggle-menu.dropdown').length) {
					var $togglebtn = $('.toggle-menu.dropdown .vertical-menu');
					var toggleBtnTop = $togglebtn.length > 0 && $togglebtn.offset().top,
						verticalTop = toggleBtnTop;

					$('.vertical-menu .menu-item-has-children').on('mouseenter', function (e) {
						var $this = $(this);
						if ($this.children('.megamenu').length) {
							var $item = $this.children('.megamenu'),
								offset = $item.offset(),
								top = offset.top - parseInt($item.css('margin-top')),
								outerHeight = $item.outerHeight();

							if (window.pageYOffset > toggleBtnTop) {
								verticalTop = $this.closest('.menu').offset().top;
							} else {
								verticalTop = toggleBtnTop;
							};

							if (typeof (verticalTop) !== 'undefined' && top >= verticalTop) {
								var offsetTop = (top + outerHeight) - window.innerHeight - window.pageYOffset;
								if (offsetTop <= 0) {
									$item.css("margin-top", "0px");
								} else if (offsetTop < top - verticalTop) {
									$item.css("margin-top", -(offsetTop + 5) + 'px');
								} else {
									$item.css("margin-top", -(top - verticalTop) + 'px')
								}
							}
						}
					}
					);
				}

				_recalcMenuPosition();
				theme.$window.on('resize recalc_menus', _recalcMenuPosition);
			}

			return {
				init: function () {
					this.initMenu();
					this.initFilterMenu();
					this.initCollapsibleWidget();
					this.initCollapsibleWidgetToggle();
				},
				initMenu: function ($selector) {
					if (typeof $selector == 'undefined') {
						$selector = '';
					}

					theme.$body
						// no link
						.on('click', $selector + ' .menu-item .nolink', theme.preventDefault)
						.on('click', $selector + ' .menu-item a[href="#"]', theme.preventDefault) // For Unit Test
						// mobile menu
						.on('click', '.mobile-menu-toggle', _showMobileMenu)
						.on('click', '.mobile-menu-overlay', _hideMobileMenu)
						.on('click', '.mobile-menu-close', _hideMobileMenu)
						.on('click', '.mobile-item-categories.show-categories-menu', function (e) {
							_showMobileMenu(e, function () {
								$('.mobile-menu-container .nav a[href="#categories"]').trigger('click');
							});
						})

					window.addEventListener('resize', _hideMobileMenu, { passive: true });

					this.addToggleButtons($selector + ' .collapsible-menu li');

					// toggle dropdown
					theme.$body.on("click", '.dropdown-menu-toggle', theme.preventDefault);


					// megamenu
					_initMegaMenu();

					// lazyload menu image
					alpha_vars.lazyload && theme.call(function () {
						$('.megamenu [data-lazy]').each(function () {
							theme._lazyload_force(this);
						})
					});

					// menu
					$('nav .menu ul:not(.megamenu)').parent().addClass('loaded');
				},
				addToggleButtons: function (selector) {
					theme.$(selector).each(function () {
						var $this = $(this);
						if ($this.hasClass('menu-item-has-children') && !$this.children('a').children('.toggle-btn').length && $this.children('ul').text().trim()) {
							$this.children('a').each(function () {
								var span = document.createElement('span');
								span.className = "toggle-btn";
								this.append(span);
							})
						}
					});
				},
				initFilterMenu: function () {
					theme.$body.on('click', '.with-ul > a i, .menu .toggle-btn, .mobile-menu .toggle-btn', function (e) {
						var $this = $(this);
						var $ul = $this.parent().siblings(':not(.count)');
						if ($ul.length > 1) {
							$this.parent().toggleClass("show").next(':not(.count)').slideToggle(300);
						} else if ($ul.length > 0) {
							$ul.slideToggle(300).parent().toggleClass("show");
						}
						setTimeout(function () {
							$this.closest('.sticky-sidebar').trigger('recalc.pin');
						}, 320);
						e.preventDefault();
					});
				},
				initCollapsibleWidgetToggle: function (selector) {
					$('.widget .product-categories li').add('.sidebar .widget.widget_categories li').add('.widget .product-brands li').add('.store-cat-stack-dokan li').each(function () { // updated(47(
						if (this.lastElementChild && this.lastElementChild.tagName === 'UL') {
							var i = document.createElement('i');
							i.className = alpha_vars.theme_icon_prefix + "-icon-angle-down-solid";
							this.classList.add('with-ul');
							this.classList.add('cat-item');
							this.firstElementChild.appendChild(i);
						}
					});

					theme.$('undefined' == typeof selector ? '.sidebar .widget-collapsible .widget-title' : selector)
						.each(function () {
							var $this = $(this);
							if ($this.closest('.top-filter-widgets').length ||
								$this.closest('.toolbox-horizontal').length ||  // if in shop pages's top-filter sidebar
								$this.siblings('.slider-wrapper').length) {
								return;
							}
							// generate toggle icon
							if (!$this.children('.toggle-btn').length) {
								var span = document.createElement('span');
								span.className = 'toggle-btn';
								this.appendChild(span);
							}
						});
				},
				initCollapsibleWidget: function () {
					// blog sidebar widget init
					$('#blog-sidebar .wp-block-group__inner-container').addClass('widget-collapsible');
					var $widgetTitles = $('#blog-sidebar .wp-block-group__inner-container h2');
					$widgetTitles.addClass('widget-title');
					$widgetTitles.each(function () {
						$(this).html('<span class="wt-area">' + $(this).html() + '</span><span class="toggle-btn"></span>');
					});

					// slideToggle
					theme.$body.on('click', '.sidebar .widget-collapsible .widget-title', function (e) {
						var $this = $(e.currentTarget);

						if ($this.closest('.top-filter-widgets').length ||
							$this.closest('.toolbox-horizontal').length ||  // if in shop pages's top-filter sidebar
							$this.siblings('.slider-wrapper').length ||
							$this.hasClass('sliding')) {
							return;
						}
						var $content = $this.siblings('*:not(script):not(style)');
						$this.hasClass("collapsed") || $content.css('display', 'block');
						$this.addClass("sliding");
						$content.slideToggle(300, function () {
							$this.removeClass("sliding");
							theme.$window.trigger('update_lazyload');
							$('.sticky-sidebar').trigger('recalc.pin');
						});
						$this.toggleClass("collapsed");
					});
				}
			}
		})();

		/**
		 * Product Single Customize
		 *
		 * @since 1.0
		 */
		theme.createProductSingle = (function () {
			function ProductSingle($el) {
				return this.init($el);
			}

			// Public Properties
			ProductSingle.prototype.init = function ($el) {
				this.$product = $el;

				// gallery
				$el.find('.woocommerce-product-gallery').each(function () {
					theme.createProductGallery($(this));
				})

				// variation
				$('.reset_variations').hide().removeClass('d-none');

				// after load, such as quickview
				if ('complete' === theme.status) {
					// variation form
					if ($.fn.wc_variation_form && typeof wc_add_to_cart_variation_params !== 'undefined') {
						this.$product.find('.variations_form').wc_variation_form();
					}

					// quantity input
					theme.quantityInput(this.$product.find('.qty'));

					// countdown
					typeof theme.countdown == 'function' && theme.countdown(this.$product.find('.product-countdown'));
				} else {
					// enable sticky tab
					this.stickyTab(this.$product.find('.product-sticky-tab'));

					// sticky add to cart
					if (!this.$product.hasClass('product-widget') || this.$product.hasClass('product-quickview')) {
						this.stickyCartForm(this.$product.find('.product-sticky-content'));
					}
				}
			}

			/**
			 * Make cart form as sticky
			 *
			 * @since 1.0
			 * @param {string|jQuery} selector
			 * @return {void}
			 */
			ProductSingle.prototype.stickyCartForm = function (selector) {
				var $stickyForm = theme.$(selector);

				if ($stickyForm.length != 1 || $stickyForm.find('.sticky-product-details').length != 0) {
					return;
				}

				var $product = $stickyForm.closest('.product-single');
				var titleEl = $product.find('.product_title').eq(0)[0];
				var $image = $product.find('.woocommerce-product-gallery .wp-post-image').eq(0);
				var imageSrc = alpha_vars.lazyload ? $image.attr('data-lazy') : $image.attr('src');
				var $price = $product.find('p.price');
				var $ratings = $product.find('.woocommerce-product-rating');

				if (!imageSrc) { // for edge's bug
					imageSrc = $image.attr('src');
				}

				// setup sticky form
				$stickyForm.find('.quantity-wrapper').before(
					'<div class="sticky-product-details">' +
					($image.length ? '<img src="' + imageSrc + '" width="' + $image.attr('width') + '" height="' + $image.attr('height') + '" alt="' + $image.attr('alt') + '">' : '') +
					'<div>' +
					(titleEl ? titleEl.outerHTML.replace('<h1', '<h3').replace('h1>', 'h3>').replace('product_title', 'product-title') : '') +
					($price.length ? $price[0].outerHTML : '') + ($ratings.length ? $ratings[0].outerHTML : '') + '</div>'
				);

				var sticky = $stickyForm.data('sticky-content');
				if (sticky) {
					/**
					 * Register getTop function for sticky "add to cart" form, that runs above 768px.
					 *
					 * @since 1.0
					 */
					sticky.getTop = function () {
						var $parent;
						if ($stickyForm.closest('.sticky-sidebar').length) {
							$parent = $product.find('.woocommerce-product-gallery');
						} else if ($stickyForm.closest('.elementor-section').length) {
							$parent = $stickyForm.closest('.elementor-section');
						} else {
							$parent = $stickyForm.closest('.product-single > *');
						}
						return $parent.offset().top + $parent.height();
					}

					sticky.onFixed = function () {
						theme.$body.addClass('addtocart-fixed');
					}

					sticky.onUnfixed = function () {
						theme.$body.removeClass('addtocart-fixed');
					}
				}

				// Fix top in mobile, fix bottom otherwise
				function _changeFixPos() {
					theme.requestTimeout(function () {
						$stickyForm.removeClass('fix-top fix-bottom').addClass(window.innerWidth < 768 ? 'fix-top' : 'fix-bottom');
					}, 50);
				}

				theme.$window.on('sticky_refresh_size.alpha', _changeFixPos);

				_changeFixPos();
			}

			/**
			 * Make product tab sticky
			 *
			 * @since 1.0
			 * @param selector
			 * @return void
			 */
			ProductSingle.prototype.stickyTab = function (selector) {
				var $stickyTab = theme.$(selector);

				if ($stickyTab.length != 1) {
					return;
				}

				theme.$body.on('click', '.product-sticky-tab.fixed a.nav-link', function (e) {
					theme.scrollTo($('.woocommerce-tabs'));
				})

				var sticky = $stickyTab.data('sticky-content');
				if (sticky) {
					/**
					 * Register getTop function for sticky "add to cart" form, that runs above 768px.
					 *
					 * @since 1.0
					 */
					sticky.getTop = function () {
						var $parent = $stickyTab.closest('.woocommerce-tabs');
						return $parent.offset().top + 100;
					}
				}
			}

			return function (selector) {
				theme.$(selector).each(function () {
					var $this = $(this);
					$this.data('alpha_product_single', new ProductSingle($this));
				});
			}
		})();

		/**
		 * Create quantity input object
		 *
		 * @class QuantityInput
		 * @since 1.0
		 * @param {string} selector
		 * @return {void}
		 */
		theme.quantityInput = (function () {

			function QuantityInput($el) {
				return this.init($el);
			}

			QuantityInput.min = 1;
			QuantityInput.max = 1000000;

			QuantityInput.prototype.init = function ($el) {
				var self = this;

				self.$minus = false;
				self.$plus = false;
				self.$value = false;
				self.value = false;

				// call Events
				self.startIncrease = self.startIncrease.bind(self);
				self.startDecrease = self.startDecrease.bind(self);
				self.stop = self.stop.bind(self);

				// Variables
				self.min = parseInt($el.attr('min'));
				self.max = parseInt($el.attr('max'));

				self.min || ($el.attr('min', self.min = QuantityInput.min))
				self.max || ($el.attr('max', self.max = QuantityInput.max))

				// Add DOM elements and event listeners
				self.$value = $el.val(self.value = Math.max(parseInt($el.val()), 1));
				self.$minus = $el.parent().find('.quantity-minus').on('click', theme.preventDefault);
				self.$plus = $el.parent().find('.quantity-plus').on('click', theme.preventDefault);

				if ('ontouchstart' in document) {
					self.$minus.get(0).addEventListener('touchstart', self.startDecrease, { passive: true })
					self.$plus.get(0).addEventListener('touchstart', self.startIncrease, { passive: true })
				} else {
					self.$minus.on('mousedown', self.startDecrease)
					self.$plus.on('mousedown', self.startIncrease)
				}

				var $cart_button = $el.closest('.product').find('.ajax_add_to_cart');

				if ($cart_button.length) {
					self.$value.on('change', function () {
						$cart_button[0].dataset.quantity = $(this).val();
					});
				}

				theme.$body.on('mouseup', self.stop)
					.on('touchend', self.stop);
			}

			QuantityInput.prototype.startIncrease = function (e) {
				var self = this;
				self.value = self.$value.val();
				self.value < self.max && (self.$value.val(++self.value), self.$value.trigger('change'));
				self.increaseTimer = theme.requestTimeout(function () {
					self.speed = 1;
					self.increaseTimer = theme.requestInterval(function () {
						self.$value.val(self.value = Math.min(self.value + Math.floor(self.speed *= 1.05), self.max));
					}, 50);
				}, 400);
			}

			QuantityInput.prototype.stop = function (e) {
				(this.increaseTimer || this.decreaseTimer) && this.$value.trigger('change');
				this.increaseTimer && (theme.deleteTimeout(this.increaseTimer), this.increaseTimer = 0);
				this.decreaseTimer && (theme.deleteTimeout(this.decreaseTimer), this.decreaseTimer = 0);
			}

			QuantityInput.prototype.startDecrease = function (e) {
				var self = this;
				self.value = self.$value.val();
				self.value > self.min && (self.$value.val(--self.value), self.$value.trigger('change'));
				self.decreaseTimer = theme.requestTimeout(function () {
					self.speed = 1;
					self.decreaseTimer = theme.requestInterval(function () {
						self.$value.val(self.value = Math.max(self.value - Math.floor(self.speed *= 1.05), self.min));
					}, 50);
				}, 400);
			}

			return function (selector) {
				theme.$(selector).each(function () {
					var $this = $(this);
					// if not initialized
					$this.data('quantityInput') ||
						$this.data('quantityInput', new QuantityInput($this));
				});
			}
		})();
	}

	/**
	 * Reviews login popup
	 *
	 * @since 1.0
	 */
	function initReviewsPopup() {
		theme.$body.on('click', '.submit-review-toggle', function (e) {
			e.preventDefault();
			var ajax_data = {
				action: 'alpha_reviews',
				product_id: $(this).data('id')
			}
			theme.popup({
				type: 'ajax',
				mainClass: 'mfp-reviews mfp-fade',
				tLoading: '<div class="reviews-popup"><div class="d-loading bg-transparent"><i></i></div></div>',
				preloader: true,
				items: {
					src: alpha_vars.ajax_url
				},
				ajax: {
					settings: {
						method: 'POST',
						data: ajax_data,
					},
					cursor: 'mfp-ajax-cur', // CSS class that will be added to body during the loading (adds "progress" cursor)
					tError: '<div class="alert alert-warning alert-round alert-inline">' + alpha_vars.texts.popup_error + '<button type="button" class="btn btn-link btn-close"><i class="close-icon"></i></button></div>'
				},
				callbacks: {
					afterChange: function () {
						this.container.html('<div class="mfp-content"></div><div class="mfp-preloader"><div class="reviews-popup"><div class="d-loading bg-transparent"><i></i></div></div></div>');
						this.contentContainer = this.container.children('.mfp-content');
						this.preloader = false;
					},
					beforeClose: function () {
						this.container.empty();
					},
					ajaxContentAdded: function () {
						var self = this;
						theme.$('.reviews-popup #rating').trigger('init');
						$('form.comment-form').attr('enctype', 'multipart/form-data');
						setTimeout(function () {
							self.contentContainer.next('.mfp-preloader').remove();
						}, 200);
					}
				}
			});
		});
	}

	/**
	 * Shortcode copy function in Elementor Preview Panel
	 * 
	 * @since 1.0
	 */
	theme.shortcodeCopy = function () {
		theme.$body.on('click', '.shortcode-copy', function (e) {
			e.preventDefault();
			var $this = $(this);
			// copy shortcode
			$this.closest('.shortcode-template').find('.shortcode-text').trigger('select');
			document.execCommand('copy');
			theme.$body.find('.copied').removeClass('copied').html('<i class="fas fa-download"></i><span>Copy Shortcode​</span>');
			$this.addClass('copied').html('<i class="fas fa-check"></i>Copied to clipboard');
			// show tooltip
			if ($('.copy-toast').length == 0)
				theme.$body.append('<div class="copy-toast"><h6 class="toast-text"><i class="fas fa-check"></i>Successfully Copied! <small>(Use Alt + V to paste)</small></h6></div>');
			//show
			setTimeout(function () {
				$('.copy-toast').addClass('toast-show');
			}, 300);
			//hide
			setTimeout(function () {
				$('.copy-toast').removeClass('toast-show');
			}, 4000);
		});

		theme.$body.on('keydown', function (e) {
			if (e.key == "v" && e.altKey == true) {
				// Alt + v

				if (typeof elementor == 'undefined') {
					return window.alert("Please paste in Elementor Preview Panel");
				}
				navigator.clipboard.readText().then(result => {
					try {
						e.preventDefault();
						mergeContent(JSON.parse(decodeURIComponent(result)));
					} catch (e) {
						console.warn(e);
					}
				}
				);
			}
		});
		//show widget on editor
		function mergeContent(copyElement) {
			var res = copyElement;
			if (res) {
				var addID = function (res) {
					if (elementorCommon != undefined) {
						Array.isArray(res) &&
							res.forEach(function (item, i) {
								item.elements && addID(item.elements);
								item.elType && (res[i].id = elementorCommon.helpers.getUniqueId());
							});
					}
				};

				if (Array.isArray(res)) {
					var isAllWidgets = true;
					res.forEach(function (element) {
						if (element.elType != 'widget') {
							isAllWidgets = false;
							return false;
						}
					});
					if (isAllWidgets) {
						res = [{
							elType: 'section',
							elements: [{
								elType: 'column',
								elements: res
							}]
						}];
					} else {
						res.forEach(function (element, i) {
							if ('widget' == element.elType) {
								res[i] = {
									elType: 'section',
									elements: [{
										elType: 'column',
										elements: element
									}]
								};
							} else if ('column' == element.elType) {
								res[i] = {
									elType: 'section',
									elements: element
								};
							}
						})
					}
				}
				addID(res);
				if (elementor != undefined) {
					elementor.getPreviewView().addChildModel(res, {});
				}
			}
		}
	}


	$(window).on('load', function () {
		// reviews popup
		initReviewsPopup();

		// remove default behaviour of wishlist action
		theme.$window.on('alpha_complete', function () {
			theme.$body.off('click', '.yith-wcwl-wishlistexistsbrowse a, .yith-wcwl-wishlistaddedbrowse a');
			theme.shortcodeCopy();
		});

		frameworkCustomize();

	});
})(jQuery);