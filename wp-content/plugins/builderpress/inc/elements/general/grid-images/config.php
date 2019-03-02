<?php
/**
 * BuilderPress Grid Images config class
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

if ( ! class_exists( 'BuilderPress_Config_Grid_Images' ) ) {
	/**
	 * Class BuilderPress_Config_Grid_Images
	 */
	class BuilderPress_Config_Grid_Images extends BuilderPress_Abstract_Config {

		/**
		 * BuilderPress_Config_Grid_Images constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'grid-images';
			self::$name = __( 'Grid Images', 'builderpress' );
			self::$desc = __( 'Display grid images', 'builderpress' );

			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
                array(
                    'type'       => 'radio_image',
                    'heading'    => __( 'Layout', 'builderpress' ),
                    'param_name' => 'layout',
                    'options'    => array(
                        'layout-1' => self::$assets_url . 'images/layouts/layout-grid.jpg',
                        'layout-images-slider'   => self::$assets_url . 'images/layouts/layout-slider.jpg',
                        'layout-2' => self::$assets_url . 'images/layouts/layout-2.png',
                    ),
                    'std'        => 'layout-1'
                ),
				array(
					'type'       => 'param_group',
					'heading'    => __( 'Images', 'builderpress' ),
					'param_name' => 'images',
					'params'     => array(
						array(
							'type'             => 'attach_image',
							'heading'          => esc_html__( 'Image', 'builderpress' ),
							'param_name'       => 'img',
							'edit_field_class' => 'vc_col-xs-6'
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Size', 'builderpress' ),
							'param_name'       => 'size',
							'value'            => array(
								esc_html__( '1x1', 'builderpress' ) => '1x1',
								esc_html__( '2x2', 'builderpress' ) => '2x2',
								esc_html__( '3x2', 'builderpress' ) => '3x2'
							),
							'std'              => '1x1',
							'edit_field_class' => 'vc_col-xs-6'
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title', 'builderpress' ),
							'param_name' => 'title',
                            'std'        => 'Title',
						),
					)
				),
                array(
                    'type'       => 'number',
                    'heading'    => __( 'Space', 'builderpress' ),
                    'param_name' => 'space',
                    'std'        => 0
                ),

                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS Shortcode', 'js_composer' ),
                    'param_name' => 'bp_css',
                    'group' => __( 'Design Options', 'js_composer' ),
                )
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_styles() {
			return array(
				'grid-images' => array(
					'src' => 'grid-images.css'
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_scripts() {
			return array(
				'grid-images' => array(
					'src' => 'grid-images.js',
                    'deps' => array(
                        'jquery',
                        'builder-press-isotope',
                        'builder-press-magnific-popup'
                    ),
					'deps_src' => array(
						'builder-press-isotope' => BUILDER_PRESS_URL . 'assets/libs/isotope/isotope.pkgd.min.js',
						'builder-press-magnific-popup' => BUILDER_PRESS_URL . 'assets/libs/magnific-popup/jquery.magnific-popup.min.js'
					)
				)
			);
		}
	}
}