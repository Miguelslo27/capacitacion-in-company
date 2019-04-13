<?php
/**
 * Template for displaying default template Image Box element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/image-box/image-box.php.
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

$el_class      = $params['el_class'];
$el_id         = $params['el_id'];
$box_link      = $params['box_link'];
$layout        = isset( $params['layout'] ) ? $params['layout'] : 'layout-gradient';
$bp_css        = $params['bp_css'];
?>

<div class="bp-element bp-element-image-box <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $params['style_image'] ); ?> image-<?php echo esc_attr( $params['image_alignment'] ); ?> <?php echo esc_attr( $params['background-color'] );?> <?php echo esc_attr( $layout ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>
    <?php builder_press_get_template( $layout,
        array(
            'params'       => $params,
            'box_link'     => $box_link,
        ), $template_path );
    ?>
</div>