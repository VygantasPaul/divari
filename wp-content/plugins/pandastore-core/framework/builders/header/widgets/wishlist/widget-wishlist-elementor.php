<?php
/**
 * Alpha Header Elementor Wishlist
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Header_Wishlist_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_header_wishlist';
	}

	public function get_title() {
		return esc_html__( 'Wishlist', 'pandastore-core' );
	}

	public function get_icon() {
		return ALPHA_ICON_PREFIX . '-icon-heart  alpha-elementor-widget-icon';
	}

	public function get_categories() {
		return array( 'alpha_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'alpha', 'wish', 'love', 'like', 'list' );
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
			'section_wishlist_content',
			array(
				'label' => esc_html__( 'Wishlist', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Wishlist Type', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
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
				'miniwishlist',
				array(
					'label'   => esc_html__( 'Mini Wish List', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''          => esc_html__( 'Do not show', 'pandastore-core' ),
						'dropdown'  => esc_html__( 'Dropdown', 'pandastore-core' ),
						'offcanvas' => esc_html__( 'Off-Canvas', 'pandastore-core' ),
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
					'label'       => esc_html__( 'Label', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Wishlist', 'pandastore-core' ),
					'condition'   => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_icon',
				array(
					'label'   => esc_html__( 'Show Icon', 'pandastore-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-heart',
						'library' => 'alpha-icons',
					),
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'     => esc_html__( 'Show Count', 'pandastore-core' ),
					'default'   => '',
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_style',
			array(
				'label' => esc_html__( 'Wishlist', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'wishlist_typography',
					'selector' => '.elementor-element-{{ID}} .wishlist',
				)
			);

			$this->add_responsive_control(
				'wishlist_padding',
				array(
					'label'      => esc_html__( 'Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .elementor-widget-container > .wishlist, .elementor-element-{{ID}} .wishlist-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wishlist i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => "margin-{$left}: {{SIZE}}px;",
					),
				)
			);

			$this->start_controls_tabs( 'tabs_account_color' );
				$this->start_controls_tab(
					'tab_account_normal',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'account_color',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_account_hover',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'account_hover_color',
					array(
						'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'wishlist_count_heading',
				array(
					'label'     => esc_html__( 'Count', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_dropdown_style',
			array(
				'label' => esc_html__( 'Dropdown', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'       => esc_html__( 'Dropdown Position', 'pandastore-core' ),
					'description' => esc_html__( 'Left offset of dropdown', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .dropdown-box' => "{$left}: {{SIZE}}{{UNIT}}; {$right}: auto;",
					),
					'condition'   => array(
						'miniwishlist' => 'dropdown',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_badge_style',
			array(
				'label' => esc_html__( 'Badge', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wishlist .wish-count' => 'font-size: {{SIZE}}px;',
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
						'.elementor-element-{{ID}} .wishlist .wish-count' => "{$left}: {{SIZE}}{{UNIT}};",
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
						'.elementor-element-{{ID}} .wishlist .wish-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wishlist .wish-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_color',
				array(
					'label'     => esc_html__( 'Count Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wishlist .wish-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'type'         => $settings['type'],
			'show_label'   => 'yes' == $settings['show_label'],
			'show_count'   => 'yes' == $settings['show_count'],
			'show_icon'    => 'yes' == $settings['show_icon'],
			'label'        => isset( $settings['label'] ) && $settings['label'] ? $settings['label'] : esc_html__( 'Wishlist', 'pandastore-core' ),
			'icon'         => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : ALPHA_ICON_PREFIX . '-icon-heart',
			'miniwishlist' => $settings['miniwishlist'],
		);
		require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/wishlist/render-wishlist-elementor.php' );
	}
}
