/**
 * Alpha Addon - GDPR
 *
 * @author     D-THEMES
 * @package    WP Alpha FrameWork
 * @subpackage Theme
 * @since      1.0
 */
'use strict';

( function ( $ ) {

	/**
	 * Initialize cookie law popup
	 * 
	 * @since 1.0
	 * 
	 * @return {void}
	 */
    theme.initCookiePopup = function () {
        var cookie_version = alpha_vars.cookie_version;

        if ( 'accepted' === theme.getCookie( 'alpha_cookies_' + cookie_version ) ) {
            return;
        }

        var $el = $( '.cookies-popup' );

        setTimeout( function () {
            $el.addClass( 'show' );

            theme.$body.on( 'click', '.accept-cookie-btn', function ( e ) {
                e.preventDefault();
                $el.removeClass( 'show' );
                theme.setCookie( 'alpha_cookies_' + cookie_version, 'accepted', 60 );
            } );

            theme.$body.on( 'click', '.decline-cookie-btn', function ( e ) {
                e.preventDefault();
                $el.removeClass( 'show' );
            } )
        }, 2500 );
    }

    $( window ).on( 'alpha_complete', theme.initCookiePopup )
} )( jQuery );