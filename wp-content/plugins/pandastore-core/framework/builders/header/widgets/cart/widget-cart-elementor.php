<?php
/**
 * Alpha Header Elementor Cart
 *
 * @author     D-THEMES
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Header_Cart_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_header_cart';
	}

	public function get_title() {
		return esc_html__( 'Cart', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-cart-medium';
	}

	public function get_categories() {
		return array( 'alpha_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'alpha', 'cart', 'shop', 'mini', 'bag' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';
		$this->start_controls_section(
			'section_cart_content',
			array(
				'label' => esc_html__( 'Cart', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Cart Type', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'block',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'pandastore-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'mini_cart',
				array(
					'label'   => esc_html__( 'Mini Cart List', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'dropdown',
					'options' => array(
						'dropdown'  => esc_html__( 'Dropdown', 'pandastore-core' ),
						'offcanvas' => esc_html__( 'Off-Canvas', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'icon_type',
				array(
					'label'   => esc_html__( 'Cart Icon Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'badge',
					'options' => array(
						'badge' => esc_html__( 'Badge Type', 'pandastore-core' ),
						'label' => esc_html__( 'Label Type', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Cart Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-cart-solid',
						'library' => 'alpha-icons',
					),
					'condition' => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_control(
				'show_label',
				array(
					'label'   => esc_html__( 'Show Label', 'pandastore-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'label',
				array(
					'label'     => esc_html__( 'Cart Label', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'My Cart', 'pandastore-core' ),
					'condition' => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_price',
				array(
					'label'   => esc_html__( 'Show Cart Total Price', 'pandastore-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'delimiter',
				array(
					'label'     => esc_html__( 'Delimiter', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '/',
					'condition' => array(
						'show_label' => 'yes',
						'show_price' => 'yes',
					),
				)
			);

			$this->add_control(
				'count_pfx',
				array(
					'label'     => esc_html__( 'Cart Count Prefix', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '(',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

			$this->add_control(
				'count_sfx',
				array(
					'label'     => esc_html__( 'Cart Count suffix', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'items )',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_style',
			array(
				'label' => esc_html__( 'Cart Toggle', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'cart_padding',
				array(
					'label'      => esc_html__( 'Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-dropdown .cart-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_cart_color' );
				$this->start_controls_tab(
					'tab_cart_normal',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'cart_color',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_cart_hover',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'cart_hover_color',
					array(
						'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .cart-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'cart_label_heading',
				array(
					'label'     => esc_html__( 'Cart Label', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_typography',
					'selector' => '.elementor-element-{{ID}} .cart-toggle, .elementor-element-{{ID}} .cart-count',
				)
			);

			$this->add_responsive_control(
				'cart_delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-toggle .cart-name-delimiter' => 'margin: 0 {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'cart_price_heading',
				array(
					'label'     => esc_html__( 'Cart Price', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'cart_price_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .cart-price' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_price_typography',
					'selector' => '.elementor-element-{{ID}} .cart-price',
				)
			);

			$this->add_responsive_control(
				'cart_price_margin',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'cart_icon_heading',
				array(
					'label'     => esc_html__( 'Cart Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_responsive_control(
				'cart_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-dropdown .cart-toggle > i' => 'font-size: {{SIZE}}px;',
					),
					'condition'  => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_responsive_control(
				'cart_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type .cart-label + i' => 'margin-bottom: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type .cart-label + i' => "margin-{$left}: {{SIZE}}px;",
					),
					'condition'  => array(
						'icon_type' => 'badge',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_badge_style',
			array(
				'label'     => esc_html__( 'Badge', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'icon_type' => 'badge',
				),
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'badge_h_position',
				array(
					'label'      => esc_html__( 'Horizontal Position', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => "{$left}: {{SIZE}}{{UNIT}};",
					),
				)
			);

			$this->add_responsive_control(
				'badge_v_position',
				array(
					'label'      => esc_html__( 'Vertical Position', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bd_color',
				array(
					'label'     => esc_html__( 'Count Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'type'      => $settings['type'],
			'icon_type' => $settings['icon_type'],
			'mini_cart' => $settings['mini_cart'],
			'title'     => $settings['show_label'],
			'label'     => $settings['label'],
			'price'     => $settings['show_price'],
			'delimiter' => $settings['delimiter'],
			'pfx'       => $settings['count_pfx'],
			'sfx'       => $settings['count_sfx'],
			'icon'      => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : ALPHA_ICON_PREFIX . '-icon-cart-solid',
		);
		require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/cart/render-cart-elementor.php' );
	}
}
