<?php
/**
 * Template Name: Custom Home Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'homepage' );
//now this is a template that simply reads the meta data of the page with this template and delivers the output
//let's get cranking

//get the option the user choosed in the page metaboxes
$source = get_post_meta( lens::lang_page_id( get_the_ID() ), wpgrade::prefix() . 'custom_homepage', true );

if ( ! empty( $source ) ) {
	switch ( $source ) {
		case 'lens_portfolio':
			get_template_part( 'theme-partials/portfolio-archive-loop' );
			break;
		case 'lens_portfolio_cat':
			//get the portfolio cat
			$portfolio_cat_slug = get_post_meta( lens::lang_post_id( get_the_ID() ), wpgrade::prefix() . 'homepage_portfolio_category', true );

			//lets set in the query
			set_query_var( 'lens_portfolio_categories', $portfolio_cat_slug );
			get_template_part( 'theme-partials/posts-lens_portfolio_categories-archive' );
			wp_reset_query();
			break;
		case 'lens_project':
			//get the project id
			$projectID = get_post_meta( wpgrade::lang_post_id( get_the_ID() ), wpgrade::prefix() . 'homepage_project', true );

			if ( is_numeric( $projectID ) ) {
				global $wp_query;
				query_posts( 'post_type=lens_portfolio&p=' . $projectID );
				if ( have_posts() ) {
					the_post();
					$portfolio_template = get_post_meta( get_the_ID(), wpgrade::prefix() . 'project_template', true );
					get_template_part( 'theme-partials/portfolio-templates/portfolio', $portfolio_template );
				}
				wp_reset_query();
			}
			break;
		case 'lens_galleries_archive':
			get_template_part( 'theme-partials/galleries-archive-loop' );
			break;
		case 'lens_galleries_cat':
			//get the galleries cat
			$galleries_cat_slug = get_post_meta( lens::lang_post_id( get_the_ID() ), wpgrade::prefix() . 'homepage_galleries_category', true );

			//lets set in the query
			set_query_var( 'lens_gallery_categories', $galleries_cat_slug );
			get_template_part( 'theme-partials/posts-lens_gallery_categories-archive' );
			wp_reset_query();
			break;
		case 'lens_gallery':
			//get the gallery id
			$galleryID = get_post_meta( lens::lang_post_id( get_the_ID() ), wpgrade::prefix() . 'homepage_gallery', true );

			if ( is_numeric( $galleryID ) ) {
				global $wp_query;
				query_posts( 'post_type=lens_gallery&p=' . $galleryID );
				get_template_part( 'theme-partials/single-lens_gallery-loop' );
				wp_reset_query();
			}
			break;
		default:
	}
}
get_footer();
