<?php
/**
 * Lazyload template
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 */
defined( 'ABSPATH' ) || die;
?>
<h2 class="wizard-title"><?php esc_html_e( 'Lazyload', 'pandastore' ); ?></h2>
<form method="post" class="alpha_submit_form">
	<p class="wizard-description"><?php esc_html_e( 'This will help you make your site faster by lazyloading images and contents.', 'pandastore' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="lazyload" <?php checked( alpha_get_option( 'lazyload' ) ); ?>> <?php esc_html_e( 'Lazyload Images', 'pandastore' ); ?>
	</label>
	<p style="margin: 10px 0 20px;">
		<?php esc_html_e( "All image resources will be lazyloaded so that page's loading speed gets faster.", 'pandastore' ); ?>
		<br>
		<?php esc_html_e( 'Use with caution! Disable this option if you have any compability problems.', 'pandastore' ); ?>
	</p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="lazyload_menu" <?php checked( alpha_get_option( 'lazyload_menu' ) ); ?>> <?php esc_html_e( 'Lazyload Menus', 'pandastore' ); ?>
	</label>
	<p style="margin: 10px 0 20px;">
		<?php esc_html_e( 'Menus will be lazyloaded and cached in browsers for faster load.', 'pandastore' ); ?>
		<br>
		<?php esc_html_e( 'Cached menus will be updated after they have been changed or customizer panel has been saved.', 'pandastore' ); ?>
	</p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="skeleton" <?php checked( alpha_get_option( 'skeleton_screen' ) ); ?>> <?php esc_html_e( 'Skeleton Screen', 'pandastore' ); ?>
	</label>
	<p style="margin: 10px 0 20px;"><?php esc_html_e( 'Instead of real content, skeleton is used to enhance speed of page loading and makes it more beautiful.', 'pandastore' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="webfont" <?php checked( alpha_get_option( 'google_webfont' ) ); ?>> <?php esc_html_e( 'Enable Google Web Font Lazyload', 'pandastore' ); ?>
	</label>
	<p style="margin: 10px 0 20px;">
	<?php
		printf(
			/* translators: %s values are docs urls */
			esc_html__( 'Using %1$sWeb Font Loader%2$s, you can enhance page loading speed by about 4 percent in %3$sGoogle PageSpeed Insights%4$s for both mobile and desktop.', 'pandastore' ),
			'<a href="https://developers.google.com/fonts/docs/webfont_loader" target="_blank">',
			'</a>',
			'<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">',
			'</a>'
		);
		?>
	</p>
	<?php
	/**
	 * Fires after lazyload main content.
	 *
	 * @since 1.0
	 */
	do_action( 'alpha_after_lazyload_main_content' );
	?>
	<p class="alpha-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-outline"><?php esc_html_e( 'Skip this step', 'pandastore' ); ?></a>
		<button type="submit" class="button-dark button button-large button-next" name="save_step" /><?php esc_html_e( 'Save & Continue', 'pandastore' ); ?></button>
		<?php wp_nonce_field( 'alpha-setup-wizard' ); ?>
	</p>
</form>
