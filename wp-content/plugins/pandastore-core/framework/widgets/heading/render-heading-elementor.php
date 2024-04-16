<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Heading Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'title'           => '',
			'tag'             => 'h2',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => '',
			'title_align'     => '',
			'link_align'      => '',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',

			// For elementor inline editing
			'self'            => '',
		),
		$atts
	)
);

$html = '';

if ( 'dynamic' == $content_type ) {
	global $alpha_layout;
	$title = '';

	if ( isset( $alpha_layout ) ) {

		if ( class_exists( 'WooCommerce' ) && is_shop() ) { // Shop Page
			$page_id = wc_get_page_id( 'shop' );
		} elseif ( is_home() && get_option( 'page_for_posts' ) ) { // Blog Page
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

		if ( 'title' == $dynamic_content ) {
			Alpha_Layout_Builder::get_instance()->setup_titles();
			$title = get_post_meta( $page_id, 'page_title', true );
			if ( ! $title ) {
				$title = $alpha_layout['title'];
			}
		} elseif ( 'subtitle' == $dynamic_content ) {
			Alpha_Layout_Builder::get_instance()->setup_titles();
			$title = get_post_meta( $page_id, 'page_subtitle', true );
			if ( ! $title ) {
				$title = $alpha_layout['subtitle'];
			}
		} elseif ( 'product_cnt' == $dynamic_content ) {
			if ( function_exists( 'alpha_is_shop' ) && alpha_is_shop() && alpha_wc_get_loop_prop( 'total' ) ) {
				$title = alpha_wc_get_loop_prop( 'total' ) . ' products';
			}
		}
	} else {
		if ( 'title' == $dynamic_content ) {
			$title = esc_html__( 'Page Title', 'pandastore-core' );
		} elseif ( 'subtitle' == $dynamic_content ) {
			$title = esc_html__( 'Page Subtitle', 'pandastore-core' );
		} elseif ( 'product_cnt' == $dynamic_content ) {
			$title = esc_html__( '* Products', 'pandastore-core' );
		}
	}


	if ( 'site_tagline' == $dynamic_content ) {
		$title = esc_html( get_bloginfo( 'description' ) );
	} elseif ( 'site_title' == $dynamic_content ) {
		$title = esc_html( get_bloginfo() );
	} elseif ( 'date' == $dynamic_content ) {
		$format      = '';
		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );

		if ( $date_format ) {
			$format   = $date_format;
			$has_date = true;
		} else {
			$has_date = false;
		}

		if ( $time_format ) {
			if ( $has_date ) {
				$format .= ' ';
			}
			$format .= $time_format;
		}

		$title = esc_html( date_i18n( $format ) );
	}
}

$class = $class ? $class . ' title elementor-heading-title' : 'title elementor-heading-title';

$wrapp_class = '';

if ( $decoration ) {
	$wrapp_class .= ' title-' . $decoration;
}

if ( $title_align ) {
	$wrapp_class .= ' ' . $title_align;
}

if ( $link_align ) {
	$wrapp_class .= ' ' . $link_align;
}


$link_label = '<span ' . ( $self ? $self->get_render_attribute_string( 'link_label' ) : '' ) . '>' . esc_html( $link_label ) . '</span>';

if ( is_array( $icon ) && $icon['value'] ) {
	if ( 'before' == $icon_pos ) {
		$wrapp_class .= ' icon-before';
		$link_label   = '<i class="' . esc_attr( $icon['value'] ) . '"></i>' . $link_label;
	} else {
		$wrapp_class .= ' icon-after';
		$link_label  .= '<i class="' . esc_attr( $icon['value'] ) . '"></i>';
	}
}

$html .= '<div class="title-wrapper ' . esc_attr( $wrapp_class ) . '">';

if ( $self ) {
	$self->add_render_attribute( 'title', 'class', $class );
}

if ( $title ) {
	$html .= sprintf( '<%1$s ' . ( $self ? $self->get_render_attribute_string( 'title' ) : '' ) . '>%2$s</%1$s>', $tag, $title );
}

if ( 'yes' == $show_link ) { // If Link is allowed
	if ( 'yes' == $show_divider ) {
		$html .= '<span class="divider"></span>';
	}
	$html .= sprintf( '<a href="%1$s" class="link"%3$s>%2$s</a>', $link_url['url'] ? esc_url( $link_url['url'] ) : '#', $link_label, ( $link_url['is_external'] ? ' target="nofollow"' : '' ) . ( $link_url['nofollow'] ? ' rel="_blank"' : '' ) );
}
$html .= '</div>';

echo do_shortcode( alpha_escaped( $html ) );
