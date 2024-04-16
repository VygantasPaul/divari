/**
 * WP Alpha Theme Framework
 * Alpha Three-sixty: 360 degree
 *
 * @package WP Alpha Theme Framework
 * @since 1.2.0
 */

window.theme = window.theme || {};

( function ( $ ) {

    /**
     * 360 degree
     * 
     * @param selector
     * @param $obj
     * @since 1.0
     */
    theme.threeSixty = function ( selector, $obj ) {
        if ( $.fn.ThreeSixty ) {
            var $container = $obj && $obj.length ? $obj.find( selector ) : $( selector );
            $container.each( function () {
                var $this = $( this );
                var images = $this.find( '.alpha-360-gallery-wrap' ).data( 'srcs' ).split( ',' );
                $this.ThreeSixty( {
                    totalFrames: images.length,
                    endFrame: images.length,
                    currentFrame: images.length - 1,
                    imgList: $this.find( '.alpha-360-gallery-wrap' ),
                    progress: '.d-loading',
                    imgArray: images,
                    // speedMultiplier: 1,
                    // monitorInt: 1,
                    speed: 10,
                    height: $this.children( '.post-div' ).length ? '' : 500,
                    width: $this.outerWidth(),
                    navigation: true
                } );
            } );
        }
    }

    $( window ).on( 'alpha_complete', function () {
        theme.threeSixty( '.alpha-360-gallery-wrapper' );    // 360 degree
    } );

} )( window.jQuery );