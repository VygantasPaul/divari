<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Elementor Shop Filter Toggle Widget
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Shop_Filter_Toggle_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_shop_widget_filter_toggle';
	}

	public function get_title() {
		return esc_html__( 'Filter Toggle', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_shop_widget' );
	}

	public function get_keywords() {
		return array( 'filter-toggle', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-eye';
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
			'section_filter_toggle',
			array(
				'label' => esc_html__( 'Filter', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'sidebar',
				array(
					'label'   => esc_html__( 'Sidebar', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						''      => esc_html__( 'Not selected', 'pandastore-core' ),
						'top'   => esc_html__( 'Top Sidebar', 'pandastore-core' ),
						'left'  => esc_html__( 'Left Sidebar', 'pandastore-core' ),
						'right' => esc_html__( 'Right Sidebar', 'pandastore-core' ),
					),
					'default' => '',
					'description' => esc_html__( 'Choose which sidebar to toggle.', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'label',
				array(
					'label'       => esc_html__( 'Label', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Filters', 'alplha-core' ),
				)
			);

			alpha_elementor_button_layout_controls( $this );

		$this->end_controls_section();

		alpha_elementor_button_style_controls( $this );

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$class = 'btn';
		$label = $atts['label'];

		if ( empty( $label ) ) {
			$label = esc_html__( 'Filters', 'pandastore-core' );
		}
		$label  = alpha_widget_button_get_label( $atts, $this, $label, 'label' );
		$class .= ' ' . implode( ' ', alpha_widget_button_get_class( $atts ) );

		if ( apply_filters( 'alpha_shop_builder_set_preview', false ) ) {

			if ( ! empty( $atts['sidebar'] ) ) {
				$toggle_class = $atts['sidebar'] . '-sidebar-toggle';
				// if ( $ts || $ls && ( empty( $alpha_layout['left_sidebar_type'] ) || 'offcanvas' != $alpha_layout['left_sidebar_type'] ) ) {
				// 	$toggle_class .= ' d-lg-none';
				// }
				printf( '<a href="#" class="' . esc_attr( $class ) . ' toolbox-toggle ' . esc_attr( $toggle_class ) . '">%1$s</a>', alpha_strip_script_tags( $label ) );
			}
		}

		do_action( 'alpha_shop_builder_unset_preview' );
	}

	protected function content_template() {}
}
