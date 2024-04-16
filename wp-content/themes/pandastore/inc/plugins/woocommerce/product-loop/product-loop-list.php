<?php
/**
 * The configuration for product type list
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'alpha_before_shop_loop_start', 'alpha_product_list_before_shop_loop_start' );
// Display short description
add_action( 'woocommerce_after_shop_loop_item_title', 'alpha_product_list_loop_description', 25 );
// Display product actions
add_action( 'woocommerce_after_shop_loop_item_title', 'alpha_product_list_loop_action', 30 );
add_action( 'alpha_after_shop_loop_end', 'alpha_product_list_after_shop_loop_end' );

/**
 * Before loop start
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_list_before_shop_loop_start' ) ) {
	function alpha_product_list_before_shop_loop_start() {
		$product_type = wc_get_loop_prop( 'product_type' );
		if ( 'list' == $product_type ) {
			// Modify rating position
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 20 );
			$addtocart_pos = 'with_qty';
			$quickview_pos = '';
			$wishlist_pos  = '';
			$content_align = 'left';
			wc_set_loop_prop( 'content_align', $content_align );
			wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
		}
	}
}

/**
 * Display short description
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_list_loop_description' ) ) {
	function alpha_product_list_loop_description() {
		$show_info = wc_get_loop_prop( 'show_info', false );
		if ( 'list' == wc_get_loop_prop( 'product_type' ) ) {
			global $product;

			$excerpt_type   = alpha_get_option( 'prod_excerpt_type' );
			$excerpt_length = alpha_get_option( 'prod_excerpt_length' );
			echo '<div class="short-desc">' . alpha_trim_description( $product->get_short_description(), $excerpt_length, $excerpt_type ) . '</div>';
		}
	}
}

/**
 *The product list loop action
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_list_loop_action' ) ) {
	function alpha_product_list_loop_action() {
		global $product;
		$product_type = wc_get_loop_prop( 'product_type' );
		if ( 'list' == $product_type ) {
			$content_align = wc_get_loop_prop( 'content_align' );
			$show_info     = wc_get_loop_prop( 'show_info', false );

			if ( defined( 'YITH_WCWL' ) && ( ! is_array( $show_info ) || in_array( 'wishlist', $show_info ) ) ) {
				$wishlist = do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
			} else {
				$wishlist = '';
			}

			if ( ( ! is_array( $show_info ) || in_array( 'quickview', $show_info ) ) &&
			'' == wc_get_loop_prop( 'quickview_pos' ) ) {
				$quickview = '<button class="btn-product-icon btn-quickview" data-mfp-src="' . alpha_get_product_featured_image_src( $product ) . '" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'pandastore' ) . '">' . esc_html__( 'Quick View', 'pandastore' ) . '</button>';
			}

			if ( alpha_get_option( 'compare_available' ) && ( ! is_array( $show_info ) || in_array( 'compare', $show_info ) ) ) {
				ob_start();
				alpha_product_compare( ' btn-product-icon' );
				$compare = ob_get_clean();
			} else {
				$compare = '';
			}

			echo '<div class="product-action">';

			if ( 'simple' == $product->get_type() ) {
				woocommerce_quantity_input(
					array(
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
						'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( sanitize_text_field( wp_unslash( $_POST['quantity'] ) ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
					)
				);
			}

			if ( 'center' == $content_align || ( ( ! is_rtl() && 'right' == $content_align ) || ( is_rtl() && 'left' == $content_align ) ) ) {
				echo alpha_escaped( $wishlist );
			}
			if ( ( ! is_rtl() && 'right' == $content_align ) || ( is_rtl() && 'left' == $content_align ) ) {
				echo alpha_escaped( $quickview );
			}
			if ( ( ! is_rtl() && 'right' == $content_align ) || ( is_rtl() && 'left' == $content_align ) ) {
				echo alpha_escaped( $compare );
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
			if ( ( ! is_rtl() && 'right' !== $content_align ) || ( is_rtl() && 'left' !== $content_align ) ) {
				echo alpha_escaped( $compare );
			}

			echo '</div>';
		}
	}
}

/**
 * Restore initial actions
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_list_after_shop_loop_end' ) ) {
	function alpha_product_list_after_shop_loop_end() {
		$product_type = wc_get_loop_prop( 'product_type' );
		if ( 'list' == $product_type ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 20 );
		}
	}
}
