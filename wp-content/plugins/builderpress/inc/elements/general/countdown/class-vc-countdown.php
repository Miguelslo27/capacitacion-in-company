<?php
/**
 * BuilderPress Visual Composer Countdown shortcode
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

if ( ! class_exists( 'BuilderPress_VC_Countdown' ) ) {
	/**
	 * Class BuilderPress_VC_Countdown
	 */
	class BuilderPress_VC_Countdown extends BuilderPress_VC_Shortcode {

		/**
		 * BuilderPress_VC_Countdown constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'BuilderPress_Config_Countdown';

			parent::__construct();
		}
	}
}

new BuilderPress_VC_Countdown();