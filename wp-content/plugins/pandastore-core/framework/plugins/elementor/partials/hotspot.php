<?php
/**
 * Hotspot Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Alpha_Controls_Manager;

/**
 * Register hotspot layout controls
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_hotspot_layout_controls' ) ) {
	function alpha_elementor_hotspot_layout_controls( $self, $name_prefix = '', $condition_key = '', $condition_value = '', $repeater = false ) {
		if ( empty( $name_prefix ) ) {
			$self->start_controls_section(
				$name_prefix . 'section_hotspot',
				array(
					'label' => esc_html__( 'Hotspot', 'pandastore-core' ),
				)
			);
		}
			$self->add_control(
				$name_prefix . 'icon',
				array(
					'label'       => esc_html__( 'Icon', 'pandastore-core' ),
					'description' => esc_html__( 'Choose icon from icon library for hotspot on image.', 'pandastore-core' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-plus',
						'library' => '',
					),
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);
			$self->add_responsive_control(
				$name_prefix . 'horizontal',
				array(
					'label'       => esc_html__( 'Horizontal', 'pandastore-core' ),
					'description' => esc_html__( 'Controls horizontal position of hotspot on image.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) => 'left: {{SIZE}}{{UNIT}};',
					),
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);

			$self->add_responsive_control(
				$name_prefix . 'vertical',
				array(
					'label'       => esc_html__( 'Vertical', 'pandastore-core' ),
					'description' => esc_html__( 'Controls vertical position of hotspot on image.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) => 'top: {{SIZE}}{{UNIT}};',
					),
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);

			$self->add_control(
				$name_prefix . 'effect',
				array(
					'label'       => esc_html__( 'Hotspot Effect', 'pandastore-core' ),
					'description' => esc_html__( 'Choose effect of hotspot item.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'type1',
					'options'     => array(
						''      => esc_html__( 'None', 'pandastore-core' ),
						'type1' => esc_html__( 'Spread', 'pandastore-core' ),
						'type2' => esc_html__( 'Twinkle', 'pandastore-core' ),
					),
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);

			$self->add_control(
				$name_prefix . 'el_class',
				array(
					'label'       => esc_html__( 'Custom Class', 'pandastore-core' ),
					'description' => esc_html__( 'Input custom class except dot to apply custom styles or codes.', 'pandastore-core' ),
					'type'        => Controls_Manager::TEXT,
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);

		if ( empty( $name_prefix ) ) {
			$self->end_controls_section();

			$self->start_controls_section(
				$name_prefix . 'section_content',
				array(
					'label' => esc_html__( 'Popup Content', 'pandastore-core' ),
				)
			);
		}

		$self->add_control(
			$name_prefix . 'type',
			array(
				'label'       => esc_html__( 'Type', 'pandastore-core' ),
				'description' => esc_html__( 'Choose popup information type that will be displayed when mouse is over hotspot.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'html',
				'options'     => array(
					'html'    => esc_html__( 'Custom Html', 'pandastore-core' ),
					'block'   => esc_html__( 'Block', 'pandastore-core' ),
					'product' => esc_html__( 'Product', 'pandastore-core' ),
					'image'   => esc_html__( 'Image', 'pandastore-core' ),
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);
		$self->add_control(
			$name_prefix . 'html',
			array(
				'label'       => esc_html__( 'Custom Html', 'pandastore-core' ),
				'description' => esc_html__( 'Input Html Code that will be shown in hotspot popup.', 'pandastore-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'condition'   => $condition_key ? array(
					$name_prefix . 'type' => 'html',
					$condition_key        => $condition_value,
				) : array(
					$name_prefix . 'type' => 'html',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'image',
			array(
				'label'       => esc_html__( 'Choose Image', 'pandastore-core' ),
				'description' => esc_html__( 'Choose image that will be shown in hotspot popup.', 'pandastore-core' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition'   => $condition_key ? array(
					$name_prefix . 'type' => 'image',
					$condition_key        => $condition_value,
				) : array(
					$name_prefix . 'type' => 'image',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'block',
			array(
				'label'       => esc_html__( 'Select a Block', 'pandastore-core' ),
				'description' => esc_html__( 'Choose block that will be shown in hotspot popup.', 'pandastore-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'block',
				'label_block' => true,
				'condition'   => $condition_key ? array(
					$name_prefix . 'type' => 'block',
					$condition_key        => $condition_value,
				) : array(
					$name_prefix . 'type' => 'block',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'link',
			array(
				'label'       => esc_html__( 'Link Url', 'pandastore-core' ),
				'description' => esc_html__( 'Input link url of hotspot where you will move to.', 'pandastore-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url' => '',
				),
				'condition'   => $condition_key ? array(
					$name_prefix . 'type!' => 'product',
					$condition_key         => $condition_value,
				) : array(
					$name_prefix . 'type!' => 'product',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'product',
			array(
				'label'       => esc_html__( 'Product', 'pandastore-core' ),
				'description' => esc_html__( 'Choose product that will be shown in hotspot popup.', 'pandastore-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'product',
				'label_block' => true,
				'condition'   => $condition_key ? array(
					$name_prefix . 'type' => 'product',
					$condition_key        => $condition_value,
				) : array(
					$name_prefix . 'type' => 'product',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'popup_position',
			array(
				'label'       => esc_html__( 'Popup Position', 'pandastore-core' ),
				'description' => esc_html__( 'Determines where popup will be shown when mouse is over hotspot.', 'pandastore-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => array(
					'none'   => esc_html__( 'Do not display', 'pandastore-core' ),
					'top'    => esc_html__( 'Top', 'pandastore-core' ),
					'left'   => esc_html__( 'Left', 'pandastore-core' ),
					'right'  => esc_html__( 'Right', 'pandastore-core' ),
					'bottom' => esc_html__( 'Bottom', 'pandastore-core' ),
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		if ( empty( $name_prefix ) ) {
			$self->end_controls_section();
		}
	}
}

/**
 * Register hotspot style controls
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_hotspot_style_controls' ) ) {
	function alpha_elementor_hotspot_style_controls( $self, $name_prefix = '', $condition_key = '', $condition_value = '', $repeater = false ) {
		if ( empty( $name_prefix ) ) {
			$self->start_controls_section(
				$name_prefix . 'style_hotspot',
				array(
					'label' => esc_html__( 'Hotspot', 'pandastore-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);
		}
		$self->add_responsive_control(
			$name_prefix . 'size',
			array(
				'label'       => esc_html__( 'Hotspot Size', 'pandastore-core' ),
				'description' => esc_html__( 'Controls hotspot size.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'icon_size',
			array(
				'label'       => esc_html__( 'Icon Size', 'pandastore-core' ),
				'description' => esc_html__( 'Controls icon size in hotspot.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
					'em',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'em' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'pandastore-core' ),
				'description' => esc_html__( 'Controls border radius value of hotspot.', 'pandastore-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'%',
					'em',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_control(
			$name_prefix . 'spread_color',
			array(
				'label'       => esc_html__( 'Spread Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color of spread effects.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#fff',
				'condition'   => $condition_key ? array(
					$name_prefix . 'effect' => 'type1',
					$condition_key          => $condition_value,
				) : array(
					$name_prefix . 'effect' => 'type1',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : ' ' ) . '.hotspot-type1:not(:hover):before' => 'background: {{VALUE}};',
				),
			)
		);

		if ( empty( $name_prefix ) ) {
			$self->start_controls_tabs( $name_prefix . 'tabs_hotspot' );

			$self->start_controls_tab(
				$name_prefix . 'tab_btn_normal',
				array(
					'label' => esc_html__( 'Normal', 'pandastore-core' ),
				)
			);
		}

		$self->add_control(
			$name_prefix . 'btn_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the color of button.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot' => 'color: {{VALUE}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color',
			array(
				'label'       => esc_html__( 'Background Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the background color of button.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot' => 'background-color: {{VALUE}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		if ( empty( $name_prefix ) ) {
			$self->end_controls_tab();

			$self->start_controls_tab(
				$name_prefix . 'tab_btn_hover',
				array(
					'label' => esc_html__( 'Hover', 'pandastore-core' ),
				)
			);
		}

		$self->add_control(
			$name_prefix . 'btn_color_hover',
			array(
				'label'       => esc_html__( 'Hover Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the hover color of button.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : ' ' ) . '.hotspot-wrapper:hover .hotspot' => 'color: {{VALUE}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color_hover',
			array(
				'label'       => esc_html__( 'Hover Background Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the hover background color of button.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : ' ' ) . '.hotspot-wrapper:hover .hotspot' => 'background-color: {{VALUE}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		if ( empty( $name_prefix ) ) {
			$self->end_controls_tab();

			$self->end_controls_tabs();

			$self->end_controls_section();

			$self->start_controls_section(
				$name_prefix . 'style_popup',
				array(
					'label' => esc_html__( 'Popup', 'pandastore-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);
		}
			$self->add_responsive_control(
				$name_prefix . 'popup_width',
				array(
					'label'       => esc_html__( 'Popup Width', 'pandastore-core' ),
					'description' => esc_html__( 'Controls width hotspot content popup.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'%',
						'rem',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 10,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}' . ( $repeater ? ' {{CURRENT_ITEM}}' : '' ) . ' .hotspot-box' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}',
					),
					'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
				)
			);
		if ( empty( $name_prefix ) ) {
			$self->end_controls_section();
		}
	}
}
