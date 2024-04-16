<?php
/**
 * Header template in admin panel
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
$userinfo      = wp_get_current_user();
$errors        = get_option( 'alpha_register_error_msg' );
$purchase_code = Alpha_Admin::get_instance()->get_purchase_code_asterisk();
$is_activated  = false;
if ( ! empty( $purchase_code ) && empty( $errors ) ) {
	$is_activated = true;
}

$white_label_logo = alpha_get_option( 'white_label_logo' );
if ( empty( $white_label_logo ) ) {
	$white_label_logo = ALPHA_URI . '/assets/images/logo-admin.png';
}
?>
<div class="alpha-wrap">
	<div class="alpha-admin-header">
		<div class="alpha-admin-logo">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=alpha' ) ); ?>">
				<img src="<?php echo esc_url( $white_label_logo ); ?>" data-image-src="<?php echo esc_attr( ALPHA_URI . '/assets/images/' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
			</a>
		</div>
		<?php if ( ! empty( $admin_config['admin_navs'] ) ) : ?>
		<nav class="alpha-admin-nav">
			<?php
			foreach ( $admin_config['admin_navs'] as $key => $item ) {
				$url       = isset( $item['url'] ) ? $item['url'] : '#';
				$label     = isset( $item['label'] ) ? $item['label'] : '';
				$icon      = isset( $item['icon'] ) ? $item['icon'] : 'fas fa-th-large';
				$icon_html = ! isset( $item['is_svg'] ) ? '<i class="' . esc_attr( $icon ) . '"></i>' : esc_html( $icon );
				if ( empty( $item['submenu'] ) ) {
					$is_active = $key === $active_page ? ' active' : '';
					?>
					<a class="alpha-admin-nav-panel <?php echo esc_attr( $key . $is_active ); ?>" href="<?php echo esc_url( $url ); ?>">
						<?php echo alpha_strip_script_tags( $icon_html ); ?>
						<label><?php echo esc_html( $label ); ?></label>
					</a>
					<?php
				} elseif ( 1 == count( $item['submenu'] ) ) {
					foreach ( $item['submenu'] as $subkey => $subitem ) {
						$url       = isset( $subitem['url'] ) ? $subitem['url'] : '#';
						$label     = isset( $subitem['label'] ) ? $subitem['label'] : '';
						$is_active = $subkey === $active_page ? ' active' : '';
						?>
						<a class="alpha-admin-nav-panel <?php echo esc_attr( $subkey . $is_active ); ?>" href="<?php echo esc_url( $url ); ?>">
							<?php echo alpha_strip_script_tags( $icon_html ); ?>
							<label><?php echo esc_html( $label ); ?></label>
						</a>
						<?php
					}
				} else {
					$is_active = false !== array_search( $active_page, array_keys( $item['submenu'] ) ) ? ' active' : '';
					?>
					<div class="alpha-admin-nav-panel has-menu <?php echo esc_attr( $key . $is_active ); ?>">
						<?php echo alpha_strip_script_tags( $icon_html ); ?>
						<label><?php echo esc_html( $label ); ?></label>
						<div class="alpha-admin-subnavs">
						<?php
						foreach ( $item['submenu'] as $subkey => $subitem ) {
							$url       = isset( $subitem['url'] ) ? $subitem['url'] : '#';
							$label     = isset( $subitem['label'] ) ? $subitem['label'] : '';
							$icon      = isset( $subitem['icon'] ) ? $subitem['icon'] : 'fas fa-th-large';
							$desc      = isset( $subitem['desc'] ) ? $subitem['desc'] : '';
							$icon_html = ! isset( $subitem['is_svg'] ) ? '<i class="' . esc_attr( $icon ) . '"></i>' : $icon;
							?>
							<a class="alpha-admin-subnav <?php echo esc_attr( $subkey ); ?>" href="<?php echo esc_url( $url ); ?>">
								<?php echo alpha_strip_script_tags( $icon_html ); ?>
								<label>
									<?php echo esc_html( $label ); ?>
									<span><?php echo esc_html( $desc ); ?></span>
								</label>
							</a>	
							<?php
						}
						?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</nav>
		<?php endif; ?>
		<div class="alpha-active-dropdown">
			<a href="#" class="alpha-toggle alpha-active-toggle <?php echo esc_attr( $is_activated ? 'activated' : '' ); ?>">
				<i class="admin-svg-key"></i>
				<?php
				if ( $is_activated ) {
					echo esc_html__( 'Registered', 'pandastore' );
				} else {
					echo esc_html__( 'Unregistered', 'pandastore' );
				}
				?>
			</a>
			<div class="alpha-active-content">
			</div>
		</div>
	</div>
	<div id="alpha_active_wrapper" style="<?php echo esc_attr( $is_activated ? 'display:none;' : '' ); ?>">
		<?php require_once alpha_framework_path( ALPHA_FRAMEWORK_PATH . '/admin/panel/views/activation.php' ); ?>
	</div>
	<div class="alpha-admin-panel">
		<div class="alpha-admin-preloader">
			<div class="alpha-loader">
				<div class="alpha-inner alpha-one"></div>
				<div class="alpha-inner alpha-two"></div>
				<div class="alpha-inner alpha-three"></div>
			</div>
		</div>
		<div class="alpha-admin-panel-header">
		<?php if ( empty( $title ) ) { ?>
			<h2 class="alpha-panel-title"><?php printf( esc_html__( 'Welcome to %1$s!', 'pandastore' ), ALPHA_DISPLAY_NAME ); ?></h2>
			<p class="alpha-running-info"><?php printf( esc_html__( 'Thanks for choosing %1$s. Get ready to build something beautiful. We hope you enjoy it!', 'pandastore' ), ALPHA_DISPLAY_NAME ); ?></p>
		<?php } else { ?>
			<h2 class="alpha-panel-title"><?php echo esc_html( $title['title'] ); ?></h2>
			<p class="alpha-running-info"><?php echo esc_html( $title['desc'] ); ?></p>
		<?php } ?>
		</div>
