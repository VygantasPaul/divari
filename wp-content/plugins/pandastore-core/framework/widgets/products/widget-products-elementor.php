<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Products Widget
 *
 * Alpha Widget to display products.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

class Alpha_Products_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_products';
	}

	public function get_title() {
		return esc_html__( 'Products', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-product';
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		alpha_elementor_products_select_controls( $this );

		alpha_elementor_products_layout_controls( $this );

		alpha_elementor_product_type_controls( $this );

		alpha_elementor_slider_style_controls( $this, 'layout_type' );

		alpha_elementor_product_style_controls( $this );

		// alpha_elementor_loadmore_button_controls( $this, 'layout_type' );

	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/products/render-products.php' );
	}

	protected function content_template() {}
}
