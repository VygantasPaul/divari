<?php
/**
 * Testimonial Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

/**
 * Register elementor style controls for testimonials.
 *
 * @since 1.0
 */
function alpha_elementor_testimonial_style_controls( $self ) {
	$left  = is_rtl() ? 'right' : 'left';
	$right = 'left' == $left ? 'right' : 'left';

	$self->start_controls_section(
		'testimonial_style',
		array(
			'label' => esc_html__( 'Testimonial Style', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->start_controls_tabs( 'tabs_testimonial_style' );

			$self->start_controls_tab(
				'tab_testimonial_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);
				$self->add_control(
					'testimonial_bg_color',
					array(
						'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .testimonial:not(.testimonial-simple)' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .testimonial.testimonial-simple .content' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .testimonial.testimonial-simple .content::before' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'testimonial_box_shadow',
						'selector' => '.elementor-element-{{ID}} .testimonial',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_testimonial_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);
				$self->add_control(
					'testimonial_bg_hover_color',
					array(
						'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .testimonial:hover' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'label'    => esc_html__( 'Hover Box Shadow', 'pandastore-core' ),
						'name'     => 'testimonial_hover_box_shadow',
						'selector' => '.elementor-element-{{ID}} .testimonial:hover',
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_responsive_control(
			'testimonial_pd',
			array(
				'label'       => esc_html__( 'Padding', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the padding of testimonial.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'testimonial_border_width',
			array(
				'label'       => esc_html__( 'Border Width', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the border width of testimonial.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$self->add_responsive_control(
			'testimonial_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the border radius of testimonial.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $self->add_control(
		// 	'testimonial_border_color',
		// 	array(
		// 		'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => array(
		// 			'.elementor-element-{{ID}} .testimonial' => 'border-color: {{VALUE}};',
		// 		),
		// 	)
		// );

	$self->end_controls_section();

	$self->start_controls_section(
		'avatar_style',
		array(
			'label' => esc_html__( 'Avatar', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'avatar_sz',
			array(
				'label'       => esc_html__( 'Size', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Avatar size.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'em',
				),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .testimonial-simple .content::after, .elementor-element-{{ID}} .testimonial-simple .content::before' => "{$left}: calc(2rem + {{SIZE}}{{UNIT}} / 2 - 1rem); {$right}: auto;",
					'.elementor-element-{{ID}} .testimonial-simple.inversed .content::after, .elementor-element-{{ID}} .testimonial-simple.inversed .content::before' => "{$right}: calc(3rem + {{SIZE}}{{UNIT}} / 2 - 1rem); {$left}: auto;",
					'.elementor-element-{{ID}} .avatar::before' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'avatar_bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Avatar backgrund color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .avatar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'avatar_shadow',
				'selector' => '.elementor-element-{{ID}} .avatar',
			)
		);

		$self->add_control(
			'avatar_divider',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$self->add_control(
			'avatar_pd',
			array(
				'label'       => esc_html__( 'Padding', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Avatar padding.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'avatar_mg',
			array(
				'label'       => esc_html__( 'Margin', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Avatar margin.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'avatar_border',
				'selector' => '.elementor-element-{{ID}} .avatar',
			)
		);

		$self->add_control(
			'avatar_br',
			array(
				'label'       => esc_html__( 'Border Radius', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Avatar border radius.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'title_style',
		array(
			'label' => esc_html__( 'Title', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'title_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Title color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment-title' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .comment-title',
			)
		);

		$self->add_control(
			'title_mg',
			array(
				'label'       => esc_html__( 'Margin', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Title margin.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'comment_style',
		array(
			'label' => esc_html__( 'Comment', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'comment_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Comment color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'comment_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .testimonial.testimonial-simple .content' => 'border-color: {{VALUE}};',
					'.elementor-element-{{ID}} .testimonial.testimonial-simple .content::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'testimonial_type' => array( 'simple' ),
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'comment_typography',
				'label'    => esc_html__( 'Typography', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .comment',
			)
		);

		$self->add_control(
			'comment_pd',
			array(
				'label'      => esc_html__( 'Padding', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'comment_mg',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'name_style',
		array(
			'label' => esc_html__( 'Name', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'name_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Name color.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .name' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .name',
			)
		);

		$self->add_control(
			'name_mg',
			array(
				'label'       => esc_html__( 'Margin', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the Name margin.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'role_style',
		array(
			'label' => esc_html__( 'Role', 'pandastore-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'role_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the role color', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .role' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'role_typography',
				'label'    => esc_html__( 'Role', 'pandastore-core' ),
				'selector' => '.elementor-element-{{ID}} .role',
			)
		);

		$self->add_control(
			'role_mg',
			array(
				'label'       => esc_html__( 'Margin', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the role margin.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .role' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'rating_style',
		array(
			'label'     => esc_html__( 'Rating', 'pandastore-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'testimonial_type!' => 'simple',
			),
		)
	);

		$self->add_control(
			'rating_sz',
			array(
				'label'      => esc_html__( 'Size', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .ratings-full' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'rating_sp',
			array(
				'label'      => esc_html__( 'Star Spacing', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
			)
		);

		$self->add_control(
			'rating_color',
			array(
				'label'     => esc_html__( 'Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .ratings-full .ratings::before' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'rating_blank_color',
			array(
				'label'     => esc_html__( 'Blank Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .ratings-full::before' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'rating_mg',
			array(
				'label'      => esc_html__( 'Margin', 'pandastore-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .ratings-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();
}

/**
 * Register elementor content controls for testimonials
 */
function alpha_elementor_testimonial_content_controls( $self ) {
	$self->add_control(
		'name',
		array(
			'label'       => esc_html__( 'Name', 'pandastore-core' ),
			'description' => esc_html__( 'Type a commenter name.', 'pandastore-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'John Doe',
		)
	);

	$self->add_control(
		'role',
		array(
			'label'       => esc_html__( 'Role', 'pandastore-core' ),
			'description' => esc_html__( 'Type a commenter role.', 'pandastore-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Customer',
		)
	);

	$self->add_control(
		'title',
		array(
			'label'       => esc_html__( 'Title', 'pandastore-core' ),
			'description' => esc_html__( 'Type a title of your testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
		)
	);

	$self->add_control(
		'content',
		array(
			'label'       => esc_html__( 'Description', 'pandastore-core' ),
			'description' => esc_html__( 'Type a comment of your testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::TEXTAREA,
			'rows'        => '10',
			'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'pandastore-core' ),
		)
	);

	$self->add_control(
		'avatar',
		array(
			'label'       => esc_html__( 'Choose Avatar', 'pandastore-core' ),
			'description' => esc_html__( 'Choose a certain image for your testimonial avatar.', 'pandastore-core' ),
			'type'        => Controls_Manager::MEDIA,
			'default'     => array(
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
		)
	);

	$self->add_control(
		'link',
		array(
			'label'       => esc_html__( 'Link', 'pandastore-core' ),
			'description' => esc_html__( 'Type a certain URL for your testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'pandastore-core' ),
		)
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'      => 'avatar',
			'default'   => 'full',
			'exclude'   => [ 'custom' ],
			'separator' => 'none',
		)
	);

	$self->add_control(
		'rating',
		array(
			'label'       => esc_html__( 'Rating', 'pandastore-core' ),
			'description' => esc_html__( 'Type a certain number from 1 to 5.', 'pandastore-core' ),
			'type'        => Controls_Manager::NUMBER,
			'min'         => 0,
			'max'         => 5,
			'step'        => 0.1,
			'default'     => '',
		)
	);
}

/**
 * Register elementor type controls for testimonials.
 *
 * @since 1.0
 */
function alpha_elementor_testimonial_type_controls( $self ) {
	$self->add_control(
		'testimonial_type',
		array(
			'label'       => esc_html__( 'Testimonial Type', 'pandastore-core' ),
			'description' => esc_html__( 'Select a certain display type of your testimonial among Simple, Boxed and Custom types.', 'pandastore-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'simple',
			'options'     => array(
				'simple' => esc_html__( 'Simple', 'pandastore-core' ),
				'boxed'  => esc_html__( 'Boxed', 'pandastore-core' ),
				'aside'  => esc_html__( 'Aside', 'pandastore-core' ),
			),
		)
	);

	$self->add_control(
		'testimonial_inverse',
		array(
			'label'       => esc_html__( 'Inversed', 'pandastore-core' ),
			'description' => esc_html__( 'Enables to change the alignment of your testimonial only in the Simple type.', 'pandastore-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'condition'   => array(
				'testimonial_type' => array( 'simple', 'aside' ),
			),
		)
	);

	$self->add_control(
		'avatar_pos',
		array(
			'label'       => esc_html__( 'Avatar Position', 'pandastore-core' ),
			'description' => esc_html__( 'Choose the position of the avatar in the testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'top',
			'options'     => array(
				'top'    => esc_html__( 'Top', 'pandastore-core' ),
				'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
			),
			'condition'   => array(
				'testimonial_type' => array( 'boxed' ),
			),
		)
	);

	$self->add_control(
		'commenter_pos',
		array(
			'label'       => esc_html__( 'Commenter Position', 'pandastore-core' ),
			'description' => esc_html__( 'Choose the position of the commenter in the testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'after',
			'options'     => array(
				'before' => esc_html__( 'Before Comment', 'pandastore-core' ),
				'after'  => esc_html__( 'After Comment', 'pandastore-core' ),
			),
			'condition'   => array(
				'testimonial_type' => array( 'boxed' ),
			),
		)
	);

	$self->add_control(
		'aside_commenter_pos',
		array(
			'label'       => esc_html__( 'Commenter Position', 'pandastore-core' ),
			'description' => esc_html__( 'Choose the position of the commenter in the testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'after_avatar',
			'options'     => array(
				'after_avatar'   => esc_html__( 'After Avatar', 'pandastore-core' ),
				'before_comment' => esc_html__( 'Before Comment', 'pandastore-core' ),
				'after_comment'  => esc_html__( 'After Comment', 'pandastore-core' ),
			),
			'condition'   => array(
				'testimonial_type' => array( 'aside' ),
			),
		)
	);

	$self->add_control(
		'rating_pos',
		array(
			'label'       => esc_html__( 'Rating Position', 'pandastore-core' ),
			'description' => esc_html__( 'Choose the position of the rating in the testimonial.', 'pandastore-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'before_title',
			'options'     => array(
				'before_title'   => esc_html__( 'Before Title', 'pandastore-core' ),
				'after_title'    => esc_html__( 'After Title', 'pandastore-core' ),
				'before_comment' => esc_html__( 'Before Comment', 'pandastore-core' ),
				'after_comment'  => esc_html__( 'After Comment', 'pandastore-core' ),
			),
			'condition'   => array(
				'testimonial_type' => array( 'boxed', 'aside' ),
			),
		)
	);

	$self->add_control(
		'v_align',
		array(
			'label'       => esc_html__( 'Vertical Alignment', 'pandastore-core' ),
			'description' => esc_html__( 'Select the testimonial\'s vertical alignment.', 'pandastore-core' ),
			'type'        => Controls_Manager::CHOOSE,
			'default'     => 'center',
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
			'selectors'   => array(
				'.elementor-element-{{ID}} .testimonial' => 'text-align: {{VALUE}};',
			),
			'condition'   => array(
				'testimonial_type' => array( 'boxed', 'aside' ),
			),
		)
	);

	$self->add_control(
		'h_align',
		array(
			'label'       => esc_html__( 'Horizontal Alignment', 'pandastore-core' ),
			'description' => esc_html__( 'Select the testimonial\'s horizontal alignment.', 'pandastore-core' ),
			'type'        => Controls_Manager::CHOOSE,
			'default'     => 'center',
			'options'     => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-top',
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-middle',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'pandastore-core' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .testimonial' => 'align-items: {{VALUE}};',
				'.elementor-element-{{ID}} .commenter'   => 'align-items: {{VALUE}};',
			),
			'condition'   => array(
				'testimonial_type' => array( 'aside' ),
			),
		)
	);
}
