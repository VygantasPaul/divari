<?php

/**
 * Cart  template
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
 ?>


<div class="my_cart">
	<?php

	$atts = '';
	$type = '';
	$mini_cart = 'dropdown';
	$icon_type = '';
	$label = '';
	$delimiter = '';
	$price = '';

	$icon      = 'p-icon-cart-solid';


	$extra_class = ' cart-offcanvas offcanvas-type ';

	$extra_class .= ' cart-with-qty';

	?>
	<div class="dropdown mini-basket-dropdown cart-dropdown dropdown mini-basket-dropdown cart-dropdown inline-type compact-type cart-offcanvas offcanvas-type">
		<a class="cart-toggle" href="<?php echo esc_url(wc_get_page_permalink('cart')); ?>">
			<i class="<?php echo esc_attr($icon); ?>"></i>
			<?php if ($title || $price) { ?>
				<div class="cart-label">
				<?php } ?>

				<?php if ($title) : ?>
					<span class="cart-name"><?php echo esc_html__('My Cart', 'pandastore-core'); ?></span>
					<?php if ($delimiter) : ?>
						<span class="cart-name-delimiter"><?php echo esc_html($delimiter); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ($price) : ?>
					<span class="cart-price ">€0.00</span>
				<?php endif; ?>

				<p class="mb-0 items"><span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span> <?php echo esc_html__('items', 'pandastore-core'); ?> :
					<?php if ($delimiter) : ?>
						<span class="cart-name-delimiter"><?php echo esc_html($delimiter); ?></span>
					<?php endif; ?>
					<span class="cart-price">€0.00</span>
					<?php if ($price) : ?>
						<span class="cart-price ">€0.00</span>
					<?php endif; ?>
				</p>

				<?php if ($title || $price) { ?>
				</div>
			<?php } ?>



		</a>

		<div class="cart-overlay"></div>

		<div class="cart-popup widget_shopping_cart dropdown-box">
			<div class="widget_shopping_cart_content">
				<div class="cart-loading"></div>
			</div>
		</div>
	</div>
</div>