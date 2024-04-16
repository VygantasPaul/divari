<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Alpha_Block_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-block',
			'description' => sprintf( esc_html__( 'Display %s Block built by template block bilder', 'pandastore-core' ), ALPHA_DISPLAY_NAME ),
		);

		$control_ops = array( 'id_base' => 'block-widget' );

		parent::__construct( 'block-widget', ALPHA_DISPLAY_NAME . esc_html__( ' - Block', 'pandastore-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args ); // @codingStandardsIgnoreLine

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo alpha_strip_script_tags( $before_widget );

		if ( $title ) {
			echo alpha_strip_script_tags( $before_title ) . sanitize_text_field( $title ) . alpha_strip_script_tags( $after_title );
		}

		if ( isset( $instance['id'] ) ) {
			echo do_shortcode( '[' . ALPHA_NAME . '_block name="' . $instance['id'] . '"]' );
		}

		echo alpha_strip_script_tags( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['id']    = $new_instance['id'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );

		$blocks = get_posts(
			array(
				'post_type'   => ALPHA_NAME . '_template',
				'meta_key'    => ALPHA_NAME . '_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);

		sort( $blocks );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'pandastore-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
				<strong><?php esc_html_e( 'Select Block', 'pandastore-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" value="<?php echo isset( $instance['id'] ) ? esc_attr( $instance['id'] ) : ''; ?>">
					<?php
					echo '<option value=""' . selected( ( isset( $instance['id'] ) ? $instance['id'] : '' ), '' ) . '>' . esc_attr( 'Select block to use', 'pandastore-core' ) . '</option>';

					if ( ! empty( $blocks ) ) {
						foreach ( $blocks as $block ) {
							echo '<option value="' . $block->ID . '" ' . selected( ( isset( $instance['id'] ) ? $instance['id'] : '' ), $block->ID ) . '>' . $block->post_title . '</option>';
						}
					}
					?>
				</select>
			</label>
		</p>
		<?php
	}
}
