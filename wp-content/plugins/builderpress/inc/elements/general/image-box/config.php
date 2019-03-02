<?php
/**
 * BuilderPress Image Box config class
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

if ( ! class_exists( 'BuilderPress_Config_Image_Box' ) ) {
	/**
	 * Class BuilderPress_Config_Image_Box
	 */
	class BuilderPress_Config_Image_Box extends BuilderPress_Abstract_Config {

		/**
		 * BuilderPress_Config_Image_Box constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'image-box';
			self::$name = __( 'Image box', 'builderpress' );
			self::$desc = __( 'Display image box', 'builderpress' );

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
                        'layout-default'  => self::$assets_url . 'images/layouts/layout-default.jpg',
                        'layout-gradient' => self::$assets_url . 'images/layouts/layout-gradient.jpg',
                        'vblog-layout-2' => self::$assets_url . 'images/layouts/vblog-layout-2.png',
                        'vblog-layout-4' => self::$assets_url . 'images/layouts/vblog-layout-4.png',
                        'kindergarten-layout-1' => self::$assets_url . 'images/layouts/kindergarten-layout-1.png',
                    ),
                    'std'        => 'layout-default'
                ),
                array(
                    'type'             => 'attach_image',
                    'heading'          => esc_html__( 'Image', 'builderpress' ),
                    'param_name'       => 'img',
                    'edit_field_class' => 'vc_col-xs-6'
                ),
                array(
                    'type'             => 'attach_image',
                    'heading'          => esc_html__( 'Icon', 'builderpress' ),
                    'param_name'       => 'img-icon',
                    'edit_field_class' => 'vc_col-xs-6'
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => esc_html__( 'Title', 'builderpress' ),
                    'param_name' => 'title',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Description', 'builderpress' ),
                    'param_name' => 'description',
                ),
                // link
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_attr__( 'Link', 'builderpress' ),
                    'param_name' => 'box_link'
                ),
                // Background color
                array(
                    'type'             => 'dropdown',
                    'heading'          => esc_html__( 'Background color', 'builderpress' ),
                    'param_name'       => 'background-color',
                    'value'            => array(
                        esc_html__( 'Color 1', 'builderpress' )  => 'color-1',
                        esc_html__( 'Color 2', 'builderpress' ) => 'color-2',
                    ),
                    'description'      => esc_html__( 'Select background for box image.', 'builderpress' ),
                    'dependency'       => array(
                        'element' => 'layout',
                        'value'   => array( 'layout-gradient' )
                    ),
                    'std'              => 'color-1'
                ),
                array(
                    'type'             => 'dropdown',
                    'heading'          => esc_html__( 'Image Alignment', 'builderpress' ),
                    'param_name'       => 'image_alignment',
                    'value'            => array(
                        esc_html__( 'Left', 'builderpress' )  => 'left',
                        esc_html__( 'Right', 'builderpress' ) => 'right'
                    ),
                    'description'      => esc_html__( 'Select Image alignment.', 'builderpress' ),
                    'dependency'       => array(
                        'element' => 'layout',
                        'value'   => array( 'layout-default' ),
                    ),
                    'std'              => 'left'
                ),
                array(
                    'type'       => 'radio_image',
                    'heading'    => __( 'Style Image', 'builderpress' ),
                    'param_name' => 'style_image',
                    'options'    => array(
                        'demo-1' => self::$assets_url . 'images/layouts/demo-1.jpg',
                        'demo-2' => self::$assets_url . 'images/layouts/demo-2.jpg',
                        'demo-3' => self::$assets_url . 'images/layouts/demo-3.jpg',
                    ),
                    'dependency'       => array(
                        'element' => 'layout',
                        'value'   => array( 'layout-default' ),
                    ),
                    'std'        => 'demo-1'
                ),

                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS Shortcode', 'js_composer' ),
                    'param_name' => 'bp_css',
                    'group' => __( 'Design Options', 'js_composer' ),
                ),
            );
		}

		/**
		 * @return array|mixed
		 */
		public function get_styles() {
			return array(
				'image-box' => array(
					'src' => 'image-box.css'
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_scripts() {
			return array(
				'image-box' => array(
					'src'  => 'image-box.js',
					'deps' => array(
						'jquery'
					)
				)
			);
		}
	}
}