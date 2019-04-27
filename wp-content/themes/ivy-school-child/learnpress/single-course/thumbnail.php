<?php
/**
 * Template for displaying thumbnail of single course.
 *
 * @author   ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit();

global $post;
$course           = learn_press_get_course();
$user             = LP_Global::user();
$video_embed      = $course->get_video_embed();
$video_intro      = get_post_meta(get_the_ID(), 'thim_course_media', true);
$thim_course_page = get_option('learn_press_single_course_image_size');
$width            = !empty($thim_course_page['width']) ? $thim_course_page['width'] : 1022;
$height           = !empty($thim_course_page['height']) ? $thim_course_page['height'] : 608;
?>

<?php if ($video_embed) { ?>
  <div class="course-video"><?php echo esc_attr($video_embed); ?></div>
<?php } ?>

<?php if (!has_post_thumbnail() || $video_embed) {
  return;
} ?>

<!-- wp-content\themes\ivy-school-child\learnpress\single-course\thumbnail.php -->
<div class="course-thumbnail">
  <?php
  $image_title   = get_the_title(get_post_thumbnail_id()) ? esc_attr(get_the_title(get_post_thumbnail_id())) : '';
  $image_caption = get_post(get_post_thumbnail_id()) ? esc_attr(get_post(get_post_thumbnail_id())->post_excerpt) : '""';
  $image_link    = wp_get_attachment_url(get_post_thumbnail_id());
  $image_crop    = thim_aq_resize($image_link, $width, $height, true);
  if (!$image_crop) {
    $image = '<img src="' . esc_url($image_link) . '" alt="' . esc_attr($image_title) . '" title="' . esc_attr($image_title) . '" class="no-cropped"/>';
  } else {
    $image = '<img src="' . esc_url($image_crop) . '" alt="' . esc_attr($image_title) . '" title="' . esc_attr($image_title) . '" />';
  }

  if (learn_press_is_learning_course()) {
    thim_thumbnail($course->get_id(), '647x399', 'post', false);
  } else {
    echo (ent2ncr($image));
  } ?>
  <?php if ($video_intro) { ?>
    <a href="<?php echo esc_url($video_intro); ?>" class="play-button video-thumbnail popup-youtube">
      <span class="video-thumbnail hvr-push"></span>
    </a>
  <?php } ?>
  <div class="time">
    <?php
    $course_duration_meta = get_post_meta(get_the_ID(), '_lp_duration', true);
    $course_duration_arr  = array_pad(explode(' ', $course_duration_meta, 2), 2, 'minute');

    list($number, $time) = $course_duration_arr;

    switch ($time) {
      case 'week':
        $course_duration_text = sprintf(_n("<div class=\"date-start\">%s</div> <div class=\"month-start\">semana</div>", "<div class=\"date-start\">%s</div> <div class=\"month-start\">semanas</div>", $number, 'ivy-school'), $number);
        break;
      case 'day':
        $course_duration_text = sprintf(_n("<div class=\"date-start\">%s</div> <div class=\"month-start\">día</div>", "<div class=\"date-start\">%s</div> <div class=\"month-start\">días</div>", $number, 'ivy-school'), $number);
        break;
      case 'hour':
        $course_duration_text = sprintf(_n("<div class=\"date-start\">%s</div> <div class=\"month-start\">hora</div>", "<div class=\"date-start\">%s</div> <div class=\"month-start\">horas</div>", $number, 'ivy-school'), $number);
        break;
      default:
        $course_duration_text = sprintf(_n("<div class=\"date-start\">%s</div> <div class=\"month-start\">minuto</div>", "<div class=\"date-start\">%s</div> <div class=\"month-start\">minutos</div>", $number, 'ivy-school'), $number);
    }

    echo $course_duration_text;
    ?>
  </div>
</div>