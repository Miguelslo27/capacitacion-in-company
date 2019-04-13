<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$event    = new WPEMS_Event( get_the_ID() );
$user = get_user_by( 'id', $event->post->post_author );
$user_meta = get_user_meta( $event->post->post_author );
$avatar = get_avatar( $event->post->post_author, 87, '', '', array( 'gravatar' => false ) );
?>

<div class="bl-author-event">
    <div class="text">

        <p class="content">
            <?php echo esc_html($user_meta['description'][0]); ?>
        </p>
    </div>
</div>