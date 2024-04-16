<?php
/**
 * Alpha Elementor Single Product Flash Sale Widget
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Alpha_Single_Product_Flash_Sale_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_flash_sale';
	}

	public function get_title() {
		return esc_html__( 'Product Flash Sale', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-countdown';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'flash', 'sale', 'countdown' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_flash_style',
			array(
				'label' => esc_html__( 'Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'sp_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-countdown-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_end_style',
			array(
				'label'     => esc_html__( 'Label', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_ends_typo',
				'selector' => '.elementor-element-{{ID}} .countdown-wrap"',
			)
		);

		$this->add_control(
			'sp_ends_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-wrap' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_period_style',
			array(
				'label'     => esc_html__( 'Period', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_amount_typo',
				'selector' => '.elementor-element-{{ID}} .countdown-amount',
			)
		);

		$this->add_control(
			'sp_amount_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			global $product;

			if ( function_exists( 'alpha_single_product_sale_countdown' ) ) {
				alpha_single_product_sale_countdown();
			}

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
