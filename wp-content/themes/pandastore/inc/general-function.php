<?php
/**
 * General function
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
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
			if ( isset( $settings['nav_type'] ) && 'outline' == $settings['nav_type'] ) {
				$class .= ' slider-nav-outline';
			} elseif ( isset( $settings['nav_type'] ) && 'long-arrow' == $settings['nav_type'] ) {
				$class .= ' slider-nav-long-arrow';
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
		if ( isset( $settings['dots_type'] ) && 'number' == $settings['dots_type'] ) {
			$class .= ' slider-dots-' . $settings['dots_type'];
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

/**
 * Loadmore html
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_loadmore_html' ) ) {
	function alpha_loadmore_html( $query, $loadmore_type, $loadmore_label, $loadmore_btn_style = '', $name_prefix = '' ) {
		if ( 'button' == $loadmore_type ) {
			$class = 'btn btn-load ';

			if ( $loadmore_btn_style ) {
				$class .= function_exists( 'alpha_widget_button_get_class' ) ? implode( ' ', alpha_widget_button_get_class( $loadmore_btn_style, $name_prefix ) ) : '';
			} else {
				$class .= 'btn-dark';
			}

			$label = empty( $loadmore_label ) ? esc_html__( 'Load More', 'pandastore' ) : esc_html( $loadmore_label );
			echo '<button class="' . esc_attr( $class ) . '">' . ( $loadmore_btn_style && function_exists( 'alpha_widget_button_get_label' ) ? alpha_widget_button_get_label( $loadmore_btn_style, null, $label, $name_prefix ) : $label ) . '</button>';
		} elseif ( 'page' == $loadmore_type || ! $loadmore_type ) {
			echo alpha_get_pagination( $query, 'pagination-load' );
		}
	}
}
