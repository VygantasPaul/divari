<?php
/**
 * Core Framework
 *
 * 1. Load the plugin base
 * 2. Load the other plugin functions
 * 3. Load builders
 * 4. Load addons and shortcodes
 *
 * @author     D-THEMES
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

define( 'ALPHA_CORE_PLUGINS', ALPHA_CORE_FRAMEWORK_PATH . '/plugins' );
define( 'ALPHA_CORE_PLUGINS_URI', ALPHA_CORE_FRAMEWORK_URI . '/plugins' );
define( 'ALPHA_BUILDERS', ALPHA_CORE_FRAMEWORK_PATH . '/builders' );
define( 'ALPHA_BUILDERS_URI', ALPHA_CORE_FRAMEWORK_URI . '/builders' );
define( 'ALPHA_CORE_ADDONS', ALPHA_CORE_FRAMEWORK_PATH . '/addons' );
define( 'ALPHA_CORE_ADDONS_URI', ALPHA_CORE_FRAMEWORK_URI . '/addons' );

global $pagenow;
$alpha_pages = array( 'post-new.php', 'post.php', 'index.php', 'admin-ajax.php', 'edit.php', 'admin.php', 'widgets.php' );
/**************************************/
/* 1. Load the plugin base            */
/**************************************/

require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/common-functions.php' );
require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/plugin-functions.php' );
require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/plugin-actions.php' );

/**
 * Fires after framework init
 *
 * @since 1.0
 */
do_action( 'alpha_after_core_framework_init' );

/**************************************/
/* 2. Load the other plugin functions */
/**************************************/
if ( in_array( $pagenow, $alpha_pages ) ) {

	// @start feature: fs_pb_wpb
	if ( alpha_get_feature( 'fs_pb_wpb' ) ) {
		require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/wpb/class-alpha-wpb.php' );               // WPBakery
	}
	// @end feature: fs_pb_wpb

	// @start feature: fs_pb_elementor
	if ( alpha_get_feature( 'fs_pb_elementor' ) ) {
		require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/elementor/class-alpha-core-elementor.php' );   // Elementor
	}
	// @end feature: fs_pb_elementor

}

// @start feature: fs_plugin_acf
if ( alpha_get_feature( 'fs_plugin_acf' ) && class_exists( 'ACF' ) ) {
	require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/acf/class-alpha-core-acf.php' );                     // ACF
}
// @end feature: fs_plugin_acf

if ( defined( 'RWMB_VER' ) ) {
	require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/class-alpha-admin-meta-boxes.php' );             // Meta Box
}

/**
 * Fires after loading framework plugin compatibility.
 *
 * @since 1.0
 */
do_action( 'alpha_after_core_framework_plugins' );

/**************************************/
/* 3. Load builders                   */
/**************************************/
if ( ! isset( $_POST['action'] ) || 'alpha_quickview' != $_POST['action'] ) {
	require_once alpha_core_framework_path( ALPHA_BUILDERS . '/class-alpha-builders.php' );
	// @start feature: fs_builder_sidebar
	if ( alpha_get_feature( 'fs_builder_sidebar' ) ) {
		require_once alpha_core_framework_path( ALPHA_BUILDERS . '/sidebar/class-alpha-sidebar-builder.php' );
	}
	// @end feature: fs_builder_sidebar

	// @start feature: fs_builder_header
	if ( alpha_get_feature( 'fs_builder_header' ) ) {
		require_once alpha_core_framework_path( ALPHA_BUILDERS . '/header/class-alpha-header-builder.php' );
	}
	// @end feature: fs_builder_header

	// @start feature: fs_plugin_woocommerce
	if ( alpha_get_feature( 'fs_plugin_woocommerce' ) && class_exists( 'WooCommerce' ) ) {
		// @start feature: fs_builder_singleproduct
		if ( alpha_get_feature( 'fs_builder_singleproduct' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/single-product/class-alpha-single-product-builder.php' );
		}
		// @end feature: fs_builder_singleproduct

		// @start feature: fs_builder_shop
		if ( alpha_get_feature( 'fs_builder_shop' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/shop/class-alpha-shop-builder.php' );
		}
		// @end feature: fs_builder_shop

		// @start feature: fs_builder_cart
		if ( alpha_get_feature( 'fs_builder_cart' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/cart/class-alpha-cart-builder.php' );
		}
		// @end feature: fs_builder_cart

		// @start feature: fs_builder_checkout
		if ( alpha_get_feature( 'fs_builder_checkout' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/checkout/class-alpha-checkout-builder.php' );
		}
		// @end feature: fs_builder_checkout
	}
	// @end feature: fs_plugin_woocommerce

	// @start feature: fs_pb_elementor
	if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) ) {

		// @start feature: fs_builder_single
		if ( alpha_get_feature( 'fs_builder_single' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/single/class-alpha-single-builder.php' );
		}
		// @end feature: fs_builder_single

		// @start feature: fs_builder_archive
		if ( alpha_get_feature( 'fs_builder_archive' ) ) {
			require_once alpha_core_framework_path( ALPHA_BUILDERS . '/archive/class-alpha-archive-builder.php' );
		}
		// @end feature: fs_builder_archive
	}
	// @end feature: fs_pb_elementor

}

/**
 * Fires after loading framework template builder.
 *
 * @since 1.0
 */
do_action( 'alpha_after_core_framework_builders' );

/**************************************/
/* 4. Load addons and shortcodes      */
/**************************************/

require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/addons/init.php' );
require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/shortcode.php' );
/**
 * Fires after loading framework init.
 *
 * @since 1.0
 */
do_action( 'alpha_after_core_framework_shortcodes' );

