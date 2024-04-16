<?php
/**
 * Plugin Actions, Filters
 *
 * @author     D-THEMES
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'after_setup_theme', 'alpha_setup_make_script_async' );
add_action( 'wp_enqueue_scripts', 'alpha_enqueue_core_framework_base_styles', 18 );
add_action( 'wp_enqueue_scripts', 'alpha_enqueue_core_framework_styles', 19 );
add_action( 'admin_print_footer_scripts', 'alpha_print_footer_scripts', 30 );
add_action( 'wp_ajax_alpha_load_creative_layout', 'alpha_load_creative_layout' );
add_action( 'wp_ajax_nopriv_alpha_load_creative_layout', 'alpha_load_creative_layout' );

if ( ! function_exists( 'alpha_print_footer_scripts' ) ) {
	/**
	 * Print footer scripts
	 *
	 * @since 1.0
	 */
	function alpha_print_footer_scripts() {
		echo '<script id="alpha-core-admin-js-extra">';
		echo 'var alpha_core_vars = ' . json_encode(
			apply_filters(
				'alpha_core_admin_localize_vars',
				array(
					'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'      => wp_create_nonce( 'alpha-core-nonce' ),
					'assets_url' => ALPHA_CORE_URI,
				)
			)
		) . ';';
		echo '</script>';
	}
}

if ( ! function_exists( 'alpha_enqueue_core_framework_base_styles' ) ) {
	/**
	 * Enqueue framework base styles
	 *
	 * @since 1.0
	 */
	function alpha_enqueue_core_framework_base_styles() {
		if ( ! defined( 'ALPHA_PATH' ) ) {
			wp_enqueue_style( 'alpha-core-framework-base-style', ALPHA_CORE_FRAMEWORK_URI . '/assets/css/framework-base.min.css', null, ALPHA_CORE_VERSION, 'all' );
		}
	}
}

if ( ! function_exists( 'alpha_enqueue_core_framework_styles' ) ) {
	/**
	 * Enqueue framework styles
	 *
	 * @since 1.0
	 */
	function alpha_enqueue_core_framework_styles() {
		wp_enqueue_style( 'alpha-core-framework-style', ALPHA_CORE_URI . '/assets/css/framework' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', null, ALPHA_CORE_VERSION, 'all' );
	}
}

if ( ! function_exists( 'alpha_setup_make_script_async' ) ) {
	/**
	 * Add a filter to make scripts async.
	 *
	 * @since 1.0
	 */
	function alpha_setup_make_script_async() {
		// Set scripts as async
		if ( ! alpha_is_wpb_preview() && function_exists( 'alpha_get_option' ) && alpha_get_option( 'resource_async_js' ) ) {
			add_filter( 'script_loader_tag', 'alpha_make_script_async', 10, 2 );
		}
	}
}

if ( ! function_exists( 'alpha_make_script_async' ) ) {
	/**
	 * Set scripts as async
	 *
	 * @since 1.0
	 *
	 * @param string $tag
	 * @param string $handle
	 * @return string Async script tag
	 */
	function alpha_make_script_async( $tag, $handle ) {
		$async_scripts = apply_filters(
			'alpha_async_scripts',
			array(
				'jquery-parallax',
				'jquery-autocomplete',
				'jquery-countdown',
				'jquery-magnific-popup',
				'jquery-cookie',
				'alpha-framework-async',
				'alpha-theme',
				'alpha-shop',
				'alpha-woocommerce',
				'alpha-single-product',
				'alpha-ajax',
				'alpha-countdown',
			)
		);

		if ( in_array( $handle, $async_scripts ) ) {
			return str_replace( ' src', ' async="async" src', $tag );
		}
		return $tag;
	}
}

add_filter(
	'alpha_core_filter_doing_ajax',
	function() {
		// check ajax doing on others
		return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && mb_strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
	}
);

if ( ! function_exists( 'alpha_load_creative_layout' ) ) {
	function alpha_load_creative_layout() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		$mode = isset( $_POST['mode'] ) ? $_POST['mode'] : 0;

		if ( $mode ) {
			echo json_encode( alpha_creative_layout( $mode ) );
		} else {
			echo json_encode( array() );
		}

		exit();

		// phpcs:enable
	}
}
