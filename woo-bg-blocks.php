<?php
/**
 * Plugin Name: WooCommerce Blocks – BGN/EUR Dual Price
 * Description: Extends WooCommerce Cart and Checkout blocks with dual BGN/EUR price display, mirroring the Bulgarisation for WooCommerce plugin behaviour for block-based cart/checkout.
 * Author: Jordan Hlebarov
 * Version: 1.0.0
 * Requires Plugins: woocommerce, bulgarisation-for-woocommerce
 * Text Domain: woo-bg-blocks
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'woo_bg_blocks_load_textdomain' );

function woo_bg_blocks_load_textdomain() {
	load_plugin_textdomain( 'woo-bg-blocks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'admin_notices', 'woo_bg_blocks_admin_notice' );

function woo_bg_blocks_admin_notice() {
	if ( function_exists( 'woo_bg_get_option' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p>' . sprintf(
		/* translators: 1: Plugin name, 2: Required plugin name */
		__( '<strong>%1$s</strong> requires the <strong>%2$s</strong> plugin to be installed and active.', 'woo-bg-blocks' ),
		'WooCommerce Blocks &ndash; BGN/EUR Dual Price',
		'Bulgarisation for WooCommerce'
	) . '</p></div>';
}

add_action( 'wp_enqueue_scripts', 'woo_bg_blocks_enqueue' );

function woo_bg_blocks_enqueue() {
	if ( ! function_exists( 'WC' ) || ! function_exists( 'woo_bg_get_option' ) ) {
		return;
	}

	$asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	if ( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = include $asset_file;

	wp_register_script(
		'woo-bg-blocks',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		// wc-blocks-checkout is WooCommerce's WP handle for @woocommerce/blocks-checkout.
		// It is not listed in index.asset.php because @wordpress/dependency-extraction-webpack-plugin
		// does not handle @woocommerce/* packages — we declare the external manually in webpack.config.js.
		array_merge( $asset['dependencies'], [ 'wc-blocks-checkout' ] ),
		$asset['version'],
		true
	);

	wp_set_script_translations( 'woo-bg-blocks', 'woo-bg-blocks', plugin_dir_path( __FILE__ ) . 'languages' );

	wp_enqueue_style(
		'woo-bg-blocks',
		plugin_dir_url( __FILE__ ) . 'build/index.css',
		[],
		$asset['version']
	);

	wp_localize_script(
		'woo-bg-blocks',
		'wooBgBlocks',
		[
			'locale'   => get_locale(),
			'currency' => get_woocommerce_currency(),
			'debug'    => defined( 'WP_DEBUG' ) && WP_DEBUG,
		]
	);

	wp_enqueue_script( 'woo-bg-blocks' );
}
