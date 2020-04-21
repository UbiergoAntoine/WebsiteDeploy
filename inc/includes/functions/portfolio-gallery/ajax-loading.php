<?php

/**
 * Ajax loading of all projects
 */
function wpgrade_callback_load_all_portfolio_projects($front_page = false, $featured_first = true) {
	global $post;

	$paged = 1;

	if (get_query_var('paged')) {
		$paged = get_query_var('paged');
	}

	if (get_query_var('page')) {
		$paged = get_query_var('page');
	}

	$query_args = array
		(
			'post_type'      => 'portfolio',
			'posts_per_page' => 999, // unlikely number
			'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
//				'order'          => 'desc',
			'paged'          => $paged
		);

	if (isset( $_POST['offset'])) {
		$query_args['offset'] = (int)$_POST['offset'];
	}

	if ($featured_first) {
		$query_args['meta_key'] = wpgrade::prefix() .'portfolio_featured';
		$query_args['orderby'] = array('meta_value' => 'DESC', 'menu_order' => 'ASC', 'date' => 'DESC');

		add_filter( 'posts_orderby', 'custom_orderby_display_portfolio' );
		$query = new WP_Query( $query_args );
		remove_filter( 'posts_orderby', 'custom_orderby_display_portfolio' );
	}
	else {
		$query = new WP_Query($query_args);
	}

	ob_start();

	if ( ! empty($query)) {
		while ($query->have_posts()) {
			$query->the_post();
			$terms = wp_get_post_terms($post->ID, 'portfolio_cat', array("fields" => "slugs"));

			echo '<div class="portfolio-row row"'. ($terms ? 'data-terms="'. implode(' ', $terms).'"' : '').'>';

			$rows = get_post_meta( $post->ID, wpgrade::prefix() .'portfolio_rows', true);
			$rows = json_decode($rows, true);

			if ( ! empty($rows)) {
				// get only the first row
				wpgrade_get_portfolio_row((array)$rows[0], true);
			}

			echo "</div>";
		}
	}

	wp_reset_postdata();

	echo json_encode(ob_get_clean());
	die;
}

add_action('wp_ajax_wpgrade_load_all_portfolio_projects', 'wpgrade_callback_load_all_portfolio_projects');
add_action('wp_ajax_nopriv_wpgrade_load_all_portfolio_projects', 'wpgrade_callback_load_all_portfolio_projects');


add_action( 'wp_footer', 'lens_before_dynamic_content', 10 );

function lens_before_dynamic_content() {

	/**
	 * Localize a static list with resourses already loaded on the first page load this lists will be filled on
	 * each d-jax request which has new resources
	 *
	 * Note: make this dependent to wpgrade-main-scripts because we know for sure it is there
	 */
	wp_localize_script( 'wpgrade-main-scripts', 'lens_static_resources', array(
		'scripts' => lens::get_queued_scripts(),
		'styles'  => lens::get_queued_styles()
	) );

}


add_action('wp_footer', 'lens_last_function', 999999999);

/**
 * Display dynamic generated data while runing d-jax requests :
 *
 * a script which will load others scripts on the run
 */
function lens_last_function(){
	/**
	 * Display dynamic generated data while runing d-jax requests :
	 *
	 * a script which will load others scripts on the run
	 */
	$dynamic_scripts = lens::get_queued_scripts();
	$dynamic_styles  = lens::get_queued_styles();?>
	<div id="djax_list_scripts_and_styles">
		<div id="lens_list_scripts_and_styles" class="djax-updatable">
			<script id="lens_list_scripts_and_styles">
				(function ($) {
					// wait for all dom elements
					$(document).ready(function () {
						// run this only if we have resources
						if (!window.hasOwnProperty('lens_static_resources')) return;
						window.lens_dynamic_loaded_scripts = <?php echo json_encode( $dynamic_scripts ); ?>;
						window.lens_dynamic_loaded_styles = <?php echo json_encode( $dynamic_styles ); ?>;

						// run this only if we have resources
						if (!window.hasOwnProperty('lens_static_resources')) return;

						// lens_dynamic_loaded_scripts is generated in footer when all the scripts should be already enqueued
						$.each( window.lens_dynamic_loaded_scripts, function (key, url) {

							if (key in lens_static_resources.scripts) return;

							if (globalDebug) {console.dir("Scripts loaded dynamic");}
							if (globalDebug) {console.dir(key);}
							if (globalDebug) {console.log(url);}

							// add this script to our global stack so we don't enqueue it again
							lens_static_resources.scripts[key] = url;

							$.getScript(url)
								.done(function (script, textStatus) {
									$(document).trigger('lens:script:' + key + ':loaded');
								})
								.fail(function (jqxhr, settings, exception) {
									if (globalDebug) {console.log('I failed');}
								});

							if (globalDebug) {console.groupEnd();}

						});
						$(document).trigger('lens:page_scripts:loaded');

						$.each( window.lens_dynamic_loaded_styles, function (key, url) {

							if (key in lens_static_resources.styles) return;

							if (globalDebug) {console.dir("Styles loaded dynamic");}
							if (globalDebug) {console.dir(key);}
							if (globalDebug) {console.log(url);}

							// add this style to our global stack so we don't enqueue it again
							lens_static_resources.styles[key] = url;

							// sorry no cache this time
							$.ajax({
								url: url,
								dataType: 'html',
								success: function (data) {
									$('<style type="text/css">\n' + data + '</style>').appendTo("head");
									$(document).trigger('lens:style:' + key + ':loaded');
								}
							});

							if (globalDebug) {console.groupEnd();}
						});
						$(document).trigger('lens:page_styles:loaded');
					});
				})(jQuery);
			</script>
		</div>
	</div>
<?php
}