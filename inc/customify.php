<?php

if ( ! function_exists( 'add_customify_lens_options' ) ) {
	function add_customify_lens_options( $config ) {

		$config['opt-name'] = 'lens_options';

		$config['sections'] = array(
			'colors_section'      => array(
				'title'       => '&#x1f3a8; ' . esc_html__( 'Colors', 'lens' ),
				'priority'    => 1,
				'description' => esc_html__( 'Use the color picker to change the main color of the site to match your brand color. If you want to override the color of some elements you can always use CSS editor panel.', 'lens' ),
				'options'     => array(
					'main_color'     => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Main Color', 'lens' ),
						//'desc'   => esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'lens' ),
						'live'    => true,
						'default' => '#fffc00',
						'css'     => array(
							array(
								'property' => 'color',
								'selector' => '.inverse a,
										.highlighted,
										blockquote:before,
										.emphasized:before,
										.site-navigation--main .menu-item:hover > a,
										.site-navigation--main .menu-item:focus > a,
										.site-navigation--main .menu-item:active > a,
										.site-navigation--main .menu-item.current-menu-item > a,
										.site-navigation--main .menu-item.current-menu-ancestor > a,
										.site-navigation--main .menu-item.current-menu-parent > a,
										.mosaic__filter-item.active, .mosaic__filter-item:hover,
										.complete i,
										.liked i,
										.article-timestamp--single .article-timestamp__date,
										a:hover > i.pixcode--icon,
										.btn:hover, .wpcf7-submit:hover, .form-submit #comment-submit:hover,
										.woocommerce #page .button:hover,
										.widget--header a:hover,
										a.site-home-link, .site-navigation--mobile .menu-item:hover > a,
										.site-navigation--mobile .menu-item.current-menu-ancestor > a,
										.site-navigation--mobile .menu-item.current-menu-parent > a,
										.site-navigation--mobile .menu-item.current-menu-item > a,
										.cart--widget .cart-link:hover,
										.mosaic__pagination .prev:hover, .mosaic__pagination .next:hover,
										.sidebar--header .form-search .btn:hover,
										.site-social-links a:hover:before,
										.woocommerce #page .button:hover',
							),
							array(
								'property' => 'background-color',
								'selector' => '.rsNavSelected,
										.pin_ring--outer,
										.liked i,
										.btn, .wpcf7-submit, .form-submit #comment-submit,
										.woocommerce #page .button,
										.progressbar__progress,
										.rsNavSelected,
										.product__badge, .cart--widget .cart__btn .cart-size,
										.woocommerce-page .woocommerce-message .pixcode--icon,
										.woocommerce-page .woocommerce-info .pixcode--icon,
										.pixproof-lens-gallery .proof-photo.selected .background-container',
							),
							array(
								'property' => 'background-color',
								'selector' => '.article--product:hover .product__container,
												.image__item-meta, .mfp-video:hover .image__item-meta, .external_url:hover .image__item-meta,
												.touch .mosaic__item--page-title .image__item-meta,
												.touch .mosaic__item--page-title-mobile .image__item-meta,
												.team-member__profile',
								'callback_filter' => 'lens_field_with_07rgba_value',
							),
							array(
								'property' => 'background-image',
								'selector' => '.header:before',
								'callback_filter' => 'lens_header_gradient_value',
							),
							array(
								'property' => 'border-color',
								'selector' => '.loading .pace .pace-activity, .no-touch .arrow-button:hover',
							),
							array(
								'property' => 'border-top-color',
								'selector' => '.site-navigation--main .menu-item.current-menu-item:after,
										.site-navigation--main .menu-item.current-menu-ancestor:after,
										.site-navigation--main .menu-item.current-menu-parent:after,
										.site-navigation--main .menu-item:hover:after,
										.site-navigation--main .menu-item:focus:after,
										.site-navigation--main .menu-item:active:after,
										.site-navigation--mobile .menu-item.current-menu-parent:after,
										.site-navigation--mobile .menu-item:hover:after,
										.site-navigation--mobile .menu-item:focus:after,
										.site-navigation--mobile .menu-item:active:after'
							)
						)
					),
					'text_color'     => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Text Color', 'lens' ),
						'live'    => true,
						'default' => '#515150',
						'css'     => array(
							array(
								'property' => 'color',
								'selector' => 'body, .up-link, .testimonial__author-name, .testimonial__author-title,
									 ol li, .search-query, button'
							),
							array(
								'property' => 'border-color',
								'selector' => '.up-link:before'
							),
						)
					),
					'headings_color' => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Headings Color', 'lens' ),
						'live'    => true,
						'default' => '#262526',
						'css'     => array(
							array(
								'property' => 'color',
								'selector' => 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
									.article-archive .article__title a, .article-archive .article__title a:hover,
									.entry__title, .testimonial__content, .single-portfolio-fullwidth .entry__title,
									.entry__content h1, .entry__content h2, .entry__content h3',
							)
						)
					),

					'content_background_color' => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Content Background Color', 'lens' ),
						'live'    => true,
						'default' => '#ffffff',
						'css'     => array(
							array(
								'property' => 'background-color',
								'selector' => 'body:not(.blog), .masonry article:not(.article--product)',
							)
						)
					),

					'container_image_pattern' => array(
						'type'  => 'custom_background',
						'label' => esc_html__( 'Container Background', 'lens' ),
						'output'           => array( ".content, .loaded .masonry, html" ),
					),

					'header_background_color' => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Sidebar Background Color', 'lens' ),
						'live'    => true,
						'default' => '#242423',
						'css'     => array(
							array(
								'property' => 'background-color',
								'selector' => '.header, .navigation--mobile',
							),
							array(
								'property' => 'background-image',
								'selector' => '.header:after',
								'callback_filter' => 'lens_header_secondary_gradient_value',
							)
						)
					),

					'header_image_pattern'    => array(
						'type'  => 'custom_background',
						// 'label' => esc_html__( 'Header Background', 'lens' ),
						'output'           => array( '.header' ),
					),

					'header_inverse' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Inverse Sidebar Contrast', 'lens' ),
						'desc'    => esc_html__( 'Change the left sidebar contrast to black text on white background.', 'lens' ),
						'default' => '0',
					),
				)
			),

			/**
			 * FONTS - This section will handle different elements fonts (eg. headings, body)
			 */
			'typography_section'  => array(
				'title'    => '&#x1f4dd; ' . esc_html__( 'Fonts', 'lens' ),
				'priority' => 3,
				'options' => array(
					'google_main_font'  => array(
						'type'             => 'typography',
						'label'            => esc_html__( 'Main Heading Font', 'lens' ),
						'desc'             => esc_html__( 'Select a font for the main titles.', 'lens' ),
						'load_all_weights' => true,
						'recommended'      => array(
							'Josefin Slab',
							'Roboto',
							'Open Sans',
							'Crimson Text',
							'Playfair Display',
							'Oswald',
							'Lato',
							'Open Sans',
							'Exo',
							'PT Sans',
							'Ubuntu',
							'Vollkorn',
							'Lora',
							'Arvo',
							'Crete Round',
							'Kreon',
							'Bubblegum Sans',
							'The Girl Next Door',
							'Pacifico',
							'Handlee',
							'Satify',
							'Pompiere'
						),
						'selector'         => '.count, .count sup,
									.gallery-control .count sup,
									.header-quote-content blockquote,
									.article-timestamp,
									.progressbar__title,
									.progressbar__tooltip,
									.testimonial__content,
									.testimonial__author-name,
									.tweet__meta,
									.search-query,
									.mfp-title,
									.entry__content ul li,
									.hN, .alpha, h1,
									.beta, h2, .gamma, h3,
									.masonry__item .entry__title,
									.single-portfolio-fullwidth .entry__title,
									.delta, h4, .epsilon, h5, .zeta, h6,
									.comment__author-name,
									.entry__meta-box a,
									.rsCaption__title'
					),
					'google_body_font'  => array(
						'type'             => 'typography',
						'label'            => esc_html__( 'Body Font', 'lens' ),
						'desc'             => esc_html__( 'Select a font for content and other general areas.', 'lens' ),
						'load_all_weights' => true,
						'recommended'      => array(
							'Crimson Text',
							'Roboto',
							'Open Sans',
							'Josefin Slab',
							'Playfair Display',
							'Oswald',
							'Lato',
							'Open Sans',
							'Exo',
							'PT Sans',
							'Ubuntu',
							'Vollkorn',
							'Lora',
							'Arvo',
							'Crete Round',
							'Kreon',
							'Bubblegum Sans',
							'The Girl Next Door',
							'Pacifico',
							'Handlee',
							'Satify',
							'Pompiere'
						),
						'selector'         => 'html,
									.wpcf7-form-control:not([type="submit"]),
									.wp-caption-text,
									blockquote:before,
									ol li,
									.comment__timestamp,
									.meta-box__box-title,
									.header-quote-content blockquote .author_description,
									.testimonial__author-title,
									.widget-content',
					),

					'google_menu_font' => array(
						'type'             => 'typography',
						'label'            => esc_html__( 'Navigation', 'lens' ),
						'desc'             => esc_html__( 'Font for the navigation menu.', 'lens' ),
						'default' => array( 'Roboto', '300' ),
						'recommended'      => array(
							'Roboto',
							'Josefin Slab',
							'Open Sans',
							'Crimson Text',
							'Playfair Display',
							'Oswald',
							'Lato',
							'Open Sans',
							'Exo',
							'PT Sans',
							'Ubuntu',
							'Vollkorn',
							'Lora',
							'Arvo',
							'Crete Round',
							'Kreon',
							'Bubblegum Sans',
							'The Girl Next Door',
							'Pacifico',
							'Handlee',
							'Satify',
							'Pompiere'
						),
						'selector'         => '.image__plus-icon,
									.image_item-description,
									.image_item-category,
									.btn, .wpcf7-submit, .form-submit #comment-submit,
									.header,
									.header .hN,
									.header .alpha,
									.header h1,
									.header .beta,
									.header h2,
									.header .gamma,
									.header h3,
									.header .masonry__item .entry__title,
									.masonry__item .header .entry__title,
									.header .single-portfolio-fullwidth .entry__title,
									.single-portfolio-fullwidth .header .entry__title,
									.header .delta,
									.header h4,
									.header .epsilon,
									.header h5,
									.header .zeta,
									.header h6,
									.footer .hN,
									.footer .alpha, .footer h1,
									.footer .beta,
									.footer h2,
									.footer .gamma,
									.footer h3,
									.footer .masonry__item .entry__title,
									.masonry__item .footer .entry__title,
									.footer .single-portfolio-fullwidth .entry__title,
									.single-portfolio-fullwidth .footer .entry__title,
									.footer .delta,
									.footer h4,
									.footer .epsilon,
									.footer h5,
									.footer .zeta,
									.footer h6,
									.text-link,
									.projects_nav-item a,
									.navigation--mobile'
					),
				)
			),
			'galleries'           => array(
				'title'    => '&#x1f307; ' . esc_html__( 'Galleries', 'lens' ),
				'priority' => 4,
				'options'  => array(
					// 'this_divider_128932182' => array(
					// 	'type' => 'html',
					// 	'html' => '<span class="separator label large">' . esc_html__( 'Single Gallery', 'lens' ) . '</span>'
					// ),

					'this_divider_5347669123' => array(
						'type' => 'html',
						'html' => '<span class="separator label large">' . esc_html__( 'Galleries Archive', 'lens' ) . '</span> <br/>'
					),
					'this_divider_39773812763'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Galleries Archive Title', 'lens' ) . '</span>'
					),
					'galleries_show_archive_title'             => array(
						'type'    => 'checkbox',
						'label'    => esc_html__( 'Show galleries archive title', 'lens' ),
						'default' => 1
					),

					'this_divider_39273812763'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Galleries Filter', 'lens' ) . '</span>'
					),
					'galleries_archive_filtering'             => array(
						'type'    => 'checkbox',
						'label'    => esc_html__( 'Display Filters on Galleries Archive Page', 'lens' ),
						'default' => 1
					),

					'galleries_thumb_orientation' => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Grid Thumbnails Orientation', 'lens' ),
						'default' => 'landscape',
						'choices' => array(
							'landscape' => esc_html__( 'Landscape', 'lens' ),
							'portrait'  => esc_html__( 'Portrait', 'lens' )
						),
					),



					'this_divider_297218723'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Infinite Scroll', 'lens' ) . '</span>'
					),
					'galleries_infinitescroll'                => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Load new items on scroll (will load at once the number of galleries specified below).', 'lens' ),
						'default' => 0,
						//'required' => array( 'galleries_enable_pagination', '=', 1 ),
					),

					'this_divider_297976231'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Or Use Pagination', 'lens' ) . '</span>'
					),
					'galleries_enable_pagination' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Enable Standard Pagination', 'lens' ),
						'default' => 0
					),
					'galleries_per_page' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Galleries Per Page', 'lens' ),
						'default' => 9,
						//'required' => array( 'galleries_enable_pagination', '=', 1 ),
					),
				)
			),

			'portfolio' => array(
				'title'       => '&#x1f5fb; ' . esc_html__( 'Portfolio', 'lens' ),
				'priority' => 5,
				'options' => array(
					'this_divider_867289367'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label large">' . esc_html__( 'Single Project', 'lens' ) . '</span> <br/>'
					),

					'this_divider_2987832183'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Sharing Buttons', 'lens' ) . '</span>'
					),
					'portfolio_single_show_share_links' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Show Share Buttons in Projects', 'lens' ),
						'default' => 1
					),

					'this_divider_283719238'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label large">' . esc_html__( 'Projects Archives', 'lens' ) . '</span>'
					),

					'this_divider_298723'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Portfolio Archive Title', 'lens' ) . '</span>'
					),
					'portfolio_show_archive_title'             => array(
						'type'    => 'checkbox',
						'label'    => esc_html__( 'Show portfolio archive title', 'lens' ),
						'default' => 1
					),

					'this_divider_2998621'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Portfolio Filter', 'lens' ) . '</span>'
					),
					'portfolio_projects_filtering'             => array(
						'type'    => 'checkbox',
						'label'    => esc_html__( 'Display Filters on Portfolio Archive Page', 'lens' ),
						'default' => 1
					),

					'portfolio_thumb_orientation' => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Grid Thumbnails Orientation', 'lens' ),
						'default' => 'landscape',
						'choices' => array(
							'landscape' => esc_html__( 'Landscape', 'lens' ),
							'portrait'  => esc_html__( 'Portrait', 'lens' )
						),
					),

					'this_divider_297908723'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Infinite Scroll', 'lens' ) . '</span>'
					),
					'portfolio_infinitescroll'                => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Load new items on scroll (will load at once the number of galleries specified below).', 'lens' ),
						'default' => 0,
						//'required' => array( 'portfolio_enable_pagination', '=', 1 ),
					),

					'this_divider_20865421'                 => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Or Use Pagination', 'lens' ) . '</span>'
					),
					'portfolio_enable_pagination' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Enable Standard Pagination', 'lens' ),
						'default' => 0
					),
					'portfolio_projects_per_page' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Number of Projects Per Page', 'lens' ),
						'default' => 9,
						//'required' => array( 'portfolio_enable_pagination', '=', 1 ),
					),

				)
			),

			'blog' => array(
				'title'   => '&#x1f4d4; ' . esc_html__( 'Blog', 'lens' ),
				'priority' => 6,
				'options' => array(
					'this_divider_8874320137'	=> array(
						'type' => 'html',
						'html' => '<span class="separator label large">' . esc_html__( 'Single Post', 'lens' ) . '</span> <br/>'
					),
					'this_divider_37986312'	=> array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'Sharing Buttons', 'lens' ) . '</span>'
					),
					'blog_single_show_share_links' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Show Share Buttons in Posts', 'lens' ),
						'default' => 1,
					),

					'this_divider_5343879' => array(
						'type' => 'html',
						'html' => '<span class="separator label large">' . esc_html__( 'Blog Archive', 'lens' ) . '</span>'
					),

					'blog_excerpt_length' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Excerpt Length', 'lens' ),
						'default' => 100,
					),
				)
			),

		);

		$config['panels'] = array();

		$config['panels']['theme_options'] = array(
			'title'    => '&#x1f506; ' . esc_html__( 'Theme Options', 'lens' ),
			'priority' => 1,
			'sections' => array(
				'general' => array(
					'title'   => esc_html__( 'General', 'lens' ),
					'options' => array(
						'main_logo'                => array(
							'type'  => 'media',
							'label' => esc_html__( 'Logo', 'lens' ),
						),
						'logo_height'              => array(
							'type'        => 'range',
							'label'       => esc_html__( 'Logo Height', 'lens' ),
							'input_attrs' => array(
								'min'  => 10,
								'max'  => 200,
								'step' => 1,
							),
							'live'        => true,
							'default'     => 30,
							'css'         => array(
								array(
									'property' => 'height',
									'selector' => '.site-logo img',
								),
								array(
									'property' => 'font-size',
									'selector' => '.site-logo--text',
								)
							),
						),
						'divider_title_5347678321' => array(
							'type' => 'html',
							'html' => '<span class="separator label">' . esc_html__( 'Smooth Scrolling', 'lens' ) . '</span>'
						),
						'use_smooth_scroll'        => array(
							'type'    => 'checkbox',
							'label'   => esc_html__( 'Enable Smooth Scrolling.', 'lens' ),
							'default' => 1,
						),
						'divider_title_5347719831' => array(
							'type' => 'html',
							'html' => '<span class="separator label">' . esc_html__( 'Ajax Loading', 'lens' ) . '</span>'
						),
						'use_ajax_loading'         => array(
							'type'    => 'checkbox',
							'label'   => esc_html__( 'Enable dynamic page content loading using AJAX.', 'lens' ),
							'default' => 1,
						),

						'divider_title_531237062'  => array(
							'type' => 'html',
							'html' => '<span class="separator label">' . esc_html__( 'Right-Click Protection', 'lens' ) . '</span>'
						),
						'enable_copyright_overlay' => array(
							'type'    => 'checkbox',
							'label'   => esc_html__( 'Prevent right-click saving for images', 'lens' ),
							'default' => 0,
						),
						'copyright_overlay_text'   => array(
							'type'    => 'text',
							'desc'    => esc_html__( 'The tooltip message that appears when click.', 'lens' ),
							'default' => esc_html__( 'This content is &copy; Lens | All rights reserved.', 'lens' ),
						),

						'show_title_caption_popup' => array(
							'type'    => 'checkbox',
							'label'   => esc_html__( 'Show Title and Caption In Pop-up and Sliders', 'lens' ),
							'default' => 1,
						),

						'copyright_text' => array(
							'type'              => 'textarea',
							'label'             => esc_html__( 'Copyright Text', 'lens' ),
							'default'           => sprintf( esc_html__( '%%year%% &copy; Handcrafted with love by the %1$s Team', 'lens' ), '&nbsp;<a href="https://pixelgrade.com/" rel="designer">Pixelgrade</a>&nbsp;' ),
							'sanitize_callback' => 'wp_kses_post',
							'live'              => array( '.site-info' )
						),

						'divider_title_547671321' => array(
							'type' => 'html',
							'html' => '<span class="separator label">' . esc_html__( 'Contact Page', 'lens' ) . '</span>'
						),


						'contact_gmap_link'   => array(
							'type'    => 'textarea',
							'label'    => esc_html__( 'Google Maps Link', 'lens' ),
						),

						'google_maps_api_key' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Google Maps API key', 'lens' ),
							'default' => '',
							'desc'    => sprintf(
								'<p>%s.   <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">%s</a> <br><br>%s</p>',
								esc_html__( 'To use Google Maps you must authenticate your application with an API key', 'lens' ),
								esc_html__( 'Optain a key', 'lens' ),
								esc_html__( 'After you get the key, enable the "Google Maps JavaScript API" from the Overview tab', 'lens' )
							)
						),
						
						'contact_gmap_custom_style' => array(
							'type'    => 'checkbox',
							'label'   => esc_html__( 'Custom Styling for Map?', 'lens' ),
							'default' => 1,
						),
					)
				),

				'share_settings' => array(
					'title'    => esc_html__( 'Share Settings', 'lens' ),
					'options' => array(
						'share_buttons_settings' => array(
							'type'	=> 'text',
							'default' => 'preferred,preferred,preferred,preferred,more',
							'label' => esc_html__( 'Share Services', 'lens' ),
							'desc' => __( 'Add here the share services you want to use, single comma delimited (no spaces). You can find the full <a href="http://www.addthis.com/services/list" target="_blank">list of services</a>. Also you can use the more tag to show the plus sign and the counter tag to show a global share counter.', 'lens' ),
						)
					)
				),

				'custom_js'   => array(
					'title'   => esc_html__( 'Custom JavaScript', 'lens' ),
					'priority' => 999,
					'options' => array(
						'custom_js'        => array(
							'type'        => 'ace_editor',
							'label'       => esc_html__( 'Header', 'lens' ),
							'desc'        => esc_html__( 'Easily add Custom Javascript code. This code will be loaded in the <head> section.', 'lens' ),
							'editor_type' => 'javascript',
						),
						'google_analytics' => array(
							'type'        => 'ace_editor',
							'label'       => esc_html__( 'Footer', 'lens' ),
							'desc'        => esc_html__( 'You can paste here your Google Analytics tracking code (or for what matters any tracking code) and we will put it on every page.', 'lens' ),
							'editor_type' => 'javascript',
						),
					)
				),
			)
		);


		/**
		 * Check if WooCommerce is active
		 **/
		if ( class_exists( 'WooCommerce' ) ) {

			$config['panels']['theme_options']['sections']['woocommerce'] = array(
				'title'   => esc_html__( 'WooCommerce', 'lens' ),
				'options' => array(
					'divider_title_962836192' => array(
						'type' => 'html',
						'html' => '<span class="separator label">' . esc_html__( 'WooCommerce Support', 'lens' ) . '</span>'
					),
					'enable_woocommerce_support' => array(
						'type'    => 'checkbox',
						'label'   => esc_html__( 'Load WooCommerce CSS and JS files.', 'lens' ),
						'default' => 1
					),

					'woocommerce_products_numbers' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Products per page', 'lens' ),
						'desc'    => esc_html__( 'Select the number of products per page.This must be numeric.', 'lens' ),
						'default' => '12'
					),
				)
			);
		}


		return $config;
	}
}
add_filter( 'customify_filter_fields', 'add_customify_lens_options', 10 );


function convert_redux_options_to_customify() {

	$current_options = get_option( 'lens_options' );

	if ( is_array( $current_options['main_logo'] ) && isset( $current_options['main_logo']['id'] ) ) {
		$current_options['main_logo'] = $current_options['main_logo']['id'];
	}

	$checkbox_types_ids = array(
		'use_smooth_scroll',
		'use_ajax_loading',
		'enable_copyright_overlay',
		'show_title_caption_popup',
		'contact_gmap_custom_style',
		'galleries_enable_pagination',
		'galleries_infinitescroll',
		'galleries_archive_filtering',
		'galleries_show_archive_title',
		'portfolio_single_show_share_links',
		'portfolio_enable_pagination',
		'portfolio_infinitescroll',
		'portfolio_projects_filtering',
		'portfolio_show_archive_title',
		'blog_single_show_share_links',
		'header_inverse'
	);

	foreach ( $checkbox_types_ids as $key ) {
		if ( isset( $current_options[$key] ) ) {
			if ( $current_options[$key] ) {
				$current_options[$key] = true;
			} else {
				$current_options[$key] = false;
			}
		}
	}

	if ( isset( $current_options['custom_css'] ) && ! empty( $current_options['custom_css'] ) ) {
		$current_ccss = get_option('live_css_edit');
		update_option( 'live_css_edit', trim( $current_options['custom_css'] ) . "\n" . $current_ccss );
	}

	update_option( 'lens_options', $current_options );
	lens_convert_social_links();

	update_option( 'convert_options_to_customify', 1 );

//	header( 'Location: ' . admin_url() . 'customize.php?save_customizer_once=true' );
//	die();
}

//delete_option('convert_options_to_customify');
$once = get_option( 'convert_options_to_customify' );
if ( empty( $once ) ) {
	add_action( 'init', 'convert_redux_options_to_customify' );
}

function lens_convert_social_links() {
	$current_options = get_option( 'lens_options' );

	if ( ! isset( $current_options['social_icons'] ) || ! isset( $current_options['do_social_footer_menu'] ) || ! $current_options['do_social_footer_menu'] ) {
		return;
	}

	$footer_links = array();
	$social_links = $current_options['social_icons'];

	if ( ! empty( $social_links ) ) {
		foreach ( $social_links as $key => $link ) {

			if ( empty( $link['value'] ) ) {
				continue;
			}
			$footer_links[ $key ] = $link['value'];
		}
	}

	if ( ! empty( $footer_links ) ) {
		// create a widget menu and import links

		$menu_title = esc_html__( 'Social Footer Menu', 'lens' );

		if ( isset( $current_options['social_footer_menu_title'] ) && ! empty( $current_options['social_footer_menu_title'] ) ) {
			$menu_title = $current_options['social_footer_menu_title'];
		}

		$menu_id = wp_create_nav_menu( $menu_title );
		//then get the menu object by its name
		$menu = get_term_by( 'name', $menu_title, 'nav_menu' );

		foreach ( $footer_links as $key => $link ) {
			//then add the actuall link/ menu item and you do this for each item you want to add
			wp_update_nav_menu_item( $menu->term_id, 0, array(
					'menu-item-title'  => $key,
					'menu-item-url'    => $link,
					'menu-item-status' => 'publish'
				)
			);
		}
		//then you set the wanted theme  location
		$locations                = get_theme_mod( 'nav_menu_locations' );
		$locations['social_menu'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	unset( $current_options['social_icons'] );
	// save the new options
	update_option( 'lens_options', $current_options );
}

/**
 * Convert HEX to RGB and adjust color brightness
 */
function lens_hex2rgb( $hex ) {
	$hex = str_replace( "#", "", $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );

//     return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

function lens_field_with_07rgba_value( $value, $selector, $property, $unit ) {
	$rgb    = implode( ",", lens_hex2rgb( $value ) );
	$output = $selector . '{
		' . $property . ': rgba(' . $rgb . ", 0.7);\n" .
	          "}\n";

	return $output;
}

function lens_header_gradient_value( $value, $selector, $property, $unit ) {
	$output = $selector . '{ ' . $property . ': linear-gradient('. $value .' 50%, #464a4d); }';

	return $output;
}

function lens_header_secondary_gradient_value( $value, $selector, $property, $unit ) {
	$output = $selector . '{ ' . $property . ': linear-gradient('. $value .' 5%, '. $value .' 91.66%, transparent 91.66%, transparent); }';

	return $output;
}
