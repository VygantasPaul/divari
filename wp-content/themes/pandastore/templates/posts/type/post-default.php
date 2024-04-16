<?php
/**
 * The post default template
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

alpha_get_template_part( 'posts/loop/post', 'media' );
?>
<div class="post-details text-center p-relative">
	<div class="post-calendar">
		<span class="post-date"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></span>
	</div>
	<?php
	alpha_get_template_part( 'posts/loop/post', 'title' );
	alpha_get_template_part( 'posts/loop/post', 'content' );
	?>
</div>
