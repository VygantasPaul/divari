<?php
/**
 * Alpha WooCommerce Functions
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 *
 *
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Woocommerce_Extend' ) ) :

	class Alpha_Woocommerce_Extend {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Product loop
			add_action( 'alpha_after_product_loop_hooks', array( $this, 'after_product_loop_hooks' ) );
			// Single product
			add_action( 'alpha_after_ps_hooks', array( $this, 'after_ps_hooks' ) );
			add_filter( 'woocommerce_comment_pagination_args', array( $this, 'product_review_pagination_args' ) );
			// Woocommerce subpages
			if ( ! empty( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] && is_admin() ) {
				add_action( 'init', array( $this, 'load_woo_functions_extend' ), 8 );
			} else {
				$this->load_woo_functions_extend();
			}
		}

		/**
		 * Product loop
		 *
		 * @since 1.0
		 */
		public function after_product_loop_hooks() {
			// Remove ratings after title
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			// Remove product categories from all product types
			remove_action( 'alpha_shop_loop_item_categories', 'alpha_shop_loop_item_categories' );
			// Change order of del and ins tag
			add_filter( 'woocommerce_format_sale_price', array( $this, 'wc_format_sale_price_extend' ), 20, 3 );
			// Show weight unit attribute for all product types
			// Show sales deal at bottom of the product
			add_action( 'alpha_product_loop_before_item', array( $this, 'sales_deal_before_shop_loop_start' ) );
			add_action( 'alpha_product_loop_after_item', array( $this, 'sales_deal_after_shop_loop_end' ) );
		}

		/**
		 * Single product
		 *
		 * @since 1.0
		 */
		public function after_ps_hooks() {

			// First wrap
			remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_wrap_first_start' ), 5 );

			// Second wrap
			remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_wrap_second_start' ), 30 );

			// Summary
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 60 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			if ( class_exists( 'YITH_WCWL_Frontend' ) ) {
				remove_action( 'woocommerce_single_product_summary', 'alpha_print_wishlist_button', 52 );
				add_action( 'woocommerce_single_product_summary', 'alpha_print_wishlist_button', 54 );
			}
			remove_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 54 );
			add_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 52 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 60 );

			// Reviews
			if ( alpha_doing_ajax() && isset( $_REQUEST['action'] ) && 'alpha_reviews' == $_REQUEST['action'] && isset( $_POST['product_id'] ) ) {
				add_action( 'wp_ajax_alpha_reviews', array( $this, 'wc_reviews' ) );
				add_action( 'wp_ajax_nopriv_alpha_reviews', array( $this, 'wc_reviews' ) );
			}

			// Up-sells
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 25 );
		}

		/**
		 * Load woo functions extend file
		 *
		 * @since 1.0
		 */
		public function load_woo_functions_extend() {
			require_once ALPHA_INC_PLUGINS . '/woocommerce/woo-functions-extend.php';
		}

		/**
		 * Modify sale price position
		 *
		 * @since 1.0
		 */
		public function wc_format_sale_price_extend( $price, $regular_price, $sale_price ) {
			return '<del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del> <ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins>';
		}

		/**
		 * Display attributes for all product types
		 *
		 * @since 1.0
		 */
		public function product_loop_attributes( $attributes = '' ) {
			global $product;

			if ( 'variable' == $product->get_type() || ! $product->is_purchasable() ) {
				return;
			}

			// Get attributes for loop product
			if ( '' == $attributes ) {
				$attributes = array();
				foreach ( $product->get_attributes() as $attribute ) {
					$attributes = array_merge(
						$attributes,
						array(
							wc_attribute_label( $attribute['name'], $product ) => $this->get_attribute_options( $product->get_id(), $attribute ),
						)
					);
				}
			}

			// Print attributes
			foreach ( $attributes as $attribute_name => $options ) {

				if ( 'Weight Unit' != $attribute_name || 1 != count( $options ) ) {
					continue;
				}

				$option = $options;
				$terms  = wc_get_product_terms(
					$product->get_id(),
					$attribute_name,
					array(
						'fields' => 'all',
					)
				);

				echo '<div class="product-attr ' . esc_attr( $terms ? $attribute_name : 'pa_custom_' . strtolower( $attribute_name ) ) . '">';

				if ( ! empty( $option ) ) {

					$term = get_term_by( is_numeric( $option[0] ) ? 'id' : 'slug', $option[0], $attribute_name );
					if ( $term ) {
						$attr_label = sanitize_text_field( get_term_meta( $term->term_id, 'attr_label', true ) );
					} else {
						$attr_label = $option[0];
					}

					printf( '<span>(%s)</span>', $attr_label ? $attr_label : $term->name );

				}
				echo '</div>';
			}
		}

		/**
		 * Get attribute options.
		 *
		 * @param int $product_id
		 * @param array $attribute
		 * @return array
		 */
		protected function get_attribute_options( $product_id, $attribute ) {
			if ( isset( $attribute['is_taxonomy'] ) && $attribute['is_taxonomy'] ) {
				return wc_get_product_terms( $product_id, $attribute['name'], array( 'fields' => 'names' ) );
			} elseif ( isset( $attribute['value'] ) ) {
				return array_map( 'trim', explode( '|', $attribute['value'] ) );
			}

			return array();
		}

		/**
		 * Before display sales deal
		 *
		 * @since 1.0
		 */
		public function sales_deal_before_shop_loop_start() {
			global $product;
			$product_id = $product->get_id();
			$is_out     = get_post_meta( $product_id, 'alpha_sale_price_pos', true );
			if ( isset( $is_out ) && 'yes' == $is_out ) {
				remove_action( 'woocommerce_before_shop_loop_item_title', 'alpha_product_loop_count_deal', 30 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_loop_count_deal' ), 20 );
			}
		}

		/**
		 * After Display sales deal
		 *
		 * @since 1.0
		 */
		public function sales_deal_after_shop_loop_end() {
			global $product;
			$product_id = $product->get_id();
			$is_out     = get_post_meta( $product_id, 'alpha_sale_price_pos', true );
			if ( isset( $is_out ) && 'yes' == $is_out ) {
				remove_action( 'woocommerce_before_shop_loop_item_title', 'alpha_product_loop_count_deal', 30 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_loop_count_deal' ), 20 );
			}
		}

		/**
		 * After Display sales deal
		 *
		 * @since 1.0
		 */
		public function product_loop_count_deal() {
			global $product;

			$show_info = alpha_wc_get_loop_prop( 'show_info', array() );
			if ( ! in_array( 'countdown', $show_info ) ) {
				return;
			}

			if ( $product->is_on_sale() ) {
				if ( $product->is_type( 'variable' ) ) {
					$variations = $product->get_available_variations( 'object' );
					$date_diff  = '';
					$sale_date  = '';
					foreach ( $variations as $variation ) {
						if ( $variation->is_on_sale() ) {
							$new_date = get_post_meta( $variation->get_id(), '_sale_price_dates_to', true );
							if ( ! $new_date || ( $date_diff && $date_diff != $new_date ) ) {
								$date_diff = false;
							} elseif ( $new_date ) {
								if ( false !== $date_diff ) {
									$date_diff = $new_date;
								}
								$sale_date = $new_date;
							}
							if ( false === $date_diff && $sale_date ) {
								break;
							}
						}
					}
					if ( $date_diff ) {
						$date_diff = date( 'Y/m/d H:i:s', (int) $date_diff );
					} elseif ( $sale_date ) {
						$date_diff = date( 'Y/m/d H:i:s', (int) $sale_date );
					}
				} else {
					$date_diff = $product->get_date_on_sale_to();
					if ( $date_diff ) {
						$date_diff = $date_diff->date( 'Y/m/d H:i:s' );
					}
				}
				if ( $date_diff ) :
					wp_enqueue_script( 'jquery-countdown' );
					wp_enqueue_script( 'alpha-countdown' );
					?>
					<div class="countdown-container block-type">
						<h4 class="countdown-heading">Hurry up!<br/><span>Offer ends in</span></h4>
						<div class="countdown" data-until="<?php echo esc_attr( strtotime( $date_diff ) - strtotime( 'now' ) ); ?>" data-relative="true" data-labels-short="true"></div>
					</div>
					<?php
				endif;
			}
		}

		/**
		 * single_product_wrap_first_start
		 *
		 * Render start part of single product wrap.
		 *
		 * @since 1.0
		 */
		public function single_product_wrap_first_start() {
			$single_product_layout = alpha_get_single_product_layout();

			if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) ||
				( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) &&
				'gallery' != $single_product_layout ) {

				echo '<div class="col-md-7">';
			}
		}

		/**
		 * single_product_wrap_second_start
		 *
		 * Render start part of single product wrap.
		 *
		 * @since 1.0
		 */
		public function single_product_wrap_second_start() {
			$single_product_layout = alpha_get_single_product_layout();

			if ( ( ( alpha_doing_ajax() && 'offcanvas' != alpha_get_option( 'quickview_type' ) ) || ( ! alpha_doing_ajax() || alpha_is_elementor_preview() ) ) && 'gallery' != $single_product_layout ) {
				echo '<div class="col-md-5">';
			}
		}

		/**
		 * Reviews ajax action
		 *
		 * @since 1.0
		 */
		public function wc_reviews() {
			global $product, $post;
			$product_id = intval( $_POST['product_id'] );
			$post       = get_post( $product_id );
			$product    = wc_get_product( $product_id );

			if ( $product->is_type( 'variation' ) ) {
				$attrs = wc_get_product_variation_attributes( $post->ID );
				if ( ! empty( $attrs ) ) {
					foreach ( $attrs as $key => $val ) {
						$_REQUEST[ $key ] = $val;
					}
				}
				$parent_id = wp_get_post_parent_id( $post );
				if ( $parent_id ) {
					$post    = get_post( (int) $parent_id );
					$product = wc_get_product( $post->ID );
				}
			}

			echo '<div class="reviews-popup"><div id="review_form">';

			$commenter    = wp_get_current_commenter();
			$comment_form = array(
				'comment_field'        => '',
				/* translators: %s is product title */
				'title_reply'          => esc_html__( 'Submit Your Review', 'pandastore' ),
				/* translators: %s is product title */
				'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'pandastore' ),
				'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
				'title_reply_after'    => '</h3>',
				'comment_notes_after'  => '',
				'label_submit'         => esc_html__( 'Submit', 'pandastore' ),
				'logged_in_as'         => '',
				'comment_notes_before' => '',
				'submit_button'        => '<button type="submit" class="btn btn-dim btn-submit">Submit Review</button>',
			);

			$name_email_required = (bool) get_option( 'require_name_email', 1 );
			$fields              = array(
				'author' => array(
					'label'       => __( 'Name', 'pandastore' ),
					'type'        => 'text',
					'value'       => $commenter['comment_author'],
					'placeholder' => esc_html__( 'Your Name...', 'pandastore' ),
					'required'    => $name_email_required,
				),
				'email'  => array(
					'label'       => __( 'Email', 'pandastore' ),
					'type'        => 'email',
					'value'       => $commenter['comment_author_email'],
					'placeholder' => esc_html__( 'Your Email Address...', 'pandastore' ),
					'required'    => $name_email_required,
				),
			);

			$comment_form['fields'] = array();

			foreach ( $fields as $key => $field ) {
				$field_html  = '<div class="col-md-6">';
				$field_html .= '<input name="' . esc_attr( $key ) . '" class="form-control" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' placeholder="' . $field['placeholder'] . '" /></div>';

				$comment_form['fields'][ $key ] = $field_html;
			}

			$account_page_url = wc_get_page_permalink( 'myaccount' );
			if ( $account_page_url ) {
				/* translators: %s opening and closing link tags respectively */
				$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'pandastore' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
			}

			if ( wc_review_ratings_enabled() ) {
				$comment_form['comment_field'] = '<div class="comment-form-rating d-flex align-items-center mt-1"><label for="rating" class="mb-0">' . esc_html__( 'Your Rating Of This Product', 'pandastore' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">:</span>' : '' ) . '</label><select name="rating" id="rating" required>
					<option value="">' . esc_html__( 'Rate&hellip;', 'pandastore' ) . '</option>
					<option value="5">' . esc_html__( 'Perfect', 'pandastore' ) . '</option>
					<option value="4">' . esc_html__( 'Good', 'pandastore' ) . '</option>
					<option value="3">' . esc_html__( 'Average', 'pandastore' ) . '</option>
					<option value="2">' . esc_html__( 'Not that bad', 'pandastore' ) . '</option>
					<option value="1">' . esc_html__( 'Very poor', 'pandastore' ) . '</option>
				</select></div>';
			}

			$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" class="form-control" name="comment" cols="45" rows="6" required placeholder="Write Your Review Here..."></textarea></p>';
			comment_form( $comment_form );

			echo '</div></div>';
			die;
		}

		/**
		 *
		 *
		 * @since 1.0
		 */
		public function product_review_pagination_args() {
			return array(
				'echo'      => false,
				'prev_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i>',
				'next_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i>',
			);
		}
	}

endif;

new Alpha_Woocommerce_Extend;
