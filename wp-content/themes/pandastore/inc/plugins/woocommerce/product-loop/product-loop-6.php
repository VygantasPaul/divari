<?php
/**
 * The configuration for product type 6
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'woocommerce_before_shop_loop_item_title', 'alpha_product_6_loop_vertical_action', 20 ); // Vertical action
add_action( 'woocommerce_after_shop_loop_item_title', 'alpha_product_6_loop_action', 30 );
add_action( 'alpha_product_loop_hide_details', 'alpha_product_6_loop_action' );
add_action( 'alpha_before_shop_loop_start', 'alpha_product_6_before_shop_loop_start' );

/**
 * The vertical action: e.g: wishlist, add to cart, quickview
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_6_loop_vertical_action' ) ) {
	function alpha_product_6_loop_vertical_action() {
		// if product type is not default, do not print vertical action buttons.
		global $product;
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-6' == $product_type ) {
			$html      = '';
			$show_info = alpha_wc_get_loop_prop( 'show_info', false );

			if ( alpha_get_option( 'compare_available' ) && ( ! isset( $show_info ) || ! is_array( $show_info ) || in_array( 'compare', $show_info ) ) ) {
				ob_start();
				alpha_product_compare( ' btn-product-icon' );
				$html .= ob_get_clean();
			}

			if ( $html ) {
				echo '<div class="product-action-vertical">' . alpha_escaped( $html ) . '</div>';
			}
		}
	}
}

/**
 * The summary ( loop action )
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_6_loop_action' ) ) {
	function alpha_product_6_loop_action( $details = '' ) {
		global $product;
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-6' == $product_type ) {
			if ( 'hide-details' !== $details && alpha_wc_get_loop_prop( 'is_popup' ) ) {
				return;
			}

			$content_align = alpha_wc_get_loop_prop( 'content_align' );
			$show_info     = alpha_wc_get_loop_prop( 'show_info', false );

			if ( defined( 'YITH_WCWL' ) && ( ! is_array( $show_info ) || in_array( 'wishlist', $show_info ) ) ) {
				$wishlist = do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
			} else {
				$wishlist = '';
			}

			if ( ( ! is_array( $show_info ) || in_array( 'quickview', $show_info ) ) &&
				'' == alpha_wc_get_loop_prop( 'quickview_pos' ) ) {
				$quickview = '<button class="btn-product-icon btn-quickview" data-mfp-src="' . alpha_get_product_featured_image_src( $product ) . '" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'pandastore' ) . '">' . esc_html__( 'Quick View', 'pandastore' ) . '</button>';
			} else {
				$quickview = '';
			}

			echo '<div class="product-action">';

			if ( 'center' == $content_align || ( ( ! is_rtl() && 'right' == $content_align ) || ( is_rtl() && 'left' == $content_align ) ) ) {
				echo alpha_escaped( $wishlist );
			}
			if ( ( ! is_rtl() && 'right' == $content_align ) || ( is_rtl() && 'left' == $content_align ) ) {
				echo alpha_escaped( $quickview );
			}
			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'btn-product',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							)
						)
					),
				)
			);

			if ( ( ! is_rtl() && 'left' == $content_align ) || ( is_rtl() && 'right' == $content_align ) ) {
				echo alpha_escaped( $wishlist );
			}
			if ( ( ! is_rtl() && 'right' !== $content_align ) || ( is_rtl() && 'left' !== $content_align ) ) {
				echo alpha_escaped( $quickview );
			}

			echo '</div>';
		}
	}
}

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_6_before_shop_loop_start' ) ) {
	function alpha_product_6_before_shop_loop_start() {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-6' == $product_type ) {
			$addtocart_pos = '';
			$quickview_pos = '';
			$wishlist_pos  = '';
			$content_align = 'center';
			alpha_wc_get_loop_prop( 'content_align' ) || wc_set_loop_prop( 'content_align', $content_align );
			wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
		}
	}
}
