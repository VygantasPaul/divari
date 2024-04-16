<?php
/**
 * Alpha_Sidebar_Builder class
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
define( 'ALPHA_SIDEBAR_BUILDER', ALPHA_BUILDERS . '/sidebar' );

class Alpha_Sidebar_Builder extends Alpha_Base {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		if ( isset( $_GET['page'] ) && 'alpha_sidebar' == $_GET['page'] ) {
			add_filter( 'alpha_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );
		}
		$this->_init_sidebars();

		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
		add_action( 'widgets_init', array( $this, 'add_widgets' ) );

		// Compatabilities
		add_filter( 'widget_nav_menu_args', array( $this, 'make_collapsible_menus' ), 10, 4 );

		// Ajax
		add_action( 'wp_ajax_alpha_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_nopriv_alpha_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_alpha_remove_widget_area', array( $this, 'remove_sidebar' ) );
		add_action( 'wp_ajax_nopriv_alpha_remove_widget_area', array( $this, 'remove_sidebar' ) );
	}

	/**
	 * Add widgets
	 *
	 * @since 1.0
	 */
	public function add_widgets() {

		$widgets = array(
			'block',       // @feature: fs_sidebar_block
			'posts',       // @feature: fs_sidebar_posts
			'posts_nav',   // @feature: fs_sidebar_posts_nav
		);
		// @start feature: fs_plugin_woocommerce
		if ( class_exists( 'WooCommerce' ) ) {
			$widgets[] = 'price_filter';    // @feature: fs_sidebar_price_filter
			$widgets[] = 'products';        // @feature: fs_sidebar_products
			$widgets[] = 'filter_clean';    // @feature: fs_sidebar_filter_clean
			// @start feature: fs_addon_product_brand
			if ( ( function_exists( 'alpha_get_option' ) && alpha_get_option( 'brand' ) ) ||
			( class_exists( 'Alpha_Plugin_Options' ) && Alpha_Plugin_Options::get_option( 'alpha_product_brand', 'yes' ) ) ) {
				$widgets[] = 'brands_nav';   // @feature: fs_sidebar_brands_nav
			}
			// @end feature: fs_addon_product_brand
		}
		// @end feature: fs_plugin_woocommerce
		$widgets = apply_filters( 'alpha_sidebar_widgets', $widgets );
		foreach ( $widgets as $widget ) {
			include_once alpha_core_framework_path( ALPHA_BUILDERS . '/sidebar/widgets/' . str_replace( '_', '-', $widget ) . '.php' );
			register_widget( 'Alpha_' . ucwords( $widget, '_' ) . '_Sidebar_Widget' );
		}
	}

	/**
	 * Add admin menus.
	 *
	 * @since 1.0
	 */
	public function add_admin_menus() {
		// Menu - alpha / sidebar
		add_submenu_page( 'alpha', esc_html__( 'Sidebars', 'pandastore-core' ), esc_html__( 'Sidebars', 'pandastore-core' ), 'administrator', 'alpha_sidebar', array( Alpha_Sidebar_Builder::get_instance(), 'sidebar_view' ) );
	}

	/**
	 * Make collapsible menus.
	 *
	 * @since 1.0
	 */
	public function make_collapsible_menus( $nav_menu_args, $menu, $args, $instance ) {
		$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="menu collapsible-menu">%3$s</ul>';
		return $nav_menu_args;
	}

	/**
	 * Init sidebars.
	 *
	 * @since 1.0
	 */
	private function _init_sidebars() {
		$sidebars = get_option( 'alpha_sidebars' );
		if ( $sidebars ) {
			$sidebars       = json_decode( $sidebars, true );
			$this->sidebars = $sidebars;
		} else {
			$this->sidebars = array();
		}
	}

	/**
	 * Add localize vars.
	 *
	 * @since 1.0
	 */
	public function add_localize_vars( $vars ) {
		$vars['sidebars']  = $this->sidebars;
		$vars['admin_url'] = esc_url( admin_url() );
		return $vars;
	}

	/**
	 * Sidebar View
	 *
	 * @since 1.0
	 */
	public function sidebar_view() {
		if ( class_exists( 'Alpha_Admin_Panel' ) ) {
			$title        = array(
				'title' => esc_html__( 'Sidebars Builder', 'pandastore-core' ),
				'desc'  => esc_html__( 'This enables you to add unlimited widget areas for your stunning site and remove unnecessary sidebars.', 'pandastore-core' ),
			);
			$admin_config = Alpha_Admin::get_instance()->admin_config;
			Alpha_Admin_Panel::get_instance()->view_header( 'sidebars_builder', $admin_config, $title );
			?>
			
			<div class="alpha-admin-panel-body alpha-card-box sidebars-builder">
				<div class="alpha-sidebar-actions buttons">
					<button id="add_widget_area" class="alpha-sidebar-action button button-dark button-large"><?php esc_html_e( 'Add New Sidebar', 'pandastore-core' ); ?></button>
				</div>
				<table class="wp-list-table widefat" id="sidebar_table">
					<thead>
						<tr>
							<th scope="col" id="title" class="manage-column column-title column-primary"><?php esc_html_e( 'Title', 'pandastore-core' ); ?></th>
							<th scope="col" id="slug" class="manage-column column-slug"><?php esc_html_e( 'Slug', 'pandastore-core' ); ?></th>
							<th scope="col" id="remove" class="manage-column column-remove"><?php esc_html_e( 'Action', 'pandastore-core' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
					global $wp_registered_sidebars;
					$default_sidebars = array();
					foreach ( $wp_registered_sidebars as $key => $value ) {
						echo '<tr id="' . $key . '" class="sidebar">';
							echo '<td class="title column-title"><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' . $value['name'] . '</a></td>';
							echo '<td class="slug column-slug">' . $key . '</td>';
							echo '<td class="remove column-remove">' . ( in_array( $key, array_keys( $this->sidebars ) ) ? '<a href="#">' . esc_html__( 'Remove', 'pandastore-core' ) . '</a>' : esc_html__( 'Unremovable', 'pandastore-core' ) ) . '</td>';
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
			</div>
				<?php
				Alpha_Admin_Panel::get_instance()->view_footer( $admin_config );
		}
	}

	/**
	 * Add sidebar
	 *
	 * @since 1.0
	 */
	public function add_sidebar() {
		if ( ! check_ajax_referer( 'alpha-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( isset( $_POST['slug'] ) && isset( $_POST['name'] ) ) {
			$this->sidebars[ $_POST['slug'] ] = $_POST['name'];

			update_option( 'alpha_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully registered', 'pandastore-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}

	/**
	 * Remove sidebar
	 *
	 * @since 1.0
	 */
	public function remove_sidebar() {
		if ( ! check_ajax_referer( 'alpha-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( isset( $_POST['slug'] ) ) {
			unset( $this->sidebars[ $_POST['slug'] ] );

			update_option( 'alpha_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully removed', 'pandastore-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}
}

Alpha_Sidebar_Builder::get_instance();
