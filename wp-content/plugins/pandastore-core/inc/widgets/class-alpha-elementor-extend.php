<?php
/**
 * Extending widget features
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! class_exists( 'Alpha_Elementor_Extend' ) ) {
	class Alpha_Elementor_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			$this->update_elementor_widget_options();
			// Remove unnecessary widgets
			add_filter( 'alpha_elementor_widgets', array( $this, 'remove_widgets' ) );
		}

		/**
		 * Update elementor widget options
		 *
		 * @since 1.0
		 */
		public function update_elementor_widget_options() {
			// Products element
			add_action( 'elementor/element/panda_widget_products/section_product_type/after_section_end', array( $this, 'update_widget_products_options' ) );
			add_action( 'elementor/element/panda_widget_products_tab/section_product_type/after_section_end', array( $this, 'update_widget_products_options' ) );
			add_action( 'elementor/element/panda_widget_products_banner/section_product_type/after_section_end', array( $this, 'update_widget_products_options' ) );
			add_action( 'elementor/element/panda_widget_shop_widget_products/section_product_type/after_section_end', array( $this, 'update_widget_products_options' ) );
			// Post element
			add_action( 'elementor/element/panda_widget_posts/section_style_content/after_section_end', array( $this, 'update_widget_posts_options' ) );
			// Category element
			add_action( 'elementor/element/panda_widget_categories/section_style_content/after_section_end', array( $this, 'update_widget_categories_options' ) );
			add_action( 'elementor/element/panda_widget_categories/section_style_button/after_section_end', array( $this, 'remove_widget_categories_button_style' ) );
			// Hotspot element
			add_action( 'elementor/element/panda_widget_hotspot/section_hotspot/after_section_start', array( $this, 'add_widget_hotspot_options' ) );
			add_action( 'elementor/element/panda_widget_hotspot/style_hotspot/after_section_end', array( $this, 'update_widget_hotspot_options' ) );
			// Button element
			add_action( 'elementor/element/panda_widget_button/section_button_icon_style/before_section_end', array( $this, 'update_widget_buttons_options' ) );
			// Image box element
			add_action( 'elementor/element/panda_widget_imagebox/imagebox_content/before_section_end', array( $this, 'update_widget_image_box_options' ) );
			// Share element
			add_action( 'elementor/element/panda_widget_share/section_share_style/after_section_end', array( $this, 'update_widget_share_options' ) );
			// Countdown element
			add_action( 'elementor/element/panda_widget_countdown/countdown_dimension/after_section_end', array( $this, 'update_widget_countdown_options' ) );
			// Search element
			add_action( 'elementor/element/panda_widget_search/section_search_content/after_section_end', array( $this, 'update_widget_search' ) );
			add_action( 'elementor/element/panda_widget_search/section_general_style/after_section_end', array( $this, 'update_widget_search_style' ) );
		}

		/**
		 * Update products element options
		 *
		 * @since 1.0
		 */
		public function update_widget_products_options( $args ) {
			$args->remove_control( 'show_info' );
			$args->update_control(
				'desc_line_clamp',
				array(
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'follow_theme_option',
								'operator' => '==',
								'value'    => '',
							),
						),
					),
				)
			);
		}

		/**
		 * Update post element options
		 *
		 * @since 1.0
		 */
		public function update_widget_posts_options( $args ) {
			$args->remove_control( 'content_align' );
		}

		/**
		 * Update category element options
		 *
		 * @since 1.0
		 */
		public function update_widget_categories_options( $args ) {
			$args->update_control(
				'category_type',
				array(
					'default' => 'simple',
				)
			);
			$args->update_control(
				'content_top',
				array(
					'default' => array(
						'size' => '',
					),
				)
			);
			$args->update_control(
				'content_left',
				array(
					'default' => array(
						'size' => '',
					),
				)
			);
			$args->update_control(
				'overlay',
				array(
					'condition' => array(
						'category_type'       => array( 'simple', 'classic', 'banner' ),
						'follow_theme_option' => '',
					),
				)
			);
		}

		/**
		 * Remove category button style
		 *
		 * @since 1.0
		 */
		public function remove_widget_categories_button_style( $self ) {
			$self->remove_control( 'section_style_button' );
		}

		/**
		 * Update hotspot element options
		 *
		 * @since 1.0
		 */
		public function update_widget_hotspot_options( $args ) {
			$args->update_control(
				'icon',
				array(
					'condition' => array(
						'hotspot_type' => 'type1',
					),
				)
			);

			$args->update_responsive_control(
				'size',
				array(
					'default' => array(
						'size' => 32,
						'unit' => 'px',
					),
				)
			);

			$args->update_responsive_control(
				'icon_size',
				array(
					'default' => array(
						'size' => 18,
						'unit' => 'px',
					),
				)
			);

			$args->update_control(
				'spread_color',
				array(
					'default' => 'rgba(51,51,51,.4)',
				)
			);

			$args->update_control(
				'size',
				array(
					'selectors' => array(
						'.elementor-element-{{ID}} .hotspot-wrapper .hotspot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$args->update_control(
				'btn_color',
				array(
					'selectors' => array(
						'.elementor-element-{{ID}} .hotspot-wrapper .hotspot' => 'color: {{VALUE}};',
					),
				)
			);

			$args->update_control(
				'btn_back_color',
				array(
					'selectors' => array(
						'.elementor-element-{{ID}} .hotspot-wrapper .hotspot' => 'background-color: {{VALUE}};',
					),
				)
			);
		}

		/**
		 * Add hotspot element options
		 *
		 * @since 1.0
		 */
		public function add_widget_hotspot_options( $args ) {
			$args->add_control(
				'hotspot_type',
				array(
					'label'   => esc_html__( 'Hotspot Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'type1',
					'options' => array(
						'type1' => esc_html__( 'Type 1', 'pandastore-core' ),
						'type2' => esc_html__( 'Type 2', 'pandastore-core' ),
					),
				)
			);
		}

		/**
		 * Update buttons element options
		 *
		 * @since 1.0
		 */
		public function update_widget_buttons_options( $args ) {
			$args->start_controls_tabs(
				'tabs_icon_color',
				array(
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$args->start_controls_tab(
				'tab_icon_color_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Icon Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} i' => 'color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->start_controls_tab(
				'tab_icon_color_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_color_hover',
				array(
					'label'     => esc_html__( 'Hover Icon Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}}:hover i' => 'color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->start_controls_tab(
				'tab_icon_color_active',
				array(
					'label' => esc_html__( 'Active', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_color_active',
				array(
					'label'     => esc_html__( 'Active Icon Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}}:not(:focus):active i' => 'color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->end_controls_tabs();

			$args->add_control(
				'show_icon_background',
				array(
					'label'     => esc_html__( 'Show Icon Background?', 'pandastore-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$args->add_control(
				'icon_background_size',
				array(
					'label'     => esc_html__( 'Icon Background Size (px)', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'default'   => array(
						'size' => 37,
					),
					'selectors' => array(
						'.elementor-element-{{ID}} i' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px; border-radius: 50%;',
					),
					'condition' => array(
						'show_icon'            => 'yes',
						'show_icon_background' => 'yes',
					),
				)
			);

			$args->start_controls_tabs(
				'tabs_icon_background',
				array(
					'condition' => array(
						'show_icon'            => 'yes',
						'show_icon_background' => 'yes',
					),
				)
			);

			$args->start_controls_tab(
				'tab_icon_background_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_background_color',
				array(
					'label'     => esc_html__( 'Icon Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} i' => 'background-color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->start_controls_tab(
				'tab_icon_background_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_background_color_hover',
				array(
					'label'     => esc_html__( 'Hover Icon Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}}:hover i' => 'background-color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->start_controls_tab(
				'tab_icon_background_active',
				array(
					'label' => esc_html__( 'Active', 'pandastore-core' ),
				)
			);

			$args->add_control(
				'icon_background_color_active',
				array(
					'label'     => esc_html__( 'Active Icon Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}}:not(:focus):active i' => 'background-color: {{VALUE}};',
					),
				)
			);

			$args->end_controls_tab();

			$args->end_controls_tabs();

			$args->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'      => 'icon_box_shadow',
					'selector'  => '.elementor-element-{{ID}} i',
					'condition' => array(
						'show_icon'            => 'yes',
						'show_icon_background' => 'yes',
					),
				)
			);
		}

		/**
		 * Update image box element options
		 *
		 * @since 1.0
		 */
		public function update_widget_image_box_options( $args ) {
			$args->update_control(
				'title',
				array(
					'default' => 'Nunc id cursus me',
				)
			);

			$args->update_control(
				'subtitle',
				array(
					'default' => '',
				)
			);

			$args->update_control(
				'content',
				array(
					'default' => 'Lorem ipsum dolor sit amet, consecte ad <br/> et dolore magna aliqua.',
				)
			);

			$args->update_control(
				'type',
				array(
					'label'   => esc_html__( 'Imagebox Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'border',
					'options' => array(
						'border' => esc_html__( 'Default', 'pandastore-core' ),
						'round'  => esc_html__( 'Round', 'pandastore-core' ),
						'inner'  => esc_html__( 'Inner', 'pandastore-core' ),
						'aside'  => esc_html__( 'Aside', 'pandastore-core' ),
						'boxed'  => esc_html__( 'Boxed', 'pandastore-core' ),
					),
				)
			);

			$args->remove_control( 'visible_bottom' );

			$args->remove_control( 'invisible_top' );

			$args->update_control(
				'imagebox_align',
				array(
					'condition' => array( 'type!' => array( 'aside', 'round' ) ),
				)
			);
		}

		/**
		 * Update share element options
		 *
		 * @since 1.0
		 */
		public function update_widget_share_options( $args ) {
			$args->update_responsive_control(
				'col_space',
				array(
					'default' => array(
						'size' => 30,
						'unit' => 'px',
					),
				)
			);

			$args->update_responsive_control(
				'row_space',
				array(
					'default' => array(
						'size' => 30,
						'unit' => 'px',
					),
				)
			);
		}

		/**
		 * Update countdown element options
		 *
		 * @since 1.0
		 */
		public function update_widget_countdown_options( $args ) {
			$args->update_responsive_control(
				'item_spacing',
				array(
					'default' => '15',
				)
			);
		}

		/**
		 * Update search style.
		 *
		 * @since 1.0
		 */
		public function update_widget_search_style( $args ) {
			$args->update_control(
				'search_height',
				array(
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper .select-box, .elementor-element-{{ID}} .search-wrapper .btn-search, .elementor-element-{{ID}} .search-wrapper input.form-control' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);
		}
		/**
		 * Update search element options
		 *
		 * @since 1.0
		 */
		public function update_widget_search( $args ) {
			$args->update_control(
				'toggle_type',
				array(
					'condition' => array(
						'undefined_option' => 'true',
					),
				)
			);
			$args->add_control(
				'classic_type',
				array(
					'label'        => esc_html__( 'Classic Type', 'pandastore-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'rect',
					'options'      => array(
						'rect'  => esc_html__( 'Rectangle', 'pandastore-core' ),
						'round' => esc_html__( 'Rounded', 'pandastore-core' ),
					),
					'prefix_class' => 'hs-',
					'condition'    => array(
						'type' => '',
					),
				),
				array(
					'position' => array(
						'at' => 'after',
						'of' => 'type',
					),
				)
			);
		}

		/**
		 * Remove unnecessary widgets
		 *
		 * @since 1.0
		 */
		public function remove_widgets( $widgets ) {
			$remove_widgets = array( 'vendor' );
			foreach ( $remove_widgets as $widget_name ) {
				$widgets[ $widget_name ] = false;
			}
			return $widgets;
		}
	}
}

new Alpha_Elementor_Extend;
