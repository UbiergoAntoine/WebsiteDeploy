<?php
/**
 * Lens functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Lens
 * @since   Lens 2.4.8
 */

// ensure EXT is defined
if ( ! defined('EXT')) {
	define('EXT', '.php');
}

// ensure REQUEST_PROTOCOL is defined
if ( ! defined('REQUEST_PROTOCOL')) {
	if (is_ssl()) {
		define( 'REQUEST_PROTOCOL', 'https:' );
	} else {
		define( 'REQUEST_PROTOCOL', 'http:' );
	}
}

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on Timber, use a find and replace
 * to change 'timber' to the name of your theme in all the template files
 */
load_theme_textdomain( 'lens', get_template_directory() . '/languages' );

if ( ! function_exists(' lens_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own lens_theme_setup() function to override in a child theme.
	 *
	 * @since Lens 2.4.8
	 */
	function lens_theme_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Add theme support for Featured Images
		add_theme_support( 'post-thumbnails' );

		add_image_size('blog-big', 800);
		add_image_size('blog-medium', 500);

		add_image_size('portfolio-big', 800, 440, true);
		add_image_size('portfolio-medium', 600, 330, true);
		add_image_size('portfolio-small', 400, 220, true);
		add_image_size('portfolio-big-v', 440, 800, true);
		add_image_size('portfolio-medium-v', 330, 600, true);
		add_image_size('portfolio-small-v', 220, 400, true);

		/*
		 * MAXIMUM SIZE
		 * Maximum Full Image Size
		 * - Sliders
		 * - Lightbox
		 */
		add_image_size('full-size', 2048);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'caption',
		) );

		/**
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'image',
			'gallery',
			'video',
			'audio',
			'quote',
		) );

		add_theme_support( 'woocommerce' );

		/**
		 * Pixcare Helper Plugin
		 */
		add_theme_support( 'pixelgrade_care', array(
				'support_url'   => 'https://pixelgrade.com/docs/lens/',
				'changelog_url' => 'https://wupdates.com/lens-changelog',
				'ock'           => 'Lm12n034gL19',
				'ocs'           => '6AU8WKBK1yZRDerL57ObzDPM7SGWRp21Csi5Ti5LdVNG9MbP'
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'lens_theme_setup' );


// Load various plugin integrations
// ----------------------
require get_template_directory() . '/inc/integrations.php';

// Initialize system core
// ----------------------

require_once 'wpgrade-core/bootstrap'.EXT;

#
# Please perform any initialization via options in wpgrade-config and
# calls in wpgrade-core/bootstrap. Required for testing.
#

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 960;
}

/**
 * Add the global AddThis configuration in the <head>
 */
function lens_setup_addthis() {
	if ( ( is_singular('post') && pixelgrade_option( 'blog_single_show_share_links' ) ) ||
	     ( is_singular('lens_portfolio') && pixelgrade_option( 'portfolio_single_show_share_links' ) ) ||
	     ( is_page() && get_post_meta(lens::lang_page_id(get_the_ID()), wpgrade::prefix() . 'custom_homepage', true) == 'lens_project' ) ||
	     is_singular('product')) {
		//here we will configure the AddThis sharing globally
		get_template_part( 'inc/addthis/addthis-js-config' );
	}
}
add_action( 'wp_head', 'lens_setup_addthis' );

/* Automagical updates */
function wupdates_check_vpz6M( $transient ) {
	// First get the theme directory name (the theme slug - unique)
	$slug = basename( get_template_directory() );

	// Nothing to do here if the checked transient entry is empty or if we have already checked
	if ( empty( $transient->checked ) || empty( $transient->checked[ $slug ] ) || ! empty( $transient->response[ $slug ] ) ) {
		return $transient;
	}

	// Let's start gathering data about the theme
	// Then WordPress version
	include( ABSPATH . WPINC . '/version.php' );
	$http_args = array (
		'body' => array(
			'slug' => $slug,
			'url' => home_url( '/' ), //the site's home URL
			'version' => 0,
			'locale' => get_locale(),
			'phpv' => phpversion(),
			'child_theme' => is_child_theme(),
			'data' => null, //no optional data is sent by default
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' )
	);

	// If the theme has been checked for updates before, get the checked version
	if ( isset( $transient->checked[ $slug ] ) && $transient->checked[ $slug ] ) {
		$http_args['body']['version'] = $transient->checked[ $slug ];
	}

	// Use this filter to add optional data to send
	// Make sure you return an associative array - do not encode it in any way
	$optional_data = apply_filters( 'wupdates_call_data_request', $http_args['body']['data'], $slug, $http_args['body']['version'] );

	// Encrypting optional data with private key, just to keep your data a little safer
	// You should not edit the code bellow
	$optional_data = json_encode( $optional_data );
	$w=array();$re="";$s=array();$sa=md5('52b195b1ff572d70bee2692721e622fc598f40de');
	$l=strlen($sa);$d=$optional_data;$ii=-1;
	while(++$ii<256){$w[$ii]=ord(substr($sa,(($ii%$l)+1),1));$s[$ii]=$ii;} $ii=-1;$j=0;
	while(++$ii<256){$j=($j+$w[$ii]+$s[$ii])%255;$t=$s[$j];$s[$ii]=$s[$j];$s[$j]=$t;}
	$l=strlen($d);$ii=-1;$j=0;$k=0;
	while(++$ii<$l){$j=($j+1)%256;$k=($k+$s[$j])%255;$t=$w[$j];$s[$j]=$s[$k];$s[$k]=$t;
		$x=$s[(($s[$j]+$s[$k])%255)];$re.=chr(ord($d[$ii])^$x);}
	$optional_data=bin2hex($re);

	// Save the encrypted optional data so it can be sent to the updates server
	$http_args['body']['data'] = $optional_data;

	// Check for an available update
	$url = $http_url = set_url_scheme( 'https://wupdates.com/wp-json/wup/v1/themes/check_version/vpz6M', 'http' );
	if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
		$url = set_url_scheme( $url, 'https' );
	}

	$raw_response = wp_remote_post( $url, $http_args );
	if ( $ssl && is_wp_error( $raw_response ) ) {
		$raw_response = wp_remote_post( $http_url, $http_args );
	}
	// We stop in case we haven't received a proper response
	if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
		return $transient;
	}

	$response = (array) json_decode($raw_response['body']);
	if ( ! empty( $response ) ) {
		// You can use this action to show notifications or take other action
		do_action( 'wupdates_before_response', $response, $transient );
		if ( isset( $response['allow_update'] ) && $response['allow_update'] && isset( $response['transient'] ) ) {
			$transient->response[ $slug ] = (array) $response['transient'];
		}
		do_action( 'wupdates_after_response', $response, $transient );
	}

	return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'wupdates_check_vpz6M' );

function wupdates_add_id_vpz6M( $ids = array() ) {
	// First get the theme directory name (unique)
	$slug = basename( get_template_directory() );

	// Now add the predefined details about this product
	// Do not tamper with these please!!!
	$ids[ $slug ] = array( 'name' => 'Lens', 'slug' => 'lens', 'id' => 'vpz6M', 'type' => 'theme', 'digest' => '0a2d65a18a7ee0232d3b3b4e9b05545e', );

	return $ids;
}
add_filter( 'wupdates_gather_ids', 'wupdates_add_id_vpz6M', 10, 1 );
