<?php
defined( 'ABSPATH' ) || die;

/**
 * Creative Grid Functions
 * Creative Grid Functions
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Alpha_Controls_Manager;

/**
 * Register elementor layout controls for creative grid.
 *
 * @since 1.0
 */

if ( ! function_exists( 'alpha_elementor_creative_layout_controls' ) ) {
	function alpha_elementor_creative_layout_controls( $self, $condition_key, $widget = '' ) {

		/**
		 * Using Isotope
		 */
		$self->add_control(
			'creative_mode',
			array(
				'label'     => esc_html__( 'Creative Layout', 'pandastore-core' ),
				'type'      => Alpha_Controls_Manager::IMAGE_CHOOSE,
				'default'   => 1,
				'options'   => alpha_creative_preset_imgs(),
				'condition' => array(
					$condition_key => 'creative',
				),
				'width'     => 3,
			)
		);

		$self->add_control(
			'creative_height',
			array(
				'label'     => esc_html__( 'Change Grid Height', 'pandastore-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 600,
				),
				'range'     => array(
					'px' => array(
						'step' => 5,
						'min'  => 100,
						'max'  => 1000,
					),
				),
				'condition' => array(
					$condition_key => 'creative',
				),
			)
		);

		$self->add_control(
			'creative_height_ratio',
			array(
				'label'     => esc_html__( 'Grid Mobile Height (%)', 'pandastore-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 75,
				),
				'range'     => array(
					'%' => array(
						'step' => 1,
						'min'  => 30,
						'max'  => 100,
					),
				),
				'condition' => array(
					$condition_key => 'creative',
				),
			)
		);

		$self->add_control(
			'creative_col_sp',
			array(
				'label'     => esc_html__( 'Columns Spacing', 'pandastore-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => apply_filters( 'alpha_col_default', 'md' ),
				'options'   => apply_filters(
					'alpha_col_sp',
					array(
						'no' => esc_html__( 'No space', 'pandastore-core' ),
						'xs' => esc_html__( 'Extra Small', 'pandastore-core' ),
						'sm' => esc_html__( 'Small', 'pandastore-core' ),
						'md' => esc_html__( 'Medium', 'pandastore-core' ),
						'lg' => esc_html__( 'Large', 'pandastore-core' ),
					),
					'elementor'
				),
				'condition' => array(
					$condition_key => 'creative',
				),
			)
		);

		$self->add_control(
			'grid_float',
			array(
				'label'       => esc_html__( 'Use Float Grid', 'pandastore-core' ),
				'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					$condition_key => 'creative',
				),
			)
		);
	}
}
