<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Heading Widget
 *
 * Alpha Widget to display heading.
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
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;


class Alpha_Heading_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'heading', 'title', 'subtitle', 'text', 'alpha', 'dynamic' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-heading';
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_heading_title',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'       => esc_html__( 'Content', 'pandastore-core' ),
				'description' => esc_html__( 'Select a certain content type among Custom and Dynamic.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'custom'  => esc_html__( 'Custom Text', 'pandastore-core' ),
					'dynamic' => esc_html__( 'Dynamic Content', 'pandastore-core' ),
				),
				'default'     => 'custom',
			)
		);

		$this->add_control(
			'dynamic_content',
			array(
				'label'       => esc_html__( 'Dynamic Content', 'pandastore-core' ),
				'description' => esc_html__( 'Select the certain dynamic content you want to show in your page. ( ex. page title, subtitle, user info and so on )', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'title'        => esc_html__( 'Page Title', 'pandastore-core' ),
					'subtitle'     => esc_html__( 'Page Subtitle', 'pandastore-core' ),
					'product_cnt'  => esc_html__( 'Products Count', 'pandastore-core' ),
					'site_tagline' => esc_html__( 'Site Tag Line', 'pandastore-core' ),
					'site_title'   => esc_html__( 'Site Title', 'pandastore-core' ),
					'date'         => esc_html__( 'Current Date Time', 'pandastore-core' ),
				),
				'default'     => 'title',
				'condition'   => array(
					'content_type' => 'dynamic',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain heading you want to display.', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Add Your Heading Text Here', 'pandastore-core' ),
				'placeholder' => esc_html__( 'Enter your title', 'pandastore-core' ),
				'condition'   => array(
					'content_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'       => esc_html__( 'HTML Tag', 'pandastore-core' ),
				'description' => esc_html__( 'Select the HTML Heading tag from H1 to H6 and P tag too.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
				'default'     => 'h2',
			)
		);

		$this->add_control(
			'decoration',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Type', 'pandastore-core' ),
				'description' => esc_html__( 'Select the decoration type among Simple, Cross and Underline options. The Default type is the Simple type.', 'pandastore-core' ),
				'default'     => '',
				'options'     => array(
					''          => esc_html__( 'Simple', 'pandastore-core' ),
					'cross'     => esc_html__( 'Cross', 'pandastore-core' ),
					'underline' => esc_html__( 'Underline', 'pandastore-core' ),
				),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'       => esc_html__( 'Title Align', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the alignment of title. Options are left, center and right.', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'title-left',
				'options'     => array(
					'title-left'   => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'title-center' => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'title-right'  => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			array(
				'label'       => esc_html__( 'Decoration Spacing', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the space between the heading and the decoration.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .title::before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .title::after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Decoration Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title-cross .title::before, .elementor-element-{{ID}} .title-cross .title::after, .elementor-element-{{ID}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'show_link',
			array(
				'label'       => esc_html__( 'Show Link?', 'pandastore-core' ),
				'description' => esc_html__( 'Toggle for making your heading has link or not.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link',
			array(
				'label'     => esc_html__( 'Link', 'pandastore-core' ),
				'condition' => array(
					'show_link' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'       => esc_html__( 'Link Url', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain URL to link through other pages.', 'pandastore-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'link_label',
			array(
				'label'       => esc_html__( 'Link Label', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain label of your heading link.', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'link',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'pandastore-core' ),
				'description' => esc_html__( 'Upload a certain icon of your heading link.', 'pandastore-core' ),
				'type'        => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'       => esc_html__( 'Icon Position', 'pandastore-core' ),
				'description' => esc_html__( 'Select a certain position of your icon.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'after',
				'options'     => array(
					'after'  => esc_html__( 'After', 'pandastore-core' ),
					'before' => esc_html__( 'Before', 'pandastore-core' ),
				),
			)
		);

		$this->add_control(
			'icon_space',
			array(
				'label'       => esc_html__( 'Icon Spacing (px)', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain number for the space between label and icon.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .icon-before i' => "margin-{$right}: {{SIZE}}px;",
					'.elementor-element-{{ID}} .icon-after i'  => "margin-{$left}: {{SIZE}}px;",
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Size (px)', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain number for your icon size.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_responsive_control(
			'link_align',
			array(
				'label'       => esc_html__( 'Link Align', 'pandastore-core' ),
				'description' => esc_html__( 'Choose a certain alignment of your heading link.', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'link-left'  => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'link-right' => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'     => 'link-right',
			)
		);

		$this->add_responsive_control(
			'show_divider',
			array(
				'label'       => esc_html__( 'Show Divider?', 'donad-core' ),
				'description' => esc_html__( 'Toggle for making your heading has a divider or not. It is only available in left alignment.', 'pandastore-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'link_align' => 'link-left',
				),
			)
		);

		$this->add_control(
			'link_gap',
			array(
				'label'       => esc_html__( 'Link Space', 'pandastore-core' ),
				'description' => esc_html__( 'Type a certain number for the space between heading and link.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .link' => "margin-{$left}: {{SIZE}}{{UNIT}};",
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Title Padding', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'       => esc_html__( 'Title Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the heading color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '.elementor-element-{{ID}} .title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link_style',
			array(
				'label' => esc_html__( 'Link', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'link_spacing',
			array(
				'label'      => esc_html__( 'Link Spacing', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '.elementor-element-{{ID}} .link',
			)
		);

		$this->start_controls_tabs( 'tabs_heading_link' );

		$this->start_controls_tab(
			'tab_link_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'link_label' );
		if ( 'custom' == $atts['content_type'] ) {
			$this->add_inline_editing_attributes( 'title' );
		}
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/heading/render-heading-elementor.php' );
	}
}
