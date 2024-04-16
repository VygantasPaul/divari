<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alpha Image Box Widget
 *
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Alpha_Image_Box_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_imagebox';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-imagebox';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'image box', 'imagebox', 'feature', 'member', 'alpha' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'imagebox_content',
			array(
				'label' => esc_html__( 'Image Box', 'pandastore-core' ),
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Imagebox Type', 'pandastore-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''      => esc_html__( 'Default', 'pandastore-core' ),
						'outer' => esc_html__( 'Outer Title', 'pandastore-core' ),
						'inner' => esc_html__( 'Inner Title', 'pandastore-core' ),
					),
				)
			);

			$this->add_control(
				'image',
				array(
					'label'   => esc_html__( 'Choose Image', 'pandastore-core' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'dynamic' => array(
						'active' => false,
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'image',
					'default'   => 'full',
					'separator' => 'none',
					'exclude'   => [ 'custom' ],
				)
			);

			$this->add_control(
				'title',
				array(
					'label'   => esc_html__( 'Title', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Input Title Here', 'pandastore-core' ),
					'dynamic' => array(
						'active' => false,
					),
				)
			);

			$this->add_control(
				'subtitle',
				array(
					'label'   => esc_html__( 'Subtitle', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Input SubTitle Here', 'pandastore-core' ),
					'dynamic' => array(
						'active' => false,
					),
				)
			);

			$this->add_control(
				'link',
				array(
					'label'   => esc_html__( 'Link Url', 'pandastore-core' ),
					'type'    => Controls_Manager::URL,
					'default' => array(
						'url' => '',
					),
				)
			);

			$this->add_control(
				'content',
				array(
					'label'   => esc_html__( 'Content', 'pandastore-core' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '10',
					'default' => '<div class="social-icons">
									<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>',
				)
			);

			$this->add_responsive_control(
				'visible_bottom',
				array(
					'label'      => esc_html__( 'Title Bottom Offset', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 10,
						'unit' => 'rem',
					),
					'size_units' => array(
						'rem',
						'px',
					),
					'range'      => array(
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 30,
						),
					),
					'condition'  => array( 'type' => 'inner' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure:hover .overlay-visible' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'invisible_top',
				array(
					'label'      => esc_html__( 'Description Top Offset', 'pandastore-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 0,
						'unit' => 'rem',
					),
					'size_units' => array(
						'rem',
						'px',
					),
					'range'      => array(
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 30,
						),
					),
					'condition'  => array( 'type' => 'inner' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure:hover .overlay-transparent' => 'padding-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'imagebox_align',
				array(
					'label'     => esc_html__( 'Alignment', 'pandastore-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
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
					'default'   => 'center',
					'selectors' => array(
						'.elementor-element-{{ID}} .image-box' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .image-box .title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .image-box .title',
				)
			);

			$this->add_control(
				'title_mg',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .image-box .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			array(
				'label' => esc_html__( 'Subtitle', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'subtitle_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .image-box .subtitle' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'subtitle_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .image-box .subtitle',
				)
			);

			$this->add_control(
				'subtitle_mg',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .image-box .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			array(
				'label' => esc_html__( 'Description', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'description_color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .image-box .content' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'description_typography',
					'label'    => esc_html__( 'Typography', 'pandastore-core' ),
					'selector' => '.elementor-element-{{ID}} .image-box .content',
				)
			);

			$this->add_control(
				'description_mg',
				array(
					'label'      => esc_html__( 'Margin', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .image-box .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_inline_editing_attributes( 'content' );

		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/image-box/render-image-box-elementor.php' );
	}
}
