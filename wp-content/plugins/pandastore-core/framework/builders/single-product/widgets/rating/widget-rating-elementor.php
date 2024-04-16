<?php
/**
 * Alpha Elementor Single Product Ratings Widget
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Alpha_Single_Product_Rating_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_rating';
	}

	public function get_title() {
		return esc_html__( 'Product Rating', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-product-rating';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'rating', 'reviews' );
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
			'section_product_rating',
			array(
				'label' => esc_html__( 'Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'label'   => esc_html__( 'Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'star',
					'options' => array(
						'star'   => esc_html__( 'Star', 'pandastore-core' ),
						'number' => esc_html__( 'Number', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'sp_align',
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
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'sp_number_typo',
					'label'     => esc_html__( 'Typography', 'pandastore-core' ),
					'selector'  => '.elementor-element-{{ID}} .woocommerce-product-rating',
					'condition' => array(
						'sp_type' => 'number',
					),
				)
			);

			$this->add_control(
				'stars_text_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'number',
					),
				)
			);

			$this->add_control(
				'heading_star_style',
				array(
					'label'     => esc_html__( 'Star', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'     => esc_html__( 'Size', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_space',
				array(
					'label'     => esc_html__( 'Spacing', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 50,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'letter-spacing: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_unmarked_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating span:after' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_color',
				array(
					'label'     => esc_html__( 'Black Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating:before' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'sp_reviews',
				array(
					'label'     => esc_html__( 'Reviews', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'pandastore-core' ),
					'label_on'  => esc_html__( 'Show', 'pandastore-core' ),
					'default'   => 'yes',
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'sp_review_typo',
					'label'     => esc_html__( 'Typography', 'pandastore-core' ),
					'selector'  => '.elementor-element-{{ID}} .woocommerce-review-link',
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

			$this->add_control(
				'sp_review_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-review-link' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			$settings = $this->get_settings_for_display();

			if ( 'number' == $settings['sp_type'] ) {
				add_filter( 'alpha_single_product_rating_show_number', '__return_true' );
			}
			if ( '' == $settings['sp_reviews'] ) {
				add_filter( 'alpha_single_product_show_review', '__return_false' );
			}

			woocommerce_template_single_rating();

			if ( 'number' == $settings['sp_type'] ) {
				remove_filter( 'alpha_single_product_rating_show_number', '__return_true' );
			}
			if ( '' == $settings['sp_reviews'] ) {
				remove_filter( 'alpha_single_product_show_review', '__return_false' );
			}

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
