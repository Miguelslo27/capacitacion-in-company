<?php
function thim_child_enqueue_styles() {
	if ( is_multisite() ) {
		wp_enqueue_style( 'thim-child-style', get_stylesheet_uri() );
	} else {
		wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css' );
	}
}

if ( ! function_exists( 'thim_related_courses' ) ) {
	function thim_related_courses() {
		$related_courses = thim_get_related_courses( 6 );
		if ( $related_courses ) {
				?>
				<!-- wp-content\themes\ivy-school-child\functions.php:thim_related_courses() -->
				<div class="related-archive">
						<h3 class="related-title"><?php esc_html_e( 'Cursos relacionados', 'ivy-school' ); ?></h3>

						<div class="slide-course js-call-slick-col" data-numofslide="3" data-numofscroll="1" data-loopslide="1" data-autoscroll="0" data-speedauto="6000" data-respon="[3, 1], [3, 1], [2, 1], [2, 1], [1, 1]">
								<div class="slide-slick">
										<?php foreach ( $related_courses as $course_item ) : ?>
												<?php
												$course      = LP_Course::get_course( $course_item->ID );
												$is_required = $course->is_required_enroll();
												$course_id   = $course_item->ID;
												if ( class_exists( 'LP_Addon_Course_Review' ) ) {
														$course_rate              = learn_press_get_course_rate( $course_id );
														$course_number_vote       = learn_press_get_course_rate_total( $course_id );
														$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'ivy-school' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'ivy-school' );
												}
												?>
												<div class="item-slick">
														<div class="course-item">
																<a href="<?php the_permalink();?>" class="link-item"></a>
																<div class="image">
																		<?php
																		echo thim_feature_image( get_post_thumbnail_id( $course->get_id()), 284, 200, false );
																		?>
																</div>

																<div class="content">
																		<div class="ava">
																				<?php echo ent2ncr($course->get_instructor()->get_profile_picture('',68)) ?>
																		</div>

																		<div class="name">
																				<?php echo ent2ncr($course->get_instructor_html()); ?>
																		</div>

																		<?php
																		if ( class_exists( 'LP_Addon_Course_Review' ) ) {
																				$num_ratings = learn_press_get_course_rate_total( get_the_ID() ) ? learn_press_get_course_rate_total( get_the_ID() ) : 0;
																				$course_rate   = learn_press_get_course_rate( get_the_ID() );
																				$non_star = 5 - intval($course_rate);
																				?>
																				<div class="star">
																						<?php for ($i=0;$i<intval($course_rate);$i++) {?>
																								<i class="fa fa-star"></i>
																						<?php }?>
																						<?php for ($j=0;$j<intval($non_star);$j++) {?>
																								<i class="fa fa-star-o"></i>
																						<?php }?>
																				</div>
																		<?php }?>

																		<h4 class="title">
																				<a href="<?php echo get_permalink($course->get_id());?>">
																						<?php echo get_the_title($course->get_id());?>
																				</a>
																		</h4>
																</div>

																<div class="info">
																		<div class="price">
																				<?php echo esc_html($course->get_price_html()); ?>
																				<!-- wp-content\themes\ivy-school-child\inc\learnpress-functions.php -->
																				<span class="price-tax">+ iva</span>
																				<?php if ( $course->has_sale_price() ) { ?>
																						<span class="old-price"> <?php echo esc_html($course->get_origin_price_html()); ?></span>
																						<!-- wp-content\themes\ivy-school-child\inc\learnpress-functions.php -->
																						<span class="price-tax">+ iva</span>
																				<?php } ?>
																		</div>

																		<div class="numbers">
																				<?php if ( class_exists( 'LP_Addon_Course_Review' ) ) {?>
																				<span class="chat">
																						<i class="ion ion-chatbubbles"></i>
																						<?php echo esc_html($num_ratings);?>
																				</span>
																				<?php }?>
																		</div>
																</div>
														</div>
												</div>
										<?php endforeach; ?>
								</div>
						</div>
						<div class="courses-carousel archive-courses course-grid owl-carousel owl-theme" data-cols="3">

						</div>
				</div>
				<?php
		}
	}
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 100 );