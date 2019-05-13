<?php
/**
 * Template for displaying default template register popup of Login Popup element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/login-popup/register.php.
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

<!-- wp-content\themes\ivy-school-child\builderpress\login-popup\register.php -->
<div class="login-popup box-register">
  <div class="media-content" style="background-image: url(/wp-content/uploads/2019/04/annie-spratt-608001-unsplash.jpg)">
  </div>

  <div class="inner-login">
    <h3 class="title">
      <span class="current-title"><?php echo esc_html__('Registrarme', 'builderpress'); ?></span>

      <span><a href="#login" class="display-box" data-display=".box-login"><?php echo esc_html__('Entrar', 'builderpress'); ?></a></span>
    </h3>

    <div class="form-row">
      <div class="wrap-form">
        <div class="form-desc"><?php esc_html_e('Ingresa tu información', 'builderpress'); ?></div>
        <?php
        $register_redirect = get_theme_mod('theme_feature_register_redirect', false);
        if (empty($register_redirect)) {
          $register_redirect = apply_filters('thim_default_register_redirect', (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        }
        $register_redirect_url = !empty($_REQUEST['redirect_to']) ? esc_url($_REQUEST['redirect_to']) : $register_redirect;
        ?>
        <form name="loginform" id="popupRegisterForm" action="<?php echo esc_url(site_url('wp-login.php?action=register', 'login_post')); ?>" method="post">
          <?php wp_nonce_field('ajax_register_nonce', 'register_security'); ?>
          <p class="login-username">
            <input required placeholder="<?php esc_attr_e('Nombre de usuario', 'builderpress'); ?>" type="text" name="user_login" class="input" />
          </p>

          <p class="login-email">
            <input required placeholder="<?php esc_attr_e('Email', 'builderpress'); ?>" type="email" name="user_email" class="input" />
          </p>

          <p class="login-password">
            <input required placeholder="<?php esc_attr_e('Password', 'builderpress'); ?>" type="password" name="password" class="input" />
          </p>

          <p class="login-password">
            <input required placeholder="<?php esc_attr_e('Confirmar Password', 'builderpress'); ?>" type="password" name="repeat_password" class="input" />
          </p>

          <?php do_action('register_form'); ?>

          <p class="login-submit">
            <input type="submit" name="wp-submit" id="popupRegisterSubmit" class="button button-primary button-large" value="<?php esc_attr_e('Registrarme', 'builderpress'); ?>">
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($register_redirect_url); ?>">
          </p>

          <div class="popup-message"></div>

          <p class="link-bottom"><?php esc_html_e('¿Ya eres miembro? ', 'builderpress'); ?>
            <a href="#login" class="display-box" data-display=".box-login"><?php esc_html_e('Entra ahora', 'builderpress'); ?></a>
          </p>
        </form>
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