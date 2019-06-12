<?php
/**
 * Template for displaying review form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/review-form.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
?>

<button class="write-a-review btn-normal shape-round btn-primary"><?php _e( 'Escribe una reseña', 'ivy-school' ); ?></button>
<div class="course-review-wrapper" id="course-review">
    <div class="review-overlay"></div>
    <div class="review-form" id="review-form">
        <div class="form-overlay-review"></div>
        <form>
            <h3>
				<?php _e( 'Escribe una reseña', 'ivy-school' ); ?>
                <a href="" class="close dashicons dashicons-no-alt"></a>
            </h3>
            <ul class="review-fields">
				<?php do_action( 'learn_press_before_review_fields' ); ?>
                <li>
                    <label><?php _e( 'Título', 'ivy-school' ); ?> <span class="required">*</span></label>
                    <input type="text" name="review_title"/>
                </li>
                <li>
                    <label><?php _e( 'Mensaje', 'ivy-school' ); ?><span class="required">*</span></label>
                    <textarea name="review_content"></textarea>
                </li>
                <li>
                    <label><?php _e( 'Valoración', 'ivy-school' ); ?><span class="required">*</span></label>
                    <ul class="review-stars">
						<?php for ( $i = 1; $i <= 5; $i ++ ) { ?>
                            <li class="review-title" title="<?php echo $i; ?>">
                                <span class="dashicons dashicons-star-empty"></span></li>
						<?php } ?>
                    </ul>
                </li>
				<?php do_action( 'learn_press_after_review_fields' ); ?>
                <li class="review-actions">
                    <button type="button" class="submit-review btn-normal shape-round btn-primary"
                            data-id="<?php the_ID(); ?>"><?php _e( 'Enviar reseña', 'ivy-school' ); ?></button>
                    <span class="ajaxload"></span>
                    <span class="error"></span>
					<?php wp_nonce_field( 'learn_press_course_review_' . get_the_ID(), 'review-nonce' ); ?>
                    <input type="hidden" name="rating" value="0">
                    <input type="hidden" name="lp-ajax" value="add_review">
                    <input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>">
                </li>
            </ul>
        </form>
    </div>
</div>