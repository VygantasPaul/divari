<?php
/**
 * Alpha WooCommerce Gallery Single Product Functions
 *
 * Functions used to display Gallery single product type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

// Single Product - the other types except gallery and sticky-both types
add_action( 'woocommerce_single_product_summary', 'alpha_sp_gallery_wrap_special_start', 2 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_gallery_wrap_special_end', 22 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_gallery_wrap_special_start', 22 );
add_action( 'woocommerce_single_product_summary', 'alpha_sp_gallery_wrap_special_end', 70 );

add_action( 'alpha_woocommerce_product_images', 'alpha_sp_gallery_images' );
add_filter( 'alpha_single_product_summary_class', 'alpha_sp_gallery_summary_extend_class' );

/**
 * sp_gallery_wrap_special_start
 *
 * Render start part of single product gallery wrapper.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_gallery_wrap_special_start' ) ) {
	function alpha_sp_gallery_wrap_special_start() {
		if ( 'gallery' == alpha_get_single_product_layout() ) {
			$wrap_class = 'col-md-6';
			echo '<div class="' . esc_attr( $wrap_class ) . '">';
		}
	}
}

/**
 * sp_gallery_wrap_special_end
 *
 * Render end part of single product gallery wrapper.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_gallery_wrap_special_end' ) ) {
	function alpha_sp_gallery_wrap_special_end() {
		if ( 'gallery' == alpha_get_single_product_layout() ) {
			echo '</div>';
		}
	}
}

/**
 * sp_gallery_images
 *
 * Render single product gallery images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_gallery_images' ) ) {
	function alpha_sp_gallery_images() {
		if ( 'gallery' == alpha_get_single_product_layout() ) {
			global $product;
			global $alpha_layout;

			$post_thumbnail_id = $product->get_image_id();
			$attachment_ids    = $product->get_gallery_image_ids();

			if ( $post_thumbnail_id ) {
				$html = apply_filters( 'woocommerce_single_product_image_thumbnail_html', alpha_wc_get_gallery_image_html( $post_thumbnail_id, true, true ), $post_thumbnail_id );
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image">', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'pandastore' ) );
				$html .= '</div>';
			}

			if ( $attachment_ids && $post_thumbnail_id ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$html .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', alpha_wc_get_gallery_image_html( $attachment_id, true ), $attachment_id );
				}
			}
				$html = '<div class="product-gallery-carousel slider-wrapper' .
					apply_filters(
						'alpha_single_product_gallery_type_class',
						(
							! empty( $alpha_layout['left_sidebar'] ) && 'hide' != $alpha_layout['left_sidebar'] &&
							( empty( $alpha_layout['left_sidebar_type'] ) || 'offcanvas' != $alpha_layout['left_sidebar_type'] )
							||
							! empty( $alpha_layout['right_sidebar'] ) && 'hide' != $alpha_layout['right_sidebar'] &&
							( empty( $alpha_layout['right_sidebar_type'] ) || 'offcanvas' != $alpha_layout['right_sidebar_type'] )
							?
							' row cols-1 cols-md-2' : ' row cols-1 cols-md-2 cols-lg-3'
						)
					)
					. '" data-slider-status="slider-same-height slider-nav-inner slider-nav-fade"' . apply_filters( 'alpha_single_product_gallery_type_attr', '' ) . '>' . $html . '</div>';
			echo alpha_escaped( $html );
		}
	}
}

/**
 * sp_gallery_summary_extend_class
 *
 * Render single product gallery images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_gallery_summary_extend_class' ) ) {
	function alpha_sp_gallery_summary_extend_class( $class ) {
		if ( 'gallery' == alpha_get_single_product_layout() ) {
			$class .= ' row';
		}
		return $class;
	}
}
