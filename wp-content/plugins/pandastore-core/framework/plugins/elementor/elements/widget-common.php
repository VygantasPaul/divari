<?php
/**
 * Alpha Common Elementor
 *
 * Enhanced elementor base common widget that gives you all the advanced options of the basic.
 * Added Alpha custom CSS and JS control
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class Alpha_Common_Elementor_Widget extends \Elementor\Widget_Common {
	/**
	 * Default Settings for WP Alpha Effect
	 *
	 * @since 1.0
	 * @access public
	 */
	public $default_addional_settings = array();

	public function __construct( array $data = [], array $args = null ) {
		$this->default_additional_settings = apply_filters(
			'alpha_dr_settings',
			array(
				'alpha_widget_duplex'          => 'false',
				'alpha_widget_duplex_type'     => 'text',
				'alpha_widget_duplex_text'     => '',
				'alpha_widget_duplex_image'    => array(
					'url' => '',
					'id'  => '',
				),

				// Ribbon
				'alpha_widget_ribbon'          => 'false',
				'alpha_widget_ribbon_type'     => 'type-1',
				'alpha_widget_ribbon_text'     => esc_html__( 'Ribbon', 'pandastore-core' ),
				'alpha_widget_ribbon_position' => 'top-left',
			)
		);
		parent::__construct( $data, $args );
		add_action( 'elementor/frontend/widget/before_render', array( $this, 'widget_before_render' ) );
		add_filter( 'elementor/widget/render_content', array( $this, 'add_html_widget_after_render' ), 10, 2 );
		/**
		 * Fires after alpha common elementor widget construct.
		 *
		 * @since 1.0
		 */
		do_action( 'alpha_common_elementor_widget_actions', $this );
	}

	protected function register_controls() {
		parent::register_controls();

		alpha_elementor_addon_controls( $this );
	}

	public function widget_before_render( $widget ) {
		$settings = $widget->get_settings_for_display();
		$widget->add_render_attribute(
			'_wrapper',
			alpha_get_additional_options( $settings )
		);
	}

	/**
	 * Html before widget render
	 *
	 * @since 1.0
	 */
	public function add_html_widget_after_render( $content, $widget ) {
		$data     = $widget->get_data();
		$settings = $data['settings'];
		$settings = wp_parse_args( $settings, $this->default_additional_settings );
		$settings = apply_filters( 'alpha_widget_advanced_effect', $settings, $widget );

		ob_start();

		if ( isset( $settings['alpha_widget_duplex'] ) && filter_var( $settings['alpha_widget_duplex'], FILTER_VALIDATE_BOOLEAN ) ) {
			switch ( $settings['alpha_widget_duplex_type'] ) {
				case 'text':
					if ( ! empty( $settings['alpha_widget_duplex_text'] ) ) {
						echo sprintf(
							'<div class="duplex-wrap">
										<span class="duplex duplex-text">%1$s</span>
									</div>',
							alpha_strip_script_tags( $settings['alpha_widget_duplex_text'] )
						);
					}
					break;

				case 'image':
					if ( ! empty( $settings['alpha_widget_duplex_image']['url'] ) ) {
						echo sprintf(
							'<div class="duplex-wrap">
										<div class="duplex duplex-image">
											<img src="%1$s" alt="">
										</div>
									</div>',
							esc_urL( $settings['alpha_widget_duplex_image']['url'] )
						);
					}
					break;
			}
		}

		// Ribbon
		if ( isset( $settings['alpha_widget_ribbon'] ) && filter_var( $settings['alpha_widget_ribbon'], FILTER_VALIDATE_BOOLEAN ) ) {
			if ( 'type-1' == $settings['alpha_widget_ribbon_type'] || 'type-2' == $settings['alpha_widget_ribbon_type'] || 'type-5' == $settings['alpha_widget_ribbon_type'] || 'type-6' == $settings['alpha_widget_ribbon_type'] ) {
					echo sprintf(
						'<div class="ribbon ribbon-%1$s ribbon-%2$s">
									<span class="ribbon-text">
										%3$s
									</span>
								</div>',
						esc_attr( $settings['alpha_widget_ribbon_type'] ),
						esc_attr( $settings['alpha_widget_ribbon_position'] ),
						$settings['alpha_widget_ribbon_text'] ? alpha_strip_script_tags( $settings['alpha_widget_ribbon_text'] ) : esc_html__( 'Ribbon', 'pandastore-core' )
					);
			} else {
				if ( isset( $settings['alpha_widget_ribbon_icon'] ) && $settings['alpha_widget_ribbon_icon'] && ! empty( $settings['alpha_widget_ribbon_icon']['value'] ) ) {
					echo sprintf(
						'<div class="ribbon ribbon-%1$s ribbon-%2$s">
									<div class="ribbon-icon %3$s">
									</div>
								</div>',
						esc_attr( $settings['alpha_widget_ribbon_type'] ),
						esc_attr( $settings['alpha_widget_ribbon_position'] ),
						esc_attr( $settings['alpha_widget_ribbon_icon']['value'] )
					);
				}
			}
		}

		$content = ob_get_clean() . $content;

		return $content;
	}
}
