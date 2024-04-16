<?php
/*
Plugin Name: PandaStore Core
Plugin URI: https://d-themes.com/wordpress/framework
Description: Adds functionality such as Shortcodes, Post Types, Widgets and Page Builders to PandaStore Theme
Version: 1.0.0
Author: D-Themes
Author URI: https://d-themes.com/
License: GPL2
Text Domain: pandastore-core
*/

// Direct load is not allowed
defined( 'ABSPATH' ) || die;


/**************************************/
/* Define Constants                   */
/**************************************/
define( 'ALPHA_NAME', 'pandastore' );
define( 'ALPHA_ICON_PREFIX', 'p' );                                                        // Theme Icon Prefix
define( 'ALPHA_DISPLAY_NAME', 'PandaStore' );                                   // Theme Display Name
define( 'ALPHA_CORE_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) );               // Plugin directory uri
define( 'ALPHA_CORE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );             // Plugin directory path
define( 'ALPHA_CORE_FILE', __FILE__ );                                                     // Plugin file path
define( 'ALPHA_CORE_VERSION', '1.0.0' );                                                     // Plugin Version

// Define script debug
defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? define( 'ALPHA_JS_SUFFIX', '.js' ) : define( 'ALPHA_JS_SUFFIX', '.min.js' );

if ( ! class_exists( 'Alpha_Base' ) ) {
	require_once ALPHA_CORE_PATH . '/framework/class-alpha-base.php';
}

require_once ALPHA_CORE_PATH . '/framework/config.php';

/**
 * Alpha Core Plugin Class
 *
 * @since 1.0
 */
class Alpha_Core {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Load plugin
		add_action( 'plugins_loaded', array( $this, 'load' ) );
	}

	/**
	 * Load required files
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function load() {
		// Load text domain
		load_plugin_textdomain( 'alpha-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		require_once ALPHA_CORE_PATH . '/inc/core-setup.php';
		require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/init.php' );

	}
}

new Alpha_Core();
