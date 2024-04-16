<?php
/**
 * Post Media
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

global $post;
$post_type = get_post_type();

if ( 'video' == get_post_format() && get_post_meta( $post->ID, 'featured_video' ) && ! in_array( alpha_get_loop_prop( 'type' ), array( 'widget', 'mask' ) ) ) {
	wp_enqueue_script( 'jquery-fitvids' );

	$video_code = get_post_meta( $post->ID, 'featured_video', true );
	if ( false !== strpos( $video_code, '[video src="' ) && has_post_thumbnail() ) {
		$video_code = str_replace( '[video src="', '[video poster="' . esc_url( get_the_post_thumbnail_url( null, 'full' ) ) . '" src="', $video_code );
	}
	?>
	<figure class="post-media fit-video">
		<?php
		echo do_shortcode( $video_code );

		if ( 'default' !== alpha_get_loop_prop( 'type' ) && 'widget' !== alpha_get_loop_prop( 'type' ) ) {
			?>
			<div class="post-calendar">
				<?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
			</div>
			<?php
		}
		?>
	</figure>
	<?php
} else {
	$featured_id = get_post_thumbnail_id();
	// get supported images of the post
	$image_ids = get_post_meta( $post->ID, 'supported_images' );
	if ( $featured_id ) {
		$image_ids = array_merge( array( $featured_id ), $image_ids );
	}

	if ( count( $image_ids ) ) {
		if ( count( $image_ids ) > 1 && 'large' == alpha_get_loop_prop( 'image_size' ) ) {
			$col_cnt = alpha_get_responsive_cols( array( 'lg' => 1 ) );

			$attrs = array( 'col_sp' => 'no' );

			if ( in_array( alpha_get_loop_prop( 'type' ), array( 'mask' ) ) ) {
				$attrs['show_dots'] = '';
			}
			?>
			<div class="post-media-carousel slider-dots-white
				<?php
				echo alpha_get_col_class( $col_cnt ) . ' ' . alpha_get_slider_class(
					array(
						'dots_pos' => 'inner',
					)
				);
				?>
				" data-slider-options="<?php echo esc_attr( json_encode( alpha_get_slider_attrs( $attrs, $col_cnt ) ) ); ?>">
			<?php
		} else {
			$image_ids = array( $image_ids[0] );
		}

		foreach ( $image_ids as $thumbnail_id ) {
			?>
			<figure class="post-media">
				<a href="<?php the_permalink(); ?>">
					<?php
					$size = apply_filters( 'post_thumbnail_size', alpha_get_loop_prop( 'image_size' ), $post->ID );

					if ( $thumbnail_id ) {
						do_action( 'begin_fetch_post_thumbnail_html', $post->ID, $thumbnail_id, $size );
						if ( in_the_loop() ) {
							update_post_thumbnail_cache();
						}
						$html = wp_get_attachment_image( $thumbnail_id, $size, false );
						do_action( 'end_fetch_post_thumbnail_html', $post->ID, $thumbnail_id, $size );
					} else {
						$html = '';
					}

					echo apply_filters( 'post_thumbnail_html', $html, $post->ID, $thumbnail_id, $size );

					// Caption
					$caption = get_the_post_thumbnail_caption();
					if ( $caption ) {
						?>
						<figcaption class="thumbnail-caption">
							<?php echo alpha_strip_script_tags( $caption ); ?>
						</figcaption>
						<?php
					}
					?>
				</a>
				<?php
				if ( 'default' !== alpha_get_loop_prop( 'type' ) && 'widget' !== alpha_get_loop_prop( 'type' ) ) {
					?>
					<div class="post-calendar">
						<?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
					</div>
					<?php
				}
				?>
			</figure>
			<?php
		}

		if ( count( $image_ids ) > 1 ) {
			?>
			</div>
			<?php
		}
	} else {
		?>
		<figure class="post-media">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo ALPHA_ASSETS . '/images/placeholders/' . $post_type . '-placeholder.jpg'; ?>" alt="<?php esc_attr_e( 'Post placeholder image', 'pandastore' ); ?>">
			</a>
			<?php
			if ( 'default' !== alpha_get_loop_prop( 'type' ) && 'widget' !== alpha_get_loop_prop( 'type' ) ) {
				?>
				<div class="post-calendar">
					<?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
				</div>
				<?php
			}
			?>
		</figure>
		<?php
	}
}
