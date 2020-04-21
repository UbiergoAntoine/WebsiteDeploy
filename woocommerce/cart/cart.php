<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" class="cart-form">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' );

		get_template_part('woocommerce/cart/cart-loop');

		do_action( 'woocommerce_cart_contents' );
		?>

	</tbody>
</table>

<!-- Totals -->
<?php woocommerce_cart_totals(); ?>

<tr class="cart-buttons">
	<td colspan="4" class="actions">

		<?php if ( WC()->cart->coupons_enabled() ) { ?>
			<div class="coupon"  style="display:none;">

				<label for="coupon_code"><?php esc_html_e( 'Coupon', 'woocommerce' ); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="btn btn--medium" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'woocommerce' ); ?>" />

				<?php do_action('woocommerce_cart_coupon'); ?>

			</div>
		<?php } ?>

		<?php if ( !pixelgrade_option('use_ajax_loading') ) { ?>
			<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />
		<?php } ?>

		<?php wp_nonce_field('woocommerce-cart') ?>
	</td>
	<td class="product-remove"></td>

</tr>

<?php do_action( 'woocommerce_after_cart_contents' ); ?>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
