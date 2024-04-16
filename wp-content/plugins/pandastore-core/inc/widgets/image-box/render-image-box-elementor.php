<?php
/**
 * The image box elementor render.
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'title'        => esc_html__( 'Nunc id cursus me', 'pandastore-core' ),
			'subtitle'     => '',
			'content'      => 'Lorem ipsum dolor sit amet, consecte ad <br/> et dolore magna aliqua.',
			'image'        => array( 'url' => '' ),
			'thumbnail'    => 'full',
			'type'         => 'border',
			'page_builder' => '',
			'link'         => '',
		),
		$atts
	)
);

$html  = '';
$image = '';

if ( 'wpb' == $page_builder && ! empty( $atts['image'] ) ) {
	$image = wp_get_attachment_image( $atts['image'], $thumbnail );
} elseif ( defined( 'ELEMENTOR_VERSION' ) ) {
	$image = Elementor\Group_Control_Image_Size::get_attachment_image_html( $atts, 'image' );
}

$link_open  = empty( $link['url'] ) ? '' : '<a href="' . esc_url( $link['url'] ) . '"' . ( empty( $link['is_external'] ) ? '' : ' target="nofollow"' ) . ( empty( $link['nofollow'] ) ? '' : ' rel="_blank"' ) . '>';
$link_close = empty( $link['url'] ) ? '' : '</a>';

if ( $link && $title ) {
	$title = $link_open . $title . $link_close;
}

$title_html    = $title ? '<h3 class="title">' . $title . '</h3>' : '';
$subtitle_html = $subtitle ? '<h4 class="subtitle">' . $subtitle . '</h4>' : '';
$content_html  = $content ? '<div class="content">' . $content . '</div>' : '';

$html = '<div class="image-box ' . esc_attr( $type ) . '">';

if ( 'inner' == $type ) {
	$html .= '<figure>' . $image . '<div class="overlay">' . $title_html . $subtitle_html . $content_html . '</div>' . '</figure>';
} elseif ( 'border' == $type || 'boxed' == $type || 'aside' == $type ) {
	$html .= $link_open . '<figure>' . $image . '</figure>' . $link_close . '<div class="image-box-content">' . $title_html . $subtitle_html . $content_html . '</div>';
} else {
	$html .= $link_open . '<figure>' . $image . '</figure>' . $link_close . $title_html . $subtitle_html . $content_html;
}

$html .= '</div>';

echo alpha_escaped( $html );
