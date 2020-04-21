<?php
/**
 * Woocommerce support
 * If woocommerce is active and is required woo support then load tehm all
 */
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || ! pixelgrade_option('enable_woocommerce_support' ) ) return;

/**
 * Assets
 */
function wpgrade_callback_load_woocommerce_assets(){
	$theme = wp_get_theme();

	// enqueue this script on all pages
	wp_enqueue_style('wpgrade-woocommerce', get_template_directory_uri() . '/woocommerce.css', array('wpgrade-main-style'), $theme->get( 'Version' ) );
	wp_enqueue_script('wpgrade-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', array('jquery', 'jquery-cookie', 'wp-util'), $theme->get( 'Version' ), true );

	global $wp, $woocommerce;
	$assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
	$woocommerce_params['locale'] = json_encode( WC()->countries->get_country_locale() );

//	localize_printed_scripts
	if( class_exists('WC_Frontend_Scripts') ) {
		WC_Frontend_Scripts::localize_printed_scripts();

		$add_to_cart_params =  array(
			'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
			'i18n_make_a_selection_text'       => esc_attr__( 'Select product options before adding this product to your cart.', 'woocommerce' ),
			'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' )
		);

		wp_localize_script( 'wpgrade-woocommerce', 'wc_add_to_cart_variation_params', apply_filters( 'wc_add_to_cart_params', $add_to_cart_params ) );

		wc_get_template( 'single-product/add-to-cart/variation.php' );

	}
}
add_action('wp_enqueue_scripts','wpgrade_callback_load_woocommerce_assets',9999);

// Ensure cart contents update when products are added to the cart via AJAX
add_filter('woocommerce_add_to_cart_fragments', 'woopgrade_header_add_to_cart_fragment');
function woopgrade_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start(); ?>
	<a class="cart-contents" href="<?php echo wc_get_cart_url() ?>" title="<?php esc_html_e('View your shopping cart', 'woothemes'); ?>">
		<?php echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'woothemes'), WC()->cart->cart_contents_count);?> - <?php echo WC()->cart->get_cart_total(); ?>
	</a>
	<?php $fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

// add_filter( 'woocommerce_add_to_cart_message', 'wpgrade_add_to_cart_button', 999);
function wpgrade_add_to_cart_button( $message )
{
	// Here you should modify $message as you want, and then return it.
	$newButtonString = 'View cart';
	$replaceString = '<p><a$1class="btn btn--medium">' . $newButtonString .'</a>';
	$message = preg_replace('#<a(.*?)class="button">(.*?)</a>#', $replaceString, $message);
	return $message.'</p>';
}

/* This snippet removes the action that inserts thumbnails to products in teh loop
 * and re-adds the function customized with our wrapper in it.
 * It applies to all archives with products.
 *
 * @original plugin: WooCommerce
 * @author of snippet: Brian Krogsard
 */

/**
 * WooCommerce Loop Product Thumbs
 **/

 if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
	 remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	 add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	 function woocommerce_template_loop_product_thumbnail() {

		 global $post;

		 $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-big');
		 $image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
		 if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
			 $image_ratio = $image[2] * 100/$image[1];
		 }

		 echo '<div class="product__image-wrapper" style="padding-top: '. $image_ratio .'%;">';
			 echo woocommerce_get_product_thumbnail('blog-big');
		 echo '</div>';
	 }
 }

/**
 * WooCommerce Loop Categories Thumbs
 **/

if ( ! function_exists( 'woocommerce_subcategory_thumbnail' ) ) {
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
	add_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
	function woocommerce_subcategory_thumbnail( $category ) {
		$image = wp_get_attachment_image_src( get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  ), 'blog-big');

		$image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
		if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
			$image_ratio = $image[2] * 100/$image[1];
		} else {
			$image_ratio = 100;
			$image[0] = wc_placeholder_img_src();
		}

		echo '<div class="product__image-wrapper" style="padding-top: '. $image_ratio .'%;">';
		echo '<img src="' . $image[0] . '" alt="' . $category->name . '" />';
		echo '</div>';
	}
}


/**
 * WooCommerce Product Thumbnail
 **/
 if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	 function woocommerce_get_product_thumbnail( $size = 'blog-big', $placeholder_width = 0, $placeholder_height = 0  ) {
		 global $post;
		 if ( has_post_thumbnail() ) {
			 return get_the_post_thumbnail( $post->ID, $size );
		 } else {
			 return '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder"/>';
		 }
	 }
 }

add_action('wp_ajax_woopix_remove_from_cart', 'woopix_remove_from_cart');
add_action('wp_ajax_nopriv_woopix_remove_from_cart', 'woopix_remove_from_cart');
function woopix_remove_from_cart() {
	global $woocommerce;
	$result = array('success' => false);

	check_ajax_referer( 'woo_remove_' . $_POST['remove_item'], 'remove_nonce' );

	WC()->cart->set_quantity( $_POST['remove_item'], 0 );
	$result['success'] = true;
	$result['removed_item'] = $_POST['remove_item'];
	echo json_encode($result);

	die();
}

add_action('wp_ajax_woopix_update_cart', 'woopix_update_cart');
add_action('wp_ajax_nopriv_woopix_update_cart', 'woopix_update_cart');
function woopix_update_cart() {
	global $woocommerce;
	$result = array('success' => false);

	WC()->cart->set_quantity( $_POST['remove_item'], $_POST['qty'] );
	ob_start();

	wc_get_template_part('woocommerce/cart/cart-loop');

	$result['cart_items'] = ob_get_clean();

	ob_start();

	if ( ! defined('WOOCOMMERCE_CART') ) define( 'WOOCOMMERCE_CART', true );

	if ( isset( $_POST['shipping_method'] ) )
		WC()->session->chosen_shipping_method = $_POST['shipping_method'];

	WC()->cart->calculate_totals();

	//get_template_part('woocommerce/cart/cart-totals');

	$result['totals'] = ob_get_clean();
	$result['success'] = true;
	echo json_encode($result);
	die();
}

// add woocommerce urls to djax ignore list
function localize_djax_ignored_woo_links(){

	$djax_ignored_links = array();
	$checkout_page_url = get_permalink( wc_get_page_id( 'checkout' ) );

	if ( ! empty($checkout_page_url) ) {
		$djax_ignored_links[] = $checkout_page_url;
	}

	$cart_page_url = get_permalink( wc_get_page_id( 'cart' ) );
	if ( ! empty($cart_page_url) ) {
		$djax_ignored_links[] = $cart_page_url;
	}

	if ( ! empty ( $djax_ignored_links ) ) {
		wp_localize_script( 'wpgrade-main-scripts', 'djax_ignored_links', $djax_ignored_links );
	}
}

add_action( 'wp_enqueue_scripts', 'localize_djax_ignored_woo_links' );

/**
 * Override the number of products with our theme option
 */
add_filter( 'loop_shop_per_page', 'add_woocommerce_products_per_page', 20 );
function add_woocommerce_products_per_page($cols) {
	return pixelgrade_option('woocommerce_products_numbers', 12);
}

/**
 * We will add a `#` at the end of each product link.
 * This will tell the djax script that this page doesn't need to be ajaxified
 *
 * @param $url
 * @param $post
 * @param bool $leavename
 *=
 * @return string
 */
function lens_ignore_products_from_ajax( $url, $post, $leavename=false ) {
	if ( $post->post_type == 'product' ) {
		return $url . '#';
	}
	return $url;
}
add_filter( 'post_type_link', 'lens_ignore_products_from_ajax', 10, 3 );

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
	return 'blog-medium';
} );

