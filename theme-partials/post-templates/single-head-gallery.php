<?php
/**
 * The template for the single gallery post head.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="featured-image">
    <?php echo lens::gallery_slideshow($post); ?>
</div>
