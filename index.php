<?php
/**
 * The main template.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<div id="main" class="content djax-updatable">

		<?php if ( have_posts() ) :
			//lets handle the title display
			//we will use the page title
			?>
			<div class="masonry" data-columns>
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'theme-partials/post-templates/blog-content' );
				endwhile; ?>
			</div><!-- .masonry -->
			<?php wpgrade::pagination(); ?>

		<?php else :
			get_template_part( 'no-results', 'index' );
		endif; ?>

	</div>

<?php get_footer();
