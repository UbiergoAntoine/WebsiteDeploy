<?php


// theme activation
function wpgrade_callback_geting_active() {

	// Lens really needs these settings off
	update_option( 'shop_catalog_image_size', array( 800, null, 0 ) ); // Product category thumbs
	update_option( 'shop_single_image_size', array( 800, null, 0 ) ); // Single product image
	update_option( 'shop_thumbnail_image_size', array( 800, null, 0 ) );

	update_option( 'woocommerce_enable_lightbox', 'no' );

	/**
	 * Create custom post types, taxonomies and metaboxes
	 * These will be taken by pixtypes plugin and converted in their own options
	 */
	$types_options = get_option( 'pixtypes_themes_settings' );
	if ( empty( $types_options ) ) {
		$types_options = array();
	}
	$theme_key                                   = wpgrade::shortname() . '_pixtypes_theme';
	$types_options[ $theme_key ]                 = array();
	$types_options[ $theme_key ][ 'post_types' ] = array(
		'lens_portfolio' => array(
			'labels'        => array(
				'name'               => esc_html__( 'Project', 'lens' ),
				'singular_name'      => esc_html__( 'Project', 'lens' ),
				'add_new'            => esc_html__( 'Add New', 'lens' ),
				'add_new_item'       => esc_html__( 'Add New Project', 'lens' ),
				'edit_item'          => esc_html__( 'Edit Project', 'lens' ),
				'new_item'           => esc_html__( 'New Project', 'lens' ),
				'all_items'          => esc_html__( 'All Projects', 'lens' ),
				'view_item'          => esc_html__( 'View Project', 'lens' ),
				'search_items'       => esc_html__( 'Search Projects', 'lens' ),
				'not_found'          => esc_html__( 'No Project found', 'lens' ),
				'not_found_in_trash' => esc_html__( 'No Project found in Trash', 'lens' ),
				'menu_name'          => esc_html__( 'Projects', 'lens' ),
			),
			'public'        => true,
			'rewrite'       => array(
				'slug'       => 'lens_portfolio',
				'with_front' => false,
			),
			'has_archive'   => 'portfolio-archive',
			'menu_icon'     => 'report.png',
			'menu_position' => null,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'comments' ),
			'yarpp_support' => true,
		),
		'lens_gallery'   => array(
			'labels'        => array(
				'name'               => esc_html__( 'Gallery', 'lens' ),
				'singular_name'      => esc_html__( 'Gallery', 'lens' ),
				'add_new'            => esc_html__( 'Add New', 'lens' ),
				'add_new_item'       => esc_html__( 'Add New Gallery', 'lens' ),
				'edit_item'          => esc_html__( 'Edit Gallery', 'lens' ),
				'new_item'           => esc_html__( 'New Gallery', 'lens' ),
				'all_items'          => esc_html__( 'All Galleries', 'lens' ),
				'view_item'          => esc_html__( 'View Gallery', 'lens' ),
				'search_items'       => esc_html__( 'Search Galleries', 'lens' ),
				'not_found'          => esc_html__( 'No Gallery found', 'lens' ),
				'not_found_in_trash' => esc_html__( 'No Gallery found in Trash', 'lens' ),
				'menu_name'          => esc_html__( 'Galleries', 'lens' ),
			),
			'public'        => true,
			'rewrite'       => array(
				'slug'       => 'lens_galleries',
				'with_front' => false,
			),
			'has_archive'   => 'galleries-archive',
			'menu_icon'     => 'slider.png',
			'menu_position' => null,
			'supports'      => array( 'title', 'thumbnail', 'page-attributes', 'excerpt' ),
			'yarpp_support' => true,
		),
	);
	$types_options[ $theme_key ][ 'taxonomies' ] = array(
		'lens_portfolio_categories' => array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Portfolio Categories', 'lens' ),
				'singular_name'     => esc_html__( 'Portfolio Category', 'lens' ),
				'search_items'      => esc_html__( 'Search Portfolio Category', 'lens' ),
				'all_items'         => esc_html__( 'All Portfolio Categories', 'lens' ),
				'parent_item'       => esc_html__( 'Parent Portfolio Category', 'lens' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Category: ', 'lens' ),
				'edit_item'         => esc_html__( 'Edit Portfolio Category', 'lens' ),
				'update_item'       => esc_html__( 'Update Portfolio Category', 'lens' ),
				'add_new_item'      => esc_html__( 'Add New Portfolio Category', 'lens' ),
				'new_item_name'     => esc_html__( 'New Portfolio Category Name', 'lens' ),
				'menu_name'         => esc_html__( 'Portfolio Categories', 'lens' ),
			),
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'portfolio-category', 'with_front' => false ),
			'sort'              => true,
			'post_types'        => array( 'lens_portfolio' )
		),
		'lens_gallery_categories'   => array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Gallery Categories', 'lens' ),
				'singular_name'     => esc_html__( 'Gallery Category', 'lens' ),
				'search_items'      => esc_html__( 'Search Gallery Category', 'lens' ),
				'all_items'         => esc_html__( 'All Gallery Categories', 'lens' ),
				'parent_item'       => esc_html__( 'Parent Gallery Category', 'lens' ),
				'parent_item_colon' => esc_html__( 'Parent Gallery Category: ', 'lens' ),
				'edit_item'         => esc_html__( 'Edit Gallery Category', 'lens' ),
				'update_item'       => esc_html__( 'Update Gallery Category', 'lens' ),
				'add_new_item'      => esc_html__( 'Add New Gallery Category', 'lens' ),
				'new_item_name'     => esc_html__( 'New Gallery Category Name', 'lens' ),
				'menu_name'         => esc_html__( 'Gallery Categories', 'lens' ),
			),
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'gallery-category', 'with_front' => false ),
			'sort'              => true,
			'post_types'        => array( 'lens_gallery' )
		),
	);
	$types_options[ $theme_key ][ 'metaboxes' ]  = array(
		'post_video_format'       => array(
			'id'         => 'post_format_metabox_video',
			'title'      => esc_html__( 'Video Settings', 'lens' ),
			'pages'      => array( 'post' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => esc_html__( 'Embed Code', 'lens' ),
					'desc' => esc_html__( 'Enter here a Youtube, Vimeo (or other online video services) embed code here. The width should be a minimum of 640px. We will use this if filled, not the selfhosted options bellow!', 'lens' ),
					'id'   => wpgrade::prefix() . 'video_embed',
					'type' => 'textarea_small',
					'std'  => '',
				),
			)
		),
		'post_gallery_format'     => array(
			'id'         => 'post_format_metabox_gallery',
			'title'      => esc_html__( 'Gallery Settings', 'lens' ),
			'pages'      => array( 'post' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => esc_html__( 'Images', 'lens' ),
					'id'   => wpgrade::prefix() . 'main_gallery',
					'type' => 'gallery',
				),
				array(
					'name'    => esc_html__( 'Image Scaling', 'lens' ),
					'desc'    => __( '<p class="cmb_metabox_description"><strong>Fill</strong> scales image to completely fill slider container (recommended for landscape images)</p>
<p class="cmb_metabox_description"><strong>Fit</strong> scales image to fit the container (recommended for portrait images)</p>
<p class="cmb_metabox_description"><strong>Fit if Smaller</strong> scales image to fit only if size of slider container is less than size of image.</p>
<p class="cmb_metabox_description"><a target="_blank" href="http://bit.ly/slider-image-scaling">Visual explanation</a></p>', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_image_scale_mode',
					'type'    => 'select',
					'show_on' => array(
						'key'   => 'select_value',
						'value' => array(
							'project_template' => array( 'fullwidth', 'sidebar' ),
						),
					),
					'options' => array(
						array(
							'name'  => esc_html__( 'Fit', 'lens' ),
							'value' => 'fit'
						),
						array(
							'name'  => esc_html__( 'Fill', 'lens' ),
							'value' => 'fill'
						),
						array(
							'name'  => esc_html__( 'Fit if Smaller', 'lens' ),
							'value' => 'fit-if-smaller'
						)
					),
					'std'     => 'fill'
				),
				array(
					'name'    => esc_html__( 'Show Nearby Images', 'lens' ),
					'desc'    => esc_html__( 'Enable this if you want to avoid having empty space on the sides of the image when using mostly portrait images.', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_slider_visiblenearby',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => 'true'
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => 'false'
						)
					),
					'std'     => false
				),
				array(
					'name'    => esc_html__( 'Slider transition', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_slider_transition',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Slide/Move', 'lens' ),
							'value' => 'move'
						),
						array(
							'name'  => esc_html__( 'Fade', 'lens' ),
							'value' => 'fade'
						)
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'post_slider_visiblenearby',
							'value' => 'false',
						)
					),
					'std'     => 'move'
				),
				array(
					'name'    => esc_html__( 'Slider autoplay', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_slider_autoplay',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => true
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => false
						)
					),
					'std'     => false
				),
				array(
					'name' => esc_html__( 'Autoplay delay between slides (in milliseconds)', 'lens' ),
					'id'   => wpgrade::prefix() . 'post_slider_delay',
					'type' => 'text_small',
					'std'  => '1000',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'post_slider_autoplay',
							'value' => true
						)
					),
				)
			)
		),
		'post_quote_format'       => array(
			'id'         => 'post_format_metabox_quote',
			'title'      => esc_html__( 'Quote Settings', 'lens' ),
			'pages'      => array( 'post' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => esc_html__( 'Quote Content', 'lens' ),
					'desc'    => esc_html__( 'Please type the text of your quote here.', 'lens' ),
					'id'      => wpgrade::prefix() . 'quote',
					'type'    => 'wysiwyg',
					'std'     => '',
					'options' => array(
						'textarea_rows' => 4,
					),
				),
				array(
					'name' => esc_html__( 'Author Name', 'lens' ),
					'desc' => '',
					'id'   => wpgrade::prefix() . 'quote_author',
					'type' => 'text',
					'std'  => '',
				),
				array(
					'name' => esc_html__( 'Author Title', 'lens' ),
					'desc' => '',
					'id'   => wpgrade::prefix() . 'quote_author_title',
					'type' => 'text',
					'std'  => '',
				),
				array(
					'name' => esc_html__( 'Author Link', 'lens' ),
					'desc' => esc_html__( 'Insert here an url if you want the author name to be linked to that address.', 'lens' ),
					'id'   => wpgrade::prefix() . 'quote_author_link',
					'type' => 'text',
					'std'  => '',
				),
			)
		),
		'post_audio_format'       => array(
			'id'         => 'post_format_metabox_audio',
			'title'      => esc_html__( 'Audio Settings', 'lens' ),
			'pages'      => array( 'post' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => esc_html__( 'Embed Code', 'lens' ),
					'desc' => esc_html__( 'Enter here a embed code here. The width should be a minimum of 640px.', 'lens' ),
					'id'   => wpgrade::prefix() . 'audio_embed',
					'type' => 'textarea_small',
					'std'  => '',
				),
				array(
					'name' => esc_html__( 'MP3 File URL', 'lens' ),
					'desc' => esc_html__( 'Please enter in the URL to the .mp3 file', 'lens' ),
					'id'   => wpgrade::prefix() . 'audio_mp3',
					'type' => 'file',
					'std'  => ''
				),
				array(
					'name' => esc_html__( 'M4A File URL', 'lens' ),
					'desc' => esc_html__( 'Please enter in the URL to the .m4a file', 'lens' ),
					'id'   => wpgrade::prefix() . 'audio_m4a',
					'type' => 'file',
					'std'  => ''
				),
				array(
					'name' => esc_html__( 'OGA File URL', 'lens' ),
					'desc' => esc_html__( 'Please enter in the URL to the .ogg or .oga file', 'lens' ),
					'id'   => wpgrade::prefix() . 'audio_ogg',
					'type' => 'file',
					'std'  => ''
				),
				array(
					'name' => esc_html__( 'Poster Image', 'lens' ),
					'desc' => esc_html__( 'This will be the image displayed above the audio controls. The image should be at least 640px wide. Click the "Upload" button to open the Media Manager, and click "Use as Poster Image" once you have uploaded or chosen an image from the media library.', 'lens' ),
					'id'   => wpgrade::prefix() . 'audio_poster',
					'type' => 'file',
					'std'  => ''
				),
			)
		),
		'lens_portfolio_gallery'  => array(
			'id'         => 'portfolio_gallery',
			'title'      => esc_html__( 'Gallery', 'lens' ),
			'pages'      => array( 'lens_portfolio' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'   => esc_html__( 'Images', 'lens' ),
					'id'     => wpgrade::prefix() . 'portfolio_gallery',
					'type'   => 'gallery',
					'hidden' => true,
				),
			)
		),
		//		'lens_portfolio_video' => array(
		//			'id' => 'portfolio_video',
		//			'title' => esc_html__('Video Settings (optional)', 'lens'),
		//			'pages'      => array( 'lens_portfolio' ), // Post type
		//			'context'    => 'normal',
		//			'priority'   => 'high',
		//			'show_names' => true, // Show field names on the left
		//			'fields' => array(
		//				array(
		//					'name' => esc_html__('Video Image', 'lens'),
		//					'desc' => esc_html__('Choose an image for your video.', 'lens'),
		//					'id' => wpgrade::prefix() . 'portfolio_video_image',
		//					'type' => 'attachment',
		//					'std' => '',
		//				),
		//				array(
		//					'name' => esc_html__('YouTube Embed Code', 'lens'),
		//					'desc' => esc_html__('Enter here a YouTube embed code. This video will be shown as one of the gallery items (first by default).', 'lens'),
		//					'id' => wpgrade::prefix() . 'portfolio_video_youtube',
		//					'type' => 'textarea_small',
		//					'std' => '',
		//				),
		//				array(
		//					'name' => esc_html__('Vimeo Embed Code', 'lens'),
		//					'desc' => __('Enter here a Vimeo embed code. This video will be shown as one of the gallery items (first by default).<br /><i>If you have entered a YouTube video link, this will be ignored!</i>', 'lens'),
		//					'id' => wpgrade::prefix() . 'portfolio_video_vimeo',
		//					'type' => 'textarea_small',
		//					'std' => '',
		//				),
		//			)
		//		),
		'lens_portfolio_metadata' => array(
			'id'         => 'portfolio_metadata',
			'title'      => esc_html__( 'Project Details', 'lens' ),
			'pages'      => array( 'lens_portfolio' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => esc_html__( 'Client Name', 'lens' ),
					'id'   => wpgrade::prefix() . 'portfolio_client_name',
					'type' => 'text_medium',
				),
				array(
					'name' => esc_html__( 'Client Link', 'lens' ),
					'id'   => wpgrade::prefix() . 'portfolio_client_link',
					'type' => 'text_medium',
				),
				array(
					'name'    => esc_html__( 'Template Style', 'lens' ),
					'desc'    => esc_html__( 'Select the template you want for this project.', 'lens' ),
					'id'      => wpgrade::prefix() . 'project_template',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Full Width Slider', 'lens' ),
							'value' => 'fullwidth'
						),
						array(
							'name'  => esc_html__( 'Sidebar Right', 'lens' ),
							'value' => 'sidebar'
						),
						array(
							'name'  => esc_html__( 'Classic', 'lens' ),
							'value' => 'classic'
						),
					),
					'std'     => 'fullwidth',
				),
				array(
					'name'    => esc_html__( 'Image Scaling', 'lens' ),
					'desc'    => __( '<p class="cmb_metabox_description"><strong>Fill</strong> scales image to completely fill slider container (recommended for landscape images)</p>
<p class="cmb_metabox_description"><strong>Fit</strong> scales image to fit the container (recommended for portrait images)</p>
<p class="cmb_metabox_description"><strong>Fit if Smaller</strong> scales image to fit only if size of slider container is less than size of image.</p>
<p class="cmb_metabox_description"><strong>Auto Height</strong> scales the container to fit the full size image.</p>
<p class="cmb_metabox_description"><a target="_blank" href="http://bit.ly/slider-image-scaling">Visual explanation</a></p>', 'lens' ),
					'id'      => wpgrade::prefix() . 'portfolio_image_scale_mode',
					'type'    => 'select',
					'show_on' => array(
						'key'   => 'select_value',
						'value' => array(
							'project_template' => array( 'sidebar', 'fullwidth' ),
						),
					),
					'options' => array(
						array(
							'name'  => esc_html__( 'Fit', 'lens' ),
							'value' => 'fit'
						),
						array(
							'name'  => esc_html__( 'Fill', 'lens' ),
							'value' => 'fill'
						),
						array(
							'name'  => esc_html__( 'Fit if Smaller', 'lens' ),
							'value' => 'fit-if-smaller'
						),
						array(
							'name'  => esc_html__( 'Auto Height', 'lens' ),
							'value' => 'auto'
						),
					),
					'std'     => 'fill'
				),
				array(
					'name'    => esc_html__( 'Show Nearby Images', 'lens' ),
					'desc'    => esc_html__( 'Enable this if you want to avoid having empty space on the sides of the image when using mostly portrait images.', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_slider_visiblenearby',
					'type'    => 'select',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'project_template',
							'value' => array('fullwidth')
						)
					),
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => 'true'
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => 'false'
						)
					),
					'std'     => false
				),
				array(
					'name'    => esc_html__( 'Slider transition', 'lens' ),
					'id'      => wpgrade::prefix() . 'portfolio_slider_transition',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Slide/Move', 'lens' ),
							'value' => 'move'
						),
						array(
							'name'  => esc_html__( 'Fade', 'lens' ),
							'value' => 'fade'
						)
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'post_slider_visiblenearby',
							'value' => 'false',
						)
					),
					'std'     => 'move'
				),
				array(
					'name'    => esc_html__( 'Slider autoplay', 'lens' ),
					'id'      => wpgrade::prefix() . 'portfolio_slider_autoplay',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => true
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => false
						)
					),
					'std'     => false
				),
				array(
					'name' => esc_html__( 'Autoplay delay between slides (in milliseconds)', 'lens' ),
					'id'   => wpgrade::prefix() . 'portfolio_slider_delay',
					'type' => 'text_small',
					'std'  => '1000',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'portfolio_slider_autoplay',
							'value' => true
						)
					),
				),
				array(
					'name'    => esc_html__( 'Exclude From Archives', 'lens' ),
					'desc'    => esc_html__( 'Exclude this project from portfolio archives.', 'lens' ),
					'id'      => wpgrade::prefix() . 'exclude_project',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'No', 'lens' ),
							'value' => false
						),
						array(
							'name'  => esc_html__( 'Yes', 'lens' ),
							'value' => true
						)
					),
					'std'     => false
				),
			)
		),
		'lens_gallery'            => array(
			'id'         => 'lens_gallery',
			'title'      => esc_html__( 'Gallery Details', 'lens' ),
			'pages'      => array( 'lens_gallery' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => esc_html__( 'Images', 'lens' ),
					'id'   => wpgrade::prefix() . 'main_gallery',
					'type' => 'gallery',
				),
				array(
					'name'    => esc_html__( 'Template Style', 'lens' ),
					'id'      => wpgrade::prefix() . 'gallery_template',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Grid Thumbnails', 'lens' ),
							'value' => 'masonry'
						),
						array(
							'name'  => esc_html__( 'Masonry Thumbnails', 'lens' ),
							'value' => 'masonry-plus'
						),
						array(
							'name'  => esc_html__( 'Full Width Slider', 'lens' ),
							'value' => 'fullwidth'
						),
						array(
							'name'  => esc_html__( 'Full Screen Slider', 'lens' ),
							'value' => 'fullscreen'
						)
					),
					'std'     => 'fullwidth',
				),
				array(
					'name'    => esc_html__( 'Image Scaling', 'lens' ),
					'desc'    => __( '<p class="cmb_metabox_description"><strong>Fill</strong> scales image to completely fill slider container (recommended for landscape images)</p>
<p class="cmb_metabox_description"><strong>Fit</strong> scales image to fit the container (recommended for portrait images)</p>
<p class="cmb_metabox_description"><strong>Fit if Smaller</strong> scales image to fit only if size of slider container is less than size of image.</p>
<p class="cmb_metabox_description"><a target="_blank" href="http://bit.ly/slider-image-scaling">Visual explanation</a></p>', 'lens' ),
					'id'      => wpgrade::prefix() . 'gallery_image_scale_mode',
					'type'    => 'select',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'gallery_template',
							'value' => array('fullwidth', 'fullscreen', 'sidebar')
						)
					),
					'options' => array(
						array(
							'name'  => esc_html__( 'Fit', 'lens' ),
							'value' => 'fit'
						),
						array(
							'name'  => esc_html__( 'Fill', 'lens' ),
							'value' => 'fill'
						),
						array(
							'name'  => esc_html__( 'Fit if Smaller', 'lens' ),
							'value' => 'fit-if-smaller'
						),
					),
					'std'     => 'fill'
				),
				array(
					'name'    => esc_html__( 'Show Nearby Images', 'lens' ),
					'desc'    => esc_html__( 'Enable this if you want to avoid having empty space on the sides of the image when using mostly portrait images.', 'lens' ),
					'id'      => wpgrade::prefix() . 'post_slider_visiblenearby',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'gallery_template',
							'value' => array('fullwidth', 'fullscreen')
						)
					),
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => 'true'
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => 'false'
						)
					),
					'std'     => false
				),
				array(
					'name'    => esc_html__( 'Slider transition', 'lens' ),
					'id'      => wpgrade::prefix() . 'gallery_slider_transition',
					'show_on' => array(
						'key' => 'select_value',
						'value' => array( 'gallery_template' => 'grid' )
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'post_slider_visiblenearby',
							'value' => 'false',
						)
					),
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Slide/Move', 'lens' ),
							'value' => 'move'
						),
						array(
							'name'  => esc_html__( 'Fade', 'lens' ),
							'value' => 'fade'
						)
					),
					'std'     => 'move'
				),
				array(
					'name'    => esc_html__( 'Slider autoplay', 'lens' ),
					'id'      => wpgrade::prefix() . 'gallery_slider_autoplay',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'gallery_template',
							'value' => array('fullwidth', 'fullscreen')
						)
					),
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Enabled', 'lens' ),
							'value' => true
						),
						array(
							'name'  => esc_html__( 'Disabled', 'lens' ),
							'value' => false
						)
					),
					'std'     => false
				),
				array(
					'name'    => esc_html__( 'Autoplay delay between slides (in milliseconds)', 'lens' ),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'gallery_slider_autoplay',
							'value' => true
						)
					),
					'id'      => wpgrade::prefix() . 'gallery_slider_delay',
					'type'    => 'text_small',
					'std'     => '1000'
				),
				array(
					'name'    => esc_html__( 'Grid Thumbnails Orientation', 'lens' ),
					'id'      => wpgrade::prefix() . 'thumb_orientation',
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'gallery_template',
							'value' => array('masonry')
						)
					),
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Landscape', 'lens' ),
							'value' => 'landscape'
						),
						array(
							'name'  => esc_html__( 'Portrait', 'lens' ),
							'value' => 'portrait'
						)
					),
					'std'     => 'landscape'
				),
				array(
					'name'    => esc_html__( 'Gallery Title Box', 'lens' ),
					'desc'    => esc_html__( 'Show the title of the gallery in a thumbnail box or not.', 'lens' ),
					'id'      => wpgrade::prefix() . 'show_gallery_title',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Show', 'lens' ),
							'value' => true
						),
						array(
							'name'  => esc_html__( 'Hide', 'lens' ),
							'value' => false
						)
					),
					'std'     => false
				),
				array(
					'name'    => esc_html__( 'Exclude From Archives', 'lens' ),
					'desc'    => esc_html__( 'Exclude this gallery from galleries archives.', 'lens' ),
					'id'      => wpgrade::prefix() . 'exclude_gallery',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'No', 'lens' ),
							'value' => false
						),
						array(
							'name'  => esc_html__( 'Yes', 'lens' ),
							'value' => true
						)
					),
					'std'     => false
				),
			)
		),
		'lens_homepage_chooser'   => array(
			'id'         => 'lens_homepage_chooser',
			'title'      => esc_html__( 'Choose Your Home Page', 'lens' ),
			'pages'      => array( 'page' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_on'    => array( 'key' => 'page-template', 'value' => array( 'template-homepage.php' ), ),
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => esc_html__( 'Choose:', 'lens' ),
					'desc'    => esc_html__( 'Select what would you like to be your home page. If you want to have a static page as your homepage simply go the WP classic way and set it up in Settings > Reading (instead of this one).', 'lens' ),
					'id'      => wpgrade::prefix() . 'custom_homepage',
					'type'    => 'radio',
					'options' => array(
						array(
							'name'  => esc_html__( 'Portfolio Archive', 'lens' ),
							'value' => wpgrade::shortname() . '_portfolio',
						),
						array(
							'name'  => esc_html__( 'Portfolio Category', 'lens' ),
							'value' => wpgrade::shortname() . '_portfolio_cat',
						),
						array(
							'name'  => esc_html__( 'Project', 'lens' ),
							'value' => wpgrade::shortname() . '_project',
						),
						array(
							'name'  => esc_html__( 'Galleries Archive', 'lens' ),
							'value' => wpgrade::shortname() . '_galleries_archive',
						),
						array(
							'name'  => esc_html__( 'Galleries Category', 'lens' ),
							'value' => wpgrade::shortname() . '_galleries_cat',
						),
						array(
							'name'  => esc_html__( 'Gallery', 'lens' ),
							'value' => wpgrade::shortname() . '_gallery',
						),
					),
					'std'     => 'lens_portfolio',
				),
				array(
					'name'       => esc_html__( 'Select a portfolio category', 'lens' ),
					'desc'       => esc_html__( 'Select a portfolio category and we will show it on your homepage.', 'lens' ),
					'id'         => wpgrade::prefix() . 'homepage_portfolio_category',
					'type'       => 'select_cpt_term',
					'taxonomy'   => 'lens_portfolio_categories',
					'options'    => array( //						'hidden' => true,
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'custom_homepage',
							'value' => wpgrade::shortname() . '_portfolio_cat'
						)
					),
				),
				array(
					'name'       => esc_html__( 'Select a project', 'lens' ),
					'desc'       => esc_html__( 'Select a project and we will show it on your homepage.', 'lens' ),
					'id'         => wpgrade::prefix() . 'homepage_project',
					'type'       => 'select_cpt_post',
					'options'    => array(
						'args' => array(
							'post_type' => wpgrade::shortname() . '_portfolio',
						),
						//'hidden' => true,
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'custom_homepage',
							'value' => wpgrade::shortname() . '_project'
						)
					),
				),
				array(
					'name'       => esc_html__( 'Select a galleries category', 'lens' ),
					'desc'       => esc_html__( 'Select a galleries category and we will show it on your homepage.', 'lens' ),
					'id'         => wpgrade::prefix() . 'homepage_galleries_category',
					'type'       => 'select_cpt_term',
					'taxonomy'   => 'lens_gallery_categories',
					'options'    => array( //						'hidden' => true,
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'custom_homepage',
							'value' => wpgrade::shortname() . '_galleries_cat'
						)
					),
				),
				array(
					'name'       => esc_html__( 'Select a gallery', 'lens' ),
					'desc'       => esc_html__( 'Select a gallery and we will show it on your homepage.', 'lens' ),
					'id'         => wpgrade::prefix() . 'homepage_gallery',
					'type'       => 'select_cpt_post',
					'options'    => array(
						'args' => array(
							'post_type' => 'lens_gallery',
						),
						//						'hidden' => true,
					),
					'display_on' => array(
						'display' => true,
						'on'      => array(
							'field' => wpgrade::prefix() . 'custom_homepage',
							'value' => wpgrade::shortname() . '_gallery'
						)
					),
				),
				array(
					'name' => esc_html__( 'Number of items', 'lens' ),
					'desc' => esc_html__( 'Select a number of items (projects or galleries) to show on your homepage. For unlimited items keep it empty', 'lens' ),
					'id'   => wpgrade::prefix() . 'homepage_projects_number',
					'type' => 'text_small',
				)
			)
		),
	);

	update_option( 'pixtypes_themes_settings', $types_options );

	// prepare yarpp
	$current_yarpp = get_option( 'yarpp' );

	if ( empty( $current_yarpp ) ) {

		$plugins_url   = plugins_url();
		$yarp_settings = array(
			'threshold'                 => '4',
			'limit'                     => '6',
			'excerpt_length'            => '10',
			'recent'                    => false,
			'before_title'              => '<li>',
			'after_title'               => '</li>',
			'before_post'               => ' <small>',
			'after_post'                => '</small>',
			'before_related'            => '<h3>Related posts:</h3><ol>',
			'after_related'             => '</ol>',
			'no_results'                => '<p>No related posts.</p>',
			'order'                     => 'score DESC',
			'rss_limit'                 => '3',
			'rss_excerpt_length'        => '10',
			'rss_before_title'          => '<li>',
			'rss_after_title'           => '</li>',
			'rss_before_post'           => ' <small>',
			'rss_after_post'            => '</small>',
			'rss_before_related'        => '<h3>Related posts:</h3><ol>',
			'rss_after_related'         => '</ol>',
			'rss_no_results'            => '<p>No related posts.</p>',
			'rss_order'                 => 'score DESC',
			'past_only'                 => false,
			'show_excerpt'              => false,
			'rss_show_excerpt'          => false,
			'template'                  => 'yarpp-template-portfolio.php',
			'rss_template'              => false,
			'show_pass_post'            => false,
			'cross_relate'              => false,
			'rss_display'               => false,
			'rss_excerpt_display'       => true,
			'promote_yarpp'             => false,
			'rss_promote_yarpp'         => false,
			'myisam_override'           => false,
			'exclude'                   => '',
			'weight'                    => array(
				'title' => 1,
				'body'  => 1,
				'tax'   => array(
					'category' => 1,
					'post_tag' => 1,
				),
			),
			'require_tax'               => array(),
			'optin'                     => true,
			'thumbnails_heading'        => 'Related posts:',
			'thumbnails_default'        => $plugins_url . '/yet-another-related-posts-plugin/default.png',
			'rss_thumbnails_heading'    => 'Related posts:',
			'rss_thumbnails_default'    => $plugins_url . '/yet-another-related-posts-plugin/default.png',
			'display_code'              => false,
			'auto_display_archive'      => false,
			'auto_display_post_types'   => array(),
			'pools'                     => array(),
			'manually_using_thumbnails' => false,
		);

		update_option( 'yarpp', $yarp_settings );
	}
	// flush permalinks rules on theme activation
	//		flush_rewrite_rules();
	//		global $wp_rewrite;
	//		$wp_rewrite->generate_rewrite_rules();
	//		flush_rewrite_rules();

	/**
	 * http://wordpress.stackexchange.com/questions/36152/flush-rewrite-rules-not-working-on-plugin-deactivation-invalid-urls-not-showing
	 * nothing from above works in plugin so ...
	 */
	delete_option( 'rewrite_rules' );
}

add_action( 'after_switch_theme', 'wpgrade_callback_geting_active' );
