<?php
/**
 * Alpha Elementor Single Product Linked Products Widget
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Alpha_Single_Product_Linked_Products_Elementor_Widget extends Alpha_Products_Elementor_Widget {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_linked_products';
	}

	public function get_title() {
		return esc_html__( 'Linked Products', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-product-related';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'linked_products' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->remove_control( 'ids' );
		$this->remove_control( 'categories' );

		$this->update_control(
			'status',
			array(
				'label'   => esc_html__( 'Product Status', 'pandastore-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'related',
				'options' => array(
					'related' => esc_html__( 'Related Products', 'pandastore-core' ),
					'upsell'  => esc_html__( 'Upsell Products', 'pandastore-core' ),
				),
			)
		);
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			parent::render();
			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
