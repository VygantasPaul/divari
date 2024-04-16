<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Button Widget
 *
 * Alpha Widget to display button.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;


class Alpha_Button_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'Button', 'link', 'alpha' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-button';
	}

	public function get_script_depends() {
		return array();
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button Options', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Label', 'pandastore-core' ),
				'description' => esc_html__( 'Type text that will be shown on button.', 'pandastore-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Click here', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'button_expand',
			array(
				'label'       => esc_html__( 'Expand', 'pandastore-core' ),
				'description' => esc_html__( 'Makes button\'s width 100% full.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'       => esc_html__( 'Alignment', 'pandastore-core' ),
				'description' => esc_html__( 'Controls button\'s alignment. Choose from Left, Center, Right.', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
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
				'default'     => 'left',
				'selectors'   => array(
					'.elementor-element-{{ID}} .elementor-widget-container' => 'text-align: {{VALUE}}',
				),
				'condition'   => array(
					'button_expand!' => 'yes',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link Url', 'pandastore-core' ),
				'description' => esc_html__( 'Input URL where you will move when button is clicked.', 'pandastore-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url' => '',
				),
			)
		);

		alpha_elementor_button_layout_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_button',
			array(
				'label' => esc_html__( 'Video Options', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'play_btn',
			array(
				'label'       => esc_html__( 'Use as a play button in section', 'pandastore-core' ),
				'description' => esc_html__( 'You can play video whenever you set video in parent section', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'pandastore-core' ),
				'label_on'    => esc_html__( 'On', 'pandastore-core' ),
				'condition'   => array(
					'video_btn' => '',
				),
			)
		);

		$this->add_control(
			'video_btn',
			array(
				'label'       => esc_html__( 'Use as video button', 'pandastore-core' ),
				'description' => esc_html__( 'You can play video on lightbox.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'pandastore-core' ),
				'label_on'    => esc_html__( 'On', 'pandastore-core' ),
				'default'     => '',
				'condition'   => array(
					'play_btn' => '',
				),
			)
		);

		$this->add_control(
			'vtype',
			array(
				'label'       => esc_html__( 'Source', 'pandastore-core' ),
				'description' => esc_html__( 'Select a certain video upload mode among Youtube, Vimeo, Dailymotion and Self Hosted modes.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'youtube',
				'options'     => array(
					'youtube' => esc_html__( 'YouTube', 'pandastore-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'pandastore-core' ),
					'hosted'  => esc_html__( 'Self Hosted', 'pandastore-core' ),
				),
				'condition'   => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'Video url', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'pandastore-core' ),
				'type'        => Controls_Manager::URL,
				'separator'   => 'after',
				'condition'   => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		alpha_elementor_button_style_controls( $this );
	}

	public function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'label' );
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/button/render-button-elementor.php' );
	}
}
