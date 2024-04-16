<?php
/**
 * The configuration for product type 8
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'woocommerce_before_shop_loop_item_title', 'alpha_product_8_loop_vertical_action', 20 ); // Vertical action
add_action( 'alpha_before_shop_loop_start', 'alpha_product_8_before_shop_loop_start' );

/**
 * The vertical action
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_8_loop_vertical_action' ) ) {
	function alpha_product_8_loop_vertical_action() {
		// if product type is not default, do not print vertical action buttons.
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-8' == $product_type ) {
			return;
		}
	}
}

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_8_before_shop_loop_start' ) ) {
	function alpha_product_8_before_shop_loop_start() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-8' == $product_type ) {
			$addtocart_pos = 'bottom';
			$quickview_pos = 'bottom';
			$wishlist_pos  = '';
			$content_align = 'center';
			alpha_wc_get_loop_prop( 'content_align' ) || wc_set_loop_prop( 'content_align', $content_align );
			wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
		}
	}
}
