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

require_once(plugin_dir_path( __FILE__ ) . 'inc/posttype.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/metabox.php');

// Add inttel css
add_action('admin_enqueue_scripts', 'jlh_wpp_admin_style');
// change the single template
add_filter( 'single_template', 'wpp_jlh_single_template');

// Function to encode the text
function wpp_jlh_encodeURI($uri)
{
    return preg_replace_callback("{[^0-9a-z_.!~*'();,/?:@&=+$#-]}i", function ($m) {
        return sprintf('%%%02X', ord($m[0]));
    }, $uri);
}

function jlh_wpp_admin_style() {
  wp_enqueue_style('intl-phone', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.2/css/intlTelInput.css');
}

function wpp_jlh_single_template($single) {

    global $post;
    if ( $post->post_type == 'whatsapp-redirect' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'wpp-template.php') ) {
            return plugin_dir_path( __FILE__ ) . 'wpp-template.php';
        }
    }

    return $single;
}

 ?>