/**
 * Alpha Flipbox Library
 * 
 * @package Alpha Core Framework
 * @sinec 1.0.0
 */

'use strict';

( function ( $ ) {
    theme.initFlipbox = function ( selector ) {

        if ( theme.$( selector ).length ) {
            theme.$( selector ).each( function () {
                var $this = $( this );

                hoverFliped( $this );
            } );
        }

        function hoverFliped( $obj ) {
            var isFirst = true,
                scrollOffset = $( window ).scrollTop();

            if ( 'ontouchend' in window || 'ontouchstart' in window ) {
                $obj.on( 'touchstart', function ( event ) {
                    scrollOffset = $( window ).scrollTop();
                } );

                $obj.on( 'touchend', function ( event ) {
                    if ( scrollOffset !== $( window ).scrollTop() ) {
                        return false;
                    }
                    var $this = $( this );
                    setTimeout( function () {
                        $this.toggleClass( 'flipped' );
                    }, 10 );
                } );

                $( document ).on( 'touchend', function ( event ) {
                    if ( $( event.target ).closest( $obj ).length ) {
                        return;
                    }
                    if ( !$obj.hasClass( 'flipped' ) ) {
                        return;
                    }
                    $obj.removeClass( 'flipped' );
                } );
            } else {

                $obj.on( 'mouseenter mouseleave', function ( event ) {
                    if ( isFirst && 'mouseleave' === event.type ) {
                        return;
                    }

                    if ( isFirst && 'mouseenter' === event.type ) {
                        isFirst = false;
                    }
                    $( this ).toggleClass( 'flipped' );
                } );
            }
        }
    };

    $( window ).on( 'alpha_complete', function () {
        theme.initFlipbox( '.flipbox' );
    } )
} )( jQuery );