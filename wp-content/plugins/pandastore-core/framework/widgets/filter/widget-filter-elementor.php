<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Filter Widget
 *
 * Alpha Widget to display filter for products.
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
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Alpha_Controls_Manager;

class Alpha_Filter_Elementor_Widget extends \Elementor\Widget_Base {
	public $attributes;

	public function get_name() {
		return ALPHA_NAME . '_widget_filter';
	}

	public function get_title() {
		return esc_html__( 'Filter', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-filter';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'filter', 'product', 'attribute', 'category', 'tag' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_filter_content',
			array(
				'label' => esc_html__( 'Filter', 'pandastore-core' ),
			)
		);

			$this->attributes = array();
			$taxonomies       = wc_get_attribute_taxonomies();
			$default_att      = '';

		if ( ! count( $taxonomies ) ) {
			$this->add_control(
				'sorry_desc',
				array(
					'description' => sprintf( esc_html__( 'Sorry, there are no product attributes available in this site. Click %1$shere%2$s to add attributes.', 'pandastore-core' ), '<a href="' . admin_url() . 'edit.php?post_type=product&page=product_attributes" target="blank">', '</a>' ),
					'type'        => Alpha_Controls_Manager::DESCRIPTION,
				)
			);

			$this->end_controls_section();

			return;
		}

		foreach ( $taxonomies as $key => $value ) {
			$this->attributes[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
			if ( ! $default_att ) {
				$default_att = 'pa_' . $value->attribute_name;
			}
		}

			$repeater = new Repeater();

				$repeater->add_control(
					'name',
					array(
						'label'   => esc_html__( 'Attribute', 'pandastore-core' ),
						'type'    => Controls_Manager::SELECT,
						'options' => $this->attributes,
						'default' => $default_att,
					)
				);

				$repeater->add_control(
					'query_opt',
					array(
						'label'   => esc_html__( 'Query Type', 'pandastore-core' ),
						'type'    => Controls_Manager::SELECT,
						'options' => array(
							'and' => esc_html__( 'AND', 'pandastore-core' ),
							'or'  => esc_html__( 'OR', 'pandastore-core' ),
						),
						'default' => 'or',
					)
				);

			$this->add_control(
				'attributes',
				array(
					'label'       => esc_html__( 'Product Attributes', 'pandastore-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'name'      => $default_att,
							'query_opt' => 'or',
						),
					),
					'title_field' => '{{{ name }}}',
				)
			);

			$this->add_control(
				'align',
				array(
					'label'   => esc_html__( 'Align', 'pandastore-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'options' => array(
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
				)
			);

			$this->add_control(
				'btn_label',
				array(
					'type'      => Controls_Manager::TEXT,
					'label'     => esc_html__( 'Filter Button Label', 'pandastore-core' ),
					'default'   => 'Filter',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'btn_skin',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Filter Button Skin', 'pandastore-core' ),
					'options' => array(
						'btn-primary'   => esc_html__( 'Primary', 'pandastore-core' ),
						'btn-secondary' => esc_html__( 'Secondary', 'pandastore-core' ),
						'btn-warning'   => esc_html__( 'Warning', 'pandastore-core' ),
						'btn-danger'    => esc_html__( 'Danger', 'pandastore-core' ),
						'btn-success'   => esc_html__( 'Success', 'pandastore-core' ),
						'btn-dark'      => esc_html__( 'Dark', 'pandastore-core' ),
						'btn-white'     => esc_html__( 'White', 'pandastore-core' ),
					),
					'default' => 'btn-primary',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filter_style',
			array(
				'label' => esc_html__( 'Filter Items', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'filter_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .select-ul-toggle',
				)
			);

			$this->add_control(
				'filter_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'filter_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'filter_responsive_padding',
				array(
					'label'      => esc_html__( 'Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'filter_width',
				array(
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
					'label'      => esc_html__( 'Width', 'pandastore-core' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .alpha-filter' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'filter_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 20,
							'max'  => 100,
						),
					),
					'label'      => esc_html__( 'Height', 'pandastore-core' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .alpha-filter, .elementor-element-{{ID}} .btn-filter' => 'height:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'filter_gap',
				array(
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
					),
					'label'      => esc_html__( 'Gap', 'pandastore-core' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .align-left > *' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .align-center > *' => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
						'.elementor-element-{{ID}} .align-right > *' => 'margin-left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'      => 'filter_bd',
					'selector'  => '.elementor-element-{{ID}} .select-ul-toggle',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'filter_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .btn-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style',
			array(
				'label' => esc_html__( 'Submit Button', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'btn_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .btn-filter',
				)
			);

			$this->add_responsive_control(
				'btn_width',
				array(
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 50,
							'max'  => 300,
						),
					),
					'label'      => esc_html__( 'Width', 'pandastore-core' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .btn-filter' => 'width: {{SIZE}}{{UNIT}}; padding: 0;',
					),
				)
			);

			$this->add_control(
				'btn_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .btn-filter' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn' );
				$this->start_controls_tab(
					'tab_btn_normal',
					array(
						'label' => esc_html__( 'Normal', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_btn_hover',
					array(
						'label' => esc_html__( 'Hover', 'pandastore-core' ),
					)
				);

					$this->add_control(
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg_color',
						array(
							'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bd_color',
						array(
							'label'     => esc_html__( 'Hover Border Color', 'pandastore-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/filter/render-filter.php' );
	}
}
