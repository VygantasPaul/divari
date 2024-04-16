<?php
/**
 * Alpha WooCommerce Functions
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_WooCommerce extends Alpha_Base {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		if ( alpha_get_option( 'resource_disable_wc_blocks' ) ) {
			remove_action( 'init', array( 'Automattic\WooCommerce\Blocks\Library', 'register_blocks' ) );
		}
		// change templates path to framework
		add_filter( 'wc_get_template_part', array( $this, 'correct_template_part' ), 10, 3 );
		add_filter( 'woocommerce_locate_template', array( $this, 'correct_template' ), 10, 2 );
		add_filter( 'yith_wcwl_locate_template', array( $this, 'correct_template' ), 10, 2 );
		add_filter( 'template_include', array( $this, 'correct_template_loader' ), 99 );
		add_filter( 'comments_template', array( $this, 'correct_template_loader' ), 99 );

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', array( $this, 'load_functions' ), 8 );
		} else {
			$this->load_functions();
		}
	}

	/**
	 * Load functions
	 *
	 * @since 1.0
	 * @access public
	 */
	public function load_functions() {
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/woocommerce/woo-functions.php' );
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/woocommerce/product-loop.php' );
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/woocommerce/product-category.php' );
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/woocommerce/product-archive.php' );
		require_once alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/woocommerce/product-single.php' );
	}

	/**
	 * Correct template part path
	 *
	 * @since 1.0
	 * @access public
	 * @param string $template
	 * @param string $slug
	 * @param string $name
	 * @return string $template
	 */
	public function correct_template_part( $template, $slug, $name = '' ) {
		// If template is in plugin, then check framework's template and use it if possible.
		$plugin_dir = str_replace( '/', '\\', WP_PLUGIN_DIR );
		if ( str_replace( '/', '\\', substr( $template, 0, strlen( $plugin_dir ) ) ) == $plugin_dir ) {
			$framework_template_path = ALPHA_PATH . '/framework/' . ALPHA_PART . '/' . WC()->template_path() . ( $name ? "{$slug}-{$name}.php" : "{$slug}.php" );
			if ( file_exists( $framework_template_path ) ) {
				$template = $framework_template_path;
			}
		}
		return $template;
	}

	/**
	 * Correct template path
	 *
	 * @since 1.0
	 * @access public
	 * @param string $template
	 * @param string $template_name
	 * @return string $template
	 */
	public function correct_template( $template, $template_name ) {
		// If template is in plugin, then check framework's template and use it if possible.
		$plugin_dir = str_replace( '/', '\\', WP_PLUGIN_DIR );
		if ( str_replace( '/', '\\', substr( $template, 0, strlen( $plugin_dir ) ) ) == $plugin_dir ) {
			$framework_template_path = ALPHA_PATH . '/framework/' . ALPHA_PART . '/' . WC()->template_path() . str_replace( '_', '-', $template_name );
			if ( file_exists( $framework_template_path ) ) {
				$template = $framework_template_path;
			}
		}

		return $template;
	}

	/**
	 * Correct template loader
	 *
	 * @since 1.0
	 * @access public
	 * @param string $template
	 * @return string $template
	 */
	public function correct_template_loader( $template ) {
		$file = str_replace( str_replace( '\\', '/', WC()->plugin_path() . '/templates/' ), ALPHA_FRAMEWORK_PATH . '/' . ALPHA_PART . '/woocommerce/', str_replace( '\\', '/', $template ) );
		if ( file_exists( $file ) ) {
			return $file;
		}
		return $template;
	}
}

Alpha_WooCommerce::get_instance();
