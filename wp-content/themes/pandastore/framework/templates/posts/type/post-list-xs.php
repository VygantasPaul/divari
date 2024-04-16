<?php
/**
 * The post list xs template ( calendar )
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

alpha_get_template_part( 'posts/loop/post', 'date-in-media' );
?>
<div class="post-details">
	<?php
	alpha_get_template_part( 'posts/loop/post', 'meta' );
	alpha_get_template_part( 'posts/loop/post', 'title' );
	?>
</div>
