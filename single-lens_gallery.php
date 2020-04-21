<?php
/**
 * The template for the single lens_gallery CPT.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'gallery' );

global $wpgrade_private_post;

if ( post_password_required() && ! $wpgrade_private_post['allowed'] ) {

	get_template_part( 'theme-partials/password-request-form' );

} else { // password protection

	get_template_part( 'theme-partials/single-lens_gallery-loop' );

}
get_footer();
