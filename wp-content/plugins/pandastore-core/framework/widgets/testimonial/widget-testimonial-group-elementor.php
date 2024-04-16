<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alpha Testimonial Widget
 *
 * Alpha Widget to display testimonial.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Testimonial_Group_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_testimonial_group';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-testimonial';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer', 'slider', 'grid', 'group' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_testimonial_group',
			array(
				'label' => esc_html__( 'Testimonials', 'pandastore-core' ),
			)
		);

			$repeater = new Repeater();

			alpha_elementor_testimonial_content_controls( $repeater );

			$presets = array(
				array(
					'name'    => esc_html__( 'John Doe', 'pandastore-core' ),
					'role'    => esc_html__( 'Programmer', 'pandastore-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'pandastore-core' ),
				),
				array(
					'name'    => esc_html__( 'Henry Harry', 'pandastore-core' ),
					'role'    => esc_html__( 'Banker', 'pandastore-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'pandastore-core' ),
				),
				array(
					'name'    => esc_html__( 'Tom Jakson', 'pandastore-core' ),
					'role'    => esc_html__( 'Vendor', 'pandastore-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'pandastore-core' ),
				),
			);

			$this->add_control(
				'testimonial_group_list',
				array(
					'label'   => esc_html__( 'Testimonial Group', 'pandastore-core' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => $presets,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_layout',
			array(
				'label' => esc_html__( 'Testimonials Layout', 'alpha core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Testimonials Layout', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'pandastore-core' ),
						'slider' => esc_html__( 'Slider', 'pandastore-core' ),
					),
				)
			);

			alpha_elementor_grid_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_general',
			array(
				'label' => esc_html__( 'Testimonial Type', 'pandastore-core' ),
			)
		);

			alpha_elementor_testimonial_type_controls( $this );

			$this->add_control(
				'content_line',
				array(
					'label'     => esc_html__( 'Maximum Content Line', 'pandastore-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '4',
					'selectors' => array(
						'.elementor-element-{{ID}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'star_icon',
				array(
					'label'   => esc_html__( 'Star Icon', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => 'Theme',
						'fa-icon' => 'Font Awesome',
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_testimonial_style_controls( $this );

		alpha_elementor_slider_style_controls( $this, 'layout_type' );
	}


	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/testimonial/render-testimonial-group-elementor.php' );
	}
}
