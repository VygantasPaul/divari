<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Highlight Widget
 *
 * Alpha Widget to display WC breadcrumb.
 *
 * @author     D-THEMES
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Highlight_Elementor_Widget extends Elementor\Widget_Heading {

	public function get_name() {
		return ALPHA_NAME . '_widget_highlight';
	}

	public function get_title() {
		return esc_html__( 'Highlight', 'pandastore-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon alpha-widget-icon-highlight';
	}

	public function get_keywords() {
		return array( 'highlight', 'animated', 'heading', 'text', 'alpha' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		parent::_register_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'pandastore-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'highlight',
			array(
				'label'     => esc_html__( 'Highlight', 'pandastore-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'pandastore-core' ),
				'label_off' => esc_html__( 'No', 'pandastore-core' ),
				'default'   => false,
			)
		);

		$repeater->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'highlight' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'Text Hover Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'highlight' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'highlight_color',
			array(
				'label'     => esc_html__( 'Highlight Color', 'pandastore-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => alpha_get_option( 'primary_color' ),
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'background-image: linear-gradient({{VALUE}}, {{VALUE}})',
				),
				'condition' => array(
					'highlight' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'highlight_height',
			array(
				'label'      => esc_html__( 'Height', 'pandastore-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'background-size: 0 {{SIZE}}%',
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}.animating' => 'background-size: 100% {{SIZE}}%',
				),
				'condition'  => array(
					'highlight' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'line_break',
			array(
				'label' => esc_html__( 'Line Break', 'pandastore-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$repeater->add_control(
			'custom_class',
			array(
				'label' => esc_html__( 'Custom Class', 'pandastore-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$presets = array(
			array(
				'text' => esc_html__( 'Have your', 'pandastore-core' ),
			),
			array(
				'text'      => esc_html__( 'website popup', 'pandastore-core' ),
				'highlight' => 'yes',
			),
			array(
				'text' => esc_html__( 'out with', 'pandastore-core' ),
			),
			array(
				'text'      => esc_html__( 'Our Theme', 'pandastore-core' ),
				'highlight' => 'yes',
			),
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Content', 'pandastore-core' ),
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ text }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => $presets,
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$this->remove_control( 'title' );
		$this->remove_control( 'link' );
		$this->remove_control( 'size' );
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/highlight/render-highlight-elementor.php' );
	}

	protected function content_template() {
		?>
		<#
		var headerSizeTag = elementor.helpers.validateHTMLTag( settings.header_size );
		view.addRenderAttribute( 'title', 'class', ['elementor-heading-title', 'highlight-text'] );
		#>
		<{{{ headerSizeTag }}} {{{ view.getRenderAttributeString( 'title' ) }}}>
			<#
			_.each( settings.items, function( item, index ) {
				let item_key = view.getRepeaterSettingKey( 'text', 'items', index );
				view.addRenderAttribute( item_key, 'class', 'highlight animating elementor-repeater-item-' + item._id + ' ' + item.custom_class );
				view.addInlineEditingAttributes( item_key );
				var lineBreak = '';
				if ('yes' == item.line_break) {
					lineBreak = '<br>';
				}
				#>
				<span {{{ view.getRenderAttributeString( item_key ) }}}>{{{ item.text }}}{{{ lineBreak }}}</span>
				<#
			});
			#>
		</{{{ headerSizeTag }}}>
		<?php
	}
}
