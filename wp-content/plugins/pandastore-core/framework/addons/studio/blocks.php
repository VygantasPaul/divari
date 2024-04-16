<?php
/**
 * Alpha Studio Blocks List Template
 *
 * @author     D-THEMES
 * @package    WP Alpha FrameWork
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

foreach ( $args['blocks'] as $block ) :
	if ( $block instanceof WP_Post ) :
		$template_type = get_post_meta( $block->ID, ALPHA_NAME . '_template_type', true );
		?>
		<div class="block block-template">
			<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/<?php echo esc_attr( $template_type !== 'shop_layout' ? $template_type . '.svg' : $template_type . '.jpg' ); ?>">
			<h5 class="block-title"><?php echo esc_html( $block->post_title ); ?></h5>
			<div class="block-actions" data-id="<?php echo esc_attr( $block->ID ); ?>" data-category="<?php echo esc_attr( $template_type ); ?>">
				<button class="btn btn-primary <?php echo boolval( $args['studio']->new_template_mode ) ? 'select' : 'import'; ?>">
					<i class="fas fa-download"></i>
					<?php $args['studio']->new_template_mode ? esc_html_e( 'Select', 'pandastore-core' ) : esc_html_e( 'Import', 'pandastore-core' ); ?>
				</button>
			</div>
		</div>
		<?php
	else :
		$class = 'block block-online';
		// if ( isset( $block['w'] ) && 800 == (int) $block['w'] ) {
		// 	$class .= ' width-2';
		// }
		// if ( isset( $block['h'] ) && ( 80 >= (int) $block['h'] || 500 <= (int) $block['h'] ) ) {
		// 	$class .= ' center';
		// }
		if ( isset( $args['favourites_map'][ $block['block_id'] ] ) ) {
			$class .= ' favour';
		}
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<img src="<?php echo esc_url( ALPHA_SERVER_URI . 'dummy/images/studio/' . intval( isset( $block['s'] ) ? $block['s'] : $block['block_id'] ) . '.jpg' ); ?>" alt="<?php echo esc_attr( $block['t'] ); ?>"<?php echo isset( $block['w'] ) && $block['w'] ? ' width="' . intval( $block['w'] ) . '"' : '', isset( $block['h'] ) && $block['h'] ? ' height="' . intval( $block['h'] ) . '"' : ''; ?>>
			<h5 class="block-title"><?php echo esc_html( $block['t'] ); ?></h5>
			<div class="block-actions" data-id="<?php echo esc_attr( $block['block_id'] ); ?>" data-category="<?php echo esc_attr( $block['c'] ); ?>">
				<button class="btn btn-dark favourite"><i class="far fa-heart"></i><?php esc_html_e( 'Favourite', 'pandastore-core' ); ?></button>
				<?php if ( ( function_exists( 'Alpha' ) && Alpha()->is_registered() || get_option( 'alpha_registered' ) ) ) : ?>
					<button class="btn btn-primary <?php echo boolval( $args['studio']->new_template_mode ) ? 'select' : 'import'; ?>">
						<i class="fas fa-download"></i>
						<?php $args['studio']->new_template_mode ? esc_html_e( 'Select', 'pandastore-core' ) : esc_html_e( 'Import', 'pandastore-core' ); ?>
					</button>
				<?php endif; ?>
			</div>
		</div>
		<?php
	endif;
endforeach;
