/**
 * Alpha Elementor Preview
 * 
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 * 
 */
'use strict';

window.themeAdmin = window.themeAdmin || {};

( function ( $ ) {
    function get_creative_class( $grid_item ) {
        var ex_class = '';
        if ( undefined != $grid_item ) {
            ex_class = 'grid-item ';
            Object.entries( $grid_item ).forEach( function ( item ) {
                if ( item[ 1 ] ) {
                    ex_class += item[ 0 ] + '-' + item[ 1 ] + ' ';
                }
            } )
        }
        return ex_class;
    }

    function gcd( $a, $b ) {
        while ( $b ) {
            var $r = $a % $b;
            $a = $b;
            $b = $r;
        }
        return $a;
    }

    function get_creative_grid_item_css( $id, $layout, $height, $height_ratio ) {
        if ( 'undefined' == typeof $layout ) {
            return;
        }

        var $deno = [];
        var $numer = [];
        var $style = '';
        var $ws = { 'w': [], 'w-l': [], 'w-m': [], 'w-s': [] };
        var $hs = { 'h': [], 'h-l': [], 'h-m': [] };

        $style += '<style scope="">';
        $layout.map( function ( $grid_item ) {
            Object.entries( $grid_item ).forEach( function ( $info ) {
                if ( 'size' == $info[ 0 ] ) {
                    return;
                }

                var $num = $info[ 1 ].split( '-' );
                if ( undefined != $num[ 1 ] && -1 == $deno.indexOf( $num[ 1 ] ) ) {
                    $deno.push( $num[ 1 ] );
                }
                if ( -1 == $numer.indexOf( $num[ 0 ] ) ) {
                    $numer.push( $num[ 0 ] );
                }

                if ( ( 'w' == $info[ 0 ] || 'w-l' == $info[ 0 ] || 'w-m' == $info[ 0 ] || 'w-s' == $info[ 0 ] ) && -1 == $ws[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
                    $ws[ $info[ 0 ] ].push( $info[ 1 ] );
                } else if ( ( 'h' == $info[ 0 ] || 'h-l' == $info[ 0 ] || 'h-m' == $info[ 0 ] ) && -1 == $hs[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
                    $hs[ $info[ 0 ] ].push( $info[ 1 ] );
                }
            } );
        } );
        Object.entries( $ws ).forEach( function ( $w ) {
            if ( !$w[ 1 ].length ) {
                return;
            }

            if ( 'w-l' == $w[ 0 ] ) {
                $style += '@media (max-width: 991px) {';
            } else if ( 'w-m' == $w[ 0 ] ) {
                $style += '@media (max-width: 767px) {';
            } else if ( 'w-s' == $w[ 0 ] ) {
                $style += '@media (max-width: 575px) {';
            }

            $w[ 1 ].map( function ( $item ) {
                var $opts = $item.split( '-' );
                var $width = ( undefined == $opts[ 1 ] ? 100 : ( 100 * $opts[ 0 ] / $opts[ 1 ] ).toFixed( 4 ) );
                $style += '.elementor-element-' + $id + ' .grid-item.' + $w[ 0 ] + '-' + $item + '{flex:0 0 ' + $width + '%;width:' + $width + '%}';
            } )

            if ( 'w-l' == $w[ 0 ] || 'w-m' == $w[ 0 ] || 'w-s' == $w[ 0 ] ) {
                $style += '}';
            }
        } );
        Object.entries( $hs ).forEach( function ( $h ) {
            if ( !$h[ 1 ].length ) {
                return;
            }

            $h[ 1 ].map( function ( $item ) {
                var $opts = $item.split( '-' ), $value;
                if ( undefined != $opts[ 1 ] ) {
                    $value = $height * $opts[ 0 ] / $opts[ 1 ];
                } else {
                    $value = $height;
                }
                if ( 'h' == $h[ 0 ] ) {
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                } else if ( 'h-l' == $h[ 0 ] ) {
                    $style += '@media (max-width: 991px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
                    $style += '}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                } else if ( 'h-m' == $h[ 0 ] ) {
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-m-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                }
            } )
        } );
        var $lcm = 1;
        $deno.map( function ( $value ) {
            $lcm = $lcm * $value / gcd( $lcm, $value );
        } );
        var $gcd = $numer[ 0 ];
        $numer.map( function ( $value ) {
            $gcd = gcd( $gcd, $value );
        } );
        var $sizer = Math.floor( 100 * $gcd / $lcm * 10000 ) / 10000;
        $style += '.elementor-element-' + $id + ' .grid' + '>.grid-space{flex: 0 0 ' + ( $sizer < 0.01 ? 100 : $sizer ) + '%;width:' + ( $sizer < 0.01 ? 100 : $sizer ) + '%}';
        $style += '</style>';
        return $style;
    }

    function initSlider( $el ) {
        if ( $el.length != 1 ) {
            return;
        }

        // var customDotsHtml = '';
        if ( $el.data( 'slider' ) ) {
            $el.data( 'slider' ).destroy();
            $el.children( '.slider-slide' ).removeClass( 'slider-slide' );
            $el.parent().siblings( '.slider-thumb-dots' ).off( 'click.preview' );
            $el.removeData( 'slider' );
        }

        theme.slider( $el, {}, true );

        // Register events for thumb dots
        var $dots = $el.parent().siblings( '.slider-thumb-dots' );
        if ( $dots.length ) {
            var slider = $el.data( 'slider' );
            $dots.on( 'click.preview', 'button', function () {
                if ( !slider.destroyed ) {
                    slider.slideTo( $( this ).index(), 300 );
                }
            } );
            slider && slider.on( 'transitionEnd', function () {
                $dots.children().removeClass( 'active' ).eq( this.realIndex ).addClass( 'active' );
            } )
        }

        Object.setPrototypeOf( $el.get( 0 ), HTMLElement.prototype );
    }

    themeAdmin.themeElementorPreview = themeAdmin.themeElementorPreview || {}
    themeAdmin.themeElementorPreview.completed = false;
    themeAdmin.themeElementorPreview.fnArray = [];
    themeAdmin.themeElementorPreview.init = function () {
        var self = this;

        $( 'body' ).on( 'click', 'a', function ( e ) {
            e.preventDefault();
        } )

        // for section, column slider's thumbs dots
        $( '.elementor-section > .slider-thumb-dots' ).parent().addClass( 'flex-wrap' );
        $( '.elementor-column > .slider-thumb-dots' ).parent().addClass( 'flex-wrap' );

        // Add close event for hs-close
        $( 'body' ).on( 'click', '.search-wrapper .hs-close', function ( e ) {
            e.preventDefault();
            $( this ).closest( '.search-wrapper' ).removeClass( 'show' );
        } );

        elementorFrontend.hooks.addAction( 'frontend/element_ready/column', function ( $obj ) {
            self.completed ? self.initColumn( $obj ) : self.fnArray.push( {
                fn: self.initColumn,
                arg: $obj
            } );
        } );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/section', function ( $obj ) {
            self.completed ? self.initSection( $obj ) : self.fnArray.push( {
                fn: self.initSection,
                arg: $obj
            } );
        } );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function ( $obj ) {
            self.completed ? self.initWidgetAdvanced( $obj ) : self.fnArray.push( {
                fn: self.initWidgetAdvanced,
                arg: $obj
            } );
        } );

        elementorFrontend.hooks.addAction( 'refresh_page_css', function ( css ) {
            var $obj = $( 'style#alpha_elementor_custom_css' );
            if ( !$obj.length ) {
                $obj = $( '<style id="alpha_elementor_custom_css"></style>' ).appendTo( 'head' );
            }
            css = css.replace( '/<script.*?\/script>/s', '' );
            $obj.html( css ).appendTo( 'head' );
        } );
    }
    themeAdmin.themeElementorPreview.onComplete = function () {
        var self = this;
        self.completed = true;

        // Edit menu easily 
        setTimeout( function () {
            $( '.alpha-block.elementor.elementor-edit-area-active' ).closest( '.dropdown-box' ).css( { "visibility": "visible", "opacity": "1", "top": "100%", "transform": "translate3d(0, 0, 0)" } );
            $( '.alpha-block.elementor.elementor-edit-area-active' ).parents( '.menu-item' ).addClass( 'show' );
        }, 2000 );

        $( '.alpha-block[data-el-class]' ).each( function () {
            $( this ).addClass( $( this ).attr( 'data-el-class' ) ).removeAttr( 'data-el-class' );
        } );

        self.initWidgets();
        self.initGlobal();
        self.fnArray.forEach( function ( obj ) {
            if ( typeof obj == 'function' ) {
                obj.call();
            } else if ( typeof obj == 'object' ) {
                obj.fn.call( self, obj.arg );
            }
        } );

        // Run extension
        if ( typeof self.initExtension == 'function' ) {
            self.initExtension();
        }
    }
    themeAdmin.themeElementorPreview.initWidgets = function () {
        var alpha_widgets = [
            alpha_vars.theme + '_widget_products.default',
            alpha_vars.theme + '_widget_brands.default',
            alpha_vars.theme + '_widget_categories.default',
            alpha_vars.theme + '_widget_posts.default',
            alpha_vars.theme + '_widget_imagegallery.default',
            alpha_vars.theme + '_widget_single_product.default',
            alpha_vars.theme + '_widget_testimonial_group.default',
            alpha_vars.theme + '_sproduct_linked_products.default',
            alpha_vars.theme + '_sproduct_image.default',
            alpha_vars.theme + '_widget_products_tab.default',
            alpha_vars.theme + '_widget_products_single.default',
            alpha_vars.theme + '_widget_products_banner.default',
            alpha_vars.theme + '_widget_vendors.default',
        ];


        // Widgets for posts
        alpha_widgets.forEach( function ( widget_name ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget_name, function ( $obj ) {
                $obj.find( '.slider-wrapper' ).each( function () {
                    initSlider( $( this ) );
                } )
                theme.isotopes( $obj.find( '.grid' ) );
                if ( typeof theme.countdown == 'function' ) {
                    theme.countdown( $obj.find( '.countdown' ) );
                }
            } );
        } );

        // Loadmore by scroll
        [ 'posts', 'products' ].forEach( function ( key ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_' + key + '.default', function ( $obj ) {
                $( window ).trigger( 'alpha_loadmore' );
            } );
        } )

        // widget for sticky
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_sproduct_cart_form.default', function ( $obj ) {
            theme.createProductSingle( '.product-single' );
            $( '.product-single' ).data( 'alpha_product_single' ).stickyCartForm( $( '.product-single .product-sticky-content' ) );
            theme.stickyContent( $obj.find( '.sticky-content' ) );
        } );

        // Widget for countdown
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_countdown.default', function ( $obj ) {
            if ( typeof theme.countdown == 'function' ) {
                theme.countdown( $obj.find( '.countdown' ) );
            }
        } );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_sproduct_flash_sale.default', function ( $obj ) {
            if ( typeof theme.countdown == 'function' ) {
                theme.countdown( $obj.find( '.countdown' ) );
            }
        } );

        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_sproduct_counter.default', function ( $obj ) {
            var $counterNumber = $obj.find( '.elementor-counter-number' );
            elementorFrontend.waypoint( $counterNumber, function () {
                var data = $counterNumber.data(),
                    decimalDigits = data.toValue.toString().match( /\.(.*)/ );

                if ( decimalDigits ) {
                    data.rounding = decimalDigits[ 1 ].length;
                }

                $counterNumber.numerator( data );
            } );
        } );

        // Widget for SVG floating
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_floating.default', function ( $obj ) {
            theme.floatSVG( $obj.find( '.float-svg' ) );
        } );

        // Single Product Image Widget Issue
        var removeFigureMarginWidgets = [ 'sproduct_image', 'sproduct_fbt', 'sproduct_data_tab', 'sproduct_linked_products', 'sproduct_vendor_products', 'widget_single_product', 'widget_posts' ];
        removeFigureMarginWidgets.forEach( function ( widget_name ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_' + widget_name + '.default', function ( $obj ) {
                $obj.addClass( 'elementor-widget-theme-post-content' );
            } );
        } )

        // Widget for banner
        var bannerWidgets = [ 'widget_banner', 'widget_products_banner' ];
        bannerWidgets.forEach( function ( widget_name ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_' + widget_name + '.default', function ( $obj ) {
                theme.parallax( $obj.find( '.parallax' ) );
                theme.appearAnimate( '.appear-animate' );
                jQuery( window ).trigger( 'appear.check' );

                if ( $obj.find( '.banner-stretch' ).length ) {
                    $obj.addClass( 'elementor-widget-alpha_banner_stretch' );
                } else {
                    $obj.removeClass( 'elementor-widget-alpha_banner_stretch' );
                }

                $obj.find( '.banner-item' ).each( function () {
                    var settings = $( this ).data( 'floating' );
                    if ( 'object' != typeof settings ) {
                        if ( $( this ).children( '.floating-wrapper' ).length ) {
                            var $wrapper = $( this ).children( '.floating-wrapper' );

                            if ( $wrapper.data( 'plugin' ) == 'floating' ) {
                                if ( $.fn.parallax ) {
                                    theme.initFloatingElements( $wrapper );
                                } else {
                                    if ( alpha_elementor.core_framework_url ) {
                                        $( document.createElement( 'script' ) ).attr( 'id', 'jquery-floating' ).appendTo( 'body' ).attr( 'src', alpha_elementor.core_framework_url + '/assets/js/jquery.floating.min.js' ).on( 'load', function () {
                                            theme.initFloatingElements( $wrapper );
                                        } );
                                    }
                                }
                            } else if ( $wrapper.data( 'plugin' ) == 'skrollr' ) {
                                if ( typeof skrollr != 'object' ) {
                                    if ( alpha_elementor.core_framework_url ) {
                                        $( document.createElement( 'script' ) ).attr( 'id', 'jquery-skrollr' ).appendTo( 'body' ).attr( 'src', alpha_elementor.core_framework_url + '/assets/js/skrollr.min.js' ).on( 'load', function () {
                                            theme.initAdvancedMotions();
                                        } );
                                    }
                                }
                                if ( typeof skrollr == 'object' && typeof skrollr.init == 'function' ) {
                                    theme.initAdvancedMotions();
                                }
                            }

                            return;
                        }
                        if ( 'object' != typeof settings ) {
                            settings = {};
                        }
                    }
                    if ( settings.floating ) {
                        if ( 0 == settings.floating.indexOf( 'mouse_tracking' ) ) {
                            $( this ).children().wrap( '<div class="layer"></div>' );
                        }

                        $( this ).children().wrap( '<div class="floating-wrapper layer-wrapper elementor-repeater-item-wrapper"></div>' );

                        themeAdmin.themeElementorPreview.initWidgetAdvanced( $( this ).children( '.floating-wrapper' ), settings ); // floating effect
                    }
                } );
            } );
        } );

        // Menu Widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_menu.default', function ( $obj ) {
            theme.lazyloadMenu();
            theme.menu.initMenu( '.elementor-element-' + $obj.attr( 'data-id' ) );
        } );
        // Widget for search
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_search.default', function ( $obj ) {
            if ( $obj.find( '.hs-toggle.hs-overlap' ).length ) {
                $obj.addClass( 'elementor-widget_alpha_search_overlap' );
            } else {
                $obj.removeClass( 'elementor-widget_alpha_search_overlap' );
            }
        } );

        // Widget / Animated Text
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_animated_text.default', function ( $obj ) {
            theme.animatedText( $( '.animating-text', $obj ) );
        } );

        // Widget / Image Compare
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_image_compare.default', function ( $obj ) {
            theme.imageCompare( $( '.icomp-container', $obj ) );
        } );

        // Widget / Progressbar
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_progressbars.default', function ( $obj ) {
            theme.initProgressbar( $obj.find( '.progress-wrapper' ), true );
        } );

        // Widget / Counter
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_counters.default', function ( $obj ) {
            theme.countTo( $obj.find( '.count-to' ), true );
        } );

        // Widget / Timeline
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_timeline.default', function ( $obj ) {
            if( typeof theme.initTimeline == 'function' ) {
                theme.initTimeline( $obj.find( '.timeline-vertical' ), true );
            }
        } );

        // Widget / Flipbox
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_flipbox.default', function ( $obj ) {
            if ( !window.elementor ) {
                return;
            }
            if( typeof theme.initFlipbox == 'function' ) {
                theme.initFlipbox( '.flipbox' );
            }
        } );

        // Widget / BarChart
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_bar_chart.default', function ( $obj ) {
            theme.initBarChart( $( '.bar-chart-container', $obj ) );
        } );

        // Widget / LineChart
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_line_chart.default', function ( $obj ) {
            theme.initLineChart( $( '.line-chart-container', $obj ) );
        } );

        // Widget / Pie-Doughnut Chart
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_pie_doughnut_chart.default', function ( $obj ) {
            theme.initPieDoughnutChart( $( '.pie-doughnut-chart-container', $obj ) );
        } );

        // Widget / RadarChart
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_radar_chart.default', function ( $obj ) {
            theme.initRadarChart( $( '.radar-chart-container', $obj ) );
        } );

        // Widget / RadarChart
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_polar_chart.default', function ( $obj ) {
            theme.initPolarChart( $( '.polar-chart-container', $obj ) );
        } );

        // Widget / 360 degree
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_widget_360_degree.default', function ( $obj ) {
            theme.threeSixty( '.alpha-360-gallery-wrapper', $obj );    // 360 degree
        } );

        // Widget / Checkout Billing
        elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_checkout_widget_billing.default', function ( $obj ) {
            if ( $().selectWoo && !$( '#billing_country' ).hasClass( 'select2-hidden-accessible' ) ) {    // checkout billing widget.
                $( '#billing_country, #billing_state' ).selectWoo( {
                    width: '100%'
                } );
            }
        } );
    }

    themeAdmin.themeElementorPreview.initSection = function ( $obj ) {
        var $container = $obj.children( '.elementor-container' ),
            $row = 0 == $obj.find( '.elementor-row' ).length ? $container : $container.children( '.elementor-row' );

        if ( $row.attr( 'data-slider-class' ) ) {
            var sliderOptions = ' data-slider-options="' + $row.attr( 'data-slider-options' ) + '"';
            $row.wrapInner( '<div class="' + $row.attr( 'data-slider-class' ) + '"' + sliderOptions + '></div>' )
                .removeAttr( 'data-slider-class' ).removeAttr( 'data-slider-options' );
            $row.children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $row );
        }

        if ( $obj.children( '.slider-thumb-dots' ).length ) {
            $obj.addClass( 'flex-wrap' );
        }

        $obj.removeData( '__parallax' );

        this.initWidgetAdvanced( $obj ); // Floating Effect

        if ( 'parallax' == $row.data( 'class' ) ) {
            $obj.addClass( 'background-none' );
            $obj.addClass( 'parallax' )
                .attr( 'data-plugin', 'parallax' )
                .attr( 'data-image-src', $row.data( 'image-src' ) )
                .attr( 'data-parallax-options', JSON.stringify( $row.data( 'parallax-options' ) ) );
            theme.parallax( $obj );
        } else {
            $obj.removeClass( 'parallax' );
            $obj.removeClass( 'background-none' );
        }

        if ( $row.hasClass( 'banner-fixed' ) && $row.hasClass( 'banner' ) && 'use_background' != $row.data( 'class' ) ) {
            $obj.css( 'background', 'none' );
        } else {
            $obj.css( 'background', '' );
        }

        if ( $row.hasClass( 'grid' ) ) {
            $row.append( '<div class="grid-space"></div>' );
            Object.setPrototypeOf( $row.get( 0 ), HTMLElement.prototype );
            var timer = setTimeout( function () {
                elementorFrontend.hooks.doAction( 'refresh_isotope_layout', timer, $row, true );
            } );
        } else {
            $row.siblings( 'style' ).remove();
            $row.children( '.grid-space' ).remove();
            $row.data( 'isotope' ) && $row.isotope( 'destroy' );
        }

        // Slider 
        if ( $row.hasClass( 'slider-wrapper' ) ) {
            if ( $row.data( 'slider' ) ) {
                $row.data( 'slider' ) && $row.data( 'slider' ).update();
            } else {
                initSlider( $row );
            }
        } else if ( $row.children( '.slider-wrapper' ).length ) {
            $row.children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $row );
            initSlider( $row.children( '.slider-wrapper' ) );
        }

        // Accordion
        if ( $row.hasClass( 'accordion' ) ) {
            setTimeout( function () {
                var $card = $row.children( '.card' ).eq( 0 );
                $card.find( '.card-header a' ).toggleClass( 'collapse' ).toggleClass( 'expand' );
                $card.find( '.card-body' ).toggleClass( 'collapsed' ).toggleClass( 'expanded' );
                $card.find( '.card-header a' ).trigger( 'click' );
            }, 300 );
        }

        // Shape Dividier            
        if ( typeof elementorFrontend.elementsHandler.elementsHandlers.section[ 4 ] == 'function' && elementorFrontend.elementsHandler.elementsHandlers.section[ 4 ].prototype.buildSVG ) {
            elementorFrontend.elementsHandler.elementsHandlers.section[ 4 ].prototype.onElementChange = function ( propertyName ) {
                if ( propertyName.match( /^shape_divider_(top|bottom)_custom$/ ) ) {
                    this.buildSVG( propertyName.match( /^shape_divider_(top|bottom)_custom$/ )[ 1 ] );
                    return;
                }
                var shapeChange = propertyName.match( /^shape_divider_(top|bottom)$/ );
                if ( shapeChange ) {
                    this.buildSVG( shapeChange[ 1 ] );
                    return;
                }
                var negativeChange = propertyName.match( /^shape_divider_(top|bottom)_negative$/ );
                if ( negativeChange ) {
                    this.buildSVG( negativeChange[ 1 ] );
                    this.setNegative( negativeChange[ 1 ] );
                }
            }
            elementorFrontend.elementsHandler.elementsHandlers.section[ 4 ].prototype.buildSVG = function buildSVG( side ) {
                var baseSettingKey = 'shape_divider_' + side,
                    shapeType = this.getElementSettings( baseSettingKey ),
                    $svgContainer = this.elements[ '$' + side + 'Container' ];
                $svgContainer.attr( 'data-shape', shapeType );

                if ( !shapeType ) {
                    $svgContainer.empty(); // Shape-divider set to 'none'

                    return;
                }

                var fileName = shapeType;

                if ( this.getElementSettings( baseSettingKey + '_negative' ) ) {
                    fileName += '-negative';
                }

                var svgURL;
                if ( shapeType.startsWith( 'alpha-' ) ) {
                    svgURL = alpha_elementor.core_framework_url + '/../assets/images/builders/elementor/shapes/' + fileName.replace( 'alpha-', '' ) + '.svg';
                } else {
                    svgURL = this.getSvgURL( shapeType, fileName );
                }

                if ( shapeType != 'custom' ) {
                    jQuery.get( svgURL, function ( data ) {
                        $svgContainer.empty().append( data.childNodes[ 0 ] );
                    } );
                } else {
                    var data = this.getElementSettings( baseSettingKey + '_custom' );
                    var svgManager = elementor.helpers;
                    data = data.value;
                    if ( !data.id ) {
                        $svgContainer.empty();
                        return;
                    }

                    if ( svgManager._inlineSvg.hasOwnProperty( data.id ) ) {
                        data && $svgContainer.empty().html( svgManager._inlineSvg[ data.id ] );
                        return;
                    }
                    svgManager.fetchInlineSvg( data.url, function ( svgData ) {
                        if ( svgData ) {
                            svgManager._inlineSvg[ data.id ] = svgData; //$( data ).find( 'svg' )[ 0 ].outerHTML;
                            svgData && $svgContainer.empty().html( svgData );
                            elementor.channels.editor.trigger( 'svg:insertion', svgData, data.id );
                        }
                    } );
                }
                this.setNegative( side );
            }
        }
    }

    themeAdmin.themeElementorPreview.initColumn = function ( $obj ) {
        var $row = 0 == $obj.closest( '.elementor-row' ).length ? $obj.closest( '.elementor-container' ) : $obj.closest( '.elementor-row' ),
            $column = $obj.children( '.elementor-column-wrap' ),
            $wrapper = 0 == $obj.closest( '.elementor-row' ).length ? $row : $row.parent(),
            $classes = [];

        $column = 0 === $column.length ? $obj.children( '.elementor-widget-wrap' ) : $column;

        this.initWidgetAdvanced( $obj ); // floating effect

        if ( $column.attr( 'data-slider-class' ) ) {
            var sliderOptions = ' data-slider-options="' + $column.attr( 'data-slider-options' ) + '"';
            if ( $column.hasClass( 'elementor-column-wrap' ) ) {
                $column.children( '.elementor-widget-wrap' ).wrapInner( '<div class="' + $column.attr( 'data-slider-class' ) + '"' + sliderOptions + '></div>' )
                    .removeAttr( 'data-slider-class' ).removeAttr( 'data-slider-options' );
                $column.children( '.elementor-widget-wrap' ).children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $column );
            } else {
                $column.wrapInner( '<div><div class="' + $column.attr( 'data-slider-class' ) + '"' + sliderOptions + '></div></div>' )
                    .removeAttr( 'data-slider-class' ).removeAttr( 'data-slider-options' );
                $column.children().children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $column );
            }
        }
        if ( $column.find( '.slider-wrapper' ).length && $column.siblings( '.slider-thumb-dots' ).length ) {
            $column.parent().addClass( 'flex-wrap' );
        }

        if ( $column.attr( 'data-css-classes' ) ) {
            $classes = $column.attr( 'data-css-classes' ).split( ' ' );
        }

        if ( $row.hasClass( 'grid' ) ) { // Refresh isotope
            if ( !$row.data( 'creative-preset' ) ) {
                $.ajax( {
                    url: alpha_elementor.ajax_url,
                    data: {
                        action: 'alpha_load_creative_layout',
                        nonce: alpha_elementor.wpnonce,
                        mode: $row.data( 'creative-mode' ),
                    },
                    type: 'post',
                    async: false,
                    success: function ( res ) {
                        if ( res ) {
                            $row.data( 'creative-preset', res );
                        }
                    }
                } );
            }
            // Remove existing layout classes
            var cls = $obj.attr( 'class' );
            cls = cls.slice( 0, cls.indexOf( "grid-item" ) ) + cls.slice( cls.indexOf( "size-" ) );
            $obj.attr( 'class', cls );
            $obj.removeClass( 'size-small size-medium size-large e' );

            var preset = JSON.parse( $row.data( 'creative-preset' ) );
            var item_data = $column.data( 'creative-item' );
            var grid_item = {};

            if ( undefined == preset[ $obj.index() ] ) {
                grid_item = { 'w': '1-4', 'w-l': '1-2', 'h': '1-3' };
            } else {
                grid_item = preset[ $obj.index() ];
            }

            if ( undefined != item_data[ 'w' ] ) {
                grid_item[ 'w' ] = grid_item[ 'w-l' ] = grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w' ];
            }
            if ( undefined != item_data[ 'w-l' ] ) {
                grid_item[ 'w-l' ] = grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w-l' ];
            }
            if ( undefined != item_data[ 'w-m' ] ) {
                grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w-m' ];
            }
            if ( undefined != item_data[ 'h' ] && 'preset' != item_data[ 'h' ] ) {
                if ( 'child' == item_data[ 'h' ] ) {
                    grid_item[ 'h' ] = '';
                } else {
                    grid_item[ 'h' ] = item_data[ 'h' ];
                }
            }
            if ( undefined != item_data[ 'h-l' ] && 'preset' != item_data[ 'h-l' ] ) {
                if ( 'child' == item_data[ 'h-l' ] ) {
                    grid_item[ 'h-l' ] = '';
                } else {
                    grid_item[ 'h-l' ] = item_data[ 'h-l' ];
                }
            }
            if ( undefined != item_data[ 'h-m' ] && 'preset' != item_data[ 'h-m' ] ) {
                if ( 'child' == item_data[ 'h-m' ] ) {
                    grid_item[ 'h-m' ] = '';
                } else {
                    grid_item[ 'h-m' ] = item_data[ 'h-m' ];
                }
            }

            var style = '<style>';
            Object.entries( grid_item ).forEach( function ( item ) {
                if ( 'h' == item[ 0 ] || 'size' == item[ 0 ] || !Number( item[ 1 ] ) ) {
                    return;
                }
                if ( 100 % item[ 1 ] == 0 ) {
                    if ( 1 == item[ 1 ] ) {
                        grid_item[ item[ 0 ] ] = '1';
                    } else {
                        grid_item[ item[ 0 ] ] = '1-' + ( 100 / item[ 1 ] );
                    }
                } else {
                    for ( var i = 1; i <= 100; ++i ) {
                        var val = item[ 1 ] * i;
                        var val_round = Math.round( val );
                        if ( Math.abs( Math.ceil( ( val - val_round ) * 100 ) / 100 ) <= 0.01 ) {
                            var g = gcd( 100, val_round );
                            var numer = val_round / g;
                            var deno = i * 100 / g;
                            grid_item[ item[ 0 ] ] = numer + '-' + deno;

                            // For Smooth Resizing of Isotope Layout
                            if ( 'w-l' == item[ 0 ] ) {
                                style += '@media (max-width: 991px) {';
                            } else if ( 'w-m' == item[ 0 ] ) {
                                style += '@media (max-width: 767px) {';
                            }

                            style += '.elementor-element-' + $row.closest( '.elementor-section' ).attr( 'data-id' ) + ' .grid-item.' + item[ 0 ] + '-' + numer + '-' + deno + '{flex:0 0 ' + ( numer * 100 / deno ).toFixed( 4 ) + '%;width:' + ( numer * 100 / deno ).toFixed( 4 ) + '%}';

                            if ( 'w-l' == item[ 0 ] || 'w-m' == item[ 0 ] ) {
                                style += '}';
                            }
                            break;
                        }
                    }

                }
            } )
            style += '</style>';
            $row.before( style );

            $obj.addClass( get_creative_class( grid_item ) );

            // Set Order Data
            $obj.attr( 'data-creative-order', ( undefined == $column.attr( 'data-creative-order' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order' ) ) );
            $obj.attr( 'data-creative-order-lg', ( undefined == $column.attr( 'data-creative-order-lg' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order-lg' ) ) );
            $obj.attr( 'data-creative-order-md', ( undefined == $column.attr( 'data-creative-order-md' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order-md' ) ) );

            var layout = $row.data( 'creative-layout' );
            if ( !layout ) {
                layout = [];
            }
            layout[ $obj.index() ] = grid_item;
            $row.data( 'creative-layout', layout );
            $row.find( '.grid-space' ).appendTo( $row );
            Object.setPrototypeOf( $obj.get( 0 ), HTMLElement.prototype );
            var timer = setTimeout( function () {
                elementorFrontend.hooks.doAction( 'refresh_isotope_layout', timer, $row );
            }, 300 );
        }

        if ( 0 < $obj.find( '.slider-wrapper' ).length ) {
            $obj.find( '.elementor-widget-wrap > .elementor-background-overlay' ).remove();
        }
        this.completed && initSlider( $obj.find( '.slider-wrapper' ) ); // issue
        if ( $row.hasClass( 'slider-wrapper' ) ) { // Slider
            initSlider( $row );
        } else if ( $row.children( '.slider-wrapper' ).length ) {
            initSlider( $row.children( '.slider-wrapper' ) );
        } else if ( $wrapper.hasClass( 'tab' ) ) { // Tab
            var title = $column.data( 'tab-title' ) || alpha_elementor.text_untitled;
            var content = $wrapper.children( '.tab-content' ),
                icon = $column.data( 'tab-icon' ),
                icon_pos = $column.data( 'tab-icon-pos' ),
                html = '';

            // Add a new tab
            if ( !$obj.parent().hasClass( 'tab-content' ) ) {
                content.append( $obj );
            }

            if ( icon && ( 'up' == icon_pos || 'left' == icon_pos ) ) {
                html += '<i class="' + icon + '"></i>';
            }
            html += title;
            if ( !title && !icon ) {
                html += 'Tab Title';
            }
            if ( icon && ( 'down' == icon_pos || 'right' == icon_pos ) ) {
                html += '<i class="' + icon + '"></i>';
            }

            // Delete tab
            $wrapper.children( '.nav-tabs' ).children( 'li' ).each( function () {
                var id = $( this ).attr( 'pane-id' );
                $( '.elementor-column[data-id="' + id + '"]' ).length || $( this ).remove();
            } )

            //  Set columns' id from data-id
            $obj.add( $obj.siblings() ).each( function () {
                var $col = $( this );
                $col.data( 'id' ) && $col.attr( 'id', $col.data( 'id' ) );
            } )

            $obj.addClass( 'tab-pane' );
            var $links = $wrapper.children( 'ul.nav' );
            if ( $links.find( '[pane-id="' + $obj.data( 'id' ) + '"]' ).length ) {
                var $nav = $links.find( '[pane-id="' + $obj.data( 'id' ) + '"]' );
                $nav.removeClass( 'nav-icon-left nav-icon-right nav-icon-up nav-icon-down' ).addClass( 'nav-icon-' + icon_pos );
                $nav.find( 'a' ).html( html );
            } else {
                $links.append( '<li class="nav-item ' + ( icon ? 'nav-icon-' + icon_pos : '' ) + '" pane-id="' + $obj.data( 'id' ) + '"><a class="nav-link" data-toggle="tab" href="' + $obj.data( 'id' ) + '">' + html + '</a></li>' );
            }
            var $first = $wrapper.find( 'ul.nav > li:first-child > a' );
            if ( !$first.hasClass( 'active' ) && 0 == $wrapper.find( 'ul.nav .active' ).length ) {
                $first.addClass( 'active' );
                $first.closest( 'ul.nav' ).next( '.tab-content' ).find( '.tab-pane:first-child' ).addClass( 'active' );
            }
        } else if ( $row.hasClass( 'accordion' ) ) { // Accordion
            $obj.addClass( 'card' );
            var $header = $obj.children( '.card-header' ),
                $body = $obj.children( '.card-body' );

            $body.attr( 'id', $obj.data( 'id' ) );

            var title = $column.data( 'accordion-title' ) || alpha_elementor.text_untitled;
            $header.html( '<a href="' + $obj.data( 'id' ) + '"  class="collapse"><i class="' + $body.attr( 'data-accordion-icon' ) + '"></i><span class="title">' + title + '</span><span class="toggle-icon closed"><i class="' + $row.data( 'toggle-icon' ) + '"></i></span><span class="toggle-icon opened"><i class="' + $row.data( 'toggle-active-icon' ) + '"></i></span></a>' ); // updated
        } else if ( $row.hasClass( 'banner' ) ) {  // Column Banner Layer
            var banner_class = $column.data( 'banner-class' );
            if ( -1 == $classes.indexOf( 't-c' ) ) {
                $obj.removeClass( 't-c' );
            }
            if ( -1 == $classes.indexOf( 't-m' ) ) {
                $obj.removeClass( 't-m' );
            }
            if ( -1 == $classes.indexOf( 't-mc' ) ) {
                $obj.removeClass( 't-mc' );
            }
            $obj.removeClass( 'banner-content' );
            if ( banner_class ) {
                $obj.addClass( banner_class );
            }
            // $row.hasClass('parallax') && theme.parallax($row);
        }
    }

    themeAdmin.themeElementorPreview.initWidgetAdvanced = function ( $obj, settings ) {
        var $parent = $obj.parent(),
            widget_settings;

        if ( $parent.hasClass( 'slider-wrapper' ) ) {
            initSlider( $parent );
        } else if ( $parent.hasClass( 'slider-container' ) && $obj.siblings( '.slider-wrapper' ).length ) {
            var $slider = $obj.siblings( '.slider-wrapper' );
            $obj.remove().appendTo( $slider );
            initSlider( $slider );
        }
        if ( 'undefined' == typeof settings ) {
            widget_settings = this.widgetEditorSettings( $obj.data( 'id' ) );
        } else {
            widget_settings = settings;
        }

        if ( $obj.data( 'parallax' ) ) {
            $obj.parallax( 'disable' );
            $obj.removeData( 'parallax' );
            $obj.removeData( 'options' );
        }

        if ( typeof theme == 'object' && typeof theme.initAdvancedMotions == 'function' ) {
            theme.initAdvancedMotions( $obj, 'destroy' );
        }

        if ( 'object' == typeof widget_settings && widget_settings.floating ) {
            var floating_settings = widget_settings.floating;
            if ( floating_settings.type ) {
                if ( 0 == floating_settings.type.indexOf( 'mouse_tracking' ) ) {
                    $obj.attr( 'data-plugin', 'floating' );

                    var settings = {};

                    if ( 'yes' == floating_settings[ 'm_track_dir' ] ) {
                        settings[ 'invertX' ] = true;
                        settings[ 'invertY' ] = true;
                    } else {
                        settings[ 'invertX' ] = false;
                        settings[ 'invertY' ] = false;
                    }

                    if ( 'mouse_tracking_x' == floating_settings[ 'type' ] ) {
                        settings[ 'limitY' ] = '0';
                    } else if ( 'mouse_tracking_y' == floating_settings[ 'type' ] ) {
                        settings[ 'limitX' ] = '0';
                    }

                    $obj.attr( 'data-options', JSON.stringify( settings ) );
                    $obj.attr( 'data-floating-depth', floating_settings[ 'm_track_speed' ] );

                    if ( $.fn.parallax ) {
                        theme.initFloatingElements( $obj );
                    } else {
                        if ( alpha_elementor.core_framework_url ) {
                            $( document.createElement( 'script' ) ).attr( 'id', 'jquery-floating' ).appendTo( 'body' ).attr( 'src', alpha_elementor.core_framework_url + '/assets/js/jquery.floating.min.js' ).on( 'load', function () {
                                theme.initFloatingElements( $obj );
                            } );
                        }
                    }

                    return;
                } else if ( 0 == floating_settings.type.indexOf( 'skr_' ) ) {
                    $obj.attr( 'data-plugin', 'skrollr' );

                    var settings = {};

                    if ( 0 == floating_settings.type.indexOf( 'skr_transform_' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_transform_up':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, ' + floating_settings.scroll_size + '%);';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, -' + floating_settings.scroll_size + '%);';
                                break;
                            case 'skr_transform_down':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, -' + floating_settings.scroll_size + '%);';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, ' + floating_settings.scroll_size + '%);';
                                break;
                            case 'skr_transform_left':
                                settings[ 'data-bottom-top' ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0);';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0);';
                                break;
                            case 'skr_transform_right':
                                settings[ 'data-bottom-top' ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0);';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0);';
                                break;
                        }
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_fade_in' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_fade_in':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, 0); opacity: 0;';
                                break;
                            case 'skr_fade_in_up':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, ' + floating_settings.scroll_size + '%); opacity: 0;';
                                break;
                            case 'skr_fade_in_down':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, -' + floating_settings.scroll_size + '%); opacity: 0;';
                                break;
                            case 'skr_fade_in_left':
                                settings[ 'data-bottom-top' ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                break;
                            case 'skr_fade_in_right':
                                settings[ 'data-bottom-top' ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                break;
                        }

                        settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0%, 0%); opacity: 1;';
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_fade_out' ) ) {
                        settings[ 'data-bottom-top' ] = 'transform: translate(0%, 0%); opacity: 1;';

                        switch ( floating_settings.type ) {
                            case 'skr_fade_out':
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, 0); opacity: 0;';
                                break;
                            case 'skr_fade_out_up':
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, -' + floating_settings.scroll_size + '%); opacity: 0;';
                                break;
                            case 'skr_fade_out_down':
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, ' + floating_settings.scroll_size + '%); opacity: 0;';
                                break;
                            case 'skr_fade_out_left':
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                break;
                            case 'skr_fade_out_right':
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                break;
                        }
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_flip' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_flip_x':
                                settings[ 'data-bottom-top' ] = 'transform: perspective(20cm) rotateY(' + floating_settings.scroll_size + 'deg)';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: perspective(20cm), rotateY(-' + floating_settings.scroll_size + 'deg)';
                                break;
                            case 'skr_flip_y':
                                settings[ 'data-bottom-top' ] = 'transform: perspective(20cm) rotateX(-' + floating_settings.scroll_size + 'deg)';
                                settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: perspective(20cm), rotateX(' + floating_settings.scroll_size + 'deg)';
                                break;
                        }
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_rotate' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_rotate':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, 0) rotate(-' + ( 360 * floating_settings.scroll_size / 50 ) + 'deg);';
                                break;
                            case 'skr_rotate_left':
                                settings[ 'data-bottom-top' ] = 'transform: translate(' + ( 100 * floating_settings.scroll_size / 50 ) + '%, 0) rotate(-' + ( 360 * floating_settings.scroll_size / 50 ) + 'deg);';
                                break;
                            case 'skr_rotate_right':
                                settings[ 'data-bottom-top' ] = 'transform: translate(-' + ( 100 * floating_settings.scroll_size / 50 ) + '%, 0) rotate(-' + ( 360 * floating_settings.scroll_size / 50 ) + 'deg);';
                                break;
                        }

                        settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, 0) rotate(0deg);';
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_zoom_in' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_zoom_in':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, 0) scale(' + ( 1 - floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_in_up':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, ' + ( 40 + floating_settings.scroll_size ) + '%) scale(' + ( 1 - floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_in_down':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, -' + ( 40 + floating_settings.scroll_size ) + '%) scale(' + ( 1 - floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_in_left':
                                settings[ 'data-bottom-top' ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0) scale(' + ( 1 - floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_in_right':
                                settings[ 'data-bottom-top' ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0) scale(' + ( 1 - floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                        }

                        settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, 0) scale(1);';
                    } else if ( 0 === floating_settings.type.indexOf( 'skr_zoom_out' ) ) {
                        switch ( floating_settings.type ) {
                            case 'skr_zoom_out':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, 0) scale(' + ( 1 + floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_out_up':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, ' + ( 40 + floating_settings.scroll_size ) + '%) scale(' + ( 1 + floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_out_down':
                                settings[ 'data-bottom-top' ] = 'transform: translate(0, -' + ( 40 + floating_settings.scroll_size ) + '%) scale(' + ( 1 + floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_out_left':
                                settings[ 'data-bottom-top' ] = 'transform: translate(' + floating_settings.scroll_size + '%, 0) scale(' + ( 1 + floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                            case 'skr_zoom_out_right':
                                settings[ 'data-bottom-top' ] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0) scale(' + ( 1 + floating_settings.scroll_size / 100 ) + '); transform-origin: center;';
                                break;
                        }

                        settings[ 'data-' + floating_settings.scroll_stop ] = 'transform: translate(0, 0) scale(1);';
                    }

                    $obj.attr( 'data-options', JSON.stringify( settings ) );

                    if ( typeof skrollr != 'object' ) {
                        if ( alpha_elementor.core_framework_url ) {
                            $( document.createElement( 'script' ) ).attr( 'id', 'jquery-skrollr' ).appendTo( 'body' ).attr( 'src', alpha_elementor.core_framework_url + '/assets/js/skrollr.min.js' ).on( 'load', function () {
                                theme.initAdvancedMotions();
                            } );
                        }
                    }
                }
            }
        }

        if ( typeof skrollr == 'object' && typeof skrollr.init == 'function' ) {
            theme.initAdvancedMotions();
        }

        // Duplex
        if ( widget_settings.duplex && widget_settings.duplex.enabled ) {
            $obj.addClass( 'duplex-widget' );
            if ( !$obj.find( '.duplex-wrap' ).length ) {
                var $duplex_after = $obj.find( '.elementor-widget-container' );
                var $duplex = '';
                if ( 'text' == widget_settings.duplex.type ) {
                    $duplex =
                        '<div class="duplex-wrap">' +
                        '<span class="duplex duplex-text">' + widget_settings.duplex.text + '</span>' +
                        '</div>';
                } else {
                    $duplex =
                        '<div class="duplex-wrap">' +
                        '<div class="duplex duplex-image">' +
                        '<img src="' + widget_settings.duplex.image.url + '" alt="">' +
                        '</div>' +
                        '</div>';
                }

                $duplex_after.prepend( $duplex );
            }
        }

        // Ribbon
        if ( widget_settings.ribbon && widget_settings.ribbon.enabled ) {
            if ( 'type-4' == widget_settings.ribbon.type || 'type-5' == widget_settings.ribbon.type ) {
                $obj.addClass( 'ribbon-added-widget ribbon-overflow-hidden' );
            } else {
                $obj.removeClass( 'ribbon-overflow-hidden' ).addClass( 'ribbon-added-widget' );
            }

            if ( !$obj.find( '.ribbon' ).length ) {
                var $ribbon_after = $obj.find( '.elementor-widget-container' );
                var $ribbon = '';
                if ( 'type-1' == widget_settings.ribbon.type || 'type-2' == widget_settings.ribbon.type || 'type-5' == widget_settings.ribbon.type || 'type-6' == widget_settings.ribbon.type ) {
                    $ribbon =
                        '<div class="ribbon ribbon-' + widget_settings.ribbon.type + ' ribbon-' + widget_settings.ribbon.position + '">' +
                        '<span class="ribbon-text">' + ( widget_settings.ribbon.text ? widget_settings.ribbon.text : alpha_vars.texts.ribbon ) + '</span>' +
                        '</div>';
                } else {
                    $ribbon =
                        '<div class="ribbon ribbon-' + widget_settings.ribbon.type + ' ribbon-' + widget_settings.ribbon.position + '">' +
                        '<span class="ribbon-icon ' + widget_settings.ribbon.icon + '"></span>' +
                        '</div>';
                }

                $ribbon_after.prepend( $ribbon );
            }
        } else {
            $obj.removeClass( 'ribbon-added-widget ribbon-overflow-hidden' );
        }
    }

    themeAdmin.themeElementorPreview.widgetEditorSettings = function ( widgetId ) {
        var editorElements = null,
            widgetData = {};

        if ( !window.elementor.hasOwnProperty( 'elements' ) ) {
            return false;
        }

        editorElements = window.elementor.elements;

        if ( !editorElements.models ) {
            return false;
        }

        var found = false;

        $.each( editorElements.models, function ( index, obj ) {
            if ( found ) {
                return;
            }

            if ( widgetId == obj.id ) {
                widgetData = obj.attributes.settings.attributes;
                return;
            }

            $.each( obj.attributes.elements.models, function ( index, obj ) {
                if ( found ) {
                    return;
                }

                if ( widgetId == obj.id ) {
                    widgetData = obj.attributes.settings.attributes;
                    return;
                }

                $.each( obj.attributes.elements.models, function ( index, obj ) {
                    if ( found ) {
                        return;
                    }

                    if ( widgetId == obj.id ) {
                        widgetData = obj.attributes.settings.attributes;
                        return;
                    }

                    $.each( obj.attributes.elements.models, function ( index, obj ) {
                        if ( found ) {
                            return;
                        }

                        if ( widgetId == obj.id ) {
                            widgetData = obj.attributes.settings.attributes;
                            return;
                        }

                        $.each( obj.attributes.elements.models, function ( index, obj ) {
                            if ( found ) {
                                return;
                            }

                            if ( widgetId == obj.id ) {
                                widgetData = obj.attributes.settings.attributes;
                            }

                        } );

                    } );
                } );

            } );

        } );

        var floating = {
            type: widgetData[ 'alpha_floating' ],
            m_track_dir: widgetData[ 'alpha_m_track_dir' ],
            m_track_speed: 'object' == typeof widgetData[ 'alpha_m_track_speed' ] && widgetData[ 'alpha_m_track_speed' ][ 'size' ] ? widgetData[ 'alpha_m_track_speed' ][ 'size' ] : 0.5,
            scroll_size: 'object' == typeof widgetData[ 'alpha_scroll_size' ] && widgetData[ 'alpha_scroll_size' ][ 'size' ] ? widgetData[ 'alpha_scroll_size' ][ 'size' ] : 50,
            scroll_stop: 'undefined' == typeof widgetData[ 'alpha_scroll_stop' ] ? 'center' : widgetData[ 'alpha_scroll_stop' ]
        };
        var duplex = {};
        if ( 'true' == widgetData[ 'alpha_widget_duplex' ] ) {
            duplex.enabled = true;
            if ( 'text' == widgetData[ 'alpha_widget_duplex_type' ] ) {
                duplex.type = 'text';
                duplex.text = widgetData[ 'alpha_widget_duplex_text' ];
            } else {
                duplex.type = 'image';
                duplex.image = {
                    url: widgetData[ 'alpha_widget_duplex_image' ][ 'url' ]
                };
            }
        }

        var ribbon = {};
        if ( 'true' == widgetData[ 'alpha_widget_ribbon' ] ) {
            ribbon.enabled = true;

            if ( 'type-1' == widgetData[ 'alpha_widget_ribbon_type' ] || 'type-2' == widgetData[ 'alpha_widget_ribbon_type' ] || 'type-5' == widgetData[ 'alpha_widget_ribbon_type' ] || 'type-6' == widgetData[ 'alpha_widget_ribbon_type' ] ) {
                ribbon.type = widgetData[ 'alpha_widget_ribbon_type' ];
                ribbon.text = widgetData[ 'alpha_widget_ribbon_text' ];
                ribbon.position = widgetData[ 'alpha_widget_ribbon_position' ];
            } else {
                ribbon.type = widgetData[ 'alpha_widget_ribbon_type' ];
                ribbon.icon = widgetData[ 'alpha_widget_ribbon_icon' ][ 'value' ];
                ribbon.position = widgetData[ 'alpha_widget_ribbon_position' ];
            }
        }

        return { floating: floating, duplex: duplex, ribbon: ribbon };
    }

    themeAdmin.themeElementorPreview.initGlobal = function () {
        if ( typeof elementor != 'object' ) return;
        elementor.channels.data.on( 'element:after:add', function ( e ) {
            var $obj = $( '[data-id="' + e.id + '"]' ),
                $row = $obj.closest( '.elementor-row' ),
                $column = 'widget' == e.elType ? $obj.closest( '.elementor-widget-wrap' ) : false;
            if ( 'widget' == e.elType && $column.hasClass( 'slider-wrapper' ) ) {
                initSlider( $column );
            } else if ( 'column' == e.elType && $row.data( 'slider' ) ) {
                $row.data( 'slider' ).destroy();
                $row.removeData( 'slider' );
            } else if ( 'column' == e.elType && $row.data( 'isotope' ) ) {
                $row.data( 'isotope' ) && $row.isotope( 'destroy' );
            }
        } );

        elementor.channels.data.on( 'element:before:remove', function ( e ) {
            var $obj = $( '[data-id="' + e.id + '"]' ),
                $row = $obj.closest( '.elementor-row' ),
                $column = 'widget' == e.attributes.elType ? $obj.closest( '.elementor-widget-wrap' ) : false;
            if ( 'widget' == e.attributes.elType && $column.hasClass( 'slider-wrapper' ) ) {
                initSlider( $column );
            } else if ( 'column' == e.attributes.elType && $row.data( 'slider' ) ) {
                var pos = $obj.parent( '.slider-slide:not(.slider-slide-duplicate)' ).index() - ( $row.find( '.slider-slide.slider-slide-duplicate' ).length / 2 );
                $row.data( 'slider' ).removeSlide( pos );
            } else if ( 'column' == e.attributes.elType && $row.data( 'isotope' ) ) {
                $row.isotope( 'remove', $obj ).isotope( 'layout' );
            }
        } );

        elementorFrontend.hooks.addAction( 'refresh_isotope_layout', function ( timer, $selector, force ) {
            if ( undefined == force ) {
                force = false;
            }

            if ( timer ) {
                clearTimeout( timer );
            }

            if ( undefined == $selector ) {
                $selector = $( '.elementor-element-editable' ).closest( '.grid' );
            }

            $selector.siblings( 'style' ).remove();
            $selector.parent().prepend( get_creative_grid_item_css(
                $selector.closest( '.elementor-section' ).data( 'id' ),
                $selector.data( 'creative-layout' ),
                $selector.data( 'creative-height' ),
                $selector.data( 'creative-height-ratio' ) ) );

            if ( true === force ) {
                $selector.data( 'isotope' ) && $selector.isotope( 'destroy' );
                theme.isotopes( $selector );
            } else {
                if ( $selector.data( 'isotope' ) ) {
                    $selector.removeAttr( 'data-current-break' );
                    $selector.isotope( 'reloadItems' );
                    $selector.isotope( 'layout' );
                } else {
                    theme.isotopes( $selector );
                }
            }
            var slider = $selector.find( '.slider-wrapper' ).data( slider );
            slider && slider.slider && slider.slider.update();
            $( window ).trigger( 'resize' );
        } );
    }

    /**
     * Setup AlphaElementorPreview
     */
    $( window ).on( 'load', function () {
        if ( typeof elementorFrontend != 'undefined' && typeof theme != 'undefined' ) {
            if ( elementorFrontend.hooks ) {
                themeAdmin.themeElementorPreview.init();
                themeAdmin.themeElementorPreview.onComplete();
            } else {
                elementorFrontend.on( 'components:init', function () {
                    themeAdmin.themeElementorPreview.init();
                    themeAdmin.themeElementorPreview.onComplete();
                } );
            }
            // Header and Footer Type preset
            if ( window.top.alpha_core_vars.template_type && ( window.top.alpha_core_vars.template_type == 'header' || window.top.alpha_core_vars.template_type == 'footer' ) ) {
                window.top.elementor.presetsFactory.getPresetSVG = function getPresetSVG( preset, svgWidth, svgHeight, separatorWidth ) {
                    var _ = window.top._;
                    if ( _.isEqual( preset, [ 'flex-1', 'flex-auto' ] ) ) {
                        var svg = document.createElement( 'svg' );
                        var protocol = 'http';
                        svg.setAttribute( 'viewBox', '0 0 88.3 44.2' );
                        svg.setAttributeNS( protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink' );
                        svg.innerHTML = '<rect fill="#D5DADF" width="73.8" height="44.2"></rect> <rect x="75.5" fill="#D5DADF" width="12.8" height="44.2"></rect> <text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.alpha_core_vars.template_type + '</text>';
                        return svg;
                    }
                    else if ( _.isEqual( preset, [ 'flex-1', 'flex-auto', 'flex-1' ] ) ) {
                        var svg = document.createElement( 'svg' );
                        var protocol = 'http';
                        svg.setAttribute( 'viewBox', '0 0 88.3 44.2' );
                        svg.setAttributeNS( protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink' );
                        svg.innerHTML = '<rect fill="#D5DADF" width="35" height="44.2"></rect><rect x="53.4" fill="#D5DADF" width="35" height="44.2" ></rect><rect x="36.9" fill="#D5DADF" width="14.5" height="44.2"></rect><text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.alpha_core_vars.template_type + '</text>';
                        return svg;
                    }
                    else if ( _.isEqual( preset, [ 'flex-auto', 'flex-1', 'flex-auto' ] ) ) {
                        var svg = document.createElement( 'svg' );
                        var protocol = 'http';
                        svg.setAttribute( 'viewBox', '0 0 88.3 44.2' );
                        svg.setAttributeNS( protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink' );
                        svg.innerHTML = '<rect fill="#D5DADF" width="11.5" height="44.2"></rect><rect x="59.2" fill="#D5DADF" width="29.2" height="44.2"></rect><rect x="13.7" fill="#D5DADF" width="43.5" height="44.2"></rect> <text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.alpha_core_vars.template_type + '</text></svg>';
                        return svg;
                    }
                    svgWidth = svgWidth || 100;
                    svgHeight = svgHeight || 50;
                    separatorWidth = separatorWidth || 2;

                    var absolutePresetValues = this.getAbsolutePresetValues( preset ),
                        presetSVGPath = this._generatePresetSVGPath( absolutePresetValues, svgWidth, svgHeight, separatorWidth );

                    return this._createSVGPreset( presetSVGPath, svgWidth, svgHeight );
                }
            }

            // check if current template is popup   
            if ( $( 'body' ).hasClass( 'alpha_popup_template' ) ) {
                var $edit_area = $( 'main [data-elementor-id]' ),
                    id = $edit_area.data( 'elementor-id' );
                $edit_area.parent().prepend( '<div class="mfp-bg mfp-fade mfp-alpha-' + id + ' mfp-ready"></div>' );
                $edit_area.wrap( '<div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-fade mfp-alpha mfp-alpha-' + id + ' mfp-ready" tabindex="-1" style="overflow: hidden auto;"><div class="mfp-container mfp-inline-holder"><div class="mfp-content"><div id="alpha-popup-' + id + '" class="popup mfp-fade"><div class="alpha-popup-content"></div></div></div></div></div>' )
            }
        }
    } );
} )( jQuery );