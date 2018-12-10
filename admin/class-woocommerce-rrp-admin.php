<?php
/**
 * The admin-specific functionality of WooCommerce RRP.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_RRP
 * @subpackage WooCommerce_RRP/admin
 * @since      1.7.0
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
	 * @since 1.7.0
	 */
	public function __construct() {
		$this->woo_rrp_admin_activate();
	}

	/**
	 * Add all filter type actions.
	 *
	 * @since 1.7.0
	 */
	public function woo_rrp_admin_activate() {
		add_filter( 'woocommerce_general_settings', array( $this, 'woo_rrp_input' ), 100, 1 );
	}

	/**
	 * Create and add input fields to the WooCommerce UI.
	 *
	 * @since  1.0
	 * @param  mixed $settings Gives access to the global wp setting api object.
	 * @return array Returns the new fields for suer input.
	 */
	public function woo_rrp_input( $settings ) {
		$woo_rrp_update = array();

		foreach ( $settings as $section ) :

			if ( isset( $section['id'] ) && 'pricing_options' === $section['id'] && isset( $section['type'] ) && 'sectionend' === $section['type'] ) :

				$woo_rrp_update[] = array(
					'name'     => __( 'Product Price Text', 'woocommerce-rrp' ), // WC < 2.0.
					'title'    => __( 'Product Price Text', 'woocommerce-rrp' ), // WC >= 2.0.
					'desc_tip' => __( 'This is the text that will appear before the regular price of the product.', 'woocommerce-rrp' ),
					'id'       => 'woo_rrp_before_price',
					'type'     => 'text',
					'css'      => 'min-width:200px;',
					'std'      => '',  // WC < 2.0.
					'default'  => '',  // WC >= 2.0.
					'desc'     => __( 'For example, "RRP:" or "MRRP:"', 'woocommerce-rrp' ),
				);
				$woo_rrp_update[] = array(
					'name'     => __( 'Sale Price Text', 'woocommerce-rrp' ), // WC < 2.0.
					'title'    => __( 'Sale Price Text', 'woocommerce-rrp' ), // WC >= 2.0.
					'desc_tip' => __( 'This is the text that will appear before the sale price of the product.', 'woocommerce-rrp' ),
					'id'       => 'woo_rrp_before_sale_price',
					'type'     => 'text',
					'css'      => 'min-width:200px;',
					'std'      => '',  // WC < 2.0.
					'default'  => '',  // WC >= 2.0.
					'desc'     => __( 'For example, "Sale Price:" or "Our Price:"', 'woocommerce-rrp' ),
				);
				$woo_rrp_update[] = array(
					'name'     => __( 'Show Text On Archives', 'woocommerce-rrp' ), // WC < 2.0.
					'title'    => __( 'Show Text On Archives', 'woocommerce-rrp' ), // WC >= 2.0.
					'desc'     => __( 'Enable Archive Template Display', 'woocommerce-rrp' ),
					'desc_tip' => __( 'Tick to display on archive templates, eg, product archive, product tag etc. Please be aware you may need to do some archive re-styling to keep everything looking nice and tidy.', 'woocommerce-rrp' ),
					'id'       => 'woo_rrp_archive_option',
					'type'     => 'checkbox',
					'css'      => 'min-width:200px;',
					'std'      => '',  // WC < 2.0.
					'default'  => '',  // WC >= 2.0.
				);

			endif;

			$woo_rrp_update[] = $section;

		endforeach;

		return $woo_rrp_update;
	}
}

/**
 * Instantiate the class
 *
 * @since 1.7.0
 */
$woocommerce_rrp_admin = new WooCommerce_RRP_Admin();
