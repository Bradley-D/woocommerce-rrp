<?php
/**
 * The public-specific functionality of WooCommerce RRP.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/public
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
class WooCommerce_RRP_Public {
	/**
	 * The Constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->woo_rrp_public_require();
	}

	/**
	 * Include all the required public partials.
	 *
	 * @since 2.0.0
	 */
	public function woo_rrp_public_require() {
		require_once 'partials/class-woocommerce-rrp-render-category.php';
		require_once 'partials/class-woocommerce-rrp-render-single-product.php';
	}
}

/**
 * Instantiate the class
 *
 * @since 2.0.0
 */
$woocommerce_rrp_public = new WooCommerce_RRP_Public();
