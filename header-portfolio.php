<?php
/**
 * The template for the portfolio CPT header.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//this is just for the doctype and <head> section
get_template_part( 'theme-partials/header/head' );

$class_name = '';
if ( is_single() && get_post_type() == 'lens_portfolio' ) {
	$class_name = 'single-portfolio-';
	$class_name .= get_post_meta( get_the_ID(), wpgrade::prefix() . 'project_template', true );
} else {
	//we are in some sort of archive
	$class_name = 'portfolio-archive';
}

if ( pixelgrade_option( 'header_inverse' ) ) {
	$class_name .= " header-inverse";
}

$data_ajaxloading     = ( pixelgrade_option( 'use_ajax_loading' ) ) ? 'data-ajaxloading' : '';
$data_smoothscrolling = ( pixelgrade_option( 'use_smooth_scroll' ) ) ? 'data-smoothscrolling' : '';

//we use this so we can generate links with post id
//right now we use it to change the Edit Post link in the admin bar
$data_currentID         = '';
$data_currentEditString = '';
$data_currentTaxonomy   = '';
if ( ( pixelgrade_option( 'use_ajax_loading' ) ) ) {
	global $wp_the_query;
	$current_object = $wp_the_query->get_queried_object();

	if ( ! empty( $current_object->post_type )
	     && ( $post_type_object = get_post_type_object( $current_object->post_type ) )
	     && current_user_can( 'edit_post', $current_object->ID )
	     && $post_type_object->show_ui && $post_type_object->show_in_admin_bar
	) {

		$data_currentID = 'data-curpostid="' . $current_object->ID . '"';
		if ( isset( $post_type_object->labels ) && isset( $post_type_object->labels->edit_item ) ) {
			$data_currentEditString = 'data-curpostedit="' . $post_type_object->labels->edit_item . '"';
		}
	} elseif ( ! empty( $current_object->taxonomy )
	           && ( $tax = get_taxonomy( $current_object->taxonomy ) )
	           && current_user_can( $tax->cap->edit_terms )
	           && $tax->show_ui
	) {

		$data_currentID       = 'data-curpostid="' . $current_object->term_id . '"';
		$data_currentTaxonomy = 'data-curtaxonomy="' . $current_object->taxonomy . '"';
		if ( isset( $tax->labels ) && isset( $tax->labels->edit_item ) ) {
			$data_currentEditString = 'data-curpostedit="' . $tax->labels->edit_item . '"';
		}
	}
}

if ( pixelgrade_option( 'enable_copyright_overlay' ) ) {
	$class_name .= '  is--copyright-protected  ';
}
?>

<body <?php body_class( $class_name ); echo ' ' . $data_ajaxloading . ' ' . $data_smoothscrolling . ' ' . $data_currentID . ' ' . $data_currentEditString . ' ' . $data_currentTaxonomy; ?>>
<?php wp_body_open(); ?>
<div class="pace">
	<div class="pace-activity"></div>
</div>
<?php if ( pixelgrade_option( 'enable_copyright_overlay' ) ) : ?>
	<div class="copyright-overlay">
		<div class="copyright-overlay__container">
			<div class="copyright-overlay__content">
				<?php echo pixelgrade_option( 'copyright_overlay_text' ) ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<div id="page">
	<nav class="navigation  navigation--mobile">
		<h2 class="accessibility"><?php esc_html_e( 'Primary Mobile Navigation', 'lens' ) ?></h2>
		<div id="nav-wrapper" class="djax-updatable">
			<?php
			wpgrade_main_nav_mobile();
			?>
		</div>
		<div class="nav-meta">
			<?php
			get_sidebar( 'header' );

			wpgrade_social_nav();
			?>
			<div class="site-info">
				<?php echo pixelgrade_footer_get_copyright_content(); ?>
			</div><!-- .site-info -->
		</div>
	</nav>
	<div class="wrapper">
<?php //get the main header section - logo, nav, footer
get_template_part( 'theme-partials/header/site' );
