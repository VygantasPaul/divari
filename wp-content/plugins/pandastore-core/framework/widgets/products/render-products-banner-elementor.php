<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Products Banner Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_insert'        => '',
			'layout_type'          => 'grid',
			'creative_cols'        => '',
			'creative_cols_tablet' => '',
			'creative_cols_mobile' => '',
			'items_list'           => '',
		),
		$atts
	)
);

if ( is_array( $items_list ) ) {
	$repeater_ids = array();
	foreach ( $items_list as $item ) {
		$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];
	}
	wc_set_loop_prop( 'repeater_ids', $repeater_ids );
}
$GLOBALS['alpha_current_product_id'] = 0;

ob_start();
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/banner/render-banner-elementor.php' );
$banner_html = ob_get_clean();

wc_set_loop_prop( 'product_banner', $banner_html );
wc_set_loop_prop( 'banner_insert', $banner_insert );

alpha_products_widget_render( $atts );

if ( isset( $GLOBALS['alpha_current_product_id'] ) ) {
	unset( $GLOBALS['alpha_current_product_id'] );
}
