<?php
/**
 * Post Archive
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

global $alpha_layout;

$wrapper_class = alpha_get_loop_prop( 'wrapper_class', array() );
$wrapper_attrs = alpha_get_loop_prop( 'wrapper_attrs', '' );

$cpt             = alpha_get_loop_prop( 'cpt' );
$posts_layout    = alpha_get_loop_prop( 'posts_layout' );
$post_type       = alpha_get_loop_prop( 'type' );
$overlay         = alpha_get_loop_prop( 'overlay' );
$col_cnt         = alpha_get_loop_prop( 'col_cnt' );
$loop_classes    = alpha_get_loop_prop( 'loop_classes', array() );
$loop_classes[]  = 'post';
$wrapper_class[] = 'posts';

if ( 'post' != $cpt ) {
	$wrapper_class[] = $cpt . 's';
}
// Archive
if ( ! alpha_get_loop_prop( 'widget' ) && ! alpha_get_loop_prop( 'related' ) ) {
	$posts_column = alpha_get_loop_prop( 'posts_column' );
	$image_size   = alpha_get_loop_prop( 'image_size' );
	if ( $posts_column > 1 ) {
		if ( 2 == $posts_column ) {
			$image_size = 'alpha-post-medium';
		}
		$wrapper_class[] = 'grid';
	} else {
		$loop_classes[] = 'post-lg';
		$image_size     = 'full';
	}
	if ( 'creative' == $posts_layout ) {
		$image_size = 'large';
	}
	alpha_set_loop_prop( 'image_size', $image_size );
}

if ( ! empty( $overlay ) ) {
	$loop_classes[] = alpha_get_overlay_class( $overlay );
}
if ( $post_type && ( 'list' != $post_type || 'creative' != $posts_layout ) ) {
	$loop_classes[] = ' ' . $cpt . '-' . $post_type;
}
alpha_set_loop_prop( 'loop_classes', $loop_classes );

// One column - List, Intro
if ( 'list' == $post_type ) {
	$wrapper_class[] = 'list-type-posts';
}
// Layouts - Grid, Masonry, Slider, Creative Grid(widget)
if ( 'masonry' == $posts_layout ) {

	$wrapper_class[] = 'grid';
	$wrapper_class[] = 'masonry';
	$wrapper_attrs   = " data-grid-options='" . json_encode( array( 'masonry' => array( 'horizontalOrder' => true ) ) ) . "'";
	wp_enqueue_script( 'isotope-pkgd' );

} elseif ( 'slider' == $posts_layout ) {

	if ( ! alpha_get_loop_prop( 'widget' ) ) {

		$wrapper_class[] = alpha_get_slider_class();
		$wrapper_attrs   = ' data-slider-options="' . esc_attr(
			json_encode( alpha_get_slider_attrs( apply_filters( 'alpha_related_slider_options', array(), alpha_get_loop_prop( 'related' ) ), alpha_get_loop_prop( 'col_cnt' ) ) )
		) . '"';
	}
}

if ( 'creative' != $posts_layout ) {
	$wrapper_class[] = alpha_get_col_class( $col_cnt );
}

// Loadmore Button or Pagination
$posts_query = alpha_get_loop_prop( 'posts' );
if ( empty( $posts_query ) ) {
	$posts_query = $GLOBALS['wp_query'];
}

if ( 1 < $posts_query->max_num_pages ) {
	if ( 'scroll' == alpha_get_loop_prop( 'loadmore_type' ) ) {
		$wrapper_class[] = 'load-scroll';
	}
	$wrapper_attrs .= ' ' . alpha_loadmore_attributes(
		$cpt,
		alpha_get_loop_prop( 'loadmore_props' ),
		alpha_get_loop_prop( 'loadmore_args' ),
		'page',
		$posts_query->max_num_pages
	);
}

if ( 'scroll' == alpha_get_loop_prop( 'loadmore_type' ) || 'button' == alpha_get_loop_prop( 'loadmore_type' ) ) {
	wp_enqueue_script( 'alpha-ajax' );
}
// Category Filter
if ( ! empty( $is_archive ) && alpha_get_option( 'posts_filter' ) ) {
	alpha_get_template_part( 'posts/post-filter' );
}

// Print Posts
$wrapper_class = apply_filters( 'alpha_post_loop_wrapper_classes', $wrapper_class );
echo '<div class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '"' . $wrapper_attrs . ( $post_type ? ' data-post-type="' . $post_type . '"' : '' ) . '>';
