<?php

/**
 * Header content template
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

defined('ABSPATH') || die;

global $alpha_layout;

if (!empty($alpha_layout['header']) && 'publish' == get_post_status(intval($alpha_layout['header']))) {

	echo '<header class="header custom-header header-' . intval($alpha_layout['header']) . '" id="header">';
?>
	<div class="header_inner">
		<div class="top_bar">
			<div class="container-fluid">
				<div class="inner">
					<div class="free_deliver">
						<div class="free_deliver-text">
							<?php
							function lt_header()
							{
								if (ICL_LANGUAGE_CODE == 'lt') {
							?>
									<?php if (have_rows('group_1_header', 25)) : ?>
										<?php while (have_rows('group_1_header', 25)) : the_row(); ?>
											<?php $free_deliver = get_sub_field('free_deliver'); ?>
											<p><?php echo $free_deliver; ?></p>
										<?php endwhile; ?>
									<?php endif; ?>
								<?php }  ?>
							<?php }  ?>
							<?php lt_header(); ?>

							<?php
							function en_header()
							{
								if (ICL_LANGUAGE_CODE == 'en') {
							?>
									<?php if (have_rows('group_1_header', 48907)) : ?>
										<?php while (have_rows('group_1_header', 48907)) : the_row(); ?>
											<?php $free_deliver = get_sub_field('free_deliver'); ?>
											<p><?php echo $free_deliver; ?></p>
										<?php endwhile; ?>
									<?php endif; ?>
								<?php }  ?>
							<?php }  ?>

							<?php en_header(); ?>

							<?php
							function de_header()
							{
								if (ICL_LANGUAGE_CODE == 'de') {
							?>
									<?php if (have_rows('header_group_1', 48912)) : ?>
										<?php while (have_rows('header_group_1', 48912)) : the_row(); ?>
											<?php $free_deliver = get_sub_field('free_deliver'); ?>
											<p><?php echo $free_deliver; ?></p>
										<?php endwhile; ?>
									<?php endif; ?>
								<?php }  ?>
							<?php }  ?>

							<?php de_header(); ?>
						</div>
					</div>
					<div class="right_side">
						<div>
							<?php
							if (has_nav_menu('lang-switcher')) {
								wp_nav_menu(
									array(
										'theme_location'  => 'lang-switcher',
										'container'       => 'nav',
										'container_class' => '',
										'items_wrap'      => '<ul id="%1$s" class="menu switcher lang-switcher">%3$s</ul>',
										'walker'          => new Alpha_Walker_Nav_Menu(),
									)
								);
							}
							$languages = apply_filters('wpml_active_languages', array());
							if (!empty($languages) && 1 < count($languages)) {
								$active_lang = '';
								$other_langs = '';
								foreach ($languages as $l) {
									if (!$l['active']) {
										$other_langs .= '<li class="menu-item"><a href="' . esc_url($l['url']) . '">';
									}
									if ($l['country_flag_url']) {
										if ($l['active']) {
											$active_lang .= '<img src="' . esc_url($l['country_flag_url']) . '" alt="' . esc_attr($l['language_code']) . '" width="18" height="12px" />';
										} else {
											$other_langs .= '<img src="' . esc_url($l['country_flag_url']) . '" alt="' . esc_attr($l['language_code']) . '" width="18" height="12px" />';
										}
									}
									if ($l['active']) {
										$active_lang .= icl_disp_language($l['native_name'], $l['translated_name'], apply_filters('alpha_icl_show_native_name', true, $l));
									} else {
										$other_langs .= icl_disp_language($l['native_name'], $l['translated_name'], apply_filters('alpha_icl_show_native_name', true, $l));
									}
									if (!$l['active']) {
										$other_langs .= '</a></li>';
									}
								}
							?>
								<ul class="menu switcher lang-switcher">
									<li class="menu-item-has-children">
										<a class="switcher-toggle" href="#"><?php echo alpha_strip_script_tags($active_lang); ?></a>
										<?php if ($other_langs) : ?>
											<ul>
												<?php echo alpha_strip_script_tags($other_langs); ?>
											</ul>
										<?php endif; ?>
									</li>
								</ul>
							<?php 	} ?>
						</div>
						<?php if (have_rows('group_1_header', 25)) : ?>
							<?php while (have_rows('group_1_header', 25)) : the_row(); ?>
								<span class="divider"></span>
								<div class="social-icons">
									<?php if (have_rows('social_links', 25)) : ?>
										<?php while (have_rows('social_links', 25)) : the_row(); ?>
											<?php $icon = get_sub_field('icon', 25); ?>
											<?php $title = get_sub_field('title', 25); ?>
											<?php $link = get_sub_field('link', 25); ?>
											<a href="<?php echo $link ?>" class="social-icon social-custom 
											<?php
											if ($icon == 'fab fa-facebook-f') {
												echo 'social-facebook';
											} elseif ($icon == 'fab fa-instagram') {
												echo 'social-instagram';
											} elseif ($icon == 'fab fa-whatsapp') {
												echo 'social-whatsapp';
											}
											?>" target="_blank" title="<?php echo $title ?>" rel="noopener noreferrer">
												<i class="<?php echo $icon ?>"></i>
											</a>
										<?php endwhile; ?>
									<?php endif; ?>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="bottom_bar ">
			<div class="container-fluid for-desktop">
				<div class="flex-left">
					<a href="#" class="sidebar-toggle-mobile"><i class="fas fa-bars"></i></a>
					<div class="mobile-logo-wrap">
						<a href="<?php echo esc_url(home_url()); ?>" class="logo-mobile">
							<?php if (alpha_get_option('custom_logo')) : ?>
								<img class="logo" src="<?php echo esc_url(str_replace(array('http:', 'https:'), '', wp_get_attachment_url(alpha_get_option('custom_logo')))); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
							<?php else : ?>
								<img class="logo" src="<?php echo ALPHA_ASSETS . '/images/logo.png'; ?>" width="100" height="100" alt="<?php esc_attr_e('Logo', 'pandastore'); ?>" />
							<?php endif; ?>
						</a>
					</div>
				</div>
				<?
				function alpha_search_form($args = array())
				{
					$args = wp_parse_args(
						$args,
						array(
							'type'             => 'classic',
							'toggle_type'      => 'overlap',
							'search_align'     => 'start',
							'show_categories'  => false,
							'where'            => '',
							'live_search'      => (bool) alpha_get_option('live_search'),
							'search_post_type' => alpha_get_option('search_post_type'),
							'icon'             => ALPHA_ICON_PREFIX . '-icon-search',
							'label'            => '',
							'placeholder'      => '',
						)
					);

					extract($args);

					ob_start();
					$class = '';
					if ('toggle' == $type) {
						$class .= ' hs-toggle hs-' . $toggle_type;
					}

					if ($show_categories) {
						$class .= ' hs-expanded';
					} else {
						$class .= ' hs-simple';
					}
					if ('toggle' == $type && 'dropdown' == $toggle_type) {
						$class .= ' hs-' . $search_align;
					}

				?>

					<div class="search-wrapper <?php echo esc_attr($class); ?>">
						<?php if ('toggle' == $type) : ?>
							<a href="#" class="search-toggle">
								<i class="<?php echo esc_attr($icon); ?>"></i>
								<?php if ($label) : ?>
									<span><?php echo esc_html($label); ?></span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ('fullscreen' == $toggle_type) : ?>
							<div class="search-form-overlay">
								<div class="close-overlay"></div>
								<div class="search-form-wrapper">
									<div class="search-inner-wrapper">
										<div class="search-form">
										<?php endif; ?>
										<form action="<?php echo esc_url(home_url()); ?>/" method="get" class="input-wrapper">
											<input type="hidden" name="post_type" value="<?php echo esc_attr($search_post_type); ?>" />

											<?php if ('header' == $where && $show_categories) : ?>

											<?php endif; ?>

											<input type="search" aria-label="<?php esc_attr_e('Search', 'pandastore'); ?>" class="form-control" name="s" placeholder="<?php esc_attr_e('Search products…', 'woocommerce'); ?>" required="" autocomplete="off">

											<?php if ($live_search) : ?>
												<div class="live-search-list"></div>
											<?php endif; ?>

											<button class="btn btn-search" aria-label="<?php esc_attr_e('Search Button', 'pandastore'); ?>" type="submit">
												<i class="<?php echo esc_attr($icon); ?>"></i>
											</button>

											<?php if ('overlap' == $toggle_type) : ?>
												<div class="hs-close">
													<a href="#">
														<span class="close-wrap">
															<span class="close-line close-line1"></span>
															<span class="close-line close-line2"></span>
														</span>
													</a>
												</div>
											<?php endif; ?>

										</form>
										<?php if ('fullscreen' == $toggle_type) : ?>
											<div class="search-header">
												<?php esc_html_e('Hit enter to search or ESC to close', 'pandastore'); ?>
												<div class="hs-close">
													<a href="#">
														<span class="close-wrap">
															<span class="close-line close-line1"></span>
															<span class="close-line close-line2"></span>
														</span>
													</a>
												</div>
											</div>
										</div>
										<div class="search-container mt-8">
											<div class="scrollable">
												<div class="search-results">
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>

							</div>
						<?php
					}
					alpha_search_form(); ?>
						<div class="flex-content">
							<div class="call_to_us">
								<?php if (have_rows('group_2_header', 25)) : ?>
									<?php while (have_rows('group_2_header', 25)) : the_row(); ?>
										<?php $call_us_icon = get_sub_field('call_us_icon', 25); ?>
										<?php $call_us_number = get_sub_field('call_us_number', 25); ?>
										<div class="contact">
											<?php $trimmed_number = str_replace(' ', '', $call_us_number); ?>
											<a class="phone_number_icon" href="tel: <?php echo $trimmed_number; ?>" aria-label="Contact">
												<i class="mb-0 <?php echo $call_us_icon ?>"></i>
											</a>
											<div class="contact-content">
												<span class="live-call"><?php esc_attr_e('Call to us', 'pandastore') ?></span><span class="contact-delimiter">:</span> <a title="<?php esc_attr_e('Call to us', 'pandastore') ?>" href="tel:<?php echo $trimmed_number; ?>" class="telephone"><?php echo $call_us_number ?></a>
											</div>

										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>

							<div class="my_account">
								<a class="account" href="<?php echo home_url('/mano-paskyra/'); ?>" aria-label="Account">
									<?php if (have_rows('group_2_header', 25)) : ?>
										<?php while (have_rows('group_2_header', 25)) : the_row(); ?>
											<?php $account_icon = get_sub_field('account_icon', 25); ?>
											<i class="<?php echo $account_icon ?>"></i>
										<?php endwhile; ?>
									<?php endif; ?>
								</a>
							</div>
							<div class="divider"></div>
							<?php if (have_rows('group_2_header', 25)) : ?>
								<?php while (have_rows('group_2_header', 25)) : the_row(); ?>
									<?php $cart_icon = get_sub_field('cart_icon', 25); ?>
									<div class="my_cart">
										<?php
										$atts = '';
										$type = '';
										$mini_cart = 'dropdown';
										$icon_type = '';
										$label = '';
										$delimiter = '';
										$price = '';
										$icon   = $cart_icon;
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
														<span class="cart-name"><?php esc_attr_e('My Cart', 'pandastore-core'); ?></span>
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
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>

					<div class="container-fluid for-mobile">
						<?
						function alpha_search_form2($args = array())
						{
							$args = wp_parse_args(
								$args,
								array(
									'type'             => 'classic',
									'toggle_type'      => 'overlap',
									'search_align'     => 'start',
									'show_categories'  => false,
									'where'            => '',
									'live_search'      => (bool) alpha_get_option('live_search'),
									'search_post_type' => alpha_get_option('search_post_type'),
									'icon'             => ALPHA_ICON_PREFIX . '-icon-search',
									'label'            => '',
									'placeholder'      => '',
								)
							);

							extract($args);

							ob_start();
							$class = '';
							if ('toggle' == $type) {
								$class .= ' hs-toggle hs-' . $toggle_type;
							}

							if ($show_categories) {
								$class .= ' hs-expanded';
							} else {
								$class .= ' hs-simple';
							}
							if ('toggle' == $type && 'dropdown' == $toggle_type) {
								$class .= ' hs-' . $search_align;
							}

						?>

							<div class="search-wrapper <?php echo esc_attr($class); ?>">
								<?php if ('toggle' == $type) : ?>
									<a href="#" class="search-toggle">
										<i class="<?php echo esc_attr($icon); ?>"></i>
										<?php if ($label) : ?>
											<span><?php echo esc_html($label); ?></span>
										<?php endif; ?>
									</a>
								<?php endif; ?>

								<?php if ('fullscreen' == $toggle_type) : ?>
									<div class="search-form-overlay">
										<div class="close-overlay"></div>
										<div class="search-form-wrapper">
											<div class="search-inner-wrapper">
												<div class="search-form">
												<?php endif; ?>
												<form action="<?php echo esc_url(home_url()); ?>/" method="get" class="input-wrapper">
													<input type="hidden" name="post_type" value="<?php echo esc_attr($search_post_type); ?>" />

													<?php if ('header' == $where && $show_categories) : ?>

													<?php endif; ?>

													<input type="search" aria-label="<?php esc_attr_e('Search', 'pandastore'); ?>" class="form-control" name="s" placeholder="<?php esc_attr_e('Search products…', 'woocommerce'); ?>" required="" autocomplete="off">

													<?php if ($live_search) : ?>
														<div class="live-search-list"></div>
													<?php endif; ?>

													<button class="btn btn-search" aria-label="<?php esc_attr_e('Search Button', 'pandastore'); ?>" type="submit">
														<i class="<?php echo esc_attr($icon); ?>"></i>
													</button>

													<?php if ('overlap' == $toggle_type) : ?>
														<div class="hs-close">
															<a href="#">
																<span class="close-wrap">
																	<span class="close-line close-line1"></span>
																	<span class="close-line close-line2"></span>
																</span>
															</a>
														</div>
													<?php endif; ?>

												</form>
												<?php if ('fullscreen' == $toggle_type) : ?>
													<div class="search-header">
														<?php esc_html_e('Hit enter to search or ESC to close', 'pandastore'); ?>
														<div class="hs-close">
															<a href="#">
																<span class="close-wrap">
																	<span class="close-line close-line1"></span>
																	<span class="close-line close-line2"></span>
																</span>
															</a>
														</div>
													</div>
												</div>
												<div class="search-container mt-8">
													<div class="scrollable">
														<div class="search-results">
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>

									</div>
								<?php
							}
							alpha_search_form2(); ?>
							</div>
					</div>
			</div>

		<?php



		echo '</header>';
	}
