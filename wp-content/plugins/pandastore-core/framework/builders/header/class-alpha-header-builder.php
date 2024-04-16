<?php
/**
 * Alpha Builder Header class
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

define( 'ALPHA_HEADER_BUILDER', ALPHA_BUILDERS . '/header' );

class Alpha_Header_Builder extends Alpha_Base {

	/**
	 * Header builder widgets.
	 *
	 * @var array
	 * @since 1.0
	 */
	public $widgets = array();

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->widgets = apply_filters(
			'alpha_header_widget',
			array(
				'cart'              => true,
				'language_switcher' => true,
				'currency_switcher' => true,
				'mmenu_toggle'      => true,
				'v_divider'         => true,
				'account'           => true,
				'wishlist'          => true,
				'compare'           => true,
			)
		);
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
	 * Register elementor category.
	 *
	 * @since 1.0
	 */
	public function register_elementor_category( $self ) {
		global $post, $alpha_layout;

		$register = false;

		if ( is_admin() ) {
			if ( ! alpha_is_elementor_preview() || ( $post && ALPHA_NAME . '_template' == $post->post_type && 'header' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) ) {
				$register = true;
			}
		} else {
			if ( ! empty( $alpha_layout['header'] ) && 'hide' != $alpha_layout['header'] ) {
				$register = true;
			}
		}

		if ( $register ) {
			$self->add_category(
				'alpha_header_widget',
				array(
					'title'  => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'pandastore-core' ),
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
		global $post, $alpha_layout;

		$register = $post && ALPHA_NAME . '_template' == $post->post_type && 'header' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true );

		if ( ! $register ) {
			if ( is_admin() ) {
				if ( ! alpha_is_elementor_preview() ) {
					$register = true;
				}
			} elseif ( ! empty( $alpha_layout['header'] ) && 'hide' != $alpha_layout['header'] ) {
				$register = true;
			}
		}

		if ( $register ) {
			array_multisort( $this->widgets );
			foreach ( $this->widgets as $widget => $usable ) {
				if ( $usable ) {
					require_once alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
					$class_name = 'Alpha_Header_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
					$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
				}
			}
		}
	}

	/**
	 * Register wpb elements.
	 *
	 * @since 1.0
	 */
	public function register_wpb_elements() {
		global $post;

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
			$elements[ 'hb_' . $widget ] = $usable;
		}

		Alpha_WPB::get_instance()->add_shortcodes( $elements, 'header' );
	}
}

Alpha_Header_Builder::get_instance();
