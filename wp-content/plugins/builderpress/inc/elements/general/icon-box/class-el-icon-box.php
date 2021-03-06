<?php
/**
 * BuilderPress Elementor Icon Box widget
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     BuilderPress/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BuilderPress_El_Icon_Box' ) ) {
	/**
	 * Class BuilderPress_El_Icon_Box
	 */
	class BuilderPress_El_Icon_Box extends BuilderPress_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'BuilderPress_Config_Icon_Box';

		/**
		 * Register controls.
		 */
		protected function _register_controls() {
			$this->start_controls_section(
				'el-icon-box', [ 'label' => esc_html__( 'Icon Box', 'builderpress' ) ]
			);

			$controls = \BuilderPress_El_Mapping::mapping( $this->options() );

			foreach ( $controls as $key => $control ) {
				$this->add_control( $key, $control );
			}

			$this->end_controls_section();
		}
	}
}