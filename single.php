<?php
/**
 * The template for the single post.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
	<div id="main" class="content djax-updatable">

		<div class="page-content  page-content--with-sidebar">

			<div class="page-main entry__body" itemprop="mainEntity" itemscope itemtype="http://schema.org/Article"
			     itemid="<?php echo lens_get_current_canonical_url(); ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'theme-partials/post-templates/single-head', get_post_format() ); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
						<meta itemprop="author" content="<?php echo get_the_author(); ?>">
						<header class="entry-header">
							<div class="entry-header__meta">
								<div class="article-timestamp article-timestamp--single">
									<div class="article-timestamp__date"><?php the_time( 'j' ); ?></div>
									<div class="article-timestamp__right-box">
										<span class="article-timestamp__month"><?php the_time( 'M' ); ?></span>
										<span class="article-timestamp__year"><?php the_time( 'Y' ); ?></span>
									</div>
									<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
								</div><!-- .article-timestamp -->
							</div><!-- .entry-header__meta -->
							<h1 class="entry__title" itemprop="headline name"><?php the_title(); ?></h1>
							<hr class="separator separator--dotted separator--full-left grow">
						</header>


						<div class="entry__wrap">
							<div class="entry__likes">
								<?php if ( function_exists( 'display_pixlikes' ) ) {
									display_pixlikes( array( 'class' => 'likes-box--article' ) );
								} ?><!-- .likes-box -->
							</div>
							<div class="entry__content"><?php the_content(); ?></div>
						</div>

						<?php wp_link_pages(); // pagination for posts with <!--nextpage--> ?>

						<footer class="entry__meta cf">
							<?php $categories = wp_get_post_categories( $post->ID ); ?>
							<?php if ( $categories && count( $categories ) ): ?>
								<div class="entry__meta-box meta-box--categories">
									<span class="meta-box__box-title"><?php esc_html_e( "Filed under", 'lens' ); ?>: </span>
									<?php foreach ( $categories as $cat ): ?>
										<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" rel="category">
											<?php echo get_category( $cat )->name; ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php $tags = wp_get_post_tags( $post->ID );
							if ( count( $tags ) ): ?>
								<div class="entry__meta-box meta-box--tags">
									<span class="meta-box__box-title"><?php esc_html_e( "Tagged", 'lens' ); ?>: </span>
									<?php foreach ( $tags as $tag ) : ?>
										<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" rel="tag">
											<?php echo $tag->name; ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif;

							if ( pixelgrade_option( 'blog_single_show_share_links' ) ) {
								get_template_part( 'theme-partials/addthis-share' );
							} ?>
						</footer><!-- .entry-meta -->
						<hr class="separator separator--striped">
						<?php

						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) {
							comments_template();
						}
						?>
					</article>
				<?php endwhile; ?>

			</div><!-- .page-main -->

			<div class="page-side">
				<?php get_sidebar(); ?>
			</div>

		</div><!-- .page-content -->

	</div><!-- .content -->
<?php get_footer();
