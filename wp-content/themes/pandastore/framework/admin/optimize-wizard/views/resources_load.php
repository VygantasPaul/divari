<?php
/**
 * Load resources.
 *
 * @author     D-THEMES
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

// Elements Group Mapping
$used_mapping = [];
// @start feature: fs_pb_wpb
if ( alpha_get_feature( 'fs_pb_wpb' ) && defined( 'WPB_VC_VERSION' ) ) {
	$used_mapping['shortcode'] = array(
		'title' => esc_html__( 'WPBakery Shortcodes', 'pandastore' ),
	);
}
// @end feature: fs_pb_wpb

// Initialize grouped array.
$used_by_group = array();
foreach ( $used_mapping as $group => $data ) {
	$used_by_group[ $group ] = array();
}

foreach ( $alpha_used_elements as $element => $used ) {
	$find = false;
	foreach ( $used_mapping as $group => $data ) {
		if ( isset( $data['prefix'] ) ) {
			foreach ( $data['prefix'] as $prefix ) {
				if ( substr( $element, 0, strlen( $prefix ) ) == $prefix ) {
					$used_by_group[ $group ][] = $element;
					$find                      = true;
					break;
				}
			}
		}
		if ( $find ) {
			break;
		}
	}
}

if ( alpha_get_feature( 'fs_pb_wpb' ) && defined( 'WPB_VC_VERSION' ) ) {
	$used_by_group['shortcode'] = $this->get_all_shortcodes();
}

foreach ( $used_by_group as $group => $elements ) {
	ksort( $used_by_group[ $group ] );
}

foreach ( $used_by_group as $group => $elements ) {
	// WPB Shortcodes
	if ( alpha_get_feature( 'fs_pb_wpb' ) && 'shortcode' == $group && defined( 'WPB_VC_VERSION' ) ) {
		?>
		<div class="alpha-card <?php echo esc_attr( $group ); ?>">
			<div class="alpha-card-header">
				<h3><?php echo esc_html( $used_mapping[ $group ]['title'] ); ?></h3>
				<label class="checkbox checkbox-inline checkbox-toggle">
				<?php esc_html_e( 'Toggle All', 'pandastore' ); ?>
					<span type="checkbox" class="toggle"></span>
				</label>
			</div>
			<div class="alpha-card-list">
				<?php
				foreach ( $elements as $element ) {
					?>
					<label class="checkbox checkbox-inline">
						<input type="checkbox" name="used_shortcode[<?php echo esc_attr( $element ); ?>]" 
							<?php
							disabled( in_array( $element, $used_shortcodes ) );
							checked( in_array( $element, $checked_shortcodes ) );
							?>
						class="element">
							<?php echo esc_html( $element ); ?>
					</label>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="alpha-card <?php echo esc_attr( $group ); ?>">
			<div class="alpha-card-header">
				<h3><?php echo esc_html( $used_mapping[ $group ]['title'] ); ?></h3>
				<label class="checkbox checkbox-inline checkbox-toggle">
				<?php esc_html_e( 'Toggle All', 'pandastore' ); ?>
					<span type="checkbox" class="toggle"></span>
				</label>
			</div>
			<div class="alpha-card-list">
				<?php
				foreach ( $elements as $element ) {
					if ( 'helper' != $group || ! in_array( $element, $helper_classes ) ) {
						?>
						<label class="checkbox checkbox-inline">
							<input type="checkbox" name="used[<?php echo esc_attr( $element ); ?>]" 
								<?php
								disabled( true === $alpha_used_elements[ $element ] );
								checked( $alpha_used_elements[ $element ] );
								?>
							class="element">
								<?php echo esc_html( $element ); ?>
						</label>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}
