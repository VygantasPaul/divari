<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Alpha_Products_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-products',
			'description' => esc_html__( 'Display widget typed products.', 'pandastore-core' ),
		);

		$control_ops = array( 'id_base' => 'products-widget' );

		parent::__construct( 'products-widget', ALPHA_DISPLAY_NAME . esc_html__( ' - Products', 'pandastore-core' ), $widget_ops, $control_ops );
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

		$args = array(
			'limit'   => isset( $instance['count'] ) ? $instance['count'] : 6,
			'orderby' => isset( $instance['orderby'] ) ? $instance['orderby'] : '',
			'order'   => isset( $instance['orderway'] ) ? $instance['orderway'] : 'ASC',
		);

		if ( isset( $instance['status'] ) ) {
			if ( 'featured' == $instance['status'] ) {
				$args['featured'] = true;
			} elseif ( 'sale' == $instance['status'] ) {
				//$args['sale_price'] = '>0';
			}
		}

		add_filter( 'woocommerce_product_is_visible', '__return_true' );

		$products = wc_get_products( $args );
		// wc_set_loop_prop( 'thumbnail_size', 'thumbnail' );
		wc_set_loop_prop( 'product_type', 'widget' );
		wc_set_loop_prop( 'is_sidebar_widget', true );
		// wc_set_loop_prop( 'show_info', array( 'price', 'rating' ) );
		wc_set_loop_prop( 'show_info', apply_filters( 'alpha_get_widget_products_show_info', array( 'price', 'rating' ) ) );

		if ( ! empty( $products ) ) {
			$slide_cnt = isset( $instance['slide_cnt'] ) ? $instance['slide_cnt'] : 3;

			if ( $slide_cnt < count( $products ) ) {
				echo '<div class="slider-wrapper row cols-1 gutter-no" data-slider-options="' . esc_attr(
					json_encode(
						array(
							'slidesPerView' => 1,
							'navigation'    => true,
							'pagination'    => false,
							'spaceBetween'  => 20,
							'statusClass'   => 'slider-nav-top',
						)
					)
				) . '">';
			}

			global $post, $product;

			for ( $i = 0; $i < count( $products ); $i ++ ) {
				if ( 0 == $i % $slide_cnt ) {
					if ( 0 != $i ) {
						echo '</ul>';
					}
					echo '<ul class="products-col">';
				}

				$product = $products[ $i ];
				$post    = get_post( $product->get_id() );

				wc_get_template_part( 'content', 'product' );
			}

				echo '</ul>';

			if ( $slide_cnt < count( $products ) ) {
				echo '</div>';
			}
		}
		wc_reset_loop();

		remove_filter( 'woocommerce_product_is_visible', '__return_true' );

		echo alpha_strip_script_tags( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = $new_instance['title'];
		$instance['status']    = $new_instance['status'];
		$instance['orderby']   = $new_instance['orderby'];
		$instance['orderway']  = $new_instance['orderway'];
		$instance['count']     = $new_instance['count'];
		$instance['slide_cnt'] = $new_instance['slide_cnt'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'     => '',
			'status'    => '',
			'orderby'   => '',
			'orderway'  => 'ASC',
			'count'     => '6',
			'slide_cnt' => '3',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'pandastore-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>">
				<strong><?php esc_html_e( 'Product Status', 'pandastore-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'status' ) ); ?>" value="<?php echo isset( $instance['status'] ) ? esc_attr( $instance['status'] ) : ''; ?>">
					<?php
					echo '<option value=""' . selected( $instance['status'], '' ) . '>' . esc_html__( 'All', 'pandastore-core' ) . '</option>';
					echo '<option value="featured"' . selected( $instance['status'], 'featured' ) . '>' . esc_html__( 'Featured', 'pandastore-core' ) . '</option>';
					?>
				</select>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<strong><?php esc_html_e( 'Product orderby', 'pandastore-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" value="<?php echo isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : ''; ?>">
					<?php
					echo '<option value=""' . selected( $instance['orderby'], '' ) . '>' . esc_html__( 'Default', 'pandastore-core' ) . '</option>';
					echo '<option value="ID"' . selected( $instance['orderby'], 'ID' ) . '>' . esc_html__( 'ID', 'pandastore-core' ) . '</option>';
					echo '<option value="title"' . selected( $instance['orderby'], 'title' ) . '>' . esc_html__( 'Name', 'pandastore-core' ) . '</option>';
					echo '<option value="date"' . selected( $instance['orderby'], 'date' ) . '>' . esc_html__( 'Date', 'pandastore-core' ) . '</option>';
					echo '<option value="modified"' . selected( $instance['orderby'], 'modified' ) . '>' . esc_html__( 'Modified', 'pandastore-core' ) . '</option>';
					echo '<option value="price"' . selected( $instance['orderby'], 'price' ) . '>' . esc_html__( 'Price', 'pandastore-core' ) . '</option>';
					echo '<option value="rand"' . selected( $instance['orderby'], 'rand' ) . '>' . esc_html__( 'Random', 'pandastore-core' ) . '</option>';
					echo '<option value="rating"' . selected( $instance['orderby'], 'rating' ) . '>' . esc_html__( 'Rating', 'pandastore-core' ) . '</option>';
					echo '<option value="comment_count"' . selected( $instance['orderby'], 'comment_count' ) . '>' . esc_html__( 'Comment Count', 'pandastore-core' ) . '</option>';
					echo '<option value="popularity"' . selected( $instance['orderby'], 'popularity' ) . '>' . esc_html__( 'Total Sales', 'pandastore-core' ) . '</option>';
					?>
				</select>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderway' ) ); ?>">
				<strong><?php esc_html_e( 'Product orderway', 'pandastore-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderway' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderway' ) ); ?>" value="<?php echo isset( $instance['orderway'] ) ? esc_attr( $instance['orderway'] ) : ''; ?>">
					<?php
					echo '<option value="ASC"' . selected( $instance['orderway'], 'ASC' ) . '>' . esc_attr( 'Ascending', 'pandastore-core' ) . '</option>';
					echo '<option value="DESC"' . selected( $instance['orderway'], 'DESC' ) . '>' . esc_attr( 'Descending', 'pandastore-core' ) . '</option>';
					?>
				</select>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<strong><?php esc_html_e( 'Total Count', 'pandastore-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'slide_cnt' ) ); ?>">
				<strong><?php esc_html_e( 'Count per Slide', 'pandastore-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slide_cnt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide_cnt' ) ); ?>" value="<?php echo esc_attr( $instance['slide_cnt'] ); ?>" />
			</label>
		</p>
		<?php
	}
}
