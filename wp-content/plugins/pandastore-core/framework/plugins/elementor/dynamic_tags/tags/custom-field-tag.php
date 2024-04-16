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

class Alpha_Core_Custom_Field_Tag extends Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'alpha-custom-field';
	}

	public function get_title() {
		return esc_html__( 'Custom Field', 'pandastore-core' );
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
			'dynamic_field_source',
			array(
				'label'   => esc_html__( 'Source', 'pandastore-core' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'general',
				'options' => $this->get_objects(),
			)
		);

		$this->add_control(
			'dynamic_field_post_object',
			array(
				'label'     => esc_html__( 'Object Field', 'pandastore-core' ),
				'type'      => Elementor\Controls_Manager::SELECT,
				'default'   => 'post_title',
				'groups'    => $this->get_object_fields(),
				'condition' => array(
					'dynamic_field_source' => 'general',
				),
			)
		);

		$this->add_control(
			'dynamic_field_taxonomy',
			array(
				'label'     => esc_html__( 'Taxonomy Field', 'pandastore-core' ),
				'type'      => Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'groups'    => $this->get_taxonomy_fields(),
				'condition' => array(
					'dynamic_field_source' => 'taxonomy',
				),
			)
		);

		//Add acf field
		do_action( 'alpha_dynamic_extra_fields', $this );

		$this->add_control(
			'dynamic_field_custom_meta_key',
			array(
				'label'       => esc_html__( 'Custom meta key', 'pandastore-core' ),
				'type'        => Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'condition'   => array(
					'dynamic_field_source' => 'meta_data',
				),
			)
		);
	}

	public function get_objects() {
		$objects = array(
			'general'   => esc_html__( 'Posts/Users', 'pandastore-core' ),
			'taxonomy'  => esc_html__( 'Taxonomies', 'pandastore-core' ),
			'meta_data' => esc_html__( 'Meta Data', 'pandastore-core' ),
		);

		return apply_filters( 'alpha_dynamic_field_object', $objects );
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

	public function get_taxonomy_fields() {
		$taxonomy_array = get_taxonomies();
		$option_fields  = array();
		$result         = array();

		if ( $taxonomy_array && is_array( $taxonomy_array ) ) {
			$post_type = get_post_type();
			if ( count( $taxonomy_array ) > 1 ) {
				foreach ( $taxonomy_array as $value ) {
					$taxonomy_object = get_taxonomy( (string) $value );
					$taxonomy_type   = $taxonomy_object->object_type;

					if ( $post_type == $taxonomy_type[0] ) {
						$key                   = $taxonomy_object->name;
						$option_fields[ $key ] = $taxonomy_object->label;
					} else {
						continue;}
				}
			} else {
				$taxonomy_object = get_taxonomy( (string) $taxonomy_array[0] );
				$taxonomy_type   = $taxonomy_object->object_type;

				if ( $post_type == $taxonomy_type[0] ) {
					$key                   = $taxonomy_object->name;
					$option_fields[ $key ] = $taxonomy_object->label;
				}
			}
		}

		$result = array(
			array(
				'label'   => esc_html__( 'Taxonomies', 'pandastore-core' ),
				'options' => $option_fields,
			),
		);

		return $result;
	}

	public function render() {

		do_action( 'alpha_core_dynamic_before_render' );

		$post_id = get_the_ID();
		$atts    = $this->get_settings();
		$ret     = '';

		switch ( $atts['dynamic_field_source'] ) {
			case 'general':
				$property = $atts['dynamic_field_post_object'];

				$ret = (string) $this->get_prop( $property );

				if ( 'post_content' === $property ) {

					if ( Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) ) {

						$editor       = Elementor\Plugin::$instance->editor;
						$is_edit_mode = $editor->is_edit_mode();

						$editor->set_edit_mode( false );

						global $post;
						$temp = $post;
						$post = '';

						$ret = Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $post_id, $is_edit_mode );

						$post = $temp;

						$editor->set_edit_mode( $is_edit_mode );

					} else {
						$ret = apply_filters( 'the_content', $ret );
					}
				}

				if ( 'category' == $property ) {
					$ret = get_the_category_list( ', ', '', $post_id );
				} elseif ( 'tags' == $property ) {
					$ret = get_the_tag_list( '', ', ', '', $post_id );
				} elseif ( 'alpha_post_likes' == $property ) {
					$ret = get_post_meta( $post_id, $property, true );
				}
				break;
			case 'taxonomy':
				$tax = $atts['dynamic_field_taxonomy'];
				if ( $tax ) {
					$ret = get_the_term_list( $post_id, $tax, '', ', ', '' );
				}
				break;
			default:
				$ret = apply_filters( 'alpha_dynamic_extra_fields_content', null, $atts, 'field' );
				break;
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

		if ( isset( $atts['dynamic_field_custom_meta_key'] ) && $atts['dynamic_field_custom_meta_key'] ) {
			$meta_key = $atts['dynamic_field_custom_meta_key'];
			$ret      = get_post_meta( $post_id, $meta_key, true );
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
			if ( isset( $_REQUEST['editor_post_id'] ) ) {
				$post_id = $_REQUEST['editor_post_id'];
			} elseif ( isset( $_REQUEST['post_id'] ) ) {
				$post_id = $_REQUEST['post_id'];
			} else {
				$post_id = false;
			}

			if ( ! $post_id ) {
				$post_object = false;
			} else {
				$post_object = get_post( $post_id );
			}
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
				$current_user = wp_get_current_user();
			}

			if ( ! $current_user ) {
				return false;
			}

			$vars = get_object_vars( $current_user );
			$vars = ! empty( $vars['data'] ) ? (array) $vars['data'] : array();

			if ( 'user_nicename' === $property ) {
				$vars['user_nicename'] = get_user_meta( $current_user->ID, 'nickname', true );
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
		}

		return isset( $vars[ $property ] ) ? $vars[ $property ] : false;

	}
}
