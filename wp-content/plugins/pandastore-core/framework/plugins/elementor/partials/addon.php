<?php
/**
 * Addon Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Alpha_Controls_Manager;

add_filter(
	'alpha_vars',
	function( $vars ) {
		$vars['texts']['ribbon'] = esc_html__( 'Ribbon', 'pandastore-core' );
		return $vars;
	}
);

if ( ! function_exists( 'alpha_elementor_addon_controls' ) ) {
	/**
	* Register elementor custom addons for elements and widgets.
	*
	* @since 1.0
	*/
	function alpha_elementor_addon_controls( $self, $is_banner = false ) {
		if ( ! $is_banner ) {
			$self->start_controls_section(
				'_alpha_section_floating_effect',
				array(
					'label' => __( 'Floating Effects', 'pandastore-core' ),
					'tab'   => Alpha_Widget_Advanced_Tabs::TAB_CUSTOM,
				)
			);
		}

			$self->add_control(
				'alpha_floating',
				array(
					'label'       => esc_html__( 'Floating Effects', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'description' => esc_html__( 'Select the certain floating effect you want to implement in your page.', 'pandastore-core' ),
					'groups'      => array(
						''                  => esc_html__( 'None', 'pandastore-core' ),
						'transform_group'   => array(
							'label'   => esc_html__( 'Transform Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_transform_up'    => esc_html__( 'Move To Up', 'pandastore-core' ),
								'skr_transform_down'  => esc_html__( 'Move To Down', 'pandastore-core' ),
								'skr_transform_left'  => esc_html__( 'Move To Left', 'pandastore-core' ),
								'skr_transform_right' => esc_html__( 'Move To Right', 'pandastore-core' ),
							),
						),
						'fade_in_group'     => array(
							'label'   => esc_html__( 'Fade In Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_fade_in'       => esc_html__( 'Fade In', 'pandastore-core' ),
								'skr_fade_in_up'    => esc_html__( 'Fade In Up', 'pandastore-core' ),
								'skr_fade_in_down'  => esc_html__( 'Fade In Down', 'pandastore-core' ),
								'skr_fade_in_left'  => esc_html__( 'Fade In Left', 'pandastore-core' ),
								'skr_fade_in_right' => esc_html__( 'Fade In Right', 'pandastore-core' ),
							),
						),
						'fade_out_group'    => array(
							'label'   => esc_html__( 'Fade Out Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_fade_out'       => esc_html__( 'Fade Out', 'pandastore-core' ),
								'skr_fade_out_up'    => esc_html__( 'Fade Out Up', 'pandastore-core' ),
								'skr_fade_out_down'  => esc_html__( 'Fade Out Down', 'pandastore-core' ),
								'skr_fade_out_left'  => esc_html__( 'Fade Out Left', 'pandastore-core' ),
								'skr_fade_out_right' => esc_html__( 'Fade Out Right', 'pandastore-core' ),
							),
						),
						'flip_group'        => array(
							'label'   => esc_html__( 'Flip Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_flip_x' => esc_html__( 'Flip Horizontally', 'pandastore-core' ),
								'skr_flip_y' => esc_html__( 'Flip Vertically', 'pandastore-core' ),
							),
						),
						'rotate_group'      => array(
							'label'   => esc_html__( 'Rotate Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_rotate'       => esc_html__( 'Rotate', 'pandastore-core' ),
								'skr_rotate_left'  => esc_html__( 'Rotate To Left', 'pandastore-core' ),
								'skr_rotate_right' => esc_html__( 'Rotate To Right', 'pandastore-core' ),
							),
						),
						'zoom_in_group'     => array(
							'label'   => esc_html__( 'Zoom In Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_zoom_in'       => esc_html__( 'Zoom In', 'pandastore-core' ),
								'skr_zoom_in_up'    => esc_html__( 'Zoom In Up', 'pandastore-core' ),
								'skr_zoom_in_down'  => esc_html__( 'Zoom In Down', 'pandastore-core' ),
								'skr_zoom_in_left'  => esc_html__( 'Zoom In Left', 'pandastore-core' ),
								'skr_zoom_in_right' => esc_html__( 'Zoom In Right', 'pandastore-core' ),
							),
						),
						'zoom_out_group'    => array(
							'label'   => esc_html__( 'Zoom Out Scroll Effect', 'pandastore-core' ),
							'options' => array(
								'skr_zoom_out'       => esc_html__( 'Zoom Out', 'pandastore-core' ),
								'skr_zoom_out_up'    => esc_html__( 'Zoom Out Up', 'pandastore-core' ),
								'skr_zoom_out_down'  => esc_html__( 'Zoom Out Down', 'pandastore-core' ),
								'skr_zoom_out_left'  => esc_html__( 'Zoom Out Left', 'pandastore-core' ),
								'skr_zoom_out_right' => esc_html__( 'Zoom Out Right', 'pandastore-core' ),
							),
						),
						'mouse_track_group' => array(
							'label'   => esc_html__( 'Mouse Tracking', 'pandastore-core' ),
							'options' => array(
								'mouse_tracking_x' => esc_html__( 'Track Horizontally', 'pandastore-core' ),
								'mouse_tracking_y' => esc_html__( 'Track Vertically', 'pandastore-core' ),
								'mouse_tracking'   => esc_html__( 'Track Any Direction', 'pandastore-core' ),
							),
						),
					),
				)
			);

			$self->add_control(
				'alpha_m_track_dir',
				array(
					'label'       => esc_html__( 'Inverse Mouse Move', 'pandastore-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Move object in opposite direction of mouse move.', 'pandastore-core' ),
					'condition'   => array(
						'alpha_floating' => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
					),
				)
			);

			$self->add_control(
				'alpha_m_track_speed',
				array(
					'label'       => esc_html__( 'Track Speed', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Controls speed of floating object while mouse is moving.', 'pandastore-core' ),
					'default'     => array(
						'size' => 0.5,
					),
					'range'       => array(
						'' => array(
							'step' => 0.1,
							'min'  => 0,
							'max'  => 5,
						),
					),
					'condition'   => array(
						'alpha_floating' => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
					),
				)
			);

			$self->add_control(
				'alpha_scroll_size',
				array(
					'label'       => esc_html__( 'Floating Size', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Controls offset of floating object position while scrolling.', 'pandastore-core' ),
					'default'     => array(
						'size' => '50',
						'unit' => '%',
					),
					'range'       => array(
						'%' => array(
							'step' => 1,
							'min'  => 20,
							'max'  => 500,
						),
					),
					'condition'   => array(
						'alpha_floating!' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
					),
				)
			);

			$self->add_control(
				'alpha_scroll_stop',
				array(
					'label'       => esc_html__( 'When scrolling effect should be stopped', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'center',
					'options'     => array(
						'top'        => esc_html__( 'After Top of Object reaches Top of Screen', 'pandastore-core' ),
						'center-top' => esc_html__( 'After Top of Object reaches Center of Screen', 'pandastore-core' ),
						'center'     => esc_html__( 'After Center of Object reaches Center of Screen', 'pandastore-core' ),
					),
					'condition'   => array(
						'alpha_floating!' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
					),
					'description' => esc_html__( 'Determine how to stop scrolling effect.', 'pandastore-core' ),
				)
			);

		if ( ! $is_banner ) {
			$self->end_controls_section();

			$self->start_controls_section(
				'alpha_widget_duplex_section',
				array(
					'label' => esc_html__( 'Duplex', 'pandastore-core' ),
					'tab'   => Alpha_Widget_Advanced_Tabs::TAB_CUSTOM,
				)
			);

				$self->add_control(
					'alpha_widget_duplex',
					array(
						'label'        => esc_html__( 'Use Duplex Effect?', 'pandastore-core' ),
						'type'         => Elementor\Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'pandastore-core' ),
						'label_off'    => esc_html__( 'No', 'pandastore-core' ),
						'return_value' => 'true',
						'default'      => 'false',
						'render_type'  => 'template',
					)
				);

				$self->start_controls_tabs(
					'alpha_widget_duplex_tabs',
					array(
						'condition' => array(
							'alpha_widget_duplex' => 'true',
						),
					)
				);

					$self->start_controls_tab(
						'alpha_widget_duplex_settings_tab',
						array(
							'label' => esc_html__( 'Settings', 'pandastore-core' ),
						)
					);

						$self->add_control(
							'alpha_widget_duplex_type',
							array(
								'label'       => esc_html__( 'Type', 'pandastore-core' ),
								'type'        => Elementor\Controls_Manager::SELECT,
								'default'     => 'text',
								'options'     => array(
									'text'  => esc_html__( 'Text', 'pandastore-core' ),
									'image' => esc_html__( 'Image', 'pandastore-core' ),
								),
								'render_type' => 'template',
							)
						);

						$self->add_control(
							'alpha_widget_duplex_text',
							array(
								'label'       => esc_html__( 'Text', 'pandastore-core' ),
								'type'        => Elementor\Controls_Manager::TEXT,
								'default'     => esc_html__( 'Duplex', 'pandastore-core' ),
								'condition'   => array(
									'alpha_widget_duplex_type' => 'text',
								),
								'render_type' => 'template',
							)
						);

						$self->add_control(
							'alpha_widget_duplex_image',
							array(
								'label'       => esc_html__( 'Image', 'pandastore-core' ),
								'type'        => Elementor\Controls_Manager::MEDIA,
								'default'     => array(
									'url' => Elementor\Utils::get_placeholder_image_src(),
								),
								'condition'   => array(
									'alpha_widget_duplex_type' => 'image',
								),
								'render_type' => 'template',
							)
						);

						$self->add_responsive_control(
							'alpha_widget_duplex_x_offset',
							array(
								'label'      => esc_html__( 'X-Offset', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::SLIDER,
								'size_units' => array( 'px', '%', 'em' ),
								'range'      => array(
									'px' => array(
										'min' => -500,
										'max' => 500,
									),
									'%'  => array(
										'min' => -100,
										'max' => 100,
									),
								),
								'default'    => array(
									'size' => 0,
									'unit' => 'px',
								),
								'selectors'  => array(
									'.elementor-element-{{ID}} .duplex-wrap' => 'transform: translateX({{SIZE}}{{UNIT}});',
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_duplex_y_offset',
							array(
								'label'      => esc_html__( 'Y-Offset', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::SLIDER,
								'size_units' => array( 'px', '%', 'em' ),
								'range'      => array(
									'px' => array(
										'min' => -500,
										'max' => 500,
									),
									'%'  => array(
										'min' => -100,
										'max' => 100,
									),
								),
								'default'    => array(
									'size' => -40,
									'unit' => 'px',
								),
								'selectors'  => array(
									'{{WRAPPER}} .duplex-wrap .duplex' => 'transform: translateY({{SIZE}}{{UNIT}});',
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_duplex_z_index',
							array(
								'label'     => esc_html__( 'z-Index', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::NUMBER,
								'default'   => 0,
								'min'       => 0,
								'max'       => 999,
								'step'      => 1,
								'selectors' => array(
									'.elementor-element-{{ID}} .duplex-wrap' => 'z-index:{{VALUE}}',
								),
							)
						);

					$self->end_controls_tab();

					$self->start_controls_tab(
						'alpha_widget_duplex_styles_tab',
						array(
							'label' => esc_html__( 'Styles', 'pandastore-core' ),
						)
					);

						$self->add_control(
							'alpha_widget_duplex_text_color',
							array(
								'label'     => esc_html__( 'Color', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::COLOR,
								'condition' => array(
									'alpha_widget_duplex_type' => 'text',
								),
								'selectors' => array(
									'.elementor-element-{{ID}} .duplex-wrap .duplex-text' => 'color: {{VALUE}}',
								),
							)
						);

						$self->add_group_control(
							Elementor\Group_Control_Typography::get_type(),
							array(
								'name'      => 'alpha_widget_duplex_text_typography',
								'selector'  => '.elementor-element-{{ID}} .duplex-wrap .duplex-text',
								'condition' => array(
									'alpha_widget_duplex_type' => 'text',
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_duplex_stroke_width',
							array(
								'label'      => esc_html__( 'Stroke Width (px)', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::SLIDER,
								'size_units' => array( 'px' ),
								'selectors'  => array(
									'.elementor-element-{{ID}} .duplex-text' => '-webkit-text-fill-color: transparent; -webkit-text-stroke-width: {{SIZE}}px;',
								),
								'condition'  => array(
									'alpha_widget_duplex_type' => 'text',
								),
							)
						);

						$self->add_control(
							'alpha_widget_duplex_stroke_color',
							array(
								'label'     => esc_html__( 'Stroke Color', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::COLOR,
								'selectors' => array(
									'.elementor-element-{{ID}} .duplex-text' => '-webkit-text-stroke-color: {{VALUE}};',
								),
								'condition' => array(
									'alpha_widget_duplex_type' => 'text',
								),
							)
						);

						$self->add_group_control(
							Elementor\Group_Control_Text_Shadow::get_type(),
							array(
								'name'      => 'alpha_widget_duplex_text_shadow',
								'selector'  => '.elementor-element-{{ID}} .duplex-wrap .duplex-text',
								'condition' => array(
									'alpha_widget_duplex_type' => 'text',
								),
							)
						);

						$self->add_control(
							'alpha_widget_duplex_image_width',
							array(
								'label'      => esc_html__( 'Width', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::SLIDER,
								'size_units' => array( 'px', 'rem', '%' ),
								'range'      => array(
									'px'  => array(
										'step' => 1,
										'min'  => 1,
										'max'  => 300,
									),
									'%'   => array(
										'step' => 1,
										'min'  => 1,
										'max'  => 200,
									),
									'rem' => array(
										'step' => 1,
										'min'  => 1,
										'max'  => 30,
									),
								),
								'condition'  => array(
									'alpha_widget_duplex_type' => 'image',
								),
								'selectors'  => array(
									'.elementor-element-{{ID}} .duplex-wrap' => 'width:{{SIZE}}{{UNIT}}',
								),
							)
						);

			if ( class_exists( 'Elementor\Group_Control_Css_Filter' ) ) {
				$self->add_group_control(
					Elementor\Group_Control_Css_Filter::get_type(),
					array(
						'name'     => 'alpha_widget_duplex_css_filters',
						'selector' => '.elementor-element-{{ID}} .duplex',
					)
				);
			}

					$self->end_controls_tab();

				$self->end_controls_tabs();

			$self->end_controls_section();

			$self->start_controls_section(
				'alpha_widget_ribbon_section',
				array(
					'label' => esc_html__( 'Ribbon', 'pandastore-core' ),
					'tab'   => Alpha_Widget_Advanced_Tabs::TAB_CUSTOM,
				)
			);

				$self->add_control(
					'alpha_widget_ribbon',
					array(
						'label'        => esc_html__( 'Add Ribbon?', 'pandastore-core' ),
						'type'         => Elementor\Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'pandastore-core' ),
						'label_off'    => esc_html__( 'No', 'pandastore-core' ),
						'return_value' => 'true',
						'default'      => 'false',
						'render_type'  => 'template',
					)
				);

				$self->start_controls_tabs(
					'alpha_widget_ribbon_tabs',
					array(
						'condition' => array(
							'alpha_widget_ribbon' => 'true',
						),
					)
				);

					$self->start_controls_tab(
						'alpha_widget_ribbon_settings_tab',
						array(
							'label' => esc_html__( 'Setting', 'pandastore-core' ),
						)
					);

						$self->add_control(
							'alpha_widget_ribbon_type',
							array(
								'label'   => esc_html__( 'Ribbon Type', 'pandastore-core' ),
								'type'    => Alpha_Controls_Manager::IMAGE_CHOOSE,
								'default' => 'type-1',
								'options' => array(
									'type-1' => 'assets/images/badges/badge-1.jpg',
									'type-2' => 'assets/images/badges/badge-2.jpg',
									'type-3' => 'assets/images/badges/badge-3.jpg',
									'type-4' => 'assets/images/badges/badge-4.jpg',
									'type-5' => 'assets/images/badges/badge-5.jpg',
									'type-6' => 'assets/images/badges/badge-6.jpg',
								),
								'width'   => 2,
							)
						);

						$self->add_control(
							'alpha_widget_ribbon_text',
							array(
								'label'       => esc_html__( 'Ribbon Text', 'pandastore-core' ),
								'type'        => Elementor\Controls_Manager::TEXT,
								'placeholder' => esc_html__( 'Ribbon', 'pandastore-core' ),
								'condition'   => array(
									'alpha_widget_ribbon_type' => array( 'type-1', 'type-2', 'type-5', 'type-6' ),
								),
							)
						);

						$self->add_control(
							'alpha_widget_ribbon_icon',
							array(
								'label'     => esc_html__( 'Choose Icon', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::ICONS,
								'default'   => array(
									'value'   => ALPHA_ICON_PREFIX . '-icon-star',
									'library' => 'themes-icons',
								),
								'condition' => array(
									'alpha_widget_ribbon_type' => array( 'type-3', 'type-4' ),
								),
							)
						);

						$self->add_control(
							'alpha_widget_ribbon_position',
							array(
								'label'   => esc_html__( 'Ribbon Position', 'pandastore-core' ),
								'type'    => Elementor\Controls_Manager::SELECT,
								'default' => 'top-left',
								'options' => array(
									'top-left'     => esc_html__( 'Top - Left', 'pandastore-core' ),
									'top-right'    => esc_html__( 'Top - Right', 'pandastore-core' ),
									'bottom-left'  => esc_html__( 'Bottom - Left', 'pandastore-core' ),
									'bottom-right' => esc_html__( 'Bottom - Right', 'pandastore-core' ),
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_z_index',
							array(
								'label'     => esc_html__( 'z-Index', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::NUMBER,
								'default'   => 1,
								'min'       => 0,
								'max'       => 999,
								'step'      => 1,
								'selectors' => array(
									'.elementor-element-{{ID}}  .ribbon' => 'z-index:{{VALUE}}',
								),
							)
						);

					$self->end_controls_tab();

					$self->start_controls_tab(
						'alpha_widget_ribbon_styles_tab',
						array(
							'label' => esc_html__( 'Styles', 'pandastore-core' ),
						)
					);

						$self->add_responsive_control(
							'alpha_widget_ribbon_4_size',
							array(
								'label'     => esc_html__( 'Ribbon Size', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::SLIDER,
								'range'     => array(
									'px' => array(
										'min' => 50,
										'max' => 300,
									),
								),
								'selectors' => array(
									'.elementor-element-{{ID}} .ribbon' => 'font-size: {{SIZE}}{{UNIT}};',
								),
								'condition' => array(
									'alpha_widget_ribbon_type' => 'type-4',
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_6_size',
							array(
								'label'     => esc_html__( 'Ribbon Size', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::SLIDER,
								'range'     => array(
									'px' => array(
										'min' => 50,
										'max' => 300,
									),
								),
								'selectors' => array(
									'.elementor-element-{{ID}} .ribbon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
								),
								'condition' => array(
									'alpha_widget_ribbon_type' => 'type-6',
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_icon_size',
							array(
								'label'     => esc_html__( 'Icon Size', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::SLIDER,
								'range'     => array(
									'px' => array(
										'min' => 10,
										'max' => 50,
									),
								),
								'selectors' => array(
									'.elementor-element-{{ID}} .ribbon-icon' => 'font-size: {{SIZE}}{{UNIT}};',
									'.elementor-element-{{ID}}' => '--alpha-ribbon-icon-size: {{SIZE}}{{UNIT}};',
								),
								'condition' => array(
									'alpha_widget_ribbon_type' => array( 'type-3', 'type-4' ),
								),
							)
						);

						$self->add_control(
							'alpha_widget_ribbon_text_color',
							array(
								'label'     => esc_html__( 'Color', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::COLOR,
								'condition' => array(
									'alpha_widget_ribbon' => 'true',
									'alpha_widget_ribbon_type' => array( 'type-1', 'type-2', 'type-5', 'type-6' ),
								),
								'selectors' => array(
									'.elementor-element-{{ID}} .ribbon .ribbon-text' => 'color: {{VALUE}}',
								),
							)
						);

						$self->add_group_control(
							Elementor\Group_Control_Typography::get_type(),
							array(
								'name'      => 'alpha_widget_ribbon_text_typography',
								'selector'  => '.elementor-element-{{ID}} .ribbon .ribbon-text',
								'condition' => array(
									'alpha_widget_ribbon' => 'true',
									'alpha_widget_ribbon_type' => array( 'type-1', 'type-2', 'type-5', 'type-6' ),
								),
							)
						);

						$self->add_control(
							'alpha_widget_ribbon_icon_color',
							array(
								'label'     => esc_html__( 'Icon Color', 'pandastore-core' ),
								'type'      => Elementor\Controls_Manager::COLOR,
								'condition' => array(
									'alpha_widget_ribbon' => 'true',
									'alpha_widget_ribbon_type' => array( 'type-4', 'type-3' ),
								),
								'selectors' => array(
									'{{WRAPPER}} .ribbon .ribbon-icon' => 'color: {{VALUE}}',
								),
							)
						);

						$self->add_group_control(
							Elementor\Group_Control_Background::get_type(),
							array(
								'name'           => 'alpha_widget_ribbon_bg_color',
								'selector'       => '.elementor-element-{{ID}} .ribbon',
								'exclude'        => array( 'image' ),
								'fields_options' => array(
									'background' => array(
										'label' => esc_html__( 'Background Color', 'pandastore-core' ),
									),
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_margin',
							array(
								'label'      => esc_html__( 'Margin', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::DIMENSIONS,
								'size_units' => array( 'px', 'rem', '%' ),
								'selectors'  => array(
									'.elementor-element-{{ID}} .ribbon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
								),
								'condition'  => array(
									'alpha_widget_ribbon_type' => array( 'type-1', 'type-3', 'type-6' ),
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_margin2',
							array(
								'label'              => esc_html__( 'Margin', 'pandastore-core' ),
								'type'               => Elementor\Controls_Manager::DIMENSIONS,
								'size_units'         => array( 'px', 'rem', '%' ),
								'allowed_dimensions' => 'vertical',
								'selectors'          => array(
									'.elementor-element-{{ID}} .ribbon' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
								),
								'condition'          => array(
									'alpha_widget_ribbon_type' => array( 'type-2' ),
								),
							)
						);

						$self->add_responsive_control(
							'alpha_widget_ribbon_padding',
							array(
								'label'      => esc_html__( 'Padding', 'pandastore-core' ),
								'type'       => Elementor\Controls_Manager::DIMENSIONS,
								'size_units' => array( 'px', 'rem', '%' ),
								'selectors'  => array(
									'.elementor-element-{{ID}} .ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
								),
								'condition'  => array(
									'alpha_widget_ribbon_type' => array( 'type-1', 'type-2', 'type-3', 'type-5' ),
								),
							)
						);

					$self->end_controls_tab();

				$self->end_controls_tabs();

			$self->end_controls_section();
			/**
			 * Fires after add elementor addon controls.
			 *
			 * @since 1.0
			 */
			do_action( 'alpha_elementor_addon_controls', $self );

			$self->start_controls_section(
				'_alpha_section_custom_css',
				array(
					'label' => __( 'Custom Page CSS', 'pandastore-core' ),
					'tab'   => Alpha_Widget_Advanced_Tabs::TAB_CUSTOM,
				)
			);
		}

		$self->add_control(
			'_alpha_custom_css',
			array(
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 40,
			)
		);

		if ( ! $is_banner ) {
			$self->end_controls_section();

			$self->start_controls_section(
				'_alpha_section_custom_js',
				array(
					'label' => __( 'Custom Page JS', 'pandastore-core' ),
					'tab'   => Alpha_Widget_Advanced_Tabs::TAB_CUSTOM,
				)
			);

				$self->add_control(
					'_alpha_custom_js',
					array(
						'type' => Controls_Manager::TEXTAREA,
						'rows' => 40,
					)
				);

			$self->end_controls_section();
		}
	}
}
