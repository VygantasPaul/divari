<?php
/**
 * Alpha Dynamic Tags class
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 * @version    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Alpha_Core_Custom_Gallery_Tag extends Elementor\Core\DynamicTags\Data_Tag {

	public function get_name() {
		return 'alpha-custom-gallery';
	}

	public function get_title() {
		return esc_html__( 'Meta Box', 'pandastore-core' );
	}

	public function get_group() {
		return Alpha_Core_Dynamic_Tags::ALPHA_CORE_GROUP;
	}

	public function get_categories() {
		return array(
			Alpha_Core_Dynamic_Tags::GALLERY_CATEGORY,
		);
	}

	protected function _register_controls() {

		$this->add_control(
			'dynamic_field_source',
			array(
				'label'   => esc_html__( 'Source', 'pandastore-core' ),
				'type'    => Elementor\Controls_Manager::HIDDEN,
				'default' => 'meta-box',
			)
		);

		do_action( 'alpha_core_dynamic_before_render' );

		//Add metabox field
		do_action( 'alpha_dynamic_extra_fields', $this, 'image', 'meta-box' );

		do_action( 'alpha_core_dynamic_after_render' );

	}

	public function get_value( array $options = array() ) {

		do_action( 'alpha_core_dynamic_before_render' );

		$image_id = apply_filters( 'alpha_dynamic_extra_fields_content', null, $this->get_settings(), 'image' );

		do_action( 'alpha_core_dynamic_after_render' );

		if ( ! $image_id ) {
			return array();
		}

		return array_map(
			function( $item ) {
				return array( 'id' => $item );
			},
			$image_id
		);
	}

}
