<?php
/**
 * Template for displaying default template lost password of Login Popup element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/login-popup/lost-password.php.
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
$image         = wp_get_attachment_image_src($params['popup_image'], 'full');
$popup_image   = $image[0];
?>

<!-- wp-content\themes\ivy-school-child\builderpress\login-popup\lost-password.php -->
<div class="login-popup box-lostpass">
  <div class="media-content" style="background-image: url(/wp-content/uploads/2019/04/annie-spratt-608001-unsplash.jpg)">
  </div>

  <div class="inner-login">

    <h3 class="title">
      <?php if (get_option('users_can_register') && $text_register) { ?>
        <span><a href="#register" class="display-box" data-display=".box-register"><?php echo esc_html($text_register); ?></a></span>
      <?php } ?>

      <?php if ($text_login) { ?>
        <span class="current-title"><?php esc_html_e('Resetear contraseña', 'builderpress'); ?></span>
      <?php } ?>
    </h3>

    <div class="form-row">
      <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url(network_site_url('wp-login.php?action=lostpassword', 'login_post')); ?>" method="post">
        <p class="description"><?php esc_html_e('Por favor, ingresa tu nombre de usuario o correo electrónico. Recibirás en tu email, un link para crear una nueva contraseña.', 'builderpress'); ?></p>
        <p class="login-username">
          <input placeholder="<?php esc_attr_e('Nombre de usuario o email', 'builderpress'); ?>" type="text" name="user_login_lostpass" id="user_login_lostpass" class="input" />
        </p>
        <p>
          <input type="submit" name="wp-submit-lostpass" id="wp-submit-lostpass" class="button button-primary button-large" value="<?php esc_attr_e('Resetear contraseña', 'builderpress'); ?>" />
        </p>

        <?php do_action('lostpassword_form'); ?>
      </form>
    </div>
  </div>
</div>