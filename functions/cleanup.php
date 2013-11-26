<?php



/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */

function pandz_head_cleanup() {

  // Originally from http://wpengineer.com/1438/wordpress-header/

  remove_action('wp_head', 'feed_links', 2);

  remove_action('wp_head', 'feed_links_extra', 3);

  remove_action('wp_head', 'rsd_link');

  remove_action('wp_head', 'wlwmanifest_link');

  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

  remove_action('wp_head', 'wp_generator');

  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);



  global $wp_widget_factory;

  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));



  add_filter('use_default_gallery_style', '__return_null');



}



/**
 * Remove the WordPress version from RSS feeds
 */

add_filter('the_generator', '__return_false');





/**
 * Add and remove body_class() classes
 */

function pandz_body_class($classes) {



  // Add post/page slug

  if (is_single() || is_page() && !is_front_page()) {

    $classes[] = basename(get_permalink());

  }



  // Remove unnecessary classes

  $home_id_class = 'page-id-' . get_option('page_on_front');

  $remove_classes = array(

    'page-template-default',

    $home_id_class

  );

  $classes = array_diff($classes, $remove_classes);



  return $classes;

}



add_filter('body_class', 'pandz_body_class');



/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */

function pandz_embed_wrap($cache, $url, $attr = '', $post_ID = '') {

  return '<div class="entry-content-asset">' . $cache . '</div>';

}



add_filter('embed_oembed_html', 'pandz_embed_wrap', 10, 4);

add_filter('embed_googlevideo', 'pandz_embed_wrap', 10, 2);



/**
 * Add class="thumbnail" to attachment items
 */

function pandz_attachment_link_class($html) {

  $postid = get_the_ID();

  $html = str_replace('<a', '<a class="thumbnail"', $html);

  return $html;

}



add_filter('wp_get_attachment_link', 'pandz_attachment_link_class', 10, 1);








/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * pandz_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */

class pandz_Nav_Walker extends Walker_Nav_Menu {

  function check_current($classes) {

    return preg_match('/(current[-_])|active|dropdown/', $classes);

  }



  function start_lvl(&$output, $depth = 0, $args = array()) {

    $output .= "\n<ul class=\"dropdown-menu\">\n";

  }



  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

    $item_html = '';

    parent::start_el($item_html, $item, $depth, $args);



    if ($item->is_dropdown && ($depth === 0)) {

      $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html);

      $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);

    }

    elseif (in_array('divider-vertical', $item->classes)) {

      $item_html = '<li class="divider-vertical">';

    }  

    elseif (in_array('divider', $item->classes)) {

      $item_html = '<li class="divider">';

    }

    elseif (in_array('nav-header', $item->classes)) {

      $item_html = '<li class="nav-header">' . $item->title;

    }



    $output .= $item_html;

  }



  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

    $element->is_dropdown = !empty($children_elements[$element->ID]);



    if ($element->is_dropdown) {

      if ($depth === 0) {

        $element->classes[] = 'dropdown';

      } elseif ($depth === 1) {

        $element->classes[] = 'dropdown-submenu';

      }

    }



    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

  }

}



/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */

function pandz_nav_menu_css_class($classes, $item) {

  $slug = sanitize_title($item->title);

  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);

  $classes = preg_replace('/((menu|page)[-_\w+]+)+/', '', $classes);



  $classes[] = 'menu-' . $slug;



  $classes = array_unique($classes);



  return array_filter($classes, 'is_element_empty');

}



add_filter('nav_menu_css_class', 'pandz_nav_menu_css_class', 10, 2);

add_filter('nav_menu_item_id', '__return_null');



function is_element_empty($element) {

  $element = trim($element);

  return empty($element) ? false : true;

}



/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Use pandz_Nav_Walker() by default
 */

function pandz_nav_menu_args($args = '') {



  if (!$args['items_wrap']) {

    $pandz_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';

  }



  if (current_theme_supports('bootstrap-top-navbar')) {

    $pandz_nav_menu_args['depth'] = 3;

  }



  if (!$args['walker']) {

    $pandz_nav_menu_args['walker'] = new pandz_Nav_Walker();

  }



  return array_merge($args, $pandz_nav_menu_args);

}



add_filter('wp_nav_menu_args', 'pandz_nav_menu_args');



/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */

function pandz_change_mce_options($options) {

  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';



  if (isset($initArray['extended_valid_elements'])) {

    $options['extended_valid_elements'] .= ',' . $ext;

  } else {

    $options['extended_valid_elements'] = $ext;

  }



  return $options;

}



add_filter('tiny_mce_before_init', 'pandz_change_mce_options');



/**
 * Add additional classes onto widgets
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */

function pandz_widget_first_last_classes($params) {

  global $my_widget_num;



  $this_id = $params[0]['id'];

  $arr_registered_widgets = wp_get_sidebars_widgets();



  if (!$my_widget_num) {

    $my_widget_num = array();

  }



  if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {

    return $params;

  }



  if (isset($my_widget_num[$this_id])) {

    $my_widget_num[$this_id] ++;

  } else {

    $my_widget_num[$this_id] = 1;

  }



  $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';



  if ($my_widget_num[$this_id] == 1) {

    $class .= 'widget-first ';

  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {

    $class .= 'widget-last ';

  }



  $params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);



  return $params;

}



add_filter('dynamic_sidebar_params', 'pandz_widget_first_last_classes');



/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */

function pandz_nice_search_redirect() {

  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {

    wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var('s')))), 301);

    exit();

  }

}



add_action('template_redirect', 'pandz_nice_search_redirect');



/**
 * Fix for get_search_query() returning +'s between search terms
 */

function pandz_search_query($escaped = true) {

  $query = apply_filters('pandz_search_query', get_query_var('s'));



  if ($escaped) {

    $query = esc_attr($query);

  }



  return urldecode($query);

}



add_filter('get_search_query', 'pandz_search_query');



/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */

function pandz_request_filter($query_vars) {

  if (isset($_GET['s']) && empty($_GET['s'])) {

    $query_vars['s'] = ' ';

  }



  return $query_vars;

}



add_filter('request', 'pandz_request_filter');