<?php
/**
 * The template for displaying Archive Portfolio.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header('portfolio');

get_template_part('theme-partials/posts-lens_portfolio-archive');

get_footer();
