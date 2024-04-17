<?php
/**
 * Default Theme Options
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 * @var array $alpha_option
 */
defined( 'ABSPATH' ) || die;

$default_conditions = array(
	'site'            => array(
		array(
			'title' => esc_html__( 'Global Layout', 'pandastore' ),
		),
	),
	'archive_product' => array(
		array(
			'title'   => esc_html__( 'Shop Page Layout', 'pandastore' ),
			'scheme'  => array(
				'all' => true,
			),
			'options' => array(
				'left_sidebar'    => 'shop-sidebar',
				'ptb'             => 'hide',
				'show_breadcrumb' => 'yes',
			),
		),
	),
	'single_product'  => array(
		array(
			'title'   => esc_html__( 'Single Product Layout', 'pandastore' ),
			'scheme'  => array(
				'all' => true,
			),
			'options' => array(
				'right_sidebar'   => 'product-sidebar',
				'ptb'             => 'hide',
				'show_breadcrumb' => 'yes',
			),
		),
	),
	'archive_post'    => array(
		array(
			'title'   => esc_html__( 'Blog Page Layout', 'pandastore' ),
			'scheme'  => array(
				'all' => true,
			),
			'options' => array(
				'right_sidebar' => 'blog-sidebar',
			),
		),
	),
	'single_post'     => array(
		array(
			'title'   => esc_html__( 'Single Post Layout', 'pandastore' ),
			'scheme'  => array(
				'all' => true,
			),
			'options' => array(
				'right_sidebar' => 'blog-sidebar',
			),
		),
	),
	'error'           => array(
		array(
			'title'   => esc_html__( '404 Page Layout', 'pandastore' ),
			'options' => array(
				'wrap' => 'full',
				'ptb'  => 'hide',
			),
		),
	),
);

$alpha_option = array(
	// Navigator
	'navigator_items'              => array(
		'custom_css_js'  => array( esc_html__( 'Style / Additional CSS & Script', 'pandastore' ), 'section' ),
		'color'          => array( esc_html__( 'Color & Skin', 'pandastore' ), 'section' ),
		'blog_global'    => array( esc_html__( 'Blog / Blog Global', 'pandastore' ), 'section' ),
		'product_type'   => array( esc_html__( 'Shop / Product Type', 'pandastore' ), 'section' ),
		'category_type'  => array( esc_html__( 'Shop / Category Type', 'pandastore' ), 'section' ),
		'product_detail' => array( esc_html__( 'WooCommerce / Product Page', 'pandastore' ), 'section' ),
		'share'          => array( esc_html__( 'Share', 'pandastore' ), 'section' ),
		'lazyload'       => array( esc_html__( 'Advanced / Lazy Load', 'pandastore' ), 'section' ),
		'search'         => array( esc_html__( 'Advanced / Search', 'pandastore' ), 'section' ),
	),

	// Conditions
	'conditions'                   => $default_conditions,

	// General
	'site_type'                    => 'full',
	'site_width'                   => '1400',
	'site_gap'                     => '20',
	'container'                    => '1280',
	'container_fluid'              => '1820',
	'content_bg'                   => array(
		'background-color' => '#fff',
	),
	'site_bg'                      => array(
		'background-color' => '#fff',
	),

	// Colors
	'primary_color'                => '#2879FE',
	'secondary_color'              => '#f93',
	'dark_color'                   => '#333',
	'light_color'                  => '#ccc',
	'white_color'                  => '#fff',

	// Skin
	'rounded_skin'                 => true,

	// Typography
	'typo_default'                 => array(
		'font-family'    => 'Poppins',
		'variant'        => '400',
		'font-size'      => '14px',
		'line-height'    => '1.6',
		'letter-spacing' => '',
		'color'          => '#666',
	),
	'typo_heading'                 => array(
		'font-family'    => 'inherit',
		'variant'        => '600',
		'line-height'    => '1.2',
		'letter-spacing' => '-0.025em',
		'text-transform' => 'none',
		'color'          => '#333',
	),
	'typo_custom1'                 => array(
		'font-family' => 'inherit',
	),
	'typo_custom2'                 => array(
		'font-family' => 'inherit',
	),
	'typo_custom3'                 => array(
		'font-family' => 'inherit',
	),

	// Mobile Bar
	'mobile_bar_icons'             => array( 'home', 'shop', 'account', 'cart', 'search' ),
	'mobile_bar_menu_label'        => esc_html__( 'Menu', 'pandastore' ),
	'mobile_bar_menu_icon'         => ALPHA_ICON_PREFIX . '-icon-bars',
	'mobile_bar_home_label'        => esc_html__( 'Home', 'pandastore' ),
	'mobile_bar_home_icon'         => ALPHA_ICON_PREFIX . '-icon-home',
	'mobile_bar_shop_label'        => esc_html__( 'Categories', 'pandastore' ),
	'mobile_bar_shop_icon'         => ALPHA_ICON_PREFIX . '-icon-category',
	'mobile_bar_wishlist_label'    => esc_html__( 'Wishlist', 'pandastore' ),
	'mobile_bar_wishlist_icon'     => ALPHA_ICON_PREFIX . '-icon-heart',
	'mobile_bar_account_label'     => esc_html__( 'Account', 'pandastore' ),
	'mobile_bar_account_icon'      => ALPHA_ICON_PREFIX . '-icon-account',
	'mobile_bar_cart_label'        => esc_html__( 'Cart', 'pandastore' ),
	'mobile_bar_cart_icon'         => ALPHA_ICON_PREFIX . '-icon-cart-solid',
	'mobile_bar_search_label'      => esc_html__( 'Search', 'pandastore' ),
	'mobile_bar_search_icon'       => ALPHA_ICON_PREFIX . '-icon-search',
	'mobile_bar_top_label'         => esc_html__( 'To Top', 'pandastore' ),
	'mobile_bar_top_icon'          => ALPHA_ICON_PREFIX . '-icon-long-arrow-up',

	// Menu
	'menu_labels'                  => '',
	'mobile_menu_items'            => array(),

	'top_button_size'              => '100',
	'top_button_pos'               => 'right',

	// Share
	'social_login'                 => true,
	'share_type'                   => 'framed',
	'share_icons'                  => array( 'facebook', 'twitter', 'pinterest', 'whatsapp', 'linkedin' ),

	// Page Title Bar
	'ptb_bg'                       => array(
		'background-color' => '#eee',
	),
	'ptb_height'                   => '180',
	'ptb_delimiter'                => '>',
	'typo_ptb_title'               => array(
		'font-family'    => 'inherit',
		'variant'        => '700',
		'font-size'      => '34px',
		'line-height'    => '1.125',
		'letter-spacing' => '-0.025em',
		'text-transform' => 'capitalize',
		'color'          => '#333',
	),
	'typo_ptb_subtitle'            => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '18px',
		'line-height'    => '1.8',
		'letter-spacing' => '',
		'color'          => '#666',
	),
	'typo_ptb_breadcrumb'          => array(
		'font-family'    => 'inherit',
		'font-size'      => '13px',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '#333',
	),

	// Blog
	'blog_ajax'                    => false,
	'post_overlay'                 => 'zoom',
	'posts_layout'                 => 'grid',
	'posts_gap'                    => 'md',
	'posts_column'                 => 4,
	'post_related_count'           => 3,
	'post_related_column'          => 3,
	'excerpt_length'               => 15,
	'post_show_info'               => array(
		'image',
		'author',
		'date',
		'category',
		'comment',
		'tag',
		'author_info',
		'share',
		'related',
		'navigation',
		'comments_list',
	),

	// Products
	'products_column'              => 4,

	// Single Product
	'product_data_type'            => 'tab',
	'single_product_sticky'        => true,
	'product_description_title'    => esc_html__( 'Description', 'pandastore' ),
	'product_specification_title'  => esc_html__( 'Specification', 'pandastore' ),
	'product_reviews_title'        => esc_html__( 'Customer Reviews', 'pandastore' ),
	'product_related_title'        => esc_html__( 'Related Products', 'pandastore' ),
	'product_upsells_title'        => esc_html__( 'You may also like&hellip', 'pandastore' ),
	'show_buy_now_btn'             => false,
	'buy_now_text'                 => esc_html__( 'Buy Now', 'pandastore' ),

	'product_vendor_info_title'    => esc_html__( 'Vendor Info', 'pandastore' ),

	'product_upsells_count'        => 4,
	'product_related_count'        => 4,
	'product_related_column'       => 4,
	'product_type_new_period'      => 7,
	'product_more_title'           => esc_html__( 'More Products From This Vendor', 'pandastore' ),
	'product_more_order'           => 'rand',

	'product_hide_vendor_tab'      => false,

	// Product Excerpt
	'prod_excerpt_type'            => '',
	'prod_excerpt_length'          => 20,

	// Shop Advanced
	'new_product_period'           => 7,
	'shop_ajax'                    => false,
	'prod_open_click_mob'          => true,
	'catalog_mode'                 => false,
	'catalog_price'                => true,
	'catalog_cart'                 => false,
	'catalog_review'               => false,

	// layouts
	'layout_default_wrap'          => 'container',
	'archive_layout_right_sidebar' => 'blog-sidebar',
	'single_layout_right_sidebar'  => 'blog-sidebar',
	'shop_layout_left_sidebar'     => 'shop-sidebar',
	'error_layout_wrap'            => 'full',
	'error_layout_ptb'             => 'hide',

	// Vendor related options
	'vendor_products_column'       => 3,
	'vendor_style'                 => 'default',
	'vendor_style_option'          => 'theme',
	'vendor_soldby_style_option'   => 'theme',

	// Shop / Product Type
	'product_type'                 => '',
	'classic_hover'                => '',
	'addtocart_pos'                => '',
	'quickview_pos'                => 'bottom',
	'wishlist_pos'                 => '',
	'show_in_box'                  => false,
	'show_media_shadow'            => false,
	'show_hover_shadow'            => false,
	'show_info'                    => array(
		'category',
		'label',
		'custom_label',
		'price',
		'rating',
		'addtocart',
		'quickview',
		'wishlist',
		'compare',
		'sold_by',
	),
	'sold_by_label'                => esc_html__( 'Sold By', 'pandastore' ),
	'hover_change'                 => true,
	'quickview_type'               => '',
	'quickview_thumbs'             => 'horizontal',
	'content_align'                => 'left',
	'split_line'                   => false,

	// Shop / Category Type
	'category_type'                => '',
	'subcat_cnt'                   => '5',
	'category_show_icon'           => '',
	'category_overlay'             => '',

	// WooCommerce
	'cart_show_clear'              => true,

	// Advanced / Lazyload
	'skeleton_screen'              => false,
	'lazyload'                     => false,
	'lazyload_bg'                  => '#f4f4f4',
	'loading_animation'            => false,

	// Advanced / Search
	'live_search'                  => true,
	'search_post_type'             => 'product',
	'sales_popup'                  => '',
	'sales_popup_title'            => esc_html__( 'Someone Purchased', 'pandastore' ),
	'sales_popup_count'            => 0,
	'sales_popup_start_delay'      => 121212160,
	'sales_popup_interval'         => 121212160,
	'sales_popup_category'         => '',
	'sales_popup_mobile'           => false,
	'custom_image_size'            => array(
		'Width'  => '',
		'Height' => '',
	),
	'image_quality'                => 82,
	'big_image_threshold'          => 2560,

	// optimize wizard
	'google_webfont'               => false,
	'lazyload_menu'                => false,
	'menu_last_time'               => 0,
	'mobile_disable_slider'        => false,
	'mobile_disable_animation'     => false,

	'preload_fonts'                => array( 'alpha', 'fas', 'fab' ),
	'resource_disable_gutenberg'   => false,
	'resource_disable_wc_blocks'   => false,
	'resource_disable_elementor'   => false,
	'resource_disable_dokan'       => false,
	'resource_async_js'            => true,
	'resource_split_tasks'         => true,
	'resource_after_load'          => true,

	// Custom CSS & JS
	'custom_css'                   => '',
	'custom_js'                    => '',
);

$alpha_option['menu_labels'] = json_encode(
	array(
		'new' => get_theme_mod( 'primary_color', $alpha_option['primary_color'] ),
		'hot' => get_theme_mod( 'secondary_color', $alpha_option['secondary_color'] ),
	)
);

$social_shares = alpha_get_social_shares();

foreach ( $social_shares as $key => $data ) {
	$alpha_option[ 'social_addr_' . $key ] = '';
}

$alpha_option = apply_filters( 'alpha_theme_option_default_values', $alpha_option );

/**
 * Fires after setting default options. Here you can change default options,
 * add or remove.
 *
 * @since 1.0
 */
do_action( 'alpha_after_default_options' );
