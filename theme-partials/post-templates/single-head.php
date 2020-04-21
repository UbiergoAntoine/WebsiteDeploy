<?php
/**
 * The template for the single post head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( has_post_thumbnail() ) : ?>
	<div class="featured-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
		<?php the_post_thumbnail( 'large', array( 'itemprop' => 'url' ) ); ?>
		<?php
		//output the image meta so we can keep Google happy
		$image_meta = wp_get_attachment_metadata( get_post_thumbnail_id() );
		$image_size = _wp_get_image_size_from_meta( 'large', $image_meta );
		if ( ! empty( $image_size ) ) {
			echo '<meta itemprop="width" content="' . esc_attr( $image_size[0] ) . '">';
			echo '<meta itemprop="height" content="' . esc_attr( $image_size[1] ) . '">';
		} ?>
	</div>
<?php endif;
