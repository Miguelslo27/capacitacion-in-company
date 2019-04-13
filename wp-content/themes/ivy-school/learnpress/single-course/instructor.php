<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP_Global::course();
$author = $course->get_instructor();

$lp_info = get_the_author_meta( 'lp_info', $author->get_id() );
$author_meta = get_user_meta( $author->get_id() );
$author_meta = array_map( 'thim_get_user_meta', $author_meta );
?>
<?php if ( ! learn_press_is_learning_course() ): ?>
	<div id="tab-instructor" style="height: 40px"></div>
<?php endif; ?>
