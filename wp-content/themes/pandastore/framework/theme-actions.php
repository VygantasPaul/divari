<?php
/**
 * Theme Actions & Filters
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

// The body tag's Class
add_filter( 'body_class', 'alpha_add_body_class' );

// The main tag's class
add_filter( 'alpha_main_class', 'alpha_add_main_class' );

// add aria label to search cat for seo purpose
add_filter( 'wp_dropdown_cats', 'alpha_add_search_cat_aria_label' );

// Pingback header
add_action( 'wp_head', 'alpha_pingback_header' );

// Font Preload
add_action( 'alpha_preload_fonts', 'alpha_fonts_preload_html' );

// Page layout
add_action( 'alpha_print_before_page_layout', 'alpha_print_layout_before' );
add_action( 'alpha_print_after_page_layout', 'alpha_print_layout_after' );

// Posts
add_action( 'alpha_before_posts_loop', 'alpha_setup_loop' );
add_action( 'alpha_after_posts_loop', 'alpha_reset_loop', 999 );

// Comment
add_filter( 'alpha_filter_comment_form_args', 'alpha_comment_form_args' );
add_action( 'comment_form_before_fields', 'alpha_comment_form_before_fields' );
add_action( 'comment_form_after_fields', 'alpha_comment_form_after_fields' );
add_filter( 'pre_get_avatar_data', 'alpha_set_avatar_size' );

// Author date
add_filter( 'alpha_filter_author_date_pattern', 'alpha_author_date_pattern' );

// Cookie
add_action( 'init', 'alpha_set_cookies' );

// Contact Form
add_action( 'wpcf7_init', 'alpha_wpcf7_add_form_tag_submit', 20, 0 );
add_filter( 'wpcf7_form_novalidate', 'alpha_wpcf7_form_novalidate' );

// Widget Compatabilities
add_filter( 'widget_nav_menu_args', 'alpha_widget_nav_menu_args', 10, 4 );

// Image Quality and Big Image Size Threshold
add_filter( 'jpeg_quality', 'alpha_set_image_quality' );
add_filter( 'wp_editor_set_quality', 'alpha_set_image_quality' );
add_filter( 'big_image_size_threshold', 'alpha_set_big_image_size_threshold' );

// update image srcset meta
add_filter( 'wp_calculate_image_srcset', 'alpha_image_srcset_filter_sizes', 10, 2 );

// Alpha Ajax Actions
add_action( 'wp_ajax_alpha_loadmore', 'alpha_loadmore' );
add_action( 'wp_ajax_nopriv_alpha_loadmore', 'alpha_loadmore' );
add_action( 'wp_ajax_alpha_account_form', 'alpha_ajax_account_form' );
add_action( 'wp_ajax_nopriv_alpha_account_form', 'alpha_ajax_account_form' );
add_action( 'wp_ajax_alpha_account_signin_validate', 'alpha_account_signin_validate' );
add_action( 'wp_ajax_nopriv_alpha_account_signin_validate', 'alpha_account_signin_validate' );
add_action( 'wp_ajax_alpha_account_signup_validate', 'alpha_account_signup_validate' );
add_action( 'wp_ajax_nopriv_alpha_account_signup_validate', 'alpha_account_signup_validate' );
add_action( 'wp_ajax_alpha_load_mobile_menu', 'alpha_load_mobile_menu' );
add_action( 'wp_ajax_nopriv_alpha_load_mobile_menu', 'alpha_load_mobile_menu' );
add_action( 'wp_ajax_alpha_load_menu', 'alpha_load_menu' );
add_action( 'wp_ajax_nopriv_alpha_load_menu', 'alpha_load_menu' );
add_action( 'wp_ajax_comment-feeling', 'alpha_ajax_comment_feeling' );
add_action( 'wp_ajax_nopriv_comment-feeling', 'alpha_ajax_comment_feeling' );
add_action( 'wp_ajax_alpha_print_popup', 'alpha_ajax_print_popup' );
add_action( 'wp_ajax_nopriv_alpha_print_popup', 'alpha_ajax_print_popup' );

if ( ! function_exists( 'alpha_pingback_header' ) ) {
	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @since 1.0.0
	 */
	function alpha_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
}

if ( ! function_exists( 'alpha_fonts_preload_html' ) ) {
	/**
	 * Render fonts preload HTML.
	 *
	 * @since 1.0.0
	 */
	function alpha_fonts_preload_html() {
		$preload_fonts = alpha_get_option( 'preload_fonts' );
		if ( ! empty( $preload_fonts ) ) {
			if ( in_array( 'alpha', $preload_fonts ) ) {
				echo '<link rel="preload" href="' . ALPHA_ASSETS . '/vendor/' . ALPHA_NAME . '-icons/fonts/' . ALPHA_NAME . '.ttf?5gap68" as="font" type="font/ttf" crossorigin>';
			}
			if ( in_array( 'fas', $preload_fonts ) ) {
				echo '<link rel="preload" href="' . ALPHA_ASSETS . '/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>';
			}
			if ( in_array( 'far', $preload_fonts ) ) {
				echo '<link rel="preload" href="' . ALPHA_ASSETS . '/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>';
			}
			if ( in_array( 'fab', $preload_fonts ) ) {
				echo '<link rel="preload" href="' . ALPHA_ASSETS . '/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>';
			}
		}
		if ( ! empty( $preload_fonts['custom'] ) ) {
			$font_urls = explode( "\n", $preload_fonts['custom'] );
			foreach ( $font_urls as $font_url ) {
				$dot_pos = strrpos( $font_url, '.' );
				if ( false !== $dot_pos ) {
					$type = substr( $font_url, $dot_pos + 1 );
					echo '<link rel="preload" href="' . esc_url( $font_url ) . '" as="font" type="font/' . esc_attr( $type ) . '" crossorigin>';
				}
			}
		}
	}
}

/**
 * Fires after setting default actions and filters.
 *
 * Here you can remove and add more actions and filters.
 *
 * @since 1.0
 */
do_action( 'alpha_after_default_actions' );

if ( ! function_exists( 'alpha_add_body_class' ) ) {
	/**
	 * Add classes to body
	 *
	 * @since 1.0
	 *
	 * @param array[string] $classes
	 *
	 * @return array[string] $classes
	 */
	function alpha_add_body_class( $classes ) {
		global $alpha_layout;

		// Site Layout
		if ( 'full' != alpha_get_option( 'site_type' ) ) { // Boxed or Framed
			$classes[] = 'site-boxed';
		}

		// Page Type
		$classes[] = 'alpha-' . str_replace( '_', '-', alpha_get_page_layout() ) . '-layout';

		// Disable Mobile Slider
		if ( alpha_get_option( 'mobile_disable_slider' ) ) {
			$classes[] = 'alpha-disable-mobile-slider';
		}

		// Disable Mobile Animation
		if ( alpha_get_option( 'mobile_disable_animation' ) ) {
			$classes[] = 'alpha-disable-mobile-animation';
		}

		if ( is_customize_preview() ) {
			$classes[] = 'alpha-disable-animation';
		}

		// Add single-product-page or shop-page to body class
		if ( alpha_is_product() ) {
			$classes[] = 'single-product-page';
		} elseif ( alpha_is_shop() ) {
			$classes[] = 'product-archive-page';
		}

		// @start feature: fs_plugin_woocommerce
		if ( class_exists( 'WooCommerce' ) && wc_get_page_id( 'compare' ) == get_the_ID() ) {
			$classes[] = 'compare-page';
		}
		// @end feature: fs_plugin_woocommerce

		global $alpha_layout;

		$post_style_type = isset( $alpha_layout['post_style_type'] ) ? $alpha_layout : '';

		// Category Filter
		if ( is_archive() && 'post' == get_post_type() && alpha_get_option( 'posts_filter' ) ) {
			$classes[] = 'breadcrumb-divider-active';
		}

		if ( alpha_get_option( 'rounded_skin' ) ) {
			$classes[] = 'alpha-rounded-skin';
		}

		if ( is_admin_bar_showing() ) {
			$classes[] = 'alpha-adminbar';
		}
		if ( defined( 'ALPHA_FRAMEWORK_VENDORS' ) ) {
			$classes[] = 'alpha-use-vendor-plugin';
		}
		return $classes;
	}
}

/**
 * Add search category aria abel.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_add_search_cat_aria_label' ) ) {
	function alpha_add_search_cat_aria_label( $output ) {
		$output = str_replace( " name='cat'", " name='cat' aria-label='" . esc_html__( 'Categories to search', 'pandastore' ) . "'", $output );
		$output = str_replace( " name='product_cat'", " name='product_cat' aria-label='" . esc_html__( 'Product categories to search', 'pandastore' ) . "'", $output );
		return $output;
	}
}

/**
 * Add main class.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_add_main_class' ) ) {
	function alpha_add_main_class( $classes ) {
		if ( ( defined( 'YITH_WCWL' ) && function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) ||
			( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ) {
			$classes .= ' pt-lg';
		}
		return $classes;
	}
}

/**
 * Print page title bar.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_print_title_bar' ) ) {
	function alpha_print_title_bar() {
		global $alpha_layout;

		if ( is_front_page() ) {
			// Do not show page title bar and breadcrumb in home page.
			if ( is_home() ) {
				$site_desc = get_option( 'blogdescription' );
				?>
<div class="page-header mb-8">
    <div class="page-title-bar">
        <div class="page-title-wrap">
            <?php if ( ! empty( $site_desc ) ) : ?>
            <h2 class="page-title"><?php echo alpha_strip_script_tags( $site_desc ); ?></h2>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
			}
		} else {
			if ( ! empty( $alpha_layout['ptb'] ) && 'hide' != $alpha_layout['ptb'] ) {
				// Display selected template instead of page title bar.
				$alpha_layout['is_page_header'] = true;
				alpha_print_template( $alpha_layout['ptb'] );
				unset( $alpha_layout['is_page_header'] );
			} elseif ( ( ! empty( $alpha_layout['ptb'] ) && 'hide' == $alpha_layout['ptb'] ) || apply_filters( 'alpha_is_vendor_store', false ) ) {
				// Hide page title bar.
			} elseif ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() ) ) {
				$alpha_layout['show_breadcrumb'] = 'no';
				?>
<div class="woo-page-header">
    <div class="<?php echo esc_attr( 'full' == $alpha_layout['wrap'] ? 'container' : $alpha_layout['wrap'] ); ?>">

        <ul class="breadcrumb">
            <li class="<?php echo is_cart() ? esc_attr( 'current' ) : ''; ?>">
                <a
                    href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo apply_filters( 'alpha_wc_checkout_ptb_title', esc_html__( 'Shopping Cart', 'pandastore' ), 'cart' ); ?></a>
            </li>
            <li class="<?php echo is_checkout() && ! is_order_received_page() ? esc_attr( 'current' ) : ''; ?>">
                <i class="delimiter"></i>
                <a
                    href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php echo apply_filters( 'alpha_wc_checkout_ptb_title', esc_html__( 'Checkout', 'pandastore' ), 'checkout' ); ?></a>
            </li>
            <li class="<?php echo is_order_received_page() ? esc_attr( 'current' ) : esc_attr( 'disable' ); ?>">
                <i class="delimiter"></i>
                <a
                    href="#"><?php echo apply_filters( 'alpha_wc_checkout_ptb_title', esc_html__( 'Order Complete', 'pandastore' ), 'order' ); ?></a>
            </li>
        </ul>

    </div>
</div>
<?php
			} else {
				// Show page header
				if ( class_exists( 'WooCommerce' ) && is_shop() ) { // Shop Page
					$page_id = wc_get_page_id( 'shop' );
				} elseif ( is_home() && get_option( 'page_for_posts' ) ) { // Blog Page
					$page_id = get_option( 'page_for_posts' );
				} else {
					$page_id = get_the_ID();
				}

				Alpha_Layout_Builder::get_instance()->setup_titles();
				$page_title = get_post_meta( $page_id, 'page_title', true );

				if ( ! $page_title ) {
					$page_title = $alpha_layout['title'];
				}
				$page_subtitle = get_post_meta( $page_id, 'page_subtitle', true );
				if ( ! $page_subtitle ) {
					$page_subtitle = $alpha_layout['subtitle'];
				}
				?>
<div class="page-header">
    <div class="page-title-bar">
        <div class="page-title-wrap">
            <?php if ( ! empty( $page_title ) ) : ?>
            <h2 class="page-title"><?php echo alpha_strip_script_tags( $page_title ); ?></h2>
            <?php endif; ?>
            <?php if ( ! empty( $page_subtitle ) ) : ?>
            <h3 class="page-subtitle"><?php echo alpha_strip_script_tags( $page_subtitle ); ?></h3>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
			}

			if ( empty( $alpha_layout['show_breadcrumb'] ) || 'no' != $alpha_layout['show_breadcrumb'] ) {
				alpha_breadcrumb();
			}
		}
	}
}

/**
 * Print layout before.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_print_layout_before' ) ) {
	function alpha_print_layout_before() {
		global $alpha_layout;

		$main_content_wrap_class = 'main-content-wrap';
		$has_left_sidebar        = apply_filters( 'alpha_has_left_sidebar', ! empty( $alpha_layout['left_sidebar'] ) && 'hide' != $alpha_layout['left_sidebar'] );
		$has_right_sidebar       = apply_filters( 'alpha_has_right_sidebar', ! empty( $alpha_layout['right_sidebar'] ) && 'hide' != $alpha_layout['right_sidebar'] );
		if ( $has_left_sidebar || $has_right_sidebar ) {
			$main_content_wrap_class .= ' row gutter-lg';
		}
		$main_content_wrap_class = apply_filters( 'alpha_main_content_wrap_cls', $main_content_wrap_class );

		if ( isset( $alpha_layout['wrap'] ) && 'full' != $alpha_layout['wrap'] ) {
			echo '<div class="' . esc_attr( 'container-fluid' == $alpha_layout['wrap'] ? 'container-fluid' : 'container' ) . '">';
		}

		do_action( 'alpha_before_main_content' );

		echo '<div class="' . esc_attr( $main_content_wrap_class ) . '">';

		if ( $has_left_sidebar ) {
			alpha_get_template_part( 'sidebar', null, array( 'position' => 'left' ) );
		}

		if ( $has_right_sidebar ) {
			alpha_get_template_part( 'sidebar', null, array( 'position' => 'right' ) );
		}

		do_action( 'alpha_sidebar' );

		echo '<div class="' . esc_attr( apply_filters( 'alpha_main_content_class', 'main-content' ) ) . '">';

		do_action( 'alpha_before_inner_content' );
	}
}

/**
 * Print layout after.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_print_layout_after' ) ) {
	function alpha_print_layout_after() {
		$ls        = false; // state of left sidebar
		$rs        = false; // state of right sidebar
		$ls_canvas = false; // on_canvas/off_canvas
		$rs_canvas = false; // on_canvas/off_canvas

		global $alpha_layout;

		do_action( 'alpha_after_inner_content', $alpha_layout );

		echo '</div>'; // End of main content wrap

		do_action( 'alpha_after_main_content' );

		echo '</div>';

		if ( is_page() && ! alpha_is_shop() && comments_open() ) {
			comments_template();
		}

		if ( isset( $alpha_layout['wrap'] ) && 'full' != $alpha_layout['wrap'] ) { // end of container or container-fluid
			echo '</div>';
		}
	}
}

/**
 * The comment form before fields.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_comment_form_before_fields' ) ) {
	function alpha_comment_form_before_fields() {
		echo '<div class="row">';
	}
}

/**
 * The comment form after fields.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_comment_form_after_fields' ) ) {
	function alpha_comment_form_after_fields() {
		echo '</div>';
	}
}

/**
 * Set avatar size.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_set_avatar_size' ) ) {
	function alpha_set_avatar_size( $args ) {
		$args['size']   = 90;
		$args['width']  = 90;
		$args['height'] = 90;
		return $args;
	}
}

/**
 * The author date pattern.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_author_date_pattern' ) ) {
	function alpha_author_date_pattern( $date ) {
		return date( 'F j, Y \a\t g:s a', strtotime( $date ) );
	}
}

/**
 * Set cookies.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_set_cookies' ) ) {
	function alpha_set_cookies() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		if ( ! empty( $_GET['top_filter'] ) ) {
			setcookie( 'top_filter', sanitize_title( $_GET['top_filter'] ), time() + ( 86400 ), '/' );
			$_COOKIE['alpha_top_filter'] = esc_html( $_GET['top_filter'] );
		}
		// phpcs:enable
	}
}

/**
 * Ajax actions: loadmore
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_loadmore' ) ) {
	function alpha_loadmore() {

		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		if ( isset( $_POST['args'] ) && isset( $_POST['props'] ) ) {
			$args  = $_POST['args'];
			$props = $_POST['props'];
			$cpt   = empty( $args['cpt'] ) ? 'post' : $args['cpt'];

			if ( 'product' == $cpt ) {
				/**
				 * Load more products
				 */
				$args  = $_POST['args'];
				$props = $_POST['props'];

				if ( isset( $args['paged'] ) && $args['paged'] ) {
					$args['page'] = $args['paged'];
					unset( $args['paged'] );
				}

				if ( isset( $args['total'] ) && $args['total'] ) {
					unset( $args['total'] );
				}

				if ( isset( $props['row_cnt'] ) ) {
					$GLOBALS['alpha_current_product_id'] = 0;
				}

				wc_set_loop_prop( 'alpha_ajax_load', true );

				foreach ( $props as $key => $prop ) {
					wc_set_loop_prop( $key, $prop );
				}

				$args_str = '';
				foreach ( $args as $key => $value ) {
					$args_str .= ' ' . $key . '=' . json_encode( $value );
				}

				$html = do_shortcode( '[products' . $args_str . ']' );

				echo alpha_escaped( $html );
			} else {
				/**
				 * Load more posts
				 */
				$posts = new WP_Query( $args );
				if ( $posts ) {

					ob_start();

					do_action( 'alpha_before_posts_loop', $props );

					alpha_get_template_part( 'posts/post', 'loop-start' );

					while ( $posts->have_posts() ) :
						$posts->the_post();
						alpha_get_template_part( 'posts/post' );
					endwhile;

					alpha_get_template_part( 'posts/post', 'loop-end' );

					do_action( 'alpha_after_posts_loop' );

					$html = ob_get_clean();

					if ( $_POST['pagination'] ) {
						echo json_encode(
							array(
								'html'       => $html,
								'pagination' => alpha_get_pagination( $posts, 'pagination-load' ),
							)
						);
					} else {
						echo alpha_escaped( $html );
					}

					wp_reset_postdata();
				}
			}
		}

		exit;

		// phpcs:enable
	}
}

/**
 * Ajax sign in/ sign up
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_ajax_account_form' ) ) {
	function alpha_ajax_account_form() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		wc_get_template( 'myaccount/form-login.php' );
		exit();
		// phpcs:enable
	}
}

// sign in ajax validate
if ( ! function_exists( 'alpha_account_signin_validate' ) ) {
	function alpha_account_signin_validate() {
		$nonce_value = wc_get_var( $_REQUEST['woocommerce-login-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
		$result      = false;
		if ( wp_verify_nonce( $nonce_value, 'woocommerce-login' ) ) {
			try {
				$creds = array(
					'user_login'    => trim( $_POST['username'] ),
					'user_password' => $_POST['password'],
					'remember'      => isset( $_POST['rememberme'] ),
				);

				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $_POST['username'], $_POST['password'] );

				if ( $validation_error->get_error_code() ) {
					echo json_encode(
						array(
							'loggedin' => false,
							'message'  => '<strong>' . esc_html__(
								'Error:',
								'pandastore'
							) . '</strong> ' . $validation_error->get_error_message(),
						)
					);
					die();
				}

				if ( empty( $creds['user_login'] ) ) {
					echo json_encode(
						array(
							'loggedin' => false,
							'message'  => '<strong>' . esc_html__(
								'Error:',
								'pandastore'
							) . '</strong> ' . esc_html__(
								'Username is required.',
								'pandastore'
							),
						)
					);
					die();
				}

				// On multisite, ensure user exists on current site, if not add them before allowing login.
				if ( is_multisite() ) {
					$user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

					if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
						add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
					}
				}

				// Perform the login
				$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );
				if ( ! is_wp_error( $user ) ) {
					$result = true;
				}
			} catch ( Exception $e ) {
			}
		}
		if ( $result ) {
			echo json_encode(
				array(
					'loggedin' => true,
					'message'  => esc_html__(
						'Login successful, redirecting...',
						'pandastore'
					),
				)
			);
		} else {
			echo json_encode(
				array(
					'loggedin' => false,
					'message'  => esc_html__(
						'Wrong username or password.',
						'pandastore'
					),
				)
			);
		}
		die();
	}
}

/**
 * Account signup validate
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_account_signup_validate' ) ) {
	function alpha_account_signup_validate() {

		$nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
		$nonce_value = isset( $_POST['woocommerce-register-nonce'] ) ? $_POST['woocommerce-register-nonce'] : $nonce_value;
		$result      = true;

		if ( wp_verify_nonce( $nonce_value, 'woocommerce-register' ) ) {
			$username = 'no' == get_option( 'woocommerce_registration_generate_username' ) ? $_POST['username'] : '';
			$password = 'no' == get_option( 'woocommerce_registration_generate_password' ) ? $_POST['password'] : '';
			$email    = $_POST['email'];

			try {
				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );

				if ( $validation_error->get_error_code() ) {
					echo json_encode(
						array(
							'loggedin' => false,
							'message'  => $validation_error->get_error_message(),
						)
					);
					die();
				}

				$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

				if ( is_wp_error( $new_customer ) ) {
					echo json_encode(
						array(
							'loggedin' => false,
							'message'  => $new_customer->get_error_message(),
						)
					);
					die();
				}

				if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
					wc_set_customer_auth_cookie( $new_customer );
				}
			} catch ( Exception $e ) {
				$result = false;
			}
		}
		if ( $result ) {
			echo json_encode(
				array(
					'loggedin' => true,
					'message'  => esc_html__(
						'Register successful, redirecting...',
						'pandastore'
					),
				)
			);
		} else {
			echo json_encode(
				array(
					'loggedin' => false,
					'message'  => esc_html__(
						'Register failed.',
						'pandastore'
					),
				)
			);
		}
		die();
	}
}

/**
 * Load Mobile Menu
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_load_mobile_menu' ) ) {
	function alpha_load_mobile_menu() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		?>
<!-- Search Form -->
<div class="search-wrapper hs-simple">
    <form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="input-wrapper">
        <input type="hidden" name="post_type"
            value="<?php echo esc_attr( alpha_get_option( 'search_post_type' ) ); ?>" />
        <input type="search" class="form-control" name="s"
            placeholder="<?php echo esc_attr( esc_html__( 'Search', 'pandastore' ) ); ?>" required=""
            autocomplete="off">

        <?php if ( alpha_get_option( 'live_search' ) ) : ?>
        <div class="live-search-list"></div>
        <?php endif; ?>

        <button class="btn btn-search" type="submit">
            <i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-search"></i>
        </button>
    </form>
</div>

<?php
		$mobile_menus      = alpha_get_option( 'mobile_menu_items' );
		$mobile_menus_temp = array();
		foreach ( $mobile_menus as $menu ) {
			if ( empty( $menu ) ) {
				continue;
			}
			$menu_obj = is_numeric( $menu ) ? get_term( $menu, 'nav_menu' ) : get_term_by( 'slug', $menu, 'nav_menu' );
			if ( empty( $menu_obj ) || is_wp_error( $menu_obj ) ) {
				continue;
			}
			$mobile_menus_temp[] = $menu;
		}
		$mobile_menus = $mobile_menus_temp;

		if ( ! empty( $mobile_menus ) ) {
			?>
<div class="nav-wrapper">
    <?php
				if ( count( $mobile_menus ) > 1 ) {
					?>
    <div class="tab tab-nav-simple tab-nav-boxed">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php
							$first = true;
							foreach ( $mobile_menus as $menu ) :
								$menu_obj = is_numeric( $menu ) ? get_term( $menu, 'nav_menu' ) : get_term_by( 'slug', $menu, 'nav_menu' );
								?>
            <li class="nav-item">
                <a class="nav-link<?php echo ! $first ? '' : ' active'; ?>"
                    href="#<?php echo esc_html( $menu ); ?>"><?php echo esc_html( $menu_obj->name ); ?></a>
            </li>
            <?php $first = false; ?>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php
							$first = true;
							foreach ( $mobile_menus as $menu ) :
								?>
            <div class="tab-pane<?php echo ! $first ? '' : ' active in'; ?>"
                id="<?php echo esc_html( strtolower( $menu ) ); ?>">
                <?php
									wp_nav_menu(
										array(
											'menu'       => $menu,
											'container'  => 'nav',
											'container_class' => $menu,
											'items_wrap' => '<ul id="%1$s" class="mobile-menu">%3$s</ul>',
											'walker'     => class_exists( 'Alpha_Walker_Nav_Menu' ) ? new Alpha_Walker_Nav_Menu() : new Walker_Nav_Menu(),
											'theme_location' => '',
										)
									);
									$first = false;
									?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
				} else {
					foreach ( $mobile_menus as $menu ) {
						wp_nav_menu(
							array(
								'menu'            => $menu,
								'container'       => 'nav',
								'container_class' => $menu,
								'items_wrap'      => '<ul id="%1$s" class="mobile-menu">%3$s</ul>',
								'walker'          => class_exists( 'Alpha_Walker_Nav_Menu' ) ? new Alpha_Walker_Nav_Menu() : new Walker_Nav_Menu(),
								'theme_location'  => '',
							)
						);
					}
				}
				?>
    </div>
    <?php
		} elseif ( has_nav_menu( 'main-menu' ) ) {
			?>
    <div class="nav-wrapper">
        <?php
				wp_nav_menu(
					array(
						'container'       => 'nav',
						'container_class' => '',
						'items_wrap'      => '<ul id="%1$s" class="mobile-menu">%3$s</ul>',
						'walker'          => class_exists( 'Alpha_Walker_Nav_Menu' ) ? new Alpha_Walker_Nav_Menu() : new Walker_Nav_Menu(),
						'theme_location'  => 'main-menu',
					)
				);
				?>
    </div>
    <?php
		}

		if ( alpha_doing_ajax() && $_REQUEST['action'] && 'alpha_load_mobile_menu' == $_REQUEST['action'] ) {
			die;
		}

		// phpcs:enable
	}
}

/**
 * Load Menu
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_load_menu' ) ) {
	function alpha_load_menu() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		if ( isset( $_POST['menus'] ) && is_array( $_POST['menus'] ) ) {
			$menus = $_POST['menus'];
			if ( ! empty( $menus ) ) {
				$result = array();
				foreach ( $menus as $menu ) {
					$result[ $menu ] = wp_nav_menu(
						array(
							'menu'       => $menu,
							'container'  => '',
							'items_wrap' => '%3$s',
							'walker'     => class_exists( 'Alpha_Walker_Nav_Menu' ) ? new Alpha_Walker_Nav_Menu() : new Walker_Nav_Menu(),
							'echo'       => false,
						)
					);
				}
				echo json_encode( $result );
			}
		}

		exit;

		// phpcs:enable
	}
}

/**
 * Alpha Contact Form Functions
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wpcf7_add_form_tag_submit' ) ) {
	function alpha_wpcf7_add_form_tag_submit() {
		wpcf7_remove_form_tag( 'submit' );
		wpcf7_add_form_tag( 'submit', 'alpha_wpcf7_submit_form_tag_handler' );
	}
}

if ( ! function_exists( 'alpha_wpcf7_submit_form_tag_handler' ) ) {
	function alpha_wpcf7_submit_form_tag_handler( $tag ) {
		$class = wpcf7_form_controls_class( $tag->type );

		$atts = array();

		$atts['class']    = $tag->get_class_option( $class );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		$value = isset( $tag->values[0] ) ? $tag->values[0] : '';

		if ( empty( $value ) ) {
			$value = esc_html__( 'Send', 'pandastore' );
		}

		$atts['type']  = 'submit';
		$atts['value'] = $value;

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf( '<button %1$s>%2$s</button>', $atts, esc_html( $value ) );

		return $html;
	}
}

function alpha_wpcf7_form_novalidate() {
	return '';
}

/**
 * Alpha Widget Compatability Functions
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_widget_nav_menu_args' ) ) {
	function alpha_widget_nav_menu_args( $nav_menu_args, $menu, $args, $instance ) {
		$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="menu collapsible-menu">%3$s</ul>';
		return $nav_menu_args;
	}
}

/**
 * The image quality
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_set_image_quality' ) ) {
	function alpha_set_image_quality() {
		return alpha_get_option( 'image_quality', 82 );
	}
}

/**
 * The big image size Threshold
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_set_big_image_size_threshold' ) ) {
	function alpha_set_big_image_size_threshold() {
		return alpha_get_option( 'big_image_threshold', 2560 );
	}
}

/**
 * The comment feeling
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_ajax_comment_feeling' ) ) {
	function alpha_ajax_comment_feeling() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		$id = isset( $_POST['comment_id'] ) ? $_POST['comment_id'] : 0;
		if ( $id ) {
			$action        = $_POST['button'];
			$status        = isset( $_COOKIE[ 'alpha_comment_feeling_' . $id ] ) ? (int) $_COOKIE[ 'alpha_comment_feeling_' . $id ] : 0;
			$like_count    = get_comment_meta( $id, 'like_count', true );
			$dislike_count = get_comment_meta( $id, 'dislike_count', true );

			if ( 'like' == $action ) {
				if ( 1 == $status ) {
					-- $like_count;
					$status = 0;
				} else {
					if ( -1 == $status ) {
						-- $dislike_count;
					}

					++ $like_count;
					$status = 1;
				}
			} else {
				if ( -1 == $status ) {
					-- $dislike_count;
					$status = 0;
				} else {
					if ( 1 == $status ) {
						-- $like_count;
					}

					++ $dislike_count;
					$status = -1;
				}
			}

			$like_count    = max( 0, $like_count );
			$dislike_count = max( 0, $dislike_count );

			if ( $status ) {
				setcookie( 'comment_feeling_' . intval( $id ), $status, time() + 360 * 24 * 60 * 60, '/' );
			} else {
				setcookie( 'comment_feeling_' . intval( $id ), '', time() - 360 * 24 * 60 * 60, '/' );
			}

			update_comment_meta( $id, 'like_count', $like_count );
			update_comment_meta( $id, 'dislike_count', $dislike_count );

			echo json_encode( array( $status, intval( $like_count ), intval( $dislike_count ) ) );
		}

		// phpcs:enable
		exit();
	}
}


if ( ! function_exists( 'alpha_comment_form_args' ) ) {

	/**
	 * Set comment form arguments
	 *
	 * @since 1.0
	 */
	function alpha_comment_form_args( $args ) {
		$args['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title">';
		$args['title_reply_after']  = '</h3>';
		$args['fields']['author']   = '<div class="col-md-6"><input name="author" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Your Name', 'pandastore' ) . '"> </div>';
		$args['fields']['email']    = '<div class="col-md-6"><input name="email" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Your Email', 'pandastore' ) . '"> </div>';

		$args['comment_field']  = isset( $args['comment_field'] ) ? $args['comment_field'] : '';
		$args['comment_field']  = substr( $args['comment_field'], 0, strpos( $args['comment_field'], '<p class="comment-form-comment">' ) );
		$args['comment_field'] .= '<textarea name="comment" id="comment" class="form-control" rows="6" maxlength="65525" required="required" placeholder="' . esc_attr__( 'Write Your Review Here&hellip;', 'pandastore' ) . '"></textarea>';
		$args['submit_button']  = '<button type="submit" class="btn btn-dark btn-submit">' .
			( alpha_is_product() ? esc_html__( 'Submit Review', 'pandastore' ) : esc_html__( 'Post Comment', 'pandastore' ) . ' <i class=" ' . ALPHA_ICON_PREFIX . '-icon-arrow-long-right"></i>' ) . '</button>';

		return $args;
	}
}

if ( ! function_exists( 'alpha_ajax_print_popup' ) ) {

	/**
	 * Render popup template when a specific selector is clicked
	 *
	 * @since 1.0
	 */
	function alpha_ajax_print_popup() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		$id = isset( $_POST['popup_id'] ) ? $_POST['popup_id'] : 0;

		if ( $id ) {
			alpha_print_popup_template( $id, '', '' );
		}

		// phpcs:enable
		exit();
	}
}

if ( ! function_exists( 'alpha_setup_loop' ) ) {

	/**
	 * Sets up the alpha_loop global from the passed args or from the main query.
	 *
	 * @since 1.0
	 * @param array $args Args to pass into the global.
	 */
	function alpha_setup_loop( $args = array() ) {

		if ( ! is_array( $args ) ) {
			$args = array();
		}

		if ( isset( $args['cpt'] ) && apply_filters( 'alpha_custom_post_types', array() ) ) {
			$cpt = $args['cpt'];
		} else {
			global $post;
			if ( function_exists( 'alpha_is_elementor_preview' ) && alpha_is_elementor_preview() && ALPHA_NAME . '_template' == $post->post_type && 'archive' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
				$cpt = Alpha_Template_Archive_Builder::get_instance()->preview_mode;
			} else {
				if ( is_search() && 'any' == get_query_var( 'post_type' ) ) {
					$cpt = 'post';
				} else {
				$cpt = get_post_type();
			}
			}
			if ( ALPHA_NAME == substr( $cpt, 0, strlen( ALPHA_NAME ) ) && in_array( substr( $cpt, strlen( ALPHA_NAME ) + 1 ), apply_filters( 'alpha_custom_post_types', array() ) ) ) {
				$cpt = substr( $cpt, strlen( ALPHA_NAME ) + 1 );
			} else {
				$cpt = 'post';
			}
		}

		$related = ! empty( $args['related'] );
		$widget  = ! empty( $args['widget'] );
		if ( is_archive() ) {
			$layout = $GLOBALS['alpha_layout'];
		} else {
			if ( ! isset( $GLOBALS[ 'alpha_layout_archive_' . $cpt ] ) ) {
				$GLOBALS[ 'alpha_layout_archive_' . $cpt ] = Alpha_Layout_Builder::get_instance()->get_layout( 'archive_' . $cpt );
			}
			$layout = $GLOBALS[ 'alpha_layout_archive_' . $cpt ];
		}

		$default_args = apply_filters(
			'alpha_post_loop_default_args',
			array(
				'cpt'             => $cpt,
				'type'            => isset( $layout['post_type'] ) ? $layout['post_type'] : 'default',
				'widget'          => $widget,
				'related'         => $related,
				'image_size'      => 'alpha-post-small',
				'read_more_class' => 'btn-dark btn-link btn-underline',
				'read_more_label' => 'post' != $cpt ? alpha_get_option( $cpt . '_read_more_label' ) : esc_html__( 'Read More', 'pandastore' ) . ' <i class="' . ALPHA_ICON_PREFIX . '-icon-arrow-long-right"></i>',
				'posts_layout'    => isset( $layout['posts_layout'] ) ? $layout['posts_layout'] : '',
				'posts_column'    => isset( $layout['posts_column'] ) ? $layout['posts_column'] : '',
				'excerpt_type'    => isset( $layout['excerpt_type'] ) ? $layout['excerpt_type'] : '',
				'excerpt_length'  => isset( $layout['excerpt_length'] ) ? $layout['excerpt_length'] : '',
				'overlay'         => isset( $layout['post_overlay'] ) ? $layout['post_overlay'] : '',
				'loadmore_type'   => isset( $layout['loadmore_type'] ) ? $layout['loadmore_type'] : '',
				'loadmore_args'   => array(
					'cpt'  => $cpt,
					'blog' => ! $widget,
				),
				'loadmore_label'  => esc_html__( 'Load More', 'pandastore' ),
			)
		);

		if ( ! isset( $args['type'] ) ) {
			if ( isset( $_REQUEST['post_style_type'] ) ) {
				$args['type'] = $_REQUEST['post_style_type'];
			} elseif ( alpha_doing_ajax() && ! empty( $_REQUEST['only_posts'] ) ) {
				$args['type'] = '';
			}
		}

		if ( isset( $args['thumbnail_size'] ) ) {
			$args['image_size'] = $args['thumbnail_size'];
		}
		if ( alpha_doing_ajax() && ! empty( $_REQUEST['post_image'] ) ) {
			$args['image_size'] = wp_unslash( $_REQUEST['post_image'] );
		}

		if ( ! isset( $args['col_cnt'] ) ) {
			$args['col_cnt']        = alpha_get_responsive_cols(
				array(
					'lg' => intval(
						isset( $args['posts_column'] ) ? $args['posts_column'] : (
							isset( $layout['posts_column'] ) ? $layout['posts_column'] : 1
						)
					),
				)
			);
			$args['col_cnt']['min'] = 1;
		}

		if ( isset( $args['layout'] ) ) {
			$args['posts_layout'] = $args['layout'];
		}

		// Merge any existing values.
		if ( isset( $GLOBALS['alpha_loop'] ) ) {
			$default_args = array_merge( $default_args, $GLOBALS['alpha_loop'] );
		}
		$GLOBALS['alpha_loop'] = wp_parse_args( apply_filters( 'alpha_post_args', $args ), $default_args );
		if ( $widget ) {
			$GLOBALS['alpha_post_idx'] = 0;
		}
	}
}


if ( ! function_exists( 'alpha_reset_loop' ) ) {

	/**
	 * Resets the alpha_loop global.
	 *
	 * @since 1.0
	 */
	function alpha_reset_loop() {
		unset( $GLOBALS['alpha_loop'] );
	}
}


if ( ! function_exists( 'alpha_set_loop_prop' ) ) {
	/**
	 * Sets a property in the alpha_loop global.
	 *
	 * @since 1.0
	 * @param string $prop Prop to set.
	 * @param string $value Value to set.
	 */
	function alpha_set_loop_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['alpha_loop'] ) ) {
			alpha_setup_loop();
		}
		$GLOBALS['alpha_loop'][ $prop ] = $value;
	}
}


if ( ! function_exists( 'alpha_get_loop_prop' ) ) {
	/**
	 * Gets a property from the alpha_loop global.
	 *
	 * @since 1.0
	 * @param string $prop Prop to get.
	 * @param string $default Default if the prop does not exist.
	 * @return mixed
	 */
	function alpha_get_loop_prop( $prop, $default = '' ) {
		if ( ! isset( $GLOBALS['alpha_loop'] ) ) {
			alpha_setup_loop(); // Ensure posts loop is setup.
		}

		return isset( $GLOBALS['alpha_loop'], $GLOBALS['alpha_loop'][ $prop ] ) ? $GLOBALS['alpha_loop'][ $prop ] : $default;
	}
}

if ( ! function_exists( 'alpha_image_srcset_filter_sizes' ) ) :
	function alpha_image_srcset_filter_sizes( $sources, $size_array ) {
		foreach ( $sources as $width => $source ) {
			if ( isset( $source['descriptor'] ) && 'w' == $source['descriptor'] && ( $width < apply_filters( 'alpha_mini_screen_size', 320 ) || (int) $width > (int) $size_array[0] ) ) {
				unset( $sources[ $width ] );
			}
		}
		return $sources;
	}
endif;