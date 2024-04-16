<?php
/**
 * Post Archive
 *
 * @var string $no_heading      "Nothing Found" title from archive builder
 * @var string $no_description  "Nothing Found" description from archive builder
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! empty( $is_builder_rendering ) || ! apply_filters( 'alpha_run_archive_builder', false ) ) {
	?>
	<div class="post-archive">
		<?php

		if ( have_posts() ) {

			do_action( 'alpha_before_posts_loop', empty( $props ) ? '' : $props );

			alpha_get_template_part( 'posts/post', 'loop-start', array( 'is_archive' => true ) );

			while ( have_posts() ) :
				the_post();
				alpha_get_template_part( 'posts/post' );
			endwhile;

			alpha_get_template_part( 'posts/post', 'loop-end' );

			do_action( 'alpha_after_posts_loop' );
		} else {
			?>
			<h2 class="entry-title"><?php echo empty( $no_heading ) ? esc_html__( 'Nothing Found', 'pandastore' ) : esc_html( $no_heading ); ?></h2>

			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
				<p class="alert alert-light alert-info">
					<?php
					printf(
						// translators: %1$s represents open tag of admin url to create new, %2$s represents close tag.
						esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'pandastore' ),
						sprintf( '<a href="%1$s" target="_blank">', esc_url( admin_url( 'post-new.php' . '?post_type=' . get_post_type() ) ) ),
						'</a>'
					);
					?>
				</p>
			<?php elseif ( is_search() ) : ?>
				<p class="alert alert-light alert-info"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pandastore' ); ?></p>
			<?php else : ?>
				<p class="alert alert-light alert-info">
					<?php echo empty( $no_description ) ? esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pandastore' ) : alpha_strip_script_tags( $no_description ); ?>
				</p>
			<?php endif; ?>
			<?php
		}
		?>
	</div>
	<?php
}
