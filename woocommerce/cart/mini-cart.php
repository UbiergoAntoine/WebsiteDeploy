<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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

do_action( 'woocommerce_before_mini_cart' ); ?>

	<span  class="cart-text"><?php esc_html_e('Cart', 'woocommerce'); ?></span>
	<i class="pixcode  pixcode--icon  icon-shopping-cart"><span class="cart-size"><?php echo count( WC()->cart->get_cart() ); ?></span></i>

	<ul>
		<li class="cart-item  sticky-button-item">
			<span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</li>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<li class="cart-item  sticky-button-item">
			<a href="<?php echo wc_get_cart_url(); ?>" class="cart-link wc-forward dJAX_internal"><?php esc_html_e( 'View Cart', 'woocommerce' ); ?></a>
		</li>

		<li class="cart-item  sticky-button-item">
			<a href="<?php echo wc_get_checkout_url(); ?>" class="cart-link wc-forward dJAX_internal"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
		</li>
	</ul>

<?php do_action( 'woocommerce_after_mini_cart' );

