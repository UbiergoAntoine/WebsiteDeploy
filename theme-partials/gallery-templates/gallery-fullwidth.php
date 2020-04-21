<?php
/**
 * The template for the fullwidth gallery.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="main" class="content djax-updatable">
	<?php
	$gallery_ids = get_post_meta( $post->ID, wpgrade::prefix() . 'main_gallery', true );
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

	$image_scale_mode     = get_post_meta( get_the_ID(), wpgrade::prefix() . 'gallery_image_scale_mode', true );
	$slider_visiblenearby = get_post_meta( get_the_ID(), wpgrade::prefix() . 'post_slider_visiblenearby', true );
	$slider_transition    = get_post_meta( get_the_ID(), wpgrade::prefix() . 'gallery_slider_transition', true );
	$slider_autoplay      = get_post_meta( get_the_ID(), wpgrade::prefix() . 'gallery_slider_autoplay', true );

	if ( $slider_autoplay ) {
		$slider_delay = get_post_meta( get_the_ID(), wpgrade::prefix() . 'gallery_slider_delay', true );
	}

	// Force transition to move if nearby images are visible
	// because fade transition is incompatible with nearby images
	if ( 'true' === $slider_visiblenearby ) {
		$slider_transition = 'move';
	}

	if ( $attachments ) : ?>
		<div class="pixslider js-pixslider  pixslider--gallery-fs"
		     data-customarrows="right"
		     data-fullscreen
		     data-imagealigncenter
		     data-imagescale="<?php echo esc_attr( $image_scale_mode ); ?>"
		     data-slidertransition="<?php echo esc_attr( $slider_transition ); ?>"

			<?php if ( $slider_autoplay ) {
				echo 'data-sliderautoplay="" ';
				echo 'data-sliderdelay="' . esc_attr( $slider_delay ) . '" ';
			}


			if ( "true" === $slider_visiblenearby ) {
				echo ' data-visiblenearby ';
			}
			?> >
			<?php
			foreach ( $attachments as $attachment ) :
				$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
				$thumbimg = wp_get_attachment_image_src( $attachment->ID, 'big' );
				$attachment_fields = get_post_custom( $attachment->ID );

				// check if this attachment has a video url
				$video_url = ( isset( $attachment_fields['_video_url'][0] ) && ! empty( $attachment_fields['_video_url'][0] ) ) ? esc_url( $attachment_fields['_video_url'][0] ) : '';

				//  if there is a video let royal slider know about it
				if ( ! empty( $video_url ) ) : ?>
					<div class="gallery-item video">
						<a href="<?php echo esc_url( $thumbimg[0] ); ?>" class="rsImg" data-rsVideo="<?php echo esc_url( $video_url ); ?>"><?php echo $attachment->post_title; ?></a>
						<?php echo lens_get_caption_markup( $attachment ); ?>
					</div>
				<?php else: ?>
					<div class="gallery-item" itemscope itemtype="http://schema.org/ImageObject">
						<a href="<?php echo esc_url( $thumbimg[0] ); ?>" class="attachment-blog-big rsImg" itemprop="contentURL"><?php echo $attachment->post_title; ?></a>
						<?php echo lens_get_caption_markup( $attachment ); ?>
					</div>
				<?php endif;
			endforeach; ?>
		</div>
	<?php endif; ?>
</div>
