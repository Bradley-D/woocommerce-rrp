<?php
/**
 * Plugin Name: WooCommerce RRP
 * Plugin URI: http://bradley-davis.com/wordpress-plugins/woocommerce-rrp/
 * Description: WooCommerce RRP allows users to add text before the regular price and sale price of a product from within WooCommerce General settings.
 * Version: 2.0.0
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
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) :
	woo_rrp_require();
endif;

/**
 * Undocumented function
 *
 * @since 2.0.0
 */
function woo_rrp_require() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-woocommerce-rrp-admin.php';
	require_once plugin_dir_path( __FILE__ ) . 'public/class-woocommerce-rrp-public.php';
}
