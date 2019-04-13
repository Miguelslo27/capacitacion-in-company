<?php
/**
 * Template for displaying global default template Testimonials element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/testimonials/testimonials.php.
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

/**
 * @var $params array - shortcode params
 */

if ( ! $params['testimonials'] ) {
	return;
}

// global params
$template_path = $params['template_path'];
$layout        = !empty($params['layout']) ? $params['layout'] : 'layout-slider-1';
$testimonials  = $params['testimonials'];
$items_visible = $params['items_visible'];
$items_tablet  = $params['items_tablet'];
$items_mobile  = $params['items_mobile'];
$background    = $params['background'] ? 'style="background-image: url(' . esc_url( wp_get_attachment_image_url( $params['background'], 'thumbnail' ) ) . ');"' : '';
$image_rating  = $params['image_rating'];
$el_class      = $params['el_class'];
$el_id         = $params['el_id'];
$bp_css        = $params['bp_css'];
?>

<div class="bp-element bp-element-testimonials <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $layout ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>

	<?php builder_press_get_template( $layout, array(
		'params'        => $params,
		'testimonials'  => $testimonials,
		'background'    => $background,
		'items_visible' => $items_visible,
		'items_tablet'  => $items_tablet,
		'items_mobile'  => $items_mobile
	), $template_path ); ?>

</div>
