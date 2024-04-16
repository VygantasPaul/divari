<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Alpha_Filter_Clean_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-filter-clean',
			'description' => esc_html__( 'Display filter clean button in shop sidebar.', 'pandastore-core' ),
		);

		$control_ops = array( 'id_base' => 'filter-clean-widget' );

		parent::__construct( 'filter-clean-widget', ALPHA_DISPLAY_NAME . esc_html__( ' - Filter Clean', 'pandastore-core' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		if ( ! function_exists( 'alpha_is_shop' ) || ! alpha_is_shop() ) {
			return;
		}

		global $alpha_layout;
		if ( ! empty( $alpha_layout['top_sidebar'] ) && 'hide' != $alpha_layout['top_sidebar'] ) {
			return;
		}

		$show_clean = true;
		$url        = parse_url( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$shop_url   = str_replace( [ 'https://', 'http://', 'www.' ], '', get_permalink( wc_get_page_id( 'shop' ) ) );
		if ( $shop_url == $url['path'] && ( empty( $url['query'] ) || 'only_posts=1' == $url['query'] ) ) {
			$show_clean = false;
		}

		extract( $args ); // @codingStandardsIgnoreLine

		?>

		<div class="filter-actions">
			<label><?php esc_html_e( 'Filter :', 'pandastore-core' ); ?></label>
			<?php if ( $show_clean ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean"><?php esc_html_e( 'Clean All', 'pandastore-core' ); ?></a>
			<?php endif; ?>
		</div>

		<?php
	}


	public function form( $instance ) {
		?>
		<p><?php esc_html_e( 'Display filter clean button in shop sidebar.', 'pandastore-core' ); ?></p>
		<?php
	}
}
