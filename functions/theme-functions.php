<?php


if ( ! isset( $content_width ) ) $content_width = 900;

/*Feautured Image in Rss feed*/
function insertThumbnailRSS($content) {
global $post;
if ( has_post_thumbnail( $post->ID ) ){
$content = '' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'style' => 'margin:0 20px 20px 20px; float:right;' ) ) . '' . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'insertThumbnailRSS');
add_filter('the_content_feed', 'insertThumbnailRSS');



/* Get The Slug */
function get_the_slug($postID="") {
 
	global $post;
	$postID = ( $postID != "" ) ? $postID : $post->ID;
	$post_data = get_post($postID, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug;
}


/* Add Category to attachment */
add_action( 'init', 'pandz_attachment_taxonomies' );
function pandz_attachment_taxonomies() {

    register_taxonomy_for_object_type( 'category', 'attachment' ); // add to post type attachment

}



/* is_subpage */
function is_subpage( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;               // load details about this page

    if ( is_page($pid) )
        return true;            // we're at the page or at a sub page

    $ancestors = get_post_ancestors( $post->ID );
	if( !empty($ancestors)) {
		foreach ( $ancestors as $ancestor ) {
			if( is_page() && $ancestor == $pid ) {
				return true;
			}
		}
	}

    return false;  // we arn't at the page, and the page is not an ancestor
}



// Body classes
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes[] = $category->category_nicename;
	return $classes;
}
add_filter('body_class', 'category_id_class');

?>