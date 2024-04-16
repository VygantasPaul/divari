<?php
/**
 * Single post and other post-types template
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

get_header();
do_action( 'alpha_before_content' );
?>

<div class="page-content">
	<?php
		do_action( 'alpha_print_before_page_layout' );
		alpha_get_template_part( 'posts/single' );
		do_action( 'alpha_print_after_page_layout' );
	?>
</div>

<?php
do_action( 'alpha_after_content' );
get_footer();
