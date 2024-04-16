<?php
/**
 * Post Meta
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

$html = '';

if ( ! isset( $show_info ) || in_array( 'author', $show_info ) ) {
	$html .= '<span class="post-author">';
	// translators: %s represents author link tag.
	$html .= sprintf( esc_html__( 'by %s', 'pandastore' ), get_the_author_posts_link() );
	$html .= '</span>';
}

if ( ! isset( $show_info ) || in_array( 'date', $show_info ) ) {
	$id    = get_the_ID();
	$link  = get_day_link(
		get_post_time( 'Y', false, $id, false ),
		get_post_time( 'm', false, $id, false ),
		get_post_time( 'j', false, $id, false )
	);
	$html .= '<span class="post-date"><a href="' . esc_url( $link ) . '">' . esc_html( get_the_date() ) . '</a></span>';
}

if ( ! isset( $show_info ) || in_array( 'comment', $show_info ) ) {
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		ob_start();

		// translators: %1$s and %2$s are opening and closing of mark tag.
		$zero = sprintf( esc_html__( '%1$s0%2$s Comments', 'pandastore' ), '<mark>', '</mark>' ); //phpcs:ignore
		// translators: %1$s and %2$s are opening and closing of mark tag.
		$one = sprintf( esc_html__( '%1$s1%2$s Comment', 'pandastore' ), '<mark>', '</mark>' ); //phpcs:ignore
		// translators: %1$s and %3$s are opening and closing of mark tag, %2$s is %.
		$more = sprintf( esc_html__( '%1$s%2$s%3$s Comment', 'pandastore' ), '<mark>', '%', '</mark>' ); //phpcs:ignore

		comments_popup_link( $zero, $one, $more, 'comments-link scroll-to local' );

		$html .= ob_get_clean();
	}
}

if ( $html ) {
	echo '<div class="post-meta">' . alpha_escaped( $html ) . '</div>';
}
