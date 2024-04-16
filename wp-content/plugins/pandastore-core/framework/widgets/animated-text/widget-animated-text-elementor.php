<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Highlight Widget
 *
 * Alpha Widget to display WC breadcrumb.
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Animated_Text_Elementor_Widget extends Elementor\Widget_Heading {

	public function get_name() {
		return ALPHA_NAME . '_widget_animated_text';
	}

	public function get_title() {
		return esc_html__( 'Animated Text', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-animated-text';
	}

	public function get_keywords() {
		return array( 'animation', 'animated', 'heading', 'text', 'alpha' );
	}

	public function get_script_depends() {
		wp_register_script( 'alpha-animated-text', alpha_core_framework_uri( '/widgets/animated-text/animated-text' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-animated-text' );
	}

	protected function _register_controls() {

		parent::_register_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain heading you want to display.', 'pandastore-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => alpha_get_option( 'primary_color' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'custom_class',
			array(
				'label'       => esc_html__( 'Custom Class', 'pandastore-core' ),
				'description' => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'title_after',
			array(
				'label'       => esc_html__( 'Title After', 'pandastore-core' ),
				'description' => esc_html__( 'Enter after text.', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Theme', 'pandastore-core' ),
				'dynamic'     => array(
					'active' => true,
				),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$presets = array(
			array(
				'text' => esc_html__( 'Business', 'pandastore-core' ),
			),
			array(
				'text' => esc_html__( 'Portfolio', 'pandastore-core' ),
			),
			array(
				'text' => esc_html__( 'Education', 'pandastore-core' ),
			),
			array(
				'text' => esc_html__( 'E-Commerce', 'pandastore-core' ),
			),
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Animated Texts', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ text }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => $presets,
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$this->add_control(
			'title_before',
			array(
				'label'       => esc_html__( 'Title Before', 'pandastore-core' ),
				'description' => esc_html__( 'Enter before text.', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Truly', 'pandastore-core' ),
				'dynamic'     => array(
					'active' => true,
				),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$this->remove_control( 'title' );
		$this->remove_control( 'link' );
		$this->remove_control( 'size' );

		$this->start_controls_section(
			'section_animation',
			array(
				'label' => esc_html__( 'Animation', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'animation_type',
				array(
					'label'       => esc_html__( 'Animation Type', 'pandastore-core' ),
					'description' => esc_html__( 'Select the style for animated text.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'joke',
					'options'     => array(
						'joke'     => esc_html__( 'Joke', 'pandastore-core' ),
						'fall'     => esc_html__( 'Fall', 'pandastore-core' ),
						'rotation' => esc_html__( 'Rotation', 'pandastore-core' ),
						'croco'    => esc_html__( 'Croco', 'pandastore-core' ),
						'scaling'  => esc_html__( 'Scaling', 'pandastore-core' ),
						'typing'   => esc_html__( 'Typing', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'animation_delay',
				array(
					'label'       => esc_html__( 'Animation Delay (ms)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls the delay of animation between each text in a set. In milliseconds, 1000 = 1 second.', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => '3000',
				)
			);

			$this->add_control(
				'split_type',
				array(
					'label'       => esc_html__( 'Split Type', 'pandastore-core' ),
					'description' => esc_html__( 'Choose the split type.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'letter',
					'options'     => array(
						'letter' => esc_html__( 'Letters', 'pandastore-core' ),
						'word'   => esc_html__( 'Words', 'pandastore-core' ),
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/animated-text/render-animated-text-elementor.php' );
	}

	protected function content_template() {
	}
}
