<?php
/**
 * Extending single product widget features
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Single_Product_Builder_Extend' ) ) {
	class Alpha_Single_Product_Builder_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_filter( 'alpha_single_product_widgets', array( $this, 'remove_single_product_widgets' ) );
		}

		/**
		 * Remove Sidebar widgets
		 *
		 * @since 1.0
		 */
		public function remove_single_product_widgets( $widgets ) {
			$remove_widgets = array( 'fbt', 'vendor_products' );
			foreach ( $remove_widgets as $widget_name ) {
				$widgets[ $widget_name ] = false;
			}
			return $widgets;
		}
	}
}

new Alpha_Single_Product_Builder_Extend;
