<?php
/**
 * Invoked in wpgrade-config.php
 */
function wpgrade_callback_contact_script() {
	if (is_page_template('template-contact.php')) {
		wp_enqueue_script('contact-scripts');
	}
}

/**
 * Invoked in wpgrade-config.php
 */
function wpgrade_callback_thread_comments_scripts() {
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

/*
 * Enqueue some custom JS in the admin area for various small tasks
 */
add_action('admin_enqueue_scripts','wpgrade_add_admin_general_script');
function wpgrade_add_admin_general_script( $hook ){
	wp_enqueue_style( wpgrade::shortname() . '-admin-general', wpgrade::resourceuri( 'css/admin/admin-general.css' ), array(), time(), 'all' );
}

/**
 * Invoked in wpgrade-config.php
 */
function wpgrade_callback_addthis_script() {
	if ( ( is_singular('post') && pixelgrade_option( 'blog_single_show_share_links' ) ) ||
	     ( is_singular('lens_portfolio') && pixelgrade_option( 'portfolio_single_show_share_links' ) ) ||
	     ( is_page() && get_post_meta(lens::lang_page_id(get_the_ID()), wpgrade::prefix() . 'custom_homepage', true) == 'lens_project' ) ||
	     is_singular('product')) {
		wp_enqueue_script( 'addthis-api' , '//s7.addthis.com/js/250/addthis_widget.js#async=1', array( 'jquery' ), '1.0.0', true );
	}
}