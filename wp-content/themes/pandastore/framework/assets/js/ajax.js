/**
 * WP Alpha FrameWork
 * Alpha Ajax
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.2.0
 */

window.theme = window.theme || {};

( function ( $ ) {

    /**
     * Initialize ajax load post
     *
     * @since 1.0
     * @return {void}
     */
    theme.initAjaxLoadPost = ( function () {
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
            isAjaxShop: alpha_vars.shop_ajax ? $( document.body ).hasClass( 'alpha-archive-product-layout' ) : false,
            isAjaxBlog: alpha_vars.blog_ajax ? $( document.body ).hasClass( 'alpha-archive-post-layout' ) : false,
            scrollWrappers: false,
            ajax_tab_cache: {},
			/**
			 * Initialize
			 *
			 * @since 1.0
			 * @return {void}
			 */
            init: function () {

                if ( AjaxLoadPost.isAjaxShop ) {
                    theme.$body
                        .on( 'click', '.widget_product_categories a, .wc-block-product-categories-list-item a', this.filterByCategory )				// Product Category
                        .on( 'click', '.widget_product_tag_cloud a', this.filterByLink )					// Product Tag Cloud
                        .on( 'click', '.alpha-price-filter a', this.filterByLink )						// Alpha - Price Filter
                        .on( 'click', '.woocommerce-widget-layered-nav a', this.filterByLink )			// Filter Products by Attribute
                        .on( 'click', '.widget-filter-attribute a', this.filterByLink )					// Filter Products by Attributes
                        .on( 'click', '.widget_price_filter .button', this.filterByPrice )				// Filter Products by Price
                        .on( 'submit', '.alpha-price-range', this.filterByPriceRange )					// Filter Products by Price Range
                        .on( 'click', '.widget_rating_filter a', this.filterByRating )					// Filter Products by Rating
                        .on( 'click', '.filter-clean', this.filterByLink )								// Reset Filter
                        .on( 'click', '.toolbox-show-type .btn-showtype', this.changeShowType )			// Change Show Type
                        .on( 'change', '.toolbox-show-count .count', this.changeShowCount )				// Change Show Count
                        .on( 'click', '.yith-woo-ajax-navigation a', this.saveLastYithAjaxTrigger )       // Compatibility with YITH ajax navigation
                        .on( 'change', '.sidebar select.dropdown_product_cat', this.filterByCategory )    // Filter by category dropdown
                        .on( 'click', '.categories-filter-shop .product-category a', this.filterByCategory ) // Filter by product categories widget in shop page
                        .on( 'click', '.product-archive + div .pagination a' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_pagination .pagination a`, this.loadmoreByPagination ) // Load by pagination in shop page

                    $( '.toolbox .woocommerce-ordering' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_sort .woocommerce-ordering` )													// Orderby
                        .off( 'change', 'select.orderby' ).on( 'change', 'select.orderby', this.sortProducts );

                    $( '.product-archive > .woocommerce-info' ).wrap( '<ul class="products"></ul>' );

                    if ( !alpha_vars.skeleton_screen ) {
                        $( '.sidebar .dropdown_product_cat' ).off( 'change' );
                    }
                } else {
                    theme.$body
                        .on( 'change', '.toolbox-show-count .count', this.changeShowCountPage )            // Change Show Count when ajax disabled
                        .on( 'change', '.sidebar select.dropdown_product_cat', this.changeCategory )		 // Change category by dropdown

                    AjaxLoadPost.initSelect2();
                }

                AjaxLoadPost.isAjaxBlog && theme.$body
                    .on( 'click', '.widget_categories a', this.filterPostsByLink )                    // Filter blog by categories
                    .on( 'click', '.post-archive .post-filters a', this.filterPostsByLink )           // Filter blog by categories filter
                    .on( 'click', '.post-archive .pagination a', this.loadmoreByPagination )          // Load by pagination in shop page

                theme.$body
                    .on( 'click', '.btn-load', this.loadmoreByButton )						        // Load by button
                    .on( 'click', '.products + .pagination a', this.loadmoreByPagination )              // Load by pagination in products widget
                    .on( 'click', '.products .pagination a', this.loadmoreByPagination )              // Load by pagination in products widget
                    .on( 'click', '.product-filters .nav-filter', this.filterWidgetByCategory )	    // Load by Nav Filter
                    .on( 'click', '.filter-categories a', this.filterWidgetByCategory )		        // Load by Categories Widget's Filter
                    .on( 'click', 'div:not(.post-archive) > .posts + .pagination a', this.loadmoreByPagination )				// Load by pagination in posts widget

                theme.$window.on( 'alpha_loadmore', this.startScrollLoad );	    // Load by infinite scroll
                this.startScrollLoad();

                // YITH AJAX Navigation Plugin Compatibility
                if ( typeof yith_wcan != 'undefined' ) {
                    $( document )
                        .on( 'yith-wcan-ajax-loading', this.loadingPage )
                        .on( 'yith-wcan-ajax-filtered', this.loadedPage );

                    // Issue for multiple products in shop pages.
                    $( '.yit-wcan-container' ).each( function () {
                        $( this ).parent( '.product-archive' ).length || $( this ).children( '.products' ).addClass( 'ywcps-products' ).unwrap();
                    } );
                    yith_wcan.container = '.product-archive .products';
                }
            },

			/**
			 * Run select2 js plugin
			 */
            initSelect2: function () {
                if ( $.fn.selectWoo ) {
                    $( '.dropdown_product_cat' ).selectWoo( {
                        placeholder: alpha_vars.select_category,
                        minimumResultsForSearch: 5,
                        width: '100%',
                        allowClear: true,
                        language: {
                            noResults: function () {
                                return alpha_vars.no_matched
                            }
                        }
                    } )
                }
            },

			/**
			 * Event handler to change show count for non ajax mode.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            changeShowCountPage: function ( e ) {
                if ( this.value ) {
                    location.href = theme.addUrlParam( location.href.replace( /\/page\/\d*/, '' ), 'count', this.value );
                }
            },

			/**
			 * Event handler to change category by dropdown
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            changeCategory: function ( e ) {
                location.href = this.value ? theme.addUrlParam( alpha_vars.home_url, 'product_cat', this.value ) : alpha_vars.shop_url;
            },

			/**
			 * Event handler to filter posts by link
			 *
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterPostsByLink: function ( e ) {

                // If link's toggle is clicked, return
                if ( ( e.target.tagName == 'I' || e.target.classList.contains( 'toggle-btn' ) ) && e.target.parentElement == e.currentTarget ) {
                    return;
                }

                var $link = $( e.currentTarget );

                if ( $link.hasClass( 'active' ) || $link.parent().hasClass( 'current-cat' ) ) {
                    e.preventDefault();
                    return;
                }
                if ( $link.is( '.nav-filters .nav-filter' ) ) {
                    $link.closest( '.nav-filters' ).find( '.nav-filter' ).removeClass( 'active' );
                    $link.addClass( 'active' )
                }

                var $container = $( '.post-archive .posts' );

                if ( !$container.length ) {
                    return;
                }

                if ( AjaxLoadPost.isAjaxBlog && AjaxLoadPost.doLoading( $container, 'filter' ) ) {
                    e.preventDefault();
                    var url = theme.addUrlParam( e.currentTarget.getAttribute( 'href' ), 'only_posts', 1 );
                    var postType = $container.data( 'post-type' );
                    if ( postType ) {
                        url = theme.addUrlParam( url, 'post_style_type', postType );
                    }
                    $.get( encodeURI( decodeURIComponent( decodeURI( url.replace( /\/page\/(\d*)/, '' ) ) ) ), function ( res ) {
                        res && AjaxLoadPost.loadedPage( 0, res, url );
                    } );
                }
            },

			/**
			 * Event handler to filter products by price
			 *
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterByPrice: function ( e ) {
                e.preventDefault();
                var url = location.href,
                    minPrice = $( e.currentTarget ).siblings( '#min_price' ).val(),
                    maxPrice = $( e.currentTarget ).siblings( '#max_price' ).val();
                minPrice && ( url = theme.addUrlParam( url, 'min_price', minPrice ) );
                maxPrice && ( url = theme.addUrlParam( url, 'max_price', maxPrice ) );
                AjaxLoadPost.loadPage( url );
            },

			/**
			 * Event handler to filter products by price
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterByPriceRange: function ( e ) {
                e.preventDefault();
                var url = location.href,
                    minPrice = $( e.currentTarget ).find( '.min_price' ).val(),
                    maxPrice = $( e.currentTarget ).find( '.max_price' ).val();
                url = minPrice ? theme.addUrlParam( url, 'min_price', minPrice ) : theme.removeUrlParam( url, 'min_price' );
                url = maxPrice ? theme.addUrlParam( url, 'max_price', maxPrice ) : theme.removeUrlParam( url, 'max_price' );
                url != location.href && AjaxLoadPost.loadPage( url );
            },

			/**
			 * Event handler to filter products by rating
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterByRating: function ( e ) {
                var match = e.currentTarget.getAttribute( 'href' ).match( /rating_filter=(\d)/ );
                if ( match && match[ 1 ] ) {
                    e.preventDefault();
                    AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'rating_filter', match[ 1 ] ) );
                }
            },

			/**
			 * Event handler to filter products by link
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterByLink: function ( e ) {
                e.preventDefault();
                AjaxLoadPost.loadPage( e.currentTarget.getAttribute( 'href' ) );
            },

			/**
			 * Event handler to filter products by category
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            filterByCategory: function ( e ) {
                e.preventDefault();

                var url;
                var isFromFilterWidget = false;

                if ( e.type == 'change' ) { // Dropdown's event
                    url = this.value ? theme.addUrlParam( alpha_vars.home_url, 'product_cat', this.value ) : alpha_vars.shop_url;

                } else { // Link's event
                    // If link's toggle is clicked, return
                    if ( e.target.parentElement == e.currentTarget ) {
                        return;
                    }
                    var $link = $( e.currentTarget );

                    if ( $link.is( '.categories-filter-shop .product-category a' ) ) {
                        // Products categories widget
                        var $category = $link.closest( '.product-category' );
                        if ( $category.hasClass( 'active' ) ) {
                            return;
                        }
                        $category.closest( '.categories-filter-shop' ).find( '.product-category' ).removeClass( 'active' );
                        $category.addClass( 'active' );
                        isFromFilterWidget = true;

                    } else {
                        // Product categories sidebar widget
                        if ( $link.hasClass( 'active' ) || $link.parent().hasClass( 'current-cat' ) ) {
                            // If it's active, return
                            theme.endLoading( $link.closest( '.product-categories' ) );
                            return;
                        }
                    }
                    url = $link.attr( 'href' );
                }

                // Make current category active in categories-filter-shop widgets
                if ( !isFromFilterWidget ) {
                    theme.$body.one( 'alpha_ajax_shop_layout', function () {
                        $( '.categories-filter-shop .product-category a' ).each( function () {
                            $( this ).closest( '.product-category' ).toggleClass( 'active', this.href == location.href );
                        } )
                    } );
                }

                AjaxLoadPost.loadPage( url );
            },

			/**
			 * Event handler to filter products by category.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            saveLastYithAjaxTrigger: function ( e ) {
                AjaxLoadPost.lastYithAjaxTrigger = e.currentTarget;
            },

			/**
			 * Event handler to change show type.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            changeShowType: function ( e ) {
                e.preventDefault();
                if ( !this.classList.contains( 'active' ) ) {
                    var type = this.classList.contains( alpha_vars.theme_icon_prefix + '-icon-list' ) ? 'list' : 'grid';
                    $( '.product-archive .products' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` ).data( 'loading_show_type', type )	// For skeleton screen
                    $( this ).parent().children().toggleClass( 'active' );				// Toggle active class
                    AjaxLoadPost.loadPage(
                        theme.addUrlParam( location.href, 'showtype', type ),
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
            sortProducts: function ( e ) {
                AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'orderby', this.value ) );
            },

			/**
			 * Event handler to change show count.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
            changeShowCount: function ( e ) {
                AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'count', this.value ) );
            },

			/**
			 * Refresh widgets
			 * 
			 * @since 1.0
			 * @param {string} widgetSelector
			 * @param {jQuery} $newContent 
			 */
            refreshWidget: function ( widgetSelector, $newContent ) {
                var newWidgets = $newContent.find( '.sidebar ' + widgetSelector ),
                    oldWidgets = $( '.sidebar ' + widgetSelector );

                oldWidgets.length && oldWidgets.each( function ( i ) {
                    // if new widget exists
                    if ( newWidgets.eq( i ).length ) {
                        this.innerHTML = newWidgets.eq( i ).html();
                    } else {
                        // else
                        $( this ).empty();
                    }
                } );
            },

			/**
			 * Refresh button
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {jQuery} $newButton
			 * @param {object} options
			 */
            refreshButton: function ( $wrapper, $newButton, options ) {
                var $btn = $wrapper.siblings( '.btn-load' );

                if ( typeof options != 'undefined' ) {
                    if ( typeof options == 'string' && options ) {
                        options = JSON.parse( options );
                    }
                    if ( !options.args || !options.args.paged || options.max > options.args.paged ) {
                        if ( $btn.length ) {
                            $btn[ 0 ].outerHTML = $newButton.length ? $newButton[ 0 ].outerHTML : '';
                        } else {
                            $newButton.length && $wrapper.after( $newButton );
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
            loadPage: function ( url, data ) {
                AjaxLoadPost.loadingPage();

                // If it's not "show type change" load, remove page number from url
                if ( 'undefined' == typeof showtype ) {
                    url = encodeURI( decodeURIComponent( decodeURI( url.replace( /\/page\/(\d*)/, '' ) ) ) );
                }

                // Add show type if current layout is list
                if ( data && 'list' == data.showtype || ( !data || 'undefined' == typeof data.showtype ) && 'list' == theme.getUrlParam( location.href, 'showtype' ) ) {
                    url = theme.addUrlParam( url, 'showtype', 'list' );
                } else {
                    url = theme.removeUrlParam( url, 'showtype' );
                }

                // Add show count if current show count is set, except show count change
                if ( !theme.getUrlParam( url, 'count' ) ) {
                    var showcount = theme.getUrlParam( location.href, 'count' );
                    if ( showcount ) {
                        url = theme.addUrlParam( url, 'count', showcount );
                    }
                }

                $.get( theme.addUrlParam( url, 'only_posts', 1 ), function ( res ) {
                    res && AjaxLoadPost.loadedPage( 0, res, url );
                } );
            },

			/**
			 * Process while loading. 
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
            loadingPage: function ( e ) {
                var $container = $( '.product-archive .products' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` );

                if ( $container.length ) {
                    if ( e && e.type == 'yith-wcan-ajax-loading' ) {
                        $container.removeClass( 'yith-wcan-loading' ).addClass( 'product-filtering' );
                    }
                    if ( AjaxLoadPost.doLoading( $container, 'filter' ) ) {
                        theme.scrollToFixedContent(
                            ( $( '.toolbox-top' ).length ? $( '.toolbox-top' ) : $container ).offset().top - 20,
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
            loadedPage: function ( e, res, url, loadmore_type ) {
                var $res = $( res );
                $res.imagesLoaded( function () {

                    var $container, $newContainer;

                    // Update browser history (IE doesn't support it)
                    if ( url && !theme.isIE && loadmore_type != 'button' && loadmore_type != 'scroll' ) {
                        history.pushState( { pageTitle: res && res.pageTitle ? '' : res.pageTitle }, "", theme.removeUrlParam( url, 'only_posts' ) );
                    }

                    if ( typeof loadmore_type == 'undefined' ) {
                        loadmore_type = 'filter';
                    }

                    if ( AjaxLoadPost.isAjaxBlog ) {
                        $container = $( '.post-archive .posts' );
                        $newContainer = $res.find( '.post-archive .posts' );
                        if ( !$newContainer.length ) {
                            $res.each( function () {
                                var $this = $( this );
                                if ( $this.hasClass( 'post-archive' ) ) {
                                    $newContainer = $this.find( '.posts' );
                                    return false;
                                }
                            } );
                        }
                    } else if ( AjaxLoadPost.isAjaxShop ) {
                        $container = $( '.product-archive .products' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` );
                        $newContainer = $res.find( '.product-archive .products' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` );
                    } else {
                        $container = $( '.post-archive .posts' );
                        $newContainer = $res.find( '.post-archive .posts' );
                        if ( !$newContainer.length ) {
                            $newContainer = $res.find( '.posts' );
                        }

                        // Update Loadmore - Button
                        if ( $container.hasClass( 'posts' ) ) { // Blog Archive
                            AjaxLoadPost.refreshButton( $container, $newContainer.siblings( '.btn-load' ), $container.attr( 'data-load' ) );
                        } else {
                            $container = $( '.product-archive .products' );
                            $newContainer = $res.find( '.product-archive .products' );

                            if ( $container.hasClass( 'products' ) ) { // Shop Archive
                                var $parent = $( '.product-archive' ),
                                    $newParent = $res.find( '.product-archive' );
                                AjaxLoadPost.refreshButton( $parent, $newParent.siblings( '.btn-load' ), $container.attr( 'data-load' ) );
                            }
                        }
                        return;
                    }

                    // Change content and update status.
                    // When loadmore by button, scroll or pagination is performing, the 'loadmore' function performs this.
                    if ( loadmore_type == 'filter' ) {
                        $container.html( $newContainer.html() );
                        AjaxLoadPost.endLoading( $container, loadmore_type );

                        // Update Loadmore
                        if ( $newContainer.attr( 'data-load' ) ) {
                            $container.attr( 'data-load', $newContainer.attr( 'data-load' ) );
                        } else {
                            $container.removeAttr( 'data-load' );
                        }
                    }

                    // Change page title bar
                    $( '.page-title-bar' ).html( $res.find( '.page-title-bar' ).length ? $res.find( '.page-title-bar' ).html() : '' );


                    if ( AjaxLoadPost.isAjaxBlog ) { // Blog Archive

                        // Update Loadmore - Button
                        AjaxLoadPost.refreshButton( $container, $newContainer.siblings( '.btn-load' ), $container.attr( 'data-load' ) );

                        // Update Loadmore - Pagination
                        var $pagination = $container.siblings( '.pagination' ),
                            $newPagination = $newContainer.siblings( '.pagination' );

                        if ( $pagination.length ) {
                            $pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
                        } else {
                            $newPagination.length && $container.after( $newPagination );
                        }

                        // Update sidebar widgets
                        AjaxLoadPost.refreshWidget( '.widget_categories', $res );
                        AjaxLoadPost.refreshWidget( '.widget_tag_cloud', $res );

                        // Update nav filter
                        var $newNavFilters = $res.find( '.post-archive .nav-filters' );
                        $newNavFilters.length && $( '.post-archive .nav-filters' ).html( $newNavFilters.html() );

                        // Init posts
                        AjaxLoadPost.fitVideos( $container );
                        theme.slider( '.post-media-carousel' );

                        theme.$body.trigger( 'alpha_ajax_blog_layout', $container, res, url, loadmore_type );

                    } else if ( AjaxLoadPost.isAjaxShop ) { // Products Archive

                        var $parent = $( '.product-archive' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` ),
                            $newParent = $res.find( '.product-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` );

                        // If new content is empty, show woocommerce info.
                        if ( !$newContainer.length ) {
                            $container.empty().append( $res.find( '.woocommerce-info' ) );
                        }

                        // Update Toolbox Title
                        var $newTitle = $res.find( '.main-content .toolbox .title' );
                        $newTitle.length && $( '.main-content .toolbox .title' ).html( $newTitle.html() );

                        // Update nav filter
                        var $newNavFilters = $res.find( '.main-content .toolbox .nav-filters' );
                        $newNavFilters.length && $( '.main-content .toolbox .nav-filters' ).html( $newNavFilters.html() );

                        // Update Show Count
                        if ( typeof loadmore_type != 'undefined' && ( loadmore_type == 'button' || loadmore_type == 'scroll' ) ) {
                            var $span = $( '.main-content .woocommerce-result-count > span' );
                            if ( $span.length ) {
                                var newShowInfo = $span.html(),
                                    match = newShowInfo.match( /\d+\–(\d+)/ );
                                if ( match && match[ 1 ] ) {
                                    var last = parseInt( match[ 1 ] ) + $newContainer.children().length,
                                        match = newShowInfo.replace( /\d+\–\d+/, '' ).match( /\d+/ );
                                    $span.html( match && match[ 0 ] && last == match[ 0 ] ? alpha_vars.texts.show_info_all.replace( '%d', last ) : newShowInfo.replace( /(\d+)\–\d+/, '$1–' + last ) );
                                }
                            }
                        } else {
                            var $count = $( '.main-content .woocommerce-result-count' );
                            var $toolbox = $count.parent( '.toolbox-pagination' );
                            var newShowInfo = $res.find( '.woocommerce-result-count' ).html();

                            $count.html( newShowInfo ? newShowInfo : '' );
                            newShowInfo ? $toolbox.removeClass( 'no-pagination' ) : $toolbox.addClass( 'no-pagination' );
                        }

                        // Update Toolbox Pagination
                        var $toolboxPagination = $parent.siblings( '.toolbox-pagination' ),
                            $newToolboxPagination = $newParent.siblings( '.toolbox-pagination' );

                        if ( !$toolboxPagination.length ) {
                            $newToolboxPagination.length && $parent.after( $newToolboxPagination );

                        } else { // Update Loadmore - Pagination
                            var $pagination = $parent.siblings( '.toolbox-pagination' ).find( '.pagination' ),
                                $newPagination = $newParent.siblings( '.toolbox-pagination' ).find( '.pagination' );

                            if ( $pagination.length ) {
                                $pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
                            } else {
                                $newPagination.length && $parent.siblings( '.toolbox-pagination' ).append( $newPagination );
                            }
                        }

                        // Update Shop Pagination Widget
                        var $shopPagination = $( `.elementor-widget-${ alpha_vars.theme }_shop_widget_pagination` ),
                            $newShopPagination = $res.find( `.elementor-widget-${ alpha_vars.theme }_shop_widget_pagination` );

                        if ( $shopPagination.length ) {
                            var $paginationContainer = $shopPagination.find( '.elementor-widget-container' ),
                                $newPaginationContainer = $newShopPagination.find( '.elementor-widget-container' );

                            $paginationContainer.html( $newPaginationContainer.html() );
                        }

                        // Update Loadmore - Button
                        AjaxLoadPost.refreshButton( $parent, $newParent.siblings( '.btn-load' ), $container.attr( 'data-load' ) );

                        // Update Sidebar Widgets
                        if ( loadmore_type == 'filter' ) {
                            AjaxLoadPost.refreshWidget( '.alpha-price-filter', $res );

                            AjaxLoadPost.refreshWidget( '.widget_rating_filter', $res );
                            theme.woocommerce.ratingTooltip( '.widget_rating_filter' )

                            AjaxLoadPost.refreshWidget( '.widget_price_filter', $res );
                            theme.initPriceSlider();

                            AjaxLoadPost.refreshWidget( '.widget_product_categories', $res );

                            AjaxLoadPost.refreshWidget( '.widget_product_brands', $res );

                            AjaxLoadPost.refreshWidget( '.widget-filter-attribute', $res );

                            AjaxLoadPost.refreshWidget( '.filter-actions', $res );
                            // Refresh Filter Products by Attribute Widgets
                            AjaxLoadPost.refreshWidget( '.woocommerce-widget-layered-nav:not(.widget_product_brands)', $res );

                            if ( !e || e.type != "yith-wcan-ajax-filtered" ) {
                                // Refresh YITH Ajax Navigation Widgets
                                AjaxLoadPost.refreshWidget( '.yith-woo-ajax-navigation', $res );
                            } else {
                                yith_wcan && $( yith_wcan.result_count ).show();
                                var $last = $( AjaxLoadPost.lastYithAjaxTrigger );
                                $last.closest( '.yith-woo-ajax-navigation' ).is( ':hidden' ) && $last.parent().toggleClass( 'chosen' );
                                $( '.sidebar .yith-woo-ajax-navigation' ).show();
                            }

                            AjaxLoadPost.initSelect2();
                        }

                        if ( !$container.hasClass( 'skeleton-body' ) ) {
                            if ( $container.data( 'loading_show_type' ) ) {
                                $container.toggleClass( 'list-type-products', 'list' == $container.data( 'loading_show_type' ) );
                                $container.attr( 'class',
                                    $container.attr( 'class' ).replace( /row|cols\-\d|cols\-\w\w-\d/g, '' ).replace( /\s+/, ' ' ) +
                                    $container.attr( 'data-col-' + $container.data( 'loading_show_type' ) )
                                );
                                $( '.main-content-wrap > .sidebar.closed' ).length && theme.shop.switchColumns( false );
                            }
                        }

                        // Remove loading show type.
                        $container.removeData( 'loading_show_type' );

                        // Init products
                        theme.woocommerce.initProducts( $container );

                        theme.$body.trigger( 'alpha_ajax_shop_layout', $container, res, url, loadmore_type );

                        $container.removeClass( 'product-filtering' );
                    }


                    $container.removeClass( 'skeleton-body load-scroll' );
                    $newContainer.hasClass( 'load-scroll' ) && $container.addClass( 'load-scroll' );

                    // Sidebar Widget Compatibility
                    theme.menu.initCollapsibleWidgetToggle();

                    // Isotope Refresh
                    if ( $container.hasClass( 'grid' ) ) {
                        $container.data( 'isotope' ) && $container.isotope( 'destroy' );
                        theme.isotopes( $container );
                    }

                    // countdown init
                    if ( typeof theme.countdown == 'function' ) {
                        theme.countdown( $container.find( '.countdown' ) );
                    }

                    // Update Loadmore - Scroll
                    theme.call( AjaxLoadPost.startScrollLoad, 50 );

                    // Refresh layouts
                    theme.call( theme.refreshLayouts, 70 );

                    theme.$body.trigger( 'alpha_ajax_finish_layout', $container, res, url, loadmore_type );
                } );
            },

			/**
			 * Check load 
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {string} type
			 */
            canLoad: function ( $wrapper, type ) {
                // check max
                if ( type == 'button' || type == 'scroll' ) {
                    var load = $wrapper.attr( 'data-load' );
                    if ( load ) {
                        var options = JSON.parse( $wrapper.attr( 'data-load' ) );
                        if ( options && options.args && options.max <= options.args.paged ) {
                            return false;
                        }
                    }
                }

                // If it is loading or active, return
                if ( $wrapper.hasClass( 'loading-more' ) || $wrapper.hasClass( 'skeleton-body' ) || $wrapper.siblings( '.d-loading' ).length ) {
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
            doLoading: function ( $wrapper, type ) {
                if ( !AjaxLoadPost.canLoad( $wrapper, type ) ) {
                    return false;
                }

                // "Loading start" effect
                if ( alpha_vars.skeleton_screen && $wrapper.closest( '.product-archive, .post-archive' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) {

                    // Skeleton screen for archive pages

                    var count = 12,
                        template = '';

                    if ( $wrapper.closest( '.product-archive' ).add( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) {
                        // Shop Ajax
                        count = parseInt( theme.getCookie( 'alpha_count' ) );
                        if ( !count ) {
                            var $count = $( '.main-content .toolbox-show-count .count' );
                            $count.length && ( count = $count.val() );
                        }
                        count || ( count = 12 );
                    } else if ( $wrapper.closest( '.post-archive' ).length ) {

                        // Blog Ajax
                        $wrapper.children( '.grid-space' ).remove();
                        count = alpha_vars.posts_per_page;
                    }

                    if ( $wrapper.hasClass( 'products' ) ) {
                        // product template
                        var skelType = $wrapper.hasClass( 'list-type-products' ) ? 'skel-pro skel-pro-list' : 'skel-pro';
                        if ( $wrapper.data( 'loading_show_type' ) ) {
                            skelType = 'list' == $wrapper.data( 'loading_show_type' ) ? 'skel-pro skel-pro-list' : 'skel-pro';
                        }
                        template = '<li class="product-wrap"><div class="' + skelType + '"></div></li>';
                    } else {
                        // post template
                        var skelType = 'skel-post';
                        if ( $wrapper.hasClass( 'list-type-posts' ) ) {
                            skelType = 'skel-post-list';
                        }
                        if ( 'mask' == $wrapper.attr( 'data-post-type' ) ) {
                            skelType = 'skel-post-mask';
                        }
                        template = '<div class="post-wrap"><div class="' + skelType + '"></div></div>';
                    }

                    // Empty wrapper
                    if ( type == 'page' || type == 'filter' ) {
                        $wrapper.html( '' );
                    }

                    if ( $wrapper.data( 'loading_show_type' ) ) {
                        $wrapper.toggleClass( 'list-type-products', 'list' == $wrapper.data( 'loading_show_type' ) );
                        $wrapper.attr( 'class',
                            $wrapper.attr( 'class' ).replace( /row|cols\-\d|cols\-\w\w-\d/g, '' ).replace( /\s+/, ' ' ) +
                            $wrapper.attr( 'data-col-' + $wrapper.data( 'loading_show_type' ) )
                        );
                    }

                    if ( theme.isIE ) {
                        var tmpl = '';
                        while ( count-- ) { tmpl += template; }
                        $wrapper.addClass( 'skeleton-body' ).append( tmpl );
                    } else {
                        $wrapper.addClass( 'skeleton-body' ).append( template.repeat( count ) );
                    }

                    if ( $wrapper.data( 'isotope' ) ) {
                        $wrapper.isotope( 'destroy' );
                    }

                } else {
                    // Widget or not skeleton in archive pages
                    if ( type == 'button' || type == 'scroll' ) {
                        theme.showMore( $wrapper );
                    } else {
                        theme.doLoading( $wrapper.parent() );
                    }
                }

                // Scroll to wrapper's top offset
                if ( type == 'page' ) {
                    theme.scrollToFixedContent( ( $( '.toolbox-top' ).length ? $( '.toolbox-top' ) : $wrapper ).offset().top - 20, 400 );
                }

                $wrapper.addClass( 'loading-more' );

                return true;
            },

			/**
			 * End loading effect. 
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {string} type
			 */
            endLoading: function ( $wrapper, type ) {
                // Clear loading effect
                if ( alpha_vars.skeleton_screen && $wrapper.closest( '.product-archive, .post-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) { // shop or blog archive
                    if ( type == 'button' || type == 'scroll' ) {
                        $wrapper.find( '.skel-pro,.skel-post' ).parent().remove();
                    }
                    $wrapper.removeClass( 'skeleton-body' );
                } else {
                    if ( type == 'button' || type == 'scroll' ) {
                        theme.hideMore( $wrapper.parent() );
                    } else {
                        theme.endLoading( $wrapper.parent() );
                    }
                }
                $wrapper.removeClass( 'loading-more' );
            },

			/**
			 * Filter widgets by category
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
            filterWidgetByCategory: function ( e ) {
                var $filter = $( e.currentTarget );

                e.preventDefault();

                // If this is filtered by archive page's toolbox filter or this is active now, return.
                if ( $filter.is( '.toolbox .nav-filter' ) || $filter.is( '.post-archive .nav-filter' ) || $filter.hasClass( 'active' ) ) {
                    return;
                }

                // Find Wrapper
                var filterNav, $wrapper, filterCat = $filter.attr( 'data-cat' );

                filterNav = $filter.closest( '.nav-filters' );
                if ( filterNav.length ) {
                    $wrapper = filterNav.parent().find( filterNav.hasClass( 'product-filters' ) ? '.products' : '.posts' );
                } else {
                    filterNav = $filter.closest( '.filter-categories' );
                    if ( filterNav.length ) {
                        if ( $filter.closest( '.elementor-section' ).length ) {
                            $wrapper = $filter.closest( '.elementor-section' ).find( '.products[data-load]' ).eq( 0 );
                            if ( !$wrapper.length ) {
                                $wrapper = $filter.closest( '.elementor-top-section' ).find( '.products[data-load]' ).eq( 0 );
                            }
                        } else if ( $filter.closest( '.vce-row' ).length ) {
                            $wrapper = $filter.closest( '.vce-row' ).find( '.products[data-load]' ).eq( 0 );
                        } else if ( $filter.closest( '.wpb_row' ).length ) {
                            $wrapper = $filter.closest( '.wpb_row' ).find( '.products[data-load]' ).eq( 0 );

                            // If there is no products to be filtered in vc row, just find it in the same section
                            if ( !$wrapper.length ) {
                                if ( $filter.closest( '.vc_section' ).length ) {
                                    $wrapper = $filter.closest( '.vc_section' ).find( '.products[data-load]' ).eq( 0 );
                                }
                            }
                        }
                    }
                }

                if ( $wrapper.length ) {
                    filterNav.length && (
                        filterNav.find( '.cat-type-icon' ).length
                            ? ( // if category type is icon
                                filterNav.find( '.cat-type-icon' ).removeClass( 'active' ),
                                $filter.closest( '.cat-type-icon' ).addClass( 'active' ) )
                            : ( // if not,
                                filterNav.find( '.product-category, .nav-filter' ).removeClass( 'active' ),
                                $filter.closest( '.product-category, .nav-filter' ).addClass( 'active' )
                            )
                    );
                }

                var section_id = $wrapper.closest( '.elementor-top-section' ).data( 'id' );
                if ( section_id && AjaxLoadPost.ajax_tab_cache[ section_id ] && AjaxLoadPost.ajax_tab_cache[ section_id ][ filterCat ] ) {
                    var $content = AjaxLoadPost.ajax_tab_cache[ section_id ][ filterCat ];

                    $wrapper.css( 'opacity', 0 );
                    $wrapper.animate(
                        {
                            'opacity': 1,
                        },
                        400,
                        function () {
                            $wrapper.css( 'opacity', '' );
                        }
                    );
                    $wrapper.empty();
                    if ( $content.length ) {
                        $wrapper.append( $content.clone() );
                    } else {
                        $wrapper.append( $content );
                    }
                    if ( $wrapper.hasClass( 'slider-wrapper' ) ) {
                        $wrapper.removeData( 'slider' );
                        theme.slider( $wrapper );
                    }
                    if ( typeof theme.countdown == 'function' ) {
                        $wrapper.find( '.countdown' ).each( function () {
                            $( this ).countdown( 'destroy' );
                        } );
                        theme.countdown( $wrapper.find( '.countdown' ) );
                    }
                } else {
                    $wrapper.length &&
                        AjaxLoadPost.loadmore( {
                            wrapper: $wrapper,
                            page: 1,
                            type: 'filter',
                            category: filterCat
                        } )
                }
            },

			/**
			 * Load more by button
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
            loadmoreByButton: function ( e ) {
                var $btn = $( e.currentTarget ); // This will be replaced with new html of ajax content.
                e.preventDefault();

                AjaxLoadPost.loadmore( {
                    wrapper: $btn.siblings( '.product-archive' ).length ? $btn.siblings( '.product-archive' ).find( '.products' ) : $btn.siblings( '.products, .posts' ),
                    page: '+1',
                    type: 'button',
                    onStart: function () {
                        $btn.data( 'text', $btn.html() )
                            .addClass( 'loading' ).blur()
                            .html( alpha_vars.texts.loading );
                    },
                    onFail: function () {
                        $btn.text( alpha_vars.texts.loadmore_error ).addClass( 'disabled' );
                    }
                } );
            },

			/**
			 * Event handler for ajax loading by infinite scroll 
			 * 
			 * @since 1.0
			 */
            startScrollLoad: function () {
                AjaxLoadPost.scrollWrappers = $( '.load-scroll' );
                if ( AjaxLoadPost.scrollWrappers.length ) {
                    AjaxLoadPost.loadmoreByScroll();
                    theme.$window.off( 'scroll resize', AjaxLoadPost.loadmoreByScroll );
                    window.addEventListener( 'scroll', AjaxLoadPost.loadmoreByScroll, { passive: true } );
                    window.addEventListener( 'resize', AjaxLoadPost.loadmoreByScroll, { passive: true } );
                }
            },

			/**
			 * Load more by scroll
			 * 
			 * @since 1.0
			 * @param {jQuery} $scrollWrapper
			 */
            loadmoreByScroll: function ( $scrollWrapper ) {
                var target = AjaxLoadPost.scrollWrappers,
                    loadOptions = target.attr( 'data-load' ),
                    maxPage = 1,
                    curPage = 1;

                if ( loadOptions ) {
                    loadOptions = JSON.parse( loadOptions );
                    maxPage = loadOptions.max;
                    if ( loadOptions.args && loadOptions.args.paged ) {
                        curPage = loadOptions.args.paged;
                    }
                }

                if ( curPage >= maxPage ) {
                    return;
                }

                $scrollWrapper && $scrollWrapper instanceof jQuery && ( target = $scrollWrapper );

                // load more
                target.length && AjaxLoadPost.canLoad( target, 'scroll' ) && target.each( function () {
                    var rect = this.getBoundingClientRect();
                    if ( rect.top + rect.height > 0 &&
                        rect.top + rect.height < window.innerHeight ) {
                        AjaxLoadPost.loadmore( {
                            wrapper: $( this ),
                            page: '+1',
                            type: 'scroll',
                            onDone: function ( $result, $wrapper, options ) {
                                // check max
                                if ( options.max && options.max <= options.args.paged ) {
                                    $wrapper.removeClass( 'load-scroll' );
                                }
                                // continue loadmore again
                                theme.call( AjaxLoadPost.startScrollLoad, 50 );
                            },
                            onFail: function ( jqxhr, $wrapper ) {
                                $wrapper.removeClass( 'load-scroll' );
                            }
                        } );
                    }
                } );

                // remove loaded wrappers
                AjaxLoadPost.scrollWrappers = AjaxLoadPost.scrollWrappers.filter( function () {
                    var $this = $( this );
                    $this.children( theme.applyFilters( 'ajax_load_post/scroll_wrappers_wrap', '.post-wrap,.product-wrap' ) ).length || $this.removeClass( 'load-scroll' );
                    return $this.hasClass( 'load-scroll' );
                } );
                AjaxLoadPost.scrollWrappers.length || (
                    window.removeEventListener( 'scroll', AjaxLoadPost.loadmoreByScroll ),
                    window.removeEventListener( 'resize', AjaxLoadPost.loadmoreByScroll )
                )
            },

			/**
			 * Fit videos
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 */
            fitVideos: function ( $wrapper, fitVids ) {
                // Video Post Refresh
                if ( $wrapper.find( '.fit-video' ).length ) {

                    var defer_mecss = ( function () {
                        var deferred = $.Deferred();
                        if ( $( '#wp-mediaelement-css' ).length ) {
                            deferred.resolve();
                        } else {
                            $( document.createElement( 'link' ) ).attr( {
                                id: 'wp-mediaelement-css',
                                href: alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.css' ),
                                media: 'all',
                                rel: 'stylesheet'
                            } ).appendTo( 'body' ).on(
                                'load',
                                function () {
                                    deferred.resolve();
                                }
                            );
                        }
                        return deferred.promise();
                    } )();

                    var defer_mecss_legacy = ( function () {
                        var deferred = $.Deferred();
                        if ( $( '#mediaelement-css' ).length ) {
                            deferred.resolve();
                        } else {
                            $( document.createElement( 'link' ) ).attr( {
                                id: 'mediaelement-css',
                                href: alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css' ),
                                media: 'all',
                                rel: 'stylesheet'
                            } ).appendTo( 'body' ).on(
                                'load',
                                function () {
                                    deferred.resolve();
                                }
                            );
                        }
                        return deferred.promise();
                    } )();

                    var defer_mejs = ( function () {
                        var deferred = $.Deferred();

                        if ( typeof window.wp.mediaelement != 'undefined' ) {
                            deferred.resolve();
                        } else {

                            $( '<script>var _wpmejsSettings = { "stretching": "responsive" }; </script>' ).appendTo( 'body' );

                            var defer_mejsplayer = ( function () {
                                var deferred = $.Deferred();

                                $( document.createElement( 'script' ) ).attr( 'id', 'mediaelement-core-js' )
                                    .appendTo( 'body' )
                                    .on( 'load', function () {
                                        deferred.resolve();
                                    } )
                                    .attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-and-player.min.js' ) );

                                return deferred.promise();
                            } )();
                            var defer_mejsmigrate = ( function () {
                                var deferred = $.Deferred();

                                setTimeout( function () {
                                    $( document.createElement( 'script' ) ).attr( 'id', 'mediaelement-migrate-js' ).appendTo( 'body' ).on(
                                        'load',
                                        function () {
                                            deferred.resolve();
                                        }
                                    ).attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-migrate.min.js' ) );
                                }, 100 );

                                return deferred.promise();
                            } )();
                            $.when( defer_mejsplayer, defer_mejsmigrate ).done(
                                function ( e ) {
                                    $( document.createElement( 'script' ) ).attr( 'id', 'wp-mediaelement-js' ).appendTo( 'body' ).on(
                                        'load',
                                        function () {
                                            deferred.resolve();
                                        }
                                    ).attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.js' ) );
                                }
                            );
                        }

                        return deferred.promise();
                    } )();

                    var defer_fitvids = ( function () {
                        var deferred = $.Deferred();
                        if ( $.fn.fitVids ) {
                            deferred.resolve();
                        } else {
                            $( document.createElement( 'script' ) ).attr( 'id', 'jquery.fitvids-js' )
                                .appendTo( 'body' )
                                .on( 'load', function () {
                                    deferred.resolve();
                                } ).attr( 'src', alpha_vars.assets_url + '/vendor/jquery.fitvids/jquery.fitvids.min.js' );
                        }
                        return deferred.promise();
                    } )();

                    $.when( defer_mecss, defer_mecss_legacy, defer_mejs, defer_fitvids ).done(
                        function ( e ) {
                            theme.call( function () {
                                theme.fitVideoSize( $wrapper );
                            }, 200 );
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
            loadmoreByPagination: function ( e ) {
                var $btn = $( e.currentTarget ); // This will be replaced with new html of ajax content

                if ( theme.$body.hasClass( 'dokan-store' ) && $btn.closest( '.dokan-single-store' ).length ) {
                    return;
                }
                e.preventDefault();

                var $pagination = $btn.closest( '.toolbox-pagination' ).length ? $btn.closest( '.toolbox-pagination' ) : $btn.closest( '.pagination' );

                AjaxLoadPost.loadmore( {
                    wrapper: $pagination.siblings( '.product-archive' ).length ?
                        $pagination.siblings( '.product-archive' ).find( '.products' ) :
                        $pagination.siblings( '.products, .posts' ).length ?
                            $pagination.siblings( '.products, .posts' ) :
                            theme.$body.find( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` ),

                    page: $btn.hasClass( 'next' ) ? '+1' :
                        ( $btn.hasClass( 'prev' ) ? '-1' : $btn.text() ),
                    type: 'page',
                    onStart: function ( $wrapper, options ) {
                        theme.doLoading( $btn.closest( '.pagination' ), 'simple' );
                    }
                } );
            },

			/**
			 * Load more ajax content 
			 * 
			 * @since 1.0
			 * @param {object} params
			 * @return {boolean}
			 */
            loadmore: function ( params ) {
                if ( !params.wrapper ||
                    1 != params.wrapper.length ||
                    !params.wrapper.attr( 'data-load' ) ||
                    !AjaxLoadPost.doLoading( params.wrapper, params.type ) ) {
                    return false;
                }

                // Get wrapper
                var $wrapper = params.wrapper;

                // Get options
                var options = JSON.parse( $wrapper.attr( 'data-load' ) );
                options.args = options.args || {};
                if ( !options.args.paged ) {
                    options.args.paged = 1;

                    // Get correct page number at first in archive pages
                    if ( $wrapper.closest( '.product-archive, .post-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) {
                        var match = location.pathname.match( /\/page\/(\d*)/ );
                        if ( match && match[ 1 ] ) {
                            options.args.paged = parseInt( match[ 1 ] );
                        }
                    }
                }
                if ( 'filter' == params.type ) {
                    options.args.paged = 1;
                    if ( params.category ) {
                        options.args.category = params.category; // filter category
                    } else if ( options.args.category ) {
                        delete options.args.category; // do not filter category
                    }
                } else if ( '+1' === params.page ) {
                    ++options.args.paged;
                } else if ( '-1' === params.page ) {
                    --options.args.paged;
                } else {
                    options.args.paged = parseInt( params.page );
                }

                // Get ajax url
                var url = alpha_vars.ajax_url;
                if ( $wrapper.closest( '.product-archive, .post-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) { // shop or blog archive
                    var pathname = location.pathname;
                    if ( pathname.endsWith( '/' ) ) {
                        pathname = pathname.slice( 0, pathname.length - 1 );
                    }
                    if ( pathname.indexOf( '/page/' ) >= 0 ) {
                        pathname = pathname.replace( /\/page\/\d*/, '/page/' + options.args.paged );
                    } else {
                        pathname += '/page/' + options.args.paged;
                    }

                    url = theme.addUrlParam( location.origin + pathname + location.search, 'only_posts', 1 );
                    if ( options.args.category && options.args.category != '*' ) {
                        url = theme.addUrlParam( url, 'product_cat', category );
                    }
                }

                // Add product-page param to set current page for pagination
                if ( $wrapper.hasClass( 'products' ) && !$wrapper.closest( '.product-archive' ).length ) {
                    url = theme.addUrlParam( url, 'product-page', options.args.paged );
                }

                // Add post type to blog posts' ajax pagination.
                if ( $wrapper.closest( '.post-archive' ).length ) {
                    var postType = $wrapper.data( 'post-type' );
                    if ( postType ) {
                        url = theme.addUrlParam( url, 'post_style_type', postType );
                    }
                }

                // Get ajax data
                var data = {
                    action: $wrapper.closest( '.product-archive, .post-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ? '' : 'alpha_loadmore',
                    nonce: alpha_vars.nonce,
                    props: options.props,
                    args: options.args,
                    loadmore: params.type,
                    cpt: options.cpt ? options.cpt : 'post',
                }

                if ( params.type == 'page' ) {
                    data.pagination = 1;
                }

                // Before start loading
                params.onStart && params.onStart( $wrapper, options );

                // Do ajax
                $.post( url, data )
                    .done( function ( result ) {
                        // In case of posts widget's pagination, result's structure will be {html: '', pagination: ''}.
                        var res_pagination = '';
                        if ( $wrapper.hasClass( 'posts' ) && !$wrapper.closest( '.post-archive' ).length && params.type == 'page' ) {
                            result = JSON.parse( result );
                            res_pagination = result.pagination;
                            result = result.html;
                        }

                        // In other cases, result will be html.
                        var $result = $( result ),
                            $content;

                        $result.imagesLoaded( function () {

                            // Get content, except posts widget
                            if ( $wrapper.closest( '.product-archive' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length ) {
                                $content = $result.find( '.product-archive .products' + `, .elementor-widget-${ alpha_vars.theme }_shop_widget_products .products` );
                            } else if ( $wrapper.closest( '.post-archive' ).length ) {
                                $content = $result.find( '.post-archive .posts' );
                                if ( !$content.length ) {
                                    $result.each( function () {
                                        var $this = $( this );
                                        if ( $this.hasClass( 'post-archive' ) ) {
                                            $content = $this.find( '.posts' );
                                            return false;
                                        }
                                    } );
                                }
                            } else {
                                $content = $wrapper.hasClass( 'products' ) ? $result.find( '.products' ) : $result.children();
                                var section_id = $wrapper.closest( '.elementor-top-section' ).data( 'id' );
                                if ( section_id ) {
                                    if ( undefined == AjaxLoadPost.ajax_tab_cache[ section_id ] ) {
                                        AjaxLoadPost.ajax_tab_cache[ section_id ] = {};
                                    }

                                    AjaxLoadPost.ajax_tab_cache[ section_id ][ params.category ] = $content.children();
                                }
                            }

                            // Change status and content
                            if ( params.type == 'page' || params.type == 'filter' ) {
                                if ( $wrapper.data( 'slider' ) ) {
                                    $wrapper.data( 'slider' ).destroy();
                                    $wrapper.removeData( 'slider' );
                                    $wrapper.data( 'slider-layout' ) && $wrapper.addClass( $wrapper.data( 'slider-layout' ).join( ' ' ) );
                                }
                                $wrapper.data( 'isotope' ) && $wrapper.data( 'isotope' ).destroy();
                                $wrapper.empty();
                            }

                            if ( !$wrapper.hasClass( 'posts' ) || $wrapper.closest( '.post-archive' ).length ) {
                                // Except posts widget, update max page and class
                                var max = $content.attr( 'data-load-max' );
                                if ( max ) {
                                    options.max = parseInt( max );
                                }
                                $wrapper.append( $content.children() );
                            } else {
                                // For posts widget
                                $wrapper.append( $content );
                            }

                            // Update wrapper status.
                            $wrapper.attr( 'data-load', JSON.stringify( options ) );

                            if ( $wrapper.closest( '.product-archive' ).length || $wrapper.closest( `.elementor-widget-${ alpha_vars.theme }_shop_widget_products` ).length || $wrapper.closest( '.post-archive' ).length ) {
                                AjaxLoadPost.loadedPage( 0, result, url, params.type );
                            } else {
                                // Change load controls for widget
                                var loadmore_type = params.type == 'filter' ? options.props.loadmore_type : params.type;

                                if ( loadmore_type == 'button' ) {
                                    if ( params.type != 'filter' && $wrapper.hasClass( 'posts' ) ) {
                                        var $btn = $wrapper.siblings( '.btn-load' );
                                        if ( $btn.length ) {
                                            if ( typeof options.args == 'undefined' || typeof options.max == 'undefined' ||
                                                typeof options.args.paged == 'undefined' || options.max <= options.args.paged ) {
                                                $btn.remove();
                                            } else {
                                                $btn.html( $btn.data( 'text' ) );
                                            }
                                        }
                                    } else {
                                        AjaxLoadPost.refreshButton( $wrapper, $result.find( '.btn-load' ), options );
                                    }

                                } else if ( loadmore_type == 'page' ) {
                                    var $pagination = $wrapper.parent().find( '.pagination' )
                                    var $newPagination = $wrapper.hasClass( 'posts' ) ? $( res_pagination ) : $result.find( '.pagination' );
                                    if ( $pagination.length ) {
                                        $pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
                                    } else {
                                        $newPagination.length && $wrapper.after( $newPagination );
                                    }

                                } else if ( loadmore_type == 'scroll' ) {
                                    $wrapper.addClass( 'load-scroll' );
                                    if ( params.type == 'filter' ) {
                                        theme.call( function () {
                                            AjaxLoadPost.loadmoreByScroll( $wrapper );
                                        }, 50 );
                                    }
                                }
                            }

                            // Init products and posts
                            $wrapper.hasClass( 'products' ) && theme.woocommerce.initProducts( $wrapper );
                            $wrapper.hasClass( 'posts' ) && AjaxLoadPost.fitVideos( $wrapper );

                            // Refresh layouts
                            if ( $wrapper.hasClass( 'grid' ) ) {
                                $wrapper.removeData( 'isotope' );
                                theme.isotopes( $wrapper );
                            }
                            if ( $wrapper.hasClass( 'slider-wrapper' ) ) {
                                theme.slider( $wrapper );
                            }
                            if ( typeof theme.countdown == 'function' ) {
                                theme.countdown( $wrapper.find( '.countdown' ) );
                            }

                            params.onDone && params.onDone( $result, $wrapper, options );

                            // If category filter is not set in widget and loadmore has been limited to max, remove data-load attribute
                            if ( !$wrapper.hasClass( 'filter-products' ) &&
                                !( $wrapper.hasClass( 'products' ) && $wrapper.parent().siblings( '.nav-filters' ).length ) &&
                                options.max && options.max <= options.args.paged && 'page' != params.type ) {
                                $wrapper.removeAttr( 'data-load' );
                            }

                            AjaxLoadPost.endLoading( $wrapper, params.type );
                            params.onAlways && params.onAlways( result, $wrapper, options );
                            theme.refreshLayouts();
                        } );
                    } ).fail( function ( jqxhr ) {
                        params.onFail && params.onFail( jqxhr, $wrapper );
                        AjaxLoadPost.endLoading( $wrapper, params.type );
                        params.onAlways && params.onAlways( result, $wrapper, options );
                    } );

                return true;
            }
        }
        return function () {
            AjaxLoadPost.init();
            theme.AjaxLoadPost = AjaxLoadPost;
        }
    } )();

    $( window ).on( 'alpha_complete', function () {
        theme.initAjaxLoadPost();
    } );

} )( window.jQuery );
