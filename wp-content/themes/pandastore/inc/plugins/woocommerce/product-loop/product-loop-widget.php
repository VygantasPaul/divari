<?php
/**
 * The configuration for product widget
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'woocommerce_before_shop_loop_item_title', 'alpha_product_widget_before_loop_action', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'alpha_product_widget_after_loop_action' );
add_action( 'alpha_before_shop_loop_start', 'alpha_product_widget_before_shop_loop_start' );
add_action( 'alpha_after_shop_loop_end', 'alpha_product_widget_after_shop_loop_end' );

/**
 * The vertical action
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_widget_before_loop_action' ) ) {
	function alpha_product_widget_before_loop_action() {
		// if product type is not default, do not print vertical action buttons.
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'widget' == $product_type ) {
			if ( alpha_wc_get_loop_prop( 'is_sidebar_widget' ) ) {
				add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
			}
			return;
		}
	}
}

/**
 * After product loop item
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_widget_after_loop_action' ) ) {
	function alpha_product_widget_after_loop_action() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'widget' == $product_type ) {
			if ( alpha_wc_get_loop_prop( 'is_sidebar_widget' ) ) {
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
			}
			return;
		}
	}
}

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_widget_before_shop_loop_start' ) ) {
	function alpha_product_widget_before_shop_loop_start() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'widget' == $product_type ) {
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
if ( ! function_exists( 'alpha_product_widget_after_shop_loop_end' ) ) {
	function alpha_product_widget_after_shop_loop_end() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'widget' == $product_type ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 50 );
		}
	}
}
