<?php
/**
 * Header mini-cart template
 *
 * @author     D-THEMES
 * @package    Alpha Core
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( class_exists( 'WooCommerce' ) ) :
	extract( // @codingStandardsIgnoreLine
		shortcode_atts(
			array(
				'type'      => '',
				'icon_type' => '',
				'mini_cart' => 'dropdown',
				'title'     => '',
				'label'     => '',
				'price'     => '',
				'delimiter' => '',
				'pfx'       => '',
				'sfx'       => '',
				'icon'      => ALPHA_ICON_PREFIX . '-icon-cart-solid',
			),
			$atts
		)
	);

	$type = $type ? $type . '-type' : '';

	if ( 'offcanvas' == $mini_cart ) {
		$extra_class = ' cart-offcanvas offcanvas-type ';
	} else {
		$extra_class = '';
	}
	if ( alpha_get_option( 'cart_show_qty' ) ) {
		$extra_class .= ' cart-with-qty';
	}
	?>
	<div class="dropdown mini-basket-dropdown cart-dropdown <?php echo esc_attr( $type . ( $icon_type ? ' ' . $icon_type . '-type ' : ' ' ) . esc_attr( $extra_class ) ); ?>">
		<a class="cart-toggle" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>">
			<?php if ( $title || $price ) { ?>
			<div class="cart-label">
			<?php } ?>
				<?php if ( 'badge' == $icon_type || 'label' == $icon_type ) : ?>
					<?php if ( $title ) : ?>
					<span class="cart-name"><?php echo esc_html( $label ); ?></span>
						<?php if ( $delimiter ) : ?>
							<span class="cart-name-delimiter"><?php echo esc_html( $delimiter ); ?></span>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $price ) : ?>
					<span class="cart-price">€0.00</span>
					<?php endif; ?>
				<?php else : ?>
					<?php if ( $title ) : ?>
					<span class="cart-name"><?php echo esc_html( $label ); ?></span>
					<?php endif; ?>
					<p class="mb-0"><span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span> <?php echo esc_html__( 'items', 'pandastore-core' ); ?>
						<?php if ( $delimiter ) : ?>
							<span class="cart-name-delimiter"><?php echo esc_html( $delimiter ); ?></span>
						<?php endif; ?>
						<?php if ( $price ) : ?>
							<span class="cart-price">€0.00</span>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			<?php if ( $title || $price ) { ?>
			</div>
			<?php } ?>
			<?php if ( 'badge' == $icon_type ) : ?>
				<i class="<?php echo esc_attr( $icon ); ?>">
					<span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span>
				</i>
			<?php elseif ( 'compact' == $icon_type ) : ?>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
			<?php elseif ( 'label' == $icon_type ) : ?>
				<span class="cart-count-wrap">
				<?php
				$html = '';
				if ( $pfx ) {
					$html .= esc_html( $pfx );
				}
				$html .= '<span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span>';
				if ( $sfx ) {
					$html .= esc_html( $sfx );
				}
				echo alpha_escaped( $html );
				?>
				</span>
			<?php endif ?>
		</a>
		<?php if ( ! alpha_is_elementor_preview() && 'offcanvas' == $mini_cart ) : ?>
			<div class="cart-overlay"></div>
		<?php endif; ?>
		<div class="cart-popup widget_shopping_cart dropdown-box">
			<div class="widget_shopping_cart_content">
				<div class="cart-loading"></div>
			</div>
		</div>
	</div>
	<?php
endif;
