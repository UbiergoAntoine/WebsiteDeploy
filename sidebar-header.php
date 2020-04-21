<?php
/**
 * The template for the header sidebar.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (is_active_sidebar('sidebar-header')): ?>
	<div class="sidebar--header">
		<?php dynamic_sidebar('sidebar-header'); ?>
	</div>
<?php endif;
