<?php
/**
 * Single Post
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */

// Show Info
$show_info = alpha_get_option( 'post_show_info', array() );
$classes   = get_post_class();

if ( in_array( 'meta', $show_info ) ) {
	$show_info[] = 'author';
	$show_info[] = 'date';
	$show_info[] = 'comment_count';
}
if ( ! in_array( 'post', $classes ) ) {
	$classes[] = 'post';
}

// The Post
the_post();

?>

<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'alpha_post_single_class', array( 'post-single' ) ) ) ); ?>">

	<div class="post-wrap">

		<?php do_action( 'alpha_post_loop_before_item', 'default', 'single' ); ?>

		<article class="<?php echo esc_attr( implode( ' ', apply_filters( 'alpha_post_single_classes', $classes ) ) ); ?>">
			<?php

			if ( in_array( 'image', $show_info ) ) {
				alpha_get_template_part( 'posts/single/post', 'media' );
			}

			?>
			<div class="post-details">
				<?php

				alpha_get_template_part( 'posts/single/post', 'meta', array( 'show_info' => $show_info ) );

				alpha_get_template_part( 'posts/single/post', 'title' );

				alpha_get_template_part( 'posts/single/post', 'content' );

				if ( in_array( 'tag', $show_info ) ) {
					alpha_get_template_part( 'posts/single/post', 'tag' );
				}

				if ( in_array( 'author_info', $show_info ) ) {
					alpha_get_template_part( 'posts/single/post', 'author' );
				}

				if ( in_array( 'share', $show_info ) && function_exists( 'alpha_print_share' ) ) {
					alpha_print_share();
				}
				?>
			</div>
		</article>

		<?php do_action( 'alpha_post_loop_after_item', 'default', 'single' ); ?>

	</div>
	<?php

	if ( in_array( 'navigation', $show_info ) ) {
		alpha_get_template_part( 'posts/single/post', 'navigation' );
	}

	if ( in_array( 'related', $show_info ) ) {
		alpha_get_template_part( 'posts/single/post', 'related' );
	}

	if ( in_array( 'comments_list', $show_info ) ) {
		comments_template();
	}

	?>
</div>
