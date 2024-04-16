<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.0
 */

defined( 'ABSPATH' ) || die;

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>

	<div class="cart-empty-page text-center">
		<i class="cart-empty <?php echo ALPHA_ICON_PREFIX; ?>-icon-cart-solid"></i>
		<?php
		/*
		* @hooked wc_empty_cart_message - 10
		*/
		do_action( 'woocommerce_cart_is_empty' );
		?>
		<p class="return-to-shop">
			<a class="button wc-backward btn btn-dark" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php
					/**
					 * Filter "Return To Shop" text.
					 *
					 * @since 4.6.0
					 * @param string $default_text Default text.
					 */
					echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', esc_html__( 'Go To Shop', 'pandastore' ) ) );
				?>
			</a>
		</p>
	</div>
<?php endif; ?>
