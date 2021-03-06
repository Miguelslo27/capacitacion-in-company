<?php
/**
 * BuilderPress Testimonials config class
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

if ( ! class_exists( 'BuilderPress_Config_Testimonials' ) ) {
	/**
	 * Class BuilderPress_Config_Testimonials
	 */
	class BuilderPress_Config_Testimonials extends BuilderPress_Abstract_Config {
		/**
		 * BuilderPress_Config_Testimonials constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'testimonials';
			self::$name = __( 'Testimonials', 'builderpress' );
			self::$desc = __( 'Display a testimonials box.', 'builderpress' );

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
                        'layout-slider-1'   => self::$assets_url . 'images/layouts/layout-1.jpg',
                        'layout-slider-2'   => self::$assets_url . 'images/layouts/layout-2.jpg',
                        'layout-slider-3'   => self::$assets_url . 'images/layouts/layout-3.jpg',
                        'layout-slider-4'   => self::$assets_url . 'images/layouts/layout-slider-4.jpg',
                        'layout-slider-5'   => self::$assets_url . 'images/layouts/layout-slider-5.jpg',
                        'layout-slider-6'   => self::$assets_url . 'images/layouts/layout-6.png',
                        'layout-slider-7'   => self::$assets_url . 'images/layouts/layout-7.png',
                        'layout-slider-8'   => self::$assets_url . 'images/layouts/layout-8.png',
                        'layout-slider-9'   => self::$assets_url . 'images/layouts/layout-9.png',
                        'layout-slider-10'   => self::$assets_url . 'images/layouts/layout-10.png',
                        'vblog-layout-slider-1' => self::$assets_url . 'images/layouts/vblog-layout-slider-1.jpg',
                    ),
                    'std'         => 'layout-slider-1',
                    'description' => __( 'Select type of style.', 'builderpress' )
                ),
				
				array(
					'type'       => 'param_group',
					'value'      => '',
					'heading'    => __( 'Testimonials', 'builderpress' ),
					'param_name' => 'testimonials',
					'params'     => array(
						array(
							'type'       => 'textfield',
							'heading'    => __( 'Name', 'builderpress' ),
							'param_name' => 'name',
							'std'        => __( 'John Doe', 'builderpress' )
						),

						array(
							'type'             => 'attach_image',
							'heading'          => __( 'Image', 'builderpress' ),
							'param_name'       => 'image',
							'edit_field_class' => 'vc_col-sm-6'
						),

						array(
							'type'             => 'textfield',
							'heading'          => __( 'Website', 'builderpress' ),
							'param_name'       => 'website',
							'std'              => '#',
							'edit_field_class' => 'vc_col-sm-6'
						),

						array(
							'type'       => 'textfield',
							'heading'    => __( 'Info', 'builderpress' ),
							'param_name' => 'works',
							'std'        => __( 'Founder', 'builderpress' )
						),

						array(
							'type'       => 'textarea',
							'heading'    => __( 'Content', 'builderpress' ),
							'param_name' => 'content',
							'value'      => '',
							'std'        => __( 'This is my first time to consult in this hospital and I’m lucky I got a perfect doctor who takes care of me since day one of my consultation, until the day of my surgery.', 'builderpress' )
						),

						array(
							'type'       => 'number',
							'heading'    => __( 'Rating', 'builderpress' ),
							'param_name' => 'rating',
							'min'        => 0,
							'max'        => 5,
							'step'       => 0.5
						),

					)
				),
                array(
                    'type'             => 'attach_image',
                    'heading'          => __( 'Image rating', 'builderpress' ),
                    'param_name'       => 'image_rating',
                    'dependency'       => array(
                        'element' => 'layout',
                        'value'   => array( 'layout-slider-9' ),
                    ),
                    'edit_field_class' => 'vc_col-sm-6'
                ),
				array(
					'type'       => 'attach_image',
					'heading'    => __( 'Background', 'builderpress' ),
					'param_name' => 'background',
                    'dependency'       => array(
                        'element' => 'layout',
                        'value'   => array( 'layout-slider-4' ),
                    ),
				),
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS Shortcode', 'js_composer' ),
                    'param_name' => 'bp_css',
                    'group' => __( 'Design Options', 'js_composer' ),
                ),
			),


				// config slider number items
				$this->_number_items_options(
					array(
						'items_visible' => 1,
						'items_tablet'  => 1,
						'items_mobile'  => 1
					)
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_styles() {
			return array(
				'testimonials' => array(
					'src'  => 'testimonials.css',
					'deps' => array(
						'dashicons',
						'builder-press-slick'
					)
				)
			);
		}

		/**
		 * @return array|mixed
		 */
		public function get_scripts() {
			return array(
				'testimonials' => array(
					'src'  => 'testimonials.js',
					'deps' => array(
						'jquery',
						'builder-press-slick'
					)
				)
			);
		}
	}
}