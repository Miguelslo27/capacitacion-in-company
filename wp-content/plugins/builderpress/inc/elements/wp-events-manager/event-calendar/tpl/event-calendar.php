<?php
/**
 * Template for displaying default template Event Calendar element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/event-calendar/event-calendar.php.
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

$el_class = $params['el_class'];
$el_id    = $params['el_id'];
$bp_css       = $params['bp_css'];

$query = array(
	'post_type'           => 'tp_event',
	'post_status'         => 'publish',
	'order_by'            => 'DESC',
	'ignore_sticky_posts' => true
);

$events = new WP_Query( apply_filters( 'builder-press/event-calendar-query', $query ) );

if ( ! $events->post_count ) {
	return;
}

$data_date = array();

if ( $events->have_posts() ) {
	while ( $events->have_posts() ) {
		$events->the_post();
		$data_date[] = wpems_event_start( get_option( 'date_format' ) );
	}
}

$data_date   = apply_filters( 'builder-press/event-calendar-data-date', array_unique( $data_date ) );
$archive_url = get_post_type_archive_link( 'tp_event' );
?>

<div class="bp-element bp-element-event-calendar <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>
    <?php if( isset($params['title']) ) {?>
        <h3 class="title"><?php echo esc_html( $params['title'] ); ?></h3>
    <?php }?>
    <div class="wrap-calendar js-call-calendar"></div>
</div>