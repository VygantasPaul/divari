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
use Elementor\Alpha_Controls_Manager;

class Alpha_Products_Single_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_products_single';
	}

	public function get_title() {
		return esc_html__( 'Products + Single', 'pandastore-core' );
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

		alpha_elementor_products_layout_controls( $this, 'custom_layouts' );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'sp_id',
				array(
					'label'       => esc_html__( 'Select a Product', 'pandastore-core' ),
					'type'        => Alpha_Controls_Manager::AJAXSELECT2,
					'options'     => 'product',
					'label_block' => true,
				)
			);

			$this->add_control(
				'sp_insert',
				array(
					'label'   => esc_html__( 'Single Product Index', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => array(
						'1'    => '1',
						'2'    => '2',
						'3'    => '3',
						'4'    => '4',
						'5'    => '5',
						'6'    => '6',
						'7'    => '7',
						'8'    => '8',
						'9'    => '9',
						'last' => esc_html__( 'At last', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'       => esc_html__( 'Title Tag', 'pandastore-core' ),
					'description' => esc_html__( 'Choose product name’s tag: H1, H2, H3, H4, H5, H6.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default'     => 'h2',
				)
			);

			$this->add_control(
				'sp_gallery_type',
				array(
					'label'       => esc_html__( 'Gallery Type', 'pandastore-core' ),
					'description' => esc_html__( 'Choose single product gallery type from presets.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''           => esc_html__( 'Default', 'pandastore-core' ),
						'vertical'   => esc_html__( 'Vertical', 'pandastore-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'pandastore-core' ),
						'grid'       => esc_html__( 'Grid Images', 'pandastore-core' ),
						'masonry'    => esc_html__( 'Masonry', 'pandastore-core' ),
						'gallery'    => esc_html__( 'Gallery', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'sp_sales_type',
				array(
					'label'       => esc_html__( 'Sales Type', 'pandastore-core' ),
					'description' => esc_html__( 'Choose position of sale countdown.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''        => esc_html__( 'In Summary', 'pandastore-core' ),
						'gallery' => esc_html__( 'In Gallery', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'sp_vertical',
				array(
					'label'       => esc_html__( 'Show Vertical', 'pandastore-core' ),
					'description' => esc_html__( 'Choose to show single product vertically.', 'pandastore-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => 'yes',
				)
			);

		$this->add_control(
			'sp_show_in_box',
			array(
				'label'       => esc_html__( 'Show In Box', 'pandastore-core' ),
				'description' => esc_html__( 'Choose to show outline border around single product.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
			)
		);

			$this->add_control(
				'sp_show_info',
				array(
					'type'        => Controls_Manager::SELECT2,
					'label'       => esc_html__( 'Show Information', 'pandastore-core' ),
					'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'pandastore-core' ),
					'multiple'    => true,
					'default'     => array( 'gallery', 'title', 'meta', 'price', 'rating', 'excerpt', 'addtocart_form', 'share', 'wishlist', 'compare', 'divider' ),
					'options'     => array(
						'gallery'        => esc_html__( 'Gallery', 'pandastore-core' ),
						'title'          => esc_html__( 'Title', 'pandastore-core' ),
						'meta'           => esc_html__( 'Meta', 'pandastore-core' ),
						'price'          => esc_html__( 'Price', 'pandastore-core' ),
						'rating'         => esc_html__( 'Rating', 'pandastore-core' ),
						'excerpt'        => esc_html__( 'Description', 'pandastore-core' ),
						'addtocart_form' => esc_html__( 'Add To Cart Form', 'pandastore-core' ),
						'divider'        => esc_html__( 'Divider In Cart Form', 'pandastore-core' ),
						'share'          => esc_html__( 'Share', 'pandastore-core' ),
						'wishlist'       => esc_html__( 'Wishlist', 'pandastore-core' ),
						'compare'        => esc_html__( 'Compare', 'pandastore-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'sp_col_cnt',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_xl',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_min',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_sp',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_products_select_controls( $this );

		alpha_elementor_product_type_controls( $this );

		alpha_elementor_single_product_style_controls( $this );

		alpha_elementor_slider_style_controls( $this, 'layout_type' );

		// alpha_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/products/render-products-single-elementor.php' );
	}

	protected function content_template() {}
}
