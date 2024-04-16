<?php
/**
 * Alpha Product Category Icon Functions
 *
 * Functions used to display icon type.
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */

// Category Thumbnail
add_action( 'woocommerce_before_subcategory_title', 'alpha_pc_icon_before_subcategory_thumbnail', 5 );
add_action( 'woocommerce_before_subcategory_title', 'alpha_pc_icon_after_subcategory_thumbnail', 15 );
add_action( 'woocommerce_before_subcategory_title', 'alpha_pc_icon_subcategory_thumbnail' );

// Category Content
add_action( 'woocommerce_after_subcategory_title', 'alpha_pc_icon_after_subcategory_title' );
add_action( 'woocommerce_shop_loop_subcategory_title', 'alpha_pc_icon_template_loop_category_title' );

/**
 * pc_icon_before_subcategory_thumbnail
 *
 * Render html after subcategory thumbnail.
 *
 * @param string $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_icon_before_subcategory_thumbnail' ) ) {
	function alpha_pc_icon_before_subcategory_thumbnail( $category ) {
		if ( 'icon' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"' .
			( alpha_wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) . '>';
	}
}

/**
 * pc_icon_subcategory_thumbnail
 *
 * Render subcategory thumbnail.
 *
 * @param string $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_icon_subcategory_thumbnail' ) ) {
	function alpha_pc_icon_subcategory_thumbnail( $category ) {
		if ( 'icon' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}
		$icon_class = get_term_meta( $category->term_id, 'product_cat_icon', true );
		$icon_class = $icon_class ? $icon_class : 'far fa-heart';
		echo '<i class="' . $icon_class . '"></i>';
	}
}

/**
 * pc_icon_after_subcategory_thumbnail
 *
 * Render html after subcategory thumbnail.
 *
 * @param string $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_icon_after_subcategory_thumbnail' ) ) {
	function alpha_pc_icon_after_subcategory_thumbnail( $category ) {
		if ( 'icon' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}
		$content_origin = alpha_wc_get_loop_prop( 'content_origin' );
		echo '</a>';
		if ( $content_origin ) {
			echo '<div class="category-content ' . $content_origin . '">';
		} else {
			echo '<div class="category-content">';
		}
	}
}

/**
 * pc_icon_template_loop_category_title
 *
 * Render product category title.
 *
 * @param array $category
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_icon_template_loop_category_title' ) ) {
	function alpha_pc_icon_template_loop_category_title( $category ) {
		if ( 'icon' != alpha_wc_get_loop_prop( 'category_type' ) ) {
			return;
		}

		// Title
		echo '<h3 class="woocommerce-loop-category__title">';
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"' .
			( alpha_wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) . '>';
		echo esc_html( $category->name );
		echo '</a>';
		echo '</h3>';

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
 * pc_icon_after_subcategory_title
 *
 * Render html after subcategory title.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_pc_icon_after_subcategory_title' ) ) {
	function alpha_pc_icon_after_subcategory_title() {
		if ( 'icon' == alpha_wc_get_loop_prop( 'category_type' ) ) {
			echo '</div>';
		}
	}
}
