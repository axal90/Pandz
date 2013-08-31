<?php


// Tell the TinyMCE editor to use a custom stylesheet
add_editor_style( get_template_directory_uri() . '/css/content.css');
  

/*Register Nav Menus*/
function register_my_menus() {
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
		)
	);
}
add_action( 'init', 'register_my_menus' );


/* Theme Support */

add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's fixed navbar
add_theme_support( 'post-thumbnails' ); 	// Post Thumbnails
add_theme_support( 'automatic-feed-links' ); // Feedlinks

//Custom Backgrounds
add_theme_support( 'custom-background', array(
	'default-color'          => 'E6E6E6',
	'default-image'          => '',
));

//Custom Header Image
add_theme_support( 'custom-header', array(
	'random-default'         => false,
	'width'                  => 250,
	'height'                 => 150,
	'flex-height'            => true,
	'flex-width'             => true,
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
	wp_enqueue_style('pandz_main_css', get_template_directory_uri() . '/css/main.css', false, null);
	wp_enqueue_style('pandz_content_css', get_template_directory_uri() . '/css/content.css', array('pandz_main_css'), null);
	wp_enqueue_style('thickbox', '', '', null);
	
	// Load style.css from child theme
	if (is_child_theme()) {
		wp_enqueue_style('roots_child', get_stylesheet_uri(), false, null);
	}
	
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"), array(),null,false);
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery_cycle_all', get_template_directory_uri() . '/js/responsiveslides.min.js', array('jquery'), null );
	wp_enqueue_script('thickbox', '', '', null);
}
add_action('wp_enqueue_scripts', 'pandz_scripts_method');


function pandz_categorys_for_pages() {
	register_taxonomy_for_object_type('category', 'page'); 
}
add_action( 'init', 'pandz_categorys_for_pages' );


function pandz_category_archives( $wp_query ) {

	if ( $wp_query->get( 'category_name' ) || $wp_query->get( 'cat' ) )
		$wp_query->set( 'post_type', 'any' );
	}

	if( !is_admin() ) {
		add_action( 'pre_get_posts', 'pandz_category_archives' );
	}

// Create the featured category
	wp_insert_term(
		'Featured', // the term
		'category', // the taxonomy
		array(
			'description'=> 'Featured Posts.',
			'slug' => 'featured'
		)
	);

?>