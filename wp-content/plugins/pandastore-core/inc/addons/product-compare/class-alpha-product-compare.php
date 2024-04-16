<?php

/**
 * Product Compare
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @version    1.0
 */
if ( ! class_exists( 'Alpha_Product_Compare' ) ) :
	class Alpha_Product_Compare extends Alpha_Base {

		public $action       = 'add';
		public $popup_type   = 'offcanvas';
		public $limit        = 4;
		public $products     = array();
		public $compare_page = array();

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Add theme options
			add_filter( 'alpha_customize_fields', array( $this, 'add_customize_fields' ) );
			add_filter(
				'alpha_customize_sections',
				function( $sections ) {
					$sections['compare'] = array(
						'title'    => esc_html__( 'Compare', 'pandastore-core' ),
						'panel'    => 'features',
						'priority' => 20,
					);
					return $sections;
				}
			);
			add_filter(
				'alpha_customize_page_links',
				function( $page_links ) {
					$page_links['compare'] = array(
						'url'      => esc_js( wc_get_page_permalink( 'compare' ) ),
						'is_panel' => false,
					);
					return $page_links;
				}
			);
			if ( function_exists( 'alpha_set_default_option' ) ) {
				alpha_set_default_option( 'compare_available', true );
				alpha_set_default_option( 'compare_limit', 4 );
				alpha_set_default_option( 'compare_popup_type', 'offcanvas' );
			}

			if ( function_exists( 'alpha_get_option' ) && alpha_get_option( 'compare_available' ) ) {
				$this->popup_type = alpha_get_option( 'compare_popup_type' );
				$this->limit      = alpha_get_option( 'compare_limit' );
				$this->products   = $this->get_compared_products();

				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 35 );

				// Create default compare page
				$this->compare_page = array(
					'name'    => _x( 'compare', 'Page slug', 'pandastore-core' ),
					'title'   => _x( 'Compare', 'Page title', 'pandastore-core' ),
					'content' => '<!-- wp:shortcode -->[' . apply_filters( 'alpha_woocompare_shortcode_tag', ALPHA_NAME . '_compare' ) . ']<!-- /wp:shortcode -->',
				);

				add_filter( 'woocommerce_create_pages', array( $this, 'add_default_compare_page' ) );
				add_action( 'init', array( $this, 'force_add_default_compare_page' ) );

				// Add product to compare
				add_action( 'wp_ajax_alpha_add_to_compare', array( $this, 'add_to_compare' ) );
				add_action( 'wp_ajax_nopriv_alpha_add_to_compare', array( $this, 'add_to_compare' ) );

				// Remove product from compare
				add_action( 'wp_ajax_alpha_remove_from_compare', array( $this, 'remove_from_compare' ) );
				add_action( 'wp_ajax_nopriv_alpha_remove_from_compare', array( $this, 'remove_from_compare' ) );

				add_action( 'wp_ajax_alpha_clean_compare', array( $this, 'clean_compare' ) );
				add_action( 'wp_ajax_nopriv_alpha_clean_compare', array( $this, 'clean_compare' ) );
				add_filter( 'alpha_vars', array( $this, 'add_compare_vars' ) );
			}
		}

		/**
		 * Add fields for compare
		 *
		 * @param {Array} $fields
		 *
		 * @param {Array} $fields
		 *
		 * @since 1.0
		 */
		public function add_customize_fields( $fields ) {
			$fields['cs_shop_compare_about_title'] = array(
				'section' => 'compare',
				'type'    => 'custom',
				'label'   => '',
				'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'pandastore-core' ) . '</h3>',
			);
			$fields['cs_shop_compare_desc']        = array(
				'section' => 'compare',
				'type'    => 'custom',
				'label'   => esc_html__( 'We provide flexible and useful compare functionality that might help you to choose your favourite one.', 'pandastore-core' ),
				'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/compare.jpg' . '" alt="Theme Option Descrpition Image"></p>',
			);
			$fields['cs_compare_advanced']         = array(
				'section' => 'compare',
				'type'    => 'custom',
				'label'   => '',
				'default' => '<h3 class="options-custom-title">' . esc_html__( 'Compare', 'pandastore-core' ) . '</h3>',
			);
			$fields['compare_available']           = array(
				'section' => 'compare',
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable Products Compare', 'pandastore-core' ),
			);
			$fields['compare_popup_type']          = array(
				'section'         => 'compare',
				'type'            => 'radio_buttonset',
				'label'           => esc_html__( 'Compare Popup Type', 'pandastore-core' ),
				'transport'       => 'refresh',
				'choices'         => array(
					'mini_popup' => esc_html__( 'Mini Popup', 'pandastore-core' ),
					'offcanvas'  => esc_html__( 'Off Canvas', 'pandastore-core' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'compare_available',
						'operator' => '==',
						'value'    => true,
					),
				),
			);
			$fields['compare_limit']               = array(
				'section'         => 'compare',
				'type'            => 'number',
				'label'           => esc_html__( 'Products Max Count', 'pandastore-core' ),
				'active_callback' => array(
					array(
						'setting'  => 'compare_available',
						'operator' => '==',
						'value'    => true,
					),
					// array(
					// 	'setting'  => 'compare_popup_type',
					// 	'operator' => '==',
					// 	'value'    => 'offcanvas',
					// ),
				),
				'transport'       => 'refresh',
			);
			return $fields;
		}


		/**
		 * Load scripts
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'alpha-product-compare', alpha_core_framework_uri( '/addons/product-compare/product-compare' . ALPHA_JS_SUFFIX ), array( 'alpha-framework-async' ), ALPHA_VERSION, true );
		}


		/**
		 * Add compare page as default when WooCommerce is installed and activated.
		 *
		 * @since 1.0
		 */
		public function add_default_compare_page( $pages ) {
			$pages['compare'] = $this->compare_page;
			return $pages;
		}


		/**
		 * Add compare related vars to alpha var
		 *
		 * @since 1.0
		 */
		public function add_compare_vars( $vars ) {
			$vars['compare_popup_type'] = $this->popup_type;
			return $vars;
		}


		/**
		 * Add compare page manually
		 *
		 * @since 1.0
		 */
		public function force_add_default_compare_page() {
			if ( class_exists( 'WooCommerce' ) && ! empty( get_option( 'woocommerce_db_version' ) ) && -1 == wc_get_page_id( 'compare' ) ) {
				include_once WC()->plugin_path() . '/includes/admin/wc-admin-functions.php';
				wc_create_page( esc_sql( $this->compare_page['name'] ), 'woocommerce_compare_page_id', $this->compare_page['title'], $this->compare_page['content'], ! empty( $this->compare_page['parent'] ) ? wc_get_page_id( $this->compare_page['parent'] ) : '' );
			}
		}


		/**
		 * Set cookie name for compare list
		 *
		 * @since 1.0
		 */
		public function compare_cookie_name() {
			$name = 'alpha_compare_list';

			if ( is_multisite() ) {
				$name .= '_' . get_current_blog_id();
			}

			return $name;
		}


		/**
		 * Check wether product is in compare list or not
		 *
		 * @param $prod_id
		 * @return true/false boolean
		 * @since 1.0
		 */
		public function is_compared_product( $prod_id ) {
			return in_array( $prod_id, $this->products );
		}


		/**
		 * Get compared product lists
		 *
		 * @since 1.0
		 */
		public function get_compared_products() {
			$cookie_name = $this->compare_cookie_name();
			return isset( $_COOKIE[ $cookie_name ] ) ? json_decode( wp_unslash( $_COOKIE[ $cookie_name ] ), true ) : array();
		}


		/**
		 * Set cookies for compare product list
		 *
		 * @param $prod_id
		 * @param $action string
		 * @since 1.0
		 */
		public function set_compared_products( $prod_id ) {
			$cookie_name = $this->compare_cookie_name();
			$prods       = $this->products;

			if ( 'add' == $this->action ) {
				if ( $this->limit <= count( $prods ) ) {
					array_shift( $prods );
				}
				$prods[] = $prod_id;
			} else {
				foreach ( $prods as $k => $each ) {
					if ( intval( $prod_id ) == $each ) {
						unset( $prods[ $k ] );
					}
				}
			}

			$this->products = $prods;

			if ( empty( $prods ) ) {
				setcookie( $cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
				$_COOKIE[ $cookie_name ] = false;
			} else {
				setcookie( $cookie_name, json_encode( $prods ), 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
				$_COOKIE[ $cookie_name ] = json_encode( $prods );
			}
		}


		/**
		 * Get response as json for getting compared products
		 *
		 * @since 1.0
		 */
		public function compare_json_response( $table = false ) {

			$popup = $this->get_compare_popup_template();
			$args  = array(
				'url'            => get_permalink( wc_get_page_id( 'compare' ) ),
				'count'          => count( $this->products ),
				'products'       => $this->products,
				'popup_template' => $popup,
			);

			if ( $table ) {
				ob_start();

				$this->print_compare_table();

				$args['compare_table'] = ob_get_clean();
			}

			ob_start();

			$atts['minicompare'] = $_POST['minicompare'];
			require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/compare/render-compare-elementor.php' );

			$args['minicompare'] = ob_get_clean();

			wp_send_json( $args );
		}


		/**
		 * Add product to compare list
		 *
		 * @since 1.0
		 */
		public function add_to_compare() {
			$id           = (int) sanitize_text_field( $_POST['id'] );
			$this->action = 'add';

			if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
				global $sitepress;
				$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
			}

			if ( ! $this->is_compared_product( $id ) ) {
				$this->set_compared_products( $id );
			}

			$this->compare_json_response();
		}


		/**
		 * Remove product from compare lists
		 *
		 * @since 1.0
		 */
		public function remove_from_compare() {
			$id           = (int) sanitize_text_field( $_POST['id'] );
			$this->action = 'remove';

			if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
				global $sitepress;
				$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
			}

			if ( $this->is_compared_product( $id ) ) {
				$this->set_compared_products( $id );
			}

			$this->compare_json_response( true );
		}



		/**
		 * Clean compare lists
		 *
		 * @since 1.0
		 */
		public function clean_compare() {
			$cookie_name = $this->compare_cookie_name();

			setcookie( $cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
			$_COOKIE[ $cookie_name ] = false;
		}


		/**
		 * Get compare popup template
		 *
		 * @since 1.0
		 */
		public function get_compare_popup_template() {

			ob_start();
			if ( 'offcanvas' == $this->popup_type ) :
				?>
			<div class="container">
				<div class="compare-heading">
					<h3><?php esc_html_e( 'Compare Products', 'pandastore-core' ); ?></h3>
					<p>
					<?php
					// translators: %d represents count of compare products
					printf( esc_html__( '(%s Products)', 'pandastore-core' ), '<mark>' . count( $this->products ) . '</mark>' );
					?>
					</p>
				</div>
				<div class="compare-list">
					<ul class="compare-slider slider-wrapper row gutter-lg">
					<?php
					foreach ( $this->products as $prod_id ) :
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $prod_id ) ); ?>">
								<figure>
									<?php
									$product = wc_get_product( $prod_id );
									echo alpha_strip_script_tags( $product->get_image( 'woocommerce_thumbnail' ) );
									?>
								</figure>
							</a>
							<a href="#" data-product_id="<?php echo esc_attr( $prod_id ); ?>" class="btn-remove remove_from_compare fas fa-times"></a>
						</li>
						<?php
					endforeach;

					$more = 4 - count( $this->products );
					if ( $more ) {
						for ( $i = 0; $i < $more; $i ++ ) :
							?>
						<li></li>
							<?php
						endfor;
					}
					?>
					</ul>
					<div class="slider-scrollbar"></div>
				</div>
				<a href="#" class="compare-clean"><?php esc_html_e( 'Clean All', 'pandastore-core' ); ?></a>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'compare' ) ) ); ?>" class="btn btn-dim"><?php esc_html_e( 'Start Compare !', 'pandastore-core' ); ?></a>
			</div>
				<?php
			endif;

			if ( 'mini_popup' == $this->popup_type ) :
				if ( 'remove' != $this->action ) :
					$product_id  = $this->products[ count( $this->products ) - 1 ];
					$cur_product = wc_get_product( $product_id );
					$comp_prefix = esc_html__( 'has been added to compare list', 'pandastore-core' );
					?>
				<div class="minipopup-box">
					<h4 class="minipopup-title"><?php echo esc_html__( 'Added To Compare List', 'pandastore-core' ); ?></h4>
					<div class="product product-list-sm">
						<figure class="product-media">
							<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
							<?php echo alpha_strip_script_tags( $cur_product->get_image( 'woocommerce_thumbnail' ) ); ?>
							</a>
						</figure>
						<div class="product-details">
							<a class="product-title" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"><?php echo esc_html( $cur_product->get_title() ); ?></a>
							<?php echo alpha_escaped( $comp_prefix ); ?>
						</div>
					</div>
					<div class="minipopup-footer">
						<?php
						global $product;
						$org_product = $product;
						$product     = $cur_product;
						woocommerce_template_loop_add_to_cart(
							array(
								'class' => implode(
									' ',
									array(
										'btn btn-sm btn-rounded',
										$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
										$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
									)
								),
							)
						);

						$product = $org_product;
						?>
						<a href="<?php echo get_permalink( wc_get_page_id( 'compare' ) ); ?>" class="btn btn-sm btn-secondary"><?php echo esc_html__( 'Compare', 'pandastore-core' ); ?></a>
					</div>
				</div>
					<?php
				endif;
			endif;

			return ob_get_clean();
		}


		/**
		 * Render compare list page
		 *
		 * @since 1.0
		 */
		public function print_compare_table() {
			$products = $this->get_compared_products_data();
			$fields   = $this->compare_product_fields();
			if ( ! empty( $products ) ) {
				?>
				<div class="alpha-compare-table product-loop pt-1 mb-4 mb-lg-8">
				<?php
				foreach ( $fields as $field_id => $field ) {
					if ( ! $this->is_field_avaliable( $field_id, $products ) ) {
						continue;
					}
					$tb_head = true;
					?>
					<div class="compare-row compare-<?php echo esc_attr( $field_id ); ?>">
					<?php
					$i = 0;

					foreach ( $products as $product_id => $product ) :
						$add_class = '';
						$i++;
						if ( count( $products ) == $i ) {
							$add_class .= ' last-col';
						}
						if ( $tb_head ) :
							?>
							<div class="compare-col compare-field">
								<?php echo ! $field ? esc_html__( 'Product', 'pandastore-core' ) : $field; ?>
							</div>
							<?php
							$tb_head = false;
						endif;

						if ( ! empty( $product ) ) :
							?>
							<div class="compare-col compare-value<?php echo esc_attr( $add_class ); ?>" data-title="<?php echo esc_attr( $field ); ?>">
								<?php $this->compare_display_field( $field_id, $product ); ?>
							</div>
							<?php
						endif;
					endforeach;

					if ( ! wp_is_mobile() ) {
						$more = 3 - count( $this->products );
						if ( $more ) {
							for ( $i = 0; $i < $more; $i ++ ) :
								?>
							<div class="compare-col compare-value" data-title="<?php echo esc_attr( $field ); ?>">
								<?php if ( ! $field ) : ?>
								<div class="compare-basic-info empty"></div>
							<?php endif; ?>
							</div>
								<?php
							endfor;
						}
					}
					?>

					</div>
					<?php
				}
				?>
				</div>
				<?php
			} else {
				?>
			<div class="alpha-compare-table empty">
				<i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-compare empty-icon"></i>
				<h2><?php echo apply_filters( 'alpha_compare_no_product_to_remove_message', esc_html__( 'No products added to the compare', 'pandastore-core' ) ); ?></h2>
				<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'GO TO SHOP', 'pandastore-core' ); ?>
				</a>
			</div>
				<?php
			}
			?>

			<?php
		}


		/**
		 * Get compare product data
		 *
		 * @since 1.0
		 */
		public function get_compared_products_data() {
			$ids = $this->products;

			if ( empty( $ids ) ) {
				return array();
			}

			$args = array(
				'include' => $ids,
				'orderby' => 'post__in',
				'limit'   => $this->limit,
			);

			$products = wc_get_products( $args );

			$result = array();

			$fields = $this->compare_product_fields( false );

			$none = '-';

			foreach ( $products as $product ) {
				$product_id         = $product->get_id();
				$product_title      = $product->get_title();
				$product_img        = $product->get_image();
				$add_to_cart        = $this->compare_add_to_cart_html( $product );
				$yith_html          = do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . $product_id . '" container_classes="btn-product-icon"]' );
				$product_price_html = $product->get_price_html();
				$type               = $product->get_type() . ' product';
				$stock_html         = wc_get_stock_html( $product );
				$product_excerpt    = $product->get_short_description();
				$product_weight     = $product->get_weight();
				$product_sku        = $product->get_sku();
				$rating_count       = $product->get_rating_count();
				$average            = $product->get_average_rating();

				$result[ $product_id ] = array(
					'basic'        => array(
						'image'       => $product_img ? $product_img : $none,
						'add_to_cart' => $add_to_cart ? $add_to_cart : $none,
						'add_to_yith' => $yith_html ? $yith_html : $none,
						'permalink'   => $product->get_permalink(),
					),
					'id'           => $product_id,
					'title'        => $product_title ? $product_title : $none,
					'price'        => $product_price_html ? $product_price_html : $none,
					'type'         => $type ? $type : $none,
					'availability' => $stock_html ? $stock_html : esc_html__( 'In stock', 'pandastore-core' ),
					'description'  => $product_excerpt ? $product_excerpt : $none,
					'rating'       => wc_get_rating_html( $average, $rating_count ) . $this->get_rating_link_html( $product ),
					'dimensions'   => wc_format_dimensions( $product->get_dimensions( false ) ),
					'weight'       => $product_weight ? $product_weight : $none,
				);

				foreach ( $fields as $field_id => $field_name ) {
					if ( taxonomy_exists( $field_id ) ) {
						$separator                          = ', ';
						$result[ $product_id ][ $field_id ] = array();
						$orderby                            = wc_attribute_orderby( $field_id ) ? wc_attribute_orderby( $field_id ) : 'name';
						$terms                              = wp_get_post_terms(
							$product_id,
							$field_id,
							array(
								'orderby' => $orderby,
							)
						);
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$term_id = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
								$type    = wc_get_attribute( $term_id )->type;
								$term    = sanitize_term( $term, $field_id );
								$color   = sanitize_hex_color( get_term_meta( $term->term_id, 'attr_color', true ) );
								$label   = get_term_meta( $term->term_id, 'attr_label', true );

								if ( 'list' == $type ) {
									if ( $color ) {
										$separator                            = '';
										$result[ $product_id ][ $field_id ][] = sprintf(
											'<span %s title="%s"></span>',
											apply_filters(
												'alpha_wc_product_listed_attribute_attr',
												$color ? ' class="swatch" style="background-color:' . esc_attr( $color ) . '"' : '',
												$term->taxonomy,
												$term_id
											),
											$term->name
										);
									} else {
										$separator                            = '';
										$result[ $product_id ][ $field_id ][] = sprintf(
											'<span %s title="%s">%s</span>',
											apply_filters(
												'alpha_wc_product_listed_attribute_attr',
												'class="swatch label-swatch"',
												$term->taxonomy,
												$term_id
											),
											$term->name,
											$label ? $label : $term->name
										);
									}
								} else {
									$result[ $product_id ][ $field_id ][] = $term->name;
								}
							}
						} else {
							$result[ $product_id ][ $field_id ][] = '-';
						}
						$result[ $product_id ][ $field_id ] = implode( $separator, $result[ $product_id ][ $field_id ] );
					}
				}
			}

			return $result;
		}


		/**
		 * Get each fields of product to be compared
		 *
		 * @since 1.0
		 */
		public function compare_product_fields( $global = true ) {
			$fields = array();

			if ( $global ) {
				$fields = apply_filters(
					'alpha_compare_fields',
					array(
						'basic'        => '',
						'title'        => array(
							'name'  => esc_html__( 'Title', 'pandastore-core' ),
							'value' => 'title',
						),
						'price'        => array(
							'name'  => esc_html__( 'Price', 'pandastore-core' ),
							'value' => 'price',
						),
						'type'         => array(
							'name'  => esc_html__( 'Type', 'pandastore-core' ),
							'value' => 'type',
						),
						'availability' => array(
							'name'  => esc_html__( 'Availability', 'pandastore-core' ),
							'value' => 'availability',
						),
						'description'  => array(
							'name'  => esc_html__( 'Description', 'pandastore-core' ),
							'value' => 'description',
						),
						'rating'       => array(
							'name'  => esc_html__( 'Ratings & Reviews', 'pandastore-core' ),
							'value' => 'rating',
						),
						'dimensions'   => array(
							'name'  => esc_html__( 'Dimensions', 'pandastore-core' ),
							'value' => 'dimensions',
						),
						'weight'       => array(
							'name'  => esc_html__( 'Weight', 'pandastore-core' ),
							'value' => 'weight',
						),
					)
				);
			}

			$product_attributes = wc_get_attribute_taxonomies();

			if ( count( $product_attributes ) > 0 ) {
				foreach ( $product_attributes as $attribute ) {
					$fields[ 'pa_' . $attribute->attribute_name ] = array(
						'name'  => wc_attribute_label( $attribute->attribute_label ),
						'value' => 'pa_' . $attribute->attribute_name,
					);
				}
			}

			if ( $global ) {
				foreach ( $fields as $name => $value ) {
					if ( isset( $fields[ $name ]['name'] ) ) {
						$fields[ $name ] = $fields[ $name ]['name'];
					}
				}
			}
			return $fields;
		}


		/**
		 * Check whether field is available or not
		 *
		 * @since 1.0
		 */
		public function is_field_avaliable( $field, $products ) {
			foreach ( $products as $product_id => $product ) {
				if ( isset( $product[ $field ] ) && ( ! empty( $product[ $field ] ) && '-' !== $product[ $field ] && 'N/A' !== $product[ $field ] ) ) {
					return true;
				}
			}
			return false;
		}


		/**
		 * Get compared field
		 *
		 * @since 1.0
		 */
		public function compare_display_field( $field_id, $product ) {

			$type = $field_id;

			if ( 'pa_' === substr( $field_id, 0, 3 ) ) {
				$type = 'attribute';
			}

			switch ( $type ) {
				case 'basic':
					echo '<div class="compare-basic-info">';
						echo '<figure class="product-media"><a href="' . esc_url( get_permalink( $product['id'] ) ) . '">' . $product['basic']['image'] . '</a></figure>';
						echo '<div class="product-action">';
							echo '<a class="to-left" href="#" title="' . esc_html__( 'To Left', 'pandastore-core' ) . '" data-product_id="' . $product['id'] . '"><i class="' . ALPHA_ICON_PREFIX . '-icon-angle-left-solid"></i></a>';
								echo '<div class="action-panel">';
									echo alpha_strip_script_tags( $product['basic']['add_to_cart'] );
									echo alpha_strip_script_tags( $product['basic']['add_to_yith'] );
									echo '<a href="#" class="remove_from_compare" data-product_id="' . esc_attr( $product['id'] ) . '"><i class="' . ALPHA_ICON_PREFIX . '-icon-times-solid"></i></a>';
								echo '</div>';
							echo '<a class="to-right" href="#" title="' . esc_html__( 'To Right', 'pandastore-core' ) . '" data-product_id="' . $product['id'] . '"><i class="' . ALPHA_ICON_PREFIX . '-icon-angle-right-solid"></i></a>';
						echo '</div>';
					echo '</div>';
					break;

				case 'title':
					echo '<a class="product-title" href="' . esc_url( get_permalink( $product['id'] ) ) . '">' . $product['title'] . '</a>';
					break;

				case 'weight':
					if ( $product[ $field_id ] ) {
						$unit = '-' !== $product[ $field_id ] ? get_option( 'woocommerce_weight_unit' ) : '';
						echo wc_format_localized_decimal( $product[ $field_id ] ) . ' ' . esc_attr( $unit );
					}
					break;

				case 'description':
					echo apply_filters( 'woocommerce_short_description', $product[ $field_id ] );
					break;

				default:
					echo alpha_strip_script_tags( $product[ $field_id ] );
					break;
			}
		}


		/**
		 * Add product in compare lists to cart
		 *
		 * @since 1.0
		 */
		public function compare_add_to_cart_html( $product ) {
			if ( ! $product ) {
				return;
			}

			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
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
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', $defaults, $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
			}

			return apply_filters(
				'woocommerce_loop_add_to_cart_link',
				sprintf(
					'<a href="%s" data-quantity="%s" class="%s add-to-cart-loop" %s><span>%s</span></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				),
				$product,
				$args
			);
		}

		/**
		 * Add product in compare lists to cart
		 *
		 * @since 1.0
		 */
		public function get_rating_link_html( $product ) {
			return '<a href="' . esc_url( get_the_permalink( $product->get_id() ) ) . '#reviews" class="woocommerce-review-link scroll-to" rel="nofollow">(' . $product->get_review_count() . ')</a>';
		}
	}
	Alpha_Product_Compare::get_instance();

	// Add shortcode
	add_shortcode( ALPHA_NAME . '_compare', array( Alpha_Product_Compare::get_instance(), 'print_compare_table' ) );
endif;
