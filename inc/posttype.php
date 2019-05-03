<?php
// create the posttype
function wpp_jlh_create_posttypes() {
  register_post_type( 'whatsapp-redirect',
      array(
          'labels' => array(
              'name' => __( 'Whatsapp Links' ),
              'singular_name' => __( 'Whatsapp Link' )
          ),
          'menu_icon' => 'dashicons-admin-links',
          'menu_position' => 5,
          'public' => true,
          'has_archive' => false,
          'rewrite' => array('slug' => 'wpp', 'with_front' => false),
          'supports' => array('title')
      )
  );
}
add_action( 'init', 'wpp_jlh_create_posttypes' );