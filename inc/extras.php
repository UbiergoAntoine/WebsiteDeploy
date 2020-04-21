<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Lens
 * @since Lens 2.3.0
 */

if ( ! function_exists( 'lens_get_option' ) ) :
	/**
	 * Get option from the database
	 *
	 * @param string
	 * @return mixed
	 */
	function lens_get_option( $option, $default = null ) {
		_deprecated_function('lens_get_option', '2.4.7', 'pixelgrade_option');
		return pixelgrade_option( $option, $default );
	} #function
endif;

// This function should come from Customify, but we need to do our best to make things happen
if ( ! function_exists( 'pixelgrade_option') ) {
	/**
	 * Get option from the database
	 *
	 * @param string $option The option name.
	 * @param mixed $default Optional. The default value to return when the option was not found or saved.
	 * @param bool $force_default Optional. When true, we will use the $default value provided for when the option was not saved at least once.
	 *                          When false, we will let the option's default set value (in the Customify settings) kick in first, then our $default.
	 *                          It basically, reverses the order of fallback, first the option's default, then our own.
	 *                          This is ignored when $default is null.
	 *
	 * @return mixed
	 */
	function pixelgrade_option( $option, $default = null, $force_default = false ) {
		/** @var PixCustomifyPlugin $pixcustomify_plugin */
		global $pixcustomify_plugin;

		if ( $pixcustomify_plugin !== null ) {
			// Customify is present so we should get the value via it

			// We need to account for the case where a option has an 'active_callback' defined in it's config
			$options_config = $pixcustomify_plugin->get_options_configs();
			if ( ! empty( $options_config ) && ! empty( $options_config[ $option ] ) && ! empty( $options_config[ $option ]['active_callback'] ) ) {
				// This option has an active callback
				// We need to "question" it
				//
				// IMPORTANT NOTICE:
				//
				// Be extra careful when setting up the options to not end up in a circular logic
				// due to callbacks that get an option and that option has a callback that gets the initial option - INFINITE LOOPS :(
				if ( is_callable( $options_config[ $option ]['active_callback'] ) ) {
					// Now we call the function and if it returns false, this means that the control is not active
					// Hence it's saved value doesn't matter
					$active = call_user_func( $options_config[ $option ]['active_callback'] );
					if ( empty( $active ) ) {
						// If we need to force the default received; we respect that
						if ( true === $force_default && null !== $default ) {
							return $default;
						} else {
							// Else we return false
							// because we treat the case when the active callback returns false as if the option would be non-existent
							// We do not return the default configured value in this case
							return false;
						}
					}
				}
			}

			// Now that the option is truly active, we need to see if we are not supposed to force over the option's default value
			if ( $default !== null && $force_default == false ) {
				// We will not pass the received $default here so Customify will fallback on the option's default value, if set
				$customify_value = $pixcustomify_plugin->get_option( $option );

				// We only fallback on the $default if none was given from Customify
				if ( null === $customify_value ) {
					return $default;
				}
			} else {
				$customify_value = $pixcustomify_plugin->get_option( $option, $default );
			}

			return $customify_value;
		} elseif ( false === $force_default ) {
			// In case there is no Customify present and we were not supposed to force the default
			// we want to know what the default value of the option should be according to the configuration
			// For this we will fire the all-gathering-filter that Customify uses
			$config = apply_filters('customify_filter_fields', array() );

			// Next we will search for this option and see if it has a default value set ('default')
			if ( ! empty( $config['sections'] ) && is_array( $config['sections'] ) ) {
				foreach ( $config['sections'] as $section ) {
					if ( ! empty( $section['options'] ) && is_array( $section['options'] ) ) {
						foreach ( $section['options'] as $option_id => $option_config ) {
							if ( $option_id == $option ) {
								// We have found our option (the option ID should be unique)
								// It's time to deal with it's default, if it has one
								if ( isset( $option_config['default'] ) ) {
									return $option_config['default'];
								}

								// If the targeted option doesn't have a default value
								// there is no point in searching further because the option IDs should be unique
								// Just return the $default
								return $default;
							}
						}
					}
				}
			}
		}

		// If all else failed, return the default (even if it's null)
		return $default;
	}
}

/**
 * Returns the proper post id in case WPML is active and a the post has a translation
 *
 * @param $id
 * @param string $post_type
 *
 * @return int The id of the post
 */
function lens_get_post_id( $id = null, $post_type = 'post' ) {
	global $post;

	if ( $id === null ) {
		$id = get_the_ID();
	}

	if ( function_exists( 'icl_object_id' ) ) {
		// make this work for any post type
		if ( isset( $post->post_type ) && $post->post_type !== $post_type ) {
			$post_type = $post->post_type;
		}

		return icl_object_id( $id, $post_type, true );
	} else {
		return $id;
	}
}

/**
 * The following code is inspired by Yoast SEO.
 */
function lens_get_current_canonical_url() {
	global $wp_query;

	if ( $wp_query->is_404 || $wp_query->is_search ) {
		return false;
	}

	$haspost = count( $wp_query->posts ) > 0;

	if ( get_query_var( 'm' ) ) {
		$m = preg_replace( '/[^0-9]/', '', get_query_var( 'm' ) );
		switch ( strlen( $m ) ) {
			case 4:
				$link = get_year_link( $m );
				break;
			case 6:
				$link = get_month_link( substr( $m, 0, 4 ), substr( $m, 4, 2 ) );
				break;
			case 8:
				$link = get_day_link( substr( $m, 0, 4 ), substr( $m, 4, 2 ), substr( $m, 6, 2 ) );
				break;
			default:
				return false;
		}
	} elseif ( ( $wp_query->is_single || $wp_query->is_page ) && $haspost ) {
		$post = $wp_query->posts[0];
		$link = get_permalink( lens_get_post_id( $post->ID ) );
	} elseif ( $wp_query->is_author && $haspost ) {
		$author = get_userdata( get_query_var( 'author' ) );
		if ( $author === false ) {
			return false;
		}
		$link = get_author_posts_url( $author->ID, $author->user_nicename );
	} elseif ( $wp_query->is_category && $haspost ) {
		$link = get_category_link( get_query_var( 'cat' ) );
	} elseif ( $wp_query->is_tag && $haspost ) {
		$tag = get_term_by( 'slug', get_query_var( 'tag' ), 'post_tag' );
		if ( ! empty( $tag->term_id ) ) {
			$link = get_tag_link( $tag->term_id );
		}
	} elseif ( $wp_query->is_day && $haspost ) {
		$link = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
	} elseif ( $wp_query->is_month && $haspost ) {
		$link = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
	} elseif ( $wp_query->is_year && $haspost ) {
		$link = get_year_link( get_query_var( 'year' ) );
	} elseif ( $wp_query->is_home ) {
		if ( ( get_option( 'show_on_front' ) == 'page' ) && ( $pageid = get_option( 'page_for_posts' ) ) ) {
			$link = get_permalink( $pageid );
		} else {
			if ( function_exists( 'icl_get_home_url' ) ) {
				$link = icl_get_home_url();
			} else { // icl_get_home_url does not exist
				$link = home_url();
			}
		}
	} elseif ( $wp_query->is_tax && $haspost ) {
		$taxonomy = get_query_var( 'taxonomy' );
		$term     = get_query_var( 'term' );
		$link     = get_term_link( $term, $taxonomy );
	} elseif ( $wp_query->is_archive && function_exists( 'get_post_type_archive_link' ) && ( $post_type = get_query_var( 'post_type' ) ) ) {
		$link = get_post_type_archive_link( $post_type );
	} else {
		return false;
	}

	//let's see about the page number
	$page = get_query_var( 'page' );
	if ( empty( $page ) ) {
		$page = get_query_var( 'paged' );
	}

	if ( ! empty( $page ) && $page > 1 ) {
		$link = trailingslashit( $link ) . "page/$page";
		$link = user_trailingslashit( $link, 'paged' );
	}

	return $link;
}
