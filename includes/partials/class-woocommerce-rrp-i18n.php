<?php
/**
 * Define the internationalization functionality.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/includes
 * @since      1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Define the internationalization functionality.
 *
 * @since 1.7.0
 */
class WooCommerce_RRP_I18n {
	/**
	 * The Constructor.
	 *
	 * @since 1.7.0
	 */
	public function __construct() {
		$this->woo_rrp_i18n_activate();
	}

	/**
	 * Add all filter type actions.
	 *
	 * @since 1.7.0
	 */
	public function woo_rrp_i18n_activate() {
		add_action( 'plugins_loaded', array( $this, 'woo_rrp_i18n_textdomain' ) );
	}


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function woo_rrp_i18n_textdomain() {
		load_plugin_textdomain(
			'woocommerce-rrp',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}
}

/**
 * Instantiate the class
 *
 * @since 1.7.0
 */
$woocommerce_rrp_i18n = new WooCommerce_RRP_I18n();
