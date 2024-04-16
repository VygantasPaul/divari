<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Column Element
 *
 * Extended Element_Column Class
 * Added Slider, Banner Layer, Creative Grid Item Functions.
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;

add_action( 'elementor/frontend/column/before_render', 'alpha_column_render_attributes', 10, 1 );

class Alpha_Element_Column extends Elementor\Element_Column {

	private $is_slider_wrap = false;

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
	}

	private function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'div';
		}

		return Elementor\Utils::validate_html_tag( $html_tag );
	}

	protected function _register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';
		parent::_register_controls();

		$this->start_controls_section(
			'column_additional',
			array(
				'label' => ALPHA_DISPLAY_NAME . esc_html__( ' Settings', 'pandastore-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
			$this->add_responsive_control(
				'creative_width',
				array(
					'label'       => esc_html__( 'Grid Item Width (%)', 'pandastore-core' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'This Option will be applied when only parent section is used for creative grid. Empty Value will be set from preset of parent creative grid.', 'pandastore-core' ),
					'min'         => 1,
					'max'         => 100,
				)
			);

			$this->add_responsive_control(
				'creative_height',
				array(
					'label'       => esc_html__( 'Grid Item Height', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'preset',
					'options'     => array(
						'1'      => '1',
						'1-2'    => '1/2',
						'1-3'    => '1/3',
						'2-3'    => '2/3',
						'1-4'    => '1/4',
						'3-4'    => '3/4',
						'child'  => esc_html__( 'Depending on Children', 'pandastore-core' ),
						'preset' => esc_html__( 'Use From Preset', 'pandastore-core' ),
					),
					'description' => esc_html__( 'This Option will be applied when only parent section is used for creative grid.', 'pandastore-core' ),
				)
			);

			$this->add_responsive_control(
				'creative_order',
				array(
					'label'       => esc_html__( 'Grid Item Order', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'separator'   => 'after',
					'options'     => array(
						''   => esc_html__( 'Default', 'pandastore-core' ),
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
					),
					'description' => esc_html__( 'This Option will be applied when only parent section is used for creative grid.', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'use_as',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Use Column For', 'pandastore-core' ),
					'default' => '',
					'options' => array(
						''                  => esc_html__( 'Default', 'pandastore-core' ),
						'slider'            => esc_html__( 'Slider', 'pandastore-core' ),
						'banner_layer'      => esc_html__( 'Banner Layer', 'pandastore-core' ),
						'accordion_content' => esc_html__( 'Accordion Content', 'pandastore-core' ),
						'tab_content'       => esc_html__( 'Tab Content', 'pandastore-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'column_slider',
			array(
				'label'     => esc_html__( 'Slider', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'slider',
				),
			)
		);

			alpha_elementor_grid_layout_controls( $this, 'use_as' );
			alpha_elementor_slider_layout_controls( $this, 'use_as' );

		$this->end_controls_section();

		$this->start_controls_section(
			'column_acc',
			array(
				'label'     => esc_html__( 'Accordion Content', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'accordion_content',
				),
			)
		);

			$this->add_control(
				'accordion_title',
				array(
					'label' => esc_html__( 'Accordion Title', 'pandastore-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			$this->add_control(
				'accordion_header_icon',
				array(
					'label'            => esc_html__( 'Icon', 'pandastore-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'accordion_heading',
				array(
					'label'     => esc_html__( 'Header Icon', 'pandastore-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'accordion_header_icon[value]!' => '',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'accordion_icon_typography',
					'separator' => 'before',
					'label'     => esc_html__( 'Header Icon Typography', 'pandastore-core' ),
					'selector'  => '.elementor-element-{{ID}} .card-header a > i:first-child',
					'condition' => array(
						'accordion_header_icon[value]!' => '',
					),
				)
			);

			$this->add_control(
				'accordion_color_icon_space',
				array(
					'label'     => esc_html__( 'Header Icon Space', 'pandastore-core' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						'.elementor-element-{{ID}} .card-header a > i:first-child' => "margin-{$right}: {{VALUE}}px;",
					),
					'condition' => array(
						'accordion_header_icon[value]!' => '',
					),
				)
			);
			$this->add_responsive_control(
				'accordion_content_pad',
				array(
					'label'      => esc_html__( 'Accordion Content Padding', 'pandastore-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.elementor-element .card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'column_tab',
			array(
				'label'     => esc_html__( 'Tab Content', 'pandastore-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'tab_content',
				),
			)
		);

			$this->add_control(
				'tab_title',
				array(
					'type'  => Controls_Manager::TEXT,
					'label' => esc_html__( 'Tab Title', 'pandastore-core' ),
				)
			);

			$this->add_control(
				'tab_icon',
				array(
					'label'       => esc_html__( 'Tab Icon', 'pandastore-core' ),
					'description' => esc_html__( 'Choose icon for title of each tab item.', 'pandastore-core' ),
					'type'        => Controls_Manager::ICONS,
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_pos',
				array(
					'label'       => esc_html__( 'Tab Icon Position', 'pandastore-core' ),
					'description' => esc_html__( 'Choose icon position of each tab nav. Choose from Left, Up, Right, Bottom.', 'pandastore-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'left',
					'options'     => array(
						'left'  => esc_html__( 'Left', 'pandastore-core' ),
						'right' => esc_html__( 'Right', 'pandastore-core' ),
						'up'    => esc_html__( 'Up', 'pandastore-core' ),
						'down'  => esc_html__( 'Down', 'pandastore-core' ),
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_space',
				array(
					'label'       => esc_html__( 'Tab Icon Spacing (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls spacing between icon and label in tab item header.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 10,
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 30,
						),
					),
					'selectors'   => array(
						'.nav-icon-left .nav-link[href="{{ID}}"] i' => "margin-{$right}: {{SIZE}}px;",
						'.nav-icon-right .nav-link[href="{{ID}}"] i' => "margin-{$left}: {{SIZE}}px;",
						'.nav-icon-up .nav-link[href="{{ID}}"] i' => 'margin-bottom: {{SIZE}}px;',
						'.nav-icon-down .nav-link[href="{{ID}}"] i' => 'margin-top: {{SIZE}}px;',
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_size',
				array(
					'label'       => esc_html__( 'Tab Icon Size (px)', 'pandastore-core' ),
					'description' => esc_html__( 'Controls icon size of tab item header.', 'pandastore-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'selectors'   => array(
						'.tab .nav-link[href="{{ID}}"] i' => 'font-size: {{SIZE}}px;',
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_banner_layer_layout_controls( $this, 'use_as' );
		alpha_elementor_slider_style_controls( $this, 'use_as' );

		alpha_elementor_addon_controls( $this );
	}

	protected function content_template() {
		$is_legacy_mode_active = ! alpha_elementor_if_dom_optimization();
		$wrapper_element       = $is_legacy_mode_active ? 'column' : 'widget';
		?>
		<#
			let wrapper_class = '';
			let wrapper_attrs = '';
			let extra_class = '';
			let extra_attrs = '';

			let grid_item = {};

			if ( 'slider' == settings.use_as ) {
				<?php
					alpha_elementor_grid_template();
					alpha_elementor_slider_template();
				if ( $is_legacy_mode_active ) {
					?>
					if ('thumb' == settings.dots_type) {
						wrapper_class += ' flex-wrap';
					}
					<?php
				} else {
					?>
					extra_attrs += ' data-slider-class="' + extra_class + '"';
					extra_class  = '';
					<?php
				}
				?>
			}

			if ( settings.creative_width ) {
				grid_item['w'] = settings.creative_width;
			}
			if ( settings.creative_width_tablet ) {
				grid_item['w-l'] = settings.creative_width_tablet;
			}
			if ( settings.creative_width_mobile ) {
				grid_item['w-m'] = settings.creative_width_mobile;
			}

			if ( 'child' != settings.creative_height ) {
				grid_item['h'] = settings.creative_height;
			}
			if ( settings.creative_height_tablet && 'preset' != settings.creative_height_tablet && 'child' != settings.creative_height_tablet ) {
				grid_item['h-l'] = settings.creative_height_tablet;
			}
			if ( settings.creative_height_mobile && 'preset' != settings.creative_height_mobile && 'child' != settings.creative_height_mobile ) {
				grid_item['h-m'] = settings.creative_height_mobile;
			}

			if ( settings.creative_order ) {
				wrapper_attrs += ' data-creative-order="' + settings.creative_order + '"';
			}
			if ( settings.creative_order_tablet ) {
				wrapper_attrs += ' data-creative-order-lg="' + settings.creative_order_tablet + '"';
			}
			if ( settings.creative_order_mobile ) {
				wrapper_attrs += ' data-creative-order-md="' + settings.creative_order_mobile + '"';
			}

			wrapper_attrs += 'data-creative-item=' + JSON.stringify(grid_item);

			if ( 'banner_layer' == settings.use_as ) { // if banner content
				wrapper_attrs += ' data-banner-class="banner-content ' + (settings.banner_origin ? settings.banner_origin : '') + '"';
			}

			if( 'tab_content' == settings.use_as ) {
				wrapper_attrs += ' data-role="tab-pane"';
				wrapper_attrs += ' data-tab-title="' + settings.tab_title + '"';
				wrapper_attrs += ' data-tab-icon="' + (settings.tab_icon ? settings.tab_icon.value : '') + '"';
				wrapper_attrs += ' data-tab-icon-pos="' + settings.tab_icon_pos + '"';
			}

			if( 'accordion_content' == settings.use_as ) {
				wrapper_attrs += ' data-accordion-title="' + settings.accordion_title + '"';
				wrapper_attrs += ' data-accordion-icon="' + ( settings.accordion_header_icon ? settings.accordion_header_icon.value : '' ) + '"';
				wrapper_class += ' card-body expanded';
			}

			if ( settings.css_classes ) {
				wrapper_attrs += ' data-css-classes="' + settings.css_classes + '"';
			}
		#>
		<# if( 'accordion_content' == settings.use_as ) { #>
			<div class="card-header"></div>
		<# } #>
		<?php if ( $is_legacy_mode_active ) { ?>
			<div class="elementor-<?php echo esc_attr( $wrapper_element ); ?>-wrap{{ wrapper_class }}" {{{ wrapper_attrs }}}>
		<?php } else { ?>
			<div class="elementor-<?php echo esc_attr( $wrapper_element ); ?>-wrap{{ wrapper_class }} {{ extra_class }}" {{{ wrapper_attrs }}} {{{extra_attrs}}}>
		<?php } ?>

			<div class="elementor-background-overlay"></div>
			<?php if ( $is_legacy_mode_active ) { ?>
				<div class="elementor-widget-wrap{{{ extra_class }}}" {{{ extra_attrs }}}></div>
			</div>
			<# if( 'slider' == settings.use_as && 'yes' == settings.show_dots && 'thumb' == settings.dots_type ) { #>
				<div class="slider-thumb-dots dots-bordered slider-thumb-dots-{{{view.getID()}}}">
				<#
					if ( settings.thumbs.length ) {
						settings.thumbs.map(function(img) {
						#>
							<button class="slider-pagination-bullet">
								<img src="{{{img['url']}}}">
							</button>
						<#
						});
					}
				#>
				</div>
			<# } #>
		<?php } else { ?>
			</div>
		<?php } ?>

		<?php if ( ! $is_legacy_mode_active ) { ?>
			<# if( 'slider' == settings.use_as && 'yes' == settings.show_dots && 'thumb' == settings.dots_type ) { #>
				<div class="slider-thumb-dots dots-bordered slider-thumb-dots-{{{view.getID()}}}">
				<#
					if ( settings.thumbs.length ) {
						settings.thumbs.map(function(img) {
						#>
							<button class="slider-pagination-bullet">
								<img src="{{{img['url']}}}">
							</button>
						<#
						});
					}
				#>
				</div>
			<# } #>
			<?php
		}
	}

	public function before_render() {
		$settings = $this->get_settings_for_display();

		$has_background_overlay = in_array( $settings['background_overlay_background'], array( 'classic', 'gradient' ), true ) || in_array( $settings['background_overlay_hover_background'], array( 'classic', 'gradient' ), true );

		$is_legacy_mode_active    = ! alpha_elementor_if_dom_optimization();
		$wrapper_attribute_string = $is_legacy_mode_active ? '_inner_wrapper' : '_widget_wrapper';

		$column_wrap_classes = $is_legacy_mode_active ? array( 'elementor-column-wrap' ) : array( 'elementor-widget-wrap' );

		if ( $this->get_children() ) {
			$column_wrap_classes[] = 'elementor-element-populated';
		}

		if ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_type'] ) {
			// if ( $is_legacy_mode_active ) {
				// $column_wrap_classes[] = 'flex-wrap';
			// } else {
				$this->add_render_attribute( '_wrapper', 'class', 'flex-wrap' );
			// }
		}

		$this->add_render_attribute(
			array(
				'_inner_wrapper'      => array(
					'class' => $column_wrap_classes,
				),
				'_widget_wrapper'     => array(
					'class' => $is_legacy_mode_active ? 'elementor-widget-wrap' : $column_wrap_classes,
				),
				'_background_overlay' => array(
					'class' => array( 'elementor-background-overlay' ),
				),
			)
		);
		?>
		<<?php echo alpha_escaped( $this->get_html_tag() . ' ' . $this->get_render_attribute_string( '_wrapper' ) ); ?>>
			<?php
			if ( 'accordion_content' == $settings['use_as'] ) : // accordion header
				global $alpha_section;
				?>
				<div class="card-header">
					<a href="<?php echo esc_attr( $this->get_data( 'id' ) ); ?>" class="<?php echo 1 == $alpha_section['index'] ? 'collapse' : 'expand'; ?>">
						<?php
						if ( $settings['accordion_header_icon']['value'] ) {
							echo '<i class="' . $settings['accordion_header_icon']['value'] . '"></i>';
						}
						?>
						<span class="title"><?php echo alpha_escaped( $settings['accordion_title'] ? esc_html( $settings['accordion_title'] ) : esc_html__( 'Untitled', 'pandastore-core' ) ); ?></span>
						<?php
						if ( $alpha_section['active_icon'] && $alpha_section['active_icon']['value'] ) {
							echo '<span class="toggle-icon opened"><i class="' . esc_attr( $alpha_section['active_icon']['value'] ) . '"></i></span>';
						}
						if ( $alpha_section['icon'] && $alpha_section['icon']['value'] ) {
							echo '<span class="toggle-icon closed"><i class="' . esc_attr( $alpha_section['icon']['value'] ) . '"></i></span>';
						}
						?>
					</a>
				</div>
			<?php endif; ?>

			<div <?php $this->print_render_attribute_string( '_inner_wrapper' ); ?>>
		<?php if ( $has_background_overlay ) : ?>
			<div <?php $this->print_render_attribute_string( '_background_overlay' ); ?>></div>
		<?php endif; ?>
		<?php if ( $is_legacy_mode_active ) : ?>
			<div <?php $this->print_render_attribute_string( '_widget_wrapper' ); ?>>
		<?php endif; ?>
		<?php
		if ( 'slider' == $settings['use_as'] && ! $is_legacy_mode_active ) {
			$this->is_slider_wrap = true;
			$col_cnt              = alpha_elementor_grid_col_cnt( $settings );
			$slider_class         = alpha_get_col_class( $col_cnt ) . ' ' . alpha_get_grid_space_class( $settings ) . ' ' . alpha_get_slider_class( $settings );
			$slider_attrs         = alpha_get_slider_attrs( $settings, $col_cnt, $this->get_data( 'id' ) );
			if ( ! $is_legacy_mode_active ) {
				echo '<div class="w-100">';
			}
			?>
			<div class="<?php echo esc_attr( $slider_class ); ?>" data-slider-options="<?php echo esc_attr( json_encode( $slider_attrs ) ); ?>">
			<?php
		}
	}

	public function after_render() {
		$settings              = $this->get_settings_for_display();
		$is_legacy_mode_active = ! alpha_elementor_if_dom_optimization();

		if ( $is_legacy_mode_active ) {
			?>
			</div>
			<?php
		}

		if ( $this->is_slider_wrap ) {
			?>
			</div>
			<?php
			if ( ! $is_legacy_mode_active ) {
				?>
			</div>
				<?php
			}
		}
		if ( 'slider' != $settings['use_as'] || 'thumb' != $settings['dots_type'] || $is_legacy_mode_active ) {
			?>
				</div>
			<?php
		}

		if ( 'slider' == $settings['use_as'] && 'yes' == $settings['show_dots'] && 'thumb' == $settings['dots_type'] ) {
			if ( ! $is_legacy_mode_active ) {
				?>
				</div>
				<?php
			}
			?>
			<div class="slider-thumb-dots dots-bordered <?php echo 'slider-thumb-dots-' . esc_attr( $this->get_data( 'id' ) ); ?>">
				<?php
				if ( count( $settings['thumbs'] ) ) {
					$first = true;
					foreach ( $settings['thumbs'] as $thumb ) {
						echo '<button class="slider-pagination-bullet' . ( $first ? ' active' : '' ) . '">';
						echo wp_get_attachment_image( $thumb['id'] );
						echo '</button>';
						$first = false;
					}
				} else {

				}
				?>
			</div>
		<?php } ?>

		</<?php echo esc_html( $this->get_html_tag() ); ?>>
				<?php
	}
}

if ( ! function_exists( 'alpha_column_render_attributes' ) ) {
	/**
	 * Add render attributes for columns.
	 *
	 * @since 1.0
	 */
	function alpha_column_render_attributes( $self ) {

		global $alpha_section;

		$settings = $self->get_settings_for_display();

		$inner_args   = array();
		$widget_args  = array();
		$wrapper_args = array( 'class' => '' );

		$is_legacy_mode_active = ! alpha_elementor_if_dom_optimization();

		global $alpha_section;

		if ( isset( $alpha_section['section'] ) && 'creative' == $alpha_section['section'] && $alpha_section['top'] == $self->get_data( 'isInner' ) ) { // creative
			$idx       = $alpha_section['index'];
			$classes[] = 'grid-item';
			$grid      = array();
			if ( $idx < count( $alpha_section['preset'] ) ) {
				foreach ( $alpha_section['preset'][ $idx ] as $key => $value ) {
					if ( 'h' == $key ) {
						continue;
					}

					$grid[ $key ] = $value;
				}
			} else {
				$grid['w']   = '1-4';
				$grid['w-l'] = '1-2';
			}

			if ( isset( $settings['creative_width'] ) && $settings['creative_width'] ) {
				$grid['w'] = $grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width'];
			}
			if ( isset( $settings['creative_width_tablet'] ) && $settings['creative_width_tablet'] ) {
				$grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width_tablet'];
			}
			if ( isset( $settings['creative_width_mobile'] ) && $settings['creative_width_mobile'] ) {
				$grid['w-m'] = $grid['w-s'] = $settings['creative_width_mobile'];
			}

			if ( isset( $settings['creative_height'] ) && 'preset' == $settings['creative_height'] ) {
				$grid['h'] = $idx < count( $alpha_section['preset'] ) ? $alpha_section['preset'][ $idx ]['h'] : '1-3';
			} elseif ( isset( $settings['creative_height'] ) && 'child' != $settings['creative_height'] ) {
				$grid['h'] = $settings['creative_height'];
			}

			if ( isset( $settings['creative_height_tablet'] ) && $settings['creative_height_tablet'] && 'preset' != $settings['creative_height_tablet'] && 'child' != $settings['creative_height_tablet'] ) {
				$grid['h-l'] = $settings['creative_height_tablet'];
			}
			if ( isset( $settings['creative_height_mobile'] ) && $settings['creative_height_mobile'] && 'preset' != $settings['creative_height_mobile'] && 'child' != $settings['creative_height_mobile'] ) {
				$grid['h-m'] = $settings['creative_height_mobile'];
			}

			if ( isset( $settings['creative_order'] ) && $settings['creative_order'] ) {
				$wrapper_args['data-creative-order'] = $settings['creative_order'];
			} else {
				$wrapper_args['data-creative-order'] = $idx + 1;
			}
			if ( isset( $settings['creative_order_tablet'] ) && $settings['creative_order_tablet'] ) {
				$wrapper_args['data-creative-order-lg'] = $settings['creative_order_tablet'];
			} else {
				$wrapper_args['data-creative-order-lg'] = $idx + 1;
			}
			if ( isset( $settings['creative_order_mobile'] ) && $settings['creative_order_mobile'] ) {
				$wrapper_args['data-creative-order-md'] = $settings['creative_order_mobile'];
			} else {
				$wrapper_args['data-creative-order-md'] = $idx + 1;
			}

			foreach ( $grid as $key => $value ) {
				if ( false !== strpos( $key, 'w' ) && is_numeric( $value ) && 1 != $value ) {
					if ( 0 == 100 % $value ) {
						if ( 100 == $value ) {
							$grid[ $key ] = '1';
						} else {
							$grid[ $key ] = '1-' . ( 100 / $value );
						}
					} else {
						for ( $i = 1; $i <= 100; ++$i ) {
							$val       = $value * $i;
							$val_round = round( $val );
							if ( abs( round( $val - $val_round, 2, PHP_ROUND_HALF_UP ) ) <= 0.01 ) {
								$g            = alpha_get_gcd( 100, $val_round );
								$grid[ $key ] = ( $val_round / $g ) . '-' . ( $i * 100 / $g );
								break;
							}
						}
					}
				}
			}

			$alpha_section['layout'][ $idx ] = $grid;
			foreach ( $grid as $key => $value ) {
				if ( $value ) {
					$classes[] = $key . '-' . $value;
				}
			}
			$alpha_section['index'] = ++$idx;

			$wrapper_args['class'] .= implode( ' ', $classes );
		}

		if ( 'slider' == $settings['use_as'] ) { // if using as slider
			if ( $is_legacy_mode_active ) {
				$col_cnt = alpha_elementor_grid_col_cnt( $settings );

				$extra_class   = alpha_get_col_class( $col_cnt );
				$extra_class  .= ' ' . alpha_get_grid_space_class( $settings );
				$extra_class  .= ' ' . alpha_get_slider_class( $settings );
				$extra_options = alpha_get_slider_attrs( $settings, $col_cnt, $self->get_data( 'id' ) );

				if ( $is_legacy_mode_active ) {
					$widget_args['class']               = $extra_class;
					$widget_args['data-slider-options'] = esc_attr( json_encode( $extra_options ) );
				} else {
					$inner_args['class']               = $extra_class;
					$inner_args['data-slider-options'] = esc_attr( json_encode( $extra_options ) );
				}
			}
		} elseif ( 'banner_layer' == $settings['use_as'] ) { // if banner content
			$wrapper_args['class'] .= ' banner-content';
			if ( $settings['banner_origin'] ) {
				$wrapper_args['class'] .= ' ' . $settings['banner_origin'];
			}
		} elseif ( 'tab_content' == $settings['use_as'] ) { // tab content
			$classes[]                 = ' tab-pane';
			$wrapper_args['data-role'] = ' tab-pane';
			$wrapper_args['id']        = $self->get_data( 'id' );
			if ( isset( $alpha_section['section'] ) ) {
				$alpha_section['tab_data'][] = array(
					'title'    => $settings['tab_title'],
					'icon'     => $settings['tab_icon']['value'],
					'icon_pos' => $settings['tab_icon_pos'],
					'id'       => $self->get_data( 'id' ),
				);

				if ( 'tab' == $alpha_section['section'] && 0 == $alpha_section['index'] ) {
					$classes[] = 'active';
				}
			}
			$alpha_section['index'] = ++$alpha_section['index'];
			$wrapper_args['class'] .= ' ' . implode( ' ', $classes );
		} elseif ( 'accordion_content' == $settings['use_as'] ) {
			if ( isset( $alpha_section['section'] ) ) {
				$inner_args['id']       = $self->get_data( 'id' );
				$wrapper_args['class'] .= ' card';
				if ( 'accordion' == $alpha_section['section'] ) {
					if ( 0 == $alpha_section['index'] ) {
						$inner_args['class'] = 'card-body expanded';
					} else {
						$inner_args['class'] = 'card-body collapsed';
					}
				}
				$alpha_section['index'] = ++$alpha_section['index'];
			}
		}

		$self->add_render_attribute(
			array(
				'_wrapper'        => alpha_get_additional_options( $settings, $wrapper_args ),
				'_inner_wrapper'  => $inner_args,
				'_widget_wrapper' => $widget_args,
			)
		);

		if ( $settings['background_image'] && $settings['background_image']['url'] && function_exists( 'alpha_get_option' ) && alpha_get_option( 'lazyload' ) ) {
			if ( ! is_admin() && ! is_customize_preview() && ! alpha_doing_ajax() ) {
				$data = array(
					'data-lazy' => esc_url( $settings['background_image']['url'] ),
				);
				if ( ! $settings['background_color'] ) {
					$data['style'] = 'background: ' . alpha_get_option( 'lazyload_bg' ) . ';';
				}
				$self->add_render_attribute( array( '_inner_wrapper' => $data ) );
			}
		}
	}
}
