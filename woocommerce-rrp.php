<?php
/**
 * Plugin Name: WooCommerce RRP
 * Plugin URI: http://bradley-davis.com/wordpress-plugins/woocommerce-rrp/
 * Description: WooCommerce RRP allows users to add text before the regular price and sale price of a product from within WooCommerce General settings.
 * Version: 2.0
 * Author: Bradley Davis
 * Author URI: http://bradley-davis.com
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: woocommerce-rrp
 * Domain Path: /languages
 * WC requires at least: 3.0.0
 * WC tested up to: 3.5.1
 *
 * @author    Bradley Davis
 * @category  Admin
 * @package   WooCommerce RRP
 * @since     1.0
 *
 * WooCommerce RRP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * WooCommerce RRP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

/**
 * Check if WooCommerce is active.
 *
 * @since 1.0
 */
if ( class_exists( 'WooCommerce' ) ) :

	/**
	 * Parent class that pulls everything together.
	 *
	 * @since 1.0
	 */
	class WooCommerce_RRP {
		/**
		 * The Constructor.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			if ( ! is_admin() ) :
				add_filter( 'woocommerce_get_price_html', array( $this, 'woo_rrp_price_html' ), 100, 2 );
			endif;
			add_filter( 'woocommerce_general_settings', array( $this, 'woo_rrp_input' ), 100, 1 );
			add_action( 'plugins_loaded', array( $this, 'woo_rrp_plugin_textdomain' ) );
		}

		/**
		 * Load the languages directory for translations.
		 *
		 * @since 1.6
		 */
		public function woo_rrp_plugin_textdomain() {
			load_plugin_textdomain( 'woocommerce-rrp', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages' );
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

	} // END class Woo_RRP.

	$woocommerce_rrp = new WooCommerce_RRP();

endif;
