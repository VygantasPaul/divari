<?php
/**
 * Alpha Elementor Single Product Tags Widget
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

class Alpha_Single_Product_Tags_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'alpha_sproduct_tags';
	}

	public function get_title() {
		return esc_html__( 'Product Tags', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-tags';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'tags' );
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
			'section_product_tags',
			array(
				'label' => esc_html__( 'Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
							'title' => esc_html__( 'Justified', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags' => 'text-align: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_label_style',
				array(
					'label'     => esc_html__( 'Label', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .product-tags label',
				)
			);

			$this->add_control(
				'label_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags label' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'label_space',
				array(
					'label'      => esc_html__( 'Space (px)', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'body:not(.rtl) .elementor-element-{{ID}} .product-tags label' => 'margin-right: {{SIZE}}px;',
						'body.rtl .elementor-element-{{ID}} .product-tags label' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'heading_link_style',
				array(
					'label'     => esc_html__( 'Link', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'link_typography',
					'selector' => '.elementor-element-{{ID}} .product-tags > a',
				)
			);

			$this->start_controls_tabs( 'tags_link_cat' );

			$this->start_controls_tab(
				'tags_link_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'link_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'link_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'link_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tags_link_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'link_color_hover',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a:hover' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'link_border_color_hover',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a:hover' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'link_bg_color_hover',
				array(
					'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-tags > a:hover' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			global $product;

			echo alpha_strip_script_tags( wc_get_product_tag_list( $product->get_id(), '', '<div class="product-tags">' . _n( '<label>Tag:</label>', '<label>Tags:</label>', count( $product->get_tag_ids() ), 'pandastore-core' ) . ' ', '</div>' ) );

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
