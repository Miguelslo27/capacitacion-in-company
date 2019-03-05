<?php
/**
 * BuilderPress Siteorigin Search Courses widget
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
defined('ABSPATH') || exit;

if (!class_exists('BuilderPress_SO_Search_Courses')) {
    /**
     * Class BuilderPress_SO_Search_Courses
     */
    class BuilderPress_SO_Search_Courses extends BuilderPress_SO_Widget{
        /**
         * BuilderPress_SO_Search_Courses constructor.
         */
        public function __construct(){
            // set config class
            $this->config_class = 'BuilderPress_Config_Search_Courses';

            parent::__construct();
        }
    }
}

add_action( 'widgets_init', 'builder_press_so_register_widget_search_courses' );

if ( ! function_exists( 'builder_press_so_register_widget_search_courses' ) ) {
	/**
	 * Register widget
	 */
	function builder_press_so_register_widget_search_courses() {
		register_widget( 'BuilderPress_SO_Search_Courses' );
	}
}
