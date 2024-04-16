<?php
/**
 * Alpha Elementor Custom Advanced Tab
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;


use Elementor\Controls_Manager;

if ( ! class_exists( 'Alpha_Widget_Advanced_Tabs' ) ) {
	/**
	 * Advanced Alpha Advanced Tab
	 *
	 * @since 1.0
	 */
	class Alpha_Widget_Advanced_Tabs {
		const TAB_CUSTOM = 'alpha_custom_tab';

		private $custom_tabs;

		/**
		 * The constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Init Custom Tabs
			$this->init_custom_tabs();
			$this->register_custom_tabs();
		}

		/**
		 * init Custom Tab
		 *
		 * @since 1.0
		 */
		private function init_custom_tabs() {
			$this->custom_tabs = array();

			$this->custom_tabs[ $this::TAB_CUSTOM ] = ALPHA_DISPLAY_NAME;

			$this->custom_tabs = apply_filters( 'alpha_init_custom_tabs', $this->custom_tabs );
		}

		/**
		 * register Custom Tab
		 *
		 * @since 1.0
		 */
		public function register_custom_tabs() {
			foreach ( $this->custom_tabs as $key => $value ) {
				Elementor\Controls_Manager::add_tab( $key, $value );
			}
		}
	}
	new Alpha_Widget_Advanced_Tabs;
}
