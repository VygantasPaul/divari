<?php
/**
 * Progressbars Element
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

class Alpha_Progressbars_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_progressbars';
	}

	public function get_title() {
		return esc_html__( 'Progress Bars', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-progressbar';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	/**
	 * Get script dependency
	 *
	 * @since 1.2.0
	 */
	public function get_script_depends() {
		wp_register_script( 'alpha-progress-bar', alpha_core_framework_uri( '/widgets/progressbars/progressbar' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-progress-bar' );
	}

	public function get_keywords() {
		return array( 'progress', 'bar' );
	}

	protected function _register_controls() {
		$left = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_progress',
			array(
				'label' => esc_html__( 'Progress Bars', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'text_pos',
			array(
				'label'   => esc_html__( 'Text Position', 'pandastore-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'outer',
				'options' => array(
					'inner' => esc_html__( 'Inner', 'pandastore-core' ),
					'outer' => esc_html__( 'Outer', 'pandastore-core' ),
				),
			)
		);
		$this->add_control(
			'display_percentage',
			array(
				'label'   => esc_html__( 'Display Percentage', 'pandastore-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'percentage_pos',
			array(
				'label'     => esc_html__( 'Percentage Position', 'pandastore-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''            => esc_html__( 'End of Bar', 'pandastore-core' ),
					'percent'     => esc_html__( 'End of Percent', 'pandastore-core' ),
					'after_title' => esc_html__( 'After Title', 'pandastore-core' ),
				),
				'condition' => array(
					'display_percentage' => 'yes',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'pandastore-core' ),
				'default'     => esc_html__( 'Performance', 'pandastore-core' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'progress_skin',
			array(
				'label'   => esc_html__( 'Skin', 'pandastore-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'   => esc_html__( 'Default', 'pandastore-core' ),
					'primary'   => esc_html__( 'Primary', 'pandastore-core' ),
					'secondary' => esc_html__( 'Secondary', 'pandastore-core' ),
					'dark'      => esc_html__( 'Dark', 'pandastore-core' ),
					'white'     => esc_html__( 'White', 'pandastore-core' ),
					'accent'    => esc_html__( 'Accent', 'pandastore-core' ),
					'success'   => esc_html__( 'Success', 'pandastore-core' ),
					'info'      => esc_html__( 'Info', 'pandastore-core' ),
					'warning'   => esc_html__( 'Warning', 'pandastore-core' ),
					'danger'    => esc_html__( 'Danger', 'pandastore-core' ),
				),
			)
		);

		$repeater->add_control(
			'percent',
			array(
				'label'   => esc_html__( 'Percentage', 'pandastore-core' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 50,
					'unit' => '%',
				),
			)
		);

		$this->add_control(
			'progressbars_list',
			array(
				'label'       => esc_html__( 'Progressbars', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'         => esc_html__( 'Performance', 'pandastore-core' ),
						'progress_skin' => 'default',
						'percent'       => array(
							'size' => 86,
							'unit' => '%',
						),
					),
					array(
						'title'         => esc_html__( 'Average Improvements', 'pandastore-core' ),
						'progress_skin' => 'default',
						'percent'       => array(
							'size' => 98,
							'unit' => '%',
						),
					),
					array(
						'title'         => esc_html__( 'Promotion', 'pandastore-core' ),
						'progress_skin' => 'default',
						'percent'       => array(
							'size' => 69,
							'unit' => '%',
						),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_control(
			'spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'pandastore-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .progress-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_progress_style',
			array(
				'label' => esc_html__( 'Progress Bar', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Effect', 'pandastore-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''           => esc_html__( 'None', 'pandastore-core' ),
					'indicating' => esc_html__( 'Indicating', 'pandastore-core' ),
					'animated'   => esc_html__( 'Animated', 'pandastore-core' ),
				),
			)
		);

		$this->add_control(
			'bar_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .progress-wrapper' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'bar_color',
				'selector'       => '.elementor-element-{{ID}} .progress-bar',
				'exclude'        => array( 'image' ),
				'fields_options' => array(
					'background' => array(
						'label' => esc_html__( 'Color Type', 'pandastore-core' ),
					),
				),
			)
		);

		$this->add_control(
			'bar_height',
			array(
				'label'     => esc_html__( 'Height', 'pandastore-core' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .progress-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .progress-wrapper .inner-text' => 'line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bar_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .progress-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bar_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .progress-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_heading',
			array(
				'label'     => esc_html__( 'Title', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Text Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .title',
			)
		);

		$this->add_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .title' => "margin-{$right}: {{SIZE}}{{UNIT}};",
				),
				'condition'  => array(
					'percentage_pos' => 'after_title',
				),
			)
		);

		$this->add_control(
			'percentage_heading',
			array(
				'label'     => esc_html__( 'Percentage', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'percentage_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .progress-percentage' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'percentage_typography',
				'selector' => '{{WRAPPER}} .progress-percentage',
			)
		);

		$this->end_controls_section();
	}

	protected function content_template() {
		?>
		<#
		var addClass = 'progress-bars';
		if ( settings.effect ) {
			addClass += ' progress-' + settings.effect;
		}
		if ( 'inner' == settings.text_pos ) {
			addClass += ' progress-inner-text';
		}
		if ( 'percent' == settings.percentage_pos ) {
			addClass += ' percent-end-progress';
		} else if ( 'after_title' == settings.percentage_pos ) {
			addClass += ' percent-end-title';
		} else {
			addClass += ' percent-end-bar';
		}
		#>
		<div class="{{{addClass}}}">
		<#
		_.each( settings.progressbars_list, function( item, index ) {
			var progress_percentage = 0;
			if ( ! isNaN( item.percent.size ) ) {
				progress_percentage = 100 < item.percent.size ? 100 : item.percent.size;
			}

			view.addRenderAttribute( 'title', {
				'class': 'title'
			} );

			var title_key = view.getRepeaterSettingKey( 'title', 'progressbars_list', index );
			view.addRenderAttribute( title_key, 'class', 'title' );
			view.addInlineEditingAttributes( title_key );

			view.addRenderAttribute( index, {
				'class': [ 'progress-wrapper', 'progress-' + item.progress_skin ],
				'data-value': progress_percentage,
			} );

			#>
			<# if ( 'outer' == settings.text_pos ) { 
				if ( 'yes' == settings.display_percentage ) {
					#>
				<div class="title-wrapper">
					<#
				}
				#>
					<span {{{ view.getRenderAttributeString( title_key ) }}}>{{{ item.title }}}</span><#
				if ( 'yes' == settings.display_percentage ) {#>
					<span class="progress-percentage">{{{ progress_percentage }}}%</span></div>
				<#}
			} #>
			<div {{{ view.getRenderAttributeString( index ) }}}>
				<div class="progress-bar">
					<# if ( 'inner' == settings.text_pos ) { #>
						<span {{{ view.getRenderAttributeString( title_key ) }}}>{{{ item.title }}}</span>
					<# } #>
					<# if ( 'yes' == settings.display_percentage && 'inner' == settings.text_pos ) { #>
						<span class="progress-percentage">{{{ progress_percentage }}}%</span>
					<# } #>
				</div>
			</div>
		<#
		} );
		#>
		</div>
		<?php
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require ALPHA_CORE_FRAMEWORK_PATH . '/widgets/progressbars/render-progressbars-elementor.php';
	}
}
