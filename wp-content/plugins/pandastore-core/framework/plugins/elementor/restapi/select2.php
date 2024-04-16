<?php
/**
 * Alpha Restful API
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_Rest_Api {

	/**
	 * Ajax Request
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected $request = array();

	/**
	 * Post types
	 *
	 * @since 1.0
	 * @access public
	 */
	public $post_types = array();


	/**
	 * Taxonomies
	 *
	 * @since 1.0
	 * @access public
	 */
	public $taxonomies = array();


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->post_types = apply_filters( 'alpha_select_post_types', array( 'post', 'page', 'product', 'block' ) );
		$this->taxonomies = apply_filters( 'alpha_select_taxonomies', array( 'category', 'product_cat', 'product_brand' ) );
	}

	/**
	 * Get method from request and implement it
	 *
	 * @since 1.0
	 */
	public function get_action( $request ) {
		if ( isset( $request['method'] ) ) {
			$this->request = $request;

			if ( in_array( $request['method'], $this->post_types ) ) {
				return $this->get_archives( $request['method'] );
			} elseif ( in_array( $request['method'], $this->taxonomies ) ) {
				return $this->get_taxonomies( $request['method'] );
			} else {
				return $this->get_vendors();
			}
		}
	}


	/**
	 * Get vendor list
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_vendors() {
		$query_args = array();
		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->request['ids'];
			$query_args['include'] = $ids;
			$query_args['orderby'] = 'include';

			if ( '' == $this->request['ids'] ) {
				return array( 'results' => array() );
			}
		}

		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$options = function_exists( 'alpha_get_vendors' ) ? alpha_get_vendors( $query_args ) : array();

		return array( 'results' => $options );
		wp_reset_postdata();
	}


	/**
	 * Get Archives
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_archives( $post_type = 'post' ) {
		if ( 'block' == $post_type ) {
			$query_args = array(
				'post_type'      => ALPHA_NAME . '_template',
				'post_status'    => 'publish',
				'meta_key'       => ALPHA_NAME . '_template_type',
				'meta_value'     => $post_type,
				'posts_per_page' => 15,
			);

		} else {
			$query_args = array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 15,
			);
		}

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = explode( ',', $this->request['ids'] );
			$query_args['post__in'] = $ids;
			$query_args['orderby']  = 'post__in';

			if ( '' == $this->request['ids'] ) {
				return array(
					'results' => array(),
				);
			}
		}

		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query = new WP_Query( apply_filters( 'alpha_get_archives', $query_args ) );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = array(
					'id'   => $post->ID,
					'text' => $post->post_title,
				);
			}
		endif;
		return array( 'results' => $options );
		wp_reset_postdata();
	}

	/**
	 * Get Taxonomies
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_taxonomies( $taxonomy = 'category' ) {
		$query_args = array(
			'taxonomy'   => array( $taxonomy ),
			'hide_empty' => false,
		);

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = explode( ',', $this->request['ids'] );
			$query_args['include'] = $ids;
			$query_args['orderby'] = 'include';

			if ( '' == $this->request['ids'] ) {
				return array( 'results' => array() );
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms( apply_filters( 'alpha_get_taxonomies', $query_args ) );

		$options = array();
		$count   = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'id'   => $term->term_id,
					'text' => htmlspecialchars_decode( $term->name ),
				);
			}
		endif;
		return array( 'results' => $options );
	}
}

/**
 * Get an instance of Alpha_Rest_Api and
 * call an action
 *
 * @since 1.0
 */
function alpha_ajax_select_api( WP_REST_Request $request ) {
	$api = new Alpha_Rest_Api();
	return $api->get_action( $request );
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ajaxselect2/v1',
			'/(?P<method>\w+)/',
			array(
				'methods'             => 'GET',
				'callback'            => 'alpha_ajax_select_api',
				'permission_callback' => '__return_true',
			)
		);
	}
);
