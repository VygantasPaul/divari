<?php
/**
 * Post Meta
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

$html = '';

if ( ! isset( $show_info ) || in_array( 'author', $show_info ) ) {
	if ( 'widget' !== alpha_get_loop_prop( 'type' ) ) {
		$html .= '<span class="post-author">';
		$html .= get_avatar( get_the_ID(), 30 );
		// translators: %s represents author link tag.
		$html .= sprintf( esc_html__( 'By %s', 'pandastore' ), get_the_author_posts_link() );
		$html .= '</span>';
	} else {
		$id    = get_the_ID();
		$link  = get_day_link(
			get_post_time( 'Y', false, $id, false ),
			get_post_time( 'm', false, $id, false ),
			get_post_time( 'j', false, $id, false )
		);
		$html .= '<span class="post-date"><a href="' . esc_url( $link ) . '">' . esc_html( get_the_date() ) . '</a></span>';
	}
}

if ( 'widget' !== alpha_get_loop_prop( 'type' ) ) {
	if ( ! isset( $show_info ) || in_array( 'comment', $show_info ) ) {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			ob_start();

			// translators: %1$s and %2$s are opening and closing of mark tag.
			$zero = sprintf( esc_html__( '%1$s0%2$s', 'pandastore' ), '<mark>', '</mark>' ); //phpcs:ignore
			// translators: %1$s and %2$s are opening and closing of mark tag.
			$one = sprintf( esc_html__( '%1$s1%2$s', 'pandastore' ), '<mark>', '</mark>' ); //phpcs:ignore
			// translators: %1$s and %3$s are opening and closing of mark tag, %2$s is %.
			$more = sprintf( esc_html__( '%1$s%2$s%3$s', 'pandastore' ), '<mark>', '%', '</mark>' ); //phpcs:ignore

			comments_popup_link( $zero, $one, $more, 'comments-link scroll-to local' );

			$html .= ob_get_clean();
		}
	}

	$html .= '<div class="post-share-wrapper p-relative">
				<div class="social-icons p-absolute">
					<a href="https://www.facebook.com/sharer.php?u=' . esc_url( get_the_permalink() ) . '" class="social-icon  social-custom social-facebook" target="_blank" title="facebook"
						rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
					<a href="https://twitter.com/intent/tweet?text=Global+Opportunities&amp;url=' . esc_url( get_the_permalink() ) . '" class="social-icon  social-custom social-twitter" target="_blank" title="twitter"
						rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
					<a href="https://pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink() ) . '"
						class="social-icon  social-custom social-pinterest" target="_blank" title="pinterest"
						rel="noopener noreferrer"><i class="fab fa-pinterest"></i></a>
					<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url( get_the_permalink() ) . '&amp;title=Global+Opportunities" class="social-icon  social-custom social-linkedin" target="_blank" title="linkedin"
						rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
				</div>
				<a class="post-share-icon" href="#"><i class="' . ALPHA_ICON_PREFIX . '-icon-socials"></i></a>
			</div>';
}

if ( $html ) {
	echo '<div class="post-meta">' . alpha_escaped( $html ) . '</div>';
}
