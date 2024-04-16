<?php
/**
 * History of theme
 *
 * Here, you can add or remove whats new content and change log.
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

if ( empty( $history_type ) ) {
	return;
}

// What's New Section
if ( 'whatsnew' == $history_type ) {
	?>
	<div class="alpha-whatsnew-item">
		<h3 class="alpha-item-title"><?php printf( esc_html__( 'Step into WordPress %1$s5.7.1%2$s', 'pandastore' ), '<span class="text-primary">', '</span>' ); ?></h3>
		<p class="alpha-item-desc">
		<?php
		echo esc_html__(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore ctetur adipis
magna aliqua. Venenatis tellus in metus vulputate eu scelerisque felis. Vel pretium lectus quam id leo in vitae us in metus vulpu
turpis massa. Nunc id cursus metus aliquam. Libero id faucibus nisl tincidunt eget. Aliquam id diam maecenas ero id fauci
ultricies mi eget mauris.',
			'pandastore'
		);
		?>
		</p>
	</div>
	<div class="alpha-whatsnew-item">
		<h4 class="alpha-item-title"><?php echo esc_html__( 'Maintenance and Security Releases', 'pandastore' ); ?></h4>
		<p class="alpha-item-desc">
		<?php
		printf(
			esc_html__(
				'Version 5.7.1 addressed some security issues and fixed 26 bugs. For more information, see %1$sthe release notes%2$s.',
				'pandastore'
			),
			'<a href="#">',
			'</a>'
		);
		?>
		</p>
	</div>
	<div class="alpha-whatsnew-item">
		<h4 class="alpha-item-title"><?php echo esc_html__( 'Maintenance and Security Releases', 'pandastore' ); ?></h4>
		<p class="alpha-item-desc">
		<?php
		printf(
			esc_html__(
				'Version 5.7.1 addressed some security issues and fixed 26 bugs. For more information, see %1$sthe release notes%2$s.',
				'pandastore'
			),
			'<a href="#">',
			'</a>'
		);
		?>
		</p>
	</div>
	<?php
} elseif ( 'changelog' == $history_type ) {
	?>
	<div class="alpha-changelog" id="log1">
		<h4 class="alpha-release-version"><?php echo esc_html__( 'Version 1.0.0 (27th December 2021)', 'pandastore' ); ?></h4>
		<h5 class="alpha-log-title"><i class="fas fa-star"></i><?php echo esc_html__( 'Initial Release', 'pandastore' ); ?></h5>
		<ul>
			<li><?php echo esc_html__( 'We launched on 27th Dec, 2021', 'pandastore' ); ?></li>
		</ul>
	</div>
	<?php
} elseif ( 'changelog_menu' == $history_type ) {
	?>
	<ul class="alpha-log-versions">
		<li class="alpha-log-version active"><a href="#log1">Version 1.0</a></li>
	</ul>
	<?php
}
