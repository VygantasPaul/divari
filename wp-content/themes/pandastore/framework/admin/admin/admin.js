/**
 * Javascript Library for Admin
 * 
 * - Admin Dashboard
 * 
 * @since 1.0
 * @package  Alpha FrameWork
 */
'use strict';

window.themeAdmin = window.themeAdmin || {};

// Admin Dashboard
( function ( wp, $ ) {
    themeAdmin.$body = $( 'body' );
    themeAdmin.$window = $( window );

    /**
	 * Set cookie
	 * 
	 * @since 1.0
	 * @param {string} name Cookie name
	 * @param {string} value Cookie value
	 * @param {number} exdays Expire period
	 * @return {void}
	 */
    themeAdmin.setCookie = function ( name, value, exdays ) {
        var date = new Date();
        date.setTime( date.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
        document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
    }

	/**
	 * Get cookie
	 *
	 * @since 1.0
	 * @param {string} name Cookie name
	 * @return {string} Cookie value
	 */
    themeAdmin.getCookie = function ( name ) {
        var n = name + "=";
        var ca = document.cookie.split( ';' );
        for ( var i = 0; i < ca.length; ++i ) {
            var c = ca[ i ];
            while ( c.charAt( 0 ) == ' ' ) {
                c = c.substring( 1 );
            }
            if ( c.indexOf( n ) == 0 ) {
                return c.substring( n.length, c.length );
            }
        }
        return "";
    }

    /**
     * initGreeting
     * 
     * Change greeting text.
     * 
     * @since 1.0
     */
    themeAdmin.initGreeting = ( function ( selector ) {
        var today = new Date(),
            hours = today.getHours(),
            $greet = $( selector );

        if ( hours <= 12 ) {
            $greet.html( 'Good Morning ' );
        } else if ( hours <= 18 ) {
            $greet.html( 'Good Afternoon ' );
        } else {
            $greet.html( 'Good Evening ' );
        }
    } )( '.greeting' );

    /**
     * initStickyLinks
     * 
     * @since 1.0
     */
    themeAdmin.initStickyLinks = ( function ( selector ) {
        var $wrapper = $( selector );
        $wrapper.find( 'a > span' ).each( function () {
            var $this = $( this );
            $this.css( 'width', this.clientWidth );
        } );
        $wrapper.addClass( 'loaded' );

    } )( '.alpha-admin-sticky-buttons' );

    /**
     * initThemeSkin
     * 
     * @since 1.0
     */
    themeAdmin.initThemeSkin = function ( selector ) {
        themeAdmin.$body.on( 'click', selector, function ( e ) {
            e.preventDefault();
            themeAdmin.$body.toggleClass( 'dark-version' );
            themeAdmin.$body.toggleClass( 'light-version' );

            var $logo = $( '.alpha-admin-logo img' ),
                $coming_soon = $( '.coming-soon img' );
            if ( themeAdmin.$body.hasClass( 'dark-version' ) ) {
                $logo.attr( 'src', $logo.data( 'image-src' ) + 'logo-admin.png' );
                $coming_soon.attr( 'src', $coming_soon.data( 'dark-image-src' ) );
            } else {
                $logo.attr( 'src', $logo.data( 'image-src' ) + 'logo-admin-dark.png' );
                $coming_soon.attr( 'src', $coming_soon.data( 'image-src' ) );
            }
        } )
    }

    /**
     * initChangeLogNavigation
     * 
     * @since 1.0
     */
    themeAdmin.initChangeLogNavigation = function ( selector ) {
        var $wrapper = $( selector ).closest( '.alpha-changelog-section' ),
            $logs = $wrapper.find( '.alpha-changelogs' );
        themeAdmin.$body.on( 'click', selector, function ( e ) {
            var $this = $( this ),
                id = $this.attr( 'href' ),
                $log = $logs.find( id );
            if ( $logs.length > 0 ) {
                $logs[ 0 ].scrollTo( {
                    top: $log[ 0 ].offsetTop,
                    left: 0,
                    behavior: 'smooth'
                } );
            }
            $this.parent().addClass( 'active' ).siblings().removeClass( 'active' );
            e.preventDefault();
        } );
        $logs.on( 'scroll', function ( e ) {
            var $this = $( this ),
                pos = this.scrollTop,
                height = this.clientHeight;
            $this.find( '.alpha-changelog' ).each( function ( index ) {
                var $item = $( this ),
                    itemPos = this.offsetTop;

                if ( pos <= itemPos && itemPos <= pos + height / 2 ) {
                    $wrapper.find( '[href="#' + $item.attr( 'id' ) + '"]' ).parent().addClass( 'active' ).siblings().removeClass( 'active' );
                    return;
                }
            } );
        } );
    }

    /**
     * Notification
     * 
     * @since 1.0
     */
    themeAdmin.notification = ( function () {

        /**
         * getNotifications
         * 
         * @since 1.0
         */
        var getNotifications = function ( $wrapper ) {
            let notifications = themeAdmin.getCookie( 'alpha_notifications' )
            if ( notifications ) {
                notifications = JSON.parse( notifications )
                notifications.forEach( function ( item ) {
                    let html = '<div class="alpha-notification notification-' + item.type + '">' +
                        '<label>' + item.content + '</label>' +
                        '<span>' + item.meta + '</span>' +
                        '</div>';
                    $wrapper.append( $( html ) );
                } );
                $wrapper.closest( '.alpha-notifications-dropdown' ).find( '.alpha-notification-toggle span' ).html( notifications.length );
            } else {
                $wrapper.addClass( 'loading' );
                $.ajax( {
                    type: "GET",
                    url: alpha_admin_vars.dummy_url + '?method=notification_list',
                } ).done( function ( response ) {
                    $wrapper.removeClass( 'loading' );
                    try {
                        response = JSON.parse( response );
                        if ( response ) {
                            response.forEach( function ( item ) {
                                let html = '<div class="alpha-notification notification-' + item.type + '">' +
                                    '<label>' + item.content + '</label>' +
                                    '<span>' + item.meta + '</span>' +
                                    '</div>';
                                $wrapper.append( $( html ) );
                            } );
                            themeAdmin.setCookie( 'alpha_notifications', JSON.stringify( response ), 1 );
                            $wrapper.closest( '.alpha-notifications-dropdown' ).find( '.alpha-notification-toggle span' ).html( response.length );
                        }
                    } catch ( e ) {
                        console.warn( e );
                    }
                } );
            }
        }
        /**
         * initToggle
         * 
         * Init notification toggler for notifications panel.
         * 
         * @param {string} selector 
         * @since 1.0
         */
        var initToggle = function ( selector ) {
            themeAdmin.$body.on( 'click', selector, function ( e ) {
                let $this = $( this ),
                    $notifications = $this.next(),
                    $notifications_list = $notifications.find( '.alpha-notifications' );

                $notifications.toggleClass( 'show' );

                if ( $notifications.hasClass( 'show' ) && 0 == $notifications_list.children().length ) {
                }
                e.preventDefault();
            } );
        };
        return {
            init: function () {
            }
        }
    } )();

    /**
     * Ajax Activation
     * 
     * @since 1.0
     */
    themeAdmin.initActivation = function () {
        // Dropdown Hide
        themeAdmin.$body.on( 'click', '.alpha-admin-panel', function ( e ) {
            if ( !$.contains( document.querySelector( '.alpha-active-content' ), e.target ) ) {
                $( '.alpha-active-dropdown' ).removeClass( 'show' );
            }
        } );

        themeAdmin.$body.on( 'submit', '#alpha_registration', function ( e ) {
            e.preventDefault();
            var $form = $( this ),
                $wrapper = $form.parent(),
                $toggleBtn = $( '.alpha-active-toggle' ),
                data = {
                    action: 'alpha_activation',
                    code: $form.find( '#alpha_purchase_code' ).val(),
                    form_action: $form.find( '[name="action"]' ).val(),
                    _wp_http_referer: $form.find( '[name="_wp_http_referer"]' ).val(),
                    _wpnonce: $form.find( '[name="_wpnonce"]' ).val(),
                    alpha_registration: true,
                    nonce: alpha_admin_vars.nonce,
                };
            $wrapper.addClass( 'loading' );
            $.ajax( {
                type: "POST",
                url: alpha_admin_vars.ajax_url,
                data: data
            } ).done( function ( response ) {
                var $activeAction = $( response ).find( '#alpha_active_action' );
                $wrapper.removeClass( 'loading' );
                $wrapper.html( response );
                $toggleBtn.toggleClass( 'activated', $activeAction.val() === 'unregister' );
                $toggleBtn.html( $activeAction.data( 'toggle-html' ) );
            } );
        } ).on( 'click', '.alpha-active-toggle', function ( e ) {
            e.preventDefault();
            $( '#alpha_active_wrapper' ).slideToggle();
        } ).on( 'click', '.alpha-toggle-howto', function () {
            $( '.alpha-active-howto' ).slideToggle();
        } );
    };

    /**
     * initReadingProgressBar
     * 
     * Init reading progress bar for admin page.
     * 
     * @since 1.0
     */
    themeAdmin.initReadingProgressBar = function ( selector ) {
        var $progressBar = $( selector ),
            $wpbody = $( '#wpbody' );
        var handleScrollProgress = function () {
            var scrollPos = Number( window.scrollY ) / Number( $wpbody.outerHeight() - window.innerHeight );
            $progressBar.css( 'width', ( scrollPos < 1 ? scrollPos : 1 ) * 100 + '%' );
            $progressBar.css( 'transition', 'width .3s' );
        }
        handleScrollProgress();
        $( window ).on( 'scroll', () => {
            handleScrollProgress();
        } );
    }

    /**
     * initSlider
     * 
     * Init Swiper Slider
     * 
     * @sinde 1.0
     */
    themeAdmin.initSlider = function ( selector, options ) {
        if ( 'undefined' != window.Swiper ) {
            $( selector ).each( function () {
                let $this = $( this );
                $this.children().addClass( 'swiper-slide' );
                let
                    slider = new Swiper( $this.parent()[ 0 ], options );

                $this.trigger( 'initialize.slider', [ slider ] );
                $this.data( 'slider', slider );
            } );
        }
    }

    themeAdmin.tab = function () {

        themeAdmin.$body
            // tab nav link
            .on( 'click', '.nav-tabs .nav-link', function ( e ) {
                var $link = $( this );

                // if tab is loading, return
                if ( $link.closest( '.nav-tabs' ).hasClass( 'loading' ) ) {
                    return;
                }

                // get href
                var href = 'SPAN' == this.tagName ? $link.data( 'href' ) : $link.attr( 'href' );

                // get panel
                var $panel;
                if ( '#' == href ) {
                    $panel = $link.closest( '.nav' ).siblings( '.tab-content' ).children( '.tab-pane' ).eq( $link.parent().index() );
                } else {
                    $panel = $( ( '#' == href.substring( 0, 1 ) ? '' : '#' ) + href );
                }
                if ( !$panel.length ) {
                    return;
                }

                e.preventDefault();

                var $activePanel = $panel.parent().children( '.active' );


                if ( $link.hasClass( "active" ) || !href ) {
                    return;
                }
                // change active link
                $link.parent().parent().find( '.active' ).removeClass( 'active' );
                $link.addClass( 'active' );

                // change tab instantly
                _changeTab();

                // Change tab panel
                function _changeTab () {
                    $activePanel.removeClass( 'in active' );
                    $panel.addClass( 'active in' );
                }
            } )
    }

    themeAdmin.init = function () {
        themeAdmin.notification.init();                                     // Notification
        themeAdmin.initReadingProgressBar( '.alpha-rp-bar' );               // Reading Progress Bar
        themeAdmin.initActivation();
        themeAdmin.initSlider( '.alpha-demos', {                           // Demos Slider
            slidesPerView: 2,
            spaceBetween: 20,
            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                992: {
                    slidesPerView: 4
                },
                1200: {
                    slidesPerView: 5
                }
            }
        } );
        themeAdmin.initSlider( '.alpha-products', {                           // Products Slider
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                576: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                }
            }
        } );
        themeAdmin.tab();
        themeAdmin.initThemeSkin( '.skin-toggle' );
        themeAdmin.initChangeLogNavigation( '.alpha-log-version > a' );
    }

    $( window ).on( 'load', function () {
        if ( $( 'body.alpha-admin-page' ).length > 0 ) {
            themeAdmin.init();
        }
        if ( $( '.alpha-admin-preloader' ).length > 0 ) {
            $( '.alpha-admin-preloader' ).remove();
        }
    } )
} )( wp, jQuery );