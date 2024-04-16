<?php
/**
 * Extending header builder widgeet features
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

if ( ! class_exists( 'Alpha_Header_Builder_Extend' ) ) {
	class Alpha_Header_Builder_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Cart Widget
			add_action( "elementor/element/panda_header_cart/section_cart_content/after_section_end", array( $this, 'update_widget_cart_content_options' ) );
			add_action( "elementor/element/panda_header_cart/section_cart_style/after_section_end", array( $this, 'update_widget_cart_style_options' ) );
		}

		/**
		 * Update Cart Content
		 *
		 * @since 1.0
		 */
		public function update_widget_cart_content_options( $args ) {
			$args->update_control(
				'icon_type',
				array(
					'options' => array(
						'badge'   => esc_html__( 'Badge Type', 'pandastore-core' ),
						'label'   => esc_html__( 'Label Type', 'pandastore-core' ),
						'compact' => esc_html__( 'Compact Type', 'pandastore-core' )
					),
				)
			);
			$args->update_control(
				'icon',
				array(
					'condition' => array(
						'icon_type' => array( 'badge', 'compact' )
					),
				)
			);
		}

		/**
		 * Update Cart Style
		 *
		 * @since 1.0
		 */
		public function update_widget_cart_style_options( $args ) {
			$left  = is_rtl() ? 'right' : 'left';
			$right = 'left' == $left ? 'right' : 'left';
			$args->update_control(
				'cart_icon_heading',
				array(
					'condition' => array(
						'icon_type' => array( 'badge', 'compact' ),
					),
				)
			);

			$args->update_control(
				'cart_icon',
				array(
					'condition'  => array(
						'icon_type' => array( 'badge', 'compact' ),
					),
				)
			);

			$args->add_responsive_control(
				'cart_icon_space_2',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type .cart-label + i' => 'margin-bottom: {{SIZE}}px;',
						'.elementor-element-{{ID}} .compact-type.inline-type .cart-label' => "margin-{$left}: {{SIZE}}px;",
						'.elementor-element-{{ID}} .block-type .cart-toggle > i' => 'margin-bottom: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type .cart-toggle > p' => "margin-{$left}: {{SIZE}}px;",
					),
					'condition'  => array(
						'icon_type' => 'compact',
					),
				),
				array(
					'position' => array(
						'at' => 'after',
						'of' => 'cart_icon',
					),
				)
			);

		}
	}
}

new Alpha_Header_Builder_Extend;
