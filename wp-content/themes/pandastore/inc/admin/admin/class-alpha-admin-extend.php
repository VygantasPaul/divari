<?php
/**
 * Panda Admin Extend
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Admin_Extend' ) ) {
	class Alpha_Admin_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_filter( 'alpha_admin_config', array( $this, 'update_admin_config' ) );
			add_filter( 'alpha_demo_types', array( $this, 'update_demo_types' ) );
		}

		/**
		 * Update admin config
		 *
		 * @since 1.0
		 */
		public function update_admin_config( $admin_config ) {
			return $admin_config;
		}

		/**
		 * Update demo types.
		 *
		 * @return array The demos array.
		 * @since 1.0
		 */
		public function update_demo_types() {
			return array(
				'demo1'  => array(
					'alt'     => 'Demo 1',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-1.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo2'  => array(
					'alt'     => 'Demo 2',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-2.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo3'  => array(
					'alt'     => 'Demo 3',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-3.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo4'  => array(
					'alt'     => 'Demo 4',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-4.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo5'  => array(
					'alt'     => 'Demo 5',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-5.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo6'  => array(
					'alt'     => 'Demo 6',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-6.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo7'  => array(
					'alt'     => 'Demo 7',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-7.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo8'  => array(
					'alt'     => 'Demo 8',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-8.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo9'  => array(
					'alt'     => 'Demo 9',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-9.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
				'demo10' => array(
					'alt'     => 'Demo 10',
					'img'     => ALPHA_ASSETS . '/images/admin/setup-wizard/demo-10.jpg',
					'filter'  => 'food-grocery',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor' ),
				),
			);
		}
	}
}

new Alpha_Admin_Extend;
