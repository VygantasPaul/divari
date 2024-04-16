<?php
/**
 * Post Related
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

if ( 'attachment' == get_post_type() ) {
	return;
}

global $alpha_layout;

if ( ! isset( $args ) ) {
	$args = array();
}

$args          = wp_parse_args(
	$args,
	array(
		'post_type'           => get_post_type(),
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => 0,
		'category__in'        => wp_get_post_categories( get_the_ID() ),
		'posts_per_page'      => empty( $alpha_layout['related_count'] ) ? 4 : $alpha_layout['related_count'],
		'orderby'             => empty( $alpha_layout['related_order'] ) ? '' : $alpha_layout['related_order'],
		'order'               => empty( $alpha_layout['related_orderway'] ) ? '' : $alpha_layout['related_orderway'],
	)
);
$related_posts = new WP_Query( apply_filters( 'alpha_filter_related_posts_args', $args ) );

if ( $related_posts && $related_posts->have_posts() ) :

	$col_cnt = alpha_get_responsive_cols( array( 'lg' => empty( $alpha_layout['related_column'] ) ? 4 : $alpha_layout['related_column'] ), 'post' );

	?>
	<section class="related-posts p-relative">
		<h3 class="title-wrapper title-underline"><span class="title"><?php esc_html_e( 'Related Posts', 'pandastore' ); ?></span></h3>
		<?php
		$props = array(
			'posts_layout' => 'slider',
			'col_cnt'      => $col_cnt,
			'related'      => true,
		);

		do_action( 'alpha_before_posts_loop', $props );

		alpha_get_template_part( 'posts/post', 'loop-start' );

		while ( $related_posts->have_posts() ) :
			$related_posts->the_post();
			alpha_get_template_part( 'posts/post' );
		endwhile;

		alpha_get_template_part( 'posts/post', 'loop-end' );

		do_action( 'alpha_after_posts_loop' );

		wp_reset_postdata();
		?>
	</section>
	<?php
endif;
