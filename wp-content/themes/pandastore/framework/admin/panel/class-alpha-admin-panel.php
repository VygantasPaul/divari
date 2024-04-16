<?php
/**
 * Alpha Admin Panel
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

/**
 * Alpha Admin Panel Class
 *
 * @since 1.0
 */
if ( ! class_exists( 'Alpha_Admin_Panel' ) ) {
	class Alpha_Admin_Panel extends Alpha_Base {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_admin_menus' ), 5 );
			add_action(
				'admin_enqueue_scripts',
				function () {
					wp_enqueue_script( 'admin-swiper', ALPHA_ASSETS . '/vendor/swiper/swiper' . ALPHA_JS_SUFFIX, array( 'jquery-core' ), '6.7.0', true );
				}
			);
		}

		/**
		 * Add admin menus
		 *
		 * @since 1.0
		 */
		public function add_admin_menus() {

			if ( current_user_can( 'edit_theme_options' ) ) {

				// Menu - alpha
				$title = alpha_get_option( 'white_label_title' );
				$icon  = alpha_get_option( 'white_label_icon' );
				// Theme-Check notice is displayed for WP.org theme devs, informing them to NOT use this.
				call_user_func(
					'add_menu_page',
					ALPHA_DISPLAY_NAME,
					$title ? $title : ALPHA_DISPLAY_NAME,
					'administrator',
					'alpha',
					array( $this, 'panel_activate' ),
					$icon ? $icon : 'dashicons-alpha-logo',
					'2'
				);

				// Menu - alpha / licence
				add_submenu_page( 'alpha', esc_html__( 'Dashboard', 'pandastore' ), esc_html__( 'Dashboard', 'pandastore' ), 'administrator', 'alpha', array( $this, 'panel_activate' ) ); // phpcs:ignore WPThemeReview.PluginTerritory.NoAddAdminPages

				// Menu - alpha / theme options
				add_submenu_page( 'alpha', esc_html__( 'Theme Options', 'pandastore' ), esc_html__( 'Theme Options', 'pandastore' ), 'administrator', 'customize.php', '' ); // phpcs:ignore WPThemeReview.PluginTerritory.NoAddAdminPages

				// Menu - alpha / layout builder
				if ( class_exists( 'Alpha_Layout_Builder_Admin' ) ) {
					add_submenu_page( 'alpha', esc_html__( 'Layout Builder', 'pandastore' ), esc_html__( 'Layout Builder', 'pandastore' ), 'manage_options', 'alpha-layout-builder', array( Alpha_Layout_Builder_Admin::get_instance(), 'view_layout_builder' ), 2 ); // phpcs:ignore WPThemeReview.PluginTerritory.NoAddAdminPages
				} else {
					add_submenu_page( 'alpha', esc_html__( 'Layout Builder', 'pandastore' ), esc_html__( 'Layout Builder', 'pandastore' ), 'manage_options', 'admin.php?page=alpha-layout-builder', '', 2 ); // phpcs:ignore WPThemeReview.PluginTerritory.NoAddAdminPages
				}
			}
		}

		/**
		 * Load header template for admin panel.
		 *
		 * @since 1.0
		 */
		public function view_header( $active_page, $admin_config = array(), $title = array() ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/header.php' );
		}

		/**
		 * Load footer template for admin panel.
		 *
		 * @since 1.0
		 */
		public function view_footer( $admin_config = array() ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/footer.php' );
		}

		/**
		 * Load license panel template.
		 *
		 * @since 1.0
		 */
		public function panel_activate() {

			$admin_config = Alpha_Admin::get_instance()->admin_config;
			$this->view_header( 'dashboard', $admin_config );
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/license.php' );
			$this->view_footer( $admin_config );
		}
	}
}

Alpha_Admin_Panel::get_instance();
