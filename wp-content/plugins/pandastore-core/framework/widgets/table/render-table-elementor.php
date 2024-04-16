<?php
/**
 * Table Shortcode Render
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Table Header
			'table_header' => array(
				array(
					'table_header_cell_text' => '',
					'table_header_show_icon' => '',
					'icon'                   => '',
					'table_header_col_span'  => '',
				),
			),
			// Table Body
			'table_body'   => array(
				array(
					'table_body_action'    => 'cell',
					'table_body_cell_text' => '',
					'table_body_col_span'  => '',
					'table_body_row_span'  => '',
				),
			),
		),
		$atts
	)
);


/**
 * Render table cell
 *
 * @since 4.0.0
 */
if ( ! function_exists( 'get_table_cell' ) ) {
	function get_table_cell( $data = array(), $context = 'head' ) {
		$html = '';

		$is_first_row = true;

		if ( 'head' === $context ) {
			$html .= '<tr class="table-head-row">';
		}

		foreach ( $data as $index => $item ) {

			if ( isset( $item['table_body_action'] ) && 'row' === $item['table_body_action'] ) {
				// Render row html
				if ( $is_first_row ) {
					$html        .= sprintf( '<tr class="table-body-row elementor-repeater-item-%s">', esc_attr( $item['_id'] ) );
					$is_first_row = false;
				} else {
					$html .= sprintf( '</tr><tr class="table-body-row elementor-repeater-item-%s">', esc_attr( $item['_id'] ) );
				}
			} else {
				// Render cell html
				$additional_content = '';
				$show_icon          = isset( $item['table_header_cell_show_icon'] ) ? $item['table_header_cell_show_icon'] : '';
				$position           = isset( $item['table_header_cell_icon_position'] ) ? $item['table_header_cell_icon_position'] : 'before';
				$icon               = isset( $item['table_header_cell_icon'] ) ? '<i class="' . esc_attr( $item['table_header_cell_icon']['value'] ) . '"></i>' : '';
				$th_colspan         = $item['table_header_col_span'] ? 'colspan="' . esc_attr( $item['table_header_col_span'] ) . '"' : '';
				$tb_colspan         = $item['table_body_col_span'] ? 'colspan="' . esc_attr( $item['table_body_col_span'] ) . '"' : '';
				$tb_rowspan         = $item['table_body_row_span'] ? 'rowspan="' . esc_attr( $item['table_body_row_span'] ) . '"' : '';

				if ( $show_icon ) {
					$additional_content = '<span class="table-header-cell-icon icon-position-' . esc_attr( $position ) . '">' . $icon . '</span>';
				}

				if ( 'head' == $context ) {
					$html .= '<th class="table-header-cell elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"' . $th_colspan . '><div class="table-cell-inner">';
					$html .= alpha_strip_script_tags( $additional_content );
					$html .= '<span class="table-header-cell-text">' . $item['table_header_cell_text'] . '</span>';
					$html .= '</div></th>';
				} else {
					$content_html = '';
					if ( isset( $item['table_body_cell_link'] ) && '' != $item['table_body_cell_link']['url'] ) {
						$content_html = '<a href="' . esc_url( $item['table_body_cell_link']['url'] ) . '">' . alpha_strip_script_tags( $item['table_body_cell_text'] ) . '</a>';
					} else {
						$content_html = '<span class="table-body-cell-text">' . alpha_strip_script_tags( $item['table_body_cell_text'] ) . '</span>';
					}

					if ( 'yes' == $item['table_body_col_is_th'] ) {
						$html .= '<th class="table-body-cell elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"' . $tb_colspan . ' ' . $tb_rowspan . '>';
					} else {
						$html .= '<td class="table-body-cell elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"' . $tb_colspan . ' ' . $tb_rowspan . '>';
					}

					$html .= '<div class="table-cell-inner">';
					$html .= $content_html;
					$html .= '</div>';

					if ( 'yes' == $item['table_body_col_is_th'] ) {
						$html .= '</th>';
					} else {
						$html .= '</td>';
					}
				}
			}
		}

		$html .= '</tr>';

		return $html;
	}
}
?>

<div class="widget-table-wrapper">
	<table class="widget-table">
		<thead class="table-head"><?php echo get_table_cell( $table_header, 'head' ); ?></thead>
		<tbody class="table-body"><?php echo get_table_cell( $table_body, 'body' ); ?></tbody>
	</table>
</div>
