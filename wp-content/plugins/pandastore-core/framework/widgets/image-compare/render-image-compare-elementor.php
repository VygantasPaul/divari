<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Highlight Widget Render
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'handle_type'    => '',
			'direction'      => '',
			'show_label'     => 'yes',
			'labels_pos'     => 'center',
			'text_before'    => esc_html__( 'Before', 'pandastore-core' ),
			'text_after'     => esc_html__( 'After', 'pandastore-core' ),
			'image_before'   => '',
			'image_after'    => '',
			'image_size'     => '',
			'handle_control' => 'drag_click',
			'handle_offset'  => '',
		),
		$atts
	)
);

$args = array(
	'before_label' => esc_html( $text_before ),
	'after_label'  => esc_html( $text_after ),
	'orientation'  => 'vertical' == $direction ? 'vertical' : 'horizontal',
	'no_overlay'   => 'yes' == $show_label ? 0 : 1,
);

if ( 'drag_click' == $handle_control ) {
	$args['click_to_move'] = true;
} elseif ( 'drag' == $handle_control ) {
	$args['move_with_handle_only'] = true;
	$args['click_to_move']         = false;
} else {
	$args['move_slider_on_hover'] = true;
	$args['click_to_move']        = false;
}

if ( '' !== $handle_offset['size'] ) {
	$args['default_offset_pct'] = $handle_offset['size'] / 100;
}

echo '<div class="icomp-container icomp-' . esc_attr( ( 'circle' == $handle_type || 'rect' == $handle_type ) ? ( $handle_type . ' icomp-arrow icomp-has-bg' ) : $handle_type ) . ' icomp-labels-' . esc_attr( $labels_pos ) . '" data-icomp-options="' . esc_attr( json_encode( $args ) ) . '">';
if ( $image_before['url'] ) {
	if ( $image_before['id'] ) {
		echo wp_get_attachment_image( (int) $image_before['id'], $image_size );
	} else {
		echo '<img src="' . esc_url( $image_before['url'] ) . '">';
	}
}
if ( $image_after['url'] ) {
	if ( $image_after['id'] ) {
		echo wp_get_attachment_image( (int) $image_after['id'], $image_size );
	} else {
		echo '<img src="' . esc_url( $image_after['url'] ) . '">';
	}
}
echo '</div>';
