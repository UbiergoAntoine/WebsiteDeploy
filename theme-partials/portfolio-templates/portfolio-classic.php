<?php
/**
 * The template for the classic portfolio.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="main" class="content djax-updatable">
	<?php
	$client_name = '';
	$client_name = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_name', true );

	$client_link = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_link', true );
	if ( $client_link == '' ) {
		$client_link = '#';
	}

	?>
	<div class="page-content">
		<div class="page-main">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry__body' ); ?> >
				<header class="entry-header">
					<h1 class="entry__title" itemprop="headline"><?php the_title(); ?></h1>
				</header>
				<div class="entry__content project-entry-content js-project-gallery" itemprop="description">
					<?php the_content(); ?>
				</div><!-- .entry__content -->
				<hr class="separator--dotted separator--full-left"/>
				<footer class="entry__meta entry__meta--project cf">
					<?php if ( $client_name != '' ) : ?>
						<div class="entry__meta-box meta-box--client">
							<span class="meta-box__box-title"><?php esc_html_e( "Client", 'lens' ); ?>: </span>
							<a href="<?php echo esc_url( $client_link ); ?>" target="_blank"><?php echo $client_name; ?></a>
						</div>
					<?php endif; ?>
					<?php
					$categories = get_the_terms( $post->ID, 'lens_portfolio_categories' );
					if ( $categories && ! is_wp_error( $categories ) ): ?>
						<div class="entry__meta-box meta-box--categories span-12 hand-span-6">
							<span class="meta-box__box-title"><?php esc_html_e( "Filed under", 'lens' ); ?>: </span>
							<?php foreach ( $categories as $cat ): ?>
								<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" rel="category"><?php echo $cat->name; ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</footer><!-- .entry__meta .entry__meta--project -->
				<hr class="separator separator--striped separator--full-left"/>
				<footer class="entry__meta  flexbox">
					<?php
					if ( function_exists( 'display_pixlikes' ) ) {
						display_pixlikes( array( 'class' => 'likes-box  likes-box--footer  flexbox__item' ) );
					}

					if ( pixelgrade_option( 'portfolio_single_show_share_links' ) ) {
						get_template_part( 'theme-partials/addthis-share' );
					} ?>
				</footer><!-- .entry__meta -->

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) {
					comments_template();
				}
				?>
			</article><!-- #post -->

			<?php
			$yarpp_active = false;
			if ( function_exists( 'related_posts' ) ) {
				$yarpp_active = true;
			} ?>

			<section class="related-projects_container entry__body">
				<header class="related-projects_header">
					<?php if ( $yarpp_active ) : ?>
						<h4 class="related-projects_title"><?php esc_html_e( "Related projects", 'lens' ); ?></h4>
					<?php endif; ?>
					<nav class="projects_nav">
						<ul class="projects_nav-list">
							<li class="projects_nav-item">
								<?php next_post_link( '%link', '<span class="prev">&#8592;</span>' . esc_html__( 'Previous', 'lens' ) ); ?>
							</li>
							<li class="projects_nav-item">
								<a href="<?php echo esc_url( get_portfolio_page_link() ); ?>">
									<?php esc_html_e( "All projects", 'lens' ); ?>
								</a>
							</li>
							<li class="projects_nav-item">
								<?php previous_post_link( '%link', esc_html__( 'Next', 'lens' ) . '<span class="next">&#8594;</span>' ); ?>
							</li>
						</ul>
					</nav>
				</header>
				<?php
				if ( $yarpp_active ) {
					yarpp_related(
						array(
							// Pool options: these determine the "pool" of entities which are considered
							'post_type'      => array( 'lens_portfolio' ), // my cpt
							'show_pass_post' => false, // show password-protected posts
						),
						$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
						true // third argument: (optional) true to echo the HTML block; false to return it
					);
				}
				?>
			</section>
		</div><!-- .page-main -->
	</div><!-- .page-content -->
</div><!-- .content -->
