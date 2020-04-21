<?php
class lens {

	/**
	 * Function related to WPML functionality and logic
	 */
	static function lang_post_id($id) {
		global $post;
		// make this work for any post type
		if ( isset($post->post_type) ) {
			$post_type = $post->post_type;
		} else {
			$post_type = 'post';
		}

		if(function_exists('icl_object_id')) {
			return icl_object_id($id, $post_type,true);
		} else {
			return $id;
		}
	}

	static function lang_page_id($id){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'page',true);
		} else {
			return $id;
		}
	}

	static function lang_category_id($id){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'category',true);
		} else {
			return $id;
		}
	}
	// a dream
	static function lang_portfolio_tax_id($id){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'portfolio_cat',true);
		} else {
			return $id;
		}
	}

	static function lang_post_tag_id($id){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'post_tag',true);
		} else {
			return $id;
		}
	}

	static function lang_original_post_id($id){
		global $post;

		// make this work with custom post types
		if ( isset($post->post_type) ) {
			$post_type = $post->post_type;
		} else {
			$post_type = 'post';
		}

		if(function_exists('icl_object_id')) {
			return icl_object_id($id, $post_type,true, get_short_defaultwp_language());
		} else {
			return $id;
		}
	}

	static function get_short_defaultwp_language() {
		global $sitepress;
		if (isset($sitepress)) {
			return $sitepress->get_default_language();
		} else {
			return substr(get_bloginfo ( 'language' ), 0, 2);
		}
	}

	static function get_attachment_id_from_src ($url) {
		// Split the $url into two parts with the wp-content directory as the separator.
		$parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

		// Get the host of the current site and the host of the $url, ignoring www.
		$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
		$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

		// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
		if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
			return;
		}

		// Now we're going to quickly search the DB for any attachment GUID with a partial path match.
		// Example: /uploads/2013/05/test-image.jpg
		global $wpdb;

		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parse_url[1] ) );

		// Returns null if no attachment is found.
		return $attachment[0];
	}

	static function portfolio_get_posts($number, $offset = 0) {
		global $paged, $post;
		$paged = 1;
		if ( get_query_var('paged') ) $paged = get_query_var('paged');
		if ( get_query_var('page') ) $paged = get_query_var('page');

		$query_args = array(
			'post_type'         => 'portfolio',
			'posts_per_page'    => $number,
			'paged'				=> $paged,
			'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
//			'order' => 'desc',
		);

		$cat_param = get_query_var('portfolio_cat');
		if ( is_archive() && !empty($cat_param) ) {
			$tax_query_args = array(
				array(
					'taxonomy' => 'portfolio_cat',
					'field' => 'slug',
					'terms' => $cat_param,
				)
			);

			$query_args['tax_query'] = $tax_query_args;
		} else {
			$tag_param = get_query_var('portfolio_tag');
			if ( is_archive() && !empty($tag_param) ) {
				$tax_query_args = array(
					array(
						'taxonomy' => 'portfolio_tag',
						'field' => 'slug',
						'terms' => $tag_param,
					)
				);

				$query_args['tax_query'] = $tax_query_args;
			}
		}

		if ($offset > 0) {
			$query_args['offset'] = $offset;
		}

		return new WP_Query( $query_args );

	}

	/**
	* get youtube video ID from URL
	*
	* @param string $url
	* @return string Youtube video id or FALSE if none found.
	*/
	static function youtube_id_from_url($url) {
		$pattern = '#(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?#x';
		$result = preg_match($pattern, $url, $matches);

		if (false != $result) {
			return $matches[1];
		}
		return false;
	}


	static function vimeo_id_from_url($url)
	{
		$pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
		preg_match($pattern, $url, $matches);
		if (count($matches))
		{
		  return $matches[2];
		}

		return '';
	}


	/**
	 * Get an array with all queued scripts
	 *
	 * @return array
	 */
	static function get_queued_scripts() {
		global $wp_scripts;

		$loading_scripts = array();
		foreach ( $wp_scripts->queue as $key => $handle ) {
			$loading_scripts[ $handle ] = $wp_scripts->registered[ $handle ]->src;
		}
		return $loading_scripts;
	}

	/**
	 * Get an array with all queued styles
	 *
	 * @return array
	 */
	static function get_queued_styles() {
		global $wp_styles;

		$loading_styles = array();
		foreach ( $wp_styles->queue as $key => $handle ) {
			$loading_styles[ $handle ] = $wp_styles->registered[ $handle ]->src;
		}
		return $loading_styles;
	}

	/**
	 * Checks if a psot type object needs password aproval
	 *
	 * @return if the form was submited it returns an array with the success status and a message
	 */

	static function is_password_protected(){
		global $post;
		$private_post = array('allowed' => false, 'error' => '');

		if ( isset( $_POST['submit_password']) ) { // when we have a submision check the password and its submision
			if ( isset( $_POST['submit_password_nonce'] ) && wp_verify_nonce( $_POST['submit_password_nonce'], 'password_protection') ) {
				if ( isset ( $_POST['post_password'] ) && !empty($_POST['post_password']) ) { // some simple checks on password
					// finally test if the password submitted is correct
					if ( $post->post_password ===  $_POST['post_password'] ) {
						$private_post['allowed'] = true;

						// ok if we have a correct password we should inform wordpress too
						// otherwise the mad dog will put the password form again in the_content() and other filters
						global $wp_hasher;
						if ( empty( $wp_hasher ) ) {
							require_once( ABSPATH . 'wp-includes/class-phpass.php' );
							$wp_hasher = new PasswordHash(8, true);
						}

						setcookie( 'wp-postpass_' . COOKIEHASH, $wp_hasher->HashPassword( stripslashes( $_POST['post_password'] ) ), 0, COOKIEPATH );

					} else {
						$private_post['error'] = '<h4 class="text--error">' . esc_html__( 'Wrong Password', 'lens') . '</h4>';
					}
				}
			}
		}

		if (isset($_COOKIE['wp-postpass_' . COOKIEHASH]) && get_permalink() == wp_get_referer()) {
			$private_post['error'] = '<h4 class="text--error">' . esc_html__( 'Wrong Password', 'lens') . '</h4>';
		}

		return $private_post;
	}

	static function get_post_format_first_image_src(){
		global $post;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];

		if(empty($first_img)){ //Defines a default image
			$first_img = wpgrade::uri("/assets/img/default.jpg");
		}
		return $first_img;
	}

	static function get_post_format_first_url(){
		global $post;
		$first_url = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/href\s*=\s*[\"\']([^\"\']+)/', $post->post_content, $matches);
		$first_url = $matches[1][0];

		return $first_url;
	}

	/**
	 * Display a filter box for the given taxonomy
	 * @param $taxonomy_name string
	 */

	static function display_filter_box( $taxonomy_name ){

		// Custom post archive Filter Button
        $filter_categories = get_terms($taxonomy_name);
        if(!empty($filter_categories) && !is_wp_error($filter_categories)) { ?>
            <div class="mosaic__filter sticky-button">
                <div class="filter__btn sticky-button__btn btn btn--large"><i class="pixcode  pixcode--icon  icon-e-up-circled"></i><span><?php esc_html_e('Filter', 'lens'); ?></span>
                    <ul>
                        <?php foreach($filter_categories as $key=>$category) { ?>
                            <li class="mosaic__filter-item sticky-button-item" data-filter="<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
                        <?php } ?>
                        <li class="mosaic__filter-item sticky-button-item" data-filter="all"><?php esc_html_e('View All', 'lens'); ?></li>
                    </ul>
                </div>
            </div>
        <?php
        }
	}

	static function get_terms_as_string ( $taxonomy_name, $field = 'name', $separator = ' ' ) {

		$return = '';
		$terms = get_terms($taxonomy_name);
		$last = count($terms);

		if(!empty($terms) && !is_wp_error($terms)) {
			foreach( $terms as $key => $term ){

				if ( $field == 'name' ) {
					$return .= $term->name;
				} elseif ( $field == 'slug' ) {
					$return .= $term->slug;
				} else {
					continue;
				}

				if ( $last != $key ) {
					$return .= $separator;
				}
			}
		}

		return $return;
	}

	static function get_edit_url() {
		global $wp_the_query;
		$current_object = $wp_the_query->get_queried_object();

		$theID = false;
		if ( ! empty( $current_object->post_type )
			&& ( $post_type_object = get_post_type_object( $current_object->post_type ) )
			&& current_user_can( 'edit_post', $current_object->ID )
			&& $post_type_object->show_ui && $post_type_object->show_in_admin_bar )
		{
			 $theID = $current_object->ID;
		} elseif ( ! empty( $current_object->taxonomy )
			&& ( $tax = get_taxonomy( $current_object->taxonomy ) )
			&& current_user_can( $tax->cap->edit_terms )
			&& $tax->show_ui )
		{
			$theID = $current_object->term_id;
		}

		if ($theID) {
			return get_edit_post_link($theID);
		}

		return '';
	}


	/**
	 * We check if there is a gallery shortcode in the content, extract it and
	 * display it in the form of a slideshow.
	 */
	static function gallery_slideshow($current_post, $template = null) {
		if ($template === null) {

			$image_scale_mode = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_image_scale_mode', true);
			$slider_visiblenearby = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_visiblenearby', true);
			$slider_transition = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_transition', true);
			$slider_autoplay = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_autoplay', true);
			if($slider_autoplay) {
				$slider_delay = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_delay', true);
			}
			// Force transition to move if nearby images are visible
			// because fade transition is incompatible with nearby images
			if( 'true' === $slider_visiblenearby ) $slider_transition = 'move';

			$template = '<div class="wp-gallery" data-royalslider data-customarrows data-sliderpauseonhover data-slidertransition="' . $slider_transition . '" ';
			$template .= ' data-imagescale="' . $image_scale_mode . '" ';

//			var_dump($slider_visiblenearby); die();
			if ( "true" === $slider_visiblenearby ) {
				$template .= ' data-visiblenearby ';
			}
			if($slider_autoplay){
				$template .= ' data-sliderautoplay="" ';
				$template .= ' data-sliderdelay="' . $slider_delay . '" ';
			}
			$template .= ' data-imagealigncenter ';
			if (pixelgrade_option('show_title_caption_popup') ) {
				$template .= ' data-enable_caption=""';
			}
			$template .= '>:gallery</div>';
		}

		// first check if we have a meta with a gallery
		$gallery_ids = array();
		$gallery_ids = get_post_meta( $current_post->ID, wpgrade::prefix() . 'main_gallery', true );

		if ( ! empty($gallery_ids)) {
			//recreate the gallery shortcode
			$gallery = '[gallery ids="'.$gallery_ids.'"]';

			if (strpos($gallery, 'style') === false) {
				$gallery = str_replace("]", " style='big_thumb' size='blog-big' link='file']", $gallery);
			}

			$shrtcode = do_shortcode($gallery);
//			$shrtcode = preg_replace('/(<dd class="wp-caption-text gallery-caption">.+?)+(<\/dd>)/i', '', $shrtcode);
			if (!empty($shrtcode)) {

				return strtr($template, array(':gallery' => $shrtcode));
			} else {
				return null;
			}
		}
		else { // empty gallery_ids
			// search for the first gallery shortcode
			$gallery_matches = null;
			preg_match("!\[gallery.+?\]!", $current_post->post_content, $gallery_matches);

			if ( ! empty($gallery_matches)) {
				$gallery = $gallery_matches[0];

				if (strpos($gallery, 'style') === false) {
					$gallery = str_replace("]", " style='big_thumb' size='blog-big' link='file']", $gallery);
				}
				$shrtcode = do_shortcode($gallery);
				if (!empty($shrtcode)) {
					return strtr($template, array(':gallery' => $shrtcode));
				} else {
					return null;
				}
			}
			else { // gallery_matches is empty
				return null;
			}
		}
	}

    //our version supports a second parameter
    static function get_sidebar( $name = null, $require_once = true ) {
        do_action( 'get_sidebar', $name );

        $templates = array();
        $name = (string) $name;
        if ( '' !== $name )
            $templates[] = "sidebar-{$name}.php";

        $templates[] = 'sidebar.php';

        // Backward compat code will be removed in a future release
        if ('' == locate_template($templates, true, $require_once))
            load_template( ABSPATH . WPINC . '/theme-compat/sidebar.php');
    }

	static function get_img_alt( $image ) {
		$img_alt = trim( strip_tags( get_post_meta( $image, '_wp_attachment_image_alt', true ) ) );
		return $img_alt;
	}

}

function strip_tags_content($text, $tags = '', $invert = FALSE) {

	preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	$tags = array_unique($tags[1]);

	if(is_array($tags) AND count($tags) > 0) {
		if($invert == FALSE) {
			return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		else {
			return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
		}
	}
	elseif($invert == FALSE) {
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	}
	return $text;
}
