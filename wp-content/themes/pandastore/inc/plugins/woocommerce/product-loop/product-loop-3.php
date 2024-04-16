<?php
/**
 * The configuration for product type 3
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'alpha_before_shop_loop_start', 'alpha_product_3_before_shop_loop_start' );
add_action( 'alpha_after_shop_loop_end', 'alpha_product_3_after_shop_loop_end' );

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_3_before_shop_loop_start' ) ) {
	function alpha_product_3_before_shop_loop_start() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-3' == $product_type ) {
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
			$addtocart_pos = 'with_qty';
			$quickview_pos = 'bottom';
			$wishlist_pos  = 'bottom';
			$content_align = 'center';
			alpha_wc_get_loop_prop( 'content_align' ) || wc_set_loop_prop( 'content_align', $content_align );
			wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
		}
	}
}

/**
 * Restore initial actions
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_3_after_shop_loop_end' ) ) {
	function alpha_product_3_after_shop_loop_end() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-3' == $product_type ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
		}
	}
}
