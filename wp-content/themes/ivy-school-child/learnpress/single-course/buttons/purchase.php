<?php
/**
 * Template for displaying Purchase button in single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/buttons/purchase.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $course ) ) {
	$course = learn_press_get_course();
}
$guest_checkout = ( LP()->checkout()->is_enable_guest_checkout() ) ? 'allow_guest_checkout' : '';
?>

<?php do_action( 'learn-press/before-purchase-form' ); ?>
    <!-- wp-content\themes\ivy-school-child\learnpress\single-course\buttons\purchase.php -->
    <a href="/contacto/" class="request-course-info">Solicite el curso</a>

<?php do_action( 'learn-press/after-purchase-form' ); ?>