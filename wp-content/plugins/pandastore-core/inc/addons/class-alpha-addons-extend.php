<?php
/**
 * Alpha Template
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Addons_Extend' ) ) {
	class Alpha_Addons_Extend {

		/**
		 * The Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'alpha_framework_addons', array( $this, 'after_framework_addons' ), 11 );
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ), 20 );
			// Share
			add_action( 'init', array( $this, 'setup_wc_share' ) );
			// Post Comments Pagination
			add_filter( 'alpha_comments_pagination_args', array( $this, 'post_comments_pagination_args' ) );
			//
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Hooks after Framewrok addons
		 *
		 * @since 1.0
		 */
		public function after_framework_addons() {
		}

		/**
		 * After setup theme
		 *
		 * @since 1.0
		 */
		public function after_setup_theme() {
			if ( class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_addon_product_image_comments' ) && class_exists( 'Alpha_Product_Image_Comment' ) ) {
				// Change order of review images and votes
				remove_action( 'woocommerce_review_after_comment_text', array( Alpha_Product_Image_Comment::get_instance(), 'display_images' ), 30 );
				add_action( 'woocommerce_review_after_comment_text', array( Alpha_Product_Image_Comment::get_instance(), 'display_images' ), 19 );
			}
		}

		/**
		 * Setup WooCommerce share
		 *
		 * @since 1.0
		 */
		public function setup_wc_share() {
			remove_action( 'woocommerce_share', 'alpha_print_share' );
			add_action( 'woocommerce_share', array( $this, 'print_share' ) );
		}

		/**
		 * Print Share
		 *
		 * @since 1.0
		 */
		public function print_share() {
			if ( ! function_exists( 'alpha_get_option' ) || ! function_exists( 'alpha_get_social_shares' ) ) {
				return;
			}

			ob_start();
			?>
			<div class="social-icons">
				<label class="social-icons-label"><?php echo esc_html__( 'Share', 'pandastore-core' ); ?>: </label>
				<?php

				$social_shares = alpha_get_social_shares();
				$icon_type     = alpha_get_option( 'share_type' );
				$custom        = alpha_get_option( 'share_use_hover' ) ? '' : ' use-hover';

				foreach ( alpha_get_option( 'share_icons' ) as $share ) {
					$permalink = apply_filters( 'the_permalink', get_permalink() );
					$title     = esc_attr( get_the_title() );
					$image     = wp_get_attachment_url( get_post_thumbnail_id() );

					if ( class_exists( 'YITH_WCWL' ) && is_user_logged_in() ) {
						if ( get_option( 'yith_wcwl_wishlist_page_id' ) == get_the_ID() ) {
							$wishlist_id = ( YITH_WCWL()->last_operation_token ) ? YITH_WCWL()->last_operation_token : YITH_WCWL()->details['wishlist_id'];
							$permalink  .= '/view/' . $wishlist_id;
							$permalink   = urlencode( $permalink );
						}
					}

					$permalink = esc_url( $permalink );

					if ( 'whatsapp' == $share ) {
						$title = rawurlencode( $title );
					} else {
						$title = urlencode( $title );
					}

					$link = strtr(
						$social_shares[ $share ]['link'],
						array(
							'$permalink' => $permalink,
							'$title'     => $title,
							'$image'     => $image,
						)
					);
					$link = 'whatsapp' == $share || 'email' == $share ? esc_attr( $link ) : esc_url( $link );
					$link = $link ? $link : '#';

					echo '<a href="' . esc_url( alpha_escaped( $link ) ) . '" class="social-icon ' . esc_attr( $icon_type . $custom ) . ' social-' . $share . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr( $social_shares[ $share ]['title'] ) . '">';
					echo '<i class="' . esc_attr( $social_shares[ $share ]['icon'] ) . '"></i>';
					echo '</a>';
				}
				?>
			</div>
			<?php
			echo ob_get_clean();
		}

		/**
		 * Post Comments Pagination
		 *
		 * @since 1.0
		 */
		public function post_comments_pagination_args( $args ) {
			$args['prev_text'] = '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i>';
			$args['next_text'] = '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i>';
			return $args;
		}

		/**
		 * Custom Scripts
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'alpha-product-helpful-comments-extend', ALPHA_CORE_INC_URI . '/addons/product-helpful-comments-extend/product-helpful-comments-extend.min.css', array( 'alpha-product-helpful-comments' ), ALPHA_CORE_VERSION, 'all' );
		}
	}
}

new Alpha_Addons_Extend;
