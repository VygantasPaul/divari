<?php
/**
 * Alpha Studio Blocks Wrapper Template
 *
 * @author     D-THEMES
 * @package    WP Alpha FrameWork
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

$is_ajax = alpha_doing_ajax();
?>
<script type="text/template" id="alpha_studio_blocks_wrapper_template">
	<div class="blocks-wrapper closed">
		<button title="<?php esc_attr_e( 'Close (Esc)', 'pandastore-core' ); ?>" type="button" class="mfp-close">&times;</button>
		<div class="category-list">
			<?php /* translators: %s represents theme name.*/ ?>
			<h3>
				<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/logo-studio.png" alt="<?php printf( esc_attr__( '%s Studio', 'pandastore-core' ), ALPHA_DISPLAY_NAME ); ?>" width="206" height="73" />
			</h3>
			<ul>
				<li class="filtered"><a href="#" data-filter-by="0" data-total-page="<?php echo (int) $args['total_pages']; ?>"></a></li>
				<li>
					<a href="#" class="all active">
					<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/icon-all.svg">
						<?php esc_html_e( 'All', 'pandastore-core' ); ?>
						<span>(<?php echo (int) $args['total_count']; ?>)</span>
					</a>
				</li>
				<li class="category-has-children">
					<a href="#" class="block-category-blocks" data-filter-by="blocks" data-total-page="<?php echo (int) $args['blocks_pages']; ?>">
						<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/icon-block.svg">
						<?php esc_html_e( 'Blocks', 'pandastore-core' ); ?><i class="fa fa-chevron-down"></i>
					</a>
					<ul>
						<?php
						foreach ( $args['block_categories'] as $category ) :
							if ( ! in_array( $category['title'], $args['big_categories'] ) && $category['count'] > 0 ) :
								?>
								<li>
									<a href="#" data-filter-by="<?php echo (int) $category['id']; ?>" data-total-page="<?php echo (int) ( $category['total'] ); ?>">
										<?php echo esc_html( $args['studio']->get_category_title( $category['title'] ) ); ?>
									</a>
								</li>
								<?php
							endif;
						endforeach;
						?>
					</ul>
				</li>
				<?php
				foreach ( $args['big_categories'] as $big_category ) :
					$not_found = true;
					foreach ( $args['block_categories'] as $category ) :
						if ( $category['title'] == $big_category ) :
							?>
							<li>
								<a href="#" class="block-category-<?php echo esc_attr( $category['title'] ); ?>" data-filter-by="<?php echo esc_attr( $category['id'] ); ?>" data-total-page="<?php echo (int) ( $category['total'] ); ?>">
									<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/icon-<?php echo esc_attr( $big_category ); ?>.svg">
									<?php
									echo esc_html( $args['studio']->get_category_title( $category['title'] ) );
									if ( 'favourites' == $big_category || 'my-templates' == $big_category ) {
										echo '<span>(' . (int) $category['count'] . ')</span>';
									}
									?>
								</a>
							</li>
							<?php
							$not_found = false;
							break;
						endif;
					endforeach;
					if ( $not_found ) :
						?>
						<li>
							<a href="#" class="block-category-<?php echo esc_attr( $big_category ); ?>">
								<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/icon-<?php echo esc_attr( $big_category ); ?>.svg">
								<?php echo esc_html( $args['studio']->get_category_title( $big_category ) ); ?>
							</a>
						</li>
						<?php
					endif;
				endforeach;
				?>
			</ul>
		</div>
		<div class="blocks-section">
			<div class="blocks-section-inner">
				<div class="blocks-row">
					<div class="blocks-title">
						<h3><?php esc_html_e( 'All in One Library', 'pandastore-core' ); ?></h3>
						<p><?php esc_html_e( 'Choose any type of template from our library.', 'pandastore-core' ); ?></p>
					</div>
					<div class="demo-filter">
						<div class="layout-buttons">
							<button class="layout-2" data-column="2"></button>
							<button class="layout-3 active" data-column="3"></button>
							<button class="layout-4" data-column="4"></button>
						</div>
						<?php
						if ( ! class_exists( 'Alpha_Setup_Wizard' ) ) {
							require_once alpha_core_framework_path( ALPHA_FRAMEWORK_ADMIN . '/wizard/setup_wizard/setup_wizard.php' );
						}
						$instance = Alpha_Setup_Wizard::get_instance();
						$filters  = $instance->demo_types();
						?>
						<div class="custom-select">
							<select class="filter-select">
								<option value=""><?php esc_html_e( 'Select Demo', 'pandastore-core' ); ?></option>
								<?php foreach ( $filters as $name => $value ) : ?>
									<?php
									if ( ! empty( $value['editors'] ) && (
										( 'e' == $args['page_type'] && in_array( 'elementor', $value['editors'] ) ) ||
										( 'w' == $args['page_type'] && in_array( 'js_composer', $value['editors'] ) ) ) ) :
										?>
										<option value="<?php echo esc_attr( $name ); ?>" data-filter="<?php echo esc_attr( $value['filter'] ); ?>"><?php echo esc_html( $value['alt'] ); ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<button class="btn btn-primary" disabled="disabled"><?php esc_html_e( 'Filter', 'pandastore-core' ); ?></button>
					</div>
				</div>
					<?php if ( ! $is_ajax ) : ?>
					<div class="block-categories">
						<a href="#" class="block-category" data-category="blocks">
							<h4><?php esc_html_e( 'Blocks', 'pandastore-core' ); ?></h4>
							<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/block.svg">
						</a>
						<?php
						foreach ( $args['big_categories'] as $big_category ) {
							?>
							<a href="#" class="block-category" data-category="<?php echo esc_attr( $big_category ); ?>">
								<h4><?php echo esc_html( $args['studio']->get_category_title( $big_category ) ); ?></h4>
								<img src="<?php echo ALPHA_CORE_URI; ?>/assets/images/add-on/studio/<?php echo esc_attr( $big_category ); ?>.svg">
							</a>
							<?php
						}
						?>
					</div>
				<?php endif; ?>
				<div class="blocks-list column-3"></div>
				<div class="alpha-loading"><i></i></div>
			</div>
		</div>
		<div class="alpha-loading"><i></i></div>
	</div>
</script>
