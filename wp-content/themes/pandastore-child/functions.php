<?php

add_action('wp_enqueue_scripts', 'alpha_child_css', 1001);


// Load CSS
function alpha_child_css()
{
  // alpha child theme styles
  wp_deregister_style('styles-child');
  wp_register_style('styles-child', esc_url(get_theme_file_uri()) . '/style.css');
  wp_enqueue_style('styles-child');
}



add_filter('wc_session_expiring', 'woocommerce_cart_session_about_to_expire');
function woocommerce_cart_session_about_to_expire()
{

  // Default value is 47
  return 60 * 60 * 47;
}

// Sets when the session will expire
add_filter('wc_session_expiration', 'woocommerce_cart_session_expires');
function woocommerce_cart_session_expires()
{

  // Default value is 48
  return 60 * 60 * 48;
}


add_action('after_setup_theme', 'remove_wc_gallery', 1000);

function remove_wc_gallery()
{
  remove_theme_support('wc-product-gallery-zoom');
    remove_theme_support('wc-product-gallery-lightbox');
}


