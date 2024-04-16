<?php
/**
 * Timeline Element
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Timeline_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_timeline';
	}

	public function get_title() {
		return esc_html__( 'Timeline - Vertical', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-time-line';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'timeline', 'process', 'step', 'vertical' );
	}

	public function get_script_depends() {
		wp_register_script( 'alpha-timeline', alpha_core_framework_uri( '/widgets/timeline/timeline' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-timeline' );
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'section_timeline_content',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
			)
		);
			$repeater = new Repeater();

			$repeater->add_control(
				'show_image',
				array(
					'label'     => esc_html__( 'Show Image', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon!' => 'yes',
					),
				)
			);
			$repeater->add_control(
				'image_position',
				array(
					'label'     => esc_html__( 'Image Position', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''             => esc_html__( 'Default', 'pandastore-core' ),
						'before_title' => esc_html__( 'Before Title', 'pandastore-core' ),
						'after_desc'   => esc_html__( 'After Description', 'pandastore-core' ),
					),
					'condition' => array(
						'show_image' => 'yes',
						'show_icon!' => 'yes',
					),
				)
			);
			$repeater->add_control(
				'image',
				array(
					'label'     => esc_html__( 'Image', 'pandastore-core' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => array(
						'url' => Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'show_image' => 'yes',
						'show_icon!' => 'yes',
					),
				)
			);

			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'exclude'   => [ 'custom' ],
					'default'   => 'woocommerce_thumbnail',
					'condition' => array(
						'show_image' => 'yes',
						'show_icon!' => 'yes',
					),
				)
			);

			$repeater->add_control(
				'show_icon',
				array(
					'label'     => esc_html__( 'Show Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_image!' => 'yes',
					),
				)
			);
			$repeater->add_control(
				'icon_position',
				array(
					'label'     => esc_html__( 'Icon Position', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''             => esc_html__( 'Default', 'pandastore-core' ),
						'before_title' => esc_html__( 'Before Title', 'pandastore-core' ),
						'after_desc'   => esc_html__( 'After Description', 'pandastore-core' ),
					),
					'condition' => array(
						'show_icon'   => 'yes',
						'show_image!' => 'yes',
					),
				)
			);
			$repeater->add_control(
				'timeline_icon',
				array(
					'label'     => esc_html__( 'Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-cart-solid',
						'library' => 'themes-icons',
					),
					'condition' => array(
						'show_icon'   => 'yes',
						'show_image!' => 'yes',
					),
				)
			);
			$repeater->add_control(
				'title',
				array(
					'label' => esc_html__( 'Title', 'pandastore-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			$repeater->add_control(
				'meta',
				array(
					'label' => esc_html__( 'Meta', 'pandastore-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			$repeater->add_control(
				'desc',
				array(
					'label' => esc_html__( 'Description', 'pandastore-core' ),
					'type'  => Controls_Manager::TEXTAREA,
					'rows'  => '10',
				)
			);

			$repeater->add_control(
				'breakpoint_heading',
				array(
					'label'     => esc_html__( 'Breakpoint', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$repeater->add_control(
				'breakpoint_type',
				array(
					'label'   => esc_html__( 'Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'text',
					'options' => array(
						'icon' => esc_html__( 'Icon', 'pandastore-core' ),
						'text' => esc_html__( 'Text', 'pandastore-core' ),
					),
				)
			);

			$repeater->add_control(
				'breakpoint_icon',
				array(
					'label'     => esc_html__( 'Select Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-cart-solid',
						'library' => 'themes-icons',
					),
					'condition' => array(
						'breakpoint_type' => 'icon',
					),
				)
			);

			$repeater->add_control(
				'breakpoint_text',
				array(
					'label'     => esc_html__( 'Text', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'breakpoint_type' => 'text',
					),
				)
			);

			$presets = array(
				array(
					'title'           => esc_html__( 'Step #1', 'pandastore-core' ),
					'meta'            => esc_html__( 'Monday, October 11, 2021', 'pandastore-core' ),
					'desc'            => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'pandastore-core' ),
					'breakpoint_text' => '1',
				),
				array(
					'title'           => esc_html__( 'Step #2', 'pandastore-core' ),
					'meta'            => esc_html__( 'Tuesday, October 12, 2021', 'pandastore-core' ),
					'desc'            => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'pandastore-core' ),
					'breakpoint_text' => '2',
				),
				array(
					'title'           => esc_html__( 'Step #3', 'pandastore-core' ),
					'meta'            => esc_html__( 'Wednesday, October 13, 2021', 'pandastore-core' ),
					'desc'            => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'pandastore-core' ),
					'breakpoint_text' => '3',
				),
			);

			$this->add_control(
				'timeline_list',
				array(
					'label'       => esc_html__( 'Timeline Items', 'pandastore-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => $presets,
					'title_field' => '{{{title}}}',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_timeline_layout',
			array(
				'label' => esc_html__( 'Layout', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'h_align',
				array(
					'label'   => esc_html__( 'Horizontal Alignment', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'options' => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-h-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-h-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
					'toggle'  => false,
				)
			);

			$this->add_control(
				'v_align',
				array(
					'label'   => esc_html__( 'Vertical Alignment', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'middle',
					'options' => array(
						'top'    => array(
							'title' => esc_html__( 'Top', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-top',
						),
						'middle' => array(
							'title' => esc_html__( 'Middle', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'bottom' => array(
							'title' => esc_html__( 'Bottom', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
					),
					'toggle'  => false,
				)
			);

			$this->add_responsive_control(
				'h_space',
				array(
					'label'      => esc_html__( 'Horizontal Space', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 20,
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-point' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'v_space',
				array(
					'label'      => esc_html__( 'Vertical Space', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-item + .timeline-item' => 'margin-top: {{SIZE}}px;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_image',
			array(
				'label' => esc_html__( 'Image', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_responsive_control(
				'image_width',
				array(
					'label'      => esc_html__( 'Width', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 300,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'image_height',
				array(
					'label'      => esc_html__( 'Height', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 300,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'image_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'image_border_width',
				array(
					'label'      => esc_html__( 'Border Width', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'image_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'image_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'dropdown_box_shadow',
					'selector' => '.elementor-element-{{ID}} .timeline-media img',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_icon_section',
			array(
				'label' => esc_html__( 'Icon', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'timeline_icon_size',
				array(
					'label'      => esc_html__( 'Icon Size', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'%',
						'rem',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media i' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'timeline_icon_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-media i' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-media i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_meta',
			array(
				'label' => esc_html__( 'Meta', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'meta_typography',
					'selector' => '.elementor-element-{{ID}} .timeline-meta',
				)
			);

			$this->add_control(
				'meta_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-meta' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'meta_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_title',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'selector' => '.elementor-element-{{ID}} .timeline-title',
				)
			);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'title_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_desc',
			array(
				'label' => esc_html__( 'Description', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'desc_typography',
					'selector' => '.elementor-element-{{ID}} .timeline-desc',
				)
			);

			$this->add_control(
				'desc_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-desc' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'desc_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_content',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'content_shadow',
				array(
					'label' => esc_html__( 'Enable Shadow', 'pandastore-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'content_color',
				array(
					'label'     => esc_html__( 'Background', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-content' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_width',
				array(
					'label'      => esc_html__( 'Width', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 50,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline.timeline-vertical .timeline-content, .elementor-element-{{ID}} .timeline.timeline-vertical .timeline-meta-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .timeline-h-align-right .timeline-item' => 'justify-content: flex-end;',
						'.elementor-element-{{ID}} .timeline-h-align-center .timeline-item' => 'justify-content: center;',
					),
				)
			);

			$this->add_responsive_control(
				'content_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_padding',
				array(
					'label'      => esc_html__( 'Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_point',
			array(
				'label' => esc_html__( 'Point', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->start_controls_tabs( 'tabs_point_content' );
				$this->start_controls_tab(
					'tab_point_text',
					array(
						'label' => esc_html__( 'Text', 'pandastore-core' ),
					)
				);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'point_text',
							'selector' => '.elementor-element-{{ID}} .timeline-point',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_point_icon',
					array(
						'label' => esc_html__( 'Icon', 'pandastore-core' ),
					)
				);

					$this->add_responsive_control(
						'icon_size',
						array(
							'label'      => esc_html__( 'Icon Size', 'pandastore-core' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => array(
								'px',
								'%',
								'em',
							),
							'selectors'  => array(
								'.elementor-element-{{ID}} .timeline-point i' => 'font-size: {{SIZE}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->start_controls_tabs( 'tabs_point_style' );
				$this->start_controls_tab(
					'tab_point_style',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);
					$this->add_responsive_control(
						'point_size',
						array(
							'label'      => esc_html__( 'Size', 'pandastore-core' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => array(
								'px',
								'%',
								'rem',
							),
							'range'      => array(
								'px'  => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 200,
								),
								'%'   => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
								'rem' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 20,
								),
							),
							'selectors'  => array(
								'.elementor-element-{{ID}} .timeline-point' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
								'.elementor-element-{{ID}} .timeline-h-align-left .timeline-line' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
								'.elementor-element-{{ID}} .timeline-h-align-right .timeline-line' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2);',
								'.elementor-element-{{ID}} .timeline-h-align-center .timeline-line' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
							),
						)
					);

					$this->add_control(
						'point_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .timeline-point' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'point_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .timeline-point' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_responsive_control(
						'point_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%', 'rem' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .timeline-point' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'point_box_shadow',
							'selector' => '.elementor-element-{{ID}} .timeline-point',
						)
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_point_active',
					array(
						'label' => esc_html__( 'Active', 'pandastore-core' ),
					)
				);
					$this->add_responsive_control(
						'point_size_active',
						array(
							'label'      => esc_html__( 'Size', 'pandastore-core' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => array(
								'px',
								'%',
								'rem',
							),
							'selectors'  => array(
								'.elementor-element-{{ID}} .active .timeline-point' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
								'.elementor-element-{{ID}} .timeline-h-align-left .active .timeline-line' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
								'.elementor-element-{{ID}} .timeline-h-align-right .active .timeline-line' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2);',
							),
						)
					);

					$this->add_control(
						'point_color_active',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .active .timeline-point' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'point_bg_color_active',
						array(
							'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .active .timeline-point' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_responsive_control(
						'point_border_radius_active',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%', 'rem' ),
							'selectors'  => array(
								'.elementor-element-{{ID}} .active .timeline-point' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'point_box_shadow_active',
							'selector' => '.elementor-element-{{ID}} .active .timeline-point',
						)
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'timeline_line',
			array(
				'label' => esc_html__( 'Line', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'timeline_line_color',
				array(
					'label'     => esc_html__( 'Line Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-line' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'timeline_progress_color',
				array(
					'label'     => esc_html__( 'Progress Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .timeline-progress' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'timeline_line_width',
				array(
					'label'      => esc_html__( 'Thickness', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .timeline-line' => 'width: {{SIZE}}px;',
					),
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/timeline/render-timeline-elementor.php' );
	}
}
