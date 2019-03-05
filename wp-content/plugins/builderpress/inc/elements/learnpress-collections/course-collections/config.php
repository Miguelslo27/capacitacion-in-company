<?php
/**
 * BuilderPress Learnpress Course Collections config class
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

if ( ! class_exists( 'BuilderPress_Config_Course_Collections' ) ) {
	/**
	 * Class BuilderPress_Config_Course_Collections
	 */
	class BuilderPress_Config_Course_Collections extends BuilderPress_Abstract_Config {

		/**
		 * BuilderPress_Config_Course_Collections constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'course-collections';
			self::$name = __( 'Course Collections', 'builderpress' );
			self::$desc = __( 'Display LearnPress list course collections', 'builderpress' );

			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {
			// options
			return array_merge( array(

                array(
                    'type'        => 'radio_image',
                    'heading'     => __( 'Layout', 'builderpress' ),
                    'param_name'  => 'layout',
                    'options'     => array(
                        'layout-slider'   => self::$assets_url . 'images/layouts/layout-slider-1.jpg',
                        'layout-slider-2' => self::$assets_url . 'images/layouts/layout-slider-2.jpg',
                        'layout-grid'     => self::$assets_url . 'images/layouts/layout-grid.png',
                    ),
                    'std'         => 'layout-slider',
                    'description' => __( 'Select type of style.', 'builderpress' )
                ),
                array(
                    'type'        => 'vc_link',
                    'heading'     => esc_html__( 'Link', 'builderpress' ),
                    'param_name'  => 'course_link',
                    'dependency' => array(
                        'element' => 'layout',
                        'value'   => array(
                            'layout-grid',
                        ),
                    ),
                    'admin_label' => true
                ),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Number Items', 'builderpress' ),
					'param_name' => 'number_items',
					'value'      => 8,
                    'edit_field_class' => 'vc_col-sm-6'
				),
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS Shortcode', 'js_composer' ),
                    'param_name' => 'bp_css',
                    'group' => __( 'Design Options', 'js_composer' ),
                )
			),
				// config slider number items
				$this->_number_items_options()
			);

		}

		/**
		 * @return array|mixed
		 */
		public function get_styles() {
			return array(
				'course-collections' => array(
					'src' => 'course-collections.css'
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_scripts() {
			return array(
				'course-collections' => array(
					'src'  => 'course-collections.js',
					'deps' => array(
						'builder-press-slick'
					),
					'deps_src' => array(
						'builder-press-slick' => BUILDER_PRESS_URL . 'assets/libs/slick/slick.min.js'
					)
				)
			);
		}
	}
}