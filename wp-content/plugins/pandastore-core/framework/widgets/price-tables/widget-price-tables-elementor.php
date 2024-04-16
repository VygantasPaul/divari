<?php
/**
 * Price Tables Element
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */


use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Alpha_Controls_Manager;
use ELementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Alpha_Price_Tables_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_price_tables';
	}

	public function get_title() {
		return esc_html__( 'Price Tables', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-price-table';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'price', 'tables' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'Price Tables', 'pandastore-core' ),
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'pricing_tabs' );

		$repeater->start_controls_tab(
			'text_tab',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Plan Name', 'pandastore-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Basic Plan', 'pandastore-core' ),
			)
		);

			$repeater->add_control(
				'desc',
				array(
					'label' => esc_html__( 'Plan Description', 'pandastore-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			$repeater->add_control(
				'features_list',
				array(
					'label'       => esc_html__( 'Featured List', 'pandastore-core' ),
					'description' => esc_html__( 'Start each feature from a new line', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => 'Feature 1
		Feature 2
		Feature 3',
				)
			);

			$repeater->add_control(
				'price_value',
				array(
					'label'   => esc_html__( 'Price Value', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '199',
				)
			);

			$repeater->add_control(
				'price_suffix',
				array(
					'label'   => esc_html__( 'Price Suffix', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'monthly', 'pandastore-core' ),
				)
			);

			$repeater->add_control(
				'currency',
				array(
					'label'   => esc_html__( 'Price Currency', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '$',
				)
			);

			$repeater->add_control(
				'best_option',
				array(
					'label'        => esc_html__( 'Is Featured', 'pandastore-core' ),
					'description'  => esc_html__( 'Highlight this price plan as best one.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'separator'    => 'before',
					'label_on'     => esc_html__( 'Yes', 'pandastore-core' ),
					'label_off'    => esc_html__( 'No', 'pandastore-core' ),
					'return_value' => 'yes',
				)
			);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'button_tab',
			array(
				'label' => esc_html__( 'Button', 'pandastore-core' ),
			)
		);

		$repeater->add_control(
			'button_label',
			array(
				'label'   => esc_html__( 'Label', 'pandastore-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose Plan', 'pandastore-core' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link Url', 'pandastore-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		alpha_elementor_button_layout_controls( $repeater, '', 'yes', '', true );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'tables',
			array(
				'label'       => esc_html__( 'Price Tables', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ name }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'          => esc_html__( 'Basic Plan', 'pandastore-core' ),
						'price_value'   => '29.99',
						'currency'      => '$',
						'features_list' => esc_html__(
							'Basic Product
25 Product Downloads
Free Support
Basic Customization
Free Updates',
							'alpha-core'
						),
					),
					array(
						'name'          => esc_html__( 'Standard Plan', 'pandastore-core' ),
						'price_value'   => '49.99',
						'currency'      => '$',
						'best_option'   => 'yes',
						'features_list' => esc_html__(
							'Basic Product
25 Product Downloads
Free Support
Basic Customization
Free Updates',
							'alpha-core'
						),
					),
					array(
						'name'          => esc_html__( 'Professional Plan', 'pandastore-core' ),
						'price_value'   => '89.99',
						'currency'      => '$',
						'features_list' => esc_html__(
							'Basic Product
25 Product Downloads
Free Support
Basic Customization
Free Updates',
							'alpha-core'
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout',
			array(
				'label' => esc_html__( 'Layout', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Layout', 'pandastore-core' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'grid',
			)
		);

		alpha_elementor_grid_layout_controls( $this, 'layout_type', false, '', 3 );

		$this->end_controls_section();

		$this->start_controls_section(
			'type',
			array(
				'label' => esc_html__( 'Type', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'price_table_type',
			array(
				'label'   => esc_html__( 'Type', 'pandastore-core' ),
				'type'    => Alpha_Controls_Manager::IMAGE_CHOOSE,
				'default' => 'default',
				'options' => array(
					'simple'  => 'assets/images/price-tables/table-1.jpg',
					'default' => 'assets/images/price-tables/table-2.jpg',
					'mini'    => 'assets/images/price-tables/table-3.jpg',
					'colored' => 'assets/images/price-tables/table-4.jpg',
					'classic' => 'assets/images/price-tables/table-5.jpg',
				),
				'width'   => 1,
			)
		);

		$this->add_control(
			'feature_divider',
			array(
				'label' => esc_html__( 'Show Feature Dividers', 'pandastore-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_style',
			array(
				'label' => esc_html__( 'Table', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'table_styles' );

			$this->start_controls_tab(
				'table_global',
				array(
					'label' => esc_html__( 'Global', 'pandastore-core' ),
				)
			);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'table_bg_global',
						'selector' => '.elementor-element-{{ID}} .price-table',
					)
				);

				$this->add_responsive_control(
					'padding_global',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'border_radius_global',
					array(
						'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'table_box_shadow_global',
						'selector' => '.elementor-element-{{ID}} .price-table',
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'table_featured',
				array(
					'label' => esc_html__( 'Featured', 'pandastore-core' ),
				)
			);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'table_bg_featured',
						'selector' => '.elementor-element-{{ID}} .price-table.featured',
					)
				);

				$this->add_responsive_control(
					'padding_featured',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-table.featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'border_radius_featured',
					array(
						'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'table_box_shadow_featured',
						'selector' => '.elementor-element-{{ID}} .featured',
					)
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'header_style',
			array(
				'label' => esc_html__( 'Header', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->start_controls_tabs( 'header_styles' );

			$this->start_controls_tab(
				'header_global',
				array(
					'label' => esc_html__( 'Global', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'header_color_global',
					array(
						'label'     => esc_html__( 'Name Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .price-table .plan-header' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Name Typography', 'pandastore-core' ),
						'name'     => 'header_typography',
						'selector' => '.elementor-element-{{ID}} .price-tables .price-table .plan-header',
					)
				);

				$this->add_control(
					'header_desc_color_global',
					array(
						'label'     => esc_html__( 'Description Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .plan-desc' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Description Typography', 'pandastore-core' ),
						'name'     => 'header_desc_typography',
						'selector' => '.elementor-element-{{ID}} .price-tables .plan-desc',
					)
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'header_bg_global',
						'selector' => '.elementor-element-{{ID}} .price-tables .price-table .plan-header',
					)
				);

				$this->add_responsive_control(
					'header_padding_global',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-tables .price-table .plan-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'header_featured',
				array(
					'label' => esc_html__( 'Featured', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'header_color_featured',
					array(
						'label'     => esc_html__( 'Name Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .featured .plan-header' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Name Typography', 'pandastore-core' ),
						'name'     => 'header_typography_featured',
						'selector' => '.elementor-element-{{ID}} .price-tables .featured .plan-header',
					)
				);

				$this->add_control(
					'header_desc_color_featured',
					array(
						'label'     => esc_html__( 'Description Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .featured .plan-desc' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Description Typography', 'pandastore-core' ),
						'name'     => 'header_desc_typography_featured',
						'selector' => '.elementor-element-{{ID}} .price-tables .featured .plan-desc',
					)
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'header_bg_featured',
						'selector' => '.elementor-element-{{ID}} .price-tables .featured .plan-header',
					)
				);

				$this->add_responsive_control(
					'header_padding_featured',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-tables .featured .plan-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'pricing_style',
			array(
				'label' => esc_html__( 'Pricing', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'price_styles' );

			$this->start_controls_tab(
				'price_global',
				array(
					'label' => esc_html__( 'Global', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'price_heading_global',
					array(
						'label' => esc_html__( 'Price', 'pandastore-core' ),
						'type'  => Controls_Manager::HEADING,
					)
				);

				$this->add_control(
					'price_color_global',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .price-table .plan-price' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'price_typography',
						'selector' => '.elementor-element-{{ID}} .plan-price',
					)
				);

				$this->add_control(
					'currency_heading_global',
					array(
						'label'     => esc_html__( 'Currency', 'pandastore-core' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					)
				);

				$this->add_control(
					'currency_color_global',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .currency' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'currency_typography',
						'selector' => '.elementor-element-{{ID}} .currency',
					)
				);

				$this->add_control(
					'suffix_heading_global',
					array(
						'label'     => esc_html__( 'Suffix', 'pandastore-core' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					)
				);

				$this->add_control(
					'suffix_color_global',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .price-table .price-suffix' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'suffix_typography',
						'selector' => '.elementor-element-{{ID}} .price-suffix',
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'price_featured',
				array(
					'label' => esc_html__( 'Featured', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'price_heading_featured',
					array(
						'label' => esc_html__( 'Price', 'pandastore-core' ),
						'type'  => Controls_Manager::HEADING,
					)
				);

				$this->add_control(
					'price_color_featured',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .featured .plan-price' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'price_typography_featured',
						'selector' => '.elementor-element-{{ID}} .featured .plan-price',
					)
				);

				$this->add_control(
					'currency_heading_featured',
					array(
						'label'     => esc_html__( 'Currency', 'pandastore-core' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					)
				);

				$this->add_control(
					'currency_color_featured',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .featured .currency' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'currency_typography_featured',
						'selector' => '.elementor-element-{{ID}} .featured .currency',
					)
				);

				$this->add_control(
					'suffix_heading_featured',
					array(
						'label'     => esc_html__( 'Suffix', 'pandastore-core' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					)
				);

				$this->add_control(
					'suffix_color_featured',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .featured .price-suffix' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'suffix_typography_featured',
						'selector' => '.elementor-element-{{ID}} .featured .price-suffix',
					)
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'features_style',
			array(
				'label' => esc_html__( 'Features', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( 'features_styles' );

			$this->start_controls_tab(
				'features_global',
				array(
					'label' => esc_html__( 'Global', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'features_color_global',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .plan-features' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'features_typography',
						'selector' => '.elementor-element-{{ID}} .plan-features',
					)
				);

				$this->add_responsive_control(
					'features_margin_global',
					array(
						'label'      => esc_html__( 'Margin', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-table .plan-features' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'features_padding_global',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .price-table .plan-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_control(
					'features_border_width_global',
					array(
						'label'     => esc_html__( 'Border Width (px)', 'pandastore-core' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => array(
							'px' => array(
								'step' => 1,
								'min'  => 1,
								'max'  => 50,
							),
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .plan-feature' => 'border-width: 0 0 {{SIZE}}px 0; border-style: solid',
						),
					)
				);

				$this->add_control(
					'features_border_color_global',
					array(
						'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .price-table .plan-feature' => 'border-color: {{VALUE}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'features_featured',
				array(
					'label' => esc_html__( 'Featured', 'pandastore-core' ),
				)
			);

				$this->add_control(
					'features_color_featured',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .featured .plan-features' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'features_typography_featured',
						'selector' => '.elementor-element-{{ID}} .featured .plan-features',
					)
				);

				$this->add_responsive_control(
					'features_margin_featured',
					array(
						'label'      => esc_html__( 'Margin', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .featured .plan-features' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'features_padding_featured',
					array(
						'label'      => esc_html__( 'Padding', 'pandastore-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'rem',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .featured .plan-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_control(
					'features_border_width_featured',
					array(
						'label'     => esc_html__( 'Border Width (px)', 'pandastore-core' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => array(
							'px' => array(
								'step' => 1,
								'min'  => 1,
								'max'  => 50,
							),
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .featured.plan-feature' => 'border-width: 0 0 {{SIZE}}px 0; border-style: solid',
						),
					)
				);

				$this->add_control(
					'features_border_color_featured',
					array(
						'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price-tables .featured .plan-feature' => 'border-color: {{VALUE}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/price-tables/render-price-tables-elementor.php' );
	}

	protected function content_template() {
		?>
		<#
		var wrapper_cls = 'price-tables';

		if ( 'lg' == settings.col_sp || '' == settings.col_sp ) {
			wrapper_cls += ' gutter-lg';
		} else {
			wrapper_cls += ' gutter-' + settings.col_sp;
		}
		
		<?php
			alpha_elementor_grid_template();
		?>
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
		wrapper_cls += ' ' + alpha_get_col_class( col_cnt );

		var table_cls  = 'price-table';
		table_cls += ' ' + settings.price_table_type + '-type';
		if ( 'yes' == settings.feature_divider ) {
			table_cls += ' features-separated';
		}

		var html = '<div class="' + wrapper_cls +  '">';

		_.each( settings.tables, function( table, index ) {

			var repeater_cls = ' elementor-repeater-item-' + table._id;
			html +=  '<div class="grid-col">';
			html +=  '<div class="' + table_cls + repeater_cls  + ( 'yes' == table.best_option ? ' featured' : ' standard' ) + '">';
			html +=  '<div class="plan-header">';

			var settingKey = view.getRepeaterSettingKey( 'name', 'tables', index );
			view.addRenderAttribute( settingKey, 'class', 'plan-name' );
			view.addInlineEditingAttributes( settingKey );

			html += '<h3 ' +  view.getRenderAttributeString( settingKey ) + '>' + table.name + '</h3>';

			if ( table.desc && 'mini' != settings.price_table_type ) {
				settingKey = view.getRepeaterSettingKey( 'desc', 'tables', index );
				view.addRenderAttribute( settingKey, 'class', 'plan-desc' );
				view.addInlineEditingAttributes( settingKey );

				html += '<p ' +  view.getRenderAttributeString( settingKey ) + '>' + table.desc + '</p>';
			}

			html += '</div>';

			if ( table.desc && 'mini' == settings.price_table_type ) {
				settingKey = view.getRepeaterSettingKey( 'desc', 'tables', index );
				view.addRenderAttribute( settingKey, 'class', 'plan-desc' );
				view.addInlineEditingAttributes( settingKey );

				html += '<p ' +  view.getRenderAttributeString( settingKey ) + '>' + table.desc + '</p>';
			}


			html += '<div class="plan-price">';
			html += table.currency ? ( '<span class="currency">' + table.currency + '</span>' ) : '';
			html += table.price_value ? table.price_value : '29.99';
			html += table.price_suffix ? ( '<p class="price-suffix">' + table.price_suffix + '</p>' ) : '';
			html += '</div>';

			var features = table.features_list.split( "\n" );
			if ( features.length ) {
				html += '<ul class="plan-features">';

				_.each( features, function( feature ) {
					html += '<li class="plan-feature">';
					html += feature;
					html += '</li>';
				} );

				html += '</ul>';
			}

			var settingKey = view.getRepeaterSettingKey( 'button_label', 'tables', index );
			view.addInlineEditingAttributes( settingKey );

			<?php
				alpha_elementor_button_template();
			?>

			html += '<div class="plan-footer">';

			var button_label = alpha_widget_button_get_label( table, view, table.button_label, settingKey );
			var btn_class    = alpha_widget_button_get_class( table );
			btn_class = 'btn ' + btn_class.join(' ');
			html        += '<a class="' + btn_class + '" href="' + ( table['link']['url'] ? '#' : table['link']['url'] ) + '">' + button_label + '</a>';

			html += '</div>';

			html += '</div>';
			html += '</div>';
		} );

		html += '</div>';

		print( html );
		#>
		<?php
	}
}
