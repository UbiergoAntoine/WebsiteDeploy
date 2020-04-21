<?php

get_template_part( 'inc/includes/required-plugins/class-tgm-plugin-activation' );
add_action( 'tgmpa_register', 'wpgrade_register_required_plugins', 995 );

function wpgrade_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
//	$plugins = array(
//		array(
//			'name'     				=> 'PLUGIN NAME', // The plugin name
//			'slug'     				=> 'PLUGINSLUG', // The plugin slug (typically the folder name)
//			'source'   				=> 'PLUGIN_LOCATION', // The plugin source
//			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
//			'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
//			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
//			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
//			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
//		)
//	);

	$protocol = 'http:';
	if ( is_ssl() ) {
		$protocol = 'https:';
	}

	$plugins = array(
		array(
			'name'               => 'Pixelgrade Care',
			'slug'               => 'pixelgrade-care',
			'force_activation'   => true,
			'force_deactivation' => false,
			'required'           => true,
			'source'             => $protocol . '//wupdates.com/api_wupl_version/JxbVe/2v5t1czd3vw4kmb5xqmyxj1kkwmnt9q0463lhj393r5yxtshdyg05jssgd4jglnfx7A2vdxtfdcf78r9r1sm217k4ht3r2g7pkdng5f6tgwyrk23wryA0pjxvs7gwhhb',
			'external_url'       => $protocol . '//github.com/pixelgrade/pixelgrade_care',
			'version'            => '1.5.6',
			'is_automatic'       => true
		),
		array(
			'name'     => 'PixTypes',
			'slug'     => 'pixtypes',
			'required' => true,
		),
		array(
			'name'     => 'Customify',
			'slug'     => 'customify',
			'required' => true,
		),
		array(
			'name'     => 'PixCodes',
			'slug'     => 'pixcodes',
			'required' => true,
		),
		array(
			'name'         => 'PixLikes',
			'slug'         => 'pixlikes',
			'version'      => '1.1.3',
			'external_url' => $protocol . '//github.com/pixelgrade/pixlikes',
			'source'       => $protocol . '//wupdates.com/api_wupl_version/v75R3/zfj7hxx36y35qssyp1tAfyk4g5y1dl3sshkxph1cdzx74jtgjdkctlwkrx033lv1b4jx5mcs41w5wf72srsysn31ccyg6lbvg3n0yf0xnfyj3330fqpbp52wmlsmtszf',
		),
		array(
			'name'     => 'PixProof',
			'slug'     => 'pixproof',
			'required' => false,
		),
		array(
			'name'     => 'Simple Page Ordering',
			'slug'     => 'simple-page-ordering',
			'required' => false,
		),
		array(
			'name'     => 'Yet Another Related Posts Plugin (YARPP)',
			'slug'     => 'yet-another-related-posts-plugin',
			'required' => false,
		),
	);

	$config  = array(
		'domain'       => 'lens', // Text domain - likely want to be the same as your theme.
		'default_path' => '', // Default absolute path to pre-packaged plugins
		'menu'         => 'install-required-plugins', // Menu slug
		'has_notices'  => true, // Show admin notices or not
		'is_automatic' => false, // Automatically activate plugins after installation or not
		'message'      => '', // Message to output right before the plugins table
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'lens' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'lens' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'lens' ),
			// %1$s = plugin name
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'lens' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'lens' ),
			// %1$s = plugin name(s)
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'lens' ),
			// %1$s = plugin name(s)
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'lens' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'lens' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'lens' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'lens' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'lens' )
			// %1$s = dashboard link
		)
	);

	tgmpa( $plugins, $config );

}