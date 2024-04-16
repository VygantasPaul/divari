<?php
/**
 * Alpha Template
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_Builders extends Alpha_Base {

	/**
	 * The builder Type e.g: header, footer, single product
	 *
	 * @since 1.0
	 * @var array[string]
	 */
	protected $template_types = array();

	/**
	 * The post id
	 *
	 * @since 1.0
	 * @var int
	 */
	protected $post_id = '';

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$this->_init_template_types();

		add_action( 'init', array( $this, 'register_template_type' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );

		// Print Alpha Template Builder Page's Header
		if ( current_user_can( 'edit_posts' ) && 'edit.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post_type'] ) && ALPHA_NAME . '_template' == $_REQUEST['post_type'] ) {
			add_action( 'all_admin_notices', array( $this, 'print_template_dashboard_header' ) );
			add_filter( 'views_edit-' . ALPHA_NAME . '_template', array( $this, 'print_template_category_tabs' ) );
		}

		// Add "template type" column to posts table.
		add_filter( 'manage_' . ALPHA_NAME . '_template_posts_columns', array( $this, 'admin_column_header' ) );
		add_action( 'manage_' . ALPHA_NAME . '_template_posts_custom_column', array( $this, 'admin_column_content' ), 10, 2 );

		// Ajax
		add_action( 'wp_ajax_alpha_save_template', array( $this, 'save_alpha_template' ) );
		add_action( 'wp_ajax_nopriv_alpha_save_template', array( $this, 'save_alpha_template' ) );

		// Delete post meta when post is delete
		add_action( 'delete_post', array( $this, 'delete_template' ) );

		// Change Admin Post Query with alpha template types
		add_action( 'parse_query', array( $this, 'filter_template_type' ) );

		// Resources
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		// Add template builder classes to body class
		add_filter( 'body_class', array( $this, 'add_body_class_for_preview' ) );

		add_filter(
			'alpha_core_admin_localize_vars',
			function( $vars ) {
				$post_id                                   = get_the_ID();
				$vars['template_type']                     = $this->post_id ? get_post_meta( $this->post_id, ALPHA_NAME . '_template_type', true ) : 'layout';
				$vars['texts']['elementor_addon_settings'] = ALPHA_DISPLAY_NAME . esc_html__( ' Settings', 'pandastore-core' );
				return $vars;
			}
		);

		if ( is_admin() ) {
			if ( alpha_is_elementor_preview() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] ) {
				$this->post_id = intval( $_REQUEST['post'] );
				add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_assets' ), 30 );
				add_filter( 'alpha_core_admin_localize_vars', array( $this, 'add_addon_htmls' ) );
			} elseif ( alpha_is_wpb_preview() ) {
				if ( isset( $_REQUEST['post'] ) ) {
					$this->post_id = $_REQUEST['post'];
				} elseif ( isset( $_REQUEST['post_id'] ) ) {
					$this->post_id = $_REQUEST['post_id'];
				} else {
					$this->post_id = 0;
				}
			}
		}
	}

	/**
	 * Add admin menus.
	 *
	 *
	 * @since 1.0
	 */
	public function add_admin_menus() {
		// Menu - alpha / template
		add_submenu_page( 'alpha', esc_html__( 'Templates', 'pandastore-core' ), esc_html__( 'Templates', 'pandastore-core' ), 'administrator', 'edit.php?post_type=' . ALPHA_NAME . '_template', '', 5 );
	}

	/**
	 * Init template types
	 *
	 * @since 1.0
	 * @access private
	 */
	private function _init_template_types() {
		// @start feature: fs_builder_block
		if ( alpha_get_feature( 'fs_builder_block' ) ) {
			$this->template_types['block'] = esc_html__( 'Block Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_block

		// @start feature: fs_builder_header
		if ( alpha_get_feature( 'fs_builder_header' ) ) {
			$this->template_types['header'] = esc_html__( 'Header Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_header

		// @start feature: fs_builder_footer
		if ( alpha_get_feature( 'fs_builder_footer' ) ) {
			$this->template_types['footer'] = esc_html__( 'Footer Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_footer

		// @start feature: fs_builder_popup
		if ( alpha_get_feature( 'fs_builder_popup' ) ) {
			$this->template_types['popup'] = esc_html__( 'Popup Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_popup

		// @start feature: fs_plugin_woocommerce
		if ( class_exists( 'WooCommerce' ) && alpha_get_feature( 'fs_plugin_woocommerce' ) ) {
			// @start feature: fs_builder_singleproduct
			if ( alpha_get_feature( 'fs_builder_singleproduct' ) ) {
				$this->template_types['product_layout'] = esc_html__( 'Single Product Builder', 'pandastore-core' );
			}
			// @end feature: fs_builder_singleproduct

			// @start feature: fs_builder_shop
			if ( alpha_get_feature( 'fs_builder_shop' ) ) {
				$this->template_types['shop_layout'] = esc_html__( 'Shop Builder', 'pandastore-core' );
			}
			// @end feature: fs_builder_shop

			// @start feature: fs_builder_cart
			if ( alpha_get_feature( 'fs_builder_cart' ) ) {
				$this->template_types['cart'] = esc_html__( 'Cart Builder', 'pandastore-core' );
			}
			// @end feature: fs_builder_cart

			// @start feature: fs_builder_checkout
			if ( alpha_get_feature( 'fs_builder_checkout' ) ) {
				$this->template_types['checkout'] = esc_html__( 'Checkout Builder', 'pandastore-core' );
			}
			// @end feature: fs_builder_checkout
		}
		// @end feature: fs_plugin_woocommerce

		// @start feature: fs_builder_single
		if ( alpha_get_feature( 'fs_builder_single' ) ) {
			$this->template_types['single'] = esc_html__( 'Single Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_single

		// @start feature: fs_builder_archive
		if ( alpha_get_feature( 'fs_builder_archive' ) ) {
			$this->template_types['archive'] = esc_html__( 'Archive Builder', 'pandastore-core' );
		}
		// @end feature: fs_builder_archive

		$this->template_types = apply_filters( 'alpha_template_types', $this->template_types );
	}

	/**
	 * Add addon html to admin's localize vars.
	 *
	 * @param array $vars
	 * @return array $vars
	 * @since 1.0
	 */
	public function add_addon_htmls( $vars ) {
		$vars['builder_addons'] = apply_filters( 'alpha_builder_addon_html', array() );
		$vars['theme_url']      = esc_url( get_parent_theme_file_uri() );
		return $vars;
	}

	/**
	 * Enqueue style and script
	 *
	 * @since 1.0
	 */
	public function load_assets() {
		if ( defined( 'ALPHA_VERSION' ) ) {
			wp_enqueue_style( 'alpha-core-builder', alpha_core_framework_uri( '/builders/builder' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ), array(), ALPHA_CORE_VERSION );
			wp_enqueue_script( 'alpha-core-builder', alpha_core_framework_uri( '/builders/builder' . ALPHA_JS_SUFFIX ), array(), false, true );
		}
	}

	/**
	 * Add body class for preview.
	 *
	 * @param array $classes The class list
	 * @return array The class List
	 * @since 1.0
	 */
	public function add_body_class_for_preview( $classes ) {
		if ( ALPHA_NAME . '_template' == get_post_type() ) {
			$template_category = get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true );

			if ( ! $template_category ) {
				$template_category = 'block';
			}

			$classes[] = 'alpha_' . $template_category . '_template';
		}
		return $classes;
	}

	/**
	 * Register new template type.
	 *
	 * @since 1.0
	 */
	public function register_template_type() {
		register_post_type(
			ALPHA_NAME . '_template',
			array(
				'label'               => ALPHA_DISPLAY_NAME . esc_html__( ' Templates', 'pandastore-core' ),
				'labels'              => array(
					'not_found'          => esc_html__( 'No templates found', 'pandastore-core' ),
					'not_found_in_trash' => esc_html__( 'No templates found in trash', 'pandastore-core' ),
				),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'public'              => true,
				'supports'            => array( 'title', 'editor', 'alpha', 'pandastore-core' ),
				'can_export'          => true,
				'show_in_rest'        => true,
				'show_in_menu'        => false,
			)
		);
	}

	/**
	 * Hide page.
	 *
	 * @since 1.0
	 */
	public function hide_page( $class ) {
		return $class . ' hidden';
	}

	/**
	 * Print template dashboard header.
	 *
	 * @since 1.0
	 */
	public function print_template_dashboard_header() {
		if ( class_exists( 'Alpha_Admin_Panel' ) ) {
			$title        = array(
				'title' => esc_html__( 'Templates Builder', 'pandastore-core' ),
				'desc'  => sprintf( esc_html__( 'Build any part of your site with %1$s Template Builder. This provides an easy but powerful way to build a full site with hundreds of pre-built templates from %1$s Studio.', 'pandastore-core' ), ALPHA_DISPLAY_NAME ),
			);
			$admin_config = Alpha_Admin::get_instance()->admin_config;
			Alpha_Admin_Panel::get_instance()->view_header( 'templates_builder', $admin_config, $title );
			?>
			<div class="alpha-admin-panel-body alpha-card-box templates-builder">
			<div class="alpha-template-actions buttons">
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ) ); ?>" class="page-title-action alpha-add-new-template button button-dark"><?php esc_html_e( 'Add New Template', 'pandastore-core' ); ?></a>
			</div>
			</div>
			<?php
			Alpha_Admin_Panel::get_instance()->view_footer( $admin_config );
		}
	}

	/**
	 * Print template category tabs.
	 *
	 * @since 1.0
	 */
	public function print_template_category_tabs( $views = array() ) {
		echo '<div class="nav-tab-wrapper" id="alpha-template-nav">';

		$curslug = '';

		if ( isset( $_GET ) && isset( $_GET['post_type'] ) && ALPHA_NAME . '_template' == $_GET['post_type'] && isset( $_GET[ ALPHA_NAME . '_template_type' ] ) ) {
			$curslug = $_GET[ ALPHA_NAME . '_template_type' ];
		}

		echo '<a class="nav-tab' . ( '' == $curslug ? ' nav-tab-active' : '' ) . '" href="' . admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ) . '">' . esc_html__( 'All Builder', 'pandastore-core' ) . '</a>';

		foreach ( $this->template_types as $slug => $name ) {
			echo '<a class="nav-tab' . ( $slug == $curslug ? ' nav-tab-active' : '' ) . '" href="' . admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template&' . ALPHA_NAME . '_template_type=' . $slug ) . '">' . sprintf( esc_html__( '%s', 'pandastore-core' ), $name ) . '</a>';
		}

		echo '</div>';

		wp_enqueue_script( 'jquery-magnific-popup' );

		?>

		<div class="alpha-modal-overlay"></div>
		<div id="alpha_new_template" class="alpha-modal alpha-new-template-modal">
			<button class="alpha-modal-close dashicons dashicons-no-alt"></button>
			<div class="alpha-modal-box">
				<div class="alpha-modal-header">
					<h2><span class="alpha-mini-logo"></span><?php esc_html_e( 'New Template', 'pandastore-core' ); ?></h2>
				</div>
				<div class="alpha-modal-body">
					<div class="alpha-new-template-description">
						<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
						<h3><?php printf( esc_html__( 'One Click Install %1$sTemplates%2$s', 'pandastore-core' ), '<b>', '</b>' ); ?></h3>

						<p><?php esc_html_e( 'A huge library of online templates are ready for your quick work, and their combination will bring about a new fashionable site.', 'pandastore-core' ); ?></p>
						<?php if ( defined( 'ALPHA_VERSION' ) ) : ?>
							<div class="editors">
								<?php if ( defined( 'ELEMENTOR_VERSION' ) && alpha_get_feature( 'fs_pb_elementor' ) ) : ?>
									<label for="alpha-elementor-studio">
										<input type="radio" id="alpha-elementor-studio" name="alpha-studio-type" value="elementor" checked="checked">
										<img src="<?php echo esc_url( ALPHA_CORE_URI . '/assets/images/builders/builder_elementor.png' ); ?>" alt="<?php esc_attr_e( 'Elementor' ); ?>" title="<?php esc_attr_e( 'Elementor' ); ?>">
									</label>
								<?php endif; ?>
								<?php if ( defined( 'WPB_VC_VERSION' ) && alpha_get_feature( 'fs_pb_wpb' ) ) : ?>
									<label for="alpha-js_composer-studio">
										<input type="radio" id="alpha-js_composer-demo" name="alpha-studio-type" value="js_composer">
										<img src="<?php echo esc_url( ALPHA_CORE_URI . '/assets/images/builders/builder_wpbakery.png' ); ?>" alt="<?php esc_attr_e( 'WPBakery Page Builder', 'pandastore-core' ); ?>" title="<?php esc_attr_e( 'WPBakery Page Builder', 'pandastore-core' ); ?>">
									</label>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="alpha-new-template-form">
						<h4><?php esc_html_e( 'Choose Template Type', 'pandastore-core' ); ?></h4>
						<div class="option">
							<label><?php esc_html_e( 'Select Template Type', 'pandastore-core' ); ?></label>
							<select class="template-type">
							<?php
							foreach ( $this->template_types as $slug => $key ) {
								echo '<option value="' . esc_attr( $slug ) . '" ' . selected( $slug, $curslug ) . '>' . esc_html( $key ) . '</option>';
							}
							?>
							</select>
						</div>
						<div class="option">
							<label><?php esc_html_e( 'Name your template', 'pandastore-core' ); ?></label>
							<input type="text" name="template-name" class="template-name" placeholder="<?php esc_attr_e( 'Enter your template name (required)', 'pandastore-core' ); ?>" />
						</div>
						<div class="option">
							<label><?php esc_html_e( 'From Online Templates', 'pandastore-core' ); ?></label>
							<div class="alpha-template-input">
								<input id="alpha-new-template-type" type="hidden" />
								<input id="alpha-new-template-id" type="hidden" />
								<input id="alpha-new-template-name" type="text" class="online-template" readonly />
								<button id="alpha-new-studio-trigger" title="<?php echo ALPHA_DISPLAY_NAME . esc_attr( ' Studio', 'pandastore-core' ); ?>"><i class="fas fa-layer-group"></i>
							</div>
						</div>
						<button class="button" id="alpha-create-template-type"><?php esc_html_e( 'Create Template', 'pandastore-core' ); ?></button>
					</div>
				</div>
			</div>
		</div>

		<?php
		return $views;
	}

	/**
	 * The admin column header.
	 *
	 * @since 1.0
	 */
	public function admin_column_header( $defaults ) {
		$date_post = array_search( 'date', $defaults );
		$changed   = array_merge( array_slice( $defaults, 0, $date_post - 1 ), array( 'template_type' => esc_html__( 'Template Type', 'pandastore-core' ) ), array_slice( $defaults, $date_post ) );
		return $changed;
	}

	/**
	 * The admin column content.
	 *
	 * @since 1.0
	 */
	public function admin_column_content( $column_name, $post_id ) {
		if ( 'template_type' === $column_name ) {
			$type = esc_attr( get_post_meta( $post_id, ALPHA_NAME . '_template_type', true ) );
			echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template&' . ALPHA_NAME . '_template_type=' . $type ) ) . '">' . str_replace( '_', ' ', $type ) . '</a>';
		}
	}

	/**
	 * Save template.
	 *
	 * @since 1.0
	 */
	public function save_alpha_template() {
		if ( ! check_ajax_referer( 'alpha-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['name'] ) || ! isset( $_POST['type'] ) ) {
			wp_send_json_error( esc_html__( 'no template type or name', 'pandastore-core' ) );
		}

		if ( isset( $_POST['page_builder'] ) ) {
			switch ( $_POST['page_builder'] ) {
				case 'elementor':
					$cpts = get_option( 'elementor_cpt_support' );
					if ( is_array( $cpts ) && ! in_array( ALPHA_NAME . '_template', $cpts ) ) {
						$cpts[] = ALPHA_NAME . '_template';
						update_option( 'elementor_cpt_support', $cpts );
					}
					break;
				case 'wpbakery':
					$user       = wp_get_current_user();
					$user_roles = array_intersect( array_values( (array) $user->roles ), array_keys( (array) get_editable_roles() ) );
					$role       = get_role( reset( $user_roles ) );
					$caps       = $role->capabilities;
					if ( ! ( isset( $caps['vc_access_rules_post_types'] ) && 'custom' === $caps['vc_access_rules_post_types'] && isset( $caps[ 'vc_access_rules_post_types/' . ALPHA_NAME . '_template' ] ) && true === $caps[ 'vc_access_rules_post_types/' . ALPHA_NAME . '_template' ] ) ) {
						$role->add_cap( 'vc_access_rules_post_types', 'custom' );
						$role->add_cap( 'vc_access_rules_post_types/' . ALPHA_NAME . '_template', true );
					}
					break;
			}
		} else {
			wp_send_json_error( esc_html__( 'no page builder is chosen', 'pandastore-core' ) );
		}

		$post_id = wp_insert_post(
			array(
				'post_title'  => $_POST['name'],
				'post_type'   => ALPHA_NAME . '_template',
				'post_status' => 'publish',
			)
		);

		wp_save_post_revision( $post_id );
		update_post_meta( $post_id, ALPHA_NAME . '_template_type', $_POST['type'] );
		if ( isset( $_POST['template_id'] ) && (int) $_POST['template_id'] && isset( $_POST['template_type'] ) && $_POST['template_type'] && isset( $_POST['template_category'] ) && $_POST['template_category'] ) {

			$template_type     = $_POST['template_type'];
			$template_category = $_POST['template_category'];

			update_post_meta(
				$post_id,
				'alpha_start_template',
				array(
					'id'   => (int) $_POST['template_id'],
					'type' => $template_type,
				)
			);
		}

		wp_send_json_success( $post_id );
	}

	/**
	 * Delete template.
	 *
	 * @since 1.0
	 */
	public function delete_template( $post_id ) {
		if ( ALPHA_NAME . '_template' == get_post_type( $post_id ) ) {
			delete_post_meta( $post_id, ALPHA_NAME . '_template_type' );
		}
	}

	/**
	 * Fitler template type.
	 *
	 * @since 1.0
	 */
	public function filter_template_type( $query ) {
		if ( is_admin() ) {
			global $pagenow;

			if ( 'edit.php' == $pagenow && isset( $_GET ) && isset( $_GET['post_type'] ) && ALPHA_NAME . '_template' == $_GET['post_type'] ) {
				$template_type = '';
				if ( isset( $_GET[ ALPHA_NAME . '_template_type' ] ) && $_GET[ ALPHA_NAME . '_template_type' ] ) {
					$template_type = $_GET[ ALPHA_NAME . '_template_type' ];
				}

				$query->query_vars['meta_key']   = ALPHA_NAME . '_template_type';
				$query->query_vars['meta_value'] = $template_type;
			}
		}
	}
}

Alpha_Builders::get_instance();
