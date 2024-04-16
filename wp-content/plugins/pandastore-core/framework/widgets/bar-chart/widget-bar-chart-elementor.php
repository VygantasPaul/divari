<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Bar Chart Widget
 *
 * Alpha Widget to display bar chart.
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

class Alpha_Bar_Chart_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get a name of widget
	 *
	 * @since 1.0
	 */
	public function get_name() {
		return ALPHA_NAME . '_widget_bar_chart';
	}


	/**
	 * Get a title of widget
	 *
	 * @since 1.0
	 */
	public function get_title() {
		return esc_html__( 'Bar Chart', 'pandastore-core' );
	}


	/**
	 * Get an icon of widget
	 *
	 * @since 1.0
	 */
	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-bar-chart';
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
		wp_register_script( 'alpha-bar-chart', alpha_core_framework_uri( '/widgets/bar-chart/bar-chart' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-chart-lib', 'alpha-bar-chart' );
	}


	/**
	 * Register Control
	 *
	 * @since 1.0
	 */
	public function _register_controls() {

		// Layout Section
		$this->start_controls_section(
			'section_bar_chart_layout',
			array(
				'label' => esc_html__( 'Chart Layout', 'pandastore-core' ),
			)
		);
			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Chart Type', 'pandastore-core' ),
					'description' => esc_html__( 'Select chart type.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'bar',
					'options'     => array(
						'bar'           => esc_html__( 'Vertical', 'pandastore-core' ),
						'horizontalBar' => esc_html__( 'Horizontal', 'pandastore-core' ),
					),
				)
			);

			// $this->add_control(
			// 	'title',
			// 	array(
			// 		'label'   => esc_html__( 'Title', 'pandastore-core' ),
			// 		'type'    => Controls_Manager::TEXT,
			// 		'default' => esc_html__( 'Bar Chart', 'pandastore-core' ),
			// 	)
			// );
		$this->end_controls_section();

		// Chart Data Section
		$this->start_controls_section(
			'section_data',
			array(
				'label' => esc_html__( 'Chart Data', 'pandastore-core' ),
			)
		);
			$this->add_control(
				'data_axis_label',
				array(
					'label'       => esc_html__( 'Data Labels', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Jan, Feb, Mar', 'pandastore-core' ),
					'description' => esc_html__( 'Set labels of data axis. Write multiple labels separated by comma(,). Example: Jan, Feb, Mar', 'pandastore-core' ),

				)
			);
			$this->add_control(
				'data_value_range',
				array(
					'label'       => esc_html__( 'Data Axis Range', 'pandastore-core' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 10,
					'description' => esc_html__( 'Set maximum value of range that can be set for the data value', 'pandastore-core' ),
				)
			);
			$this->add_control(
				'data_value_step',
				array(
					'label'       => esc_html__( 'Data Axis Unit', 'pandastore-core' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 1,
					'description' => esc_html__( 'Set scale of the axis to show data value', 'pandastore-core' ),
				)
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs( 'bar_chart_tabs' );
				$repeater->start_controls_tab(
					'content_tab',
					array(
						'label' => esc_html__( 'Content', 'pandastore-core' ),
					)
				);
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
							'label'       => esc_html__( 'Value', 'pandastore-core' ),
							'type'        => Controls_Manager::TEXT,
							'description' => esc_html__( 'Enter data value separated by comma(,). Example: 2, 4, 6', 'pandastore-core' ),
						)
					);
					// $repater->add_control(
					// 	'chart_point_style',
					// 	array(
					// 		'label'     => esc_html__( 'Pointer Style', 'pandastore-core' ),
					// 		'type'      => Controls_Manager::SELECT,
					// 		'default'   => 'circle',
					// 		'options'   => array(
					// 			'circle' => esc_html__( 'Circle', 'pandastore-core' ),
					// 			'cross'  => esc_html__( 'Cross', 'pandastore-core' ),
					// 			'square' => esc_html__( 'Square', 'pandastore-core' ),
					// 			'star'   => esc_html__( 'Star', 'pandastore-core' ),
					// 		),
					// 	)
					// );
				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'style_tab',
					array(
						'label' => esc_html__( 'Style', 'pandastore-core' ),
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
					$repeater->add_control(
						'bg_hover_color',
						array(
							'label'       => esc_html__( 'Background Hover Color', 'pandastore-core' ),
							'type'        => Controls_Manager::COLOR,
							'description' => esc_html__( 'Set background hover color of chart area', 'pandastore-core' ),
						)
					);
					$repeater->add_control(
						'border_color',
						array(
							'label'       => esc_html__( 'Border Color', 'pandastore-core' ),
							'type'        => Controls_Manager::COLOR,
							'description' => esc_html__( 'Set border color of chart area', 'pandastore-core' ),
						)
					);
					$repeater->add_control(
						'border_hover_color',
						array(
							'label' => esc_html__( 'Border Hover Color', 'pandastore-core' ),
							'type'  => Controls_Manager::COLOR,
						)
					);
				$repeater->end_controls_tab();
			$repeater->end_controls_tab();
			$this->add_control(
				'chart_data',
				array(
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'label'              => esc_html__( 'Microsoft', 'pandastore-core' ),
							'data'               => esc_html__( '3, 4, 8', 'pandastore-core' ),
							'bg_color'           => 'rgba(221,75,57,0.4)',
							'bg_hover_color'     => '#dd4b39',
							'border_color'       => '#dd4b39',
							'border_hover_color' => '#dd4b39',
						),
						array(
							'label'              => esc_html__( 'Sumsung', 'pandastore-core' ),
							'data'               => esc_html__( '4, 5, 3', 'pandastore-core' ),
							'bg_color'           => 'rgba(59,89,152,0.4)',
							'bg_hover_color'     => '#3b5998',
							'border_color'       => '#3b5998',
							'border_hover_color' => '#3b5998',
						),
						array(
							'label'              => esc_html__( 'Apple', 'pandastore-core' ),
							'data'               => esc_html__( '5, 9, 5', 'pandastore-core' ),
							'bg_color'           => 'rgba(85,172,238,0.4)',
							'bg_hover_color'     => '#55acee',
							'border_color'       => '#55acee',
							'border_hover_color' => '#55acee',
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
				'show_grid',
				array(
					'label'        => esc_html__( 'Show Grid Line', 'pandastore-core' ),
					'description'  => esc_html__( 'Determines whether grid(guide) lines are shown or not.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			$this->add_control(
				'show_label',
				array(
					'label'        => esc_html__( 'Show Label', 'pandastore-core' ),
					'description'  => esc_html__( 'Choose whether labels should be displayed. Default currently set to Yes.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			$this->add_control(
				'show_tooltip',
				array(
					'label'        => esc_html__( 'Show Tooltip', 'pandastore-core' ),
					'description'  => esc_html__( 'Choose whether tooltips should be displayed on hover. Default currently set to Yes.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			$this->add_control(
				'chart_legend_heading',
				array(
					'label'     => esc_html__( 'Legend', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			$this->add_control(
				'show_legend',
				array(
					'label'        => esc_html__( 'Show Legend', 'pandastore-core' ),
					'description'  => esc_html__( 'Choose whether legend should be displayed. Default currently set to Yes.', 'pandastore-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'true',
					'return_value' => 'true',
				)
			);
			$this->add_control(
				'legend_position',
				array(
					'label'       => esc_html__( 'Position', 'pandastore-core' ),
					'description' => esc_html__( 'Set chart legend position. Default currently set to Top.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'top',
					'options'     => array(
						'top'    => esc_html__( 'Top', 'pandastore-core' ),
						'left'   => esc_html__( 'Left', 'pandastore-core' ),
						'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
						'right'  => esc_html__( 'Right', 'pandastore-core' ),
					),
					'condition'   => array(
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
				'repeat_appear_animate',
				array(
					'label'        => esc_html__( 'Repeat Appear Animate', 'pandastore-core' ),
					'description'  => esc_html__( 'Apply animate whenever chart enters in viewport', 'pandastore-core' ),
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
					'label'       => esc_html__( 'Height of Chart Area' ),
					'description' => esc_html__( 'Controls the height of chart area.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'min' => 400,
							'max' => 1200,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .bar-chart-container' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);
			$this->add_control(
				'chart_border_width',
				array(
					'label'       => esc_html__( 'Border Width', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the border width of chart.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'min' => 0,
							'max' => 10,
						),
					),
				)
			);
			$this->add_control(
				'chart_grid_color',
				array(
					'label'       => esc_html__( 'Grid Color', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the color of grid.', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => 'rgba(0,0,0,0.05)',
					'condition'   => array(
						'show_grid' => 'true',
					),
				)
			);
		$this->end_controls_section();

		// Label
		$this->start_controls_section(
			'section_chart_label_style',
			array(
				'label'     => esc_html__( 'Label' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_label' => 'true',
				),
			)
		);
			$this->add_control(
				'labels_font_family',
				array(
					'label'       => esc_html__( 'Font Family', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font family of labels.', 'pandastore-core' ),
					'type'        => Controls_Manager::FONT,
					'default'     => '',
				)
			);
			$this->add_control(
				'labels_font_size',
				array(
					'label'       => esc_html__( 'Font Size', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font size of labels.', 'pandastore-core' ),
					'type'        => Controls_Manager::NUMBER,
				)
			);
			$typo_weight_options = array(
				'' => esc_html__( 'Default', 'pandastore-core' ),
			);

		foreach ( array_merge( [ 'normal', 'bold' ], range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}
			$this->add_control(
				'labels_font_weight',
				array(
					'label'       => esc_html__( 'Font Weight', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font weight of labels.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => $typo_weight_options,
				)
			);
			$this->add_control(
				'labels_font_style',
				array(
					'label'       => esc_html__( 'Font Style', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font style of labels.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''        => esc_html__( 'Default', 'pandastore-core' ),
						'normal'  => esc_attr_x( 'Normal', 'Typography Control', 'pandastore-core' ),
						'italic'  => esc_attr_x( 'Italic', 'Typography Control', 'pandastore-core' ),
						'oblique' => esc_attr_x( 'Oblique', 'Typography Control', 'pandastore-core' ),
					),
				)
			);
			$this->add_control(
				'labels_font_color',
				array(
					'label'       => esc_html__( 'Font Color', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the color of labels.', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
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
					'label'       => esc_html__( 'Font Family', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font family of legend.', 'pandastore-core' ),
					'type'        => Controls_Manager::FONT,
					'default'     => '',
				)
			);
			$this->add_control(
				'legend_font_size',
				array(
					'label'       => esc_html__( 'Font Size', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font size of legend.', 'pandastore-core' ),
					'type'        => Controls_Manager::NUMBER,
				)
			);
			$this->add_control(
				'legend_font_weight',
				array(
					'label'       => esc_html__( 'Font Weight', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font weight of legend.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => $typo_weight_options,
				)
			);
			$this->add_control(
				'legend_font_style',
				array(
					'label'       => esc_html__( 'Font Style', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font style of legend.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
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
					'label'       => esc_html__( 'Font Color', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the font color of legend.', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
				)
			);
		$this->end_controls_section();
	}


	/**
	 * Get options of chart widget
	 *
	 * @since 1.0
	 */
	public function get_options() {
		$settings = $this->get_settings_for_display();

		$show_label   = filter_var( $settings['show_label'], FILTER_VALIDATE_BOOLEAN );
		$show_tooltip = filter_var( $settings['show_tooltip'], FILTER_VALIDATE_BOOLEAN );
		$show_legend  = filter_var( $settings['show_legend'], FILTER_VALIDATE_BOOLEAN );
		$show_grid    = filter_var( $settings['show_grid'], FILTER_VALIDATE_BOOLEAN );

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
					$style_value = $this->get_chart_font_style_string( $setting_name );

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

		if ( $show_grid ) {
			$options['scales'] = array(
				'yAxes' => array(
					array(
						'ticks'     => array(
							'display'     => $show_label,
							'beginAtZero' => true,
							'max'         => isset( $settings['data_value_range'] ) ? intval( $settings['data_value_range'] ) : 10,
							'stepSize'    => isset( $settings['data_value_step'] ) ? intval( $settings['data_value_step'] ) : 1,
						),
						'gridLines' => array(
							'drawBorder' => false,
							'color'      => isset( $settings['chart_grid_color'] ) ? $settings['chart_grid_color'] : 'rgba(0,0,0,0.05)',
						),
					),
				),
				'xAxes' => array(
					array(
						'ticks'     => array(
							'display'     => $show_label,
							'beginAtZero' => true,
							'max'         => isset( $settings['data_value_range'] ) ? intval( $settings['data_value_range'] ) : 10,
							'stepSize'    => isset( $settings['data_value_step'] ) ? intval( $settings['data_value_step'] ) : 1,
						),
						'gridLines' => array(
							'drawBorder' => false,
							'color'      => isset( $settings['chart_grid_color'] ) ? $settings['chart_grid_color'] : 'rgba(0,0,0,0.05)',
						),
					),
				),
			);
		} else {
			$options['scales'] = array(
				'yAxes' => array(
					array(
						'ticks'     => array(
							'display'     => $show_label,
							'beginAtZero' => true,
						),
						'gridLines' => array(
							'display' => false,
						),
					),
				),
				'xAxes' => array(
					array(
						'ticks'     => array(
							'display'     => $show_label,
							'beginAtZero' => true,
						),
						'gridLines' => array(
							'display' => false,
						),
					),
				),
			);
		}

		$labels_style = array();

		$labels_style_dictionary = array(
			'fontFamily' => 'labels_font_family',
			'fontSize'   => 'labels_font_size',
			'fontStyle'  => array( 'labels_font_style', 'labels_font_weight' ),
			'fontColor'  => 'labels_font_color',
		);

		if ( $show_label ) {

			foreach ( $labels_style_dictionary as $style_property => $setting_name ) {

				if ( is_array( $setting_name ) ) {
					$style_value = $this->get_chart_font_style_string( $setting_name );

					if ( ! empty( $style_value ) ) {
						$labels_style[ $style_property ] = $style_value;
					}
				} else {
					if ( ! empty( $settings[ $setting_name ] ) ) {
						if ( is_array( $settings[ $setting_name ] ) ) {
							if ( ! empty( $settings[ $setting_name ]['size'] ) ) {
								$labels_style[ $style_property ] = $settings[ $setting_name ]['size'];
							}
						} else {
							$labels_style[ $style_property ] = $settings[ $setting_name ];
						}
					}
				}
			}

			if ( ! empty( $labels_style ) ) {
				$options['scales']['xAxes'][0]['ticks'] = array_merge( $options['scales']['xAxes'][0]['ticks'], $labels_style );
				$options['scales']['yAxes'][0]['ticks'] = array_merge( $options['scales']['yAxes'][0]['ticks'], $labels_style );
			}
		}

		return $options;
	}


	/**
	 * Get font style string
	 *
	 * @since 1.0
	 * @param {Array} $fonts
	 */
	public function get_chart_font_style_string( $fonts = array() ) {
		if ( ! is_array( $fonts ) ) {
			return '';
		}

		$settings = $this->get_settings_for_display();

		$font_styles = array();

		foreach ( $fonts as $font ) {
			if ( ! empty( $settings[ $font ] ) ) {
				$font_styles[] = $settings[ $font ];
			}
		}

		if ( empty( $font_styles ) ) {
			return '';
		}

		$font_styles = array_unique( $font_styles );

		return join( ' ', $font_styles );
	}

	/**
	 * Get data of chart widget
	 *
	 * @since 1.0
	 */
	public function get_chart_data() {
		$settings = $this->get_settings_for_display();

		$datasets   = array();
		$chart_data = $settings['chart_data'];

		foreach ( $chart_data as $item_data ) {
			$item_data['label']                = ! empty( $item_data['label'] ) ? $item_data['label'] : '';
			$item_data['data']                 = ! empty( $item_data['data'] ) ? array_map( 'floatval', explode( ',', $item_data['data'] ) ) : '';
			$item_data['backgroundColor']      = ! empty( $item_data['bg_color'] ) ? alpha_rgba_hex_2_rgba_func( $item_data['bg_color'] ) : '#fefae9';
			$item_data['hoverBackgroundColor'] = ! empty( $item_data['bg_hover_color'] ) ? alpha_rgba_hex_2_rgba_func( $item_data['bg_hover_color'] ) : '#ffefe7';
			$item_data['borderColor']          = ! empty( $item_data['border_color'] ) ? alpha_rgba_hex_2_rgba_func( $item_data['border_color'] ) : '#ffefe7';
			$item_data['hoverBorderColor']     = ! empty( $item_data['border_hover_color'] ) ? alpha_rgba_hex_2_rgba_func( $item_data['border_hover_color'] ) : '#ffefe7';
			$item_data['borderWidth']          = ( '' !== $settings['chart_border_width']['size'] ) ? $settings['chart_border_width']['size'] : 1;

			$datasets[] = $item_data;
		}

		return $datasets;
	}


	/**
	 * Render widget
	 *
	 * @since 1.0
	 */
	protected function render() {

		$settings     = $this->get_settings_for_display();
		$data_chart   = $this->get_chart_data();
		$data_options = $this->get_options();
		$canvas_class = 'bar-chart chart';

		if ( 'true' == $settings['repeat_appear_animate'] ) {
			$canvas_class .= ' repeat-appear-animate';
		}

		$this->add_render_attribute(
			[
				'container' => array(
					'class'         => 'bar-chart-container chart-container',
					'data-settings' =>
					esc_attr(
						json_encode(
							array(
								'type'    => $settings['type'],
								'data'    => array(
									'labels'   => explode( ',', $settings['data_axis_label'] ),
									'datasets' => $data_chart,
								),
								'options' => $data_options,
							)
						)
					),
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
