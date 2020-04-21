<?php
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		?>
		<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

			<td class="product-thumbnail">
				<?php
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

				if ( ! $_product->is_visible() )
					echo $thumbnail;
				else
					printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
				?>
			</td>

			<td class="product-name" data-mobile-caption="<?php esc_html_e( 'Product', 'woocommerce' ); ?>">
				<?php
				if ( ! $_product->is_visible() )
					echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
				else
					echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

				// Meta data
				echo wc_get_formatted_cart_item_data( $cart_item );

				// Backorder notification
				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
					echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
				?>
			</td>

			<td class="product-quantity" data-mobile-caption="<?php esc_html_e( 'Quantity', 'woocommerce' ); ?>">
				<div class="pix-quantity">
					<?php

					//$product_quantity = sprintf( '<input type="text" name="cart[%s][qty]" step="%s" min="%s" max="%s" value="%s" size="4" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="input-text qty text" maxlength="12" data-item_key="%s" /></div>', $cart_item_key, $step, $min, $max, esc_attr( $values['quantity'] ), $cart_item_key );


					if ( $_product->is_sold_individually() ) {
						$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" data-item_key="%s" />', $cart_item_key, $cart_item_key );
					} else {
						$product_quantity = woocommerce_quantity_input( array(
							'input_name'  => "cart[{$cart_item_key}][qty]",
							'input_value' => $cart_item['quantity'],
							'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
							'item_key'    => $cart_item_key
						), $_product, false );
					}

					echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
					?>
				</div>
			</td>

			<td class="product-subtotal" data-mobile-caption="<?php esc_html_e( 'Price', 'woocommerce' ); ?>">
				<?php
				echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
				?>
			</td>


			<td class="product-remove">
				<?php
				echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s#" class="remove" title="%s"  data-item_key="%s", data-remove_nonce="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'woocommerce' ), $cart_item_key, wp_create_nonce("woo_remove_".$cart_item_key) ), $cart_item_key );
				?>
			</td>

		</tr>
	<?php
	}
}
