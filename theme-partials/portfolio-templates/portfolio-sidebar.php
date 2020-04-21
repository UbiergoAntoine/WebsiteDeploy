<?php
/**
 * The template for the sidebar portfolio.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="main" class="content djax-updatable">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry__body' ); ?> >
		<div class="page-content  page-content--with-sidebar  project--sidebar">

			<div class="page-main  project--sidebar__images  js-project-gallery">
				<h1 class="beta  entry__title  title-mobile"><?php the_title(); ?></h1>

				<?php
				$client_name = '';
				$client_name = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_name', true );

				$client_link = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_link', true );
				if ( $client_link == '' ) {
					$client_link = '#';
				}

				$gallery_ids = get_post_meta( $post->ID, wpgrade::prefix() . 'portfolio_gallery', true );
				if ( ! empty( $gallery_ids ) ) {
					$gallery_ids = explode( ',', $gallery_ids );
				} else {
					$gallery_ids = array();
				}

				if ( ! empty( $gallery_ids ) ) {
					$attachments = get_posts( array(
						'post_type'      => 'attachment',
						'posts_per_page' => - 1,
						'orderby'        => "post__in",
						'post__in'       => $gallery_ids,
					) );
				} else {
					$attachments = array();
				}

				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						$class          = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
						$thumbimg       = wp_get_attachment_image_src( $attachment->ID, 'blog-big' );
						$attachment_url = wp_get_attachment_url( $attachment->ID );

						$attachment_fields = get_post_custom( $attachment->ID );
						$video_url         = ( isset( $attachment_fields['_video_url'][0] ) && ! empty( $attachment_fields['_video_url'][0] ) ) ? esc_url( $attachment_fields['_video_url'][0] ) : '';
						$is_video          = false;
						//  if there is one let royal slider know about it
						if ( ! empty( $video_url ) ) {
							$attachment_url = $video_url;
							$is_video       = true;
							$class          .= ' mfp-iframe mfp-video';
						} else {
							$class .= ' mfp-image';
						}

						//whether or not to show the title and caption in popups
						$img_title   = '';
						$img_caption = '';
						if ( pixelgrade_option( 'show_title_caption_popup' ) ) {
							$img_title   = $attachment->post_title;
							$img_caption = $attachment->post_excerpt;
						}

						echo '<a href="' . esc_url( $attachment_url ) . '" class="' . esc_attr( $class ) . '" title="' . esc_attr( $attachment->post_title ) . '" data-title="' . esc_attr( $img_title ) . '" data-alt="' . esc_attr( $img_caption ) . '" data-design-thumbnail itemscope itemtype="http://schema.org/ImageObject" itemprop="contentURL"><img alt="" src="' . esc_url( $thumbimg[0] ) . '" itemprop="thumbnailUrl" /></a>';
					}
				}
				?>
			</div><!-- .page-main -->

			<div class="page-side  project--sidebar__content">

				<div class="entry-header">
					<div class="beta  entry__title  title-lap" itemprop="headline"><?php the_title(); ?></div>
				</div>
				<hr class="separator separator--dotted"/>

				<div class="entry__content project-entry-content" itemprop="description">
					<?php the_content(); ?>
				</div><!-- .entry__content -->


				<?php $categories = get_the_terms( $post->ID, 'lens_portfolio_categories' ); ?>
				<?php if ( $client_name !== '' && ! empty( $categories ) && ! is_wp_error( $categories ) ): ?>
					<hr class="separator separator--dotted"/>
					<footer class="entry__meta entry__meta--project row cf">
						<?php if ( $client_name !== '' ) : ?>
							<div class="entry__meta-box meta-box--client col-12 hand-col-6">
								<span class="meta-box__box-title"><?php esc_html_e( "Client", 'lens' ); ?>: </span>
								<a href="<?php echo $client_link; ?>" target="_blank"><?php echo $client_name; ?></a>
							</div>
						<?php endif; ?>
						<?php if ( $categories && ! empty( $categories ) && ! is_wp_error( $categories ) ): ?>
							<div class="entry__meta-box meta-box--categories col-12 hand-col-6">
								<span class="meta-box__box-title"><?php esc_html_e( "Filed under", 'lens' ); ?>: </span>
								<?php foreach ( $categories as $cat ): ?>
									<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" rel="category">
										<?php echo $cat->name; ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</footer><!-- .entry__meta .entry__meta-project -->
				<?php endif; ?>

				<hr class="separator separator--striped"/>

				<footer class="entry__meta entry__meta--project flexbox">
					<?php
					if ( function_exists( 'display_pixlikes' ) ) {
						display_pixlikes( array( 'class' => 'likes-box--footer flexbox__item' ) );
					}

					if ( pixelgrade_option( 'portfolio_single_show_share_links' ) ) {
						get_template_part( 'theme-partials/addthis-share' );
					} ?>
				</footer><!-- .entry__meta -->
			</div><!-- .page-side -->

			<div class="page-main  project--sidebar__related">
				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) {
					comments_template();
				}

				$yarpp_active = false;
				if ( function_exists( 'related_posts' ) ) {
					$yarpp_active = true;
				}
				?>
				<aside class="related-projects_container entry__body">
					<div class="related-projects_header">
						<?php if ( $yarpp_active ) : ?>
							<h4 class="related-projects_title"><?php esc_html_e( "Related projects", 'lens' ); ?></h4>
						<?php endif; ?>
						<div class="projects_nav">
							<ul class="projects_nav-list">
								<li class="projects_nav-item">
									<?php next_post_link( '%link', '<span class="prev">&#8592;</span>' . esc_html__( 'Previous', 'lens' ) ); ?>
								</li>
								<li class="projects_nav-item">
									<a href="<?php echo get_portfolio_page_link(); ?>">
										<?php esc_html_e( "All projects", 'lens' ); ?>
									</a>
								</li>
								<li class="projects_nav-item">
									<?php previous_post_link( '%link', esc_html__( 'Next', 'lens' ) . '<span class="next">&#8594;</span>' ); ?>
								</li>
							</ul>
						</div>
					</div>
					<?php
					if ( $yarpp_active ):
						yarpp_related(
							array(
								// Pool options: these determine the "pool" of entities which are considered
								'post_type'      => array( 'lens_portfolio' ), // my cpt
								'show_pass_post' => false, // show password-protected posts
							),
							$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
							true // third argument: (optional) true to echo the HTML block; false to return it
						);
					endif;
					?>
				</aside>
			</div>
		</div>
	</article><!-- #post -->
</div><!-- .content -->
