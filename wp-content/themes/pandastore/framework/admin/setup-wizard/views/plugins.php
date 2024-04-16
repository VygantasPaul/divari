<?php
/**
 * Plugin panel
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 */
defined( 'ABSPATH' ) || die;
?>
<h2 class="wizard-title"><?php esc_html_e( 'Install Plugins', 'pandastore' ); ?></h2>
<form method="post">

	<?php
	$plugins = $this->_get_plugins();
	if ( count( $plugins['all'] ) ) {
		?>
		<p>
			<?php echo sprintf( esc_html__( 'This will install the default plugins which are used in %s.', 'pandastore' ), ALPHA_DISPLAY_NAME ); //phpcs:ignore ?>
			<br>
			<?php esc_html_e( 'Please check the plugins to install:', 'pandastore' ); ?>
		</p>
		<ul class="alpha-plugins">
			<?php
			$idx      = 0;
			$loadmore = false;
			foreach ( $plugins['all'] as $slug => $plugin ) {
				if ( isset( $plugin['visibility'] ) && 'speed_wizard' == $plugin['visibility'] ) {
					continue;
				}
				++ $idx;
				?>
				<?php
				if ( $idx > 6 && ! $loadmore ) :
					?>
					<li class="separator">
						<a href="#" class="button-load-plugins"><b><?php esc_html_e( 'Load more', 'pandastore' ); ?></b> <i class="fas fa-chevron-down"></i></a>
					</li>
					<?php
					$loadmore = true;
				endif;
				?>
				<li data-slug="<?php echo esc_attr( $slug ); ?>"<?php echo 6 < $idx ? ' class="hidden"' : ''; ?>>
					<label class="checkbox checkbox-inline">
						<input type="checkbox" name="setup-plugin"<?php echo ! $plugin['required'] ? '' : ' checked="checked"'; ?>>
						<?php echo esc_html( $plugin['name'] ); ?>
						<span class="info">
						<?php
							$key = '';
						if ( isset( $plugins['install'][ $slug ] ) ) {
							$key = esc_html__( 'Installation', 'pandastore' );
						} elseif ( isset( $plugins['update'][ $slug ] ) ) {
							$key = esc_html__( 'Update', 'pandastore' );
						} elseif ( isset( $plugins['activate'][ $slug ] ) ) {
							$key = esc_html__( 'Activation', 'pandastore' );
						}
						if ( $key ) {
							if ( $plugin['required'] ) {
								/* translators: %s: Plugin name */
								printf( esc_html__( '%s required', 'pandastore' ), $key );
							} else {
								/* translators: %s: Plugin name */
								printf( esc_html__( '%s recommended for certain demos', 'pandastore' ), $key );
							}
						}
						?>
						</span>
					</label>
				</li>
				<?php if ( ALPHA_CORE_SLUG == $plugin['slug'] ) : ?>
					<li class="separator"></li>
				<?php endif; ?>
			<?php } ?>
		</ul>
		<div class="use-multiple-editors notice-warning notice-alt notice-large" style="display: none;margin-bottom:0">
			<?php /* translators: $1 and $2 opening and closing bold tags respectively */ ?>
			<?php printf( esc_html__( 'Using %1$sElementor%2$s and %1$sVisual Composer%2$s togther affects your site performance.', 'pandastore' ), '<b>', '</b>' ); ?>
		</div>
		<?php
	} else {
		echo '<p class="lead">' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'pandastore' ) . '</p>';
	}
	?>

	<p class="alpha-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-dark button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Continue', 'pandastore' ); ?></a>
		<?php wp_nonce_field( 'alpha-setup-wizard' ); ?>
	</p>
</form>
