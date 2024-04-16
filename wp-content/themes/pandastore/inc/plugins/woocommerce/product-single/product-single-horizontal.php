<?php
/**
 * Alpha WooCommerce Horizontal Single Product Functions
 *
 * Functions used to display horizontal single product type.
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */


// Single Product Media
add_action( 'alpha_woocommerce_product_images', 'alpha_sp_horizontal_images' );
add_action( 'woocommerce_product_thumbnails', 'alpha_wc_show_sp_horizontal_thumbnails', 20 );
add_filter( 'woocommerce_gallery_image_size', 'alpha_wc_sp_horizontal_gallery_image_size' );

/**
 * sp_horizontal_images
 *
 * Render horizontal single product images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_horizontal_images' ) ) {
	function alpha_sp_horizontal_images() {
		if ( 'horizontal' == alpha_get_single_product_layout() ) {
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
			$html = '<div class="product-single-carousel-wrap slider-nav-fade"><div class="product-single-carousel slider-wrapper row cols-1 gutter-no">' . $html . '</div></div>';

			echo alpha_escaped( $html );
		}
	}
}

/**
 * wc_show_sp_horizontal_thumbnails
 *
 * Render horizontal single product thumbnails
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_show_sp_horizontal_thumbnails' ) ) {
	function alpha_wc_show_sp_horizontal_thumbnails() {
		if ( 'horizontal' == alpha_get_single_product_layout() ) {

			if ( alpha_doing_quickview() ) {
				return;
			}

			$slider_opts = array(
				'spaceBetween' => 20,
				'breakpoints'  => array(
					'576' => array(
						'spaceBetween' => 20,
					),
					'0'   => array(
						'spaceBetween' => 15,
					),
				),
			);

			$slider_opts = "data-slider-options='" . json_encode( $slider_opts ) . "'";

			echo alpha_escaped( '<div class="product-thumbs-wrap"><div class="product-thumbs slider-wrapper row gutter-no" ' . apply_filters( 'alpha_single_product_gallery_space_attr', $slider_opts ) . '>' );

			woocommerce_show_product_thumbnails();

			echo alpha_escaped( '</div></div>' );

		}
	}
}

/**
 * Woocommerce gallery image size
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_sp_horizontal_gallery_image_size' ) ) {
	function alpha_wc_sp_horizontal_gallery_image_size( $size ) {
		if ( 'horizontal' == alpha_get_single_product_layout() ) {
			$size = 'full';
		}
		return $size;
	}
}
