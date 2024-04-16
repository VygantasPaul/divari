<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Menu Widget
 *
 * Alpha Widget to display menu.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */


use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Alpha_Controls_Manager;

class Alpha_Subcategories_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_subcategories';
	}

	public function get_title() {
		return esc_html__( 'Subcategories List', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-nav-menu';
	}

	public function get_keywords() {
		return array( 'menu', 'dynamic', 'list', 'alpha' );
	}

	public function get_script_depends() {
		return array();
	}


	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->term_id ] = $item->name;
		}
		return $menu_items;
	}

	protected function _register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_list',
			array(
				'label' => esc_html__( 'List', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'list_type',
				array(
					'label'   => esc_html__( 'Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'pcat',
					'options' => array(
						'cat'  => esc_html__( 'Categories', 'pandastore-core' ),
						'pcat' => esc_html__( 'Product Categories', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'pandastore-core' ),
					'type'        => Alpha_Controls_Manager::AJAXSELECT2,
					'options'     => 'category',
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'cat',
					),
				)
			);

			$this->add_control(
				'product_category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'pandastore-core' ),
					'type'        => Alpha_Controls_Manager::AJAXSELECT2,
					'options'     => 'product_cat',
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'pcat',
					),
				)
			);

			$this->add_control(
				'show_subcategories',
				array(
					'type'    => Controls_Manager::SWITCHER,
					'label'   => esc_html__( 'Show Subcategories', 'pandastore-core' ),
					'default' => 'yes',
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Subcategories Count', 'pandastore-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 24,
						),
					),
					'description' => esc_html__( '0 value will show all categories.', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Hide Empty', 'pandastore-core' ),
					'separator' => 'after',
				)
			);

			$this->add_control(
				'list_style',
				array(
					'label'     => esc_html__( 'Style', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''          => esc_html__( 'Simple', 'pandastore-core' ),
						'underline' => esc_html__( 'Underline', 'pandastore-core' ),
					),
					'condition' => array(
						'show_subcategories' => 'yes',
					),
				)
			);

			$this->add_control(
				'view_all',
				array(
					'type'  => Controls_Manager::TEXT,
					'label' => esc_html__( 'View All Label', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'cat_delimiter',
				array(
					'type'      => Controls_Manager::TEXT,
					'label'     => esc_html__( 'Category Delimiter', 'pandastore-core' ),
					'default'   => '',
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-title::after' => "content: '{{value}}'",
						'.elementor-element-{{ID}} .subcat-title' => "margin-{$right}: 0;",
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_type_style',
			array(
				'label'     => esc_html__( 'Title', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_subcategories' => 'yes',
				),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typo',
					'selector' => '.elementor-element-{{ID}} .subcat-title',
				)
			);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'title_space',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Space', 'pandastore-core' ),
					'range'     => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-title' => "margin-{$right}: {{SIZE}}{{UNIT}};",
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_link_style',
			array(
				'label' => esc_html__( 'Link', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'link_typo',
					'selector' => '.elementor-element-{{ID}} .subcat-nav a',
				)
			);

			$this->add_control(
				'link_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link__hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a:hover, .elementor-element-{{ID}} .subcat-nav a:focus, .elementor-element-{{ID}} .subcat-nav a:visited' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link_space',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Space', 'pandastore-core' ),
					'range'     => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a' => "margin-{$right}: {{SIZE}}{{UNIT}};",
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/subcategories/render-subcategories-elementor.php' );
	}
}
