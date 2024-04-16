<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Brands Widget
 *
 * Alpha Widget to display brands.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Alpha_Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;


class Alpha_Brands_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_brands';
	}

	public function get_title() {
		return esc_html__( 'Brands', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'brands', 'brand', 'product' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-brand';
	}

	public function get_script_depends() {
		return array( 'swiper' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_brands',
			array(
				'label' => esc_html__( 'Brands Selector', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'brands',
				array(
					'label'       => esc_html__( 'Select Brands', 'pandastore-core' ),
					'description' => esc_html__( 'Choose your favourite brand.', 'pandastore-core' ),
					'type'        => Alpha_Controls_Manager::AJAXSELECT2,
					'options'     => 'product_brand',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Hide Empty', 'pandastore-core' ),
					'description' => esc_html__( 'Hide brand without any products', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Brands Count', 'pandastore-core' ),
					'description' => esc_html__( '0 value will show all brands.', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'orderby',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order By', 'pandastore-core' ),
					'description' => esc_html__( 'Defines how brands should be ordered: Default, ID, Name, Slug, Modified and so on.', 'pandastore-core' ),
					'default'     => 'name',
					'options'     => array(
						'name'        => esc_html__( 'Name', 'pandastore-core' ),
						'id'          => esc_html__( 'ID', 'pandastore-core' ),
						'slug'        => esc_html__( 'Slug', 'pandastore-core' ),
						'modified'    => esc_html__( 'Modified', 'pandastore-core' ),
						'count'       => esc_html__( 'Product Count', 'pandastore-core' ),
						'parent'      => esc_html__( 'Parent', 'pandastore-core' ),
						'description' => esc_html__( 'Description', 'pandastore-core' ),
						'term_group'  => esc_html__( 'Term Group', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'orderway',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order Way', 'pandastore-core' ),
					'description' => esc_html__( 'Defines brands ordering type: Ascending or Descending.', 'pandastore-core' ),
					'default'     => 'ASC',
					'options'     => array(
						'ASC'  => esc_html__( 'Ascending', 'pandastore-core' ),
						'DESC' => esc_html__( 'Descending', 'pandastore-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'       => esc_html__( 'Layout', 'pandastore-core' ),
					'description' => esc_html__( 'Choose brands layout type: Grid, Slider', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'grid',
					'options'     => array(
						'grid'   => esc_html__( 'Grid', 'pandastore-core' ),
						'slider' => esc_html__( 'Slider', 'pandastore-core' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'exclude' => [ 'custom' ],
					'default' => 'woocommerce_thumbnail',
				)
			);

			alpha_elementor_grid_layout_controls( $this, 'layout_type', false, 'has_rows' );

			$this->add_control(
				'slider_vertical_align',
				array(
					'label'       => esc_html__( 'Vertical Align', 'pandastore-core' ),
					'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'top'         => array(
							'title' => esc_html__( 'Top', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-top',
						),
						'middle'      => array(
							'title' => esc_html__( 'Middle', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'bottom'      => array(
							'title' => esc_html__( 'Bottom', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'same-height' => array(
							'title' => esc_html__( 'Stretch', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-stretch',
						),
					),
					'condition'   => array(
						'brand_type'  => '1',
						'layout_type' => 'slider',
					),
				)
			);

			$this->add_control(
				'slider_image_expand',
				array(
					'label'     => esc_html__( 'Image Full Width', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'slider',
					),
				)
			);

			$this->add_control(
				'slider_horizontal_align',
				array(
					'label'       => esc_html__( 'Horizontal Align', 'pandastore-core' ),
					'description' => esc_html__( 'Choose horizontal alignment of items.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
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
					'selectors'   => array(
						'.elementor-element-{{ID}} figure' => 'display: flex; justify-content:{{VALUE}}',
					),
					'condition'   => array(
						'brand_type'          => '1',
						'slider_image_expand' => '',
						'layout_type'         => 'slider',
					),
				)
			);

			$this->add_control(
				'grid_vertical_align',
				array(
					'label'       => esc_html__( 'Vertical Align', 'pandastore-core' ),
					'description' => esc_html__( 'Choose vertical alignment of items.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'flex-start' => array(
							'title' => esc_html__( 'Top', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-top',
						),
						'center'     => array(
							'title' => esc_html__( 'Middle', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Bottom', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'stretch'    => array(
							'title' => esc_html__( 'Stretch', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-stretch',
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} figure' => 'display: flex; align-items:{{VALUE}}; height: 100%;',
					),
					'condition'   => array(
						'brand_type'  => '1',
						'layout_type' => 'grid',
					),
				)
			);

			$this->add_control(
				'grid_image_expand',
				array(
					'label'     => esc_html__( 'Image Full Width', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'selectors' => array(
						'.elementor-element-{{ID}} figure a, .elementor-element-{{ID}} figure img' => 'width: 100%;',
					),
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'grid',
					),
				)
			);

			$this->add_control(
				'grid_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'pandastore-core' ),
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
						'.elementor-element-{{ID}} figure' => 'display: flex; justify-content:{{VALUE}}',
					),
					'condition' => array(
						'brand_type'        => '1',
						'grid_image_expand' => '',
						'layout_type'       => 'grid',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_brand_type',
			array(
				'label' => esc_html__( 'Brands Type', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'brand_type',
				array(
					'label'   => esc_html__( 'Display Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '3',
					'options' => array(
						'1' => esc_html__( 'Type 1', 'pandastore-core' ),
						'2' => esc_html__( 'Type 2', 'pandastore-core' ),
						'3' => esc_html__( 'Type 3', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'show_brand_rating',
				array(
					'label'     => esc_html__( 'Show Brand Rating', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'condition' => array(
						'brand_type' => array( '2', '3' ),
					),
				)
			);

			$this->add_control(
				'show_brand_products',
				array(
					'label'     => esc_html__( 'Show Brand Products', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'brand_type' => array( '3' ),
					),
				)
			);

		$this->end_controls_section();

		// Add brand style
		$this->start_controls_section(
			'section_brand_style',
			array(
				'label'     => esc_html__( 'Brand Style', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'brand_type' => array( '2', '3' ),
				),
			)
		);

			// Style for Brand name
			$this->add_control(
				'style_brand_name',
				array(
					'label' => esc_html__( 'Brand Name', 'pandastore-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->start_controls_tabs( 'brand_name_tabs' );
				$this->start_controls_tab(
					'brand_name_default_style',
					array(
						'label' => esc_html__( 'Default', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'brand_name_default_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .brand-name a' => 'color: {{VALUE}};',
							),
						)
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'brand_name_hover_style',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'brand_name_hover_color',
						array(
							'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .brand-name a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'brand_name_typo',
					'selector' => '.elementor-element-{{ID}} .brand-name',
				)
			);

			// Style for Product Count
			$this->add_control(
				'style_brand_product_count',
				array(
					'label'     => esc_html__( 'Product Count', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'brand_product_count_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .brand-product-count' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'brand_product_count_typo',
					'selector' => '.elementor-element-{{ID}} .brand-product-count',
				)
			);

		$this->end_controls_section();

		alpha_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/brands/render-brands-elementor.php' );
	}

}
