<?php
/**
 * General action
 *
 * 1. General
 * 2. Products archive
 * 3. Product
 * 4. Single product
 * 5. Single Post
 * 6. Post
 * 7. Product category
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

/**************************************/
/* 1. General                         */
/**************************************/

/**
 * Filters the pagination args.
 *
 * @since 1.0
 */
add_filter( 'alpha_filter_pagination_args', 'alpha_filter_pagination_args' );

/**
 * Adjust post image size.
 *
 * @since 1.0
 */
add_filter( 'alpha_image_sizes', 'alpha_post_image_sizes' );

/**
 * Adjust checkout PTB title.
 *
 * @since 1.0
 */
add_filter( 'alpha_wc_checkout_ptb_title', 'wc_checkout_ptb_title', 10, 2 );

/**
 * Post image resize
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_post_image_sizes' ) ) {
	function alpha_post_image_sizes( $image_sizes ) {
		$image_sizes = array_merge(
			$image_sizes,
			array(
				'alpha-post-small'        => array(
					'width'  => 400,
					'height' => 250,
					'crop'   => true,
				),
				'alpha-product-thumbnail' => array(
					'width'  => 180,
					'height' => 0,
					'crop'   => true,
				),
			)
		);
		return $image_sizes;
	}
}

/**
 * Print Pagination.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_filter_pagination_args' ) ) {
	function alpha_filter_pagination_args( $args ) {
		$args = array(
			'prev_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i>',
			'next_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i>',
		);
		return $args;
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
			$main_content_wrap_class .= ' row gutter-xl';
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
 * Adjust checkout PTB title.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wc_checkout_ptb_title' ) ) {
	function wc_checkout_ptb_title( $title, $step ) {
		if ( 'cart' == $step ) {
			$title = esc_html__( '1.Shopping Cart', 'pandastore' );
		} elseif ( 'checkout' == $step ) {
			$title = esc_html__( '2.Checkout', 'pandastore' );
		} else {
			$title = esc_html__( '3.Order Complete', 'pandastore' );
		}

		return $title;
	}
}

add_filter( 'alpha_vars', 'alpha_add_quickview_var' );

/**
 * Change quickview var.
 *
 * @since 1.0
 * @var $var array
 */
if ( ! function_exists( 'alpha_add_quickview_var' ) ) {
	function alpha_add_quickview_var( $var ) {
		$var['quickview_wrap_1']  = esc_js( 'col-md-7' );
		$var['quickview_wrap_2']  = esc_js( 'col-md-5' );
		$var['quickview_percent'] = esc_js( '42.2%' );
		return $var;
	}
}
/**************************************/
/* 2. Product archive                 */
/**************************************/

/**
 * Shop page toolbox - products count
 *
 * @see plugins/woocommerce/product-archive.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_loop_shop_per_page' ) ) {
	function alpha_loop_shop_per_page( $count_select = '' ) {
		if ( ! empty( $_GET['count'] ) ) {
			return (int) $_GET['count'];
		}

		if ( ! is_array( $count_select ) ) {
			global $wp_query;
			$query = $wp_query->query;

			$count_select = '';

			if ( ! $count_select ) {
				$count_select = alpha_get_option( 'products_count_select' );
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
 * Shop page toolbox - select form for products count
 *
 * @see plugins/woocommerce/product-archive.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_count_per_page' ) ) {
	function alpha_wc_count_per_page() {
		global $alpha_layout;

		$count_select = apply_filters( 'alpha_products_count_select', alpha_get_option( 'products_count_select' ) );
		$ts           = ! empty( $alpha_layout['top_sidebar'] ) && 'hide' == $alpha_layout['top_sidebar'] && is_active_sidebar( $alpha_layout['top_sidebar'] );
		?>
		<div class="toolbox-item toolbox-show-count select-box">
			<?php if ( ! $ts ) : ?>
			<label><?php esc_html_e( 'Show:', 'pandastore' ); ?></label>
			<?php endif; ?>
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
					echo '<option value="' . $num . '" ' . selected( $num == $current, true, false ) . '>' . $num . '</option>';
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
 * Shop page toolbox - showtype
 *
 * @see plugins/woocommerce/product-archive.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_shop_show_type' ) ) {
	function alpha_wc_shop_show_type() {
		$is_list_type = isset( $_GET['showtype'] ) && 'list' == $_GET['showtype'];

		$domain  = parse_url( get_site_url() );
		$cur_url = str_replace( 'http://', 'https://', esc_url( $domain['host'] . remove_query_arg( 'showtype' ) ) );
		?>
		<div class="toolbox-item toolbox-show-type">
			<a href="<?php echo esc_url( alpha_add_url_parameters( $cur_url, 'showtype', 'list' ) ); ?>" class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-list btn-showtype<?php echo boolval( $is_list_type ) ? ' active' : ''; ?>"></a>
			<a href="<?php echo esc_url( alpha_add_url_parameters( $cur_url, 'showtype', 'grid' ) ); ?>" class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-grid btn-showtype<?php echo boolval( $is_list_type ) ? '' : ' active'; ?>"></a>
		</div>
		<?php
		do_action( 'alpha_wc_archive_after_toolbox' );
	}
}

/**************************************/
/* 3. Product                         */
/**************************************/

/**
 * Get the rating link html.
 *
 * @see plugins/woocommerce/product-loop.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_rating_link_html' ) ) {
	function alpha_get_rating_link_html( $product ) {
		if ( 'product-4' == wc_get_loop_prop( 'product_type' ) ) {
			return '<a href="' . esc_url( get_the_permalink( $product->get_id() ) ) . '#reviews" class="woocommerce-review-link scroll-to" rel="nofollow">(' . $product->get_review_count() . ')</a>';
		} else {
			return '<a href="' . esc_url( get_the_permalink( $product->get_id() ) ) . '#reviews" class="woocommerce-review-link scroll-to" rel="nofollow">(' . $product->get_review_count() . ' ' . esc_html__( 'reviews', 'pandastore' ) . ')</a>';
		}
	}
}

/**
 * Alpha product compare function
 *
 * @see plugins/woocommerce/product-loop.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_compare' ) ) {
	function alpha_product_compare( $extra_class = '' ) {
		if ( ! class_exists( 'Alpha_Product_Compare' ) ) {
			return;
		}

		global $product;

		$css_class  = 'compare' . $extra_class;
		$product_id = $product->get_id();
		$url        = '#';

		if ( Alpha_Product_Compare::get_instance()->is_compared_product( $product_id ) ) {
			$url         = get_permalink( wc_get_page_id( 'compare' ) );
			$css_class  .= ' added';
			$button_text = apply_filters( 'alpha_woocompare_added_label', esc_html__( 'Browse To Compare', 'pandastore' ) );
		} else {
			$button_text = apply_filters( 'alpha_woocompare_add_label', esc_html__( 'Add To Compare', 'pandastore' ) );
		}

		printf( '<a href="%s" class="%s" title="%s" data-product_id="%d" data-added-text="%s">%s</a>', esc_url( $url ), esc_attr( $css_class ), esc_attr( $button_text ), $product_id, esc_html( apply_filters( 'alpha_woocompare_added_label', esc_html__( 'Browse To Compare', 'pandastore' ) ) ), esc_html( $button_text ) );
	}
}

/**
 * The product loop media action
 *
 * @see plugins/woocommerce/product-loop.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_loop_media_action' ) ) {
	function alpha_product_loop_media_action() {

		global $product;

		$show_info = alpha_wc_get_loop_prop( 'show_info', false );

		if ( 'bottom' == alpha_wc_get_loop_prop( 'addtocart_pos' ) ) {
			if ( 'bottom' == alpha_wc_get_loop_prop( 'quickview_pos' ) ) {
				if ( is_array( $show_info ) && ! in_array( 'addtocart', $show_info ) && ! in_array( 'wishlist', $show_info ) && ! in_array( 'quickview', $show_info ) ) {
					return;
				}
				echo '<div class="product-action action-panel">';
				woocommerce_template_loop_add_to_cart(
					array(
						'class' => implode(
							' ',
							array_filter(
								array(
									'btn-product-icon',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
							)
						),
					)
				);

				if ( ( ! is_array( $show_info ) || in_array( 'wishlist', $show_info ) ) && defined( 'YITH_WCWL' ) ) {
					echo do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
				}

				if ( alpha_get_option( 'compare_available' ) && ( ! is_array( $show_info ) || in_array( 'compare', $show_info ) ) ) {
					echo alpha_product_compare( ' btn-product-icon' );
				}

				if ( ! is_array( $show_info ) || in_array( 'quickview', $show_info ) ) {
					echo '<button class="btn-product-icon btn-quickview" data-mfp-src="' . esc_url( alpha_get_product_featured_image_src( $product ) ) . '" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'pandastore' ) . '">' . esc_html__( 'Quick View', 'pandastore' ) . '</button>';
				}
			} else {
				echo '<div class="product-action">';
				woocommerce_template_loop_add_to_cart(
					array(
						'class' => implode(
							' ',
							array_filter(
								array(
									'btn-product',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
							)
						),
					)
				);
			}
			echo '</div>';
		} elseif ( 'bottom' == alpha_wc_get_loop_prop( 'quickview_pos' ) && ( ! is_array( $show_info ) || in_array( 'quickview', $show_info ) ) ) {
			if ( 'bottom' == alpha_wc_get_loop_prop( 'wishlist_pos' ) && in_array( 'wishlist', $show_info ) ) {
				echo '<div class="product-action">';
				if ( defined( 'YITH_WCWL' ) ) {
					echo do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
				}
				if ( ! is_array( $show_info ) || in_array( 'quickview', $show_info ) ) {
					echo '<button class="btn-product-icon btn-quickview" data-mfp-src="' . esc_url( alpha_get_product_featured_image_src( $product ) ) . '" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'pandastore' ) . '"><span>' . esc_html__( 'Quick View', 'pandastore' ) . '</span></button>';
				}
				echo '</div>';
			} else {
				echo '<div class="product-action"><button class="btn-product btn-quickview" data-mfp-src="' . esc_url( alpha_get_product_featured_image_src( $product ) ) . '" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'pandastore' ) . '">' . esc_html__( 'Quick View', 'pandastore' ) . '</button></div>';
			}
		}
	}
}

/**
 * Change add to wishlist lable.
 *
 * @since 1.0
 */
add_filter( 'alpha_add_to_wishlist_label', 'alpha_add_to_wishlist_label' );

/**
 * Change add to wishlist lable.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_add_to_wishlist_label' ) ) {
	function alpha_add_to_wishlist_label( $label ) {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-3' == $product_type ) {
			$label = 'Wishlist';
		}

		return $label;
	}
}

/**
 * Change browse wishlist lable.
 *
 * @since 1.0
 */
add_filter( 'yith_wcwl_browse_wishlist_label', 'alpha_browse_wishlist_label' );

/**
 * Change browse wishlist lable.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_browse_wishlist_label' ) ) {
	function alpha_browse_wishlist_label( $label ) {
		$product_type = alpha_wc_get_loop_prop( 'product_type' );
		if ( 'product-3' == $product_type && ! alpha_doing_quickview() ) {
			$label = 'Added';
		}

		return $label;
	}
}

/**************************************/
/* 4. Single Product                  */
/**************************************/

/**
 * Render single product navigation.
 *
 * @see plugins/woocommerce/product-singel.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_navigation' ) ) {
	function alpha_single_product_navigation() {
		$html = '';
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
			global $post;
			$prev_post = get_previous_post( true, '', 'product_cat' );
			$next_post = get_next_post( true, '', 'product_cat' );
			if ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) {
				$html .= '<ul class="product-nav">';

				if ( is_a( $prev_post, 'WP_Post' ) ) {
					$html             .= '<li class="product-nav-prev">';
						$html         .= '<a href="' . esc_url( get_the_permalink( $prev_post->ID ) ) . '" rel="prev"><i class="' . ALPHA_ICON_PREFIX . '-icon-arrow-long-left"></i>';
							$html     .= '<span class="product-nav-popup">';
								$html .= alpha_strip_script_tags( get_the_post_thumbnail( $prev_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
								$html .= '<span>' . esc_attr( get_the_title( $prev_post->ID ) ) . '</span>';
					$html             .= '</span></a></li>';
				}
				if ( is_a( $next_post, 'WP_Post' ) ) {
					$html             .= '<li class="product-nav-next">';
						$html         .= '<a href="' . esc_url( get_the_permalink( $next_post->ID ) ) . '" rel="next"><i class="' . ALPHA_ICON_PREFIX . '-icon-arrow-long-right"></i>';
							$html     .= ' <span class="product-nav-popup">';
								$html .= alpha_strip_script_tags( get_the_post_thumbnail( $next_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
								$html .= '<span>' . esc_attr( get_the_title( $next_post->ID ) ) . '</span>';
					$html             .= '</span></a></li>';
				}

				$html .= '</ul>';
			}
			do_action( 'alpha_single_product_builder_unset_preview' );
		}
		return apply_filters( 'alpha_single_product_navigation', $html );
	}
}

/**
 * Filters to change order of comment reply form controls
 *
 * @since 1.0
 */
add_filter( 'comment_form_fields', 'alpha_comment_form_fields', 11 );

/**
 * Change order of comment and cookie in comments
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_comment_form_fields' ) ) {
	function alpha_comment_form_fields( $args ) {
		$cookies = $args['cookies'];
		unset( $args['cookies'] );

		return array_merge( $args, array( 'cookies' => $cookies ) );
	}
}

/**
 * single_product_get_data_tab_type
 *
 * Return single product data tab type.
 *
 * @param string $tabs
 * @return string
 * @see plugins/woocommerce/product-single.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_get_data_tab_type' ) ) {
	function alpha_single_product_get_data_tab_type( $tab ) {
		global $alpha_layout;
		if ( isset( $alpha_layout['product_data_type'] ) ) {
			if ( 'accordion' == $alpha_layout['product_data_type'] ) {
				return 'accordion';
			} elseif ( 'section' == $alpha_layout['product_data_type'] ) {
				return 'section';
			} else {
				return 'tab';
			}
		}

		return $tab;
	}
}

/**************************************/
/* 5. Single Post                   */
/**************************************/

/**
 * Filters to add extra slider options to related posts in post page.
 *
 * @since 1.0
 */
add_filter( 'alpha_related_slider_options', 'alpha_related_slider_options', 10, 2 );

/**
 * Related slider option
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_related_slider_options' ) ) {
	function alpha_related_slider_options( $arg1, $arg2 ) {
		if ( true == $arg2 ) {
			return array_merge( $arg1, array( 'show_dots' => true ) );
		} else {
			return $arg1;
		}
	}
}

/**
 * Set comment form arguments
 *
 * @see plugins/woocommerce/product-single.php
 * @since 1.0
 */
if ( ! function_exists( 'alpha_comment_form_args' ) ) {
	function alpha_comment_form_args( $args ) {
		$args['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title">';
		$args['title_reply']        = esc_html__( 'Leave a comment', 'pandastore' );
		$args['title_reply_after']  = '</h3>';
		$args['fields']['author']   = '<div class="col-md-6"><label>Your name*</label><input name="author" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Enter your name', 'pandastore' ) . '"> </div>';
		$args['fields']['email']    = '<div class="col-md-6"><label>Your email address*</label><input name="email" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Enter your email', 'pandastore' ) . '"> </div>';

		$args['comment_field']  = isset( $args['comment_field'] ) ? $args['comment_field'] : '';
		$args['comment_field']  = substr( $args['comment_field'], 0, strpos( $args['comment_field'], '<p class="comment-form-comment">' ) );
		$args['comment_field'] .= '<div class="col-md-12"><textarea name="comment" id="comment" class="form-control" rows="5" maxlength="65525" required="required" placeholder="' . esc_attr__( 'Enter your comment', 'pandastore' ) . '"></textarea></div>';
		$args['submit_button']  = '<button type="submit" class="btn btn-dim btn-submit">' .
			( alpha_is_product() ? esc_html__( 'Submit Review', 'pandastore' ) : esc_html__( 'Post Comment', 'pandastore' ) ) . '</button>';

		return $args;
	}
}

/**************************************/
/* 6. Post               */
/**************************************/

/**
 * Filters for the post args
 *
 * @since 1.0
 */
add_filter( 'alpha_post_loop_default_args', 'alpha_post_loop_default_args' );

/**
 * Post loop args
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_post_loop_default_args' ) ) {
	function alpha_post_loop_default_args( $args ) {
		$args['read_more_class'] = 'btn-link btn-underline';
		return $args;
	}
}
/**************************************/
/* 7. Product category                */
/**************************************/

/**
 * get_category_classes
 *
 * @since 1.0
 */
add_filter( 'alpha_get_category_classes', 'alpha_get_category_classes_extend', 10, 2 );

/**
 * get_category_classes
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_category_classes_extend' ) ) {
	function alpha_get_category_classes_extend( $class, $type ) {
		if ( 'classic' == $type ) {
			$class = 'cat-type-classic';
		}
		return $class;
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
					<input type="hidden" name="post_type" value="<?php echo esc_attr( alpha_get_option( 'search_post_type' ) ); ?>"/>
					<input type="search" class="form-control" name="s" placeholder="<?php echo esc_attr( esc_html__( 'Search', 'pandastore' ) ); ?>" required="" autocomplete="off">

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
					<div class="tab tab-nav-underline tab-nav-boxed">
						<ul class="nav nav-tabs nav-fill" role="tablist">
							<?php
							$first = true;
							foreach ( $mobile_menus as $menu ) :
								$menu_obj = is_numeric( $menu ) ? get_term( $menu, 'nav_menu' ) : get_term_by( 'slug', $menu, 'nav_menu' );
								?>
								<li class="nav-item">
									<a class="nav-link<?php echo ! $first ? '' : ' active'; ?>" href="#<?php echo esc_html( $menu ); ?>"><?php echo esc_html( $menu_obj->name ); ?></a>
								</li>
								<?php $first = false; ?>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php
							$first = true;
							foreach ( $mobile_menus as $menu ) :
								?>
								<div class="tab-pane<?php echo ! $first ? '' : ' active in'; ?>" id="<?php echo esc_html( strtolower( $menu ) ); ?>">
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
