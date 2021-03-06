<?php
/**
 * The template for displaying Archive Galleries.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header('gallery');

get_template_part('theme-partials/posts-lens_galleries-archive');

get_footer();
