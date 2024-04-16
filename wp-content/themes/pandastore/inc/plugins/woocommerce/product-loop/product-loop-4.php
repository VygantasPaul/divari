<?php
/**
 * The configuration for product type 4
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'alpha_before_shop_loop_start', 'alpha_product_4_before_shop_loop_start' );
add_action( 'alpha_after_shop_loop_end', 'alpha_product_4_after_shop_loop_end' );

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_4_before_shop_loop_start' ) ) {
	function alpha_product_4_before_shop_loop_start() {
		$product_type = wc_get_loop_prop( 'product_type' );
		if ( 'product-4' == $product_type ) {
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
			$addtocart_pos = '';
			$quickview_pos = '';
			$wishlist_pos  = '';
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
if ( ! function_exists( 'alpha_product_4_after_shop_loop_end' ) ) {
	function alpha_product_4_after_shop_loop_end() {
		$product_type = wc_get_loop_prop( 'product_type' );
		if ( 'product-4' == $product_type ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
		}
	}
}
