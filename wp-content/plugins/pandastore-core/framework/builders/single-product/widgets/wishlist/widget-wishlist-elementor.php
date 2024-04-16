<?php
/**
 * Alpha Single Product Elementor Wishlist
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Alpha_Single_Product_Wishlist_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return  ALPHA_NAME . '_sproduct_wishlist';
	}

	public function get_title() {
		return esc_html__( 'Product Wishlist', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon ' . ALPHA_ICON_PREFIX . '-icon-heart';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'wishlist' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_wishlist_style',
			array(
				'label' => esc_html__( 'Wishlist', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'wishlist_align',
				array(
					'label'     => esc_html__( 'Align', 'pandastore-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'flex-start',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .yith-wcwl-add-button' => 'text-align: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'wishlist_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .yith-wcwl-add-to-wishlist a::before' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_wishlist_color' );
				$this->start_controls_tab(
					'tab_wishlist_normal',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'wishlist_color',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .yith-wcwl-add-to-wishlist a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_wishlist_hover',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

				$this->add_control(
					'wishlist_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .yith-wcwl-add-to-wishlist a:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {

		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			echo do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
