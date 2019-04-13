<?php
/**
 * Template for displaying default template Social Links element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/social-links/social-links.php.
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
if ( ! $params['links'] ) {
	return;
}

$layout   = isset($params['layout']) ? $params['layout'] : 'default';
$title    = $params['title'];
$links    = $params['links'];
$el_class = $params['el_class'];
$el_id    = $params['el_id'];
$bp_css   = $params['bp_css'];
?>

<div class="bp-element bp-element-social-links <?php echo esc_attr($layout);?> <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>

    <?php builder_press_get_template( $layout, array(
        'links'                => $links,
        'title'                => $title,
    ), $template_path ); ?>

</div>