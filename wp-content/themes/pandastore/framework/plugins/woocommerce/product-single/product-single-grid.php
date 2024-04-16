<?php
/**
 * Alpha WooCommerce Grid Single Product Functions
 *
 * Functions used to display grid single product type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */
add_action( 'woocommerce_before_single_product_summary', 'alpha_sp_grid_wrap_start', 40 );
add_action( 'alpha_after_product_summary_wrap', 'alpha_sp_grid_wrap_end', 15 );

/**
 * sp_grid_wrap_start
 *
 * Render start part of grid single product wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_grid_wrap_start' ) ) {
	function alpha_sp_grid_wrap_start() {
		if ( 'grid' == alpha_get_single_product_layout() ) {
			wp_enqueue_script( 'alpha-sticky-lib' );
			echo '<div class="sticky-sidebar" data-sticky-options="{\'minWidth\': 767}">';
		}
	}
}

/**
 * sp_grid_wrap_end
 *
 * Render end part of grid single product wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_grid_wrap_end' ) ) {
	function alpha_sp_grid_wrap_end() {
		if ( 'grid' == alpha_get_single_product_layout() ) {
			echo '</div>';
		}
	}
}
