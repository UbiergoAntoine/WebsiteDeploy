<?php

/*
 * Register Widgets areas.
 */

function wpgrade_register_sidebars() {

    register_sidebar( array(
        'id'            => 'sidebar-blog',
        'name'          => esc_html__( 'Blog Sidebar', 'lens' ),
        'description'   => esc_html__( 'Blog Sidebar', 'lens' ),
        'before_title'  => '<h4 class="widget__title widget--sidebar-blog__title">',
        'after_title'   => '</h4>',
        'before_widget' => '<div id="%1$s" class="widget widget--sidebar-blog %2$s">',
        'after_widget'  => '</div>',
        )
    );

    register_sidebar( array(
        'id'            => 'sidebar-header',
        'name'          => esc_html__( 'Header Sidebar', 'lens' ),
        'description'   => esc_html__( 'Header Sidebar', 'lens' ),
        'before_title'  => '<h4 class="widget__title widget--header__title">',
        'after_title'   => '</h4>',
        'before_widget' => '<div id="%1$s" class="widget widget--header %2$s">',
        'after_widget'  => '</div>',
        )
    );


	// Use shortcodes in text widgets.
	add_filter('widget_text', 'do_shortcode');

}
add_action('widgets_init', 'wpgrade_register_sidebars');

/*
 * Register custom widgets.
 */
class wpgrade_instagram_widget extends WP_Widget {

	public function __construct()
	{
		parent::__construct( 'wpgrade_instagram_widget', esc_html__( '%s Instagram Widget','lens'), wpgrade::themename() , array('description' => esc_html__('Display Instagram images in your sidebar or footer', 'lens')) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title 		= isset(  $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';
		$username 	= $instance['username'];

		wp_register_script( 'instagram_photostream', WPGRADE_SCRIPT_URL."instagram_photostream_widget.js", array('jquery'), wpgrade::themeversion(), true );
        wp_enqueue_script( 'instagram_photostream' );

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;

		//limit the number of images
		$count = isset( $args['count'] ) ? absint( $args['count'] ) : 8;

		$unique_id =  $username . $count ;
		$unique_id = preg_replace("/[^A-Za-z0-9]/", '', $unique_id);
		$html = '<ul id="' . $unique_id  .'" class="wpgrade-instagram-items"></ul>';
		$html .= '<script type="text/javascript"> jQuery(document).ready(function($){ ';
		$html .= '$("#' . $unique_id .'").instagram_photostream({user: "' . $username . '", limit:' . $count . '});';
		$html .= '});</script>';
		echo $html;

		echo $after_widget;
	}

	/**
	 * Validate and update widget options.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['count'] = absint( $new_instance['count'] );
		return $instance;
	}

	function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Instagram shots','lens');
		$username = isset ($instance['username']) ? esc_attr($instance['username']) : '';
		//default to 8 images
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 8;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'lens'); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php esc_html_e('Instagram username', 'lens'); ?>:</label>
			<input id="<?php echo $this->get_field_id('username'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $username; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'Number of images','lens'); ?>:</label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
		</p>
		<?php
	}
}

class wpgrade_contact_widget extends WP_Widget {

    public function __construct()
    {
        parent::__construct( 'wpgrade_contact_widget', esc_html__( '%s Contact Widget','lens'), wpgrade::themename(), array('description' => esc_html__('Display your contact information', 'lens')) );
    }

    function widget($args, $instance) {
        extract( $args );
        $title 		= isset(  $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';
        $social_label = $instance['social_label'];
        $social_name = $instance['social_name'];
        $social_link = $instance['social_link'];

        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;

        $contactinfo = array();
        $contactinfo['address'] = pixelgrade_option('contact_address');
        $contactinfo['phone'] = pixelgrade_option('contact_phone');
        $contactinfo['email'] = pixelgrade_option('contact_email');
        $contactinfo['social'] = array(
            'label' => $social_label,
            'name' => $social_name,
            'link' => $social_link,
        );

        if (count($contactinfo) > 0) {
            echo '<ul class="widget-contact-details">';
            foreach ($contactinfo as $info => $value) {
                echo '<li class="widget-contact-detail">';
                    switch ($info) {
                        case 'email':
                            echo '<span class="widget-contact-value"><a href="mailto:'. $value .'">'. $value .'</a></span>';
                            break;
                        case 'social':
                            echo '<span class="widget-contact-value"><a href="'.$value['link'].'" target="_blank">'. $value['name'] .'</a></span>';
                            break;
                        default:
                            echo '<span class="widget-contact-value">'. $value .'</span>';
                            break;
                    }
                echo '</li>';
            }
            echo '</ul>';
        } else {
            esc_html_e('No contact info to be displayed', 'lens');
        }

        echo $after_widget;
    }

    /**
     * Validate and update widget options.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['social_label'] = strip_tags($new_instance['social_label']);
        $instance['social_name'] = strip_tags($new_instance['social_name']);
        $instance['social_link'] = strip_tags($new_instance['social_link']);
        return $instance;
    }

    function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Contact us','lens');
        $social_label = isset( $instance['social_label'] ) ? $instance['social_label'] : '';
        $social_name = isset( $instance['social_name'] ) ? $instance['social_name'] : '';
        $social_link = isset( $instance['social_link'] ) ? $instance['social_link'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'lens'); ?>:</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <h4>Display a social link (optional)</h4>
        <p>
            <label for="<?php echo $this->get_field_id('social_label'); ?>"><?php esc_html_e('Label', 'lens'); ?>:</label>
            <input id="<?php echo $this->get_field_id('social_label'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social_label'); ?>" value="<?php echo $social_label; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('social_name'); ?>"><?php esc_html_e('Name', 'lens'); ?>:</label>
            <input id="<?php echo $this->get_field_id('social_name'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social_name'); ?>" value="<?php echo $social_name; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('social_link'); ?>"><?php esc_html_e('Link', 'lens'); ?>:</label>
            <input id="<?php echo $this->get_field_id('social_link'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social_link'); ?>" value="<?php echo $social_link; ?>" />
        </p>
    <?php
    }
}

/*
 * Display the tag cloud
 */
function custom_tag_cloud_widget($args) {
	$args['number'] = 0; //adding a 0 will display all tags
	$args['largest'] = 19; //largest tag
	$args['smallest'] = 19; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/*
 * Display the Latest Posts Slider
 */
class wpgrade_posts_slider_widget extends WP_Widget {

	public function __construct()
	{
		parent::__construct( 'wpgrade_posts_slider_widget', esc_html__(wpgrade::themename().' Latest Posts Slider','lens'), array('description' => esc_html__('Display the latest blog posts in your sidebar or footer', 'lens')) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title 		= isset(  $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';
		// default to 4 posts
		$number 	= isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;

		// The Query
		$options = array( 'posts_per_page' => $number );
		$latest_posts = new WP_Query( $options );

		// Reset Post Data
		wp_reset_postdata();

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		if ( $latest_posts->have_posts() ): ?>
			<div class="latest-posts-slider wp-slider">
				<ul class="latest-posts slides  js-pixslider"  data-autoheight>
					<?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
						<li class="latest-posts-post slide push--bottom">
              <div class="desk-span6">
                <?php if ( has_post_thumbnail() ) { ?>
                  <span class="latest-posts-thumnail-wrapper">
                    <?php the_post_thumbnail('portfolio-medium'); ?>
                  </span>
                <?php } else { ?>
                  <span class="latest-posts-thumnail-wrapper no-image">
                    <span><?php esc_html_e('No Image', 'lens'); ?></span>
                  </span>
                <?php } ?>
              </div>
              <div class="desk-span6">
				<div class="latest-posts-date"><?php the_time('F j, Y'); ?></div>
                <h4 class="latest-posts-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <div class="latest-posts-excerpt">
                  <p>
                    <?php
                      // $excerpt = get_the_excerpt();
                      $excerpt = substr(get_the_excerpt(), 0, 160);
                      echo $excerpt.'&hellip;';
                    ?>
                  </p>
                  <a class="btn btn-small btn-more" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'lens'); ?></a>
              </div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif;
		echo $after_widget;

		wp_reset_query();
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}

	function form($instance) {
		!empty($instance['title'])  ? $title = esc_attr($instance['title']) : $title = esc_html__('From the Blog','lens');
		// default to 4 posts
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4; ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php esc_html__('Title:', 'lens'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
				<?php esc_html__('Number of posts:', 'lens'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('number'); ?>" class="widefat" type="number" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" />
		</p>
		<?php
	}
}

/*
 * Display a Flickr photo stream
 */
class wpgrade_flickr_widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct( 'wpgrade_flickr_widget', esc_html__( wpgrade::themename() .' Flickr Widget','lens'), array('description' => esc_html__('Display Flickr images in your sidebar or footer (maximum 20 but we recommend less).','lens'),) );
	}

	/**
	 * The widget contents
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset(  $instance['title'] ) ?  apply_filters( 'widget_title', $instance['title'] ) : '';

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		{
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$photos = $this->get_photos( array(
			'username' => $instance['username'],
			'count' => $instance['count'],
			'tags' => $instance['tags'],
		) );

		if ( is_wp_error( $photos ) )
		{
			echo $photos->get_error_message();
		}
		else
		{
			echo '<ul class="wpgrade-flickr-items">';
			foreach ( $photos as $photo )
			{
				$link = esc_url( $photo->link );
				$src = esc_url($this->resize($photo->media->m));
				$title = esc_attr( $photo->title );
				$item = sprintf( '<a class="wpgrade-flickr-link" href="%s"><img src="%s" alt="%s" /></a>', $link, $src, $title );
				$item = sprintf( '<li class="wpgrade-flickr-item">%s</li>', $item );
				echo $item;
			}
			echo '</ul>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Returns an array of photos
	 */
	private function get_photos( $args = array() )
	{
		// do some caching to prevent Flickr from banning us
		$transient_key = md5( 'wpgrade-flickr-cache-' . print_r( $args, true ) );
		$cached = get_transient( $transient_key );

		//if there is a cached version use that one
		if ( $cached )
		{
			return $cached;
		}

		$username = isset( $args['username'] ) ? $args['username'] : '';
		$tags = isset( $args['tags'] ) ? $args['tags'] : '';
		$count = isset( $args['count'] ) ? absint( $args['count'] ) : 8;
		$query = array('tagmode' => 'any','tags' => $tags);

		// If username is actually an RSS feed
		if ( preg_match( '#^https?://api\.flickr\.com/services/feeds/photos_public\.gne#', $username ) )
		{
			$url = parse_url( $username );
			$url_query = array();
			wp_parse_str( $url['query'], $url_query );
			$query = array_merge( $query, $url_query );
		}
		elseif (strpos($username, '@N')) {
			//we are dealing with a user id
			$user_id = $username;
			$query['id'] = $user_id;
		} else {
			$user = $this->request( 'flickr.people.findByUsername', array( 'username' => $username ) );
			if ( is_wp_error( $user ) )
			{
				return $user;
			}

			$user_id = $user->user->id;
			$query['id'] = $user_id;
		}

		$photos = $this->request_feed( 'photos_public', $query );

		if ( ! $photos )
		{
			return new WP_Error( 'error', 'Something went wrong.' );
		}

		$photos = array_slice( $photos, 0, $count );
		//cache the photos for an hour
		set_transient( $transient_key, $photos, apply_filters( 'wpgrade_flickr_widget_cache_timeout', 3600 ) );
		return $photos;
	}

	/**
	 * Make a request to the Flickr API.
	 */
	private function request( $method, $args )
	{
		$args['method'] = $method;
		$args['format'] = 'json';
		// the api key we've aquired from Flickr
		$args['api_key'] = 'cf07a23ac8100c1b53c0fb164941bf62';
		$args['nojsoncallback'] = 1;
		$url = esc_url_raw( add_query_arg( $args, 'https://api.flickr.com/services/rest/' ) );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) )
		{
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
 		$obj = json_decode( $body );

		if ( $obj && $obj->stat == 'fail' )
		{
			return new WP_Error( 'error', $obj->message );
		}

		return $obj ? $obj : false;
	}

	/**
	 * Fetch items from the Flickr Feed API.
	 */
	private function request_feed( $feed = 'photos_public', $args = array() )
	{
		$args['format'] = 'json';
		$args['nojsoncallback'] = 1;
		$url = sprintf( 'https://api.flickr.com/services/feeds/%s.gne', $feed );
		$url = esc_url_raw( add_query_arg( $args, $url ) );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) )
		{
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$body = preg_replace( "#\\\\'#", "\\\\\\'", $body );
 		$obj = json_decode( $body );

		return $obj ? $obj->items : false;

	}

	/**
	 * Modify the url to get a new size of the image
	 */
	private function resize($url, $size = 'square')
	{
		$url_array = explode('/', $url);
		//strip the filename
		$photo = array_pop($url_array);

		switch($size)
		{
		  case 'square': $suffix = '_s.';  break;
		  case 'thumbnail': $suffix = '_t.';  break;
		  case 'small': $suffix = '_m.';  break;
		  case 'm640': $suffix = '_z.';  break;
		  case 'm800': $suffix = '_c.';  break;
		  case 's320': $suffix = '_n.';  break;
		  case 's150': $suffix = '_q.';  break;
		  case 'large': $suffix = '_b.';  break;
		  default:  $suffix = '.';  break; // Medium
		}

		// replace the old size marker with the needed one
		$url_array[] =  preg_replace('/(_(s|t|c|n|q|m|b|z))?\./i', $suffix, $photo);
		return implode('/', $url_array);
	}

	/**
	 * Validate and update widget options.
	 */
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tags'] = strip_tags( $new_instance['tags'] );
		$instance['count'] = absint( $new_instance['count'] );
		return $instance;
	}

	/**
	 * Render widget controls.
	 */
	public function form( $instance )
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Flickr Shots','lens');
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$tags = isset( $instance['tags'] ) ? $instance['tags'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 8;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title','lens'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php esc_html_e( 'Username or RSS url','lens'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php esc_html_e( 'Tags' ,'lens'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="text" value="<?php echo esc_attr( $tags ); ?>" /><br />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'Number of images','lens'); ?>:</label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
		</p>

		<?php
	}
}

// Register the widgets
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_contact_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_contact_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_posts_slider_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_flickr_widget");'));
