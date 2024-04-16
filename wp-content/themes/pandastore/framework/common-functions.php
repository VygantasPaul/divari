<?php
/**
 * Define common functions using in Alpha FrameWork.
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

if ( ! function_exists( 'alpha_strip_script_tags' ) ) :

	/**
	 * Strip script and style tags from content.
	 *
	 * @since 1.0
	 *
	 * @param string $content Content to strip script and style tags.
	 *
	 * @return string stripped text
	 */
	function alpha_strip_script_tags( $content ) {
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = preg_replace( '/<script.*?\/script>/s', '', $content ) ? : $content;
		$content = preg_replace( '/<style.*?\/style>/s', '', $content ) ? : $content;
		return $content;
	}
endif;

if ( ! function_exists( 'alpha_get_col_class' ) ) :

	/**
	 * Get column class from columns count array
	 *
	 * @since 1.0
	 *
	 * @param int[] $col_cnt Array of columns count per each breakpoint.
	 *
	 * @return string columns class
	 */
	function alpha_get_col_class( $col_cnt = array() ) {

		$class = ' row';
		foreach ( $col_cnt as $w => $c ) {
			if ( $c > 0 ) {
				$class .= ' cols-' . ( 'min' != $w ? $w . '-' : '' ) . $c;
			}
		}

		return apply_filters( 'alpha_get_col_class', $class );
	}
endif;


if ( ! function_exists( 'alpha_get_slider_class' ) ) {

	/**
	 * Get slider class from settings array
	 *
	 * @since 1.0
	 *
	 * @return string slider class
	 */
	function alpha_get_slider_class() {

		wp_enqueue_script( 'swiper' );

		return 'slider-wrapper';
	}
}

if ( ! function_exists( 'alpha_get_slider_status_class' ) ) {
	/**
	 * Get slider status class from settings array
	 *
	 * @since 1.0
	 *
	 * @param array $settings Slider settings array from elementor widget.
	 *
	 * @return string slider class
	 */
	function alpha_get_slider_status_class( $settings = array() ) {

		$class = '';
		// Nav & Dots
		if ( isset( $settings['nav_type'] ) && 'full' == $settings['nav_type'] ) {
			$class .= ' slider-nav-full';
		} else {
			if ( isset( $settings['nav_type'] ) && 'circle' == $settings['nav_type'] ) {
				$class .= ' slider-nav-circle';
			}
			if ( isset( $settings['nav_pos'] ) && 'top' == $settings['nav_pos'] ) {
				$class .= ' slider-nav-top';
			} elseif ( isset( $settings['nav_pos'] ) && 'bottom' == $settings['nav_pos'] ) {
				$class .= ' slider-nav-bottom';
			} elseif ( isset( $settings['nav_pos'] ) && 'inner' != $settings['nav_pos'] ) {
				$class .= ' slider-nav-outer';
			}
		}
		if ( isset( $settings['nav_hide'] ) && 'yes' == $settings['nav_hide'] ) {
			$class .= ' slider-nav-fade';
		}
		if ( isset( $settings['dots_skin'] ) && $settings['dots_skin'] ) {
			$class .= ' slider-dots-' . $settings['dots_skin'];
		}
		if ( isset( $settings['dots_pos'] ) && 'inner' == $settings['dots_pos'] ) {
			$class .= ' slider-dots-inner';
		}
		if ( isset( $settings['dots_pos'] ) && 'outer' == $settings['dots_pos'] ) {
			$class .= ' slider-dots-outer';
		}
		if ( isset( $settings['fullheight'] ) && 'yes' == $settings['fullheight'] ) {
			$class .= ' slider-full-height';
		}
		if ( isset( $settings['box_shadow_slider'] ) && 'yes' == $settings['box_shadow_slider'] ) {
			$class .= ' slider-shadow';
		}

		if ( isset( $settings['slider_vertical_align'] ) && ( 'top' == $settings['slider_vertical_align'] ||
			'middle' == $settings['slider_vertical_align'] ||
			'bottom' == $settings['slider_vertical_align'] ||
			'same-height' == $settings['slider_vertical_align'] ) ) {

			$class .= ' slider-' . $settings['slider_vertical_align'];
		}

		return $class;
	}
}

if ( ! function_exists( 'alpha_get_slider_attrs' ) ) {

	/**
	 * Get slider data attribute from settings array
	 *
	 * @since 1.0
	 *
	 * @param array $settings Slider settings array from elementor widget.
	 * @param array $col_cnt  Columns count
	 * @param string $id      Hash string for element
	 *
	 * @return string slider data attribute
	 */
	function alpha_get_slider_attrs( $settings, $col_cnt, $id = '' ) {

		$max_breakpoints = alpha_get_breakpoints();

		$extra_options = array();

		if ( ! empty( $settings['slide_effect'] ) ) {
			$extra_options['effect'] = $settings['slide_effect'];
		}

		$extra_options['spaceBetween'] = alpha_get_grid_space( isset( $settings['col_sp'] ) ? $settings['col_sp'] : '' );

		if ( isset( $settings['loop'] ) && 'yes' == $settings['loop'] ) { // default is false
			$extra_options['loop'] = true;
		}

		// Auto play
		if ( isset( $settings['autoplay'] ) && 'yes' == $settings['autoplay'] ) { // default is false
			if ( isset( $settings['autoplay_timeout'] ) ) { // default is 5000
				$extra_options['autoplay'] = array(
					'delay'                => (int) $settings['autoplay_timeout'],
					'disableOnInteraction' => false,
				);
			}
		}

		if ( ! empty( $settings['show_dots'] ) && isset( $settings['dots_type'] ) && 'thumb' == $settings['dots_type'] && $id ) {
			$extra_options['dotsContainer'] = '.slider-thumb-dots-' . $id;
		}
		if ( ! empty( $settings['show_nav'] ) ) {
			$extra_options['navigation'] = true;
		}
		if ( ! empty( $settings['show_dots'] ) ) {
			$extra_options['pagination'] = true;
		}
		if ( isset( $settings['autoheight'] ) && 'yes' == $settings['autoheight'] ) {
			$extra_options['autoHeight'] = true;
		}

		$responsive = array();
		$col_cnt    = alpha_get_responsive_cols( $col_cnt );

		foreach ( $col_cnt as $w => $c ) {
			if ( 'min' == $w ) {
				$responsive[ $max_breakpoints[ $w ] ] = array(
					'slidesPerView' => $c,
					'spaceBetween'  => (int) $extra_options['spaceBetween'] > 20 ? 20 : (int) $extra_options['spaceBetween'],
				);
				$responsive[480]                      = array(
					'slidesPerView' => $c,
					'spaceBetween'  => (int) $extra_options['spaceBetween'],
				);
			} elseif ( 'sm' == $w ) {
				$responsive[ $max_breakpoints[ $w ] ] = array(
					'slidesPerView' => $c,
				);
			} else {
				$responsive[ $max_breakpoints[ $w ] ] = array(
					'slidesPerView' => $c,
				);
			}
		}

		if ( isset( $col_cnt['xl'] ) ) {
			$extra_options['slidesPerView'] = $col_cnt['xl'];
		} elseif ( isset( $col_cnt['lg'] ) ) {
			$extra_options['slidesPerView'] = $col_cnt['lg'];
		}

		if ( isset( $settings['dots_type'] ) && 'thumb' == $settings['dots_type'] && $id ) {
			$extra_options['pagination'] = false;
			foreach ( $responsive as $w => $c ) {
				$responsive[ $w ]['pagination'] = false;
			}
		}

		$extra_options['breakpoints'] = $responsive;

		$extra_options['statusClass'] = trim( ( empty( $settings['status_class'] ) ? '' : $settings['status_class'] ) . alpha_get_slider_status_class( $settings ) );

		return $extra_options;
	}
}

if ( ! function_exists( 'alpha_get_overlay_class' ) ) {
	/**
	 * Get overlay class
	 *
	 * @since 1.0
	 *
	 * @param string $overlay overlay type
	 *
	 * @return string Overlay classes
	 */
	function alpha_get_overlay_class( $overlay ) {
		if ( 'light' === $overlay ) {
			return 'overlay-light';
		}
		if ( 'dark' === $overlay ) {
			return 'overlay-dark';
		}
		if ( 'zoom' === $overlay ) {
			return 'overlay-zoom';
		}
		if ( 'zoom_light' === $overlay ) {
			return 'overlay-zoom overlay-light';
		}
		if ( 'zoom_dark' === $overlay ) {
			return 'overlay-zoom overlay-dark';
		}
		if ( 0 == strncmp( $overlay, 'effect-', 7 ) ) {
			return 'overlay-' . $overlay;
		}
		return '';
	}
}

if ( ! function_exists( 'alpha_escaped' ) ) {
	/**
	 * Get already escaped text.
	 *
	 * @since 1.0
	 *
	 * @param string $html_escaped Escaped text
	 *
	 * @return string Original escaped text
	 */
	function alpha_escaped( $html_escaped ) {
		return $html_escaped;
	}
}

if ( ! function_exists( 'alpha_get_breakpoints' ) ) {

	/**
	 * Get breakpoints
	 *
	 * @since 1.0
	 *
	 * @param string $screen_mode Screen mode
	 *
	 * @return int|array Breakpoints array or given breakpoint number.
	 */
	function alpha_get_breakpoints( $screen_mode = '' ) {
		if ( 'min' == $screen_mode ) {
			return 0;
		} elseif ( 'sm' == $screen_mode ) {
			return 576;
		} elseif ( 'md' == $screen_mode ) {
			return 768;
		} elseif ( 'lg' == $screen_mode ) {
			return 992;
		} elseif ( 'xl' == $screen_mode ) {
			return 1200;
		}
		return array(
			'min' => 0,
			'sm'  => 576,
			'md'  => 768,
			'lg'  => 992,
			'xl'  => 1200,
		);
	}
}

if ( ! function_exists( 'alpha_add_url_parameters' ) ) {
	/**
	 * Add parameters with value to url
	 *
	 * @since 1.0
	 */
	function alpha_add_url_parameters( $url, $name, $value ) {

		$url_data = parse_url( str_replace( '#038;', '&', $url ) );
		if ( ! isset( $url_data['query'] ) ) {
			$url_data['query'] = '';
		}
		$params = array();
		parse_str( $url_data['query'], $params );
		$params[ $name ]   = $value;
		$url_data['query'] = http_build_query( $params );

		$url = '';

		if ( isset( $url_data['host'] ) ) {

			$url .= $url_data['scheme'] . '://';

			if ( isset( $url_data['user'] ) ) {

				$url .= $url_data['user'];

				if ( isset( $url_data['pass'] ) ) {

					$url .= ':' . $url_data['pass'];
				}

				$url .= '@';

			}

			$url .= $url_data['host'];

			if ( isset( $url_data['port'] ) ) {

				$url .= ':' . $url_data['port'];
			}
		}

		if ( isset( $url_data['path'] ) ) {

			$url .= $url_data['path'];
		}

		if ( isset( $url_data['query'] ) ) {

			$url .= '?' . $url_data['query'];
		}

		if ( isset( $url_data['fragment'] ) ) {

			$url .= '#' . $url_data['fragment'];
		}

		return alpha_woo_widget_clean_link( $url );
	}
}

if ( ! function_exists( 'alpha_woo_widget_clean_link' ) ) {
	/**
	 * Get clean link
	 *
	 * @since 1.0
	 */
	function alpha_woo_widget_clean_link( $link ) {
		return str_replace( '#038;', '&', str_replace( '%2C', ',', $link ) );
	}
}

if ( ! function_exists( 'alpha_get_template_part' ) ) {
	/**
	 * Include template part
	 *
	 * @since 1.0
	 * @param string $slug
	 * @param string $name
	 * @param array $args
	 * @return string $template
	 */
	function alpha_get_template_part( $slug, $name = null, $args = array() ) {

		if ( ! defined( 'ALPHA_FRAMEWORK_PATH' ) ) {
			return '';
		}

		// Add ALPHA_PART to slug, if it hasn't
		if ( ALPHA_PART != substr( $slug, strlen( ALPHA_PART ) ) ) {
			$slug = ALPHA_PART . '/' . $slug;
		}

		// Get template path
		$template = '';
		$name     = (string) $name;
		if ( $name ) {
			$template = locate_template( array( "{$slug}-{$name}.php", "inc/{$slug}-{$name}.php", "framework/{$slug}-{$name}.php" ) );
		}
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", "inc/{$slug}.php", "framework/{$slug}.php" ) );
		}
		$template = apply_filters( 'alpha_get_template_part', $template, $slug, $name );

		// Extract args and include template
		if ( $template ) {
			if ( ! empty( $args ) && is_array( $args ) ) {
				extract( $args ); // @codingStandardsIgnoreLine
			}
			include $template;
		}

		return $template;
	}
}

if ( ! function_exists( 'alpha_get_review_pagination' ) ) {
	/**
	 * Include template part
	 *
	 * @since 1.0
	 * @param string $slug
	 * @param string $name
	 * @param array $args
	 * @return string $template
	 */
	function alpha_get_review_pagination() {
		global $wp_query;
		$page = $wp_query->get( 'cpage' );

		$args = apply_filters(
			'woocommerce_comment_pagination_args',
			array(
				'echo'      => false,
				'prev_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i>' . esc_html__( 'Prev', 'pandastore' ),
				'next_text' => esc_html__( 'Next', 'pandastore' ) . '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i>',
			)
		);

		$pagination = paginate_comments_links( $args );

		if ( $pagination ) {
			if ( 1 == $page ) {
				$pagination = sprintf(
					'<span class="prev page-numbers disabled">%s</span>',
					$args['prev_text']
				) . $pagination;
			} elseif ( get_comment_pages_count() == $page ) {
				$pagination .= sprintf(
					'<span class="next page-numbers disabled">%s</span>',
					$args['next_text']
				);
			}
		}

		return $pagination;
	}
}
