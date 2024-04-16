<?php
/**
 * Entrypoint of Core
 *
 * 1. Load the plugin base
 * 2. Load the other plugin functions
 * 3. Load builders
 * 4. Load addons and shortcodes
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Core
 * @version    1.0
 */

defined( 'ABSPATH' ) || die;

/**************************************/
/* Define Constants                */
/**************************************/

define( 'ALPHA_CORE_INC_URI', ALPHA_CORE_URI . '/inc' );
define( 'ALPHA_CORE_INC_PATH', ALPHA_CORE_PATH . '/inc' );
define( 'ALPHA_CORE_BUILDERS', ALPHA_CORE_INC_PATH . '/builders' );

class Alpha_Core_Setup {

	/**
	 * The Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		/**************************************/
		/* 1. Load the core general           */
		/**************************************/

		require_once ALPHA_CORE_INC_PATH . '/core-function.php';
		require_once ALPHA_CORE_INC_PATH . '/core-action.php';
		$this->config_extend();

		/**************************************/
		/* 2. Load plugin functions */
		/**************************************/

		// Elementor functions
		require_once ALPHA_CORE_INC_PATH . '/widgets/class-alpha-elementor-extend.php';
		require_once ALPHA_CORE_INC_PATH . '/plugins/elementor/class-alpha-core-elementor-extend.php';

		// Meta boxes
		require_once ALPHA_CORE_INC_PATH . '/plugins/meta-box/class-alpha-admin-meta-boxes-extend.php';

		/**************************************/
		/* 3. Load builders                   */
		/**************************************/
		require_once ALPHA_CORE_INC_PATH . '/builders/header/class-alpha-header-builder-extend.php';
		require_once ALPHA_CORE_INC_PATH . '/builders/sidebar/class-alpha-sidebar-builder-extend.php';
		require_once ALPHA_CORE_INC_PATH . '/builders/single-product/class-alpha-single-product-builder-extend.php';

		/**************************************/
		/* 4. Load addons and shortcodes      */
		/**************************************/
		require_once ALPHA_CORE_INC_PATH . '/addons/class-alpha-addons-extend.php';

	}

	/**
	 * Removing unnecessary configuration
	 *
	 * @since 1.0
	 * @access public
	 */
	public function config_extend() {
		alpha_remove_feature(
			array(
				// List type Feature
				'fs_bt_list-xs',
				// Mast type Feature
				'fs_bt_mask',
				// Single Product Feature
				'fs_spt_vertical',
				'fs_spt_grid',
				'fs_spt_masonry',
				'fs_spt_sticky-info',
				'fs_spt_sticky-thumbs',
				'fs_spt_sticky-both',
				// Addon Feature
				'fs_addon_product_frequently_bought_together',
				'fs_addon_vendors',
				'fs_addon_product_buy_now',
				// Plugin Feature
				'fs_plugin_dokan',
				'fs_plugin_wc-vendors',
				'fs_plugin_wcfm',
				'fs_plugin_wcmp',
				// Builder Feature
				'fs_builder_single',
				'fs_builder_archive',
			)
		);
	}
}

new Alpha_Core_Setup;
