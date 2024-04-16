<?php
/**
 * Alpha WooCommerce Sticky Info Single Product Functions
 *
 * Functions used to display sticky info single product type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

add_action( 'woocommerce_before_single_product_summary', 'alpha_sp_sticky_info_wrap_sticky_info_start', 40 );
add_action( 'alpha_after_product_summary_wrap', 'alpha_sp_sticky_info_wrap_sticky_info_end', 15 );

/**
 * alpha_sp_sticky_info_wrap_sticky_info_start
 *
 * Render start part of sticky info single product summary wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_info_wrap_sticky_info_start' ) ) {
	function alpha_sp_sticky_info_wrap_sticky_info_start() {
		if ( 'sticky-info' == alpha_get_single_product_layout() ) {
			wp_enqueue_script( 'alpha-sticky-lib' );
			echo '<div class="sticky-sidebar" data-sticky-options="{\'minWidth\': 767}">';
		}
	}
}

/**
 * alpha_sp_sticky_info_wrap_sticky_info_end
 *
 * Render end part of sticky info single product summary wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_info_wrap_sticky_info_end' ) ) {
	function alpha_sp_sticky_info_wrap_sticky_info_end() {
		if ( 'sticky-info' == alpha_get_single_product_layout() ) {
			echo '</div>';
		}
	}
}
