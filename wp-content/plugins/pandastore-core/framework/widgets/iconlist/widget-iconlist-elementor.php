<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Icon List Widget
 *
 * Alpha Widget to display icon list.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;

class Alpha_IconList_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_iconlist';
	}

	public function get_title() {
		return esc_html__( 'Icon List', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'icon list', 'icon', 'list', 'alpha', 'menu' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-iconlist';
	}

	public function get_script_depends() {
		return array();
	}

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function register_controls() {

		$left   = is_rtl() ? 'right' : 'left';
		$right  = 'left' == $left ? 'right' : 'left';
		$before = is_rtl() ? 'after' : 'before';
		$after  = 'before' == $before ? 'after' : 'before';

		$this->start_controls_section(
			'section_icon',
			array(
				'label' => esc_html__( 'Icon List', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'view',
			array(
				'label'   => esc_html__( 'Layout', 'pandastore-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'block',
				'options' => array(
					'block'  => array(
						'title' => esc_html__( 'Default', 'pandastore-core' ),
						'icon'  => 'eicon-editor-list-ul',
					),
					'inline' => array(
						'title' => esc_html__( 'Inline', 'pandastore-core' ),
						'icon'  => 'eicon-ellipsis-h',
					),
				),
				'toggle'  => false,
				// 'render_type'    => 'template',
				// 'classes'        => 'elementor-control-start-end',
				// 'style_transfer' => true,
				// 'prefix_class'   => 'elementor-icon-list--layout-',
			)
		);

		$this->add_responsive_control(
			'icon_h_align',
			array(
				'label'     => esc_html__( 'Alignment', 'pandastore-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'start',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists' => 'align-items: {{VALUE}};',
				),
				'condition' => array(
					'view' => 'block',
				),
			)
		);

		$this->add_responsive_control(
			'icon_v_align',
			array(
				'label'     => esc_html__( 'Alignment', 'pandastore-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists' => 'justify-content: {{VALUE}};',
				),
				'condition' => array(
					'view' => 'inline',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your title', 'pandastore-core' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List Item', 'pandastore-core' ),
				'default'     => esc_html__( 'List Item', 'pandastore-core' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'selected_icon',
			array(
				'label'   => esc_html__( 'Icon', 'pandastore-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				// 'fa4compatibility' => 'icon',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'pandastore-core' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => 'https://your-link.com',
			)
		);

		$this->add_control(
			'icon_list',
			array(
				'label'       => esc_html__( 'Items', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'text'          => esc_html__( 'List Item #1', 'pandastore-core' ),
						'selected_icon' => array(
							'value'   => 'fas fa-check',
							'library' => 'fa-solid',
						),
					),
					array(
						'text'          => esc_html__( 'List Item #2', 'pandastore-core' ),
						'selected_icon' => array(
							'value'   => 'fas fa-times',
							'library' => 'fa-solid',
						),
					),
					array(
						'text'          => esc_html__( 'List Item #3', 'pandastore-core' ),
						'selected_icon' => array(
							'value'   => 'fas fa-dot-circle',
							'library' => 'fa-solid',
						),
					),
				),
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			array(
				'label'     => esc_html__( 'Title', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'title!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '.elementor-element-{{ID}} .list-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} .list-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_list',
			array(
				'label' => esc_html__( 'List Item', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'selector' => '.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item',
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'default'    => array(
					'top'    => 5,
					'right'  => 10,
					'bottom' => 5,
					'left'   => 10,
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '.elementor-element-{{ID}} .alpha-icon-lists.inline-type .alpha-icon-list-item:not(:last-child), .elementor-element-{{ID}} .alpha-icon-lists.inline-type .alpha-icon-list-item:not(:first-child)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '.elementor-element-{{ID}} .alpha-icon-lists.block-type .alpha-icon-list-item' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;'
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'divider',
			array(
				'label'     => esc_html__( 'Divider', 'pandastore-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'pandastore-core' ),
				'label_on'  => esc_html__( 'On', 'pandastore-core' ),
				'selectors' => array(
					".elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item:not(:last-child):{$after}" => 'content:""',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'divider_style',
			array(
				'label'     => esc_html__( 'Style', 'pandastore-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => esc_html__( 'Solid', 'pandastore-core' ),
					'double' => esc_html__( 'Double', 'pandastore-core' ),
					'dotted' => esc_html__( 'Dotted', 'pandastore-core' ),
					'dashed' => esc_html__( 'Dashed', 'pandastore-core' ),
				),
				'default'   => 'solid',
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					".elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item:not(:last-child):{$after}" => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'divider_width',
			array(
				'label'      => esc_html__( 'Width', 'alpha - core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( ' % ', 'px' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'range'      => array(
					' % ' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'  => array(
					'divider' => 'yes',
				),
				'selectors'  => array(
					".elementor-element-{{ID}} .alpha-icon-lists.block-type .alpha-icon-list-item:not(:last-child):{$after}" => 'width: {{SIZE}}{{UNIT}}',
					".elementor-element-{{ID}} .alpha-icon-lists.inline-type .alpha-icon-list-item:not(:last-child):{$after}" => 'border-right-width: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .alpha-icon-lists.inline-type .alpha-icon-list-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_height',
			array(
				'label'      => esc_html__( 'Height', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range'      => array(
					'%' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'  => array(
					'divider' => 'yes',
				),
				'selectors'  => array(
					".elementor-element-{{ID}} .alpha-icon-lists.block-type .alpha-icon-list-item:not(:last-child):{$after}" => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .alpha-icon-lists.block-type .alpha-icon-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					".elementor-element-{{ID}} .alpha-icon-lists.inline-type .alpha-icon-list-item:not(:last-child):{$after}" => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					".elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item:not(:last-child):{$after}" => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			array(
				'label' => esc_html__( 'Icon', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Size', 'pandastore-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 14,
				),
				'range'     => array(
					'px' => array(
						'min' => 6,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'default'    => array(
					'top'    => 0,
					'right'  => 5,
					'bottom' => 0,
					'left'   => 0,
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} .alpha-icon-lists .alpha-icon-list-item i:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/iconlist/render-iconlist-elementor.php' );
	}
}
