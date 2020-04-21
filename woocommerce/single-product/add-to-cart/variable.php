<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<section class="shopping__options">
	<form class="variations_form cart form-shopping  shopping--single-product" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

			<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

		<?php else : ?>

			<div class="variations row soft--bottom cf">

				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>

					<div class="col-12  small-col-6  float--left">
						<label for="<?php echo sanitize_title($name); ?>" class="shop__label"><?php echo wc_attribute_label( $name ); ?></label>
						<select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>" class="shop__select">
							<option value=""><?php echo esc_html__( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>

							<?php
							if ( is_array( $options ) ) {

								if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
									$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
								} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
									$selected_value = $selected_attributes[ sanitize_title( $name ) ];
								} else {
									$selected_value = '';
								}

								// Get terms if this is a taxonomy - ordered
								if ( taxonomy_exists( $name ) ) {

									$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

									foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
									}

								} else {

									foreach ( $options as $option ) {
										echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
									}

								}
							} ?>

						</select> <?php
//							if ( sizeof($attributes) == $loop ) echo '<a class="reset_variations btn  btn--medium" href="#reset">' . esc_html__( 'Clear selection', 'woocommerce' ) . '</a>';
						?>
					</div>

				<?php endforeach;?>

				<div class="single_variation_wrap col-12  push--top  float--left" style="display:none;">

					<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( 'woocommerce_before_single_variation' ); ?>

					<div class="single_variation  push--bottom"></div>
					<div class="variations_button ">
						<input type="hidden" name="variation_id" value="" />

						<?php woocommerce_quantity_input(); ?>

						<div class="push--top">
							<button type="submit" class="single_add_to_cart_button  btn  btn--medium"><?php echo $product->single_add_to_cart_text(); ?></button>
						</div>
					</div>
				</div>
				<div>
					<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="product_id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
					<input type="hidden" name="variation_id" class="variation_id" value="" />

					<?php
					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'woocommerce_after_single_variation' ); ?>

				</div>

			</div>

			<?php do_action('woocommerce_before_add_to_cart_button'); ?>

			<?php do_action('woocommerce_after_add_to_cart_button'); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>
</section>

<?php
do_action('woocommerce_after_add_to_cart_form');
