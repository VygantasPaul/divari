<?php
//=================================================
// Plugin Name: Divari core
// Description: Add-ons for Diver theme
// Plugin URI: https://www.divari.lt/
// Author:      Divari
// Author       URI: https://www.divari.lt/
// Version:     1.0.0
// License:     GPL 2.0

// Text Domain: divari-core
// Domain Path: /languages
//
// @package   Divari
// @version   1.0.0
// @author    Divari
// @copyright Copyright (c) 2023
// @link      https://divari.lt/

//=================================================

define('DIVARI_VERSION', '1.0.0');
define('DIVARI_CORE_FILE', __FILE__);
define('DIVARI_CORE_BASE_URL', plugins_url('/', DIVARI_CORE_FILE));
define('DIVARI_CORE_BASE_PATH', plugin_dir_path(DIVARI_CORE_FILE));

//=================================================
// Required files
//=================================================
// Cron
require_once DIVARI_CORE_BASE_PATH . '/inc/divari-permalinks.php';
// WooCommerce
//require_once DIVARI_CORE_BASE_PATH . '/inc/woocommerce/divari-woocommerce.php';