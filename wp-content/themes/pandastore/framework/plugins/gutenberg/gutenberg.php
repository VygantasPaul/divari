<?php
/**
 * Gutenberg Compatibility
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

if ( is_admin() && ! is_customize_preview() ) {
	add_action( 'enqueue_block_editor_assets', 'alpha_enqueue_block_editor_assets', 999 );
}

if ( ! function_exists( 'alpha_enqueue_block_editor_assets' ) ) {
	function alpha_enqueue_block_editor_assets() {
		wp_enqueue_style( 'alpha-icons' );
		wp_enqueue_style( 'alpha-blocks-style-editor', alpha_framework_uri( '/plugins/gutenberg/gutenberg-editor' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ), ALPHA_VERSION );

		alpha_load_google_font();

		Alpha_Layout_Builder::get_instance()->setup_layout();

		ob_start();
		include alpha_framework_path( ALPHA_FRAMEWORK_PLUGINS . '/gutenberg/gutenberg-variable.php' );
		$output_style = ob_get_clean();

		if ( function_exists( 'alpha_minify_css' ) ) {
			$output_style = alpha_minify_css( $output_style );
		}

		wp_add_inline_style( 'alpha-blocks-style-editor', $output_style );
	}
}
