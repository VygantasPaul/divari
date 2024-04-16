<?php
/**
 * Alpha Product Category Label Functions
 *
 * Functions used to display label type.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

// Category Thumbnail
add_action( 'woocommerce_before_subcategory_title', 'alpha_pc_label_before_subcategory_thumbnail', 5 );
add_action( 'woocommerce_before_subcategory_title', 'alpha_pc_label_subcategory_thumbnail' );

// Category Content
add_action( 'woocommerce_after_subcategory_title', 'alpha_pc_label_after_subcategory_title' );
add_action( 'woocommerce_shop_loop_subcategory_title', 'alpha_pc_label_template_loop_category_title' );

/**
 * pc_label_before_subcategory_thumbnail
 *
 * Render html after subcategory thumbnail.
 *
 * @param string $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_label_before_subcategory_thumbnail' ) ) {
	function alpha_pc_label_before_subcategory_thumbnail( $category ) {
		if ( 'label' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"' .
			( alpha_wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) . '>';
	}
}

/**
 * pc_label_subcategory_thumbnail
 *
 * Render subcategory thumbnail.
 *
 * @param string $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_label_subcategory_thumbnail' ) ) {
	function alpha_pc_label_subcategory_thumbnail( $category ) {
		if ( 'label' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}

		if ( alpha_wc_get_loop_prop( 'show_icon', false ) ) {
			$icon_class = get_term_meta( $category->term_id, 'product_cat_icon', true );
			$icon_class = $icon_class ? $icon_class : 'far fa-heart';
			echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
		}
	}
}

/**
 * pc_label_template_loop_category_title
 *
 * Render product category title.
 *
 * @param array $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_label_template_loop_category_title' ) ) {
	function alpha_pc_label_template_loop_category_title( $category ) {
		if ( 'label' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}
		// Title
		echo '<h3 class="woocommerce-loop-category__title">' . esc_html( $category->name ) . '</h3>';

		// Count
		if ( alpha_wc_get_loop_prop( 'show_count', true ) ) {
			echo apply_filters( 'woocommerce_subcategory_count_html', '<mark>' . esc_html( $category->count ) . ' ' . esc_html__( 'Products', 'pandastore' ) . '</mark>', $category );
		}

		// Link
		if ( alpha_wc_get_loop_prop( 'show_link', true ) ) {
			$link_text  = alpha_wc_get_loop_prop( 'link_text' );
			$link_class = 'btn btn-underline btn-link';
			echo '<a class="' . esc_html( $link_class ) . '"' .
			( alpha_wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) .
			' href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">' .
			( $link_text ? esc_html( $link_text ) : esc_html__( 'Shop Now', 'pandastore' ) ) .
			'</a>';
		}
	}
}

/**
 * pc_label_after_subcategory_title
 *
 * Render html after subcategory title.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_label_after_subcategory_title' ) ) {
	function alpha_pc_label_after_subcategory_title() {
		if ( 'label' == alpha_wc_get_loop_prop( 'category_type' ) ) {
			echo '</a>';
		}
	}
}
