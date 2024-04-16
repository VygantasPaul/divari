<?php
/**
 * The testimonial widget render.
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'testimonial_type' => 'testimonial-1',
			'name'             => esc_html__( 'John Doe', 'pandastore-core' ),
			'role'             => esc_html__( 'Customer', 'pandastore-core' ),
			'link'             => '',
			'title'            => '',
			'content'          => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'pandastore-core' ),
			'avatar'           => array( 'url' => '' ),
			'rating'           => '',
			'star_icon'        => '',
			'rating_sp'        => array( 'size' => 0 ),
		),
		$atts
	)
);

$html        = '';
$rating_html = '';

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	$image = Elementor\Group_Control_Image_Size::get_attachment_image_html( $atts, 'avatar' );
} else {
	$image = '';
	if ( is_numeric( $avatar ) ) {
		$img_data = wp_get_attachment_image_src( $avatar, 'full' );
		$img_alt  = get_post_meta( $avatar, '_wp_attachment_image_alt', true );
		$img_alt  = $img_alt ? esc_attr( trim( $img_alt ) ) : esc_attr__( 'Testimonial Image', 'pandastore-core' );

		if ( is_array( $img_data ) ) {
			$image = '<img src="' . esc_url( $img_data[0] ) . '" alt="' . $img_alt . '" width="' . esc_attr( $img_data[1] ) . '" height="' . esc_attr( $img_data[2] ) . '">';
		}
	}
}

if ( isset( $link['url'] ) && $link['url'] ) {
	$image = '<a href="' . esc_url( $link['url'] ) . '">' . $image . '</a>';
}

$image = '<div class="avatar">' . $image . '</div>';

$title_escaped = trim( esc_html( $title ) );
$content       = '<p class="comment">' . esc_textarea( $content ) . '</p>';

if ( $rating && ( 'testimonial-1' != $testimonial_type && 'testimonial-4' != $testimonial_type && 'testimonial-5' != $testimonial_type ) ) {
	$rating            = floatval( $rating );
	$rating_sp['size'] = floatval( $rating_sp['size'] );
	$rating_cls        = '';
	if ( $star_icon ) {
		$rating_cls .= ' ' . $star_icon;
	}
	$rating_w     = 'calc(' . 20 * floatval( $rating ) . '% - ' . $rating_sp['size'] * ( $rating - floor( $rating ) ) . 'px)'; // get rating width
	$rating_html .= '<div class="ratings-container"><div class="ratings-full' . $rating_cls . '" style="letter-spacing: ' . $rating_sp['size'] . 'px;" aria-label="Rated ' . $rating . ' out of 5"><span class="ratings" style="width: ' . $rating_w . '; letter-spacing: ' . $rating_sp['size'] . 'px;"></span><span class="tooltiptext tooltip-top">' . $rating . '</span></div></div>';
}

$commenter = '<cite><span class="name">' . esc_html( $name ) . '</span><span class="role">' . esc_html( $role ) . '</span></cite>';

if ( 'testimonial-1' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-1' . ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	$html .= '<div class="content">' . $content . '</div>';
	$html .= '<div class="commenter">' . $image . $commenter . '</div>';
	$html .= '</blockquote>';
} elseif ( 'testimonial-2' == $testimonial_type || 'testimonial-3' == $testimonial_type ) {
	if ( 'testimonial-2' == $testimonial_type ) {
		$html .= '<blockquote class="testimonial testimonial-2';
	} else {
		$html .= '<blockquote class="testimonial testimonial-2 testimonial-3';
	}
	$html .= ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	$html .= '<div class="media">' . $image . $rating_html . '</div>';
	$html .= '<div class="content">' . $content . '</div>';
	$html .= '<div class="commenter">' . $commenter . '</div>';
	$html .= '</blockquote>';
} elseif ( 'testimonial-4' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-4' . ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	$html .= $image;
	$html .= '<div class="content">' . $content . '<div class="commenter">' . $commenter . '</div></div>';
	$html .= '</blockquote>';
} else {
	$html .= '<blockquote class="testimonial testimonial-5' . ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	$html .= $image;
	$html .= '<div class="content">' . $content . '</div>';
	$html .= '<div class="commenter">' . $commenter . '</div>';
	$html .= '</blockquote>';
}

echo alpha_strip_script_tags( $html );
