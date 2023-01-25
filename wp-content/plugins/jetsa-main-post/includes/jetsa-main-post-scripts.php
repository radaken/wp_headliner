<?php
  // Add Scripts
  function jmp_add_scripts(){
    // Add Main CSS
    wp_enqueue_style('jmp-style', plugins_url(). '/jetsa-main-post/css/style.css');

  }

 add_action('wp_enqueue_scripts', 'jmp_add_scripts');