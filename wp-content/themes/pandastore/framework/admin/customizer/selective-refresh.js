/**
 * Selective Refresh for Customize
 * 
 * @package  Alpha WordPress theme
 * @since 1.0
 */
'use strict';
jQuery( document ).ready( function ( $ ) {

    function getCustomize ( option ) {
        var o = wp.customize( option );
        return o ? o.get() : '';
    }

    var options = [
        'container', 'container_fluid',
        [ 'site_type', 'site_bg', 'content_bg', 'site_width', 'site_gap' ],
        [ 'breakpoint_tab', 'breakpoint_mob' ],
        [ 'primary_color', 'secondary_color', 'dark_color', 'light_color' ],
        [ 'typo_default' ],
        'typo_heading',
        'ptb_bg', 'ptb_height',
        'typo_ptb_title', 'typo_ptb_subtitle', 'typo_ptb_breadcrumb',
        'share_color',
        [ 'custom_css' ],
        [ 'rounded_skin' ],
        'product_description_title', 'product_reviews_title', 'product_upsells_title', 'product_related_title', 'product_tab_title', 'product_specification_title', 'product_vendor_info_title',
    ];
    var tooltips = [ {
        target: '.main-content .product-single .social-icons, .main-content .post-single .social-icons',
        text: 'Share',
        elementID: 'share',
        pos: 'bottom',
        type: 'section'
    }, {
        target: '.page-header',
        text: 'Page Title Bar',
        elementID: 'title_bar',
        pos: 'bottom',
        type: 'section'
    }, {
        target: '.post-archive',
        text: 'Archive Page',
        elementID: 'blog_archive',
        pos: 'top',
        type: 'section'
    }, {
        target: '.single .post-single',
        text: 'Single Page',
        elementID: 'blog_single',
        pos: 'top',
        type: 'section'
    }, {
        target: '.main-content > .products, .main-content > .yit-wcan-container > .products',
        text: 'Product Archive Page',
        elementID: 'products_archive',
        pos: 'top',
        type: 'section'
    }, {
        target: '.single .product-single',
        text: 'Product Page',
        elementID: 'product_detail',
        pos: 'top',
        type: 'section'
    }, {
        target: '.products .product-wrap .product',
        text: 'Product Type',
        elementID: 'product_type',
        pos: 'center',
        type: 'section'
    }, {
        target: '.products .category-wrap .product-category',
        text: 'Category Type',
        elementID: 'category_type',
        pos: 'center',
        type: 'section'
    }, {
        target: '.product-single .woocommerce-tabs',
        text: 'Product DataTab Type',
        elementID: 'product_description_title',
        pos: 'center',
        type: 'control'
    } ];

    $.fn.alphaTooltip = function ( options ) {
        options.target = escape( options.target.replace( /"/g, '' ) );
        $( '.alpha-tooltip[data-target="' + options.target + '"]' ).remove();
        return $( this ).each( function () {
            if ( $( this ).hasClass( 'alpha-tooltip-initialized' ) ) {
                return;
            }

            var $this = $( this ),
                $tooltip = $( '<div class="alpha-tooltip" data-target="' + options.target + '" style="display: none; position: absolute; z-index: 9999;">' + options.text + '</div>' ).appendTo( 'body' );
            $tooltip.data( 'triggerObj', $this );
            if ( options.init ) {
                $tooltip.data( 'initCall', options.init );
            }
            $this.on( 'mouseenter', function () {
                $tooltip.text( options.text );
                if ( options.position == 'top' ) {
                    $tooltip.css( 'top', $this.offset().top - $tooltip.outerHeight() / 2 ).css( 'left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2 );
                } else if ( options.position == 'bottom' ) {
                    $tooltip.css( 'top', $this.offset().top + $this.outerHeight() - $tooltip.outerHeight() / 2 ).css( 'left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2 );
                } else if ( options.position == 'left' ) {
                    $tooltip.css( 'top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2 ).css( 'left', $this.offset().left - $tooltip.outerWidth() / 2 );
                } else if ( options.position == 'right' ) {
                    $tooltip.css( 'top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2 ).css( 'left', $this.offset().left + $this.outerWidth() - $tooltip.outerWidth() / 2 );
                } else if ( options.position == 'center' ) {
                    $tooltip.css( 'top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2 ).css( 'left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2 );
                }
                $tooltip.stop().fadeIn( 100 );
                $this.addClass( 'alpha-tooltip-active' );
            } ).on( 'mouseleave', function () {
                $tooltip.stop( true, true ).fadeOut( 400 );
                $this.removeClass( 'alpha-tooltip-active' );
            } ).addClass( 'alpha-tooltip-initialized' );
        } );
    }

    function initTooltipSection ( e, $obj ) {
        if ( e.elementID && 'custom' != e.type ) {
            if ( !e.type ) {
                e.type = 'section';
            }
            window.parent.wp.customize[ e.type ]( e.elementID ).focus();
            if ( e.type == 'section' && window.parent.wp.customize[ e.type ]( e.elementID ).contentContainer ) {
                window.parent.jQuery( 'body' ).trigger( 'initReduxFields', [ window.parent.wp.customize[ e.type ]( e.elementID ).contentContainer ] );
            } else if ( e.type == 'control' && window.parent.wp.customize[ e.type ]( e.elementID ).container ) {
                window.parent.jQuery( 'body' ).trigger( 'initReduxFields', [ window.parent.wp.customize[ e.type ]( e.elementID ).container.closest( '.control-section' ) ] );
            }
        } else if ( 'custom' == e.type && e.elementID ) {
            window.parent.wp.customize.section( 'alpha_header_layouts' ).focus();
            var index = $( e.target, '.header-wrapper' ).index( $obj ),
                isMobile = $obj.closest( '.visible-for-sm:visible' ).length ? true : false;
            $( '.alpha-header-builder .header-wrapper-' + ( isMobile ? 'mobile' : 'desktop' ) + ' .header-builder-wrapper', window.parent.document ).find( '[data-id="' + e.elementID + '"]' ).eq( index ).trigger( 'click' );
        }
    }

    function initCustomizerTooltips ( $parent ) {
        tooltips.forEach( function ( e ) {
            if ( $( e.target ).is( $parent ) || $parent.find( $( e.target ) ).length ) {
                e.type || ( e.type = 'control' );
                $( e.target ).alphaTooltip( {
                    position: e.pos,
                    text: e.text,
                    target: e.target,
                    init: function ( $obj ) {
                        initTooltipSection( e, $obj );
                    }
                } );
            }
        } );

        $( document.body ).on( 'mouseenter', '.alpha-tooltip', function () {
            $( this ).stop( true, true ).show();
            var obj = $( this ).data( 'triggerObj' );
            if ( obj ) {
                obj.addClass( 'alpha-tooltip-active' );
            }
        } ).on( 'mouseleave', '.alpha-tooltip', function () {
            $( this ).stop().fadeOut( 400 );
            var obj = $( this ).data( 'triggerObj' );
            if ( obj ) {
                obj.removeClass( 'alpha-tooltip-active' );
            }
        } ).on( 'click', '.alpha-tooltip', function () {
            var initCall = $( this ).data( 'initCall' );
            if ( initCall ) {
                initCall.call( this, $( this ).data( 'triggerObj' ) );
            }
        } );
    }

    function initDynamicCSS () {
        var handles = [ 'alpha-theme-shop', 'alpha-theme-blog', 'alpha-theme-shop-other', 'alpha-theme-single-product', 'alpha-theme-single-post' ],
            h = 'alpha-theme',
            style = '';

        handles.forEach( function ( value, idx ) {
            if ( 'alpha-theme' != h ) {
                return;
            }

            if ( $( '#' + value + '-inline-css' ).length ) {
                h = value;
            }
        } );

        style = $( '#' + h + '-inline-css' ).text();

        var res_keys = style.matchAll( /\n(--[^\: ]*)\:/g ),
            res_values = style.matchAll( /\n--[^\: ]*\: ([^\;]*)\;/g ),
            keys = [],
            values = [],
            htmlStyle = $( 'html' )[ 0 ].style;

        for ( var key of res_keys ) {
            keys.push( key[ 1 ] );
        }
        for ( var value of res_values ) {
            values.push( value[ 1 ] );
        }

        for ( var i = 0; i < keys.length; i++ ) {
            htmlStyle.setProperty( keys[ i ], values[ i ] );
        }

        $( '#' + h + '-inline-css' ).text( '' );
    }

    initCustomizerTooltips( $( 'body' ) );
    initDynamicCSS();
    eventsInit();

    for ( var i = 0; i < options.length; i++ ) {
        if ( Array.isArray( options[ i ] ) ) {
            var option = options[ i ];
        } else {
            var option = [ options[ i ] ];
        }

        for ( var j = 0; j < option.length; j++ ) {
            wp.customize( option[ j ], function ( e ) {
                var event = option[ 0 ];
                e.bind( function ( value ) {
                    $( document.body ).trigger( event );
                } );
            } );
        }

        $( document.body ).trigger( option[ 0 ] );
    }

    function eventsInit () {
        var style = $( 'html' )[ 0 ].style;
        if ( document.querySelector( '.elementor-section' ) ) {
            style.setProperty( '--alpha-gap', alpha_vars.alpha_gap );
        }
        $( document.body ).on( 'container', function () {
            style.setProperty( '--alpha-container-width', getCustomize( 'container' ) + 'px' );
            style.setProperty( '--alpha-container-width-max', getCustomize( 'container' ) - 1 + 'px' );
        } )
        $( document.body ).on( 'container_fluid', function () {
            style.setProperty( '--alpha-container-fluid-width', getCustomize( 'container_fluid' ) + 'px' );
            style.setProperty( '--alpha-container-fluid-width-max', getCustomize( 'container_fluid' ) - 1 + 'px' );
        } )

        $( document.body ).on( 'product_description_title', function () {
            alpha_selective_content( 'product_description_title', '.woocommerce-Tabs-panel--description .title' );
            alpha_selective_content( 'product_description_title', '#tab-title-description>a' );
        } )

        $( document.body ).on( 'product_reviews_title', function () {
            alpha_selective_content( 'product_reviews_title', '.woocommerce-Tabs-panel--reviews .title' );
            alpha_selective_content( 'product_reviews_title', '#tab-title-reviews>a' );
        } )

        $( document.body ).on( 'product_specification_title', function () {
            alpha_selective_content( 'product_specification_title', '.woocommerce-Tabs-panel--additional_information .title' );
            alpha_selective_content( 'product_specification_title', '#tab-title-additional_information>a' );
        } )

        $( document.body ).on( 'product_upsells_title', function () {
            alpha_selective_content( 'product_upsells_title', '.up-sells .title' );
        } )

        $( document.body ).on( 'product_related_title', function () {
            alpha_selective_content( 'product_related_title', '.related .title' );
        } )

        $( document.body ).on( 'product_tab_title', function () {
            alpha_selective_content( 'product_tab_title', '.woocommerce-Tabs-panel--alpha_product_tab .title' );
            alpha_selective_content( 'product_tab_title', '#tab-title-alpha_product_tab>a' );
        } )

        $( document.body ).on( 'product_vendor_info_title', function () {
            alpha_selective_content( 'product_vendor_info_title', '.woocommerce-Tabs-panel--alpha_product_tab .title' );
            alpha_selective_content( 'product_vendor_info_title', '#tab-title-seller>a' );
        } )

        $( document.body ).on( 'site_type', function () {
            var site_type = getCustomize( 'site_type' );
            if ( 'full' != site_type ) {
                $( document.body ).addClass( 'site-boxed' );
                alpha_selective_background( style, 'site', getCustomize( 'site_bg' ) );
                style.setProperty( '--alpha-site-width', getCustomize( 'site_width' ) + 'px' );
                style.setProperty( '--alpha-site-margin', '0 auto' );
                if ( 'boxed' == site_type ) {
                    style.setProperty( '--alpha-site-gap', '0 ' + getCustomize( 'site_gap' ) + 'px' );
                } else {
                    style.setProperty( '--alpha-site-gap', getCustomize( 'site_gap' ) + 'px' );
                }
            } else {
                $( document.body ).removeClass( 'site-boxed' );
                alpha_selective_background( style, 'site', { 'background-color': '#fff' } );
                style.setProperty( '--alpha-site-width', 'false' );
                style.setProperty( '--alpha-site-margin', '0' );
                style.setProperty( '--alpha-site-gap', '0' );
            }
            if ( document.querySelector( '.page-wrapper' ) )
                alpha_selective_background( document.querySelector( '.page-wrapper' ).style, 'page-wrapper', getCustomize( 'content_bg' ) );
        } )

        $( document.body ).on( 'rounded_skin', function () {
            $( document.body ).toggleClass( 'alpha-rounded-skin', getCustomize( 'rounded_skin' ) != '' );
        } )

        $( document.body ).on( 'primary_color', function () {
            style.setProperty( '--alpha-primary-color', getCustomize( 'primary_color' ) );
            style.setProperty( '--alpha-primary-color-hover', getLighten( getCustomize( 'primary_color' ) ) );
            style.setProperty( '--alpha-primary-color-op-90', getColorA( getCustomize( 'primary_color' ), 0.9 ) );
            style.setProperty( '--alpha-secondary-color', getCustomize( 'secondary_color' ) );
            style.setProperty( '--alpha-secondary-color-hover', getLighten( getCustomize( 'secondary_color' ) ) );
            style.setProperty( '--alpha-dark-color', getCustomize( 'dark_color' ) );
            style.setProperty( '--alpha-dark-color-hover', getLighten( getCustomize( 'dark_color' ) ) );
            style.setProperty( '--alpha-light-color', getCustomize( 'light_color' ) );
            style.setProperty( '--alpha-light-color-hover', getLighten( getCustomize( 'light_color' ) ) );
        } )
        $( document.body ).on( 'typo_default', function () {
            alpha_selective_typography( style, 'body', getCustomize( 'typo_default' ) );
        } )
        $( document.body ).on( 'typo_heading', function () {
            alpha_selective_typography( style, 'heading', getCustomize( 'typo_heading' ) );
        } )
        $( document.body ).on( 'ptb_bg', function () {
            if ( document.querySelector( '.page-header' ) )
                alpha_selective_background( document.querySelector( '.page-header' ).style, 'ptb', getCustomize( 'ptb_bg' ) );
        } )
        $( document.body ).on( 'ptb_height', function () {
            if ( document.querySelector( '.page-title-bar' ) )
                document.querySelector( '.page-title-bar' ).style.setProperty( '--alpha-ptb-height', getCustomize( 'ptb_height' ) + 'px' );
        } )
        $( document.body ).on( 'ptb_breadcrumb_bg', function () {
            if ( document.querySelector( '.breadcrumb' ) )
                document.querySelector( '.breadcrumb' ).style.setProperty( '--alpha-ptb-breadcrumb-background', getCustomize( 'ptb_breadcrumb_bg' ) );
        } )
        $( document.body ).on( 'typo_ptb_title', function () {
            if ( document.querySelector( '.page-header .page-title' ) )
                alpha_selective_typography( document.querySelector( '.page-header .page-title' ).style, 'ptb-title', getCustomize( 'typo_ptb_title' ) );
        } )
        $( document.body ).on( 'typo_ptb_subtitle', function () {
            if ( document.querySelector( '.page-header .page-subtitle' ) )
                alpha_selective_typography( document.querySelector( '.page-header .page-subtitle' ).style, 'ptb-subtitle', getCustomize( 'typo_ptb_subtitle' ) );
        } )
        $( document.body ).on( 'typo_ptb_breadcrumb', function () {
            if ( document.querySelector( '.breadcrumb' ) )
                alpha_selective_typography( document.querySelector( '.breadcrumb' ).style, 'ptb-breadcrumb', getCustomize( 'typo_ptb_breadcrumb' ) );
        } )

        $( document.body ).on( 'custom_css', function () {
            if ( !$( 'style#alpha-preview-custom-inline-css' ).length ) {
                $( '<style id="alpha-preview-custom-inline-css"></style>' ).insertAfter( '#alpha-preview-custom-css' );
            }

            $( 'style#alpha-preview-custom-inline-css' ).html( getCustomize( 'custom_css' ) );
        } )
    }

    function alpha_selective_content ( $id, $class ) {
        var $title = document.querySelector( '.product-single ' + $class );
        if ( $( $title ).length > 0 ) {
            $title.textContent = getCustomize( $id );
        }
    }

    function alpha_selective_background ( style, id, bg ) {
        if ( bg[ 'background-color' ] ) {
            style.setProperty( '--alpha-' + id + '-bg-color', bg[ 'background-color' ] );
        } else {
            style.removeProperty( '--alpha-' + id + '-bg-color' );
        }
        if ( bg[ 'background-image' ] ) {
            style.setProperty( '--alpha-' + id + '-bg-image', 'url(' + bg[ 'background-image' ] + ')' );

            if ( bg[ 'background-repeat' ] ) {
                style.setProperty( '--alpha-' + id + '-bg-repeat', bg[ 'background-repeat' ] );
            }
            if ( bg[ 'background-position' ] ) {
                style.setProperty( '--alpha-' + id + '-bg-position', bg[ 'background-position' ] );
            }
            if ( bg[ 'background-size' ] ) {
                style.setProperty( '--alpha-' + id + '-bg-size', bg[ 'background-size' ] );
            }
            if ( bg[ 'background-attachment' ] ) {
                style.setProperty( '--alpha-' + id + '-bg-attachment', bg[ 'background-attachment' ] );
            }
        } else {
            style.removeProperty( '--alpha-' + id + '-bg-image' );
            style.removeProperty( '--alpha-' + id + '-bg-repeat' );
            style.removeProperty( '--alpha-' + id + '-bg-position' );
            style.removeProperty( '--alpha-' + id + '-bg-size' );
            style.removeProperty( '--alpha-' + id + '-bg-attachment' );
        }
    }

    function alpha_selective_typography ( style, id, typo ) {
        if ( typo[ 'font-family' ] && 'inherit' != typo[ 'font-family' ] ) {
            style.setProperty( '--alpha-' + id + '-font-family', "'" + typo[ 'font-family' ] + "', sans-serif" );

            if ( !typo[ 'variant' ] ) {
                typo[ 'variant' ] = 400;
            }
        } else {
            style.removeProperty( '--alpha-' + id + '-font-family' );
        }
        if ( typo[ 'variant' ] ) {
            style.setProperty( '--alpha-' + id + '-font-weight', 'regular' == typo[ 'variant' ] ? 400 : typo[ 'variant' ] );
        } else if ( 'heading' == id ) {
            style.setProperty( '--alpha-' + id + '-font-weight', 600 );
        } else {
            style.removeProperty( '--alpha-' + id + '-font-weight' );
        }
        if ( typo[ 'font-size' ] && '' != typo[ 'font-size' ] ) {
            style.setProperty( '--alpha-' + id + '-font-size', ( Number( typo[ 'font-size' ] ) ? ( typo[ 'font-size' ] + 'px' ) : typo[ 'font-size' ] ) );
        } else {
            style.removeProperty( '--alpha-' + id + '-font-size' );
        }
        if ( typo[ 'line-height' ] && '' != typo[ 'line-height' ] ) {
            style.setProperty( '--alpha-' + id + '-line-height', typo[ 'line-height' ] );
        } else {
            style.removeProperty( '--alpha-' + id + '-line-height' );
        }
        if ( typo[ 'letter-spacing' ] && '' != typo[ 'letter-spacing' ] ) {
            style.setProperty( '--alpha-' + id + '-letter-spacing', typo[ 'letter-spacing' ] );
        } else {
            style.removeProperty( '--alpha-' + id + '-letter-spacing' );
        }
        if ( typo[ 'text-transform' ] && '' != typo[ 'text-transform' ] ) {
            style.setProperty( '--alpha-' + id + '-text-transform', typo[ 'text-transform' ] );
        } else {
            style.removeProperty( '--alpha-' + id + '-text-transform' );
        }
        if ( typo[ 'color' ] && '' != typo[ 'color' ] ) {
            style.setProperty( '--alpha-' + id + '-color', typo[ 'color' ] );
        } else {
            style.removeProperty( '--alpha-' + id + '-color' );
        }
    }

    function getHSL ( color ) {
        color = Number.parseInt( color.slice( 1 ), 16 );
        var $blue = color % 256;
        color /= 256;
        var $green = color % 256;
        var $red = color = color / 256;

        var $min = Math.min( $red, $green, $blue );
        var $max = Math.max( $red, $green, $blue );

        var $l = $min + $max;
        var $d = Number( $max - $min );
        var $h = 0;
        var $s = 0;

        if ( $d ) {
            if ( $l < 255 ) {
                $s = $d / $l;
            } else {
                $s = $d / ( 510 - $l );
            }

            if ( $red == $max ) {
                $h = 60 * ( $green - $blue ) / $d;
            } else if ( $green == $max ) {
                $h = 60 * ( $blue - $red ) / $d + 120;
            } else if ( $blue == $max ) {
                $h = 60 * ( $red - $green ) / $d + 240;
            }
        }

        return [ ( $h + 360 ) % 360, ( $s * 100 ), ( $l / 5.1 + 7 ) ];
    }

    function getLighten ( color ) {
        var hsl = getHSL( color );
        return 'hsl(' + hsl[ 0 ] + ', ' + hsl[ 1 ] + '%, ' + hsl[ 2 ] + '%)';
    }

    function getColorA ( color, opacity ) {
        var hsl = getHSL( color );
        return 'hsl(' + hsl[ 0 ] + ', ' + hsl[ 1 ] + '%, ' + hsl[ 2 ] + '%, ' + opacity + ')';
    }
} )