<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha IconList Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'view'      => 'block',
			'title'     => '',
			'class'     => '',
			'icon_list' => '',
		),
		$atts
	)
);

$html = '<div class="alpha-icon-lists ' . esc_attr( $view ) . '-type ' . '">';

if ( $title ) {
	$html .= '<h4 class="list-title">' . alpha_strip_script_tags( $title ) . '</h4>';
}

if ( is_array( $icon_list ) ) {
	foreach ( $icon_list as $icon_item ) {
		$html .= '<a href="' . ( empty( $icon_item['link']['url'] ) ? '#' : esc_url( $icon_item['link']['url'] ) ) . '" class="alpha-icon-list-item">';
		if ( ! empty( $icon_item['selected_icon']['value'] ) ) {
			$html .= '<i class="' . esc_attr( $icon_item['selected_icon']['value'] ) . '"></i>';
		}
		$html .= esc_html( $icon_item['text'] ) . '</a>';
	}
}

$html .= '</div>';

echo do_shortcode( alpha_escaped( $html ) );
