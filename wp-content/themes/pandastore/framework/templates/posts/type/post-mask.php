<?php
/**
 * The post mask template
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
alpha_get_template_part( 'posts/loop/post', 'media' );
?>
<div class="post-details">
	<div class="post-meta-visible">
		<?php alpha_get_template_part( 'posts/loop/post', 'date' ); ?>
		<?php alpha_get_template_part( 'posts/loop/post', 'title' ); ?>
	</div>
	<?php alpha_get_template_part( 'posts/loop/post', 'meta' ); ?>
</div>
