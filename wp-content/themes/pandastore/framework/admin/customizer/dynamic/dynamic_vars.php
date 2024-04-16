<?php
/**
 * Dynamic vars
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/customizer/dynamic/dynamic-color-lib.php' );

$style = 'html {' . PHP_EOL;

// /* Basic Layout */
$style .= '--alpha-container-width: ' . alpha_get_option( 'container' ) . 'px;
			--alpha-container-fluid-width: ' . alpha_get_option( 'container_fluid' ) . 'px;' . PHP_EOL;

$site_type = alpha_get_option( 'site_type' );
if ( 'full' != $site_type ) {
	$style .= alpha_dynamic_vars_bg( 'site', alpha_get_option( 'site_bg' ) );
	$style .= '--alpha-site-width: ' . alpha_get_option( 'site_width' ) . 'px;
				--alpha-site-margin: ' . '0 auto;' . PHP_EOL;

	if ( 'boxed' == $site_type ) {
		$style .= '--alpha-site-gap: ' . '0 ' . alpha_get_option( 'site_gap' ) . 'px;' . PHP_EOL;
	} else {
		$style .= '--alpha-site-gap: ' . alpha_get_option( 'site_gap' ) . 'px;' . PHP_EOL;
	}
} else {
	$style .= alpha_dynamic_vars_bg( 'site', array( 'background-color' => '#fff' ) );
	$style .= '--alpha-site-width: false;
				--alpha-site-margin: 0;
				--alpha-site-gap: 0;' . PHP_EOL;
}

/* Color & Typography */
$style .= '--alpha-primary-color: ' . alpha_get_option( 'primary_color' ) . ';
			--alpha-secondary-color: ' . alpha_get_option( 'secondary_color' ) . ';
			--alpha-dark-color: ' . alpha_get_option( 'dark_color' ) . ';
			--alpha-light-color: ' . alpha_get_option( 'light_color' ) . ';
			--alpha-white-color: ' . alpha_get_option( 'white_color' ) . ';
			--alpha-primary-color-hover: ' . AlphaColorLib::lighten( alpha_get_option( 'primary_color' ), 6.7 ) . ';' . PHP_EOL;

$p_color_rgb = AlphaColorLib::hexToRGB( alpha_get_option( 'primary_color' ), false );
$style      .= '--alpha-primary-color-alpha: rgba(' . $p_color_rgb[0] . ',' . $p_color_rgb[1] . ',' . $p_color_rgb[2] . ', 0.8);' . PHP_EOL;

$style .= '--alpha-secondary-color-hover: ' . AlphaColorLib::lighten( alpha_get_option( 'secondary_color' ), 6.7 ) . ';
			--alpha-dark-color-hover: ' . AlphaColorLib::lighten( alpha_get_option( 'dark_color' ), 6.7 ) . ';
			--alpha-light-color-hover: ' . AlphaColorLib::lighten( alpha_get_option( 'light_color' ), 6.7 ) . ';' . PHP_EOL;
$style      .= '--alpha-border-radius-form: 3px;' . PHP_EOL;
$style    .= alpha_dynamic_vars_typo( 'body', alpha_get_option( 'typo_default' ) );
$body_size = alpha_get_option( 'typo_default' )['font-size'];
if ( false !== strpos( $body_size, 'rem' ) || false !== strpos( $body_size, 'em' ) ) {
	$body_size = intval( str_replace( array( 'rem', 'em' ), '', $body_size ) ) * 10;
} else {
	$body_size = intval( preg_replace( '/[a~zA~Z]/', '', $body_size ) );
}

$style .= '--alpha-typo-ratio: ' . floatval( $body_size / 14 ) . ';' . PHP_EOL;
$style .= alpha_dynamic_vars_typo( 'heading', alpha_get_option( 'typo_heading' ), array( 'font-weight' => 600 ) );
$style .= PHP_EOL . '}' . PHP_EOL;

$style .= '.page-wrapper {' . PHP_EOL;
$style .= alpha_dynamic_vars_bg( 'page-wrapper', alpha_get_option( 'content_bg' ) );
$style .= PHP_EOL . '}' . PHP_EOL;
/* PTB */
$style .= '.page-header {' . PHP_EOL;
$style .= alpha_dynamic_vars_bg( 'ptb', alpha_get_option( 'ptb_bg' ) );
$style .= PHP_EOL . '}' . PHP_EOL;
$style .= '.page-header .page-title {' . PHP_EOL;
$style .= alpha_dynamic_vars_typo( 'ptb-title', alpha_get_option( 'typo_ptb_title' ) );
$style .= PHP_EOL . '}' . PHP_EOL;
$style .= '.page-header .page-subtitle {' . PHP_EOL;
$style .= alpha_dynamic_vars_typo( 'ptb-subtitle', alpha_get_option( 'typo_ptb_subtitle' ) );
$style .= PHP_EOL . '}' . PHP_EOL;
$style .= '.page-title-bar {' . PHP_EOL;
$style .= '--alpha-ptb-height: ' . alpha_get_option( 'ptb_height' ) . 'px;' . PHP_EOL;
$style .= PHP_EOL . '}' . PHP_EOL;
$style .= '.breadcrumb {' . PHP_EOL;
$style .= alpha_dynamic_vars_typo( 'ptb-breadcrumb', alpha_get_option( 'typo_ptb_breadcrumb' ) );
$style .= PHP_EOL . '}' . PHP_EOL;

/* LazyLoad */
$style .= '.d-lazyload {' . PHP_EOL;
$style .= '--alpha-lazy-load-bg: ' . alpha_get_option( 'lazyload_bg' ) . ';' . PHP_EOL;
$style .= PHP_EOL . '}' . PHP_EOL;

/* alpha gap */
$style .= '.elementor-section {' . PHP_EOL;
$style .= '--alpha-gap: ' . ALPHA_GAP . ';' . PHP_EOL;
$style .= PHP_EOL . '}' . PHP_EOL;
/* Responsive */
$style .= '@media (max-width: ' . ( (int) alpha_get_option( 'container' ) - 1 ) . 'px) {
    .container-fluid .container {
        padding-left: 0;
        padding-right: 0;
    }
}' . PHP_EOL;

$style .= '@media (max-width: ' . ( (int) alpha_get_option( 'container' ) - 1 ) . 'px) and (min-width: 480px) {
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-no,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-no {
		width: calc(100% - var(--alpha-gap) * 4);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-default,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-default {
		width: calc(100% - var(--alpha-gap) * 2);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-narrow,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-narrow {
		width: calc(100% - var(--alpha-gap) * 4 + 10px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-extended,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-extended {
		width: calc(100% - var(--alpha-gap) * 4 + 30px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wide,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wide {
		width: calc( 100% - var(--alpha-gap) * 4 + 40px );
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wider,
	.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wider {
		width: calc( 100% - var(--alpha-gap) * 4 + 50px );
	}
}' . PHP_EOL;

$style .= '@media (max-width: ' . ( (int) alpha_get_option( 'container_fluid' ) - 1 ) . 'px) and (min-width: 480px) {
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-no.container-fluid {
		width: calc(100% - 40px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-default.container-fluid {
		width: calc(100% + 2 * var(--alpha-gap) - 40px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-narrow.container-fluid {
		width: calc(100% - 30px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-extended.container-fluid {
		width: calc(100% - 10px);
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wide.container-fluid {
		width: 100%;
	}
	.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wider.container-fluid {
		width: calc(100% + 10px);
	}
}' . PHP_EOL;

echo preg_replace( '/[\t]+/', '', apply_filters( 'alpha_dynamic_style', $style ) );
