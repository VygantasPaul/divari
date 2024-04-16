<?php
/**
 * Alpha Product Advanced Swatch Tab for Admin
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Advanced_Swatch_Tab' ) ) {
	class Alpha_Advanced_Swatch_Tab extends Alpha_Base {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			$is_list_added              = false;
			$this->attribute_taxonomies = wc_get_attribute_taxonomies();
			foreach ( $this->attribute_taxonomies as $tax ) {
				if ( 'list' == $tax->attribute_type ) {
					add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_add_form_fields', array( $this, 'attr_add_form_fields' ), 100, 1 );
					add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_edit_form_fields', array( $this, 'attr_edit_form_fields' ), 100, 2 );
					$is_list_added = true;
				}
			}
			if ( $is_list_added ) {
				add_action( 'created_term', array( $this, 'save_attr_meta' ), 100, 3 );
				add_action( 'edit_term', array( $this, 'save_attr_meta' ), 100, 3 );
				add_action( 'delete_term', array( $this, 'delete_attr_meta' ), 10, 5 );
			}
			add_filter( 'product_attributes_type_selector', array( $this, 'product_attributes_add_list_type' ) );
			add_action( 'woocommerce_product_option_terms', array( $this, 'wc_product_option_terms' ), 10, 3 );

			add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ), 99 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_data_panel' ), 99 );
			add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_meta' ), 1, 2 );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1001 );
		}

		/**
		 * Add product data tab.
		 *
		 * @since 1.0
		 */
		public function add_product_data_tab( $tabs ) {
			$tabs['swatch'] = array(
				'label'    => esc_html__( 'Image Change & Swatch', 'pandastore-core' ),
				'target'   => 'swatch_product_options',
				'class'    => array( 'show_if_variable' ),
				'priority' => 80,
			);
			return $tabs;
		}

		/**
		 * Add product data panel.
		 *
		 * @since 1.0
		 */
		public function add_product_data_panel() {
			global $product_object;

			$attributes     = array_filter(
				$product_object->get_attributes(),
				function( $attr ) {
					return true === $attr->get_variation();
				}
			);
			$swatch_options = wc_get_product( $product_object->get_Id() )->get_meta( 'swatch_options', true );
			if ( $swatch_options ) {
				$swatch_options = json_decode( $swatch_options, true );
			}
			?>
			<div id="swatch_product_options" class="panel wc-metaboxes-wrapper woocommerce_options_panel hidden">
				<div class="wc-metaboxes">
				<?php
				if ( ! count( $attributes ) ) :
					?>

					<div id="message" class="inline notice alpha-wc-message">
						<p><?php printf( esc_html__( 'Before you can add image swatch you need to add some %1$slist%2$s variation attributes on the %1$sAttributes%2$s tab.', 'pandastore-core' ), '<strong>', '</strong>' ); ?></p>
						<p><a class="button-primary" href="<?php echo esc_url( apply_filters( 'woocommerce_docs_url', 'https://docs.woocommerce.com/document/variable-product/', 'product-variations' ) ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'pandastore-core' ); ?></a></p>
					</div>

					<?php
				else :
					?>
					<div class="inline error notice woocommerce-message"><p><?php echo sprintf( esc_html__( 'Product Attribute should have list( Advanced Swatch ) type. Please see the attribute type. %1$sClick here%2$s', 'pandastore-core' ), '<a target="_blank" href="' . admin_url( 'edit.php?post_type=product&page=product_attributes' ) . '">', '</a>' ); ?></p></div>
					<div class="inline notice woocommerce-message"><p><?php esc_html_e( 'This will replace product image with following uploaded image when attribute button is clicked.', 'pandastore-core' ); ?></p></div>
					<?php
					foreach ( $attributes as $attribute ) :
						$attribute_obj = $attribute->get_taxonomy_object();

						$metabox_class = array();
						if ( $attribute->is_taxonomy() ) {
							$metabox_class[] = 'taxonomy';
							$metabox_class[] = $attribute->get_name();
						}

						$swatch_type = $swatch_options && isset( $swatch_options[ $attribute->get_name() ] ) ? $swatch_options[ $attribute->get_name() ]['type'] : 'image';
						?>
							<div data-taxonomy="<?php echo esc_attr( $attribute->get_taxonomy() ); ?>" class="woocommerce_attribute wc-metabox closed <?php echo esc_attr( implode( ' ', $metabox_class ) ); ?>" rel="<?php echo esc_attr( $attribute->get_position() ); ?>">
								<h3>
									<strong>
										<?php echo wc_attribute_label( $attribute->get_name() ); ?>
									</strong>
								</h3>
								<div class="woocommerce_attribute_data wc-metabox-content hidden">
									<p class="form-field">
										<label><?php esc_html_e( 'Button Type', 'pandastore-core' ); ?> </label>
										<select class="swatch-type" id="swatch_options[<?php echo esc_attr( $attribute->get_name() ); ?>][type]" name="swatch_options[<?php echo esc_attr( $attribute->get_name() ); ?>][type]">
											<option value="label" <?php selected( $swatch_type, 'label' ); ?>><?php esc_html_e( 'Default', 'pandastore-core' ); ?></option>
											<option value="image" <?php selected( $swatch_type, 'image' ); ?>><?php esc_html_e( 'Image', 'pandastore-core' ); ?></option>
										</select>
										<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Select button type as image to show image on button.', 'pandastore-core' ); ?>"></span>
									</p>
									<table class="product_custom_swatches">
										<thead>
											<th><?php esc_html_e( 'Attribute', 'pandastore-core' ); ?></th>
											<th><?php esc_html_e( 'Image', 'pandastore-core' ); ?></th>
										</thead>

										<tbody>
										<?php
										foreach ( $attribute->get_options() as $option ) {
											$term = get_term( $option );
											if ( $term ) {
												$attr_label = $term->name;
											} else {
												$attr_label = $option;
												$option     = preg_replace( '/\s+/', '_', $option );
											}
											$src    = wc_placeholder_img_src();
											$src_id = $swatch_options && isset( $swatch_options[ $attribute->get_name() ] ) && isset( $swatch_options[ $attribute->get_name() ][ $option ] ) ? $swatch_options[ $attribute->get_name() ][ $option ] : '';
											if ( $src_id ) {
												$src = wp_get_attachment_image_src( $src_id )[0];
											}
											?>
												<tr>
													<td><?php echo esc_html( $attr_label ); ?></td>
													<td>
														<img src="<?php echo esc_url( $src ); ?>" alt="<?php esc_attr_e( 'Thumbnail Preview', 'pandastore-core' ); ?>" width="32" height="32">
														<input class="upload_image_url" type="hidden" name="swatch_options[<?php echo esc_attr( $attribute->get_name() ); ?>][<?php echo esc_attr( $option ); ?>]" value="<?php echo esc_attr( $src_id ); ?>" />
														<button class="button_upload_image button"><?php esc_html_e( 'Upload/Add image', 'pandastore-core' ); ?></button>
														<button class="button_remove_image button"><?php esc_html_e( 'Remove image', 'pandastore-core' ); ?></button>
													</td>
												</tr>
												<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						<?php
					endforeach;
					?>
					<div class="toolbar">
						<span class="expand-close"><a href="#" class="expand_all"><?php esc_html_e( 'Expand', 'pandastore-core' ); ?></a> / <a href="#" class="close_all"><?php esc_html_e( 'Close', 'pandastore-core' ); ?></a></span>
						<button type="submit" class="button-primary alpha-admin-save-changes" disabled="disabled"><?php esc_html_e( 'Save changes', 'pandastore-core' ); ?></button>
						<button type="reset" class="button alpha-admin-cancel-changes" disabled="disabled"><?php esc_html_e( 'Cancel', 'pandastore-core' ); ?></button>
					</div>
					<?php
				endif;
				?>
				</div>
			</div>
			<?php
		}

		/**
		 * Enqueue script
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_media();
			wp_enqueue_script( 'alpha-swatch-admin', alpha_core_framework_uri( '/addons/product-advanced-swatch/swatch-admin' . ALPHA_JS_SUFFIX ), array(), ALPHA_VERSION, true );
			wp_localize_script(
				'alpha-swatch-admin',
				'lib_swatch_admin',
				array(
					'placeholder' => esc_js( wc_placeholder_img_src() ),
					'title'       => esc_html__( 'Choose an image', 'pandastore-core' ),
					'button_text' => esc_html__( 'Use image', 'pandastore-core' ),
				)
			);
		}

		/**
		 * Save product meta.
		 *
		 * @param int $post_id The product id
		 * @since 1.0
		 */
		public function save_product_meta( $post_id, $post ) {

			if ( 'variable' != $_POST['product-type'] ) {
				return;
			}

			$product = wc_get_product( $post_id );

			$swatch_options = isset( $_POST['swatch_options'] ) ? $_POST['swatch_options'] : false;

			if ( $swatch_options && is_array( $swatch_options ) ) {
				$product->update_meta_data( 'swatch_options', json_encode( $swatch_options ) );
			} else {
				$product->delete_meta_data( 'swatch_options' );
			}

			$product->save_meta_data();
		}

		/**
		 * Add attribute type: list
		 *
		 * @since 1.0
		 */
		public function product_attributes_add_list_type( $types ) {
			$types['list'] = esc_html__( 'Advanced: Image, Color, Label Swatch', 'pandastore-core' );
			return $types;
		}

		/**
		 * The product option terms.
		 *
		 * @since 1.0
		 */
		public function wc_product_option_terms( $attribute_taxonomy, $i, $attribute ) {
			if ( 'list' == $attribute_taxonomy->attribute_type ) :
				?>
			<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
				<?php
				$args      = array(
					'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
					'hide_empty' => 0,
				);
				$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						$options = $attribute->get_options();
						$options = ! empty( $options ) ? $options : array();
						echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
					}
				}
				?>
			</select>
			<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
			<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
			<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button>
				<?php
			endif;
		}

		/**
		 * Add attribute form fields.
		 *
		 * @since 1.0
		 */
		public function attr_add_form_fields( $taxonomy ) {
			if ( $this->attribute_taxonomies ) {
				foreach ( $this->attribute_taxonomies as $tax ) {
					if ( wc_attribute_taxonomy_name( $tax->attribute_name ) == $taxonomy ) {
						?>
						<div class="form-field term-swatch-label-wrap">
							<label for="name"><?php esc_html_e( 'Swatch Label', 'pandastore-core' ); ?></label>
							<input name="attr_label" id="attr_label" type="text" value="" placeholder="Short text with 1 or 2 letters...">
							<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. This label will be shown on attribute swatches.', 'pandastore-core' ); ?></p>
						</div>
						<div class="form-field term-swatch-color-wrap">
							<label for="name"><?php esc_html_e( 'Swatch Color', 'pandastore-core' ); ?></label>
							<input type="text" class="alpha-color-picker" id="attr_color" name="attr_color" value="">
							<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. Each attribute swatch will be filled with this color.', 'pandastore-core' ); ?></p>
						</div>
						<div class="form-field term-swatch-image-wrap">
							<label for="name"><?php esc_html_e( 'Swatch Image', 'pandastore-core' ); ?></label>
							<div id="attr_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
							<div style="line-height: 60px;">
								<input type="hidden" id="attr_image" name="attr_image" value="" />
								<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'pandastore-core' ); ?></button>
								<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'pandastore-core' ); ?></button>
							</div>
							<div class="clear"></div>
							<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. This image will be shown on attribute swatches.', 'pandastore-core' ); ?></p>
						</div>
						<?php
					}
				}
			}
		}


		/**
		 * Edit attribute form fields.
		 *
		 * @since 1.0
		 */
		public function attr_edit_form_fields( $tag, $taxonomy ) {
			if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
				return;
			}
			if ( $this->attribute_taxonomies ) {
				foreach ( $this->attribute_taxonomies as $tax ) {
					if ( 'list' == $tax->attribute_type &&
					wc_attribute_taxonomy_name( $tax->attribute_name ) == $taxonomy ) {
						$thumbnail_url = '';
						$thumbnail_id  = '';
						if ( $tag ) {
							$thumbnail_id = get_term_meta( $tag->term_id, 'attr_image', true );
						}
						if ( ! $thumbnail_id ) {
							$thumbnail_url = wc_placeholder_img_src();
						} else {
							$thumbnail_url = wp_get_attachment_url( $thumbnail_id );
						}
						?>
						<tr class="form-field">
							<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Label', 'pandastore-core' ); ?></label></th>
							<td>
								<input name="attr_label" id="attr_label" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_label', true ) ); ?>" placeholder="Short text with 1 or 2 letters...">
								<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. This label will be shown on attribute swatches.', 'pandastore-core' ); ?></p>
							</td>
						</tr>
						<tr class="form-field">
							<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Color', 'pandastore-core' ); ?></label></th>
							<td>
								<input type="text" class="alpha-color-picker" id="attr_color" name="attr_color" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_color', true ) ); ?>">
								<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. Each attribute swatch will be filled with this color.', 'pandastore-core' ); ?></p>
							</td>
						</tr>

						<tr class="form-field">
							<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Image', 'pandastore-core' ); ?></label></th>
							<td>
								<div id="attr_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $thumbnail_url ); ?>" width="60px" height="60px" /></div>
								<div style="line-height: 60px;">
									<input type="hidden" id="attr_image" name="attr_image" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
									<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'pandastore-core' ); ?></button>
									<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'pandastore-core' ); ?></button>
								</div>
								<p class="description"><?php echo esc_html__( 'This option is added by Our Theme. This image will be shown on attribute swatches.', 'pandastore-core' ); ?></p>
								<div class="clear"></div>
							</td>
						</tr>

							<?php
					}
				}
			}
		}

		/**
		 * Save attr meta.
		 *
		 * @since 1.0
		 */
		public function save_attr_meta( $term_id, $tt_id, $taxonomy ) {
			if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
				return;
			}

			$args = array( 'attr_label', 'attr_color', 'attr_image' );

			foreach ( $args as $arg ) {
				if ( ! empty( $_POST[ $arg ] ) ) {
					if ( 'cat_col_cnt' == $arg ) {
						update_term_meta( $term_id, $arg, intval( $_POST[ $arg ] ) );
					} else {
						update_term_meta( $term_id, $arg, sanitize_text_field( $_POST[ $arg ] ) );
					}
				} else {
					delete_term_meta( $term_id, $arg );
				}
			}
		}

		/**
		 * Delete attr meta.
		 *
		 * @since 1.0
		 */
		public function delete_attr_meta( $term_id, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
			if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
				return;
			}

			$args = array( 'attr_label', 'attr_color', 'attr_image' );

			foreach ( $args as $arg ) {
				delete_term_meta( $term_id, $arg );
			}
		}
	}
}

Alpha_Advanced_Swatch_Tab::get_instance();
