<?php
/**
 * Alpha Admin Page
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
if ( ! class_exists( 'Alpha_Admin' ) ) {
	class Alpha_Admin extends Alpha_Base {

		/**
		 * Check whether theme is activated or not.
		 *
		 * @var   bool
		 * @since 1.0
		 */
		private $checked_purchase_code;

		/**
		 * Activation url for checking license key.
		 *
		 * @var   string
		 * @since 1.0
		 */
		private $activation_url = 'https://dythemes.com/wordpress/dummy/api/includes/verify_purchase.php';

		/**
		 * The admin configuration.
		 *
		 * @since 1.0
		 */
		public $admin_config;

		/**
		 * Constructor
		 *
		 * Add actions and filters for admin page.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			if ( is_admin_bar_showing() ) {
				add_action( 'wp_before_admin_bar_render', array( $this, 'add_wp_toolbar_menu' ) );
			}

			add_action( 'admin_menu', array( $this, 'custom_admin_menu_order' ) );
			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
			add_action( 'after_switch_theme', array( $this, 'reset_child_theme_options' ), 15 );

			if ( is_child_theme() && empty( alpha_get_option( 'container' ) ) ) {
				$parent_theme_options = get_option( 'theme_mods_' . ALPHA_NAME );
				update_option( 'theme_mods_' . get_option( 'stylesheet' ), $parent_theme_options );
			}
			add_action( 'admin_enqueue_scripts', array( $this, 'add_theme_update_url' ), 1001 );

			add_action( 'admin_init', array( $this, 'check_activation' ) );
			add_action( 'admin_init', array( $this, 'show_activation_notice' ) );
			add_action( 'admin_init', array( $this, 'add_admin_class' ) );

			if ( is_admin() ) {
				add_filter( 'pre_set_site_transient_update_themes', array( $this, 'pre_set_site_transient_update_themes' ) );
				add_filter( 'upgrader_pre_download', array( $this, 'upgrader_pre_download' ), 10, 3 );
				add_filter( 'wp_ajax_alpha_activation', array( $this, 'ajax_activation' ) );
			}

			$this->admin_config = array(
				'admin_navs'     => array(
					'dashboard'     => array(
						'icon'  => 'fas fa-tachometer-alt',
						'label' => esc_html__( 'Dashboard', 'pandastore' ),
						'url'   => admin_url( 'admin.php?page=alpha' ),
					),
					'management'    => array(
						'icon'    => 'fas fa-cog',
						'label'   => esc_html__( 'Management', 'pandastore' ),
						'submenu' => array(
							'setup_wizard'    => array(
								'label' => esc_html__( 'Setup Wizard', 'pandastore' ),
								'icon'  => 'fas fa-user-cog',
								'url'   => admin_url( 'admin.php?page=alpha-setup-wizard' ),
								'desc'  => esc_html__( 'Setup your site quickly.', 'pandastore' ),
							),
							'optimize_wizard' => array(
								'label' => esc_html__( 'Optimize Wizard', 'pandastore' ),
								'icon'  => 'fas fa-rocket',
								'url'   => admin_url( 'admin.php?page=alpha-optimize-wizard' ),
								'desc'  => esc_html__( 'Enhance your site spped.', 'pandastore' ),
							),
							'tools'           => array(
								'label' => esc_html__( 'Tools', 'pandastore' ),
								'icon'  => 'fas fa-puzzle-piece',
								'url'   => admin_url( 'admin.php?page=alpha-tools' ),
								'desc'  => esc_html__( 'Keep your site healthy.', 'pandastore' ),
							),
						),
					),
					'layouts'       => array(
						'icon'    => 'fas fa-layer-group',
						'label'   => esc_html__( 'Layouts', 'pandastore' ),
						'submenu' => array(
							'layout_builder' => array(
								'label' => esc_html__( 'Layout Builder', 'pandastore' ),
								'icon'  => 'fas fa-object-group',
								'url'   => admin_url( 'admin.php?page=alpha-layout-builder' ),
								'desc'  => esc_html__( 'Edit your site layouts.', 'pandastore' ),
							),
						),
					),
					'theme_options' => array(
						'icon'  => 'fas fa-users-cog',
						'label' => esc_html__( 'Theme Options', 'pandastore' ),
						'url'   => admin_url( 'customize.php' ),
					),
				),
				'social_links'   => array(
					'facebook'  => array(
						'label' => esc_html__( 'Facebook', 'pandastore' ),
						'link'  => 'Facebook.com',
						'url'   => 'https://www.facebook.com/',
						'icon'  => 'fab fa-facebook-square',
						'color' => '#3b5999',
					),
					'twitter'   => array(
						'label' => esc_html__( 'Twitter', 'pandastore' ),
						'link'  => 'Twitter.com',
						'url'   => 'https://www.twitter.com/',
						'icon'  => 'fab fa-twitter',
						'color' => '#00acee',
					),
					'instagram' => array(
						'label' => esc_html__( 'Instagram', 'pandastore' ),
						'link'  => 'Instagram.com',
						'url'   => 'https://www.instagram.com/',
						'icon'  => 'fab fa-instagram',
						'color' => '#000000',
					),
					'wordpress' => array(
						'label' => esc_html__( 'WordPress', 'pandastore' ),
						'link'  => 'WordPress.org',
						'url'   => 'https://wordpress.org/',
						'icon'  => 'fab fa-wordpress',
						'color' => '#0073aa',
					),
					'envato'    => array(
						'label' => esc_html__( 'Envato', 'pandastore' ),
						'link'  => 'Themeforest.net',
						'url'   => 'https://themeforest.net/',
						'icon'  => 'icon-envato',
						'color' => '#81B441',
					),
				),
				'other_products' => array(
					'molla'   => array(
						'name'  => 'Molla',
						'url'   => 'https://d-themes.com/wordpress/molla/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/molla.jpg',
					),
					'riode'   => array(
						'name'  => 'Riode',
						'url'   => 'https://d-themes.com/wordpress/riode/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/riode.jpg',
					),
					'wolmart' => array(
						'name'  => 'Wolmart',
						'url'   => 'https://d-themes.com/wordpress/wolmart/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/wolmart.jpg',
					),
					'more'    => array(
						'name'  => 'Comming Soon...',
						'url'   => '#',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/coming.jpg',
					),
				),
				'links'          => array(
					'documentation' => array(
						'label' => esc_html__( 'Documentation', 'pandastore' ),
						'url'   => ALPHA_SERVER_URI . 'documentation/',
						'icon'  => '<i class="admin-svg-documentation" style="width:100px;"></i>',
						'desc'  => 'Contains all descriptions related to ' . ALPHA_DISPLAY_NAME . ' usage and features. Before you use ' . ALPHA_DISPLAY_NAME . ', read documentation first.',
					),
					'support'       => array(
						'label' => esc_html__( 'Support', 'pandastore' ),
						'url'   => 'https://d-themes.com/support/',
						'icon'  => '<i class="admin-svg-support" style="width:115px;"></i>',
						'desc'  => 'We provide 24/7 supports. Contact us if you get any issue while using ' . ALPHA_DISPLAY_NAME . ', reply within 16 hrs.',
					),
					'reviews'       => array(
						'label' => esc_html__( 'Reviews', 'pandastore' ),
						'url'   => 'https://themeforest.net/downloads/',
						'icon'  => '<i class="admin-svg-reviews" style="width:122px;"></i>',
						'desc'  => 'How did our customers rate our theme?  Pls check their reviews and you will be more sure of chooisng ' . ALPHA_DISPLAY_NAME . '.',
					),
					'request'       => array(
						'label' => esc_html__( 'Request a Feature', 'pandastore' ),
						'url'   => 'mailto:dthemes55@gmail.com',
						'icon'  => '<i class="admin-svg-request" style="width:100px"></i>',
						'desc'  => 'Let us make ' . ALPHA_DISPLAY_NAME . ' more awesome and powerful together. If you want any extra feature, pls send a request.',
					),
					'howto_videos'  => array(
						'label' => esc_html__( 'How-to Videos', 'pandastore' ),
						'url'   => ALPHA_SERVER_URI . 'documentation/',
						'icon'  => '<i class="admin-svg-videos" style="width:102px;"></i>',
						'desc'  => 'We provide many How-to Videos for visual instructions. Check our video tutorials and find your answer.',
					),
					'showcase'      => array(
						'label' => esc_html__( 'Add to Showcase', 'pandastore' ),
						'url'   => '#',
						'icon'  => '<i class="admin-svg-showcase" style="width:156px"></i>',
						'desc'  => 'Are you satisfied with our theme? If you register with details of your site, it will be added to our showcase.',
					),
					'buynow'        => array(
						'label' => esc_html__( 'Buy now!', 'pandastore' ),
						'url'   => 'https://d-themes.com/buynow/' . ALPHA_NAME . 'wp',
						'icon'  => 'fas fa-shopping-cart',
					),
				),
			);
			if ( class_exists( 'Alpha_Builders' ) ) {
				$this->admin_config['admin_navs']['layouts']['submenu']['templates_builder'] = array(
					'label' => esc_html__( 'Templates', 'pandastore' ),
					'icon'  => 'fas fa-pencil-ruler',
					'url'   => admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ),
					'desc'  => esc_html__( 'Create unique styled site.', 'pandastore' ),
				);
			}
			if ( class_exists( 'Alpha_Sidebar_Builder' ) ) {
				$this->admin_config['admin_navs']['layouts']['submenu']['sidebars_builder'] = array(
					'label'  => esc_html__( 'Sidebars', 'pandastore' ),
					'icon'   => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 70 70" enable-background="new 0 0 70 70" xml:space="preserve">
						<rect x="3.5" y="3.5" width="17.5" height="63"/>
						<rect x="27.8" y="49.6" width="38.7" height="16.9"/>
						<rect x="27.8" y="3.5" width="38.7" height="39.5"/>
					</svg>',
					'is_svg' => true,
					'url'    => admin_url( 'admin.php?page=alpha_sidebar' ),
					'desc'   => esc_html__( 'Create unlimited sidebars.', 'pandastore' ),
				);
			}
			$this->admin_config = apply_filters( 'alpha_admin_config', $this->admin_config );

		}

		/**
		 * Add alpha-admin-page class to body tag.
		 *
		 * @since 1.0
		 */
		public function add_admin_class() {
			if ( ( isset( $_REQUEST['page'] ) && 'alpha' == substr( $_REQUEST['page'], 0, 5 ) ) || ( isset( $_REQUEST['post_type'] ) && ALPHA_NAME . '_template' == $_REQUEST['post_type'] ) ) {
				add_filter(
					'admin_body_class',
					function() {
						return 'alpha-admin-page';
					}
				);
			}
		}

		/**
		 * Check Theme Activation Status
		 *
		 * @since 1.0
		 */
		public function ajax_activation() {
			if ( ! check_ajax_referer( 'alpha-admin', 'nonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__( 'Nonce Error', 'pandastore' ),
					)
				);
			}
			$this->check_activation();
			$this->show_activation_notice();
			require_once ALPHA_FRAMEWORK_PATH . '/admin/panel/views/activation.php';
			die();
		}

		/**
		 * Add Alpha menu items to WordPress admin menu.
		 *
		 * @since 1.0
		 */
		public function add_wp_toolbar_menu() {

			$target = is_admin() ? '_self' : '_blank';

			if ( current_user_can( 'edit_theme_options' ) ) {

				$title = alpha_get_option( 'white_label_title' );
				$icon  = alpha_get_option( 'white_label_icon' );
				$this->add_wp_toolbar_menu_item(
					'<span class="ab-icon dashicons ' . ( ! $icon ? 'dashicons-alpha-logo">' : 'custom-mini-logo"><img src="' . esc_attr( $icon ) . '" alt="logo" width="20" height="20" />' ) . '</span><span class="ab-label">' . ( $title ? esc_html( $title ) : ALPHA_DISPLAY_NAME ) . '</span>',
					false,
					esc_url( admin_url( 'admin.php?page=alpha' ) ),
					array(
						'class'  => 'alpha-menu',
						'target' => $target,
					),
					'alpha'
				);

				// License

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Dashboard', 'pandastore' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha' ) ),
					array(
						'target' => $target,
					)
				);

				// Theme Options

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Theme Options', 'pandastore' ),
					'alpha',
					esc_url( admin_url( 'customize.php' ) ),
					array(
						'target' => $target,
					)
				);

				// Management Submenu

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Management', 'pandastore' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
					array(
						'target' => $target,
					),
					'alpha_management'
				);

				if ( class_exists( 'Alpha_Setup_Wizard' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Setup Wizard', 'pandastore' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Status', 'pandastore' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Child Theme', 'pandastore' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=customize' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Plugins', 'pandastore' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=default_plugins' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup_plugins'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Demo', 'pandastore' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=demo_content' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Ready', 'pandastore' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=ready' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup_ready'
					);
				}
				if ( class_exists( 'Alpha_Optimize_Wizard' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Optimize Wizard', 'pandastore' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard' ) ),
						array(
							'target' => $target,
						),
						'alpha_optimize'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Resources', 'pandastore' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Lazyload', 'pandastore' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=lazyload' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Performance', 'pandastore' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=performance' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Plugins', 'pandastore' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=plugins' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Ready', 'pandastore' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=ready' ) ),
						array(
							'target' => $target,
						)
					);
				}
				if ( class_exists( 'Alpha_Tools' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Tools', 'pandastore' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-tools' ) ),
						array(
							'target' => $target,
						)
					);
				}

				// Layouts Submenu

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Layouts', 'pandastore' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ),
					array(
						'target' => $target,
					),
					'alpha_layouts'
				);

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Layout Builder', 'pandastore' ),
					'alpha_layouts',
					esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ),
					array(
						'target' => $target,
					)
				);

				if ( class_exists( 'Alpha_Builders' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'All Templates', 'pandastore' ),
						'alpha_layouts',
						esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ) ),
						array(
							'target' => $target,
						)
					);
				}
				if ( class_exists( 'Alpha_Sidebar_Builder' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Sidebars', 'pandastore' ),
						'alpha_layouts',
						esc_url( admin_url( 'admin.php?page=alpha_sidebar' ) ),
						array(
							'target' => $target,
						)
					);
				}

				if ( class_exists( 'Alpha_Builders' ) ) {

					global $alpha_layout;

					if ( ! empty( $alpha_layout['used_blocks'] ) && count( $alpha_layout['used_blocks'] ) ) {

						$used_templates = $alpha_layout['used_blocks'];

						foreach ( $used_templates as $template_id => $data ) {

							$template_type = get_post_meta( $template_id, ALPHA_NAME . '_template_type', true );
							if ( ! $template_type ) {
								$template_type = 'block';
							}

							$template = get_post( $template_id );

							if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $template_id, '_elementor_edit_mode', true ) ) {
								$edit_link = admin_url( 'post.php?post=' . $template_id . '&action=elementor' );
							} else {
								$edit_link = admin_url( 'post.php?post=' . $template_id . '&action=edit' );
							}

							if ( $template ) {
								$this->add_wp_toolbar_menu_item(
									// translators: %s represents template title.
									'<span class="alpha-ab-template-title">' . sprintf( esc_html__( 'Edit %s', 'pandastore' ), $template->post_title ) . '</span><span class="alpha-ab-template-type">' . sprintf( esc_html__( 'mY %s', 'pandastore' ), str_replace( '_', ' ', $template_type ) ) . '</span>', //phpcs:ignore
									'edit',
									esc_url( $edit_link ),
									array(
										'target' => $target,
									),
									'edit_' . ALPHA_NAME . '_template_' . $template_id
								);
							}
						}
					}
				}

				// Activate Theme
				if ( ! $this->is_registered() ) {
					$this->add_wp_toolbar_menu_item(
						'<span class="ab-icon dashicons dashicons-admin-network"></span><span class="ab-label">' . esc_html__( 'Activate Theme', 'pandastore' ) . '</span>',
						false,
						esc_url( admin_url( 'admin.php?page=alpha' ) ),
						array(
							'class'  => 'alpha-menu',
							'target' => $target,
						),
						'alpha-activate'
					);
				}

				do_action( 'alpha_add_wp_toolbar_menu', $this );
			}
		}

		/**
		 * Add Alpha menu items to WordPress admin menu.
		 *
		 * @param string $title         Title of menu item
		 * @param string $parent        Parent Menu id
		 * @param string $href          Link of menu item
		 * @param array  $custom_meta   Metadata for link
		 * @param string $custom_id     Menu id
		 * @since 1.0
		 */
		public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {
			global $wp_admin_bar;
			if ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
					return;
				}
				// Set custom ID
				if ( $custom_id ) {
					$id = $custom_id;
				} else { // Generate ID based on $title
					$id = strtolower( str_replace( ' ', '-', $title ) );
				}
				// links from the current host will open in the current window
				$meta = strpos( $href, home_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new $targetw

				$meta = array_merge( $meta, $custom_meta );
				$wp_admin_bar->add_node(
					array(
						'parent' => $parent,
						'id'     => $id,
						'title'  => $title,
						'href'   => $href,
						'meta'   => $meta,
					)
				);
			}
		}

		/**
		 * Change admin menu order.
		 *
		 * @since 1.0
		 */
		public function custom_admin_menu_order() {
			global $menu;

			$admin_menus = array();

			// Change dasbhoard menu order.
			$posts = array();
			$idx   = 0;
			foreach ( $menu as $key => $menu_item ) {
				if ( 'Posts' == $menu_item[0] ) {
					$admin_menus[9] = $menu_item;
				} elseif ( 'separator1' == $menu_item[2] ) {
					$admin_menus[8] = $menu_item;
				} else {
					$admin_menus[ $key ] = $menu_item;
				}
			}

			$menu = $admin_menus;
		}

		/**
		 * Check purchase code for license.
		 *
		 * @return string Return checking value of purchase code. e.g: verified, unregister and invalid.
		 * @since 1.0
		 */
		public function check_purchase_code() {

			if ( ! $this->checked_purchase_code ) {
				$code         = isset( $_POST['code'] ) ? sanitize_text_field( $_POST['code'] ) : '';
				$code_confirm = $this->get_purchase_code();

				if ( isset( $_POST['form_action'] ) && ! empty( $_POST['form_action'] ) ) {
					if ( 'unregister' == $_POST['form_action'] && $code != $code_confirm ) {
						if ( $code_confirm ) {
							$result = $this->curl_purchase_code( $code_confirm, 'remove' );
						}
						if ( $result && isset( $result['result'] ) && 3 == (int) $result['result'] ) {
							$this->checked_purchase_code = 'unregister';
							$this->set_purchase_code( '' );
							delete_transient( 'alpha_purchase_code_error_msg' );
							if ( isset( $_COOKIE['alpha_dismiss_code_error_msg'] ) ) {
								setcookie( 'alpha_dismiss_code_error_msg', '', time() - 3600 );
							}
							return $this->checked_purchase_code;
						}
					}
					if ( $code ) {
						$result = $this->curl_purchase_code( $code, 'add' );
						if ( ! $result ) {
							$this->checked_purchase_code = 'invalid';
							$code_confirm                = '';
						} elseif ( isset( $result['result'] ) && 1 == (int) $result['result'] ) {
							$code_confirm                = $code;
							$this->checked_purchase_code = 'verified';
						} else {
							$this->checked_purchase_code = $this->get_api_message( $result['message'] );
							$code_confirm                = '';
						}
					} else {
						$code_confirm                = '';
						$this->checked_purchase_code = '';
					}
					$this->set_purchase_code( $code_confirm );
				} else {
					if ( $code && $code_confirm && $code == $code_confirm ) {
						$this->checked_purchase_code = 'verified';
					}
				}
			}
			return $this->checked_purchase_code;
		}

		/**
		 * Get api message to activate license.
		 *
		 * @param  string $msg_code  Messaeg code
		 * @return string Return msg to response for activating license.
		 * @since 1.0
		 */
		public function get_api_message( $msg_code ) {
			if ( 'blocked_spam' == $msg_code ) {
				return esc_html__( 'Your ip address is blocked as spam!!!', 'pandastore' );
			} elseif ( 'code_invalid' == $msg_code ) {
				return esc_html__( 'Purchase Code is not valid!!!', 'pandastore' );
			} elseif ( 'already_used' == $msg_code && ! empty( $data['domain'] ) ) {
				return sprintf( esc_html__( 'This code was already used in %s', 'pandastore' ), $data['domain'] );
			} elseif ( 'reactivate' == $msg_code ) {
				return esc_html__( 'Please re-activate the theme.', 'pandastore' );
			} elseif ( 'unregistered' == $msg_code ) {
				return ALPHA_DISPLAY_NAME . esc_html__( ' Theme is unregistered!', 'pandastore' );
			} elseif ( 'activated' == $msg_code ) {
				return ALPHA_DISPLAY_NAME . esc_html__( ' Theme is activated!', 'pandastore' );
			} elseif ( 'p_blocked' == $msg_code ) { //permanetly blocked
				return sprintf( esc_html__( 'You are using illegal version now. Please purchase legal version %1$shere%2$s.', 'pandastore' ), '<a href="' . esc_url( $this->admin_config['links']['buynow']['url'] ) . '" target="_blank">', '</a>' );
			} elseif ( 's_blocked' == $msg_code ) { // soft blocked
				return sprintf( esc_html__( 'Your purchase code is temporarily blocked. Please contact us %1$shere%2$s to unblock it.', 'pandastore' ), '<a href="' . esc_url( $this->admin_config['links']['support']['url'] ) . '" target="_blank">', '</a>' );
			}
			return '';
		}

		/**
		 * Get curl purchase code.
		 *
		 * @param  string $code       License code.
		 * @param  string $act        Actions for purchase code. e.g: 'add' or 'remove'.
		 * @return string Result code
		 *
		 * @since 1.0
		 */
		public function curl_purchase_code( $code, $act ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api = new Alpha_Importer_API();

			$domain = $importer_api->generate_args();
			$domain = $domain['domain'];

			$result = $importer_api->get_response(
				$this->activation_url,
				array(
					'body' => array(
						'item'     => ALPHA_ENVATO_CODE,
						'code'     => $code,
						'domain'   => $domain,
						'siteurl'  => urlencode( home_url() ),
						'act'      => $act,
						'local'    => ( $importer_api->is_localhost() ? true : '' ),
						'template' => get_template(),
					),
				)
			);

			if ( ! $result ) {
				return false;
			}
			if ( is_wp_error( $result ) ) {
				return array( 'message' => $result->get_error_message() );
			}
			return $result;
		}

		/**
		 * Get purchase code.
		 *
		 * @return string Return purchase code if registed.
		 * @since 1.0
		 */
		public function get_purchase_code() {
			if ( $this->is_envato_hosted() ) {
				return SUBSCRIPTION_CODE;
			}
			return get_option( 'envato_purchase_code_' . ALPHA_ENVATO_CODE );
		}

		/**
		 * Get whether theme is activated or not.
		 *
		 * @return bool True if registed, false not.
		 * @since 1.0
		 */
		public function is_registered() {
			if ( $this->is_envato_hosted() ) {
				return true;
			}
			return get_option( 'alpha_registered' );
		}

		/**
		 * Store purchase code to option table.
		 *
		 * @param string $code Verified purchase code.
		 * @since 1.0
		 */
		public function set_purchase_code( $code ) {
			update_option( 'envato_purchase_code_' . ALPHA_ENVATO_CODE, $code );
		}

		/**
		 * Is envato hosted ?
		 *
		 * @return bool True if defined, false not.
		 * @since 1.0
		 */
		public function is_envato_hosted() {
			return defined( 'ENVATO_HOSTED_KEY' ) ? true : false;
		}

		/**
		 * Get ish
		 *
		 * @return bool|string Host key code if defined, false not.
		 * @since 1.0
		 */
		public function get_ish() {
			if ( ! defined( 'ENVATO_HOSTED_KEY' ) ) {
				return false;
			}
			return substr( ENVATO_HOSTED_KEY, 0, 16 );
		}

		/**
		 * Get virtual code for displaying purchase code.
		 *
		 * @return string Return virtual code.
		 * @since 1.0
		 */
		public function get_purchase_code_asterisk() {
			$code = $this->get_purchase_code();
			if ( $code ) {
				$code = substr( $code, 0, 13 );
				$code = $code . '-****-****-************';
			}
			return $code;
		}

		/**
		 * Adjust transient before setting for update themes.
		 *
		 * @param array $transient Values for setting transient
		 * @return array Filtered transient.
		 */
		public function pre_set_site_transient_update_themes( $transient ) {
			if ( ! $this->is_registered() ) {
				return $transient;
			}
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api   = new Alpha_Importer_API();
			$new_version    = $importer_api->get_latest_theme_version();
			$theme_template = get_template();
			if ( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {

				$args = $importer_api->generate_args( false );
				if ( $this->is_envato_hosted() ) {
					$args['ish'] = $this->get_ish();
				}

				$transient->response[ $theme_template ] = array(
					'theme'       => $theme_template,
					'new_version' => $new_version,
					'url'         => $importer_api->get_url( 'changelog' ),
					'package'     => add_query_arg( $args, $importer_api->get_url( 'theme' ) ),
				);

			}
			return $transient;
		}

		/**
		 * Filters whether to return the package.
		 *
		 * @param  bool        $reply   Whether to bail without returning the package. Default false.
		 * @param  string      $package The package file name.
		 * @param  WP_Upgrader $obj     The instance
		 * @return bool                 Returning package.
		 */
		public function upgrader_pre_download( $reply, $package, $obj ) {

			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api = new Alpha_Importer_API();
			if ( strpos( $package, $importer_api->get_url( 'theme' ) ) !== false || strpos( $package, $importer_api->get_url( 'plugins' ) ) !== false ) {
				if ( ! $this->is_registered() ) {
					return new WP_Error( 'not_registerd', sprintf( esc_html__( 'Please %s theme to get access to pre-built demo websites and auto updates.', 'pandastore' ), '<a href="admin.php?page=alpha">' . esc_html__( 'register', 'pandastore' ) . '</a> ' . ALPHA_DISPLAY_NAME ) );
				}
				$code   = $this->get_purchase_code();
				$result = $this->curl_purchase_code( $code, 'add' );
				if ( ! isset( $result['result'] ) || 1 !== (int) $result['result'] ) {
					$message = isset( $result['message'] ) ? $result['message'] : esc_html__( 'Purchase Code is not valid or could not connect to the API server!', 'pandastore' );
					return new WP_Error( 'purchase_code_invalid', wp_kses( $message ) );
				}
			}
			return $reply;
		}

		/**
		 * Add theme update url.
		 *
		 * @since 1.0
		 */
		public function add_theme_update_url() {
			global $pagenow;
			if ( 'update-core.php' == $pagenow ) {
				require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
				$importer_api   = new Alpha_Importer_API();
				$new_version    = $importer_api->get_latest_theme_version();
				$theme_template = get_template();
				if ( version_compare( ALPHA_VERSION, $new_version, '<' ) ) {
					$url         = $importer_api->get_url( 'changelog' );
					$checkbox_id = md5( wp_get_theme( $theme_template )->get( 'Name' ) );
					wp_add_inline_script( 'alpha-admin', 'if (jQuery(\'#checkbox_' . $checkbox_id . '\').length) {jQuery(\'#checkbox_' . $checkbox_id . '\').closest(\'tr\').children().last().append(\'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_js( esc_html__( 'View Details', 'pandastore' ) ) . '</a>\');}' );
				}
			}
		}

		/**
		 * Clear transients after switching theme.
		 *
		 * @since 1.0
		 */
		public function after_switch_theme() {
			if ( $this->is_registered() ) {
				$this->refresh_transients();
			}
		}

		/**
		 * Reset child theme's options.
		 *
		 * @since 1.0
		 */
		public function reset_child_theme_options() {
			if ( is_child_theme() && empty( alpha_get_option( 'container' ) ) ) {
				update_option( 'theme_mods_' . get_option( 'stylesheet' ), get_option( 'theme_mods_' . ALPHA_NAME ) );
			}
		}

		/**
		 * Clear transients
		 *
		 * @since 1.0
		 */
		public function refresh_transients() {
			delete_site_transient( 'alpha_plugins' );
			delete_site_transient( 'update_themes' );
			unset( $_COOKIE['alpha_dismiss_activate_msg'] );
			setcookie( 'alpha_dismiss_activate_msg', null, -1, '/' );
			delete_transient( 'alpha_purchase_code_error_msg' );
			setcookie( 'alpha_dismiss_code_error_msg', '', time() - 3600 );
		}

		/**
		 * Show activation notices.
		 *
		 * @since 1.0
		 */
		public function activation_notices() {
			?>
			<div class="notice error notice-error is-dismissible">
				<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
				<p><?php printf( esc_html__( 'Please %1$sregister%2$s alpha theme to get access to pre-built demo websites and auto updates.', 'pandastore' ), '<a href="admin.php?page=alpha">', '</a>' ); ?></p>
				<?php /* translators: $1 and $2 opening and closing strong tags respectively, and $3 and $4 are opening and closing anchor tags respectively */ ?>
				<p><?php printf( esc_html__( '%1$s Important! %2$s One %3$s standard license %4$s is valid for only %1$s1 website%2$s. Running multiple websites on a single license is a copyright violation.', 'pandastore' ), '<strong>', '</strong>', '<a target="_blank" href="https://themeforest.net/licenses/standard">', '</a>' ); ?></p>
				<button type="button" class="notice-dismiss alpha-notice-dismiss"><span class="screen-reader-text"><?php esc_html__( 'Dismiss this notice.', 'pandastore' ); ?></span></button>
			</div>
			<script>
				(function($) {
					var setCookie = function (name, value, exdays) {
						var exdate = new Date();
						exdate.setDate(exdate.getDate() + exdays);
						var val = encodeURIComponent(value) + ((null === exdays) ? "" : "; expires=" + exdate.toUTCString());
						document.cookie = name + "=" + val;
					};
					$(document).on('click.alpha-notice-dismiss', '.alpha-notice-dismiss', function(e) {
						e.preventDefault();
						var $el = $(this).closest('.notice');
						$el.fadeTo( 100, 0, function() {
							$el.slideUp( 100, function() {
								$el.remove();
							});
						});
						setCookie('alpha_dismiss_activate_msg', '<?php echo ALPHA_VERSION; ?>', 30);
					});
				})(window.jQuery);
			</script>
			<?php
		}

		/**
		 * Show activation message.
		 *
		 * @since 1.0
		 */
		public function activation_message() {
			?>
			<script>
				(function($){
					$(window).on( 'load', function() {
						<?php /* translators: $1 and $2 are opening and closing anchor tags respectively */ ?>
						$('.themes .theme.active .theme-screenshot').after('<div class="notice update-message notice-error notice-alt"><p><?php printf( esc_html__( 'Please %1$sverify purchase%2$s to get updates!', 'pandastore' ), '<a href="admin.php?page=alpha" class="button-link">', '</a>' ); ?></p></div>');
					});
				})(window.jQuery);
			</script>
			<?php
		}

		/**
		 * Check activation
		 *
		 * @since 1.0
		 */
		public function check_activation() {
			if ( isset( $_POST['alpha_registration'] ) && check_admin_referer( 'alpha-setup-wizard' ) ) {
				update_option( 'alpha_register_error_msg', '' );
				$result = $this->check_purchase_code();
				if ( 'verified' == $result ) {
					update_option( 'alpha_registered', true );
					$this->refresh_transients();
				} elseif ( 'unregister' == $result ) {
					update_option( 'alpha_registered', false );
					$this->refresh_transients();
				} elseif ( 'invalid' == $result ) {
					update_option( 'alpha_registered', false );
					update_option( 'alpha_register_error_msg', sprintf( esc_html__( 'There is a problem contacting to the %s API server. Please try again later.', 'pandastore' ), ALPHA_DISPLAY_NAME ) );
				} else {
					update_option( 'alpha_registered', false );
					update_option( 'alpha_register_error_msg', $result );
				}
			}
		}

		/**
		 * Show activation notice
		 *
		 * @since 1.0
		 */
		public function show_activation_notice() {
			if ( ! $this->is_registered() ) {
				if ( ( 'themes.php' == $GLOBALS['pagenow'] && isset( $_GET['page'] ) ) ||
					empty( $_COOKIE['alpha_dismiss_activate_msg'] ) ||
					version_compare( $_COOKIE['alpha_dismiss_activate_msg'], ALPHA_VERSION, '<' )
				) {
					add_action( 'admin_notices', array( $this, 'activation_notices' ) );
				} elseif ( 'themes.php' == $GLOBALS['pagenow'] ) {
					add_action( 'admin_footer', array( $this, 'activation_message' ) );
				}
			}
		}
	}
}

Alpha_Admin::get_instance();
