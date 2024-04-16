<?php
/**
 * Define functions using in Alpha Core Plugin
 *
 * @author     D-THEMES
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

/**
 * The filtered term product counts
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_filtered_term_product_counts' ) ) :
	function alpha_filtered_term_product_counts( $term_ids, $taxonomy = false, $query_type = false ) {
		global $wpdb;

		if ( ! class_exists( 'WC_Query' ) ) {
			return false;
		}

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		if ( 'product_brand' === $taxonomy ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) ) {
					if ( 'product_brand' === $query['taxonomy'] ) {
						unset( $tax_query[ $key ] );

						if ( preg_match( '/pa_/', $query['taxonomy'] ) ) {
							unset( $tax_query[ $key ] );
						}
					}
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . '
			AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')
		';

		if ( $search = WC_Query::get_main_search_query_sql() ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = 'GROUP BY terms.term_id';
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );

		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );
		$cache      = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A );
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
endif;

/**
 * Get the exact parameters of each predefined layouts.
 *
 * @param int $index    The index of predefined creative layouts
 * @since 1.0
 */
if ( ! function_exists( 'alpha_creative_preset_imgs' ) ) {
	function alpha_creative_preset_imgs() {
		return apply_filters(
			'alpha_creative_preset_imgs',
			array(
				1  => '/assets/images/creative-grid/creative-1.jpg',
				2  => '/assets/images/creative-grid/creative-2.jpg',
				3  => '/assets/images/creative-grid/creative-3.jpg',
				4  => '/assets/images/creative-grid/creative-4.jpg',
				5  => '/assets/images/creative-grid/creative-5.jpg',
				6  => '/assets/images/creative-grid/creative-6.jpg',
				7  => '/assets/images/creative-grid/creative-7.jpg',
				8  => '/assets/images/creative-grid/creative-8.jpg',
				9  => '/assets/images/creative-grid/creative-9.jpg',
				10 => '/assets/images/creative-grid/creative-10.jpg',
				11 => '/assets/images/creative-grid/creative-11.jpg',
				12 => '/assets/images/creative-grid/creative-12.jpg',
				13 => '/assets/images/creative-grid/creative-13.jpg',
			)
		);
	}
}

/**
 * Get the creative layout.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_creative_layout' ) ) {
	function alpha_creative_layout( $index ) {
		$layout = array();
		if ( 1 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'large',
				),
			);
		} elseif ( 2 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
			);
		} elseif ( 3 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'medium',
				),
			);
		} elseif ( 4 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'large',
				),
			);
		} elseif ( 5 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-4',
					'h'    => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
			);
		} elseif ( 6 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
			);
		} elseif ( 7 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '2-3',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-3',
					'h'    => '1-3',
					'w-s'  => '1',
					'w-l'  => '1-3',
					'size' => 'medium',
				),
				array(
					'w'    => '1-3',
					'h'    => '1-3',
					'w-s'  => '1',
					'w-l'  => '1-3',
					'size' => 'medium',
				),
				array(
					'w'    => '1-3',
					'h'    => '1-3',
					'w-s'  => '1',
					'w-l'  => '1-3',
					'size' => 'medium',
				),
			);
		} elseif ( 8 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '2-3',
					'w-s'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-3',
					'w-s'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '2-3',
					'w-s'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-3',
					'w-s'  => '1',
					'size' => 'medium',
				),
			);
		} elseif ( 9 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '2-3',
					'h'    => '2-3',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-3',
					'h'    => '2-3',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'w-s'  => '1',
					'size' => 'medium',
				),
			);
		} elseif ( 10 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '2-3',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-3',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-3',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
			);
		} elseif ( 11 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '5-12',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-3',
					'h'    => '1',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '5-12',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-s'  => '1',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
			);
		} elseif ( 12 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '7-12',
					'h'    => '2-3',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '5-24',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '5-24',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '5-12',
					'h'    => '2-3',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '9-24',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
				array(
					'w'    => '5-24',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'medium',
				),
			);
		} elseif ( 13 == (int) $index ) {
			$layout = array(
				array(
					'w'    => '1-2',
					'h'    => '1',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-2',
					'h'    => '1-2',
					'w-l'  => '1',
					'size' => 'large',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
				array(
					'w'    => '1-4',
					'h'    => '1-2',
					'w-l'  => '1-2',
					'size' => 'medium',
				),
			);
		}

		return apply_filters( 'alpha_creative_layout_filter', $layout );
	}
}

/**
 * The creative layout style.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_creative_layout_style' ) ) {
	function alpha_creative_layout_style( $wrapper, $layout, $height = 600, $ratio = 75 ) {
		$hs    = array( 'h-1', 'h-1-2', 'h-1-3', 'h-2-3', 'h-1-4', 'h-3-4' );
		$deno  = array();
		$numer = array();
		$ws    = array(
			'w'   => array(),
			'w-l' => array(),
			'w-m' => array(),
			'w-s' => array(),
		);
		$hs    = array(
			'h'   => array(),
			'h-l' => array(),
			'h-m' => array(),
		);

		$breakpoints = alpha_get_breakpoints();

		echo '<style>';
		foreach ( $layout as $grid_item ) {
			foreach ( $grid_item as $key => $value ) {
				if ( 'size' == $key ) {
					continue;
				}

				$num = explode( '-', $value );
				if ( isset( $num[1] ) && ! in_array( $num[1], $deno ) ) {
					$deno[] = $num[1];
				}
				if ( ! in_array( $num[0], $numer ) ) {
					$numer[] = $num[0];
				}

				if ( ( 'w' == $key || 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) && ! in_array( $value, $ws[ $key ] ) ) {
					$ws[ $key ][] = $value;
				}
				if ( ( 'h' == $key || 'h-l' == $key || 'h-m' == $key ) && ! in_array( $value, $hs[ $key ] ) ) {
					$hs[ $key ][] = $value;
				}
			}
		}
		foreach ( $ws as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}

			if ( 'w-l' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
			} elseif ( 'w-m' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
			} elseif ( 'w-s' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['sm'] - 1 ) . 'px) {';
			}

			foreach ( $value as $item ) {
				$opts  = explode( '-', $item );
				$width = ( ! isset( $opts[1] ) ? 100 : round( 100 * $opts[0] / $opts[1], 4 ) );
				echo esc_attr( $wrapper ) . ' .grid-item.' . $key . '-' . $item . '{flex:0 0 ' . $width . '%;width:' . $width . '%}';
			}

			if ( 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) {
				echo '}';
			}
		};
		foreach ( $hs as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}

			foreach ( $value as $item ) {
				$opts = explode( '-', $item );

				if ( isset( $opts[1] ) ) {
					$h = $height * $opts[0] / $opts[1];
				} else {
					$h = $height;
				}
				if ( 'h' == $key ) {
					echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h, 2 ) . 'px}';
					echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
					echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
					echo '}';
				} elseif ( 'h-l' == $key ) {
					echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
					echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h, 2 ) . 'px}';
					echo '}';
					echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
					echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
					echo '}';
				} elseif ( 'h-m' == $key ) {
					echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
					echo esc_attr( $wrapper ) . ' .h-m-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
					echo '}';
				}
			}
		};
		$lcm = 1;
		foreach ( $deno as $value ) {
			$lcm = $lcm * $value / alpha_get_gcd( $lcm, $value );
		}
		$gcd = $numer[0];
		foreach ( $numer as $value ) {
			$gcd = alpha_get_gcd( $gcd, $value );
		}
		$sizer          = floor( 100 * $gcd / $lcm * 10000 ) / 10000;
		$space_selector = ' .grid>.grid-space';
		if ( false !== strpos( $wrapper, 'wpb_' ) ) {
			$space_selector = '>.grid-space';
		}
		echo esc_attr( $wrapper ) . $space_selector . '{flex: 0 0 ' . ( $sizer < 0.01 ? 100 : $sizer ) . '%;width:' . ( $sizer < 0.01 ? 100 : $sizer ) . '%}';
		echo '</style>';
	}
}

/**
 * Display grid preset images.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_display_grid_preset_imgs' ) ) {
	function alpha_display_grid_preset_imgs() {
		return array(
			1 => '/assets/images/products-grid/creative-1.jpg',
			2 => '/assets/images/products-grid/creative-2.jpg',
			3 => '/assets/images/products-grid/creative-3.jpg',
			4 => '/assets/images/products-grid/creative-4.jpg',
			5 => '/assets/images/products-grid/creative-5.jpg',
			6 => '/assets/images/products-grid/creative-6.jpg',
			7 => '/assets/images/products-grid/creative-7.jpg',
			8 => '/assets/images/products-grid/creative-8.jpg',
			9 => '/assets/images/products-grid/creative-9.jpg',
		);
	}
}

/**
 * Get creative image sizes.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_creative_image_sizes' ) ) {
	function alpha_get_creative_image_sizes( $mode, $idx ) {
		if ( 1 == $mode && 0 == $idx % 7 ) {
			return 'large';
		}
		if ( 2 == $mode && 1 == $idx % 5 ) {
			return 'large';
		}
		if ( 3 == $mode && 0 == $idx % 5 ) {
			return 'large';
		}
		if ( 4 == $mode && 2 == $idx % 5 ) {
			return 'large';
		}
		if ( 5 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
			return 'large';
		}
		if ( 6 == $mode && ( 0 == $idx % 4 || 2 == $idx % 4 ) ) {
			return 'large';
		}
		if ( 7 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
			return 'large';
		}
		if ( 8 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
			return 'large';
		}
		if ( 9 == $mode && 0 == $idx % 10 ) {
			return 'large';
		}
		return '';
	}
}

/**
 * Get gcd of two numbers.
 *
 * @since 1.0
 */
function alpha_get_gcd( $a, $b ) {
	while ( $b ) {
		$r = $a % $b;
		$a = $b;
		$b = $r;
	}
	return $a;
}

/**
 * Get grid space classes.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_grid_space_class' ) ) {
	function alpha_get_grid_space_class( $settings ) {
		if ( empty( $settings['col_sp'] ) ) {
			return ' gutter-md';
		} else {
			return ' gutter-' . $settings['col_sp'];
		}
	}
}

/**
 * Check Units
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_check_units' ) ) {
	function alpha_check_units( $value ) {
		if ( ! preg_match( '/((^\d+(.\d+){0,1})|((-){0,1}.\d+))(px|%|em|rem|pt){0,1}$/', $value ) ) {
			if ( 'auto' == $value || 'inherit' == $value || 'initial' == $value || 'unset' == $value ) {
				return $value;
			}
			return false;
		} elseif ( is_numeric( $value ) ) {
			$value .= 'px';
		}
		return $value;
	}
}

/**
 * Is elementor page builder preview?
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_is_elementor_preview' ) ) {
	function alpha_is_elementor_preview() {
		return defined( 'ELEMENTOR_VERSION' ) && (
				( isset( $_REQUEST['action'] ) && ( 'elementor' == $_REQUEST['action'] || 'elementor_ajax' == $_REQUEST['action'] ) ) ||
				isset( $_REQUEST['elementor-preview'] )
			);
	}
}

/**
 * Is wpbakery page builder preview?
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_is_wpb_preview' ) ) {
	function alpha_is_wpb_preview() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			if ( alpha_is_wpb_backend() || vc_is_inline() ) {
				return true;
			}
		}
		return false;
	}
}


/**
 * Is page builder preview?
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_is_preview' ) ) {
	function alpha_is_preview() {
		return alpha_is_elementor_preview() || alpha_is_wpb_preview();
	}
}

/**
 * Is wpb backend editor ?
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_is_wpb_backend' ) ) {
	function alpha_is_wpb_backend() {
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && ( 'post.php' == $GLOBALS['pagenow'] || 'post-new.php' == $GLOBALS['pagenow'] ) && defined( 'WPB_VC_VERSION' ) ) {
			return true;
		}
		return false;
	}
}

/**
 * Returns true when viewing the compare page.
 *
 * @return bool
 * @since 1.2.0
 */

if ( ! function_exists( 'alpha_is_compare' ) ) {
	function alpha_is_compare() {
		$page_id = wc_get_page_id( 'compare' );

		return ( $page_id && is_page( $page_id ) ) && class_exists( 'WooCommerce' ) && class_exists( 'Alpha_Product_Compare' );
	}
}
/**
 * Remove all admin notices.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_remove_all_admin_notices' ) ) {
	function alpha_remove_all_admin_notices() {
		add_action(
			'network_admin_notices',
			function() {
				remove_all_actions( 'network_admin_notices' );
			},
			1
		);
		add_action(
			'user_admin_notices',
			function() {
				remove_all_actions( 'user_admin_notices' );
			},
			1
		);
		add_action(
			'admin_notices',
			function() {
				remove_all_actions( 'admin_notices' );
			},
			1
		);
		add_action(
			'all_admin_notices',
			function() {
				remove_all_actions( 'all_admin_notices' );
			},
			1
		);
	}
}

if ( ! function_exists( 'alpha_get_grid_space' ) ) {

	/**
	 * Get columns' gutter size value from size string
	 *
	 * @since 1.0
	 *
	 * @param string $col_sp Columns gutter size string
	 *
	 * @return int Gutter size value
	 */
	function alpha_get_grid_space( $col_sp ) {
		if ( 'no' == $col_sp ) {
			return 0;
		} elseif ( 'sm' == $col_sp ) {
			return 10;
		} elseif ( 'lg' == $col_sp ) {
			return 30;
		} elseif ( 'xs' == $col_sp ) {
			return 2;
		} else {
			return 20;
		}
	}
}

/**
 * Get image sizes.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_image_sizes' ) ) {
	function alpha_get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			esc_html__( 'Default', 'pandastore-core' ) => '',
			esc_html__( 'Full', 'pandastore-core' )    => 'full',
		);

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size . ' ( ' . get_option( "{$_size}_size_w" ) . 'x' . get_option( "{$_size}_size_h" ) . ( get_option( "{$_size}_crop" ) ? '' : ', false' ) . ' )' ] = $_size;
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size . ' ( ' . $_wp_additional_image_sizes[ $_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $_size ]['height'] . ( $_wp_additional_image_sizes[ $_size ]['crop'] ? '' : ', false' ) . ' )' ] = $_size;
			}
		}
		return $sizes;
	}
}

/*******************************************
 ********* Render Core Functions ***********
 *******************************************/
/**
 * Get button widget class
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_widget_button_get_class' ) ) {
	function alpha_widget_button_get_class( $settings, $prefix = '' ) {
		$class = array();
		if ( ! empty( $prefix ) ) {
			$class[] = 'btn-' . $prefix;
		}
		if ( isset( $settings[ $prefix . 'button_type' ] ) && $settings[ $prefix . 'button_type' ] ) {
			$class[] = $settings[ $prefix . 'button_type' ];
		}
		if ( isset( $settings[ $prefix . 'link_hover_type' ] ) && $settings[ $prefix . 'link_hover_type' ] ) {
			$class[] = $settings[ $prefix . 'link_hover_type' ];
		}
		if ( isset( $settings[ $prefix . 'button_size' ] ) && $settings[ $prefix . 'button_size' ] ) {
			$class[] = $settings[ $prefix . 'button_size' ];
		}
		if ( isset( $settings[ $prefix . 'shadow' ] ) && $settings[ $prefix . 'shadow' ] ) {
			$class[] = $settings[ $prefix . 'shadow' ];
		}
		if ( isset( $settings[ $prefix . 'button_border' ] ) && $settings[ $prefix . 'button_border' ] ) {
			$class[] = $settings[ $prefix . 'button_border' ];
		}
		if ( ( ! isset( $settings[ $prefix . 'button_type' ] ) || 'btn-gradient' != $settings[ $prefix . 'button_type' ] ) && isset( $settings[ $prefix . 'button_skin' ] ) && $settings[ $prefix . 'button_skin' ] ) {
			$class[] = $settings[ $prefix . 'button_skin' ];
		}
		if ( isset( $settings[ $prefix . 'button_type' ] ) && 'btn-gradient' == $settings[ $prefix . 'button_type' ] && isset( $settings[ $prefix . 'button_gradient_skin' ] ) && $settings[ $prefix . 'button_gradient_skin' ] ) {
			$class[] = $settings[ $prefix . 'button_gradient_skin' ];
		}
		if ( ! empty( $settings[ $prefix . 'btn_class' ] ) ) {
			$class[] = $settings[ $prefix . 'btn_class' ];
		}
		if ( isset( $settings[ $prefix . 'icon_hover_effect_infinite' ] ) && 'yes' == $settings[ $prefix . 'icon_hover_effect_infinite' ] ) {
			$class[] = 'btn-infinite';
		}

		if ( isset( $settings[ $prefix . 'icon' ] ) && is_array( $settings[ $prefix . 'icon' ] ) && $settings[ $prefix . 'icon' ]['value'] ) {
			if ( isset( $settings[ $prefix . 'show_label' ] ) && ! $settings[ $prefix . 'show_label' ] ) {
				$class[] = 'btn-icon';
			} elseif ( 'before' == $settings[ $prefix . 'icon_pos' ] ) {
				$class[] = 'btn-icon-left';
			} else {
				$class[] = 'btn-icon-right';
			}
			if ( isset( $settings[ $prefix . 'icon_hover_effect' ] ) && $settings[ $prefix . 'icon_hover_effect' ] ) {
				$class[] = $settings[ $prefix . 'icon_hover_effect' ];
			}
		}
		return $class;
	}
}

use Elementor\Icons_Manager;
/**
 * Get button widget label
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_widget_button_get_label' ) ) {

	function alpha_widget_button_get_label( $settings, $self, $label, $inline_key = '', $prefix = '' ) {
		if ( $self && ( ! isset( $self::$is_wpb ) || ! $self::$is_wpb ) ) {
			$label = sprintf( '<span %1$s>%2$s</span>', $inline_key ? $self->get_render_attribute_string( $inline_key ) : '', $label );
		}

		$icon = '';
		if ( isset( $settings[ $prefix . 'icon' ] ) && is_array( $settings[ $prefix . 'icon' ] ) && $settings[ $prefix . 'icon' ]['value'] ) {
			if ( 'svg' == $settings[ $prefix . 'icon' ]['library'] ) {
				ob_start();
				Icons_Manager::render_icon( $settings[ $prefix . 'icon' ], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_clean();
			} else {
				$icon = '<i class="' . $settings[ $prefix . 'icon' ]['value'] . '"></i>';
			}
		}

		if ( $icon ) {
			if ( isset( $settings[ $prefix . 'show_label' ] ) && 'yes' != $settings[ $prefix . 'show_label' ] ) {
				$label = $icon;
			} elseif ( 'before' == $settings[ $prefix . 'icon_pos' ] ) {
				$label = $icon . $label;
			} else {
				$label .= $icon;
			}
		}
		return $label;
	}
}

/**
 * The elementor loadmore render html.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_loadmore_render_html' ) ) {
	function alpha_elementor_loadmore_render_html( $query, $atts ) {

		if ( $query->max_num_pages > 1 ) {

			if ( 'button' == $atts['loadmore_type'] ) {

				echo '<button class="btn btn-load btn-primary">';
				echo empty( $atts['loadmore_label'] ) ? esc_html__( 'Load More', 'pandastore-core' ) : esc_html( $atts['loadmore_label'] );
				echo '</button>';

			} elseif ( 'page' == $atts['loadmore_type'] || '' == $atts['loadmore_type'] ) {
				echo alpha_get_pagination( $query, 'pagination-load' );
			}
		}
	}
}

/**
 * Get the grid col cnt for elementor page builder.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_grid_col_cnt' ) ) {
	function alpha_elementor_grid_col_cnt( $settings ) {
		$col_cnt = array(
			'xl'  => isset( $settings['col_cnt_xl'] ) ? (int) $settings['col_cnt_xl'] : 0,
			'lg'  => isset( $settings['col_cnt'] ) ? (int) $settings['col_cnt'] : 0,
			'md'  => isset( $settings['col_cnt_tablet'] ) ? (int) $settings['col_cnt_tablet'] : 0,
			'sm'  => isset( $settings['col_cnt_mobile'] ) ? (int) $settings['col_cnt_mobile'] : 0,
			'min' => isset( $settings['col_cnt_min'] ) ? (int) $settings['col_cnt_min'] : 0,
		);

		return function_exists( 'alpha_get_responsive_cols' ) ? alpha_get_responsive_cols( $col_cnt ) : $col_cnt;
	}
}

/**
 * Get post id by name.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_post_id_by_name' ) ) {
	function alpha_get_post_id_by_name( $post_type, $name ) {
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_name = %s", $post_type, $name ) );
	}
}

/**
 * The Wc product dropdown brands.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_wc_product_dropdown_brands' ) ) {
	function alpha_wc_product_dropdown_brands( $args = array() ) {
		global $wp_query;

		$args = wp_parse_args(
			$args,
			array(
				'pad_counts'         => 1,
				'show_count'         => 1,
				'hierarchical'       => 1,
				'hide_empty'         => 1,
				'show_uncategorized' => 1,
				'orderby'            => 'name',
				'selected'           => isset( $wp_query->query_vars['product_brand'] ) ? $wp_query->query_vars['product_brand'] : '',
				'show_option_none'   => __( 'Select a category', 'woocommerce' ),
				'option_none_value'  => '',
				'value_field'        => 'slug',
				'taxonomy'           => 'product_brand',
				'name'               => 'product_brand',
				'class'              => 'dropdown_product_brand',
			)
		);

		if ( 'order' === $args['orderby'] ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = 'order'; // phpcs:ignore
		}

		wp_dropdown_categories( $args );
	}
}

/**
 * Get animations.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_get_animations' ) ) {
	function alpha_get_animations( $type = '' ) {
		$animations_in = array(
			'none'               => esc_html__( 'Default Animation', 'pandastore-core' ),
			'bounce'             => esc_html__( 'Bounce', 'pandastore-core' ),
			'flash'              => esc_html__( 'Flash', 'pandastore-core' ),
			'pulse'              => esc_html__( 'Pulse', 'pandastore-core' ),
			'rubberBand'         => esc_html__( 'RubberBand', 'pandastore-core' ),
			'shake'              => esc_html__( 'Shake', 'pandastore-core' ),
			'headShake'          => esc_html__( 'HeadShake', 'pandastore-core' ),
			'swing'              => esc_html__( 'Swing', 'pandastore-core' ),
			'tada'               => esc_html__( 'Tada', 'pandastore-core' ),
			'wobble'             => esc_html__( 'Wobble', 'pandastore-core' ),
			'jello'              => esc_html__( 'Jello', 'pandastore-core' ),
			'heartBeat'          => esc_html__( 'HearBeat', 'pandastore-core' ),
			'blurIn'             => esc_html__( 'BlurIn', 'pandastore-core' ),
			'bounceIn'           => esc_html__( 'BounceIn', 'pandastore-core' ),
			'bounceInUp'         => esc_html__( 'BounceInUp', 'pandastore-core' ),
			'bounceInDown'       => esc_html__( 'BounceInDown', 'pandastore-core' ),
			'bounceInLeft'       => esc_html__( 'BounceInLeft', 'pandastore-core' ),
			'bounceInRight'      => esc_html__( 'BounceInRight', 'pandastore-core' ),
			'fadeIn'             => esc_html__( 'FadeIn', 'pandastore-core' ),
			'fadeInUp'           => esc_html__( 'FadeInUp', 'pandastore-core' ),
			'fadeInUpBig'        => esc_html__( 'FadeInUpBig', 'pandastore-core' ),
			'fadeInUpShorter'    => esc_html__( 'FadeInUpShort', 'pandastore-core' ),
			'fadeInDown'         => esc_html__( 'FadeInDown', 'pandastore-core' ),
			'fadeInDownBig'      => esc_html__( 'FadeInDownBig', 'pandastore-core' ),
			'fadeInDownShorter'  => esc_html__( 'FadeInDownShort', 'pandastore-core' ),
			'fadeInLeft'         => esc_html__( 'FadeInLeft', 'pandastore-core' ),
			'fadeInLeftBig'      => esc_html__( 'FadeInLeftBig', 'pandastore-core' ),
			'fadeInLeftShorter'  => esc_html__( 'FadeInLeftShort', 'pandastore-core' ),
			'fadeInRight'        => esc_html__( 'FadeInRight', 'pandastore-core' ),
			'fadeInRightBig'     => esc_html__( 'FadeInRightBig', 'pandastore-core' ),
			'fadeInRightShorter' => esc_html__( 'FadeInRightShort', 'pandastore-core' ),
			'flip'               => esc_html__( 'Flip', 'pandastore-core' ),
			'flipInX'            => esc_html__( 'FlipInX', 'pandastore-core' ),
			'flipInY'            => esc_html__( 'FlipInY', 'pandastore-core' ),
			'lightSpeedIn'       => esc_html__( 'LightSpeedIn', 'pandastore-core' ),
			'rotateIn'           => esc_html__( 'RotateIn', 'pandastore-core' ),
			'rotateInUpLeft'     => esc_html__( 'RotateInUpLeft', 'pandastore-core' ),
			'rotateInUpRight'    => esc_html__( 'RotateInUpRight', 'pandastore-core' ),
			'rotateInDownLeft'   => esc_html__( 'RotateInDownLeft', 'pandastore-core' ),
			'rotateInDownRight'  => esc_html__( 'RotateInDownRight', 'pandastore-core' ),
			'hinge'              => esc_html__( 'Hinge', 'pandastore-core' ),
			'jackInTheBox'       => esc_html__( 'JackInTheBox', 'pandastore-core' ),
			'rollIn'             => esc_html__( 'RollIn', 'pandastore-core' ),
			'zoomIn'             => esc_html__( 'ZoomIn', 'pandastore-core' ),
			'zoomInUp'           => esc_html__( 'ZoomInUp', 'pandastore-core' ),
			'zoomInDown'         => esc_html__( 'ZoomInDown', 'pandastore-core' ),
			'zoomInLeft'         => esc_html__( 'ZoomInLeft', 'pandastore-core' ),
			'zoomInRight'        => esc_html__( 'ZoomInRight', 'pandastore-core' ),
			'slideInUp'          => esc_html__( 'SlideInUp', 'pandastore-core' ),
			'slideInDown'        => esc_html__( 'SlideInDown', 'pandastore-core' ),
			'slideInLeft'        => esc_html__( 'SlideInLeft', 'pandastore-core' ),
			'slideInRight'       => esc_html__( 'SlideInRight', 'pandastore-core' ),
			'blurIn'             => esc_html__( 'BlurIn', 'pandastore-core' ),
		);

		$animations_out = array(
			'default'            => esc_html__( 'Default Animation', 'pandastore-core' ),
			'blurOut'            => esc_html__( 'BlurOut', 'pandastore-core' ),
			'bounceOut'          => esc_html__( 'BounceOut', 'pandastore-core' ),
			'bounceOutUp'        => esc_html__( 'BounceOutUp', 'pandastore-core' ),
			'bounceOutDown'      => esc_html__( 'BounceOutDown', 'pandastore-core' ),
			'bounceOutLeft'      => esc_html__( 'BounceOutLeft', 'pandastore-core' ),
			'bounceOutRight'     => esc_html__( 'BounceOutRight', 'pandastore-core' ),
			'fadeOut'            => esc_html__( 'FadeOut', 'pandastore-core' ),
			'fadeOutUp'          => esc_html__( 'FadeOutUp', 'pandastore-core' ),
			'fadeOutUpBig'       => esc_html__( 'FadeOutUpBig', 'pandastore-core' ),
			'fadeOutDown'        => esc_html__( 'FadeOutDown', 'pandastore-core' ),
			'fadeOutDownBig'     => esc_html__( 'FadeOutDownBig', 'pandastore-core' ),
			'fadeOutLeft'        => esc_html__( 'FadeOutLeft', 'pandastore-core' ),
			'fadeOutLeftBig'     => esc_html__( 'FadeOutLeftBig', 'pandastore-core' ),
			'fadeOutRight'       => esc_html__( 'FadeOutRight', 'pandastore-core' ),
			'fadeOutRightBig'    => esc_html__( 'FadeOutRightBig', 'pandastore-core' ),
			'flipOutX'           => esc_html__( 'FlipOutX', 'pandastore-core' ),
			'flipOutY'           => esc_html__( 'FlipOutY', 'pandastore-core' ),
			'lightSpeedOut'      => esc_html__( 'LightSpeedOut', 'pandastore-core' ),
			'rotateOutUpLeft'    => esc_html__( 'RotateOutUpLeft', 'pandastore-core' ),
			'rotateOutRight'     => esc_html__( 'RotateOutUpRight', 'pandastore-core' ),
			'rotateOutDownLeft'  => esc_html__( 'RotateOutDownLeft', 'pandastore-core' ),
			'rotateOutDownRight' => esc_html__( 'RotateOutDownRight', 'pandastore-core' ),
			'rollOut'            => esc_html__( 'RollOut', 'pandastore-core' ),
			'zoomOut'            => esc_html__( 'ZoomOut', 'pandastore-core' ),
			'zoomOutUp'          => esc_html__( 'ZoomOutUp', 'pandastore-core' ),
			'zoomOutDown'        => esc_html__( 'ZoomOutDown', 'pandastore-core' ),
			'zoomOutLeft'        => esc_html__( 'ZoomOutLeft', 'pandastore-core' ),
			'zoomOutRight'       => esc_html__( 'ZoomOutRight', 'pandastore-core' ),
			'slideOutUp'         => esc_html__( 'SlideOutUp', 'pandastore-core' ),
			'slideOutDown'       => esc_html__( 'SlideOutDown', 'pandastore-core' ),
			'slideOutLeft'       => esc_html__( 'SlideOutLeft', 'pandastore-core' ),
			'slideOutRight'      => esc_html__( 'SlideOutRight', 'pandastore-core' ),
		);

		$animations_appear = apply_filters(
			'alpha_animation_appear',
			array(
				ALPHA_DISPLAY_NAME . ' Fading' => array(
					'fadeInDownShorter'  => esc_html__( 'Fade In Down Shorter', 'pandastore-core' ),
					'fadeInLeftShorter'  => esc_html__( 'Fade In Left Shorter', 'pandastore-core' ),
					'fadeInRightShorter' => esc_html__( 'Fade In Right Shorter', 'pandastore-core' ),
					'fadeInUpShorter'    => esc_html__( 'Fade In Up Shorter', 'pandastore-core' ),
				),
				'Blur'                         => array(
					'blurIn' => esc_html__( 'BlurIn', 'pandastore-core' ),
				),
			)
		);

		if ( 'appear' == $type ) {
			return $animations_appear;
		} elseif ( 'in' == $type ) {
			return $animations_in;
		} elseif ( 'out' == $type ) {
			return $animations_out;
		}

		return array(
			'sliderIn'  => $animations_in,
			'sliderOut' => $animations_out,
			'appear'    => $animations_appear,
		);
	}
}

/**
 * Remove filter callbacks
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_clean_filter' ) ) {
	function alpha_clean_filter( $hook, $callback, $priority = 10 ) {
		remove_filter( $hook, $callback, $priority );
	}
}

/**
 * alpha_get_additional_options
 *
 * gets floating options
 *
 * @return array options of floating effect
 *
 * @since 1.0
 */

function alpha_get_additional_options( $settings, $options = array() ) {
	// Floating Options
	if ( 0 === strpos( $settings['alpha_floating'], 'mouse_tracking' ) ) { // mouse tracking
		$floating_settings = array();
		if ( 'yes' == $settings['alpha_m_track_dir'] ) {
			$floating_settings['invertX'] = true;
			$floating_settings['invertY'] = true;
		} else {
			$floating_settings['invertX'] = false;
			$floating_settings['invertY'] = false;
		}

		if ( 'mouse_tracking_x' == $settings['alpha_floating'] ) {
			$floating_settings['limitY'] = '0';
		} elseif ( 'mouse_tracking_y' == $settings['alpha_floating'] ) {
			$floating_settings['limitX'] = '0';
		}

		if ( ! empty( $settings['builder'] ) && 'wpb' == $settings['builder'] ) {
			$speed = empty( $settings['alpha_m_track_speed'] ) ? 0.5 : floatval( $settings['alpha_m_track_speed'] );
		} else {
			$speed = empty( $settings['alpha_m_track_speed']['size'] ) ? 0.5 : floatval( $settings['alpha_m_track_speed']['size'] );
		}

		wp_enqueue_script( 'jquery-floating' );
		$options = $options +
			array(
				'data-plugin'         => 'floating',
				'data-options'        => json_encode( $floating_settings ),
				'data-floating-depth' => $speed,
			);
	} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_' ) ) { // scrolling effect
		$scroll_settings = array();
		$pos             = isset( $settings['alpha_scroll_stop'] ) ? $settings['alpha_scroll_stop'] : 'center';

		if ( ! empty( $settings['builder'] ) && 'wpb' == $settings['builder'] ) {
			$size = empty( $settings['alpha_scroll_size'] ) ? 50 : floatval( $settings['alpha_scroll_size'] );
		} else {
			$size = empty( $settings['alpha_scroll_size']['size'] ) ? 50 : floatval( $settings['alpha_scroll_size']['size'] );
		}

		if ( 0 === strpos( $settings['alpha_floating'], 'skr_transform_' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_transform_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . $size . '%);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(0, -' . $size . '%);';
					break;
				case 'skr_transform_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . $size . '%);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(0, ' . $size . '%);';
					break;
				case 'skr_transform_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(-' . $size . '%, 0);';
					break;
				case 'skr_transform_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(' . $size . '%, 0);';
					break;
			}
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_fade_in' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_fade_in':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0); opacity: 0;';
					break;
				case 'skr_fade_in_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_in_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_in_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0); opacity: 0;';
					break;
				case 'skr_fade_in_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0); opacity: 0;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0%, 0%); opacity: 1;';
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_fade_out' ) ) {
			$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0%, 0%); opacity: 1;';

			switch ( $settings['alpha_floating'] ) {
				case 'skr_fade_out':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0); opacity: 0;';
					break;
				case 'skr_fade_out_up':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, -' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_out_down':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, ' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_out_left':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(-' . $size . '%, 0); opacity: 0;';
					break;
				case 'skr_fade_out_right':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(' . $size . '%, 0); opacity: 0;';
					break;
			}
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_flip' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_flip_x':
					$scroll_settings['options']['data-bottom-top'] = 'transform: perspective(20cm) rotateY(' . $size . 'deg)';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: perspective(20cm), rotateY(-' . $size . 'deg)';
					break;
				case 'skr_flip_y':
					$scroll_settings['options']['data-bottom-top'] = 'transform: perspective(20cm) rotateX(-' . $size . 'deg)';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: perspective(20cm), rotateX(' . $size . 'deg)';
					break;
			}
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_rotate' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_rotate':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
				case 'skr_rotate_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . ( 100 * $size / 50 ) . '%, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
				case 'skr_rotate_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . ( 100 * $size / 50 ) . '%, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) rotate(0deg);';
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_zoom_in' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_zoom_in':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . ( 40 + $size ) . '%) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . ( 40 + $size ) . '%) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) scale(1);';
		} elseif ( 0 === strpos( $settings['alpha_floating'], 'skr_zoom_out' ) ) {
			switch ( $settings['alpha_floating'] ) {
				case 'skr_zoom_out':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . ( 40 + $size ) . '%) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . ( 40 + $size ) . '%) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) scale(1);';
		}

		wp_enqueue_script( 'jquery-skrollr' );
		$options = $options +
			array(
				'data-plugin'  => 'skrollr',
				'data-options' => json_encode( $scroll_settings['options'] ),
			);
	}

	$class = '';
	if ( isset( $settings['alpha_widget_duplex'] ) && filter_var( $settings['alpha_widget_duplex'], FILTER_VALIDATE_BOOLEAN ) ) {
		$class = 'duplex-widget';
	}

	if ( isset( $settings['alpha_widget_ribbon'] ) && filter_var( $settings['alpha_widget_ribbon'], FILTER_VALIDATE_BOOLEAN ) ) {
		$class = 'ribbon-added-widget';
		if ( 'type-4' == $settings['alpha_widget_ribbon_type'] || 'type-5' == $settings['alpha_widget_ribbon_type'] ) {
			$class .= ' ribbon-overflow-hidden';
		}
	}
	if ( ! empty( $class ) ) {
		if ( isset( $options['class'] ) ) {
			$options['class'] .= $class;
		} else {
			$options['class'] = $class;
		}
	}

	return apply_filters( 'alpha_get_additional_options', $options, $settings );
}

/**
 * Convert RGBA 8 hex values color to RGBA function color
 *
 * @param  string $color
 * @return array  options of floating effect
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_rgba_hex_2_rgba_func' ) ) {
	function alpha_rgba_hex_2_rgba_func( $color ) {
		$output = $color;

		if ( empty( $color ) ) {
			return $output;
		}

		if ( '#' == $color[0] ) {
			$color = substr( $color, 1 );
		}

		if ( strlen( $color ) == 8 ) { //ARGB
			$output  = 'rgba(0,0,0,1)';
			$opacity = round( hexdec( substr( $color, 6, 2 ) ) / 255, 2 );
			$hex     = array( substr( $color, 0, 2 ), substr( $color, 2, 2 ), substr( $color, 4, 2 ) );
			$rgb     = array_map( 'hexdec', $hex );
			$output  = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		}

		return $output;
	}
}
