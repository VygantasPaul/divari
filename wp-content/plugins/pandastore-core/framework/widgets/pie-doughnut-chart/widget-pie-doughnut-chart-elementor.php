<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Pie-Doughnut Chart Widget
 *
 * Alpha Widget to display pie chart.
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Alpha_Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

class Alpha_Pie_Doughnut_Chart_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get a name of widget
	 *
	 * @since 1.0
	 */
	public function get_name() {
		return ALPHA_NAME . '_widget_pie_doughnut_chart';
	}


	/**
	 * Get a title of widget
	 *
	 * @since 1.0
	 */
	public function get_title() {
		return esc_html__( 'Pie & Doughnut Chart', 'pandastore-core' );
	}


	/**
	 * Get an icon of widget
	 *
	 * @since 1.0
	 */
	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-pie-chart';
	}


	/**
	 * Get categories of widget
	 *
	 * @since 1.0
	 */
	public function get_categories() {
		return array( 'alpha_widget' );
	}


	/**
	 * Get script dependency
	 *
	 * @since 1.0
	 */
	public function get_script_depends() {
		wp_register_script( 'alpha-pie-doughnut-chart', alpha_core_framework_uri( '/widgets/pie-doughnut-chart/pie-doughnut-chart' . ALPHA_JS_SUFFIX ), array( 'alpha-chart-lib' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-chart-lib', 'alpha-pie-doughnut-chart' );
	}


	/**
	 * Register Control
	 *
	 * @since 1.0
	 */
	public function _register_controls() {

		// Chart Layout
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Chart Layout', 'pandastore-core' ),
			)
		);
			$this->add_control(
				'chart_type',
				array(
					'label'   => esc_html__( 'Chart Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'pie',
					'options' => array(
						'pie'      => esc_html__( 'Pie', 'pandastore-core' ),
						'doughnut' => esc_html__( 'Doughnut', 'pandastore-core' ),
					),
				)
			);
		$this->end_controls_section();

		// Chart Data
		$this->start_controls_section(
			'section_data',
			array(
				'label' => esc_html__( 'Chart Data', 'pandastore-core' ),
			)
		);
			$repeater = new Repeater();

			$repeater->add_control(
				'label',
				array(
					'label'       => esc_html__( 'Label', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Set label of each bar chart', 'pandastore-core' ),
				)
			);
			$repeater->add_control(
				'data',
				array(
					'label' => esc_html__( 'Value', 'pandastore-core' ),
					'type'  => Controls_Manager::NUMBER,
				)
			);
			$repeater->add_control(
				'bg_color',
				array(
					'label'       => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
					'description' => esc_html__( 'Set background color of chart area', 'pandastore-core' ),
				)
			);
			$this->add_control(
				'chart_data',
				array(
					'label'       => esc_html__( 'Data', 'pandastore-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'label'        => esc_html__( 'Microsoft', 'pandastore-core' ),
							'data'         => esc_html__( '40', 'pandastore-core' ),
							'bg_color'     => '#ff5f15',
							'border_color' => '#ff5f15',
						),
						array(
							'label'        => esc_html__( 'Sumsung', 'pandastore-core' ),
							'data'         => esc_html__( '20', 'pandastore-core' ),
							'bg_color'     => '#ff9f73',
							'border_color' => '#ff9f73',
						),
						array(
							'label'        => esc_html__( 'Apple', 'pandastore-core' ),
							'data'         => esc_html__( '30', 'pandastore-core' ),
							'bg_color'     => '#ff9f73',
							'border_color' => '#ffd0ba',
						),
					),
					'title_field' => '{{{ label }}}',
				)
			);
		$this->end_controls_section();

		// Setting Section
		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Setting', 'pandastore-core' ),
			)
		);
			$this->add_control(
				'chart_legend_heading',
				array(
					'label' => esc_html__( 'Legend', 'pandastore-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);
			$this->add_control(
				'show_legend',
				array(
					'label'        => esc_html__( 'Show Legend', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			$this->add_control(
				'legend_position',
				array(
					'label'     => esc_html__( 'Position', 'pandastore-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'top',
					'options'   => array(
						'top'    => esc_html__( 'Top', 'pandastore-core' ),
						'left'   => esc_html__( 'Left', 'pandastore-core' ),
						'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
						'right'  => esc_html__( 'Right', 'pandastore-core' ),
					),
					'condition' => array(
						'show_legend' => 'true',
					),
				)
			);
			$this->add_control(
				'legend_reverse',
				array(
					'label'        => esc_html__( 'Reverse', 'pandastore-core' ),
					'description'  => esc_html__( 'Legend will show datasets in reverse order.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'true',
					'condition'    => array(
						'show_legend' => 'true',
					),
				)
			);
			$this->add_control(
				'animation_heading',
				array(
					'label'     => esc_html__( 'Animation', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			$this->add_control(
				'repeat_appear_animate',
				array(
					'label'        => esc_html__( 'Repeat Appear Animate', 'pandastore-core' ),
					'description'  => esc_html__( 'Apply animate whenever chart area enters in viewport', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			// $this->add_control(
			// 	'chart_animation_duration',
			// 	array(
			// 		'label'      => esc_html__( 'Duration', 'pandastore-core' ),
			// 		'type'       => Controls_Manager::SLIDER,
			// 		'size_units' => array( 'ms' ),
			// 		'range'      => array(
			// 			'ms' => array(
			// 				'min' => 100,
			// 				'max' => 3000,
			// 			),
			// 		),
			// 		'default'    => array(
			// 			'unit' => 'ms',
			// 		),
			// 	)
			// );

			// $animation_easing = array(
			// 	'linear',
			// 	'easeInQuad',
			// 	'easeOutQuad',
			// 	'easeInOutQuad',
			// 	'easeInCubic',
			// 	'easeOutCubic',
			// 	'easeInOutCubic',
			// 	'easeInQuart',
			// 	'easeOutQuart',
			// );
			// $this->add_control(
			// 	'chart_animation_easing',
			// 	array(
			// 		'label'   => esc_html__( 'Easing', 'pandastore-core' ),
			// 		'type'    => Controls_Manager::SELECT,
			// 		'default' => 'easeOutQuart',
			// 		'options' => array_combine( $animation_easing, $animation_easing ),
			// 	)
			// );
			// $this->add_control(
			// 	'chart_animate_scale',
			// 	array(
			// 		'label'        => esc_html__( 'Animate Scale', 'pandastore-core' ),
			// 		'description'  => esc_html__( 'If yes, will animate scaling the chart from the center outwards.', 'pandastore-core' ),
			// 		'type'         => Controls_Manager::SWITCHER,
			// 		'default'      => '',
			// 		'return_value' => 'true',
			// 	)
			// );
			$this->add_control(
				'tooltip_heading',
				array(
					'label'     => esc_html__( 'Tooltip', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			$this->add_control(
				'show_tooltip',
				array(
					'label'        => esc_html__( 'Show Tooltip?', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
		$this->end_controls_section();

		// Styles Tab
		$this->start_controls_section(
			'section_chart_general_style',
			array(
				'label' => esc_html__( 'Chart', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_responsive_control(
				'chart_height',
				array(
					'label'     => esc_html__( 'Height of Chart Area' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 400,
							'max' => 1200,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .pie-doughnut-chart-container' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);
			$this->add_control(
				'chart_cutout_percentage',
				array(
					'label'       => esc_html__( 'Cutout Percentage', 'pandastore-core' ),
					'description' => esc_html__( 'The percentage of the chart that is cut out of the middle.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( '%' ),
					'range'       => array(
						'%' => array(
							'min' => 0,
							'max' => 99,
						),
					),
					'default'     => array(
						'unit' => '%',
					),
					'condition'   => array(
						'chart_type' => 'pie',
					),
				)
			);
			$this->add_control(
				'chart_border_width',
				array(
					'label' => esc_html__( 'Border Width', 'pandastore-core' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => array(
						'px' => array(
							'min' => 0,
							'max' => 10,
						),
					),
				)
			);
			$this->add_control(
				'chart_border_color',
				array(
					'label' => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'  => Controls_Manager::COLOR,
				)
			);
		$this->end_controls_section();

		// Legend
		$this->start_controls_section(
			'section_chart_legend_stylel',
			array(
				'label'     => esc_html__( 'Legend', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_legend' => 'true',
				),
			)
		);
			$this->add_control(
				'legend_font_family',
				array(
					'label'   => esc_html__( 'Font Family', 'pandastore-core' ),
					'type'    => Controls_Manager::FONT,
					'default' => '',
				)
			);
			$this->add_control(
				'legend_font_size',
				array(
					'label' => esc_html__( 'Font Size', 'pandastore-core' ),
					'type'  => Controls_Manager::NUMBER,
				)
			);

			$typo_weight_options = array(
				'' => esc_html__( 'Default', 'pandastore-core' ),
			);

		foreach ( array_merge( [ 'normal', 'bold' ], range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

			$this->add_control(
				'legend_font_weight',
				array(
					'label'   => esc_html__( 'Font Weight', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => $typo_weight_options,
				)
			);
			$this->add_control(
				'legend_font_style',
				array(
					'label'   => esc_html__( 'Font Style', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => esc_html__( 'Default', 'pandastore-core' ),
						'normal'  => esc_attr_x( 'Normal', 'Typography Control', 'pandastore-core' ),
						'italic'  => esc_attr_x( 'Italic', 'Typography Control', 'pandastore-core' ),
						'oblique' => esc_attr_x( 'Oblique', 'Typography Control', 'pandastore-core' ),
					),
				)
			);
			$this->add_control(
				'legend_font_color',
				array(
					'label' => esc_html__( 'Font Color', 'pandastore-core' ),
					'type'  => Controls_Manager::COLOR,
				)
			);
		$this->end_controls_section();
	}


	/**
	 * Get chart data.
	 *
	 * @since 1.0
	 * @return array
	 */
	public function get_chart_data() {
		$settings = $this->get_settings_for_display();

		$data = array(
			'datasets' => array(
				array(
					'data'            => array(),
					'backgroundColor' => array(),
				),
			),
			'labels'   => array(),
		);

		$chart_data = $settings['chart_data'];

		foreach ( $chart_data as $item_data ) {
			$data['datasets'][0]['data'][]            = ! empty( $item_data['data'] ) ? $item_data['data'] : '';
			$data['datasets'][0]['backgroundColor'][] = ! empty( $item_data['bg_color'] ) ? alpha_rgba_hex_2_rgba_func( $item_data['bg_color'] ) : '#ffffff';
			$data['labels'][]                         = ! empty( $item_data['label'] ) ? $item_data['label'] : '';
		}

		$data['datasets'][0]['borderWidth']      = ( isset( $settings['chart_border_width']['size'] ) && '' !== $settings['chart_border_width']['size'] ) ? $settings['chart_border_width']['size'] : 1;
		$data['datasets'][0]['borderColor']      = ! empty( $settings['chart_border_color'] ) ? alpha_rgba_hex_2_rgba_func( $settings['chart_border_color'] ) : '#ffffff';
		$data['datasets'][0]['hoverBorderColor'] = ! empty( $settings['chart_border_color'] ) ? alpha_rgba_hex_2_rgba_func( $settings['chart_border_color'] ) : '#ffffff';

		return $data;
	}


	/**
	 * Get Chart Options
	 *
	 * @return array
	 */
	public function get_chart_options() {
		$settings = $this->get_settings_for_display();

		$show_legend  = filter_var( $settings['show_legend'], FILTER_VALIDATE_BOOLEAN );
		$show_tooltip = filter_var( $settings['show_tooltip'], FILTER_VALIDATE_BOOLEAN );
		$show_tooltip = filter_var( $settings['show_tooltip'], FILTER_VALIDATE_BOOLEAN );

		$options = array(
			'tooltips'            => array(
				'enabled' => $show_tooltip,
			),
			'legend'              => array(
				'display'  => $show_legend,
				'position' => ! empty( $settings['legend_position'] ) ? $settings['legend_position'] : 'top',
				'reverse'  => filter_var( $settings['legend_reverse'], FILTER_VALIDATE_BOOLEAN ),
			),
			'maintainAspectRatio' => false,
			'tooltip'             => array(
				'enabled' => $show_tooltip,
			),
		);

		$legend_style = array();

		$legend_style_dictionary = array(
			'fontFamily' => 'legend_font_family',
			'fontSize'   => 'legend_font_size',
			'fontStyle'  => array( 'legend_font_style', 'legend_font_weight' ),
			'fontColor'  => 'legend_font_color',
		);

		if ( $show_legend ) {

			foreach ( $legend_style_dictionary as $style_property => $setting_name ) {

				if ( is_array( $setting_name ) ) {
					$style_value = $this->get_font_styles( $setting_name );

					if ( ! empty( $style_value ) ) {
						$legend_style[ $style_property ] = $style_value;
					}
				} else {
					if ( ! empty( $settings[ $setting_name ] ) ) {
						if ( is_array( $settings[ $setting_name ] ) ) {
							if ( ! empty( $settings[ $setting_name ]['size'] ) ) {
								$legend_style[ $style_property ] = $settings[ $setting_name ]['size'];
							}
						} else {
							$legend_style[ $style_property ] = $settings[ $setting_name ];
						}
					}
				}
			}

			if ( ! empty( $legend_style ) ) {
				$options['legend']['labels'] = $legend_style;
			}
		}

		if ( ! empty( $settings['chart_cutout_percentage']['size'] ) ) {
			$options['cutoutPercentage'] = $settings['chart_cutout_percentage']['size'];
		}

		return $options;
	}


	/**
	 * Get font style string.
	 *
	 * @param array $settings_names Settings names.
	 *
	 * @return string
	 */
	public function get_font_styles( $settings_names = array() ) {
		if ( ! is_array( $settings_names ) ) {
			return '';
		}

		$settings = $this->get_settings_for_display();

		$font_styles = array();

		foreach ( $settings_names as $setting_name ) {
			if ( ! empty( $settings[ $setting_name ] ) ) {
				$font_styles[] = $settings[ $setting_name ];
			}
		}

		if ( empty( $font_styles ) ) {
			return '';
		}

		$font_styles = array_unique( $font_styles );

		return join( ' ', $font_styles );
	}


	/**
	 * Render Widget
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function render() {
		$settings     = $this->get_settings_for_display();
		$data_chart   = $this->get_chart_data();
		$data_options = $this->get_chart_options();
		$canvas_class = 'pie-doughnut-chart chart';
		$chart_type   = $settings['chart_type'];

		if ( 'true' == $settings['repeat_appear_animate'] ) {
			$canvas_class .= ' repeat-appear-animate';
		}

		$this->add_render_attribute(
			[
				'container' => array(
					'class'        => 'pie-doughnut-chart-container chart-container',
					'data-chart'   => esc_attr( json_encode( $data_chart ) ),
					'data-options' => esc_attr( json_encode( $data_options ) ),
					'data-type'    => esc_attr( $chart_type ),
				),
				'canvas'    => array(
					'class' => $canvas_class,
					'role'  => 'img',
				),
			]
		);

		?>
		<div <?php $this->print_render_attribute_string( 'container' ); ?>>
			<canvas <?php $this->print_render_attribute_string( 'canvas' ); ?>></canvas>
		</div>
		<?php
	}
}
