/**
 * Selective Refresh Extend for Customize
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

    function eventsInit () {
        var style = $( 'html' )[ 0 ].style;

        $( document.body ).on( 'dim_color', function () {
            style.setProperty( '--alpha-dim-color', getCustomize( 'dim_color' ) );
        } );
    }

    eventsInit();

    wp.customize( 'dim_color', function ( e ) {
        e.bind( function ( value ) {
            $( document.body ).trigger( 'dim_color' );
        } );
    } );
} )