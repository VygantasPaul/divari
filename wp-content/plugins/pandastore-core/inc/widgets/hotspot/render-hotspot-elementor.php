<?php
/**
 * The hotspot render
 *
 * @author     D-THEMES
 * @package    PandaStore Core
 * @subpackage Core
 * @since      1.0
 */
use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'hotspot_type'   => 'type1',
			'type'           => 'html',
			'html'           => '',
			'block'          => '',
			'link'           => '#',
			'product'        => '',
			'image'          => array(),
			'icon'           => '',
			'popup_position' => 'top',
			'el_class'       => '',
			'effect'         => '',
			'page_builder'   => '',
			'image_size'     => '',
		),
		$atts
	)
);

if ( $icon && ! is_array( $icon ) ) {
	$icon = json_decode( $icon, true );
	if ( isset( $icon['icon'] ) ) {
		$icon['value'] = $icon['icon'];
	} else {
		$icon['value'] = '';
	}
}

$url        = isset( $link['url'] ) ? esc_url( $link['url'] ) : '#';
$product_id = $product;

if ( ! is_numeric( $product_id ) && is_string( $product_id ) ) {
	$product_id = alpha_get_post_id_by_name( 'product', $product_id );
}

$wrapper_class   = array( 'hotspot-wrapper' );
$wrapper_class[] = $el_class;

// Type
$wrapper_class[] = 'hotspot-' . $type;

// Effect
if ( $effect ) {
	$wrapper_class[] = 'hotspot-' . $effect;
}

$wrapper_class[] = $hotspot_type;

?>
<div class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
	<a href="<?php echo esc_url( 'product' == $type && $product_id ? get_permalink( $product_id ) : $url ); ?>"
		<?php echo ( ( isset( $link['is_external'] ) && $link['is_external'] ) ? ' target="_blank"' : '' ) . ( ( isset( $link['nofollow'] ) && $link['nofollow'] ) ? ' rel="nofollow"' : '' ); ?>
		class="hotspot<?php echo ( ( 'product' == $type && $product_id ) ? ' btn-quickview' : '' ); ?>"<?php echo ( 'product' == $type && $product_id ) ? ( ' data-product="' . $product_id . '"' ) : ''; ?>
		<?php echo ( ( 'product' == $type && $product_id && function_exists( 'alpha_get_product_featured_image_src' ) ) ? ' data-mfp-src="' . alpha_get_product_featured_image_src( wc_get_product( $product_id ) ) . '"' : '' ); ?>>

		<?php if ( 'type1' == $hotspot_type && $icon['value'] ) : ?>
			<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
		<?php endif; ?>
	</a>
	<?php if ( 'none' != $popup_position ) : ?>
	<div class="hotspot-box hotspot-box-<?php echo esc_attr( $popup_position ); ?>">
		<?php
		if ( 'html' == $type ) {
			echo do_shortcode( $html );
		} elseif ( 'block' == $type ) {
			alpha_print_template( $block );
		} elseif ( 'image' == $type ) {
			$image_html = '';
			if ( ! empty( $image ) ) {
				if ( $page_builder ) {
					$image_html = wp_get_attachment_image( $image, $image_size );
				} else {
					$image_html = Group_Control_Image_Size::get_attachment_image_html( $atts, 'image' );
				}
			}

			echo '<figure>' . $image_html . '</figure>';
		} elseif ( $product_id && class_exists( 'WooCommerce' ) ) {
			$args = array(
				'post_type' => 'product',
				'post__in'  => array( $product_id ),
			);

			$product = new WP_Query( $args );
			while ( $product->have_posts() ) {
				$product->the_post();
				global $post;
				?>
				<?php if ( 'type1' == $hotspot_type ) : ?>
					<div <?php wc_product_class( 'woocommerce product-widget', $post ); ?>>
						<div class="product-media">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
								<?php echo woocommerce_get_product_thumbnail(); ?>
							</a>
						</div>
						<div class="product-body">
							<h3 class="woocommerce-loop-product__title product-title">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
							</h3>
							<?php woocommerce_template_loop_price(); ?>
							<div class="product-loop">
								<?php

								$product_item = wc_get_product( $product_id );
								woocommerce_template_loop_add_to_cart(
									array(
										'class' => implode(
											' ',
											array_filter(
												array(
													'product_type_' . $product_item->get_type(),
													$product_item->is_purchasable() && $product_item->is_in_stock() ? 'add_to_cart_button' : '',
													$product_item->supports( 'ajax_add_to_cart' ) && $product_item->is_purchasable() && $product_item->is_in_stock() ? 'ajax_add_to_cart' : '',
												)
											)
										),
									)
								);
								?>
							</div>
						</div>
					</div>
				<?php elseif ( 'type2' == $hotspot_type ) : ?>
					<div <?php wc_product_class( 'woocommerce product-widget', $post ); ?>>
						<div class="product-body">
							<h3 class="woocommerce-loop-product__title product-title">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
							</h3>
							<div class="product-loop">
								<?php
									$product_item = wc_get_product( $product_id );
									echo '<div class="short-desc">' . alpha_trim_description( $product_item->get_short_description(), 5, 'words' ) . '</div>';
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php
			}
			wp_reset_postdata();
		}
		?>
	</div>
	<?php endif; ?>
</div>
