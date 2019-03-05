<?php
/**
 * BuilderPress Elementor Slide Image Box widget
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

if ( ! class_exists( 'BuilderPress_El_Slide_Image_Box' ) ) {
	/**
	 * Class BuilderPress_El_Slide_Image_Box
	 */
	class BuilderPress_El_Slide_Image_Box extends BuilderPress_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'BuilderPress_Config_Slide_Image_Box';

		/**
		 * Register controls.
		 */
		protected function _register_controls() {
			$this->start_controls_section(
				'el-slide-image-box', [ 'label' => esc_html__( 'Slide Image Box', 'builderpress' ) ]
			);
			$config_options = $this->options();
			$new_params = array();
			foreach($config_options[0]['params'] as $param){
				if($param['type'] == 'vc_link'){
					$new_params[] = array(
						'type' => 'text',
						'heading' => __( 'Link Title', 'builderpress' ),
						'param_name' => 'linktype_title',
					);
				}
				$new_params[] = $param;
			}
			$config_options[0]['params'] = $new_params;

            $controls = \BuilderPress_El_Mapping::mapping( $config_options );

			foreach ( $controls as $key => $control ) {
				$this->add_control( $key, $control );
			}

			$this->end_controls_section();
		}
	}
}