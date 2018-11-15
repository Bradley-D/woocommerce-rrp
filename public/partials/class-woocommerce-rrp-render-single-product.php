<?php
/**
 * Renders the rrp output on a single product.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/public/partials
 * @since      2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Public parent class that pulls everything together.
 *
 * @since 2.0.0
 */
class WooCommerce_RRP_Render_Single_Product {
	/**
	 * The Constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->woo_rrp_public_single_activate();
	}

	/**
	 * Add all filter type actions.
	 *
	 * @since 2.0
	 */
	public function woo_rrp_public_single_activate() {
		if ( ! is_admin() ) :
			add_filter( 'woocommerce_get_price_html', array( $this, 'woo_rrp_price_html' ), 100, 2 );
		endif;
	}

	/**
	 * Output the field values to the product price on the front end.
	 *
	 * @since 1.0
	 * @param int   $price Allows access to the product price.
	 * @param mixed $product Allows access to product object.
	 */
	public function woo_rrp_price_html( $price, $product ) {
		// Let's get the data we entered in the WC UI.
		$woo_rrp_before_price      = apply_filters( 'woo_rrp_before_price', get_option( 'woo_rrp_before_price', 1 ) ) . ' ';
		$woo_rrp_before_sale_price = apply_filters( 'woo_rrp_before_sale_price', get_option( 'woo_rrp_before_sale_price', 1 ) ) . ' ';
		$woo_rrp_archive_option    = get_option( 'woo_rrp_archive_option', 1 );

		// Check $price is not empty.
		if ( '' !== $price ) :

			if ( 'yes' === $woo_rrp_archive_option ) : // Enable archive template display selected.

				if ( $product->is_on_sale() ) : // Product is on sale.
					$woo_rrp_replace = array(
						'<del>' => '<del><span class="rrp-price">' . esc_attr_x( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>',
						'<ins>' => '<br><span class="rrp-sale">' . esc_attr_x( $woo_rrp_before_sale_price, 'woocommerce-rrp' ) . '</span><ins>',
					);

					$string_return = str_replace( array_keys( $woo_rrp_replace ), array_values( $woo_rrp_replace ), $price );

				else : // Product is not on sale.

					$string_return = '<span class="rrp-price">' . esc_attr_x( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>' . $price;

				endif;

			else : // Single product display only.

				if ( is_product() && $product->is_on_sale() ) : // Is single product and is on sale.
					$woo_rrp_replace = array(
						'<del>' => '<del><span class="rrp-price">' . esc_attr_x( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>',
						'<ins>' => '<br><span class="rrp-sale">' . esc_attr_x( $woo_rrp_before_sale_price, 'woocommerce-rrp' ) . '</span><ins>',
					);

					$string_return = str_replace( array_keys( $woo_rrp_replace ), array_values( $woo_rrp_replace ), $price );

				elseif ( is_product() ) : // Single product.

					$string_return = '<span class="rrp-price">' . esc_attr_x( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>' . $price;

				else : // Return price without additional text on all other instances.

					$string_return = $price;

				endif;

			endif;

			return $string_return;

		endif;
	}
}

/**
 * Instantiate the class
 *
 * @since 2.0.0
 */
$woocommerce_rrp_render_single_product = new WooCommerce_RRP_Render_Single_product();
