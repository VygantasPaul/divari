<?php
/**
 * Tab Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

/**
 * Register elementor tab layout controls
 *
 * @since 1.0
 */
function alpha_elementor_tab_layout_controls( $self, $condition_key = '' ) {

	$self->add_control(
		'tab_type',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Layout', 'pandastore-core' ),
				'description' => esc_html__( 'Determine whether to arrange tab navs horizontally or vertically.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''         => esc_html__( 'Horizontal', 'pandastore-core' ),
					'vertical' => esc_html__( 'Vertical', 'pandastore-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_responsive_control(
		'tab-nav-width',
		array_merge(
			array(
				'label'      => esc_html__( 'Vertical Nav width', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .tab-vertical .nav' => 'width: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .tab-vertical .tab-content' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => 'vertical',
				),
			) : array(
				'condition' => array(
					'tab_type' => 'vertical',
				),
			)
		)
	);

	$self->add_responsive_control(
		'tab_navs_pos',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Navs Position', 'pandastore-core' ),
				'description' => esc_html__( 'Controls alignment of tab navs. Choose from Start, Middle, End.', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'left',
				'options'     => array(
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
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => '',
				),
			) : array(
				'condition' => array(
					'tab_type' => '',
				),
			)
		)
	);

	$self->add_control(
		'tab_h_type',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Type', 'pandastore-core' ),
				'description' => esc_html__( 'Choose from 7 tab types. Choose from Default, simple, solid, outline and link and so on.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''         => esc_html__( 'Default', 'pandastore-core' ),
					'simple'   => esc_html__( 'Simple', 'pandastore-core' ),
					'solid1'   => esc_html__( 'Solid 1', 'pandastore-core' ),
					'solid2'   => esc_html__( 'Solid 2', 'pandastore-core' ),
					'outline1' => esc_html__( 'Outline 1', 'pandastore-core' ),
					'outline2' => esc_html__( 'Outline 2', 'pandastore-core' ),
					'link'     => esc_html__( 'Underline', 'pandastore-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => '',
				),
			) : array(
				'condition' => array(
					'tab_type' => '',
				),
			)
		)
	);

	$self->add_control(
		'tab_v_type',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Type', 'pandastore-core' ),
				'description' => esc_html__( 'Choose from 3 tab types. Choose from Default, simple, solid.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''       => esc_html__( 'Default', 'pandastore-core' ),
					'simple' => esc_html__( 'Simple', 'pandastore-core' ),
					'solid'  => esc_html__( 'Solid', 'pandastore-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => 'vertical',
				),
			) : array(
				'condition' => array(
					'tab_type' => 'vertical',
				),
			)
		)
	);
}

/**
 * Register elementor tab style controls
 */
function alpha_elementor_tab_style_controls( $self, $condition_key = '' ) {
	$left  = is_rtl() ? 'right' : 'left';
	$right = 'left' == $left ? 'right' : 'left';

	$self->start_controls_section(
		'tab_style',
		array_merge(
			array(
				'label' => esc_html__( 'Tab', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_control(
		'tab_br',
		array_merge(
			array(
				'label'      => esc_html__( 'Tab Border Radius (px)', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .tab-content'   => 'border-radius: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .nav .nav-link' => 'border-radius: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .tab-outline2 .nav-link' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
					'.elementor-element-{{ID}} .tab-outline2 .tab-content' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_responsive_control(
		'nav_margin',
		array(
			'label'      => esc_html__( 'Nav Box Margin', 'pandastore-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'nav_item_margin',
		array(
			'label'      => esc_html__( 'Nav Item Margin', 'pandastore-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'separator'  => 'before',
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .nav .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'nav_item_padding',
		array(
			'label'      => esc_html__( 'Nav Item Padding', 'pandastore-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'default'    => array(
				'top'    => 8,
				'right'  => 15,
				'bottom' => 8,
				'left'   => 15,
			),
			'separator'  => 'after',
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .nav .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'tab_nav_typography',
			'label'    => esc_html__( 'Nav Typography', 'pandastore-core' ),
			'selector' => '.elementor-element-{{ID}} .nav .nav-link',
		)
	);

	$self->add_control(
		'nav_bd',
		array_merge_recursive(
			array(
				'label'     => esc_html__( 'Nav Border Width (px)', 'pandastore-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'selectors' => array(
					'.elementor-element-{{ID}} .tab:not(.tab-vertical) .nav-link' => 'border-width: {{VALUE}}px;',
					'.elementor-element-{{ID}} .tab.tab-nav-underline .nav-link' => 'border-width: 0 0 {{VALUE}}px;',
					'.elementor-element-{{ID}} .tab-nav-simple .nav-link.active, .elementor-element-{{ID}} .tab-nav-simple .nav-link:hover' => 'border-bottom-width: calc({{VALUE}}px * 2)',
					'.elementor-element-{{ID}} .tab-outline .nav-link' => 'border-top-width: calc({{VALUE}}px * 2);',
					'.elementor-element-{{ID}} .tab-nav-underline .nav-link:after' => 'border-bottom-width: {{VALUE}}px;',
					'.elementor-element-{{ID}} .tab-vertical.tab-simple .nav-link::after' => 'width: {{VALUE}}px;',
					'.elementor-element-{{ID}} .tab-vertical.tab-simple .nav-link' => "margin-{$right}: -{{VALUE}}px; width: calc(100% + {{VALUE}}px);",
				),
				'condition' => array(
					'tab_h_type!' => array( '', 'solid1', 'solid2' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->start_controls_tabs( 'tabs_bg_color' );

	$self->start_controls_tab(
		'tab_color_normal',
		array(
			'label' => esc_html__( 'Normal', 'pandastore-core' ),
		)
	);

	$self->add_control(
		'bg_color',
		array(
			'label'     => esc_html__( 'Nav Background Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'color',
		array(
			'label'     => esc_html__( 'Nav Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'nav_bd_color',
		array(
			'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .tab .nav .nav-link' => 'border-color: {{VALUE}};',
				'.elementor-element-{{ID}} .tab-nav-underline .nav-link:after' => 'border-color: {{VALUE}};',
			),
			'condition' => array(
				'tab_h_type!' => array( '', 'solid1', 'solid2' ),
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_color_hover',
		array(
			'label' => esc_html__( 'Hover', 'pandastore-core' ),
		)
	);

	$self->add_control(
		'bg_color_hover',
		array(
			'label'     => esc_html__( 'Hover Nav Background Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'color_hover',
		array(
			'label'     => esc_html__( 'Hover Nav Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'nav_bd_hover_color',
		array(
			'label'     => esc_html__( 'Hover Border Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .tab .nav .nav-link:hover' => 'border-color: {{VALUE}};',
				'.elementor-element-{{ID}} .tab-nav-underline .nav-link:hover:after' => 'border-color: {{VALUE}};',
			),
			'condition' => array(
				'tab_h_type!' => array( '', 'solid1', 'solid2' ),
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_color_active',
		array(
			'label' => esc_html__( 'Active', 'pandastore-core' ),
		)
	);

	$self->add_control(
		'bg_color_active',
		array(
			'label'     => esc_html__( 'Active Nav Background Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link.active' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'color_active',
		array(
			'label'     => esc_html__( 'Active Nav Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link.active' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'nav_bd_active_color',
		array(
			'label'     => esc_html__( 'Active Border Color', 'pandastore-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .nav .nav-link.active' => 'border-color: {{VALUE}};',
				'.elementor-element-{{ID}} .tab-nav-underline .nav-link.active:after' => 'border-color: {{VALUE}};',
			),
			'condition' => array(
				'tab_h_type!' => array( '', 'solid1', 'solid2' ),
			),
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->end_controls_section();
}
