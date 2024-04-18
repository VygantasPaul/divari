<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined( 'ABSPATH' ) || die;

wp_enqueue_script( 'alpha-sticky-lib' );

do_action( 'woocommerce_before_cart' );

?>

<div class="row gutter-md pb-5 pb-lg-10">
	<div class="col-lg-8 pr-lg-6">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>
						<th class="product-thumbnail"><?php esc_html_e( 'Product', 'pandastore' ); ?></th>
						<th class="product-name">&nbsp;</th>
						<th class="product-price"><?php esc_html_e( 'Price', 'pandastore' ); ?></th>
						<th class="product-quantity"><?php esc_html_e( 'Quantity', 'pandastore' ); ?></th>
						<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'pandastore' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

								<td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo alpha_strip_script_tags( $thumbnail ); // PHPCS: XSS ok.
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
								}
								?>
								</td>

								<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'pandastore' ); ?>">
								<?php
								if ( ! $product_permalink ) {
									echo alpha_strip_script_tags( apply_filters( 'woocommerce_cart_item_name', esc_html( $_product->get_name() ), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo alpha_strip_script_tags( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) );
								}

								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo alpha_strip_script_tags( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'pandastore' ) . '</p>', $product_id ) );
								}
								?>
								</td>

								<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'pandastore' ); ?>">
									<?php
										echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
									?>
								</td>

								<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'pandastore' ); ?>">
								<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
								</td>

								<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'pandastore' ); ?>">
									<?php
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
									?>
								</td>
								<td class="product-close">
									<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove p-icon-times-solid" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'pandastore' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									);
									?>
								</td>
							</tr>
							<?php
						}
					}
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>

					<tr>
						<td colspan="6" class="actions pr-0 pt-6 pl-0 pb-0">
							<div class="cart-actions mb-10">
								<div>
							<div class="cart-title-flex">
							<h3 class="cart-title"><?php esc_html_e( 'Cart Totals', 'pandastore' ); ?></h3>
							<?php wc_cart_totals_subtotal_html(); ?>
							</div>
							<div class="flex-box">
							<button type="submit" class="btn btn-outline btn-dim btn-border-thin wc-action-btn<?php echo ( alpha_get_option( 'cart_auto_update' ) ? ' d-none' : '' ) . ( is_rtl() ? ' ml-2' : '' ); ?> mb-4" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'pandastore' ); ?>"><?php esc_html_e( 'Update cart', 'pandastore' ); ?></button>
								

									<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class=" btn  btn-dim btn-border-thin mb-4 mr-2 btn-icon-right  alt wc-forward">
									<?php esc_html_e( 'Proceed to checkout', 'pandastore' ); ?><?php echo is_rtl() ? '' : '<i class="' . ALPHA_ICON_PREFIX . '-icon-arrow-long-right"></i>'; ?>
									</a>
									</div>
							</div>
							</div>

									<?php if ( wc_coupons_enabled() ) { ?>
								<div id="cart_coupon_box" class="expanded mb-2 pt-1" style="display: block;">
									<h5><?php esc_html_e( 'Coupon Discount', 'pandastore' ); ?></h5>
									<div class="form-row form-coupon">
										<input type="text" name="coupon_code" class="input-text form-control mb-6" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter coupon code here...', 'pandastore' ); ?>">
										<button type="submit" name="apply_coupon" class="btn btn-border-thin btn-outline btn-dim" value="<?php esc_attr_e( 'Apply coupon', 'pandastore' ); ?>"><?php esc_html_e( 'Apply coupon', 'pandastore' ); ?></button>
										<?php do_action( 'woocommerce_cart_coupon' ); ?>
									</div>
								</div>
							<?php } ?>
									<?php do_action( 'woocommerce_cart_actions' ); ?>

									<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</td>
					</tr>

									<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
			</table>
									<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
	</div>
	<div class="col-lg-4">
									<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<div class="cart-collaterals sticky-sidebar">
									<?php
									/**
									 * Cart collaterals hook.
									 *
									 * @removed woocommerce_cross_sell_display
									 * @hooked woocommerce_cart_totals - 10
									 */
									do_action( 'woocommerce_cart_collaterals' );
									?>
		</div>
	</div>
</div>

									<?php
									/**
									 * After Cart Action
									 *
									 * @hooked woocommerce_cross_sell_display
									 */
									do_action( 'woocommerce_after_cart' );
									?>
