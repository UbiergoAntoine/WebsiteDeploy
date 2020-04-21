<?php
/**
 * The template for the single video post head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$video_embed = get_post_meta( $post->ID, wpgrade::prefix().'video_embed', true );
if ( ! empty( $video_embed ) ): ?>
    <div class="featured-image">
        <div class="page-header-video">
            <div class="video-wrap">
                <?php echo stripslashes( htmlspecialchars_decode( $video_embed ) ) ?>
            </div>
        </div>
    </div>
<?php endif;
