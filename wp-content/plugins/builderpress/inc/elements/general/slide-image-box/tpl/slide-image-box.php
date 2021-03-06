<?php
/**
 * Template for displaying default template Slide Image Box element.
 *
 * This template can be overridden by copying it to yourtheme/builderpress/slide-image-box/slide-image-box.php.
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
$bp_css         = $params['bp_css'];
$slide_image_box = $params['slide_image_box'];

?>

<div class="bp-element bp-element-slide-image-box  <?php echo is_plugin_active('js_composer/js_composer.php') ? vc_shortcode_custom_css_class( $bp_css ) : '';?> <?php echo esc_attr( $el_class ); ?>" <?php echo $el_id ? "id='" . esc_attr( $el_id ) . "'" : '' ?>>
    <div class="slide-img-box js-call-slick-col" data-verticalslide="1" data-verticalswipe="1" data-numofslide="1" data-numofscroll="1" data-loopslide="1" data-autoscroll="0" data-speedauto="6000" data-respon="[1, 1], [1, 1], [1, 1], [1, 1], [1, 1]">
        <div class="wrap-dot-slick"></div>

        <div class="slide-slick">
            <?php
                foreach ($slide_image_box as $get_list_slide_image_box):
                    $link = $get_list_slide_image_box['link'];
                ?>

                    <div class="item-slick">
                        <div class="item-img-box">
                            <div class="pic">
                                <div class="wrap-img">
                                    <div class="main-img">
                                        <?php
                                        if ( $link ) {
                                            $title = $link['title'] ? $link['title'] : __( 'Read More', 'builderpress' );
                                            if ( isset ( $get_list_slide_image_box['linktype_title'] ) && $get_list_slide_image_box['linktype_title'] != '' ) {
                                                $title = $get_list_slide_image_box['linktype_title'];
                                            }
                                            ?>
                                            <a href="<?php echo $get_list_slide_image_box['link']['url']?>" class="link">
                                                <?php echo $title?>
                                                <i class="ion ion-ios-arrow-thin-right"></i>
                                            </a>
                                        <?php }?>
                                        <?php
                                            if(isset($get_list_slide_image_box['main_image'])):
                                                $main_image = $get_list_slide_image_box['main_image'];
                                        ?>
                                                <?php
                                                    builder_press_get_attachment_image($main_image);
                                                ?>
                                        <?php
                                            endif;
                                        ?>
                                    </div>

                                    <div class="background">
                                        <span class="grey-bg small"></span>
                                        <span class="grey-bg big"></span>

                                        <span class="color-bg small"></span>
                                        <span class="color-bg normal"></span>
                                    </div>

                                    <div class="symbol">
                                        <?php
                                            if(!empty($get_list_slide_image_box['symbol_image'])):
                                            $symbol_image = $get_list_slide_image_box['symbol_image'];
                                        ?>
                                                <?php builder_press_get_attachment_image($symbol_image); ?>
                                        <?php
                                            endif;
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="text">
                                <div class="wrap-content">
                                    <div class="description">
                                        <?php echo $get_list_slide_image_box['sub_title']; ?>
                                    </div>

                                    <h3 class="title">
                                        <?php echo $get_list_slide_image_box['title']; ?>
                                    </h3>

                                    <div class="content">
                                        <?php echo $get_list_slide_image_box['description']; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</div>