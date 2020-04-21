<?php
/**
 * The template for the single audio post head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$html_title  = get_post_meta( get_the_ID(), wpgrade::prefix() . 'post_html_title', true );
$audio_embed = get_post_meta( $post->ID, wpgrade::prefix() . 'audio_embed', true )
?>

<div class="featured-image">
	<?php if ( ! empty( $audio_embed ) ) {
		echo stripslashes( htmlspecialchars_decode( $audio_embed ) );
	} else { # audio_embed is empty
		wpgrade::audio_selfhosted( $post->ID );
	} ?>
</div>
