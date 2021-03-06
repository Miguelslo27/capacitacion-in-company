<?php
/**
 * Template for displaying template Testimonials element layout slider 2.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/testimonials/layout-slider-2.php.
 *
 * @author      ThimPress
 * @package     BuilderPress/Templates
 * @version     1.0.0
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;
?>

<div class="slide-testimonial js-call-slick-testimonial" data-autoscroll="0" data-speedauto="5000" data-fadeslide="0">
    <div class="slide-content">
        <div class="slide-slick">
			<?php foreach ( $testimonials as $testimonial ) { ?>
                <div class="item-slick">
                    <div class="testimonial-content">
                        <div class="content"><?php echo esc_html( $testimonial['content'] ) ?></div>

                        <div class="author">
                            <span class="name">_<?php echo esc_html( $testimonial['name'] ); ?>,</span> <?php echo esc_html( $testimonial['works'] ); ?>
                        </div>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>

    <div class="slide-thumb">
        <div class="slide-slick">
			<?php foreach ( $testimonials as $testimonial ) { ?>
                <div class="item-slick">
					<?php
					$thumbnail_id = (int) $testimonial['image'];
					$size         = apply_filters( 'builder-press/testimonial/image-size', '80x80' );
					builder_press_get_attachment_image( $thumbnail_id, $size );
					?>
                </div>
			<?php } ?>
        </div>
    </div>
</div>