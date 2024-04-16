<?php
/**
 * Alpha WooCommerce Sticky Thumbs Single Product Functions
 *
 * Functions used to display sticky thumbs single product type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

// Single Product - sticky-info type
add_action( 'woocommerce_before_single_product_summary', 'alpha_sp_sticky_thumbs_wrap_sticky_info_start', 40 );
add_action( 'alpha_after_product_summary_wrap', 'alpha_sp_sticky_thumbs_wrap_sticky_info_end', 15 );

add_action( 'alpha_woocommerce_product_images', 'alpha_sp_sticky_thumbs_images' );
add_action( 'woocommerce_product_thumbnails', 'alpha_wc_show_sp_sticky_thumbs_thumbnails', 20 );

/**
 * sp_sticky_thumbs_wrap_sticky_info_start
 *
 * Render start part of sticky thumbs single product summary wrapper.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_thumbs_wrap_sticky_info_start' ) ) {
	function alpha_sp_sticky_thumbs_wrap_sticky_info_start() {
		if ( 'sticky-thumbs' == alpha_get_single_product_layout() ) {
			wp_enqueue_script( 'alpha-sticky-lib' );
			echo '<div class="sticky-sidebar" data-sticky-options="{\'minWidth\': 767}">';
		}
	}
}
/**
 * sp_sticky_thumbs_wrap_sticky_info_end
 *
 * Render end part of sticky thumbs single product summary wrapper.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_thumbs_wrap_sticky_info_end' ) ) {
	function alpha_sp_sticky_thumbs_wrap_sticky_info_end() {
		if ( 'sticky-thumbs' == alpha_get_single_product_layout() ) {
			echo '</div>';
		}
	}
}

/**
 * sp_sticky_thumbs_images
 *
 * Render sticky thumbs single product images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_sp_sticky_thumbs_images' ) ) {
	function alpha_sp_sticky_thumbs_images() {
		if ( 'sticky-thumbs' == alpha_get_single_product_layout() ) {
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
			$html = '<div class="product-sticky-images">' . $html . '</div>';
			echo alpha_escaped( $html );
		}
	}
}


/**
 * wc_show_sp_sticky_thumbs_thumbnails
 *
 * Render single product sticky thumbnails.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_show_sp_sticky_thumbs_thumbnails' ) ) {
	function alpha_wc_show_sp_sticky_thumbs_thumbnails() {
		if ( 'sticky-thumbs' == alpha_get_single_product_layout() ) {
			wp_enqueue_script( 'alpha-sticky-lib' );
			?>
			<div class="product-sticky-thumbs">
				<div class="product-sticky-thumbs-inner sticky-sidebar" data-sticky-options="{'minWidth': 319}">
					<?php woocommerce_show_product_thumbnails(); ?>
				</div>
			</div>
			<?php
		}
	}
}
