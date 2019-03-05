<?php
/**
 * Section Sharing
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
    array(
        'id'       => 'sharing',
        'panel'    => 'blog',
        'title'    => esc_html__( 'Social Share', 'ivy-school' ),
        'priority' => 21,
    )
);

// Enable or Disable Author Meta Tags
thim_customizer()->add_field(
    array(
        'id'          => 'show_sharing',
        'type'        => 'switch',
        'label'       => esc_html__( 'Show Sharing', 'ivy-school' ),
        'tooltip'     => esc_html__( 'Allows you to show Sharing on single post.', 'ivy-school' ),
        'section'     => 'sharing',
        'default'     => false,
        'priority'    => 10,
        'choices'     => array(
            true  	  => esc_html__( 'Show', 'ivy-school' ),
            false	  => esc_html__( 'Hide', 'ivy-school' ),
        ),
    )
);

// Sharing Group
thim_customizer()->add_field(
    array(
        'id'       => 'group_sharing',
        'type'     => 'sortable',
        'label'    => esc_html__( 'Sortable Buttons Sharing', 'ivy-school' ),
        'tooltip'  => esc_html__( 'Click on eye icons to show or hide buttons. Use drag and drop to change the position of social share icons..', 'ivy-school' ),
        'section'  => 'sharing',
        'priority' => 20,
        'default'  => array(
            'facebook',
            'twitter',
            'pinterest',
            'google',
        ),
        'choices'  => array(
            'facebook'  => esc_html__( 'Facebook', 'ivy-school' ),
            'twitter'   => esc_html__( 'Twitter', 'ivy-school' ),
            'pinterest' => esc_html__( 'Pinterest', 'ivy-school' ),
            'google'    => esc_html__( 'Google Plus', 'ivy-school' ),
        ),
    )
);

