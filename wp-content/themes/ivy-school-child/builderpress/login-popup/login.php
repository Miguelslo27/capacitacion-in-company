<?php
/**
 * Template for displaying default template login popup of Login Popup element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/login-popup/login.php.
 *
 * @author      ThimPress
 * @package     BuilderPress/Templates
 * @version     1.0.0
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit;

/**
 * @var $params array - shortcode params
 */
$text_register = $params['text_register'];
$text_login    = $params['text_login'];
$shortcode     = $params['shortcode'];
$image         = wp_get_attachment_image_src($params['popup_image'], 'full');
$popup_image   = $image[0];
?>

<!-- wp-content\themes\ivy-school-child\builderpress\login-popup\login.php -->
<div class="login-popup box-login">
  <div class="media-content" style="background-image: url(/wp-content/uploads/2019/04/annie-spratt-608001-unsplash.jpg)"></div>
  <div class="inner-login">

    <h3 class="title">
      <?php if (get_option('users_can_register')) { ?>
        <span><a href="#register" class="display-box" data-display=".box-register"><?php echo esc_html__('Registro', 'builderpress'); ?></a></span>
      <?php } ?>

      <span class="current-title"><?php echo esc_html__('Entrar', 'builderpress'); ?></span>
    </h3>

    <div class="form-row">
      <div class="wrap-form">
        <div class="form-desc"><?php esc_html_e('Ingresa tu información', 'builderpress'); ?></div>
        <?php
        $login_redirect_option = get_theme_mod('theme_feature_login_redirect', false);
        // Set link login redirect
        if (!empty($_REQUEST['redirect_to'])) {
          $login_redirect = $_REQUEST['redirect_to'];
        } else if (!empty($login_redirect_option)) {
          $login_redirect = $login_redirect_option;
        } else {
          $login_redirect = apply_filters('builder-press/login-redirect', esc_url(home_url('/')));
        }
        wp_login_form(array(
          'redirect'     => $login_redirect,
          'id_username'  => 'bp_login_name',
          'id_password'  => 'bp_login_pass',
          'label_log_in' => esc_html__('Entrar', 'builderpress')
        )); ?>
        <p class="link-bottom"><a href="#losspw" class="display-box" data-display=".box-lostpass"><?php esc_html_e('¿Perdiste tu contraseña?', 'builderpress'); ?></a>
        </p>
      </div>

      <?php if ($shortcode) {
        $shortcode = str_replace(array('`', '{', '}'), '', $shortcode); ?>

        <div class="shortcode">
          <?php echo do_shortcode('[' . $shortcode . ']'); ?>
        </div>
      <?php } ?>
    </div>

  </div>
</div>