<?php
/**
 * The template for the single proof_gallery CPT.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

global $wpgrade_private_post;

if ( post_password_required() && ! $wpgrade_private_post['allowed'] ) {
	// password protection
	get_template_part( 'theme-partials/password-request-form' );

} else {
	global $post; ?>

	<div id="main" class="content full-width djax-updatable">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( has_post_thumbnail() ): ?>
				<div class="featured-image"><?php the_post_thumbnail(); ?></div>
			<?php endif; ?>
			<div class="page-content">
				<div class="page-main">
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
				</div>
			</div><!-- .page-content -->
		<?php endwhile; ?>
	</div>
	<?php
}
get_footer();
