<?php
/**
 * Alpha Vendors class
 *
 * Available plugins are: Dokan, WCFM, WC Marketplace, WC Vendors
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 * @version    1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

define( 'ALPHA_CORE_ELEMENTOR', ALPHA_CORE_PLUGINS . '/elementor' );
define( 'ALPHA_CORE_ELEMENTOR_URI', ALPHA_CORE_PLUGINS_URI . '/elementor' );

use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Controls_Manager;
use Elementor\Alpha_Controls_Manager;

class Alpha_Core_Elementor extends Alpha_Base {

	/**
	 * Check if dom is optimized
	 *
	 * @since 1.0
	 *
	 * @var boolean $is_dom_optimized
	 */
	public static $is_dom_optimized = false;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Include Partials
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/addon.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/hotspot.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/banner.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/creative.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/grid.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/slider.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/button.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/tab.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/products.php' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/partials/testimonial.php' );

		/**
		 * Fires after default partials for extending.
		 *
		 * @since 1.0
		 */
		do_action( 'alpha_extend_elementor_partials' );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		// Register controls, widgets, elements, icons
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_control' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widget' ) );
		add_action( 'elementor/elements/elements_registered', array( $this, 'register_element' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'alpha_add_icon_library' ) );
		add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'add_appear_animations' ), 10, 1 );

		// Load Elementor CSS and JS
		if ( alpha_is_elementor_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_preview_scripts' ) );
		}

		// Disable elementor resource.
		if ( function_exists( 'alpha_get_option' ) && alpha_get_option( 'resource_disable_elementor' ) && ! current_user_can( 'edit_pages' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'resource_disable_elementor' ), 99 );
			add_action( 'elementor/widget/before_render_content', array( $this, 'enqueue_theme_alternative_scripts' ) );

			// Do not update dynamic css for visitors.
			add_action( 'init', array( $this, 'remove_dynamic_css_update' ) );
		}

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_admin_styles' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'remove_fontawesome' ), 11 );
		// Include Elementor Admin JS
		add_action(
			'elementor/editor/after_enqueue_scripts',
			function() {
				if ( defined( 'ALPHA_VERSION' ) ) {
					wp_enqueue_style( 'themes-icons', ALPHA_ASSETS . '/vendor/' . ALPHA_NAME . '-icons/css/icons.min.css', array(), ALPHA_VERSION );
					wp_enqueue_style( 'alpha-admin-dynamic', ALPHA_CSS . '/dynamic_css_vars.css', array(), ALPHA_VERSION );
				}
				wp_enqueue_script( 'alpha-elementor-admin', alpha_core_framework_uri( '/plugins/elementor/assets/elementor-admin' . ALPHA_JS_SUFFIX ), array( 'elementor-editor' ), ALPHA_CORE_VERSION, true );
			}
		);

		// Add Elementor Page Custom CSS
		if ( wp_doing_ajax() ) {
			add_action( 'elementor/document/before_save', array( $this, 'save_page_custom_css_js' ), 10, 2 );
			add_action( 'elementor/document/after_save', array( $this, 'save_elementor_page_css_js' ), 10, 2 );
		}

		// Init Elementor Document Config
		add_filter( 'elementor/document/config', array( $this, 'init_elementor_config' ), 10, 2 );

		// Register Document Controls
		add_action( 'elementor/documents/register_controls', array( $this, 'register_document_controls' ) );

		// Remove ui theme control: dark/light mode
		add_action( 'elementor/element/editor-preferences/preferences/after_section_end', array( $this, 'remove_dark_mode' ) );

		// Add Custom CSS & JS to Alpha Elementor Addons
		add_filter( 'alpha_builder_addon_html', array( $this, 'add_custom_css_js_addon_html' ) );

		// Because elementor removes all callbacks, add it again
		add_action( 'elementor/editor/after_enqueue_scripts', 'alpha_print_footer_scripts' );

		// Add Template Builder Classes
		add_filter( 'body_class', array( $this, 'add_body_class' ) );

		// Add shape divider
		add_action( 'elementor/shapes/additional_shapes', array( $this, 'add_shape_dividers' ) );
		add_action( 'elementor/element/section/section_shape_divider/after_section_end', array( $this, 'add_custom_shape_divider' ), 10, 2 );

		// Compatabilities
		add_filter( 'elementor/widgets/wordpress/widget_args', array( $this, 'add_wp_widget_args' ), 10, 2 );

		// Is dom optimized?
		// if ( version_compare( ELEMENTOR_VERSION, '3.1.0', '>=' ) ) {
		// 	alpha_elementor_if_dom_optimization() = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		// } elseif ( version_compare( ELEMENTOR_VERSION, '3.0', '>=' ) ) {
		// 	alpha_elementor_if_dom_optimization() = ( ! \Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' ) );
		// }
		// Load Used Block CSS
		/*
		 * Get Dependent Elementor Styles
		 * Includes Kit style and post style
		 */
		add_action( 'elementor/css-file/post/enqueue', array( $this, 'get_dependent_elementor_styles' ) );
		add_action( 'alpha_before_enqueue_theme_style', array( $this, 'add_global_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_elementor_css' ), 30 );
		add_action( 'alpha_before_enqueue_custom_css', array( $this, 'add_elementor_page_css' ), 20 );
		add_action( 'alpha_before_enqueue_custom_css', array( $this, 'add_block_css' ) );

		// Elementor Custom Control Manager
		require_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/restapi/select2.php' );
		require_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/controls_manager/controls.php' );

		// Dynamic Tags
		add_action( 'elementor/init', array( $this, 'init_module' ) );
	}

	/**
	 * Register scripts
	 *
	 * @since 1.0
	 */
	public function register_scripts() {

		// Parallax scripts
		wp_register_script( 'jquery-floating', ALPHA_CORE_FRAMEWORK_URI . '/assets/js/jquery.floating.min.js', array( 'jquery-core' ), false, true );
		wp_register_script( 'jquery-skrollr', ALPHA_CORE_FRAMEWORK_URI . '/assets/js/skrollr.min.js', array(), '0.6.30', true );

		// Chart scripts
		wp_register_script( 'alpha-chart-lib', ALPHA_CORE_FRAMEWORK_URI . '/assets/js/chart.min.js', array(), false, true );
	}

	/**
	 * Initialize Elementor Module
	 *
	 * @since 1.0
	 */
	public function init_module() {
		// @start feature: fs_plugin_acf
		require_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/dynamic_tags/dynamic_tags.php' );
		// @end feature: fs_plugin_acf
	}

	// Register new Category
	public function register_category( $self ) {
		$self->add_category(
			'alpha_widget',
			array(
				'title'  => ALPHA_DISPLAY_NAME . esc_html__( ' Widgets', 'pandastore-core' ),
				'active' => true,
			)
		);
	}

	// Register new Control
	public function register_control( $self ) {

		$controls = apply_filters(
			'alpha_elementor_register_control',
			array(
				'ajaxselect2',
				'description',
				'image_choose',
				'origin_position',
			)
		);

		foreach ( $controls as $control ) {
			include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/controls/' . $control . '.php' );
			$class_name = 'Alpha_Control_' . ucfirst( $control );
			$self->register_control( $control, new $class_name() );
		}
	}


	public function register_element() {
		// Elementor Custom Advanced Tab Sections
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/tabs/widget-advanced-tabs.php' );

		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/elements/section.php' );
		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'section' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Alpha_Element_Section() );

		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/elements/column.php' );
		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'column' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Alpha_Element_Column() );
	}


	// Register new Widget
	public function register_widget( $self ) {
		/* Remove elementor default common widget and register ours */
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/tabs/widget-advanced-tabs.php' );
		$self->unregister_widget_type( 'common' );
		include_once alpha_core_framework_path( ALPHA_CORE_ELEMENTOR . '/elements/widget-common.php' );
		$self->register_widget_type( new Alpha_Common_Elementor_Widget( array(), array( 'widget_name' => 'common' ) ) );

		$widgets = array(
			'heading'             => true,
			'posts'               => true,
			'block'               => true,
			'banner'              => true,
			'breadcrumb'          => true,
			'countdown'           => true,
			'button'              => true,
			'image-gallery'       => true,
			'search'              => true,
			'testimonial-group'   => true,
			'image-box'           => true,
			'share'               => true,
			'menu'                => true,
			'subcategories'       => true,
			'hotspot'             => true,
			'logo'                => true,
			'iconlist'            => true,
			'svg-floating'        => true,
			'animated-text'       => true,
			'bar-chart'           => true,
			'line-chart'          => true,
			'highlight'           => true,
			'pie-doughnut-chart'  => true,
			'polar-chart'         => true,
			'radar-chart'         => true,
			'flipbox'             => true,
			'image-compare'       => true,
			'price-tables'        => true,
			'table'               => true,
			'progressbars'        => true,
			'timeline'            => true,
			'timeline-horizontal' => true,
			'contact'             => true,
			'360-degree'          => true,
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$widgets = array_merge(
				$widgets,
				array(
					'products'        => true,
					'products-tab'    => true,
					'products-banner' => true,
					'categories'      => true,
					'singleproducts'  => true,
					'filter'          => true,
				)
			);

			// @start feature: fs_widget_vendor
			if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCMp' ) || class_exists( 'WCFM' ) || class_exists( 'WC_Vendors' ) ) {
				$widgets['vendor'] = true;
			}
			// @end feature: fs_widget_vendor
			// @start feature: fs_widget_brands
			if ( ( function_exists( 'alpha_get_option' ) && alpha_get_option( 'brand' ) )
			|| ( class_exists( 'Alpha_Plugin_Options' ) && Alpha_Plugin_Options::get_option( 'alpha_product_brand', 'yes' ) ) ) {
				$widgets['brands'] = true;
			}
			// @end feature: fs_widget_brands
		}

		$widgets = apply_filters( 'alpha_elementor_widgets', $widgets );
		array_multisort( $widgets );

		foreach ( $widgets as $widget => $usable ) {
			if ( $usable ) {
				$prefix = $widget;
				if ( 'products' == substr( $widget, 0, 8 ) ) {
					$prefix = 'products';
				} elseif ( 'testimonial' == substr( $widget, 0, 11 ) ) {
					$prefix = 'testimonial';
				}
				require_once alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/' . $prefix . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
				$class_name = 'Alpha_' . ucwords( str_replace( '-', '_', $widget ), '_' ) . '_Elementor_Widget';
				$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}

	public function load_admin_styles() {
		if ( defined( 'ALPHA_ASSETS' ) ) {
			wp_enqueue_style( 'fontawesome-free', ALPHA_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );
		}
		wp_enqueue_style( 'alpha-elementor-admin-style', alpha_core_framework_uri( '/plugins/elementor/assets/elementor-admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ) );
		wp_dequeue_style( 'elementor-editor-dark-mode' ); // Disable Dark Mode
	}

	public function remove_fontawesome() {
		wp_deregister_style( 'elementor-icons-shared-0' );
		wp_deregister_style( 'elementor-icons-fa-regular' );
		wp_deregister_style( 'elementor-icons-fa-solid' );
		wp_deregister_style( 'elementor-icons-fa-bold' );
	}

	public function load_preview_scripts() {
		// load needed style file in elementor preview
		wp_enqueue_style( 'alpha-elementor-preview', alpha_core_framework_uri( '/plugins/elementor/assets/elementor-preview' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ) );
		wp_enqueue_script( 'alpha-elementor-js', alpha_core_framework_uri( '/plugins/elementor/assets/elementor' . ALPHA_JS_SUFFIX ), array(), ALPHA_CORE_VERSION, true );
		wp_localize_script(
			'alpha-elementor-js',
			'alpha_elementor',
			array(
				'ajax_url'           => esc_js( admin_url( 'admin-ajax.php' ) ),
				'wpnonce'            => wp_create_nonce( 'alpha-elementor-nonce' ),
				'core_framework_url' => ALPHA_CORE_FRAMEWORK_URI,
				'text_untitled'      => esc_html__( 'Untitled', 'pandastore-core' ),
			)
		);
		wp_enqueue_script( 'selectWoo' );
		wp_enqueue_script( 'wc-country-select' );
	}

	/**
	 * Disable elementor resource for high performance
	 *
	 * @since 1.0
	 */
	public function resource_disable_elementor() {
		wp_dequeue_style( 'e-animations' );
		wp_dequeue_script( 'elementor-frontend' );
		wp_dequeue_script( 'elementor-frontend-modules' );
		wp_dequeue_script( 'elementor-waypoints' );
		wp_dequeue_script( 'elementor-webpack-runtime' );
		wp_deregister_script( 'elementor-frontend' );
		wp_deregister_script( 'elementor-frontend-modules' );
		wp_deregister_script( 'elementor-waypoints' );
		wp_deregister_script( 'elementor-webpack-runtime' );
	}

	/**
	 * Enqueue alternative scripts for disable elementor resource mode.
	 *
	 * @param $widget
	 * @since 1.0
	 */
	public function enqueue_theme_alternative_scripts( $widget ) {
		if ( 'counter' == $widget->get_name() ) {
			wp_enqueue_script( 'jquery-count-to' );
		}
	}

	public function alpha_add_icon_library( $icons ) {
		if ( defined( 'ALPHA_VERSION' ) ) {
			$icons['themes-icons'] = array(
				'name'          => 'alpha',
				'label'         => ALPHA_DISPLAY_NAME . esc_html__( ' Icons', 'pandastore-core' ),
				'prefix'        => ALPHA_ICON_PREFIX . '-icon-',
				'displayPrefix' => ' ',
				'labelIcon'     => ALPHA_ICON_PREFIX . '-icon-gift',
				'fetchJson'     => alpha_core_framework_uri( '/plugins/elementor/assets/themes-icons.js' ),
				'ver'           => ALPHA_CORE_VERSION,
				'native'        => false,
			);
		}
		return $icons;
	}

	public function save_page_custom_css_js( $self, $data ) {
		if ( empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );

		// save Alpha elementor page CSS
		if ( ! empty( $data['settings']['page_css'] ) ) {
			update_post_meta( $post_id, 'page_css', wp_slash( $data['settings']['page_css'] ) );
		} else {
			delete_post_meta( $post_id, 'page_css' );
		}

		if ( current_user_can( 'unfiltered_html' ) ) {
			// save Alpha elementor page JS
			if ( ! empty( $data['settings']['page_js'] ) ) {
				update_post_meta( $post_id, 'page_js', trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $data['settings']['page_js'] ) ) );
			} else {
				delete_post_meta( $post_id, 'page_js' );
			}
		}
	}

	public function save_elementor_page_css_js( $self, $data ) {
		if ( current_user_can( 'unfiltered_html' ) || empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );
		if ( ! empty( $data['settings']['page_css'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_css'] = alpha_strip_script_tags( get_post_meta( $post_id, 'page_css', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
		if ( ! empty( $data['settings']['page_js'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_js'] = alpha_strip_script_tags( get_post_meta( $post_id, 'page_js', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
	}

	public function init_elementor_config( $config = array(), $post_id = 0 ) {

		if ( ! isset( $config['settings'] ) ) {
			$config['settings'] = array();
		}
		if ( ! isset( $config['settings']['settings'] ) ) {
			$config['settings']['settings'] = array();
		}

		$config['settings']['settings']['page_css'] = get_post_meta( $post_id, 'page_css', true );
		$config['settings']['settings']['page_js']  = get_post_meta( $post_id, 'page_js', true );
		return $config;
	}

	/**
	 * Add custom css, js addon html to bottom of elementor editor panel.
	 *
	 * @since 1.0
	 * @param array $html
	 * @return array $html
	 */
	public function add_custom_css_js_addon_html( $html ) {
		$html[] = array(
			'elementor' => '<li id="alpha-custom-css"><i class="fab fa-css3"></i>' . esc_html__( 'Page CSS', 'pandastore-core' ) . '</li>',
		);
		$html[] = array(
			'elementor' => '<li id="alpha-custom-js"><i class="fab fa-js"></i>' . esc_html__( 'Page JS', 'pandastore-core' ) . '</li>',
		);
		return $html;
	}

	public function register_document_controls( $document ) {
		if ( ! $document instanceof Elementor\Core\DocumentTypes\PageBase && ! $document instanceof Elementor\Modules\Library\Documents\Page ) {
			return;
		}

		// Add Template Builder Controls
		$id = (int) $document->get_main_id();

		if ( ALPHA_NAME . '_template' == get_post_type( $id ) ) {
			$category = get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true );

			if ( $id && 'popup' == get_post_meta( $id, ALPHA_NAME . '_template_type', true ) ) {

				$selector = '.mfp-alpha-' . $id;

				$document->start_controls_section(
					'alpha_popup_settings',
					array(
						'label' => ALPHA_DISPLAY_NAME . esc_html__( ' Popup Settings', 'pandastore-core' ),
						'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
					)
				);

					$document->add_responsive_control(
						'popup_width',
						array(
							'label'      => esc_html__( 'Width', 'pandastore-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 600,
							),
							'size_units' => array(
								'px',
								'vw',
							),
							'range'      => array(
								'vw' => array(
									'step' => 1,
									'min'  => 0,
								),
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'width: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_height_type',
						array(
							'label'   => esc_html__( 'Height', 'pandastore-core' ),
							'type'    => Elementor\Controls_Manager::SELECT,
							'options' => array(
								''       => esc_html__( 'Fit To Content', 'pandastore-core' ),
								'custom' => esc_html__( 'Custom', 'pandastore-core' ),
							),
						)
					);

					$document->add_responsive_control(
						'popup_height',
						array(
							'label'      => esc_html__( 'Custom Height', 'pandastore-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 380,
							),
							'size_units' => array(
								'px',
								'vh',
							),
							'range'      => array(
								'vh' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'condition'  => array(
								'popup_height_type' => 'custom',
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'height: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_content_pos_heading',
						array(
							'label'     => esc_html__( 'Content Position', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_content_h_pos',
						array(
							'label'     => esc_html__( 'Horizontal', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => esc_html__( 'Top', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => esc_html__( 'Middle', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => esc_html__( 'Bottom', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .alpha-popup-content' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_content_v_pos',
						array(
							'label'     => esc_html__( 'Vertical', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => esc_html__( 'Top', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => esc_html__( 'Middle', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => esc_html__( 'Bottom', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .alpha-popup-content' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_pos_heading',
						array(
							'label'     => esc_html__( 'Position', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_h_pos',
						array(
							'label'     => esc_html__( 'Horizontal', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => esc_html__( 'Left', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => esc_html__( 'Center', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => esc_html__( 'Right', 'pandastore-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_v_pos',
						array(
							'label'     => esc_html__( 'Vertical', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => esc_html__( 'Top', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => esc_html__( 'Middle', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => esc_html__( 'Bottom', 'pandastore-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_style_heading',
						array(
							'label'     => esc_html__( 'Style', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_control(
						'popup_overlay_color',
						array(
							'label'     => esc_html__( 'Overlay Color', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( '.mfp-bg' . $selector ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_content_color',
						array(
							'label'     => esc_html__( 'Content Color', 'pandastore-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( $selector . ' .popup .alpha-popup-content' ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_group_control(
						Elementor\Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'popup_box_shadow',
							'selector' => ( $selector . ' .popup' ),
						)
					);

					$document->add_responsive_control(
						'popup_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
							'type'       => Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => array(
								'px',
								'%',
								'em',
							),
							'selectors'  => array(
								( $selector . ' .popup .alpha-popup-content' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_margin',
						array(
							'label'      => esc_html__( 'Margin', 'pandastore-core' ),
							'type'       => Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => array(
								'px',
								'%',
								'em',
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_animation',
						array(
							'type'      => Elementor\Controls_Manager::SELECT,
							'label'     => esc_html__( 'Popup Animation', 'pandastore-core' ),
							'options'   => alpha_get_animations( 'in' ),
							'separator' => 'before',
							'default'   => 'default',
						)
					);

					$document->add_control(
						'popup_anim_duration',
						array(
							'type'    => Elementor\Controls_Manager::NUMBER,
							'label'   => esc_html__( 'Animation Duration (ms)', 'pandastore-core' ),
							'default' => 400,
						)
					);

					$document->add_control(
						'popup_desc_click',
						array(
							'type'        => Alpha_Controls_Manager::DESCRIPTION,
							'description' => sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'pandastore-core' ), '<b>', '</b>' ),
						)
					);

				$document->end_controls_section();
			}
		}

		$document->start_controls_section(
			'alpha_blank_styles',
			array(
				'label' => ALPHA_DISPLAY_NAME . esc_html__( ' Blank Styles', 'pandastore-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$document->end_controls_section();

		$document->start_controls_section(
			'alpha_custom_css_settings',
			array(
				'label' => ALPHA_DISPLAY_NAME . esc_html__( ' Custom CSS', 'pandastore-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

			$document->add_control(
				'page_css',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 20,
				)
			);

		$document->end_controls_section();

		if ( current_user_can( 'unfiltered_html' ) ) {

			$document->start_controls_section(
				'alpha_custom_js_settings',
				array(
					'label' => ALPHA_DISPLAY_NAME . esc_html__( ' Custom JS', 'pandastore-core' ),
					'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$document->add_control(
				'page_js',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 20,
				)
			);

			$document->end_controls_section();
		}
	}

	public function add_body_class( $classes ) {
		if ( alpha_is_elementor_preview() && ALPHA_NAME . '_template' == get_post_type() ) {
			$template_category = get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true );

			if ( ! $template_category ) {
				$template_category = 'block';
			}

			$classes[] = 'alpha_' . $template_category . '_template';
		}
		return $classes;
	}

	public function add_appear_animations() {
		return alpha_get_animations( 'appear' );
	}

	public function add_wp_widget_args( $args, $self ) {
		$args['before_widget'] = '<div class="widget ' . $self->get_widget_instance()->widget_options['classname'] . ' widget-collapsible">';
		$args['after_widget']  = '</div>';
		$args['before_title']  = '<h3 class="widget-title">';
		$args['after_title']   = '</h3>';

		return $args;
	}

	public function get_dependent_elementor_styles( $self ) {
		if ( 'file' == $self->get_meta()['status'] ) { // Re-check if it's not empty after CSS update.
			preg_match( '/post-(\d+).css/', $self->get_url(), $id );
			if ( count( $id ) == 2 ) {
				global $e_post_ids;

				wp_dequeue_style( 'elementor-post-' . $id[1] );

				wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array( 'elementor-frontend' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

				if ( ! isset( $e_post_ids ) ) {
					$e_post_ids = array();
				}
				$e_post_ids[] = $id[1];
			}
		}
	}

	public function add_global_css() {
		global $alpha_layout;
		$alpha_layout['used_blocks'] = alpha_get_page_blocks();

		if ( ! empty( $alpha_layout['used_blocks'] ) ) {
			foreach ( $alpha_layout['used_blocks'] as $block_id => $enqueued ) {
				if ( $this->is_elementor_block( $block_id ) ) {
					wp_enqueue_style( 'elementor-icons' );
					wp_enqueue_style( 'elementor-frontend' );

					if ( isset( \Elementor\Plugin::$instance ) ) {

						$kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
						if ( $kit_id ) {
							wp_enqueue_style( 'elementor-post-' . $kit_id, wp_upload_dir()['baseurl'] . '/elementor/css/post-' . $kit_id . '.css' );
						}

						add_action(
							'wp_footer',
							function() {
								try {
									wp_enqueue_script( 'elementor-frontend' );
									$settings = \Elementor\Plugin::$instance->frontend->get_settings();
									\Elementor\Utils::print_js_config( 'elementor-frontend', 'elementorFrontendConfig', $settings );
								} catch ( Exception $e ) {
								}
							}
						);
					}

					$scheme_css_file = Global_CSS::create( 'global.css' );
					$scheme_css_file->enqueue();

					break;
				}
			}
		}

		global $e_post_ids;
		if ( is_array( $e_post_ids ) ) {
			foreach ( $e_post_ids as $id ) {
				if ( get_the_ID() != $id ) {
					wp_enqueue_style( 'elementor-post-' . $id );
				}
			}
		}
	}

	public function is_elementor_block( $id ) {
		$elements_data = get_post_meta( $id, '_elementor_data', true );
		return $elements_data && get_post_meta( $id, '_elementor_edit_mode', true );
	}

	public function add_elementor_css() {
		// Add Alpha elementor style
		wp_enqueue_style( 'alpha-elementor-style', alpha_core_framework_uri( '/plugins/elementor/assets/elementor' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ), array( 'elementor-frontend' ) );
	}

	public function add_elementor_page_css() {
		// Add page css
		wp_enqueue_style( 'elementor-post-' . get_the_ID() );
	}

	public function add_block_css() {
		global $alpha_layout;

		if ( ! empty( $alpha_layout['used_blocks'] ) ) {
			$upload     = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_url = $upload['baseurl'];

			foreach ( $alpha_layout['used_blocks'] as $block_id => $enqueued ) {
				if ( 'internal' !== get_option( 'elementor_css_print_method' ) && ( ! alpha_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $block_id ) && $this->is_elementor_block( $block_id ) ) { // Check if current elementor block is editing

					$block_css = get_post_meta( (int) $block_id, 'page_css', true );
					if ( $block_css ) {
						$block_css = function_exists( 'alpha_minify_css' ) ? alpha_minify_css( $block_css ) : $block_css;
					}

					$post_css_path = wp_normalize_path( $upload_dir . '/elementor/css/post-' . $block_id . '.css' );
					if ( file_exists( $post_css_path ) ) {
						wp_enqueue_style( 'elementor-post-' . $block_id, $upload_url . '/elementor/css/post-' . $block_id . '.css' );
						wp_add_inline_style( 'elementor-post-' . $block_id, apply_filters( 'alpha_elementor_block_style', $block_css ) );
					} else {
						$css_file  = new Elementor\Core\Files\CSS\Post( $block_id );
						$block_css = $css_file->get_content() . apply_filters( 'alpha_elementor_block_style', $block_css );

						// Save block css as elementor post css.
						// filesystem
						global $wp_filesystem;
						// Initialize the WordPress filesystem, no more using file_put_contents function
						if ( empty( $wp_filesystem ) ) {
							require_once ABSPATH . '/wp-admin/includes/file.php';
							WP_Filesystem();
						}
						$wp_filesystem->put_contents( $post_css_path, $block_css, FS_CHMOD_FILE );

						// Fix elementor's "max-width: auto" error.
						$block_css = str_replace( 'max-width:auto', 'max-width:none', $block_css );
						wp_add_inline_style( 'alpha-style', $block_css );
					}

					$alpha_layout['used_blocks'][ $block_id ]['css'] = true;
				}
			}
		}
	}

	/**
	 * Remove elementor action to update dynamic post css.
	 */
	public function remove_dynamic_css_update() {
		remove_action( 'elementor/css-file/post/enqueue', array( Elementor\Plugin::$instance->dynamic_tags, 'after_enqueue_post_css' ) );
	}

	/**
	 * Add theme shape dividers.
	 *
	 * @since 1.0
	 *
	 * @param array $shapes Additional Elementor shapes.
	 * @return array $shapes
	 */
	public function add_shape_dividers( $shapes ) {

		$shapes['alpha-shape1'] = array(
			'title'        => esc_html__( 'Shape 1', 'pandastore-core' ),
			'has_negative' => false,
		);
		$shapes['alpha-shape2'] = array(
			'title'        => esc_html__( 'Shape 2', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-shape3'] = array(
			'title'        => esc_html__( 'Shape 3', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-shape4'] = array(
			'title'        => esc_html__( 'Shape 4', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-shape5'] = array(
			'title'        => esc_html__( 'Shape 5', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-wave1']  = array(
			'title'        => esc_html__( 'Wave 1', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-wave2']  = array(
			'title'        => esc_html__( 'Wave 2', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-wave3']  = array(
			'title'        => esc_html__( 'Wave 3', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-wave4']  = array(
			'title'        => esc_html__( 'Wave 4', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['alpha-wave5']  = array(
			'title'        => esc_html__( 'Wave 5', 'pandastore-core' ),
			'has_negative' => true,
		);
		$shapes['custom']       = array(
			'title'        => esc_html__( 'Custom', 'pandastore-core' ),
			'has_negative' => true,
		);

		return $shapes;
	}

	/**
	 * Add Shape divider option to elementor section.
	 *
	 * @since 1.0
	 *
	 * @param object $self Object of elementor section
	 * @param array  $args
	 */
	public function add_custom_shape_divider( $self, $args ) {

		// $shapes_options = array(
		// 	'' => esc_html__( 'None', 'elementor' ),
		// );
		// foreach ( Elementor\Shapes::get_shapes() as $shape_name => $shape_props ) {
		// 	$shapes_options[ $shape_name ] = $shape_props['title'];
		// }
		// $shapes_options['custom'] = __( 'Custom', 'pandastore-core' );

		// $self->update_control(
		// 	'shape_divider_top',
		// 	array(
		// 		'label'              => esc_html__( 'Type', 'elementor' ),
		// 		'type'               => Controls_Manager::SELECT,
		// 		'options'            => $shapes_options,
		// 		'render_type'        => 'none',
		// 		'frontend_available' => true,
		// 	),
		// 	array(
		// 		'overwrite' => true,
		// 	)
		// );
		// $self->update_control(
		// 	'shape_divider_bottom',
		// 	array(
		// 		'label'              => esc_html__( 'Type', 'elementor' ),
		// 		'type'               => Controls_Manager::SELECT,
		// 		'options'            => $shapes_options,
		// 		'render_type'        => 'none',
		// 		'frontend_available' => true,
		// 	),
		// 	array(
		// 		'overwrite' => true,
		// 	)
		// );

		$self->update_control(
			'shape_divider_top_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shape_divider_top!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-shape-top .elementor-shape-fill' => 'fill: {{VALUE}};',
					'{{WRAPPER}} > .elementor-shape-top svg' => 'fill: {{VALUE}};',
				],
			),
			array(
				'overwrite' => true,
			)
		);
		$self->update_control(
			'shape_divider_bottom_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shape_divider_bottom!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-shape-bottom .elementor-shape-fill' => 'fill: {{VALUE}};',
					'{{WRAPPER}} > .elementor-shape-bottom svg' => 'fill: {{VALUE}};',
				],
			),
			array(
				'overwrite' => true,
			)
		);

		$self->add_control(
			'shape_divider_top_custom',
			array(
				'label'                  => esc_html__( 'Custom SVG', 'pandastore-core' ),
				'type'                   => Controls_Manager::ICONS,
				'label_block'            => false,
				'skin'                   => 'inline',
				'exclude_inline_options' => array( 'icon' ),
				'render_type'            => 'none',
				'frontend_available'     => true,
				'condition'              => array(
					'shape_divider_top' => 'custom',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_top',
				),
			)
		);
		$self->add_control(
			'shape_divider_bottom_custom',
			array(
				'label'                  => esc_html__( 'Custom SVG', 'pandastore-core' ),
				'type'                   => Controls_Manager::ICONS,
				'label_block'            => false,
				'skin'                   => 'inline',
				'exclude_inline_options' => array( 'icon' ),
				'render_type'            => 'none',
				'frontend_available'     => true,
				'condition'              => array(
					'shape_divider_bottom' => 'custom',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_bottom',
				),
			)
		);
	}

	/**
	 * Remove Dark Mode
	 *
	 * @since 1.0.0
	 */
	public function remove_dark_mode( $args ) {
		$args->remove_control( 'ui_theme' );
	}
}

/**
 * Create instance
 *
 * @since 1.0
 */
Alpha_Core_Elementor::get_instance();

if ( ! function_exists( 'alpha_elementor_if_dom_optimization' ) ) :
	function alpha_elementor_if_dom_optimization() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return false;
		}
		if ( version_compare( ELEMENTOR_VERSION, '3.1.0', '>=' ) ) {
			return \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		} elseif ( version_compare( ELEMENTOR_VERSION, '3.0', '>=' ) ) {
			return ( ! \Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' ) );
		}
		return false;
	}
endif;
