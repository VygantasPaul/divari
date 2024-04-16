<?php
/**
 * Alpha Elementor Single Product Image Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class Alpha_Single_Product_Image_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_image';
	}

	public function get_title() {
		return esc_html__( 'Product Images', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-product-images';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'image', 'thumbnail', 'gallery' );
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_gallery_content',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'label'   => esc_html__( 'Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''           => esc_html__( 'Featured', 'pandastore-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'pandastore-core' ),
						'vertical'   => esc_html__( 'Vertical', 'pandastore-core' ),
						'grid'       => esc_html__( 'Grid', 'pandastore-core' ),
						'masonry'    => esc_html__( 'Masonry', 'pandastore-core' ),
						'gallery'    => esc_html__( 'Gallery', 'pandastore-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'col_cnt',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Columns', 'pandastore-core' ),
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'pandastore-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_xl',
				array(
					'label'     => esc_html__( 'Columns ( >= 1200px )', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'pandastore-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_min',
				array(
					'label'     => esc_html__( 'Columns ( < 576px )', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'pandastore-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_sp',
				array(
					'label'     => esc_html__( 'Spacing', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'md',
					'options'   => apply_filters(
						'alpha_col_sp',
						array(
							'no' => esc_html__( 'No space', 'pandastore-core' ),
							'xs' => esc_html__( 'Extra Small', 'pandastore-core' ),
							'sm' => esc_html__( 'Small', 'pandastore-core' ),
							'md' => esc_html__( 'Medium', 'pandastore-core' ),
							'lg' => esc_html__( 'Large', 'pandastore-core' ),
						),
						'elementor'
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_gallery_style',
			array(
				'label' => esc_html__( 'Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '.woocommerce .elementor-element-{{ID}} .woocommerce-product-gallery__image img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .woocommerce-product-gallery__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_thumbs_style',
			array(
				'label'     => esc_html__( 'Thumbnails', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'thumbs_border',
				'selector' => '.woocommerce .elementor-element-{{ID}} .product-thumb img',
			)
		);

		$this->add_responsive_control(
			'thumbs_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .product-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'spacing_thumbs',
			array(
				'label'      => esc_html__( 'Spacing', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .product-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);
	}

	public function get_gallery_type() {
		return $this->get_settings_for_display( 'sp_type' );
	}

	public function extend_gallery_class( $classes ) {
		$settings              = $this->get_settings_for_display();
		$single_product_layout = $settings['sp_type'];
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
			$classes[]        = alpha_get_col_class( alpha_elementor_grid_col_cnt( $settings ) );
			$grid_space_class = alpha_get_grid_space_class( $settings );
			if ( $grid_space_class ) {
				$classes[] = $grid_space_class;
			}
		}

		return $classes;
	}

	public function extend_gallery_type_class( $class ) {
		$settings         = $this->get_settings_for_display();
		$class            = ' ' . alpha_get_col_class( alpha_elementor_grid_col_cnt( $settings ) );
		$grid_space_class = alpha_get_grid_space_class( $settings );
		if ( $grid_space_class ) {
			$class .= ' ' . $grid_space_class;
		}
		return $class;
	}

	public function extend_gallery_type_attr( $attr ) {
		$settings              = $this->get_settings_for_display();
		$settings['show_nav']  = 'yes';
		$settings['show_dots'] = 'yes';
		$attr                 .= ' data-slider-options="' . esc_attr(
			json_encode(
				alpha_get_slider_attrs( $settings, alpha_elementor_grid_col_cnt( $settings ) )
			)
		) . '"';
		return $attr;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}

	protected function render() {

		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			$sp_type = $this->get_settings_for_display( 'sp_type' );

			add_filter( 'alpha_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			add_filter( 'alpha_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				add_filter( 'alpha_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				add_filter( 'alpha_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			woocommerce_show_product_images();

			remove_filter( 'alpha_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			remove_filter( 'alpha_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				remove_filter( 'alpha_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				remove_filter( 'alpha_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
