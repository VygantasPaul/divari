<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined('ABSPATH') || die;

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) :
	$product_tabs_type = apply_filters('alpha_single_product_data_tab_type', alpha_get_option('product_data_type'));

	$wrapper_class = 'woocommerce-tabs';

	if ('accordion' == $product_tabs_type) {
		$wrapper_class .= ' wc-tabs-wrapper wc-tabs accordion accordion-border accordion-boxed';
	} elseif ('tab' == $product_tabs_type) {
		$wrapper_class .= ' wc-tabs-wrapper wc-tabs tab tab-nav-underline';
	} else {
		$wrapper_class .= ' wc-tabs-wrapper tab-sections';
	}
?>

	<?php do_action('alpha_wc_product_before_tabs'); ?>

	<div class="<?php echo esc_attr(apply_filters('alpha_single_product_data_tab_class', $wrapper_class)); ?>" role="tablist">

		<?php
		if ('tab' == $product_tabs_type) :
			if (apply_filters('alpha_single_product_tab_sticky_enabled', alpha_get_option('product_data_tab_sticky'))) {
				echo '<div class="sticky-content product-sticky-tab fix-top" data-sticky-options="{\'minWidth\': 768' . '}"><div class="container">';
			}
		?>
			<ul class="nav nav-tabs tabs">
				<?php
				$index = 0;
				foreach ($product_tabs as $key => $product_tab) :
					$index++;
				?>
					<li class="nav-item <?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
						<a href="#tab-<?php echo esc_attr($key); ?>" class="nav-link <?php echo (1 == $index ? 'active' : ''); ?>">
							<?php echo alpha_strip_script_tags(apply_filters('woocommerce_product_' . $key . '_tab_title2', $product_tab['title'], $key)); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php
			if (apply_filters('alpha_single_product_tab_sticky_enabled', true)) {
				echo '</div></div>';
			}
		endif;
		?>
		<?php if (have_rows('top_product_group')) : ?>
			<?php while (have_rows('top_product_group')) : the_row(); ?>
				<?php $top_heading = get_sub_field('top_heading') ?>
				<?php $top_description = get_sub_field('top_description') ?>
				<?php $top_h3 = get_sub_field('top_h3') ?>
				<div class="top-product heading">
					<div class="row ">
						<div class="col-12">
							<h2 class="title title-line title-underline mb-lg-8">
								<span>
									<?php echo $top_heading ?>
								</span>
							</h2>
							<h3 class="content-title mb-0">
								<?php echo $top_h3 ?>
							</h3>
							<div class=" mb-4 mb-lg-8">
								<?php echo $top_description ?>
							</div>
						</div>
					</div>
				</div>

				<?php if (have_rows('content_for_top_product')) : ?>
				<?php $total_rows = count(get_field('content_for_top_product')); ?>
					<?php $counter = 1; ?>
					<div class="top-product wrap">
						<?php while (have_rows('content_for_top_product')) : the_row(); ?>
							<?php $heading = get_sub_field('heading') ?>
							<?php $description = get_sub_field('description') ?>
							<?php $image = get_sub_field('image') ?>
							<div class="row align-center <?php echo ($counter  === 1) ? 'mt-0 pt-0' : 'mt-0 mt-lg-10 pt-8' ?>">
								<?php if ($counter % 2 === 0) : ?>
									<div class="col-12 col-md-6 col-lg-6 with-content-index content-index-1 pr-2 pr-lg-7 order-first order-md-last order-lg-first">
										<h4 class="content-subtitle mt-2">
											<?php echo $heading ?>
										</h4>
										<?php echo $description ?>
										<div class="counter-number">
											<?php echo $counter ?>
										</div>
									</div>
									<div class="col-12 col-md-6 col-lg-6 d-flex align-items-center order-last  order-md-first order-lg-first">
										<div class="overlay-dark">
											<figure>
												<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
											</figure>
										</div>
									</div>

								<?php else : ?>
									<div class="col-12 col-md-6 col-lg-6 d-flex align-items-center order-last order-lg-first  ">
										<div class="overlay-dark">
											<figure>
												<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
											</figure>
										</div>
									</div>
									<div class="col-12 col-md-6 col-lg-6 with-content-index content-index-2  pl-2 pl-lg-7 order-first order-lg-first  ">
										<h4 class="content-subtitle mt-2">
											<?php echo $heading ?>
										</h4>
										<?php echo $description ?>
										<div class="counter-number">
											<?php echo $counter ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
							<?php $counter++ ?>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php foreach ($product_tabs as $key => $product_tab) : ?>
			<?php
			$panel_class = 'entry-content';

			if ('accordion' == $product_tabs_type) {
				$panel_class .= ' card-body collapsed panel wc-tab';

			?>
				<div class="card">
					<div class="card-header <?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
						<a href="#tab-<?php echo esc_attr($key); ?>" class="expand">
							<?php echo alpha_strip_script_tags(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
							<span class="toggle-icon opened"><i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-angle-up-solid"></i></span>
							<span class="toggle-icon closed"><i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-angle-down-solid"></i></span>
						</a>
					</div>
				<?php
			} elseif ('tab' == $product_tabs_type) {
				$panel_class .= ' tab-pane panel wc-tab';
			} else {
				$panel_class .= ' tab-section'; ?>
		
			<?php }
			$panel_class .= ' woocommerce-Tabs-panel woocommerce-Tabs-panel--' . esc_attr($key);
				?>

				<div class="<?php echo esc_attr($panel_class); ?>" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" <?php echo 'section' != $product_tabs_type ? ' aria-labelledby="tab-title-' . esc_attr($key) . '"' : ''; ?>>
			
					<?php
					if ('section' == $product_tabs_type && !in_array($key, array('description', 'additional_information', 'vendor', 'reviews'))) :
					?>
						<h2 class="title-wrapper title-underline">
							<span class="title"><?php echo alpha_strip_script_tags($product_tab['title']); ?></span>
						</h2>
						
					<?php
					endif;
?> 
				 <?php	if (isset($product_tab['callback'])) {
					
						call_user_func($product_tab['callback'], $key, $product_tab);
					}
					?>

				</div>

				<?php if ('accordion' == $product_tabs_type) { ?>
				</div>
			<?php } ?>

		<?php endforeach; ?>

		<?php /// wc_get_template_part( 'single-product/meta'  ); 
		?>
		<?php
		global $product;

		$has_brand_image = false;
		$brands          = wp_get_post_terms(get_the_ID(), 'product_brand', array('fields' => 'id=>name'));
		$brand_html      = '';

		if (is_array($brands) && count($brands)) {
			foreach ($brands as $brand_id => $brand_name) {
				$brand_image = get_term_meta($brand_id, 'brand_thumbnail_id', true);
				if ($brand_image) {
					// If brand has an image
					$has_brand_image = true;
					$brand_html .= '<a class="brand" href="' . esc_url(get_term_link($brand_id, 'product_brand')) . '" title="' . esc_attr($brand_name) . '">';
					$brand_html .= wp_get_attachment_image($brand_image, 'full');
					$brand_html .= '</a>';
				} else {
					// If brand doesn't have an image, wrap the link within a <table> tag
					$brand_html .= '<table>';
					$brand_html .= 
					'<tr>
					<th>' . esc_html__('Brand: ', 'pandastore') . '</th> 
					<td><a href="' . esc_url(get_term_link($brand_id, 'product_brand')) . '" title="' . esc_attr($brand_name) . '">' . esc_html($brand_name) . '</a>
					</td>
					</tr>';
					$brand_html .= '</table>';
				}
			}
		}
		

		?>
		<div class="product_meta<?php echo !$has_brand_image ? ' no-brand-image' : ''; ?>">

			<?php
			if ($has_brand_image && $brand_html) :
				echo alpha_strip_script_tags($brand_html);
			endif;
			?>

			<?php do_action('woocommerce_product_meta_start'); ?>

			<div class="product-meta-inner">

				<?php
				if (!$has_brand_image && $brand_html) :
					echo alpha_strip_script_tags($brand_html);
				endif;
				?>
			</div>

			<?php do_action('woocommerce_product_meta_end'); ?>
		</div>

	</div>

	<?php do_action('woocommerce_product_after_tabs'); ?>

<?php endif; ?>