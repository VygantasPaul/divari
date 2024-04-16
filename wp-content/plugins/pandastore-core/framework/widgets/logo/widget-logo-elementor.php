<?php
/**
 * Alpha Header Elementor Logo
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Alpha_Logo_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_header_site_logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-logo';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'alpha', 'header', 'logo', 'site' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_logo_content',
			array(
				'label' => esc_html__( 'Image', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'logo_align',
			array(
				'label'     => esc_html__( 'Alignment', 'pandastore-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'.elementor-element-{{ID}}' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_logo_style',
			array(
				'label' => esc_html__( 'Image', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_logo' );

			$this->start_controls_tab(
				'tab_logo_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);

				$this->add_responsive_control(
					'logo_width',
					array(
						'label'      => esc_html__( 'Width', 'pandastore-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} .logo img' => 'width: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'logo_max_width',
					array(
						'label'      => esc_html__( 'Max Width', 'pandastore-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} .logo img' => 'max-width: {{SIZE}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_logo_sticky',
				array(
					'label' => esc_html__( 'In Sticky', 'pandastore-core' ),
				)
			);

				$this->add_responsive_control(
					'logo_width_sticky',
					array(
						'label'      => esc_html__( 'Width in Sticky', 'pandastore-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.fixed .elementor-element-{{ID}} .logo img' => 'width: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'logo_max_width_sticky',
					array(
						'label'      => esc_html__( 'Max Width in Sticky', 'pandastore-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.fixed .elementor-element-{{ID}} .logo img' => 'max-width: {{SIZE}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/logo/render-logo.php' );
	}
}
