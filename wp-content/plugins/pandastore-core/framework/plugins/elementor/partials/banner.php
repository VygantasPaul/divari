<?php
/**
 * Banner Partial
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register banner controls.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_controls' ) ) {

	function alpha_elementor_banner_controls( $self, $mode = '', $is_pb = false ) {

		$self->start_controls_section(
			'section_banner',
			array(
				'label' => esc_html__( 'Banner', 'pandastore-core' ),
			)
		);

		if ( 'insert_number' == $mode ) {
			$self->add_control(
				'banner_insert',
				array(
					'label'       => esc_html__( 'Banner Index', 'pandastore-core' ),
					'description' => esc_html__( 'Determines which index the banner is inserted in.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '2',
					'options'     => array(
						'1'    => '1',
						'2'    => '2',
						'3'    => '3',
						'4'    => '4',
						'5'    => '5',
						'6'    => '6',
						'7'    => '7',
						'8'    => '8',
						'9'    => '9',
						'last' => esc_html__( 'At last', 'pandastore-core' ),
					),
				)
			);
		}

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_banner_btn_cat' );

			$repeater->start_controls_tab(
				'tab_banner_content',
				array(
					'label' => esc_html__( 'Content', 'pandastore-core' ),
				)
			);

				$repeater->add_control(
					'banner_item_type',
					array(
						'label'       => esc_html__( 'Type', 'pandastore-core' ),
						'description' => esc_html__( 'Choose the content item type.', 'pandastore-core' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => 'text',
						'options'     => array(
							'text'    => esc_html__( 'Text', 'pandastore-core' ),
							'button'  => esc_html__( 'Button', 'pandastore-core' ),
							'image'   => esc_html__( 'Image', 'pandastore-core' ),
							'hotspot' => esc_html__( 'Hotspot', 'pandastore-core' ),
							'divider' => esc_html__( 'Divider', 'pandastore-core' ),
						),
					)
				);

				/* Text Item */
				$repeater->add_control(
					'banner_text_content',
					array(
						'label'       => esc_html__( 'Content', 'pandastore-core' ),
						'description' => esc_html__( 'Please input the text.', 'pandastore-core' ),
						'type'        => Controls_Manager::TEXTAREA,
						'default'     => esc_html__( 'Add Your Text Here', 'pandastore-core' ),
						'condition'   => array(
							'banner_item_type' => 'text',
						),
						'dynamic'     => array(
							'active' => true,
						),
					)
				);

				$repeater->add_control(
					'banner_text_tag',
					array(
						'label'       => esc_html__( 'Tag', 'pandastore-core' ),
						'description' => esc_html__( 'Select the HTML Heading tag from H1 to H6 and P tag too.', 'pandastore-core' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => 'h2',
						'options'     => array(
							'h1'   => esc_html__( 'H1', 'pandastore-core' ),
							'h2'   => esc_html__( 'H2', 'pandastore-core' ),
							'h3'   => esc_html__( 'H3', 'pandastore-core' ),
							'h4'   => esc_html__( 'H4', 'pandastore-core' ),
							'h5'   => esc_html__( 'H5', 'pandastore-core' ),
							'h6'   => esc_html__( 'H6', 'pandastore-core' ),
							'p'    => esc_html__( 'p', 'pandastore-core' ),
							'div'  => esc_html__( 'div', 'pandastore-core' ),
							'span' => esc_html__( 'span', 'pandastore-core' ),
						),
						'condition'   => array(
							'banner_item_type' => 'text',
						),
					)
				);

				/* Button */
				$repeater->add_control(
					'banner_btn_text',
					array(
						'label'       => esc_html__( 'Text', 'pandastore-core' ),
						'description' => esc_html__( 'Type text that will be shown on button.', 'pandastore-core' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => esc_html__( 'Click here', 'pandastore-core' ),
						'condition'   => array(
							'banner_item_type' => 'button',
						),
					)
				);

				$repeater->add_control(
					'banner_btn_link',
					array(
						'label'       => esc_html__( 'Link Url', 'pandastore-core' ),
						'description' => esc_html__( 'Input URL where you will move when button is clicked.', 'pandastore-core' ),
						'type'        => Controls_Manager::URL,
						'default'     => array(
							'url' => '',
						),
						'condition'   => array(
							'banner_item_type' => 'button',
						),
					)
				);

				alpha_elementor_button_layout_controls( $repeater, 'banner_item_type', 'button' );

				/* Image */
				$repeater->add_control(
					'banner_image',
					array(
						'label'       => esc_html__( 'Choose Image', 'pandastore-core' ),
						'description' => esc_html__( 'Upload an image to display.', 'pandastore-core' ),
						'type'        => Controls_Manager::MEDIA,
						'default'     => array(
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
						'condition'   => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_group_control(
					Group_Control_Image_Size::get_type(),
					array(
						'name'      => 'banner_image',
						'exclude'   => [ 'custom' ],
						'default'   => 'full',
						'separator' => 'none',
						'condition' => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_control(
					'img_link_to',
					array(
						'label'       => esc_html__( 'Link', 'pandastore-core' ),
						'description' => esc_html__( 'Determines whether you give url to image.', 'pandastore-core' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => 'none',
						'options'     => array(
							'none'   => esc_html__( 'None', 'pandastore-core' ),
							'custom' => esc_html__( 'Custom URL', 'pandastore-core' ),
						),
						'condition'   => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_control(
					'img_link',
					array(
						'label'       => esc_html__( 'Link', 'pandastore-core' ),
						'description' => esc_html__( 'Add the URL the picture will link to, ex: http://example.com.', 'pandastore-core' ),
						'type'        => Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'pandastore-core' ),
						'condition'   => array(
							'img_link_to'      => 'custom',
							'banner_item_type' => 'image',
						),
						'show_label'  => false,
					)
				);

				$repeater->add_responsive_control(
					'banner_divider_width',
					array(
						'label'       => esc_html__( 'Width', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the width of the divider.', 'pandastore-core' ),
						'type'        => Controls_Manager::SLIDER,
						'default'     => array(
							'size' => 50,
						),
						'size_units'  => array(
							'px',
							'%',
						),
						'range'       => array(
							'px' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
							'%'  => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
						),
						'condition'   => array(
							'banner_item_type' => 'divider',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_divider_height',
					array(
						'label'       => esc_html__( 'Height', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the height of the divider.', 'pandastore-core' ),
						'type'        => Controls_Manager::SLIDER,
						'default'     => array(
							'size' => 4,
						),
						'size_units'  => array(
							'px',
							'%',
						),
						'range'       => array(
							'px' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
							'%'  => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
						),
						'condition'   => array(
							'banner_item_type' => 'divider',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-top-width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				/* ----- Hotspot ----- */
				alpha_elementor_hotspot_layout_controls( $repeater, 'hotspot_', 'banner_item_type', 'hotspot', true );
				/* ----- Hotspot ----- */

				$repeater->add_control(
					'banner_item_display',
					array(
						'label'       => esc_html__( 'Inline Item', 'pandastore-core' ),
						'description' => esc_html__( 'Choose the display type of content item.', 'pandastore-core' ),
						'separator'   => 'before',
						'type'        => Controls_Manager::SWITCHER,
						'condition'   => array( 'banner_item_type!' => 'hotspot' ),
					)
				);

				$repeater->add_control(
					'banner_item_aclass',
					array(
						'label'       => esc_html__( 'Custom Class', 'pandastore-core' ),
						'description' => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'pandastore-core' ),
						'type'        => Controls_Manager::TEXT,
						'condition'   => array( 'banner_item_type!' => 'hotspot' ),
					)
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_banner_style',
				array(
					'label' => esc_html__( 'Style', 'pandastore-core' ),
				)
			);

				$repeater->add_control(
					'banner_text_color',
					array(
						'label'       => esc_html__( 'Color', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the color of text.', 'pandastore-core' ),
						'type'        => Controls_Manager::COLOR,
						'condition'   => array(
							'banner_item_type' => 'text',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text' => 'color: {{VALUE}};',
						),
					)
				);
				$repeater->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'      => 'banner_text_typo',
						'condition' => array(
							'banner_item_type!' => array( 'image', 'divider', 'hotspot' ),
						),
						'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text, .elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn',
					)
				);

				$repeater->add_control(
					'divider_color',
					array(
						'label'       => esc_html__( 'Color', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the color of divider.', 'pandastore-core' ),
						'type'        => Controls_Manager::COLOR,
						'condition'   => array(
							'banner_item_type' => 'divider',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-color: {{VALUE}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_image_width',
					array(
						'label'       => esc_html__( 'Width', 'pandastore-core' ),
						'description' => esc_html__( 'Set the width the image should take up.', 'pandastore-core' ),
						'type'        => Controls_Manager::SLIDER,
						'size_units'  => array(
							'px',
							'%',
						),
						'condition'   => array(
							'banner_item_type' => 'image',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} .banner-item{{CURRENT_ITEM}}.image, .elementor-element-{{ID}} .banner-item{{CURRENT_ITEM}} .image' => 'width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_btn_border_radius',
					array(
						'label'       => esc_html__( 'Border Radius', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the border radius.', 'pandastore-core' ),
						'type'        => Controls_Manager::DIMENSIONS,
						'size_units'  => array(
							'px',
							'%',
							'em',
						),
						'condition'   => array(
							'banner_item_type!' => array( 'text', 'hotspot' ),
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn,  .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn, .elementor-element-{{ID}} {{CURRENT_ITEM}}.image, .elementor-element-{{ID}} {{CURRENT_ITEM}} .image, .elementor-element-{{ID}} {{CURRENT_ITEM}}.divider-wrap, .elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_btn_border_width',
					array(
						'label'       => esc_html__( 'Border Width', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the border width.', 'pandastore-core' ),
						'type'        => Controls_Manager::DIMENSIONS,
						'size_units'  => array( 'px', '%', 'em' ),
						'condition'   => array(
							'banner_item_type' => 'button',
						),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_item_margin',
					array(
						'label'       => esc_html__( 'Margin', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the margin of item.', 'pandastore-core' ),
						'type'        => Controls_Manager::DIMENSIONS,
						'size_units'  => array( 'px', '%', 'em' ),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition'   => array(
							'banner_item_type!' => 'hotspot',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_item_padding',
					array(
						'label'       => esc_html__( 'Padding', 'pandastore-core' ),
						'description' => esc_html__( 'Controls the padding of item.', 'pandastore-core' ),
						'type'        => Controls_Manager::DIMENSIONS,
						'default'     => array(
							'unit' => 'px',
						),
						'condition'   => array(
							'banner_item_type!' => array( 'divider', 'hotspot' ),
						),
						'size_units'  => array( 'px', 'em', 'rem', '%' ),
						'selectors'   => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn,  .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn, .elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text, .elementor-element-{{ID}} {{CURRENT_ITEM}}.image, .elementor-element-{{ID}} {{CURRENT_ITEM}} .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				/* Hotspot Style Controls */
				alpha_elementor_hotspot_style_controls( $repeater, 'hotspot_', 'banner_item_type', 'hotspot', true );
				/* Hotspot Style Controls */

				$repeater->add_responsive_control(
					'_animation',
					array(
						'label'              => esc_html__( 'Entrance Animation', 'pandastore-core' ),
						'description'        => esc_html__( 'Select the type of animation to use on the item.', 'pandastore-core' ),
						'type'               => Controls_Manager::ANIMATION,
						'frontend_available' => true,
						'separator'          => 'before',
						'condition'          => array( 'banner_item_type!' => 'hotspot' ),
					)
				);

				$repeater->add_control(
					'animation_duration',
					array(
						'label'        => esc_html__( 'Animation Duration', 'pandastore-core' ),
						'type'         => Controls_Manager::SELECT,
						'default'      => '',
						'options'      => array(
							'slow' => esc_html__( 'Slow', 'pandastore-core' ),
							''     => esc_html__( 'Normal', 'pandastore-core' ),
							'fast' => esc_html__( 'Fast', 'pandastore-core' ),
						),
						'prefix_class' => 'animated-',
						'condition'    => array(
							'_animation!'       => '',
							'banner_item_type!' => 'hotspot',
						),
					)
				);

				$repeater->add_control(
					'_animation_delay',
					array(
						'label'              => esc_html__( 'Animation Delay', 'pandastore-core' ) . ' (ms)',
						'type'               => Controls_Manager::NUMBER,
						'default'            => '',
						'min'                => 0,
						'step'               => 100,
						'condition'          => array(
							'_animation!'       => '',
							'banner_item_type!' => 'hotspot',
						),
						'render_type'        => 'none',
						'frontend_available' => true,
					)
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'banner_item_floating',
				array(
					'label' => esc_html__( 'Floating', 'pandastore-core' ),
				)
			);

				alpha_elementor_addon_controls( $repeater, true );

			$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$presets = array(
			array(
				'banner_item_type'    => 'text',
				'banner_item_display' => '',
				'banner_text_content' => esc_html__( 'This is a simple banner', 'pandastore-core' ),
				'banner_text_tag'     => 'h3',
			),
			array(
				'banner_item_type'    => 'text',
				'banner_item_display' => '',
				'banner_text_content' => sprintf( esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nummy nibh %seuismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'pandastore-core' ), '<br/>' ),
				'banner_text_tag'     => 'p',
			),
			array(
				'banner_item_type'    => 'button',
				'banner_item_display' => 'yes',
				'banner_btn_text'     => esc_html__( 'Click here', 'pandastore-core' ),
				'button_type'         => '',
				'button_skin'         => 'btn-white',
			),
		);

		$self->add_control(
			'banner_background_heading',
			array(
				'label' => esc_html__( 'Background', 'pandastore-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'banner_background_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the background color of banner.', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#eee',
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'banner_background_image',
			array(
				'label'       => esc_html__( 'Choose Image', 'pandastore-core' ),
				'description' => esc_html__( 'Upload an image to display.', 'pandastore-core' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array(
					'url' => defined( 'ALPHA_ASSETS' ) ? ( ALPHA_ASSETS . '/images/placeholders/banner-placeholder.jpg' ) : \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$self->add_control(
			'banner_items_heading',
			array(
				'label'     => esc_html__( 'Content', 'pandastore-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'banner_text_color',
			array(
				'label'       => esc_html__( 'Color', 'pandastore-core' ),
				'description' => esc_html__( 'Controls the content color', 'pandastore-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_text_align',
			array(
				'label'       => esc_html__( 'Text Align', 'pandastore-core' ),
				'description' => esc_html__( 'Select the content\'s alignment.', 'pandastore-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'center',
				'options'     => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'pandastore-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'banner_item_list',
			array(
				'label'       => esc_html__( 'Content Items', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $presets,
				'title_field' => sprintf( '{{{ banner_item_type == "hotspot" ? \'%6$s\' : ( banner_item_type == "text" ? \'%1$s\' : ( banner_item_type == "image" ? \'%2$s\' : ( banner_item_type == "button" ? \'%3$s\' : \'%4$s\' ) ) ) }}}  {{{ banner_item_type == "hotspot" ? \'%7$s\' : ( banner_item_type == "text" ? banner_text_content : ( banner_item_type == "image" ? banner_image[\'url\'] : ( banner_item_type == "button" ?  banner_btn_text : \'%5$s\' ) ) ) }}}', '<i class="eicon-t-letter"></i>', '<i class="eicon-image"></i>', '<i class="eicon-button"></i>', '<i class="eicon-divider"></i>', esc_html__( 'Divider', 'pandastore-core' ), '<i class="eicon-image-hotspot"></i>', esc_html__( 'Hotspot', 'pandastore-core' ) ),
			)
		);

		$self->end_controls_section();

		/* Banner Style */
		$self->start_controls_section(
			'section_banner_style',
			array(
				'label' => esc_html__( 'Banner Wrapper', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'stretch_height',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Stretch Height', 'pandastore-core' ),
					'description' => esc_html__( 'You can make your banner height full of its parent', 'pandastore-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_min_height',
				array(
					'label'       => esc_html__( 'Min Height', 'pandastore-core' ),
					'description' => esc_html__( 'Controls min height value of banner.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'unit' => 'px',
						'size' => 450,
					),
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner' => 'min-height:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->add_responsive_control(
				'banner_max_height',
				array(
					'label'       => esc_html__( 'Max Height', 'pandastore-core' ),
					'description' => esc_html__( 'Controls max height value of banner.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
					),
					'selectors'   => array(
						$is_pb ? '.elementor-element-{{ID}} .banner' : '{{WRAPPER}}, .elementor-element-{{ID}} .banner, .elementor-element-{{ID}} img' => 'max-height:{{SIZE}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$self->add_responsive_control(
				'banner_img_pos',
				array(
					'label'       => esc_html__( 'Image Position (%)', 'pandastore-core' ),
					'description' => esc_html__( 'Changes image position when image is larger than render area.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'%' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner-img img' => 'object-position: {{SIZE}}%;',
					),
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'banner_layer_layout',
			array(
				'label' => esc_html__( 'Banner Content', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'banner_origin',
				array(
					'label'       => esc_html__( 'Origin X, Y', 'pandastore-core' ),
					'description' => esc_html__( 'Set base point of banner content to determine content position.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 't-mc',
					'options'     => array(
						't-none' => esc_html__( '---------- ----------', 'pandastore-core' ),
						't-m'    => esc_html__( '---------- Center', 'pandastore-core' ),
						't-c'    => esc_html__( 'Center ----------', 'pandastore-core' ),
						't-mc'   => esc_html__( 'Center Center', 'pandastore-core' ),
					),
				)
			);

			$self->start_controls_tabs( 'banner_position_tabs' );

			$self->start_controls_tab(
				'banner_pos_left_tab',
				array(
					'label' => esc_html__( 'Left', 'pandastore-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_left',
				array(
					'label'       => esc_html__( 'Left Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Left position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'left:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_top_tab',
				array(
					'label' => esc_html__( 'Top', 'pandastore-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_top',
				array(
					'label'       => esc_html__( 'Top Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Top position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'top:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_right_tab',
				array(
					'label' => esc_html__( 'Right', 'pandastore-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_right',
				array(
					'label'       => esc_html__( 'Right Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Right position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'right:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_bottom_tab',
				array(
					'label' => esc_html__( 'Bottom', 'pandastore-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_bottom',
				array(
					'label'       => esc_html__( 'Bottom Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Bottom position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->end_controls_tabs();

			$self->add_control(
				'banner_wrap',
				array(
					'label'       => esc_html__( 'Wrap with', 'pandastore-core' ),
					'description' => esc_html__( 'Choose to wrap banner content in Fullscreen banner.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'separator'   => 'before',
					'options'     => array(
						''                => esc_html__( 'None', 'pandastore-core' ),
						'container'       => esc_html__( 'Container', 'pandastore-core' ),
						'container-fluid' => esc_html__( 'Container Fluid', 'pandastore-core' ),
					),
				)
			);

			$self->add_responsive_control(
				'banner_width',
				array(
					'label'       => esc_html__( 'Width', 'pandastore-core' ),
					'description' => esc_html__( 'Changes banner content width.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', '%' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'unit' => '%',
					),
					'selectors'   => array(
						'{{WRAPPER}} .banner .banner-content' => 'max-width:{{SIZE}}{{UNIT}}; width: 100%',
					),
				)
			);

			$self->add_responsive_control(
				'banner_content_padding',
				array(
					'label'       => esc_html__( 'Padding', 'pandastore-core' ),
					'description' => esc_html__( 'Controls padding of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'default'     => array(
						'unit' => 'px',
					),
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'banner_effect',
			array(
				'label' => esc_html__( 'Banner Effect', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'banner_image_effect',
				array(
					'label' => esc_html__( 'Image Effect', 'pandastore-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$self->add_control(
				'overlay',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Hover Effect', 'pandastore-core' ),
					'description' => esc_html__( 'Choose banner overlay effect on hover.', 'pandastore-core' ),
					'options'     => array(
						''           => esc_html__( 'No', 'pandastore-core' ),
						'light'      => esc_html__( 'Light', 'pandastore-core' ),
						'dark'       => esc_html__( 'Dark', 'pandastore-core' ),
						'zoom'       => esc_html__( 'Zoom', 'pandastore-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'pandastore-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'pandastore-core' ),
						'effect-1'   => esc_html__( 'Effect 1', 'pandastore-core' ),
						'effect-2'   => esc_html__( 'Effect 2', 'pandastore-core' ),
						'effect-3'   => esc_html__( 'Effect 3', 'pandastore-core' ),
						'effect-4'   => esc_html__( 'Effect 4', 'pandastore-core' ),
					),
				)
			);

			$self->add_control(
				'banner_overlay_color',
				array(
					'label'       => esc_html__( 'Hover Effect Color', 'pandastore-core' ),
					'description' => esc_html__( 'Choose banner overlay color on hover.', 'pandastore-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner:before, .elementor-element-{{ID}} .banner:after, .elementor-element-{{ID}} .banner figure:before, .elementor-element-{{ID}} .banner figure:after' => 'background: {{VALUE}};',
						'.elementor-element-{{ID}} .overlay-dark:hover figure:after' => 'opacity: .5;',
					),
					'condition'   => array(
						'overlay!' => '',
					),
				)
			);

			$self->add_control(
				'overlay_filter',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Hover Filter Effect', 'pandastore-core' ),
					'description' => esc_html__( 'Choose banner filter effect on hover.', 'pandastore-core' ),
					'options'     => array(
						''                   => esc_html__( 'No', 'pandastore-core' ),
						'blur(4px)'          => esc_html__( 'Blur', 'pandastore-core' ),
						'brightness(1.5)'    => esc_html__( 'Brightness', 'pandastore-core' ),
						'contrast(1.5)'      => esc_html__( 'Contrast', 'pandastore-core' ),
						'grayscale(1)'       => esc_html__( 'Greyscale', 'pandastore-core' ),
						'hue-rotate(270deg)' => esc_html__( 'Hue Rotate', 'pandastore-core' ),
						'opacity(0.5)'       => esc_html__( 'Opacity', 'pandastore-core' ),
						'saturate(3)'        => esc_html__( 'Saturate', 'pandastore-core' ),
						'sepia(0.5)'         => esc_html__( 'Sepia', 'pandastore-core' ),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .banner img' => 'transition: filter .3s;',
						'.elementor-element-{{ID}} .banner:hover img' => 'filter: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'background_effect',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Backgrund Effect', 'pandastore-core' ),
					'options'     => array(
						''                   => esc_html__( 'No', 'pandastore-core' ),
						'kenBurnsToRight'    => esc_html__( 'kenBurnsRight', 'pandastore-core' ),
						'kenBurnsToLeft'     => esc_html__( 'kenBurnsLeft', 'pandastore-core' ),
						'kenBurnsToLeftTop'  => esc_html__( 'kenBurnsLeftTop', 'pandastore-core' ),
						'kenBurnsToRightTop' => esc_html__( 'kenBurnsRightTop', 'pandastore-core' ),
					),
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Please avoid giving %2$sHover Effect%3$s and %2$sBackground Effect%3$s together.%4$s', 'pandastore-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
				)
			);

			$self->add_control(
				'background_effect_duration',
				array(
					'label'       => esc_html__( 'Background Effect Duration (s)', 'pandastore-core' ),
					'description' => esc_html__( 'Set banner background effect duration time.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						's',
					),
					'default'     => array(
						'size' => 30,
						'unit' => 's',
					),
					'range'       => array(
						's' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 60,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .background-effect' => 'animation-duration:{{SIZE}}s;',
					),
					'condition'   => array(
						'background_effect!' => '',
					),
				)
			);

			$self->add_control(
				'particle_effect',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Particle Effects', 'pandastore-core' ),
					'description' => esc_html__( 'Shows animating particles over banner image. Choose from Snowfall, Sparkle.', 'pandastore-core' ),
					'options'     => array(
						''         => esc_html__( 'No', 'pandastore-core' ),
						'snowfall' => esc_html__( 'Snowfall', 'pandastore-core' ),
						'sparkle'  => esc_html__( 'Sparkle', 'pandastore-core' ),
					),
				)
			);

			$self->add_control(
				'parallax',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Enable Parallax', 'pandastore-core' ),
					'description' => esc_html__( 'Set to enable parallax effect for banner.', 'pandastore-core' ),
				)
			);

			$self->add_control(
				'banner_content_effect',
				array(
					'label'     => esc_html__( 'Content Effect', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$self->add_responsive_control(
				'_content_animation',
				array(
					'label'              => esc_html__( 'Content Entrance Animation', 'pandastore-core' ),
					'description'        => esc_html__( 'Set entrance animation for entire banner content.', 'pandastore-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
				)
			);

			$self->add_control(
				'content_animation_duration',
				array(
					'label'        => esc_html__( 'Animation Duration', 'pandastore-core' ),
					'description'  => esc_html__( 'Determine how long entrance animation should shown.', 'pandastore-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						'slow' => esc_html__( 'Slow', 'pandastore-core' ),
						''     => esc_html__( 'Normal', 'pandastore-core' ),
						'fast' => esc_html__( 'Fast', 'pandastore-core' ),
					),
					'prefix_class' => 'animated-',
					'condition'    => array(
						'_content_animation!' => '',
					),
				)
			);

			$self->add_control(
				'_content_animation_delay',
				array(
					'label'              => esc_html__( 'Animation Delay', 'pandastore-core' ) . ' (ms)',
					'description'        => esc_html__( 'Set delay time for content entrance animation.', 'pandastore-core' ),
					'type'               => Controls_Manager::NUMBER,
					'default'            => '',
					'min'                => 0,
					'step'               => 100,
					'condition'          => array(
						'_content_animation!' => '',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'parallax_options',
			array(
				'label'     => esc_html__( 'Parallax', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'parallax' => 'yes',
				),
			)
		);

			$self->add_control(
				'parallax_speed',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Speed', 'pandastore-core' ),
					'description' => esc_html__( 'Change speed of banner parallax effect.', 'pandastore-core' ),
					'condition'   => array(
						'parallax' => 'yes',
					),
					'default'     => array(
						'size' => 1,
						'unit' => 'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
				)
			);

			$self->add_control(
				'parallax_offset',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Determine offset value of parallax effect to show different parts on screen.', 'pandastore-core' ),
					'condition'   => array(
						'parallax' => 'yes',
					),
					'default'     => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
				)
			);

			$self->add_control(
				'parallax_height',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Height (%)', 'pandastore-core' ),
					'description' => esc_html__( 'Change height of parallax background image.', 'pandastore-core' ),
					'condition'   => array(
						'parallax' => 'yes',
					),
					'separator'   => 'after',
					'default'     => array(
						'size' => 200,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
				)
			);

		$self->end_controls_section();
	}
}

/**
 * Render banner.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_products_render_banner' ) ) {
	function alpha_products_render_banner( $self, $atts ) {
		$atts['self'] = $self;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/banner/render-banner-elementor.php' );
	}
}


/**
 * Register elementor layout controls for section & column banner.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_layout_controls' ) ) {
	function alpha_elementor_banner_layout_controls( $self, $condition_key ) {

		$self->add_responsive_control(
			'banner_min_height',
			array(
				'label'       => esc_html__( 'Min Height', 'pandastore-core' ),
				'description' => esc_html__( 'Controls min height value of banner.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
				'selectors'   => array(
					'.elementor .elementor-element-{{ID}}' => 'min-height:{{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} > .elementor-container' => 'min-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_max_height',
			array(
				'label'       => esc_html__( 'Max Height', 'pandastore-core' ),
				'description' => esc_html__( 'Controls max height value of banner.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
				'selectors'   => array(
					'.elementor .elementor-element-{{ID}}' => 'max-height:{{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} > .elementor-container' => 'max-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_img_pos',
			array(
				'label'       => esc_html__( 'Image Position (%)', 'pandastore-core' ),
				'description' => esc_html__( 'Changes image position when image is larger than render area.', 'pandastore-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
				'selectors'   => array(
					'{{WRAPPER}} .banner-img img' => 'object-position: {{SIZE}}%;',
				),
			)
		);

		$self->add_control(
			'overlay',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Banner Overlay', 'pandastore-core' ),
				'description' => esc_html__( 'Choose banner overlay effect on hover.', 'pandastore-core' ),
				'options'     => array(
					''           => esc_html__( 'No', 'pandastore-core' ),
					'light'      => esc_html__( 'Light', 'pandastore-core' ),
					'dark'       => esc_html__( 'Dark', 'pandastore-core' ),
					'zoom'       => esc_html__( 'Zoom', 'pandastore-core' ),
					'zoom_light' => esc_html__( 'Zoom and Light', 'pandastore-core' ),
					'zoom_dark'  => esc_html__( 'Zoom and Dark', 'pandastore-core' ),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
			)
		);
	}
}


/**
 * Register elementor layout controls for column banner layer.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_layer_layout_controls' ) ) {
	function alpha_elementor_banner_layer_layout_controls( $self, $condition_key ) {

		$self->start_controls_section(
			'banner_layer_layout',
			array(
				'label'     => esc_html__( 'Banner Layer', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);
			$self->add_control(
				'banner_text_align',
				array(
					'label'       => esc_html__( 'Text Align', 'pandastore-core' ),
					'description' => esc_html__( 'Select the content\'s alignment.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justify', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors'   => array(
						'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_control(
				'banner_origin',
				array(
					'label'       => esc_html__( 'Origin', 'pandastore-core' ),
					'description' => esc_html__( 'Set base point of banner content to determine content position.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						't-m'  => array(
							'title' => esc_html__( 'Vertical Center', 'pandastore-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						't-c'  => array(
							'title' => esc_html__( 'Horizontal Center', 'pandastore-core' ),
							'icon'  => 'eicon-h-align-center',
						),
						't-mc' => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-frame-minimize',
						),
					),
					'default'     => 't-mc',
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->start_controls_tabs( 'banner_position_tabs' );

			$self->start_controls_tab(
				'banner_pos_left_tab',
				array(
					'label'     => esc_html__( 'Left', 'pandastore-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_left',
				array(
					'label'       => esc_html__( 'Left Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Left position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'left:{{SIZE}}{{UNIT}};',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_top_tab',
				array(
					'label'     => esc_html__( 'Top', 'pandastore-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_top',
				array(
					'label'       => esc_html__( 'Top Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Top position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'top:{{SIZE}}{{UNIT}};',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_right_tab',
				array(
					'label'     => esc_html__( 'Right', 'pandastore-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_right',
				array(
					'label'       => esc_html__( 'Right Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Right position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:{{SIZE}}{{UNIT}};',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_bottom_tab',
				array(
					'label'     => esc_html__( 'Bottom', 'pandastore-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_bottom',
				array(
					'label'       => esc_html__( 'Bottom Offset', 'pandastore-core' ),
					'description' => esc_html__( 'Set Bottom position of banner content.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->end_controls_tabs();

			$self->add_responsive_control(
				'banner_width',
				array(
					'label'       => esc_html__( 'Width', 'pandastore-core' ),
					'description' => esc_html__( 'Changes banner content width.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', '%' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'unit' => '%',
					),
					'separator'   => 'before',
					'selectors'   => array(
						'{{WRAPPER}}.banner-content,{{WRAPPER}}>.banner-content,{{WRAPPER}}>div>.banner-content' => 'max-width:{{SIZE}}{{UNIT}};width: 100%;',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_height',
				array(
					'label'       => esc_html__( 'Height', 'pandastore-core' ),
					'description' => esc_html__( 'Changes banner content height.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', '%' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'     => array(
						'unit' => '%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'height:{{SIZE}}{{UNIT}};',
					),
					'condition'   => array(
						$condition_key => 'banner_layer',
					),
				)
			);

		$self->end_controls_section();
	}
}
