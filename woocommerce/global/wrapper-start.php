<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div id="main" class="content djax-updatable">
	<div id="pix-cart" class="cart  cart--widget  sticky-button">
		<div class="cart__btn  sticky-button__btn  btn  btn--large">
			<div class="widget_shopping_cart_content">
			
				<?php /* Placeholder until the page is loaded */ ?>
					<span class="cart-text">Cart</span>
					<i class="pixcode  pixcode--icon  icon-shopping-cart"></i>

					<ul>
						<li class="cart-item  sticky-button-item">
							<span class="cart-total"><span>$0</span></span>
						</li>

						
						<li class="cart-item  sticky-button-item">
							<a href="<?php echo wc_get_cart_url(); ?>" class="cart-link dJAX_internal"><?php esc_html_e( 'View Cart', 'woocommerce' ); ?></a>
						</li>

						<li class="cart-item  sticky-button-item">
							<a href="<?php echo wc_get_checkout_url(); ?>" class="cart-link dJAX_internal"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
						</li>
					</ul>
				<?php /* End of Placeholder */ ?>

			</div>
		</div>
	</div>
