<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Button Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'share_buttons' => array(
				array(
					'site' => 'facebook',
					'link' => '',
				),
				array(
					'site' => 'twitter',
					'link' => '',
				),
				array(
					'site' => 'linkedin',
					'link' => '',
				),
			),
			'type'          => 'stacked',
			'custom_color'  => '',

			// For elementor inline editing
			'self'          => '',
		),
		$atts
	)
);
?>



<?php
