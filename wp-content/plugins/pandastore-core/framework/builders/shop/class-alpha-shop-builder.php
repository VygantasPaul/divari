<?php
/**
 * Alpha Shop Builder class
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

define( 'ALPHA_SHOP_BUILDER', ALPHA_BUILDERS . '/shop' );

class Alpha_Template_Shop_Builder extends Alpha_Base {

	/**
	 * Widgets
	 *
	 * @access protected
	 * @var array[string] $widgets
	 * @since 1.0
	 */
	protected $widgets = array();

	/**
	 * Is shop layout
	 *
	 * @access protected
	 * @var boolean
	 * @since 1.0
	 */
	protected $is_shop_layout = false;

	/**
	 * Original
	 *
	 * @access protected
	 * @var array $original
	 * @since 1.0
	 */
	public $original;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->widgets = apply_filters(
			'alpha_shop_widgets',
			array(
				'products'      => true,
				'sort'          => true,
				'result'        => true,
				'pagination'    => true,
				'count'         => true,
				'show_type'     => true,
				'filter_toggle' => true,
			)
		);

		// setup builder
		add_action( 'init', array( $this, 'find_preview' ) );  // for editor preview
		add_action( 'wp', array( $this, 'find_preview' ), 1 ); // for template view
		add_action( 'wp', array( $this, 'setup_shop_layout' ), 99 );
		add_filter( 'alpha_run_shop_builder', array( $this, 'run_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 25 );

		add_filter( 'alpha_shop_builder_set_preview', array( $this, 'set_preview' ) );
		add_action( 'alpha_shop_builder_unset_preview', array( $this, 'unset_preview' ) );

		// @start feature: fs_pb_elementor
		if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) ) {
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
		}
		// @end feature: fs_pb_elementor
	}

	/**
	 * Get preview mode in editors and template view.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function find_preview() {
		global $post;
		if ( ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'elementor_ajax' == $_REQUEST['action'] ) ||
			( doing_action( 'wp' ) && ALPHA_NAME . '_template' == get_post_type() && 'shop_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ||
			doing_action( 'init' ) && ( alpha_is_elementor_preview() ) && is_admin() &&
			isset( $_GET['post'] ) && ALPHA_NAME . '_template' == get_post_type( (int) $_GET['post'] ) && 'shop_layout' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) ) ) {

		}
	}

	/**
	 * Setup shop layout.
	 *
	 * @since 1.0
	 */
	public function setup_shop_layout() {
		global $post;

		if ( ! empty( $post ) ) {
			$is_template = ALPHA_NAME . '_template' == $post->post_type && 'shop_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true );
			if ( ! $is_template ) {
				$this->is_shop_layout = false;
			}
			if ( $is_template || ( defined( 'ALPHA_VERSION' ) && alpha_is_shop() ) ) {
				$this->is_shop_layout = true;
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

		global $post;
		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'shop_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			the_content();
			return true;

		} else {

			global $alpha_layout;
			if ( isset( $alpha_layout['shop_layout_type'] ) && 'builder' == $alpha_layout['shop_layout_type'] &&
			! empty( $alpha_layout['shop_layout_template'] ) ) {

				if ( is_numeric( $alpha_layout['shop_layout_template'] ) ) {
					$template = (int) $alpha_layout['shop_layout_template'];
					do_action( 'alpha_before_shop_template', $template );
					alpha_print_template( $template );
					do_action( 'alpha_after_shop_template', $template );

					return true;
				} elseif ( 'hide' == $alpha_layout['shop_layout_template'] ) {
					return true;
				}
			}
		}

		return $run;
	}

	/**
	 * Set preview for editor and template view
	 *
	 * @since 1.0.0
	 * @access public
	 * @see alpha_shop_builder_set_preview
	 */
	public function set_preview() {

		if ( ! alpha_is_shop() ) {
			global $wp_query, $post, $product, $alpha_layout;

			$this->original = array(
				'layout'   => $alpha_layout,
				'wp_query' => $wp_query,
				'post'     => $post,
				'product'  => empty( $product ) ? '' : $product,
			);

			// Get current options
			$alpha_layout = Alpha_Layout_Builder::get_instance()->get_layout( 'archive_product' );
			$posts        = new WP_Query;
			$posts->query(
				array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'numberposts'         => -1,
					'posts_per_page'      => alpha_loop_shop_per_page(),
					'ignore_sticky_posts' => true,
				)
			);
			$wp_query = $posts;
			WC()->query->product_query( $wp_query );

			wc_setup_loop();

			return true;
		}

		return $this->is_shop_layout;
	}

	/**
	 * Unset preview for editor and template view
	 *
	 * @since 1.0.0
	 * @access public
	 * @see alpha_shop_builder_unset_preview
	 */
	public function unset_preview() {

		if ( ! alpha_is_shop() ) {
			global $wp_query, $post, $product, $alpha_layout;

			$alpha_layout = $this->original['layout'];
			$wp_query     = $this->original['wp_query'];
			$post         = $this->original['post'];
			if ( ! empty( $this->original['product'] ) ) {
				$product = $this->original['product'];
			}
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		if ( $this->is_shop_layout && ! alpha_is_shop() ) {
			wp_enqueue_style( 'alpha-theme-shop' );
		}
	}


	/**
	 * Register elementor category.
	 *
	 * @since 1.0
	 */
	public function register_elementor_category( $self ) {
		global $post;

		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'shop_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			$self->add_category(
				'alpha_shop_widget',
				array(
					'title'  => ALPHA_DISPLAY_NAME . esc_html__( ' Shop', 'pandastore-core' ),
					'active' => true,
				)
			);
		}
	}

	/**
	 * Register elementor widgets.
	 *
	 * @since 1.0
	 */
	public function register_elementor_widgets( $self ) {
		global $post;

		$register = $post && ALPHA_NAME . '_template' == $post->post_type && 'shop_layout' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true );

		if ( ! $register ) {
			global $alpha_layout;
			$register = isset( $alpha_layout['shop_layout_type'] ) && 'builder' == $alpha_layout['shop_layout_type'] &&
			! empty( $alpha_layout['shop_layout_template'] ) && is_numeric( $alpha_layout['shop_layout_template'] );
			// $this->preview_mode = true;
		}

		if ( $register ) {
			foreach ( $this->widgets as $widget => $usable ) {
				if ( $usable ) {
					require_once alpha_core_framework_path( ALPHA_BUILDERS . '/shop/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
					$class_name = 'Alpha_Shop_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
					$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
				}
			}
		}
	}
}

Alpha_Template_Shop_Builder::get_instance();
