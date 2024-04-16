<?php
/**
 * Alpha Menu Walker
 *
 * @author     D-THEMES
 * @package    Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_Walker extends Alpha_Base {

	private $blocks = array();

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_walker_meta' ), 10, 1 );
		add_action( 'alpha_add_custom_fields', array( $this, 'add_custom_fields' ), 10, 4 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), 10, 2 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_walker' ), 10, 3 );

		add_action( 'admin_enqueue_scripts', array( $this, 'load' ) );

		$this->get_blocks();
	}

	/**
	 * Get blocks
	 *
	 * @since 1.0
	 */
	private function get_blocks() {
		$posts = get_posts(
			array(
				'post_type'   => ALPHA_NAME . '_template',
				'meta_key'    => ALPHA_NAME . '_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);

		sort( $posts );

		foreach ( $posts as $post ) {
			$this->blocks[ $post->ID ] = $post->post_title;
		}
	}

	/**
	 * Decorates a menu item object with the shared navigation menu item properties.
	 *
	 * @param array $menu_item The menu item to modify.
	 * @since 1.0
	 */
	public function setup_walker_meta( $menu_item ) {
		$menu_item->nolink         = get_post_meta( $menu_item->ID, '_menu_item_nolink', true );
		$menu_item->megamenu       = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
		$menu_item->megamenu_width = get_post_meta( $menu_item->ID, '_menu_item_megamenu_width', true );
		$menu_item->megamenu_pos   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_pos', true );
		$menu_item->image          = get_post_meta( $menu_item->ID, '_menu_item_image', true );
		$menu_item->block          = get_post_meta( $menu_item->ID, '_menu_item_block', true );
		$menu_item->icon           = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
		$menu_item->label_name     = get_post_meta( $menu_item->ID, '_menu_item_label_name', true );

		return $menu_item;
	}

	/**
	 * Add custom fields
	 *
	 * @since 1.0
	 */
	public function add_custom_fields( $id, $item, $depth, $args ) {
		?>
		<p class="field-nolink description description-wide">
			<label for="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>" value="nolink" name="menu-item-nolink[<?php echo esc_attr( $item->ID ); ?>]"<?php checked( $item->nolink, 'nolink' ); ?> />
					<?php esc_html_e( 'No Link', 'pandastore-core' ); ?>
			</label>
		</p>

		<p class="field-megamenu description description-wide">
			<label for="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>" value="megamenu" name="menu-item-megamenu[<?php echo esc_attr( $item->ID ); ?>]"<?php checked( $item->megamenu, 'megamenu' ); ?> />
					<?php esc_html_e( 'Megamenu', 'pandastore-core' ); ?>
			</label>
		</p>

		<p class="field-megamenu_width description description-wide" style="display: <?php echo alpha_escaped( $item->megamenu ? 'block' : 'none' ); ?>;">
			<label for="edit-menu-item-megamenu_width-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Megamenu Width (px)', 'pandastore-core' ); ?>
				<input type="text" id="edit-menu-item-megamenu_width-<?php echo esc_attr( $item->ID ); ?>" class="widefat" value="<?php echo (int) '' !== $item->megamenu_width ? $item->megamenu_width : 618; ?>" name="menu-item-megamenu_width[<?php echo esc_attr( $item->ID ); ?>]" />
				<?php echo sprintf( esc_html__( 'Input %1$szero%2$s to make full width megamenu', 'pandastore-core' ), '<b style="color: #000;">', '</b>' ); //phpcs:ignore ?>
			</label>
		</p>

		<p class="field-megamenu_pos description description-wide" style="display: <?php echo alpha_escaped( $item->megamenu ? 'block' : 'none' ); ?>;">
			<label for="edit-menu-item-megamenu_pos-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Megamenu Position', 'pandastore-core' ); ?>
				<select id="edit-menu-item-megamenu_pos-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-megamenu_pos[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->megamenu_pos ); ?>">
					<option value="left" <?php selected( 'left', $item->megamenu_pos ); ?>><?php esc_html_e( 'Left', 'pandastore-core' ); ?></option>
					<option value="center" <?php selected( 'center', $item->megamenu_pos ); ?>><?php esc_html_e( 'Center', 'pandastore-core' ); ?></option>
					<option value="right" <?php selected( 'right', $item->megamenu_pos ); ?>><?php esc_html_e( 'Right', 'pandastore-core' ); ?></option>
				</select>
			</label>
		</p>

		<?php if ( 2 == $depth ) { ?>

			<p class="field-image description description-wide">
				<label for="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>">
					<?php echo 'Select Background Image'; ?><br />
					<input type="text" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" class="widefat edit-menu-item-image"
						<?php if ( $item->image ) : ?>
							name="menu-item-image[<?php echo esc_attr( $item->ID ); ?>]"
						<?php endif; ?>
							data-name="menu-item-image[<?php echo esc_attr( $item->ID ); ?>]"
							value="<?php echo esc_attr( $item->image ); ?>" />
					<br/>
					<input class="btn_upload_img button" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" type="button" value="<?php echo esc_attr__( 'Upload Image', 'pandastore-core' ); ?>" />&nbsp;
					<input class="btn_remove_img button" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" type="button" value="<?php echo esc_attr__( 'Remove Image', 'pandastore-core' ); ?>" />
				</label>
			</p>

			<p class="field-block description description-wide">
				<label for="edit-menu-item-block-<?php echo esc_attr( $item->ID ); ?>">
					<?php echo esc_html__( 'Use Block', 'pandastore-core' ); ?><br />
					<select id="edit-menu-item-block-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-block[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->block ); ?>">
						<option value=""><?php esc_html_e( 'Select A Block', 'pandastore-core' ); ?></option>
						<?php
						if ( $this->blocks ) :
							foreach ( $this->blocks as $key => $value ) :
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $item->block, $key ); ?>><?php echo esc_html( $value ); ?></option>
								<?php
							endforeach;
						endif;
						?>
					</select>
					<?php esc_html_e( 'This option only works in megamenu.', 'pandastore-core' ); ?>
				</label>
			</p>

		<?php } ?>

		<p class="field-icon description description-wide">
			<label for="edit-menu-item-icon-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Prefix Icon Class', 'pandastore-core' ); ?>
				<input type="text" id="edit-menu-item-icon-<?php echo esc_attr( $item->ID ); ?>" class="widefat" value="<?php echo esc_attr( $item->icon ); ?>" name="menu-item-icon[<?php echo esc_attr( $item->ID ); ?>]" />
				<?php echo ALPHA_DISPLAY_NAME . esc_html__( ' Icon Store might be useful for you to select icons.', 'pandastore-core' ); ?>
			</label>
		</p>

		<p class="field-label_name description description-wide">
			<label for="edit-menu-item-label_name-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Add Label', 'pandastore-core' ); ?><br />
				<select id="edit-menu-item-label_name-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-label_name[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->label_name ); ?>">
					<option value=""><?php esc_html_e( 'Select A Label', 'pandastore-core' ); ?></option>
					<?php
					$labels = json_decode( alpha_get_option( 'menu_labels' ), true );
					if ( $labels ) :
						foreach ( $labels as $key => $value ) :
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $item->label_name, $key ); ?>><?php echo esc_html( $key ); ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
			</label>
		</p>
		<?php
	}

	/**
	 * Filters the Walker class used when adding nav menu items
	 *
	 * @since 1.0
	 */
	public function edit_walker() {
		require_once alpha_core_framework_path( ALPHA_CORE_ADDONS . '/walker/class-alpha-walker-nav-menu-edit.php' );
		return 'Alpha_Walker_Nav_Menu_Edit';
	}

	/**
	 * Save the properties of a menu item or create a new one.
	 *
	 * @param int      $menu_id            The ID of the menu. Required. If "0", makes the menu item a draft orphan.
	 * @param int      $menu_item_db_id    The ID of the menu item. If "0", creates a new menu item.
	 * @param array    $args               The menu item's data.
	 *
	 * @since 1.0
	 */
	public function update_walker( $menu_id, $menu_item_db_id, $args ) {
		$customs = array( 'nolink', 'megamenu', 'megamenu_width', 'megamenu_pos', 'image', 'icon', 'label_name', 'block' );

		foreach ( $customs as $key ) {
			if ( ! isset( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) ) {
				if ( ! isset( $args[ 'menu-item-' . $key ] ) ) {
					$value = '';
				} else {
					$value = $args[ 'menu-item-' . $key ];
				}
			} else {
				$value = sanitize_text_field( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] );

				if ( 'block' == $key ) {

				}
			}

			if ( '' !== $value ) {
				update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
			} else {
				delete_post_meta( $menu_item_db_id, '_menu_item_' . $key );
			}
		}
	}

	/**
	 * Enqueue script and style for Walker.
	 *
	 * @since 1.0
	 */
	public function load() {
		wp_enqueue_media();
		wp_enqueue_style( 'alpha-admin-walker', alpha_core_framework_uri( '/addons/walker/walker-admin.min.css' ), null, ALPHA_VERSION, 'all' );
		wp_enqueue_script( 'alpha-admin-walker', alpha_core_framework_uri( '/addons/walker/walker-admin' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );
	}
}

Alpha_Walker::get_instance();
