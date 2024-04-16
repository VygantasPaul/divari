<?php
/**
 * Alpha Tools
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

// Direct access is denied
defined( 'ABSPATH' ) || die;

class Alpha_Tools extends Alpha_Base {

	/**
	 * The Page slug
	 *
	 * @since 1.0
	 * @access public
	 */
	public $page_slug = 'alpha-tools';

	/**
	 * The Result
	 *
	 * @since 1.0
	 * @access public
	 */
	private $result;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		if ( ! current_user_can( 'administrator' ) || ! isset( $_GET['page'] ) || $this->page_slug != $_GET['page'] ) {
			return;
		}

		$this->handle_request();
	}


	/**
	 * Add Tools to admin menu
	 *
	 * @since 1.0
	 * @access public
	 */
	public function add_admin_menu() {
		add_submenu_page( 'alpha', esc_html__( 'Tools', 'pandastore' ), esc_html__( 'Tools', 'pandastore' ), 'manage_options', $this->page_slug, array( $this, 'view_tools' ), 2 ); // phpcs:ignore WPThemeReview.PluginTerritory.NoAddAdminPages
	}

	/**
	 * Handle request to execute tools
	 *
	 * @since 1.0
	 * @access public
	 */
	public function handle_request() {

		if ( ! current_user_can( 'administrator' ) || ! isset( $_GET['page'] ) || $this->page_slug != $_GET['page'] ) {
			return;
		}

		$tools = $this->get_tools();

		$result_success = true;
		$message        = '';

		if ( ! empty( $_GET['action'] ) ) {
			if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'alpha-tools' ) ) {
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'pandastore' ) );
			}

			$action = wp_unslash( $_GET['action'] ); // WPCS: input var ok.

			if ( array_key_exists( $action, $tools ) ) {
				$this->result = $this->execute_tool( $action );

				$tool = $tools[ $action ];
				$tool = array(
					'id'          => $action,
					'name'        => $tool['action_name'],
					'action'      => $tool['button_text'],
					'description' => $tool['description'],
				);
				$tool = array_merge( $tool, $this->result );

				/**
				 * Fires after a Alpha tool has been executed.
				 *
				 * @param array  $tool  Details about the tool that has been executed.
				 */
				do_action( 'alpha_tool_executed', $tool );
			} else {
				$this->result = array(
					'success' => false,
					'message' => esc_html__( 'Tool does not exist.', 'pandastore' ),
				);
			}
		}
	}

	/**
	 * Refresh all blocks
	 *
	 * @since 1.0
	 * @access public
	 */
	public function refresh_blocks() {

	}

	/**
	 * Get available Tools
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_tools() {
		$tools = array(
			'clear_transients'        => array(
				'action_name' => esc_html__( 'Addon transients', 'pandastore' ),
				'button_text' => esc_html__( 'Clear transients', 'pandastore' ),
				'description' => sprintf( esc_html__( 'This will clear the %s Addon Features(Brand, Vendor, etc)transients cache.', 'pandastore' ), ALPHA_DISPLAY_NAME ),
			),
			'clear_plugin_transients' => array(
				'action_name' => esc_html__( 'Plugin transients', 'pandastore' ),
				'button_text' => esc_html__( 'Clear transients', 'pandastore' ),
				'description' => sprintf( esc_html__( 'This tool will clear the plugin(%s Core Plugin, WPBakery Page Builder) update transients cache.', 'pandastore' ), ALPHA_DISPLAY_NAME ),
			),
			'clear_studio_transients' => array(
				'action_name' => esc_html__( 'Studio block transients', 'pandastore' ),
				'button_text' => esc_html__( 'Clear transients', 'pandastore' ),
				'description' => sprintf( esc_html__( 'This tool will clear the %s Studio block transients cache.', 'pandastore' ), ALPHA_DISPLAY_NAME ),
			),
		);

		return apply_filters( 'alpha_admin_get_tools', $tools );
	}

	/**
	 * Execute tool
	 *
	 * @since 1.0
	 * @access public
	 */
	public function execute_tool( $tool ) {
		$ran = true;
		switch ( $tool ) {
			case 'clear_transients':
				alpha_clear_transient();
				$message = __( 'Addon transients are cleared', 'pandastore' );
				break;
			case 'clear_plugin_transients':
				delete_site_transient( 'alpha_plugins' );
				$message = __( 'Plugin transients are cleared', 'pandastore' );
				break;
			case 'clear_studio_transients':
				delete_site_transient( 'alpha_blocks_e' );
				delete_site_transient( 'alpha_block_categories_e' );
				delete_site_transient( 'alpha_blocks_wpb' );
				delete_site_transient( 'alpha_block_categories_w' );
				$message = sprintf( esc_html__( '%s Studio transients are cleared', 'pandastore' ), ALPHA_DISPLAY_NAME );
				break;
			case 'refresh_blocks':
				$this->refresh_blocks();
				$message = esc_html__( 'Refreshed successfully.', 'pandastore' );
				break;
			default:
				$tools = $this->get_tools();
				if ( isset( $tools[ $tool ]['callback'] ) ) {
					$callback = $tools[ $tool ]['callback'];
					$return   = call_user_func( $callback );
					if ( is_string( $return ) ) {
						$message = $return;
					} elseif ( false === $return ) {
						$callback_string = is_array( $callback ) ? get_class( $callback[0] ) . '::' . $callback[1] : $callback;
						$ran             = false;
						/* translators: %s: callback string */
						$message = sprintf( esc_html__( 'There was an error calling %s', 'pandastore' ), $callback_string );
					} else {
						$message = esc_html__( 'Tool ran.', 'pandastore' );
					}
				} else {
					$ran     = false;
					$message = __( 'There was an error calling this tool. There is no callback present.', 'pandastore' );
				}
				/**
				 * Fires after setting default execute options.
				 *
				 * @since 1.0
				 */
				do_action( 'alpha_execute_tool', $this, $tool );
				break;
		}

		return array(
			'success' => $ran,
			'message' => $message,
		);
	}


	/**
	 * Render tools page
	 *
	 * @since 1.0
	 * @access public
	 */
	public function view_tools() {
		$admin_config = Alpha_Admin::get_instance()->admin_config;
		$title        = array(
			'title' => esc_html__( 'Management Tools', 'pandastore' ),
			'desc'  => sprintf( esc_html__( 'Keep your site health instantly using %s Tools', 'pandastore' ), ALPHA_DISPLAY_NAME ),
		);
		Alpha_Admin_Panel::get_instance()->view_header( 'tools', $admin_config );

		$tools = $this->get_tools();
		$nonce = wp_create_nonce( 'alpha-tools' );
		?>
		<div class="alpha-admin-panel-body alpha-card-box alpha-available-tools">
			<?php
			if ( isset( $this->result ) ) {
				if ( $this->result['success'] ) {
					echo '<div class="alpha-notify updated inline"><p>' . esc_html( $this->result['message'] ) . '</p></div>';
				} else {
					echo '<div class="alpha-notify error inline"><p>' . esc_html( $this->result['message'] ) . '</p></div>';
				}
			}
			?>
			<table class="wp-list-table widefat" id="alpha_tools_table">
				<thead>
					<tr>
						<th scope="col" id="title" class="manage-column column-title column-primary"><?php esc_html_e( 'Action Name', 'pandastore' ); ?></th>
						<th scope="col" id="remove" class="manage-column column-remove"><?php esc_html_e( 'Action', 'pandastore' ); ?></th>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php foreach ( $tools as $action => $tool ) : ?>
						<tr class="<?php echo sanitize_html_class( $action ); ?>">
							<th>
								<strong class="action-name"><?php echo esc_html( $tool['action_name'] ); ?></strong>
								<p class="description"><?php echo alpha_strip_script_tags( $tool['description'] ); ?></p>
							</th>
							<td class="run-tool">
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=alpha-tools&action=' . $action . '&&_wpnonce=' . $nonce ) ); ?>" class="button button-large button-light <?php echo esc_attr( $action ); ?>"><?php echo esc_html( $tool['button_text'] ); ?></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
		Alpha_Admin_Panel::get_instance()->view_footer( $admin_config );
	}
}

Alpha_Tools::get_instance();
