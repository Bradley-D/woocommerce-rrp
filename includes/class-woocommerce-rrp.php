<?php
/**
 * The includes are included for WooCommerce RRP.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/includes
 * @since      2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Includes parent class that pulls everything together.
 *
 * @since 1.0
 */
class WooCommerce_RRP {

	/**
	 * The Constructor.
	 *
	 * @since 2.0
	 */
	public function __construct() {
		$this->woo_rrp_includes_require();
	}

	/**
	 * Include all the required include partials.
	 *
	 * @since 2.0.0
	 */
	public function woo_rrp_includes_require() {
		/**
		 * The class responsible for defining internationalization functionality.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/partials/class-woocommerce-rrp-i18n.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-rrp-admin.php';
		/**
		 * The class responsible for defining all actions that occur on the public-facing side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-rrp-public.php';
	}
}

/**
 * Instantiate the class
 *
 * @since 2.0.0
 */
$woocommerce_rrp = new WooCommerce_RRP();
