/**
 * WP Alpha Theme Framework
 * Alpha Countdown
 * 
 * @package WP Alpha Theme Framework
 * @since 1.2.0
 */

window.theme = window.theme || {};

( function ( $ ) {

    /**
    * Start countdown
    * 
    * @since 1.0
    * @param {string} selector
    * @param {object} options
    * @return {void}
    */
    theme.countdown = function ( selector, options ) {
        if ( $.fn.countdown ) {
            theme.$( selector ).each( function () {
                var $this = $( this ),
                    untilDate = $this.attr( 'data-until' ),
                    compact = $this.attr( 'data-compact' ),
                    dateFormat = ( !$this.attr( 'data-format' ) ) ? 'DHMS' : $this.attr( 'data-format' ),
                    newLabels = ( !$this.attr( 'data-labels-short' ) ) ? alpha_vars.countdown.labels : alpha_vars.countdown.labels_short,
                    newLabels1 = ( !$this.attr( 'data-labels-short' ) ) ? alpha_vars.countdown.label1 : alpha_vars.countdown.label1_short;


                $this.data( 'countdown' ) && $this.countdown( 'destroy' );

                $this.countdown( $.extend(
                    $this.hasClass( 'user-tz' ) ?
                        {
                            until: ( !$this.attr( 'data-relative' ) ) ? new Date( untilDate ) : untilDate,
                            format: dateFormat,
                            padZeroes: true,
                            compact: compact,
                            compactLabels: [ ' y', ' m', ' w', ' days, ' ],
                            timeSeparator: ' : ',
                            labels: newLabels,
                            labels1: newLabels1,
                            serverSync: new Date( $( this ).attr( 'data-time-now' ) )
                        } : {
                            until: ( !$this.attr( 'data-relative' ) ) ? new Date( untilDate ) : untilDate,
                            format: dateFormat,
                            padZeroes: true,
                            compact: compact,
                            compactLabels: [ ' y', ' m', ' w', ' days, ' ],
                            timeSeparator: ' : ',
                            labels: newLabels,
                            labels1: newLabels1
                        },
                    options )
                );
            } );
        }
    }

    $( window ).on( 'alpha_complete', function () {
        theme.countdown( '.product-countdown, .countdown' );
    } );
} )( window.jQuery );