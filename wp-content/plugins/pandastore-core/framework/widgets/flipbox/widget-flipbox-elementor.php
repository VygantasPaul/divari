<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Flipbox Widget
 *
 * Alpha Widget to display flipbox.
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Alpha_Controls_Manager;
use Elementor\Group_Control_Background;

class Alpha_Flipbox_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_flipbox';
	}

	public function get_title() {
		return esc_html__( 'Flipbox', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-flipbox';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}


	public function get_script_depends() {
		wp_register_script( 'alpha-flipbox', alpha_core_framework_uri( '/widgets/flipbox/flipbox' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-flipbox' );
	}

	public function get_keywords() {
		return array( 'flipbox' );
	}

	protected function _register_controls() {

		// Start Front Side Content
		$this->start_controls_section(
			'section_front_side_content',
			array(
				'label' => esc_html__( 'Front Side Content', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'front_side_icon',
				array(
					'label'   => esc_html__( 'Choose Icon', 'pandastore-core' ),
					'type'    => Controls_Manager::ICONS,
					// 'skin'                   => 'inline',
					// 'exclude_inline_options' => [ 'svg' ],
					// 'label_block'            => false,
					'default' => array(
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					),
				)
			);

			$this->add_control(
				'front_side_title',
				array(
					'label'   => esc_html__( 'Title', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Title', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'front_side_subtitle',
				array(
					'label'   => esc_html__( 'Subtitle', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Subtitle', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'front_side_content',
				array(
					'label'   => esc_html__( 'Content', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Add some contents here', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'front_side_button_text',
				array(
					'label'   => esc_html__( 'Button text', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'View More', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'front_side_button_link',
				array(
					'label'       => esc_html__( 'Button Link', 'pandastore-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => 'http://your-link.com',
					'default'     => array(
						'url' => '#',
					),
					'dynamic'     => array( 'active' => true ),
				)
			);

			$this->add_control(
				'front_side_align',
				array(
					'label'   => esc_html__( 'Alignment', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'default' => 'center',
				)
			);
		$this->end_controls_section();

		// Start Back-Side content
		$this->start_controls_section(
			'section_back_side_content',
			array(
				'label' => esc_html__( 'Back Side Content', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'back_side_icon',
				array(
					'label'   => esc_html__( 'Choose Icon', 'pandastore-core' ),
					'type'    => Controls_Manager::ICONS,
					// 'skin'                   => 'inline',
					// 'exclude_inline_options' => [ 'svg' ],
					// 'label_block'            => false,
					'default' => array(
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					),
				)
			);

			$this->add_control(
				'back_side_title',
				array(
					'label'   => esc_html__( 'Title', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Title', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'back_side_subtitle',
				array(
					'label'   => esc_html__( 'Subtitle', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Subtitle', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'back_side_content',
				array(
					'label'   => esc_html__( 'Content', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Add some contents here', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'back_side_button_text',
				array(
					'label'   => esc_html__( 'Button text', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'View More', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'back_side_button_link',
				array(
					'label'       => esc_html__( 'Button Link', 'pandastore-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => 'http://your-link.com',
					'default'     => array(
						'url' => '#',
					),
					'dynamic'     => array( 'active' => true ),
				)
			);

			$this->add_control(
				'back_side_align',
				array(
					'label'   => esc_html__( 'Alignment', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'default' => 'center',
				)
			);
		$this->end_controls_section();

		// Add Flipbox Settings Controls Section
		$this->start_controls_section(
			'section_flipbox_settings',
			array(
				'label' => esc_html__( 'Flipbox Settings', 'pandastore-core' ),
			)
		);

			$this->add_responsive_control(
				'flipbox_max_height',
				array(
					'label'      => esc_html__( 'Max Height', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem', 'vh' ),
					'range'      => array(
						'px'  => array(
							'min' => 100,
							'max' => 1000,
						),
						'rem' => array(
							'min' => 1,
							'max' => 50,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .flipbox' => 'max-height: {{SIZE}}{{UNIT}};',
						// '{{WRAPPER}} .flipbox .flipbox_back' => 'min-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'flipbox_min_height',
				array(
					'label'      => esc_html__( 'Min Height', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem', 'vh' ),
					'range'      => array(
						'px'  => array(
							'min' => 100,
							'max' => 1000,
						),
						'rem' => array(
							'min' => 1,
							'max' => 50,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .flipbox' => 'min-height: {{SIZE}}{{UNIT}};',
						// '{{WRAPPER}} .flipbox .flipbox_back' => 'min-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'flipbox_animation_effect',
				array(
					'label'   => esc_html__( 'Animation Effect', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'fb-flip-horizontal',
					'groups'  => array(
						'pull'  => array(
							'label'   => esc_html__( 'Pull', 'pandastore-core' ),
							'options' => array(
								'fb-pull-left'  => esc_html__( 'Pull Left', 'pandastore-core' ),
								'fb-pull-up'    => esc_html__( 'Pull Up', 'pandastore-core' ),
								'fb-pull-right' => esc_html__( 'Pull Right', 'pandastore-core' ),
								'fb-pull-down'  => esc_html__( 'Pull Down', 'pandastore-core' ),
							),
						),
						'slide' => array(
							'label'   => esc_html__( 'Slide', 'pandastore-core' ),
							'options' => array(
								'fb-slide-left'   => esc_html__( 'Slide Left', 'pandastore-core' ),
								'fb-slide-top'    => esc_html__( 'Slide Top', 'pandastore-core' ),
								'fb-slide-right'  => esc_html__( 'Slide Right', 'pandastore-core' ),
								'fb-slide-bottom' => esc_html__( 'Slide Bottom', 'pandastore-core' ),
							),
						),
						'fall'  => array(
							'label'   => esc_html__( 'Fall', 'pandastore-core' ),
							'options' => array(
								'fb-fall-horizontal fb-fall-left' => esc_html__( 'Fall Left', 'pandastore-core' ),
								'fb-fall-vertical fb-fall-up'   => esc_html__( 'Fall Up', 'pandastore-core' ),
								'fb-fall-horizontal fb-fall-right' => esc_html__( 'Fall Right', 'pandastore-core' ),
								'fb-fall-vertical fb-fall-down' => esc_html__( 'Fall Down', 'pandastore-core' ),
							),
						),
						'flip'  => array(
							'label'   => esc_html__( 'Flip', 'pandastore-core' ),
							'options' => array(
								'fb-flip-horizontal' => esc_html__( 'Flip Horizontal', 'pandastore-core' ),
								'fb-flip-vertical'   => esc_html__( 'Flip Vertical', 'pandastore-core' ),
							),
						),
					),
				)
			);
		$this->end_controls_section();

		// Add Flipbox Styles Tab
		$this->start_controls_section(
			'section_flipbox_layout_style',
			array(
				'label' => esc_html__( 'Layout', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'layout_style_tabs' );

				$this->start_controls_tab(
					'tab_front_layout_styles',
					array(
						'label' => esc_html__( 'Front', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'front_vertical_alignment',
						array(
							'label'     => esc_html__( 'Content Alignment', 'pandastore-core' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => esc_html__( 'Top', 'pandastore-core' ),
								'center'     => esc_html__( 'Center', 'pandastore-core' ),
								'flex-end'   => esc_html__( 'Bottom', 'pandastore-core' ),
							),
							'selectors' => array(
								'{{WRAPPER}} .flipbox .flipbox_front' => 'justify-content: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						array(
							'name'     => 'front_side_background',
							'selector' => '{{WRAPPER}} .flipbox .flipbox_front',
						)
					);

					$this->add_responsive_control(
						'front_side_padding',
						array(
							'label'      => esc_html__( 'Padding', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .flipbox .flipbox_front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'front_side_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .flipbox .flipbox_front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_back_layout_styles',
					array(
						'label' => esc_html__( 'Back', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'back_vertical_alignment',
						array(
							'label'     => esc_html__( 'Content Alignment', 'pandastore-core' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => esc_html__( 'Top', 'pandastore-core' ),
								'center'     => esc_html__( 'Center', 'pandastore-core' ),
								'flex-end'   => esc_html__( 'Bottom', 'pandastore-core' ),
							),
							'selectors' => array(
								'{{WRAPPER}} .flipbox .flipbox_back' => 'justify-content: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						array(
							'name'     => 'back_side_background',
							'selector' => '{{WRAPPER}} .flipbox .flipbox_back',
						)
					);

					$this->add_responsive_control(
						'back_side_padding',
						array(
							'label'      => esc_html__( 'Padding', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .flipbox .flipbox_back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'back_side_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .flipbox .flipbox_back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_flipbox_icon_style',
			array(
				'label' => esc_html__( 'Icon', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'icon_styles_tab' );

				$this->start_controls_tab(
					'tab_front_icon_style',
					array(
						'label' => esc_html__( 'Front', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'front_icon_type',
						array(
							'label'   => esc_html__( 'Icon View', 'pandastore-core' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'default',
							'options' => array(
								'default' => esc_html__( 'Default', 'pandastore-core' ),
								'stacked' => esc_html__( 'Stacked', 'pandastore-core' ),
								'framed'  => esc_html__( 'Framed', 'pandastore-core' ),
							),
						)
					);

					$this->add_control(
						'front_icon_shape',
						array(
							'label'   => esc_html__( 'Shape', 'pandastore-core' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'circle',
							'options' => array(
								'circle' => esc_html__( 'Circle', 'pandastore-core' ),
								''       => esc_html__( 'Square', 'pandastore-core' ),
							),
						)
					);

					$this->add_control(
						'front_icon_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon.stacked' => 'background-color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon.framed' => 'border-color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon.framed' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon.default' => 'color: {{VALUE}};',
							),
							'condition' => array(
								'front_side_icon[library]!' => 'svg',
							),
						)
					);

					$this->add_control(
						'front_icon_svg_stroke',
						array(
							'label'     => esc_html__( 'Stroke Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon svg' => 'stroke: {{VALUE}};',
							),
							'condition' => array(
								'front_side_icon[library]' => 'svg',
							),
						)
					);

					$this->add_control(
						'front_icon_svg_fill',
						array(
							'label'     => esc_html__( 'Fill Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon svg' => 'fill: {{VALUE}};',
							),
							'condition' => array(
								'front_side_icon[library]' => 'svg',
							),
						)
					);

					$this->add_responsive_control(
						'front_icon_size',
						array(
							'label'     => esc_html__( 'Size', 'pandastore-core' ),
							'type'      => Controls_Manager::SLIDER,
							'range'     => array(
								'px' => array(
									'min' => 6,
									'max' => 300,
								),
							),
							'default'   => array(
								'size' => 60,
								'unit' => 'px',
							),
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}}' => '--alpha-flipbox-front-icon-size: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$this->add_control(
						'front_icon_padding',
						array(
							'label'     => esc_html__( 'Padding', 'pandastore-core' ),
							'type'      => Controls_Manager::SLIDER,
							'selectors' => array(
								'{{WRAPPER}}' => '--alpha-flipbox-front-icon-padding: {{SIZE}}{{UNIT}};',
							),
							'range'     => array(
								'em' => array(
									'min' => 0,
									'max' => 5,
								),
							),
						)
					);

					$this->add_control(
						'front_icon_border_width',
						array(
							'label'     => esc_html__( 'Border Width', 'pandastore-core' ),
							'type'      => Controls_Manager::DIMENSIONS,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array(
								'front_icon_type' => 'framed',
							),
						)
					);

					$this->add_control(
						'front_icon_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'front_icon_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%', 'rem' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_back_icon_style',
					array(
						'label' => esc_html__( 'Back', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'back_icon_type',
						array(
							'label'   => esc_html__( 'Icon View', 'pandastore-core' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'default',
							'options' => array(
								'default' => esc_html__( 'Default', 'pandastore-core' ),
								'stacked' => esc_html__( 'Stacked', 'pandastore-core' ),
								'framed'  => esc_html__( 'Framed', 'pandastore-core' ),
							),
						)
					);

					$this->add_control(
						'back_icon_shape',
						array(
							'label'   => esc_html__( 'Shape', 'pandastore-core' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'circle',
							'options' => array(
								'circle' => esc_html__( 'Circle', 'pandastore-core' ),
								''       => esc_html__( 'Square', 'pandastore-core' ),
							),
						)
					);

					$this->add_control(
						'back_icon_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon.stacked' => 'background-color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon.framed' => 'border-color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon.framed' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon.default' => 'color: {{VALUE}};',
							),
							'condition' => array(
								'back_side_icon[library]!' => 'svg',
							),
						)
					);

					$this->add_control(
						'back_icon_svg_stroke',
						array(
							'label'     => esc_html__( 'Stroke Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon svg' => 'stroke: {{VALUE}};',
							),
							'condition' => array(
								'back_side_icon[library]' => 'svg',
							),
						)
					);

					$this->add_control(
						'back_icon_svg_fill',
						array(
							'label'     => esc_html__( 'Fill Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon svg' => 'fill: {{VALUE}};',
							),
							'condition' => array(
								'back_side_icon[library]' => 'svg',
							),
						)
					);

					$this->add_responsive_control(
						'back_icon_size',
						array(
							'label'     => esc_html__( 'Size', 'pandastore-core' ),
							'type'      => Controls_Manager::SLIDER,
							'range'     => array(
								'px' => array(
									'min' => 6,
									'max' => 300,
								),
							),
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}}' => '--alpha-flipbox-back-icon-size: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$this->add_control(
						'back_icon_padding',
						array(
							'label'     => esc_html__( 'Padding', 'pandastore-core' ),
							'type'      => Controls_Manager::SLIDER,
							'selectors' => array(
								'{{WRAPPER}}' => '--alpha-flipbox-back-icon-padding: {{SIZE}}{{UNIT}};',
							),
							'range'     => array(
								'em' => array(
									'min' => 0,
									'max' => 5,
								),
							),
						)
					);

					$this->add_control(
						'back_icon_border_width',
						array(
							'label'     => esc_html__( 'Border Width', 'pandastore-core' ),
							'type'      => Controls_Manager::DIMENSIONS,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array(
								'back_icon_type' => 'framed',
							),
						)
					);

					$this->add_control(
						'back_icon_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'back_icon_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%', 'rem' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// Title Style Section
		$this->start_controls_section(
			'section_flipbox_title_style',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'title_styles_tab' );

				$this->start_controls_tab(
					'tab_front_title_style',
					array(
						'label' => esc_html__( 'Front', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'front_title_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-title' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'title_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_front .flipbox-title',
						)
					);

					$this->add_responsive_control(
						'front_title_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_back_title_style',
					array(
						'label' => esc_html__( 'Back', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'back_title_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-title' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'title_back_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_back .flipbox-title',
						)
					);

					$this->add_responsive_control(
						'back_title_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// Subtitle Style Section
		$this->start_controls_section(
			'section_flipbox_subtitle_style',
			array(
				'label' => esc_html__( 'Subtitle', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'subtitle_styles_tab' );

				$this->start_controls_tab(
					'tab_front_subtitle_style',
					array(
						'label' => esc_html__( 'Front', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'front_subtitle_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-subtitle' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'subtitle_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_front .flipbox-subtitle',
						)
					);

					$this->add_responsive_control(
						'front_subtitle_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_back_subtitle_style',
					array(
						'label' => esc_html__( 'Back', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'back_subtitle_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-subtitle' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'subtitle_back_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_back .flipbox-subtitle',
						)
					);

					$this->add_responsive_control(
						'back_subtitle_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// Description Style Section
		$this->start_controls_section(
			'section_flipbox_description_style',
			array(
				'label' => esc_html__( 'Description', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'description_styles_tab' );

				$this->start_controls_tab(
					'tab_front_description_style',
					array(
						'label' => esc_html__( 'Front', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'front_description_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-description' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'description_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_front .flipbox-description',
						)
					);

					$this->add_responsive_control(
						'front_description_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_front .flipbox-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_back_description_style',
					array(
						'label' => esc_html__( 'Back', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'back_description_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-description' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'description_back_typography',
							'selector' => '.elementor-element-{{ID}} .flipbox_back .flipbox-description',
						)
					);

					$this->add_responsive_control(
						'back_description_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', 'rem', '%' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .flipbox_back .flipbox-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// Button Style Section
		$this->start_controls_section(
			'section_flipbox_button_style',
			array(
				'label' => esc_html__( 'View More Button', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'button_style_tabs' );

			$this->start_controls_tab(
				'tab_front_button_styles',
				array(
					'label' => esc_html__( 'Front', 'pandastore-core' ),
				)
			);

				alpha_elementor_button_layout_controls( $this, '', 'yes', 'front_' );

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_back_button_styles',
				array(
					'label' => esc_html__( 'Back', 'pandastore-core' ),
				)
			);

				alpha_elementor_button_layout_controls( $this, '', 'yes', 'back_' );

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;

		$this->add_inline_editing_attributes( 'front_side_title' );
		$this->add_inline_editing_attributes( 'front_side_subtitle' );
		$this->add_inline_editing_attributes( 'front_side_content' );
		$this->add_inline_editing_attributes( 'front_side_button_text' );
		$this->add_inline_editing_attributes( 'back_side_title' );
		$this->add_inline_editing_attributes( 'back_side_subtitle' );
		$this->add_inline_editing_attributes( 'back_side_content' );
		$this->add_inline_editing_attributes( 'back_side_button_text' );
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/flipbox/render-flipbox-elementor.php' );
	}

	public function before_render() {
		$atts = $this->get_settings_for_display();
		?>
		<div <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php
	}

	protected function content_template() {
		$widget_id = $this->get_id();
		?>
		<#
		let flipbox_class = ['flipbox'],
			html = '';

		if ( settings.flipbox_animation_effect ) {
			flipbox_class.push( settings.flipbox_animation_effect.split( '-' )[1] );
			flipbox_class.push( settings.flipbox_animation_effect );
		}

		html += '<div class="' + flipbox_class.join(' ') + '" data-flipbox-settings="{effect: ' + settings.flipbox_animation_effect + '}">';

		// Font Side Content
		html += '<div class="flipbox_front ' + settings.front_side_align + '-align">';
			html += render_flipbox_content( 'front' );
		html += '</div>';

		// Back Side content
		html += '<div class="flipbox_back ' + settings.back_side_align + '-align">';
			html += render_flipbox_content( 'back' );
		html += '</div>';

		html += '</div>';

		print( html );


		/**
		 * Render flipbox Front and Back side content
		 */
		function render_flipbox_content( mode = 'front' ) {
			let content_str = '',
				btn_class = 'btn',
				btn_label = '',
				icon_html = elementor.helpers.renderIcon( view, settings[ mode + '_side_icon' ], { 'aria-hidden': true }, 'i' , 'object' );

			<?php
				alpha_elementor_button_template();
			?>

			btn_class += ' ' + alpha_widget_button_get_class( settings, mode + '_' ).join( ' ' );
			btn_label = alpha_widget_button_get_label( settings, view, settings[ mode + '_side_button_text' ], 'label', mode + '_' );

			// Icon
			let icon_wrap_class = ['flipbox-icon'];

			if ( settings[ mode + '_icon_type' ] ) {
				icon_wrap_class.push( settings[ mode + '_icon_type' ]);
			}

			if ( settings[ mode + '_icon_shape' ] ) {
				icon_wrap_class.push( settings[ mode + '_icon_shape' ] );
			}
			if ( settings[ mode + '_side_icon' ] && settings[ mode + '_side_icon' ]['value'] ) {
				content_str += '<div class="flipbox-icon-wrap">';
				content_str += '<span class="' + icon_wrap_class.join(' ') + ('svg' == settings[mode + '_side_icon']['library'] ? ' flipbox-svg' : '') + '">';
					if ( icon_html && icon_html.rendered ) {
						content_str += icon_html.value;
					} else {
						content_str += '<i class="' + settings[ mode + '_side_icon' ]['value'] + '"></i>';
					}
				content_str += '</span></div>';
			}

			content_str += '<div class="flipbox-content">';

			// Title
			if ( settings[ mode + '_side_title' ] ) {
				view.addRenderAttribute( mode + '_side_title', 'class', 'flipbox-title' );
				view.addInlineEditingAttributes( mode + '_side_title' );

				content_str += '<h3 ' + view.getRenderAttributeString( mode + '_side_title' ) + '>';
					content_str += settings[ mode + '_side_title' ];
				content_str += '</h3>';
			}

			// Subtitle
			if ( settings[ mode + '_side_subtitle' ] ) {
				view.addRenderAttribute( mode + '_side_subtitle', 'class', 'flipbox-subtitle' );
				view.addInlineEditingAttributes( mode + '_side_subtitle' );

				content_str += '<h4 ' + view.getRenderAttributeString( mode + '_side_subtitle' ) + '>';
					content_str += settings[ mode + '_side_subtitle' ];
				content_str += '</h4>';
			}

			// Description
			if ( settings[ mode + '_side_content' ] ) {
				view.addRenderAttribute( mode + '_side_content', 'class', 'flipbox-description' );
				view.addInlineEditingAttributes( mode + '_side_content' );

				content_str += '<p ' + view.getRenderAttributeString( mode + '_side_content' ) + '>';
					content_str += settings[ mode + '_side_content' ];
				content_str += '</p>';
			}

			// View More Button
			if ( settings[ mode + '_side_button_text' ] ) {
				view.addRenderAttribute( mode + '_side_button_text', 'class', btn_class );
				view.addInlineEditingAttributes( mode + '_side_button_text' );
				content_str += '<a ' + view.getRenderAttributeString( mode + '_side_button_text' ) + ' href="' + ( settings[mode + '_side_button_link']['url'] ? settings[mode + '_side_button_link']['url'] : '#' ) + '" ' + ( settings[mode + '_side_button_link']['is_external'] ? ' target="_blank"' : '' ) + ( settings[mode + '_side_button_link']['nofollow'] ? ' rel="nofollow"' : '' ) + '>' + btn_label + '</a>';
			}

			content_str += '</div>';

			return content_str;
		}
		#>
		<?php
	}
}
