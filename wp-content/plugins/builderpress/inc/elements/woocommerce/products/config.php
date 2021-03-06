<?php
/**
 * BuilderPress Products config class
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     BuilderPress/Classes
 * @category    Classes
 * @author      Thimpress, vinhnq
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BuilderPress_Config_Products' ) ) {
	/**
	 * Class BuilderPress_Config_Products
	 */
	class BuilderPress_Config_Products extends BuilderPress_Abstract_Config {

		/**
		 * BuilderPress_Config_Products constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'products';
			self::$name = __( 'Products', 'builderpress' );
			self::$desc = __( 'Display products', 'builderpress' );

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
                        'vblog-layout-list-1' => self::$assets_url . 'images/layouts/vblog-layout-list-1.jpg',
                        'vblog-layout-slider-1' => self::$assets_url . 'images/layouts/vblog-layout-slider-1.png',
                    ),
                    'std'        => 'vblog-layout-list-1'
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'builderpress' ),
                    'param_name'  => 'title',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_attr__( 'Category', 'builderpress' ),
                    'param_name'  => 'category',
                    'admin_label' => true,
                    'value'       => $this->_post_type_categories( 'product_cat' ),
                    'description' => esc_attr__( 'Select product category.', 'builderpress' )
                ),
                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Number items', 'builderpress' ),
                    'param_name'       => 'number_items',
                    'value'            => '3',
                ),

                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS Shortcode', 'js_composer' ),
                    'param_name' => 'bp_css',
                    'group' => __( 'Design Options', 'js_composer' ),
                ),

                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS on Tablet', 'js_composer' ),
                    'param_name' => 'bp_css_tablet',
                    'group' => __( 'Design Options', 'js_composer' ),
                ),

                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS on Mobile', 'js_composer' ),
                    'param_name' => 'bp_css_mobile',
                    'group' => __( 'Design Options', 'js_composer' ),
                ),
            );
		}

		/**
		 * @return array|mixed
		 */
		public function get_styles() {
			return array(
				'products' => array(
					'src' => 'products.css'
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_scripts() {
			return array(
				'products' => array(
					'src'  => 'products.js',
					'deps' => array(
						'jquery'
					)
				)
			);
		}
	}
}