<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Elementor Shop Show Type Widget
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;

class Alpha_Shop_Show_Type_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_shop_widget_show_type';
	}

	public function get_title() {
		return esc_html__( 'Grid / List Toggle', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_shop_widget' );
	}

	public function get_keywords() {
		return array( 'show-type', 'grid', 'list', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-apps';
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		$left = is_rtl() ? 'right' : 'left';

		$this->start_controls_section(
			'section_show_type',
			array(
				'label' => esc_html__( 'Item Space', 'alpha_core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'item_space',
				array(
					'label'       => esc_html__( 'Item Spacing', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 10,
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .btn-showtype + .btn-showtype' => "margin-{$left}: {{SIZE}}px",
					),
					'description' => esc_html__( 'Adjust spacing between each show type buttons.', 'pandastore-core' ),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		if ( apply_filters( 'alpha_shop_builder_set_preview', false ) ) {
			alpha_wc_shop_show_type();
		}
		do_action( 'alpha_shop_builder_unset_preview' );
	}

	protected function content_template() {}
}
