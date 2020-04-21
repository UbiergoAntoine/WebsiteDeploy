<?php
/**
 * The template for the sidebar.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<div class="sidebar sidebar--right">
    <?php if ( ! dynamic_sidebar( 'sidebar-blog' ) ) :
    endif; ?>
</div>
