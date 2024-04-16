<?php
/**
 * Alpha Layout Builder Admin
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

// Direct access is denied
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Layout_Builder_Admin' ) ) {
	class Alpha_Layout_Builder_Admin extends Alpha_Base {

		/**
		 * Conditions Map
		 *
		 * @since 1.0
		 * @access public
		 */
		public $conditions;

		/**
		 * Layouts array for different conditions.
		 *
		 * @since 1.0
		 * @access public
		 */
		public $schemes;

		/**
		 * Constructor
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_nopriv_alpha_layout_builder_save', array( $this, 'ajax_save_layout_builder' ) );
			add_action( 'wp_ajax_alpha_layout_builder_save', array( $this, 'ajax_save_layout_builder' ) );
		}

		/**
		 * Enqueue scripts for layout builder.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function enqueue_scripts() {

			$this->get_condition_categories();
			$this->conditions = alpha_get_option( 'conditions' );

			// Parsing as array.
			foreach ( $this->conditions as $category => $conditions ) {
				$condition_data = array();
				foreach ( $conditions as $i => $condition ) {
					$condition_data[] = $condition;
				}
				$this->conditions[ $category ] = $condition_data;
			}

			// Enqueue styles and scripts.
			wp_enqueue_style( 'jquery-select2' );
			wp_enqueue_script( 'jquery-select2' );
			wp_enqueue_script( 'isotope-pkgd' );
			wp_enqueue_script( 'alpha-layout-builder-admin', alpha_framework_uri( '/admin/layout-builder/layout-builder-admin' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );

			// Localize vars.
			wp_localize_script(
				'alpha-layout-builder-admin',
				'alpha_layout_vars',
				apply_filters(
					'alpha_layout_vars',
					array(
						'schemes'                       => $this->schemes,
						'controls'                      => Alpha_Layout_Builder::get_instance()->get_controls(),
						'conditions'                    => $this->conditions,
						'templates'                     => alpha_get_global_templates_sidebars(),
						'layout_images_url'             => ALPHA_ASSETS . '/images/admin/',
						'text_default'                  => esc_html__( 'Default', 'pandastore' ),
						'text_all'                      => esc_html__( 'All', 'pandastore' ),
						'text_hide'                     => esc_html__( 'Hide', 'pandastore' ),
						'text_my_templates'             => esc_html__( 'My Templates', 'pandastore' ),
						'text_duplicate'                => esc_html__( 'Duplicate', 'pandastore' ),
						'text_options'                  => esc_html__( 'Options', 'pandastore' ),
						'text_apply_prefix'             => esc_html__( 'Apply this ', 'pandastore' ),
						'text_apply_suffix'             => esc_html__( ' for:', 'pandastore' ),
						'text_delete'                   => esc_html__( 'Delete', 'pandastore' ),
						'text_open'                     => esc_html__( 'Open', 'pandastore' ),
						'text_close'                    => esc_html__( 'Close', 'pandastore' ),
						'text_copy'                     => esc_html__( 'Copy Options', 'pandastore' ),
						'text_paste'                    => esc_html__( 'Paste Options', 'pandastore' ),
						'text_confirm_delete_condition' => esc_html__( 'Do you want to delete this layout?', 'pandastore' ),
						'text_create_layout'            => esc_html__( 'Create Layout for ', 'pandastore' ),
						'template_builder'              => array(
							'block'          => alpha_get_feature( 'fs_builder_block' ) && defined( 'ALPHA_CORE_VERSION' ),
							'header'         => alpha_get_feature( 'fs_builder_header' ) && defined( 'ALPHA_CORE_VERSION' ),
							'footer'         => alpha_get_feature( 'fs_builder_footer' ) && defined( 'ALPHA_CORE_VERSION' ),
							'popup'          => alpha_get_feature( 'fs_builder_popup' ) && defined( 'ALPHA_CORE_VERSION' ),
							'product_layout' => class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_plugin_woocommerce' ) && alpha_get_feature( 'fs_builder_singleproduct' ) && defined( 'ALPHA_CORE_VERSION' ),
							'shop_layout'    => class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_plugin_woocommerce' ) && alpha_get_feature( 'fs_builder_shop' ) && defined( 'ALPHA_CORE_VERSION' ),
							'cart'           => class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_plugin_woocommerce' ) && alpha_get_feature( 'fs_builder_cart' ) && defined( 'ALPHA_CORE_VERSION' ),
							'sidebar'        => alpha_get_feature( 'fs_builder_sidebar' ) && defined( 'ALPHA_CORE_VERSION' ),
							'single'         => alpha_get_feature( 'fs_builder_single' ) && defined( 'ALPHA_CORE_VERSION' ),
							'archive'        => alpha_get_feature( 'fs_builder_archive' ) && defined( 'ALPHA_CORE_VERSION' ),
							'checkout'       => class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_plugin_woocommerce' ) && alpha_get_feature( 'fs_builder_checkout' ) && defined( 'ALPHA_CORE_VERSION' ),
						),
					)
				)
			);
		}

		/**
		 * Get condition categories.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function get_condition_categories() {

			// Add layouts.
			$this->schemes                 = array();
			$this->schemes['site']         = array(
				'title' => esc_html__( 'All Layouts', 'pandastore' ),
				'icon'  => 'fa fa-layer-group',
			);
			$this->schemes['single_front'] = array(
				'title' => esc_html__( 'Home Page', 'pandastore' ),
				'icon'  => 'fa fa-home',
			);
			$this->schemes['single_page']  = array(
				'title' => esc_html__( 'General Page', 'pandastore' ),
				'icon'  => 'fa fa-file',
			);
			// @start feature: fs_plugin_woocommerce
			if ( class_exists( 'WooCommerce' ) ) {
				$this->schemes['archive_product'] = array(
					'title' => esc_html__( 'Shop Page', 'pandastore' ),
					'icon'  => 'fa fa-shopping-bag',
				);
				$this->schemes['single_product']  = array(
					'title' => esc_html__( 'Single Product', 'pandastore' ),
					'icon'  => 'fa fa-shopping-cart',
				);
				// @start feature: fs_plugin_cart
				if ( alpha_get_feature( 'fs_builder_cart' ) ) {
					$this->schemes['cart'] = array(
						'title' => esc_html__( 'Cart Page', 'pandastore' ),
						'icon'  => 'fa fa-file',
					);
				}
				// @end feature: fs_plugin_cart
				// @start feature: fs_plugin_checkout
				if ( alpha_get_feature( 'fs_builder_checkout' ) ) {
					$this->schemes['checkout'] = array(
						'title' => esc_html__( 'Checkout Page', 'pandastore' ),
						'icon'  => 'fa fa-file',
					);
				}
				// @end feature: fs_plugin_checkout
			}
			// @end feature: fs_plugin_woocommerce
			$this->schemes['archive_post'] = array(
				'title' => esc_html__( 'Blog Page', 'pandastore' ),
				'icon'  => 'fa fa-calendar',
			);
			$this->schemes['single_post']  = array(
				'title' => esc_html__( 'Single Post', 'pandastore' ),
				'icon'  => 'fa fa-calendar-check',
			);
			$this->schemes['search']       = array(
				'title'  => esc_html__( 'Search Page', 'pandastore' ),
				'scheme' => array(
					'all' => array(
						'title' => esc_html__( 'All Post Types', 'pandastore' ),
					),
				),
				'icon'   => 'fa fa-search',
			);
			$this->schemes['error']        = array(
				'title' => esc_html__( '404 Page', 'pandastore' ),
				'icon'  => 'fa fa-sad-tear',
			);

			// Get post types to apply layout condition.
			$post_types = array();
			/**
			 * Filters the exclude post type.
			 *
			 * @param array The post type array.
			 * @since 1.0
			 */
			$post_types_exclude   = apply_filters( 'alpha_condition_exclude_post_types', array( ALPHA_NAME . '_template', 'attachment', 'elementor_library' ) );
			$available_post_types = get_post_types( array( 'public' => true ), 'objects' );
			foreach ( $available_post_types as $post_type_slug => $post_type ) {
				if ( ! in_array( $post_type_slug, $post_types_exclude ) ) {
					$post_types[ $post_type_slug ] = array(
						'name'          => $post_type->labels->name,
						'singular_name' => $post_type->labels->singular_name,
					);
				}
			}

			foreach ( $post_types as $post_type => $titles ) {
				if ( empty( $this->schemes[ 'archive_' . $post_type ] ) && apply_filters( 'alpha_layout_builder_is_available_archive', 'page' != $post_type, $post_type ) ) {
					$this->schemes[ 'archive_' . $post_type ] = array(
						'title' => $titles['name'],
					);
				}
				if ( empty( $this->schemes[ 'single_' . $post_type ] ) && apply_filters( 'alpha_layout_builder_is_available_single', true, $post_type ) ) {
					$this->schemes[ 'single_' . $post_type ] = array(
						'title' => $titles['singular_name'],
					);
				}
			}

			foreach ( $post_types as $post_type => $titles ) {

				$schemes = array(
					'all' => array(
						'title' => esc_html__( 'All', 'pandastore' ),
					),
				);

				if ( 'product' == $post_type ) { // Products archive

					$schemes['product_cat'] = array(
						'title' => esc_html__( 'Categories', 'pandastore' ),
						'list'  => get_terms(
							array(
								'taxonomy'   => 'product_cat',
								'fields'     => 'id=>name',
								'hide_empty' => false,
							)
						),
					);

					$schemes['product_brand'] = array(
						'title' => esc_html__( 'Brands', 'pandastore' ),
						'list'  => get_terms(
							array(
								'taxonomy'   => 'product_brand',
								'fields'     => 'id=>name',
								'hide_empty' => false,
							)
						),
					);

					$schemes['product_tag'] = array(
						'title' => esc_html__( 'Tags', 'pandastore' ),
						'list'  => get_terms(
							array(
								'taxonomy'   => 'product_tag',
								'fields'     => 'id=>name',
								'hide_empty' => false,
							)
						),
					);

				} elseif ( 'post' == $post_type ) {

					// Posts archive
					$schemes['category'] = array(
						'title' => esc_html__( 'Categories', 'pandastore' ),
						'list'  => get_terms(
							array(
								'taxonomy'   => 'category',
								'fields'     => 'id=>name',
								'hide_empty' => false,
							)
						),
					);

					$schemes['post_tag'] = array(
						'title' => esc_html__( 'Tags', 'pandastore' ),
						'list'  => get_terms(
							array(
								'taxonomy'   => 'post_tag',
								'fields'     => 'id=>name',
								'hide_empty' => false,
							)
						),
					);
				}

				foreach ( $schemes as $key => $scheme ) {
					if ( isset( $schemes[ $key ]['list'] ) ) {
						// translators: %s represents post types or taxonomies in the plural.
						$schemes[ $key ]['placeholder'] = sprintf( esc_html__( 'All %s', 'pandastore' ), $scheme['title'] );
					}
				}

				if ( count( $schemes ) ) {

					// Correct archive names of post types.
					if ( 'product' == $post_type ) {
						$schemes['all']['title'] = esc_html__( 'All Shop Pages', 'pandastore' );
					} elseif ( 'post' == $post_type ) {
						$schemes['all']['title'] = esc_html__( 'All Blog Pages', 'pandastore' );
					} elseif ( 'page' == $post_type ) {
						$schemes['all']['title'] = esc_html__( 'All Pages', 'pandastore' );
					}
					$schemes['all']['title'] = apply_filters( 'alpha_layout_builder_get_title_of_all_archive', $schemes['all']['title'], $post_type );

					// Add archive scheme for $post_type
					if ( apply_filters( 'alpha_layout_builder_is_available_archive', 'page' != $post_type, $post_type ) ) {
						$this->schemes[ 'archive_' . $post_type ]['scheme'] = $schemes;
					}

					// Correct single names of post types.
					if ( 'product' == $post_type ) {
						$schemes['all']['title'] = esc_html__( 'All Product Pages', 'pandastore' );
					} elseif ( 'post' == $post_type ) {
						$schemes['all']['title'] = esc_html__( 'All Post Pages', 'pandastore' );
					}
					$schemes['all']['title'] = apply_filters( 'alpha_layout_builder_get_title_of_all_single', $schemes['all']['title'], $post_type );

					// Add post pages for each post type.
					$posts        = new WP_Query();
					$posts        = $posts->query(
						array(
							'posts_per_page' => 100,
							'post_type'      => $post_type,
							'post_status'    => 'publish',
						)
					);
					$posts_titles = array();
					foreach ( $posts as $post ) {
						$posts_titles[ $post->ID ] = $post->post_title;
					}

					$schemes[ $post_type ] = array(
						'title'       => $titles['singular_name'],
						// translators: %s represents singular name of post type.
						'placeholder' => sprintf( esc_html__( 'Select Individual %s', 'pandastore' ), $titles['name'] ),
						'list'        => $posts_titles,
					);

					if ( 'page' == $post_type ) {
						$schemes['child'] = array(
							'title'       => esc_html__( 'Child of Pages', 'pandastore' ),
							'placeholder' => esc_html__( 'Select Parent Pages', 'pandastore' ),
							'list'        => $posts_titles,
						);
					}

					// Add single scheme for $post_type
					if ( apply_filters( 'alpha_layout_builder_is_available_single', true, $post_type ) ) {
						$this->schemes[ 'single_' . $post_type ]['scheme'] = $schemes;
					}
				}

				// Add post type to search scheme
				$this->schemes['search']['scheme'][ $post_type ] = array(
					'title' => $titles['singular_name'],
				);
			}

			foreach ( $this->schemes as $category => $scheme ) {
				if ( empty( $this->schemes[ $category ]['layout_title'] ) ) {
					/* translators: %s represents condition category title. */
					$this->schemes[ $category ]['layout_title'] = sprintf( esc_html__( '%s Layout', 'pandastore' ), $this->schemes[ $category ]['title'] );
				}
			}

			$this->schemes = apply_filters( 'alpha_layout_builder_schemes', $this->schemes );
		}

		/**
		 * Print Builder Content
		 *
		 * @since 1.0
		 * @access public
		 */
		public function view_layout_builder() {
			$title        = array(
				'title' => esc_html__( 'Layout Builder', 'pandastore' ),
				'desc'  => esc_html__( 'Create remarkable site with fully customizable layouts and online library.', 'pandastore' ),
			);
			$admin_config = Alpha_Admin::get_instance()->admin_config;
			Alpha_Admin_Panel::get_instance()->view_header( 'layout_builder', $admin_config, $title );
			?>
			<script type="text/template" id="alpha_layout_template">
				<div class="alpha-layout">
					<div class="layout-part general" data-part="general">
						<span><?php esc_html_e( 'General Settings', 'pandastore' ); ?></span>
					</div>
					<div class="layout-part header" data-part="header">
						<span class="block-name"><?php esc_html_e( 'Header', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>
					<div class="layout-part ptb" data-part="ptb">
						<span class="block-name"><?php esc_html_e( 'Page Header', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>
					<div class="layout-part top-block" data-part="top_block">
						<span class="block-name"><?php esc_html_e( 'Top Block', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>
					<div class="layout-part top-sidebar sidebar" data-part="top_sidebar">
						<span class="block-name"><?php esc_html_e( 'Horizontal Filter', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>							
					<div class="content-wrapper">
						<div class="layout-part left-sidebar sidebar" data-part="left_sidebar">
							<span class="block-name"><?php esc_html_e( 'Sidebar', 'pandastore' ); ?></span><span class="block-value"></span>
						</div>							
						<div class="content-inwrap">
							<div class="layout-part inner-top-block" data-part="inner_top_block">
								<span class="block-name"><?php esc_html_e( 'Inner Top', 'pandastore' ); ?></span><span class="block-value"></span>
							</div>
							<div class="layout-part content" data-part="content">
								<span class="block-name"><?php esc_html_e( 'Content', 'pandastore' ); ?></span><span class="block-value"></span>
							</div>
							<div class="layout-part inner-bottom-block" data-part="inner_bottom_block">
								<span class="block-name"><?php esc_html_e( 'Inner Bottom', 'pandastore' ); ?></span><span class="block-value"></span>
							</div>							
						</div>
						<div class="layout-part right-sidebar sidebar" data-part="right_sidebar">
							<span class="block-name"><?php esc_html_e( 'Sidebar', 'pandastore' ); ?></span><span class="block-value"></span>
						</div>
					</div>
					<div class="layout-part bottom-block" data-part="bottom_block">
						<span class="block-name"><?php esc_html_e( 'Bottom Block', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>
					<div class="layout-part footer" data-part="footer">
						<span class="block-name"><?php esc_html_e( 'Footer', 'pandastore' ); ?></span><span class="block-value"></span>
					</div>
				</div>
			</script>
			<div class="alpha-admin-panel-row" id="alpha_layout_builder">
				<button class="button button-dark button-large alpha-layouts-save"><i class="far fa-save"></i><?php esc_html_e( 'Save Layouts', 'pandastore' ); ?></button>
				<div class="alpha-admin-panel-side">
					<ul class="alpha-layout-builder-categories">
						<?php foreach ( $this->schemes as $category => $data ) : ?>
							<li class="alpha-condition-cat alpha-condition-cat-<?php echo esc_attr( $category . ( 'site' == $category ? ' active' : '' ) ); ?>"
								data-category="<?php echo esc_attr( $category ); ?>">
								<?php
								$icon_class = isset( $data['icon'] ) ? $data['icon'] : '';
								if ( ! in_array( $category, array( 'site', 'archive_post', 'single_post', 'archive_product', 'single_product', 'error', 'search', 'single_front', 'single_page' ) ) ) {
									if ( 'single' == substr( $category, 0, 6 ) ) {
										$icon_class = 'fa fa-calendar-check';
									} else {
										$icon_class = 'fa fa-calendar';
									}
								}

								?>
								<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
								<?php echo esc_html( $data['title'] ); ?>
								<span class="alpha-condition-count" style="display:none;">(0)</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="alpha-admin-panel-content">
					<div id="alpha_layout_content" class="alpha-layouts-container"></div>
				</div>
			</div>
			</div>
			<?php
			Alpha_Admin_Panel::get_instance()->view_footer( $admin_config );
		}

		/**
		 * Save layout builder conditions by ajax request
		 *
		 * @since 1.0
		 */
		public function ajax_save_layout_builder() {
			if ( ! check_ajax_referer( 'alpha-core-nonce', 'nonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__( 'Nonce Error', 'pandastore' ),
					)
				);
			}

			if ( isset( $_POST['conditions'] ) ) {

				// Parsing as array.
				$conditions = $_POST['conditions'];

				foreach ( $conditions as $category => $category_conditions ) {
					$condition_data      = array();
					$category_conditions = array_filter( $category_conditions, 'is_array' );
					foreach ( $category_conditions as $condition ) {
						$condition_data[] = $condition;
					}
					usort( $condition_data, 'alpha_layout_builder_compare_condition' );
					$conditions[ $category ] = $condition_data;
				}

				// Sort by category priorities
				uksort( $conditions, 'alpha_layout_builder_compare_category' );

				set_theme_mod( 'conditions', $conditions );
			}
		}
	}
}


/**
 * Setup Alpha Layout Builder
 *
 * @since 1.0
 */
Alpha_Layout_Builder_Admin::get_instance();

if ( ! function_exists( 'alpha_layout_builder_compare_category' ) ) {
	/**
	 * Compare priority of two condition categories.
	 *
	 * @since 1.0
	 * @param string $first
	 * @param string $second
	 * @param int compared result
	 */
	function alpha_layout_builder_compare_category( $first, $second ) {
		if ( $first == $second ) {
			return 0;
		}
		if ( 'site' == $first ) {
			return -1;
		}
		if ( 'site' == $second ) {
			return 1;
		}
		if ( 'error' == $first ) {
			return 1;
		}
		if ( 'error' == $second ) {
			return -1;
		}
		if ( 'single_front' == $first ) {
			return 1;
		}
		if ( 'single_front' == $second ) {
			return -1;
		}
		if ( 'search' == $first ) {
			return 1;
		}
		if ( 'search' == $second ) {
			return -1;
		}
		return strcmp( $first, $second );
	}
}


if ( ! function_exists( 'alpha_layout_builder_compare_condition' ) ) {
	/**
	 * Compare priority of two condition categories.
	 *
	 * @since 1.0
	 * @param string $first
	 * @param string $second
	 * @param int compared result
	 */
	function alpha_layout_builder_compare_condition( $first, $second ) {
		if ( empty( $second['scheme'] ) || ! empty( $second['scheme']['all'] ) ) {
			return 1;
		}
		if ( empty( $first['scheme'] ) || ! empty( $first['scheme']['all'] ) ) {
			return -1;
		}
		if ( 1 == count( $first['scheme'] ) ) {
			foreach ( $first['scheme'] as $scheme_key => $scheme_value ) {
				if ( post_type_exists( $scheme_key ) ) {
					return 1;
				}
			}
		}
		if ( 1 == count( $second['scheme'] ) ) {
			foreach ( $second['scheme'] as $scheme_key => $scheme_value ) {
				if ( post_type_exists( $scheme_key ) ) {
					return -1;
				}
			}
		}
		return 0;
	}
}
