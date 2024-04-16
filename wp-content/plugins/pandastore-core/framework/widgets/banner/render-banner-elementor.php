<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Banner Widget Render
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'stretch_height'             => '',
			'banner_item_list'           => array(),
			'banner_origin'              => '',
			'banner_wrap'                => '',
			'parallax'                   => '',
			'_content_animation'         => '',
			'content_animation_duration' => '',
			'_content_animation_delay'   => '',

			// For elementor inline editing
			'self'                       => null,
		),
		$atts
	)
);

$banner_class  = array( 'banner' );
$wrapper_class = array( 'banner-content' );

// Banner Overlay
if ( $atts['overlay'] ) {
	$banner_class[] = alpha_get_overlay_class( $atts['overlay'] );
}

// Background Effect
$background_class[] = '';
if ( $atts['background_effect'] ) {
	$background_class[] = $atts['background_effect'];
}

// Particle Effect
$particle_class[] = '';
if ( $atts['particle_effect'] ) {
	$particle_class[] = $atts['particle_effect'];
}

$banner_class[] = 'banner-fixed';

// Banner Origin
$wrapper_class[] = $banner_origin;

if ( 'yes' == $stretch_height ) {
	$banner_class[] = 'banner-stretch';
}

// Parallax
if ( 'yes' == $parallax ) {
	$banner_class[]   = 'parallax';
	$parallax_img     = esc_url( $atts['banner_background_image']['url'] );
	$parallax_options = array(
		'speed'          => $atts['parallax_speed']['size'] ? 10 / $atts['parallax_speed']['size'] : 1.5,
		'parallaxHeight' => $atts['parallax_height']['size'] ? $atts['parallax_height']['size'] . '%' : '300%',
		'offset'         => $atts['parallax_offset']['size'] ? $atts['parallax_offset']['size'] : 0,
	);
	$parallax_options = "data-parallax-options='" . json_encode( $parallax_options ) . "'";
	echo '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '" data-image-src="' . $parallax_img . '" ' . $parallax_options . '>';
} else {
	echo  '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '">';
}

// Background Effect
if ( '' !== $atts['background_effect'] || '' !== $atts['particle_effect'] ) {
	echo '<div class="background-effect-wrapper">';

	if ( ! empty( $atts['banner_background_image'] ) ) {
		if ( '' !== $atts['particle_effect'] && '' == $atts['background_effect'] ) {
			$background_img = '';
		} else {
			$background_img = esc_url( $atts['banner_background_image']['url'] );
		}

		echo '<div class="background-effect ' . esc_attr( implode( ' ', $background_class ) ) . '" style="background-image: url(' . $background_img . '); background-size: cover;">';

		if ( '' !== $atts['particle_effect'] ) {
			echo '<div class="particle-effect ' . esc_attr( implode( ' ', $particle_class ) ) . '"></div>';
		}

		echo '</div>';
	}

	echo '</div>';
}
$banner_img_cls = '';
if ( isset( $atts['background_effect'] ) && ! empty( $atts['background_effect'] ) ) {
	$banner_img_cls = 'banner-img-hidden';
}

/* Image */

if ( isset( $atts['banner_background_image']['id'] ) && $atts['banner_background_image']['id'] ) {
	$banner_img_id = $atts['banner_background_image']['id'];
	?>
	<figure class="banner-img">
		<?php
		$attr = array();
		if ( $atts['banner_background_color'] ) {
			$attr['style'] = 'background-color:' . $atts['banner_background_color'];
		}
		// Display full image for wide banner (width > height * 3).
		$image = wp_get_attachment_image_src( $banner_img_id, 'full' );
		if ( ! empty( $image[1] ) && ! empty( $image[2] ) && $image[2] && $image[1] / $image[2] > 3 ) {
			$attr['srcset'] = $image[0];
		}
		echo wp_get_attachment_image( $banner_img_id, 'full', false, $attr );
		?>
	</figure>
	<?php
} elseif ( isset( $atts['banner_background_image']['url'] ) && $atts['banner_background_image']['url'] ) {
	?>
	<figure class="banner-img">
		<?php echo '<img src="' . esc_url( $atts['banner_background_image']['url'] ) . '" width="1400" height="753">'; ?>
	</figure>
	<?php
}
/* ---- Hotspot part ----*/
foreach ( $banner_item_list as $key => $item ) {
	if ( 'hotspot' == $item['banner_item_type'] ) {
		extract( // @codingStandardsIgnoreLine
			shortcode_atts(
				array(
					// Global Options
					'_id'                    => '',
					'_animation'             => '',
					'animation_duration'     => '',
					'_animation_delay'       => '',
					'banner_item_type'       => '',
					// Hotspot Options
					'hotspot_type'           => 'html',
					'hotspot_html'           => '',
					'hotspot_block'          => '',
					'hotspot_link'           => '#',
					'hotspot_product'        => '',
					'hotspot_image'          => array(),
					'hotspot_icon'           => '',
					'hotspot_popup_position' => 'top',
					'hotspot_el_class'       => '',
					'hotspot_effect'         => '',
					'hotspot_image_size'     => '',
				),
				$item
			)
		);
		$class = array( 'elementor-repeater-item-' . $_id );
		if ( ! empty( $hotspot_el_class ) ) {
			$class[] = $hotspot_el_class;
		}
		$atts['type']           = $hotspot_type;
		$atts['html']           = $hotspot_html;
		$atts['block']          = $hotspot_block;
		$atts['link']           = $hotspot_link;
		$atts['product']        = $hotspot_product;
		$atts['image']          = $hotspot_image;
		$atts['icon']           = $hotspot_icon;
		$atts['popup_position'] = $hotspot_popup_position;
		$atts['el_class']       = implode( ' ', $class );
		$atts['effect']         = $hotspot_effect;
		$atts['image_size']     = $hotspot_image_size;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/hotspot/render-hotspot-elementor.php' );
	}
}

if ( $banner_wrap ) {
	echo '<div class="' . esc_attr( $banner_wrap ) . '">';
}

/* Showing Items */
echo '<div class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '">';

/* Content Animation */
$settings = array( '' );
if ( $_content_animation ) {
	$wrapper_class[] = '';
	$wrapper_class[] = 'animated-' . $content_animation_duration;
	$settings        = array(
		'_animation'       => $_content_animation,
		'_animation_delay' => $_content_animation_delay ? $_content_animation_delay : 0,
	);
	$settings        = " data-settings='" . json_encode( $settings ) . "'";
	echo '<div class="appear-animate animated-' . $content_animation_duration . '" ' . $settings . '>';
}

foreach ( $banner_item_list as $key => $item ) {

	$class = array( 'banner-item' );

	extract( // @codingStandardsIgnoreLine
		shortcode_atts(
			array(
				// Global Options
				'_id'                    => '',
				'banner_item_display'    => '',
				'banner_item_aclass'     => '',
				'_animation'             => '',
				'animation_duration'     => '',
				'_animation_delay'       => '',

				// Text Options
				'banner_item_type'       => '',
				'banner_text_tag'        => 'h2',
				'banner_text_content'    => '',

				// Image Options
				'banner_image'           => '',
				'banner_image_size'      => 'full',
				'img_link_to'            => 'none',
				'img_link'               => esc_html__( 'https://your-link.com', 'pandastore-core' ),

				// Button Options
				'banner_btn_text'        => '',
				'banner_btn_link'        => '',
				'banner_btn_aclass'      => '',

				// Hotspot Options
				'hotspot_type'           => 'html',
				'hotspot_html'           => '',
				'hotspot_block'          => '',
				'hotspot_link'           => '#',
				'hotspot_product'        => '',
				'hotspot_image'          => array(),
				'hotspot_icon'           => '',
				'hotspot_popup_position' => 'top',
				'hotspot_el_class'       => '',
				'hotspot_effect'         => '',
				'hotspot_image_size'     => '',
			),
			$item
		)
	);
	$class[] = 'elementor-repeater-item-' . $_id;

	// Custom Class
	if ( $banner_item_aclass ) {
		$class[] = $banner_item_aclass;
	}

	// Animation
	$settings = '';
	if ( $_animation ) {
		$class[]  = 'appear-animate';
		$class[]  = 'animated-' . $animation_duration;
		$settings = array(
			'_animation'       => $_animation,
			'_animation_delay' => $_animation_delay ? $_animation_delay : 0,
		);
		$settings = " data-settings='" . json_encode( $settings ) . "'";
	}

	// Item display type
	if ( 'yes' != $banner_item_display && 'hotspot' != $banner_item_type ) {
		$class[] = 'item-block';
	} else {
		$class[] = 'item-inline';
	}

	$floating_options = alpha_get_additional_options( $item );
	$floating_attrs   = '';
	if ( ! empty( $floating_options ) ) {
		foreach ( $floating_options as $key => $value ) {
			$floating_attrs .= $key . "='" . $value . "' ";
		}

		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . '" ' . $settings . '>';
		$class     = [];
		$setttings = '';

		echo '<div class="floating-wrapper layer-wrapper elementor-repeater-item-' . $_id . '-wrapper" ' . $floating_attrs . '>';

		if ( 0 === strpos( $item['alpha_floating'], 'mouse_tracking' ) ) {
			echo '<div class="layer">';
		}
	}
	if ( 'text' == $banner_item_type ) { // Text

		$class[] = 'text';

		if ( $self ) {
			$repeater_setting_key = $self->get_repeater_setting_key( 'banner_text_content', 'banner_item_list', $key );
			$self->add_render_attribute( $repeater_setting_key, 'class', $class );
			if ( ALPHA_NAME . '_widget_banner' == $self->get_name() ) {
				$self->add_inline_editing_attributes( $repeater_setting_key );
			}
		}

		echo sprintf(
			'<%1$s ' . ( $self ? $self->get_render_attribute_string( $repeater_setting_key ) : '' ) . $settings . '>%2$s</%1$s>',
			esc_attr( $banner_text_tag ),
			do_shortcode( alpha_strip_script_tags( $banner_text_content ) )
		);
	} elseif ( 'image' == $banner_item_type ) { // Image
		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . ' image" ' . $settings . '>';
		if ( 'custom' == $img_link_to ) {
			echo '<a href="' . esc_url( isset( $img_link['url'] ) ? $img_link['url'] : '#' ) . '"' . ( ( isset( $img_link['is_external'] ) && $img_link['is_external'] ) ? ' target="_blank"' : '' ) . ( ( isset( $img_link['nofollow'] ) && $img_link['nofollow'] ) ? ' rel="nofollow"' : '' ) . '>';
		}
		echo wp_get_attachment_image(
			$banner_image['id'],
			$banner_image_size,
			false,
			''
		);
		if ( 'custom' == $img_link_to ) {
			echo '</a>';
		}
		echo '</div>';

	} elseif ( 'button' == $banner_item_type ) { // Button

		$class[] = ' btn';
		if ( $banner_btn_aclass ) {
			$class[] = $banner_btn_aclass;
		}
		if ( ! $banner_btn_text ) {
			$banner_btn_text = esc_html__( 'Click here', 'pandastore-core' );
		}

		if ( $self ) {
			$repeater_setting_key = $self->get_repeater_setting_key( 'banner_btn_text', 'banner_item_list', $key );
			if ( ALPHA_NAME . '_widget_banner' == $self->get_name() ) {
				$self->add_inline_editing_attributes( $repeater_setting_key );
			}
			$banner_btn_text = alpha_widget_button_get_label( $item, $self, $banner_btn_text, $repeater_setting_key );
		}

		$class[] = implode( ' ', alpha_widget_button_get_class( $item ) );

		$attrs           = [];
		$attrs['href']   = ! empty( $banner_btn_link['url'] ) ? esc_url( $banner_btn_link['url'] ) : '#';
		$attrs['target'] = ! empty( $banner_btn_link['is_external'] ) ? '_blank' : '';
		$attrs['rel']    = ! empty( $banner_btn_link['nofollow'] ) ? 'nofollow' : '';
		if ( ! empty( $banner_btn_link['custom_attributes'] ) ) {
			foreach ( explode( ',', $banner_btn_link['custom_attributes'] ) as $attr ) {
				$key   = explode( '|', $attr )[0];
				$value = implode( ' ', array_slice( explode( '|', $attr ), 1 ) );
				if ( isset( $attrs[ $key ] ) ) {
					$attrs[ $key ] .= ' ' . $value;
				} else {
					$attrs[ $key ] = $value;
				}
			}
		}
		$link_attrs = '';
		foreach ( $attrs as $key => $value ) {
			if ( ! empty( $value ) ) {
				$link_attrs .= $key . '="' . esc_attr( $value ) . '" ';
			}
		}

		echo sprintf( '<a class="' . esc_attr( implode( ' ', $class ) ) . '" ' . $link_attrs . $settings . '>%1$s</a>', alpha_strip_script_tags( $banner_btn_text ) );
	} elseif ( 'hotspot' == $banner_item_type ) {
	} else {
		$class[] = 'divider-wrap';
		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . '" ' . $settings . '><hr class="divider"></div>';
	}

	if ( ! empty( $floating_options ) ) {
		if ( 0 === strpos( $item['alpha_floating'], 'mouse_tracking' ) ) {
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
}

echo '</div>';

if ( $_content_animation ) {
	echo '</div>';
}

if ( $banner_wrap ) {
	echo '</div>';
}

echo  '</div>';
