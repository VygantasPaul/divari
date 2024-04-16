<?php

/**
 * Footer template
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined('ABSPATH') || die;

?>
</main>

<?php do_action('alpha_after_main'); ?>

<footer class="footer custom-footer" id="footer">
	<div class="row">
		<div class="col-12">
			<div class="border-bottom">
				<div class="row inner">
					<?php
					function lt_footer()
					{
						if (ICL_LANGUAGE_CODE == 'lt') {
					?>
							<?php if (have_rows('group_1_footer', 25)) : ?>
								<?php while (have_rows('group_1_footer', 25)) : the_row(); ?>
									<?php $logo = get_sub_field('logo', 25); ?>
									<?php $description = get_sub_field('description', 25); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-logo">
											<?php if ($logo) : ?>
												<a title="<?php echo $logo['alt'] ?>" href="<?php home_url() ?>"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>"></a>
											<?php endif; ?>
										</div>
										<div class="footer-description">
											<div><?php echo $description ?></div>
										</div>

									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if (have_rows('group_2_footer', 25)) : ?>
								<?php while (have_rows('group_2_footer', 25)) : the_row(); ?>
									<?php $title = get_sub_field('title', 25); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-heading">
											<h5><?php esc_attr_e('Contacts', 'pandastore'); ?></h5>
										</div>
										<div class="footer-list">
											<ul>
												<?php if (have_rows('contact_row', 25)) : ?>
													<?php while (have_rows('contact_row', 25)) : the_row(); ?>
														<?php $icon = get_sub_field('icon', 25) ?>
														<?php $text = (get_sub_field('text', 25, false)) ?>
														<li><i class="<?php echo $icon; ?>"></i> <?php echo $text; ?> </li>
													<?php endwhile; ?>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<div class="col-12 col-md-6 col-xl-2">
								<div class="footer-heading">
									<h5><?php esc_attr_e('Information', 'pandastore'); ?></h5>
								</div>
								<div class="footer-nav-menu">
									<?php
									wp_nav_menu(array(
										'menu'   => 'Footer menu lt',
									));
									?>
								</div>
							</div>
							<div class="col-12 col-md-6 col-xl-4">
								<?php if (have_rows('group_3_footer', 25)) : ?>
									<?php while (have_rows('group_3_footer', 25)) : the_row(); ?>
										<?php $title = get_sub_field('title', 25); ?>
										<?php $subscribe = get_sub_field('subscribe', 25); ?>
										<?php $subscribe_text = get_sub_field('subscribe_text', 25); ?>
										<div class="footer-heading">
											<h5><?php esc_attr_e('Subscribe us', 'pandastore'); ?></h5>
										</div>
										<div class="footer-subscribe-desc">
											<?php echo $subscribe_text ?>
										</div>
										<div class="footer-subscribe">
											<?php echo $subscribe ?>
										</div>
										<div class="footer-social">
											<?php if (have_rows('social_icons', 25)) : ?>
												<?php while (have_rows('social_icons', 25)) : the_row(); ?>
													<?php $icon = get_sub_field('icon', 25); ?>
													<?php $link = get_sub_field('link', 25); ?>
													<?php $title = get_sub_field('title', 25); ?>
													<a title="<?php echo $title ?>" href="<?php echo $link ?>"> <i class="<?php echo $icon ?>"></i> </a>
												<?php endwhile; ?>
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>

					<?php }
					} ?>

					<?php
					function en_footer()
					{
						if (ICL_LANGUAGE_CODE == 'en') {
					?>
							<?php if (have_rows('group_1_en_footer', 48907)) : ?>
								<?php while (have_rows('group_1_en_footer', 48907)) : the_row(); ?>
									<?php $logo = get_sub_field('logo', 48907); ?>
									<?php $description = get_sub_field('description', 48907); ?>
									<?php $email = get_sub_field('email', 48907); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-logo">
											<?php if ($logo) : ?>
												<a title="<?php echo $logo['alt'] ?>" href="<?php home_url() ?>"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>"></a>
											<?php endif; ?>
										</div>
										<div class="footer-description">
											<div><?php echo $description ?></div>
										</div>
										<div class="footer-email">
											<div><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></div>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if (have_rows('group_2_en_footer', 48907)) : ?>
								<?php while (have_rows('group_2_en_footer', 48907)) : the_row(); ?>
									<?php $title = get_sub_field('title', 48907); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-heading">
											<h5><?php esc_attr_e('Contacts', 'pandastore'); ?></h5>
										</div>
										<div class="footer-list">
											<ul>
												<?php if (have_rows('contact_row', 48907)) : ?>
													<?php while (have_rows('contact_row', 48907)) : the_row(); ?>
														<?php $icon = get_sub_field('icon', 48907) ?>
														<?php $text = (get_sub_field('text', 48907, false)) ?>
														<li><i class="<?php echo $icon; ?>"></i> <?php echo $text; ?> </li>
													<?php endwhile; ?>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<div class="col-12 col-md-6 col-xl-2">
								<div class="footer-heading">
									<h5><?php esc_attr_e('Information', 'pandastore'); ?></h5>
								</div>
								<div class="footer-nav-menu">
									<?php
									wp_nav_menu(array(
										'menu'   => 'Footer menu en',
									));
									?>
								</div>
							</div>
							<div class="col-12 col-md-6 col-xl-4">
								<div class="footer-heading">
									<h5><?php esc_attr_e('Subscribe us', 'pandastore'); ?></h5>
								</div>
								<?php if (have_rows('group_3_en_footer', 48907)) : ?>
									<?php while (have_rows('group_3_en_footer', 48907)) : the_row(); ?>
										<?php $title = get_sub_field('title', 48907); ?>
										<?php $subscribe = get_sub_field('subscribe', 48907); ?>
										<?php $subscribe_text = get_sub_field('subscribe_text', 48907); ?>

										<div class="footer-subscribe-desc">
											<?php echo $subscribe_text ?>
										</div>
										<div class="footer-subscribe">
											<?php echo $subscribe ?>
										</div>
										<div class="footer-social">
											<?php if (have_rows('social_icons', 48907)) : ?>
												<?php while (have_rows('social_icons', 48907)) : the_row(); ?>
													<?php $icon = get_sub_field('icon', 48907); ?>
													<?php $link = get_sub_field('link', 48907); ?>
													<?php $title = get_sub_field('title', 48907); ?>
													<a title="<?php echo $title ?>" href="<?php echo $link ?>"> <i class="<?php echo $icon ?>"></i> </a>
												<?php endwhile; ?>
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>

					<?php }
					} ?>
					<?php
					function de_footer()
					{
						if (ICL_LANGUAGE_CODE == 'de') {
					?>
							<?php if (have_rows('group_1_de_footer', 48912)) : ?>
								<?php while (have_rows('group_1_de_footer', 48912)) : the_row(); ?>
									<?php $logo = get_sub_field('logo', 48912); ?>
									<?php $description = get_sub_field('description', 48912); ?>
									<?php $email = get_sub_field('email', 48912); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-logo">
											<?php if ($logo) : ?>
												<a title="<?php echo $logo['alt'] ?>" href="<?php home_url() ?>"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>"></a>
											<?php endif; ?>
										</div>
										<div class="footer-description">
											<div><?php echo $description ?></div>
										</div>
										<div class="footer-email">
											<div><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></div>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if (have_rows('group_2_de_footer', 48912)) : ?>
								<?php while (have_rows('group_2_de_footer', 48912)) : the_row(); ?>
									<?php $title = get_sub_field('title', 48912); ?>
									<div class="col-12 col-md-6 col-xl-3">
										<div class="footer-heading">
											<h5><?php esc_attr_e('Contacts', 'pandastore'); ?></h5>
										</div>
										<div class="footer-list">
											<ul>
												<?php if (have_rows('contact_row', 48912)) : ?>
													<?php while (have_rows('contact_row', 48912)) : the_row(); ?>
														<?php $icon = get_sub_field('icon', 48912) ?>
														<?php $text = (get_sub_field('text', 48912, false)) ?>
														<li><i class="<?php echo $icon; ?>"></i> <?php echo $text; ?> </li>
													<?php endwhile; ?>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<div class="col-12 col-md-6 col-xl-2">
								<div class="footer-heading">
									<h5><?php esc_attr_e('Information', 'pandastore'); ?></h5>
								</div>
								<div class="footer-nav-menu">
									<?php
									wp_nav_menu(array(
										'menu'   => 'Footer menu de',
									));
									?>
								</div>
							</div>
							<div class="col-12 col-md-6 col-xl-4">
								<div class="footer-heading">
									<h5><?php esc_attr_e('Subscribe us', 'pandastore'); ?></h5>
								</div>
								<?php if (have_rows('group_3_de_footer', 48912)) : ?>
									<?php while (have_rows('group_3_de_footer', 48912)) : the_row(); ?>
										<?php $title = get_sub_field('title', 48912); ?>
										<?php $subscribe = get_sub_field('subscribe', 48912); ?>
										<?php $subscribe_text = get_sub_field('subscribe_text', 48912); ?>

										<div class="footer-subscribe-desc">
											<?php echo $subscribe_text ?>
										</div>
										<div class="footer-subscribe">
											<?php echo $subscribe ?>
										</div>
										<div class="footer-social">
											<?php if (have_rows('social_icons', 48912)) : ?>
												<?php while (have_rows('social_icons', 48912)) : the_row(); ?>
													<?php $icon = get_sub_field('icon', 48912); ?>
													<?php $link = get_sub_field('link', 48912); ?>
													<?php $title = get_sub_field('title', 48912); ?>
													<a title="<?php echo $title ?>" href="<?php echo $link ?>"> <i class="<?php echo $icon ?>"></i> </a>
												<?php endwhile; ?>
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>

					<?php }
					} ?>


					<?php lt_footer(); ?>
					<?php en_footer(); ?>
					<?php de_footer(); ?>
				</div>


			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-12">
			<div class="row align-center">
				<div class="col-12 col-md-6">
					<div class="copyrights">
						<?php printf(esc_html__('&copy; %s. UAB „Divari“. All Rights Reserved', 'pandastore'), date('Y'));
						?>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="payments">
						<?php if (have_rows('group_4_footer', 25)) : ?>
							<?php while (have_rows('group_4_footer', 25)) : the_row(); ?>
								<?php if (have_rows('payments', 25)) : ?>
									<?php while (have_rows('payments', 25)) : the_row(); ?>
										<?php $payment = get_sub_field('payment', 25); ?>
										<?php $title = get_sub_field('title', 25); ?>
										<?php if ($payment) : ?>
											<img src="<?php echo $payment['url'] ?>" alt="<?php echo $title ?>">
										<?php endif; ?>
									<?php endwhile; ?>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>




</div>

<?php do_action('alpha_after_page_wrapper'); ?>

<?php alpha_print_mobile_bar(); ?>

<a id="scroll-top" class="scroll-top" href="#top" title="<?php esc_attr_e('Top', 'pandastore'); ?>" role="button">
	<i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-angle-up-solid"></i>
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 70 70" enable-background="new 0 0 70 70" xml:space="preserve">
		<circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35" r="34" />
	</svg>
</a>



<?php wp_footer();

?>

<?php


?>
</body>

</html>