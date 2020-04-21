<?php
/**
 * Template Name: Galleries Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'gallery' );
get_template_part( 'theme-partials/galleries-archive-loop' );
get_footer();
