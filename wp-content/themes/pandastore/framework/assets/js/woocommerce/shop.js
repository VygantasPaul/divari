/**
 * WP Alpha Theme Framework
 * Alpha Shop
 * 
 * @package WP Alpha Framework
 * @since 1.2.0
 */

window.theme = window.theme || {};

( function ( $ ) {
    /**
     * Initialize shop functions
     *
     * @class Shop
     * @since 1.0
     * @return {void}
     */
    theme.shop = ( function () {

        /**
         * Initialize shop filter menu for horizontal layout (horizontal filter widgets)
         * 
         * @since 1.0
         */
        function initSelectMenu () {

            function _initSelectMenu () {
                // show selected attributes after loading
                $( '.toolbox-horizontal .shop-sidebar .widget .chosen' ).each( function ( e ) {
                    if ( $( this ).find( 'a' ).attr( 'href' ) == window.location.href ) {
                        return;
                    }

                    $( '<a href="#" class="select-item">' + $( this ).find( 'a' ).text() + '<i class="' + alpha_vars.theme_icon_prefix + '-icon-times-solid"></i></a>' )
                        .insertBefore( '.toolbox-horizontal + .select-items .filter-clean' )
                        .attr( 'data-type', $( this ).closest( '.widget' ).attr( 'id' ).split( '-' ).slice( 0, -1 ).join( '-' ) )
                        .data( 'link_id', $( this ).closest( '.widget' ).attr( 'id' ) )
                        .data( 'link_idx', $( this ).index() );

                    $( '.toolbox-horizontal + .select-items' ).fadeIn();
                } )
            }

            function openMenu ( e ) {
                // close all select menu
                $( this ).parent().siblings().removeClass( 'opened' );
                $( this ).parent().toggleClass( 'opened' );
                e.stopPropagation();
            }

            function closeMenu ( e ) {
                $( '.toolbox-horizontal .shop-sidebar .widget, .alpha-filters .select-ul' ).removeClass( 'opened' );
            }

            function stopPropagation ( e ) {
                e.stopPropagation();
            }

            function onAddFilterItem ( e ) {
                var $this = $( this );

                if ( $this.closest( '.widget' ).hasClass( 'yith-woo-ajax-reset-navigation' ) ) {
                    return;
                }

                theme.doLoading( '.horizontal-sidebar .widget>*:not(.widget-title)', 'small' );

                if ( $this.closest( '.product-categories' ).length ) {
                    $( '.toolbox-horizontal + .select-items .select-item' ).remove();
                }

                if ( $this.parent().hasClass( 'chosen' ) ) {
                    $( '.toolbox-horizontal + .select-items .select-item' )
                        .filter( function ( i, el ) {
                            return $( el ).data( 'link_id' ) == $this.closest( '.widget' ).attr( 'id' ) &&
                                $( el ).data( 'link_idx' ) == $this.closest( 'li' ).index();
                        } )
                        .fadeOut( function () {
                            $( this ).remove();

                            // if only clean all button remains
                            if ( $( '.select-items' ).children().length < 2 ) {
                                $( '.select-items' ).hide();
                            }
                        } )
                } else {
                    var type = $this.closest( '.widget' ).attr( 'id' ).split( '-' ).slice( 0, -1 ).join( '-' );

                    if ( 'alpha-price-filter' == type ) {
                        $( '.toolbox-horizontal + .select-items' ).find( '[data-type="alpha-price-filter"]' ).remove();
                        $this.closest( 'li' ).addClass( 'chosen' ).siblings().removeClass( 'chosen' );
                    }

                    $( '<a href="#" class="select-item">' + $this.text() + '<i class="' + alpha_vars.theme_icon_prefix + '-icon-times-solid"></i></a>' )
                        .insertBefore( '.toolbox-horizontal + .select-items .filter-clean' )
                        .hide().fadeIn()
                        .attr( 'data-type', type )
                        .data( 'link_id', $this.closest( '.widget' ).attr( 'id' ) )
                        .data( 'link_idx', $this.closest( 'li' ).index() ); // link to anchor

                    // if only clean all button remains
                    if ( $( '.select-items' ).children().length >= 2 ) {
                        $( '.select-items' ).show();
                    }
                }
            }

            function onAddFiltersWidgetItem ( e ) {
                e.preventDefault();
                e.stopPropagation();

                if ( 'or' == $( this ).closest( '.alpha-filter' ).attr( 'data-filter-query' ) ) {
                    $( this ).closest( 'li' ).toggleClass( 'chosen' );
                } else {
                    $( this ).closest( 'li' ).toggleClass( 'chosen' ).siblings().removeClass( 'chosen' );
                }

                var $btn_filter = $( this ).closest( '.alpha-filters' ).find( '.btn-filter' ),
                    link = $btn_filter.attr( 'href' ),
                    $filters = $( this ).closest( '.alpha-filters' );
                link = link.split( '/' );
                link[ link.length - 1 ] = '';

                $filters.length && $filters.find( '.alpha-filter' ).each( function ( index ) {
                    var chosens = $( this ).find( '.chosen' );

                    if ( chosens.length ) {
                        var values = [],
                            attr = $( this ).attr( 'data-filter-attr' );

                        chosens.each( function () {
                            values.push( $( this ).attr( 'data-value' ) );
                        } )

                        link[ link.length - 1 ] += 'filter_' + attr + '=' + values.join( ',' ) + '&query_type_' + attr + '=' + $( this ).attr( 'data-filter-query' ) + ( index != $filters.length ? '&' : '' );
                    }
                } );

                link[ link.length - 1 ] = '?' + link[ link.length - 1 ];
                $btn_filter.attr( 'href', link.join( '/' ) );
            }

            function onRemoveFilterItem ( e ) {
                e.preventDefault();
                var $this = $( this );
                var id = $this.data( 'link_id' );
                if ( id ) {
                    var $link = $( '.toolbox-horizontal .shop-sidebar #' + id ).find( 'li' ).eq( $this.data( 'link_idx' ) ).children( 'a' );
                    if ( $link.length ) {
                        if ( $link.closest( '.product-categories' ).length ) {
                            $this.siblings( '.filter-clean' ).trigger( 'click' );
                        } else {
                            $link.trigger( 'click' );
                        }
                    }
                }
            }

            function onCleanFilterItems ( e ) {
                e.preventDefault();

                $( this ).parent( '.select-items' ).fadeOut( function () {
                    $( this ).children( '.select-item' ).remove();
                } )
            }

            _initSelectMenu();

            theme.$body
                // show or hide select menu
                .on( 'click', '.toolbox-horizontal .shop-sidebar .widget-title, .alpha-filters .select-ul-toggle, .toolbox-horizontal .shop-sidebar .wp-block-group__inner-container > h2', openMenu )
                .on( 'click', '.toolbox-horizontal .shop-sidebar .widget-title + *, .toolbox-horizontal .shop-sidebar .wp-block-group__inner-container > h2 + *', stopPropagation ) // if click in popup area, not hide it
                .on( 'click', closeMenu )

                // if select item is clicked
                .on( 'click', '.toolbox-horizontal .shop-sidebar .widget a', onAddFilterItem )
                .on( 'click', '.toolbox-horizontal + .select-items .select-item', onRemoveFilterItem )
                .on( 'click', '.toolbox-horizontal + .select-items .filter-clean', onCleanFilterItems )

                // alpha filters widget / filter item is clicked
                .on( 'click', '.alpha-filters .select-ul a', onAddFiltersWidgetItem );
        }

        /**
         * Initalize subpages
         * 
         * @since 1.0
         */
        function initSubpages () {
            // Refresh sticky sidebar on shipping calculator in cart page
            theme.$body.on( 'click', '.shipping-calculator-button', function ( e ) {
                var btn = e.currentTarget;
                setTimeout( function () {
                    $( btn ).closest( '.sticky-sidebar' ).trigger( 'recalc.pin' );
                }, 400 );
            } )

            if ( alpha_vars.cart_auto_update ) {
                theme.$body.on( 'click', '.shop_table .quantity-minus, .shop_table .quantity-plus', function () {
                    $( '.shop_table button[name="update_cart"]' ).trigger( 'click' );
                } );
                theme.$body.on( 'keyup', '.shop_table .quantity .qty', function () {
                    $( '.shop_table button[name="update_cart"]' ).trigger( 'click' );
                } );
            }
        }

        /**
         * Set quantity
         *
         * @since 1.0
         * @return {void}
         */
        function handleQTY () {
            var $obj = $( this );
            if ( $obj.closest( '.quantity' ).next( '.add_to_cart_button[data-quantity]' ).length ) {
                var count = $obj.val();
                if ( count ) {
                    $obj.closest( '.quantity' ).next( '.add_to_cart_button[data-quantity]' ).attr( 'data-quantity', count );
                }
            }
        }

        /**
         * Event handler to change show count for non ajax mode.
         * 
         * @since 1.0
         * @param {Event} e 
         */
        function changeShowCountPage ( e ) {
            if ( this.value ) {
                location.href = theme.addUrlParam( location.href.replace( /\/page\/\d*/, '' ), 'count', this.value );
            }
        }

        return {
            init: function () {

                // Functions for shop page
                initSelectMenu();
                initSubpages();

                // Handler
                if ( !( alpha_vars.shop_ajax && $( document.body ).hasClass( 'alpha-archive-product-layout' ) ) ) {
                    theme.$body
                        .on( 'change', '.toolbox-show-count .count', changeShowCountPage )
                }

                // Functions for Alert
                theme.woocommerce.initAlertAction();
            }

        }
    } )();

    $( window ).on( 'alpha_complete', function () {
        theme.shop.init();
    } );
} )( window.jQuery );