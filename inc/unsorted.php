<?php
function wpgrade_is_all_multibyte($string)
{
	if (function_exists('mb_check_encoding')) {
		// check if the string doesn't contain invalid byte sequence
		if (mb_check_encoding($string, 'UTF-8') === false) return false;

		$length = mb_strlen($string, 'UTF-8');

		for ($i = 0; $i < $length; $i += 1) {
			$char = mb_substr($string, $i, 1, 'UTF-8');

			// check if the string doesn't contain single character
			if (mb_check_encoding($char, 'ASCII')) {
				return false;
			}
		}

		return true;
	} else {
    	return false;
    }

}

function wpgrade_contains_any_multibyte($string)
{
	if (function_exists('mb_check_encoding')) {
    	return !mb_check_encoding($string, 'ASCII') && mb_check_encoding($string, 'UTF-8');
    } else {
    	return false;
    }
}

/**
* Cutting the titles and adding '...' after
* @param  [string] $text       [description]
* @param  [int] $cut_length [description]
* @param  [int] $limit      [description]
* @return [type]             [description]
*/
function short_text($text, $cut_length, $limit, $echo = true){
   $char_count = mb_strlen($text,'UTF-8');
   $text = ( $char_count > $limit ) ? mb_substr($text,0,$cut_length).'&#8230;' : $text;
   if ($echo) {
	   echo $text;
   } else {
	   return $text;
   }
}

/**
* Borrowed from CakePHP
*
* Truncates text.
*
* Cuts a string to the length of $length and replaces the last characters
* with the ending if the text is longer than length.
*
* ### Options:
*
* - `ending` Will be used as Ending and appended to the trimmed string
* - `exact` If false, $text will not be cut mid-word
* - `html` If true, HTML tags would be handled correctly
*
* @param string  $text String to truncate.
* @param integer $length Length of returned string, including ellipsis.
* @param array $options An array of html attributes and options.
* @return string Trimmed string.
* @access public
* @link http://book.cakephp.org/view/1469/Text#truncate-1625
*/

function truncate($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text),'UTF-8') <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending),'UTF-8');
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]),'UTF-8');
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0],'UTF-8');
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text,'UTF-8') <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending, 'UTF-8'));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</'.$tag.'>';
        }
    }

    return $truncate;
}

/**
 * @param string $text The content to truncate
 * @param int $excerpt_length The number of characters to show
 * @param bool $filters Whether to apply filters on the content or not
 *
 * @return mixed|void
 */
function wpgrade_better_excerpt($text = '', $excerpt_length = 70, $filters = true) {
	global $post;
	$raw_excerpt = '';

	//if the post has a manual excerpt ignore the content given
	if ($text == '' && function_exists('has_excerpt') && has_excerpt()) {
		$text = get_the_excerpt();
		$raw_excerpt = $text;

		$text = strip_shortcodes( $text );
		if ($filters == true) {
			$text = apply_filters('the_content', $text);
		}
		$text = str_replace(']]>', ']]&gt;', $text);

		// Removes any JavaScript in posts (between <script> and </script> tags)
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

		// Enable formatting in excerpts - Add HTML tags that you want to be parsed in excerpts
		$allowed_tags = '<p><a><strong><i><br><h1><h2><h3><h4><h5><h6><blockquote><ul><li><ol>';
		$text = strip_tags($text, $allowed_tags);
//		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
//		$text .= $excerpt_more;

	} else {

		if ( empty( $text ) ) {
			//need to grab the content
			$text = $post->post_content;
		}

		$raw_excerpt = $text;
		$text = strip_shortcodes( $text );
		if ($filters == true) {
			$text = apply_filters( 'the_content', $text );
		}
		$text = str_replace( ']]>', ']]&gt;', $text );

		// Removes any JavaScript in posts (between <script> and </script> tags)
		$text = preg_replace( '@<script[^>]*?>.*?</script>@si', '', $text );

		// Enable formatting in excerpts - Add HTML tags that you want to be parsed in excerpts
		//$allowed_tags = '<p><a><em><strong><i><br><h1><h2><h3><h4><h5><h6><blockquote><ul><li><ol>';
		$text = strip_tags( $text, '' );

		$excerpt_more = apply_filters( 'excerpt_more', '' . '&#8230;' );

		//test if we are dealing with a utf8 text - like chinese
		if ( wpgrade_is_all_multibyte( $text ) ) {
			//then we simply split my mb characters rather than words
			$text = short_text( $text, $excerpt_length, $excerpt_length );
		} else {
			$options = array(
				'ending' => $excerpt_more, 'exact' => false, 'html' => false
			);

			$text = truncate( $text, $excerpt_length, $options );

			//this is an alternative to truncate() to handle mb strings, but it works with words not characters
//			$words = preg_split("/[\n\r\t\s]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
//
//			//some further testing to ensure that we catch the mb languages like chinese
//			//test for extra long average word length - means that each sentence is interpreted as a word
//			$temp_words = $words;
//			if (count($temp_words) > 1) {
//				array_pop($temp_words);
//			}
//
//			//we have taken a large average word length - 20
//			if (count($temp_words) > 0 && mb_strlen(implode(' ', $temp_words),'UTF-8')/count($temp_words) > 20) {
//				//we have a mb language
//				//then we simply split by mb characters rather than words
//				$text = short_text($text,$excerpt_length,$excerpt_length);
//			} else {
//
//				if ( count($words) > $excerpt_length ) {
//					array_pop($words);
//					$text = implode(' ', $words);
//					//$text = force_balance_tags( $text );
//					$text = $text . $excerpt_more;
//				} else {
//					$text = implode(' ', $words);
//				}
//
//			}
		}
	}

	// IMPORTANT! Prevents tags cutoff by excerpt (i.e. unclosed tags) from breaking formatting
	$text = force_balance_tags( $text );

	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
}

function custom_excerpt_length( $length ) {
	// Set custom excerpt length - number of words to be shown in excerpts
	if (pixelgrade_option('blog_excerpt_length'))	{
		return absint(pixelgrade_option('blog_excerpt_length'));
	} else {
		return 55;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*
 * COMMENT LAYOUT
 */
function wpgrade_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment__meta comment-author vcard">
				<time datetime="<?php comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" class="comment__timestamp"><?php comment_time(__('M j, Y \a\t H:i', 'lens')); ?> </a></time>
				<?php printf(__('<cite class="comment__author-name">%s</cite>', 'lens'), get_comment_author_link()) ?>
			</header><!-- .comment-meta -->
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="alert info">
				<p><?php esc_html_e('Your comment is awaiting moderation.', 'lens') ?></p>
			</div>
			<?php endif; ?>
			<section class="comment__content comment">
				<?php comment_text() ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				<?php edit_comment_link(__('Edit', 'lens'),'  ','') ?>
			</section>
		</article>
	<!-- </li> is added by WordPress automatically -->
	<?php
} // don't remove this bracket!

function wpgrade_register_attachments(){

	// add video support for attachments
	if ( !function_exists( 'add_video_url_field_to_attachments' ) ) {
		function add_video_url_field_to_attachments($form_fields, $post){
			if ( !isset($form_fields["video_url"]) ) {
				$form_fields["video_url"] = array(
					"label" => esc_html__("Video URL", 'pixtypes_txtd'),
					"input" => "text", // this is default if "input" is omitted
					"value" => esc_url( get_post_meta($post->ID, "_video_url", true) ),
					"helps" => __("<p>Here you can link a video</p><small>Only youtube or vimeo!</small>", 'pixtypes_txtd'),
				);
			}
			return $form_fields;
		}
		add_filter("attachment_fields_to_edit", "add_video_url_field_to_attachments", 99999, 2);
	}

	// add video support for attachments
	if ( !function_exists( 'add_external_url_field_to_attachments' ) ) {
		function add_external_url_field_to_attachments($form_fields, $post){
			if ( !isset($form_fields["external_url"]) ) {
				$form_fields["external_url"] = array(
					"label" => esc_html__("External URL", 'pixtypes_txtd'),
					"input" => "text", // this is default if "input" is omitted
					"value" => esc_url( get_post_meta($post->ID, "_external_url", true) ),
					"helps" => __("<p>Here you can add an external URL.</p>", 'pixtypes_txtd'),
				);
			}
			return $form_fields;
		}
		add_filter("attachment_fields_to_edit", "add_external_url_field_to_attachments", 99999, 2);
	}

	/**
	 * Save custom media metadata fields
	 *
	 * Be sure to validate your data before saving it
	 * http://codex.wordpress.org/Data_Validation
	 *
	 * @param $post The $post data for the attachment
	 * @param $attachment The $attachment part of the form $_POST ($_POST[attachments][postID])
	 * @return $post
	 */

	if ( !function_exists( 'add_image_attachment_fields_to_save' ) ) {
		add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", 9999 , 2);
		function add_image_attachment_fields_to_save( $post, $attachment ) {
			if ( isset( $attachment['video_url'] ) )
				update_post_meta( $post['ID'], '_video_url', esc_url($attachment['video_url']) );


			if ( isset( $attachment['external_url'] ) )
				update_post_meta( $post['ID'], '_external_url', esc_url($attachment['external_url']) );

			return $post;
		}
	}
}

/** let this come last, it may be already called in older versions of pixtypes */
add_action('wp_loaded', 'wpgrade_register_attachments');

//filter the image on insert into the editor and test if it has a video link
//we need to add a special class and modifiy the url
function wpgrade_filter_insert_image($html, $id, $caption, $title, $align, $url, $size) {

	// check if this attachment has a video url
	$attachment_fields = get_post_custom( $id );
	$video_url = ( isset($attachment_fields['_video_url'][0] ) && !empty( $attachment_fields['_video_url'][0]) ) ? esc_url( $attachment_fields['_video_url'][0] ) : '';

	if (!empty($video_url)) {
		$classes = 'popup-video'; // separated by spaces, e.g. 'img image-link'

		// check if there are already classes assigned to the anchor
		if ( preg_match('/<a.*? class=".*?">/', $html) ) {
			$html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		} else {
			$html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		}

		//now let's change the link url to point to the video url
		$pattern = "/(?<=href=(\"|'))[^\"']+(?=(\"|'))/";
		$html = preg_replace($pattern,$video_url,$html);
	}

	return $html;
}
add_filter( 'image_send_to_editor', 'wpgrade_filter_insert_image', 10, 9 );

//put the google_analytics field in the footer - treat it just like custom_js_footer
add_action('wp_footer', 'wpgrade_callback_load_google_analytics_aka_cjsfooter',999);
function wpgrade_callback_load_google_analytics_aka_cjsfooter() {
	$custom_js = pixelgrade_option('google_analytics');
	if ( ! empty($custom_js)) {
		//first lets test is the js code is clean or has <script> tags and such
		//if we have <script> tags than we will not enclose it in anything - raw output
		if (strpos($custom_js, '</script>') !== false) {
			echo $custom_js."\n";
		} else {
			echo "<script type=\"text/javascript\">\n;(function($){\n".$custom_js."\n})(jQuery);\n</script>\n";
		}
	}
}

/**
 * http://wordpress.stackexchange.com/questions/73190/can-the-next-prev-post-links-be-ordered-by-menu-order-or-by-a-meta-key#answer-95969
 * Will try to change to regular order for next_post_link and previous_post_link functions from post_date to menu order
 *
 * Customize Adjacent Post Link Order
 */
function lens_adjacent_project_where($sql) {
	if ( is_singular('lens_portfolio') && is_main_query() ) {
		$the_post = get_post( get_the_ID() );
		$patterns = array();
		$patterns[] = '/post_date/';
		$patterns[] = '/\'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\'/';
		$replacements = array();
		$replacements[] = 'menu_order';
		$replacements[] = $the_post->menu_order;
		return preg_replace( $patterns, $replacements, $sql );
	}

	return $sql;
}

function lens_adjacent_project_sort($sql) {
	if ( is_singular('lens_portfolio') && is_main_query() ) {
		$pattern = '/post_date/';
		$replacement = 'menu_order';
		return preg_replace( $pattern, $replacement, $sql );
	}
	return $sql;
}

// do this only if simple_page_plugin is active
if ( in_array( 'simple-page-ordering/simple-page-ordering.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	add_filter( 'get_next_post_where', 'lens_adjacent_project_where' );
	add_filter( 'get_previous_post_where', 'lens_adjacent_project_where' );

	add_filter( 'get_next_post_sort', 'lens_adjacent_project_sort' );
	add_filter( 'get_previous_post_sort', 'lens_adjacent_project_sort' );

}

///*
// * Disable the 1600px limit for maxwidth introduced in WP 4.4 (Responsive Images)
// */
//function lens_remove_max_srcset_image_width( $max_width ) {
//	return false;
//}
//add_filter( 'max_srcset_image_width', 'lens_remove_max_srcset_image_width' );
