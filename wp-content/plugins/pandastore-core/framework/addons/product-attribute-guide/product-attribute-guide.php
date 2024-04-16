<?php
/**
 * Product Attribute Guide Addon
 *
 * @author     D-THEMES
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @version    1.0
 */

// Show guide input controls
if ( is_admin() && 'edit.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post_type'] ) && 'product' == $_REQUEST['post_type'] && isset( $_REQUEST['page'] ) && 'product_attributes' == $_REQUEST['page'] ) {
	add_action( 'woocommerce_after_add_attribute_fields', 'alpha_wc_product_attribute_add_guide_options' );
	add_action( 'woocommerce_after_edit_attribute_fields', 'alpha_wc_product_attribute_edit_guide_options' );

	/**
 * The product attribute to add guide options
 *
 * @since 1.0
 */
	if ( ! function_exists( 'alpha_product_attribute_add_guide_options' ) ) {
		function alpha_product_attribute_add_guide_options() {
			//  Add, edit, or delete guide options
			$guide_block     = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
			$guide_text      = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
			$att_name        = isset( $_POST['attribute_name'] ) ? wc_sanitize_taxonomy_name( wp_unslash( $_POST['attribute_name'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
			$alpha_pa_blocks = get_option( 'alpha_pa_blocks', array() );
			if ( ! empty( $_POST['add_new_attribute'] ) || ( ! empty( $_POST['save_attribute'] ) && ! empty( $_GET['edit'] ) ) ) { // WPCS: CSRF ok.
				$alpha_pa_blocks[ $att_name ] = array(
					'block' => $guide_block,
					'text'  => $guide_text,
				);
			} elseif ( ! empty( $_GET['delete'] ) && isset( $alpha_pa_blocks[ $att_name ] ) ) {
				unset( $alpha_pa_blocks[ $att_name ] );
			}
			update_option( 'alpha_pa_blocks', $alpha_pa_blocks );
		}
	}

	alpha_product_attribute_add_guide_options();

	/**
	 * The wc product attribute to add guide otpions.
	 *
	 * @since 1.0
	 */
	if ( ! function_exists( 'alpha_wc_product_attribute_add_guide_options' ) ) {
		function alpha_wc_product_attribute_add_guide_options() {
			// Get blocks
			$posts = get_posts(
				array(
					'post_type'   => ALPHA_NAME . '_template',
					'meta_key'    => ALPHA_NAME . '_template_type',
					'meta_value'  => 'block',
					'numberposts' => -1,
				)
			);
			sort( $posts );
			?>
		<div class="form-field">
			<label for="guide_block"><?php esc_html_e( 'Guide block', 'pandastore-core' ); ?></label>
			<select name="guide_block" id="guide_block">
				<option value=""></option>
			<?php foreach ( $posts as $post ) : ?>
				<option value="<?php echo esc_attr( $post->ID ); ?>"><?php echo esc_html( $post->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'pandastore-core' ); ?></p>
	</div>
	<div class="form-field">
		<label for="guide_text"><?php esc_html_e( 'Guide link text', 'pandastore-core' ); ?></label>
		<input name="guide_text" id="guide_text" type="text" maxlength="64" />
		<p class="description"><?php esc_html_e( 'Link text for guide block.', 'pandastore-core' ); ?></p>
	</div>
			<?php
		}
	}

	/**
	 * The wc product attribute edit guide options.
	 *
	 * @since 1.0
	 */
	if ( ! function_exists( 'alpha_wc_product_attribute_edit_guide_options' ) ) {
		function alpha_wc_product_attribute_edit_guide_options() {
			$guide_block = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
			$guide_text  = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
			$edit        = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

			if ( $edit ) {
				global $wpdb;
				$attribute = $wpdb->get_row(
					$wpdb->prepare( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = %d", $edit )
				);

				if ( $attribute ) {
					$att_name = $attribute->attribute_name;

					$alpha_pa_blocks = get_option( 'alpha_pa_blocks', array() );
					if ( isset( $alpha_pa_blocks[ $att_name ] ) ) {
						$guide_block = $alpha_pa_blocks[ $att_name ]['block'];
						$guide_text  = $alpha_pa_blocks[ $att_name ]['text'];
					}
				}
			}

			// Get blocks
			$posts = get_posts(
				array(
					'post_type'   => ALPHA_NAME . '_template',
					'meta_key'    => ALPHA_NAME . '_template_type',
					'meta_value'  => 'block',
					'numberposts' => -1,
				)
			);
			sort( $posts );

			// Form
			?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="guide_block"><?php esc_html_e( 'Guide block', 'pandastore-core' ); ?></label>
		</th>
		<td>
			<select name="guide_block" id="guide_block">
				<option value=""></option>
			<?php foreach ( $posts as $post ) : ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $guide_block, $post->ID ); ?>><?php echo esc_html( $post->post_title ); ?></option>
				<?php endforeach; ?>
			</select>
			<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'pandastore-core' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="guide_text"><?php esc_html_e( 'Guide link text', 'pandastore-core' ); ?></label>
		</th>
		<td>
			<input name="guide_text" id="guide_text" type="text" value="<?php echo esc_attr( $guide_text ); ?>" maxlength="28" />
			<p class="description"><?php esc_html_e( 'Link text for guide block.', 'pandastore-core' ); ?></p>
		</td>
	</tr>
			<?php
		}
	}
}

add_filter( 'woocommerce_product_tabs', 'alpha_attribute_guide', 100 );

/**
 * Add attribute guide
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_attribute_guide' ) ) {
	function alpha_attribute_guide( $tabs ) {

		// Guide block
		global $product;
		if ( 'variable' == $product->get_type() ) {
			$attributes      = $product->get_attributes();
			$alpha_pa_blocks = get_option( 'alpha_pa_blocks' );

			foreach ( $attributes as $key => $attribute ) {
				$name = substr( $key, 3 );
				if ( isset( $alpha_pa_blocks[ $name ] ) &&
					isset( $alpha_pa_blocks[ $name ]['block'] ) && $alpha_pa_blocks[ $name ]['block'] &&
					isset( $alpha_pa_blocks[ $name ]['text'] ) && $alpha_pa_blocks[ $name ]['text'] ) {

					$tabs[ 'alpha_pa_block_' . $name ] = apply_filters(
						"alpha_product_attribute_{$name}_guide",
						array(
							'title'    => sanitize_text_field( $alpha_pa_blocks[ $name ]['text'] ),
							'priority' => 28,
							'callback' => 'alpha_wc_product_custom_tab',
							'block_id' => absint( $alpha_pa_blocks[ $name ]['block'] ),
						)
					);
				}
			}
		}
		return $tabs;
	}
}
