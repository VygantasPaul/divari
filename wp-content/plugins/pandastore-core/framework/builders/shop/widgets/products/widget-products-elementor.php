<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Elementor Shop Products Widget
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Shop_Products_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_shop_widget_products';
	}

	public function get_title() {
		return esc_html__( 'Shop Products', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_shop_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-products';
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		alpha_elementor_products_layout_controls( $this, 'shop_builder' );

		$this->start_controls_section(
			'load_more_section',
			array(
				'label' => esc_html__( 'Load More', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'loadmore_type',
				array(
					'label'   => esc_html__( 'Load More', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						'page'   => esc_html__( 'No', 'pandastore-core' ),
						'button' => esc_html__( 'By button', 'pandastore-core' ),
						'scroll' => esc_html__( 'By scroll', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'loadmore_label',
				array(
					'label'       => esc_html__( 'Load More Label', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => esc_html__( 'Load More', 'pandastore-core' ),
					'condition'   => array(
						'loadmore_type' => 'button',
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_product_type_controls( $this );

		$this->start_controls_section(
			'cat_style',
			array(
				'label' => esc_html__( 'Category', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'cat_color',
				array(
					'label'     => esc_html__( 'Category Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-cat' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cat_typography',
					'label'    => esc_html__( 'Category Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .product-cat',
				)
			);

			$this->add_responsive_control(
				'cat_margin',
				array(
					'label'      => esc_html__( 'Category Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Title Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-loop-product__title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Title Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .woocommerce-loop-product__title',
				)
			);

			$this->add_responsive_control(
				'title_margin',
				array(
					'label'      => esc_html__( 'Title Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'rating_style',
			array(
				'label' => esc_html__( 'Rating', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'rating_star_size',
				array(
					'label'     => esc_html__( 'Star Size (px)', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'font-size: {{SIZE}}px',
					),
				)
			);

			$this->add_control(
				'rating_star_color',
				array(
					'label'     => esc_html__( 'Star Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating span:after' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'review_count_color',
				array(
					'label'     => esc_html__( 'Review Count Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating + a' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'review_count_typography',
					'label'    => esc_html__( 'Review Count Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .star-rating + a',
				)
			);

			$this->add_responsive_control(
				'rating_margin',
				array(
					'label'      => esc_html__( 'Rating Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'price_style',
			array(
				'label' => esc_html__( 'Price', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'price_color',
				array(
					'label'     => esc_html__( 'Price Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .price' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'old_price_color',
				array(
					'label'     => esc_html__( 'Old Price Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .price del' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'price_typography',
					'label'    => esc_html__( 'Price Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .price',
				)
			);

			$this->add_responsive_control(
				'price_margin',
				array(
					'label'      => esc_html__( 'Price Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'attrs_style',
			array(
				'label' => esc_html__( 'Attribute', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'attrs_item_typography',
					'label'    => esc_html__( 'Attribute Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .product-variations > *:not(.color):not(.image)',
				)
			);

			$this->add_control(
				'attrs_item_size',
				array(
					'label'     => esc_html__( 'Item Size', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'min-width: {{SIZE}}px;min-height: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'attrs_item_padding',
				array(
					'label'      => esc_html__( 'Item Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'attrs_item_margin',
				array(
					'label'      => esc_html__( 'Item Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'attrs_wrapper_margin',
				array(
					'label'      => esc_html__( 'Wrapper Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-variation-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn_cat' );

			$this->start_controls_tab(
				'tab_btn_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'btn_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'btn_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'btn_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > *' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_btn_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'btn_color_hover',
				array(
					'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > :hover, .elementor-element-{{ID}} .product-variations > .active' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'btn_back_color_hover',
				array(
					'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > :hover, .elementor-element-{{ID}} .product-variations > .active' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'btn_border_color_hover',
				array(
					'label'     => esc_html__( 'Hover Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations > :hover, .elementor-element-{{ID}} .product-variations > .active' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		if ( apply_filters( 'alpha_shop_builder_set_preview', false ) ) {
			global $wp_query, $alpha_layout;

			$atts                    = $this->get_settings_for_display();
			$atts['is_shop_builder'] = true;
			$atts['count']           = array( 'size' => alpha_wc_get_loop_prop( 'per_page' ) );
			$atts['orderby']         = $wp_query->get( 'orderby' );
			$atts['widget']          = 'shop_products';

			$alpha_layout['is_shop_builder_rendering'] = true;

			alpha_products_widget_render( $atts );
		}

		do_action( 'alpha_shop_builder_unset_preview' );
	}

	protected function content_template() {}
}
