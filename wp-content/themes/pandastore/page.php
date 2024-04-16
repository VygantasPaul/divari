<?php
/**
 * The page template
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
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
			alpha_get_page_links_html();
		}
	} else {
		echo '<h2 class="entry-title">' . esc_html__( 'Nothing Found', 'pandastore' ) . '</h2>';
	}

	do_action( 'alpha_print_after_page_layout' );
	?>

</div>

<?php
do_action( 'alpha_after_content' );

get_footer();
