<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Button Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'label'                      => '',
			'button_expand'              => '',
			'button_type'                => '',
			'button_size'                => '',
			'button_skin'                => 'btn-primary',
			'button_gradient_skin'       => '',
			'shadow'                     => '',
			'button_border'              => '',
			'link_hover_type'            => '',
			'link'                       => '',
			'show_icon'                  => '',
			'show_label'                 => 'yes',
			'icon'                       => '',
			'icon_pos'                   => 'after',
			'icon_hover_effect'          => '',
			'icon_hover_effect_infinite' => '',
			'btn_class'                  => '',
			'show_icon'                  => '',
			'play_btn'                   => '',
			'video_btn'                  => '',
			'video_url'                  => array( 'url' => '#' ),
			'vtype'                      => 'youtube',
			'builder'                    => 'elementor',

			// For elementor inline editing
			'self'                       => '',
		),
		$atts
	)
);

$class = 'btn';

if ( 'yes' == $button_expand ) {
	$class .= ' btn-block';
}

if ( empty( $label ) ) {
	$label = esc_html__( 'Click here', 'pandastore-core' );
}
$label  = alpha_widget_button_get_label( $atts, $self, $label, 'label' );
$class .= ' ' . implode( ' ', alpha_widget_button_get_class( $atts ) );

global $alpha_section;
if ( isset( $play_btn ) && 'yes' == $play_btn ) {
	$alpha_section['video_btn'] = true;
	$class                     .= ' btn-video elementor-custom-embed-image-overlay';
	$options                    = array();
	if ( isset( $alpha_section['lightbox'] ) ) {
		$options = $alpha_section['lightbox'];
	}
	echo '<div class="' . esc_attr( $class ) . '" role="button"' . ( $options ? ( ' data-elementor-open-lightbox="yes" data-elementor-lightbox="' . esc_attr( json_encode( $options ) ) . '"' ) : '' ) . '>' . alpha_strip_script_tags( $label ) . '</div>';
} elseif ( 'yes' == $video_btn ) {
	$class .= ' btn-video-iframe';
	printf( '<a class="' . esc_attr( $class ) . '" href="' . esc_url( ! empty( $video_url['url'] ) ? $video_url['url'] : '#' ) . '" data-video-source="' . esc_attr( $vtype ) . '">%1$s</a>', alpha_strip_script_tags( $label ) );
} else {
	$attrs = [];
	if ( 'elementor' === $builder ) {
		$attrs['href']   = ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '#';
		$attrs['target'] = ! empty( $link['is_external'] ) ? '_blank' : '';
		$attrs['rel']    = ! empty( $link['nofollow'] ) ? 'nofollow' : '';
		if ( ! empty( $link['custom_attributes'] ) ) {
			foreach ( explode( ',', $link['custom_attributes'] ) as $attr ) {
				$key   = explode( '|', $attr )[0];
				$value = implode( ' ', array_slice( explode( '|', $attr ), 1 ) );
				if ( isset( $attrs[ $key ] ) ) {
					$attrs[ $key ] .= ' ' . $value;
				} else {
					$attrs[ $key ] = $value;
				}
			}
		}
	} else {
		$attrs['href']   = ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '#';
		$attrs['target'] = ! empty( $link['target'] ) ? esc_attr( $link['target'] ) : '';
		$attrs['rel']    = ! empty( $link ['rel'] ) ? esc_attr( $link['rel'] ) : '';
	}
	$link_attrs = '';
	foreach ( $attrs as $key => $value ) {
		if ( ! empty( $value ) ) {
			$link_attrs .= $key . '="' . esc_attr( $value ) . '" ';
		}
	}
	printf( '<a class="' . esc_attr( $class ) . '" ' . $link_attrs . '>%1$s</a>', alpha_strip_script_tags( $label ) );
}
