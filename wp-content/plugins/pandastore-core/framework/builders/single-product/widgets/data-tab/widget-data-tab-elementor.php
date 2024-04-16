<?php
/**
 * Alpha Elementor Single Product Data_tab Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Alpha_Single_Product_Data_Tab_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_data_tab';
	}

	public function get_title() {
		return esc_html__( 'Product Data Tabs', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-product-tabs';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'data_tab' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_data_tab',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'sp_tab_type',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Type', 'pandastore-core' ),
					'default' => 'theme',
					'options' => array(
						'theme'     => esc_html__( 'Theme Option', 'pandastore-core' ),
						'tab'       => esc_html__( 'Tab', 'pandastore-core' ),
						'accordion' => esc_html__( 'Accordion', 'pandastore-core' ),
						'section'   => esc_html__( 'Section', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'sp_tab_link_align',
				array(
					'label'     => esc_html__( 'Align', 'pandastore-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .wc-tabs > .tabs' => 'justify-content: {{VALUE}};',
					),
					'condition' => array(
						'sp_tab_type' => array( '', 'theme' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_tab_link_typo',
					'label'    => esc_html__( 'Link Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a',
				)
			);

			$this->start_controls_tabs( 'sp_share_tabs' );
				$this->start_controls_tab(
					'sp_tab_link_tab',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'sp_tab_link_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .wc-tabs>.card',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_tab_link_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_hover_color',
						array(
							'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .card-header a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_hover_bg_color',
						array(
							'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .card-header a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'label'    => esc_html__( 'Hover Border Type', 'pandastore-core' ),
							'name'     => 'sp_tab_link_hover_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .wc-tabs>.card:hover a',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_tab_link_active_tab',
					array(
						'label' => esc_html__( 'Active', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_active_color',
						array(
							'label'     => esc_html__( 'Active Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card-header .collapse' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_active_bg_color',
						array(
							'label'     => esc_html__( 'Active Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card-header .collapse' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'label'    => esc_html__( 'Active Border Type', 'pandastore-core' ),
							'name'     => 'sp_tab_link_active_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card.active',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'sp_tab_link_dimen',
				array(
					'label'      => esc_html__( 'Link Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'sp_tab_content_dimen',
				array(
					'label'      => esc_html__( 'Content Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .panel.woocommerce-Tabs-panel'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	public function get_tab_type( $type ) {
		$sp_type = $this->get_settings_for_display( 'sp_tab_type' );
		if ( 'theme' == $sp_type ) {
			return $type;
		}
		return $sp_type;
	}

	protected function render() {

		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			add_filter( 'alpha_single_product_data_tab_type', array( $this, 'get_tab_type' ), 20 );

			woocommerce_output_product_data_tabs();

			remove_filter( 'alpha_single_product_data_tab_type', array( $this, 'get_tab_type' ), 20 );

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
