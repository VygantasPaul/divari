<?php
/**
 * Alpha Elementor Single Product Counter Widget
 *
 * @author     D-THEMES
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Alpha_Single_Product_Counter_Elementor_Widget extends \Elementor\Widget_Counter {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_counter';
	}

	public function get_title() {
		return esc_html__( 'Product Counter', 'pandastore-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-counter';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'name', 'total', 'sale', 'count', 'stock' );
	}

	public function get_script_depends() {
		return array( 'jquery-numerator' );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->update_control(
			'starting_number',
			array(
				'dynamic' => array(
					'active' => false,
				),
			)
		);

		$this->add_control(
			'adding_number',
			array(
				'label'   => esc_html__( 'Additional Count', 'pandastore-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'ending_number',
				),
			)
		);

		$this->update_control(
			'ending_number',
			array(
				'type'    => Controls_Manager::SELECT,
				'default' => 'sale',
				'options' => array(
					'sale'  => esc_html__( 'Sale Count', 'pandastore-core' ),
					'stock' => esc_html__( 'Stock', 'pandastore-core' ),
				),
			)
		);
	}

	protected function content_template() {
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			global $product;
			$settings = $this->get_settings_for_display();

			if ( 'sale' == $settings['ending_number'] ) {
				$count_to = $product->get_total_sales();
			} else {
				$count_to = $product->get_stock_quantity();
			}

			if ( $settings['adding_number'] ) {
				$count_to += $settings['adding_number'];
			}

			$this->add_render_attribute(
				'counter',
				array(
					'class'           => 'elementor-counter-number',
					'data-duration'   => $settings['duration'],
					'data-to-value'   => $count_to,
					'data-from-value' => $settings['starting_number'],
				)
			);

			if ( ! empty( $settings['thousand_separator'] ) ) {
				$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
				$this->add_render_attribute( 'counter', 'data-delimiter', $delimiter );
			}

			$this->add_render_attribute( 'counter-title', 'class', 'elementor-counter-title' );

			$this->add_inline_editing_attributes( 'counter-title' );
			?>
			<div class="elementor-counter">
				<div class="elementor-counter-number-wrapper">
					<span class="elementor-counter-number-prefix"><?php echo alpha_strip_script_tags( $settings['prefix'] ); ?></span>
					<span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php echo alpha_strip_script_tags( $settings['starting_number'] ); ?></span>
					<span class="elementor-counter-number-suffix"><?php echo alpha_strip_script_tags( $settings['suffix'] ); ?></span>
				</div>
				<?php if ( $settings['title'] ) : ?>
					<div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php echo alpha_strip_script_tags( $settings['title'] ); ?></div>
				<?php endif; ?>
			</div>
			<?php
			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}
