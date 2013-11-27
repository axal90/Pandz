<?php











/* Theme Support */

add_theme_support( 'post-thumbnails' ); 	// Post Thumbnails

add_theme_support( 'automatic-feed-links' ); // Feedlinks



//Custom Backgrounds

add_theme_support( 'custom-background', array(

	'default-color'          => 'E6E6E6',

	'default-image'          => '',

));



//Custom Header Image

add_theme_support( 'custom-header', array(
	'width'                  => 960,
	'height'                 => 250,
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => '575759',
	'header-text'            => true,
	'uploads'                => true,

));





define('POST_EXCERPT_LENGTH', 40); // Excerpt length



add_image_size( 'homepage-thumb', 600, 600, true );	// Excerpt length

add_image_size( 'featured-thumb', 961, 272, true );		// Excerpt length

add_image_size( 'profile-thumb', 50, 67, true );	// Excerpt length

add_image_size( 'profile', 200, 301, true );		// Excerpt length



/*Register Sidebar*/



register_sidebar(array(

	'name' => __( 'Sidebar' ),

	'id' => 'sidebar',

	'before_widget' => '<div id="%1$s" class="widget %2$s">',

	'after_widget'  => '</div>',

	'before_title' => '<h3>',

	'after_title' => '</h3>'

));

register_sidebar(array(

	'name' => __( 'Footer' ),

	'id' => 'footer',

	'before_widget' => '<div id="%1$s" class="widget %2$s">',

	'after_widget'  => '</div>',

	'before_title' => '<h3>',

	'after_title' => '</h3>'

));

register_sidebar(array(

	'name' => __( 'Front Page Sidebar' ),

	'id' => 'front-sidebar',

	'before_widget' => '<div id="%1$s" class="widget %2$s">',

	'after_widget'  => '</div>',

	'before_title' => '<h3>',

	'after_title' => '</h3>'

));



/*Register Nav Menus*/

function register_my_menus() {

	register_nav_menus(

		array(

			'main-menu' => __( 'Main Menu' ),

		)

	);

}

add_action( 'init', 'register_my_menus' );



// returns WordPress subdirectory if applicable

function wp_base_dir() {

  preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);

  if (count($matches) === 3) {

	return end($matches);

  } else {

	return '';

  }

}



// opposite of built in WP functions for trailing slashes

function leadingslashit($string) {

  return '/' . unleadingslashit($string);

}



function unleadingslashit($string) {

  return ltrim($string, '/');

}



function add_filters($tags, $function) {

  foreach($tags as $tag) {

	add_filter($tag, $function);

  }

}





// Backwards compatibility for older than PHP 5.3.0

if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }



// Define helper constants

$get_theme_name = explode('/themes/', get_template_directory());



define('WP_BASE',                   wp_base_dir());

define('THEME_NAME',                next($get_theme_name));

define('RELATIVE_PLUGIN_PATH',      str_replace(site_url() . '/', '', plugins_url()));

define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);

define('RELATIVE_CONTENT_PATH',     str_replace(site_url() . '/', '', content_url()));

define('THEME_PATH',                RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);

if ( ! defined( 'WP_PLUGIN_DIR' ) ) {

	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

}



/*Javascripts and styles*/

function pandz_scripts_method() {

	wp_enqueue_style('pandz_main_css', get_template_directory_uri() . '/assets/css/main.css', false, null);

	wp_enqueue_style('normalize_css', get_template_directory_uri() . '/assets/css/normalize.css', false, null);

	

	// Load style.css from child theme

	if (is_child_theme()) {

		wp_enqueue_style('pandz_child', get_stylesheet_uri(), false, null);

	}

	

	wp_enqueue_script('jquery');

}

add_action('wp_enqueue_scripts', 'pandz_scripts_method');





// Tell the TinyMCE editor to use a custom stylesheet

add_editor_style( get_template_directory_uri() . '/assets/css/normalize.css');

add_editor_style( get_template_directory_uri() . '/assets/css/main.css');

  



?>