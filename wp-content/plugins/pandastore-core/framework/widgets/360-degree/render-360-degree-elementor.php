<?php
/**
 * Alpha 360 Degree View Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Images
			'images'         => '',
			'thumbnail_size' => 'thumbnail',
			'button_type'    => 'framed',
		),
		$atts
	)
);

if ( ! is_array( $images ) ) {
	$images = explode( '|', $images );
	foreach ( $images as $key => $val ) {
		$images[ $key ] = json_decode( $val, true );
	}
}

if ( $images && defined( 'ALPHA_VERSION' ) ) {
	$srcs     = [];
	$post_img = '';
	foreach ( $images as $image ) {
		if ( ! $post_img ) {
			$post_img = $image['id'];
		}
		$srcs[] = esc_url( wp_get_attachment_image_url( $image['id'], $thumbnail_size ) );
	}
	?>
	<div class="alpha-360-gallery-wrapper nav-bar-<?php echo esc_attr( $button_type ); ?>">
		<div class="post-div">
			<?php echo wp_get_attachment_image( $post_img, $thumbnail_size ); ?>
			<div class="nav_bar">
				<a href="#" class="nav_bar_previous"></a>
				<a href="#" class="nav_bar_play"></a>
				<a href="#" class="nav_bar_next"></a>
			</div>
		</div>
		<ul class="alpha-360-gallery-wrap list-type-none" data-srcs="<?php echo esc_attr( implode( ',', $srcs ) ); ?>">
		</ul>
		<div class="d-loading"><i></i></div>
	</div>

	<?php
}
