<?php
/**
 * Alpha Elementor Single Product Excerpt Widget
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Alpha_Single_Product_Excerpt_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_excerpt';
	}

	public function get_title() {
		return esc_html__( 'Product Excerpt', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-post-excerpt';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'excerpt' );
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
			'section_product_excerpt',
			array(
				'label' => esc_html__( 'Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} p',
				)
			);

			$this->add_control(
				'sp_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'pandastore-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justify', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			woocommerce_template_single_excerpt();
			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
