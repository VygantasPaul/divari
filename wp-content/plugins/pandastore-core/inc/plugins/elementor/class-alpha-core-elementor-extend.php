<?php
/**
 * Extending elementor partials
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

if ( ! class_exists( 'Alpha_Core_Elementor_Extend' ) ) {
	class Alpha_Core_Elementor_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'alpha_after_core_framework_plugins', array( $this, 'after_core_framework_plugins' ) );
			$this->update_partial_options();
			$this->update_elements_options();
		}

		/**
		 * Load extend assets
		 *
		 * @since 1.0
		 */
		public function after_core_framework_plugins() {
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_admin_extend_styles' ), 35 );
			if ( alpha_is_elementor_preview() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'load_preview_extend_scripts' ) );
			}
		}

		/**
		 * Load preview extend js
		 *
		 * @since 1.0
		 */
		public function load_preview_extend_scripts() {
			wp_enqueue_script( 'alpha-elementor-extend-js', ALPHA_CORE_INC_URI . '/plugins/elementor/assets/elementor-extend' . ALPHA_JS_SUFFIX, array(), ALPHA_CORE_VERSION, true );
		}

		/**
		 * Update partial options
		 *
		 * @since 1.0
		 */
		public function update_partial_options() {
			// Products options
			add_action( 'elementor/element/panda_widget_products/section_product_type/after_section_end', array( $this, 'update_products_opts' ) );
			// Testimonials options
			add_action( 'elementor/element/panda_widget_testimonial_group/testimonial_general/after_section_end', array( $this, 'update_testimonials_options' ) );
			// Grid options
			add_filter( 'alpha_product_loop_creative_types', array( $this, 'product_loop_creative_types' ), 10, 2 );
			// Products banner element
			add_action( 'elementor/element/panda_widget_products_banner/section_product_type/after_section_end', array( $this, 'update_products_opts' ) );
			// Remove Ribbon
			add_action( 'alpha_elementor_addon_controls', array( $this, 'update_addon_controls' ) );
		}

		/**
		 * Update products element options
		 *
		 * @since 1.0
		 */
		public function update_products_opts( $args ) {
			$args->remove_control( 'show_in_box' );
			$args->remove_control( 'show_hover_shadow' );
			$args->remove_control( 'show_media_shadow' );
			// $args->remove_control( 'show_info' );
			$args->remove_control( 'show_progress' );
		}

		/**
		 * Update testimonials element options
		 *
		 * @since 1.0
		 */
		public function update_testimonials_options( $args ) {
			$args->update_control(
				'testimonial_type',
				array(
					'default' => 'testimonial-1',
					'options' => array(
						'testimonial-1' => esc_html__( 'Type 1', 'pandastore-core' ),
						'testimonial-2' => esc_html__( 'Type 2', 'pandastore-core' ),
						'testimonial-3' => esc_html__( 'Type 3', 'pandastore-core' ),
						'testimonial-4' => esc_html__( 'Type 4', 'pandastore-core' ),
						'testimonial-5' => esc_html__( 'Type 5', 'pandastore-core' ),
					),
				)
			);
			$args->update_control(
				'testimonial_inverse',
				array(
					'condition' => array(
						'testimonial_type' => array( 'testimonial-1' ),
					),
				)
			);
			$args->remove_control( 'avatar_pos' );
			$args->remove_control( 'commenter_pos' );
			$args->remove_control( 'aside_commenter_pos' );
			$args->remove_control( 'rating_pos' );
			$args->remove_control( 'v_align' );
			$args->remove_control( 'star_icon' );
			$args->remove_control( 'h_align' );
		}

		/**
		 * Update creative product type options
		 *
		 * @since 1.0
		 */
		public function product_loop_creative_types( $types, $location ) {
			if ( 'elementor' == $location ) {
				$types = array(
					'product-4' => esc_html__( 'Type 1', 'pandastore-core' ),
					'product-8' => esc_html__( 'Type 2', 'pandastore-core' ),
					'product-1' => esc_html__( 'Type 3', 'pandastore-core' ),
					'product-6' => esc_html__( 'Type 4', 'pandastore-core' ),
					'product-3' => esc_html__( 'Type 5', 'pandastore-core' ),
					'widget'    => esc_html__( 'Widget', 'pandastore-core' ),
					'list'      => esc_html__( 'List', 'pandastore-core' ),
				);
			}

			return $types;
		}

		/**
		 * Update elements options
		 *
		 * @since 1.0
		 */
		public function update_elements_options() {
			// Accordion options
			add_action( 'elementor/element/section/section_accordion/after_section_end', array( $this, 'update_accordion_content_opts' ) );
			add_action( 'elementor/element/section/accordion_style/after_section_end', array( $this, 'update_accordion_style_opts' ) );
			// Tab options
			add_action( 'elementor/element/section/section_tab/after_section_end', array( $this, 'update_tab_content_opts' ) );
			add_action( 'elementor/element/section/tab_style/after_section_end', array( $this, 'update_tab_style_opts' ) );
			// Add shape divider
			add_action( 'elementor/shapes/additional_shapes', array( $this, 'add_shape_dividers_extend' ), 15 );
		}

		/**
		 * Update accordion options
		 *
		 * @since 1.0
		 */
		public function update_accordion_content_opts( $args ) {
			$args->update_control(
				'accordion_icon',
				array(
					'default' => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-angle-down-solid',
						'library' => 'alpha-icons',
					),
				)
			);
			$args->update_control(
				'accordion_active_icon',
				array(
					'default' => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-angle-up-solid',
						'library' => 'alpha-icons',
					),
				)
			);
		}

		/**
		 * Update accordion style options
		 *
		 * @since 1.0
		 */
		public function update_accordion_style_opts( $args ) {
			$args->update_control(
				'accordion_bd',
				array(
					'default' => array(),
				)
			);
			$args->update_control(
				'accordion_bd_color',
				array(
					'selectors' => array(
						'.elementor-element-{{ID}} .accordion' => 'border-color: {{VALUE}};',
						'.elementor-element-{{ID}} .card' => 'border-color: {{VALUE}};',
						'.elementor-element-{{ID}} .accordion-simple .card-body>div:before' => 'background: {{VALUE}};',
					),
				)
			);
		}

		/**
		 * Update tab content options
		 *
		 * @since 1.0
		 */
		public function update_tab_content_opts( $args ) {
			$args->update_control(
				'tab_navs_pos',
				array_merge(
					array(
						'label'     => esc_html__( 'Tab Navs Position', 'pandastore-core' ),
						'type'      => Controls_Manager::CHOOSE,
						'default'   => 'left',
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
						'condition' => array(
							'tab_type'    => '',
							'tab_h_type!' => 'outline2',
						),
					),
				)
			);
			$args->update_control(
				'tab_h_type',
				array(
					'options' => array(
						''         => esc_html__( 'Default', 'pandastore-core' ),
						'simple'   => esc_html__( 'Simple', 'pandastore-core' ),
						'solid1'   => esc_html__( 'Solid', 'pandastore-core' ),
						'outline2' => esc_html__( 'Outline', 'pandastore-core' ),
						'link'     => esc_html__( 'Underline', 'pandastore-core' ),
					),
				),
			);
			$args->update_control(
				'tab_v_type',
				array(
					'label'   => esc_html__( 'Tab Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''       => esc_html__( 'Default', 'pandastore-core' ),
						'simple' => esc_html__( 'Simple', 'pandastore-core' ),
					),
				),
			);
		}

		/**
		 * Update tab style options
		 *
		 * @since 1.0
		 */
		public function update_tab_style_opts( $args ) {
			$args->update_control(
				'nav_item_padding',
				array(
					'default' => array(
						'top'    => 12,
						'right'  => 30,
						'bottom' => 12,
						'left'   => 30,
					),
				)
			);
			$args->remove_control( 'nav_bd' );
			$args->remove_control( 'tab_br' );
			$args->update_control(
				'nav_bd_color',
				array(
					'condition' => array(
						'tab_h_type!' => array( '', 'solid1', 'solid2', 'simple' ),
					),
				)
			);
			$args->update_control(
				'nav_bd_hover_color',
				array(
					'condition' => array(
						'tab_h_type!' => array( '', 'solid1', 'solid2', 'simple' ),
					),
				)
			);
			$args->update_control(
				'nav_bd_active_color',
				array(
					'condition' => array(
						'tab_h_type!' => array( '', 'solid1', 'solid2', 'simple' ),
					),
				)
			);
		}

		/**
		 * Add extra shape dividers.
		 *
		 * @since 1.0
		 */
		public function add_shape_dividers_extend( $shapes ) {

			$shapes['alpha-shape6'] = array(
				'title'        => __( 'Panda Shape 1', 'pandastore-core' ),
				'has_negative' => true,
			);
			$shapes['alpha-shape7'] = array(
				'title'        => __( 'Panda Shape 2', 'pandastore-core' ),
				'has_negative' => true,
			);
			$shapes['alpha-shape8'] = array(
				'title'        => __( 'Panda Shape 3', 'pandastore-core' ),
				'has_negative' => true,
			);
			$shapes['alpha-wave6']  = array(
				'title'        => __( 'Panda Wave 1', 'pandastore-core' ),
				'has_negative' => true,
			);
			$shapes['alpha-wave7']  = array(
				'title'        => __( 'Panda Wave 2', 'pandastore-core' ),
				'has_negative' => true,
			);
			$shapes['alpha-wave8']  = array(
				'title'        => __( 'Panda Wave 3', 'pandastore-core' ),
				'has_negative' => true,
			);

			return $shapes;
		}

		/**
		 * Update elementor addon controls
		 *
		 * @since 1.0
		 */
		public function update_addon_controls( $self ) {
			$self->remove_control( 'alpha_widget_ribbon_section' );
		}

		/**
		 * Load extra admin preview styles
		 *
		 * @since 1.0
		 */
		public function load_admin_extend_styles() {
			wp_enqueue_style( 'alpha-elementor-admin-extend-style', ALPHA_CORE_INC_URI . '/plugins/elementor/assets/elementor-admin-extend.min.css' );
		}
	}
}

new Alpha_Core_Elementor_Extend;
