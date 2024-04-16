<?php
/**
 * Extending sidebar widget features
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Sidebar_Builder_Extend' ) ) {
	class Alpha_Sidebar_Builder_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// add_filter( 'alpha_sidebar_widgets', array( $this, 'remove_sidebar_widgets' ) );
		}

		/**
		 * Remove Sidebar widgets
		 *
		 * @since 1.0
		 */
		public function remove_sidebar_widgets( $widgets ) {
			return array_diff( $widgets, array( 'posts_nav' ) );
		}
	}
}

new Alpha_Sidebar_Builder_Extend;
