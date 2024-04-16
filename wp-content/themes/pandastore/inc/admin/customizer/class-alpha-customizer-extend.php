<?php
/**
 * Alpha Customizer
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Customizer_Extend' ) ) :


	class Alpha_Customizer_Extend {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_filter( 'alpha_customize_fields', array( $this, 'customize_fields_extend' ), 20 );
			add_filter( 'alpha_post_types', array( $this, 'post_types_extend' ), 10, 2 );
			add_filter( 'alpha_product_loop_types', array( $this, 'product_loop_types_extend' ), 10, 2 );
			add_filter( 'alpha_sp_types', array( $this, 'single_product_types_extend' ), 10, 2 );
			add_filter( 'alpha_pc_types', array( $this, 'product_category_types_extend' ), 10, 2 );

			// Add custom css vars
			add_filter( 'alpha_dynamic_style', array( $this, 'add_custom_vars' ) );

			// Enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'alpha-admin', alpha_framework_uri( '/admin/customizer/selective-refresh-extend' . ALPHA_JS_SUFFIX ), array( 'alpha-selective' ), ALPHA_VERSION, true );
		}

		/**
		 * Remove show information section from woocommerce/shop
		 *
		 * @since 1.0
		 */
		public function customize_fields_extend( $fields ) {
			if ( isset( $fields['show_info'] ) || isset( $fields['cs_product_show_info'] ) || isset( $fields['sold_by_label'] ) || isset( $fields['single_product_type'] ) ) {
				// Remove options
				$fields = array_diff_key(
					$fields,
					array(
						'show_info'            => '',
						'cs_product_show_info' => '',
						'sold_by_label'        => '',
						'quickview_thumbs'     => '',
						'show_in_box'          => '',
						'show_hover_shadow'    => '',
						'show_media_shadow'    => '',
						'category_show_icon'   => '',
					)
				);
				// Update options
				$fields['single_product_type'] = array_merge(
					$fields['single_product_type'],
					array(
						'choices' => '',
						'type'    => 'custom',
						'label'   => '<p style="margin-bottom: 20px; cursor: auto;">' . esc_html__( 'Create your single product template and manage it in Layout Builder', 'pandastore' ) . '</p>' .
						(
							class_exists( 'Alpha_Builders' ) ?
							'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template&' . ALPHA_NAME . '_template_type=product_layout' ) ) . '" target="_blank">' . esc_html__( 'Single Product Builder', 'pandastore' ) . '</a>' :
							'<p>' . sprintf( esc_html__( 'Please install %s Core Plugin', 'pandastore' ), ALPHA_DISPLAY_NAME ) . '</p>' .
							'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=default_plugins' ) ) . '" target="_blank">' . esc_html__( 'Install Plugins', 'pandastore' ) . '</a>'
						) .
						'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ) . '" target="_blank">' . esc_html__( 'Layout Builder', 'pandastore' ) . '</a>',
						'default' => '',
						'tooltip' => '',
					)
				);
				$fields['category_overlay']    = array_merge(
					$fields['category_overlay'],
					array(
						'active_callback' => array(
							array(
								'setting'  => 'category_type',
								'operator' => 'in',
								'value'    => array( 'simple', 'classic', 'banner' ),
							),
						),
					)
				);
			}

			// Remove unnecessary options
			$fields = array_diff_key(
				$fields,
				array(
					'cs_skin_title'               => '',
					'rounded_skin'                => '',
					'cs_product_reviews_form'     => '',
					'product_review_offcanvas'    => '',
					'cs_product_data'             => '',
					'product_data_type'           => '',
					'product_description_title'   => '',
					'product_specification_title' => '',
					'product_reviews_title'       => '',
					'cs_product_excerpt'          => '',
					'prod_excerpt_type'           => '',
					'prod_excerpt_length'         => '',
				)
			);

			// Product tab sticky
			$new_fields = array();
			foreach ( $fields as $key => $field ) {
				$new_fields[ $key ] = $field;
				if ( 'product_data_type' == $key ) {
					$new_fields['product_data_tab_sticky'] = array(
						'section'         => 'product_detail',
						'type'            => 'toggle',
						'label'           => esc_html__( 'Tab Sticky', 'pandastore' ),
						'active_callback' => array(
							array(
								'setting'  => 'product_data_type',
								'operator' => '==',
								'value'    => 'tab',
							),
						),
					);
				}
			}

			// Dim Color
			$new_fields['dim_color'] = array(
				'section'   => 'color',
				'type'      => 'color',
				'label'     => esc_html__( 'Dim Color', 'pandastore' ),
				'choices'   => array(
					'alpha' => true,
				),
				'transport' => 'postMessage',
			);

			// Custom stle for JosefinSans
			$mew_fields['font_alignment_title'] = array(
				'section' => 'typo',
				'type'    => 'custom',
				'default' => '<h3 class="options-custom-title">' . esc_html__( 'Text Alignment for Josefin Sans', 'pandastore' ) . '</h3>',
			);
			$new_fields['font_alignment']       = array(
				'section' => 'typo',
				'type'    => 'toggle',
				'label'   => esc_html__( 'Adjust text alignment', 'pandastore' ),
				'default' => false,
				'tooltip' => 'Text Alignment for Josefin Sans',
			);

			return $new_fields;
		}

		/**
		 * Post types extend
		 *
		 * @since 1.0
		 */
		public function post_types_extend( $post_types, $location ) {
			$array = array_diff_key(
				$post_types,
				array(
					'list-xs' => '',
					'mask'    => '',
				)
			);

			if ( 'theme' == $location ) {
				return array_merge(
					$array,
					array(
						'simple'  => ALPHA_ASSETS . '/images/options/post/simple.jpg',
						'plain'   => ALPHA_ASSETS . '/images/options/post/plain.jpg',
						'frame'   => ALPHA_ASSETS . '/images/options/post/frame.jpg',
						'overlap' => ALPHA_ASSETS . '/images/options/post/overlap.jpg',
					)
				);
			} elseif ( 'elementor' == $location ) {
				return array_merge(
					$array,
					array(
						'simple'  => 'assets/images/posts/post-6.jpg',
						'plain'   => 'assets/images/posts/post-7.jpg',
						'frame'   => 'assets/images/posts/post-8.jpg',
						'overlap' => 'assets/images/posts/post-9.jpg',
					)
				);
			} else {
				return $array;
			}
		}

		/**
		 * Product loop types extend
		 *
		 * @since 1.0
		 */
		public function product_loop_types_extend( $types, $location ) {
			if ( 'theme' == $location ) {
				$types = array(
					'product-4' => ALPHA_ASSETS . '/images/options/products/product-sm-1.jpg',
					'product-8' => ALPHA_ASSETS . '/images/options/products/product-sm-2.jpg',
					'product-1' => ALPHA_ASSETS . '/images/options/products/product-sm-3.jpg',
					'product-6' => ALPHA_ASSETS . '/images/options/products/product-sm-4.jpg',
					'product-3' => ALPHA_ASSETS . '/images/options/products/product-sm-5.jpg',
				);
			}

			if ( 'elementor' == $location ) {
				$types = array(
					'product-4' => 'assets/images/products/product-1.jpg',
					'product-8' => 'assets/images/products/product-2.jpg',
					'product-1' => 'assets/images/products/product-3.jpg',
					'product-6' => 'assets/images/products/product-4.jpg',
					'product-3' => 'assets/images/products/product-5.jpg',
					'widget'    => 'assets/images/products/product-widget.jpg',
					'list'      => 'assets/images/products/product-list.jpg',
				);
			}

			return $types;
		}

		/**
		 * Single product types extend
		 *
		 * @since 1.0
		 */
		public function single_product_types_extend( $types, $location ) {
			if ( 'layout' == $location ) {
				$types = array(
					''        => esc_html__( 'Default', 'pandastore' ),
					'builder' => esc_html__( 'Use Builder', 'pandastore' ),
				);
			}
			return $types;
		}

		/**
		 * Product category types extend
		 *
		 * @since 1.0
		 */
		public function product_category_types_extend( $types, $location ) {
			if ( 'theme' == $location ) {
				$types = array(
					'simple'    => ALPHA_ASSETS . '/images/options/categories/category-1.jpg',
					'icon'      => ALPHA_ASSETS . '/images/options/categories/category-2.jpg',
					'classic'   => ALPHA_ASSETS . '/images/options/categories/category-3.jpg',
					'ellipse-2' => ALPHA_ASSETS . '/images/options/categories/category-4.jpg',
					'banner'    => ALPHA_ASSETS . '/images/options/categories/category-5.jpg',
				);
			} elseif ( 'elementor' == $location ) {
				$types = array(
					'simple'    => 'assets/images/categories/category-1.jpg',
					'icon'      => 'assets/images/categories/category-2.jpg',
					'classic'   => 'assets/images/categories/category-3.jpg',
					'ellipse-2' => 'assets/images/categories/category-4.jpg',
					'banner'    => 'assets/images/categories/category-5.jpg',
				);
			}
			return $types;
		}

		/**
		 * Add custmo vars
		 *
		 * @since 1.0
		 */
		public function add_custom_vars( $style ) {
			return $style . '--alpha-dim-color: ' . alpha_get_option( 'dim_color' ) . ';
						--alpha-dim-color-hover: #666;' . PHP_EOL;
		}
	}

endif;

new Alpha_Customizer_Extend;
