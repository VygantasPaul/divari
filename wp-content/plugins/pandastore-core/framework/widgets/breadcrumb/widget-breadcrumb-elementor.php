<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Breadcrumb Widget
 *
 * Alpha Widget to display WC breadcrumb.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Breadcrumb_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_breadcrumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-breadcrumb';
	}

	public function get_keywords() {
		return array( 'breadcrumb', 'alpha' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_breadcrumb',
			array(
				'label' => esc_html__( 'Breadcrumb', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'delimiter',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Breadcrumb Delimiter', 'pandastore-core' ),
					'placeholder' => esc_html__( '/', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'delimiter_icon',
				array(
					'label' => esc_html__( 'Delimiter Icon', 'pandastore-core' ),
					'type'  => Controls_Manager::ICONS,
				)
			);

			$this->add_control(
				'home_icon',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Show Home Icon', 'pandastore-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_breadcrumb_style',
			array(
				'label' => esc_html__( 'Breadcrumb Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'breadcrumb_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .breadcrumb',
				)
			);

			$this->add_responsive_control(
				'align',
				array(
					'label'     => esc_html__( 'Align', 'pandastore-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .breadcrumb' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_link_col' );
				$this->start_controls_tab(
					'tab_link_col',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'link_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_link_col_active',
					array(
						'label' => esc_html__( 'Active', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'link_color_active',
						array(
							'label'     => esc_html__( 'Active Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'opacity: 1;',
								'.elementor-element-{{ID}} .breadcrumb a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'delimiter_size',
				array(
					'label'      => esc_html__( 'Delimiter Size', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .delimiter' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units' => array(
						'px',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .delimiter' => 'margin: 0 {{SIZE}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/breadcrumb/render-breadcrumb.php' );
	}

	protected function content_template() {}
}
