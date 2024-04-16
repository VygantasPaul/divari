<?php
/**
 * Panda Admin Meta Boxes
 *
 * @author     D-THEMES
 * @package    Alpha Core
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Admin_Meta_Boxes_Extend' ) ) {
	class Alpha_Admin_Meta_Boxes_Extend {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// Add product sales countdown option.
			if ( class_exists( 'WooCommerce' ) ) {
				add_action( 'woocommerce_product_options_pricing', array( $this, 'add_sale_pos_field' ) );
				add_action( 'woocommerce_process_product_meta', array( $this, 'save_sale_pos' ), 1, 2 );
			}
		}

		/**
		 * Print sale pos field
		 *
		 * @since 1.0
		 */
		public function add_sale_pos_field() {
			global $thepostid;
			$value = get_post_meta( $thepostid, 'alpha_sale_price_pos', true );
			?>
				<p class="form-field sale_price_pos_field">
					<input type="checkbox" id="alpha_sale_price_pos" name="alpha_sale_price_pos" value="<?php echo esc_attr( $value ); ?>" <?php checked( 'yes', $value ); ?> class="sale-price-pos-checkbox">
					<span class="description"><?php echo esc_html__( 'Enable this to show sales flash outside of product.', 'pandastore-core' ); ?></span>
				</p>
			<?php
		}

		/**
		 * Save sale pos
		 *
		 * @since 1.0
		 */
		public function save_sale_pos( $post_id ) {
			$new_meta = '';
			$new_meta = isset( $_POST['alpha_sale_price_pos'] ) ? $_POST['alpha_sale_price_pos'] : 'no';
			if ( ! empty( $new_meta ) ) {
				update_post_meta( $post_id, 'alpha_sale_price_pos', $new_meta );
			}
		}

	}
}

new Alpha_Admin_Meta_Boxes_Extend;
