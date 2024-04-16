<?php
/**
 * Alpha WooCommerce Single Product Functions
 *
 * Functions used to display single product.
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

// Compatiblilty with elementor editor
if ( ! empty( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] && is_admin() ) {
	if ( class_exists( 'WC_Template_Loader' ) ) {
		add_filter( 'woocommerce_product_tabs', array( 'WC_Template_Loader', 'unsupported_theme_remove_review_tab' ) );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_sort_product_tabs', 99 );
	}
}

// Alpha Single Product Navigation
add_filter( 'alpha_breadcrumb_args', 'alpha_single_prev_next_product' );

// Single Product Class
add_filter( 'alpha_single_product_classes', 'alpha_single_product_extend_class' );

// Single Product - Label, Sale Countdown
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'alpha_before_wc_gallery_figure', 'woocommerce_show_product_sale_flash' );
add_action( 'woocommerce_available_variation', 'alpha_variation_add_sale_ends', 100, 3 );


// Single Product - the other types except gallery and sticky-both types
add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_end', 30 );
add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
add_action( 'alpha_after_product_summary_wrap', 'alpha_single_product_wrap_second_end', 20 );

// Single Product - sticky-both type
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'alpha_wc_show_product_images_not_sticky_both', 20 );

// Remove default rendering of wishlist button by YITH
if ( class_exists( 'YITH_WCWL' ) || class_exists( 'YITH_WCWL_Frontend' ) ) {
	add_filter( 'yith_wcwl_show_add_to_wishlist', '__return_false', 20 );
}

// Single Product Media
add_filter( 'alpha_wc_thumbnail_image_size', 'alpha_single_product_thumbnail_image_size' );
add_action( 'alpha_woocommerce_product_images', 'alpha_single_product_images' );
add_filter( 'alpha_single_product_gallery_main_classes', 'alpha_single_product_gallery_classes' );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

// Single Product Summary
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
add_filter( 'alpha_single_product_summary_class', 'alpha_single_product_summary_extend_class' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
add_action( 'woocommerce_single_product_summary', 'alpha_single_product_sale_countdown', 9 );
add_action( 'woocommerce_single_product_summary', 'alpha_single_product_links_wrap_start', 45 );
if ( class_exists( 'YITH_WCWL_Frontend' ) ) {
	add_action( 'woocommerce_single_product_summary', 'alpha_print_wishlist_button', 52 );
}
add_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 54 );
add_action( 'woocommerce_single_product_summary', 'alpha_single_product_links_wrap_end', 55 );

// Single Product Form
add_action( 'woocommerce_before_add_to_cart_quantity', 'alpha_single_product_sticky_cart_wrap_start', 15 );
add_action( 'woocommerce_after_add_to_cart_button', 'alpha_single_product_sticky_cart_wrap_end', 20 );

// Single Product Data Tab
add_filter( 'alpha_single_product_data_tab_type', 'alpha_single_product_get_data_tab_type' );
add_filter( 'woocommerce_product_tabs', 'alpha_wc_product_custom_tabs', 99 );

// Single Product Reviews Tab
add_action( 'woocommerce_review_before', 'alpha_wc_review_before_avatar', 5 );
add_action( 'woocommerce_review_before', 'alpha_wc_review_after_avatar', 15 );
remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );
add_action( 'woocommerce_review_meta', 'woocommerce_review_display_rating', 15 );

// Single Product - Related Products
add_action( 'woocommerce_output_related_products_args', 'alpha_related_products_args' );

// Single Product - Up-Sells Products
add_filter( 'woocommerce_upsell_display_args', 'alpha_upsells_products_args' );

// Woocommerce Comment Form
add_filter( 'woocommerce_product_review_comment_form_args', 'alpha_comment_form_args' );

/**
 * doing_quickview
 *
 * Check if doing ajax product quickview popup.
 *
 * @return bool
 * @since 1.0
 */
if ( ! function_exists( 'alpha_doing_quickview' ) ) {
	function alpha_doing_quickview() {
		return apply_filters( 'alpha_doing_quickview', alpha_doing_ajax() && isset( $_REQUEST['action'] ) && 'alpha_quickview' == $_REQUEST['action'] && isset( $_POST['product_id'] ) );
	}
}
// Quickview ajax actions & enqueue scripts for quickview
if ( alpha_doing_quickview() ) {
	add_action( 'wp_ajax_alpha_quickview', 'alpha_wc_quickview' );
	add_action( 'wp_ajax_nopriv_alpha_quickview', 'alpha_wc_quickview' );
} elseif ( 'disable' != alpha_get_option( 'quickview_thumbs' ) ) {
	add_action( 'wp_enqueue_scripts', 'alpha_quickview_add_scripts' );
}


/**
 * Alpha Single Product Class & Layout
 */

/**
 * single_product_extend_class
 *
 * Get single product extend classes.
 *
 * @param array $classes
 * @return array
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_extend_class' ) ) {
	function alpha_single_product_extend_class( $classes ) {
		$single_product_layout = alpha_get_single_product_layout();

		if ( 'gallery' != $single_product_layout ) {
			if ( 'sticky-both' == $single_product_layout ) {
				$classes[] = 'sticky-both';
			} else {
				if ( 'sticky-info' == $single_product_layout ) {
					$classes[] = 'sticky-info';
				}
				if ( 'sticky-thumbs' == $single_product_layout ) {
					$classes[] = 'sticky-thumbs';
				}
				if ( ! alpha_doing_ajax() ) {
					$classes[] = 'row';
				}
			}
		}
		return apply_filters( 'alpha_single_product_extend_class', $classes, $single_product_layout );
	}
}

/**
 * get_single_product_layout
 *
 * Get single product layout type
 *
 * @return string
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_single_product_layout' ) ) {
	function alpha_get_single_product_layout() {
		global $alpha_layout;

		if ( alpha_doing_ajax() ) {
			$layout = '';
			if ( 'offcanvas' != alpha_get_option( 'quickview_type' ) ) {
				$layout = alpha_get_option( 'quickview_thumbs' );
			}
			if ( ! $layout ) {
				$layout = 'horizontal';
			}
		} else {
			$layout = empty( $alpha_layout['single_product_type'] ) ? 'horizontal' : $alpha_layout['single_product_type'];
		}
		return apply_filters( 'alpha_single_product_layout', $layout );
	}
}

/**
 * wc_show_product_images_not_sticky_both
 *
 * Shows single product images if gallery type is not sticky both.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_show_product_images_not_sticky_both' ) ) {
	function alpha_wc_show_product_images_not_sticky_both() {
		if ( 'sticky-both' != alpha_get_single_product_layout() ) {
			woocommerce_show_product_images();
		}
	}
}


/**
 * Alpha Single Product - Gallery Image Functions
 */
if ( ! function_exists( 'alpha_wc_get_gallery_image_html' ) ) {
	/**
	 * Get html of single product gallery image
	 *
	 * @since 1.0
	 * @param int $attachment_id        Image ID
	 * @param boolean $main_image       True if large image is needed
	 * @param boolean $featured_image   True if attachment is featured image
	 * @param boolean $is_thumbnail     True if thumb wrapper is needed
	 * @return string image html
	 */
	function alpha_wc_get_gallery_image_html( $attachment_id, $main_image = false, $featured_image = false, $is_thumbnail = true ) {

		if ( $main_image ) {
			// Get large image

			$image_size    = apply_filters( 'woocommerce_gallery_image_size', doing_action( 'woocommerce_after_shop_loop_item_title' ) ? 'woocommerce_thumbnail' : 'woocommerce_single' );
			$full_size     = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
			$thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'woocommerce_single' );
			$full_src      = wp_get_attachment_image_src( $attachment_id, $full_size );
			$alt_text      = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
			$image         = wp_get_attachment_image(
				$attachment_id,
				$image_size,
				false,
				apply_filters(
					'woocommerce_gallery_image_html_attachment_image_params',
					array(
						'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-src'                => esc_url( ! empty( $full_src ) ? $full_src[0] : '' ),
						'data-large_image'        => esc_url( ! empty( $full_src[0] ) ? $full_src[0] : '' ),
						'data-large_image_width'  => ! empty( $full_src[1] ) ? $full_src[1] : '',
						'data-large_image_height' => ! empty( $full_src[2] ) ? $full_src[2] : '',
						'class'                   => $featured_image ? 'wp-post-image' : '',
					),
					$attachment_id,
					$image_size,
					$main_image
				)
			);

			if ( $is_thumbnail ) {
				$image = '<div data-thumb="' . esc_url( ! empty( $thumbnail_src[0] ) ? $thumbnail_src[0] : '' ) . ( $alt_text ? '" data-thumb-alt="' . esc_attr( $alt_text ) : '' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( ! empty( $full_src[0] ) ? $full_src[0] : '' ) . '">' . $image . '</a></div>';
			}
		} else {
			// Get small image

			$thumbnail_size = apply_filters( 'alpha_wc_thumbnail_image_size', 'woocommerce_thumbnail' );

			if ( $attachment_id ) {
				// If default or horizontal layout, print simple image tag
				$gallery_thumbnail = false;
				if ( 'alpha-product-thumbnail' == $thumbnail_size ) {
					$image_sizes = wp_get_additional_image_sizes();
					if ( isset( $image_sizes[ $thumbnail_size ] ) ) {
						$gallery_thumbnail = $image_sizes[ $thumbnail_size ];
					}
				}
				if ( ! $gallery_thumbnail ) {
					$gallery_thumbnail = wc_get_image_size( $thumbnail_size );
				}

				if ( 0 == $gallery_thumbnail['height'] ) {
					$full_image_size = wp_get_attachment_image_src( $attachment_id, 'full' );
					if ( isset( $full_image_size[1] ) && $full_image_size[1] ) {
						$gallery_thumbnail['height'] = intval( $gallery_thumbnail['width'] / absint( $full_image_size[1] ) * absint( $full_image_size[2] ) );
					}
				}
				$thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
				$image_src      = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
				$image          = '<img alt="' . esc_attr( _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ) ) . '" src="' . esc_url( ! empty( $image_src[0] ) ? $image_src[0] : '' ) . '" width="' . (int) ( ! empty( $thumbnail_size[0] ) ? $thumbnail_size[0] : '' ) . '" height="' . (int) ( ! empty( $thumbnail_size[1] ) ? $thumbnail_size[1] : '' ) . '">';

			} else {
				$image = '';
			}

			if ( $is_thumbnail && $image ) {
				$image = '<div class="product-thumb' . ( $featured_image ? ' active' : '' ) . '">' . $image . '</div>';
			}
		}
		return apply_filters( 'alpha_wc_get_gallery_image_html', $image );
	}
}

/**
 * single_product_thumbnail_image_size
 *
 * Get single product thumbnail image size.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_thumbnail_image_size' ) ) {
	function alpha_single_product_thumbnail_image_size( $image ) {
		if ( alpha_is_product() ) {
			return 'alpha-product-thumbnail';
		}
	}
}


/**
 * Alpha Single Product Navigation
 */

/**
 * single_product_navigation
 *
 * Render single product navigation.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_navigation' ) ) {
	function alpha_single_product_navigation() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			global $post;
			$prev_post = get_previous_post( true, '', 'product_cat' );
			$next_post = get_next_post( true, '', 'product_cat' );
			$html      = '';

			if ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) {
				$html .= '<ul class="product-nav">';

				if ( is_a( $prev_post, 'WP_Post' ) ) {
					$html             .= '<li class="product-nav-prev">';
						$html         .= '<a href="' . esc_url( get_the_permalink( $prev_post->ID ) ) . '" aria-label="' . esc_html__( 'Prev', 'pandastore' ) . '" rel="prev"><i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i>';
							$html     .= '<span class="product-nav-popup">';
								$html .= alpha_strip_script_tags( get_the_post_thumbnail( $prev_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
								$html .= '<span>' . esc_attr( get_the_title( $prev_post->ID ) ) . '</span>';
					$html             .= '</span></a></li>';
				}
				if ( is_a( $next_post, 'WP_Post' ) ) {
					$html             .= '<li class="product-nav-next">';
						$html         .= '<a href="' . esc_url( get_the_permalink( $next_post->ID ) ) . '" aria-label="' . esc_html__( 'Next', 'pandastore' ) . '" rel="next"><i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i>';
							$html     .= ' <span class="product-nav-popup">';
								$html .= alpha_strip_script_tags( get_the_post_thumbnail( $next_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
								$html .= '<span>' . esc_attr( get_the_title( $next_post->ID ) ) . '</span>';
					$html             .= '</span></a></li>';
				}

				$html .= '</ul>';
			}
			do_action( 'alpha_single_product_builder_unset_preview' );
			return apply_filters( 'alpha_single_product_navigation', $html );
		}
	}
}

/**
 * single_prev_next_product
 *
 * Render single product navigation.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_prev_next_product' ) ) {
	function alpha_single_prev_next_product( $args ) {
		global $post;
		if ( 'single_product' == alpha_get_page_layout() || ( isset( $post ) && ALPHA_NAME . '_template' == get_post_type() && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) ) {
			$args['wrap_before'] = '<div class="product-navigation">' . $args['wrap_before'];
			$args['wrap_after'] .= alpha_single_product_navigation() . '</div>';
		}
		return apply_filters( 'alpha_filter_single_prev_next_product', $args );
	}
}

/**
 * single_product_wrap_first_start
 *
 * Render start part of single product wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_wrap_first_start' ) ) {
	function alpha_single_product_wrap_first_start() {

		$single_product_layout = alpha_get_single_product_layout();

		if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) ||
			( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) &&
			'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo 'grid' == $single_product_layout ? '<div class="col-md-7">' : '<div class="col-md-6">';
		}
	}
}

/**
 * single_product_wrap_first_end
 *
 * Render end part of single product wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_wrap_first_end' ) ) {
	function alpha_single_product_wrap_first_end() {

		$single_product_layout = alpha_get_single_product_layout();

		if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) || ( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) && 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo '</div>';
		}
	}
}

/**
 * single_product_wrap_second_start
 *
 * Render start part of single product wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_wrap_second_start' ) ) {
	function alpha_single_product_wrap_second_start() {

		$single_product_layout = alpha_get_single_product_layout();

		if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) || ( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) && 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo 'grid' == $single_product_layout ? '<div class="col-md-5">' : '<div class="col-md-6">';
		}
	}
}

/**
 * single_product_wrap_second_end
 *
 * Render end part of single product wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_wrap_second_end' ) ) {
	function alpha_single_product_wrap_second_end() {

		$single_product_layout = alpha_get_single_product_layout();

		if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) || ( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) && 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo '</div>';
		}
	}
}

/**
 * single_product_sticky_cart_wrap_start
 *
 * Render start part of single product sticky cart wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_sticky_cart_wrap_start' ) ) {
	function alpha_single_product_sticky_cart_wrap_start() {
		global $alpha_layout;
		if ( apply_filters( 'alpha_single_product_sticky_cart_enabled', ! empty( $alpha_layout['single_product_sticky'] ) ) ) {
			echo '<div class="sticky-content product-sticky-content" data-sticky-options="{\'minWidth\':' . ( empty( $alpha_layout['single_product_sticky_mobile'] ) ? '768' : '1' ) . ', \'scrollMode\': true}"><div class="container">';
		}
	}
}

/**
 * single_product_sticky_cart_wrap_end
 *
 * Render end part of single product sticky cart wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_sticky_cart_wrap_end' ) ) {
	function alpha_single_product_sticky_cart_wrap_end() {
		global $alpha_layout;
		if ( apply_filters( 'alpha_single_product_sticky_cart_enabled', ! empty( $alpha_layout['single_product_sticky'] ) ) ) {
			echo '</div></div>';
		}
	}
}

/**
 * Alpha Single Product Media Functions
 */

/**
 * single_product_images
 *
 * Render single product images
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_images' ) ) {
	function alpha_single_product_images() {
		$single_product_layout = alpha_get_single_product_layout();

		if ( in_array( $single_product_layout, apply_filters( 'alpha_special_gallery_types', array( 'horizontal', 'vertical', 'gallery', 'sticky-thumbs' ) ) ) ) {
			return;
		}

		global $product;
		global $alpha_layout;

		$single_product_layout = alpha_get_single_product_layout();
		$post_thumbnail_id     = $product->get_image_id();
		$attachment_ids        = $product->get_gallery_image_ids();

		if ( $post_thumbnail_id ) {
			$html = apply_filters( 'woocommerce_single_product_image_thumbnail_html', alpha_wc_get_gallery_image_html( $post_thumbnail_id, true, true ), $post_thumbnail_id );
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image">', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'pandastore' ) );
			$html .= '</div>';
		}

		if ( $single_product_layout ) {
			if ( $attachment_ids && $post_thumbnail_id ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$html .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', alpha_wc_get_gallery_image_html( $attachment_id, true ), $attachment_id );
				}
			}
		}

		echo alpha_escaped( $html );
	}
}

/**
 * single_product_gallery_classes
 *
 * Return single product gallery classes.
 *
 * @param array $classes
 * @return array
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_gallery_classes' ) ) {
	function alpha_single_product_gallery_classes( $classes ) {
		$single_product_layout = alpha_get_single_product_layout();
		$classes[]             = 'product-gallery';

		if ( 'vertical' == $single_product_layout ) {
			wp_enqueue_script( 'swiper' );
			$classes[] = 'pg-vertical';
		} elseif ( 'horizontal' == $single_product_layout ) {
			wp_enqueue_script( 'swiper' );
		} elseif ( 'gallery' == $single_product_layout ) {
			wp_enqueue_script( 'swiper' );
			$classes[] = 'pg-gallery';
		} elseif ( 'grid' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2';
		} elseif ( 'sticky-both' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2 cols-lg-1';
		} elseif ( 'masonry' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2';
			$classes[] = 'product-masonry-type';
		} elseif ( 'sticky-info' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'gutter-no';
		} elseif ( '' == $single_product_layout ) {
			$classes[] = 'pg-default';
		}
		return apply_filters( 'alpha_single_product_gallery_classes', $classes, $single_product_layout );
	}
}

/**
 * Alpha Single Product Meta - Social Sharing Wrapper Functions
 */

/**
 * single_product_ms_wrap_start
 *
 * Return start part of single product meta wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_ms_wrap_start' ) ) {
	function alpha_single_product_ms_wrap_start() {
		echo '<div class="product-ms-wrapper">';
	}
}

/**
 * single_product_ms_wrap_end
 *
 * Return end part of single product meta wrap.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_ms_wrap_end' ) ) {
	function alpha_single_product_ms_wrap_end() {
		echo '</div>';
	}
}

/**
 * Alpha Single Product Summary Functions
 */

/**
 * Display sale countdown for simple & variable product in single product page.
 *
 * @since 1.0
 * @param string $ends_label
 * @return void
 */
if ( ! function_exists( 'alpha_single_product_sale_countdown' ) ) {
	function alpha_single_product_sale_countdown( $ends_label = '' ) {

		global $product;

		if ( $product->is_on_sale() ) {

			$extra_class = '';

			if ( $product->is_type( 'variable' ) ) {
				$variations = $product->get_available_variations( 'object' );
				$date_diff  = '';
				$sale_date  = '';
				foreach ( $variations as $variation ) {
					if ( $variation->is_on_sale() ) {
						$new_date = get_post_meta( $variation->get_id(), '_sale_price_dates_to', true );
						if ( ! $new_date || ( $date_diff && $date_diff != $new_date ) ) {
							$date_diff = false;
						} elseif ( $new_date ) {
							if ( false !== $date_diff ) {
								$date_diff = $new_date;
							}
							$sale_date = $new_date;
						}
						if ( false === $date_diff && $sale_date ) {
							break;
						}
					}
				}
				if ( $date_diff ) {
					$date_diff = date( 'Y/m/d H:i:s', (int) $date_diff );
				} elseif ( $sale_date ) {
					$extra_class .= ' countdown-variations';
					$date_diff    = date( 'Y/m/d H:i:s', (int) $sale_date );
				}
			} else {
				$date_diff = $product->get_date_on_sale_to();
				if ( $date_diff ) {
					$date_diff = $date_diff->date( 'Y/m/d H:i:s' );
				}
			}

			if ( $date_diff ) {
				wp_enqueue_script( 'jquery-countdown' );
				wp_enqueue_script( 'alpha-countdown' );
				?>
				<div class="product-countdown-container<?php echo esc_attr( $extra_class ); ?>">
					<?php echo empty( $ends_label ) ? esc_html__( 'Offer Ends In:', 'pandastore' ) : esc_html( $ends_label ); ?>
					<div class="countdown product-countdown countdown-compact" data-until="<?php echo esc_attr( $date_diff ); ?>" data-compact="true">0<?php echo esc_html__( 'days', 'pandastore' ); ?>, 00 : 00 : 00</div>
				</div>
				<?php
			}
		}
	}
}

/**
 * Single Product Sale Countdown for variable product.
 *
 * @since 1.0
 * @param array $vars
 * @param array $product
 * @param array $variation
 * @return array $vars
 */
if ( ! function_exists( 'alpha_variation_add_sale_ends' ) ) {
	function alpha_variation_add_sale_ends( $vars, $product, $variation ) {

		if ( $variation->is_on_sale() ) {
			$date_diff = $variation->get_date_on_sale_to();
			if ( $date_diff ) {
				$vars['alpha_date_on_sale_to'] = $date_diff->date( 'Y/m/d H:i:s' );
			}
		}
		return $vars;
	}
}

/**
 * single_product_summary_extend_class
 *
 * Return single product summary extend class.
 *
 * @param string $class
 * @return string
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_summary_extend_class' ) ) {
	function alpha_single_product_summary_extend_class( $class ) {
		if ( alpha_doing_ajax() ) {
			$class .= ' scrollable';
		}
		return $class;
	}
}

/**
 * single_product_divider
 *
 * Render single product divider.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_divider' ) ) {
	function alpha_single_product_divider() {
		echo apply_filters( 'alpha_single_product_divider', '<hr class="product-divider">' );
	}
}

/**
 * Alpha Single Product Data Tab Functions
 */

/**
 * single_product_get_data_tab_type
 *
 * Return single product data tab type.
 *
 * @param string $tabs
 * @return string
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_get_data_tab_type' ) ) {
	function alpha_single_product_get_data_tab_type( $tabs ) {
		global $alpha_layout;
		if ( isset( $alpha_layout['product_data_type'] ) ) {
			if ( 'accordion' == $alpha_layout['product_data_type'] ) {
				return 'accordion';
			} elseif ( 'section' == $alpha_layout['product_data_type'] ) {
				return 'section';
			}
		}
		return 'tab';
	}
}

/**
 * wc_product_custom_tabs
 *
 * @param string $tabs
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_product_custom_tabs' ) ) {
	function alpha_wc_product_custom_tabs( $tabs ) {

		// Show reviews at last
		if ( isset( $tabs['reviews'] ) ) {
			$tabs['reviews']['priority'] = 999;
		}

		// Change default titles
		if ( isset( $tabs['description'] ) && isset( $tabs['description']['title'] ) ) {
			$tabs['description']['title'] = alpha_get_option( 'product_description_title' );
		}

		if ( isset( $tabs['additional_information'] ) && isset( $tabs['additional_information']['title'] ) ) {
			$tabs['additional_information']['title'] = alpha_get_option( 'product_specification_title' );
		}
		if ( isset( $tabs['reviews'] ) && isset( $tabs['reviews']['title'] ) ) {
			$tabs['reviews']['title'] = alpha_get_option( 'product_reviews_title' ) . ' <span>(' . $GLOBALS['product']->get_review_count() . ')</span>';
		}
		if ( isset( $tabs['seller'] ) && isset( $tabs['seller']['title'] ) ) {
			$tabs['seller']['title'] = alpha_get_option( 'product_vendor_info_title' );
		}
		if ( isset( $tabs['vendor'] ) && isset( $tabs['vendor']['title'] ) ) {
			$tabs['vendor']['title'] = alpha_get_option( 'product_vendor_info_title' );
		}

		// Global tab
		$title = alpha_get_option( 'product_tab_title' );
		if ( $title ) {
			$tabs['alpha_product_tab'] = array(
				'title'    => sanitize_text_field( $title ),
				'priority' => 24,
				'callback' => 'alpha_wc_product_custom_tab',
			);
		}

		// Custom tab for current product
		$title = get_post_meta( get_the_ID(), 'alpha_custom_tab_title_1st', true );
		if ( $title ) {
			$tabs['alpha_custom_tab_1st'] = array(
				'title'    => sanitize_text_field( $title ),
				'priority' => 26,
				'callback' => 'alpha_wc_product_custom_tab',
			);
		}
		$title = get_post_meta( get_the_ID(), 'alpha_custom_tab_title_2nd', true );
		if ( $title ) {
			$tabs['alpha_custom_tab_2nd'] = array(
				'title'    => sanitize_text_field( $title ),
				'priority' => 26,
				'callback' => 'alpha_wc_product_custom_tab',
			);
		}
		return $tabs;
	}
}


/**
 * wc_product_custom_tab
 *
 * Render Woocommerce Custom Tab.
 *
 * @param string $key
 * @param string product_tab
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_product_custom_tab' ) ) {
	function alpha_wc_product_custom_tab( $key, $product_tab ) {
		wc_get_template(
			'single-product/tabs/custom_tab.php',
			array(
				'tab_name' => $key,
				'tab_data' => $product_tab,
			)
		);
	}
}

/**
 * yith_wcwl_positions
 *
 * Change default YITH positions
 *
 * @param array $position
 * @return array
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_yith_wcwl_positions' ) ) {
	function alpha_yith_wcwl_positions( $position ) {
		$position['after_add_to_cart']['priority'] = 10;
		$position['after_add_to_cart']['hook']     = 'woocommerce_after_add_to_cart_button';

		$position['add-to-cart']['priority'] = 10;
		$position['add-to-cart']['hook']     = 'woocommerce_after_add_to_cart_button';

		$position['thumbnails']['priority'] = 10;
		$position['thumbnails']['hook']     = 'woocommerce_after_add_to_cart_button';

		$position['summary']['priority'] = 10;
		$position['summary']['hook']     = 'woocommerce_after_add_to_cart_button';

		return $position;
	}
}

/**
 * Single Product Reviews Tab
 */

/**
 * wc_review_before_avatar
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_review_before_avatar' ) ) {
	function alpha_wc_review_before_avatar() {
		echo '<figure class="comment-avatar">';
	}
}

/**
 * wc_review_after_avatar
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_review_after_avatar' ) ) {
	function alpha_wc_review_after_avatar() {
		echo '</figure>';
	}
}

/**
 * Alpha Single Product - Related Products Functions
 *
 * @since 1.0
 * @param array $args
 * @return array $args
 */
if ( ! function_exists( 'alpha_related_products_args' ) ) {
	function alpha_related_products_args( $args = array() ) {
		$count    = alpha_get_option( 'product_related_count' );
		$orderby  = alpha_get_option( 'product_related_order' );
		$orderway = alpha_get_option( 'product_related_orderway' );
		if ( $count ) {
			$args['posts_per_page'] = $count;
		}
		if ( $orderby ) {
			$args['orderby'] = $orderby;
		}
		if ( $orderway ) {
			$args['order'] = $orderway ? $orderway : 'desc';
		}
		return $args;
	}
}

/**
 * Alpha Single Product - Up-Sells Products Functions
 *
 * @since 1.0
 * @param array $args
 * @return array $args
 */
if ( ! function_exists( 'alpha_upsells_products_args' ) ) {
	function alpha_upsells_products_args( $args = array() ) {
		$count    = alpha_get_option( 'product_upsells_count' );
		$orderby  = alpha_get_option( 'product_upsells_order' );
		$orderway = alpha_get_option( 'product_upsells_orderway' );
		if ( $count ) {
			$args['posts_per_page'] = $count;
		}
		if ( $orderby ) {
			$args['orderby'] = $orderby;
		}
		if ( $orderway ) {
			$args['order'] = $orderway ? $orderway : 'desc';
		}
		return $args;
	}
}

/**
 * Alpha Quickview Ajax Actions
 */

/**
 * wc_quickview
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_quickview' ) ) {
	function alpha_wc_quickview() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		if ( ! has_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 58 ) ) {
			add_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 58 );
		}

		global $product, $post;
		$product_id = intval( $_POST['product_id'] );
		$post       = get_post( $product_id );
		$product    = wc_get_product( $product_id );

		if ( $product->is_type( 'variation' ) ) {
			$attrs = wc_get_product_variation_attributes( $post->ID );
			if ( ! empty( $attrs ) ) {
				foreach ( $attrs as $key => $val ) {
					$_REQUEST[ $key ] = $val;
				}
			}
			$parent_id = wp_get_post_parent_id( $post );
			if ( $parent_id ) {
				$post    = get_post( (int) $parent_id );
				$product = wc_get_product( $post->ID );
			}
		}

		wc_get_template_part( 'content', 'single-product' );
		// phpcs:enable
		die;
	}
}

/**
 * quickview_add_scripts
 *
 * Enqueue script files for quickview.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_quickview_add_scripts' ) ) {
	function alpha_quickview_add_scripts() {
		wp_enqueue_script( 'swiper' );
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jquery-countdown' );

		wp_enqueue_script( 'wc-single-product' );
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		wp_enqueue_script( 'zoom' );
	}
}

/**
 * single_product_compare
 *
 * Render Single Product Compare.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_compare' ) ) {
	function alpha_single_product_compare() {
		if ( alpha_get_option( 'compare_available' ) ) {
			alpha_product_compare( ' btn-product-icon' );
		}
	}
}

/**
 * print_wishlist_button
 *
 * Render YITH wishlist button
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_print_wishlist_button' ) ) {
	function alpha_print_wishlist_button() {
		echo do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
	}
}

/**
 * single_product_links_wrap_start
 *
 * Render start part of single product links.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_links_wrap_start' ) ) {
	function alpha_single_product_links_wrap_start() {
		echo '<div class="product-links-wrapper">';
	}
}

/**
 * single_product_links_wrap_end
 *
 * Render end part of single product links.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_links_wrap_end' ) ) {
	function alpha_single_product_links_wrap_end() {
		echo '</div>';
	}
}

/* Single Product Gallery Types */
foreach ( apply_filters(
	'alpha_sp_types',
	array(
		'vertical'      => true,
		'horizontal'    => true,
		'grid'          => true,
		'masonry'       => true,
		'gallery'       => true,
		'sticky-info'   => true,
		'sticky-thumbs' => true,
		'sticky-both'   => true,
	),
	'hooks'
) as $key => $value ) {
	if ( $key && $value ) {
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . "/woocommerce/product-single/product-single-{$key}.php" );
	}
}

/**
 * Fires after setting product single actions and filters.
 *
 * Here you can remove and add more actions and filters.
 *
 * @since 1.0
 */
do_action( 'alpha_after_ps_hooks' );
