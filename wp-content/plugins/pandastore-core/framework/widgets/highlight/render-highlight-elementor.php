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
			'items' => '',
			'self'  => '',
		),
		$atts
	)
);

if ( ! empty( $items ) ) {

	$html       = '';
	$is_preview = alpha_is_elementor_preview();

	foreach ( $items as $key => $item ) {
		if ( ( ! empty( $item['_id'] ) && ! empty( $item['highlight'] ) ) || $is_preview ) {
			if ( ! empty( $self ) ) {
				$repeater_setting_key = $self->get_repeater_setting_key( 'text', 'items', $key );
				$self->add_render_attribute( $repeater_setting_key, 'class', 'highlight ' . trim( esc_attr( ( empty( $item['custom_class'] ) ? '' : $item['custom_class'] ) . ' elementor-repeater-item-' . $item['_id'] ) ) );
				$self->add_render_attribute( $repeater_setting_key, 'class', $is_preview ? 'animating' : 'appear-animate' );
				$self->add_inline_editing_attributes( $repeater_setting_key );
			}
			$html .= '<span ' . ( $self ? $self->get_render_attribute_string( $repeater_setting_key ) : '' ) . '>' . esc_html( $item['text'] ) . '</span> ';
		} else {
			$html .= esc_html( $item['text'] ) . ' ';
		}

		if ( 'yes' == $item['line_break'] ) {
			$html .= '<br>';
		}
	}

	if ( empty( $self ) ) {
		printf(
			'<%1$s class="highlight-text">%2$s</%1$s>',
			in_array( $atts['header_size'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ) ) ? $atts['header_size'] : 'div',
			$html
		);
	} else {

		$self->add_render_attribute( 'title', 'class', 'elementor-heading-title highlight-text' );

		printf(
			'<%1$s %2$s>%3$s</%1$s>',
			in_array( $atts['header_size'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ) ) ? $atts['header_size'] : 'div',
			$self->get_render_attribute_string( 'title' ),
			$html
		);
	}
}
