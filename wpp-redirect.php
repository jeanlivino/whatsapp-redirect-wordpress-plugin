<?php
/*
Plugin Name: Whatsapp Redirect
Plugin URI: https://github.com/jeanlivino/wpp-redirect-wordpress
Description: Create posttype to redirect users to whatsapp
Version: 0.1
Author: Jean Livino
Author URI: https://jeanlivino.com.br/
Text Domain: wpp-redirect
*/
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
          'supports' => array('title', 'editor')
      )
  );
}
add_action( 'init', 'wpp_jlh_create_posttypes' );

function wpp_jlh_single_template($single) {

    global $post;
    if ( $post->post_type == 'whatsapp-redirect' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'wpp-template.php') ) {
            return plugin_dir_path( __FILE__ ) . 'wpp-template.php';
        }
    }

    return $single;
}
add_filter( 'single_template', 'wpp_jlh_single_template');

 ?>