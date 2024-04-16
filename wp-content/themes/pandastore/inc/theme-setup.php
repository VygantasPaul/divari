<?php
/**
 * Entrypoint of Theme.
 *
 * 1. Define Constants
 * 2. Load the theme general
 * 3. Load the plugin functions
 * 4. Load admin extend
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

/**************************************/
/* Define Constants                */
/**************************************/

define( 'ALPHA_INC_URI', ALPHA_URI . '/inc' );
define( 'ALPHA_INC_PATH', ALPHA_PATH . '/inc' );
define( 'ALPHA_INC_PLUGINS', ALPHA_INC_PATH . '/plugins' );
define( 'ALPHA_INC_PLUGINS_URI', ALPHA_INC_URI . '/plugins' );

class Alpha_Theme_Setup {
	/**
	 * The Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		/**************************************/
		/* 1. Load the theme general          */
		/**************************************/

		require_once ALPHA_INC_PATH . '/general-function.php';
		require_once ALPHA_INC_PATH . '/general-action.php';
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );

		/**************************************/
		/* 2. Load the plugin functions       */
		/**************************************/
		// woocommerce relates
		if ( class_exists( 'WooCommerce' ) ) {
			require_once ALPHA_INC_PATH . '/plugins/woocommerce/class-alpha-woocommerce-extend.php';
		}

		/**************************************/
		/* 3. Load admin extend                */
		/**************************************/
		require_once ALPHA_INC_PATH . '/admin/admin/class-alpha-admin-extend.php';
		require_once ALPHA_INC_PATH . '/admin/customizer/class-alpha-customizer-extend.php';
	}

	/**
	 * Enqueue admin script
	 *
	 * @since 1.0
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_style( 'alpha-admin-extend', ALPHA_INC_URI . '/admin/admin/admin-extend.min.css', array( 'alpha-admin' ), ALPHA_VERSION );
		wp_enqueue_script( 'alpha-admin-extend', ALPHA_INC_URI . '/admin/admin/admin-extend.js', array( 'alpha-admin' ), ALPHA_VERSION, true );
		wp_enqueue_style( 'alpha-admin-fonts-extend', '//fonts.googleapis.com/css?family=Jost%3A300%2C400%2C500%2C600%2C700&ver=5.2.1' );
	}

	/**
	 * Enqueue script
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		if ( alpha_get_option( 'font_alignment' ) ) {
			wp_enqueue_style( 'font-adjust', ALPHA_ASSETS . '/css/font-adjust.min.css', array( 'alpha-theme' ), ALPHA_VERSION );
		}
	}
}

new Alpha_Theme_Setup;
