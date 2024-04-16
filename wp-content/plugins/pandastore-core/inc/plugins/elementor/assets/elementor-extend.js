/**
 * Alpha Elementor Preview
 *
 * @author     D-THEMES
 * @package    Panda
 * @subpackage Core
 * @since      1.0
 *
 */
'use strict';
window.themeAdmin = window.themeAdmin || {};
( function ( $ ) {
	themeAdmin.themeElementorPreview = themeAdmin.themeElementorPreview || {};

	function productDataSticky() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/' + alpha_vars.theme + '_sproduct_data_tab.default', function ( $obj ) {
			theme.stickyContent( $obj.find( '.sticky-content' ) );
		} );
	}

	/**
     * Setup AlphaElementorPreview
     */
	$( window ).on( 'load', function () {
		if ( typeof elementorFrontend != 'undefined' && typeof theme != 'undefined' ) {
			if ( elementorFrontend.hooks ) {
				productDataSticky();
			} else {
				elementorFrontend.on( 'components:init', function () {
					productDataSticky();
				} );
			}
		}
	} )
} )( jQuery );