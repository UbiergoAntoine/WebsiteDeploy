<?php
/**
 * The template for the blog head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="article-timestamp">
    <div class="article-timestamp__date"><?php the_time('j'); ?></div>
    <div class="article-timestamp__right-box">
        <span class="article-timestamp__month"><?php the_time('M'); ?></span>
        <span class="article-timestamp__year"><?php the_time('Y'); ?></span>
    </div>
</div><!-- .article-timestamp -->

<div class="entry__header">
    <h2 class="entry__title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <hr class="separator separator--dotted grow">
</div>
<div class="entry__content"><?php the_excerpt(); ?></div>

<?php if ( has_post_thumbnail() ) : ?>
    <div class="entry__featured-image">
        <a href="<?php the_permalink(); ?>" class="image__item-link">
			<?php
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-big');
				$image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
				if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
					$image_ratio = $image[2] * 100/$image[1];
				}
			?>
            <div class="image__item-wrapper" style="padding-top: <?php echo $image_ratio ?>%;" >
                <?php the_post_thumbnail('blog-big'); ?>
            </div>
        </a>
    </div>
<?php endif;
