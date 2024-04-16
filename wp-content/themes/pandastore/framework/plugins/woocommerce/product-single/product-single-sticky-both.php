<?php
/**
 * Alpha WooCommerce Sticky Both Single Product Functions
 *
 * Functions used to display sticky both single product type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

add_action( 'alpha_before_product_summary', 'alpha_wc_show_product_images_sticky_both', 5 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_sticky_both_wrap_special_start', 2 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_sticky_both_wrap_special_end', 22 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_sticky_both_wrap_special_start', 22 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_sticky_both_wrap_special_end', 70 );

add_filter( 'woocommerce_single_product_image_gallery_classes', 'alpha_sp_sticky_both_wc_gallery_classes' );
add_filter( 'alpha_single_product_summary_class', 'alpha_sp_sticky_both_summary_extend_class' );

/**
 * wc_show_product_images_sticky_both
 *
 * Show sticky both single product images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_show_product_images_sticky_both' ) ) {
	function alpha_wc_show_product_images_sticky_both() {
		if ( 'sticky-both' == alpha_get_single_product_layout() ) {
			woocommerce_show_product_images();
		}
	}
}

/**
 * single_product_sticky_both_class
 *
 * Return sticky both single product classes
 *
 * @param array $classes
 * @return array
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_sticky_both_class' ) ) {
	function alpha_single_product_sticky_both_class( $classes ) {
		$classes[] = 'sticky-both';
		return $classes;
	}
}

/**
 * sp_sticky_both_wrap_special_start
 *
 * Render start part of sticky both single product wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_both_wrap_special_start' ) ) {
	function alpha_sp_sticky_both_wrap_special_start() {
		if ( 'sticky-both' == alpha_get_single_product_layout() ) {
			$wrap_class = 'col-md-6 col-lg-3';
			echo '<div class="' . esc_attr( $wrap_class ) . '">';

			wp_enqueue_script( 'alpha-sticky-lib' );

			echo '<div class="sticky-sidebar">';
		}
	}
}

/**
 * sp_sticky_both_wrap_special_end
 *
 * Render end part of sticky both single product wrapper
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_both_wrap_special_end' ) ) {
	function alpha_sp_sticky_both_wrap_special_end() {
		if ( 'sticky-both' == alpha_get_single_product_layout() ) {
			echo '</div></div>';
		}
	}
}

/**
 * sp_sticky_both_wc_gallery_classes
 *
 * Return sticky both gallery classes
 *
 * @param array $classes
 * @return array
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_both_wc_gallery_classes' ) ) {
	function alpha_sp_sticky_both_wc_gallery_classes( $classes ) {
		if ( 'sticky-both' == alpha_get_single_product_layout() ) {
			$classes[] = 'col-lg-6';
		}
		return $classes;
	}
}

/**
 * sp_sticky_both_summary_extend_class
 *
 * Return sticky both single product summary class
 *
 * @param string class
 * @return string
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_both_summary_extend_class' ) ) {
	function alpha_sp_sticky_both_summary_extend_class( $class ) {
		if ( 'sticky-both' == alpha_get_single_product_layout() ) {
			$class .= ' row';
		}
		return $class;
	}
}
