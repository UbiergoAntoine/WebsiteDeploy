<?php
/**
 * Template Name: Portfolio Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'portfolio' );

get_template_part( 'theme-partials/portfolio-archive-loop' );

get_footer();
