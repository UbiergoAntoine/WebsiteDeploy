<?php
/**
 * Template Name: Right Sidebar Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
	<div id="main" class="content djax-updatable">
		<div class="page-content page-content--with-sidebar">
			<div class="page-main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( has_post_thumbnail() ): ?>
						<div class="featured-image"><?php the_post_thumbnail(); ?></div>
					<?php endif; ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry__header">
							<h1 class="entry__title"><?php the_title(); ?></h1>
							<div class="bleed--left"><hr class="separator separator--dotted grow"></div>
						</header>

						<div class="entry__body">
							<div class="entry__content"><?php the_content(); ?></div>
							<?php if ( comments_open() || '0' != get_comments_number() ): ?>
								<hr class="separator separator--striped">
								<?php comments_template(); ?>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="page-side">
				<?php get_sidebar(); ?>
			</div>
		</div><!-- .page-content -->
	</div>
<?php get_footer();
