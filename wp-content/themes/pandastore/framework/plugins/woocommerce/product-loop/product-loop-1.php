<?php
/**
 * The configuration for product type 1
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

// Before Loop Start
add_action( 'alpha_before_shop_loop_start', 'alpha_product_1_before_shop_loop_start' );

/**
 * Before loop start.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_1_before_shop_loop_start' ) ) {
	function alpha_product_1_before_shop_loop_start() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-1' == $product_type ) {
			$addtocart_pos = '';
			$quickview_pos = 'bottom';
			$wishlist_pos  = '';
			wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
		}
	}
}
