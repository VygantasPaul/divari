<?php
/* Template Name: 404 page */
/**
 * Error 404 page template
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

get_header();

?>

<div class="page-content">

	<?php

		?>
		<div class="area_404">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-5">
						
						<h1 class="mb-4"><?php echo esc_html__( '404', 'pandastore' ); ?></h1>
						<h2 class="text-primary mb-5"><?php echo esc_html__( 'OOOPPS...!', 'pandastore' ); ?></h2>

						<h3 class="mb-3"><span class="text-success font-weight-normal"><?php echo esc_html__( 'Sorry!', 'pandastore' ); ?></span> <?php echo esc_html__( 'The page cannot be found', 'pandastore' ); ?></h1>
						
						<p class="mb-6"><?php esc_html_e( 'There may be a misspelling in the URL entered, or the page you are looking for may no longer exist', 'pandastore' ); ?></p>
						<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-dark btn-outline btn-icon-right"><?php echo esc_html__( 'Go Home', 'pandastore' ); ?><i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-arrow-long-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<?php

	




get_footer();
