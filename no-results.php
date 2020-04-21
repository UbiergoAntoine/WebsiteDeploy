<?php
/**
 * The template for the no results page.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
	<div id="main" class="content djax-updatable">
		<div class="page-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'theme-partials/post-templates/single-head', get_post_format() ); ?>
				<div class="entry__body">
					<article id="post-0" class="post error404 not-found">
						<header class="entry-header">
							<h1 class="heading-404"><?php esc_html_e( '404', 'lens' ); ?></h1>
							<h1 class="entry__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'lens' ); ?></h1>
							<p><?php printf( __( 'This may be because of a mistyped URL, faulty referral or out-of-date search engine listing.<br />You should try the <a href="%s">homepage</a> instead or maybe do a search?', 'lens' ), home_url() ); ?></p>
							<div class="search-form">
								<?php get_search_form(); ?>
							</div>
					</article>
				</div>
			<?php endwhile; ?>
		</div><!-- .page-content -->
		<?php get_sidebar(); ?>
	</div><!-- .content -->
<?php get_footer();
