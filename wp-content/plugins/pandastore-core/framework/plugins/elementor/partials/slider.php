<?php
/**
 * Slider Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register elementor layout controls for slider.
 *
 * @since 1.0
 */

function alpha_elementor_slider_layout_controls( $self, $condition_key ) {

	$self->add_control(
		'slider_vertical_align',
		array(
			'label'       => esc_html__( 'Vertical Align', 'pandastore-core' ),
			'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'pandastore-core' ),
			'type'        => Controls_Manager::CHOOSE,
			'options'     => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-top',
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-middle',
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-bottom',
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-stretch',
				),
			),
			'condition'   => array(
				$condition_key => 'slider',
			),
		)
	);
}

/**
 * Register elementor style controls for slider.
 *
 * @since 1.0
 */

function alpha_elementor_slider_style_controls( $self, $condition_key = '' ) {
	$left  = is_rtl() ? 'right' : 'left';
	$right = is_rtl() ? 'left' : 'right';

	if ( empty( $condition_key ) ) {
		$self->start_controls_section(
			'slider_style',
			array(
				'label' => esc_html__( 'Slider', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
	} else {
		$self->start_controls_section(
			'slider_style',
			array(
				'label'     => esc_html__( 'Slider', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					$condition_key => 'slider',
				),
			)
		);
	}
		$self->add_control(
			'style_heading_slider_options',
			array(
				'label' => esc_html__( 'Options', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'loop',
			array(
				'label'       => esc_html__( 'Enable Loop', 'pandastore-core' ),
				'description' => esc_html__( 'Makes slides of slider play sliding infinitely.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
			)
		);

		// $self->add_control(
		// 	'fullheight',
		// 	array(
		// 		'type'  => Controls_Manager::SWITCHER,
		// 		'label' => esc_html__( 'Full Height', 'pandastore-core' ),
		// 	)
		// );

		$self->add_control(
			'autoplay',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Autoplay', 'pandastore-core' ),
				'description' => esc_html__( 'Enables each slides play sliding automatically.', 'pandastore-core' ),
				'condition'   => array(
					'loop' => 'yes',
				),
			)
		);

		$self->add_control(
			'autoplay_timeout',
			array(
				'type'        => Controls_Manager::NUMBER,
				'label'       => esc_html__( 'Autoplay Timeout', 'pandastore-core' ),
				'description' => esc_html__( 'Controls how long each slides should be shown.', 'pandastore-core' ),
				'default'     => 5000,
				'condition'   => array(
					'autoplay' => 'yes',
					'loop'     => 'yes',
				),
			)
		);

		$self->add_control(
			'autoheight',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Height', 'pandastore-core' ),
				'description' => esc_html__( 'Makes each slides have their own height. Slides could have different height.', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'style_heading_nav',
			array(
				'label'     => esc_html__( 'Navs', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'show_nav',
			array(
				'label'       => esc_html__( 'Nav', 'pandastore-core' ),
				'description' => esc_html__( 'Determine whether to show/hide slider navigations.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
			)
		);

		$self->add_control(
			'nav_hide',
			array(
				'label'       => esc_html__( 'Nav Auto Hide', 'pandastore-core' ),
				'description' => esc_html__( 'Hides slider navs automatically and show them only if mouse is over.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'condition'   => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_type',
			array(
				'label'       => esc_html__( 'Nav Type', 'pandastore-core' ),
				'description' => esc_html__( 'Choose from icon presets of slider nav. Choose from Simple, Circle, Full.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'simple',
				'options'     => array(
					'simple' => esc_html__( 'Simple', 'pandastore-core' ),
					'circle' => esc_html__( 'Circle', 'pandastore-core' ),
					'full'   => esc_html__( 'Full', 'pandastore-core' ),
				),
				'condition'   => array(
					'show_nav' => 'yes',
				),
			)
		);

	if ( 'section' == $self->get_name() ) {
		$self->add_control(
			'nav_pos',
			array(
				'label'       => esc_html__( 'Nav Position', 'pandastore-core' ),
				'description' => esc_html__( 'Choose position of slider navs. Choose from Inner, Bottom.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'inner',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'pandastore-core' ),
					'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
				),
				'condition'   => array(
					'nav_type!' => 'full',
					'show_nav'  => 'yes',
				),
			)
		);
	} else {
		$self->add_control(
			'nav_pos',
			array(
				'label'       => esc_html__( 'Nav Position', 'pandastore-core' ),
				'description' => esc_html__( 'Choose position of slider navs. Choose from Inner, Outer, Top, Bottom.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'pandastore-core' ),
					''       => esc_html__( 'Outer', 'pandastore-core' ),
					'top'    => esc_html__( 'Top', 'pandastore-core' ),
					'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
				),
				'condition'   => array(
					'nav_type!' => 'full',
					'show_nav'  => 'yes',
				),
			)
		);
	}

		$self->add_responsive_control(
			'nav_h_position',
			array(
				'label'       => esc_html__( 'Nav Horizontal Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider navs.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .slider-button-prev' => ( is_rtl() ? 'right' : 'left' ) . ': {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .slider-button-next' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'nav_pos!' => array( 'top', 'bottom' ),
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'nav_top_h_position',
			array(
				'label'       => esc_html__( 'Nav Horizontal Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider navs.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-button' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'nav_pos'  => array( 'top', 'bottom' ),
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position_top',
			array(
				'label'       => esc_html__( 'Nav Vertical Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls vertical position of slider navs.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-button' => 'top: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'nav_pos'  => 'top',
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position_bottom',
			array(
				'label'       => esc_html__( 'Nav Vertical Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls vertical position of slider navs.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-button' => 'bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'nav_pos'  => 'bottom',
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position',
			array(
				'label'       => esc_html__( 'Nav Vertical Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls vertical position of slider navs.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-button' => 'top: {{SIZE}}{{UNIT}}; transform: none;',
				),
				'condition'   => array(
					'nav_pos!' => array( 'top', 'bottom' ),
					'show_nav' => 'yes',
				),
			)
		);
		$self->add_responsive_control(
			'slider_nav_size',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Nav Size', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the nav size.', 'pandastore-core' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 10,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-button' => 'font-size: {{SIZE}}px',
				),
				'condition'   => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->start_controls_tabs(
			'tabs_nav_style',
			array(
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->start_controls_tab(
			'tab_nav_normal',
			array(
				'label'     => esc_html__( 'Normal', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'nav_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'nav_box_shadow',
				'selector'  => '.elementor-element-{{ID}} .slider-button',
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_hover',
			array(
				'label'     => esc_html__( 'Hover', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'nav_color_hover',
			array(
				'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_back_color_hover',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_border_color_hover',
			array(
				'label'     => esc_html__( 'Hover Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'nav_box_shadow_hover',
				'label'     => esc_html__( 'Hover Box Shadow', 'pandastore-core' ),
				'selector'  => '.elementor-element-{{ID}} .slider-button:not(.disabled):hover',
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_disabled',
			array(
				'label'     => esc_html__( 'Disabled', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'nav_color_disabled',
			array(
				'label'     => esc_html__( 'Disabled Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_back_color_disabled',
			array(
				'label'     => esc_html__( 'Disabled Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_control(
			'nav_border_color_disabled',
			array(
				'label'     => esc_html__( 'Disabled Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'nav_box_shadow_disabled',
				'label'     => esc_html__( 'Disabled Box Shadow', 'pandastore-core' ),
				'selector'  => '.elementor-element-{{ID}} .slider-button.disabled',
				'condition' => array(
					'show_nav' => 'yes',
				),
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_dot',
			array(
				'label'     => esc_html__( 'Dots', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

	$show_dots_options = array(
		'label'       => esc_html__( 'Dots', 'pandastore-core' ),
		'description' => esc_html__( 'Determine whether to show/hide slider dots.', 'pandastore-core' ),
		'type'        => Controls_Manager::SWITCHER,
	);
	// if ( 'use_as' == $condition_key ) {
	// 	$show_dots_options['condition'] = array(
	// 		'dots_type!' => 'thumb',
	// 	);
	// }
	$self->add_control( 'show_dots', $show_dots_options );

	$dot_default = array(
		'show_dots' => 'yes',
	);
	if ( 'use_as' == $condition_key ) {
		$self->add_control(
			'dots_type',
			array(
				'label'       => esc_html__( 'Dots Type', 'pandastore-core' ),
				'description' => esc_html__( 'Choose what you are going to use for slider dots. Choose from Dots, Images.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'pandastore-core' ),
					'thumb' => esc_html__( 'Thumbnail', 'pandastore-core' ),
				),
				'condition'   => array(
					'show_dots' => 'yes',
				),
			)
		);

		$self->add_control(
			'thumbs',
			array(
				'label'       => esc_html__( 'Add Thumbnails', 'pandastore-core' ),
				'description' => esc_html__( 'Choose thumbnail images which represent each slides.', 'pandastore-core' ),
				'type'        => Controls_Manager::GALLERY,
				'default'     => array(),
				'show_label'  => false,
				'condition'   => array(
					'dots_type' => 'thumb',
					'show_dots' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'dots_thumb_spacing',
			array(
				'label'      => esc_html__( 'Dots Spacing', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'condition'  => array(
					'dots_type' => 'thumb',
					'show_dots' => 'yes',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-thumb-dots .slider-pagination-bullet' => "margin-{$right}: {{SIZE}}{{UNIT}};",
				),
			)
		);

		$dot_default = array(
			'dots_type' => '',
			'show_dots' => 'yes',
		);
	}

		$self->add_control(
			'dots_skin',
			array(
				'label'       => esc_html__( 'Dots Skin', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the dots skin.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'pandastore-core' ),
					'white' => esc_html__( 'White', 'pandastore-core' ),
					'grey'  => esc_html__( 'Grey', 'pandastore-core' ),
					'dark'  => esc_html__( 'Dark', 'pandastore-core' ),
				),
				'condition'   => $dot_default,
			)
		);

	if ( 'section' == $self->get_name() ) {
		$self->add_control(
			'dots_pos',
			array(
				'label'       => esc_html__( 'Dots Position', 'pandastore-core' ),
				'description' => esc_html__( 'Choose position of slider dots and image dots.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'inner',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'pandastore-core' ),
					'custom' => esc_html__( 'Custom', 'pandastore-core' ),
				),
				'condition'   => array(
					'show_dots' => 'yes',
				),
			)
		);
	} else {
		$self->add_control(
			'dots_pos',
			array(
				'label'       => esc_html__( 'Dots Position', 'pandastore-core' ),
				'description' => esc_html__( 'Choose position of slider dots and image dots.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'pandastore-core' ),
					''       => esc_html__( 'Close', 'pandastore-core' ),
					'outer'  => esc_html__( 'Outer', 'pandastore-core' ),
					'custom' => esc_html__( 'Custom', 'pandastore-core' ),
				),
				'condition'   => array(
					'show_dots' => 'yes',
				),
			)
		);
	}

		$self->add_responsive_control(
			'dots_h_position',
			array(
				'label'      => esc_html__( 'Dot Vertical Position', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-pagination' => 'display: flex; position: absolute; bottom: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .slider-thumb-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'dots_pos'  => 'custom',
					'show_dots' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'dots_v_position',
			array(
				'label'      => esc_html__( 'Dot Horizontal Position', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '50',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-pagination' => 'display: flex; position: absolute; left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
					'.elementor-element-{{ID}} .slider-thumb-dots' => "margin-{$left}: {{SIZE}}{{UNIT}};",
				),
				'condition'  => array(
					'dots_pos'  => 'custom',
					'show_dots' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'slider_dots_size',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Dots Size', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the size of slider dots.', 'pandastore-core' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 5,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'width: calc({{SIZE}}{{UNIT}} * 2.25); height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-thumb-dots .slider-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-pagination ~ .slider-thumb-dots' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
				),
				'condition'   => array(
					'show_dots' => 'yes',
				),
			)
		);

		$self->start_controls_tabs(
			'tabs_dot_style',
			array(
				'condition' => $dot_default,
			)
		);

		$self->start_controls_tab(
			'tab_dot_normal',
			array(
				'label'     => esc_html__( 'Normal', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'dot_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow',
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_hover',
			array(
				'label'     => esc_html__( 'Hover', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'dot_back_color_hover',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_hover',
			array(
				'label'     => esc_html__( 'Hover Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow_hover',
				'label'     => esc_html__( 'Hover Box Shadow', 'pandastore-core' ),
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_active',
			array(
				'label'     => esc_html__( 'Active', 'pandastore-core' ),
			)
		);

		$self->add_control(
			'dot_back_color_active',
			array(
				'label'     => esc_html__( 'Active Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_active',
			array(
				'label'     => esc_html__( 'Active Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow_active',
				'label'     => esc_html__( 'Active Box Shadow', 'pandastore-core' ),
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

	$self->end_controls_section();
}

/**
 * Elementor content-template for slider.
 *
 * @since 1.0
 */
function alpha_elementor_slider_template() {

	wp_enqueue_script( 'swiper' );
	?>
	var breakpoints = <?php echo json_encode( alpha_get_breakpoints() ); ?>;
	var extra_options = {};

	extra_class += ' slider-wrapper';

	// Layout
	if ( 'lg' == settings.col_sp || 'xs' == settings.col_sp || 'sm' == settings.col_sp || 'no' == settings.col_sp ) {
		extra_class += ' gutter-' + settings.col_sp;
	}

	var col_cnt = 'function' == typeof alpha_get_responsive_cols ? alpha_get_responsive_cols({
		xl: settings.col_cnt_xl,
		lg: settings.col_cnt,
		md: settings.col_cnt_tablet,
		sm: settings.col_cnt_mobile,
		min: settings.col_cnt_min,
	}) : {
		xl: settings.col_cnt_xl,
		lg: settings.col_cnt,
		md: settings.col_cnt_tablet,
		sm: settings.col_cnt_mobile,
		min: settings.col_cnt_min,
	};
	extra_class += ' ' + alpha_get_col_class( col_cnt );

	// Nav & Dot

	var statusClass = '';

	if ( 'full' == settings.nav_type ) {
		statusClass += ' slider-nav-full';
	} else {
		if ( 'circle' == settings.nav_type ) {
			statusClass += ' slider-nav-circle';
		}
		if ( 'top' == settings.nav_pos ) {
			statusClass += ' slider-nav-top';
		} else if ( 'bottom' == settings.nav_pos ) {
			statusClass += ' slider-nav-bottom';
		} else if ( 'inner' != settings.nav_pos ) {
			statusClass += ' slider-nav-outer';
		}
	}
	if ( 'yes' == settings.nav_hide ) {
		statusClass += ' slider-nav-fade';
	}
	if ( settings.dots_skin ) {
		statusClass += ' slider-dots-' + settings.dots_skin;
	}
	if ( 'inner' == settings.dots_pos ) {
		statusClass += ' slider-dots-inner';
	}
	if ( 'outer' == settings.dots_pos ) {
		statusClass += ' slider-dots-outer';
	}
	if ( 'yes' == settings.fullheight ) {
		statusClass += ' slider-full-height';
	}
	if ( 'yes' == settings.box_shadow_slider ) {
		statusClass += ' slider-shadow';
	}

	if ( 'top' == settings.slider_vertical_align ||
		'middle' == settings.slider_vertical_align ||
		'bottom' == settings.slider_vertical_align ||
		'same-height' == settings.slider_vertical_align ) {
		statusClass += ' slider-' + settings.slider_vertical_align;
	}

	extra_options['navigation'] = 'yes' == settings.show_nav;
	extra_options['pagination'] = 'yes' == settings.show_dots;
	if ( 'no' !== settings.col_sp ) {
		if ( 'sm' == settings.col_sp ) {
			extra_options['spaceBetween'] = 10;
		}
		else if ( 'lg' == settings.col_sp ) {
			extra_options['spaceBetween'] = 30;
		}
		else if ( 'xs' == settings.col_sp ) {
			extra_options['spaceBetween'] = 2;
		}
		else {
			extra_options['spaceBetween'] = 20;
		}
	}
	extra_options['spaceBetween'] = elementorFrontend.hooks.applyFilters('alpha_slider_gap', extra_options['spaceBetween'], settings.col_sp);
	if ( 'yes' == settings.autoplay ) {
		extra_options['autoplay'] = true;
		extra_options['autoplayHoverPause'] = true;
		extra_options['loop'] = true;
	}
	if ( 5000 != settings.autoplay_timeout ) {
		extra_options['autoplayTimeout'] = settings.autoplay_timeout;
	}
	if ( 'yes' == settings.autoheight) {
		extra_options['autoHeight'] = true;
	}
	if ( 'yes' == settings.autoheight) {
		extra_options['autoHeight'] = true;
	}

	if ( 'thumb' == settings.dots_type ) {
		extra_options['dotsContainer'] = '.slider-thumb-dots-' + view.getID();
	}

	var responsive = {};
	for ( var w in col_cnt ) {
		responsive[ breakpoints[ w ] ] = {
			slidesPerView: col_cnt[w]
		}
	}
	extra_options['statusClass'] = statusClass;

	if ( col_cnt.xl ) {
		extra_options['slidesPerView'] = col_cnt.xl;
	} else if ( col_cnt.lg ) {
		extra_options['slidesPerView'] = col_cnt.lg;
	}
	extra_options.breakpoints = responsive;

	extra_attrs += ' data-slider-options="' + JSON.stringify( extra_options ).replaceAll('"', '\'') + '"';
	<?php
}