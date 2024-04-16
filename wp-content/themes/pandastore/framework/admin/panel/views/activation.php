<?php
/**
 * Activation template
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
$disable_field = '';
$errors        = get_option( 'alpha_register_error_msg' );
update_option( 'alpha_register_error_msg', '' );
$purchase_code = Alpha_Admin::get_instance()->get_purchase_code_asterisk();
$regist_flag   = false;

?>
	<form id="alpha_registration" method="post">
		<?php
		if ( $purchase_code && ! empty( $purchase_code ) && Alpha_Admin::get_instance()->is_registered() ) {
			$disable_field = ' disabled=true';
		}
		?>
		<input type="hidden" name="alpha_registration" />
		<?php if ( Alpha_Admin::get_instance()->is_envato_hosted() ) : ?>
			<p class="confirm unregister">
				<?php esc_html_e( 'You are using Envato Hosted, this subscription code can not be deregistered.', 'pandastore' ); ?>
			</p>
		<?php else : ?>
			<div class="alpha-input-wrapper">
				<input type="text" id="alpha_purchase_code" name="code" class="regular-text alpha-input" value="<?php echo esc_attr( $purchase_code ); ?>" placeholder="<?php esc_attr_e( 'Please register your purchase', 'pandastore' ); ?>" <?php echo alpha_escaped( $disable_field ); ?> />
				<?php if ( ! Alpha_Admin::get_instance()->is_registered() ) : ?>
					<a href="javascript:;" class="alpha-toggle-howto"><span>?</span></a>
				<?php endif; ?>
			</div>
			<?php if ( Alpha_Admin::get_instance()->is_registered() ) : ?>
				<input type="hidden" id="alpha_active_action" name="action" value="unregister" data-toggle-html='<?php echo '<i class="admin-svg-key"></i>' . esc_html__( 'Registered', 'pandastore' ); ?>' />
				<?php submit_button( esc_html__( 'Deactivate', 'pandastore' ), array( 'button-dark', 'large', 'alpha-large-button' ), '', true ); ?>
			<?php else : ?>
				<input type="hidden" id="alpha_active_action" name="action" value="register" data-toggle-html='<?php echo '<i class="admin-svg-key"></i>' . esc_html__( 'Unregistered', 'pandastore' ); ?>' />
				<?php submit_button( esc_html__( 'Activate', 'pandastore' ), array( 'button-dark', 'large', 'alpha-large-button' ), '', true ); ?>
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_nonce_field( 'alpha-setup-wizard' ); ?>
	</form>
<?php
if ( ! empty( $errors ) ) {
	echo '<div class="notice-error notice-block"><strong><i class="fa fa-times-circle"></i></strong>' . alpha_escaped( $errors ) . esc_html__( ' Please check purchase code again.', 'pandastore' ) . '</div>';
}
if ( ! empty( $purchase_code ) ) {
	if ( ! empty( $errors ) ) {
		echo '<div class="notice-warning notice-block">' . esc_html__( 'Purchase code not updated. We will keep the existing one.', 'pandastore' ) . '</div>';
	} else {
		/* translators: $1 and $2 opening and closing strong tags respectively */
		echo '<div class="notice-success notice-block">' . sprintf( esc_html__( '%1$s Welcome! Your product is registered now. Enjoy %2$s Theme and automatic updates.', 'pandastore' ), '<strong><i class="fas fa-check-circle"></i></strong>', ALPHA_DISPLAY_NAME ) . '</div>';
	}
} elseif ( empty( $errors ) ) {
	echo '<div class="notice-block">' . sprintf( esc_html__( 'Thank you for choosing %s theme from ThemeForest. Please register your purchase and make sure that you have fulfilled all of the requirements.', 'pandastore' ), ALPHA_DISPLAY_NAME ) . '</div>';
}

if ( ! Alpha_Admin::get_instance()->is_registered() ) :
	?>
	<div class="alpha-active-howto" style="display: none;">
		<h3>Where can I find my purchase code?</h3>
		<ol>
			<li><?php echo sprintf( esc_html__( 'Please go to %1$sThemeForest.net/downloads%2$s', 'pandastore' ), '<a target="_blank" href="https://themeforest.net/downloads" rel="noopener noreferrer">', '</a>' ); //phpcs:ignore ?></li>
			<li><?php echo esc_html__( 'Click the ', 'pandastore' ) . '<strong>' . esc_html__( 'Download', 'pandastore' ) . '</strong> ' . sprintf( esc_html__( 'button in %1$s row', 'pandastore' ), ALPHA_DISPLAY_NAME ); //phpcs:ignore ?></li>
			<li><?php echo esc_html__( 'Select ', 'pandastore' ) . '<strong>' . esc_html__( 'License Certificate &amp; Purchase code', 'pandastore' ) . '</strong>'; ?></li>
			<li><?php echo esc_html__( 'Copy', 'pandastore' ) . ' <strong>' . esc_html__( 'Item Purchase Code', 'pandastore' ) . '</strong>'; ?></li>
		</ol>
	</div>
	<?php
endif;
