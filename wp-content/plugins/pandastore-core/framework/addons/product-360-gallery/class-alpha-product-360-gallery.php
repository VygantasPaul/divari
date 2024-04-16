<?php
/**
 * Alpha Product 360 Degree Gallery Addon
 *
 * @author     D-THEMES
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @version    1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Product_360_Gallery' ) ) {
	class Alpha_Product_360_Gallery extends Alpha_Base {

		/**
		 * Constructor.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Add theme options to add gallery images
			add_filter( 'alpha_customize_fields', array( $this, 'add_customize_fields' ) );
			if ( function_exists( 'alpha_set_default_option' ) ) {
				alpha_set_default_option( '360_gallery', true );
			}
			add_filter(
				'alpha_customize_sections',
				function( $sections ) {
					$sections['360gallery'] = array(
						'title'    => esc_html__( '360 Gallery', 'pandastore-core' ),
						'priority' => 90,
						'panel'    => 'features',
					);
					return $sections;
				}
			);
			// Add metabox to add gallery images
			if ( function_exists( 'alpha_get_option' ) && alpha_get_option( '360_gallery' ) ) {
				add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes' ) );
				add_action( 'template_redirect', array( $this, 'add_frontend_actions' ) );
			}
		}

		/**
		 * Add fields for 360 gallery
		 *
		 * @param array $fields
		 * @since 1.0
		 */
		public function add_customize_fields( $fields ) {
			$fields['cs_360_gallery_about_title'] = array(
				'section' => '360gallery',
				'type'    => 'custom',
				'label'   => '',
				'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'pandastore-core' ) . '</h3>',
			);
			$fields['cs_360_gallery_about_desc']  = array(
				'section' => '360gallery',
				'type'    => 'custom',
				'label'   => esc_html__( 'You could add 360 degree thumbnail which has several images taken in various angles for product thumbnails except gallery images.', 'pandastore-core' ),
				'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . esc_url( ALPHA_ASSETS . '/images/admin/customizer/360gallery.jpg' ) . '" alt="Theme Option Descrpition Image"></p>',
			);
			$fields['cs_360_gallery_title']       = array(
				'section' => '360gallery',
				'type'    => 'custom',
				'label'   => '',
				'default' => '<h3 class="options-custom-title">' . esc_html__( '360 Degree Thumbnail', 'pandastore-core' ) . '</h3>',
			);
			$fields['360_gallery']                = array(
				'section' => '360gallery',
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable 360 degree thumbnail', 'pandastore-core' ),
			);
			return $fields;
		}

		/**
		 * Get post meta and render it in product view
		 *
		 * @since 1.0
		 */
		public function add_frontend_actions() {
			$this->images = get_post_meta( get_the_ID(), 'alpha_product_360_view', false );
			$images       = array();

			if ( $this->images ) {
				foreach ( $this->images as $image ) {
					$image_src = wp_get_attachment_image_src( $image, 'full' );
					if ( ! empty( $image_src[0] ) ) {
						$images[] = $image_src[0];
					}
				}
				$this->images = implode( ',', $images );

				add_action( 'alpha_single_product_gallery_buttons', array( $this, 'get_degree_viewer_btn' ), 20 );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 35 );
				add_filter( 'alpha_vars', array( $this, 'add_images_var' ) );
			}
		}

		/**
		 * Add meta boxes
		 *
		 * @since 1.0
		 * @access public
		 */
		public function add_meta_boxes( $meta_boxes ) {

			$meta_boxes[] = array(
				'id'         => 'alpha-product-360-view',
				'title'      => esc_html__( 'Product 360 View Gallery', 'pandastore-core' ),
				'post_types' => array( 'product' ),
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'id'   => 'alpha_product_360_view',
						'name' => esc_html__( 'Upload Images', 'pandastore-core' ),
						'type' => 'image_advanced',
					),
				),
			);

			return $meta_boxes;
		}

		/**
		 * Load 360 degree viewer style & script
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_style( 'alpha-product-360-gallery', alpha_core_framework_uri( '/addons/product-360-gallery/product-360-gallery.min.css' ), null, ALPHA_CORE_VERSION, 'all' );
			wp_enqueue_script( 'three-sixty' );
			wp_enqueue_script( 'alpha-product-360-gallery', alpha_core_framework_uri( '/addons/product-360-gallery/product-360-gallery' . ALPHA_JS_SUFFIX ), array( 'alpha-framework-async' ), ALPHA_CORE_VERSION, true );
		}

		/**
		 * Pass degree viewer images to js
		 *
		 * @since 1.0
		 */
		public function add_images_var( $vars ) {
			$vars['threesixty_data'] = $this->images;
			return $vars;
		}

		/**
		 * Print Degree viewer button in product image.
		 *
		 * @since 1.0
		 */
		public function get_degree_viewer_btn( $buttons ) {
			return $buttons . '<button class="product-gallery-btn open-product-degree-viewer ' . ALPHA_ICON_PREFIX . '-icon-repeat" aria-label="' . esc_html__( '360 degree', 'pandastore-core' ) . '" title="' . esc_html__( 'Product 360 Degree Gallery', 'pandastore-core' ) . '"></button>';
		}
	}
}

Alpha_Product_360_Gallery::get_instance();
