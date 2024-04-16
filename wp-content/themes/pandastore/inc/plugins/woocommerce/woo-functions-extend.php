<?php
/**
 * Panda WooCommerce Functions
 *
 * @author     D-THEMES
 * @package    PandaStore
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

/**
 * The product loop count deal
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_product_loop_count_deal' ) ) {
	function alpha_product_loop_count_deal() {
		global $product;

		$show_info = alpha_wc_get_loop_prop( 'show_info', array() );
		if ( ! in_array( 'countdown', $show_info ) ) {
			return;
		}

		if ( $product->is_on_sale() ) {
			if ( $product->is_type( 'variable' ) ) {
				$variations = $product->get_available_variations( 'object' );
				$date_diff  = '';
				$sale_date  = '';
				foreach ( $variations as $variation ) {
					if ( $variation->is_on_sale() ) {
						$new_date = get_post_meta( $variation->get_id(), '_sale_price_dates_to', true );
						if ( ! $new_date || ( $date_diff && $date_diff != $new_date ) ) {
							$date_diff = false;
						} elseif ( $new_date ) {
							if ( false !== $date_diff ) {
								$date_diff = $new_date;
							}
							$sale_date = $new_date;
						}
						if ( false === $date_diff && $sale_date ) {
							break;
						}
					}
				}
				if ( $date_diff ) {
					$date_diff = date( 'Y/m/d H:i:s', (int) $date_diff );
				} elseif ( $sale_date ) {
					$date_diff = date( 'Y/m/d H:i:s', (int) $sale_date );
				}
			} else {
				$date_diff = $product->get_date_on_sale_to();
				if ( $date_diff ) {
					$date_diff = $date_diff->date( 'Y/m/d H:i:s' );
				}
			}
			if ( $date_diff ) :
				wp_enqueue_script( 'jquery-countdown' );
				wp_enqueue_script( 'alpha-countdown' );
				?>
				<div class="countdown-container inline-type">
					<span><?php echo esc_html__( 'Off Ends In:', 'pandastore' ); ?></span>
					<div class="countdown" data-until="<?php echo esc_attr( strtotime( $date_diff ) - strtotime( 'now' ) ); ?>" data-relative="true" data-labels-short="true" data-compact="true"></div>
				</div>
				<?php
			endif;
		}
	}
}
