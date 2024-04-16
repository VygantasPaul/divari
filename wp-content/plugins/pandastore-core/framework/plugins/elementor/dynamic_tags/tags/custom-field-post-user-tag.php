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

class Alpha_Core_Custom_Field_Post_User_Tag extends Elementor\Core\DynamicTags\Tag {

	protected $post_id;

	public function get_name() {
		return 'alpha-custom-field-post-user';
	}

	public function get_title() {
		return esc_html__( 'Posts / Users', 'pandastore-core' );
	}

	public function get_group() {
		return Alpha_Core_Dynamic_Tags::ALPHA_CORE_GROUP;
	}

	public function get_categories() {
		return array(
			Alpha_Core_Dynamic_Tags::TEXT_CATEGORY,
			Alpha_Core_Dynamic_Tags::NUMBER_CATEGORY,
			Alpha_Core_Dynamic_Tags::URL_CATEGORY,
			Alpha_Core_Dynamic_Tags::POST_META_CATEGORY,
			Alpha_Core_Dynamic_Tags::COLOR_CATEGORY,
		);
	}

	protected function _register_controls() {
		$this->add_control(
			'dynamic_field_post_object',
			array(
				'label'   => esc_html__( 'Object Field', 'pandastore-core' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'post_title',
				'groups'  => $this->get_object_fields(),
			)
		);
	}

	public function get_object_fields() {
		$fields = array(
			array(
				'label'   => esc_html__( 'Post', 'pandastore-core' ),
				'options' => array(
					'post_id'          => esc_html__( 'Post ID', 'pandastore-core' ),
					'post_title'       => esc_html__( 'Title', 'pandastore-core' ),
					'post_date'        => esc_html__( 'Date', 'pandastore-core' ),
					'post_content'     => esc_html__( 'Content', 'pandastore-core' ),
					'post_excerpt'     => esc_html__( 'Excerpt', 'pandastore-core' ),
					'post_status'      => esc_html__( 'Post Status', 'pandastore-core' ),
					'comment_count'    => esc_html__( 'Comments Count', 'pandastore-core' ),
					'alpha_post_likes' => esc_html__( 'Like Posts Count', 'pandastore-core' ),
				),
			),
			array(
				'label'   => esc_html__( 'User', 'pandastore-core' ),
				'options' => array(
					'ID'              => esc_html__( 'ID', 'pandastore-core' ),
					'user_login'      => esc_html__( 'Login', 'pandastore-core' ),
					'user_nicename'   => esc_html__( 'Nickname', 'pandastore-core' ),
					'user_email'      => esc_html__( 'E-mail', 'pandastore-core' ),
					'user_url'        => esc_html__( 'URL', 'pandastore-core' ),
					'user_registered' => esc_html__( 'Registration Date', 'pandastore-core' ),
					'display_name'    => esc_html__( 'Display Name', 'pandastore-core' ),
				),
			),
		);

		return $fields;
	}

	public function render() {

		do_action( 'alpha_core_dynamic_before_render' );

		$this->post_id = get_the_ID();
		$atts          = $this->get_settings();
		$ret           = '';

		$property = $atts['dynamic_field_post_object'];

		$ret = (string) $this->get_prop( $property );

		if ( 'post_content' === $property ) {

			if ( Elementor\Plugin::$instance->db->is_built_with_elementor( $this->post_id ) ) {

				$editor       = Elementor\Plugin::$instance->editor;
				$is_edit_mode = $editor->is_edit_mode();

				$editor->set_edit_mode( false );

				global $post;
				$temp = $post;
				$post = '';

				$ret = Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $this->post_id, $is_edit_mode );

				$post = $temp;

				$editor->set_edit_mode( $is_edit_mode );

			} else {
				$ret = apply_filters( 'the_content', $ret );
			}
		}

		if ( 'category' == $property ) {
			$ret = get_the_category_list( ', ', '', $this->post_id );
		} elseif ( 'tags' == $property ) {
			$ret = get_the_tag_list( '', ', ', '', $this->post_id );
		} elseif ( 'alpha_post_likes' == $property ) {
			$ret = get_post_meta( $this->post_id, $property, true );
		}

		if ( is_array( $ret ) ) {
			$temp_content = '';
			if ( count( $ret ) > 1 ) {
				foreach ( $ret as $value ) {
					$temp_content .= (string) $value;
				}
			} else {
				$temp_content .= (string) $ret[0];
			}
			$ret = $temp_content;
		}

		echo alpha_strip_script_tags( $ret );

		do_action( 'alpha_core_dynamic_after_render' );
	}

	// helper functions
	public function get_post_object() {
		$post_object = false;
		global $post;

		$post_object        = false;

		global $post;

		if ( is_tax() || is_category() || is_tag() || is_author() ) {
			$post_object = get_queried_object();
		} elseif ( wp_doing_ajax() ) {
			$post_object = get_post( $this->post_id );
		} else {
			$post_object = $post;
		}

		return $post_object;
	}

	public function get_prop( $property = null, $object = null ) {

		$user_properties = array(
			'ID',
			'user_login',
			'user_nicename',
			'user_email',
			'user_url',
			'user_registered',
			'display_name',
		);

		if ( $user_properties && in_array( $property, $user_properties ) ) {

			if ( $object ) {
				$current_user = $object;
			} else {
				global $authordata;
				$current_user = $authordata;
			}

			if ( ! $current_user ) {
				return false;
			}

			$vars = get_object_vars( $current_user );
			$vars = ! empty( $vars['data'] ) ? (array) $vars['data'] : array();

			if ( 'user_nicename' === $property ) {
				$vars['user_nicename'] = get_author_meta( $current_user->ID, 'nickname', true );
			}
			if ( 'user_url' === $property ) {
				$vars['user_url'] = esc_url( get_author_posts_url( $current_user->ID ) );
			}
		} else {

			if ( ! $object ) {
				$object = $this->get_post_object();
			}

			if ( ! $object ) {
				return false;
			}

			$vars = get_object_vars( $object );

			if ( 'post_id' === $property ) {
				$vars['post_id'] = $vars['ID'];
			}
			if ( 'post_title' == $property ) {
				global $alpha_layout;
				Alpha_Layout_Builder::get_instance()->setup_titles();
				if ( ! empty( $alpha_layout['is_page_header'] ) && $alpha_layout['title'] ) {
					$vars['post_title'] = $alpha_layout['title'];
				}
			}
		}

		return isset( $vars[ $property ] ) ? $vars[ $property ] : false;

	}
}
