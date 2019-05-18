<?php
/**
 * Template for displaying default template Learnpress Course Collections element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/course-collections/course-collections.php.
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

// global params
$template_path = $params['template_path'];

$layout       = isset( $params['layout'] ) ? $params['layout'] : 'layout-slider';
$number_items = $params['number_items'];
$course_link  = !empty($params['course_link']) ? $params['course_link'] : '#';
$el_class     = $params['el_class'];
$el_id        = $params['el_id'];
$bp_css       = $params['bp_css'];

$query = array(
	'post_type'      => 'lp_collection',
	'posts_per_page' => $number_items,
	'post_status'    => 'publish',
	'order' => 'ASC'
);

$collections = new WP_Query( apply_filters( 'builder-press/course-collections-query', $query ) );

if ( $collections->have_posts() ) { ?>

    <div class="bp-element bp-element-course-collections <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $layout ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>

		<?php builder_press_get_template( $layout, array(
			'collections' => $collections,
			'params'      => $params,
		), $template_path ); ?>

    </div>

	<?php wp_reset_postdata();
}
