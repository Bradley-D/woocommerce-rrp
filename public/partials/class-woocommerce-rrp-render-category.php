<?php
/**
 * Renders the rrp output on a category.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/public/partials
 * @since      1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Public parent class that pulls everything together.
 *
 * @since 1.7.0
 */
class WooCommerce_RRP_Render_Category {
	/**
	 * The Constructor.
	 *
	 * @since 1.7.0
	 */
	public function __construct() {
		$this->woo_rrp_public_category_activate();
	}

	/**
	 * Add all filter type actions.
	 *
	 * @since 1.7.0
	 */
	public function woo_rrp_public_category_activate() {
		if ( ! is_admin() ) :
			add_filter( 'woocommerce_get_price_html', array( $this, 'woo_rrp_price_html_category' ), 100, 2 );
		endif;
	}

	/**
	 * Output the field values to the category on the front end.
	 *
	 * @since 1.0
	 * @param int   $price Allows access to the product price.
	 * @param mixed $product Allows access to product object.
	 */
	public function woo_rrp_price_html_category( $price, $product ) {
		// The data we need to output from the data entered in the WC UI.
		$woo_rrp_before_price      = apply_filters( 'woo_rrp_before_price', get_option( 'woo_rrp_before_price', 1 ) ) . ' ';
		$woo_rrp_before_sale_price = apply_filters( 'woo_rrp_before_sale_price', get_option( 'woo_rrp_before_sale_price', 1 ) ) . ' ';
		$woo_rrp_archive_option    = get_option( 'woo_rrp_archive_option', 1 );

		if ( null !== $price  ) :

			if ( 'yes' === $woo_rrp_archive_option && ( is_product_category() || is_shop() ) ) :

				if ( $product->is_on_sale() ) :
					$woo_rrp_replace = array(
						'<del>' => '<del><span class="rrp-price">' . esc_attr( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>',
						'<ins>' => '<br><span class="rrp-sale">' . esc_attr( $woo_rrp_before_sale_price, 'woocommerce-rrp' ) . '</span><ins>',
					);

					$price = str_replace( array_keys( $woo_rrp_replace ), array_values( $woo_rrp_replace ), $price );

				else :

					$price = '<span class="rrp-price">' . esc_attr( $woo_rrp_before_price, 'woocommerce-rrp' ) . '</span>' . $price;

				endif;

			endif;

			return $price;

		endif;
	}
}

/**
 * Instantiate the class
 *
 * @since 1.7.0
 */
$woocommerce_rrp_render_category = new WooCommerce_RRP_Render_Category();
