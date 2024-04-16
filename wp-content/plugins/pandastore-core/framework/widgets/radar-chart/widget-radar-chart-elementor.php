<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Radar Chart Widget
 *
 * Alpha Widget to display Radar chart.
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

class Alpha_Radar_Chart_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get a name of widget
	 *
	 * @since 1.0
	 */
	public function get_name() {
		return ALPHA_NAME . '_widget_radar_chart';
	}


	/**
	 * Get a title of widget
	 *
	 * @since 1.0
	 */
	public function get_title() {
		return esc_html__( 'Radar Chart', 'pandastore-core' );
	}


	/**
	 * Get an icon of widget
	 *
	 * @since 1.0
	 */
	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-radar-chart';
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
		wp_register_script( 'alpha-radar-chart', alpha_core_framework_uri( '/widgets/radar-chart/radar-chart' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-chart-lib', 'alpha-radar-chart' );
	}


	/**
	 * Register Control
	 *
	 * @since 1.0
	 */
	public function _register_controls() {

		// Dataset section
		$this->start_controls_section(
			'section_dataset',
			array(
				'label' => esc_html__( 'Chart Dataset', 'pandastore-core' ),
			)
		);
			$ds_repeater = new Repeater();

			$ds_repeater->add_control(
				'dataset_label',
				array(
					'label'       => esc_html__( 'Label', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'This will be the label of legend in Radar chart', 'pandastore-core' ),
				)
			);

			$ds_repeater->add_control(
				'dataset_bg_color',
				array(
					'label'       => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
					'description' => esc_html__( 'Set background color of dataset in Radar chart', 'pandastore-core' ),
				)
			);
			$ds_repeater->add_control(
				'dataset_border_color',
				array(
					'label'       => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
					'description' => esc_html__( 'Set border color of dataset in Radar chart', 'pandastore-core' ),
				)
			);
			$ds_repeater->add_control(
				'dataset_border_width',
				array(
					'label'       => esc_html__( 'Border Width', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Set border width of dataset in Radar chart', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'chart_dataset',
				array(
					'label'       => esc_html__( 'Data Set', 'pandastore-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $ds_repeater->get_controls(),
					'default'     => array(
						array(
							'dataset_label'        => esc_html__( 'Series 1', 'pandastore-core' ),
							'dataset_bg_color'     => 'rgba(248,248,248,0.7)',
							'dataset_border_color' => 'rgba(220,220,220,1)',
						),
						array(
							'dataset_label'        => esc_html__( 'Series 2', 'pandastore-core' ),
							'dataset_bg_color'     => 'rgba(234,241,245,0.7)',
							'dataset_border_color' => 'rgba(151,187,205,1)',
						),
					),
					'title_field' => '{{{ dataset_label }}}',
				)
			);

		$this->end_controls_section();

		// Detailed Data
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
					'description' => esc_html__( 'Set label of each axis', 'pandastore-core' ),
				)
			);
			$repeater->add_control(
				'data',
				array(
					'label'       => esc_html__( 'Value', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Enter multiple values according to the number of datasets separated by comma(,) without whitespace. Example: if you have 2 datasets, input two values, 40, 45. First will be the value of dataset 1, and second is the one for dataset 2', 'pandastore-core' ),
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
							'label' => esc_html__( 'Microsoft', 'pandastore-core' ),
							'data'  => esc_html__( '40,50', 'pandastore-core' ),
						),
						array(
							'label' => esc_html__( 'Sumsung', 'pandastore-core' ),
							'data'  => esc_html__( '20,30', 'pandastore-core' ),
						),
						array(
							'label' => esc_html__( 'Apple', 'pandastore-core' ),
							'data'  => esc_html__( '30,25', 'pandastore-core' ),
						),
						array(
							'label' => esc_html__( 'IBM', 'pandastore-core' ),
							'data'  => esc_html__( '10,60', 'pandastore-core' ),
						),
						array(
							'label' => esc_html__( 'Benq', 'pandastore-core' ),
							'data'  => esc_html__( '30,40', 'pandastore-core' ),
						),
						array(
							'label' => esc_html__( 'Huawei', 'pandastore-core' ),
							'data'  => esc_html__( '30,60', 'pandastore-core' ),
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
						'.elementor-element-{{ID}} .radar-chart-container' => 'height: {{SIZE}}{{UNIT}};',
					),
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

		$datum = array();

		$chart_dataset = $settings['chart_dataset'];
		$chart_data    = $settings['chart_data'];
		$i             = 0;

		foreach ( $chart_dataset as $dataset ) {
			$data = array(
				'label'           => '',
				'data'            => array(),
				'backgroundColor' => '',
				'borderWidth'     => 1,
				'borderColor'     => '',
			);

			$data['label']           = ! empty( $dataset['dataset_label'] ) ? $dataset['dataset_label'] : '';
			$data['backgroundColor'] = ! empty( $dataset['dataset_bg_color'] ) ? alpha_rgba_hex_2_rgba_func( $dataset['dataset_bg_color'] ) : '#fff';
			$data['borderColor']     = ! empty( $dataset['dataset_border_color'] ) ? alpha_rgba_hex_2_rgba_func( $dataset['dataset_border_color'] ) : '';
			$data['borderWidth']     = ! empty( $dataset['dataset_border_width']['size'] ) ? $dataset['dataset_border_width']['size'] : 1;

			foreach ( $chart_data as $item ) {
				$data['data'][] = ! empty( $item['data'] ) ? floatval( explode( ',', $item['data'] )[ $i ] ) : '';
			}

			$datum['datasets'][] = $data;
			$i++;
		}

		foreach ( $chart_data as $item ) {
			$datum['labels'][] = ! empty( $item['label'] ) ? $item['label'] : '';
		}

		return $datum;
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
		$canvas_class = 'radar-chart chart';

		if ( 'true' == $settings['repeat_appear_animate'] ) {
			$canvas_class .= ' repeat-appear-animate';
		}

		$this->add_render_attribute(
			[
				'container' => array(
					'class'        => 'radar-chart-container chart-container',
					'data-chart'   => esc_attr( json_encode( $data_chart ) ),
					'data-options' => esc_attr( json_encode( $data_options ) ),
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
