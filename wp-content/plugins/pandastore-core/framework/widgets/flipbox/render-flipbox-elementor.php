<?php
/**
 * Flipbox Shortcode Render
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Icons_Manager;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// front side
			'front_side_icon'          => '',
			'front_side_title'         => '',
			'front_side_subtitle'      => '',
			'front_side_content'       => '',
			'front_icon_type'          => '',
			'front_icon_shape'         => '',
			'front_side_align'         => 'center',

			// back side
			'back_side_title'          => '',
			'back_side_subtitle'       => '',
			'back_side_content'        => '',
			'back_side_button_text'    => '',
			'back_side_button_link'    => '',
			'back_icon_type'           => '',
			'back_icon_shape'          => '',
			'back_side_align'          => 'center',

			// effect
			'flipbox_animation_effect' => '',

			// For elementor inline editing
			'self'                     => null,
		),
		$atts
	)
);

$widget_id     = $this->get_id();
$flipbox_class = array( 'flipbox' );

if ( $flipbox_animation_effect ) {
	$flipbox_class[] = explode( '-', $flipbox_animation_effect )[1];
	$flipbox_class[] = $flipbox_animation_effect;
}


/**
 * Render flipbox front and back side content
 *
 * @since 1.0
 */
if ( ! function_exists( 'render_flipbox_conent' ) ) {
	function render_flipbox_conent( $self, $atts, $mode = 'front' ) {
		$html = '';
		ob_start();

		$btn_class  = 'btn';
		$btn_class .= ' ' . implode( ' ', alpha_widget_button_get_class( $atts, $mode . '_' ) );
		$btn_label  = alpha_widget_button_get_label( $atts, $self, $atts[ $mode . '_side_button_text' ], 'label', $mode . '_' );

		// Icon
		$icon_wrap_class = array( 'flipbox-icon' );
		if ( $atts[ $mode . '_icon_type' ] ) {
			$icon_wrap_class[] = $atts[ $mode . '_icon_type' ];
		}
		if ( $atts[ $mode . '_icon_shape' ] ) {
			$icon_wrap_class[] = $atts[ $mode . '_icon_shape' ];
		}
		if ( $atts[ $mode . '_side_icon' ] && $atts[ $mode . '_side_icon' ]['value'] ) :
			?>
		<div class="flipbox-icon-wrap">
			<span class="<?php echo esc_attr( implode( ' ', $icon_wrap_class ) ) . ( 'svg' == $atts[ $mode . '_side_icon' ]['library'] ? ' flipbox-svg' : '' ); ?>">
			<?php
			if ( 'svg' == $atts[ $mode . '_side_icon' ]['library'] ) :
				Icons_Manager::render_icon( $atts[ $mode . '_side_icon' ], [ 'aria-hidden' => 'true' ] );
			else :
				?>
				<i class="<?php echo esc_attr( $atts[ $mode . '_side_icon' ]['value'] ); ?>"></i>
			<?php endif; ?>
			</span>
		</div>
		<?php endif; ?>

		<div class="flipbox-content">
			<!-- Title -->
			<?php
			if ( $atts[ $mode . '_side_title' ] ) :
				$self->add_render_attribute( $mode . '_side_title', 'class', 'flipbox-title' );
				?>
			<h3 <?php $self->print_render_attribute_string( $mode . '_side_title' ); ?>>
				<?php echo esc_html( $atts[ $mode . '_side_title' ] ); ?>
			</h3>
			<?php endif; ?>

			<!-- Subtitle -->
			<?php
			if ( $atts[ $mode . '_side_subtitle' ] ) :
				$self->add_render_attribute( $mode . '_side_subtitle', 'class', 'flipbox-subtitle' );
				?>
			<h4 <?php $self->print_render_attribute_string( $mode . '_side_subtitle' ); ?>>
				<?php echo esc_html( $atts[ $mode . '_side_subtitle' ] ); ?>
			</h4>
			<?php endif; ?>

			<!-- Description -->
			<?php
			if ( $atts[ $mode . '_side_content' ] ) :
				$self->add_render_attribute( $mode . '_side_content', 'class', 'flipbox-description' );
				?>
			<p <?php $self->print_render_attribute_string( $mode . '_side_content' ); ?>>
				<?php echo esc_html( $atts[ $mode . '_side_content' ] ); ?>
			</p>
			<?php endif; ?>

			<!-- View more button -->
			<?php
			if ( $atts[ $mode . '_side_button_text' ] ) {
				$self->add_render_attribute( $mode . '_side_button_text', 'class', $btn_class );
				printf( '<a ' . $self->get_render_attribute_string( $mode . '_side_button_text' ) . ' href="' . esc_url( ! empty( $atts[ $mode . '_side_button_link' ]['url'] ) ? $atts[ $mode . '_side_button_link' ]['url'] : '#' ) . '"' . ( ! empty( $atts[ $mode . '_side_button_link' ]['is_external'] ) ? ' target="_blank"' : '' ) . ( ! empty( $atts[ $mode . '_side_button_link' ]['nofollow'] ) ? ' rel="nofollow"' : '' ) . '>%1$s</a>', alpha_strip_script_tags( $btn_label ) );
			}
			?>
		</div>
		<?php
		$html .= ob_get_clean();

		return $html;
	}
}

?>

<div id="flipbox-<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( implode( ' ', $flipbox_class ) ); ?>" data-flipbox-settings="{
	'effect': <?php echo esc_attr( $flipbox_animation_effect ); ?>
}">
	<!-- Front Side Content -->
	<div id="flipbox_front-<?php echo esc_attr( $widget_id ); ?>" class="flipbox_front<?php echo esc_attr( ' ' . $front_side_align . '-align' ); ?>">
		<?php echo render_flipbox_conent( $this, $atts, 'front' ); ?>
	</div>

	<!-- Back Side Content -->
	<div id="flipbox_back-<?php echo esc_attr( $widget_id ); ?>" class="flipbox_back<?php echo esc_attr( ' ' . $back_side_align . '-align' ); ?>">
		<?php echo render_flipbox_conent( $this, $atts, 'back' ); ?>
	</div>
</div>

<?php
