<?php

/**
 * Plugin Name: Jetsa Статьи сверху
 * Description: Плагин для отображения хэдлайнеров
 * Plugin URI:  https://iamradaken.t.me
 * Author URI:  https://iamradaken.t.me
 * Author:      Alexey Kulikov, Pavel Marshankiy
 * Version:     1.0
 *
 * Requires at least: 2.5
 * Requires PHP: 5.4
 *
 * License:     The Chicken Dance License v 0.2   
 * License URI: https://github.com/supertunaman/cdl
 *
 * Network:     true. 
 **/

if(!defined('ABSPATH')){
  exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/jetsa-main-post-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__).'/includes/jetsa-main-post-class.php');

// Register Widget
function register_jmp(){
  register_widget('Jetsa_Main_Post_Widget');
}

// Hook in function
add_action('widgets_init', 'register_jmp');