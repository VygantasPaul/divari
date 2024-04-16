<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Share Widget
 *
 * Alpha Widget to display share buttons.
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
use Elementor\Repeater;


class Alpha_Share_Elementor_Widget extends \Elementor\Widget_Base {
	public $share_icons = array(
		'facebook'  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
		'twitter'   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
		'linkedin'  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
		'email'     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
		'instagram' => array( 'fab fa-instagram', '' ),
		'youtube'   => array( 'fab fa-youtube', '' ),
		'google'    => array( 'fab fa-google-plus-g', 'https://plus.google.com/share?url=$permalink' ),
		'pinterest' => array( 'fab fa-pinterest', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
		'reddit'    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
		'tumblr'    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
		'vk'        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
		'whatsapp'  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title-$permalink' ),
		'xing'      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
	);

	public function get_name() {
		return ALPHA_NAME . '_widget_share';
	}

	public function get_title() {
		return esc_html__( 'Social', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'Share', 'Social', 'link', 'alpha' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-share';
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_share_content',
			array(
				'label' => esc_html__( 'Share Buttons', 'pandastore-core' ),
			)
		);

			$options = array();

		foreach ( $this->share_icons as $key => $value ) {
			$options[ $key ] = $key;
		}

			$repeater = new Repeater();

				$repeater->add_control(
					'site',
					array(
						'label'       => esc_html__( 'Icon', 'pandastore-core' ),
						'description' => esc_html__( 'Select social network for each social items.', 'pandastore-core' ),
						'type'        => Controls_Manager::SELECT,
						'options'     => $options,
						'default'     => 'facebook',
					)
				);

				$repeater->add_control(
					'link',
					array(
						'label'       => esc_html__( 'Link', 'pandastore-core' ),
						'type'        => Controls_Manager::URL,
						'description' => esc_html__( 'Please Leave it blank to share this page or Input URL for a custom link', 'pandastore-core' ),
						'options'     => false,
					)
				);

			$this->add_control(
				'share_buttons',
				array(
					'label'       => esc_html__( 'Share Icons', 'pandastore-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'site' => 'facebook',
							'link' => '',
						),
						array(
							'site' => 'twitter',
							'link' => '',
						),
						array(
							'site' => 'linkedin',
							'link' => '',
						),
					),
					'title_field' => '{{{ site }}}',
				)
			);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Type', 'pandastore-core' ),
					'description' => esc_html__( 'Choose social link item type. Choose from Simple, Stacked, Framed.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						''        => esc_html__( 'Default', 'pandastore-core' ),
						'stacked' => esc_html__( 'Stacked', 'pandastore-core' ),
						'framed'  => esc_html__( 'Framed', 'pandastore-core' ),
					),
					'default'     => 'stacked',
					'separator'   => 'before',
				)
			);

			$this->add_control(
				'border',
				array(
					'label'       => esc_html__( 'Border Style', 'pandastore-core' ),
					'description' => esc_html__( 'Choose border style of social link item. Choose from Square, Rounded, Ellipse.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						'0'    => esc_html__( 'Rectangle', 'pandastore-core' ),
						'10px' => esc_html__( 'Rounded', 'pandastore-core' ),
						'50%'  => esc_html__( 'Circle', 'pandastore-core' ),
					),
					'default'     => '50%',
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-radius: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'border_width',
				array(
					'label'     => esc_html__( 'Border Width', 'pandastore-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'px' => 2,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'condition' => array(
						'type' => 'framed',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-width: {{SIZE}}px',
					),
				)
			);

			$this->add_control(
				'share_direction',
				array(
					'type'        => Controls_Manager::CHOOSE,
					'label'       => esc_html__( 'Direction', 'pandastore-core' ),
					'description' => esc_html__( 'Determine whether to arrange social link items horizontally or vertically.', 'pandastore-core' ),
					'options'     => array(
						'flex'  => array(
							'title' => esc_html__( 'Row', 'pandastore-core' ),
							'icon'  => 'eicon-arrow-right',
						),
						'block' => array(
							'title' => esc_html__( 'Column', 'pandastore-core' ),
							'icon'  => 'eicon-arrow-down',
						),
					),
					'default'     => 'flex',
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icons' => 'display: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'share_align',
				array(
					'label'       => esc_html__( 'Alignment', 'pandastore-core' ),
					'description' => esc_html__( 'Choose alignment of social icons. Choose from Left, Center, Right, Justified.', 'pandastore-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'flex-start'    => array(
							'title' => esc_html__( 'Left', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'        => array(
							'title' => esc_html__( 'Center', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'      => array(
							'title' => esc_html__( 'Right', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'space-between' => array(
							'title' => esc_html__( 'Justify', 'pandastore-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icons' => 'justify-content: {{VALUE}};',
					),
					'condition'   => array(
						'share_direction' => 'flex',
					),
				)
			);

			$this->add_control(
				'custom_color',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Use Custom Color', 'pandastore-core' ),
					'description' => esc_html__( 'Enables you to change color scheme of social icons.', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'color',
				array(
					'label'     => esc_html__( 'Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'border-color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'background_color',
				array(
					'label'     => esc_html__( 'Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'custom_hover_color',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Use Custom Hover Color', 'pandastore-core' ),
					'description' => esc_html__( 'Enables you to change color scheme of social icons when mouse is over.', 'pandastore-core' ),
					'condition'   => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'border-color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_bg_color',
				array(
					'label'     => esc_html__( 'Hover Background Color', 'pandastore-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_share_style',
			array(
				'label' => esc_html__( 'Share Icons Style', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'button_size',
				array(
					'label'       => esc_html__( 'Button Size (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls entire size of social items.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'       => esc_html__( 'Icon Size (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls only icon size of social items.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'col_space',
				array(
					'label'       => esc_html__( 'Column Gap (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls horizontal space (Left and Right) of social items.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'default'     => array(
						'size' => 5,
						'unit' => 'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

			$this->add_responsive_control(
				'row_space',
				array(
					'label'       => esc_html__( 'Row Gap (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls vertical space (Top and Bottom) of social items.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2); margin-bottom: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/share/render-share-elementor.php' );
	}
}
