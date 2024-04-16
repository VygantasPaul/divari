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

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Alpha_Products_Banner_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_products_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner + Products', 'pandastore-core' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'banner' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-products';
	}

	protected function _register_controls() {

		alpha_elementor_banner_controls( $this, 'insert_number', true );

		alpha_elementor_products_layout_controls( $this, 'custom_layouts' );

		alpha_elementor_products_select_controls( $this );

		alpha_elementor_product_type_controls( $this );

		alpha_elementor_slider_style_controls( $this, 'layout_type' );

		// alpha_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/products/render-products-banner-elementor.php' );
	}

	protected function content_template() {}
}
