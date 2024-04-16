<?php
/**
 * The post simple template
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

alpha_get_template_part( 'posts/loop/post', 'media' );
?>
<div class="post-details text-center">
	<?php
	alpha_get_template_part( 'posts/loop/post', 'category' );
	alpha_get_template_part( 'posts/loop/post', 'title' );
	alpha_get_template_part( 'posts/loop/post', 'meta' );
	alpha_get_template_part( 'posts/loop/post', 'content' );
	?>
</div>
