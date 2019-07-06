<?php
/**
 * Template for displaying default template lost password form of Login Form element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/login-form/lost-password.php.
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

$errors = apply_filters( 'builder-press/login-form/lost-password-errors', array(
	'empty'          => esc_html__( 'Ingrese correctamente su usuario o correo electrónico.', 'builderpress' ),
	'user_not_exist' => esc_html__( 'Ese usuario o correo electrónico no existen, intente nuevamente.', 'builderpress' )
) );

foreach ( $errors as $error => $message ) {
	if ( ! empty( $_GET[ $error ] ) ) { ?>
        <p class="message message-error"><?php echo $message; ?></p>
	<?php }
} ?>
<div class="login-form-wrap">
    <h4 class="subtitle"><?php esc_html_e( 'Recuperar Contraseña', 'builderpress' ); ?></h4>
    <h2 class="title"><?php esc_html_e( '¿Has perdido tu contraseña?', 'builderpress' ); ?></h2>

    <form name="lostpasswordform" id="lostpasswordform"
          action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>"
          method="post">

        <div class="wrap-fields">

            <p>
                <input placeholder="<?php esc_attr_e( 'Usuario o Correo Electrónico', 'builderpress' ); ?>" type="text"
                       name="user_login" id="user_login" class="input"/>
                <input type="hidden" name="redirect_to"
                       value="<?php echo esc_attr( add_query_arg( 'result', 'reset', bp_get_login_page_url() ) ); ?>"/>
            </p>

            <p class="submit login-submit">

                <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
                       value="<?php esc_attr_e( 'Resetear Contraseña', 'builderpress' ); ?>"/>

            </p>

        </div>


		<?php do_action( 'lostpassword_form' ); ?>
    </form>
    
    <p class="link-bottom"><?php esc_html_e( '¿Perdiste tu contraseña? Por favor ingrese su nombre de usuario o dirección de correo electrónico. Recibirá un enlace para crear una nueva contraseña por correo electrónico.', 'builderpress' ); ?></p>
</div>