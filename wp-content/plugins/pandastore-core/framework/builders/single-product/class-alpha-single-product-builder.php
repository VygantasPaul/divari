<?php
/**
 * Alpha Single Product Builder
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

define( 'ALPHA_SINGLE_PRODUCT_BUILDER', ALPHA_BUILDERS . '/single-product' );

class Alpha_Single_Product_Builder extends Alpha_Base {

	/**
	 * Widgets
	 *
	 * @access protected
	 * @var array[string] $widgets
	 * @since 1.0
	 */
	protected $widgets = array();

	/**
	 * The post
	 *
	 * @access protected
	 * @var object $post
	 * @since 1.0
	 */
	protected $post;

	/**
	 * The product
	 *
	 * @access protected
	 * @var object $product
	 * @since 1.0
	 */
	protected $product;

	/**
	 * Is product layout
	 *
	 * @access protected
	 * @var boolean
	 * @since 1.0
	 */
	protected $is_product_layout = false;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->widgets = apply_filters(
			'alpha_single_product_widgets',
			array(
				'image'           => true,
				'navigation'      => true,
				'title'           => true,
				'meta'            => true,
				'rating'          => true,
				'price'           => true,
				'flash_sale'      => true,
				'excerpt'         => true,
				'cart_form'       => true,
				'share'           => true,
				'data_tab'        => true,
				'fbt'             => true,
				'linked_products' => true,
				'vendor_products' => true,
				'counter'         => true,
				'compare'         => true,
				'wishlist'        => true,
				'tags'            => true,
			)
		);
		// setup builder
		add_action( 'init', array( $this, 'find_preview' ) );  // for editor preview
		add_action( 'wp', array( $this, 'find_preview' ), 100 ); // for template view
		add_action( 'wp', array( $this, 'setup_product_layout' ), 99 );
		add_filter( 'alpha_run_single_product_builder', array( $this, 'run_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 25 );

		// add woocommerce class to body
		add_filter( 'body_class', array( $this, 'add_body_class' ), 5 );

		// setup global $product
		add_action( 'alpha_before_template', array( $this, 'set_preview' ) );
		add_filter( 'alpha_single_product_builder_set_preview', array( $this, 'set_preview' ) );
		add_action( 'alpha_single_product_builder_unset_preview', array( $this, 'unset_preview' ) );

		// @start feature: fs_pb_elementor
		if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) ) {
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
		}
		// @end feature: fs_pb_elementor

		// @start feature: fs_pb_wpb
		if ( alpha_get_feature( 'fs_pb_wpb' ) && defined( 'WPB_VC_VERSION' ) && class_exists( 'Alpha_WPB' ) ) {
			$this->register_wpb_elements();
		}
		// @end feature: fs_pb_wpb

	}

	/**
	 * Find variable product for preview.
	 *
	 * @since 1.0
	 */
	public function find_preview() {
		global $post;
		$is_preview = ( alpha_is_elementor_preview() || alpha_is_wpb_preview() );
		if ( ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'elementor_ajax' == $_REQUEST['action'] ) ||
			( doing_action( 'wp' ) && ! $is_preview && ALPHA_NAME . '_template' == get_post_type() && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ||
			doing_action( 'init' ) && $is_preview && isset( $_GET['post'] ) && ALPHA_NAME . '_template' == get_post_type( (int) $_GET['post'] ) && 'product_layout' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) ) ) {

			$posts = get_posts(
				array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'numberposts'         => 50,
					'ignore_sticky_posts' => true,
				)
			);

			if ( ! empty( $posts ) ) {

				// find variable product
				foreach ( $posts as $post ) {
					$this->post    = $post;
					$this->product = wc_get_product( $post );

					if ( 'variable' == $this->product->get_type() ) {
						break;
					}
				}

				// if no variable product exists, get any product
				if ( ! $this->product ) {
					$this->post    = $posts[0];
					$this->product = wc_get_product( $posts[0] );
				}
			}
		}
	}

	/**
	 * Setup product layout.
	 *
	 * @since 1.0
	 */
	public function setup_product_layout() {
		global $post;

		if ( ! empty( $post ) ) {
			$is_template = ALPHA_NAME . '_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true );
			if ( ! $is_template ) {
				$this->is_product_layout = false;
				$this->post              = null;
				$this->product           = null;
			}
			if ( $is_template || ( defined( 'ALPHA_VERSION' ) && is_product() ) ) {
				$this->is_product_layout = true;
			}
		}
	}

	/**
	 * Run builder template
	 *
	 * @since 1.0
	 * @access public
	 * @param boolean $run
	 * @return boolean $run
	 */
	public function run_template( $run ) {

		if ( ! $this->is_product_layout ) {
			return $run;
		}

		global $post;
		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			the_content();
			return true;

		} else {
			global $alpha_layout;
			if ( isset( $alpha_layout['single_product_type'] ) && 'builder' == $alpha_layout['single_product_type'] ) {
				if ( ! empty( $alpha_layout['single_product_template'] ) && is_numeric( $alpha_layout['single_product_template'] ) ) {
					$template = (int) $alpha_layout['single_product_template'];
					do_action( 'alpha_before_single_product_template', $template );
					alpha_print_template( $template );
					do_action( 'alpha_after_single_product_template', $template );
					return true;
				} elseif ( ! empty( $alpha_layout['single_product_template'] ) && 'hide' == $alpha_layout['single_product_template'] ) {
					// hide
					return true;
				}
			}
		}

		return $run;
	}

	/**
	 * Set post product
	 *
	 * @since 1.0
	 */
	public function set_preview() {
		if ( ! is_product() && $this->product ) {
			global $post, $product;
			$post    = $this->post;
			$product = $this->product;
			setup_postdata( $this->post );
			add_filter( 'alpha_is_product', '__return_true', 23 );
			return true;
		}
		return $this->is_product_layout;
	}

	/**
	 * Unset post product
	 *
	 * @since 1.0
	 */
	public function unset_preview() {
		if ( ! is_product() && $this->product ) {
			remove_filter( 'alpha_is_product', '__return_true', 23 );
			wp_reset_postdata();
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		if ( $this->product ) {
			wp_enqueue_style( 'alpha-theme-single-product' );
			wp_enqueue_script( 'wc-single-product' );

			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );
				add_action( 'wp_footer', 'woocommerce_photoswipe' );
			}
		}
	}

	/**
	 * Add body class
	 *
	 * @since 1.0
	 */
	public function add_body_class( $classes ) {
		global $post;
		if ( ! empty( $post ) && $this->is_product_layout ) {
			$classes[] = 'woocommerce';
		}
		return $classes;
	}

	// @start feature: fs_pb_elementor
	/**
	 * Register elementor category.
	 *
	 * @since 1.0
	 */
	public function register_elementor_category( $self ) {
		global $post;

		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			$self->add_category(
				'alpha_single_product_widget',
				array(
					'title'  => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'pandastore-core' ),
					'active' => true,
				)
			);
		}
	}
	// @end feature: fs_pb_elementor
	// @start feature: fs_pb_elementor
	/**
	 * Register elementor widgets.
	 *
	 * @since 1.0
	 */
	public function register_elementor_widgets( $self ) {
		global $post, $product;
		if ( ( $post && ALPHA_NAME . '_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) || (
			isset( $product ) ) ) {
			foreach ( $this->widgets as $widget => $usable ) {
				if ( $usable ) {
					require_once alpha_core_framework_path( ALPHA_BUILDERS . '/single-product/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
					$class_name = 'Alpha_Single_Product_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
					$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
				}
			}
		}
	}
	// @end feature: fs_pb_elementor
	// @start feature: fs_pb_wpb
	/**
	 * Register wpb elements
	 *
	 * @since 1.0
	 */
	public function register_wpb_elements() {
		global $post, $product;

		$post_id   = 0;
		$post_type = '';

		if ( $post ) {
			$post_id   = $post->ID;
			$post_type = $post->post_type;
		} elseif ( alpha_is_wpb_preview() ) {
			if ( vc_is_inline() ) {
				$post_id   = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : $_REQUEST['vc_post_id'];
				$post_type = get_post_type( $post_id );
			} elseif ( isset( $_REQUEST['post'] ) ) {
				$post_id   = $_REQUEST['post'];
				$post_type = get_post_type( $post_id );
			}
		}

		$elements = array();

		foreach ( $this->widgets as $widget => $usable ) {
			if ( $usable ) {
				$elements[] = 'sp_' . $widget;
			}
		}

		Alpha_WPB::get_instance()->add_shortcodes( $elements, 'single-product' );
	}
	// @end feature: fs_pb_wpb
}

Alpha_Single_Product_Builder::get_instance();
