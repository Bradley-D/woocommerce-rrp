<?php
/**
 * The admin-specific functionality of WooCommerce RRP.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/admin
 * @since      2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Admin parent class that pulls everything together.
 *
 * @since 1.0
 */
class WooCommerce_RRP_Admin {
	/**
	 * The Constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {}
}

$woocommerce_rrp_admin = new WooCommerce_RRP_Admin();
