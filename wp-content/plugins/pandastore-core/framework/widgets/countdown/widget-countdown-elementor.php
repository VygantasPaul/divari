<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Countdown Widget
 *
 * Alpha Widget to display countdown.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

class Alpha_Countdown_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-countdown';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'countdown', 'counter', 'timer' );
	}

	public function get_script_depends() {
		return array( 'jquery-countdown', 'alpha-countdown' );
	}

	protected function _register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = is_rtl() ? 'left' : 'right';

		$this->start_controls_section(
			'section_countdown',
			array(
				'label' => esc_html__( 'Countdown', 'pandastore-core' ),
			)
		);
		$this->add_control(
			'align',
			array(
				'label'       => esc_html__( 'Alignment', 'pandastore-core' ),
				'description' => esc_html__( 'Determine where the countdown is located, left, center or right.​', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'flex-start',
				'options'     => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-container' => 'justify-content: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'type',
			array(
				'label'       => esc_html__( 'Type', 'pandastore-core' ),
				'description' => esc_html__( 'Select countdown type from block and inline types.​', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'block',
				'options'     => array(
					'block'  => esc_html__( 'Block', 'pandastore-core' ),
					'inline' => esc_html__( 'Inline', 'pandastore-core' ),
				),
			)
		);
		$this->add_control(
			'date',
			array(
				'label'       => esc_html__( 'Target Date', 'pandastore-core' ),
				'description' => esc_html__( 'Set the certain date the countdown element will count down to.', 'pandastore-core' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => date( 'Y-m-d H:i:s', strtotime( '+1 day' ) ),
			)
		);
		$this->add_control(
			'timezone',
			array(
				'label'       => esc_html__( 'Timezone', 'pandastore-core' ),
				'description' => esc_html__( 'Allows you to specify which timezone is used, the sites or the viewer timezone.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''              => esc_html__( 'WordPress Defined Timezone', 'pandastore-core' ),
					'user_timezone' => esc_html__( 'User System Timezone', 'pandastore-core' ),
				),
			)
		);
		$this->add_control(
			'label',
			array(
				'label'     => esc_html__( 'Label', 'pandastore-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Offer Ends In',
				'condition' => array(
					'type' => 'inline',
				),
			)
		);
		$this->add_control(
			'label_type',
			array(
				'label'       => esc_html__( 'Unit Type', 'pandastore-core' ),
				'description' => esc_html__( 'Select time unit type from full and short. The default type is the full type.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Full', 'pandastore-core' ),
					'short' => esc_html__( 'Short', 'pandastore-core' ),
				),
				'condition'   => array(
					'type' => 'block',
				),
			)
		);
		$this->add_control(
			'label_pos',
			array(
				'label'       => esc_html__( 'Unit Position', 'pandastore-core' ),
				'description' => esc_html__( 'Select unit position from inner, outer and custom. The default position is inner.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''       => esc_html__( 'Inner', 'pandastore-core' ),
					'outer'  => esc_html__( 'Outer', 'pandastore-core' ),
					'custom' => esc_html__( 'Custom', 'pandastore-core' ),
				),
				'condition'   => array(
					'type' => 'block',
				),
			)
		);

		$this->add_responsive_control(
			'label_dimension',
			array(
				'label'      => esc_html__( 'Label Position', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -50,
						'max'  => 50,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown .countdown-period' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'label_pos' => 'custom',
				),
			)
		);

		$this->add_control(
			'date_format',
			array(
				'label'       => esc_html__( 'Units', 'pandastore-core' ),
				'description' => esc_html__( 'Allows to show or hide the amount of time aspects used in the countdown element.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => array(
					'D',
					'H',
					'M',
					'S',
				),
				'options'     => array(
					'Y' => esc_html__( 'Year', 'pandastore-core' ),
					'O' => esc_html__( 'Month', 'pandastore-core' ),
					'W' => esc_html__( 'Week', 'pandastore-core' ),
					'D' => esc_html__( 'Day', 'pandastore-core' ),
					'H' => esc_html__( 'Hour', 'pandastore-core' ),
					'M' => esc_html__( 'Minute', 'pandastore-core' ),
					'S' => esc_html__( 'Second', 'pandastore-core' ),
				),
			)
		);
		$this->add_control(
			'hide_split',
			array(
				'label'       => esc_html__( 'Hide Separator', 'pandastore-core' ),
				'description' => esc_html__( 'Allows you to show or hide the splitters between time amounts.​', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'type' => 'block',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_dimension',
			array(
				'label' => esc_html__( 'Dimension', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'       => esc_html__( 'Item Padding', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the padding of each countdown section.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'%',
					'em',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Item Spacing (px)', 'pandastore-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '20',
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-section:not(:last-child)' => "margin-{$right}: {{VALUE}}px;",
					'.elementor-element-{{ID}} .countdown-section:not(:last-child):after' => "margin-{$left}: calc({{SIZE}}px / 2 - 2px);",
				),
			)
		);

		$this->add_responsive_control(
			'label_margin',
			array(
				'label'      => esc_html__( 'Label Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'type' => 'inline',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_typography',
			array(
				'label' => esc_html__( 'Typography', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'countdown_amount',
				'label'    => esc_html__( 'Amount', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .countdown-container .countdown-amount',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'countdown_label',
				'label'    => esc_html__( 'Unit, Label', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .countdown-period, .elementor-element-{{ID}} .countdown-label',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_color',
			array(
				'label' => esc_html__( 'Color', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'countdown_section_color',
			array(
				'label'       => esc_html__( 'Section Background', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the backgorund color of the countdown section.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-section' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_amount_color',
			array(
				'label'       => esc_html__( 'Amount', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color of the countdown amount.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_label_color',
			array(
				'label'       => esc_html__( 'Unit, Label', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color of the countdown label.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-period' => 'color: {{VALUE}};',
					'.elementor-element-{{ID}} .countdown-label'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_separator_color',
			array(
				'label'       => esc_html__( 'Seperator', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color of the countdown separator.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_border',
			array(
				'label' => esc_html__( 'Border', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '.elementor-element-{{ID}} .countdown-section',
			)
		);

		$this->add_control(
			'border-radius',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Border-radius', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the border radius of the countdown section.', 'pandastore-core' ),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .countdown-section' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/countdown/render-countdown-elementor.php' );
	}

	protected function content_template() {
		?>
		<#

		var html = '',
			until = 0, 
			now = 0, 
			className = '';

		if ( settings.date ) {			
			until = Date.parse(settings.date);
			now = Date.now();
			until = (until - now) / 1000;
			className = 'countdown';

			if ( settings.label_pos ) {
				className += ' outer-period';
			}
			if ( settings.timezone ) {
				className += ' user-tz';
			}
			if ( settings.hide_split ) {
				className += ' no-split';
			}

			var format = '';
			if ( settings.date_format.length > 0 ) {
				settings.date_format.forEach(function(f) {
					format += f;
				});
			} else {
				format = settings.date_format.replace(',', '');
			}

			html += '<div class="countdown-container ' + settings.type + '-type">';

			view.addInlineEditingAttributes( 'label' );
			view.addRenderAttribute( 'label', 'class', 'countdown-label' );
			if ( 'inline' == settings.type ) {
				html += '<label ' + view.getRenderAttributeString( 'label' ) + '>' + settings.label + '</label>';
			}

			var options = {
				year: 'numeric', month: 'numeric', day: 'numeric',
				hour: 'numeric', minute: 'numeric', second: 'numeric',
				hour12: false,
			};
			html += '<div class="' + className + '" data-until="' + until + '" data-relative="true" ' + ('inline' == settings.type ? 'data-compact="true" ' : ' ') + ('short' == settings.label_type ? 'data-labels-short="true" ' : ' ') + 'data-format="' + format + '" data-time-now="' + new Intl.DateTimeFormat('default', options).format(Date.now()) + '">';

			if ( 'block' == settings.type ) {
				html += '<span class="countdown-row countdown-show ' + settings.date_format.length + '">';
				

				formats = 'short' == settings.label_type ? {
					Y: <?php echo json_encode( esc_html__( 'Years', 'pandastore-core' ) ); ?>,
					O: <?php echo json_encode( esc_html__( 'Months', 'pandastore-core' ) ); ?>,
					W: <?php echo json_encode( esc_html__( 'Weeks', 'pandastore-core' ) ); ?>,
					D: <?php echo json_encode( esc_html__( 'Days', 'pandastore-core' ) ); ?>,
					H: <?php echo json_encode( esc_html__( 'Hours', 'pandastore-core' ) ); ?>,
					M: <?php echo json_encode( esc_html__( 'Mins', 'pandastore-core' ) ); ?>,
					S: <?php echo json_encode( esc_html__( 'Secs', 'pandastore-core' ) ); ?>
				} : {
					Y: <?php echo json_encode( esc_html__( 'Years', 'pandastore-core' ) ); ?>,
					O: <?php echo json_encode( esc_html__( 'Months', 'pandastore-core' ) ); ?>,
					W: <?php echo json_encode( esc_html__( 'Weeks', 'pandastore-core' ) ); ?>,
					D: <?php echo json_encode( esc_html__( 'Days', 'pandastore-core' ) ); ?>,
					H: <?php echo json_encode( esc_html__( 'Hours', 'pandastore-core' ) ); ?>,
					M: <?php echo json_encode( esc_html__( 'Minutes', 'pandastore-core' ) ); ?>,
					S: <?php echo json_encode( esc_html__( 'Seconds', 'pandastore-core' ) ); ?>
				};

				if ( settings.date_format.length ) {
					settings.date_format.forEach(function(f) {;
						html += '<span class="countdown-section"><span class="countdown-amount">00</span><span class="countdown-period">' + formats[f] + '</span></span>';
					})
				}

				html += '</span>';
			} else {
				html += '00 : 00 : 00';
			}
		}

		html += '</div>';
		html += '</div>';

		print( html );
		#>
		<?php
	}

}
