<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<div id="main" class="content djax-updatable">

		<?php if ( have_posts() ) :

			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop
			 * properly with a call to rewind_posts().
			 */
			the_post();
			?>

			<div class="masonry" data-columns>
				<div class="masonry__item archive-title">
					<div class="entry__header">
						<h1 class="entry__title"><?php printf( esc_html__( 'All posts by %s', 'lens' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
						<hr class="separator separator--dotted grow">
					</div>
					<div class="entry__content">
						<?php the_author_meta( 'description' ); ?>
					</div>
				</div><!-- .masonry__item -->

				<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
				?>

				<?php while ( have_posts() ) : the_post();
					get_template_part( 'theme-partials/post-templates/blog-content' );
				endwhile; ?>
			</div><!-- .masonry -->
			<div class="masonry__pagination"><?php echo wpgrade::pagination(); ?></div>

		<?php else :
			get_template_part( 'no-results', 'index' );
		endif; ?>

	</div>

<?php get_footer();
