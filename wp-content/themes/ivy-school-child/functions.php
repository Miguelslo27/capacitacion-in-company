<?php
function thim_child_enqueue_styles()
{
  if (is_multisite()) {
    wp_enqueue_style('thim-child-style', get_stylesheet_uri());
  } else {
    wp_enqueue_style('thim-parent-style', get_template_directory_uri() . '/style.css');
  }
}

if (!function_exists('thim_related_courses')) {
  function thim_related_courses()
  {
    $related_courses = thim_get_related_courses(6);
    if ($related_courses) {
      ?>
      <!-- wp-content\themes\ivy-school-child\functions.php:thim_related_courses() -->
      <div class="related-archive">
        <h3 class="related-title"><?php esc_html_e('Cursos relacionados', 'ivy-school'); ?></h3>

        <div class="slide-course js-call-slick-col" data-numofslide="3" data-numofscroll="1" data-loopslide="1" data-autoscroll="0" data-speedauto="6000" data-respon="[3, 1], [3, 1], [2, 1], [2, 1], [1, 1]">
          <div class="slide-slick">
            <?php foreach ($related_courses as $course_item) : ?>
              <?php
              $course      = LP_Course::get_course($course_item->ID);
              $is_required = $course->is_required_enroll();
              $course_id   = $course_item->ID;
              if (class_exists('LP_Addon_Course_Review')) {
                $course_rate              = learn_press_get_course_rate($course_id);
                $course_number_vote       = learn_press_get_course_rate_total($course_id);
                $html_course_number_votes = $course_number_vote ? sprintf(_n('(%1$s voto )', ' (%1$s votos)', $course_number_vote, 'ivy-school'), number_format_i18n($course_number_vote)) : esc_html__('(0 votos)', 'ivy-school');
              }
              ?>
              <div class="item-slick">
                <div class="course-item">
                  <a href="<?php echo get_permalink($course_id); ?>" class="link-item"></a>
                  <div class="image">
                    <?php
                    echo thim_feature_image(get_post_thumbnail_id($course->get_id()), 284, 200, false);
                    ?>
                  </div>

                  <div class="content">
                    <div class="ava">
                      <?php echo ent2ncr($course->get_instructor()->get_profile_picture('', 68)) ?>
                    </div>

                    <div class="name">
                      <a href="<?php echo get_permalink($course_id); ?>">
                        <?php echo ent2ncr($course->get_author_display_name()); ?>
                      </a>
                    </div>

                    <?php
                    if (class_exists('LP_Addon_Course_Review')) {
                      $num_ratings = learn_press_get_course_rate_total(get_the_ID()) ? learn_press_get_course_rate_total(get_the_ID()) : 0;
                      $course_rate = learn_press_get_course_rate(get_the_ID());
                      $non_star = 5 - intval($course_rate);
                      ?>
                      <div class="star">
                        <?php for ($i = 0; $i < intval($course_rate); $i++) { ?>
                          <i class="fa fa-star"></i>
                        <?php } ?>
                        <?php for ($j = 0; $j < intval($non_star); $j++) { ?>
                          <i class="fa fa-star-o"></i>
                        <?php } ?>
                      </div>
                    <?php } ?>

                    <h4 class="title">
                      <a href="<?php echo get_permalink($course_id); ?>">
                        <?php echo get_the_title($course_id); ?>
                      </a>
                    </h4>
                  </div>

                  <div class="info">
                    <?php
                    if( $price = $course->get_price_html() ) :
                        $origin_price = $course->get_origin_price_html();
                      $free_course = ( $price === 'Gratis' ) ? ' free' : '';
                    ?>
                        
                    <div class="price">
                        <?php
                        if ($price === 'Gratis') {
                            echo '<span class="course-price">Consulte</span>';
                        } else {
                            echo '<span class="course-price">' . $price . ' <span class="price-tax">+ iva</span></span>';
                        }
                        ?>
                        <?php if ($course->has_sale_price()) { ?>
                          <span class="old-price"> <?php echo esc_html($course->get_origin_price_html()); ?></span>
                          <!-- wp-content\themes\ivy-school-child\functions.php -->
                          <span class="price-tax">+ iva</span>
                        <?php } ?>
                    </div>

                    <?php
                    endif;
                    ?>

                    <div class="numbers">
                      <?php if (class_exists('LP_Addon_Course_Review')) { ?>
                        <span class="chat">
                          <i class="ion ion-chatbubbles"></i>
                          <?php echo esc_html($num_ratings); ?>
                        </span>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="courses-carousel archive-courses course-grid owl-carousel owl-theme" data-cols="3">

        </div>
      </div>
    <?php
  }
}
}

/**
 * Get content breadcrumbs
 *
 * @return string
 */
if (!function_exists('thim_breadcrumbs')) {
  function thim_breadcrumbs()
  {
    global $post;
    if (is_front_page()) { // Do not display on the homepage
      return;
    }
    $categories   = get_the_category();
    $thim_options = get_theme_mods();
    $icon         = '/';
    if (isset($thim_options['breadcrumb_icon'])) {
      $icon = html_entity_decode(get_theme_mod('breadcrumb_icon'));
    }
    // Build the breadcrums
    echo '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';
    echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(home_url('/')) . '" title="' . esc_attr__('Inicio', 'ivy-school') . '"><span itemprop="name">' . esc_html__('Inicio', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
    if (is_single()) { // Single post (Only display the first category)
      if (get_post_type() == 'tp_event') {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_post_type_archive_link('tp_event')) . '" title="' . esc_attr__('Eventos', 'ivy-school') . '"><span itemprop="name">' . esc_html__('Eventos', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      }
      if (get_post_type() == 'our_team') {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_post_type_archive_link('our_team')) . '" title="' . esc_attr__('Nuestro equipo', 'ivy-school') . '"><span itemprop="name">' . esc_html__('Nuestro equipo', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      }
      if (get_post_type() == "lpr_course" || get_post_type() == "lpr_quiz" || get_post_type() == "lp_course" || get_post_type() == "lp_quiz" || thim_check_is_course() || thim_check_is_course_taxonomy()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_post_type_archive_link('lp_course')) . '" title="' . esc_attr__('Cursos', 'ivy-school') . '"><span itemprop="name">' . esc_html__('Cursos', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
        $term_course   = get_the_terms($post, 'course_category');
        if (isset($term_course[0])) {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_term_link($term_course[0], 'course_category')) . '" title="' . esc_attr($term_course[0]->name) . '"><span itemprop="name">' . esc_html($term_course[0]->name) . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
        }
      }
      if (get_post_type() == "lp_collection") {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_post_type_archive_link('lp_collection')) . '" title="' . esc_attr__('Colecciones', 'ivy-school') . '"><span itemprop="name">' . esc_html__('Colecciones', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      }
      if (isset($categories[0])) {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_category_link($categories[0]->term_id)) . '" title="' . esc_attr($categories[0]->cat_name) . '"><span itemprop="name">' . esc_html($categories[0]->cat_name) . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      }
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</span></li>';
    } else if (is_page()) {
      // Standard page
      if ($post->post_parent) {
        $anc = get_post_ancestors($post->ID);
        $anc = array_reverse($anc);
        // Parent page loop
        foreach ($anc as $ancestor) {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_permalink($ancestor)) . '" title="' . esc_attr(get_the_title($ancestor)) . '"><span itemprop="name">' . esc_html(get_the_title($ancestor)) . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
        }
      }
      // Current page
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr(get_the_title()) . '"> ' . esc_html(get_the_title()) . '</span></li>';
    } elseif (is_day()) { // Day archive
      // Year link
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '"><span itemprop="name">' . esc_html(get_the_time('Y')) . ' ' . esc_html__('Archivo', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      // Month link
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '" title="' . esc_attr(get_the_time('M')) . '"><span itemprop="name">' . esc_html(get_the_time('M')) . ' ' . esc_html__('Archivo', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      // Day display
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr(get_the_time('jS')) . '"> ' . esc_html(get_the_time('jS')) . ' ' . esc_html(get_the_time('M')) . ' ' . esc_html__('Archivo', 'ivy-school') . '</span></li>';
    } else if (is_month()) {
      // Year link
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '"><span itemprop="name">' . esc_html(get_the_time('Y')) . ' ' . esc_html__('Archivo', 'ivy-school') . '</span></a><span class="breadcrum-icon">' . ent2ncr($icon) . '</span></li>';
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr(get_the_time('M')) . '">' . esc_html(get_the_time('M')) . ' ' . esc_html__('Archivo', 'ivy-school') . '</span></li>';
    } elseif (is_archive()) {
      if (get_post_type() == "tp_event") {
        if (get_query_var('taxonomy')) {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html(get_queried_object()->name) . '</span></li>';
        } else {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__('Eventos', 'ivy-school') . '">' . esc_html__('Eventos', 'ivy-school') . '</span></li>';
        }
      }
      if (get_post_type() == "lp_collection") {
        if (get_query_var('taxonomy')) {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html(get_queried_object()->name) . '</span></li>';
        } else {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__('Colecciones', 'ivy-school') . '">' . esc_html__('Colecciones', 'ivy-school') . '</span></li>';
        }
      }
      if (get_post_type() == "lpr_course" || get_post_type() == "lpr_quiz" || get_post_type() == "lp_course" || get_post_type() == "lp_quiz" || thim_check_is_course() || thim_check_is_course_taxonomy()) {
        if (get_query_var('taxonomy')) {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html(get_queried_object()->name) . '</span></li>';
        } else {
          echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__('Cursos', 'ivy-school') . '">' . esc_html__('Cursos', 'ivy-school') . '</span></li>';
        }
      }
      if (get_post_type() == "testimonials") {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__('Testimonios', 'ivy-school') . '">' . esc_html__('Testimonios', 'ivy-school') . '</span></li>';
      }
      if (get_post_type() == "our_team") {
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__('Nuestro equipo', 'ivy-school') . '">' . esc_html__('Nuestro equipo', 'ivy-school') . '</span></li>';
      }
    }
    thim_get_breadcrumb_items_other();
    echo '</ul>';
  }
}

/**
 * Get course, lesson, ... duration in hours
 *
 * @param $id
 *
 * @param $post_type
 *
 * @return string
 */

if (!function_exists('thim_duration_time_calculator')) {
  function thim_duration_time_calculator($id, $post_type = 'lp_course')
  {
    if ($post_type == 'lp_course') {
      $course_duration_meta = get_post_meta($id, '_lp_duration', true);
      $course_duration_arr  = array_pad(explode(' ', $course_duration_meta, 2), 2, 'minute');

      list($number, $time) = $course_duration_arr;

      switch ($time) {
        case 'week':
          $course_duration_text = sprintf(_n("%s semana", "%s semanas", $number, 'ivy-school'), $number);
          break;
        case 'day':
          $course_duration_text = sprintf(_n("%s día", "%s días", $number, 'ivy-school'), $number);
          break;
        case 'hour':
          $course_duration_text = sprintf(_n("%s hora", "%s horas", $number, 'ivy-school'), $number);
          break;
        default:
          $course_duration_text = sprintf(_n("%s minuto", "%s minutos", $number, 'ivy-school'), $number);
      }

      return $course_duration_text;
    } else { // lesson, quiz duration
      $duration = get_post_meta($id, '_lp_duration', true);

      if (!$duration) {
        return '';
      }
      $duration = (strtotime($duration) - time()) / 60;
      $hour     = floor($duration / 60);
      $minute   = $duration % 60;

      if ($hour && $minute) {
        $time = $hour . esc_html__('h', 'ivy-school') . ' ' . $minute . esc_html__('m', 'ivy-school');
      } elseif (!$hour && $minute) {
        $time = $minute . esc_html__('m', 'ivy-school');
      } elseif (!$minute && $hour) {
        $time = $hour . esc_html__('h', 'ivy-school');
      } else {
        $time = '';
      }
      return $time;
    }
  }
}

if (!function_exists('thim_course_rate')) {
  function thim_course_rate()
  {
    echo '<div class="landing-review">';
    echo '<h3 class="title-rating">' . esc_html__('Reseñas', 'ivy-school');

    if ( is_user_logged_in() ) {
      learn_press_course_review_template('review-form.php');
    } else {
      echo '<a title="Ingresá para dejar tu reseña" href="#bp-popup-login" class="cant-review-message">Ingresá para dejar tu reseña</a>';
    }

    echo '</h3>';
    learn_press_course_review_template('course-rate.php');
    learn_press_course_review_template('course-review.php');
    echo '</div>';
  }
}

/**
 * Footer Widgets
 *
 * @return bool
 * @return string
 */
if (!function_exists('thim_footer_widgets')) {
  function thim_footer_widgets()
  {
    if (get_theme_mod('footer_widgets', true)) : ?>
      <!-- wp-content\themes\ivy-school-child\functions.php -->
      <div class="footer-sidebars columns-<?php echo get_theme_mod('footer_columns', 4); ?> row">
        <?php
        $col = 12 / get_theme_mod('footer_columns', 4);
        if (get_theme_mod('footer_columns') == 5) {
          $col = '';
        }
        for ($i = 1; $i <= get_theme_mod('footer_columns', 4); $i++) : ?>
          <div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr($col); ?>">
            <?php dynamic_sidebar('footer-sidebar-' . $i); ?>
          </div>
        <?php endfor; ?>
      </div>
      <div class="footer-sidebars company-info row">
        <?php dynamic_sidebar('footer-company-info'); ?>
      </div>
    <?php endif;
}
}

add_action('wp_enqueue_scripts', 'thim_child_enqueue_styles', 100);

/**
 * Ajax Login popup
 */
remove_action('wp_ajax_nopriv_builderpress_login_popup_ajax', 'login_ajax');
remove_action('wp_ajax_builderpress_login_popup_ajax', 'login_ajax');

add_action('wp_ajax_nopriv_builderpress_login_popup_ajax', 'login_ajax_custom');
add_action('wp_ajax_builderpress_login_popup_ajax', 'login_ajax_custom');

function login_ajax_custom()
{
  global $wpdb;

  //We shall SQL prepare all inputs to avoid sql injection.
  $username = $wpdb->prepare($_REQUEST['username'], array());
  $password = $_REQUEST['password'];
  $redirect_to = $_REQUEST['redirect_to'];
  $remember = $wpdb->prepare($_REQUEST['remember'], array());

  if ($remember) {
    $remember = "true";
  } else {
    $remember = "false";
  }

  $login_data                  = array();
  $login_data['user_login']    = $username;
  $login_data['user_password'] = $password;
  $login_data['redirect_to']   = $redirect_to;
  $login_data['remember']      = $remember;
  $user_verify                 = wp_signon($login_data, false);

  $code = 1;

  if (is_wp_error($user_verify)) {
    $message = '<p class="message message-error">' . esc_html__('Nombre de usuario o contraseña incorrecta.', 'builderpress') . '</p>';
    $code    = -1;
  } else {
    $message = '<p class="message message-success">' . esc_html__('Ingreso exitoso, redirigiendo...', 'builderpress') . '</p>';
  }
  $response_data = array(
    'code'    => $code,
    'message' => $message
  );
  if (!empty($login_data['redirect_to'])) {
    $response_data['redirect'] = $login_data['redirect_to'];
  }

  echo json_encode($response_data);
  die(); // this is required to return a proper result
}

/**
 * Ajax Register popup
 */
remove_action('wp_ajax_nopriv_builderpress_register_ajax', 'register_ajax');
remove_action('wp_ajax_builderpress_register_ajax', 'register_ajax');

add_action('wp_ajax_nopriv_builderpress_register_ajax', 'register_ajax_custom');
add_action('wp_ajax_builderpress_register_ajax', 'register_ajax_custom');

function register_ajax_custom()
{
  // First check the nonce, if it fails the function will break
  $secure = check_ajax_referer('ajax_register_nonce', 'register_security', false);

  if (!$secure) {
    $response_data = array(
      'message' => '<p class="message message-error">' . esc_html__('Algo salió mal, por favor intenta de nuevo.', 'builderpress') . '</p>'
    );

    wp_send_json_error($response_data);
  }

  parse_str($_POST['data'], $data);
  $info = array();

  $info['user_login'] = sanitize_user($data['user_login']);
  $info['user_email'] = sanitize_email($data['user_email']);
  $info['user_pass']  = sanitize_text_field($data['password']);

  $confirm_password = sanitize_text_field($data['repeat_password']);

  if ($info['user_pass'] !== $confirm_password) {
    $response_data = array(
      'message' => '<p class="message message-error">' . esc_html__('Esas contraseñas no coinciden. Intenta de nuevo.', 'builderpress') . '</p>'
    );

    wp_send_json_error($response_data);
  }

  // Register the user
  $user_register = wp_insert_user($info);

  if (is_wp_error($user_register)) {
    $error = $user_register->get_error_codes();

    if (in_array('empty_user_login', $error)) {
      $response_data = array(
        'message' => '<p class="message message-error">' . esc_html__('El usuario es requerido.', 'builderpress') . '</p>'
      );
    } elseif (in_array('existing_user_login', $error)) {
      $response_data = array(
        'message' => '<p class="message message-error">' . esc_html__('Este nombre de usuario ya se encuentra registrado.', 'builderpress') . '</p>'
      );
    } elseif (in_array('existing_user_email', $error)) {
      $response_data = array(
        'message' => '<p class="message message-error">' . esc_html__('Este correo electrónico ya se encuentra registrado.', 'builderpress') . '</p>'
      );
    }

    wp_send_json_error($response_data);
  } else {
    $creds                  = array();
    $creds['user_login']    = $info['user_login'];
    $creds['user_password'] = $info['user_pass'];

    $user_signon = wp_signon($creds, false);
    if (is_wp_error($user_signon)) {
      $response_data = array(
        'message' => '<p class="message message-error">' . esc_html__('Nombre de usuario o contraseña incorrecta.', 'builderpress') . '</p>'
      );

      wp_send_json_error($response_data);
    } else {
      wp_set_current_user($user_signon->ID);
      wp_set_auth_cookie($user_signon->ID);

      $response_data = array(
        'message' => '<p class="message message-success">' . esc_html__('Registro exitoso, redirigiendo...', 'builderpress') . '</p>'
      );

      wp_send_json_success($response_data);
    }
  }
}

/**
 * Get archive title
 *
 * Display the archive title based on the queried object.
 *
 * @return string
 */
if (!function_exists('thim_archive_title')) :
  function thim_archive_title($before = '', $after = '')
  {
    if (is_category()) {
      $title = sprintf(esc_html__('%s', 'ivy-school'), single_cat_title('', false));
    } elseif (is_tag()) {
      $title = sprintf(esc_html__('%s', 'ivy-school'), single_tag_title('', false));
    } elseif (is_author()) {
      $title = sprintf(esc_html__('%s', 'ivy-school'), '<span class="vcard">' . get_the_author() . '</span>');
    } elseif (is_year()) {
      $title = sprintf(esc_html__('Year: %s', 'ivy-school'), get_the_date(_x('Y', 'yearly archives date format', 'ivy-school')));
    } elseif (is_month()) {
      $title = sprintf(esc_html__('Month: %s', 'ivy-school'), get_the_date(_x('F Y', 'monthly archives date format', 'ivy-school')));
    } elseif (is_day()) {
      $title = sprintf(esc_html__('Day: %s', 'ivy-school'), get_the_date(_x('F j, Y', 'daily archives date format', 'ivy-school')));
    } elseif (is_tax('post_format', 'post-format-aside')) {
      $title = _x('Asides', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-gallery')) {
      $title = _x('Galleries', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-image')) {
      $title = _x('Images', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-video')) {
      $title = _x('Videos', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-quote')) {
      $title = _x('Quotes', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-link')) {
      $title = _x('Links', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-status')) {
      $title = _x('Statuses', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-audio')) {
      $title = _x('Audio', 'post format archive title', 'ivy-school');
    } elseif (is_tax('post_format', 'post-format-chat')) {
      $title = _x('Chats', 'post format archive title', 'ivy-school');
    } elseif (is_post_type_archive()) {
      // TODO / Change Collection for Coleccion
      $title = sprintf(esc_html__('%s', 'ivy-school'), post_type_archive_title('', false));
      switch (strtolower($title)) {
        default:
          $title = $title;
          break;
        case 'collection':
          $title = 'Colección';
          break;
        case 'collections':
          $title = 'Colecciones';
          break;
      }
    } elseif (is_tax()) {
      $tax = get_taxonomy(get_queried_object()->taxonomy);
      /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
      $title = sprintf(esc_html__('%1$s: %2$s', 'ivy-school'), $tax->labels->singular_name, single_term_title('', false));
    } elseif (is_404()) {
      $title = esc_html__('404 Page', 'ivy-school');
    } elseif (is_search()) {
      $title = esc_html__('Search Results Page', 'ivy-school');
    } else {
      $title = esc_html__('Archives', 'ivy-school');
    }

    /**
     * Filter the archive title.
     *
     * @param string $title Archive title to be displayed.
     */
    if (!empty($title)) {
      echo ent2ncr($before . $title . $after);
    }
  }
endif;
