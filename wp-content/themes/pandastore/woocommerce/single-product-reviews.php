<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || die;

global $product;

$average_rate     = number_format( $product->get_average_rating(), 1 );
$display_rate     = $average_rate * 20;
$count            = $product->get_review_count();
$review_offcanvas = alpha_get_option( 'product_review_offcanvas' );

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">

	<?php if ( 'section' == apply_filters( 'alpha_single_product_data_tab_type', 'tab' ) ) : ?>
		<h2 class="title-wrapper title-underline woocommerce-Reviews-title">
			<span class="title"><?php echo esc_html( alpha_get_option( 'product_reviews_title' ) ); ?></span>
			<span class="select-box">
			<?php echo alpha_strip_script_tags( apply_filters( 'alpha_single_product_review_filter_select_html', '' ) ); ?>
			</span>
		</h2>
	<?php endif; ?>

	<div id="comments" data-id = "<?php the_ID(); ?>">
		<div class="row">
			<div class="col-md-4 mb-10">
				<div class="p-sticky
				<?php
				if ( 'tab' == apply_filters( 'alpha_single_product_data_tab_type', alpha_get_option( 'product_data_type' ) ) && ! alpha_doing_ajax() && apply_filters( 'alpha_single_product_tab_sticky_enabled', alpha_get_option( 'product_data_tab_sticky' ) ) ) {
					echo 'parent-tab-sticky';
				}
				?>
				">
					<h4 class="avg-rating-container">
						<mark><?php echo '' . $average_rate; ?></mark>
						<span class="avg-rating">
							<span class="avg-rating-title"><?php esc_html_e( 'Average Rating', 'pandastore' ); ?></span>
							<span class="star-rating">
								<span style="width: <?php echo alpha_escaped( $display_rate ) . '%'; ?>;">Rated</span>
							</span>
							<span class="ratings-review"><?php echo '(' . $count . ')'; ?></span>
						</span>
					</h4>
					<div class="ratings-list">
						<?php
						$ratings_count      = $product->get_rating_counts();
						$total_rating_value = 0;

						foreach ( $ratings_count as $key => $value ) {
							$total_rating_value += intval( $key ) * intval( $value );
						}

						for ( $i = 5; $i > 0; $i-- ) {
							$rating_value = isset( $ratings_count[ $i ] ) ? $ratings_count[ $i ] : 0;
							?>
							<div class="ratings-item">
								<div class="star-rating">
									<span style="width: <?php echo absint( $i ) * 20 . '%'; ?>">Rated</span>
								</div>
								<div class="rating-percent">
									<span style="width:
									<?php
									if ( ! intval( $rating_value ) == 0 ) {
										echo round( floatval( number_format( ( $rating_value * $i ) / $total_rating_value, 3 ) * 100 ), 1 ) . '%';
									} else {
										echo '0%';
									}
									?>
									;"></span>
								</div>
								<div class="progress-value">
									<?php
									if ( ! intval( $rating_value ) == 0 ) {
										echo round( floatval( number_format( ( $rating_value * $i ) / $total_rating_value, 3 ) * 100 ), 1 ) . '%';
									} else {
										echo '0%';
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) && $review_offcanvas ) : ?>
						<a class="btn btn-dim submit-review-toggle mt-7 text-uppercase" href="#" data-id="<?php echo alpha_strip_script_tags( $product->get_id() ); ?>"><?php echo esc_html__( 'Submit Review', 'pandastore' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-8 mb-4">
				<?php if ( have_comments() ) : ?>
					<h2 class="title-wrapper title-underline pb-4 select-wrapper">
						<span class="select-box">
						<?php echo alpha_strip_script_tags( apply_filters( 'alpha_single_product_review_filter_select_html', '' ) ); ?>
						</span>
					</h2>
					<?php if ( ! alpha_get_option( 'product_review_offcanvas' ) ) : ?>

						<ul class="commentlist">
							<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
						</ul>

						<?php
						if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
							echo '<nav class="woocommerce-pagination pagination mt-6">';
							echo alpha_get_review_pagination();
							echo '</nav>';
						endif;
						?>
					<?php endif; ?>

					<?php if ( alpha_get_option( 'product_review_offcanvas' ) ) : ?>
						<ul id="alpha_comment_tabs" class="alpha-comment-tabs nav nav-tabs tab-nav-solid" role="tablist" data-post_id = "<?php the_ID(); ?>">
							<li class="nav-item" role="tab" aria-controls="commentlist">
								<span data-href="#commentlist" class="nav-link active" data-mode="all"><?php esc_html_e( 'Show all', 'pandastore' ); ?></span>
							</li>
							<li class="nav-item" role="tab" aria-controls="commentlist-helpful-positive">
								<span data-href="#commentlist-helpful-positive" data-mode="helpful-positive" class="nav-link">
								<?php esc_html_e( 'Most Helpful Positive', 'pandastore' ); ?>
								</span>
							</li>
							<li class="nav-item" role="tab" aria-controls="commentlist-helpful-negative">
								<span data-href="#commentlist-helpful-negative" data-mode="helpful-negative" class="nav-link">
								<?php esc_html_e( 'Most Helpful Negative', 'pandastore' ); ?>
								</span>
							</li>
							<li class="nav-item" role="tab" aria-controls="commentlist-highrated">
								<span data-href="#commentlist-highrated" data-mode="high-rate" class="nav-link">
								<?php esc_html_e( 'Highest Rating', 'pandastore' ); ?>
								</span>
							</li>
							<li class="nav-item" role="tab" aria-controls="commentlist-lowrated">
								<span data-href="#commentlist-lowrated" data-mode="low-rate" class="nav-link">
								<?php esc_html_e( 'Lowest Rating', 'pandastore' ); ?>
								</span>
							</li>
						</ul>
						<div class="tab-content tab-templates">
							<ol id="commentlist" class="commentlist tab-pane active">
								<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
							</ol>
							<ol id="commentlist-helpful-positive" class="commentlist tab-pane" data-empty="<li class='review review-empty'><?php esc_html_e( 'No positive review exists.', 'pandastore' ); ?></li>"></ol>
							<ol id="commentlist-helpful-negative" class="commentlist tab-pane" data-empty="<li class='review review-empty'><?php esc_html_e( 'No negative review exists.', 'pandastore' ); ?></li>"></ol>
							<ol id="commentlist-highrated" class="commentlist tab-pane"></ol>
							<ol id="commentlist-lowrated" class="commentlist tab-pane"></ol>
						</div>

						<?php
						if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
							echo '<nav class="woocommerce-pagination pagination">';
							echo alpha_get_review_pagination();
							echo '</nav>';
						endif;
						?>
					<?php endif; ?>
				<?php else : ?>
					<h3 class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'pandastore' ); ?></h3>
				<?php endif ?>
			</div>
		</div>

	</div>

	<div class="clear"></div>
</div>
