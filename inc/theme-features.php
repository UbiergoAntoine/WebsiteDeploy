<?php

/**
 * @see wpgrade-config.php -> body-classes
 * @return boolean true if page may have the class 'header-transparent'
 */
function wpgrade_callback_has_featured_image_class() {
	if (is_singular() && (has_post_thumbnail() || get_post_format() == 'gallery' || get_post_format() == 'image')) {
		return false;
	} elseif (is_page() || is_archive() || is_home()) {
		if (is_page_template('template-portfolio.php') && pixelgrade_option('portfolio_header_image')) {
			return true;
		}

		if (is_tax('portfolio_cat') && pixelgrade_option('portfolio_header_image') ) {
			return true;
		}

		if (is_page_template('template-front-page.php') && pixelgrade_option('homepage_use_slider')) {
			return true;
		}

		if ((is_archive() || is_home() || is_page_template( 'template-blog-archive.php' )) && pixelgrade_option('blog_header_image')) {
			return true;
		}
	}

	return false;
}
add_action('wp_head', 'wpgrade_callbacks_html5_shim');

//function wpgrade_callback_sort_query_by_post_in( $sortby, $thequery ) {
//	if ( !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' )
//		$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
//
//	return $sortby;
//}
//add_filter( 'posts_orderby', 'wpgrade_callback_sort_query_by_post_in', 10, 2 );


function wpgrade_prepare_password_for_custom_post_types(){

	global $wpgrade_private_post;
	$wpgrade_private_post = lens::is_password_protected();

}

add_action('wp', 'wpgrade_prepare_password_for_custom_post_types');