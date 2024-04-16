<?php

/**
 * Alpha Product Data Addons
 *
 * Custom Labels
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_GDPR' ) ) {
	class Alpha_GDPR extends Alpha_Base {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Add theme options
			add_filter( 'alpha_customize_fields', array( $this, 'add_customize_fields' ) );
			if ( function_exists( 'alpha_set_default_option' ) ) {
				alpha_set_default_option( 'show_cookie_info', true );
				// translators: %1$s represents link url, %2$s represents represents a closing tag.
				// alpha_set_default_option( 'cookie_text',  esc_html__( 'We are using cookies to improve your experience on our website. By browsing this website, you agree to our %1$sPrivacy Policy%2$s.', 'pandastore-core' ), '<a href="#">', '</a>'  );
				alpha_set_default_option( 'cookie_version', 1 );
				// alpha_set_default_option( 'cookie_agree_btn', esc_html__( 'I Agree', 'pandastore-core' ) );
				// alpha_set_default_option( 'cookie_decline_btn', esc_html__( 'Decline', 'pandastore-core' ) );

			}
			add_filter(
				'alpha_customize_sections',
				function( $sections ) {
					$sections['cookie_law_info'] = array(
						'title'    => esc_html__( 'Privacy Setting (GDPR)', 'pandastore-core' ),
						'panel'    => 'advanced',
						'priority' => 100,
					);
					return $sections;
				}
			);

			if ( alpha_get_option( 'show_cookie_info' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 35 );
				add_filter( 'alpha_vars', array( $this, 'add_localized_vars' ) );
				add_action( 'alpha_after_page_wrapper', array( $this, 'print_cookie_popup' ) );
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
			// Cookie Law Options
			$fields['cs_cookie_law_title'] = array(
				'section' => 'cookie_law_info',
				'type'    => 'custom',
				'label'   => '',
				'default' => '<h3 class="options-custom-title">' . esc_html__( 'Privacy Consent Setting', 'pandastore-core' ) . '</h3>',
			);
			$fields['show_cookie_info']    = array(
				'section' => 'cookie_law_info',
				'label'   => esc_html__( 'Show Privacy Consent Info Bar', 'pandastore-core' ),
				'tooltip' => esc_html__( 'Under GDPR(General Data Protection Regulation), websites must make it clear to visitors who are from EU to control over their personal data that is being store by website. This specifically includes cookie.', 'pandastore-core' ),
				'type'    => 'toggle',
			);
			$fields['cookie_text']         = array(
				'section'         => 'cookie_law_info',
				'label'           => esc_html__( 'Content', 'pandastore-core' ),
				'description'     => esc_html__( 'Place some text here for cookie usage', 'pandastore-core' ),
				'type'            => 'textarea',
				'active_callback' => array(
					array(
						'setting'  => 'show_cookie_info',
						'operator' => '==',
						'value'    => true,
					),
				),
			);
			$fields['choose_cookie_page']  = array(
				'section'         => 'cookie_law_info',
				'label'           => esc_html__( 'Choose Privacy Policy Page', 'pandastore-core' ),
				'tooltip'         => esc_html__( 'Choose the page that will contain your privacy policy', 'pandastore-core' ),
				'type'            => 'select',
				'choices'         => alpha_get_pages_arr(),
				'active_callback' => array(
					array(
						'setting'  => 'show_cookie_info',
						'operator' => '==',
						'value'    => true,
					),
				),
			);
			$fields['cookie_version']      = array(
				'section'         => 'cookie_law_info',
				'label'           => esc_html__( 'Cookie Version', 'pandastore-core' ),
				'type'            => 'text',
				'active_callback' => array(
					array(
						'setting'  => 'show_cookie_info',
						'operator' => '==',
						'value'    => true,
					),
				),
			);
			$fields['cookie_agree_btn']    = array(
				'section'         => 'cookie_law_info',
				'label'           => esc_html__( 'Privacy Agreement Button Label', 'pandastore-core' ),
				'type'            => 'text',
				'active_callback' => array(
					array(
						'setting'  => 'show_cookie_info',
						'operator' => '==',
						'value'    => true,
					),
				),
			);
			$fields['cookie_decline_btn']  = array(
				'section'         => 'cookie_law_info',
				'label'           => esc_html__( 'Privacy Declinature Button Label', 'pandastore-core' ),
				'type'            => 'text',
				'active_callback' => array(
					array(
						'setting'  => 'show_cookie_info',
						'operator' => '==',
						'value'    => true,
					),
				),
			);

			return $fields;
		}


		/**
		 * Enqueue style and script.
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'alpha-gdpr', alpha_core_framework_uri( '/addons/gdpr/gdpr' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ) );
			wp_enqueue_script( 'alpha-gdpr', alpha_core_framework_uri( '/addons/gdpr/gdpr' . ALPHA_JS_SUFFIX ), array( 'alpha-framework-async' ), ALPHA_VERSION, true );
		}

		/**
		 * Add localized vars
		 *
		 * @since 1.0
		 * @param array $vars
		 * @return $vars
		 */
		public function add_localized_vars( $vars ) {
			$vars['cookie_version'] = alpha_get_option( 'cookie_version' );
			return $vars;
		}

		/**
		 * Print Cookie law information popup
		 *
		 * @since 1.0
		 *
		 * @return template
		 */
		public function print_cookie_popup() {
			?>
			<div class="cookies-popup bg-dark">
				<div class="container d-flex align-items-center">
					<div class="cookies-info">
					<?php
echo sprintf(
    esc_html__( 'We are using cookies to improve your experience on our website. By browsing this website, you agree to our %1$sPrivacy Policy%2$s.', 'pandastore' ),
    '<a href="' . esc_url( home_url( '/'. __('privacy-policy', 'pandastore') ) ) . '">',
    '</a>'
);

    ?>
					</div>
					<div class="cookies-buttons d-flex flex-1 align-items-center justify-content-end">
						<a href="#" rel="nofollow noopener" class="btn btn-sm btn-secondary btn-rounded decline-cookie-btn"><?php echo alpha_strip_script_tags( alpha_get_option( 'cookie_decline_btn' ) ); ?></a>
						<a href="#" rel="nofollow noopener" class="btn btn-sm btn-primary btn-rounded accept-cookie-btn"><?php echo alpha_strip_script_tags( alpha_get_option( 'cookie_agree_btn' ) ); ?></a>
					</div>
				</div>
				<a href="#" class="close-cookie-btn" aria-label="<?php esc_html_e( 'Close Cookie Consent', 'pandastore-core' ); ?>"></a>
			</div>
			<?php
		}
	}
}

Alpha_GDPR::get_instance();


