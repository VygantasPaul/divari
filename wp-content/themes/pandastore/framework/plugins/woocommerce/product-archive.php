<?php
/**
 * Alpha WooCommerce Archive Product Functions
 *
 * Functions used to display archive product.
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_filter( 'loop_shop_per_page', 'alpha_loop_shop_per_page' );
add_action( 'alpha_wc_result_count', 'woocommerce_result_count' );
add_filter( 'woocommerce_layered_nav_count', 'alpha_woo_layered_nav_count' );
add_filter( 'woocommerce_widget_get_current_page_url', 'alpha_woo_widget_get_current_page_url' );
add_filter( 'woocommerce_layered_nav_link', 'alpha_woo_widget_clean_link' );
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Alpha shop page products count
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_loop_shop_per_page' ) ) {
	function alpha_loop_shop_per_page( $count_select = '' ) {
		if ( ! empty( $_GET['count'] ) ) {
			return (int) $_GET['count'];
		}

		if ( ! is_array( $count_select ) ) {

			$count_select = '';

			if ( ! $count_select ) {
				$count_select = apply_filters( 'alpha_products_count_select', alpha_get_option( 'products_count_select' ) );
			}

			if ( $count_select ) {
				$count_select = explode( ',', str_replace( ' ', '', $count_select ) );
			} else {
				$count_select = array( '9', '_12', '24', '36' );
			}
		}

		$default = $count_select[0];

		foreach ( $count_select as $num ) {
			if ( is_string( $num ) && '_' == substr( $num, 0, 1 ) ) {
				$default = (int) str_replace( '_', '', $num );
				break;
			}
		}

		return $default;
	}
}

/**
 * Alpha shop page - select form for products count
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_count_per_page' ) ) {
	function alpha_wc_count_per_page() {
		global $alpha_layout;

		$count_select = apply_filters( 'alpha_products_count_select', alpha_get_option( 'products_count_select' ) );
		$ts           = ! empty( $alpha_layout['top_sidebar'] ) && 'hide' != $alpha_layout['top_sidebar'] && is_active_sidebar( $alpha_layout['top_sidebar'] );
		?>
		<div class="toolbox-item toolbox-show-count select-box">
			<select name="count" class="count form-control">
				<?php
				if ( ! empty( $count_select ) ) {
					$count_select = explode( ',', str_replace( ' ', '', $count_select ) );
				} else {
					$count_select = array( '9', '_12', '24', '36' );
				}

				$current = alpha_loop_shop_per_page( $count_select );

				foreach ( $count_select as $count ) {
					$num = (int) str_replace( '_', '', $count );
					echo '<option value="' . esc_attr( $num ) . '" ' . selected( $num == $current, true, false ) . '>' . esc_html__( 'Show ', 'pandastore' ) . $num . '</option>';
				}
				?>
			</select>
			<?php
			$except = array( 'count' );
			// Keep query string vars intact
			foreach ( $_GET as $key => $val ) {
				if ( in_array( $key, $except ) ) {
					continue;
				}

				if ( is_array( $val ) ) {
					foreach ( $val as $inner_val ) {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $inner_val ) . '" />';
					}
				} else {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
				}
			}
			?>
		</div>
		<?php
	}
}

/**
 * Alpha shop page show type
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_shop_show_type' ) ) {
	function alpha_wc_shop_show_type() {
		$is_list_type = isset( $_GET['showtype'] ) && 'list' == $_GET['showtype'];

		$domain  = parse_url( get_site_url() );
		$cur_url = esc_url( $domain['host'] . remove_query_arg( 'showtype' ) );
		?>
		<div class="toolbox-item toolbox-show-type">
			<a href="<?php echo esc_url( alpha_add_url_parameters( $cur_url, 'showtype', 'grid' ) ); ?>" class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-grid btn-showtype<?php echo boolval( $is_list_type ) ? '' : ' active'; ?>"></a>
			<a href="<?php echo esc_url( alpha_add_url_parameters( $cur_url, 'showtype', 'list' ) ); ?>" class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-list btn-showtype<?php echo boolval( $is_list_type ) ? ' active' : ''; ?>"></a>
		</div>
		<?php
		do_action( 'alpha_wc_archive_after_toolbox' );
	}
}


/**
 * Hide nav list count
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_woo_layered_nav_count' ) ) {
	function alpha_woo_layered_nav_count() {
		return '';
	}
}

if ( ! function_exists( 'alpha_woo_widget_get_current_page_url' ) ) {
	/**
	 * Add showtype, count params to current page URL when various filtering works.
	 *
	 * @param string $link
	 * @return string
	 * @since 1.0
	 */
	function alpha_woo_widget_get_current_page_url( $link ) {

		if ( isset( $_GET['showtype'] ) && 'list' == $_GET['showtype'] ) {
			$link = alpha_add_url_parameters( $link, 'showtype', 'list' );
		}

		if ( ! empty( $_GET['count'] ) ) {
			$link = alpha_add_url_parameters( $link, 'count', (int) $_GET['count'] );
		}

		return $link;
	}
}
