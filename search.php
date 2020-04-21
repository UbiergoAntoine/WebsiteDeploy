<?php
/**
 * The template for displaying Search Results pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
	<div id="main" class="content djax-updatable">
		<?php if ( have_posts() ) {
			//lets handle the title display
			//we will use the page title ?>
			<div class="masonry" data-columns>
				<div class="masonry__item archive-title">
					<div class="entry__header">
						<h1 class="entry__title"><?php printf( esc_html__( 'Search Results for: %s', 'lens' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</div>
				</div>
				<!-- .masonry__item -->
				<?php while ( have_posts() ) : the_post();
					get_template_part( 'theme-partials/post-templates/blog-content' );
				endwhile; ?>
			</div><!-- .masonry -->
		<?php } else { ?>
			<div class="page-content">
				<div class="page-main">
					<div class="entry__body">
						<article id="post-0" class="post error404 not-found">
							<header class="entry-header">
								<h1 class="heading-404"><?php esc_html_e( 'No Results', 'lens' ); ?></h1>

								<h1 class="entry__title"><?php esc_html_e( 'Oops! Nothing found.', 'lens' ); ?></h1>

								<p><?php printf( esc_html__( 'Try again?', 'lens' ), home_url() ); ?></p>

								<div class="search-form">
									<?php get_search_form(); ?>
								</div>
							</header>
						</article>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php get_footer();
