<?php

$theme_name = 'supermetal';


/**
 * Theme setup
 */
function the_setup() {
    
  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', $theme_name)
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
}
add_action('after_setup_theme', 'the_setup');

/**
 * Register sidebars
 */
function the_widgets_init() {
  register_sidebar([
    'name'          => __('Primary', $theme_name),
    'id'            => 'sidebar-primary',
    'before_widget' => '<div class="widget %1$s %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', $theme_name),
    'id'            => 'sidebar-footer',
    'before_widget' => '<div class="widget %1$s %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', 'the_widgets_init');

/**
 * ACF Options Page
 **/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Theme assets
 */

function the_enqueue() {
    /* local paths */ 
    $dist_path = '/wp-content/themes/superMetal/dist/';
        $styles = $dist_path . 'styles/main.min.css';
        $local_jquery = $dist_path . 'scripts/jquery.min.js';
        $local_bootstrapjs = $dist_path . 'scripts/bootstrap.min.js';
        $scripts = $dist_path . 'scripts/scripts.min.js';
    
    /* cdn paths */
    $jquery_cdn_path = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
    $bootstrapjs_cdn_path = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
    
    if(!(fopen($jquery_cdn_path,"r"))) { 
        $jquery_path = $local_jquery;
    } else { 
        $jquery_path = $jquery_cdn_path; }
    if(!(fopen($bootstrapjs_cdn_path,"r"))) { 
        $bootstrapjs_path = $local_bootstrapjs;
    } else { 
        $bootstrapjs_path = $bootstrapjs_cdn_path; }
        
    wp_deregister_script('jquery');
    wp_register_script('jquery', $jquery_path);
    wp_register_script('bootstrapjs', $bootstrapjs_path, ['jquery']);
    
    wp_enqueue_script('scripts', $scripts, ['jquery','bootstrapjs']);
    wp_enqueue_style('styles', $styles);
}
add_action('wp_enqueue_scripts', 'the_enqueue');
 
?>