<?php

/**
 * Theme Functions
 *
 * To use a child theme:
 *
 *   @see http://codex.wordpress.org/Theme_Development
 *   @see http://codex.wordpress.org/Child_Themes
 *
 * To override certain functions (wrapped in a function_exists call):
 *   define them in child theme's functions.php file.
 *
 * For more information on hooks, actions, and filters:
 *   @see http://codex.wordpress.org/Plugin_API
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

// Direct load is not allowed
defined('ABSPATH') || die;

// Theme Name, Version and icon prefix
defined('ALPHA_NAME') || define('ALPHA_NAME', 'pandastore');
defined('ALPHA_DISPLAY_NAME') || define('ALPHA_DISPLAY_NAME', 'PandaStore');
defined('ALPHA_ICON_PREFIX') || define('ALPHA_ICON_PREFIX', 'p');
defined('ALPHA_ENVATO_CODE') || define('ALPHA_ENVATO_CODE', '35889540');
define('ALPHA_VERSION', (is_child_theme() ? wp_get_theme(wp_get_theme()->template) : wp_get_theme())->version);
define('ALPHA_GAP', '10px');

define('ALPHA_CORE_NAME', 'PandaStore Core');
define('ALPHA_CORE_SLUG', 'pandastore-core');
define('ALPHA_CORE_PLUGIN_URI', 'pandastore-core/pandastore-core.php');
// Define script debug
defined('ALPHA_JS_SUFFIX') || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? define('ALPHA_JS_SUFFIX', '.js') : define('ALPHA_JS_SUFFIX', '.min.js'));

// Define Constants
define('ALPHA_PATH', get_parent_theme_file_path());                      // Template directory path
define('ALPHA_URI', get_parent_theme_file_uri());                        // Template directory uri
define('ALPHA_SERVER_URI', 'https://d-themes.com/wordpress/panda/'); // Server uri
define('ALPHA_ASSETS', ALPHA_URI . '/assets');                           // Template assets directory uri
define('ALPHA_CSS', ALPHA_ASSETS . '/css');                              // Template css uri
define('ALPHA_JS', ALPHA_ASSETS . '/js');                                // Template javascript uri
define('ALPHA_PART', 'templates');                                       // Template parts

if (!class_exists('Alpha_Base')) {
    require_once ALPHA_PATH . '/framework/class-alpha-base.php';
}
// FrameWork Config
require_once ALPHA_PATH . '/framework/config.php';
// Theme EntryPoint
require_once ALPHA_PATH . '/inc/theme-setup.php';
// FrameWork EntryPoint
require_once alpha_framework_path(ALPHA_FRAMEWORK_PATH . '/init.php');


function custom_enqueue_scripts_and_styles() {
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
  wp_enqueue_script('owl-carousel', 'https://d-themes.com/html/panda/vendor/owl-carousel/owl.carousel.min.js', array(), '1.0', true);
  wp_enqueue_script('main-min', 'https://d-themes.com/html/panda/js/main.min.js', array('jquery'), '1.0', true);
  // Enqueue stylesheets
  wp_enqueue_style('animate-css', 'https://d-themes.com/html/panda/vendor/animate/animate.min.css', array(), '1.0');
  wp_enqueue_style('owl-carousel-css', 'https://d-themes.com/html/panda/vendor/owl-carousel/owl.carousel.min.css', array(), '1.0');
    
  
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts_and_styles');

add_filter('wc_session_expiring', 'woocommerce_cart_session_about_to_expire');
function woocommerce_cart_session_about_to_expire($seconds)
{
    // Keičiame numatytąją sesijos trukmę į 47 valandas
    return 60 * 60 * 47;
}

// Nustatome, kada sesija pasibaigs
add_filter('wc_session_expiration', 'woocommerce_cart_session_expires');
function woocommerce_cart_session_expires($seconds)
{
    // Keičiame numatytąją sesijos trukmę į 48 valandas
    return 60 * 60 * 48;
}

add_filter('woocommerce_default_address_fields', 'custom_override_default_address_fields');
function custom_override_default_address_fields($address_fields)
{
    global $woocommerce;
    $country = $woocommerce->customer->get_billing_country();
    if ($country !== 'US') {
        $address_fields['state']['required'] = false;
    }
    return $address_fields;
}
add_action('woocommerce_checkout_order_processed', 'changing_order_status_before_payment', 10, 3);
function changing_order_status_before_payment($order_id, $posted_data, $order)
{
    $order->update_status('processing');
}

function enqueue_wc_cart_fragments()
{
    wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'enqueue_wc_cart_fragments');


add_action('after_setup_theme', 'remove_wc_gallery_lightbox', 100);
add_action('after_setup_theme', 'remove_wc_gallery_zoom', 1001);

function remove_wc_gallery_lightbox()
{
 
    remove_theme_support('wc-product-gallery-lightbox');
}


function remove_wc_gallery_zoom()
{
    remove_theme_support('wc-product-gallery-zoom');
    
}

add_filter( 'rank_math/woocommerce/product_redirection', '__return_false' );

// add_action('init', 'taxonomy_product_code');
// add_action('init', 'taxonomy_ean');
// function taxonomy_ean()
// {
//     $labels_eans = array(
//         'name'                       => 'EANS',
//         'singular_name'              => 'EAN',
//         'menu_name'                  => 'EANS',
//         'all_items'                  => __('All Items'),
//         'parent_item'                => __('Parent Item'),
//         'parent_item_colon'          => __('Parent Item:'),
//         'new_item_name'              => __('New Item Name'),
//         'add_new_item'               => __('Add New Item'),
//         'edit_item'                  => __('Edit Item'),
//         'update_item'                => __('Update Item'),
//         'separate_items_with_commas' => __('Separate Item with commas'),
//         'search_items'               => __('Search Items'),
//         'add_or_remove_items'        => __('Add or remove Items'),
//         'choose_from_most_used'      => __('Choose from the most used Items'),
//         'not_found'                  => 'No eans codes found',
//     );
//     $args_eans = array(
//         'labels'                     => $labels_eans,
//         'hierarchical'               => true,
//         'public'                     => true,
//         'show_ui'                    => true,
//         'show_admin_column'          => true,
//         'show_in_nav_menus'          => true,
//         'show_tagcloud'              => true,
//     );
//     register_taxonomy('ean', 'product', $args_eans);
//     register_taxonomy_for_object_type('ean', 'product');
// }




// function taxonomy_product_code()
// {
//     $labels_product_code = array(
//         'name'                       => 'Product codes',
//         'singular_name'              => 'Product code',
//         'menu_name'                  => 'Product codes',
//         'all_items'                  => __('All Items'),
//         'parent_item'                => __('Parent Item'),
//         'parent_item_colon'          => __('Parent Item:'),
//         'new_item_name'              => __('New Item Name'),
//         'add_new_item'               => __('Add New Item'),
//         'edit_item'                  => __('Edit Item'),
//         'update_item'                => __('Update Item'),
//         'separate_items_with_commas' => __('Separate Item with commas'),
//         'search_items'               => __('Search Items'),
//         'add_or_remove_items'        => __('Add or remove Items'),
//         'choose_from_most_used'      => __('Choose from the most used Items'),
//         'not_found'                  => 'No product codes found',
//     );
//     $args_product_code = array(
//         'labels'                     => $labels_product_code,
//         'hierarchical'               => true,
//         'public'                     => true,
//         'show_ui'                    => true,
//         'show_admin_column'          => true,
//         'show_in_nav_menus'          => true,
//         'show_tagcloud'              => true,
//     );
//     register_taxonomy('product_code', 'product', $args_product_code);
//     register_taxonomy_for_object_type('product_code', 'product');
// }