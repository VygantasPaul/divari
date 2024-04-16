<?php
/**
 * The main template
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

if ( alpha_doing_ajax() && isset( $_GET['only_posts'] ) ) {

	// Page content for ajax filtering in blog pages.
	alpha_print_title_bar();
	alpha_get_template_part( 'posts/archive' );
} else {

	get_header();

	do_action( 'alpha_before_content' );

	?>
	<div class="page-content">
		<?php
			do_action( 'alpha_print_before_page_layout' );
			alpha_get_template_part( 'posts/archive' );
			do_action( 'alpha_print_after_page_layout' );
		?>
	</div>
	<?php

	do_action( 'alpha_after_content' );

	get_footer();

}
