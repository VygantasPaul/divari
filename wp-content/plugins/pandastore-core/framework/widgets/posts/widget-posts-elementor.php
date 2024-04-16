<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Posts Widget
 *
 * Alpha Widget to display posts.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Alpha_Controls_Manager;

class Alpha_Posts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_posts';
	}

	public function get_title() {
		return esc_html__( 'Posts', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'blog', 'article', 'posts', 'post', 'recent' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-post';
	}

	public function get_script_depends() {
		$depends = array( 'swiper', 'isotope-pkgd' );
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_posts_selector',
			array(
				'label' => esc_html__( 'Posts Selector', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'post_ids',
			array(
				'label'       => esc_html__( 'Select Posts', 'pandastore-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'post',
				'label_block' => true,
				'multiple'    => true,
			)
		);

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Select Categories', 'pandastore-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'category',
				'label_block' => true,
				'multiple'    => true,
			)
		);

		$this->add_control(
			'count',
			array(
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Posts Count', 'pandastore-core' ),
				'default' => array(
					'size' => 4,
					'unit' => 'px',
				),
				'range'   => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order By', 'pandastore-core' ),
				'default' => 'ID',
				'options' => array(
					''              => esc_html__( 'Default', 'pandastore-core' ),
					'ID'            => esc_html__( 'ID', 'pandastore-core' ),
					'title'         => esc_html__( 'Title', 'pandastore-core' ),
					'date'          => esc_html__( 'Date', 'pandastore-core' ),
					'modified'      => esc_html__( 'Modified', 'pandastore-core' ),
					'author'        => esc_html__( 'Author', 'pandastore-core' ),
					'comment_count' => esc_html__( 'Comment count', 'pandastore-core' ),
				),
			)
		);

		$this->add_control(
			'orderway',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order Way', 'pandastore-core' ),
				'default' => 'ASC',
				'options' => array(
					'ASC'  => esc_html__( 'Ascending', 'pandastore-core' ),
					'DESC' => esc_html__( 'Descending', 'pandastore-core' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_posts_layout',
			array(
				'label' => esc_html__( 'Layout', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Posts Layout', 'pandastore-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'pandastore-core' ),
					'slider'   => esc_html__( 'Slider', 'pandastore-core' ),
					'creative' => esc_html__( 'Creative Grid', 'pandastore-core' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
				'exclude' => [ 'custom' ],
				'default' => 'alpha-post-small',
			)
		);

		alpha_elementor_grid_layout_controls( $this, 'layout_type', true, 'has_rows' );

		alpha_elementor_loadmore_layout_controls( $this, array( 'layout_type' => array( 'grid' ) ) );

		alpha_elementor_slider_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_type',
			array(
				'label' => esc_html__( 'Post Type', 'pandastore-core' ),
			)
		);

		$this->add_control(
			'follow_theme_option',
			array(
				'label'   => esc_html__( 'Follow Theme Option', 'pandastore-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		// $this->add_control(
		// 	'post_type',
		// 	array(
		// 		'label'     => esc_html__( 'Post Type', 'pandastore-core' ),
		// 		'type'      => Controls_Manager::SELECT,
		// 		'default'   => '',
		// 		'options'   => array(
		// 			''        => esc_html__( 'Default', 'pandastore-core' ),
		// 			'list'    => esc_html__( 'List', 'pandastore-core' ),
		// 			'mask'    => esc_html__( 'Mask', 'pandastore-core' ),
		// 			'widget'  => esc_html__( 'Widget', 'pandastore-core' ),
		// 			'list-xs' => esc_html__( 'Calendar', 'pandastore-core' ),
		// 		),
		// 		'condition' => array(
		// 			'follow_theme_option' => '',
		// 		),
		// 	)
		// );

		$this->add_control(
			'post_type',
			array(
				'label'     => esc_html__( 'Post Type', 'pandastore-core' ),
				'type'      => Alpha_Controls_Manager::IMAGE_CHOOSE,
				'default'   => 'default',
				'options'   => apply_filters(
					'alpha_post_types',
					array(
						'default' => 'assets/images/posts/post-1.jpg',
						'mask'    => 'assets/images/posts/post-3.jpg',
						'list'    => 'assets/images/posts/post-2.jpg',
						'widget'  => 'assets/images/posts/post-4.jpg',
						'list-xs' => 'assets/images/posts/post-5.jpg',
					),
					'elementor'
				),
				'width'     => 1,
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$this->add_control(
			'overlay',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Overlay', 'pandastore-core' ),
				'options'   => array(
					''           => esc_html__( 'No', 'pandastore-core' ),
					'light'      => esc_html__( 'Light', 'pandastore-core' ),
					'dark'       => esc_html__( 'Dark', 'pandastore-core' ),
					'zoom'       => esc_html__( 'Zoom', 'pandastore-core' ),
					'zoom_light' => esc_html__( 'Zoom and Light', 'pandastore-core' ),
					'zoom_dark'  => esc_html__( 'Zoom and Dark', 'pandastore-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'post_type!'          => 'list-xs',
				),
			)
		);

		$this->add_control(
			'excerpt_custom',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Custom Excerpt', 'pandastore-core' ),
				'separator' => 'before',
				'condition' => array(
					'follow_theme_option' => '',
					'post_type!'          => array( 'mask', 'widget', 'list-xs' ),
				),
			)
		);

		$this->add_control(
			'excerpt_type',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Excerpt By', 'pandastore-core' ),
				'default'   => 'words',
				'options'   => array(
					'words'     => esc_html__( 'Words', 'pandastore-core' ),
					'character' => esc_html__( 'Characters', 'pandastore-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'excerpt_custom'      => 'yes',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Excerpt Length', 'pandastore-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
					),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'excerpt_custom'      => 'yes',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_align',
			array(
				'label'   => esc_html__( 'Alignment', 'pandastore-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'start'  => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'end'    => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_control(
			'style_heading_meta',
			array(
				'label' => esc_html__( 'Meta', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-author, .elementor-element-{{ID}} .post-date, .elementor-element-{{ID}} .comments-link, .elementor-element-{{ID}} .mark' => 'color: {{VALUE}}',
					'.elementor-element-{{ID}} .post-meta a:not(:hover), .elementor-element-{{ID}} .post-meta mark' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '.elementor-element-{{ID}} .post-meta>*',
			)
		);

		$this->add_control(
			'style_divider_content_meta',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_title',
			array(
				'label' => esc_html__( 'Title', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '.elementor-element-{{ID}} .post-title',
			)
		);

		$this->add_control(
			'style_divider_content_title',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_cats',
			array(
				'label' => esc_html__( 'Category', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'cats_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-cats, .elementor-element-{{ID}} .post-cats a:not(:hover)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cats_typography',
				'selector' => '.elementor-element-{{ID}} .post-cats',
			)
		);

		$this->add_control(
			'style_divider_content_category',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_content',
			array(
				'label' => esc_html__( 'Excerpt', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .post-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-content' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '.elementor-element-{{ID}} .post-content p',
			)
		);

		$this->end_controls_section();

		alpha_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/posts/render-posts.php' );
	}
}
