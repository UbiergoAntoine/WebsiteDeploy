<?php
/**
 * The template for the image post head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$title = get_the_title();
if ( ! empty( $title ) ): ?>
	<div class="article-timestamp">
		<div class="article-timestamp__date"><?php the_time( 'j' ); ?></div>
		<div class="article-timestamp__right-box">
			<span class="article-timestamp__month"><?php the_time( 'M' ); ?></span>
			<span class="article-timestamp__year"><?php the_time( 'Y' ); ?></span>
		</div>
	</div><!-- .article-timestamp -->
	<div class="entry__header">
		<h2 class="entry__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<hr class="separator separator--dotted grow">
	</div>
	<div class="entry__content"><?php the_excerpt(); ?></div>
<?php endif; ?>
<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry__featured-image">
		<a href="<?php the_permalink(); ?>" class="image__item-link">
			<div class="image__item-wrapper1">
				<?php the_post_thumbnail( 'blog-big' ); ?>
			</div>
		</a>
	</div>
<?php else:
	//search for the fist image in the content and try to use that
	$first_image_src = lens::get_post_format_first_image_src();
	if ( ! empty( $first_image_src ) ): ?>
		<div class="entry__featured-image">
			<a href="<?php the_permalink(); ?>" class="image__item-link mfp-video">
				<div class="image__item-wrapper1">
					<img src="<?php echo esc_url( $first_image_src ) ?>" alt=""/>
				</div>
			</a>
		</div>
	<?php endif;
endif;
