<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$config = array(
	# Commented values are optional properties. Many properties are
	# automatically deduced from others (eg. textdomain is deduced from
	# name, unless a custom value is provided)
	# ---------------------------------------------------------------------
	'name'                         => 'Lens',
	'shortname'                    => 'lens',
	'prefix'                       => '_lens_',
	'language-path'                => 'languages',

	// additional file includes (classes, functions, etc), files are loaded
	// via wpgrade::require_all and entries should be directories; if the
	// path does not exist it is automatically ignored
	'include-paths'                => array(
		'inc/includes/classes',
		'inc/includes/functions',
	),

	// same as include-paths only instead of files you specify files, to be
	// used with vendor dependencies to avoid multiple include/requires
	// happening due to the files in question adding subfiles relative to
	// their directory (also avoids problems with php configuration files)
	'include-files'                => array(
		// main theme class
		'inc/activation-hooks' . EXT,
		'inc/content-filters' . EXT,
		'inc/customify' . EXT,
		'inc/filter-shortcodes' . EXT,
		'inc/lens' . EXT,
		'inc/pagination-formatter' . EXT,
		'inc/resource-enqueues' . EXT,
		'inc/rtl-support' . EXT,
		// widgets & template tags
		'inc/template-tags' . EXT,
		'inc/theme-defaults' . EXT,
		'inc/unsorted' . EXT,
		'inc/extras' . EXT,
		'inc/widgets' . EXT,
		'inc/woocommerce' . EXT,
		'inc/includes/required-plugins/required-plugins' . EXT,
	),

	// the path where overwrites on the core partials are stored, any files
	// placed in the partial overwrites will be loaded instead of the core
	// equivalent view files
	'core-partials-overwrite-path' => 'theme-partials/wpgrade-partials',

	// the directory where css and other media files are located; used by
	// wpgrade::resourceuri; utility allows for easy migration of files to
	// new structures
	'resource-path'                => '/assets',

	// use theme-options to add any non-customizable options with out going
	// though any of the backend code; all options added here are available
	// though the WPGradeOptions driver manager. ie. the  wpgrade::option
	// shorthand. Support for backend customization may be added at any
	// time later with out requiring any alterations; the options you add
	// here will have the lowest priority
	'theme-options'                => array(// empty
	),

	// Usage: body_class(wpgrade::body_class()) in header.php
	// Syntax: class => callback or boolean; eg. 'myclass' => true,
	// 'myclass' => false, 'myclass' => 'class_check_function'. All
	// callbacks are executed once if more classes refer the same callback.
	'body-classes'                 => array(// empty
	),

	// filter functions will recieve content as a parameter and must return
	// content; all functions are ordered by priority and executed from
	// lowest to highest. If a filter is assigned false as a priority it
	// will be ignored in processing
	'content-filters'              => array(
		'default' => array(
			'wpgrade_callback_theme_general_filters' => 100,
			'wpgrade_callback_shortcode_filters'     => 200,
			'wpgrade_callback_attachement_filters'   => 300,
			'wpgrade_callback_paragraph_filters'     => 400,
		),
	),

	'shortcodes' => array(
		'Columns',
		'Button',
		'Icon',
		'Tabs',
		'Quote',
		'TeamMember',
		'Separator',
		'ProgressBar',
		'Slider',
	),

	'resources'          => array(
		// script declarations; scripts must be enqueue'ed to appear
		'register'                => array(
			'head-scripts' => array(
				'modernizr' => array(
					'path'    => get_template_directory_uri() . '/assets/js/vendor/modernizr.min.js',
					'require' => array( 'jquery' ),
				),
			),

			'footer-scripts' => array(
				'google-maps-api'      => array(
					'path'    => REQUEST_PROTOCOL . '//maps.google.com/maps/api/js?language=en',
					'require' => array( 'jquery' ),
				),
				'wpgrade-rs'           => array(
					'path'    => REQUEST_PROTOCOL . '//pxgcdn.com/js/rs/9.5.7/index.js',
					'require' => array( 'jquery', ),
				),
				'wpgrade-mix'          => array(
					'path'    => REQUEST_PROTOCOL . '//pxgcdn.com/js/mixitup/1.5.4/index.js',
					'require' => array( 'jquery', ),
				),
				'wpgrade-easing'       => array(
					'path'    => REQUEST_PROTOCOL . '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',
					'require' => array( 'jquery', ),
				),
				'wpgrade-main-scripts' => array(
					'path'       => get_template_directory_uri() . '/assets/js/main.js',
					'cache_bust' => wpgrade::cachebust_string( wpgrade::themefilepath( '/assets/js/main.js' ) ),
					'require'    => array(
						'jquery',
						'modernizr',
						'mediaelement',
						'wpgrade-rs',
						'wpgrade-mix',
						'wpgrade-easing',
					),
				),

			),

			'styles' => array(
				'google-webfonts'    => array(
					'path' => REQUEST_PROTOCOL . '//fonts.googleapis.com/css?family=Roboto:300,500,300italic,500italic|Open+Sans:300,400,700,300italic,400italic,700italic|Josefin+Slab:400,600,700|Crimson+Text:400,400italic',
				),
				'wpgrade-main-style' => array(
					'path'       => get_template_directory_uri() . '/style.css',
					'cache_bust' => wpgrade::cachebust_string( wpgrade::themefilepath( '/style.css' ) ),
					'require'    => 'mediaelement',
				),
			),

		), # end register

		// auto invoke scripts previously registered on theme setup
		'auto-enqueue-scripts'    => array(
			'google-maps-api',
			'wpgrade-main-scripts',
		),

		// enques script and localizes
		'auto-localize-scripts'   => array(
			'wpgrade-main-scripts' => array(
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'objectl10n' => array(
					'tPrev'    => esc_html__( 'Previous (Left arrow key)', 'lens' ),
					'tNext'    => esc_html__( 'Next (Right arrow key)', 'lens' ),
					'tCounter' => esc_html__( 'of', 'lens' ),
				),
			),
		),

		// calls function to perform extra enqueue's on theme setup
		// handlers should be placed in theme's functions.php
		'script-enqueue-handlers' => array(
			'contact-form'    => 'wpgrade_callback_contact_script',
			'thread-comments' => 'wpgrade_callback_thread_comments_scripts',
			'addthis'         => 'wpgrade_callback_addthis_script',
		),

		// auto invoke styles previously registered on theme setup
		'auto-enqueue-styles'     => array
		(
			'google-webfonts',
			'wpgrade-main-style',
		),

		// calls function to perform extra enqueue's on theme setup
		// handlers should be placed in theme's functions.php
		'style-enqueue-handlers'  => array
		(
//						'dynamic-css' => array
//							(
//								'handler' => 'wpgrade_callback_enqueue_dynamic_css_old',
//								'priority' => 9999,
//							),
			'rtl-support' => 'wpgrade_callback_enqueue_rtl_support',
		),

	), # end resource

	// defaults for pagination; you may customize the values at any time
	// when invoking a pagination formatter, the following defaults will be
	// in effect if not overwritten
	'pagination'         => array
	(
		// formatter to process the links; null if none needed
		// the formatter should return a string and accept links and
		// the resulting configuration
		'formatter'     => 'wpgrade_callback_pagination_formatter',

		// show prev/next links?
		'prev_next'     => true,

		// pagination text
		'prev_text'     => esc_html__( 'Newer posts', 'lens' ),
		'next_text'     => esc_html__( 'Older posts', 'lens' ),

		// are the terms used for paging relative to the sort order?
		// ie. older/newer instead of sorting agnostic previous/next
		'sorted_paging' => false,

		// the order of the posts (asc or desc); if asc is passed and
		// sorted_paging is true the values of prev_text and next_text
		// will be flipped
		'order'         => 'desc',

		// show all pages? (ie. no cutoffs)
		'show_all'      => false,

		// how many numbers on either the start and the end list edges
		'end_size'      => 1,

		// how many numbers to either side of current page
		// not including current page
		'mid_size'      => 2,

		// an array of query args to add
		'add_args'      => false,

		// a string to append to each link
		'add_fragment'  => null,
	),

	// allows you to create special pagination instances by providing a key
	// to wpgrade::pagination; the settings defined in the key will be used
	// to overwrite the defaults defined in pagination above; if the key
	// is not avilable the pagination system will ignore the request so you
	// can use the template names while developing and customize at any
	// time later
	'pagination-targets' => array
	(
		// the following is an example
		'gallery'   => array
		(
			'formatter' => null,
			'prev_text' => esc_html__( 'Prev Images', 'lens' ),
			'next_text' => esc_html__( 'Next Images', 'lens' ),
		),
		'galleries' => array
		(
			'formatter' => 'wpgrade_callback_pagination_formatter',
			'prev_text' => esc_html__( 'Prev', 'lens' ),
			'next_text' => esc_html__( 'Next', 'lens' ),
		),
		'portfolio' => array
		(
			'formatter' => 'wpgrade_callback_pagination_formatter',
			'prev_text' => esc_html__( 'Prev', 'lens' ),
			'next_text' => esc_html__( 'Next', 'lens' ),
		),
	),

); # end theme configuration

return $config;
