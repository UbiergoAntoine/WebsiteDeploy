<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<h4  class="no-products-error  soft  push--left"><?php esc_html_e( 'No products found which match your selection.', 'woocommerce' ); ?></h4>
