<?php
/**
 * The template for the search form.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<form class="form-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <input class="search-query" type="text" name="s" id="s" placeholder="<?php esc_html_e( 'Search...', 'lens'); ?>" autocomplete="off" value="<?php the_search_query(); ?>" />
    <button class="btn" name="submit" id="searchsubmit"><i class="icon-search"></i></button>
</form>
