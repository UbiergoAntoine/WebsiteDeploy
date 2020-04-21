<?php
/**
 * The template for displaying Archive pages.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<div id="main" class="content djax-updatable">

		<?php if ( have_posts() ) :
			// lets handle the title display
			// we will use the page title
			?>
			<div class="masonry" data-columns>
				<div class="masonry__item  masonry__item--archive-title">
					<div class="entry__header">
						<h1 class="entry__title"><?php
							if ( is_day() ) :
								printf( esc_html__( 'Daily Archives: %s', 'lens' ), get_the_date() );
							elseif ( is_month() ) :
								printf( esc_html__( 'Monthly Archives: %s', 'lens' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'lens' ) ) );
							elseif ( is_year() ) :
								printf( esc_html__( 'Yearly Archives: %s', 'lens' ), get_the_date( _x( 'Y', 'yearly archives date format', 'lens' ) ) );
							else :
								_e( 'Archives', 'lens' );
							endif;
							?></h1>
					</div>
				</div><!-- .masonry__item -->
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
